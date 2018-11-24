//五星直选复式玩法实现类
(function(host, GameMethod, undefined){
	var defConfig = {
		name:'sixing.zuxuan.zuxuan24'

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
				ball = me.getBallData()[0],
				i = 0,
				len = ball.length,
				num = 0;
			for(;i < len;i++){
				if(ball[i] > 0){
					num++;
				}
			}
			if(num >= 4){
				return me.isBallsComplete = true;
			}
			return me.isBallsComplete = false;
		},
		//获取组合结果
		getLottery: function(){
			var me = this,
				ball = me.getBallData()[0],
				i = 0,
				len = ball.length,
				arr = [];

			for(;i < len;i++){
				if(ball[i] > 0){
					arr.push(i);
				}
			}

			//校验当前的面板
			//获取选中数字
			if(me.checkBallIsComplete()){
				return me.combine(arr, 4);
			}

			return [];
		},
		//限制随机投注重复
		checkRandomBets: function(hash,times){
			var me = this,
				allowTag = typeof hash == 'undefined' ? true : false,
				hash = hash || {},
				current = [],
				times = times || 0,
				num = '',
				allArr = [],
				current2 = [],
				len = me.getBallData().length,
				rowLen = me.getBallData()[0].length,
				order = Games.getCurrentGameOrder().getTotal()['orders'];

			//随机数
			for(var k=0;k < 4;k++){
				num = me.removeSame(allArr);
				current = current.concat(num);
				allArr.push(num);
			}
			current.sort(function(a, b){
				return a-b;
			});
			current = [current[0],current[1],current[2],current[3]]

			//如果大于限制数量
			//则直接输出
			if(Number(times) > Number(me.getRandomBetsNum())){
				return current;
			}
			//建立索引
			if(allowTag){
				for (var i = 0; i < order.length; i++) {
					if(order[i]['type'] == me.defConfig.name){
						var name = order[i]['original'].join('');
						hash[name] = name;
					}
				};
			}
			//对比结果
			if(hash[current.join(',')]){
				times++;
				return arguments.callee.call(me, hash, times);
			}

			return current;
		},
		//获取随机数
		randomNum: function(){
			var me = this,
				i = 0,
				current = [],
				current2 = [],
				lotterys = [],
				len = me.getBallData()[0].length,
				name_en = Games.getCurrentGame().getCurrentGameMethod().getName(),
				methodid = Games.getCurrentGame().getCurrentGameMethod().getId(),
				allArr = [],
				num;
			current = me.checkRandomBets();
			lotterys.push([[current[0]], [current[1]], [current[2]], [current[3]]]);
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
			html.push('<table width="100%" class=" table bet-table-trend" id="J-minitrend-trendtable-'+ me.getId() +'">');
				html.push('<thead><tr>');
				html.push('<th><span class="number">奖期</span></th>');
				html.push('<th><span class="balls">开奖</th>');
				html.push('<th><span>24</span></th>');
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
				has = {},
				repeat = 0,
				numlen = 0,
				moretimes = 0,
				p,
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
					repeat = 0;
					numlen = 0;
					moretimes = 0;
					has = {};
					$.each(number, function(j){
						if(j > 0){
							currCls = 'curr';
						}else{
							currCls = '';
						}
						html.push('<i class='+ currCls +'>' + this + '</i>');
						if(j > 0){
							if(has['' + this]){
								has['' + this] += 1;
							}else{
								has['' + this] = 1;
							}
						}
					});
					html.push('</span></td>');

					for(p in has){
						numlen += 1;
						if(has[p] == 1){
							moretimes += 1;
						}
					}
					if(moretimes == 4 && numlen == 4){
						xtText = '<span class="curr">24</span>';
					}else{
						xtText = '-';
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
        html_row.push('<h2 class="decimal-name decimal-name-empty"><#=title#></h2>');
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
		$.each([''], function(i){
			html_all.push(rowStr.replace(/<#=title#>/g, this).replace(/<#=row#>/g, i));
		});
		html_all.push(html_bottom.join(''));




	//继承GameMethod
	var Main = host.Class(pros, GameMethod);
		Main.defConfig = defConfig;
	//将实例挂在游戏管理器实例上
	SSC.setLoadedHas(defConfig.name, new Main());

})(betgame, betgame.GameMethod);

