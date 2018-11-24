

(function(host, GameMethod, undefined){
	var defConfig = {
		name:'daxiaodanshuang.daxiaodanshuang.qianerdaxiaodanshuang'

	},
	Games = host.Games,
	SSC = Games.SSC.getInstance();


	//定义方法
	var pros = {
		init:function(cfg){
			var me = this;

		},
		//时时彩复式结构为5行10列
		//复位选球数据
		rebuildData:function(){
			var me = this;
			me.balls = [
						[-1,-1,-1,-1],
						[-1,-1,-1,-1]
						];
		},
		buildUI:function(){
			var me = this;
			me.container.html(html_all.join(''));
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
				result = result.concat(tempArr.join(''));
			}
			return result.join('|');
		},
		//data 该玩法的单注信息
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
				html = [],
				xtText = [],
				xtText2 = [];

			$.each(data, function(i){
				item = this;
				xtText = [];
				xtText2 = [];
				trcls = '';
				trcls = i == 0 ? 'first' : trcls;
				trcls = i == dataLen - 1 ? 'last' : trcls;
				var number = item['wn_number'].split("");
				html.push('<tr class="'+ trcls +'">');
					html.push('<td><span class="number">'+ item['issue'].substr(2) +' 期</span></td>');
					html.push('<td><span class="balls">');
					$.each(number, function(j){
						if(j < 2){
							currCls = 'curr';
						}else{
							currCls = '';
						}
						html.push('<i class='+ currCls +'>' + this + '</i>');
					});
					html.push('</span></td>');

					if(parseInt(number[0]) > 4){
						xtText.push('大');
					}else{
						xtText.push('小');
					}
					if(parseInt(number[1])> 4){
						xtText.push('大');
					}else{
						xtText.push('小');
					}
					if(parseInt(number[0])%2 == 1){
						xtText2.push('单');
					}else{
						xtText2.push('双');
					}
					if(parseInt(number[1])%2 == 1){
						xtText2.push('单');
					}else{
						xtText2.push('双');
					}

					html.push('<td>'+ xtText.join('') +'</td>');
					html.push('<td>'+ xtText2.join('') +'</td>');
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
        html_row.push('<h2 class="decimal-name"><#=title#></h2>');
      html_row.push('</div>');
    html_row.push('<div class="ball-section-content">');
      $.each(['大', '小', '单', '双'], function(i){
        html_row.push('<label class="ball-number" data-value="' +this+ '" data-param="action=ball&value='+ i +'&row=<#=row#>">' +this+ '</label>');
      });
    html_row.push('</div>');
    html_row.push('</div>');

  var html_bottom = [];
		//拼接所有
	var html_all = [],rowStr = html_row.join('');
		html_all.push(html_head.join(''));
		$.each(['万位','千位'], function(i){
			html_all.push(rowStr.replace(/<#=title#>/g, this).replace(/<#=row#>/g, i));
		});
		html_all.push(html_bottom.join(''));


	//继承GameMethod
	var Main = host.Class(pros, GameMethod);
		Main.defConfig = defConfig;
	//将实例挂在游戏管理器实例上
	SSC.setLoadedHas(defConfig.name, new Main());

})(betgame, betgame.GameMethod);

