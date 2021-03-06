﻿//游戏订单模块
(function(host, name, Event, undefined) {
	var defConfig = {},
		//缓存游戏实例
		instance,
		//获取游戏类
		Games = host.Games;

	var pros = {
		//初始化
		init: function(cfg) {
			var me = this,
				cfg = me.defConfig;

			//提交数据加锁
			//防止多次重复提交
			me.postLock = null;
			//缓存方法
			Games.setCurrentGameSubmit(me);
		},
		//获取当前投注信息
		//提交的数据标准格式
		/**
		result = {
			//游戏类型
			gameType:'ssc',
			//订单总金额
			amount:100,
			//是否是追号
			isTrace:1,
			//追号追中即停(1为按中奖次数停止，2为按中奖金额停止)
			traceWinStop:1,
			//追号追中即停的值
			traceStopValue:1,
			//选球信息
			balls:[{ball:'1,2,3,4',type:'wuxing.zhixuan.fushi',moneyunit:0.1,multiple:1,id:2},{ball:'选球数据',type:'玩法类型',moneyunit:元角模式,multiple:倍数,id:ID编号}],
			//投注信息
			orders:[{number:'201312122204',multiple:2},{number:'期号',multiple:倍数}]

		};
		**/
		getSubmitData: function() {
			var me = this,
				result = {},
				ballsData = Games.getCurrentGameOrder()['orderData'],
				orderSplitType = Games.getCurrentGame().getCurrentGameMethod().getOrderSplitType();
				i = 0,
				len = ballsData.length,
				traceInfo = Games.getCurrentGameTrace().getResultData(),
				j = 0,
				multiple = Games.getCurrentGameStatistics().getMultiple() || 1,
				jsId = 0,
				len2 = traceInfo['traceData'].length;
			result['gameId'] = Games.getCurrentGame().getGameConfig().getInstance().getGameId();
			//result['gameType'] = Games.getCurrentGame().getName();
			result['isTrace'] = Games.getCurrentGameTrace().getIsTrace();
			// result['trace'] = trace;
			result['traceWinStop'] = Games.getCurrentGameTrace().getIsWinStop();
			result['traceStopValue'] = Games.getCurrentGameTrace().getTraceWinStopValue();
			result['continus'] = ballsData['continus'] || 1;
			//加一个奖金组参数
			//result['prizeGroup'] = Games.getCurrentGame().getGameConfig().getInstance().setOptionalPrizes();//J-bonus-select-value
			result['balls'] = [];

			/*for (; i < len; i++) {
				var data = {
					'jsId': ballsData[i]['id'],
					'wayId': ballsData[i]['mid'],
					'ball': ballsData[i]['postParameter'].split(',').join('|'),
					'viewBalls':ballsData[i]['viewBalls'],
					'num': ballsData[i]['num'],
					'type': ballsData[i]['type'],
					'onePrice': ballsData[i]['onePrice'],
					'moneyunit': ballsData[i]['moneyUnit'],
					'multiple': ballsData[i]['multiple'],
					'prizeGroup':ballsData[i]['prizeGroup']
				};

				if( ballsData[i]['digitChoose'] &&  ballsData[i]['digitChoose'].length ){
					data['digitChoose'] = ballsData[i]['digitChoose'].join('|');
				}
				result['balls'].push(data);
			}*/
			// console.log(ballsData)
			$.each(ballsData, function(i,balldata){
				// 任二直选/组选复式 --- 扩展性非常不好
				if( balldata['orderSplitType'] == 'renxuan_zhixuan_fs' ){
					// 根据postParameter来计算投注方案
					var _balls = balldata['postParameter'].split('|'),
						_indexs = [],
						digitNeed = 2,
						gameType = balldata['type'],
						mid = balldata['mid'];
					if( gameType.indexOf('renxuansan') != -1 ){
						digitNeed = 3;
					}else if( gameType.indexOf('renxuansi') != -1 ){
						digitNeed = 4;
					}
					$.each(_balls, function(i,n){
						if(  n != '' ){
							_indexs.push(i);
						}
					});
					// console.log(_indexs);
					_indexs = Games.getCurrentGame().k_combinations(_indexs, digitNeed);
					// console.log(_indexs)
					$.each(_indexs, function(i, n){
						var _idxs = [], _b = [], _bb = [];
						$.each(n, function(k,v){
							_idxs.push(v);
							_b.push(_balls[v]);
							_bb.push(_balls[v].split(''));
						});
						_idxs = _idxs.join(',');
						_b = _b.join('|');
						var wayId = Games.getCurrentGame().getGameConfig().getInstance().getSeriesWayId(mid, _idxs),
							_num = Games.getCurrentGame().zx_combinations(_bb).length;
							_ball = {
								// 'jsId': balldata['id'],
								// 'wayId': balldata['mid'],
								'ball'      : _b,
								'viewBalls' : _b,
								'num'       : _num,
								'type'      : balldata['type'],
								'onePrice'  : balldata['onePrice'],
								'moneyunit' : balldata['moneyUnit'],
								'multiple'  : multiple,
								'prizeGroup': balldata['prizeGroup'],
								'index'		: _idxs
							};
						jsId++;
						_ball['jsId'] = jsId;
						_ball['wayId'] = wayId;
						result['balls'].push(_ball);
					});

					// console.log(balldata)
					// $.each(balldata['lotterys'], function(k,lottery){
					// 	var _indexs = [], _balls = [];
					// 	$.each(lottery, function(x,l){
					// 		l.split('');
					// 		_indexs.push(l[0]);
					// 		_balls.push(l[1]);
					// 	});
					// 	var index = _indexs.join(','),
					// 		balls = _balls.join('|'),
					// 		wayId = Games.getCurrentGame().getGameConfig().getInstance().getSeriesWayId(balldata['mid'], index);
					// 	jsId++;
					// 	result['balls'].push({
					// 		'jsId'      : jsId,
					// 		'wayId'     : wayId,
					// 		'ball'      : balls,
					// 		'viewBalls' : balls,
					// 		'num'       : 1,
					// 		'type'      : balldata['type'],
					// 		'onePrice'  : balldata['onePrice'],
					// 		'moneyunit' : balldata['moneyUnit'],
					// 		'multiple'  : multiple,
					// 		'prizeGroup': balldata['prizeGroup'],
					// 		'index'		: index
					// 	});
					// });
				}
				// 任二其他玩法
				else if( balldata['digitChoose'] &&  balldata['digitChoose'].length ){
					var digitChoose = balldata['digitChoose'];
					$.each(digitChoose, function(i,digit){
						var index = digit.join(','),
							wayId = Games.getCurrentGame().getGameConfig().getInstance().getSeriesWayId(balldata['mid'], index),
							_ball = {
								// 'jsId': balldata['id'],
								// 'wayId': balldata['mid'],
								'ball'      : balldata['postParameter'].split(',').join('|'),
								'viewBalls' : balldata['viewBalls'],
								'num'       : balldata['num'] / digitChoose.length,
								'type'      : balldata['type'],
								'onePrice'  : balldata['onePrice'],
								'moneyunit' : balldata['moneyUnit'],
								'multiple'  : multiple,
								'prizeGroup': balldata['prizeGroup'],
								'index'		: index
							};
						// console.log(digit, index, wayId)
						jsId++;
						_ball['jsId'] = jsId;
						_ball['wayId'] = wayId;
						result['balls'].push(_ball);
					});
				}
				// 非任二玩法
				else{
					jsId++;
					result['balls'].push({
						'jsId'      : jsId,
						'wayId'     : balldata['mid'],
						'ball'      : balldata['postParameter'].split(',').join('|'),
						'viewBalls' : balldata['viewBalls'],
						'num'       : balldata['num'],
						'type'      : balldata['type'],
						'onePrice'  : balldata['onePrice'],
						'moneyunit' : balldata['moneyUnit'],
						'multiple'  : multiple,
						'prizeGroup': balldata['prizeGroup']
					});
				}
			});
			// 追号
			result['orders'] = {};
			//非追号

			if (result['isTrace'] < 1) {
				//获得当前期号，将期号作为键
				result['orders'][Games.getCurrentGame().getGameConfig().getInstance().getCurrentGameNumber()] = 1;
				//总金额
				result['amount'] = Games.getCurrentGameOrder().getTotal()['amount'];
			} else {
				//追号
				for (; j < len2; j++) {
					result['orders'][traceInfo['traceData'][j]['traceNumber']] = traceInfo['traceData'][j]['multiple'];
				}
				//总金额
				result['amount'] = traceInfo['amount'];
			}
			return result;
		},
		//执行请求锁定动作
		doPostLock: function() {
			var me = this;
			me.postLock = true;
		},
		//取消请求锁定动作
		cancelPostLock: function() {
			var me = this;
			me.postLock = false;
		},
		//清空数据缓存
		clearData: function() {
			var order = Games.getCurrentGameOrder();
			//清空订单
			order.reSet();
			//添加取消编辑
			order.cancelSelectOrder();
			//清空
			Games.getCurrentGame().getCurrentGameMethod().reSet();
			//初始化追号框
			// Games.getCurrentGameTrace().emptyRowTable();
		},
		getFastSubmitData: function(balldata){
			var me = this,
				balldata = balldata || Games.getCurrentGameStatistics().getResultData(),
				result = {},
				orderSplitType = Games.getCurrentGame().getCurrentGameMethod().getOrderSplitType();
				i = 0,
				j = 0,
				jsId = 0,
				multiple = Games.getCurrentGameStatistics().getMultiple() || 1;
			result['gameId'] = Games.getCurrentGame().getGameConfig().getInstance().getGameId();
			result['isTrace'] = 0;
			result['traceWinStop'] = 1;
			result['traceStopValue'] = 1;
			result['balls'] = [];
			// result['continus'] = balldata['continus'];
			if( !balldata['postParameter'] ){
				balldata['postParameter'] = Games.getCurrentGame().getCurrentGameMethod().makePostParameter(balldata['original']);
			}
			// 任二直选/组选复式 --- 扩展性非常不好
			if( balldata['orderSplitType'] == 'renxuan_zhixuan_fs' ){
				// 根据postParameter来计算投注方案
				var _balls = balldata['postParameter'].split('|'),
					_indexs = [],
					digitNeed = 2,
					gameType = balldata['type'],
					mid = balldata['mid'];
				if( gameType.indexOf('renxuansan') != -1 ){
					digitNeed = 3;
				}else if( gameType.indexOf('renxuansi') != -1 ){
					digitNeed = 4;
				}
				$.each(_balls, function(i,n){
					if(  n != '' ){
						_indexs.push(i);
					}
				});
				// console.log(_indexs);
				_indexs = Games.getCurrentGame().k_combinations(_indexs, digitNeed);
				// console.log(_indexs)
				$.each(_indexs, function(i, n){
					var _idxs = [], _b = [], _bb = [];
					$.each(n, function(k,v){
						_idxs.push(v);
						_b.push(_balls[v]);
						_bb.push(_balls[v].split(''));
					});
					_idxs = _idxs.join(',');
					_b = _b.join('|');
					var wayId = Games.getCurrentGame().getGameConfig().getInstance().getSeriesWayId(mid, _idxs),
						_num = Games.getCurrentGame().zx_combinations(_bb).length;
						_ball = {
							// 'jsId': balldata['id'],
							// 'wayId': balldata['mid'],
							'ball'      : _b,
							'viewBalls' : _b,
							'num'       : _num,
							'type'      : balldata['type'],
							'onePrice'  : balldata['onePrice'],
							'moneyunit' : balldata['moneyUnit'],
							'multiple'  : multiple,
							'prizeGroup': balldata['prizeGroup'],
							'index'		: _idxs
						};
					jsId++;
					_ball['jsId'] = jsId;
					_ball['wayId'] = wayId;
					result['balls'].push(_ball);
				});
			}
			// 任二其他玩法
			else if( balldata['digitChoose'] &&  balldata['digitChoose'].length ){
				var digitChoose = balldata['digitChoose'];
				$.each(digitChoose, function(i,digit){
					var index = digit.join(','),
						wayId = Games.getCurrentGame().getGameConfig().getInstance().getSeriesWayId(balldata['mid'], index),
						_b = balldata['postParameter'].split(',').join('|'),
						_ball = {
							'ball'      : _b,
							'viewBalls' : _b,
							'num'       : balldata['num'] / digitChoose.length,
							'type'      : balldata['type'],
							'onePrice'  : balldata['onePrice'],
							'moneyunit' : balldata['moneyUnit'],
							'multiple'  : multiple,
							'prizeGroup': balldata['prizeGroup'],
							'index'		: index
						};
					// console.log(digit, index, wayId)
					jsId++;
					_ball['jsId'] = jsId;
					_ball['wayId'] = wayId;
					result['balls'].push(_ball);
				});
			}
			// 非任二玩法
			else{
				jsId++;
				var _b = balldata['postParameter'].split(',').join('|');
				result['balls'].push({
					'jsId'      : jsId,
					'wayId'     : balldata['mid'],
					'ball'      : _b,
					'viewBalls' : balldata['viewBalls'],
					'num'       : balldata['num'],
					'type'      : balldata['type'],
					'onePrice'  : balldata['onePrice'],
					'moneyunit' : balldata['moneyUnit'],
					'multiple'  : multiple,
					'prizeGroup': balldata['prizeGroup']
				});
			}
			// 投注期数格式修改为键值对
			result['orders'] = {};
			// 不会有追号
			// 因此，获得当前期号，将期号作为键
			result['orders'][Games.getCurrentGame().getGameConfig().getInstance().getCurrentGameNumber()] = 1;
			// 总金额
			result['amount'] = balldata['amount'];
			// console.log(result)
			// me.submitData(result);
			return result;
		},
		// fastSubmitData: function(order){
		// 	var t, me = this,
		// 			n = [],
		// 			r = 0,
		// 			i = 0,
		// 			l = {};
		// 	for (n.push(order), t = n.length, l.gameId = o.getCurrentGame().getGameConfig().getInstance().getGameId(), l.isTrace = 0, l.traceWinStop = 1, l.traceStopValue = 1, l.balls = []; t > i; i++) l.balls.push({
		// 		jsId: n[i].id,
		// 		wayId: n[i].mid,
		// 		ball: n[i].postParameter.split(",").join("|"),
		// 		position: n[i].position,
		// 		viewBalls: n[i].viewBalls,
		// 		num: n[i].num,
		// 		type: n[i].type,
		// 		onePrice: n[i].onePrice,
		// 		moneyunit: n[i].moneyUnit,
		// 		multiple: n[i].multiple
		// 	}), r += n[i].num * n[i].onePrice * n[i].moneyUnit * n[i].multiple;
		// 	l.orders = {}, l.orders[o.getCurrentGame().getGameConfig().getInstance().getCurrentGameNumber()] = 1, l.amount = r, a.submitData(!0, l)
		// },
		// 提交游戏数据
		submitData: function(submitData){
			var me = this,
				data = submitData || me.getSubmitData(),
				message = Games.getCurrentGameMessage();
			//判断加锁
			if (me.postLock) {
				return;
			}
			//提示至少选择一注
			if (data.balls.length <= 0) {
				message.show({
					type: 'mustChoose',
					msg: '请至少选择一注投注号码！',
					data: {
						tplData: {
							msg: '请至少选择一注投注号码！'
						}
					}
				});
				//请求解锁
				me.cancelPostLock();
				return;
			}

			// 彩种检查
			message.show({
				type: 'checkLotters',
				msg: '请核对您的投注信息！',
				buttons: [{
					label: '确 认',
					icon: 'glyphicon glyphicon-ok-circle',
					cssClass: 'btn-primary',
					autospin: true,
          action: function(dialog){
          	dialog.enableButtons(false);
            dialog.setClosable(false);
            if (me.postLock) {
							return;
						}
						$.ajax({
							url: Games.getCurrentGame().getGameConfig().getInstance().getSubmitUrl(),
							data: Games.getCurrentGame().editSubmitData(data),
							dataType: 'json',
							method: 'POST',
							beforeSend:function(){
								me.doPostLock();
								me.fireEvent('beforeSend', message);
							},
							success: function(r) {
								// r = $.parseJSON(r);
								//返回消息标准
								// {"isSuccess":1,"type":"消息代号","msg":"返回的文本消息","data":{xxx:xxx}}
								if (Number(r['isSuccess']) == 1) {
									message.show(r);
									me.clearData();
									me.fireEvent('afterSubmitSuccess');
								} else {
									message.show(r);
								}

								//请求解锁
								me.cancelPostLock();
							},
							complete: function() {
								me.fireEvent('afterSubmit', message);
							},
							error: function() {
								me.cancelPostLock();
							}
						});
					}
				},
				{
					label: '取 消',
					action: function(dialog){
						// 请求解锁
						me.cancelPostLock();
						dialog.close();
					}
				}],
				data: {
					tplData: {
						//当期彩票详情
						lotteryDate: '--',
						//彩种名称
						lotteryName: Games.getCurrentGame().getGameConfig().getInstance().getGameNameCn(),
						lotteryIssue: Games.getCurrentGame().getGameConfig().getInstance().getCurrentGameNumber(),
						//投注详情
						lotteryInfo: function() {
							var html = '',
								gmConfig = Games.getCurrentGame().getGameConfig().getInstance(),
								balls = data['balls'],
								digitTexts = ['万','千','百','十','个'];
							for (var i = 0; i < balls.length; i++) {
								var current = balls[i];
								var typeText = gmConfig.getMethodCnFullNameById(current['wayId']);
								if(typeText[0] == typeText[1] && typeText[1] == typeText[2]){
									typeText = gmConfig.getMethodCnFullNameById(current['wayId'])[2];
								}else{
									typeText = typeText[0]+','+typeText[2];
								}
								if( current['index'] ){
									var index = current['index'].split(','),
										digitText = '';
									$.each(index,function(idx, n){
										digitText += digitTexts[n] || '';
									});
									typeText += ',' + digitText + '位';
								}
								var amount = current['moneyunit']*current['onePrice']*current['num']*current['multiple'];
								html += '<div class="game-submit-confirm-list">' + typeText + ' ' + current['viewBalls'] + '<span style="display:none;" class="amount-for-print">&nbsp;&nbsp;&nbsp' + amount + '元</span></div>';
							};
							return html;
						},
						//彩种金额
						lotteryamount: host.util.formatMoney(data['amount'], 3),
						//付款账号
						lotteryAcc: Games.getCurrentGame().getGameConfig().getInstance().getUserName(),
						lotterOptionalPrizes:Games.getCurrentGame().getGameConfig().getInstance().setOptionalPrizes()
					}
				}
			});
		}
	};

	var Main = host.Class(pros, Event);
	Main.defConfig = defConfig;
	Main.getInstance = function(cfg) {
		return instance || (instance = new Main(cfg));
	};
	host[name] = Main;

})(betgame, "GameSubmit", betgame.Event);
