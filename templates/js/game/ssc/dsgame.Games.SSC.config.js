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
		var data = ConfigData['gameMethods'],
			node1,
			node2,
			node3;

		$.each(data, function(){
			node1 = this;
			node1['fullname_en'] = [node1['name_en']];
			node1['fullname_cn'] = [node1['name_cn']];
			nodeCache['' + node1['id']] = node1;
			if(node1['children']){
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
							methodCache['' + node3['id']] = node3;
						});
					}
				});
			}
		});
	})();

	//ConfigData['currentTime'] = (new Date()).getTime()/1000;
	//ConfigData['currentNumberTime'] = ConfigData['currentTime'] + 5;

	var pros = {
		init:function(){
		},
		getGameId:function(){
			return ConfigData['gameId'];
		},
		//获取游戏英文名称
		getGameNameEn:function(){
			return ConfigData['gameName_en'];
		},
		//获取游戏中文名称
		getGameNameCn:function(){
			return ConfigData['gameName_cn'];
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
		//获取上期期号
		getLastGameNumber:function(){
			return ConfigData['lastNumber'];
		},
		getLotteryBalls:function(){
			return ConfigData['lotteryBalls'] || '00000';
		},
		//获取期号列表
		getGameNumbers:function(){
			return ConfigData['gameNumbers'];
		},
		//id : methodid
		//unit : money unit (1 | 0.1)
		getLimitByMethodId:function(id, unit){
			var unit = unit || 1,maxnum = Number(this.getMethodById(id)['max_multiple']);
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
			return '/';
			return ConfigData['lastGameBallsUrl'];
		},

		//获取所有玩法
		getMethods:function(){
			return ConfigData['gameMethods'];
		},
		//获取某个玩法
		getMethodById:function(id){
			return methodCache['' + id];
		},
		//获取玩法节点
		getMethodNodeById:function(id){
			return nodeCache['' + id];
		},
		//获取玩法英文名称
		getMethodNameById:function(id){
			var method = this.getMethodById(id);
			return method ? method['name_en'] : '';
		},
		//获取玩法中文名称
		getMethodCnNameById:function(id){
			var method = this.getMethodById(id);
			return method ? method['name_cn'] : '';
		},
		//获取完整的英文名称 wuxing.zhixuan.fushi
		getMethodFullNameById:function(id){
			var method = this.getMethodById(id);
			return method ? method['fullname_en'] : '';
		},
		//获取完整的玩法名称
		getMethodCnFullNameById:function(id){
			var method = this.getMethodById(id);
			return method ? method['fullname_cn'] : '';
		},
		//获取某玩法的单注单价
		getOnePriceById:function(id){
			return Number(this.getMethodById(id)['price']);
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
		getLoadIssueUrl:function(){
			return ConfigData['loadIssueUrl'];
		}

	};

	var Main = host.Class(pros, Event);
	Main.defConfig = defConfig;
	Main.getInstance = function(cfg){
		return instance || (instance = new Main(cfg));
	};

	host.Games.SSC[name] = Main;
})(dsgame, "Config", dsgame.Event);