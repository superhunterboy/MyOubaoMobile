﻿

(function(host, GameMethod, undefined){
	var defConfig = {
		name:'sbth.sbth.fs',
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

			for(;i < len;i++){
				result.push(original[i].join('|'));
			}
			return result.join('');
		},
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
			//console.log(num);
			if(num >= 3){
				return me.isBallsComplete = true;
			}
			return me.isBallsComplete = false;
		},
		formatViewBalls:function(original){
			var me = this,
				result = [],
				len = original[0].length,
				has = {'1':'1','2':'2','3':'3','4':'4','5':'5','6':'6'},
				i = 0;

			for (; i < len; i++) {
				result.push(has['' + original[0][i]]);
			}

			result = result.join('');
			return result;
		},
		//获取总注数/获取组合结果
		//isGetNum=true 只获取数量，返回为数字
		//isGetNum=false 获取组合结果，返回结果为单注数组
		getLottery:function(isGetNum){
			var me = this,
				data = me.getBallData()[0],
				arr = [];
			if(me.checkBallIsComplete()){
				$.each(data, function(i){
					if(this > 0){
						arr.push(i+ 1);
					}
				});
				arr = me.combine(arr, 3);
			}
			return arr;
		},
		//获取随机数
		randomNum:function(){
			var me = this,
				i = 0,
				arr = [],
				current = [],
				currentNum,
				ranNum,
				lotterys = [],
				order = null,
				dataNum = me.getBallData(),
				len = me.getBallData()[0].length,
				name_en = Games.getCurrentGame().getCurrentGameMethod().getName(),
				methodid = Games.getCurrentGame().getCurrentGameMethod().getId(),
				name = me.defConfig.name;

			// 建立索引数组
			for (var i = len - 1; i >= 0; i--) {
				if(i > 0){
					arr.push(i);
				}
			};
			// 随机数
			for(var k=0;k < 3; k++){
				var ranDomNum = Math.floor(Math.random() * arr.length);
				current.push(arr[ranDomNum]);
				arr.splice(ranDomNum, 1);
			};
			current.sort(function(a, b){
				return a-b;
			});
			lotterys.push([current[0], current[1],current[2]]);
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
      $.each([0, 1, 2, 3, 4, 5, 6], function(i){
        if( i == 0 ){
          html_row.push('<label class="ball-number ball-number-hidden" data-value="' +this+ '" data-param="action=ball&value='+ this +'&row=<#=row#>">' +this+ '</label>');
        }else{
          html_row.push('<label class="ball-number" data-value="' +this+ '" data-param="action=ball&value='+ this +'&row=<#=row#>">' + this + '</label>');
        }
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
	K3.setLoadedHas(defConfig.name, new Main());

})(betgame, betgame.GameMethod);

