//新init重构
$(function(){

	/*
	 *实例化个方法模块
	 */
	dsgame.Games.K3.getInstance({'jsNameSpace': 'dsgame.Games.K3.'});//游戏实例
	dsgame.GameTypes.getInstance();//游戏玩法切换
	dsgame.GameStatistics.getInstance();//统计实例
	dsgame.GameOrder.getInstance();//号码篮实例
	dsgame.GameTrace.getInstance();//追号实例
	dsgame.GameSubmit.getInstance();//提交
	dsgame.Games.K3.Message.getInstance();//消息类

	/*
	 *全局变量
	 */
	var Games = dsgame.Games;//初始化公共访问对象
	var isTimeEndAlertShow = false; //超时后提示信息
	var gData = Games.getCurrentGame().getGameConfig().getInstance(); //config数据缓存
	var gConfig = gData;// 新配置数据会更新
	var gCNumber = gData.getCurrentGameNumber();//当前期号
	var timerNum;//开奖动作定时器名称
	var numbersIsVisible = false;// 开奖号码是否显示
	var isFirstLottery = true; //一次标识
	var minAmountTip = new dsgame.Tip({cls:'j-ui-tip-alert j-ui-tip-b j-ui-tip-showrule',text:'使用厘模式进行投注，单注注单最小金额为0.02元'});


	// 开奖号码（配置窗口）
	var lotteryPopBoard = new dsgame.MiniWindow({
			cls: 'lottery-board-pop',
			effectShow: function (){
							var me = this;
							me.dom.css({
								display: 'block',
								left: '50%',
								marginLeft: -me.dom.outerWidth() / 2,
								top: -me.dom.outerHeight() * 2
							}).animate({
								top: 206
							});
						},
			effectHide: function (){
							var me = this;
							me.dom.animate({
								top: -me.dom.outerHeight() * 2
							}, function(){
								me.dom.hide();
							});
						}
		}),numberErnie,numberPopErnie,ballErnie = [0,1,2,3,4,5,6],ballHeight = 64,ballPopHeight = 74, diceAnim;
	// 开奖动画
	var diceAnimation = function($dices){
		this.$dices = $dices || $('.dice');
		this.rands = ['a', 'b', 'c', 'd'];
		this.randLen = this.rands.length;
		this.timeout = 150;
		this.animation = function(ballsArr, callback){
			var me = this;
			me.$dices.each(function(idx, dice){
				var $dice = $(dice),
					nums = me.randomBelle(me.randLen, me.randLen-1, 0);
				$dice.attr('class', 'dice')
					.delay(me.timeout).animate({opacity: 'show'}, 100, function(){
						$dice.addClass('dice_' + me.rands[nums[0]]);
					}).delay(me.timeout).animate({opacity: 'show'}, 100, function(){
						$dice.removeClass('dice_' + me.rands[nums[0]]).addClass('dice_' + me.rands[nums[1]]);
					}).delay(me.timeout).animate({opacity: 'show'}, 600, function(){
						$dice.removeClass('dice_' + me.rands[nums[1]]).addClass('dice_' + me.rands[nums[2]]);
					}).delay(me.timeout).animate({opacity: 'show'}, 600, function(){
						$dice.removeClass('dice_' + me.rands[nums[2]]).addClass('dice_' + me.rands[nums[3]]);
					}).delay(me.timeout).animate({opacity: 'show'}, 100, function(){
						$dice.removeClass('dice_' + me.rands[nums[3]]).addClass('dice_' + ballsArr[idx]);
						if( callback && typeof callback == 'function' ){
							callback();
						}
					});
			});
		}
		this.randomBelle = function(count, maxs, mins){
			var numArray = new Array();
			//getArray(4,27,0); //4是生成4个随机数,27和0是指随机生成数是从0到27的数
			function getArray(count, maxs, mins){
				while(numArray.length < count){
					var temp = getRandom(maxs,mins);
					if(!search(numArray,temp)){
						numArray.push(temp);
					}
				}
				//alert("生成的数组为:"+numArray);
				return numArray;
			}
			function getRandom(maxs, mins){  //随机生成maxs到mins之间的数
				return Math.round(Math.random()*(maxs-mins))+mins;
			}
			function search(numArray, num){   //array是否重复的数
				for(var i=0; i<numArray.length; i++){
					if(numArray[i] == num){
						return true;
					}
				}
				return false;
			}
			return getArray(count, maxs, mins);
		}
	};

	//开奖号码显示1（反转）
	var showLotteryBoard = function(number, ballsArr){
			var $dom = $('#lottery-numbers-board');
			$('#J-ernie-issue').html(number);
			if( ballsArr && ballsArr.length ){
				if( !diceAnim ){
					$dom.find('[data-lottery-ernie-numbers]').replaceWith( getLotteryBoardHtml(ballsArr.length) );
					diceAnim = new diceAnimation($dom.find('.dice'));
				}
				$('#J-lottery-ernie-numbers').show();
				$('.J-loading-lottery').hide();
				var hz = 0, dx = '大', ds = '双';
				$.each(ballsArr, function(i, ball){
					hz += parseInt(ball);
				});
				if( hz <= 10 ) dx = '小';
				// if( hz <= 9 ) dx = '小';
				if( hz % 2 ) ds = '单';
				diceAnim.animation(ballsArr, function(){
					$('#J-lottery-property-hz').html(hz);
					$('#J-lottery-property-dx').html(dx);
					$('#J-lottery-property-ds').html(ds);
				});
			}else{
				$('#J-lottery-ernie-numbers').hide();
				$('.J-loading-lottery').show();
			}
		};
	//开奖号码动作完成后执行
	var ernieCallback=function (){
			gCNumber = gData.getCurrentGameNumber();
		};
	//号码反转dom结构
	var getLotteryBoardHtml=function(len){
		var html = ['<div style="display:none;" id="J-lottery-ernie-numbers" class="lottery-ernie-numbers lottery-ernie-numbers-' +len+ '">'];
		for(var i=0; i<len; i++){
			html.push('<div class="dice"></div>');
		}
		html.push('<div class="lottery-property">和值：<b id="J-lottery-property-hz">?</b>' +
					'<br/>形态：<span id="J-lottery-property-dx">?</span><i id="J-lottery-property-ds">?</i></div>');
		html.push('</div>');
		return html.join('');
	};
	//定时跑开奖动作
	var newLotteryFun = function(){
			var me = this;
			//如果是第一次开奖则使用上一期的开奖奖期
			if(isFirstLottery){
				gCNumber = gData.getLastGameNumber();
				isFirstLottery = false;
			}
			$.ajax({
				url:gData.getLoadIssueUrl(),
				dataType:'JSON',
				success:function(data){
					if(data['last_number']['issue'] - gCNumber >0 ){ //如果差居在2期以上进行修正
						gCNumber = data['last_number']['issue'];
					};
					if (data['last_number']['issue'] == gCNumber){
						timerNum.stop();
						gConfig = data;
						showLotteryBoard( data['last_number']['issue'], (''+data['last_number']['wn_number']).split('') );

						if(gConfig['issues'][0]['issue'] == gConfig['last_number']['issue'] && gConfig['issues'][0]['wn_number'] == '' ){
							gConfig['issues'][0]['wn_number'] = gConfig['last_number']['wn_number']
						}

						gameConfigData['issueHistory']['issues'] = gConfig['issues'];
						Games.getCurrentGame().getCurrentGameMethod().miniTrend_updateTrend();

					}else{
						showLotteryBoard(gCNumber);
					}
				}
			});
		};
	//登陆超时提醒
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

	//界面渲染加载
	var updateView = function(){
			var time = gData.getCurrentLastTime(),
				timeNow = gData.getCurrentTime(),
				surplusTime = time - timeNow,
				timer,
				fn,
				currentNumber = '' + gData.getCurrentGameNumber(),
				timeDoms = $('.J-lottery-countdown li em'),
				traceTimeDom = $('#J-trace-statistics-countdown'),
				message = Games.getCurrentGameMessage();


			fn = function(){
				if(surplusTime < 0){
					timer.stop();
					Games.getCurrentGame().getServerDynamicConfig(function(){
						var newCurrentNumber = '' + gData.getCurrentGameNumber(),
							timer,
							sNum = 2;

						//关闭未下单弹窗
						message.hide();
						//清空追号数据
						Games.getCurrentGameTrace().autoDeleteTrace();
						Games.getCurrentGameTrace().hide();

						//当当前期期号不同时,提示用户期号变化
						if(currentNumber != newCurrentNumber){
							message.showTip('<div class="tipdom-cont">当前已进入第<div class="row" style="color:#F60;font-size:18px;">'+ newCurrentNumber +' 期</div><div class="row">请留意期号变化 (<span id="J-gamenumber-change-s-num">3</span>)</div></div>');
							timer = setInterval(function(){
								$('#J-gamenumber-change-s-num').text(sNum);
								sNum -= 1;
								if(sNum < -1){
									clearInterval(timer);
									message.hideTip();
								}
							}, 1 * 1000);
						};
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
		};
	//游戏记录tab
	var recordTab = function(){
		$("div.game-record-section>ul>li").click(function(){
			var me= $(this);
			$("div.game-record-section>ul>li").removeClass('current');
			me.addClass('current');
			$('#record-iframe').attr("src",me.attr("srclink"));
		})
	};
	var switchBoardFun = function(){
		var lastNumber = gConfig['last_number'] ? gConfig['last_number']['issue'] : gConfig.getLastGameNumber();
		var lotteryBalls = gConfig['last_number']? (''+gConfig['last_number']['wn_number']).split('') :(''+gConfig.getLotteryBalls()).split('');
		// console.log(gConfig.getLotteryBalls())
		if( gConfig.getLotteryBalls() == '' ){
			//showLotteryBoard(lastNumber, lotteryBalls);
			timerNum = new dsgame.Timer({time:5000,isNew:true,fn:newLotteryFun});
		}else{
			showLotteryBoard(lastNumber, lotteryBalls);
		}
		return false;
	};

	/*
	 * 自执行
	 */
	 // createLotteryNumbers();
	 updateView();
	 recordTab();
	 switchBoardFun();
	/*
	 *触发事件类
	 */
	//当最新的配置信息和新的开奖号码出现后，进行界面更新
	Games.getCurrentGame().addEvent('changeDynamicConfig', function(e, cfg){
		//跑定时器
		timerNum = new dsgame.Timer({time:5000,isNew:true,fn:newLotteryFun});
		updateView();
	});
	// 切换开奖记录／开奖号码面板

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
		var id = Games.getCurrentGame().getCurrentGameMethod().getId(),
			unit = Games.getCurrentGameStatistics().getMoneyUnit(),
			maxv = Games.getCurrentGame().getGameConfig().getInstance().getLimitByMethodId(id, unit),
			methodCfg = Games.getCurrentGame().getGameConfig().getInstance().getPrizeById(id),
			MaxPrizeGroup = Games.getCurrentGame().getGameConfig().getInstance().getMaxPrizeGroup(),
			maxUserPrizeLength =  Games.getCurrentGame().getGameConfig().getInstance().getOptionalPrizes().length,
			maxUserPrize = Games.getCurrentGame().getGameConfig().getInstance().getOptionalPrizes()[maxUserPrizeLength-1]['prize_group'],
			prize = 0,
			showPrize=false;

		methodPrize = Number(methodCfg['prize']);
		showPrize = methodCfg['display_prize'];
		if(maxUserPrize>MaxPrizeGroup){
			prize = methodPrize * unit*MaxPrizeGroup /maxUserPrize;
		}else{
			prize = methodPrize * unit;
		};
		Games.getCurrentGameStatistics().getMultipleDom().setMaxValue(maxv);

		if(showPrize){
			$('#J-method-prize').show();
			$('#J-method-prize').find('span').html( dsgame.util.formatMoney(prize) );
		}else{
			$('#J-method-prize').hide();
		};
		Games.getCurrentGame().getCurrentGameMethod().miniTrend_updateTrend();
	});
	//加载默认玩法
	Games.getCurrentGameTypes().addEvent('endShow', function() {
		this.changeMode(Games.getCurrentGame().getGameConfig().getInstance().getDefaultMethodId());
	});

	// 将选球数据添加到号码篮
	$('#J-add-order').click(function(){
		var result = Games.getCurrentGameStatistics().getResultData();
		if(!result['mid'] || result['amount']<'0.02'){
			return;
		}
		Games.getCurrentGameOrder().add(result);
	});
	//根据选球内容更新添加按钮的状态样式
	Games.getCurrentGameStatistics().addEvent('afterUpdate', function(e, num, money){
		var me = this, button = $('#J-add-order'),
			MaxPrizeGroup = Games.getCurrentGame().getGameConfig().getInstance().getMaxPrizeGroup(),
			maxUserPrizeLength =  Games.getCurrentGame().getGameConfig().getInstance().getOptionalPrizes().length,
			maxUserPrize = Games.getCurrentGame().getGameConfig().getInstance().getOptionalPrizes()[maxUserPrizeLength-1]['prize_group'];

		if(num > 0){
			if(money>='0.02'){

				button.removeClass('btn-disable');
				// 计算返点
				var rate = me.getPrizeGroupRate() || 0;
				me.setRebate(money, rate);
				minAmountTip.hide();
			}else{
				minAmountTip.show(minAmountTip.getDom().width()/2 * -1 + button.width()/2, minAmountTip.getDom().height() * -1 - 20, button);
				button.addClass('btn-disable');
				me.setRebate(0);
			}
		}else{
			button.addClass('btn-disable');
			me.setRebate(0);
			minAmountTip.hide();
		};

		var prize = methodPrize * Number( me.getMoneyUnit());
		// 计算最低单注奖金
		if(maxUserPrize>MaxPrizeGroup){
			prize = methodPrize * Number( me.getMoneyUnit() )*MaxPrizeGroup /maxUserPrize;
		};
		$('#J-method-prize').find('span').html( dsgame.util.formatMoney(prize) );
	});

	//号码蓝模拟滚动条(该滚动条初始化使用autoReinitialise: true参数也可以达到自动调整的效果，但是是用的定时器检测)
	var gameOrderScroll = $('#J-panel-order-list-cont'),
		gameOrderScrollAPI;
	gameOrderScroll.jScrollPane();
	gameOrderScrollAPI = gameOrderScroll.data('jsp');
	
	//注单提交按钮的禁用和启用
	//数字改变闪烁动画
	Games.getCurrentGameOrder().addEvent('afterChangeLotterysNum', function(e, lotteryNum){
		var me = this,subButton = $('#J-submit-order'),traceButton = $('#J-trace-switch'),rederData=e.data['orderData'],unitType = false;
		var cartEmpty = $('.J-cart-empty');
		if(lotteryNum > 0){
			for(var i = 0 ;i<rederData.length; i++){
				(rederData[i]['moneyUnit'] == 0.001 ) ? unitType = true : '';
			}
			if(unitType ){
				subButton.removeClass('btn-bet-disable');
				traceButton.addClass('btn-bet-disable');
			}else{
				subButton.add(traceButton).removeClass('btn-bet-disable');
			}
			cartEmpty.hide();
			gameOrderScrollAPI.reinitialise();
		}else{
			subButton.add(traceButton).addClass('btn-bet-disable');
			cartEmpty.show();
		}
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
		var orderData = Games.getCurrentGameOrder().orderData, moneyUnit = false;
		for(var i = 0 ; i<orderData.length; i++){
			(orderData[i].moneyUnit == '0.001')? moneyUnit = true : '';
		}
		if(moneyUnit){
			return false;
		}
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
			Games.getCurrentGameTrace().deleteTrace();
		};
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
		$('#record-iframe').attr("src",$(".game-record-section >ul.tabs >li.current").attr("srclink"));
		// 刷新余额
		$('[data-refresh-balance]:eq(0)').trigger('click');
	});
	//延迟一秒执行页面上滚定位到投注区
	setTimeout( function(){
		$('html,body').animate({scrollTop: 140}, 400);
	}, 1000)
	//调整界面布局
	$('.play-section').addClass('play-section-no-gametypes');

});