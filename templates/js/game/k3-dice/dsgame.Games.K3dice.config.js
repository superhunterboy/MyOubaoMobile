(function(host, undefined) {
	var ConfigData = gameConfigData,
		defConfig = {},
		nodeCache = {},
		methodCacheById = {},
		methodCacheByName = {},
		ballLists = [],
		instance;

		//ConfigData['jsPath'] = ConfigData['jsPath'].replace('ssc', 'K3');
	ballLists = [
		{"name":"dx.dx.fs"      , "ball": "1"  , "viewBalls":"大"  , "odds":1},
		{"name":"ds.ds.fs"      , "ball": "1"  , "viewBalls":"单"  , "odds":1},
		{"name":"ethfx.ethfx.fs", "ball": "6"  , "viewBalls":"66*" , "odds":10},
		{"name":"ethfx.ethfx.fs", "ball": "5"  , "viewBalls":"55*" , "odds":10},
		{"name":"ethfx.ethfx.fs", "ball": "4"  , "viewBalls":"44*" , "odds":10},
		{"name":"sthdx.sthdx.fs", "ball": "6"  , "viewBalls":"666" , "odds":180},
		{"name":"sthdx.sthdx.fs", "ball": "5"  , "viewBalls":"555" , "odds":180},
		{"name":"sthdx.sthdx.fs", "ball": "4"  , "viewBalls":"444" , "odds":180},
		{"name":"sthdx.sthdx.fs", "ball": "3"  , "viewBalls":"333" , "odds":180},
		{"name":"sthdx.sthdx.fs", "ball": "2"  , "viewBalls":"222" , "odds":180},
		{"name":"sthdx.sthdx.fs", "ball": "1"  , "viewBalls":"111" , "odds":180},
		{"name":"sthtx.sthtx.fs", "ball": "1"  , "viewBalls":"通选" , "odds":30},
		{"name":"ethfx.ethfx.fs", "ball": "3"  , "viewBalls":"33*" , "odds":10},
		{"name":"ethfx.ethfx.fs", "ball": "2"  , "viewBalls":"22*" , "odds":10},
		{"name":"ethfx.ethfx.fs", "ball": "1"  , "viewBalls":"11*" , "odds":10},
		{"name":"dx.dx.fs"      , "ball": "0"  , "viewBalls":"小"  , "odds":1},
		{"name":"ds.ds.fs"      , "ball": "0"  , "viewBalls":"双"  , "odds":1},
		{"name":"hz.hz.fs"      , "ball": "17" , "viewBalls":"17"  , "odds":60},
		{"name":"hz.hz.fs"      , "ball": "16" , "viewBalls":"16"  , "odds":30},
		{"name":"hz.hz.fs"      , "ball": "15" , "viewBalls":"15"  , "odds":18},
		{"name":"hz.hz.fs"      , "ball": "14" , "viewBalls":"14"  , "odds":12},
		{"name":"hz.hz.fs"      , "ball": "13" , "viewBalls":"13"  , "odds":8},
		{"name":"hz.hz.fs"      , "ball": "12" , "viewBalls":"12"  , "odds":6},
		{"name":"hz.hz.fs"      , "ball": "11" , "viewBalls":"11"  , "odds":6},
		{"name":"hz.hz.fs"      , "ball": "10" , "viewBalls":"10"  , "odds":6},
		{"name":"hz.hz.fs"      , "ball": "9"  , "viewBalls":"9"   , "odds":6},
		{"name":"hz.hz.fs"      , "ball": "8"  , "viewBalls":"8"   , "odds":8},
		{"name":"hz.hz.fs"      , "ball": "7"  , "viewBalls":"7"   , "odds":12},
		{"name":"hz.hz.fs"      , "ball": "6"  , "viewBalls":"6"   , "odds":18},
		{"name":"hz.hz.fs"      , "ball": "5"  , "viewBalls":"5"   , "odds":30},
		{"name":"hz.hz.fs"      , "ball": "4"  , "viewBalls":"4"   , "odds":60},
		{"name":"ebth.ebth.fs"  , "ball": "5|6", "viewBalls":"5,6" , "odds":5},
		{"name":"ebth.ebth.fs"  , "ball": "4|6", "viewBalls":"4,6" , "odds":5},
		{"name":"ebth.ebth.fs"  , "ball": "4|5", "viewBalls":"4,5" , "odds":5},
		{"name":"ebth.ebth.fs"  , "ball": "3|6", "viewBalls":"3,6" , "odds":5},
		{"name":"ebth.ebth.fs"  , "ball": "3|5", "viewBalls":"3,5" , "odds":5},
		{"name":"ebth.ebth.fs"  , "ball": "3|4", "viewBalls":"3,4" , "odds":5},
		{"name":"ebth.ebth.fs"  , "ball": "2|6", "viewBalls":"2,6" , "odds":5},
		{"name":"ebth.ebth.fs"  , "ball": "2|5", "viewBalls":"2,5" , "odds":5},
		{"name":"ebth.ebth.fs"  , "ball": "2|4", "viewBalls":"2,4" , "odds":5},
		{"name":"ebth.ebth.fs"  , "ball": "2|3", "viewBalls":"2,3" , "odds":5},
		{"name":"ebth.ebth.fs"  , "ball": "1|6", "viewBalls":"1,6" , "odds":5},
		{"name":"ebth.ebth.fs"  , "ball": "1|5", "viewBalls":"1,5" , "odds":5},
		{"name":"ebth.ebth.fs"  , "ball": "1|4", "viewBalls":"1,4" , "odds":5},
		{"name":"ebth.ebth.fs"  , "ball": "1|3", "viewBalls":"1,3" , "odds":5},
		{"name":"ebth.ebth.fs"  , "ball": "1|2", "viewBalls":"1,2" , "odds":5},
		{"name":"bdw.bdw.fs"    , "ball": "6"  , "viewBalls":"6"   , "odds":1},
		{"name":"bdw.bdw.fs"    , "ball": "5"  , "viewBalls":"5"   , "odds":1},
		{"name":"bdw.bdw.fs"    , "ball": "4"  , "viewBalls":"4"   , "odds":1},
		{"name":"bdw.bdw.fs"    , "ball": "3"  , "viewBalls":"3"   , "odds":1},
		{"name":"bdw.bdw.fs"    , "ball": "2"  , "viewBalls":"2"   , "odds":1},
		{"name":"bdw.bdw.fs"    , "ball": "1"  , "viewBalls":"1"   , "odds":1}
	];

	//将树状数据整理成两级缓存数据
	var setGameMethods = function(){
		var data= ConfigData['wayGroups'],			
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
							methodCacheByName[node3['fullname_en'].join('.')] = node3;
							methodCacheById['' +node3['id']] = node3;
						});
					}
				});
			}
		});
		return {
			'byName': methodCacheByName,
			'byId'  : methodCacheById
		}
	}


	//ConfigData['currentTime'] = (new Date()).getTime()/1000;
	//ConfigData['currentNumberTime'] = ConfigData['currentTime'] + 5;

	var pros = {
		init:function(){
			this.setGameMethods();
			this.setBallLists();
		},
		getConfig: function(){
			return ConfigData;
		},
		setGameMethods: function(){
			this.gameMethods = setGameMethods();
		},
		getGameMethods: function(type){
			var type = type || 'byId';
			// console.log(this.gameMethods[type])
			return this.gameMethods[type];
		},
		setBallLists: function(){
			var gameMethods = this.getGameMethods('byName'),
				temp = [];
			$.each(ballLists, function(i,n){
				var name = n['name'], id = -1;
				if( gameMethods[name] && (id = gameMethods[name]['id'] ) ){
					n['id'] = id;
					n['typeName'] = gameMethods[name]['name_cn']
				}
				temp.push(n);
			});
			return this.ballLists = temp;
		},
		getBallLists: function() {
			return this.ballLists;
		},
		getBallsById: function(id){
			var methods = this.gameMethods['byId'];
			return methods[id];
		},
		getGameLimit: function(){
			return ConfigData['prizeSettings'];
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
		//获取上期期号
		getLastGameNumber:function(){
			return ConfigData['issueHistory']['last_number']['issue'];
		},
		getLotteryBalls:function(){
			return ConfigData['issueHistory']['last_number']['wn_number'] || '';
		},
		getLotteryNumbers:function(){
			return ConfigData['issueHistory']['issues'] || [];
		},
		//获取期号列表
		getGameNumbers:function(){
			return ConfigData['gameNumbers'];
		},
		//id : methodid
		//unit : money unit (1 | 0.1)
		getLimitByMethodId:function(id, unit){
			var unit = unit || 1,
				maxnum = Number(this.getPrizeById(id)['max_multiple']);
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
		//获取所有玩法
		getMethods:function(){
			return ConfigData['wayGroups'];
		},
		//获取某个玩法
		getMethodById:function(id){
			return this.getGameMethods('byId')['' + id];
		},
		//获取大数据某个玩法
		getPrizeById:function(id){
			return ConfigData['prizeSettings']['' + id];
		},
		//获取玩法节点
		getMethodNodeById:function(id){
			return nodeCacheById['' + id];
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
		// 更新配置，进行深度拷贝
		updateConfig:function(cfg){
			$.extend(true, ConfigData, cfg);
			this.init();
		},
		getOptionalPrizes:function(){
			return ConfigData['optionalPrizes'];
		},
		setOptionalPrizes:function(){
			return $('#J-bonus-select-value').val();
		},
		getDefaultCoefficient:function(){
			// return ConfigData['defaultCoefficient'] ? ConfigData['defaultCoefficient'] : '1.00';
			return '0.50';
		},
		getDefaultMultiple:function(){
			return ConfigData['defaultMultiple'] ? ConfigData['defaultMultiple'] : 1;
		},
		getLoadIssueUrl:function(){
			return ConfigData['loadIssueUrl'];
		},
        getMaxPrizeGroup:function(){
            return ConfigData['maxPrizeGroup'];
        }
	};

	function GameConfig(){
		this.init();
	};
	GameConfig.prototype = pros;

	return host.GameConfig = GameConfig;

})(window);