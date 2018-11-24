$(function(){
	
	var $body = $('body'),
		rechargeUrl = 'recharge.php',
		gameMessage = new dsgame.GameMessage(),
		gameConfig = new GameConfig(),
		// 游戏记录
		k3History = $('[data-simulation="gameHistory"]').gameHistory({
			ballurl: 'queryOrdersDetail.php' // 投注内容详情页url
		}),
		// 骰宝
		k3dice = $body.k3dice({
			gameConfig: gameConfig,
			message: gameMessage,
			gameHistory: k3History
		}),
		// 开奖动画
		diceAnimation = $('#J-lottery-info-balls').diceAnimation(),
		// 开奖记录
		k3Records = $('#J-lottery-records').k3Records();

	// 根据投注信息生成筹码
	/*var initBalls = {"gameId":15,"traceWinStop":0,"traceStopValue":0,"isTrace":1,"multiple":3,"trace":2,"amount":"1,320.00","balls":[{"ball":"1","viewBalls":"大","jsId":0,"wayId":165,"moneyunit":0.5,"multiple":30,"amount":10,"onePrice":2,"num":1,"prizeGroup":"1800","type":"dx.dx.fs"},{"ball":"5","viewBalls":"555","jsId":6,"wayId":158,"moneyunit":0.5,"multiple":150,"amount":50,"onePrice":2,"num":1,"prizeGroup":"1800","type":"sthdx.sthdx.fs"},{"ball":"0","viewBalls":"小","jsId":15,"wayId":165,"moneyunit":0.5,"multiple":150,"amount":50,"onePrice":2,"num":1,"prizeGroup":"1800","type":"dx.dx.fs"},{"ball":"14","viewBalls":"14","jsId":20,"wayId":157,"moneyunit":0.5,"multiple":30,"amount":10,"onePrice":2,"num":1,"prizeGroup":"1800","type":"hz.hz.fs"},{"ball":"12","viewBalls":"12","jsId":22,"wayId":157,"moneyunit":0.5,"multiple":150,"amount":50,"onePrice":2,"num":1,"prizeGroup":"1800","type":"hz.hz.fs"},{"ball":"3","viewBalls":"3","jsId":49,"wayId":167,"moneyunit":0.5,"multiple":150,"amount":50,"onePrice":2,"num":1,"prizeGroup":"1800","type":"bdw.bdw.fs"}],"orders":{"20150606030":1,"20150606031":1}};
	k3dice.renderSheetFromData(initBalls);*/
	// 获取到初始数据后
	k3dice.ready(function(){
		// 筹码相关事件
		var $chips = k3dice.getChipsElements();
		$chips.draggable({
				revert: 'invalid',
				delay: 600,
				//refreshPositions: true,
				opacity: 0.5,
				helper: 'clone',
				zIndex: 100
			})
			.on('longclick', function(){
				var $this = $(this);
				k3dice.$chips.removeClass('dice-chip-draggable');
				$this.addClass('dice-chip-draggable');
				$this.trigger('chip.selected');
			})
			.on('click', function(){
				$(this).trigger('chip.selected');
			})
			.on('chip.selected', function(){
				var $this = $(this);
				k3dice.$chips.removeClass('dice-chip-selected');
				$this.addClass('dice-chip-selected');
				k3dice.setChipValue($this.data('value'));
				k3dice.setSelectedChipElements($this);
			})
			.on('chip.bet', function(event, offset){

			})
			.filter('[data-value="' + k3dice.getChipValue() + '"]').trigger('chip.selected');

		// 自定义筹码按钮
		var $chipsButton = k3dice.getChipsButtonElements(),
			$chipsCustom = k3dice.getChipsCustomElements();
		$chipsButton.addClass('active').on('click', function(){
			if( $(this).hasClass('active') ){
				$chipsCustom.animate({
					top: '+=20px',
					opacity: 'hide'
				});
				$(this).removeClass('active');
			}else{
				$chipsCustom.animate({
					top: '-=20px',
					opacity: 'show'
				});
				$(this).addClass('active');
			}
		}).trigger('click');

		// 隐藏自定义筹码
		$(document).on('click', function(e){
			var $el = $(e.target);
			if( !$el.parents('.dice-chip-wrap').length || $el.parents('.dice-chip-choose').length){
				if( $chipsButton.hasClass('active') ){
					$chipsCustom.animate({
						top: '+=20px',
						opacity: 'hide'
					});
					$chipsButton.removeClass('active');
				}
			}
		});

		// 筹码自定义
		var $chipsMirror = k3dice.getChipsMirrorElements();
		$chipsMirror.on('click', function(){
			if( $(this).hasClass('dice-chip-hide') ){
				var chipsMirror = k3dice.getChipsMirror(),
					$shifted = chipsMirror.shift();
				$shifted.addClass('dice-chip-hide');
				chipsMirror.push($(this).removeClass('dice-chip-hide'));
				k3dice.setChipsMirror(chipsMirror);
				var value1 = $shifted.data('value'),
					value2 = $(this).data('value'),
					$chips = k3dice.getChipsElements();
				$chips.filter('[data-value="' + value1 + '"]').addClass('dice-chip-hide');
				$chips.filter('[data-value="' + value2 + '"]').removeClass('dice-chip-hide');
				var $selected = $chips.filter('.dice-chip-selected')
				if( $selected.hasClass('dice-chip-hide') ){
					$selected.removeClass('dice-chip-selected');
					var $_selected = $chips.filter(':not(.dice-chip-hide)').eq(0),
						_value = $_selected.data('value');
					$_selected.addClass('dice-chip-selected');
					k3dice.setChipValue(_value);
					k3dice.setSelectedChipElements($_selected);
				}
			}
			return false;
		});

		// 回收站
		var $recycle = $('.dice-recycle');
		$recycle.droppable({
			accept: '.dice-chip, .dice-sheet',
			hoverClass: 'dice-recycle-hover',
			tolerance: 'pointer',
			drop: function( event, ui ) {
				var $ui = $(ui.draggable),
					value = k3dice.getSheetData($ui),
					$this = $(this);

				$ui.removeClass('dice-sheet-draggable');
				k3dice.setSheetData($ui, -value);

				k3dice.addActionLog({
					from   : $ui,
					to     : $this,
					amount : value,
					type   : 'recycle'
				});
			}
		});
		// 玩法盘相关事件
		var $sheets = k3dice.getSheetsElements();
		$sheets.droppable({
				accept: '.dice-chip, .dice-sheet',
				hoverClass: 'dice-sheet-hover',
				tolerance: 'pointer',
				drop: function( event, ui ) {
					var $ui = $(ui.draggable),
						value = k3dice.getSheetData($ui),
						$this = $(this),
						type = 'bet';

					if( k3dice.chipIsOverLimit($this, value) ){
						var $helper = $(ui.helper).clone().css({
							position: 'absolute',
							display: 'block',
							zIndex: 1,
							left: ui.offset.left,
							top: ui.offset.top
						}).appendTo('body');
						$helper.find('.dice-sheet-bg').css({opacity: 0});
						$helper.animate( $ui.offset(), function(){
							$helper.remove();
						});
						k3dice.showActionTips($this, '该注单超过限额了');
						return false;
					}

					if( $ui.hasClass('dice-sheet') ){
						// $this.append( $ui.removeClass('dice-sheet-draggable').find('.dice-chip') );
						$ui.removeClass('dice-sheet-draggable');
						k3dice.setSheetData($ui, -value);
						type = 'move';
					}else{
						// $this.append( $ui.clone() );
						type = 'bet';
					}
					k3dice.addActionLog({
						from   : $ui,
						to     : $this,
						amount : value,
						type   : type
					});
					k3dice.setSheetData($this, value);
					// k3dice.rebuildChip($this);
				}
			})
			.draggable({
				revert: 'invalid',
				delay: 500,
				//refreshPositions: true,
				opacity: 0.5,
				helper: 'clone'
			})
			.on('longclick', function(){
				if( !$(this).find('.dice-chip').length ){
					return false;
				}
				$sheets.removeClass('dice-sheet-draggable');
				$(this).addClass('dice-sheet-draggable');
			})
			.on('click', function(){
				if( k3dice.getAnimationStatus() ) return false;
				var chipValue = k3dice.getChipValue(),
					$this = $(this);
				// if( !k3dice.chipIsOverLimit($this, chipValue) ){
					k3dice.moveChip($this);
				// }
			})
			.tips({
				attr: 'value',
				autoinitialize: true,
				showCase: function(me){
					return me.getText() != '￥0';
				},
				beforeSetText: function(text){
					if( !text ){
						text = 0;
					}
					return text = '￥' + text;
				}
			});

		// 操作按钮相关
		k3dice.getActionsElements()
			.on('click', function(){
				if( $(this).hasClass('disabled') || $(this).prop('disable') || k3dice.getAnimationStatus() ) return false;
				var action = $(this).data('action');
				if( action ){
					actionString = 'action' + k3dice.letterCapitalize(action);
					// k3dice.debug(actionString)
					if( k3dice[actionString] ){
						k3dice[actionString]();
					}
				}
			});

		// 连投
		var continusCounter = k3dice.getContinusCounter();
		continusCounter.setTitle('连  投');
		continusCounter.addClass('continus-counter');
		// continusCounter.setOnSetValue(function(value){
		// 	k3dice.setContinusTimes(value);
		// });

		// 倍投
		var multipleCounter = k3dice.getMultipleCounter();
		multipleCounter.setTitle('倍  投');
		multipleCounter.addClass('multiple-counter');
		// multipleCounter.setOnSetValue(function(value){
		// 	k3dice.setMultipleTimes(value);
		// });

		// refresh balance
		// k3dice.getBalanceRefreshElements()
		// 	.on('click', function(){
		// 		if( !$(this).hasClass('onhandled') ){
		// 			k3dice.getBalance();
		// 		}
		// 		return false;
		// 	});
		// 设置充值链接
		k3dice.getBalanceRechargeElements().attr({
			href: rechargeUrl,
			target: '_blank'
		});

		// 游戏玩法tips
		k3dice.getTipsElements().tips({
			direction: 'right'
		});
		// 赔率玩法tips
		k3dice.getOddsTipsElements().tips({
			direction: 'bottom',
			maxLetter: 15,
			beforeSetText: function(text){
				var _text = '<span>开奖赔率：' + this.getHandler().text() + '</span>';
				return text = _text + '<span>单注最高奖金：' + text + '元</span>';
			}
		});
	});
	
	// k3dice.getServerDynamicConfig();

	var $lotteryNumber = $('#J-lottery-info-number'),
		$timeDom = $('.lottery-countdown'),
		countDownTimer = null,
		issueTimer = null,
		issueTimeout = 10000,
		isFirst = true, // 初始化加载
		currentNumber = k3dice.gameConfig.getCurrentGameNumber(), // 当前期号
		curIssues = k3dice.gameConfig.getLotteryNumbers(), //  当前开奖记录
		curNumber; // 当前开奖期号

	issueTimer = setInterval(function(){
		k3dice.getServerIssues();
	}, issueTimeout);

	showWinNumber(k3dice.gameConfig.getLotteryBalls(), currentNumber, isFirst);
	createRecords();

	// 服务器数据发生变化时
	k3dice.getTargetElement().on('k3.dynamicConfigChange', function(e, dynamicConfig){
		// console.log(dynamicConfig['loaddataUrl']);
		// 停售
		if( dynamicConfig.isstop ){
			$('.lottery-status').find('.soldout').show();
			$('.lottery-status').find('.lottery-countdown').hide();
		}else{	        	
			$('.lottery-status').find('.soldout').hide();
			$('.lottery-status').find('.lottery-countdown').show();
		}

		// 更新奖期
		var newCurrentNumber = dynamicConfig['currentNumber'];
		$lotteryNumber.html( newCurrentNumber );

		// 期号发生变化提示用户
		if(currentNumber && currentNumber != newCurrentNumber){
			var message = k3dice.message,
				time = 5,
				html = '<div class="tipdom-cont">' + 
							'<p>当前已进入第<span>' + newCurrentNumber +'</span>期</p>' + 
							'<p>请留意期号变化(<span id="J-gamenumber-change-s-num">5</span>)</p>' +
						'</div>';
			// message.showTip(html);
			message.show({
				mask: false,
				cancelIsShow: false,
				title: '温馨提示',
				content: html,
				closeIsShow: true,
				closeFun: function() {
					message.hide();
				}
			});
			(function(){
				time--;
				if(time < 0){
					message.hide();
					return;
				}
				$('#J-gamenumber-change-s-num').text(time);
				setTimeout(arguments.callee, 1000);
			})();
		}
		currentNumber = newCurrentNumber;

		// 倒计时
		var seconds = dynamicConfig['currentNumberTime'] - dynamicConfig['currentTime'];
		if( countDownTimer ){
			clearTimeout(countDownTimer);
			countDownTimer = null;
		}
		countDownTimer = setInterval(function(){
			seconds--;
			if( seconds <= 0 ){
				k3dice.getServerDynamicConfig();
			}
			// 还剩10s时
			if( seconds <= 10 ) {
				$timeDom.addClass('caution-countdown');
			}else{
				$timeDom.removeClass('caution-countdown');
			}
			// h = Math.floor(seconds / 3600), // 小时数
			var m = Math.floor(seconds % 3600 / 60), // 分钟数
				s = seconds % 3600 % 60;
			if( m < 10 ){
				m = '0' + m;
			}
			if( s < 10 ){
				s = '0' + s;
			}
			m += '';
			s += '';
			//渲染时间输出 
			var m1 = m.substring(0, 1),
				m2 = m.substring(1, 2),
				s1 = s.substring(0, 1),
				s2 = s.substring(1, 2);
			$timeDom.find('[data-time="m1"]').text(m1).attr('class', 'time-'+m1);
			$timeDom.find('[data-time="m2"]').text(m2).attr('class', 'time-'+m2);
			$timeDom.find('[data-time="s1"]').text(s1).attr('class', 'time-'+s1);
			$timeDom.find('[data-time="s2"]').text(s2).attr('class', 'time-'+s2);
		}, 1000);

	}).trigger('k3.dynamicConfigChange', k3dice.gameConfig.getConfig());

	// 开奖机制
	k3dice.getTargetElement().on('k3.serverIssuesChange', function(e, data){
		var issues = data['issues'],
			issue = issues[0];

		curIssues = issues;

		if( issue['wn_number'] ){
			showWinNumber(issue['wn_number'], issue['issue']);
		}else{
			// 等待开奖中...
		}
	});

	// 开奖
	function showWinNumber(lastballs, number){
		lastballs = lastballs.split('');
		lastballs.sort(function(a, b){
			return parseInt(a) - parseInt(b);
		});
		if( !curNumber || curNumber != number ){
			// 开奖动画
			diceAnimation.doDice(lastballs, function(){
				if( !isFirst ){
					createRecords();
				}
			});
		}else{
			diceAnimation.setBallsNum(lastballs);
		}
		curNumber = number;
	}
	// 开奖记录生成
	function createRecords(){
		curIssues = curIssues || [];
		var html = '';
		$.each(curIssues, function(idx, issue){
			balls = (issue['wn_number'] + '').split('');
			balls.sort(function(a, b){
				return parseInt(a) - parseInt(b);
			});
			var records = {}, num = 0,
				size = '-', oddEven = '-';
			records['number'] = issue['issue'].substr(-3) + '期';
			if( balls.length ){
				$.each(balls, function(i,n){
					var key = 'ball' + (i+1);
					records[key] = n;
					num += parseInt(n);
				});
				size = '小';
				oddEven = '双';
				if( num >= 11 ){
					size = '大';
				}
				if( num % 2 ){
					oddEven = '单';
				}
			}
			records['num'] = num;
			records['size'] = size;
			records['oddEven'] = oddEven;
			html += k3Records.getHTML(records);
		});
		k3Records.getDom().empty().html(html);
	}

	// 登录超时
	k3dice.getTargetElement().on('k3.logout', function(e, data){
		var message = k3dice.message;
		message.hide();
		message.show({
			mask: true,
			confirmIsShow: true,
			confirmText: '立即登录',
			confirmFun: function(){
				location.href = '/auth/signin';
			},
			content:'<div class="pop-waring"><i class="ico-waring"></i><h4 class="pop-text">登录超时，请重新登录平台！</h4></div>'
		});
	});

	// 开奖记录滚动条
	$('.scroll-pane').jScrollPane({
		autoReinitialise: true,
		showArrows: true,
		arrowScrollOnHover: true,
		autoReinitialiseDelay: 5000
	});

	// 游戏记录开关
	var $history = $('.game-history-wrap').slideUp(0);
	$('.dice-bar').on('click', '.history-toggle', function(){
		$(this).toggleClass('history-toggle-active');
		$history.slideToggle();
		return false;
	});
	$history.on('click', '.history-close', function(){
		$('.history-toggle').trigger('click');
		return false;
	});

	k3dice.getTargetElement().on('k3.beforeSend', function(e, msg){
		var panel = msg.win.dom.find('.pop-control'),
			comfirmBtn = panel.find('a.confirm'),
			cancelBtn = panel.find('a.cancel');
			comfirmBtn.addClass('btn-disabled');
			comfirmBtn.text('提交中...');
			msg.win.hideCancelButton();
	}).on('k3.afterSubmit', function(e, msg){
		console.log('k3.afterSubmit');
		// var panel = msg.win.dom.find('.pop-control'),
		// 	comfirmBtn = panel.find('a.confirm'),
		// 	cancelBtn = panel.find('a.cancel');
		// 	comfirmBtn.removeClass('btn-disabled');
		// 	comfirmBtn.text('确 认');

		// 	//刷新投注记录
		// 	$("#record-iframe").attr("src",$("#record-iframe").attr("src"));
		// 	// 刷新余额
		// 	$('[data-refresh-balance]').trigger('click');
	});

	// 筹码区位置
	(function(){
		var isIE6 = dsgame.util.isIE6,
			minHeight = 700,
			maxHeight = 1098,
			$wrap = $('.dice-wrap'),
			$ctrl = $('.dice-ctrl'),
			$footer = $('#footer'),
			f_h = $footer.outerHeight() || 0;
			
		var extraTop = $ctrl.outerHeight() + f_h + $wrap.offset().top;

		function renderPosition(){
			var height = $(window).height(),
				width = $(window).width();

			// 在某些浏览器下窗口宽度为奇数时会出现一些奇怪的样式bug
			// 需要修正为偶数像素宽度
			if( width % 2 ){
				$body.width(width-1);
			}

			if( height < extraTop + minHeight ){
				$wrap.height(minHeight);
				$ctrl.css({
					position: 'relative',
					bottom: 'auto',
					left: 0
				});
				$footer.css({
					position: 'relative',
					bottom: 'auto',
					left: 0
				});
			}else if( height > extraTop + minHeight ){
				if( !isIE6 ){
					$ctrl.css({
						position: 'fixed',
						bottom: f_h,
						left: 0
					});
					$footer.css({
						position: 'fixed',
						bottom: 0,
						left: 0
					});
				}
				if( height > extraTop + maxHeight ){
					$wrap.height(maxHeight);
				}else{
					$wrap.height(height - extraTop);
				}
			}
		}
		var resizeTimer = null;
		$(window).on( 'resize', function () {
			// renderPosition();
			if ( resizeTimer ) {
				clearTimeout(resizeTimer);
			}
			resizeTimer = setTimeout(function(){
				renderPosition();
			}, 100);
		}).trigger('resize');

	})();

});