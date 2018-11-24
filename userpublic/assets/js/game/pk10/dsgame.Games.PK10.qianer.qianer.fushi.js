//前二直选复式玩法实现类
(function(host, GameMethod, undefined){
	var defConfig = {
		name:'qianer.qianer.fushi',
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
						[-1,-1,-1,-1,-1,-1,-1,-1,-1,-1],
						[-1,-1,-1,-1,-1,-1,-1,-1,-1,-1]
						];
		},
		buildUI:function(){
			var me = this;
			me.container.html(html_all.join(''));
		},
//获取总注数/获取组合结果
		//isGetNum=true 只获取数量，返回为数字
		//isGetNum=false 获取组合结果，返回结果为单注数组
		getLottery: function(isGetNum) {
			var me = this,
				data = me.getBallData(),
				i = 0,
				len = data.length,
				row, isEmptySelect = true,
				_tempRow = [],
				j = 0,
				len2 = 0,
				result = [],
				//总注数
				total = 1,
				rowNum = 0;

			//检测球是否完整
			for (; i < len; i++) {
				result[i] = [];
				row = data[i];
				len2 = row.length;
				isEmptySelect = true;
				rowNum = 0;
				for (j = 0; j < len2; j++) {
					if (row[j] > 0) {
						isEmptySelect = false;
						//需要计算组合则推入结果
						if (!isGetNum) {
							result[i].push(j);
						}
						rowNum++;
					}
				}
				if (isEmptySelect) {
					//alert('第' + i + '行选球不完整');
					me.isBallsComplete = false;
					return [];
				}
				//计算注数
				total *= rowNum;
			}
			me.isBallsComplete = true;
			//返回注数
			if (isGetNum) {
				return total;
			}

			if (me.isBallsComplete) {
				result = me.filterErrorData(me.combination(result));
				//组合结果
				return result;
			} else {
				return [];
			}
		},
                                                    //生成单注随机数
		createRandomNum: function() {
			var me = this,
				current = [],
                                                                        tmpData = [],
				len = me.getBallData().length,
				rowLen = me.getBallData()[0].length;
			//随机数
			for (var k = 0; k < len; k++) {
				num = [Math.floor(Math.random() * rowLen)];
                                                                        while(true){
                                                                            if(tmpData.indexOf(num[0]) > -1){
                                                                                num = [Math.floor(Math.random() * rowLen)];
                                                                            }else{
                                                                                break;
                                                                            }
                                                                        }
                                                                        current[k] = num;
                                                                        tmpData[k] = num[0];
				current[k].sort(function(a, b) {
					return a > b ? 1 : -1;
				});
			};
			return current;
		},
                		filterErrorData: function(arr, len, num, saveArray) {
			var me = this,
				saveArray = saveArray || [],
				num = num || 0,
				len = len || arr.length;

			if (num == len) {
				return saveArray;
			} else {
				if (arr[num][0] != arr[num][1] && arr[num][0] != arr[num][2] && arr[num][1] != arr[num][2]) {
					saveArray.push(arr[num]);
				}
				num++;
				return me.filterErrorData(arr, len, num, saveArray);
			}
		},
                		//选球事件
		//球参数 action=ball&value=2&row=0  表示动作为'选球'，球值为2，行为第1行(万位)
		//函数名称： exeEvent_动作名称
		exeEvent_ball: function(param, target) {
			var me = this,
				el = $(target),
				currCls = me.defConfig.ballCurrentCls;
			//必要参数
			if (param['value'] != undefined && param['row'] != undefined) {
				if (el.hasClass(currCls)) {
					//取消选择
					me.setBallData(Number(param['row']), Number(param['value']-1), -1);
				} else {
					me.fireEvent('beforeSelect', param);
					//选择
					me.setBallData(Number(param['row']), Number(param['value']-1), 1);
				}
			} else {
				try {
					// console.log('GameMethod.exeEvent_ball: lack param');
				} catch (ex) {}
			}
			me.updateData();
		},
                                    formatViewBalls:function(original){
			var me = this,
				result = [],
				len = original.length,
				i = 0,
				tempArr = [],
				names = ['01', '02', '03','04','05','06','07','08','09','10'];
			for (; i < len; i++) {
				tempArr = [];
				$.each(original[i], function(j){
					tempArr[j] = names[Number(original[i][j] )];
				});
				result = result.concat(tempArr.join(' '));
			}
			return result.join('|');
		},
		makePostParameter: function(original) {
			var me = this,
				result = [],
				len,
				tempArr = [],
				i = 0;
			$.each(original, function(i){
				tempArr[i]  = [];
				$.each(original[i], function(j){
                                                                                          tempVal = original[i][j] + 1;
					tempArr[i][j] = tempVal < 10 ? '0' + tempVal : '' + tempVal;
				});
			});
			len = tempArr.length;
			for (i =0; i < len; i++) {
				result = result.concat(tempArr[i].join(' '));
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
	var html_head = [];
		//头部
		html_head.push('<div class="number-select-title balls-type-title clearfix"><div class="number-select-link"><a href="" class="pick-rule">选号规则</a><a href="" class="win-info">中奖说明</a></div><div class="function-select-title"></div></div>');
		html_head.push('<div class="number-select-content">');
		html_head.push('<ul class="ball-section">');
		//每行
	var html_row = [];
		html_row.push('<li>');
		html_row.push('<div class="ball-title"><strong><#=title#></strong><span></span></div>');
		html_row.push('<ul class="ball-content">');
			$.each([1,2,3,4,5,6,7,8,9,10], function(i){
				html_row.push('<li><a class="ball-number" data-param="action=ball&value='+ this +'&row=<#=row#>" href="javascript:void(0);">'+ this +'</a></li>');
			});
		html_row.push('</ul>');
		html_row.push('<div class="ball-control">');
		html_row.push('<a href="javascript:void(0);" class="circle"></a>');
		html_row.push('<a href="javascript:void(0);" data-param="action=batchSetBall&amp;row=<#=row#>&amp;bound=all" class="all">全</a>');
		html_row.push('<a href="javascript:void(0);" data-param="action=batchSetBall&amp;row=<#=row#>&amp;bound=big" class="big">大</a>');
		html_row.push('<a href="javascript:void(0);" data-param="action=batchSetBall&amp;row=<#=row#>&amp;bound=small" class="small">小</a>');
		html_row.push('<a href="javascript:void(0);" data-param="action=batchSetBall&amp;row=<#=row#>&amp;bound=even" class="even">奇</a>');
		html_row.push('<a href="javascript:void(0);" data-param="action=batchSetBall&amp;row=<#=row#>&amp;bound=odd" class="odd">偶</a>');
		html_row.push('<a href="javascript:void(0);" data-param="action=batchSetBall&amp;row=<#=row#>&amp;bound=none" class="none">清</a>');
		html_row.push('</div>');
		html_row.push('</li>');

	var html_bottom = [];
		html_bottom.push('</ul>');
		html_bottom.push('</div>');
		//拼接所有
	var html_all = [],rowStr = html_row.join('');
		html_all.push(html_head.join(''));
		$.each(['冠军','亚军'], function(i){
			html_all.push(rowStr.replace(/<#=title#>/g, this).replace(/<#=row#>/g, i));
		});
		html_all.push(html_bottom.join(''));



	//继承GameMethod
	var Main = host.Class(pros, GameMethod);
		Main.defConfig = defConfig;
	//将实例挂在游戏管理器实例上
	PK10.setLoadedHas(defConfig.name, new Main());

})(dsgame, dsgame.GameMethod);

