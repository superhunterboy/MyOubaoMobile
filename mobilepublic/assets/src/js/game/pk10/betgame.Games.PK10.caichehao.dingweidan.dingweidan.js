//一星定位胆万位玩法实现类
(function(host, GameMethod, undefined){
	var defConfig = {
		name:'caichehao.dingweidan.dingweidan',
		//玩法提示
		tips:'一星定位胆复式玩法提示',
		//选号实例
		exampleTip: '一星定位胆玩复式范例'
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
						[-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1],
						[-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1],
						[-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1],
						[-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1],
						[-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1],
						[-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1],
						[-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1],
						[-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1],
						[-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1],
						[-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1]
						];
		},
		buildUI:function(){
			var me = this;
			me.container.html(html_all.join(''));
		},
                                setBallData: function(x, y, value) {
			var me = this,
				data = me.getBallData();
			if(y == 0){
				return;
			}
			me.fireEvent('beforeSetBallData', x, y, value);
			if (x >= 0 && x < data.length && y >= 0) {
				data[x][y] = value;
			}
			me.fireEvent('afterSetBallData', x, y, value);
		},
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
		},

		makePostParameter:function(data, order){
			var me = this,
				result = [],
				data = order['original'],
				i = 0;
			for (; i < data.length; i++) {
				result = result.concat(data[i].join('-'));
			}
			return result.join('|');
		},
                		editSubmitData:function(data){
			var rows = data['ball'].split('|'),
				i = 0,
				len = rows.length,
				j = 0,
				len2,
				cells;
			for(i = 0; i < len; i++){
				cells = rows[i].split('-');
				len2 = cells.length;
				for(j = 0; j < len2; j++){
					if(cells[j] != ''){
						cells[j] = Number(cells[j]) - 1;
					}
				}
				rows[i] = cells.join('');
			}
			data['ball'] = rows.join('|');
		},
		//生成单注随机数
		createRandomNum: function() {
			var me = this,
				current = [],
				len = me.getBallData().length,
				rowLen = me.getBallData()[0].length;
			//随机数
			for (var k = 0; k < len; k++) {
				current[k] = [Math.ceil(Math.random() * (rowLen - 1))];
				current[k].sort(function(a, b) {
					return a > b ? 1 : -1;
				});
			};
			return current;
		},
		//生成一个当前玩法的随机投注号码
		//该处实现复式，子类中实现其他个性化玩法
		//返回值： 按照当前玩法生成一注标准的随机投注单(order)
		randomNum:function(){
			var me = this,
				i = 0,
				current = [],
				order = null,
				len = me.getBallData().length,
				rowLen = me.getBallData()[0].length,
				name_en = Games.getCurrentGame().getCurrentGameMethod().getName(),
				methodid = Games.getCurrentGame().getCurrentGameMethod().getId(),
				lotterys = [],
				original = [],

				numRow = 0,
				numCell = 0;

			numRow = Math.floor(Math.random() * len);

			for(;i < len;i++){
				if(i == numRow){
					numCell = Math.floor(Math.random() * rowLen);
					current.push([numCell]);
				}else{
					current.push([]);
				}
			}

			original = current;
			lotterys = [[numCell]];

			order = {
				'mid': methodid,
				'type': name_en,
				'original':original,
				'lotterys':lotterys,
				'moneyUnit': Games.getCurrentGameStatistics().getMoneyUnit(),
				'multiple': 1,
				'onePrice': Games.getCurrentGame().getGameConfig().getInstance().getOnePriceById(methodid),
				'num': lotterys.length
			};
			var amount = order['num'] * order['moneyUnit'] * order['multiple'] * order['onePrice'];
			order['amountText'] = host.util.formatMoney(amount);

			return order;
		}


	};



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

		$.each([0,1,2,3,4,5,6,7,8,9,10], function(i){
			if( i == 0 ){
				html_row.push('<label class="ball-number ball-number-hidden" data-value="' +this+ '" data-param="action=ball&value='+ i +'&row=<#=row#>">' +this+ '</label>');
			}else{
				html_row.push('<label class="ball-number" data-value="' +this+ '" data-param="action=ball&value='+ i +'&row=<#=row#>">' +this+ '</label>');
			}
		});
		html_row.push('</div>');
		html_row.push('</div>');
	var html_bottom = [];
		//拼接所有
	var html_all = [],rowStr = html_row.join('');
		html_all.push(html_head.join(''));
		$.each(['冠军','亚军','季军','第四名','第五名','第六名','第七名','第八名','第九名','第十名'], function(i){
			html_all.push(rowStr.replace(/<#=title#>/g, this).replace(/<#=row#>/g, i));
		});
		html_all.push(html_bottom.join(''));



	//继承GameMethod
	var Main = host.Class(pros, GameMethod);
		Main.defConfig = defConfig;
	//将实例挂在游戏管理器实例上
	PK10.setLoadedHas(defConfig.name, new Main());

})(betgame, betgame.GameMethod);
