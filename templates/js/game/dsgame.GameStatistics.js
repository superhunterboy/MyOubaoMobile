
//游戏选球统计，如注数、当前操作金额等
(function(host, name, Event, undefined){
	var defConfig = {
		//主面板dom
		mainPanel          : '#J-balls-statistics-panel',
		//注数dom
		lotteryNumDom      : '#J-balls-statistics-lotteryNum',
		//倍数
		multipleDom        : '#J-balls-statistics-multiple',
		//总金额
		amountDom          : '#J-balls-statistics-amount',
		moneyUnitDom       : '#J-balls-statistics-moneyUnit',
		moneyUnitTriggerDom: '#J-balls-statistics-moneyUnit-trigger',
		//元/角模式比例  1为元模式 0.1为角模式 0.01分模式
		moneyUnit          : gameConfigData['defaultCoefficient'],
		//元角模式对应的中文
		moneyUnitData      : gameConfigData['availableCoefficients'],
		//倍数
		multiple           : gameConfigData['defaultMultiple'],
		bonusGroupMax      : gameConfigData['maxPrizeGroup']
	},
	instance,
	Games = host.Games;

	var pros = {
		init:function(cfg){
			var me = this;
			Games.setCurrentGameStatistics(me);

			me.panel = $(cfg.mainPanel);
			me.moneyUnit = cfg.moneyUnit;
			me.multiple = cfg.multiple;
			//已组合好的选球数据
			me.lotteryData = [];


			//倍数选择模拟下拉框
			me.multipleDom = new dsgame.Select({
				cls:'select-game-statics-multiple',
				realDom:cfg.multipleDom,
				isInput:true,
				isCounter: true,
				expands:{
					inputEvent:function(){
						var meSelect = this;
						this.getInput().keyup(function(e){
							var v = this.value,
								id = Games.getCurrentGame().getCurrentGameMethod().getId(),
								unit = me.getMoneyUnit(),
								maxv = maxv = (Games.getCurrentGame().getGameConfig().getInstance().getLimitByMethodId(id, unit)==0) ? v: Games.getCurrentGame().getGameConfig().getInstance().getLimitByMethodId(id, unit);
							this.value = this.value.replace(/[^\d]/g, '');
							if($.trim(this.value) != ''){
								v = Number(this.value);
								if(v < 1){
									this.value = 1;
								}else if(v > maxv){
									this.value = maxv;
								}
								meSelect.setValue(this.value);
							}
						});
						this.getInput().blur(function(){
							var v = this.value,
								id = Games.getCurrentGame().getCurrentGameMethod().getId(),
								unit = me.getMoneyUnit(),
								maxv = (Games.getCurrentGame().getGameConfig().getInstance().getLimitByMethodId(id, unit)==0) ? v: Games.getCurrentGame().getGameConfig().getInstance().getLimitByMethodId(id, unit);
							this.value = this.value.replace(/[^\d]/g, '');
							v = Number(this.value);
							if(v < 1){
								this.value = 1;
							}else if(v > maxv){
								this.value = maxv;
							}
							meSelect.setValue(this.value);
						});
					}
				}
			});
			me.multipleDom.setValue(me.multiple);
			me.multipleDom.addEvent('change', function(e, value, text){
				var num = Number(value),
					id = Games.getCurrentGame().getCurrentGameMethod().getId(),
					unit = me.getMoneyUnit(),
					maxnum = (Games.getCurrentGame().getGameConfig().getInstance().getLimitByMethodId(id, unit)==0) ? num: Games.getCurrentGame().getGameConfig().getInstance().getLimitByMethodId(id, unit);

				if(num > maxnum){
					num = maxnum;
					this.setValue(num);
				}
				me.setMultiple(num);
				me.updateData({'lotterys':Games.getCurrentGame().getCurrentGameMethod().getLottery(),'original':Games.getCurrentGame().getCurrentGameMethod().getOriginal()}, Games.getCurrentGame().getCurrentGameMethod().getName());
				$('#J-balls-statistics-multipleNum').text(num);
			});

			//元角模式模拟下拉框
			me.moneyUnitDom = new dsgame.Select({cls:'select-game-statics-moneyUnitDom',realDom:cfg.moneyUnitDom});
			//在未添加change事件之前设置初始值
			me.moneyUnitDom.setValue(me.moneyUnit);
			me.moneyUnitDom.addEvent('change', function(e, value, text){
				var multiple = me.getMultip(),
					id = Games.getCurrentGame().getCurrentGameMethod().getId(),
					unit = Number(value),
					maxnum = (Games.getCurrentGame().getGameConfig().getInstance().getLimitByMethodId(id, unit)==0) ? 1: Games.getCurrentGame().getGameConfig().getInstance().getLimitByMethodId(id, unit);
				multiple = multiple > maxnum ? maxnum : multiple;
				me.setMultipleDom(multiple);
				me.setMoneyUnit(Number(value));
				me.multipleDom.setMaxValue(maxnum);
				me.updateData({'lotterys':Games.getCurrentGame().getCurrentGameMethod().getLottery(),'original':Games.getCurrentGame().getCurrentGameMethod().getOriginal()}, Games.getCurrentGame().getCurrentGameMethod().getName());
			});

			// 隐藏元角模式下拉元素，由trigger元素触发
			me.hidesetMoneyUnitDom();
			var moneyUnitTriggerDom = $(cfg.moneyUnitTriggerDom);
			me.setMoneyUnitTriggerDom( moneyUnitTriggerDom );
			moneyUnitTriggerDom.on('click', 'a[data-value]', function(){
				var value = $(this).data('value');
				if( value && !$(this).hasClass('current') ){
					me.moneyUnitDom.setValue(value);
					$(this).addClass('current').siblings().removeClass('current');
				}
				return false;
			});
			// 初始化trigger高亮状态
			$('a[data-value="' + me.moneyUnit + '"]', moneyUnitTriggerDom).addClass('current');

			//设置奖金组
			var bonusGroup = Games.getCurrentGame().getGameConfig().getInstance().getOptionalPrizes(),
				bonusLength = bonusGroup.length,
				$prizeGroupParent = $('.J-prize-group-slider'),
				$prizeGroupInput = $('#J-bonus-select-value'),
				$prizeGroupPercent = $prizeGroupParent.find('[data-slider-percent]'),
				$prizeGroupValue = $prizeGroupParent.find('[data-slider-value]'),
				availableIdx = bonusLength - 1,
				bonusGroupMax = (defConfig.bonusGroupMax && defConfig.bonusGroupMax != '0') ? defConfig.bonusGroupMax : bonusGroup[bonusLength-1]['prize_group'];

			for(;availableIdx>=0;availableIdx--){
				if( bonusGroup[availableIdx]['prize_group'] <= bonusGroupMax ){
					break;
				}
			}
			me.bonusGroup = bonusGroup;
			//自定义奖金组设置组件
			me.prizeSlider = new dsgame.SliderBar({
				// 'isUpOnly' : true,
				'minDom'   : '[data-slider-sub]',
				'maxDom'   : '[data-slider-add]',
				'contDom'  : '[data-slider-cont]',
				'handleDom': '[data-slider-handle]',
				'innerDom' : '[data-slider-inner]',
				'minNumDom': '[data-slider-min]',
				'maxNumDom': '[data-slider-max]',
				'parentDom': $prizeGroupParent,
				'step'     : 1,
				'minBound' : 0,
				'maxBound' : bonusLength-1,
				'rangeBound': [0, availableIdx],
				'value'     : availableIdx
			});
			// 设置初始化奖金组
			// me.prizeSlider.setValue(availableIdx);
			// var initBonus = bonusGroup[availableIdx]['prize_group'],
			// 	initRate = bonusGroup[availableIdx]['rate'];
			// $prizeGroupInput.val(initBonus);
			// $prizeGroupPercent.text((initRate*100).toFixed(2) +'%');
			// $prizeGroupValue.text(initBonus);
			me.prizeSlider.addEvent('change', function(){
				var bonus = bonusGroup[this.getValue()]['prize_group'],
					rate = bonusGroup[this.getValue()]['rate'],
					rateTxt = (rate*100).toFixed(2) +'%';
				$prizeGroupInput.val(bonus);
				$prizeGroupPercent.text(rateTxt);
				$prizeGroupValue.text(bonus);
				var result = me.getResultData();

				if( result && result['amount'] ){
					me.setRebate( result['amount'], rate );
				}
			});
			$(function(){
				me.prizeSlider.setValue(availableIdx);
				// me.triggerMoneyUnit( me.moneyUnit );
			});

			//初始化相关界面，使得界面和配置统一
			me.updateData({'lotterys':[],'original':[]});

		},
		getMultipleDom:function(){
			return this.multipleDom;
		},
		getMultipleTextDom:function(){
			return $('#J-balls-statistics-multiple-text');
		},
		getMoneyUnitText:function(moneyUnit){
			return this.defConfig.moneyUnitData[''+moneyUnit];
		},
		//更新各种数据
		updateData:function(data, name){
			var me = this,
				cfg = me.defConfig,
				count = data['lotterys']? data['lotterys'].length : 0,
				price = 2,
				multiple = me.multiple,
				moneyUnit = me.moneyUnit;


				if(Games.getCurrentGame() && Games.getCurrentGame().getCurrentGameMethod()){
					price = Games.getCurrentGame().getGameConfig().getInstance().getOnePriceById(Games.getCurrentGame().getCurrentGameMethod().getId());
				}

			//设置投注内容
			me.setLotteryData(data);
			//设置倍数
			//由于设置会引发updateData的死循环，因此在init里手动设置一次，之后通过change事件触发updateData
			//me.setMultipleDom(multiple);
			//更新元角模式
			me.setMoneyUnitDom(moneyUnit);
			//更新注数
			me.setLotteryNumDom(count);
			//更新总金额
			me.setAmountDom(me.formatMoney(count * moneyUnit * multiple * price));
			//参数：注数、金额
			me.fireEvent('afterUpdate', count, count * moneyUnit * multiple * price);

		},
		//获取当前数据
		getResultData:function(){
			var me = this,
				onePrice,
				method = Games.getCurrentGame().getCurrentGameMethod(),
				lotterys = me.getLotteryData();
			if(lotterys['lotterys'].length < 1){
				return {};
			}
			onePrice = Games.getCurrentGame().getGameConfig().getInstance().getOnePriceById(method.getId());
			return {
					mid:method.getId(),
					type:method.getName(),
					original:lotterys['original'],
					lotterys:lotterys['lotterys'],
					moneyUnit:me.moneyUnit,
					num:lotterys['lotterys'].length,
					multiple:me.multiple,
					//单价
					//onePrice:me.onePrice,
					//单价修改为从动态配置中获取，因为每个玩法有可能单注价格不一样
					onePrice:onePrice,
					//总金额
					amount:lotterys['lotterys'].length * me.moneyUnit * me.multiple * onePrice,
					//格式化后的总金额
					amountText:me.formatMoney(lotterys['lotterys'].length * me.moneyUnit * me.multiple * onePrice),
					//当前注奖金组
					prizeGroup:Games.getCurrentGame().getGameConfig().getInstance().setOptionalPrizes(),
					prizeGroupVal:$('#J-balls-statistics-rebate').text(),
				};
		},
		//设置元角模式
		setMoneyUnit:function(num){
			var me = this;
			me.moneyUnit = num;
		},
		getMoneyUnit:function(){
			return this.moneyUnit;
		},
		getLotteryData:function(){
			return this.lotteryData;
		},
		setLotteryData:function(data){
			var me = this;
			me.lotteryData = data;
		},
		//将数字保留两位小数并且千位使用逗号分隔
		formatMoney:function(num){
			var num = Number(num),
				re = /(-?\d+)(\d{3})/;

			if(Number.prototype.toFixed){
				num = (num).toFixed(3);
			}else{
				num = Math.round(num*100)/100
			}
			num  =  '' + num;
			while(re.test(num)){
				num = num.replace(re,"$1,$2");
			}
			return num;
		},
		//注数
		getLotteryNumDom:function(){
			var me = this,cfg = me.defConfig;
			return me.lotteryNumDom || (me.lotteryNumDom = $(cfg.lotteryNumDom));
		},
		setLotteryNumDom:function(v){
			var me = this;
			me.getLotteryNumDom().html(v);
		},
		//倍数
		getMultipleDom:function(){
			return this.multipleDom;
		},
		getMultip: function() {
			var me = this;
			return me.multiple;
		},
		setMultipleDom:function(v){
			var me = this;
			me.getMultipleDom().setValue(v);
		},
		setMultiple:function(num){
			this.multiple = num;
		},
		//元角模式
		getMoneyUnitDom:function(){
			return this.moneyUnitDom;
		},
		setMoneyUnitDom:function(v){
			var me = this, u = v;
				// u = (v == '0.01') ? '分' : (v == '0.10'|| v == '0.10')? '角':'元';
		    if( defConfig.moneyUnitData[v] ){
		    	u = defConfig.moneyUnitData[v];
		    }
			me.setMoneyUnit(v);
			$('.select-game-statics-moneyUnitDom input').val(u);
		},
		setMoneyUnitTriggerDom: function($dom){
			this.moneyUnitTriggerDom = $dom;
		},
		getMoneyUnitTriggerDom: function(){
			return this.moneyUnitTriggerDom;
		},
		triggerMoneyUnit: function(moneyUnit){
			var me = this,
				myEvent = $.Event('click'),
				dom = me.getMoneyUnitTriggerDom();

			myEvent.target = dom.find('a[data-value]').filter(function(){
				return Number($(this).data('value')) == Number(moneyUnit);
			})[0];

			dom.trigger(myEvent);
		},
		hidesetMoneyUnitDom: function(){
			this.moneyUnitDom.hide();
		},
		// 奖金组
		getPrizeSlider: function(){
			return this.prizeSlider;
		},
		// 获取当前选中的奖金组
		getPrizeGroup: function(){
			return this.bonusGroup[this.prizeSlider.getValue()]['prize_group'];
		},
		// 获取当前选中的奖金组返点
		getPrizeGroupRate: function(){
			return this.bonusGroup[this.prizeSlider.getValue()]['rate'];
		},
		setSliderValueByPrizeGroup: function(prizeGroup){
			var index = -1;
			$.each(this.bonusGroup, function(i,n){
				if( n['prize_group'] == prizeGroup ){
					return index = i;
				}
			});
			this.getPrizeSlider().setValue(index);
		},
		// 设置返点
		setRebate: function(money, rate){
			var str = '',
				numPoint = Math.pow(10,8); // 用于解决计算小数时出现浮点数计算不准确的bug
			if( money <= 0 || rate <= 0 ){
				str = '0.00';
			}else{
				money = '' + parseFloat(money * (rate * numPoint) / numPoint || 0);
				money = money.split('.')
				if( money[1] ){
					var digit = ''+money[1];
					if( digit.length > 8 ){
						digit = digit.slice(0,8);
					}
					str = host.util.formatMoney(money[0],0) + '.' + digit;
				}else{
					str = host.util.formatMoney(money[0],2)
				}
			}
			$('#J-balls-statistics-rebate').text(str);
		},
		//总金额
		getAmountDom:function(){
			var me = this,cfg = me.defConfig;
			return me.amountDom || (me.amountDom = $(cfg.amountDom));
		},
		setAmountDom:function(v){
			var me = this;
			me.getAmountDom().html(v);
		},
		reSet:function(){
			var me = this,cfg = me.defConfig;
			//取消还原倍数
			me.multipleDom.setValue(1);
			//取消还原圆角模式
			//me.moneyUnitDom.setValue(cfg.moneyUnit);
		}


	};

	var Main = host.Class(pros, Event);
		Main.defConfig = defConfig;
		Main.getInstance = function(cfg){
			return instance || (instance = new Main(cfg));
		};
	host[name] = Main;

})(dsgame, "GameStatistics", dsgame.Event);