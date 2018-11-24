$(function(){

	var init = function(config){
		//游戏公共访问对象
		var Games = dsgame.Games;
		//游戏实例
		dsgame.Games.SSC.getInstance({'jsNameSpace': 'dsgame.Games.SSC.'});
		//游戏玩法切换
		dsgame.GameTypes.getInstance();
		//统计实例
		dsgame.GameStatistics.getInstance();
		//号码篮实例
		dsgame.GameOrder.getInstance();
		//追号实例
		dsgame.GameTrace.getInstance();
		//提交
		dsgame.GameSubmit.getInstance();
		//消息类
		dsgame.Games.SSC.Message.getInstance();

		// 更新界面显示内容
		var isTimeEndAlertShow = false;
		var updateConfigError = function(data){
			if(data['type'] == 'loginTimeout'){
				var msgwd = Games.getCurrentGameMessage();
				msgwd.hide();
				msgwd.show({
					mask:true,
					confirmIsShow:true,
					confirmText:'关 闭',
					confirmFun:function(){
						location.href = "/";
					},
					closeFun:function(){
						location.href = "/";
					},
					content:'<div class="pop-waring"><i class="ico-waring"></i><h4 class="pop-text">登录超时，请重新登录平台！</h4></div>'
				});
			}
		};

		// 开奖号码是否显示
		// 如果显示就不再弹出显示开奖号码，并且开奖记录不可见
		var numbersIsVisible = false;
		// 是否是开奖后的第一次点击面板切换按钮
		// 如果是，那么需要走一下开奖动画
		var isFirstClickAfterLottery = true;
		// 生成开奖记录（日历）
		var createLotteryNumbers = function(cfg){
			var cfg = cfg || Games.getCurrentGame().getGameConfig().getInstance(),
				currentNumber = cfg.getCurrentGameNumber(),
				numbers = cfg.getFormatLotteryNumbers('hour'),
				$dom = $('#J-lottery-numbers');
			if( numbers && !$.isEmptyObject(numbers) ){
				var html = '';
				$.each(numbers, function(key, value){
					if( value.length < 6 ) return;
					var dl = dd = ball = '',
						dt = '<dt>' + key + '</dt>',
						isCurrent = false;
					$.each(value, function(i,n){
						var cl, number = n['number'];
						if( n['hasLottery'] ){
							cl = 'has-lottery';
						}
						if( currentNumber == number ){
							cl = cl ? cl + ' current': 'current';
							ball = n['balls'] ? '<span>'+ n['balls'] +'</span>' : '<span>开奖中...</span>';
							isCurrent = true;
						}else if( !n['balls'] ){
							cl = cl ? cl + ' coming': 'coming';							
							ball = '';
						}else{
							ball = '<span>'+ n['balls'] +'</span>';
						}
						cl = cl ? ' class="' + cl + '"' : '';
						dd += '<dd data-issue="' + number + '"' + cl + '><em>' + number.slice(-7) + '期</em>' + ball + '</dd>'
					});
					if( isCurrent ){
						dl = '<dl class="current">' + dt + dd + '</dl>';
					}else{
						dl = '<dl>' + dt + dd + '</dl>';
					}
					html += dl;
					if( isCurrent ){
						return false
					}
				});
				$dom.html(html).parent().scrollTop($dom.height());
			}else{
				// console.log(cfg)
			}
		}
		createLotteryNumbers();

		var updateView = function(){
			var cfg = Games.getCurrentGame().getGameConfig().getInstance(),
				time = cfg.getCurrentLastTime(),
				timeNow = cfg.getCurrentTime(),
				surplusTime = time - timeNow,
				timer,
				fn,
				currentNumber = '' + cfg.getCurrentGameNumber(),
				lastBalls = ('' + cfg.getLotteryBalls()).split(''),
				timeDoms = $('.J-lottery-countdown li em'),
				traceTimeDom = $('#J-trace-statistics-countdown'),
				numbers = cfg.getFormatLotteryNumbers();

			fn = function(){
				if(surplusTime < 0){
					timer.stop();
					Games.getCurrentGameTrace().hide();
					Games.getCurrentGameTrace().deleteTrace();
					if(isTimeEndAlertShow){
						return;
					}
					isTimeEndAlertShow = true;
					Games.getCurrentGameMessage().show({
						mask:true,
						cancelIsShow:true,
						cancelText:'保留',
						cancelFun:function(){
							var me = this;
							Games.getCurrentGame().getServerDynamicConfig(function(){
								me.hide();
							}, updateConfigError);
							isTimeEndAlertShow = false;
						},
						confirmIsShow:true,
						confirmText:'清空',
						confirmFun:function(){
							var me = this;
							Games.getCurrentGameOrder().reSet().cancelSelectOrder();
							Games.getCurrentGame().getCurrentGameMethod().reSet();
							Games.getCurrentGame().getServerDynamicConfig(function(){
								me.hide();
							}, updateConfigError);
							isTimeEndAlertShow = false;
						},
						content:'<div class="pop-waring"><i class="ico-waring"></i><h4 class="pop-text">当前期结束,进入下一期,是否清空投注项？<br />要清空投注项请点击"清空"，不需要清空请点击"保留"<br></h4></div>'
					});
					return;
				}
				var timeStrArr = [],
					h = Math.floor(surplusTime / 3600), // 小时数
					m = Math.floor(surplusTime % 3600 / 60), // 分钟数
					s = surplusTime%3600%60;

				h = h < 10 ? '0' + h : '' + h;
				m = m < 10 ? '0' + m : '' + m;
				s = s < 10 ? '0' + s : '' + s;
				timeStrArr.push(h);
				timeStrArr.push(m);
				timeStrArr.push(s);

				timeDoms.each(function(i,n){
					$(this).text(timeStrArr[i]);
				});
				traceTimeDom.html(timeStrArr.join(':'));

				surplusTime--;
			};
			timer = new dsgame.Timer({time:1000, fn:fn});

			$('#J-header-currentNumber').html(currentNumber);
			var lastBallsDomStr = [];
			$.each(lastBalls, function(i){
				lastBallsDomStr[i] = '<li><span class="ball-num">' + this + '</span></li>';
			});
			$('#J-lottery-balls-lasttime').html(lastBallsDomStr.join(''));
			$('#J-header-newnum').text(cfg.getLastGameNumber());
		};

		// 开奖号码（弹出）
		var lotteryPopBoard = new dsgame.MiniWindow({
				cls: 'lottery-board-pop',
				effectShow: boardShowFn,
				effectHide: boardHideFn
			}),
			numberErnie,
			numberPopErnie,
			ballErnie = [0,1,2,3,4,5,6,7,8,9],
			// ballErnie = ['00','01','02','03','04','05','06','07','08','09','10','11'],
			ballHeight = 64,
			ballPopHeight = 74;
		
		function showLotteryBoard(number, ballsArr){
			var $dom = $('#lottery-numbers-board');
			if( !numberPopErnie ){
				$dom.html( getLotteryBoardHtml(ballsArr.length) );
				numberErnie = new dsgame.Ernie({
					dom      : $dom.find('li'),
					height   : ballHeight,
					length   : ballErnie.length,
					callback : ernieCallback
				});	
			}
			$('#J-ernie-issue').html(number);
			numberErnie.start();
			numberErnie.stop(ballsArr);
		}
		function showLotteryPopBoard(number, ballsArr){
			lotteryPopBoard.setTitle('第<b>' + number + '</b>期开奖结果');
			if( !numberPopErnie ){
				lotteryPopBoard.setContent( getLotteryPopBoardHtml(ballsArr.length) );
				numberPopErnie = new dsgame.Ernie({
					dom      : $('#J-lottery-ernie-board li'),
					height   : ballPopHeight,
					length   : ballErnie.length,
					callback : ernieCallback
				});				
				lotteryPopBoard.dom.find('.hand-up').fadeIn('fast');
				lotteryPopBoard.dom.find('.hand-down').fadeOut('fast');
			}
			lotteryPopBoard.show();
			lotteryPopBoard.dom.find('.hand-up').fadeOut(1000);
			lotteryPopBoard.dom.find('.hand-down').fadeIn(1000);
			numberPopErnie.start();
			numberPopErnie.stop(ballsArr);
			isFirstClickAfterLottery = true;
		}
		function ernieCallback(){
			setTimeout(function(){
				updateView();
				if( !numbersIsVisible ){
					lotteryPopBoard.hide();
					lotteryPopBoard.dom.find('.hand-up').fadeIn('fast');
					lotteryPopBoard.dom.find('.hand-down').fadeOut('fast');
				}
			}, 3000);
		}
		function boardShowFn(){
			var me = this;
			me.dom.css({
				display: 'block',
				left: '50%',
				marginLeft: -me.dom.outerWidth() / 2,
				top: -me.dom.outerHeight() * 2
			}).animate({
				top: 206
			});
		}
		function boardHideFn(){
			var me = this;
			me.dom.animate({
				top: -me.dom.outerHeight() * 2
			}, function(){
				me.dom.hide();
			});
		}
		function getLotteryBoardHtml(len){
			var html = ['<h3>第<span id="J-ernie-issue"></span>期<br>开奖结果</h3>'];
			html.push('<ul id="J-lottery-ernie-numbers" class="lottery-ernie-numbers lottery-ernie-numbers-' +len+ '">');
			for(var i=0; i<len; i++){
				var _html = '<li>';
				$.each( ballErnie, function(i, ball){
					_html += '<span>' + ball + '</span>';
				});
				_html += '</li>'
				html.push(_html);
			}
			html.push('</ul>');
			return html.join('');
		}
		function getLotteryPopBoardHtml(len){
			var html = ['<ul id="J-lottery-ernie-board" class="lottery-ernie-board lottery-ernie-board-' +len+ '">'];
			for(var i=0; i<len; i++){
				var _html = '<li>';
				$.each( ballErnie, function(i, ball){
					_html += '<span>' + ball + '</span>';
				});
				_html += '</li>'
				html.push(_html);
			}
			html.push('</ul>');
			html.push('<div class="lottery-board-hands"><div class="hand-up"></div><div class="hand-down"></div></div>');
			return html.join('');
		}

		//当最新的配置信息和新的开奖号码出现后，进行界面更新
		Games.getCurrentGame().addEvent('changeDynamicConfig', function(e, cfg){
			// updateView();
			// 如果开奖号码面板可见
			if( numbersIsVisible ){
				showLotteryBoard( cfg.getCurrentGameNumber(), (''+cfg.getLotteryBalls()).split('') );
			}else{
				showLotteryPopBoard( cfg.getCurrentGameNumber(), (''+cfg.getLotteryBalls()).split('') );
			}
		});
		//当最新的配置信息和新的开奖号码出现后，进行界面更新
		// Games.getCurrentGame().addEvent('changeDynamicConfig', function(e, cfg){
		// 	updateView();
		// });

		// 本地测试
		// var CFG = Games.getCurrentGame().getGameConfig().getInstance();
		// showLotteryPopBoard(CFG.getCurrentGameNumber(), CFG.getLotteryBalls());
		// showLotteryPopBoard(CFG.getCurrentGameNumber(), ['02','08','09','10','11']);		

		// 初次手动更新一次界面
		updateView();

		// 切换开奖记录／开奖号码面板
		$('.J-switch-board').on('click', function(){
			$(this).parents('.css-flip:eq(0)').toggleClass('clip-hover');
			numbersIsVisible = !numbersIsVisible;
			if( isFirstClickAfterLottery ){
				var _cfg = Games.getCurrentGame().getGameConfig().getInstance();
				showLotteryBoard( _cfg.getCurrentGameNumber(), (''+_cfg.getLotteryBalls()).split('') );
			}
			isFirstClickAfterLottery = false;
			return false;
		});

		// 玩法菜单区域的高亮处理
		Games.getCurrentGameTypes().addEvent('beforeChange', function(e, id){
			var $tabs = $('#J-panel-gameTypes li'),
				$panel = $('#J-gametyes-menu-panel'),
				dom = $panel.find('[data-id="'+ id +'"]'),
				li,
				name_cn = Games.getCurrentGame().getGameConfig().getInstance().getMethodCnNameById(id),
				cls = 'current';
			if(dom.size() > 0){
				$panel.find('dd').removeClass(cls).end();
				dom.addClass(cls);
				li = dom.parents('li').addClass('current').show();
				$tabs.removeClass('current').eq(li.index()).addClass('current');
			}
		});
		//玩法规则，中奖说明的tips提示
		var tipRule = new dsgame.Tip({cls:'j-ui-tip-b j-ui-tip-showrule'});
		$('#J-balls-main-panel').on('mouseover', '.pick-rule, .win-info', function(){
			var el = $(this),
				currentMethodId = Games.getCurrentGame().getCurrentGameMethod().getId(),
				methodCfg = Games.getCurrentGame().getGameConfig().getInstance().getMethodById(currentMethodId),
				text = el.hasClass('pick-rule') ? methodCfg['bet_note'] : methodCfg['bonus_note'] ;
			tipRule.setText(text);
			tipRule.show(tipRule.getDom().width()/2 * -1 + el.width()/2, tipRule.getDom().height() * -1 - 20, el);
		});
		$('#J-balls-main-panel').on('mouseleave', '.pick-rule, .win-info', function(){
			tipRule.hide();
		});
		$('#J-balls-main-panel').on('click', '.pick-rule, .win-info', function(){
			return false;
		});

		// 选球区域的玩法名称显示
		var methodPrize = 0;
		Games.getCurrentGame().addEvent('afterSwitchGameMethod', function(e, id) {
			// console.log(Games.getCurrentGameStatistics())
			var id = Games.getCurrentGame().getCurrentGameMethod().getId(),
				unit = Games.getCurrentGameStatistics().getMoneyUnit(),
				maxv = Games.getCurrentGame().getGameConfig().getInstance().getLimitByMethodId(id, unit),
				methodCfg = Games.getCurrentGame().getGameConfig().getInstance().getMethodById(id),
				prize = 0;

			methodPrize = Number(methodCfg['prize']);
			prize = methodPrize * unit;

			Games.getCurrentGameStatistics().getMultipleDom().setMaxValue(maxv);
			$('#J-method-prize').html( dsgame.util.formatMoney(prize) );
		});

		//加载默认玩法
		Games.getCurrentGameTypes().addEvent('endShow', function() {
			this.changeMode(Games.getCurrentGame().getGameConfig().getInstance().getDefaultMethodId());
		});

		// 将选球数据添加到号码篮
		$('#J-add-order').click(function(){
			var method = Games.getCurrentGame().getCurrentGameMethod(),
				bd,
				result = Games.getCurrentGameStatistics().getResultData(),
				slectedBalls = method.container.find('.ball-number-current'),
				time = 500,
				orderPanel,
				targetPos,
				copyBalls;
			if(!result['mid']){
				return;
			}
			Games.getCurrentGameOrder().add(result);

		});
		//根据选球内容更新添加按钮的状态样式
		Games.getCurrentGameStatistics().addEvent('afterUpdate', function(e, num, money){
			var me = this, button = $('#J-add-order');
			if(num > 0){
				button.removeClass('btn-disable');
				// 计算返点
				var rate = me.getPrizeGroupRate() || 0;
				me.setRebate(money, rate);
			}else{
				button.addClass('btn-disable');
				me.setRebate(0);
			}
			// 计算最低单注奖金
			var prize = methodPrize * Number( me.getMoneyUnit() );
			$('#J-method-prize').html( dsgame.util.formatMoney(prize) );
		});

		//号码蓝模拟滚动条(该滚动条初始化使用autoReinitialise: true参数也可以达到自动调整的效果，但是是用的定时器检测)
		var gameOrderScroll = $('#J-panel-order-list-cont'),
			gameOrderScrollAPI;
		gameOrderScroll.jScrollPane();
		gameOrderScrollAPI = gameOrderScroll.data('jsp');
		//注单提交按钮的禁用和启用
		//当投注内容发生改变时，重新绘制滚动条
		//数字改变闪烁动画
		Games.getCurrentGameOrder().addEvent('afterChangeLotterysNum', function(e, lotteryNum){
			var me = this,subButton = $('#J-submit-order'),traceButton = $('#J-trace-switch');
			var cartEmpty = $('.J-cart-empty');
			if(lotteryNum > 0){
				subButton.add(traceButton).removeClass('btn-bet-disable');
				cartEmpty.hide();
			}else{
				subButton.add(traceButton).addClass('btn-bet-disable');
				cartEmpty.show();
			}
			gameOrderScrollAPI.reinitialise();
			me.totalLotterysNumDom.add(me.totalAmountDom).add(me.totalRebateDom).addClass('blink');
			setTimeout(function(){
				me.totalLotterysNumDom.add(me.totalAmountDom).add(me.totalRebateDom).removeClass('blink');
			}, 600);
		});


		//清空号码篮
		$('#J-button-clearall').click(function(e){
			e.preventDefault();
			Games.getCurrentGameOrder().reSet().cancelSelectOrder();
			Games.getCurrentGame().getCurrentGameMethod().reSet();
		});

		//单式上传的删除、去重、清除功能
		$('body').on('click', '.remove-error', function(){
			Games.getCurrentGame().getCurrentGameMethod().removeOrderError();
		}).on('click', '.remove-same', function(){
			Games.getCurrentGame().getCurrentGameMethod().removeOrderSame();
		}).on('click', '.remove-all', function(){
			Games.getCurrentGame().getCurrentGameMethod().removeOrderAll();
		});
		//设置倍数$ 模式
		Games.getCurrentGameStatistics().setMultiple(Games.getCurrentGame().getGameConfig().getInstance().getDefaultMultiple());
		Games.getCurrentGameStatistics().setMoneyUnitDom((Games.getCurrentGame().getGameConfig().getInstance().getDefaultCoefficient()));

		//投注按钮操作
		$('body').on('click', '#J-submit-order', function(){
			Games.getCurrentGameTrace().deleteTrace();
			Games.getCurrentGameSubmit().submitData();
		});

		//追号区域的显示
		$('#J-trace-switch').click(function(){
			// 更新追号区的余额显示
			$('#J-trace-statistics-balance').html($('[data-user-account-balance]').html());
			// 弹出追号窗口
			Games.getCurrentGameTrace().show();
			return false;
		});
		//追号窗口关闭
		$('#J-trace-panel').on('click', '.closeBtn', function(){
			//由关闭和取消按钮触发，恢复原来号码篮原来的倍数
			Games.getCurrentGameTrace().hide();
			Games.getCurrentGameTrace().deleteTrace();
		});
		// 追号投注
		$('#J-button-trace-confirm').click(function(){
			if( Games.getCurrentGameTrace().getIsTrace() ){
				Games.getCurrentGameTrace().hide();
				Games.getCurrentGameSubmit().submitData();
			}
		});
		// 追号确定按钮
		// 已经将保存方案的代码移入到原始对象中实现
		// hostGameTrace.js中搜"生成追号计划事件"
		// $('#J-button-trace-confirm').click(function(){
		// 	Games.getCurrentGameTrace().applyTraceData();
		// });
		//删除追号内容
		$('#J-chase-site-trace-delete').click(function(e){
			e.preventDefault();
			Games.getCurrentGameTrace().deleteTrace();
		});

		//submit loading
		Games.getCurrentGameSubmit().addEvent('beforeSend', function(e, msg){
			var panel = msg.win.dom.find('.pop-control'),
			comfirmBtn = panel.find('a.confirm'),
			cancelBtn = panel.find('a.cancel');
			comfirmBtn.addClass('btn-disabled');
			comfirmBtn.text('提交中...');
			msg.win.hideCancelButton();

		});
		Games.getCurrentGameSubmit().addEvent('afterSubmit', function(e, msg){
			var panel = msg.win.dom.find('.pop-control'),
			comfirmBtn = panel.find('a.confirm'),
			cancelBtn = panel.find('a.cancel');
			comfirmBtn.removeClass('btn-disabled');
			comfirmBtn.text('确 认');

			// 刷新投注记录
			$("#record-iframe").attr("src",$("#record-iframe").attr("src"));
			// 刷新余额
			$('[data-refresh-balance]:eq(0)').trigger('click');
		});

		// 游戏记录切换
		var recordTab = new dsgame.Tab({
			par           : '.game-record-section',
			triggers      : '.tabs li',
			panels        : '.record-content .tab-panel',
			currPanelClass: 'current-tab-panel',
			eventType     : 'click'
		});

	};

	init();

});