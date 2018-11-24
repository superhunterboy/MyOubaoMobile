

//前二直选复式玩法实现类
(function(host, GameMethod, undefined){
	var defConfig = {
		name:'erxing.zuxuan.qianerbaodan',
		//玩法提示
		tips:'前二组选包胆玩法提示',
		//选号实例
		exampleTip: '前二组选包胆范例'
	},
	Games = host.Games,
	SSC = Games.SSC.getInstance();


	//定义方法
	var pros = {
		init:function(cfg){
			var me = this;


			me.addEvent('beforeSelect', function(){
				if(Games.getCurrentGame().getCurrentGameMethod().getName() == me.getName()){
					me.reSet();
				}
			});

		},
		//时时彩复式结构为5行10列
		//复位选球数据
		rebuildData:function(){
			var me = this;
			me.balls = [
						[-1,-1,-1,-1,-1,-1,-1,-1,-1,-1]
						];
		},
		buildUI:function(){
			var me = this;
			me.container.html(html_all.join(''));
		},
		makePostParameter: function(original){
			var me = this,
				result = [],
				len = original.length,
				i = 0;
			for (; i < len; i++) {
				result = result.concat(original[i].join(','));
			}
			return result.join('');
		},
		//检测结果重复
		checkResult: function(data, array){
			//检查重复
			for (var i = array.length - 1; i >= 0; i--) {
				if(array[i].join('') == data){
					return false;
				}
			};
			return true;
		},
		//计算各种结果
		mathResult: function(sum, nBegin, nEnd){
			var me = this,
				arr = [],
				checkArray = [],
				x,y;

			for (x=nBegin;x<=nEnd ;x++ ){
				for (y=nBegin;y<=nEnd ;y++ ){
						if((x == sum && y != sum) || (y == sum && x != sum)){
						 	var postArray = [x,y].sort(function(a, b){
								return a - b;
							});
							if(me.checkResult(postArray.join(''), checkArray)){
								checkArray.push(postArray)
								arr.push([x,y]);
							}
						}
				}
			}
			return arr;
		},
		//获取组合结果
		getLottery: function(){
			var me = this,
				ball = me.getBallData()[0],
				i = 0,
				len = ball.length,
				arr = [];

			for(;i < len;i++){
				if(ball[i] > 0){
					arr.push(i);
				}
			}

			//校验当前的面板
			//获取选中数字
			if(me.checkBallIsComplete()){
				return me.mathResult(arr[0], 0, 9);
			}

			return [];
		},
		//获取随机数
		randomNum:function(){
			var me = this,
				i = 0,
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

			current[0] = Math.floor(Math.random() * len);
			lotterys = me.mathResult(current[0], 0, 9);
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
						if(j < 2){
							currCls = 'curr';
						}else{
							currCls = '';
						}
						html.push('<i class='+ currCls +'>' + this + '</i>');
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
    // html_head.push('............');
    //每行
  var html_row = [];
    html_row.push('<div class="ball-section">');
    html_row.push('<div class="ball-section-content">');
      $.each([0,1,2,3,4,5,6,7,8,9], function(i){
        html_row.push('<label class="ball-number" data-value="' +this+ '" data-param="action=ball&value='+ this +'&row=<#=row#>">' +this+ '</label>');
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
	SSC.setLoadedHas(defConfig.name, new Main());

})(betgame, betgame.GameMethod);

