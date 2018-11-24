

(function(host, GameMethod, undefined){
	var defConfig = {
		name:'quwei.quwei.housanquweierxing'

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
						[-1,-1],
						[-1,-1,-1,-1,-1,-1,-1,-1,-1,-1],
						[-1,-1,-1,-1,-1,-1,-1,-1,-1,-1]
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
				names = ['小','大'];
			for (; i < len; i++) {
				if(i < 1){
					tempArr = [];
					$.each(original[i], function(j){
						tempArr[j] = names[Number(original[i][j] )];
					});
					result = result.concat(tempArr.join(''));
				}else{
					result = result.concat(original[i].join(''));
				}

			}
			return result.join('|');
		},
		exeEvent_cancelCurrentButton: function(x, y, v) {
			var me = this,
				container = me.container;
			container.find('.ball-control').each( function() {
				 if( typeof x != 'undefined' ){
					container.find('.ball-control').each( function() {
						 if( $(this).attr('row') == x ){
						 	$(this).find('a').removeClass('current');
						 }
					});
				}else{
					container.find('.ball-control').find('a').removeClass('current');
				}
			});
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
        html_row.push('<label class="ball-number" data-value="' +this+ '" data-param="action=ball&value='+ i +'&row=<#=row#>">' +this+ '</label>');
      });
    html_row.push('</div>');
    html_row.push('</div>');

   var html_row1 = [];
    html_row1.push('<div class="ball-section">');
      html_row1.push('<div class="ball-section-top">');
        html_row1.push('<h2 class="decimal-name"><#=title#></h2>');
      html_row1.push('</div>');
    html_row1.push('<div class="ball-section-content">');
      $.each(['小(0-4)', '大(5-9)'], function(i){
        html_row1.push('<label class="ball-number ball-number-long" data-value="' +this+ '" data-param="action=ball&value='+ i +'&row=<#=row#>">' +this+ '</label>');
      });
    html_row1.push('</div>');
    html_row1.push('</div>');

  var html_bottom = [];
		//拼接所有
	var html_all = []
		rowStr = html_row.join(''),
		rowStr1 = html_row1.join('');
		html_all.push(html_head.join(''));
		$.each(['百位'], function(i){
			html_all.push(rowStr1.replace(/<#=title#>/g, this).replace(/<#=row#>/g, i));
		});
		$.each(['十位','个位'], function(i){
			html_all.push(rowStr.replace(/<#=title#>/g, this).replace(/<#=row#>/g, i + 1));
		});
		html_all.push(html_bottom.join(''));


	//继承GameMethod
	var Main = host.Class(pros, GameMethod);
		Main.defConfig = defConfig;
	//将实例挂在游戏管理器实例上
	SSC.setLoadedHas(defConfig.name, new Main());

})(betgame, betgame.GameMethod);

