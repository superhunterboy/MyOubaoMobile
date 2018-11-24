(function(host, name, Game, undefined){
	var defConfig = {
		//游戏名称
		name:'PK10',
		jsNamespace:'',
		// 位数默认选择
		digitConf: [0,0,0,0,0],
		// 需要的位数
		digitNeed: 0,
	},
	instance,
	Games = host.Games;

	var pros = {
		init:function(){
			var me = this;
			//初始化事件放在子类中执行，以确保dom元素加载完毕
			me.eventProxy();

			// 记录位数选择
			// me.digitNeed = me.defConfig.digitNeed;
			// me.digitStatus = me.defConfig.digitConf;
			// me.digitChoosed = [];
			// me.setDigitChoosed();
			// me.setProjectNum();
			me.digitStatus = [];
			me.digitChoosed = [];
		},
		getGameConfig:function(){
			return Games.PK10.Config;
		},
		// 位数选择设置
		digitStatusToggle: function(idx){
			var me = this,
				digitStatus = me.getDigitStatus(),
				flag = true;
			digitStatus[idx] = Number(!digitStatus[idx]);
			me.setDigitChoosed(digitStatus);
			if( me.checkDigitStatus(digitStatus) ){
				me.digitStatus = digitStatus;
			}else{
				digitStatus[idx] = Number(!digitStatus[idx]);
				flag = false;
				me.setDigitChoosed(digitStatus);
			}
			me.setProjectNum();
			Games.getCurrentGame().fireEvent('afterDigitStatusChange');
			return flag;
		},
		initDigitStatus: function(digitNeed, digitStatus){
			// console.log(digitNeed, digitStatus)
			this.digitNeed = Number(digitNeed);
			this.digitStatus = digitStatus;
			this.setDigitChoosed();
			this.setProjectNum();
		},
		getDigitStatus: function(idx){
			return ( idx && this.digitStatus[idx] ) || this.digitStatus;
		},
		checkDigitStatus: function(){
			digitChoosed = this.getDigitChoosed();
			if( digitChoosed.length >= this.getDigitNeed() ){
				return true;
			}else{
				return false;
			}
		},
		getDigitNeed: function(){
			return this.digitNeed;
		},
		setDigitChoosed: function(digitStatus){
			var me = this,
				digitStatus = digitStatus || me.getDigitStatus(),
				digitChoosed = [];
			$.each(digitStatus, function(i,d){
				var flag = false;
				if( d ){
					digitChoosed.push(i);
					flag = true;
				}
				Games.getCurrentGame().fireEvent('digitLabelsEvent', i, flag);
			});
			return this.digitChoosed = digitChoosed;
		},
		getDigitChoosed: function(){
			return this.digitChoosed;
		},
		getProjectNum: function(){
			return this.digitProjectNum;
		},
		setProjectNum: function(){
			var me = this,
				digitChoosed = me.k_combinations(me.getDigitChoosed(), me.getDigitNeed()),
				oldNum = me.getProjectNum() || 1;
			me.digitProjectNum = digitChoosed.length || 1;
			Games.getCurrentGame().fireEvent('afterProjectNumSet', oldNum, digitChoosed);
		},
		// 二维数组的排列组合
		// arr2 二维数组
		combination: function(arr2) {
			if (arr2.length < 1) {
				return [];
			}
			var w = arr2[0].length,
				h = arr2.length,
				i, j,
				m = [],
				n,
				result = [],
				_row = [];

			m[i = h] = 1;

			while (i--) {
				m[i] = m[i + 1] * arr2[i].length;
			}
			n = m[0];
			for (i = 0; i < n; i++) {
				_row = [];
				for (j = 0; j < h; j++) {
					_row[j] = arr2[j][~~(i % m[j] / m[j + 1])];
				}
				result[i] = _row;
			}
			return result;
		},
		k_combinations: function(set, k){
			var i, j, combs, head, tailcombs, me = this;

			if (k > set.length || k <= 0) {
				return [];
			}
			if (k == set.length) {
				return [set];
			}
			if (k == 1) {
				combs = [];
				for (i = 0; i < set.length; i++) {
					combs.push([set[i]]);
				}
				return combs;
			}

			combs = [];
			for (i = 0; i < set.length - k + 1; i++) {
				head = set.slice(i, i+1);
				tailcombs = me.k_combinations(set.slice(i + 1), k - 1);
				for (j = 0; j < tailcombs.length; j++) {
					combs.push(head.concat(tailcombs[j]));
				}
			}
			return combs;
		},
		zx_combinations:function(set){
			var ret = [];
			while(set.length){
				var pop = set.pop();
				ret = combs(pop, ret);
				// console.log(pop,ret,set);
			}
			function combs(arr1, arr2){
				var ret = [];
				$.each(arr1, function(i,n){
					var _a = [n];
					if( !arr2 || !arr2.length ){
						ret.push(n);
					}
					$.each(arr2, function(k,v){
						if( $.isArray(v) ){
							var _b = v;
						}else{
							var _b = [v];
						}
						ret.push( _a.concat(_b) );
					});
				});
				return ret;
			}
			// console.log(ret);
			return ret;
		}
	};

	var Main = host.Class(pros, Game);
		Main.defConfig = defConfig;
		//游戏控制单例
		Main.getInstance = function(cfg){
			return instance || (instance = new Main(cfg));
		};
	host.Games[name] = Main;

})(betgame, "PK10", betgame.Game);











