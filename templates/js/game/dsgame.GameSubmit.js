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
				i = 0,
				len = ballsData.length,
				traceInfo = Games.getCurrentGameTrace().getResultData(),
				j = 0,
				len2 = traceInfo['traceData'].length;

			//console.log(ballsData);


			result['gameId'] = Games.getCurrentGame().getGameConfig().getInstance().getGameId();
			//result['gameType'] = Games.getCurrentGame().getName();
			result['isTrace'] = Games.getCurrentGameTrace().getIsTrace();
			result['traceWinStop'] = Games.getCurrentGameTrace().getIsWinStop();
			result['traceStopValue'] = Games.getCurrentGameTrace().getTraceWinStopValue();
			//加一个奖金组参数
			//result['prizeGroup'] = Games.getCurrentGame().getGameConfig().getInstance().setOptionalPrizes();//J-bonus-select-value
			result['balls'] = [];
			for (; i < len; i++) {
				result['balls'].push({
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

				});
			}
			//console.log(result);

			/**
			result['orders'] = [];
			//非追号
			if(result['isTrace'] < 1){
				//获得当前期号
				result['orders'].push({'number':Games.getCurrentGame().getGameConfig().getInstance().getCurrentGameNumber(),multiple:1});
				//总金额
				result['amount'] = Games.getCurrentGameOrder().getTotal()['amount'];
			}else{
			//追号
				for(;j < len2;j++){
					result['orders'].push({'number':traceInfo['traceData'][j]['traceNumber'].replace(/[^\d]/g, ''),'multiple':traceInfo['traceData'][j]['multiple']});
				}
				//总金额
				result['amount'] = traceInfo['amount'];
			}
			**/
			//投注期数格式修改为键值对
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
			Games.getCurrentGameTrace().emptyRowTable();
		},
		//提交游戏数据
		submitData: function(){
			var me = this,
				data = me.getSubmitData(),
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



			//data = Games.getCurrentGame().editSubmitData(data);
			//console.log(Games.getCurrentGame().editSubmitData(data));


			//彩种检查
			message.show({
				type: 'checkLotters',
				msg: '请核对您的投注信息！',
				confirmIsShow: true,
				confirmFun: function() {
					if (me.postLock) {
						return;
					}
					/**
					//生成表单提交方式(test)
					var subData = Games.getCurrentGame().editSubmitData(data),
						JSONStr = '',
						formArr = [];

					//console.log(subData);


					JSONStr = encodeURI(JSON.stringify(subData));

					//JSONStr = JSONStr.replace('"', '');
					//JSONStr = JSONStr.replace("'", '');

					formArr.push('<form action="'+ Games.getCurrentGame().getGameConfig().getInstance().getSubmitUrl() +'" method="POST" target="_blank" >');
					formArr.push('<input type="hidden" name="betdata" value="'+ JSONStr +'"/>');
					formArr.push('<input type="hidden" name="_token" value="'+ Games.getCurrentGame().getGameConfig().getInstance().getToken() +'"/>');
					formArr.push('</form>');
					$(formArr.join('')).submit().remove();

					return;
					**/

					//console.log(Games.getCurrentGame().editSubmitData(data));
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
				},
				cancelIsShow: true,
				cancelFun: function() {
					//请求解锁
					me.cancelPostLock();
					this.hide();
				},
				normalCloseFun: function() {
					//请求解锁
					me.cancelPostLock();
				},
				callback: function() {
					/**
					$.ajax({
						url: me.defConfig.handlingChargeURL + '?amout='+data['amount'],
						dataType: 'json',
						method: 'GET',
						success: function(r){
							if(Number(r['isSuccess']) == 1){
								message.getContentDom().find('.handlingCharge').html(r['data']['handingcharge']);
							}
						}
					});
					**/
				},
				data: {
					tplData: {
						//当期彩票详情
						lotteryDate: '--',
						//彩种名称
						lotteryName: Games.getCurrentGame().getGameConfig().getInstance().getGameNameCn(),
						//投注详情
						lotteryInfo: function() {
							var html = '',
								gmConfig = Games.getCurrentGame().getGameConfig().getInstance(),
								balls = data['balls'];
							//console.log(balls);
							for (var i = 0; i < balls.length; i++) {
								var current = balls[i];
								var typeText = gmConfig.getMethodCnFullNameById(current['wayId']);
								if(typeText[0] == typeText[1] && typeText[1] == typeText[2]){
								    typeText = gmConfig.getMethodCnFullNameById(current['wayId'])[2];
								}else{
									typeText = typeText.join(',');
								};
								html += '<div class="game-submit-confirm-list">' + typeText + ' ' + current['viewBalls'] + '</div>';
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

})(dsgame, "GameSubmit", dsgame.Event);