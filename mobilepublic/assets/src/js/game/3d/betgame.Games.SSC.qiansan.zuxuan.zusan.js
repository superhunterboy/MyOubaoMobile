//五星直选复式玩法实现类
(function(host, GameMethod, undefined){
	var defConfig = {
		name:'qiansan.zuxuan.zusan'

	},
	Games = host.Games,
	//游戏类
	SSC = host.Games.SSC.getInstance();


	//定义方法
	var pros = {
		init:function(cfg){
			var me = this;


		},
		//时时彩复式结构为5行10列
		//复位选球数据
		rebuildData: function(){
			var me = this;
			me.balls = [
						[-1,-1,-1,-1,-1,-1,-1,-1,-1,-1]
						];
		},
		buildUI: function(){
			var me = this;
			me.container.html(html_all.join(''));
		},
		//检测选球是否完整，是否能形成有效的投注
		//并设置 isBallsComplete
		checkBallIsComplete: function(){
			var me = this,
				ball = me.getBallData(),
				i = 0,
				len = ball[0].length,
				num = 0, oNum = 0;

			for(;i < len;i++){
				if(ball[0][i] > 0){
					oNum++;
				}
			}
			//二重号大于1 && 单号大于3
			if(oNum >= 2){
				return me.isBallsComplete = true;
			}
			return me.isBallsComplete = false;
		},
		//获取组合结果
		getLottery: function(){
			var me = this,
				ball = me.getBallData(),
				i = 0,
				len = ball[0].length,
				saveNum = [],
				checkNum = [],
				result = [];
				arr = [], nr = new Array();

			//校验当前的面板
			//获取选中数字
			if(me.checkBallIsComplete()){
				for(;i < len;i++){
					if(ball[0][i] > 0){
						arr.push(i);
					}
				};
				for(var c=0;c<arr.length;c++){
					checkNum =[];
					saveNum = arr.concat();
					checkNum.push([[arr[c],arr[c]].join('')]);
					saveNum.splice(c, 1)
					checkNum.push(saveNum);
					result = result.concat(me.combination(checkNum));
				};

				for (var k = 0; k < result.length; k++) {
					result[k] = result[k].join('').split('');
				};

				return result;
			}
			return [];
		},
		getLotteryOriginal: function(data){
				var arr = data,
					me = this,
					ball = me.getBallData(),
					i = 0,
					len = ball[0].length,
					saveNum = [],
					checkNum = [],
					result = [];

				for(var c=0;c<arr.length;c++){
					checkNum =[];
					saveNum = arr.concat();
					checkNum.push([[arr[c],arr[c]].join('')]);
					saveNum.splice(c, 1)
					checkNum.push(saveNum);
					result = result.concat(me.combination(checkNum));
				};
				for (var k = 0; k < result.length; k++) {
					result[k] = result[k].join('').split('');
				};

				return result;
		},
		//单组去重处理
		removeSame: function(data) {
			var i = 0, result, me = this,
				numLen = this.getBallData()[0].length;
				len = data.length;
			result = Math.floor(Math.random() * numLen);
			for(;i<data.length;i++){
				if(result == data[i]){
					return arguments.callee.call(me, data);
				}
			}
			return result;
		},
		//获取随机数
		randomNum: function(){
			var me = this,
				i = 0,
				current = [],
				currentNum,
				ranNum,
				lotterys = [],
				order = null,
				dataNum = me.getBallData(),
				len = me.getBallData()[0].length,
				name_en = Games.getCurrentGame().getCurrentGameMethod().getName(),
				methodid = Games.getCurrentGame().getCurrentGameMethod().getId(),
				name = me.defConfig.name;

			for(;i<2;i++){
				current[i] = me.removeSame(current);
			}
			current.sort(function(a, b){
				return a > b ? 1 : -1;
			});
			lotterys = me.getLotteryOriginal(current);
			order = {
				'mid': methodid,
				'type': name_en,
				'original':[current],
				'lotterys': lotterys,
				'moneyUnit': Games.getCurrentGameStatistics().getMoneyUnit(),
				// 'multiple': Games.getCurrentGameStatistics().getMultiple(),
				'multiple': 1,
				'onePrice': Games.getCurrentGame().getGameConfig().getInstance().getOnePriceById(methodid),
				'num': lotterys.length
			};
			order['amountText'] = host.util.formatMoney(order['num'] * order['moneyUnit'] * order['multiple'] * order['onePrice']);
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
							xtText = '<span class="curr">豹子</span>';
						}else{
							xtText = '<span class="curr">组三</span>';
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

	//html模板
	var html_head = [];
    //头部
    // html_head.push('............');
    //每行
  var html_row = [];
    html_row.push('<div class="ball-section">');
      html_row.push('<div class="ball-section-top">');
        html_row.push('<div class="ball-control">');
          html_row.push('<span data-param="action=batchSetBall&amp;row=<#=row#>&amp;bound=all" class="all">全</span>');
          html_row.push('<span data-param="action=batchSetBall&amp;row=<#=row#>&amp;bound=big" class="big">大</span>');
          html_row.push('<span data-param="action=batchSetBall&amp;row=<#=row#>&amp;bound=small" class="small">小</span>');
          html_row.push('<span data-param="action=batchSetBall&amp;row=<#=row#>&amp;bound=odd" class="odd">单</span>');
          html_row.push('<span data-param="action=batchSetBall&amp;row=<#=row#>&amp;bound=even" class="even">双</span>');
          html_row.push('<span data-param="action=batchSetBall&amp;row=<#=row#>&amp;bound=none" class="none">清</span>');
        html_row.push('</div>');
        html_row.push('<h2 class="decimal-name"><#=title#></h2>');
      html_row.push('</div>');
    html_row.push('<div class="ball-section-content">');
      $.each([0,1,2,3,4,5,6,7,8,9], function(i){
        html_row.push('<label class="ball-number" data-value="' +this+ '" data-param="action=ball&value='+ this +'&row=<#=row#>">' +this+ '</label>');
      });
    html_row.push('</div>');
    html_row.push('</div>');

  var html_bottom = [];
		//拼接所有
	var html_all = [],rowStr = html_row.join('');
		html_all.push(html_head.join(''));
		$.each(['组三'], function(i){
			html_all.push(rowStr.replace(/<#=title#>/g, this).replace(/<#=row#>/g, i));
		});
		html_all.push(html_bottom.join(''));




	//继承GameMethod
	var Main = host.Class(pros, GameMethod);
		Main.defConfig = defConfig;
	//将实例挂在游戏管理器实例上
	SSC.setLoadedHas(defConfig.name, new Main());

})(betgame, betgame.GameMethod);
