//初始化数据加载
(function(host, name, Event, undefined){
	var ConfigData =gameConfigData,
		defConfig = {
		},
		nodeCache = {},
		methodCache = {},
		instance;
	//将树状数据整理成两级缓存数据
	(function(){ 
			var data= ConfigData['wayGroups'],
				node1,node2,node3;

			$.each(data, function(){
				node1 = this;
				node1['fullname_en'] = [node1['name_en']];
				node1['fullname_cn'] = [node1['name_cn']];
				nodeCache['' + node1['id']] = node1;
				if(node1['children']){
					var isRenxuan = node1['isRenxuan'];
					$.each(node1['children'], function(){
						node2 = this;
						node2['fullname_en'] = node1['fullname_en'].concat(node2['name_en']);
						node2['fullname_cn'] = node1['fullname_cn'].concat(node2['name_cn']);
						nodeCache['' + node2['id']] = node2;
						if(node2['children']){
							$.each(node2['children'], function(){
								node3 = this;
								node3['fullname_en'] = node2['fullname_en'].concat(node3['name_en']);
								node3['fullname_cn'] = node2['fullname_cn'].concat(node3['name_cn']);
								node3['isRenxuan'] = isRenxuan;
								methodCache['' + node3['id']] = node3;
							});
						}
					});
				}
			});
	})();
	//ConfigData['currentTime'] = (new Date()).getTime()/1000;
	//ConfigData['currentNumberTime'] = ConfigData['currentTime'] + 5;
	// console.log(methodCache)

	var pros = {
		init:function(){
		},
		getGameId:function(){
			return ConfigData['gameId'];
		},
		//获取游戏英文名称
		getGameNameEn:function(){
			return ConfigData['gameNameEn'];
		},
		//获取游戏中文名称
		getGameNameCn:function(){
			return ConfigData['gameNameCn'];
		},
		//获取最大追号期数
		getTraceMaxTimes:function(){
			return Number(ConfigData['traceMaxTimes']);
		},
		//获取当前期开奖时间
		getCurrentLastTime:function(){
			return ConfigData['currentNumberTime'];
		},
		//获取当前时间
		getCurrentTime:function(){
			return ConfigData['currentTime'];
		},
		//获取当前期期号
		getCurrentGameNumber:function(){
			return ConfigData['currentNumber'];
		},
		// 获取上期期号
		getLastGameNumber:function(){
			var issues = this.getLotteryNumbers();
			var number = issues[0] && issues[0]['issue'];
			return number || '';
		},
		// 获取上期开奖号码
		getLotteryBalls:function(){
			var issues = this.getLotteryNumbers();
			var ball = issues[0] && issues[0]['wn_number'];
			return ball || '';
		},
		getLotteryNumbers:function(){
			return ConfigData['issueHistory']['issues'] || [];
		},
		getBallsHistory:function(){
			return ConfigData['ballsHistory'] || [];
		},
		getFormatLotteryNumbers:function(ft,numbers){
			var me = this, temp = {};
			numbers = numbers ? numbers : me.getLotteryNumbers();
			ft = ft || 'hour';
			// {"number":"150504074","time":"12121212","hasLottery":1},
			$.each(numbers, function(i,n){
				var key = me.getKeyByDateStr((''+(n['offical_time'])) ,ft);

				if( key ){
					if( !temp[key] ){
						temp[key] = [];
					}
					temp[key].push(n);
				}
			});
			// console.log(temp);
			return temp;
		},
		getKeyByDateStr: function(unix, type){
			unix = unix || '0',
			type = type || 'hour';
			var d = new Date();
			d.setTime(parseInt(unix) * 1000);
			if( Object.prototype.toString.call(d) === "[object Date]" ) {
				// it is a date
				if( isNaN( d.getTime() ) ) {  // d.valueOf() could also work
					// date is not valid
					return '';
				}else{
					// date is valid
					var month = d.getMonth() + 1,
						day = d.getDate(),
						hour = d.getHours(),
						minute = d.getMinutes();
					if(month<10) month = '0' + month;
					if(day<10) day = '0' + day;
					if(hour<10) hour = '0' + hour;
					if(minute<10) minute = '0' + minute;

					if( type == 'month' ){
						return month + '月';
					}else if( type == 'day'){
						return month + '月' + day + '日';
					}else if( type == 'minute'){
						return hour + ':' + minute;
					}else{
						return hour + ':00';
					}
				}
			}else{
				// not a date
				return '';
			}

		},
		//获取期号列表
		getGameNumbers:function(){
			return ConfigData['gameNumbers'];
		},
		//id : methodid
		//unit : money unit (1 | 0.1)
		getLimitByMethodId:function(id, unit){
			var unit = unit || 1,maxnum = Number(this.getPrizeById(id)['max_multiple']);
			return maxnum / unit;
		},
		//注单提交地址
		getSubmitUrl:function(){
			return ConfigData['submitUrl'];
		},
		//更新开奖、配置等最新信息的地址
		getUpdateUrl:function(){
			return ConfigData['loaddataUrl'];
		},
		//文件上传地址
		getUploadPath:function(){
			return ConfigData['uploadPath'];
		},
		//js存放目录
		getJsPath:function(){
			return ConfigData['jsPath'];
		},
		//默认游戏玩法
		getDefaultMethodId:function(){
			return ConfigData['defaultMethodId'];
		},
		//获取当前用户名
		getUserName:function(){
			return ConfigData['username'];
		},

		getDelayTime:function(){
			return 5;
			return Number(ConfigData['delayTime']);
		},
		getLastGameBallsUrl:function(){
			return ConfigData['lastGameBallsUrl'];
		},

		//获取所有玩法
		getMethods:function(){
			return ConfigData['wayGroups'];
		},
		//获取某个玩法
		getMethodById:function(id){
			return methodCache['' + id];
		},
		//获取大数据某个玩法
		getPrizeById:function(id){
			return ConfigData['prizeSettings']['' + id];
		},
		//获取玩法节点
		getMethodNodeById:function(id){
			return nodeCache['' + id];
		},
		//获取玩法英文名称
		getMethodNameById:function(id){
			var method = this.getMethodById(id),
				enName;
			if( !method ){
				$.each(methodCache, function(idx, method){
					if( enName ) return false;
					if( method['relation_series_ids'] ){
						$.each(method['relation_series_ids'], function(i,n){
							if( n['series_way_id'] == id ){
								enName = method['name_en'];
								return false;
							}
						});
					}
				});
			}else{
				enName = method['name_en']
			}
			return enName || '';
		},
		//获取玩法中文名称
		getMethodCnNameById:function(id){
			var method = this.getMethodById(id),
				cnName;
			if( !method ){
				$.each(methodCache, function(idx, method){
					if( cnName ) return false;
					if( method['relation_series_ids'] ){
						$.each(method['relation_series_ids'], function(i,n){
							if( n['series_way_id'] == id ){
								cnName = method['name_cn'];
								return false;
							}
						});
					}
				});
			}else{
				cnName = method['name_cn']
			}
			return cnName || '';
		},
		//获取完整的英文名称 wuxing.zhixuan.fushi
		getMethodFullNameById:function(id){
			var method = this.getMethodById(id),
				fullEnName;
			if( !method ){
				$.each(methodCache, function(idx, method){
					if( fullEnName ) return false;
					if( method['relation_series_ids'] ){
						$.each(method['relation_series_ids'], function(i,n){
							if( n['series_way_id'] == id ){
								fullEnName = method['fullname_en'];
								return false;
							}
						});
					}
				});
			}else{
				fullEnName = method['fullname_en']
			}
			return fullEnName || '';
		},
		//获取完整的玩法名称
		getMethodCnFullNameById:function(id){
			var method = this.getMethodById(id),
				fullCnName;
			if( !method ){
				$.each(methodCache, function(idx, method){
					if( fullCnName ) return false;
					if( method['relation_series_ids'] ){
						$.each(method['relation_series_ids'], function(i,n){
							if( n['series_way_id'] == id ){
								fullCnName = method['fullname_cn'];
								return false;
							}
						});
					}
				});
			}else{
				fullCnName = method['fullname_cn']
			}
			return fullCnName || '';
		},
		//获取某玩法的单注单价
		getOnePriceById:function(id){
			return this.getMethodById(id)['price'];
		},
		getToken:function(){
			return ConfigData['_token'];
		},
		//更新配置，进行深度拷贝
		updateConfig:function(cfg){
			$.extend(true, ConfigData, cfg);
		},
		getOptionalPrizes:function(){
			return ConfigData['optionalPrizes'];
		},
		setOptionalPrizes:function(){
			return $('#J-bonus-select-value').val();
		},
		getDefaultCoefficient:function(){
			return (!ConfigData['defaultCoefficient'] ) ? '1':ConfigData['defaultCoefficient'] ;
		},
		getDefaultMultiple:function(){
			return (!ConfigData['defaultMultiple']) ?'1':ConfigData['defaultMultiple'];
		},
                		getDefaultPrizeGroup:function(){
			return (!ConfigData['defaultPrizeGroup'] ) ? '1800':ConfigData['defaultPrizeGroup'] ;
		},
		getLoadIssueUrl:function(){
			return ConfigData['loadIssueUrl'];
		},
		getMaxPrizeGroup:function(){
			return ConfigData['maxPrizeGroup'];
		},
		getSeriesWayId: function(wayid, index){
			var seriesIds = this.getMethodById(wayid)['relation_series_ids'] || [],
				id = -1;
			$.each(seriesIds, function(i,n){
				if( n['index'] == index ){
					id =  n['series_way_id'];
					return false;
				}
			});
			return id;
		},
		isRenxuan: function(id){
			var method = this.getMethodById(id);
			return method && method['isRenxuan'];
		}

	};

	var Main = host.Class(pros, Event);
	Main.defConfig = defConfig;
	Main.getInstance = function(cfg){
		return instance || (instance = new Main(cfg));
	};

	host.Games.PK10[name] = Main;

})(dsgame, "Config", dsgame.Event);

