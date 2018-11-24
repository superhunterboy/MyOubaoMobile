;(function(gameSelfConfig){
	var gameSelfConfig = gameSelfConfig || {}, // 单彩种配置
		$body = $('body'),
		rechargeUrl = $('#recharge-url').val(),
		gameMessage = new dsgame.GameMessage(),
		gameConfig = new GameConfig(),
		dsgamediceConf = gameSelfConfig['dsgamediceConf'] || {},
		// 开奖记录
		gameRecords = $('#J-lottery-records').gameRecords();

	dsgamediceConf = $.extend({
		gameConfig: gameConfig,
		// gameHistory: k3History,
		message: gameMessage
	}, dsgamediceConf);

	// 骰宝游戏类
	var dsgamedice = $body.dsgamedice(dsgamediceConf);

	var $lotteryNumber = $('#J-lottery-info-number'),
		$timeDom = $('.lottery-countdown'),
		countDownTimer = null,
		issueTimer = null,
		issueTimeout = gameSelfConfig['issueTimeout'] || 10000,
		isFirst = true, // 初始化加载
		ballsNeedSorted = gameSelfConfig['ballsNeedSorted'],
		currentNumber = dsgamedice.gameConfig.getCurrentGameNumber(), // 当前期号
		currentBalls = dsgamedice.gameConfig.getLotteryBalls(); // 当前开奖号码

	issueTimer = setInterval(function(){
		dsgamedice.getServerIssues();
	}, issueTimeout);

	// 开奖动画
	if( gameSelfConfig['diceAnimationType'] == 'flipball' ){
		var _conf = gameSelfConfig['flipballConf'] || {};
		var flipball = $('#flipball').flipball(_conf);
	}else if( gameSelfConfig['diceAnimationType'] == 'dice' ){
		var diceAnimation = $('#J-lottery-info-balls').diceAnimation();
	}

	// 重置开奖记录html结构
	if( gameSelfConfig['recordMarkup'] ){
		gameRecords.setMarkup(gameSelfConfig['recordMarkup']);
	}

	// 生成单条开奖记录
	var createRecordRowData = gameSelfConfig['createRecordRowData'] || function(){return '没有生成数据的方法';};
	// 开奖
	var showWinNumber = function(lastballs, number, isFirst){
		lastballs = lastballs.split('');
		if( ballsNeedSorted ){
			lastballs.sort(function(a, b){
				return parseInt(a) - parseInt(b);
			});
		}
		$('#show-balls-number').html(number);
		if( flipball ){
			flipball.flip(lastballs, true, function(){
				afterShowNumber(lastballs, number, isFirst);
			});
		}else if( diceAnimation ){
			diceAnimation.doDice(lastballs, function(){
				afterShowNumber(lastballs, number, isFirst);
			});
		}
	};
	// 开奖记录生成
	var createAllRecords = function(issues){
		issues = issues || dsgamedice.gameConfig.getLotteryNumbers();
		var html = '';
		// console.log(issues);
		$.each(issues, function(idx, issue){
			if( idx === 0 ){
				issueCached['issue'] = issue['issue'];
				issueCached['wn_number'] = issue['wn_number'];
			}
			balls = (issue['wn_number'] + '').split('');
			if( balls.length ) html += gameRecords.getHTML( createRecordRowData( balls, issue['issue'] ) );
		});
		gameRecords.getDom().empty().html(html);
	};
	// 开奖后执行方法
	var afterShowNumber = function(lastballs, number, isFirst){
		// console.log(lastballs,createRecordRowData(lastballs, number))
		if( !isFirst ){
			gameRecords.prepend( createRecordRowData(lastballs, number) );
		}
		if( gameSelfConfig['afterShowNumber'] && typeof gameSelfConfig['afterShowNumber'] === 'function' ){
			gameSelfConfig['afterShowNumber']();
		}
	};

	// 获取到初始数据后
	dsgamedice.ready(function(){
		// 筹码相关事件
		var $chips = dsgamedice.getChipsElements();
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
				dsgamedice.$chips.removeClass('dice-chip-draggable');
				$this.addClass('dice-chip-draggable');
				$this.trigger('chip.selected');
			})
			.on('click', function(){
				$(this).trigger('chip.selected');
			})
			.on('chip.selected', function(){
				var $this = $(this);
				dsgamedice.$chips.removeClass('dice-chip-selected');
				$this.addClass('dice-chip-selected');
				dsgamedice.setChipValue($this.data('value'));
				dsgamedice.setSelectedChipElements($this);
			})
			.on('chip.bet', function(event, offset){

			})
			.filter('[data-value="' + dsgamedice.getChipValue() + '"]').trigger('chip.selected');

		// 自定义筹码按钮
		var $chipsButton = dsgamedice.getChipsButtonElements(),
			$chipsCustom = dsgamedice.getChipsCustomElements();
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
		var $chipsMirror = dsgamedice.getChipsMirrorElements();
		$chipsMirror.on('click', function(){
			if( $(this).hasClass('dice-chip-hide') ){
				var chipsMirror = dsgamedice.getChipsMirror(),
					$shifted = chipsMirror.shift();
				$shifted.addClass('dice-chip-hide');
				chipsMirror.push($(this).removeClass('dice-chip-hide'));
				dsgamedice.setChipsMirror(chipsMirror);
				var value1 = $shifted.data('value'),
					value2 = $(this).data('value'),
					$chips = dsgamedice.getChipsElements();
				$chips.filter('[data-value="' + value1 + '"]').addClass('dice-chip-hide');
				$chips.filter('[data-value="' + value2 + '"]').removeClass('dice-chip-hide');
				var $selected = $chips.filter('.dice-chip-selected')
				if( $selected.hasClass('dice-chip-hide') ){
					$selected.removeClass('dice-chip-selected');
					var $_selected = $chips.filter(':not(.dice-chip-hide)').eq(0),
						_value = $_selected.data('value');
					$_selected.addClass('dice-chip-selected');
					dsgamedice.setChipValue(_value);
					dsgamedice.setSelectedChipElements($_selected);
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
					value = dsgamedice.getSheetData($ui),
					$this = $(this);
				if( $ui.parent().hasClass('dice-chip-choose') ) return false;
				$ui.removeClass('dice-sheet-draggable');
				dsgamedice.setSheetData($ui, -value);

				dsgamedice.addActionLog({
					from   : $ui,
					to     : $this,
					amount : value,
					type   : 'recycle'
				});
			}
		});
		// 玩法盘相关事件
		var $sheets = dsgamedice.getSheetsElements();
		$sheets.droppable({
				accept: '.dice-chip, .dice-sheet',
				hoverClass: 'dice-sheet-hover',
				tolerance: 'pointer',
				drop: function( event, ui ) {
					var $ui = $(ui.draggable),
						value = dsgamedice.getSheetData($ui),
						$this = $(this),
						type = 'bet';

					if( dsgamedice.chipIsOverLimit($this, value) ){
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
						dsgamedice.showActionTips($this, '该注单超过限额了');
						return false;
					}

					if( $ui.hasClass('dice-sheet') ){
						// $this.append( $ui.removeClass('dice-sheet-draggable').find('.dice-chip') );
						$ui.removeClass('dice-sheet-draggable');
						dsgamedice.setSheetData($ui, -value);
						type = 'move';
					}else{
						// $this.append( $ui.clone() );
						type = 'bet';
					}
					dsgamedice.addActionLog({
						from   : $ui,
						to     : $this,
						amount : value,
						type   : type
					});
					dsgamedice.setSheetData($this, value);
					// dsgamedice.rebuildChip($this);
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
				if( dsgamedice.getAnimationStatus() ) return false;
				var chipValue = dsgamedice.getChipValue(),
					$this = $(this);
				// if( !dsgamedice.chipIsOverLimit($this, chipValue) ){
					dsgamedice.moveChip($this);
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
		dsgamedice.getActionsElements()
			.on('click', function(){
				if( $(this).hasClass('disabled') || $(this).prop('disable') || dsgamedice.getAnimationStatus() ) return false;
				var action = $(this).data('action');
				if( action ){
					actionString = 'action' + dsgamedice.letterCapitalize(action);
					// dsgamedice.debug(actionString)
					if( dsgamedice[actionString] ){
						dsgamedice[actionString]();
					}
				}
			});

		// 连投
		var continusCounter = dsgamedice.getContinusCounter();
		continusCounter.setTitle('连  投');
		continusCounter.addClass('continus-counter');

		// 倍投
		var multipleCounter = dsgamedice.getMultipleCounter();
		multipleCounter.setTitle('倍  投');
		multipleCounter.addClass('multiple-counter');

		// 设置充值链接
		dsgamedice.getBalanceRechargeElements().attr({
			href: rechargeUrl,
			target: '_blank'
		});

		// 游戏玩法tips
		dsgamedice.getTipsElements().tips({
			direction: 'right'
		});
		// 赔率玩法tips
		dsgamedice.getOddsTipsElements().tips({
			direction: 'bottom',
			maxLetter: 15,
			beforeSetText: function(text){
				var _text = '<span>开奖赔率：' + this.getHandler().text() + '</span>';
				return text = _text + '<span>投注2元可中奖金：' + text + '元</span>';
			}
		});
	});

	// 服务器数据发生变化时
	dsgamedice.getTargetElement().on('dsgame.dice.dynamicConfigChange', function(e, dynamicConfig){
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
			var message = dsgamedice.message,
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
				dsgamedice.getServerDynamicConfig();
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

	}).trigger('dsgame.dice.dynamicConfigChange', dsgamedice.gameConfig.getConfig());

	// 开奖机制
	var issueCached = {issue: '', wn_number: ''}; // 当前开奖的期号和号码 
	dsgamedice.getTargetElement().on('dsgame.dice.serverIssuesChange', function(e, data){
		var issues = data['issues'],
			lastNumber = data['last_number'];

		if( lastNumber['issue'] != issueCached['issue'] ){
			// 期号变化，有开奖号码，执行开奖动画
			if( lastNumber['wn_number'] ){
				showWinNumber(lastNumber['wn_number'], lastNumber['issue']);
				issueCached['issue'] = lastNumber['issue'];
				issueCached['wn_number'] = lastNumber['wn_number'];
			}
		}else{
			// 期号相同，开奖号码不同，执行开奖动画
			if( lastNumber['wn_number'] && lastNumber['wn_number'] != issueCached['wn_number'] ){
				showWinNumber(lastNumber['wn_number'], lastNumber['issue']);
				issueCached['issue'] = lastNumber['issue'];
				issueCached['wn_number'] = lastNumber['wn_number'];
			}
		}

		if( !lastNumber['wn_number'] ){
			// 等待开奖中...
			// console.log('等待开奖中...');
		}		
	});

	// 初始化显示
	showWinNumber(currentBalls, dsgamedice.gameConfig.getLastGameNumber(), isFirst);
	createAllRecords();

	// 登录超时
	dsgamedice.getTargetElement().on('dsgame.dice.logout', function(e, data){
		var message = dsgamedice.message;
		message.hide();
		message.show({
			mask: true,
			confirmIsShow: true,
			confirmText: '立即登录',
			confirmFun: function(){
				window.location.reload();
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

	dsgamedice.getTargetElement().on('dsgame.dice.beforeSend', function(e, msg){
		var panel = msg.win.dom.find('.pop-control'),
			comfirmBtn = panel.find('a.confirm'),
			cancelBtn = panel.find('a.cancel');
			comfirmBtn.addClass('btn-disabled');
			comfirmBtn.text('提交中...');
			msg.win.hideCancelButton();
	}).on('dsgame.dice.afterSubmit', function(e, msg){
		var panel = msg.win.dom.find('.pop-control'),
			comfirmBtn = panel.find('a.confirm'),
			cancelBtn = panel.find('a.cancel');
			comfirmBtn.removeClass('btn-disabled');
			comfirmBtn.text('确 认');

			// 刷新投注记录
			document.getElementById('record-iframe').contentWindow.location.reload();
			// 刷新余额
			$('[data-refresh-balance]').eq(0).trigger('click');
	});

	// 筹码区位置
	(function(){
		var isIE6 = dsgame.util.isIE6,
			minHeight = 700,
			maxHeight = 1098,
			$wrap = $('.dice-wrap'),
			$ctrl = $('.dice-ctrl'),
			$footer = $('#footer'),
			f_h = $footer.outerHeight() || 0,
			scrollTop = $wrap.offset().top;

		var extraTop = $ctrl.outerHeight() + f_h + scrollTop;

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

		$(function(){
			setTimeout( function(){
				$('html,body').animate({scrollTop: scrollTop}, 400);
			}, 1000);
		});

	})();

})(window.gameSelfConfig);
