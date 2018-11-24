

//前三直选复式玩法实现类
(function(host, GameMethod, undefined){
	var defConfig = {
		name:'caipaiwei.zhixuanpk.qiansanpk',
		//玩法提示
		tips:'前三直选复式玩法提示',
		//选号实例
		exampleTip: '前三直选复式范例',
		//限制选求重复次数
		randomBetsNum:500
	};
	//游戏类
	var PK10 = host.Games.PK10.getInstance();


	//定义方法
	var pros = {
		init:function(cfg){
			var me = this;

			//默认加载执行30期遗漏号码
			////me.getHotCold(me.getGameMethodName(), 'currentFre', 'lost');
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
						[-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1]
						];
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
		buildUI:function(){
			var me = this;
			me.container.html(html_all.join(''));
		},
		setBallData: function(x, y, value) {
			var me = this,
				data = me.getBallData(),
				i = 0,
				len = data.length;
			//console.log(x, y, value);
			if(y == 0){
				return;
			}
			me.fireEvent('beforeSetBallData', x, y, value);
			if (x >= 0 && x < data.length && y >= 0) {
				data[x][y] = value;
			}
			me.fireEvent('afterSetBallData', x, y, value);
		},
		//过滤结果集合中的双重号和豹子号
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
		$.each(['冠军','亚军','季军'], function(i){
			html_all.push(rowStr.replace(/<#=title#>/g, this).replace(/<#=row#>/g, i));
		});
		html_all.push(html_bottom.join(''));



	//继承GameMethod
	var Main = host.Class(pros, GameMethod);
		Main.defConfig = defConfig;
	//将实例挂在游戏管理器实例上
	PK10.setLoadedHas(defConfig.name, new Main());

})(betgame, betgame.GameMethod);

