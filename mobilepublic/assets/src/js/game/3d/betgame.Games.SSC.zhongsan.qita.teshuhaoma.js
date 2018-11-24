//前三其他特殊号码
(function(host, GameMethod, undefined) {
	var defConfig = {
			name: 'zhongsan.qita.teshuhaoma'

		},
		Games = host.Games,
		SSC = Games.SSC.getInstance();


	//定义方法
	var pros = {
		init: function(cfg) {
			var me = this;

		},
		//时时彩复式结构为5行10列
		//复位选球数据
		rebuildData: function() {
			var me = this;
			me.balls = [
				[-1, -1, -1, -1, -1]
			];
		},
		buildUI: function() {
			var me = this;
			me.container.html(html_all.join(''));
		},
		formatViewBalls:function(original){
			var me = this,
				result = [],
				len = original.length,
				i = 0,
				tempArr = [],
				names = ['豹子', '顺子', '对子','半顺','杂六'];
			for (; i < len; i++) {
				tempArr = [];
				$.each(original[i], function(j){
					tempArr[j] = names[Number(original[i][j] )];
				});
				result = result.concat(tempArr.join('|'));
			}
			return result.join('');
		},
		//检测选球是否完整，是否能形成有效的投注
		//并设置 isBallsComplete
		checkBallIsComplete: function() {
			var me = this,
				ball = me.getBallData()[0],
				i = 0,
				len = ball.length,
				num = 0;
			for (; i < len; i++) {
				if (ball[i] > 0) {
					num++;
				}
			}
			//console.log(num);
			if (num >= 1) {
				return me.isBallsComplete = true;
			}
			return me.isBallsComplete = false;
		},
		//获取组合结果
		getLottery: function() {
			var me = this,
				ball = me.getBallData()[0],
				i = 0,
				len = ball.length,
				arr = [],
				resultNum = [];

			for (; i < len; i++) {
				if (ball[i] > 0) {
					arr.push(i);
				}
			}
			//校验当前的面板
			//获取选中数字
			if (me.checkBallIsComplete()) {
				return arr;
			}
			return [];
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
						if(j > 0 && j< 4){
							currCls = 'curr';
						}else{
							currCls = '';
						}
						html.push('<i class='+ currCls +'>' + this + '</i>');
					});
					html.push('</span></td>');
					//判断顺子，顺子不区分位置
					shunArr = [];
					shunArr.push(parseInt(number[1]));
					shunArr.push(parseInt(number[2]));
					shunArr.push(parseInt(number[3]));
					shunArr.sort();

					var xtText = '杂六';
					if( shunArr[0] == shunArr[1] && shunArr[0] == shunArr[2] ){
						xtText = '豹子';
					}else if(
						(shunArr[0] == 0 && shunArr[1] == 1 && shunArr[2] == 9) ||
						( (shunArr[0] - shunArr[1]) == -1 &&  (shunArr[1] - shunArr[2]) == -1 )
					){
						xtText = '顺子';
					}else if( shunArr[0] == shunArr[1] || shunArr[1] == shunArr[2] ){
						xtText = '对子';
					}else if(
						(shunArr[0] == 0 && shunArr[2] == 9) ||
						(shunArr[0] - shunArr[1]) == -1 ||
						(shunArr[1] - shunArr[2]) == -1
					){
						xtText = '半顺';
					}
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
    html_row.push('<div class="ball-section-content">');
      $.each(['豹子', '顺子', '对子','半顺','杂六'], function(i){
        html_row.push('<label class="ball-number ball-number-long" data-value="' +this+ '" data-param="action=ball&value='+ i +'&row=<#=row#>">' +this+ '</label>');
      });
    html_row.push('</div>');
    html_row.push('</div>');

  var html_bottom = [];
	//拼接所有
	var html_all = [],
		rowStr = html_row.join('');
	html_all.push(html_head.join(''));
	$.each([''], function(i) {
		html_all.push(rowStr.replace(/<#=title#>/g, this).replace(/<#=row#>/g, i));
	});
	html_all.push(html_bottom.join(''));



	//继承GameMethod
	var Main = host.Class(pros, GameMethod);
	Main.defConfig = defConfig;
	//将实例挂在游戏管理器实例上
	SSC.setLoadedHas(defConfig.name, new Main());

})(betgame, betgame.GameMethod);
