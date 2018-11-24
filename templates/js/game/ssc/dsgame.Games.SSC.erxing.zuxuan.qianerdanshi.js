﻿
(function(host, Danshi, undefined){
	var defConfig = {
		name:'erxing.zuxuan.qianerdanshi',
		//玩法提示
		tips: '前二组选单式玩法提示',
		//选号实例
		exampleTip: '前二组选单式弹出层1111提示'
	},
	Games = host.Games,
	SSC = Games.SSC.getInstance();


	//定义方法
	var pros = {
		init:function(cfg){
			var me = this;
			//建立编辑器DOM
			//防止绑定事件失败加入定时器
			setTimeout(function(){
				me.initFrame();
			},25);
		},
		rebuildData:function(){
			var me = this;
			me.balls = [
						[-1,-1,-1,-1,-1,-1,-1,-1,-1,-1],
						[-1,-1,-1,-1,-1,-1,-1,-1,-1,-1]
						];
		},
		//检测选球是否完整，是否能形成有效的投注
		//并设置 isBallsComplete
		checkBallIsComplete:function(data){
				//去除中文 && 全角符号 && 英文字符
			var me = this,
				i = 0,
				result = [];

				me.aData = [];
				me.sameData = [];
				me.errorData = [];
				me.tData = [];
				me.vData = [];

			//按规则进行拆分结果
			result = me.iterator(me.filterLotters(data)) || [];

			//判断结果
			for(;i<result.length;i++){
				if(me.defConfig.checkNum.test(result[i])
					&& result[i].length == me.balls.length
					&& !me.checkNumSameIndex(result[i], 2)){
					if(me.checkResult(result[i], me.tData)){
						me.tData.push(result[i].split(''))
					}else{
						if(me.checkResult(result[i], me.sameData)){
							//重复结果
							me.sameData.push(result[i].split(''));
						}
					}
					//正确结果[不去重]
					me.vData.push(result[i].split(''));
				}else{
					if(me.checkResult(result[i], me.errorData)){
						me.errorData.push(result[i].split(''));
					}
				}
				//记录
				if(me.checkResult(result[i], me.aData)){
					me.aData.push(result[i].split(''));
				}
			}
			//校验
			if(me.tData.length > 0){
				me.isBallsComplete = true;
				return me.tData;
			}else{
				me.isBallsComplete = false;
				return [];
			}
		},
		//用拆分符号拆分成单注
		//组选中的单式需要重新排序去除重复
		iterator: function(data) {
			var me= this,
				cfg = me.defConfig,
				result = [],
				breakNum = 0;

			for (var i = 0; i < data.length; i++) {
				if(cfg.filtration.test(data.charAt(i))){
					result.push(data.substr(breakNum, i - breakNum));
					breakNum = i+1;
				}
			}
			$.each(result, function(i){
				result[i] = result[i].split('').sort().join('');
			});
			return result;
		},
		randomNum:function(){
			var me = this,
				i = 0,
				current = [],
				currentNum,
				ranNum,
				lotterys = [],
				order = null,
				dataNum = me.getBallData(),
				len = me.getBallData().length,
				rowLen = me.getBallData()[0].length,
				name_en = Games.getCurrentGame().getCurrentGameMethod().getGameMethodName(),
				name = me.defConfig.name,
				original = [];

			//增加机选标记
			me.addRanNumTag();

			//生成随机数
			for(;i < 2; i++){
				var num = me.removeSameNum(current);
				current.push(num);
			}
			current.sort(function(a, b){
				return a > b ? 1 : -1;
			});

			original = [[current.join(',')],[]];
			lotterys.push(current);

			//生成投注格式
			order = {
				'type': name_en,
				'original': original,
				'lotterys': lotterys,
				'moneyUnit': Games.getCurrentGameStatistics().getMoneyUnit(),
				'multiple': Games.getCurrentGameStatistics().getMultip(),
				'onePrice': Games.getCurrentGame().getGameConfig().getInstance().getOnePrice(name_en),
				'num': lotterys.length
			};
			order['amountText'] = Games.getCurrentGameStatistics().formatMoney(order['num'] * order['moneyUnit'] * order['multiple'] * order['onePrice']);
			return order;
		},
		checkNumSameIndex: function(num, index){
			var me = this,
				result,
				arr = num.length > 0 ? num : [];

			for (var i = 0; i < arr.length; i++) {
				if(me.arrIndexOf(arr[i], arr) == index){
					result = true;
					break;
				}
			};

			return result || false;
		}


	};


	//继承Danshi
	var Main = host.Class(pros, Danshi);
		Main.defConfig = defConfig;
	//将实例挂在游戏管理器上
	SSC.setLoadedHas(defConfig.name, new Main());



})(dsgame, dsgame.Games.SSC.Danshi);

