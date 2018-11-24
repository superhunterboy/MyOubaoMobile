//前三直选复式玩法实现类
(function(host, GameMethod, undefined) {
	var defConfig = {
			name: 'erma.zuxuan.dantuo',
			//玩法提示
			tips: '',
			//选号实例
			exampleTip: '',
			//限制选求重复次数
			randomBetsNum: 500
		},
		gameCaseName = 'L115',
		//游戏类
		gameCase = host.Games[gameCaseName].getInstance();


	//定义方法
	var pros = {
		init: function(cfg) {
			var me = this;
			//
			me.lastSelectBallIndex = -1;

			//默认加载执行30期遗漏号码
			////me.getHotCold(me.getGameMethodName(), 'currentFre', 'lost');
			//初始化冷热号事件
			//me.initHotColdEvent();
		},
		//复位选球数据
		rebuildData: function() {
			var me = this;
			me.balls = [
				[-1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1],
				[-1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1]
			];
		},
		buildUI: function() {
			var me = this;
			me.container.html(html_all.join(''));
		},
		//设置选球数据
		//x y value   x y 为选球数据二维数组的坐标 value 为-1 或1
		setBallData: function(x, y, value) {
			var me = this,
				data = me.getBallData(),
				xLen = 0;
			if(y == 0){
				return;
			}
			me.fireEvent('beforeSetBallData', x, y, value);




			$.each(data[0], function(){
				if(this > 0){
					xLen++;
				}
			});
			if(x == 0){
				if(value == 1){
					if(xLen > 0){
						me.setBallData(0, me.lastSelectBallIndex, -1);
					}
					me.setBallData(1, y, -1);
					me.lastSelectBallIndex = y;
				}
			}
			if(x == 1){
				me.setBallData(0, y, -1);
			}




			if (x >= 0 && x < data.length && y >= 0) {
				data[x][y] = value;
			}
			me.fireEvent('afterSetBallData', x, y, value);
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
					tempArr[i][j] = original[i][j] < 10 ? '0' + original[i][j] : '' + original[i][j];
				});
			});

			len = tempArr.length;
			for (i =0; i < len; i++) {
				result = result.concat(tempArr[i].join(' '));
			}
			return result.join('|');
		},
		formatViewBalls: function(original) {
			return this.makePostParameter(original);
		},
		//检测选球是否完整，是否能形成有效的投注
		//并设置 isBallsComplete
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
			if(num >= 1 && oNum >= 1){
				return me.isBallsComplete = true;
			}

			return me.isBallsComplete = false;
		},
		//获取组合结果
		getLottery: function(){
			var me = this,
				ball = me.getBallData(),
				i = 0,
				danMaLen = me.countBallsNumInLine(0),
				len = ball[1].length,
				result = [];
				arr = [],
				danMaArr = [],
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
				result = me.combine(arr, 2 - danMaLen);
				for(var i=0,current;i<ball[0].length;i++){
					if(ball[0][i] == 1){
						danMaArr.push(i);
					}
				};

				//加上单号各种组合
				for(var s=0;s<result.length;s++){

					nr.push(result[s].concat(danMaArr));
				}

				return nr;
			}
			return [];
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
			$.each([0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11], function(i){
				var value = (i < 10 ? '0' + this : this);
				if( i == 0 ){
					html_row.push('<label class="ball-number ball-number-hidden" data-value="' +value+ '" data-param="action=ball&value='+ this +'&row=<#=row#>">' +value+ '</label>');
				}else{
					html_row.push('<label class="ball-number" data-value="' +value+ '" data-param="action=ball&value='+ this +'&row=<#=row#>">' + value + '</label>');
				}
			});
		html_row.push('</div>');
		html_row.push('</div>');

	var html_bottom = [];
	//拼接所有
	var html_all = [],
		rowStr = html_row.join('');
	html_all.push(html_head.join(''));
	$.each(['胆码', '拖码'], function(i) {
		if (i == 0) {
			html_all.push(rowStr.replace(/<#=title#>/g, this).replace(/<#=row#>/g, i).replace(/<#=styleStr#>/g, 'style="display:none;"').replace(/<#=rowStyle#>/g, 'background-image:none;'));
		} else {
			html_all.push(rowStr.replace(/<#=title#>/g, this).replace(/<#=row#>/g, i).replace(/<#=styleStr#>/g, ''));
		}

	});
	html_all.push(html_bottom.join(''));



	//继承GameMethod
	var Main = host.Class(pros, GameMethod);
	Main.defConfig = defConfig;
	//将实例挂在游戏管理器实例上
	gameCase.setLoadedHas(defConfig.name, new Main());

})(betgame, betgame.GameMethod);
