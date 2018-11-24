﻿(function(host, Danshi, undefined) {
	var defConfig = {
			name: 'housan.zhixuan.danshi',
			//玩法提示
			tips: '后三直选单式玩法提示',
			//选号实例
			exampleTip: '后三直选单式弹出层22提示'
		},
		Games = host.Games,
		SSC = Games.SSC.getInstance();


	//定义方法
	var pros = {
		init: function(cfg) {
			var me = this;
			//建立编辑器DOM
			//防止绑定事件失败加入定时器
			setTimeout(function() {
				me.initFrame();
			}, 25);
		},
		rebuildData: function() {
			var me = this;
			me.balls = [
				[-1, -1, -1, -1, -1, -1, -1, -1, -1, -1],
				[-1, -1, -1, -1, -1, -1, -1, -1, -1, -1],
				[-1, -1, -1, -1, -1, -1, -1, -1, -1, -1]
			];
		},
		//生成一个当前玩法的随机投注号码
		//该处实现复式，子类中实现其他个性化玩法
		//返回值： 按照当前玩法生成一注标准的随机投注单(order)
		randomNum: function() {
			var me = this,
				i = 0,
				current = [],
				currentNum,
				ranNum,
				order = null,
				dataNum = me.getBallData(),
				name = me.defConfig.name,
				name_en = Games.getCurrentGame().getCurrentGameMethod().getGameMethodName(),
				lotterys = [],
				original = [];

			//增加机选标记
			me.addRanNumTag();

			current = me.checkRandomBets();
			original = [
				[current.join(',')],
				[],
				[]
			];
			lotterys = me.combination(current);
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
		}
	};


	//继承Danshi
	var Main = host.Class(pros, Danshi);
	Main.defConfig = defConfig;
	//将实例挂在游戏管理器上
	SSC.setLoadedHas(defConfig.name, new Main());



})(dsgame, dsgame.Games.SSC.Danshi);