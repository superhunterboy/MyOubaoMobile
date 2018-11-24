

(function(host, GameMethod, undefined){
	var defConfig = {
		name:'ethdx.ethdx.fs',
		//玩法提示
		tips:'',
		//选号实例
		exampleTip: ''
	},
	Games = host.Games,
	K3 = Games.K3.getInstance();


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
						[-1,-1,-1,-1,-1,-1,-1],
						[-1,-1,-1,-1,-1,-1,-1]
						];
		},
		buildUI:function(){
			var me = this;
			me.container.html(html_all.join(''));
		},
		makePostParameter: function(original){
			var me = this,
				i = 0,
				len = original.length,
				result = [];
			$.each(original, function(i){
				result.push([]);
				$.each(this, function(j){
					// result[i][j] = this + 1;
					result[i][j] = this;
				});
				result[i] = result[i].join('');
			});
			return result.join('|');
		},
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
				if(ball[1][i] > 0){
					num++;
				}
			}
			//二重号大于0 && 单号大于0
			if(num > 0 && oNum > 0){
				return me.isBallsComplete = true;
			}
			return me.isBallsComplete = false;
		},
		formatViewBalls:function(original){
			var me = this;
			return me.makePostParameter(original);
		},
		//获取总注数/获取组合结果
		//isGetNum=true 只获取数量，返回为数字
		//isGetNum=false 获取组合结果，返回结果为单注数组
		getLottery: function(){
			var me = this,
				ball = me.getBallData(),
				i = 0,
				len = ball[1].length,
				result = [],
				arr = [],
				nr = new Array();

			//校验当前的面板
			//获取选中数字
			if(me.checkBallIsComplete()){
				for(;i < len;i++){
					if(ball[1][i] > 0){
						arr.push(i);
					}
				}
				//存储单号组合
				result = me.combine(arr, 1);
				//二重号组合
				for(var i=0,current;i<ball[0].length;i++){
					if(ball[0][i] == 1){
						//加上单号各种组合
						for(var s=0;s<result.length;s++){
							if(me.arrIndexOf(i, result[s]) == -1){
								nr.push(result[s].concat([i,i,i,i]));
							}
						}
					}
				}
				return nr;
			}
			return [];
		},
		//获取随机数
		randomNum:function(){
			var me = this,
				i = 0,
				allArr = [],
				current = [],
				current2 = [],
				currentNum,
				ranNum,
				lotterys = [],
				order = null,
				dataNum = me.getBallData(),
				len = me.getBallData()[0].length,
				name_en = Games.getCurrentGame().getCurrentGameMethod().getName(),
				methodid = Games.getCurrentGame().getCurrentGameMethod().getId(),
				name = me.defConfig.name;

			for(var k=0;k < 2;k++){
				if(k < 1){
					num = me.removeSame(allArr);
					current = current.concat(num);
					allArr.push(num);
				}else{
					num = me.removeSame(allArr);
					current2 = current2.concat(num);
					allArr.push(num);
				}
			}
			current2.sort(function(a, b){
				return a - b;
			});

			current = [current, current2];
			lotterys = current;
			order = {
				'mid': methodid,
				'type': name_en,
				'original':current,
				'lotterys': lotterys,
				'moneyUnit': Games.getCurrentGameStatistics().getMoneyUnit(),
				// 'multiple': Games.getCurrentGameStatistics().getMultiple(),
				'multiple': 1,
				'onePrice': Games.getCurrentGame().getGameConfig().getInstance().getOnePriceById(methodid),
				'num': lotterys.length
			};
			order['amountText'] = host.util.formatMoney(order['num'] * order['moneyUnit'] * order['multiple'] * order['onePrice']);
			return order;
		}


	};

	//html模板
  var html_head = [];
    //头部
    // html_head.push('............');
    //每行
  var html_row = [], html_row1 = [];
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
      $.each([0,11,22,33,44,55,66], function(i){
      	if( i == 0 ){
          html_row.push('<label class="ball-number ball-number-hidden" data-value="' +this+ '" data-param="action=ball&value='+ i +'&row=<#=row#>">' +this+ '</label>');
        }else{
          html_row.push('<label class="ball-number" data-value="' +this+ '" data-param="action=ball&value='+ i +'&row=<#=row#>">' + this + '</label>');
        }
      });
    html_row.push('</div>');
    html_row.push('</div>');

    html_row1.push('<div class="ball-section">');
    	html_row1.push('<div class="ball-section-top">');
        html_row1.push('<div class="ball-control">');
          html_row1.push('<span data-param="action=batchSetBall&amp;row=<#=row#>&amp;bound=all" class="all">全</span>');
          html_row1.push('<span data-param="action=batchSetBall&amp;row=<#=row#>&amp;bound=big" class="big">大</span>');
          html_row1.push('<span data-param="action=batchSetBall&amp;row=<#=row#>&amp;bound=small" class="small">小</span>');
          html_row1.push('<span data-param="action=batchSetBall&amp;row=<#=row#>&amp;bound=odd" class="odd">单</span>');
          html_row1.push('<span data-param="action=batchSetBall&amp;row=<#=row#>&amp;bound=even" class="even">双</span>');
          html_row1.push('<span data-param="action=batchSetBall&amp;row=<#=row#>&amp;bound=none" class="none">清</span>');
        html_row1.push('</div>');
        html_row1.push('<h2 class="decimal-name"><#=title#></h2>');
      html_row1.push('</div>');
    html_row1.push('<div class="ball-section-content">');
      $.each([0,1,2,3,4,5,6], function(i){
        if( i == 0 ){
          html_row1.push('<label class="ball-number ball-number-hidden" data-value="' +this+ '" data-param="action=ball&value='+ i +'&row=<#=row#>">' +this+ '</label>');
        }else{
          html_row1.push('<label class="ball-number" data-value="' +this+ '" data-param="action=ball&value='+ i +'&row=<#=row#>">' + this + '</label>');
        }
      });
    html_row1.push('</div>');
    html_row1.push('</div>');

  var html_bottom = [];
		//拼接所有
	var html_all = [],
		rowStr = html_row.join(''),
		rowStr1 = html_row1.join('');
		html_all.push(html_head.join(''));
		$.each(['同号', '不同号'], function(i){
			if(i == 0){
				html_all.push(rowStr.replace(/<#=title#>/g, this).replace(/<#=row#>/g, i));
			}else{
				html_all.push(rowStr1.replace(/<#=title#>/g, this).replace(/<#=row#>/g, i));
			}
		});
		html_all.push(html_bottom.join(''));

	//继承GameMethod
	var Main = host.Class(pros, GameMethod);
		Main.defConfig = defConfig;
	//将实例挂在游戏管理器实例上
	K3.setLoadedHas(defConfig.name, new Main());

})(betgame, betgame.GameMethod);

