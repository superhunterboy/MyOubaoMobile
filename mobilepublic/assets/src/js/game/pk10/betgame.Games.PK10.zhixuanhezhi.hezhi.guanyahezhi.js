//前二直选复式玩法实现类
(function(host, GameMethod, undefined){
	var defConfig = {
		name:'zhixuanhezhi.hezhi.guanyahezhi',
		//玩法提示
		tips:'前二直选复式玩法提示',
		//选号实例
		exampleTip: '前二直选复式范例'
	},
	Games = host.Games,
	PK10 = Games.PK10.getInstance();


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
						[-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1]
						];
		},
		buildUI:function(){
			var me = this;
			me.container.html(html_all.join(''));
		},
		//获取总注数/获取组合结果
		//isGetNum=true 只获取数量，返回为数字
		//isGetNum=false 获取组合结果，返回结果为单注数组
		getLottery:function(isGetNum){
			var me = this,data = me.getBallData(),
				i = 0,len = data.length,row,
				_tempRow = [],
				j = 0,len2 = 0,
				result = [],
				result2 = [],
			//总注数
				total = 1,
				rowNum = 0;

			//检测球是否完整
			for(;i < len;i++){
				result[i] = [];
				row = data[i];
				len2 = row.length;
				isEmptySelect = true;
				rowNum = 0;
				for(j = 0;j < len2;j++){
					if(row[j] > 0){
						me.isBallsComplete = true;
						//需要计算组合则推入结果
						if(!isGetNum){
							result[i].push(j);
						}
						rowNum++;
					}
				}
				//计算注数
				total *= rowNum;
			}

			//返回注数
			if(isGetNum){
				return total;
			}

			if(me.isBallsComplete){
				//组合结果
				for(i = 0,len = result.length;i < len;i++){
					for(j = 0,len2 = result[i].length;j < len2;j++){
						result2.push([result[i][j]]);
					}
				}
				return result2;
			}else{
				return [];
			}
		},
        //生成单注随机数
		//生成单注随机数
		createRandomNum: function(){
			var me =this,
				current = [],
				arr = [],
				len = me.getBallData().length,
				rowLen = me.getBallData()[0].length;

			//随机数
			for(var k=0;k < len; k++){
				current[k] = [Math.ceil(Math.random() * (rowLen - 3))+2];
				current[k].sort(function(a, b){
					return a > b ? 1 : -1;
				});
			};
			return current;
		},
		makePostParameter: function(original){
			return this.formatViewBalls(original);
		},
		formatViewBalls:function(original){
			var me = this,
				result = [],
				len = original.length,
				i = 0,
				len2,
				j = 0;
			for (i = 0; i < len; i++) {
				len2 = original[i].length;
				for(j = 0; j < len2; j++){
					result.push(original[i][j]);
				}
			}
			return result.join('|');
		},
		miniTrend_createHeadHtml:function(){
			var me = this,
				html = [];
			html.push('<table width="100%" class="table bet-table-trend" id="J-minitrend-trendtable-'+ me.getId() +'">');
				html.push('<thead><tr>');
				html.push('<th><span class="number">奖期</span></th>');
				html.push('<th><span class="balls">开奖</th>');
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
				html = [];
			$.each(data, function(i){
				item = this;
				trcls = '';
				trcls = i == 0 ? 'first' : trcls;
				trcls = i == dataLen - 1 ? 'last' : trcls;
				var number = (item['wn_number'].indexOf(" ")==-1 ) ? item['wn_number'].split(""): item['wn_number'].split(" ");
				html.push('<tr class="'+ trcls +'">');
					html.push('<td class="abel"><span class="number">'+ item['issue'] +' 期</span></td>');
					html.push('<td class="abel"><span class="balls">');

					$.each(number, function(j){
						html.push('<i>' + this + '</i>');
					});

					html.push('</span></td>');
				html.push('</tr>');
			});
			return html.join('');
		}


	};




	//html模板
	//html模板
	var html_head = [];
		//头部
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

			$.each([0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19], function(i){
				if( i == 0 || i==1 || i==2){
					html_row.push('<label class="ball-number ball-number-hidden" data-value="' +this+ '" data-param="action=ball&value='+ this +'&row=<#=row#>">' +this+ '</label>');
				}else{
					html_row.push('<label class="ball-number" data-value="' +this+ '" data-param="action=ball&value='+ this +'&row=<#=row#>">' +this+ '</label>');
				}
			});
		html_row.push('</div>');
		html_row.push('</div>');
	var html_bottom = [];
		//拼接所有
	var html_all = [],rowStr = html_row.join('');
		html_all.push(html_head.join(''));
		$.each(['冠压和'], function(i){
			html_all.push(rowStr.replace(/<#=title#>/g, this).replace(/<#=row#>/g, i));
		});
		html_all.push(html_bottom.join(''));



	//继承GameMethod
	var Main = host.Class(pros, GameMethod);
		Main.defConfig = defConfig;
	//将实例挂在游戏管理器实例上
	PK10.setLoadedHas(defConfig.name, new Main());

})(betgame, betgame.GameMethod);

