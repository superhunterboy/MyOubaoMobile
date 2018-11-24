//前二直选复式玩法实现类
(function(host, GameMethod, undefined){
	var defConfig = {
		name:'liangmianpan.zhixuan.guanyahezhi',
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
						[-1,-1,-1,-1]
						];
		},
		buildUI:function(){
			var me = this;
			me.container.html(html_all.join(''));
		},

                                    //生成单注随机数
		createRandomNum: function(){
			var me =this,
				current = [],
				arr = [],
				len = me.getBallData().length,
				rowLen = me.getBallData()[0].length;

			//随机数
			for(var k=0;k < len; k++){
				current[k] = [Math.ceil(Math.random() * (rowLen - 1))];
				current[k].sort(function(a, b){
					return a > b ? 1 : -1;
				});
			};
			return current;
		},
                                    formatViewBalls:function(original){
			var me = this,
				result = [],
				len = original.length,
				i = 0,
				tempArr = [],
				names = ['大', '小', '单', '双'];
			for (; i < len; i++) {
				tempArr = [];
				$.each(original[i], function(j){
					tempArr[j] = names[Number(original[i][j] )];
				});
				result = result.concat(tempArr.join(' '));
			}
			return result.join('|');
		},
                                    editSubmitData:function(data){
			var ball_num = {'0':'1','1':'0','2':'3','3':'2'},
				numArr = data['ball'].split(''),
				result = [];
			$.each(numArr, function(){
				ball_num['' + this] ? result.push(ball_num['' + this]) : result.push(this);
			});
			data['ball'] = result.join('');
		},
		miniTrend_createHeadHtml:function(){
			var me = this,
				html = [];
			html.push('<table width="100%" class="table bet-table-trend" id="J-minitrend-trendtable-'+ me.getId() +'">');
				html.push('<thead><tr>');
				html.push('<th><span class="number">奖期</span></th>');
				html.push('<th><span class="balls">开奖</th>');
				html.push('<th><span>大小</span></th>');
				html.push('<th><span>单双</span></th>');
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
		html_row.push('</div>');
		html_row.push('<h2 class="decimal-name"><#=title#></h2>');
		html_row.push('</div>');
		html_row.push('<div class="ball-section-content">');
		$.each(['大','小','单','双'], function(i){
                                        html_row.push('<label class="ball-number" data-value="' +this+ '" data-param="action=ball&value='+ i +'&row=<#=row#>">' +this+ '</label>');
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

