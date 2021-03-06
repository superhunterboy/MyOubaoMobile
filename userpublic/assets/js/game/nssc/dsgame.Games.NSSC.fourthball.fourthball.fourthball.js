﻿

(function(host, GameMethod, undefined){
	var defConfig = {
		name:'fourthball.fourthball.fourthball',
		//玩法提示
		tips:'',
		//选号实例
		exampleTip: ''
	},
	Games = host.Games,
	NSSC = Games.NSSC.getInstance();


	//定义方法
	var pros = {
		init:function(cfg){
			var me = this;

			//默认加载执行30期遗漏号码
			//me.getHotCold(me.getGameMethodName(), 'currentFre', 'lost');
			//初始化冷热号事件
			//me.initHotColdEvent();
		},
		//时时彩复式结构为5行10列
		//复位选球数据
		rebuildData:function(){
			var me = this;
			me.balls = [
					[-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1]
				];
		},
		buildUI:function(){
			var me = this;
			me.container.html(html_all.join(''));
		},
		makePostParameter: function(original){
			var me = this,
				i = 0,
				len = original.length,
				result = [];

			for(;i < len;i++){
				result.push(original[i].join('|'));
			}
			return result.join('');
		},
		checkBallIsComplete: function(){
			var me = this,
				ball = me.getBallData()[0],
				i = 0,
				len = ball.length,
				num = 0;
			for(;i < len;i++){
				if(ball[i] > 0){
					num++;
				}
			}
			//console.log(num);
			if(num >= 1){
				return me.isBallsComplete = true;
			}
			return me.isBallsComplete = false;
		},
		formatViewBalls:function(original){
			var me = this,
				result = [],
				len = original.length,
				i = 0;
			for (; i < len; i++) {
				result = result.concat(original[i].join('|'));
			}
			return result.join('|');
		},
		//获取总注数/获取组合结果
		//isGetNum=true 只获取数量，返回为数字
		//isGetNum=false 获取组合结果，返回结果为单注数组
		getLottery:function(isGetNum){
			var me = this,
				data = me.getBallData()[0],
				arr = [];
			if(me.checkBallIsComplete()){
				$.each(data, function(i){
					if(this > -1){
						arr.push(i);
					}
				});
			}
			return arr;
		},
		//获取随机数
		randomNum:function(){
			var me = this,
				i = 0,
				current = [],
				currentNum,
				ranNum,
				lotterys = [],
				order = null,
				dataNum = me.getBallData(),
				len = me.getBallData()[0].length,
				name_en = Games.getCurrentGame().getCurrentGameMethod().getGameMethodName(),
				name = me.defConfig.name;

			current[0] = Math.floor(Math.random() * len);
			lotterys = me.mathResult(current[0], 0, 9);
			order = {
				'type': name_en,
				'original':[current],
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
				xtText = [],
				xtText2 = [];

			$.each(data, function(i){
				item = this;
				xtText = [];
				trcls = '';
				trcls = i == 0 ? 'first' : trcls;
				trcls = i == dataLen - 1 ? 'last' : trcls;
				var number = item['wn_number'].split(""),
					hz = 0;
				html.push('<tr class="'+ trcls +'">');
					html.push('<td><span class="number">'+ item['issue'].substr(2) +' 期</span></td>');
					html.push('<td><span class="balls">');
					$.each(number, function(j){
						if( j == 3 ){
							html.push('<i class="curr">' + this + '</i>');
							hz += parseInt(this);
						}else{
							html.push('<i>' + this + '</i>');
						}
					});
					html.push('</span></td>');
					if( number.length == 5 ){
						var dx = '大', ds = '双';
						if( hz <= 4 ){
							dx = '小';
						}
						if( hz % 2 ){
							ds = '单';
						}
						html.push('<td>'+ dx + ds +'</td>');
					}else{
						html.push('<td>--</td>');
					}
				html.push('</tr>');
			});
			return html.join('');
		}

	};

	//html模板
	var html_head = [];
		//头部
		html_head.push('<div class="number-select-title balls-type-title clearfix"><div class="number-select-link"><a href="" class="pick-rule">选号规则</a><a href="" class="win-info">中奖说明</a></div><div class="function-select-title"></div></div>');
		html_head.push('<div class="number-select-content">');
		html_head.push('<ul class="ball-section">');
		//每行
	var html_row = [];
		html_row.push('<li>');
		html_row.push('<ul class="ball-content">');
			$.each([0,1,2,3,4,5,6,7,8,9,'大','小','单','双'], function(i){
				html_row.push('<li><a href="javascript:void(0);" data-param="action=ball&value='+ i +'&row=<#=row#>" class="ball-number">'+this+'</a></li>');
			});
		html_row.push('</ul>');
		html_row.push('</li>');

	var html_bottom = [];
		html_bottom.push('</ul>');
		html_bottom.push('</div>');
		//拼接所有
	var html_all = [],rowStr = html_row.join('');
		html_all.push(html_head.join(''));
		$.each([''], function(i){
			html_all.push(rowStr.replace(/<#=title#>/g, this).replace(/<#=row#>/g, i));
		});
		html_all.push(html_bottom.join(''));



	//继承GameMethod
	var Main = host.Class(pros, GameMethod);
		Main.defConfig = defConfig;
	//将实例挂在游戏管理器实例上
	NSSC.setLoadedHas(defConfig.name, new Main());

})(dsgame, dsgame.GameMethod);

