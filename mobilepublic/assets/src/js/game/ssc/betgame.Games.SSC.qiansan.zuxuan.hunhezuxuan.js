﻿
(function(host, Danshi, undefined){
	var defConfig = {
		name:'qiansan.zuxuan.hunhezuxuan',
		//父容器
		UIContainer:'#J-balls-main-panel'
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
						[-1,-1,-1,-1,-1,-1,-1,-1,-1,-1],
						[-1,-1,-1,-1,-1,-1,-1,-1,-1,-1]
						];
		},
		//检测单注号码是否通过
		checkSingleNum: function(lotteryNum){
			var me = this;
			if(lotteryNum.length != me.balls.length){
				return false;
			}
			if(lotteryNum[0] == lotteryNum[1] && lotteryNum[0] == lotteryNum[2]){
				return false;
			}
			return me.defConfig.checkNum.test(lotteryNum.join('')) && lotteryNum.length == me.balls.length;
		},
		//检测选球是否完整，是否能形成有效的投注
		//并设置 isBallsComplete 
		checkBallIsComplete:function(data){
			var me = this,
				len,
				i = 0,
				balls,
				ballsstr,
				has = {},
				result = [];

				me.aData = [];
				me.vData = [];
				me.sameData = [];
				me.errorData = [];
				me.tData = [];
			
			//按规则进行拆分结果
			result = me.iterator(me.filterLotters(data));
			len = result.length;

			for(i = 0; i < len; i++){
				
				balls = result[i].split('');
				ballsstr = result[i].split('').sort();

				//检测基本长度
				if(me.checkSingleNum(balls)){
					if(has[ballsstr]){
						//重复
						me.sameData.push(balls);
					}else{
						me.tData.push(balls);
						has[ballsstr] = true;
					}
				}else{
					me.errorData.push(balls);
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
		randomNum: function() {
			var me = this,
				i = 0,
				current = [],
				currentNum,
				ranNum,
				lotterys = [],
				order = null,
				original = [],
				dataNum = me.getBallData(),
				len = me.getBallData().length,
				rowLen = me.getBallData()[0].length,
				name_en = Games.getCurrentGame().getCurrentGameMethod().getGameMethodName(),
				name = me.defConfig.name;

			//增加机选标记
			me.addRanNumTag();

			//生成随机数
			for (; i < len; i++) {
				if (i == 2) {
					current[i] = me.removeSameNum(current)
				} else {
					current[i] = Math.floor(Math.random() * rowLen);
				}
			}
			current.sort(function(a, b) {
				return a > b ? 1 : -1;
			});

			original = [
				[current.join(',')],
				[],
				[]
			];
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

		miniTrend_createHeadHtml:function(){
			var me = this,
				html = [];
			html.push('<table width="100%" class="table bet-table-trend" id="J-minitrend-trendtable-'+ me.getId() +'">');
				html.push('<thead><tr>');
				html.push('<th><span class="number">奖期</span></th>');
				html.push('<th><span class="balls">开奖</th>');
				html.push('<th><span>形态</span></th>');
				html.push('</tr></thead>');
				html.push('<tbody>');
			return html.join('');
		},
		miniTrend_createRowHtml:function(){
			var me = this,
				data = me.miniTrend_getBallsData(),
				dataLen = data.length,
				trcls = '',
				currCls = 'curr',
				item,
				html = [],
				xtText = '';

			$.each(data, function(i){
				item = this;
				trcls = '';
				trcls = i == 0 ? 'first' : trcls;
				trcls = i == dataLen - 1 ? 'last' : trcls;
				var number = item['wn_number'].split("");
				html.push('<tr class="'+ trcls +'">');
					html.push('<td><span class="number">'+ item['issue'].substr(2) +' 期</span></td>');
					html.push('<td><span class="balls">');
					$.each(number, function(j){
						if(j < 3){
							currCls = 'curr';
						}else{
							currCls = '';
						}
						html.push('<i class='+ currCls +'>' + this + '</i>');
					});
					html.push('</span></td>');
					//console.log(item['balls']);
					if(parseInt(number[0]) == parseInt(number[1]) || parseInt(number[0]) == parseInt(number[2]) || parseInt(number[1]) == parseInt(number[2])){
						if(parseInt(number[0]) == parseInt(number[1]) && parseInt(number[0]) == parseInt(number[2])){
							xtText = '豹子';
						}else{
							xtText = '组三';
						}
					}else{
						xtText = '组六';
					}
					//console.log(xtText);
					html.push('<td>'+ xtText +'</td>');
				html.push('</tr>');
			});
			return html.join('');
		}
	};


	//继承Danshi
	var Main = host.Class(pros, Danshi);
		Main.defConfig = defConfig;
	//将实例挂在游戏管理器上
	SSC.setLoadedHas(defConfig.name, new Main());



})(betgame, betgame.Games.SSC.Danshi);
