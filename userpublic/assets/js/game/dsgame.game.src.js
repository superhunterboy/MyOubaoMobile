

//Games
(function(host, name, undefined){

	var Main = {};
		//缓存
		Main.cacheData = {};

		//当前游戏
		Main.currentGame = null;
		//玩法切换
		Main.currentGameTypes = null;
		//当前统计
		Main.currentGameStatistics = null;
		//当前号码篮
		Main.currentGameOrder = null;
		//当前追号
		Main.currentGameTrace = null;
		//投注按钮
		Main.currentGameSubmit = null;
		//当前游戏消息类
		Main.currentGameMessage = null;



		//当前游戏
		Main.getCurrentGame = function(){
			return Main.currentGame;
		};
		Main.setCurrentGame = function(game){
			Main.currentGame = game;
		};

		//玩法切换
		Main.getCurrentGameTypes = function(){
			return Main.currentGameTypes;
		};
		Main.setCurrentGameTypes = function(currentGameTypes){
			Main.currentGameTypes = currentGameTypes;
		};

		//选号状态
		Main.getCurrentGameStatistics = function(){
			return Main.currentGameStatistics;
		};
		Main.setCurrentGameStatistics = function(gameStatistics){
			Main.currentGameStatistics = gameStatistics;
		};

		//号码篮
		Main.getCurrentGameOrder = function(){
			return Main.currentGameOrder;
		};
		Main.setCurrentGameOrder = function(currentGameOrder){
			Main.currentGameOrder = currentGameOrder;
		};

		//追号
		Main.getCurrentGameTrace = function(){
			return Main.currentGameTrace;
		};
		Main.setCurrentGameTrace = function(currentGameTrace){
			Main.currentGameTrace = currentGameTrace;
		};

		//投注提交
		Main.getCurrentGameSubmit = function(){
			return Main.currentGameSubmit;
		};
		Main.setCurrentGameSubmit = function(currentGameSubmit){
			Main.currentGameSubmit = currentGameSubmit;
		};

		//消息提示
		Main.getCurrentGameMessage = function(){
			return Main.currentGameMessage;
		};
		Main.setCurrentGameMessage = function(currentGameMessage){
			Main.currentGameMessage = currentGameMessage;
		};


	host[name] = Main;

})(dsgame, "Games");









//游戏类
//所有游戏应继承该类
(function(host, name, Event, undefined){
	var defConfig = {
		id:-1,
		//游戏名称
		name:'',
		//文件名前缀
		jsNameSpace:'dsgame.Games.SSC.',
		//添加事件代理的主面板
		eventProxyPanel:'body'
	},
	Games = host.Games;
	//将来仿url类型的参数转换为{}对象格式，如 q=wahaha&key=323444 转换为 {q:'wahaha',key:'323444'}
	//所有参数类型均为字符串
	var formatParam = function(param){
		var arr = $.trim(param).split('&'),i = 0,len = arr.length,
			paramArr,
			result = {};
		for(;i < len;i++){
			paramArr = arr[i].split('=');
			if(paramArr.length > 0){
				if(paramArr.length == 2){
					result[paramArr[0]] = paramArr[1];
				}else{
					result[paramArr[0]] = '';
				}
			}
		}
		return result;
	};


	var pros = {
		init:function(cfg){
			var me = this;
			me.setName(cfg.name);
			//设置当前游戏
			Games.setCurrentGame(me);

			me.setJsNameSpace(cfg.jsNameSpace);

			//资源加载缓存
			me.loadedHas = {};
			//当前使用的玩法
			me.currentGameMethod = null;

			me.addEvent('afterSwitchGameMethod', function(){
				Games.getCurrentGame().getCurrentGameMethod().reSet();

				//切换玩法时，针对当前玩法进行倍数限制设置
				var methodId = Games.getCurrentGame().getCurrentGameMethod().getId(),
					unit = Games.getCurrentGameStatistics().getMoneyUnit(),
					maxmultiple = Games.getCurrentGame().getGameConfig().getInstance().getLimitByMethodId(methodId, unit),
					multiple = Games.getCurrentGameStatistics().getMultip();
				multiple = multiple > maxmultiple ? maxmultiple : multiple;
				Games.getCurrentGameStatistics().setMultipleDom(multiple);
				//console.log(maxmultiple);
				/**
				//切换后获取对应的走势图
				Games.getCurrentGame().getCurrentGameMethod().updataGamesInfo();
				**/

			});
		},
		getId:function(){
			return this.id;
		},
		setId:function(id){
			this.id = id;
		},
		//从服务器端获取数据
		//返回数据格式
		//{"isSuccess":1,"type":"消息代号","msg":"返回的文本消息","data":{xxx:xxx}}
		getServerDynamicConfig:function(callback){
			var me = this,cfg = Games.getCurrentGame().getGameConfig().getInstance();
			/**
			//test
			var currentNumber = Number(cfg.getCurrentGameNumber()) + 1;
			var nowTime = (new Date()).getTime()/1000;
			var data = {currentNumber:'' + currentNumber, currentNumberTime:nowTime + (60 * 10), currentTime:nowTime, lotteryBalls:'' + Math.floor(Math.random()*(99999-11111))+11111, lastNumber:'140804064', gameNumbers:[]};
			//需要补全的属性有 lotteryBalls  lastNumber
			me.setDynamicConfig(data);
			return;
			**/

			$.ajax({
				url:cfg.getUpdateUrl(),
				dataType:'JSON',
				success:function(data){
					if(Number(data['isSuccess']) == 1){
						me.setDynamicConfig(data['data']);
						if($.isFunction(callback)){
							callback.call(me, data['data']);
						}
					}

				}
			});
		},
		//需要更新的数据{currentNumber:当前期号, currentNumberTime:本期开奖时间,currentTime: 当前时间, lotteryBalls:上期开奖号码, lastNumber:上期期号, gameNumbers:期号列表}
		setDynamicConfig:function(cfg){
			Games.getCurrentGame().getGameConfig().getInstance().updateConfig(cfg);
			this.fireEvent('changeDynamicConfig', cfg);
		},
		//事件代理，默认只监听鼠标点击事件，如需要监听其他事件，请在具体的游戏类中实现
		//例： <span data-param="action=doSelect&value=10">点击</span>
		eventProxy:function(){
			var me = this,cfg = me.defConfig,panel = $(cfg.eventProxyPanel),
				action = '';
			panel.click(function(e){
				var q = e.target.getAttribute('data-param'),param,gameMethod;
				if(q && $.trim(q) != ''){
					e.preventDefault();
					param = formatParam(q);
					gameMethod = me.getCurrentGameMethod();
					if(gameMethod){
						gameMethod.exeEvent(param, e.target);
					}
				}
			});
		},
		setLoadedHas:function(key, value){
			this.loadedHas[key] = value;
		},
		//获取玩法的实例对象
		getCacheMethod:function(id){
			var me = this,
				has = me.loadedHas,
				fullname_en = Games.getCurrentGame().getGameConfig().getInstance().getMethodFullNameById(id).join('.');
			if(has.hasOwnProperty(fullname_en)){
				return has[fullname_en];
			}
		},
		//切换游戏玩法
		switchGameMethod:function(id){
			var me = this,
				id = Number(id),
				has = me.loadedHas,
				obj,
				fullname_en = Games.getCurrentGame().getGameConfig().getInstance().getMethodFullNameById(id).join('.');
			//当前游戏即为将要切换的游戏则无需执行
			if(me.currentGameMethod && me.currentGameMethod.getId() == id){
				return;
			}
			if(has[fullname_en]){
				obj = has[fullname_en];
				me.fireEvent('beforeSwitchGameMethod');
				if(me.currentGameMethod){
					me.currentGameMethod.hide();
				}
				me.currentGameMethod = obj;
				obj.setId(id);
				obj.show();
				me.fireEvent('afterSwitchGameMethod');
			}else{
				me.setup(id, function(){
					me.fireEvent('beforeSwitchGameMethod');
					if(me.currentGameMethod){
						me.currentGameMethod.hide();
					}
					obj = me.getCacheMethod(id);
					obj.setId(id);
					obj.show();
					me.currentGameMethod = obj;
					me.fireEvent('afterSetup');
					me.fireEvent('afterSwitchGameMethod');
				});
			}
		},
		getCurrentGameMethod:function(){
			return this.currentGameMethod;
		},
		//id 玩法id
		setup:function(id, callback){
			var me = this,
				path = me.buildPath(id),
				fn = function(){},
				_callback;
			//获取最后一个参数作为回调函数
			_callback = arguments.length > 0 ? arguments[arguments.length - 1] : fn;
			if(!$.isFunction(_callback)){
				_callback = fn;
			}
			//加载脚本并缓存
			if(!me.isSetuped(id)){
				$.ajax({
					url:path,
					cache:false,
					dataType:'script',
					success:function(){
						me.loadedHas[path] = true;
						_callback.call(me);
					},
					error:function(xhr, type){
						alert('资源加载失败\n' + path + '\n错误类型：' + type);
					}
				});
			}
		},
		//拼接路径
		buildPath:function(id){
			var me = this,
				Cfg = Games.getCurrentGame().getGameConfig().getInstance(),
				path = Cfg.getJsPath(),
				name = Cfg.getMethodFullNameById(id).join('.'),
				nameSpace = me.getJsNamespace(),
				//拼接名称为路径，并剔除空参数(空参数为了适应没有三级分组的游戏)
				src = path + nameSpace + name + '.js';
			return src;
		},
		//检测某模块是否已安装
		isSetuped:function(id){
			var me = this,has = me.loadedHas,path = me.buildPath(id);
			return has.hasOwnProperty(path);
		},
		//直接设置某资源已经加载
		setSetuped:function(type, group, method){

		},
		setJsNameSpace:function(nameSpace){
			this.jsNameSpace = nameSpace;
		},
		getJsNamespace:function(){
			return this.jsNameSpace;
		},
		//返回该游戏的游戏配置
		//在子类中实现
		getGameConfig:function(){
		},
		getName:function(){
			return this.name;
		},
		setName:function(name){
			this.name = name
		},
		//对最后即将进行提交的数据进行处理
		//调用对应玩法的editSubmitData对将要提交的注单信息进行修改
		editSubmitData:function(data){
			var me = this,balls = data['balls'],it,method;
			$.each(balls, function(){
				it = this;
				method = me.getCacheMethod(it['wayId']);
				if(method){
					method.editSubmitData(it);
					it['viewBalls'] = '';
				}else{
					//如果遇到未知的玩法，则清空注单，本次提交失败
					alert('当前玩法文件未加载:' + it['type']);
					data['balls'] = [];
				}
			});
			data['balls'] = balls;
			return data;
		}

	};

	var Main = host.Class(pros, Event);
		Main.defConfig = defConfig;
	host[name] = Main;

})(dsgame, "Game", dsgame.Event);
//游戏方法类
//所有具体游戏实现应继承该类
(function(host, name, Event, undefined) {
	var defConfig = {
			id: -1,
			//如：'wuxing.zhixuan.fushi'
			name: '',
			//父容器
			UIContainer: '#J-balls-main-panel',
			//球dom元素选择器
			ballsDom: '.ball-number',
			//选球高亮class
			ballCurrentCls: 'ball-number-current',
			//玩法提示信息
			methodMassageDom: '.prompt .method-tip',
			//玩法提示信息
			methodExampleDom: '.prompt .example-tip',
			//限制选求重复次数
			randomBetsNum: 500
		},
		Games = host.Games;

	var pros = {
		init: function(cfg) {
			var me = this;

			me.id = cfg.id;
			me.name = cfg.name;

			//父容器
			me.UIContainer = $(cfg.UIContainer);
			//自身容器
			me.container = $('<div></div>').appendTo(me.UIContainer);
			me.buildUI();

			me.hide();

			//初始化数据结构
			me.balls = [];
			me.rebuildData();

			// 设置拆单（类型）
			// 0-不拆单，1-任二直选复式拆单，2-任二其他拆单
			me.setOrderSplitType('');

			//所有选球dom
			me.ballsDom = me.getBallsDom();
			//当前选球是否完整
			me.isBallsComplete = false;

			//由于玩法是异步延后加载并实例化，所以与其他组件的结合不能提取到外部
			//选球数据更改后触发动作
			me.addEvent('updateData', function(e, data) {
				//更新统计
				var me = this,
					data = me.isBallsComplete ? data : {
						'lotterys': [],
						'original': []
					};
				Games.getCurrentGameStatistics().updateData(data, me.getName());
				//更新选球界面
				me.batchSetBallDom();
			});

			//面板复位时执行批量选求状态清空
			me.addEvent('afterReset', function() {
				me.exeEvent_cancelCurrentButton();
			})

			//选球动作结束执行批量选求状态清空
			me.addEvent('afterSetBallData', function(e, x, y, v) {
				me.exeEvent_cancelCurrentButton(x, y, v);
			});
		},
		getId: function() {
			return this.id;
		},
		setId: function(id) {
			this.id = Number(id);
		},
		getOrderSplitType: function() {
			return this.orderSplitType;
		},
		setOrderSplitType: function(type) {
			this.orderSplitType = type;
		},
		//获取选球dom元素，保存结构和选球数据(me.balls)一致
		getBallsDom: function() {
			var me = this,
				cfg = me.defConfig,
				dataMode = me.balls;
			if (dataMode.length < 1) {
				return [];
			}
			return me.ballsDom || (function() {
				var balls = me.container.find(cfg.ballsDom),
					len,
					num = 0,
					i = 0,
					row,
					result = [],
					it;
				$.each(dataMode, function(i) {
					row = this;
					result[i] = [];
					$.each(row, function(j) {
						result[i][j] = balls[num];
						num++;
					});
				});
				return result;
			})();
		},
		//游戏类型切换后
		//游戏相关信息的更新方法
		updataGamesInfo: function() {
			var me = this,
				type = me.getGameMethodName(),
				currentGame = Games.getCurrentGame(),
				freCacheName = type + 'lostcurrentFre',
				//url = ctx + '/gameBet/historyballs?type=' + type + '&extent=currentFre&line=5&lenth=30';
				url = 'simulatedata/getBetAward.php?type=' + type + '&extent=currentFre&line=5&lenth=30&lotteryid=99101&userid=31';

			if (!Games.cacheData['gameBonus']) {
				Games.cacheData['gameBonus'] = {};
			}
			if (!Games.cacheData['gameTips']) {
				Games.cacheData['gameTips'] = {};
			}
			if (!Games.cacheData['frequency']) {
				Games.cacheData['frequency'] = {};
			}

			//奖金组
			if (Games.cacheData['gameBonus'][url]) {
				currentGame.addDynamicBonus(type, Games.cacheData['gameBonus'][url]);
			}
			if (Games.cacheData['gameTips'][url]) {
				me.methodTip(Games.cacheData['gameTips'][url]);
			}
			//冷热号缓存
			//缓存名称必须和手动加载的一致
			if (Games.cacheData['frequency'][freCacheName]) {
				me.getHotCold(type, 'currentFre', 'lost');
			}
			//验证缓存
			//禁止异步请求数据
			if (Games.cacheData['gameBonus'][url] && Games.cacheData['frequency'][freCacheName] && Games.cacheData['gameTips'][url]) {
				return
			};
			//获取游戏相关数据
			$.ajax({
				url: url,
				dataType: 'json',
				success: function(result) {
					if (Number(result['isSuccess']) == 1) {
						data = result['data'];

						//游戏玩法提示
						if (typeof data['gameTips'] != 'undefined') {
							Games.cacheData['gameTips'][url] = data.gameTips;
							me.methodTip(data.gameTips);
						}
						//冷热号
						if (typeof data['frequency'] != 'undefined') {
							Games.cacheData['frequency'][freCacheName] = data['frequency'];
							me.getHotCold(type, 'currentFre', 'lost');
						}
						//奖金组
						if (typeof data['bonus'] != 'undefined') {
							Games.cacheData['gameBonus'][url] = data['bonus'];
							currentGame.addDynamicBonus(type, data['bonus']);
						}
					} else {

					}
				}
			})
		},
		//修改玩法提示方法
		methodTip: function(data) {
			var me = this,
				cfg = me.defConfig;
			//玩法提示
			$(cfg.methodMassageDom).html(data.tips);
			//玩法实例
			$(cfg.methodExampleDom).html(data.example);
		},
		//format balls for view
		formatViewBalls: function(original) {
			var me = this,
				result = [],
				len = original.length,
				i = 0;
			for (; i < len; i++) {
				result = result.concat(original[i].join(''));
			}
			return result.join('|');
		},
		//生成原始选球数据(不拆分成单注)
		//返回字符串形式的原始选球数字
		//在子类中实现/覆盖
		makePostParameter: function(original) {
			var me = this,
				result = [],
				len = original.length,
				i = 0;
			for (; i < len; i++) {
				result = result.concat(original[i].join(''));
			}
			return result.join('|');
		},
		//检查数组存在某数
		arrIndexOf: function(value, arr) {
			var r = 0;
			for (var s = 0; s < arr.length; s++) {
				if (arr[s] == value) {
					r += 1;
				}
			}
			return r || -1;
		},
		//重新构建选球数据
		//在子类中实现
		rebuildData: function() {

		},
		getBallData: function() {
			return this.balls;
		},
		//设置选球数据
		//x y value   x y 为选球数据二维数组的坐标 value 为-1 或1
		setBallData: function(x, y, value) {
			var me = this,
				data = me.getBallData();
			me.fireEvent('beforeSetBallData', x, y, value);
			if (x >= 0 && x < data.length && y >= 0) {
				data[x][y] = value;
			}
			me.fireEvent('afterSetBallData', x, y, value);
		},
		//设置遗漏冷热辅助
		//x y value   x y 为选球数据二维数组的坐标 value 为-1 或1
		//classname为冷热选球所需要的高亮效果
		setBallAidData: function(x, y, value, className) {
			var me = this,
				currentName = 'ball-aid',
				data = me.getBallsAidDom(),
				className = className ? currentName + ' ' + className : currentName;
			if (x >= 0 && x < data.length && y >= 0 && y < data[0].length) {
				data[x][y].innerHTML = value;
				data[x][y].className = className;
			}
		},
		//复位
		reSet: function() {
			var me = this;
			me.isBallsComplete = false;
			me.rebuildData();
			me.updateData();
			me.fireEvent('afterReset');
		},
		//获取该玩法的名称
		getName: function() {
			return this.name;
		},
		setName: function(name) {
			this.name = name;
		},
		//显示该游戏玩法
		show: function() {
			var me = this;
			me.fireEvent('beforeShow');
			me.container.show();
			me.fireEvent('afterShow');
		},
		//隐藏该游戏玩法
		hide: function() {
			var me = this;
			me.fireEvent('beforeHide');
			me.container.hide();
			me.fireEvent('afterHide');
		},
		//实现事件
		exeEvent: function(param, target) {
			var me = this;
			if ($.isFunction(me['exeEvent_' + param['action']])) {
				me['exeEvent_' + param['action']].call(me, param, target);
			}
		},
		//批量选球事件
		exeEvent_batchSetBall: function(param, target) {
			var me = this,
				ballsData = me.balls,
				x = Number(param['row']),
				bound = param['bound'],
				row = ballsData[x],
				i = 0,
				len = row.length,
				makearr = [],
				start = (typeof param['start'] == 'undefined') ? 0 : Number(param['start']);
			halfLen = Math.ceil((len - start) / 2 + start),
			dom = $(target),
			i = start;
			//清空该行选球
			for (; i < len; i++) {
				me.setBallData(x, i, -1);
			}

			switch (bound) {
				case 'all':
					for (i = start; i < len; i++) {
						me.setBallData(x, i, 1);
					}
					break;
				case 'big':
					for (i = halfLen; i < len; i++) {
						me.setBallData(x, i, 1);
					}
					break;
				case 'small':
					for (i = start; i < halfLen; i++) {
						me.setBallData(x, i, 1);
					}
					break;
				case 'odd':
					for (i = start; i < len; i++) {
						if ((i + 1) % 2 != 1) {
							me.setBallData(x, i, 1);
						}
					}
					break;
				case 'even':
					for (i = start; i < len; i++) {
						if ((i + 1) % 2 == 1) {
							me.setBallData(x, i, 1);
						}
					}
					break;
				case 'none':
					break;
				default:
					break;
			}

			dom.addClass('current');
			me.updateData();
		},
		//取消选球状态
		//参数：x为纵坐标 y为横坐标 v为修改值
		exeEvent_cancelCurrentButton: function(x, y, v) {

			var me = this,
				container = me.container,
				control = (typeof x != 'undefined') ? container.find('.ball-control').eq(x) : container.find('.ball-control');

			control.find('a').removeClass('current');
		},
		//选球事件
		//球参数 action=ball&value=2&row=0  表示动作为'选球'，球值为2，行为第1行(万位)
		//函数名称： exeEvent_动作名称
		exeEvent_ball: function(param, target) {
			var me = this,
				el = $(target),
				currCls = me.defConfig.ballCurrentCls;
			//必要参数
			if (param['value'] != undefined && param['row'] != undefined) {
				if (el.hasClass(currCls)) {
					//取消选择
					me.setBallData(Number(param['row']), Number(param['value']), -1);
				} else {
					me.fireEvent('beforeSelect', param);
					//选择
					me.setBallData(Number(param['row']), Number(param['value']), 1);
				}
			} else {
				try {
					// console.log('GameMethod.exeEvent_ball: lack param');
				} catch (ex) {}
			}
			me.updateData();
		},
		//渲染球dom元素的对应状态
		batchSetBallDom: function() {
			var me = this,
				cfg = me.defConfig,
				cls = cfg.ballCurrentCls,
				balls = me.balls,
				i = 0,
				j = 0,
				len = balls.length,
				len2 = 0,
				ballsDom = me.getBallsDom(),
				_cls = '';
			//同步选球数据和选球dom
			//...
			for (; i < len; i++) {
				len2 = balls[i].length;
				for (j = 0; j < len2; j++) {
					if (balls[i][j] == 1) {
						_cls = ballsDom[i][j].className;
						_cls = (' ' + _cls + ' ').replace(' ' + cls, '');
						_cls += ' ' + cls;
						ballsDom[i][j].className = _cls.replace(/\s+/g, ' ');
					} else {
						_cls = ballsDom[i][j].className;
						_cls = (' ' + _cls + ' ').replace(' ' + cls, '');
						ballsDom[i][j].className = _cls.replace(/\s+/g, ' ');
					}
				}
			}
		},
		//当选球/取消发生，更新相关数据
		updateData: function() {
			var me = this,
				lotterys = me.getLottery();
			//通知其他模块更新
			me.fireEvent('updateData', {
				'lotterys': lotterys,
				'original': me.getOriginal()
			});
		},
		//在最后提交数据之前对该玩法的提交数据进行替换处理
		//data 该玩法的单注信息
		editSubmitData: function(data) {

		},
		getOriginal: function() {
			var me = this,
				balls = me.getBallData(),
				len = balls.length,
				len2 = 0,
				i = 0,
				j = 0,
				row = [],
				result = [];
			for (; i < len; i++) {
				row = [];
				len2 = balls[i].length;
				for (j = 0; j < len2; j++) {
					if (balls[i][j] > 0) {
						row.push(j);
					}
				}
				result.push(row);
			}
			return result;
		},
		//根据下注反选球
		reSelect: function(original) {
			var me = this,
				type = me.getName(),
				ball = original,
				i,
				len,
				j,
				len2,
				x,
				y,
				isFlag = false;

			//console.log(original);

			me.reSet();

			for (i = 0, len = ball.length; i < len; i++) {
				for (j = 0, len2 = ball[i].length; j < len2; j++) {
					x = i;
					y = ball[i][j];
					me.setBallData(x, y, 1);
					isFlag = true;
				}
			}
			if (isFlag) {
				me.updateData();
			}
		},
		//获取总注数/获取组合结果
		//isGetNum=true 只获取数量，返回为数字
		//isGetNum=false 获取组合结果，返回结果为单注数组
		getLottery: function(isGetNum) {
			var me = this,
				data = me.getBallData(),
				i = 0,
				len = data.length,
				row, isEmptySelect = true,
				_tempRow = [],
				j = 0,
				len2 = 0,
				result = [],
				//总注数
				total = 1,
				rowNum = 0;
			//检测球是否完整
			for (; i < len; i++) {
				result[i] = [];
				row = data[i];
				len2 = row.length;
				isEmptySelect = true;
				rowNum = 0;
				for (j = 0; j < len2; j++) {
					if (row[j] > 0) {
						isEmptySelect = false;
						//需要计算组合则推入结果
						if (!isGetNum) {
							result[i].push(j);
						}
						rowNum++;
					}
				}
				if (isEmptySelect) {
					//alert('第' + i + '行选球不完整');
					me.isBallsComplete = false;
					return [];
				}
				//计算注数
				total *= rowNum;
			}
			me.isBallsComplete = true;
			//返回注数
			if (isGetNum) {
				return total;
			}
			if (me.isBallsComplete) {
				//组合结果
				return me.combination(result);
			} else {
				return [];
			}
		},
		//单组去重处理
		removeSame: function(data) {
			var i = 0,
				result, me = this,
				numLen = this.getBallData()[0].length,
				len = data.length;
			result = Math.floor(Math.random() * numLen);
			for (; i < data.length; i++) {
				if (result == data[i]) {
					return arguments.callee.call(me, data);
				}
			}
			return result;
		},
		//移除一维数组的重复项
		removeArraySame: function(arr) {
			var me = this,
				i = 0,
				result,
				numLen = me.getBallData()[0].length,
				len = data.length;

			result = Math.floor(Math.random() * numLen);
			for (; i < arr.length; i++) {
				if (result == arr[i]) {
					return arguments.callee.call(me, arr);
				}
			}
			return result;
		},
		getRandomBetsNum: function() {
			return this.defConfig.randomBetsNum;
		},
		//生成单注随机数
		createRandomNum: function() {
			var me = this,
				current = [],
				len = me.getBallData().length,
				rowLen = me.getBallData()[0].length;
			//随机数
			for (var k = 0; k < len; k++) {
				current[k] = [Math.floor(Math.random() * rowLen)];
				current[k].sort(function(a, b) {
					return a > b ? 1 : -1;
				});
			};
			return current;
		},
		//限制随机投注重复
		checkRandomBets: function(hash, times) {
			var me = this,
				allowTag = typeof hash == 'undefined' ? true : false,
				hash = hash || {},
				current = [],
				times = times || 0,
				len = me.getBallData().length,
				rowLen = me.getBallData()[0].length,
				order = Games.getCurrentGameOrder().getTotal()['orders'];

			//生成单数随机数
			current = me.createRandomNum();
			//如果大于限制数量
			//则直接输出
			if (Number(times) > Number(me.getRandomBetsNum())) {
				return current;
			}
			//建立索引
			if (allowTag) {
				for (var i = 0; i < order.length; i++) {
					if (order[i]['type'] == me.defConfig.name) {
						var name = order[i]['original'].join('');
						hash[name] = name;
					}
				};
			}
			//对比结果
			if (hash[current.join('')]) {
				times++;
				return arguments.callee.call(me, hash, times);
			}
			return current;
		},
		//生成一个当前玩法的随机投注号码
		//该处实现复式，子类中实现其他个性化玩法
		//返回值： 按照当前玩法生成一注标准的随机投注单(order)
		randomNum: function() {
			var me = this,
				i = 0,
				current = [],
				currentNum,
				ranNum,
				order = null,
				dataNum = me.getBallData(),
				name = me.defConfig.name,
				name_en = Games.getCurrentGame().getCurrentGameMethod().getGameMethodName(),
				lotterys = [],
				original = [];

			current = me.checkRandomBets();
			original = current;
			lotterys = me.combination(original);

			order = {
				'type': name_en,
				'original': original,
				'lotterys': lotterys,
				'moneyUnit': Games.getCurrentGameStatistics().getMoneyUnit(),
				'multiple': Games.getCurrentGameStatistics().getMultip(),
				'onePrice': Games.getCurrentGame().getGameConfig().getInstance().getOnePrice(name_en),
				'num': lotterys.length
			};
			order['amountText'] = Games.getCurrentGameStatistics().formatMoney(order['num'] * order['moneyUnit'] * order['multiple'] * order['onePrice']);
			return order;
		},
		//生成指定数目的随机投注号码，并添加进号码篮
		randomLotterys: function(num) {
			var me = this,
				i = 0;
			Games.getCurrentGameOrder().cancelSelectOrder();
			for (; i < num; i++) {
				Games.getCurrentGameOrder().add(me.randomNum());
			}
		},
		//游戏错误提示
		//主要用于进行单式投注错误提示
		//具体实现在子类中的单式投注玩法
		ballsErrorTip: function() {

		},
		//计算当前选中的球数量
		countBallsNum: function() {
			var me = this,
				num = 0,
				ball = me.getBallData();

			for (var i = ball.length - 1; i >= 0; i--) {
				if (Object.prototype.toString.call(ball[i]) == '[object Array]' && ball[i].length > 0) {
					for (var j = ball[i].length - 1; j >= 0; j--) {
						if (ball[i][j] == 1) {
							num++;
						};
					};
				} else {
					if (ball[i] == 1) {
						num++;
					}
				}
			};

			return num;
		},
		//计算当前选中的球数量
		//限制计算某一单行内球数量
		countBallsNumInLine: function(lineNum) {
			var me = this,
				num = 0,
				ball = me.getBallData();


			if (Object.prototype.toString.call(ball[lineNum]) == '[object Array]' && ball[lineNum].length > 0) {
				for (var j = ball[lineNum].length - 1; j >= 0; j--) {
					if (ball[lineNum][j] == 1) {
						num++;
					};
				};
			} else {
				if (ball[lineNum] == 1) {
					num++;
				}
			}

			return num || -1;
		},
		//是否超出限制选球数量
		LimitMaxBalls: function(limitNum) {
			var me = this,
				num = 0,
				ball = me.getBallData(),
				ballCount = Number(num);

			//当前选中的球数量
			num = me.countBallsNum();

			if (num > limitNum) {
				return true;
			} else {
				return false;
			}
		},
		//检测选球是否完整，是否能形成有效的投注
		//并设置 isBallsComplete
		checkBallIsComplete: function() {
			var me = this,
				data = me.getBallData(),
				i = 0,
				len = data.length,
				row, isEmptySelect = true,
				j = 0,
				len2 = 0;

			//检测球是否完整
			for (; i < len; i++) {
				row = data[i];
				len2 = row.length;
				isEmptySelect = true;
				for (j = 0; j < len2; j++) {
					if (row[j] > 0) {
						isEmptySelect = false;
					}
				}
				if (isEmptySelect) {
					//alert('第' + i + '行选球不完整');
					me.isBallsComplete = false;
					return false;
				}
			}
			return me.isBallsComplete = true;
		},

		//单行数组的排列组合
		//list 参与排列的数组
		//num 每组提取数量
		//last 递归中间变量
		combine: function(list, num, last) {
			var result = [],
				i = 0;
			last = last || [];
			if (num == 0) {
				return [last];
			}
			for (; i <= list.length - num; i++) {
				result = result.concat(arguments.callee(list.slice(i + 1), num - 1, last.slice(0).concat(list[i])));
			}
			return result;
		},
		//二维数组的排列组合
		//arr2 二维数组
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
		//创建投注界面的小走势图
		miniTrend_create:function(){
			var me = this,
				html = [],
				dom;
			html.push( me.miniTrend_createHeadHtml())
			html.push(me.miniTrend_createRowHtml())
			html.push(me.miniTrend_createFootHtml());

			dom = $(html.join(''));
			me.miniTrend_getContainer().prepend(dom);

			return dom;
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
				html = [];
			$.each(data, function(i){
				item = this;
				trcls = '';
				trcls = i == 0 ? 'first' : trcls;
				trcls = i == dataLen - 1 ? 'last' : trcls;
				var number = (item['wn_number'].indexOf(" ")==-1 ) ? item['wn_number'].split(""): item['wn_number'].split(" ");
				html.push('<tr class="'+ trcls +'">');
					html.push('<td><span class="number">'+ item['issue'].substr(2) +' 期</span></td>');
					html.push('<td><span class="balls">');

					$.each(number, function(j){
						html.push('<i class='+ currCls +'>' + this + '</i>');
					});

					html.push('</span></td>');
				html.push('</tr>');
			});
			return html.join('');
		},
		miniTrend_createFootHtml:function(){
			var me = this,
				html = [];
				html.push('</tbody>');
				html.push('</table>');
			return html.join('');
		},
		//切换或更新走势图
		miniTrend_updateTrend:function(){
			var me = this,tbody = me.miniTrend_getTrendTable().find('tbody');

			tbody.html(me.miniTrend_createRowHtml());

			me.miniTrend_getContainer().find('.bet-table-trend').hide();
			me.miniTrend_getTrendTable().show();
		},
		miniTrend_getTrendTable:function(){
			var me = this,id = this.getId(),pageDom = $('#J-minitrend-trendtable-' + id);
			if(pageDom.size() > 0){
				return pageDom;
			}else{
				return me.miniTrend_create();
			}
		},
		miniTrend_getContainer:function(){
			return this.miniTrendContainer || (this.miniTrendContainer = $('#J-minitrend-cont'));
		},
		//获取最新的开奖数据
		miniTrend_getBallsData:function(){
			var me = this,
				data =gameConfigData['issueHistory'],
				cfg = data['issues'];
				if(cfg[0]['issue'] == data['last_number']['issue']){
					if( cfg[0]['wn_number'] == '' && data['last_number']['wn_number'] != ''){
						cfg[0]['wn_number'] = data['last_number']['wn_number']
						// console.log(data['last_number']['wn_number'] +'最后一期的开奖号')
					}else if( cfg[0]['wn_number'] != '' && data['last_number']['wn_number'] == ''){
						data['last_number']['wn_number'] = cfg[0]['wn_number']
						// console.log(data['last_number']['wn_number']+'最后一期的开奖号')
					};
				}

			return cfg;
		},
		//更新完整走势图链接
		miniTrend_updateTrendUrl:function(){

		}

	};

	var Main = host.Class(pros, Event);
	Main.defConfig = defConfig;
	host[name] = Main;

})(dsgame, "GameMethod", dsgame.Event);

//消息
;(function(host, name, Event,undefined){
	var defConfig = {
			//彩种休市提示
			lotteryClose : ['<div class="bd text-center">',
							'<p class="text-title text-left">非常抱歉，本彩种已休市。<br />请与<#=orderDate#>后再购买</p>',
							'<div class="lottery-numbers text-left">',
								'<div class="tltle"><#=lotteryName#> 第<strong class="color-green"><#=lotteryPeriods#></strong>期开奖号码：</div>',
								'<div class="content">',
									'<#=lotterys#>',
									'<a href="#">查看更多&raquo;</a>',
								'</div>',
							'</div>',
							'<dl class="lottery-list">',
								'<dt>您可以购买以下彩种</dt>',
								'<#=lotteryType#>',
							'</dl>',
						'</div>'].join(''),

			//投注信息核对
			checkLotters : ['<div class="bd game-submit-confirm-cont">',
									'<p class="game-submit-confirm-title">',
										'<label class="ui-label">彩种：<#=lotteryName#></label>',
										'<br/><label class="ui-label" style="display:none;" id="issue-for-print">奖期：<#=lotteryIssue#></label>',
									'</p>',
									'<ul class="ui-form">',
										'<li>',
											'<div class="textarea" id="project-for-print">',
												'<#=lotteryInfo#>',
											'</div>',
										'</li>',
										'<li class="game-submit-confirm-tip">',
											'<label class="ui-label">付款总金额：<span class="color-red"><#=lotteryamount#></span>元</label>',
										'</li>',
										// '<li class="game-submit-confirm-tip">',
										// 	'<label class="ui-label">所选奖金组：<span class="color-red"><#=lotterOptionalPrizes#></span></label>',
										// '</li>',
									'</ul>',
							'</div>'].join(''),

			//未到销售时间
			nonSaleTime : ['<div class="bd text-center">',
							'<p class="text-title text-left">非常抱歉，本彩种未到销售时间。<br />请与<#=orderDate#>后再购买</p>',
							'<dl class="lottery-list">',
								'<dt>您可以购买以下彩种</dt>',
								'<#=lotteryType#>',
							'</dl>',
						'</div>'].join(''),

			//正常提示
			normal : ['<div class="bd text-center">',
								'<div class="pop-waring">',
									'<i class="ico-waring <#=icon-class#>"></i>',
									'<h4 class="pop-text"><#=msg#><br /></h4>',
								'</div>',
							'</div>'].join(''),

			//无效字符提示
			invalidtext : ['<div class="bd text-center">',
								'<div class="pop-waring">',
									'<i class="ico-waring <#=icon-class#>"></i>',
									'<h4 class="pop-text"><#=msg#><br /></h4>',
								'</div>',
							'</div>'].join(''),

			//投注过期提示
			betExpired : ['<div class="bd text-center">',
								'<div class="pop-waring">',
									'<i class="ico-waring <#=icon-class#>"></i>',
									'<h4 class="pop-text"><#=msg#><br /></h4>',
								'</div>',
							'</div>'].join(''),

			//倍数超限
			multipleOver : ['<div class="bd text-center">',
								'<div class="pop-waring">',
									'<i class="ico-waring <#=icon-class#>"></i>',
									'<h4 class="pop-text"><#=msg#><br /></h4>',
								'</div>',
							'</div>'].join(''),

			//暂停销售
			pauseBet : ['<div class="bd text-center">',
								'<div class="pop-waring">',
									'<i class="ico-waring <#=icon-class#>"></i>',
									'<h4 class="pop-text"><#=msg#><br /></h4>',
								'</div>',
							'</div>'].join(''),
			//成功提示
			successTip : ['<div class="bd text-center">',
								'<div class="pop-title">',
									'<i class="ico-success <#=icon-class#>"></i>',
									'<h4 class="pop-text"><#=msg#><br /></h4>',
								'</div>',
								'<p class="text-note" style="padding:5px 0;">您可以通过”<a href="<#=link#>" target="_blank">游戏记录</a>“查询您的投注记录！</p>',
							'</div>'].join(''),
			//部分投注成功
			betPart : ['<div class="bd text-center">',
							'<div class="pop-title">',
								'<i class="ico-error"></i>',
								'<h4 class="pop-text"><#=msg#></h4>',
							'</div>',
						'</div>'].join(''),
			//提醒选求提示
			checkBalls : ['<div class="bd text-center">',
							'<div class="pop-title">',
								'<i class="ico-waring <#=iconClass#>"></i>',
								'<h4 class="pop-text">请至少选择一注投注号码！</h4>',
							'</div>',
							'<div class="pop-btn ">',
								'<a href="javascript:void(0);" class="btn closeBtn">关 闭<b class="btn-inner"></b></a>',
							'</div>',
						'</div>'].join(''),
			//错误提示
			errorTip : ['<div class="bd text-center">',
							'<div class="pop-title">',
								'<i class="ico-error"></i>',
								'<h4 class="pop-text"><#=msg#></h4>',
							'</div>',
						'</div>'].join(''),
			//封锁变价
			blockade : ['<div class="bd panel-game-msg-blockade" id="J-blockade-panel-main">',
							'<form id="J-form-blockade-detail" action="ssc-blockade-detail.php" target="_blank" method="post"></form>',
							'<div class="game-msg-blockade-text">存在<#=blockadeType#>内容，系统已为您做出 <a href="#" data-action="blockade-detail">最佳处理</a> ，点击<span class="color-red">“确认”</span>完成投注</div>',
							'<div>',
								'<div class="game-msg-blockade-line-title">彩种：<#=gameTypeTitle#></div>',
								'<div class="game-msg-blockade-line-title">期号：<#=currentGameNumber#></div>',
							'</div>',
							'<div id="J-game-panel-msg-blockade-0">',
								'<div class="game-msg-blockade-cont" id="J-msg-panel-submit-blockade-error0"><#=blockadeData0#></div>',
							'</div>',
							'<div class="game-msg-blockade-panel-money">',
								'<div><b>付款总金额：</b><span class="color-red"><b id="J-money-blockade-adjust"><#=amountAdjust#></b></span> 元&nbsp;&nbsp;&nbsp;&nbsp;<span style="display:<#=display#>"><b>减少投入：</b><span class="color-red"><b id="J-money-blockade-change"><#=amountChange#></b></span> 元</span></div>',
								'<div><b>付款账号：</b><#=username#></div>',
							'</div>',
							'<div>',
								'<p class="text-note">购买后请您尽量避免撤单，如撤单将收取手续费：￥<span class="handlingCharge">0.00</span>元</p>',
								'<p class="text-note">本次投注，若未涉及到付款金额变化，将不再提示</p>',
							'</div>',
						'</div>'].join(''),
			//user type is proty or other,just player allowed to bet
			userTypeError:['<div class="bd text-center">',
							'<div class="pop-title">',
								'<i class="ico-error"></i>',
								'<h4 class="pop-text">对不起，仅玩家允许投注</h4>',
							'</div>',
						'</div>'].join('')
		},
	instance,
	closeTime = null,
	Games = host.Games;

	var pros = {
		//初始化
		init: function(cfg){
			var me = this;
			me.win = new host.MiniWindow({
				//实例化时追加的最外层样式名
				cls:'pop w-9'
			});
			me.mask = host.Mask.getInstance();
			//绑定隐藏完成事件
			me.reSet();
			me.win.addEvent('afterHide', function(){
				me.reSet();
			})
		},
		//彩种提示类型
		doAction: function(data){
			var me = this,
				funName = 'rebuild' + data['type'],
				getHtml = 'getHtml' + data['type'],
				fn = function(){
				};
			//'-' is not allowed to be a function name
			getHtml = getHtml.replace('-', '_');
			funName = funName.replace('-', '_');

			//console.log(getHtml);
			//console.log(funName);

			if(me[funName] && $.isFunction(me[funName])){
				fn = me[funName];
			}
			data['tpl']  = typeof data['tpl'] == 'undefined' ? me[getHtml]() : '' + data['tpl'];
			//删除type数据
			//防止在渲染的时候进行递归调用
			delete data['type'];
			//调用子类方法
			fn.call(me, data);
		},
		formatHtml:function(tpl, order){
			var me = this,o = order,p,reg;
			for(p in o){
				if(o.hasOwnProperty(p)){
					reg = RegExp('<#=' + p + '#>', 'g');
					tpl = tpl.replace(reg, o[p]);
				}
			}
			return tpl;
		},
		//检查数组存在某数
		arrIndexOf: function(value, arr){
		    var r = 0;
		    for(var s=0; s<arr.length; s++){
		        if(arr[s] == value){
		            r += 1;
		        }
		    }
		    return r || -1;
		},
		//common error tip
		getHtmlerrorTip :function(){
			var cfg = this.defConfig;
			return cfg.errorTip;
		},
		rebuilderrorTip :function(parameter){
			var me = this, result = {};
				result['mask'] = true;
				result['closeText'] = '关 闭';
				result['closeIsShow'] = true;
				result['closeFun'] = function(){
					me.hide()
				};
				result['content'] = me.formatHtml(parameter['tpl'], parameter['data']['tplData']);
				me.show($.extend(result, parameter));
		},
		// 部分投注成功
		getHtmlbet_part :function(){
			var cfg = this.defConfig;
			return cfg.betPart;
		},
		rebuildbet_part :function(parameter){
			var me = this, result = {};
				result['mask'] = true;
				result['closeText'] = '关 闭';
				result['closeIsShow'] = true;
				result['closeFun'] = function(){
					me.hide()
				};
				result['content'] = me.formatHtml(parameter['tpl'], parameter['data']['tplData']);
				me.show($.extend(result, parameter));
		},		
		//通用
		getHtmlWaring: function(){
			var cfg = this.defConfig;
			return cfg.normal;
		},
		//默认弹窗
		rebuildnormal: function(parameter){
			var me = this, result = {};
				result['mask'] = true;
				result['closeText'] = '关 闭';
				result['closeIsShow'] = true;
				result['closeFun'] = function(){
					me.hide()
				};
				result['content'] = me.formatHtml(parameter['tpl'], parameter['data']['tplData']);
				me.show($.extend(result, parameter));
		},
		//获取默认提示弹窗
		getHtmlnormal: function(){
			return this.getHtmlWaring();
		},
		rebuildlow_balance:function(parameter){
			var me = this, result = {};
				result['mask'] = true;
				result['iconClass'] = '';
				result['closeIsShow'] = true;
				result['closeFun'] = function(){
					me.hide();
				};
				result['content'] = me.formatHtml(parameter['tpl'], parameter['data']['tplData']);
				me.show($.extend(result, parameter));
		},
		getHtmllow_balance:function(){
			return this.getHtmlWaring();
		},
		//issue_error
		rebuildissue_error:function(parameter){
			var me = this, result = {};
				result['mask'] = true;
				result['iconClass'] = '';
				result['closeIsShow'] = true;
				result['closeFun'] = function(){
					me.hide();
				};
				result['content'] = me.formatHtml(parameter['tpl'], parameter['data']['tplData']);
				me.show($.extend(result, parameter));
		},
		getHtmlissue_error:function(){
			return this.getHtmlWaring();
		},
		//bet failed
		rebuildbet_failed:function(parameter){
			var me = this, result = {};
				result['mask'] = true;
				result['iconClass'] = '';
				result['closeIsShow'] = true;
				result['closeFun'] = function(){
					me.hide();
				};
				result['content'] = me.formatHtml(parameter['tpl'], parameter['data']['tplData']);
				me.show($.extend(result, parameter));
		},
		getHtmlbet_failed:function(){
			return this.getHtmlWaring();
		},
		/*
			//彩种核对
			dsgame.Games.getCurrentGameMessage().show({
			   type : 'checkLotters',
			   data : {
			   		tplData : {
				   		//当期彩票详情
				        lotteryDate : '20121128-023',
				        //彩种名称
				        lotteryName : 'shishicai',
				        //投注详情
				        lotteryInfo : ,
				        //彩种金额
				        lotteryamount : {'year':'2013','month':'5','day':'3','hour':'1','min':'30'},
				        //付款账号
				        lotteryAcc :，
				       	//手续费
				       	lotteryCharge
			   		}
				}
			})
		 */
		rebuildcheckLotters : function(parameter){
			var me = this,
				// order = Games.getCurrentGameOrder().getTotal()['orders'],
				result = {};
				result['mask'] = true;
				result['iconClass'] = '';
				result['title'] = '投注确认';

				// //彩种名称
				// parameter['data']['tplData']['lotteryName'] = function(){
				// 	return lotteryName || '';
				// };
				// //本次开奖期数
				// parameter['data']['tplData']['lotteryPeriods'] = function(){
				// 	return lotteryPeriods || '';
				// };
				// //购买日期
				// parameter['data']['tplData']['orderDate'] = function(){
				// 	return time['year'] + '年' + time['month'] + '月' + time['day'] + '日 ' + time['hour'] + ':' + time['min'];
				// };
				// //彩票详情
				// parameter['data']['tplData']['lotterys'] = function(){
				// 	var html  = '';
				// 	if($.isArray(lotterys)){
				// 		for (var i = 0; i < lotterys.length; i++) {
				// 			html += '<em>' + lotterys[i] + '</em>';
				// 		};
				// 	}
				// 	return html;
				// };
				// //彩票种类
				// parameter['data']['tplData']['lotteryType'] = function(){
				// 	var html  = '';
				// 	if($.isArray(typeArray)){
				// 		for (var i = 0; i < typeArray.length; i++) {
				// 			html += '<dd><span style="background:url(' + typeArray[i]['pic'] +')" class="pic" title="' + typeArray[i]['name'] + '" alt="' + typeArray[i]['name'] + '"></span><a href="' + typeArray[i]['url'] + '" class="btn">去投注<b class="btn-inner"></b></a></dd>';
				// 		};
				// 	}
				// 	return html;
				// };
				result['content'] = me.formatHtml(parameter['tpl'], parameter['data']['tplData']);
				me.show($.extend(result, parameter));
		},
		getHtmlcheckLotters : function(){
			var cfg = this.defConfig;
			return cfg.checkLotters;
		},
		/*
			//彩种关闭调用实例
			dsgame.Games.getCurrentGameMessage().show({
			   type : 'lotteryClose',
			   data : {
			   		tplData : {
				   		//当期彩票详情
				        lotterys : [1,2,3,4,5,6],
				        //彩种名称
				        lotteryName : 'shishicai',
				        //开奖期数
				        lotteryPeriods : '20130528-276',
				        //开始购买时间
				        orderDate : {'year':'2013','month':'5','day':'3','hour':'1','min':'30'},
				        //提示彩票种类
				        lotteryType : [{'name':'leli','pic':'#','url':'http://163.com'},{'name':'kuaile8','pic':'#','url':'http://pp158.com'}]
			   		}
				}
			})
		 */
		//彩种关闭
		rebuildlotteryClose : function(parameter){
			var me = this,
				result = {};
				lotteryName = parameter['data']['tplData']['lotteryName'];
				lotteryPeriods = parameter['data']['tplData']['lotteryPeriods'];
				time = parameter['data']['tplData']['orderDate'];
				lotterys = parameter['data']['tplData']['lotterys'];
				typeArray = parameter['data']['tplData']['lotteryType'];
				result['mask'] = true;
				result['iconClass'] = '';
				result['closeIsShow'] = true;
				result['closeFun'] = function(){
					me.hide();
				};
				//彩种名称
				parameter['data']['tplData']['lotteryName'] = function(){
					return lotteryName || '';
				};
				//本次开奖期数
				parameter['data']['tplData']['lotteryPeriods'] = function(){
					return lotteryPeriods || '';
				};
				//购买日期
				parameter['data']['tplData']['orderDate'] = function(){
					return time['year'] + '年' + time['month'] + '月' + time['day'] + '日 ' + time['hour'] + ':' + time['min'];
				};
				//彩票详情
				parameter['data']['tplData']['lotterys'] = function(){
					var html  = '';
					if($.isArray(lotterys)){
						for (var i = 0; i < lotterys.length; i++) {
							html += '<em>' + lotterys[i] + '</em>';
						};
					}
					return html;
				};
				//彩票种类
				parameter['data']['tplData']['lotteryType'] = function(){
					var html  = '';
					if($.isArray(typeArray)){
						for (var i = 0; i < typeArray.length; i++) {
							html += '<dd><span style="background:url(' + typeArray[i]['pic'] +')" class="pic" title="' + typeArray[i]['name'] + '" alt="' + typeArray[i]['name'] + '"></span><a href="' + typeArray[i]['url'] + '" class="btn">去投注<b class="btn-inner"></b></a></dd>';
						};
					}
					return html;
				};
				result['content'] = me.formatHtml(parameter['tpl'], parameter['data']['tplData']);
				me.show($.extend(result, parameter));
		},
		getHtmllotteryClose : function(){
			var cfg = this.defConfig;
			return cfg.lotteryClose;
		},
		/*
			//调用实例
			dsgame.Games.getCurrentGameMessage().show({
			   type : 'nonSaleTime',
			   data : {
			       tplData:{
						//开始购买时间
				        orderDate : {'year':'2013','month':'5','day':'3','hour':'1','min':'30'},
				        //提示彩票种类
				        lotteryType : [{'name':'leli','pic':'#','url':'http://163.com'},{'name':'kuaile8','pic':'#','url':'http://pp158.com'}]
			       }
			   }
			})
		 */
		//未到销售时间
		rebuildnonSaleTime : function(parameter){
			var me = this,
				result = {};
				time = parameter['data']['tplData']['orderDate'];
				typeArray = parameter['data']['tplData']['lotteryType'];
				result['mask'] = true;
				result['iconClass'] = '';
				result['closeIsShow'] = true;
				result['closeFun'] = function(){
					me.hide();
				};
				//购买日期
				parameter['data']['tplData']['orderDate'] = function(){
					return time['year'] + '年' + time['month'] + '月' + time['day'] + '日 ' + time['hour'] + ':' + time['min'];
				};
				//彩票种类
				parameter['data']['tplData']['lotteryType'] = function(){
					var html  = '';

					if($.isArray(typeArray)){
						for (var i = 0; i < typeArray.length; i++) {
							html += '<dd><span style="background:url(' + typeArray[i]['pic'] +')" class="pic" title="' + typeArray[i]['name'] + '" alt="' + typeArray[i]['name'] + '"></span><a href="' + typeArray[i]['url'] + '" class="btn">去投注<b class="btn-inner"></b></a></dd>';
						};
					}
					return html;
				};
				result['content'] = me.formatHtml(parameter['tpl'], parameter['data']['tplData']);
				me.show($.extend(result, parameter));
		},
		getHtmlnonSaleTime : function(){
			var cfg = this.defConfig;
			return cfg.nonSaleTime;
		},
		//just user player allowed to bet
		rebuildno_right :function(parameter){
			var me = this, result = {};
				result['mask'] = true;
				result['iconClass'] = '';
				result['closeIsShow'] = true;
				result['closeFun'] = function(){
					me.hide();
				};
				result['content'] = me.formatHtml(parameter['tpl'], parameter['data']['tplData']);
				me.show($.extend(result, parameter));
		},
		//至少选择一注
		rebuildmustChoose : function(parameter){
			var me = this, result = {};
				result['mask'] = true;
				result['iconClass'] = '';
				result['closeIsShow'] = true;
				result['closeFun'] = function(){
					me.hide();
				};
				result['content'] = me.formatHtml(parameter['tpl'], parameter['data']['tplData']);
				me.show($.extend(result, parameter));
		},
		getHtmlmustChoose : function(){
			return this.getHtmlWaring();
		},
		//网络连接异常
		rebuildnetAbnormal : function(parameter){
			var me = this, result = {};
				result['mask'] = true;
				result['iconClass'] = '';
				result['closeIsShow'] = true;
				result['closeFun'] = function(){
					me.hide();
				};
				result['content'] = me.formatHtml(parameter['tpl'], parameter['data']['tplData']);
				me.show($.extend(result, parameter));
		},
		getHtmlnetAbnormal : function(){
			return this.getHtmlWaring();
		},
		//提交成功
		rebuildsuccess : function(parameter){
			var me = this, result = {};
				result['mask'] = true;
				result['iconClass'] = '';
				result['closeIsShow'] = true;
				result['printIsShow'] = true;
				result['closeFun'] = function(){
					me.hide();
				};
                result['printFun'] = function(){
					me.print();
				};
				result['content'] = me.formatHtml(parameter['tpl'], parameter['data']['tplData']);
				me.show($.extend(result, parameter));
		},
		getHtmlsuccess : function(){
			var cfg = this.defConfig;
			return cfg.successTip;
		},
		//登陆超时loginTimeout
		rebuildloginTimeout : function(parameter){
			var me = this, result = {};
				result['mask'] = true;
				result['closeIsShow'] = true;
				result['closeFun'] = function(){
					me.hide();
				};
				result['content'] = me.formatHtml(parameter['tpl'], parameter['data']['tplData']);
				me.show($.extend(result, parameter));
		},
		getHtmlloginTimeout : function(){
			return this.getHtmlWaring();
		},
		//服务器错误
		rebuildserverError : function(parameter){
			var me = this, result = {};
				result['mask'] = true;
				result['iconClass'] = '';
				result['closeIsShow'] = true;
				result['closeFun'] = function(){
					me.hide();
				};
				result['content'] = me.formatHtml(parameter['tpl'], parameter['data']['tplData']);
				me.show($.extend(result, parameter));
		},
		getHtmlserverError : function(){
			return this.getHtmlWaring();
		},
		//余额不足
		rebuildInsufficientbalance : function(parameter){
			var me = this, result = {};
				result['mask'] = true;
				result['closeIsShow'] = true;
				result['closeFun'] = function(){
					me.hide();
				};
				result['content'] = me.formatHtml(parameter['tpl'], parameter['data']['tplData']);
				me.show($.extend(result, parameter));
		},
		getHtmlInsufficientbalance : function(){
			return this.getHtmlWaring();
		},
		//暂停销售
		rebuildpauseBet : function(parameter){
			var me = this, result = {};
				result['mask'] = true;
				result['confirmText'] = '投 注';
				result['confirmIsShow'] = true;
				result['confirmFun'] = function(){
					var order = Games.getCurrentGameOrder(),
						i = 0;
					//删除指定类别的投注
					for (; i < parameter['data']['tplData']['balls'].length; i++) {
						order.removeData(parameter['data']['tplData']['balls'][i]['id']);
					};
					//提交投注
					Games.getCurrentGameSubmit().submitData();
				};
				result['closeText'] = '关 闭';
				result['closeIsShow'] = true;
				result['closeFun'] = function(){
					me.hide();
				};
				//生成消息
				parameter['data']['tplData']['msg'] = function(){
					var numText = [],
						gameConfig = Games.getCurrentGame().getGameConfig().getInstance(),
						k = 0;
						//输出暂停销售名称集合
						for (; k < parameter['data']['tplData']['balls'].length; k++) {
							var current = parameter['data']['tplData']['balls'][k]['type'],
								typeText = gameConfig.getTitleByName(current);
							if(me.arrIndexOf(typeText.join(''), numText) == -1){
								numText.push(typeText.join(''));
							}
						};
						return '您的投注内容中“' + numText.join('') + '”已暂停销售，是否完成剩余内容投注？';
				};
				result['content'] = me.formatHtml(parameter['tpl'], parameter['data']['tplData']);
				me.show($.extend(result, parameter));
		},
		getHtmlpauseBet : function(){
			var cfg = this.defConfig;
			return cfg.pauseBet;
		},
		//倍数超限
		rebuildmultipleOver : function(parameter){
			var me = this, result = {};
				result['mask'] = true;
				result['iconClass'] = '';
				result['closeText'] = '关 闭';
				result['closeIsShow'] = true;
				result['closeFun'] = function(){
					me.hide();
				};
				//生成消息
				parameter['data']['tplData']['msg'] = function(){
					var numText = [],
						gameConfig = Games.getCurrentGame().getGameConfig().getInstance(),
						k = 0;
						//输出暂停销售名称集合
						for (; k < parameter['data']['tplData']['balls'].length; k++) {
							var current = parameter['data']['tplData']['balls'][k]['type'],
								typeText = gameConfig.getTitleByName(current);
							if(me.arrIndexOf(typeText.join(''), numText) == -1){
								numText.push(typeText.join(''));
							}
						};
						return '您的投注内容中“' + numText.join('') + '”超出倍数限制，请调整！';
				};
				result['content'] = me.formatHtml(parameter['tpl'], parameter['data']['tplData']);
				me.show($.extend(result, parameter));
		},
		getHtmlmultipleOver : function(){
			var cfg = this.defConfig;
			return cfg.multipleOver;
		},
		//无效字符
		rebuildinvalidtext : function(parameter){
			var me = this, result = {};
				result['mask'] = true;
				result['confirmText'] = '刷新页面';
				result['confirmIsShow'] = true;
				result['confirmFun'] = function(){
					window.location.reload();
				};
				result['content'] = me.formatHtml(me.getHtmlinvalidtext(), parameter);
				me.show($.extend(result, parameter));
		},
		getHtmlinvalidtext : function(){
			var cfg = this.defConfig;
			return cfg.invalidtext;
		},
		//投注过期
		rebuildbetExpired : function(parameter){
			var me = this, result = {};
				result['mask'] = true;
				result['closeText'] = '关 闭';
				result['closeIsShow'] = true;
				result['closeFun'] = function(){
					me.hide();
				};
				parameter['data']['tplData']['msg'] = function(){
						return '您好，' + parameter['data']['tplData']['bitDate']['expiredDate'] + '期 已截止销售，当前期为' + parameter['data']['tplData']['bitDate']['current'] + '期 ，请留意！';
				};
				result['content'] = me.formatHtml(me.getHtmlbetExpired(), parameter['data']['tplData']);
				me.show($.extend(result, parameter));
		},
		getHtmlbetExpired : function(){
			var cfg = this.defConfig;
			return cfg.betExpired;
		},
		//非法投注工具
		rebuildillegalTools : function(parameter){
			var me = this, result = {};
				result['mask'] = true;
				result['confirmText'] = '刷新页面';
				result['confirmIsShow'] = true;
				result['confirmFun'] = function(){
					window.location.reload();
				};
				result['content'] = me.formatHtml(me.getHtmlbetExpired(), parameter['data']['tplData']);
				me.show($.extend(result, parameter));
		},


		//封锁变价模板
		getHtmlblockade : function(){
			return this.defConfig.blockade;
		},
		//封锁变价
		rebuildblockade : function(parameter){
			var me = this, result = {},tplData = parameter['data']['tplData'],orderData = parameter['data']['orderData'],blockadeInfo = parameter['data']['blockadeInfo'],
				balls = orderData['balls'],
				dataHas = {},
				ballStr = '',
				typeName = '',
				formatMoney = Games.getCurrentGameOrder().formatMoney,
				maxLen = 28,
				//是否在提交中
				isSubmitLoading = false,
				blockadeData0 = ['<ul class="game-msg-blockade-balls">'];

				result['mask'] = true;
				result['closeIsShow'] = true;
				result['closeText'] = '关 闭';
				result['confirmIsShow'] = true;
				result['confirmText'] = '确 认';
				result['closeFun'] = function(){
					me.hide();
				};

				$.each(balls, function(i){
					dataHas['' + this['id']] = this;
					ballStr = this['ball'];
					if(ballStr.length > maxLen){
						ballStr = ballStr.substr(0, maxLen) + '...';
					}
					typeName = Games.getCurrentGame().getGameConfig().getInstance().getTitleByName(this['type']).join('_');

					blockadeData0.push('<li data-id="'+ this['id'] +'">['+ typeName +'] '+ ballStr +'</li>');
				});
				blockadeData0.push('</ul>');

				tplData['gameTypeTitle'] = Games.getCurrentGame().getGameConfig().getInstance().getGameTypeCn();
				tplData['blockadeData0'] = blockadeData0.join('');
				tplData['amount'] = formatMoney(orderData['amount']);
				tplData['username'] = blockadeInfo['username'];
				tplData['amountAdjust'] = formatMoney(blockadeInfo['amountAdjust']);
				tplData['amountChange'] = formatMoney(orderData['amount'] - blockadeInfo['amountAdjust']);
				tplData['display'] = '';

				if(blockadeInfo['type'] == 1){
					tplData['blockadeType'] = '受限';
				}else if(blockadeInfo['type'] == 2){
					tplData['blockadeType'] = '奖金变动';
					tplData['display'] = 'none';
				}else{
					tplData['blockadeType'] = '奖金变动及受限';
				}

				//获得撤单手续费
				result['callback'] = function(){
					$.ajax({
						url: Games.getCurrentGameSubmit().defConfig.handlingChargeURL + '?amout=' + blockadeInfo['amountAdjust'],
						dataType: 'json',
						method: 'GET',
						success: function(r){
							if(Number(r['isSuccess']) == 1){
								me.getContentDom().find('.handlingCharge').html(r['data']['handingcharge']);
							}
						}
					});
				};

				result['content'] = me.formatHtml(me.getHtmlbetExpired(), tplData);


				//再次提交注单
				result['confirmFun'] = function(){
					var message = Games.getCurrentGameMessage();
					if(isSubmitLoading){
						return false;
					}
					$.ajax({
						url: Games.getCurrentGameSubmit().defConfig.URL,
						data: orderData,
						dataType: 'json',
						method: 'POST',
						beforeSend:function(){
							isSubmitLoading = true;
						},
						success: function(r){
						//返回消息标准
						// {"isSuccess":1,"type":"消息代号","msg":"返回的文本消息","data":{xxx:xxx}}
							if(Number(r['isSuccess']) == 1){
								message.show(r);
								me.clearData();
								me.fireEvent('afterSubmitSuccess');
							}else{
								message.show(r);
							}
						},
						complete: function(){
							isSubmitLoading = false;
							me.fireEvent('afterSubmit');
						}
					});
				};
				//console.log(parameter);
				me.show($.extend(result, parameter));
				host.util.toViewCenter(me.win.dom);
				//console.log(parameter);



				//面板内的事件
				$('#J-blockade-panel-main').on('click', '[data-action]', function(e){
					var el = $(this),action = $.trim(el.attr('data-action')),id = $.trim(el.parent().attr('data-id'));
					e.preventDefault();
					//console.log(action, id, dataHas[id]);
					switch(action){
						//查看详情
						case 'blockade-detail' :
							//将投注内容转换成Input内容
							var form = $('#J-form-blockade-detail'),
								splitStr = '-';
							form.html('');
							//游戏名称
							$('<input type="hidden" value="'+ orderData['gameType'] +'" name="gameType" />').appendTo(form);
							//选球内容和玩法名称以 /// 分隔
							$.each(balls, function(){
								var me = this;
								if(me['lockPoint']){
									if($.trim(me['lockPoint']['beforeBlockadeList']) != ''){
										$.each(me['lockPoint']['beforeBlockadeList'], function(){
											var dt = this;
											$('<input type="hidden" value="'+ dt['beishu'] + splitStr + dt['blockadeDetail'] + splitStr + dt['realBeishu'] + splitStr + me['type'] + splitStr + me['ball'] + '" name="beforeBlockadeList[]" />').appendTo(form);
										});
									}
									if($.trim(me['lockPoint']['pointsList']) != ''){
										$.each(me['lockPoint']['pointsList'], function(){
											var dt = this;
											$('<input type="hidden" value="'+ dt['mult'] + splitStr + dt['point'] + splitStr + dt['retValue'] + splitStr + me['type'] + splitStr + me['ball'] + '" name="pointsList[]" />').appendTo(form);
										});
									}

								}

							});
							form.submit();
						break;
						default:
						break;
					}
				});


		},


		getHtmlillegalTools : function(){
			return this.getHtmlWaring();
		},
		//提交失败
		rebuildsubFailed : function(parameter){
			var me = this, result = {};
				result['mask'] = true;
				result['closeText'] = '关 闭';
				result['closeIsShow'] = true;
				result['closeFun'] = function(){
					me.hide();
				};
				result['content'] = me.formatHtml(me.getHtmlbetExpired(), parameter['data']['tplData']);
				me.show($.extend(result, parameter));
		},
		getHtmlsubFailed : function(){
			return this.getHtmlWaring();
		},
		//非法奖金组
		rebuildgroup_error : function(parameter){
			var me = this, result = {};
				result['mask'] = true;
				result['closeText'] = '关 闭';
				result['closeIsShow'] = true;
				result['closeFun'] = function(){
					me.hide();
				};
				result['content'] = me.formatHtml(me.getHtmlbetExpired(), parameter['data']['tplData']);
				me.show($.extend(result, parameter));
		},
		getHtmlgroup_error : function(){
			return this.getHtmlWaring();
		},
		//user type is proxy
		getHtmlno_right:function(){
			return this.defConfig.userTypeError;
		},
		//添加题目
		setTitle: function(html){
			var me = this, win = me.win;
			win.setTitle(html);
		},
		//添加内容
		setContent: function(html, delay){
			var me = this, win = me.win;

			win.setContent(html, delay);
		},
		//隐藏关闭按钮
		hideClose: function(){
			var me = this, win = me.win;

			win.getCloseDom().hide();
		},
		//隐藏标题栏
		hideTitle: function(){
			var me = this, win = me.win;

			win.getTitleDom().hide();
		},

		//弹窗显示 具体参数说明
		//弹窗类型(会根据弹窗类型自动获取模版) type
		//模版 tpl  数据 tplData
		//内容:content, 绑定函数: callback, 是否遮罩: mask
		//宽度:width, 长度:height, 自动关闭时间单位S:time
		//是否显示头部: hideTitle, 是否显示关闭按钮:hideClose
		//确认按钮 是否显示: confirmIsShow 名称: confirmText 事件: confirmFun
		//取消按钮 是否显示: cancelIsShow  名称: cancelText	事件: cancelFun
		//关闭按钮 是否显示: closeIsShow   名称: closeText	事件: closeFun
		show: function(data){
			var me = this, win = me.win;
			me.reSet();
			if(typeof data['data'] == 'undefined'){
				data['data'] = {};
			}
			data['data']['tplData'] = typeof data['data']['tplData'] == 'undefined' ? {} : data['data']['tplData'];

			if(!data){return}

			if(data['type']){
				me.doAction(data);
				return;
			}else{
				if(typeof data['tpl'] != 'undefined'){
					data['content'] = me.formatHtml(data['tpl'], data['data']['tplData']);
				}
			}

			//取消自动关闭时间缓存
			if(closeTime){
				clearTimeout(closeTime);
				closeTime = null;
			}
			//加入题目 && 内容
			me.setTitle(data['title'] || '温馨提示');
			me.setContent(data['content'] || '');
			//按钮名称
			if(data['confirmText']){
				win.setConfirmName(data['confirmText']);
			}
			if(data['cancelText']){
				win.setCancelName(data['cancelText']);
			}
			if(data['closeText']){
				win.setCloseName(data['closeText']);
			}
			//按钮事件
			if(data['normalCloseFun']){
				win.doNormalClose = data['normalCloseFun'];
			}
			if(data['confirmFun']){
				win.doConfirm = data['confirmFun'];
			}
			if(data['cancelFun']){
				win.doCancel = data['cancelFun'];
			}
			if(data['closeFun']){
				win.doClose = data['closeFun'];
			}
			if(data['printFun']){
				win.doPrint = data['printFun'];
			}
			//按钮显示
			if(data['confirmIsShow']){
				win.showConfirmButton();
			}
			if(data['cancelIsShow']){
				win.showCancelButton();
			}
			if(data['closeIsShow']){
				win.showCloseButton();
			}
			if(data['printIsShow']){
				win.showPrintButton();
			}
			//判断是否隐藏头部和关闭按钮
			if(data['hideTitle']){
				me.hideTitle();
			}
			if(data['hideClose']){
				me.hideClose();
			}
			//遮罩显示
			if(data['mask']){
				me.mask.show();
				$('#print-project-panel').html($('.game-submit-confirm-cont').html());
			}

			win.show();

			//执行回调事件
			if(data['callback']){
				data['callback'].call(me);
			}

			//定时关闭
			if(data['time']){
				closeTime = setTimeout(function(){
					me.hide();
					clearTimeout(closeTime);
					closeTime = null;
				}, data['time'] * 1000)
			}
		},
		getContainerDom : function(){
			var me = this;
			return me.win.getContainerDom();
		},
		//获取内容容器DOM
		getContentDom : function(){
			var me = this;
			return me.win.getContentDom();
		},
		//弹窗隐藏
		hide: function(){
			var me = this, win = me.win;
			win.hide();
			me.reSet();
		},
		//打印数据
		print: function(){
			var me = this, win = me.win;

			win.hide();
			me.reSet();
			$('#issue-for-print').show();
			$('.amount-for-print').show();
			$('.game-submit-confirm-tip').css('text-align','left');
			$('#project-for-print').removeClass('textarea').append($('<div style="font-size:8px">购买时间：'+(new Date()).toLocaleString()+'</div>'));
			$('.game-submit-confirm-list').removeClass('game-submit-confirm-list');
			$('#print-project-panel').show().css('font-size','14px');
			window.print();
			$('#print-project-panel').hide();
		},
		//重置
		reSet: function(){
			var me = this, win = me.win;

			me.mask.hide();
			me.setTitle('提示');
			me.setContent('');
			win.hideConfirmButton();
			win.hideCancelButton();
			win.hideCloseButton();
			win.hidePrintButton();
			win.doConfirm = function(){};
			win.doCancel = function(){};
			win.doClose = function(){};
			win.doNormalClose = function(){};
			win.setConfirmName('确 认');
			win.setCancelName('取 消');
			win.setCloseName('关 闭');
		},
		showTip:function(msg, callback){
			var me = this;
			me.mask.show();
			me.win.showTip(msg, callback);
		},
		hideTip:function(){
			var me = this;
			me.win.hideTip();
			me.mask.hide();
		}
	}

	var Main = host.Class(pros, Event);
		Main.defConfig = defConfig;
		Main.getInstance = function(cfg){
			return instance || (instance = new Main(cfg));
		};
	host[name] = Main;

})(dsgame, "GameMessage",  dsgame.Event);












//游戏选球统计，如注数、当前操作金额等
(function(host, name, Event, undefined){
	var defConfig = {
		//主面板dom
		mainPanel          : '#J-balls-statistics-panel',
		//注数dom
		lotteryNumDom      : '#J-balls-statistics-lotteryNum',
		//倍数
		multipleDom        : '#J-balls-statistics-multiple',
		//总金额
		amountDom          : '#J-balls-statistics-amount',
		moneyUnitDom       : '#J-balls-statistics-moneyUnit',
		moneyUnitTriggerDom: '#J-balls-statistics-moneyUnit-trigger',
		//元/角模式比例  1为元模式 0.1为角模式 0.01分模式
		moneyUnit          : gameConfigData['defaultCoefficient'],
		//元角模式对应的中文
		moneyUnitData      : gameConfigData['availableCoefficients'],
		//倍数
		multiple           : gameConfigData['defaultMultiple'],
		bonusGroupMax      : gameConfigData['maxPrizeGroup']
	},
	instance,
	Games = host.Games;

	var pros = {
		init:function(cfg){
			var me = this;
			Games.setCurrentGameStatistics(me);

			me.panel = $(cfg.mainPanel);
			me.moneyUnit = cfg.moneyUnit;
			me.multiple = cfg.multiple;
			me.setProjectNum(1);
			// me.setDigitChoose(Games.getCurrentGame().defConfig.digitConf || []);
			//已组合好的选球数据
			me.lotteryData = [];

			Games.getCurrentGame().addEvent('afterProjectNumSet', 
				function(e, oldNum, digitChoosed){
					var newNum = digitChoosed.length || 1;
					me.setProjectNum(newNum);
					me.setDigitChoose(digitChoosed);
					if( oldNum != newNum ){
						Games.getCurrentGame().getCurrentGameMethod().updateData();
					}
				});

			//倍数选择模拟下拉框
			me.multipleDom = new dsgame.Select({
				cls:'select-game-statics-multiple',
				realDom:cfg.multipleDom,
				isInput:true,
				isCounter: true,
				expands:{
					inputEvent:function(){
						var meSelect = this;
						this.getInput().keyup(function(e){
							var v = this.value,
								id = Games.getCurrentGame().getCurrentGameMethod().getId(),
								unit = me.getMoneyUnit(),
								maxv = maxv = (Games.getCurrentGame().getGameConfig().getInstance().getLimitByMethodId(id, unit)==0) ? v: Games.getCurrentGame().getGameConfig().getInstance().getLimitByMethodId(id, unit);
							this.value = this.value.replace(/[^\d]/g, '');
							if($.trim(this.value) != ''){
								v = Number(this.value);
								if(v < 1){
									this.value = 1;
								}else if(v > maxv){
									this.value = maxv;
								}
								meSelect.setValue(this.value);
							}
						});
						this.getInput().blur(function(){
							var v = this.value,
								id = Games.getCurrentGame().getCurrentGameMethod().getId(),
								unit = me.getMoneyUnit(),
								maxv = (Games.getCurrentGame().getGameConfig().getInstance().getLimitByMethodId(id, unit)==0) ? v: Games.getCurrentGame().getGameConfig().getInstance().getLimitByMethodId(id, unit);
							this.value = this.value.replace(/[^\d]/g, '');
							v = Number(this.value);
							if(v < 1){
								this.value = 1;
							}else if(v > maxv){
								this.value = maxv;
							}
							meSelect.setValue(this.value);
						});
					}
				}
			});
			me.multipleDom.setValue((me.multiple == 0 ) ? 1 :me.multiple );
			me.multipleDom.addEvent('change', function(e, value, text){
				var num = Number(value),
					id = Games.getCurrentGame().getCurrentGameMethod().getId(),
					unit = me.getMoneyUnit(),
					maxnum = (Games.getCurrentGame().getGameConfig().getInstance().getLimitByMethodId(id, unit)==0) ? num: Games.getCurrentGame().getGameConfig().getInstance().getLimitByMethodId(id, unit);

				if(num > maxnum){
					num = maxnum;
					this.setValue(num);
				}
				me.setMultiple(num);
				me.updateData({'lotterys':Games.getCurrentGame().getCurrentGameMethod().getLottery(),'original':Games.getCurrentGame().getCurrentGameMethod().getOriginal()}, Games.getCurrentGame().getCurrentGameMethod().getName());
				$('#J-balls-statistics-multipleNum').text(num);
			});

			//元角模式模拟下拉框
			me.moneyUnitDom = new dsgame.Select({cls:'select-game-statics-moneyUnitDom',realDom:cfg.moneyUnitDom});
			//在未添加change事件之前设置初始值
			me.moneyUnitDom.setValue(me.moneyUnit);
			me.moneyUnitDom.addEvent('change', function(e, value, text){
				var multiple = me.getMultip(),
					id = Games.getCurrentGame().getCurrentGameMethod().getId(),
					unit = Number(value),
					maxnum = (Games.getCurrentGame().getGameConfig().getInstance().getLimitByMethodId(id, unit)==0) ? 1: Games.getCurrentGame().getGameConfig().getInstance().getLimitByMethodId(id, unit);
				multiple = multiple > maxnum ? maxnum : multiple;
				me.setMultipleDom(multiple);
				me.setMoneyUnit(Number(value));
				me.multipleDom.setMaxValue(maxnum);
				me.updateData({'lotterys':Games.getCurrentGame().getCurrentGameMethod().getLottery(),'original':Games.getCurrentGame().getCurrentGameMethod().getOriginal()}, Games.getCurrentGame().getCurrentGameMethod().getName());
			});

			// 隐藏元角模式下拉元素，由trigger元素触发
			me.hidesetMoneyUnitDom();
			var moneyUnitTriggerDom = $(cfg.moneyUnitTriggerDom);
			me.setMoneyUnitTriggerDom( moneyUnitTriggerDom );
			moneyUnitTriggerDom.on('click', 'a[data-value]', function(){
				var value = $(this).data('value');
				if( value && !$(this).hasClass('current') ){
					me.moneyUnitDom.setValue(value);
					$(this).addClass('current').siblings().removeClass('current');
				}
				return false;
			});
			// 初始化trigger高亮状态
			$('a[data-value="' + me.moneyUnit + '"]', moneyUnitTriggerDom).addClass('current');

			//设置奖金组
			var bonusGroup = Games.getCurrentGame().getGameConfig().getInstance().getOptionalPrizes(),
				bonusLength = bonusGroup.length,
				$prizeGroupParent = $('.J-prize-group-slider'),
				$prizeGroupInput = $('#J-bonus-select-value'),
				$prizeGroupPercent = $prizeGroupParent.find('[data-slider-percent]'),
				$prizeGroupValue = $prizeGroupParent.find('[data-slider-value]'),
				availableIdx = bonusLength - 1,
				bonusGroupMax = (defConfig.bonusGroupMax && defConfig.bonusGroupMax != '0') ? defConfig.bonusGroupMax : bonusGroup[bonusLength-1]['prize_group'];

			for(;availableIdx>=0;availableIdx--){
				if( bonusGroup[availableIdx]['prize_group'] <= bonusGroupMax ){
					break;
				}
			}
			me.bonusGroup = bonusGroup;
			//自定义奖金组设置组件
			me.prizeSlider = new dsgame.SliderBar({
				// 'isUpOnly' : true,
				'minDom'   : '[data-slider-sub]',
				'maxDom'   : '[data-slider-add]',
				'contDom'  : '[data-slider-cont]',
				'handleDom': '[data-slider-handle]',
				'innerDom' : '[data-slider-inner]',
				'minNumDom': '[data-slider-min]',
				'maxNumDom': '[data-slider-max]',
				'parentDom': $prizeGroupParent,
				'step'     : 1,
				'minBound' : 0,
				'maxBound' : bonusLength-1,
				'rangeBound': [0, availableIdx],
				'value'     : availableIdx
			});
			// 设置初始化奖金组
			// me.prizeSlider.setValue(availableIdx);
			// var initBonus = bonusGroup[availableIdx]['prize_group'],
			// 	initRate = bonusGroup[availableIdx]['rate'];
			// $prizeGroupInput.val(initBonus);
			// $prizeGroupPercent.text((initRate*100).toFixed(2) +'%');
			// $prizeGroupValue.text(initBonus);
			me.prizeSlider.addEvent('change', function(){
				var bonus = bonusGroup[this.getValue()]['prize_group'],
					rate = bonusGroup[this.getValue()]['rate'],
					rateTxt = (rate*100).toFixed(2) +'%';
				$prizeGroupInput.val(bonus);
				$prizeGroupPercent.text(rateTxt);
				$prizeGroupValue.text(bonus);
				var result = me.getResultData();

				if( result && result['amount'] ){
					me.setRebate( result['amount'], rate );
				}
			});
			$(function(){
				me.prizeSlider.setValue(availableIdx);
				// me.triggerMoneyUnit( me.moneyUnit );
			});

			//初始化相关界面，使得界面和配置统一
			me.updateData({'lotterys':[],'original':[]});

		},
		setProjectNum:function(num){
			this.projectNum = num;
		},
		getProjectNum:function(num){
			return this.projectNum;
		},
		setDigitChoose:function(digitChoose){
			var temp = [];
			this.digitChoose = digitChoose;
		},
		getDigitChoose:function(){
			return this.digitChoose;
		},
		getMultipleDom:function(){
			return this.multipleDom;
		},
		getMultipleTextDom:function(){
			return $('#J-balls-statistics-multiple-text');
		},
		getMoneyUnitText:function(moneyUnit){
			return this.defConfig.moneyUnitData[''+moneyUnit];
		},
		//更新各种数据
		updateData:function(data, name){
			var me = this,
				cfg = me.defConfig,
				count = data['lotterys']? data['lotterys'].length : 0,
				price = 2,
				multiple = me.multiple,
				moneyUnit = me.moneyUnit;
				// 任选玩法直选单式需要用到
				projectNum = me.projectNum;

				if( Games.getCurrentGame() && Games.getCurrentGame().getCurrentGameMethod()){
					price = Games.getCurrentGame().getGameConfig().getInstance().getOnePriceById(Games.getCurrentGame().getCurrentGameMethod().getId());
				}
			var amount = count * moneyUnit * multiple * price * projectNum;
			//设置投注内容
			me.setLotteryData(data);
			//设置倍数
			//由于设置会引发updateData的死循环，因此在init里手动设置一次，之后通过change事件触发updateData
			//me.setMultipleDom(multiple);
			//更新元角模式
			me.setMoneyUnitDom(moneyUnit);
			//更新注数
			me.setLotteryNumDom(count * projectNum);
			//更新总金额
			me.setAmountDom(me.formatMoney(amount));
			//参数：注数、金额
			me.fireEvent('afterUpdate', count, amount);

		},
		//获取当前数据
		getResultData:function(){
			var me = this,
				onePrice,
				method = Games.getCurrentGame().getCurrentGameMethod(),
				lotterys = me.getLotteryData();
			if(lotterys['lotterys'].length < 1){
				return {};
			}
			onePrice = Games.getCurrentGame().getGameConfig().getInstance().getOnePriceById(method.getId());
			count = lotterys['lotterys'].length * me.projectNum;
			amount = count * me.moneyUnit * me.multiple * onePrice
			return {
				mid          : method.getId(),
				type         : method.getName(),
				original     : lotterys['original'],
				lotterys     : lotterys['lotterys'],
				moneyUnit    : me.moneyUnit,
				num          : count,
				multiple     : me.multiple,
				// 任选玩法直选单式需要用
				projectNum   : me.projectNum,
				digitChoose  : me.getDigitChoose(),
				orderSplitType: method.getOrderSplitType(),
				//单价
				//onePrice   : me.onePrice,
				//单价修改为从动态配置中获取，因为每个玩法有可能单注价格不一样
				onePrice     : onePrice,
				//总金额
				amount       : amount,
				//格式化后的总金额
				amountText   : me.formatMoney(amount),
				//当前注奖金组
				prizeGroup   : Games.getCurrentGame().getGameConfig().getInstance().setOptionalPrizes(),
				prizeGroupVal: $('#J-balls-statistics-rebate').text(),
			};
		},
		//设置元角模式
		setMoneyUnit:function(num){
			var me = this;
			me.moneyUnit = num;
		},
		getMoneyUnit:function(){
			return this.moneyUnit;
		},
		getLotteryData:function(){
			return this.lotteryData;
		},
		setLotteryData:function(data){
			var me = this;
			me.lotteryData = data;
		},
		//将数字保留两位小数并且千位使用逗号分隔
		formatMoney:function(num){
			var num = Number(num),
				re = /(-?\d+)(\d{3})/;

			if(Number.prototype.toFixed){
				num = (num).toFixed(3);
			}else{
				num = Math.round(num*100)/100
			}
			num  =  '' + num;
			while(re.test(num)){
				num = num.replace(re,"$1,$2");
			}
			return num;
		},
		//注数
		getLotteryNumDom:function(){
			var me = this,cfg = me.defConfig;
			return me.lotteryNumDom || (me.lotteryNumDom = $(cfg.lotteryNumDom));
		},
		setLotteryNumDom:function(v){
			var me = this;
			me.getLotteryNumDom().html(v);
		},
		//倍数
		getMultipleDom:function(){
			return this.multipleDom;
		},
		getMultip: function() {
			var me = this;
			return me.multiple;
		},
		setMultipleDom:function(v){
			var me = this;
			me.getMultipleDom().setValue(v);
		},
		setMultiple:function(num){
			this.multiple = num;
		},
		//元角模式
		getMoneyUnitDom:function(){
			return this.moneyUnitDom;
		},
		setMoneyUnitDom:function(v){
			var me = this, u = v;
				// u = (v == '0.01') ? '分' : (v == '0.10'|| v == '0.10')? '角':'元';
		    if( defConfig.moneyUnitData[v] ){
		    	u = defConfig.moneyUnitData[v];
		    }
			me.setMoneyUnit(v);
			$('.select-game-statics-moneyUnitDom input').val(u);
		},
		setMoneyUnitTriggerDom: function($dom){
			this.moneyUnitTriggerDom = $dom;
		},
		getMoneyUnitTriggerDom: function(){
			return this.moneyUnitTriggerDom;
		},
		triggerMoneyUnit: function(moneyUnit){
			var me = this,
				myEvent = $.Event('click'),
				dom = me.getMoneyUnitTriggerDom();

			myEvent.target = dom.find('a[data-value]').filter(function(){
				return Number($(this).data('value')) == Number(moneyUnit);
			})[0];

			dom.trigger(myEvent);
		},
		hidesetMoneyUnitDom: function(){
			this.moneyUnitDom.hide();
		},
		// 奖金组
		getPrizeSlider: function(){
			return this.prizeSlider;
		},
		// 获取当前选中的奖金组
		getPrizeGroup: function(){
			return this.bonusGroup[this.prizeSlider.getValue()]['prize_group'];
		},
		// 获取当前选中的奖金组返点
		getPrizeGroupRate: function(){
			return this.bonusGroup[this.prizeSlider.getValue()]['rate'];
		},
		setSliderValueByPrizeGroup: function(prizeGroup){
			var index = -1;
			$.each(this.bonusGroup, function(i,n){
				if( n['prize_group'] == prizeGroup ){
					return index = i;
				}
			});
			this.getPrizeSlider().setValue(index);
		},
		// 设置返点
		setRebate: function(money, rate){
			var str = '',
				numPoint = Math.pow(10,8); // 用于解决计算小数时出现浮点数计算不准确的bug
			if( money <= 0 || rate <= 0 ){
				str = '0.00';
			}else{
				money = '' + parseFloat(money * (rate * numPoint) / numPoint || 0);
				money = money.split('.')
				if( money[1] ){
					var digit = ''+money[1];
					if( digit.length > 8 ){
						digit = digit.slice(0,8);
					}
					str = host.util.formatMoney(money[0],0) + '.' + digit;
				}else{
					str = host.util.formatMoney(money[0],2)
				}
			}
			$('#J-balls-statistics-rebate').text(str);
		},
		//总金额
		getAmountDom:function(){
			var me = this,cfg = me.defConfig;
			return me.amountDom || (me.amountDom = $(cfg.amountDom));
		},
		setAmountDom:function(v){
			var me = this;
			me.getAmountDom().html(v);
		},
		reSet:function(){
			var me = this,cfg = me.defConfig;
			//取消还原倍数
			me.multipleDom.setValue(1);
			//取消还原圆角模式
			//me.moneyUnitDom.setValue(cfg.moneyUnit);
		}


	};

	var Main = host.Class(pros, Event);
		Main.defConfig = defConfig;
		Main.getInstance = function(cfg){
			return instance || (instance = new Main(cfg));
		};
	host[name] = Main;

})(dsgame, "GameStatistics", dsgame.Event);


(function(host, name, Event, undefined){
	var defConfig = {
		//主面板dom
		panel:'#J-panel-gameTypes'
	},
	//渲染实例
	instance,
	//游戏实例
	Games = host.Games;

	//渲染方法
	var pros = {
		init:function(cfg){
			var me = this;
			//缓存方法
			Games.setCurrentGameTypes(me);
			me.container = $(cfg.panel);
			//玩法数据
			me.data = Games.getCurrentGame().getGameConfig().getInstance().getMethods();
			me.buildDom();
			me.initEvent();
		},
		buildDom:function(){
			var me = this,it,it2,it3,strArr = [],strArrAll = [],modeArr = [];
			me.renxuanCount = 0;
			$.each(me.data, function(){
				strArr = [];
				it = this;
				if( it['isRenxuan'] ){
					me['renxuanCount'] += 1;
					strArr.push('<li class="gametypes-menu-'+ it['name_en'] +' gametypes-menu-renxuan" data-renxuan>');
				}else{
					strArr.push('<li class="gametypes-menu-'+ it['name_en'] +'">');
				}
					strArr.push('<div class="title">');
						strArr.push(it['name_cn']);
						modeArr[0] = it['name_en'];
						strArr.push('<span></span>');
					strArr.push('</div>');
					// strArr.push('<div class="content">');

					// $.each(it['children'], function(){
					// 	it2 = this;
					// 	modeArr[1] = it2['name_en'];
					// 	strArr.push('<dl>');
					// 		strArr.push('<dd class="types-node types-node-'+ it2['name_en'] +'">'+ it2['name_cn'] +'</dd>');
					// 		$.each(it2['children'], function(){
					// 			it3 = this;
					// 			modeArr[2] = it3['name_en'];
					// 			strArr.push('<dd class="types-item" data-id="'+ it3['id'] +'">'+ it3['name_cn'] +'</dd>');
					// 		});
					// 	strArr.push('</dl>');
					// });
					// strArr.push('</div>');
				strArr.push('</li>');

				strArrAll.push(strArr.join(''));
			});
			if( me.renxuanCount ){
				strArrAll.push('<li class="gametypes-menu-toggle">任选玩法</li>');
			}
			me.getContainerDom().html(strArrAll.join(''));

			//构建平板面板菜单
			me.buildPanelMenu();

			setTimeout(function(){
				me.fireEvent('endShow');
			}, 20);

		},
		buildPanelMenu:function(){
			var me = this,it,it2,it3,strArr = [],strArrAll = [],modeArr = [],
				panelDom = me.getPanelDom();
			$.each(me.data, function(){
				strArr = [];
				it = this;
				strArr.push('<li class="gametypes-sort gametypes-menu-'+ it['name_en'] +'">');
					/**
					strArr.push('<div class="title">');
						strArr.push(it['name_cn']);
						modeArr[0] = it['name_en'];
						strArr.push('<span></span>');
					strArr.push('</div>');
					**/
					strArr.push('<div class="content clearfix">');
					
					$.each(it['children'], function(){
						it2 = this;
						modeArr[1] = it2['name_en'];
						strArr.push('<dl>');
							strArr.push('<dt class="types-node types-node-'+ it2['name_en'] +'">'+ it2['name_cn'] +'</dt>');
							$.each(it2['children'], function(){
								it3 = this;
								modeArr[2] = it3['name_en'];
								strArr.push('<dd class="types-item" data-id="'+ it3['id'] +'">'+ it3['name_cn'] +'</dd>');
							});
						strArr.push('</dl>');
					});
					strArr.push('</div>');
				strArr.push('</li>');
				
				strArrAll.push(strArr.join(''));
			});
			panelDom.html(strArrAll.join(''));
		},
		initEvent:function(){
			var me = this;
			// me.container.on('click', '.types-item', function(){
			// 	var el = $(this),id = el.attr('data-id');
			// 	if(id){
			// 		me.changeMode(id, el);
			// 	}
			// });
			me.getPanelDom().on('click', '.types-item', function() {
				var el = $(this),id = el.attr('data-id');
				if(id){
					me.changeMode(id, el);
				}
			});

			/*Games.getCurrentGame().addEvent('afterSwitchGameMethod', function(obj, id){
				// console.log('daf');
				var el = me.getPanelDom().find('dd[data-id=' + id + ']'),
					cls = 'types-item-current',
					cls2 = 'gametypes-sort-current';
				me.getPanelDom().find('.types-item').removeClass(cls);
				el.addClass(cls);
				// console.log(el)
				//显示大面板
				me.getPanelDom().children().removeClass(cls2);
				el.parents('.gametypes-sort').addClass(cls2);
			});*/

			me.container.on('click', '.title', function(){
				// $(this).parents('ul').find('li').removeClass('hover')

				// me.container.find('.content').hide();
				// $(this).parents('li').find('.content').show();
				// $(this).parents('li').addClass('hover');
				// var id =$(this).next('div.content').find('dd.types-item:first').attr('data-id');

				

				// Games.getCurrentGame().getCurrentGameMethod().container.find('.number-select-link').hide();
				// me.changeMode(id);
				var idx = $(this).parent().index(),
					$parent = $(this).parents('ul').find('li'),
					$panel = me.getPanelDom().find('.gametypes-sort');
				$parent.removeClass('current').eq(idx).addClass('current');
				$panel.hide().removeClass('current').eq(idx).addClass('current').show();

				var id = $panel.eq(idx).find('dd.types-item:first').attr('data-id');

				
				// Games.getCurrentGame().getCurrentGameMethod().container.find('.number-select-link').hide();
				me.changeMode(id);


				/*var el = $(this),
					parent = el.parent(),
					lis = parent.parent().children(),
					index = lis.index(parent.get(0)),
					panel = me.getPanelDom().find('.gametypes-sort').eq(index),
					dom = panel.find('.types-item').eq(0),
					id = dom.attr('data-id');
				// console.log(id,index, dom)
				me.changeMode(id, dom);*/
			});

			me.container.on('click', '.gametypes-menu-toggle', function(){
				me.fireEvent('afterGametypesChange', this);
			});
		},
		//获取外部容器DOM
		getContainerDom: function(){
			return this.container;
		},
		getPanelDom:function(){
			return this.panelDom || (this.panelDom = $('#J-gametyes-menu-panel'));
		},
		//切换事件
		changeMode: function(mode, el){
			var me = this,
				container = me.getContainerDom();

			//执行自定义事件
			me.fireEvent('beforeChange', mode);
			try{
				if(mode == Games.getCurrentGame().getCurrentGameMethod().getGameMethodName()){
					return;
				}
			}catch(e){
			}
			//执行切换
			Games.getCurrentGame().switchGameMethod(mode);
		}
	};

	var Main = host.Class(pros, Event);
		Main.defConfig = defConfig;
		Main.getInstance = function(cfg){
			return instance || (instance = new Main(cfg));
		};
	host[name] = Main;

})(dsgame, "GameTypes", dsgame.Event);











//游戏订单模块
(function(host, name, Event, undefined) {
	var defConfig = {
			//事件监听容器
			containerEvent: '#J-panel-order-list-cont',
			//主面板dom
			containerDom: '#J-balls-order-container',
			//总注数dom
			totalLotterysNumDom: '#J-gameOrder-lotterys-num',
			//选择的奖金组
			totalBounsLists: '#J-bouns-lists-value',
			//总金额dom
			totalAmountDom: '#J-gameOrder-amount',
			//总返点dom
			totalRebateDom: '#J-rebate-amount',
			//当注单被选中时的样式
			selectedClass: 'game-order-current',
			//每行投注记录html模板
			//rowTemplate: '<li data-param="action=reselect&id=<#=id#>" id="gameorder-<#=id#>"><div class="result"><span class="moneyUnitText"><#=moneyUnitText#></span><span class="bet"><#=num#>注</span><span class="multiple"><#=multiple#>倍</span><span class="price"><span>&yen;</span><#=amountText#></span><span class="close"><a data-param="action=del&id=<#=id#>" href="javascript:void(0);" title="删除">删除</a></span></div><span>[<#=typeText#>]</span><span><#=lotterysText#></span></li>',
			rowTemplate: '<li data-param="action=reselect&id=<#=id#>&mid=<#=mid#>" id="gameorder-<#=id#>">'
						+'	<span data-param="action=reselect&id=<#=id#>" class="name" title="<#=typeText#>"><#=typeText#></span>'
						+'	<span data-param="action=reselect&id=<#=id#>" class="number" title="<#=lotterysText#>"><#=lotterysText#></span>'
						+'	<span data-param="action=reselect&id=<#=id#>" class="unit"><#=moneyUnitText#></span>'
						+'	<span data-param="action=reselect&id=<#=id#>" class="bet"><#=num#>注</span>'
						+'	<span data-param="action=reselect&id=<#=id#>" class="multiple"><#=multiple#>倍</span>'
						+'	<span data-param="action=reselect&id=<#=id#>" class="price"><span>&yen;</span><#=amountText#></span>'
						+'	<span data-param="action=reselect&id=<#=id#>" class="prizeGroup" prizeGroup="<#=prizeGroup#>" >返<#=prizeGroupVal#>元</span>'
						+'	<a data-param="action=del&id=<#=id#>" href="javascript:void(0);" title="删除" class="delete"></a>'
						+' </li>',
			//显示内容截取字符串长度
			lotterysTextLength: 40,
			//投注按钮Dom
			addOrderDom: '#J-add-order'
		},

		//获取当前游戏
		Games = host.Games,
		instance,
		orderID = 1,
		Ts = Object.prototype.toString;
	//将来仿url类型的参数转换为{}对象格式，如 q=wahaha&key=323444 转换为 {q:'wahaha',key:'323444'}
	//所有参数类型均为字符串
	var formatParam = function(param) {
		var arr = $.trim(param).split('&'),
			i = 0,
			len = arr.length,
			paramArr,
			result = {};
		for (; i < len; i++) {
			paramArr = arr[i].split('=');
			if (paramArr.length > 0) {
				if (paramArr.length == 2) {
					result[paramArr[0]] = paramArr[1];
				} else {
					result[paramArr[0]] = '';
				}
			}
		}
		return result;
	};

	var pros = {
		init: function(cfg) {
			var me = this,
				cfg = me.defConfig;
			me.cacheData = {};
			me.cacheData['detailPostParameter'] = {};
			me.orderData = [];
			Games.setCurrentGameOrder(me);
			me.container = $(cfg.containerDom);
			me.containerEvent = $(cfg.containerEvent);
			me.totalLotterysNum = 0;
			me.totalLotterysNumDom = $(cfg.totalLotterysNumDom);
			me.totalAmount = 0.00;
			//me.totalBounsLists = $(cfg.)
			me.totalAmountDom = $(cfg.totalAmountDom);
			me.totalRebateDom = $(cfg.totalRebateDom);
			me.currentSelectId = 0;

			me.eventProxy();

			//当添加数据发生时，触发追号面板相关变更
			me.addEvent('afterAdd', function() {
				var tableType = Games.getCurrentGameTrace().getRowTableType();
				if (Games.getCurrentGameTrace().getIsTrace() == 1) {
					//Games.getCurrentGameTrace().updateOrder();
					Games.getCurrentGameTrace().autoDeleteTrace();
				}
			});
			//删除
			me.addEvent('afterRemoveData', function() {
				var tableType = Games.getCurrentGameTrace().getRowTableType();
				if (Games.getCurrentGameTrace().getIsTrace() == 1) {
					Games.getCurrentGameTrace().autoDeleteTrace();
				}
			});
			//清空
			me.addEvent('afterResetData', function() {
				var tableType = Games.getCurrentGameTrace().getRowTableType();
				if (Games.getCurrentGameTrace().getIsTrace() == 1) {
					Games.getCurrentGameTrace().autoDeleteTrace();
				}
			});

			//当发生玩法面板切换时，触发取消注单的选择状态
			Games.getCurrentGameTypes().addEvent('endChange', function() {
				me.cancelSelectOrder();
			});

		},
		setTotalLotterysNum: function(v) {
			var me = this,
				oldNum = me.totalLotterysNum;
			me.totalLotterysNum = Number(v);
			me.totalLotterysNumDom.html(v);
			if (oldNum != me.totalLotterysNum) {
				me.fireEvent('afterChangeLotterysNum', me.totalLotterysNum);
			}
		},
		setTotalAmount: function(v) {
			var me = this,
				oldAmout = me.totalAmount;
			me.totalAmount = Number(v);
			me.totalAmountDom.html(me.formatMoney(v));
			if (oldAmout != me.totalAmount) {
				me.fireEvent('afterChangeAmout', me.totalAmount);
			}
		},
		setTotalRebate: function(v) {
			var me = this,
				oldRebate = me.totalRebate,
				v = v || 0,
				numPoint = Math.pow(10,6); // 用于解决计算小数时出现浮点数计算不准确的bug
			v = '' + parseFloat(v * numPoint / numPoint );
			v = v.split('.')
			if( v[1] ){
				var digit = ''+v[1];
				if( digit.length > 6 ){
					digit = digit.slice(0,6);
				}
				str = host.util.formatMoney(v[0],0) + '.' + digit;
			}else{
				str = host.util.formatMoney(v[0],2)
			}
			me.totalRebate = Number(str);
			me.totalRebateDom.html(str);
			if (oldRebate != me.totalRebate) {
				me.fireEvent('afterChangeRebate', me.totalRebate);
			}
		},
		addData: function(order) {
			var me = this;
			me.orderData.unshift(order);
		},
		getOrderById: function(id) {
			var me = this,
				id = Number(id),
				orderData = me.orderData,
				i = 0,
				len = orderData.length;

			for (i = 0; i < len; i++) {
				if (Number(orderData[i]['id']) == id) {
					return orderData[i];
				}
			}
		},
		removeData: function(id) {
			var me = this,
				id = Number(id),
				data = me.orderData,
				i = 0,
				len = data.length;
			for (; i < len; i++) {
				if (data[i]['id'] == id) {
					me.fireEvent('beforeRemoveData', data[i]);
					me.orderData.splice(i, 1);
					me.updateData();
					me.fireEvent('afterRemoveData');
					break;
				}
			}
			$('#gameorder-' + id).remove();
			me.fireEvent('afterRemoveData');
		},
		reSet: function() {
			var me = this;

			me.container.empty();
			me.orderData = [];
			me.updateData();
			me.fireEvent('afterResetData');

			return me;
		},
		updateData: function() {
			var me = this,
				total = me.getTotal();
			//
			//显示所有订单信息.......
			//方案注数 1000注，金额 ￥2000.00 元
			//console.log(total)
			me.setTotalLotterysNum(total['count']);
			me.setTotalAmount(total['amount']);
			me.setTotalRebate(total['rebate']);
		},
		getTotal: function() {
			var me = this,
				data = me.orderData,
				i = 0,
				len = data.length,
				count = 0,
				amount = 0,
				rebate = 0;
			for (; i < len; i++) {
				count += data[i]['num'];
				amount += (data[i]['num'] * data[i]['onePrice'] * data[i]['moneyUnit'] * data[i]['multiple']);
				rebate += Number(data[i]['prizeGroupVal']);
			}
			return {
				'count': count,
				'amount': amount,
				'rebate': rebate,
				'orders': data
			};
		},
		//获取订单允许设置的最大倍数(通过获取每个玩法倍数限制的最小值)
		//返回值 {gameMethod:'玩法名称',maxnum:999}
		getOrderMaxMultiple: function() {
			var me = this,
				methodCfg, limit, orders = me.getTotal()['orders'],
				i = 0,
				type, len = orders.length,
				mid, multiple,
				arr = [],
				typeText = '',
				maxNum;
			for (; i < len; i++) {
				mid = orders[i]['mid'];
				multiple = orders[i]['multiple'];
				methodCfg = Games.getCurrentGame().getGameConfig().getInstance().getPrizeById(mid);
				type = Games.getCurrentGame().getGameConfig().getInstance().getMethodFullNameById(mid);
				if (!methodCfg || !methodCfg['max_multiple']) {
					typeText = Games.getCurrentGame().getGameConfig().getInstance().getMethodCnFullNameById(mid).join('');
					alert('[' + typeText + ']\n玩法未配置奖金组中奖金额，投注倍数未能得到限制\n请配置该玩法相关配置');
					return;
				}
				limit = methodCfg['max_multiple'];
				maxNum = Number(limit) < 0 ? 99999999 : Number(limit);
				arr.push({
					'gameMethod': type,
					'maxnum': Math.floor(maxNum / multiple)
				});
			}
			arr.sort(function(a, b) {
				return a['maxnum'] - b['maxnum'];
			});
			if (arr.length > 0) {
				return arr[0];
			} else {
				return {
					'gameMethod': '',
					'maxnum': 100000000
				}
			}
		},
		//添加一条投注
		//order 参数可为单一对象或数组
		//接收参数 order {type:'玩法类型',lotterys:'投注具体数据',moneyUnit:'元角模式',num:'注数',multiple:'倍数',onePrice:'单价',prizeGroup:'返点'}
		add: function(order) {
			var me = this,
				html = '',
				sameIndex = -1,
				tpl = me.defConfig.rowTemplate,
				i = 0,
				j = 0,
				isTrace = Games.getCurrentGameTrace().getIsTrace(),
				len,
				len2;

			me.fireEvent('beforeAdd', order);

			if (order['lotterys'] && order['lotterys'].length > 0) {

				//判断是否为编辑注单
				if (me.currentSelectId > 0) {
					order['id'] = me.currentSelectId;
				} else {
					sameIndex = me.checkData(order);
					//发现有相同注，则增加倍数
					if (sameIndex != -1) {
						Games.getCurrentGameMessage().show({
							type: 'normal',
							closeText: '确定',
							closeFun: function() {
								me.addMultiple(order['multiple'], order['prizeGroupVal'], sameIndex);
								this.hide();
							},
							data: {
								tplData: {
									msg: '您选择的号码在号码篮已存在，将直接进行倍数累加'
								}
							}
						});
						return;
					}
					//新增唯一id标识
					order['id'] = orderID++;
				}

				//如果追号面板被打开，则修改倍数为1倍 (修改说明：机制修改为当修改注单时，自动取消追号)
				//order['multiple'] = !!isTrace ? 1 : order['multiple'];
				order['amountText'] = me.formatMoney(order['num'] * order['moneyUnit'] * order['multiple'] * order['onePrice']);

				// order['prizeGroup'] = Games.getCurrentGame().getGameConfig().getInstance().getOptionalPrizes()['me.getValue()']['rate'];
				//如果追号面板打开，并且正在操作盈利追号或盈利率追号，则不允许进行混投
				//清空所有追号列表
				if (!!isTrace && (Games.getCurrentGameTrace().getRowTableType() == 'yingli' || Games.getCurrentGameTrace().getRowTableType() == 'yinglilv')) {
					//不允许混投
					for (j = 0, len2 = me.orderData.length; j < len2; j++) {
						if (me.orderData[j]['type'] != order['type'] || me.orderData[j]['moneyUnit'] != order['moneyUnit']) {
							alert('盈利追号和盈利率追号不允许混投，\n 请确保玩法类型和元角模式一致');
							return;
						}
					}
				}
				//原始选球数据
				order['postParameter'] = Games.getCurrentGame().getCurrentGameMethod().makePostParameter(order['original'], order);
				//倍数备份，用于恢复原始选择的倍数
				order['oldMultiple'] = order['multiple'];

				html = me.formatRow(tpl, me.rebuildData(order));

				//是修改，则替换原有的order对象
				if (me.currentSelectId > 0) {
					me.replaceOrder(order['id'], order);
				} else {
					me.addData(order);
				}

			} else {
				return;
			}


			//如果是修改注单则删除原有的dom
			if (me.currentSelectId > 0) {
				$(html).replaceAll($('#gameorder-' + me.currentSelectId));
				me.cancelSelectOrder();
			} else {
				$(html).prependTo(me.container);
			}

			//复位选球区
			Games.getCurrentGame().getCurrentGameMethod().reSet();

			Games.getCurrentGameStatistics().reSet();

			me.updateData();
			me.fireEvent('afterAdd', order);

		},
		//替换某个Order注单对象
		replaceOrder: function(id, newOrder) {
			var me = this,
				orders = me.orderData,
				i = 0,
				len = orders.length;
			for (; i < len; i++) {
				if (orders[i]['id'] == id) {
					orders[i] = newOrder;
					return;
				}
			}
		},
		render: function() {
			var me = this,
				orders = me.getTotal()['orders'],
				i = 0,
				len = orders.length,
				html = [],
				tpl = me.defConfig.rowTemplate;
			for (; i < len; i++) {
				html[i] = me.formatRow(tpl, me.rebuildData(orders[i]));
			}
			me.updateData();
			me.container.html(html.join(''));
		},
		//填充其他数据用户界面显示
		//格式化后的数据 {typeText:'玩法类型名称',type:'玩法类型名称(英文)',lotterys:'投注具体内容',lotterysText:'显示投注具体内容的文本',moneyUnit:'元角模式',moneyUnitText:'显示圆角模式文字',num:'注数',multiple:'倍数',amount:'总金额',amountText:'显示的总金额',onePrice:'单价'}
		rebuildData: function(order) {
			var me = this,
				cfg = me.defConfig,
				gameConfig = Games.getCurrentGame().getGameConfig().getInstance(),
				type =	gameConfig.getMethodCnFullNameById(order['mid'])
				typeText = gameConfig.getMethodCnFullNameById(order['mid']).join(','),
				method = Games.getCurrentGame().getCacheMethod(order['mid']);
			//名称全部一直时处理
			if(type[0] == type[1] && type[1] == type[2]){
			    typeText = gameConfig.getMethodCnFullNameById(order['mid'])[2];
			};
			order['typeText'] = typeText;
			//order['lotterysText'] = order['postParameter'];
			order['lotterysText'] = method.formatViewBalls(order['original']).substr(0, 200);
			order['viewBalls'] = order['lotterysText'];
			order['moneyUnitText'] = order['moneyUnitText'] || Games.getCurrentGameStatistics().getMoneyUnitDom().getText();

			return order;
		},
		formatRow: function(tpl, order) {
			var me = this,
				o = order,
				p, reg;
			for (p in o) {
				if (o.hasOwnProperty(p)) {
					reg = RegExp('<#=' + p + '#>', 'g');
					tpl = tpl.replace(reg, o[p]);
				}
			}
			return tpl;
		},
		//从投注结果返回原始数据
		//用来向后台POST原始结果
		originalData: function(data) {

			var me = this,
				v = [];
			for (var i = 0; i < data.length; i++) {
				for (var j = 0; j < data[i].length; j++) {
					v[j] = v[j] || [];
					if (!me.arrIndexOf(data[i][j], v[j])) {
						v[j].push(data[i][j]);
					}
				}
			}
			return v;
		},
		//检查数组存在某数
		arrIndexOf: function(value, arr) {
			var r;
			for (var s = 0; s < arr.length; s++) {
				if (arr[s] == value) {
					r = true;
				};
			}
			return r || false;
		},
		/**
		 * [判断参数是否重复]
		 * @return {[type]} [description]
		 */
		checkData: function(order) {
			var original, current, name,prizeGroup,
				me = this,
				saveArray = [],
				i = 0,
				_index,
				len;
			name = order['type'];
			original = order['original'];
			prizeGroup = order['prizeGroup'];
			for (var i = 0; i < original.length; i++) {
				saveArray.push(original[i].join(''));
			};
			moneyUnit = order['moneyUnit'];
			//返回对象在数组的索引值index
			//未找到返回-1
			return me.searchSameResult(name, saveArray.join(), moneyUnit,prizeGroup);
		},
		eventProxy: function() {
			var me = this,
				panel = me.containerEvent;
			panel.on('click', function(e) {
				var q = e.target.getAttribute('data-param'),
					param;
				if (q && $.trim(q) != '') {
					param = formatParam(q);
					if ($.isFunction(me['exeEvent_' + param['action']])) {
						me['exeEvent_' + param['action']].call(me, param, e.target);
					}
				}
			});
		},
		exeEvent_del: function(param) {
			var me = this,
				id = Number(param['id']);
			if (me.currentSelectId == id) {
				Games.getCurrentGame().getCurrentGameMethod().reSet();
				me.cancelSelectOrder();
			}
			me.removeData(id);
		},
		exeEvent_detailhide: function(params, el) {
			$(el).parents('.lottery-details-area').eq(0).hide();
		},
		exeEvent_detail: function(param, el) {
			var me = this,
				el = $(el),
				index = Number(param['id']),
				id = index,
				dom = el.next(),
				multipleArea = dom.find('.multiple'),
				result = dom.find('.list'),
				currentData = me.getTotal().orders,
				html = '';


			//隐藏之前打开的内容容器
			//避免遍历
			if (me.cacheData['currentDetailId']) {
				$('#gameorder-' + me.cacheData['currentDetailId'] + ' .lottery-details-area').hide();
			}
			//判断是否有缓存结果
			if (me.cacheData['detailPostParameter'][id]) {
				html = me.cacheData['detailPostParameter'][id];
				//缓存面板
				me.cacheData['currentDetailId'] = id;
			} else {
				//获取结果
				for (var i = currentData.length - 1; i >= 0; i--) {
					if (currentData[i]['id'] == index) {
						currentData = currentData[i];
						break;
					}
				}
				//填充结果
				multipleArea.text('共 ' + currentData.num + ' 注');
				html = currentData['postParameter'];
				//缓存面板
				me.cacheData['currentDetailId'] = id;
				//缓存结果
				me.cacheData['detailPostParameter'][id] = html;
				//位置调整
				dom.css({
					left: dom.position().left + dom.width() + 5
				});
			}
			//渲染DOM
			result.html(html);
			//显示结果
			dom.show();
		},
		//号码篮点击事件
		exeEvent_reselect: function(param) {
			var me = this,id = Number(param['id']);
			me.selectOrderById(id);
		},
		//界面状态更新
		updateDomStatus: function() {
			var me = this,
				className = 'button-game-edit',
				id = me.currentSelectId,
				addOrderButtonDom = $(me.defConfig.addOrderDom);

			if (id > 0) {
				//设置添加投注按钮样式
				addOrderButtonDom.addClass(className);
			} else {
				addOrderButtonDom.removeClass(className);
			}
		},
		//选择一个注单
		selectOrderById: function(id) {
			var me = this,
				order = me.getOrderById(id),
				original = order['original'],
				type = order['type'],
				cls = me.defConfig.selectedClass,
				dom = $('#gameorder-' + id);

			//单式不能反选
			if (me.getOrderById(id)['type'].indexOf('danshi') != -1) {
				return;
			}

			//修改选中样式
			dom.parent().children().removeClass(cls);
			dom.addClass(cls);

			//反选球
			//切换玩法面板
			Games.getCurrentGameTypes().changeMode(order['mid']);

			//设置倍数、元角模式
			Games.getCurrentGameStatistics().getMultipleDom().setValue(order['multiple']);
			// Games.getCurrentGameStatistics().getMoneyUnitDom().setValue(order['moneyUnit']);
			Games.getCurrentGameStatistics().triggerMoneyUnit(order['moneyUnit']);

			// 设置返点
			Games.getCurrentGameStatistics().setSliderValueByPrizeGroup(order['prizeGroup']);

			//反选球
			Games.getCurrentGame().getCurrentGameMethod().reSelect(original);

			//标记当前选中注单
			me.currentSelectId = id;

			//更新界面
			me.updateDomStatus();

			//反选后将滚动条位置移动到合适位置
			//$(window).scrollTop($('#J-play-select').offset()['top']);
		},
		//取消选择的注单
		cancelSelectOrder: function() {
			var me = this,
				id = me.currentSelectId,
				addOrderButtonDom = $(me.defConfig.addOrderDom);

			if (id > 0) {
				$('#gameorder-' + id).removeClass(me.defConfig.selectedClass);
				me.currentSelectId = 0;
				//更新界面
				me.updateDomStatus();

				Games.getCurrentGame().getCurrentGameMethod().reSet();
			}
		},
		//将数字保留两位小数并且千位使用逗号分隔
		formatMoney: function(num) {
			var num = Number(num),
				re = /(-?\d+)(\d{3})/;

			if (Number.prototype.toFixed) {
				num = (num).toFixed(3);
			} else {
				num = Math.round(num * 100) / 100
			}
			num = '' + num;
			while (re.test(num)) {
				num = num.replace(re, "$1,$2");
			}
			return num;
		},
		/**
		 * 查询同类玩法重复结果
		 * @param  {string} name [游戏玩法 例:wuxing.zhixuan.danshi]
		 * @param  {string} data [投注号码 例:12345]
		 */
		searchSameResult: function(name, lotteryText, moneyUnit, prizeGroup) {
			var me = this,
				current, dataNum,
				i = 0,
				saveArray = [],
				data = me.getTotal().orders;
			for (; i < data.length; i++) {
				saveArray = [];
				current = data[i];
				ordersLotteryText = current['original'];
				for (var k = 0; k < ordersLotteryText.length; k++) {
					saveArray.push(ordersLotteryText[k].join(''));
				};
				if (current.type == name && lotteryText == saveArray.join() && current.moneyUnit == moneyUnit && prizeGroup == current.prizeGroup) {
					return i;
				}
			}
			return -1;
		},
		//增加某注倍数
		addMultiple: function(num, rebate, index) {
			var me = this,
				orders = me.getTotal()['orders'],
				order = orders[index],
				type = order['type'],
				id = order['mid'],
				maxNum = 999999;
			if (Games.getCurrentGameTrace().getIsTrace() == 1) {
				return;
			}
			maxNum = Games.getCurrentGame().getGameConfig().getInstance().getLimitByMethodId(id, order['moneyUnit']);
			//修改若为限制投注金额则不限制最大倍数
			maxNum = maxNum < 0 ? order['multiple']+num : maxNum;

			if ((order['multiple'] + num) > maxNum) {
				setTimeout(function() {
					Games.getCurrentGameMessage().show({
						type: 'normal',
						closeText: '确定',
						closeFun: function() {

							orders[index]['multiple'] = maxNum
							orders[index]['oldMultiple'] = orders[index]['multiple'];
							orders[index]['amount'] = orders[index]['num'] * orders[index]['moneyUnit'] * orders[index]['multiple'] * orders[index]['onePrice'];
							orders[index]['amountText'] = me.formatMoney(orders[index]['num'] * orders[index]['moneyUnit'] * orders[index]['multiple'] * orders[index]['onePrice']);
							orders[index]['prizeGroupVal'] = Number(orders[index]['prizeGroupVal']);
							me.render();

							//复位选球区
							Games.getCurrentGame().getCurrentGameMethod().reSet();
							//游戏错误提示
							//主要用于单式投注进行错误提示
							Games.getCurrentGame().getCurrentGameMethod().ballsErrorTip();
							Games.getCurrentGameStatistics().reSet();

							this.hide();
						},
						data: {
							tplData: {
								msg: '该组号码倍数已经超过最大限制(' + maxNum + '倍)，将调整为系统支持的最大倍数进行添加'
							}
						}
					});
				}, 100);
				return;
			}



			orders[index]['multiple'] += num;
			orders[index]['oldMultiple'] = orders[index]['multiple'];
			orders[index]['amount'] = orders[index]['num'] * orders[index]['moneyUnit'] * orders[index]['multiple'] * orders[index]['onePrice'];
			orders[index]['amountText'] = me.formatMoney(orders[index]['num'] * orders[index]['moneyUnit'] * orders[index]['multiple'] * orders[index]['onePrice']);
			orders[index]['prizeGroupVal'] = Number(orders[index]['prizeGroupVal']) + Number(rebate);
			me.render();

			//复位选球区
			Games.getCurrentGame().getCurrentGameMethod().reSet();
			//游戏错误提示
			//主要用于单式投注进行错误提示
			Games.getCurrentGame().getCurrentGameMethod().ballsErrorTip();
			Games.getCurrentGameStatistics().reSet();

			me.cancelSelectOrder();
		},
		//修改所有投注倍数
		editMultiples: function(num) {
			var me = this,
				orders = me.getTotal()['orders'],
				i = 0,
				len = orders.length;
			for (; i < len; i++) {
				orders[i]['multiple'] = num;
				orders[i]['amount'] = orders[i]['num'] * orders[i]['moneyUnit'] * orders[i]['multiple'] * orders[i]['onePrice'];
				orders[i]['amountText'] = me.formatMoney(orders[i]['amount']);
			}
			me.render();

			me.cancelSelectOrder();
		},
		//修改单注投注倍数
		editMultiple: function(num, index) {
			var me = this,
				orders = me.getTotal()['orders'];
			orders[index]['multiple'] = num;
			orders[index]['amount'] = orders[index]['num'] * orders[index]['moneyUnit'] * orders[index]['multiple'] * orders[index]['onePrice'];
			orders[index]['amountText'] = me.formatMoney(orders[i]['amount']);
			me.render();

			me.cancelSelectOrder();
		},
		//恢复原来的投注的倍数
		restoreMultiples: function() {
			var me = this,
				orders = me.getTotal()['orders'],
				i = 0,
				len = orders.length;
			for (; i < len; i++) {
				orders[i]['multiple'] = orders[i]['oldMultiple'];
				orders[i]['amount'] = orders[i]['num'] * orders[i]['moneyUnit'] * orders[i]['multiple'] * orders[i]['onePrice'];
				orders[i]['amountText'] = me.formatMoney(orders[i]['amount']);
			}
			me.render();

			me.cancelSelectOrder();
		}
	};

	var Main = host.Class(pros, Event);
	Main.defConfig = defConfig;
	Main.getInstance = function(cfg) {
		return instance || (instance = new Main(cfg));
	};
	host[name] = Main;

})(dsgame, "GameOrder", dsgame.Event);

//追号区域
(function(host, name, Event, undefined){
	var defConfig = {
		//主面板dom
		mainPanel:'#J-trace-panel',
		//高级追号类型(与tab顺序对应)
		advancedTypeHas:['fanbei','yingli','yinglilv'],
		// 默认的追号类型
		defaultType: 'tongbei',
		//追号数据表头
		dataRowHeader:'<tr><th style="width:125px;" class="text-center">序号</th><th><input data-action="checkedAll" type="checkbox"  checked="checked"/> 追号期次</th><th>倍数</th><th>金额</th><th>预计开奖时间</th></tr>',
		//追号数据列表模板
		dataRowTemplate:'<tr><td class="text-center"><#=No#></td><td><input data-action="checkedRow" class="trace-row-checked" type="checkbox" checked="checked"> <span class="trace-row-number"><#=traceNumber#></span></td><td><input class="trace-row-multiple input" value="<#=multiple#>" type="text" style="width:30px;text-align:center;"> 倍</td><td>&yen; <span class="trace-row-money"><#=money#></span> 元</td><td><span class="trace-row-time"><#=publishTime#></span></td></tr>',
		//高级追号盈利金额追号/盈利率追号表模板
		dataRowYingliHeader:'<tr><th class="text-center">序号</th><th><input data-action="checkedAll" type="checkbox" checked="checked" /> 追号期次</th><th>倍数</th><th>金额</th><th>奖金</th><th>预期盈利金额</th><th>预期盈利率</th></tr>',
		//lirunlv
		dataRowLirunlvTemplate:'<tr><td class="text-center"><#=No#></td><td><input data-action="checkedRow" class="trace-row-checked" type="checkbox" checked="checked"> <span class="trace-row-number"><#=traceNumber#></span></td><td><input class="trace-row-multiple" value="<#=multiple#>" type="text" style="width:30px;text-align:center;"> 倍</td><td>&yen; <span class="trace-row-money"><#=money#></span> 元</td><td>&yen; <span class="trace-row-userGroupMoney"><#=userGroupMoney#></span> 元</td><td>&yen; <span class="trace-row-winTotalAmount"><#=winTotalAmout#></span> 元</td><td><span class="trace-row-yinglilv"><#=yinglilv#></span>%</td></tr>'
	},
	instance,
	Games = host.Games;

	//只允许输入正整数
	//v 值
	//def 默认值
	//mx 最大值
	var checkInputNum = function(v, def, mx){
		var v = ''+v,mx = mx || 1000000000;
		v = v.replace(/[^\d]/g, '');
		v = v == '' ? def : (Number(v) >  mx ? mx : v);
		return Number(v);
	};

	//只允许输入正整数
	var checkInputNumber = function(v){
		v = v.replace(/[^\d]/g, '');
		return Number(v);
	};


	var pros = {
		init:function(cfg){
			var me = this;
			me.opts = cfg;
			Games.setCurrentGameTrace(me);
			me.panel = $(cfg.mainPanel);

			// 追号区是否可见
			me.panelIsVisible = false;

			//追号tab
			me.TraceTab = null;
			//高级追号tab
			me.TraceAdvancedTab = null;

			//订单数据
			me.orderData = null;

			//公共属性部分
			//追号类型，普通追号 高级追号
			me.traceType = cfg.defaultType;
			//追号期数
			me.times = 0;
			//追号起始期号
			me.traceStartNumber = '';
			//当前期号
			me.currentTraceNumber = '';
			//是否有追号
			me.isTrace = 0;
			//追号信息的缓存
			me.savedTraceData = null;

			//普通追号属性


			//高级追号属性
			//高级追号类型
			me.advancedType = cfg.advancedTypeHas[0];
			me.typeTypeType = 'a';


			me.initEvent();
			me.setCurrentTraceNumber();


			//配置更新后追号面板相关更新
			//重新构建期号选择列表
			Games.getCurrentGame().addEvent('changeDynamicConfig', function(){
				me.buildStartNumberSelectDom();
				me.updateTableNumber();
			});

		},
		getIsTrace:function(){
			return this.isTrace;
		},
		setIsTrace:function(v){
			this.isTrace = Number(v);
			if( v < 1 ){
				$('#J-button-trace-confirm').addClass('disable');
			}else{
				$('#J-button-trace-confirm').removeClass('disable');
			}
		},
		setAdvancedType:function(i){
			if(Object.prototype.toString.call(i) == '[object Number]'){
				this.advancedType = this.getAdvancedTypeBuIndex(i);
			}else{
				this.advancedType = i;
			}
		},
		getAdvancedType:function(){
			return this.advancedType;
		},
		getAdvancedTypeBuIndex:function(i){
			var me = this,has = me.defConfig.advancedTypeHas,len = has.length;
			if(i < len){
				return has[i];
			}
			return '';
		},
		initEvent:function(){
			var me = this;

			//追号tab
			me.TraceTab = new host.Tab({par:'#J-trace-panel',triggers:'.trace-radio a',panels:'.chase-tab-content',currPanelClass:'chase-tab-content-current',eventType:'click'});
			me.TraceTab.addEvent('afterSwitch', function(e, i){
				// var types = ['notrace','tongbei', 'lirunlv','fanbei'],
				// 	type = types[i] || '';
				// if( type && type != 'notrace' ){
				// 	if( !me.panelIsVisible ){
				// 		me.showPanel();
				// 	}
				// 	me.setTraceType( type );
				// }else{
				// 	me.hidePanel();
				// 	me.deleteTrace();
				// }
				var types = ['tongbei', 'lirunlv','fanbei'];
//				console.log(i,types[i])
				if(i < types.length){
					me.setTraceType(types[i]);
				}
				me.updateStatistics();
			});
			//高级追号tab
			me.TraceAdvancedTab = new host.Tab({par:'#J-trace-advanced-type-panel',triggers:'.tab-title li',panels:'.tab-content li',eventType:'click'});
			me.TraceAdvancedTab.addEvent('afterSwitch', function(e, i){
				var ipts = this.getPanel(i).find('.trace-advanced-type-switch');
				me.setAdvancedType(i);
				ipts.each(function(){
					if(this.checked){
						me.setTypeTypeType($(this).parent().attr('data-type'));
						return false;
					}
				});
			});

			//追中即停说明提示
			var TraceTip1 = new host.Hover({triggers:'#J-trace-iswintimesstop-hover',panels:'#chase-stop-tip-1',currPanelClass:'chase-stop-tip-current',hoverDelayOut:300});
			$('#chase-stop-tip-1').mouseleave(function(){
				TraceTip1.hide();
			});
			// var TraceTip2 = new host.Hover({triggers:'#J-trace-iswinstop-hover',panels:'#chase-stop-tip-2',currPanelClass:'chase-stop-tip-current',hoverDelayOut:300});
			// $('#chase-stop-tip-2').mouseleave(function(){
			// 	TraceTip2.hide();
			// });
			$('#J-chase-stop-switch-1').click(function(e){
				e.preventDefault();
				$('#J-trace-iswintimesstop-panel').hide();
				$('#J-trace-iswinstop-panel').show();
				$('#J-trace-iswintimesstop').get(0).checked = false;
				$('#J-trace-iswinstop').get(0).checked = true;
				$('#J-trace-iswinstop-money').removeAttr('disabled');
				$('#J-trace-iswintimesstop-times').attr('disabled', 'disabled');
			});
			$('#J-chase-stop-switch-2').click(function(e){
				e.preventDefault();
				$('#J-trace-iswinstop-panel').hide();
				$('#J-trace-iswintimesstop-panel').show();
				$('#J-trace-iswintimesstop').get(0).checked = true;
				$('#J-trace-iswinstop').get(0).checked = false;
				$('#J-trace-iswinstop-money').attr('disabled', 'disabled');
				$('#J-trace-iswintimesstop-times').removeAttr('disabled');
			});
			$('#J-trace-iswinstop-money').keyup(function(){
				this.value = checkInputNum(this.value, 1, 999999);
			});
			$('#J-trace-iswintimesstop-times').keyup(function(){
				this.value = checkInputNum(this.value, 1, 999999);
			});

			//是否止盈追号(按中奖次数)
			$('#J-trace-iswintimesstop').click(function(){
				var ipt = $('#J-trace-iswintimesstop-times');
				if(this.checked){
					ipt.attr('disabled', false).focus();
				}else{
					ipt.attr('disabled', 'disabled');
				}
			});
			//是否止盈追号(按中奖金额)
			$('#J-trace-iswinstop').click(function(){
				var ipt = $('#J-trace-iswinstop-money');
				if(this.checked){
					ipt.attr('disabled', false).focus();
				}else{
					ipt.attr('disabled', 'disabled');
				}
			});

			//普通追号事件
			//普通追号Input输入事件
			$('#J-trace-normal-times').keyup(function(){
				var	maxnum = Games.getCurrentGame().getGameConfig().getInstance().getTraceMaxTimes(),
					v = '' + this.value,
					num,
					list = $('#J-function-select-tab').find('.function-select-title li'),
					cls = 'current';
				v = v.replace(/[^\d]/g, '');
				v = v == '' ? 1 : (Number(v) >  maxnum ? maxnum : v);
				this.value = v;
				num = Number(v);
				//修改追号期数选项样式
				if(num > 0 && num <= 20 && (num%5 == 0)){
					list.removeClass(cls).eq(num/5 - 1).addClass(cls);
				}
				me.buildDetail();
			});
			/**
			$('#J-trace-normal-times').blur(function(){
				me.buildDetail();
			});
			**/
			//期数选择操作
			var NormalSelectTimesTab = new host.Tab({par:'#J-function-select-tab',triggers:'.function-select-title li',panels:'.function-select-panel li',eventType:'click',index:1});
				NormalSelectTimesTab.addEvent('afterSwitch', function(e, i){
					var tab = this,num = parseInt(tab.getTrigger(i).text());
					$('#J-trace-normal-times').val(num);
					me.buildDetail();
				});

			/**
			//倍数模拟下拉框
			me.normalSelectMultiple = new host.Select({realDom:'#J-trace-normal-multiple',isInput:true,expands:{inputEvent:function(){
				var me = this;
				me.getInput().keyup(function(e){
					var v = this.value,
						maxnum = 99999;
					this.value = this.value.replace(/[^\d]/g, '');
					v = Number(this.value);
					if(v < 1){
						this.value = 1;
					}
					if(v > maxnum){
						this.value = maxnum;
					}
					me.setValue(this.value);
				});
			}}});
			me.normalSelectMultiple.addEvent('change', function(e, value, text){
				var amount = me.getOrderData()['amount'],num = Number(value),maxObj = Games.getCurrentGameOrder().getOrderMaxMultiple(),maxnum = maxObj['maxnum'],Msg = Games.getCurrentGameMessage(),
					typeTitle = '';

				if(num > maxnum){
					typeTitle = Games.getCurrentGame().getGameConfig().getInstance().getMethodFullName(maxNumltipleObj['gameMethod']).join('-');


					alert('您输入的倍数超过了['+ typeTitle + '] 玩法的最高倍数限制，\n\n系统将自动修改为最大可输入倍数');
					value = maxnum;
					me.normalSelectMultiple.setValue(value);
					Msg.hide();

					me.getTable().find('.trace-row-multiple').val(value);
					me.getTable().find('.trace-row-money').each(function(){
						var el = $(this),multiple = Number(el.parent().parent().find('.trace-row-multiple').val());
						el.html(me.formatMoney(amount * Number(value)));
					});
					me.updateStatistics();
				}else{
					me.getTable().find('.trace-row-multiple').val(value);
					me.getTable().find('.trace-row-money').each(function(){
						var el = $(this),multiple = Number(el.parent().parent().find('.trace-row-multiple').val());
						el.html(me.formatMoney(amount * Number(value)));
					});
					me.updateStatistics();
				}
			});
			**/

			// 同倍追号 *** START  BY JASPER
			// 倍数模拟下拉框
			me.tongbeiSelectMultiple = new host.Select({
				realDom:'#J-trace-tongbei-multiple-select',
				cls: 'w-1',
				isInput:true,
				expands:{
					inputEvent:function(){
						var me = this;
						me.getInput().keyup(function(e){
							var v = this.value,
								maxnum = 99999999;
							this.value = this.value.replace(/[^\d]/g, '');
							v = Number(this.value);
							// if(v == 0  v!=0){
							// 	this.value = 1;
							// }
							if(v > maxnum){
								this.value = maxnum;
							}
							me.setValue(this.value);
						});
					}
				}
			});
			me.tongbeiSelectMultiple.addEvent('change', function(e, value, text){
				// 验证输入是否合法，代码已注释，不确认正确与否
				// var amount = me.getOrderData()['amount'],
				// 	num = Number(value),
				// 	maxObj = Games.getCurrentGameOrder().getOrderMaxMultiple(),
				// 	maxnum = maxObj['maxnum'],
				// 	Msg = Games.getCurrentGameMessage(),
				// 	typeTitle = '';
				// if(num > maxnum){
				// 	typeTitle = Games.getCurrentGame().getGameConfig().getInstance().getMethodFullName(maxNumltipleObj['gameMethod']).join('-');


				// 	alert('您输入的倍数超过了['+ typeTitle + '] 玩法的最高倍数限制，\n\n系统将自动修改为最大可输入倍数');
				// 	value = maxnum;
				// 	me.normalSelectMultiple.setValue(value);
				// 	Msg.hide();

				// 	me.getTable().find('.trace-row-multiple').val(value);
				// 	me.getTable().find('.trace-row-money').each(function(){
				// 		var el = $(this),multiple = Number(el.parent().parent().find('.trace-row-multiple').val());
				// 		el.html(me.formatMoney(amount * Number(value)));
				// 	});
				// 	me.updateStatistics();
				// }else{
				// 	me.getTable().find('.trace-row-multiple').val(value);
				// 	me.getTable().find('.trace-row-money').each(function(){
				// 		var el = $(this),multiple = Number(el.parent().parent().find('.trace-row-multiple').val());
				// 		el.html(me.formatMoney(amount * Number(value)));
				// 	});
				// 	me.updateStatistics();
				// }
				$('#J-trace-tongbei-multiple').val(value);
			});

			$('.J-trace-tongbei-times-filter > a').on('click', function(){
				var $this = $(this),
					value = $this.data('value');
				if( $this.hasClass('current') ) return false;
				$this.addClass('current').siblings('.current').removeClass('current');
				$('#J-trace-tongbei-times').val(value);
				return false;
			}).eq(0).trigger('click');
			// 同倍追号 *** END

			//数据行限制输入正整数,(可清空,失焦自动填充一倍.首字符不能为0,单选框没选中禁用，选中初始1倍值)
			me.panel.find('.chase-table').keyup(function(e){
				var el = $(e.target),amount = me.getOrderData()['amount'];
				if(el.hasClass('trace-row-multiple')){ //处理当删除注数时，追号倍数不限制

					var multiple = Number(checkInputNumber(el.val())),
						tableType = me.getRowTableType(),
						maxnum = Number(Games.getCurrentGameOrder().getOrderMaxMultiple()['maxnum']);
					if(multiple == 0){
						el.val(el.val().replace(/^0/g, ''));
						me.updateStatistics();
					}
					else if(multiple > maxnum){
						el.val(maxnum);

					}else{
						el.parent().parent().find('.trace-row-money').html(me.formatMoney(amount * multiple));
						el.val(multiple);
						//如果是盈利追号和盈利率追号，则需要重新计算盈利金额和盈利率
						if(tableType == 'trace_advanced_yingli_a' || tableType == 'trace_advanced_yingli_b' || tableType == 'trace_advanced_yinglilv_a' || tableType == 'trace_advanced_yinglilv_b'){
							me.rebuildYinglilvRows();
						}
						me.updateStatistics();
					}
				}
			}).on('blur', '.trace-row-multiple', function(e){
				var el = $(e.target);
				el.val(checkInputNum(el.val(), 1, Games.getCurrentGameOrder().getOrderMaxMultiple()['maxnum']));
				me.updateStatistics();
			});

			//高级追号事件
			//创建期号列表
			setTimeout(function(){
				me.buildStartNumberSelectDom();
			}, 10);


			//追号期数
			$('#J-trace-advanced-times').keyup(function(){
				this.value = checkInputNum(this.value, 10, Number($('#J-trace-number-max').text()));
			});

			//起始倍数
			$('#J-trace-advance-multiple').keyup(function(e){
				var el = $(e.target),multiple = Number(checkInputNumber(el.val())),maxnum = Number(Games.getCurrentGameOrder().getOrderMaxMultiple()['maxnum']);

				if(multiple == 0){
					el.val(el.val().replace(/^0/g, ''));
				}
				else if(multiple > maxnum){
					el.val(maxnum);
				}else{
					el.val(multiple);
				}

			}).blur(function(){ //失去焦点纠正为1倍
				this.value = checkInputNum(this.value, 1, Games.getCurrentGameOrder().getOrderMaxMultiple()['maxnum']);
			});

			//高级追号填写参数切换
			me.panel.find('.trace-advanced-type-switch').click(function(){
				var el = $(this),par = el.parent(),pars = par.parent().children(),_par;
				pars.each(function(i){
					_par = pars.get(i);
					if(par.get(0) != _par){
						//alert($(_par).html());
						$(_par).find('input[type="text"]').attr('disabled', 'disabled');
					}else{
						$(_par).find('input[type="text"]').attr('disabled', false).eq(0).focus();
						me.setTypeTypeType(par.attr('data-type'));
					}

					if(el.parent().hasClass('trace-input-multiple')){
						this.value = checkInputNum(this.value, 1, Games.getCurrentGameOrder().getOrderMaxMultiple()['maxnum']);
					}else{
						this.value = checkInputNum(this.value, 1, 99999999);
					}

				});
			});
			//高级追号区域输入事件
			$('#J-trace-advanced-type-panel').on('keyup', 'input[type=text]', function(e){
				var dom = $(e.target);
				//如果是倍数输入框
				if(dom.hasClass('trace-input-multiple')){
					this.value = checkInputNum(this.value, 1, Games.getCurrentGameOrder().getOrderMaxMultiple()['maxnum']);
				}else{
					this.value = checkInputNum(this.value, 1, 99999999);
				}
			});

			//生成追号计划事件
			$('#J-trace-panel .trace-button-detail').click(function(){
				me.confirmSetting();
				me.applyTraceData();
			});

			//数据行选择行生效/失效事件
			me.panel.find('.chase-table').click(function(e){
				var el = $(e.target),action = $.trim(el.attr('data-action')),isChecked = true,tableType,type = me.getTraceType();
				if(!!action && action != ''){
					switch(action){
						case 'checkedAll':
							isChecked = !!el.get(0).checked ? true : false;
							tableType = me.getRowTableType(type);
							me.getRowTable(type).find('.trace-row-checked').each(function(){
								this.checked = isChecked;
							});
							//console.log(tableType);
							//如果是盈利追号和盈利率追号，则需要重新计算盈利金额和盈利率
							if(tableType == 'lirunlv'){
								me.rebuildYinglilvRows();
							}
							me.updateStatistics();
							break;
						case 'checkedRow':
							if(el.size() > 0){
								tableType = me.getRowTableType();
								//如果是盈利追号和盈利率追号，则需要重新计算盈利金额和盈利率
								if(tableType == 'trace_advanced_yingli_a' || tableType == 'trace_advanced_yingli_b' || tableType == 'trace_advanced_yinglilv_a' || tableType == 'trace_advanced_yinglilv_b'){
									me.rebuildYinglilvRows();
								}
								me.updateStatistics();
							}
							break;
						default:
							break;
					}
				}
			});

		},
		//创建期号列表slect元素
		buildStartNumberSelectDom:function(){
			var me = this,
				gameCfg = Games.getCurrentGame().getGameConfig().getInstance(),
				list = gameCfg.getGameNumbers(),
				len = list.length,
				i = 0,
				strArr = [],
				currentNumber = gameCfg.getCurrentGameNumber(),
				currStr = '(当前期)',
				curr = currStr,
				oldValue,
				checkedStr = '';
			if(me.traceStartNumberSelect){
				oldValue = me.traceStartNumberSelect.getValue();
			}

			for(;i < len;i++){
				curr = currentNumber == list[i]['number'] ? currStr : '';
				checkedStr = (!!me.traceStartNumberSelect && (list[i]['number'] == oldValue)) ? ' selected="selected" ' : '';
				strArr.push('<option value="'+ list[i]['number'] +'" '+ checkedStr +' >'+ list[i]['number'] + curr +'</option>');
			}
			$('#J-traceStartNumber').html(strArr.join(''));
			$('#J-trace-number-max').text(len);

			//起始号选择
			if(me.traceStartNumberSelect){
				me.traceStartNumberSelect.dom.remove();
			}
			me.traceStartNumberSelect = new host.Select({realDom:'#J-traceStartNumber',cls:'chase-trace-startNumber-select'});
			me.traceStartNumberSelect.addEvent('change', function(e, value, text){
				me.setTraceStartNumber(value);
			});
		},
		//更新表格期号
		updateTableNumber:function(){
			var me = this,list = Games.getCurrentGame().getGameConfig().getInstance().getGameNumbers(),len = list.length,trs1,trs2,
				currNumber = Games.getCurrentGame().getGameConfig().getInstance().getCurrentGameNumber(),
				startNumber,
				dom,
				numberDom,
				dateDom,
				currText = '',
				index,
				traceLastNumber = '',//上期号
				//当前期
				currStr = '<span class="icon-period-current"></span>',
				traceNo;

			//当当前期号发生更变时
			if(len > 0){
				trs1 = me.getNormalRowTable().find('tr');
				trs2 = me.getAdvancedRowTable().find('tr');

				index = me.getStartNumberIndexByNumber(startNumber);
				trs1.each(function(i){
					if(i == 0){ //当当前(普通)期号发生更变时,跳出表头不放在trs1对象中循环
						return true;
					}
					dom = $(this);
					numberDom = dom.find('.trace-row-number');//当前开奖期号
					dateDom = dom.find('.trace-row-time');
					multipleDom = dom.find('.trace-row-multiple');
					startNumber = numberDom.text().replace(/[^\d]/g, '');
					traceNo = dom.find('.text-center'); //序号
					dom.find('.trace-row-multiple').removeAttr('disabled'); //被禁用倍数文本框开启，倍数1

					if((index+1) < len){
						currText = list[index+1]['number'] == currNumber ? currStr : '';
						numberDom.html(list[index+1]['number'] + currText);
						multipleDom.text('1');
						dateDom.text(list[index+1]['time']);
						traceNo.html('').html(i);
						/**
						if(traceLastNumber != numberDom.text().substr(0,8) && traceLastNumber != ""){//增加隔天期标识
							traceNo.html('').append('<div class="icon-chase-mark">明天 ' + dom.find('.trace-row-number').text().substr(0,8) + '</div>');
						}
						**/
						traceLastNumber = numberDom.text().substr(0,8);
						index++;
					}

				});

				index = me.getStartNumberIndexByNumber(startNumber);
				trs2.each(function(i){
					if(i == 0){ //去除表头（高级）
						return true;
					}
					dom = $(this);
					numberDom = dom.find('.trace-row-number');
					dateDom = dom.find('.trace-row-time');
					multipleDom = dom.find('.trace-row-multiple');
					startNumber = numberDom.text().replace(/[^\d]/g, '');
					traceNo = dom.find('.text-center'); //序号
					dom.find('.trace-row-multiple').removeAttr('disabled'); //被禁用倍数文本框开启，倍数1

					if((index+1) < len){
						currText = list[index+1]['number'] == currNumber ? currStr : '';
						numberDom.html(list[index+1]['number'] + currText);
						multipleDom.text('1');
						dateDom.text(list[index+1]['time']);
						traceNo.html('').html(i);
						/**
						if(traceLastNumber != numberDom.text().substr(0,8) && traceLastNumber != ""){//增加隔天期标识
							traceNo.html('').append('<div class="icon-chase-mark">明天 ' + dom.find('.trace-row-number').text().substr(0,8) + '</div>');
						}
						**/
						traceLastNumber = numberDom.text().substr(0,8);
						index++;
					}
				});

			}

		},
		//重新计算盈利金额和盈利率表格数据
		rebuildYinglilvRows:function(){
			var me = this,
				trs = me.getRowTable().find('tr'),
				orderData = me.getOrderData(),
				//单注预计中奖金额
				orderUserGroupMoney = me.getWinMoney(),

				rowDom = null,
				checkboxDom = null,
				multipleDom = null,
				multiple = 1,
				amountDom = null,
				amount = 0,
				userGroupMoneyDom = null,
				winMoneyDom = null,
				yinglilvDom = null,
				yinglilv = -1;

				//累计投注成本
				costAmount = 0;

			//console.log('rebuild');

			trs.each(function(i){
				//第一行为表头
				if(i > 0){
					rowDom = $(this);
					checkboxDom = rowDom.find('.trace-row-checked');
					//当该行处于选中状态
					if(checkboxDom.size() > 0 && checkboxDom.get(0).checked){
						multipleDom = rowDom.find('.trace-row-multiple');
						multiple = Number(multipleDom.val());
						amountDom = rowDom.find('.trace-row-money');
						amount = Number(amountDom.text().replace(',', ''));
						userGroupMoneyDom = rowDom.find('.trace-row-userGroupMoney');
						winMoneyDom = rowDom.find('.trace-row-winTotalAmount');
						yinglilvDom = rowDom.find('.trace-row-yinglilv');

						costAmount += orderData['amount'] * multiple;

						amountDom.text(me.formatMoney(orderData['amount'] * multiple));
						userGroupMoneyDom.text(me.formatMoney(orderUserGroupMoney * multiple));
						winMoneyDom.text(me.formatMoney(orderUserGroupMoney * multiple - costAmount));
						yinglilv = (orderUserGroupMoney * multiple - costAmount)/costAmount*100;
						yinglilvDom.text(Number(yinglilv).toFixed(2));

					}
				}
			});

		},
		setTypeTypeType:function(v){
			this.typeTypeType = v;
		},
		getTypeTypeType:function(){
			return this.typeTypeType;
		},
		getIsWinStop:function(){
			var me = this,stopDom1 = $('#J-trace-iswintimesstop'),stopDom2 = $('#J-trace-iswinstop');
			if(stopDom1.get(0).checked){
				return 1;
			}
			if(stopDom2.get(0).checked){
				return 2;
			}
			return 0;
		},
		getTraceWinStopValue:function(){
			var me = this,isWinStop = me.getIsWinStop();
			if(isWinStop == 1){
				return Number($('#J-trace-iswintimesstop-times').val());
			}
			if(isWinStop == 2){
				return Number($('#J-trace-iswinstop-money').val());
			}
			return -1;
		},
		updateStatistics:function(){
			var me = this,data = me.getResultData();
			$('#J-trace-statistics-times').html(data['times']);
			$('#J-trace-statistics-lotterys-num').html(data['lotterysNum']);
			$('#J-trace-statistics-amount').html(me.formatMoney(data['amount']));
		},
		//已经设置完成的追号信息，每次修改追号信息时将更新该对象
		//格式和getResultData一直，但来源不同，getResultData来自dom中分析出数据，该函数获取的是上次成功设置最好的缓存信息
		getSavedTraceData:function(){
			return this.savedTraceData;
		},
		setSavedTraceData:function(data){
			this.savedTraceData = data;
		},
		getResultData:function(){
			var me = this,orderData = me.getOrderData(),trs = me.getRowTable(me.getTraceType()).find('tr'),rowDom,checkedDom,
				times = 0,
				lotterysNum = 0,
				amount = 0,
				traceData = [],
				par,
				result = {'times':0,'lotterysNum':0,'amount':0,'orderData':orderData,'traceData':[],'traceType':me.getTraceType()},
				traceLastNumber = '',//上期号
				list = Games.getCurrentGame().getGameConfig().getInstance().getGameNumbers(),
				issueCode,
				index;

			trs.each(function(i){
				rowDom = $(this);
				checkedDom = rowDom.find('.trace-row-checked'),
				tracenumber = rowDom.find('.trace-row-number'),//当前开奖期号
				traceNo = rowDom.find('.text-center'); //序号

				if( i != 0){
					traceNo.html('').html(i);
				}
				if(checkedDom.size() > 0 && checkedDom.get(0).checked){
					par = checkedDom.parent();
					index = me.getStartNumberIndexByNumber(par.find('.trace-row-number').text());
					index = index == -1 ? 0 :index;
					issueCode = list[index]['issueCode'];
					//0倍时再选中，初始倍数为1倍
					rowDom.find('.trace-row-multiple').removeAttr('disabled');
					if(rowDom.find('.trace-row-multiple').val() == '0'){
						rowDom.find('.trace-row-multiple').val('1');
						rowDom.find('.trace-row-money').text(me.formatMoney(orderData['amount'] * 1));

					}

					traceData.push({'traceNumber':par.find('.trace-row-number').text(),'issueCode':issueCode,'multiple':Number(par.parent().find('.trace-row-multiple').val())});
					times++;
					amount += Number(rowDom.find('.trace-row-money').text().replace(/,/g,''));

				}
				else{//没有勾选时状态
					rowDom.find('.trace-row-money').text('0');
					rowDom.find('.trace-row-multiple').val('0');
					rowDom.find('.trace-row-multiple').attr('disabled', 'disabled').css('border','1px solid #CECECE');

				}

				/**
				if(traceLastNumber != tracenumber.text().substr(0,8) && traceLastNumber != ""){//增加隔天期标识
						traceNo.html('').append('<div class="icon-chase-mark">明天 ' + rowDom.find('.trace-row-number').text().substr(0,8) + '</div>');

				}
				**/
				traceLastNumber = tracenumber.text().substr(0,8);

			});

			if(!!orderData){
				lotterysNum = times * orderData['count'];
				result = {'times':times,'lotterysNum':lotterysNum,'amount':amount,'orderData':orderData,'traceData':traceData,'traceType':me.getTraceType()};
			}
			return result;
		},
		//追加或删除投注，在追号面板展开的情况下再次进行选球投注，追号相关信息追加或减少投注金额
		//isShowMessage 是否关闭提示
		updateOrder:function(isNotShowMessage){
			var me = this,orderData = Games.getCurrentGameOrder().getTotal(),tableType = me.getRowTableType(),
				maxObj = Games.getCurrentGameOrder().getOrderMaxMultiple(),maxnum = maxObj['maxnum'],
				selValue = Number(me.normalSelectMultiple.getValue()),
				inputValue = Number($('#J-trace-advance-multiple').val());

			me.setOrderData(orderData);

			//按照最新的允许设置的最大倍数，设置相关的倍数输入框和下拉框
			if(selValue > maxnum){
				me.normalSelectMultiple.setValue(maxnum);
			}
			if(inputValue > maxnum){
				$('#J-trace-advance-multiple').val(maxnum);
			}

			//当注单发生变化时，清空盈利追号和盈利率追号表格
			if(!isNotShowMessage && (tableType == 'trace_advanced_fanbei_a' || tableType == 'trace_advanced_fanbei_b' || tableType == 'trace_advanced_yingli_a' || tableType == 'trace_advanced_yingli_b' || tableType == 'trace_advanced_yinglilv_a' || tableType == 'trace_advanced_yinglilv_b')){
				Games.getCurrentGameMessage().show({
						type : 'normal',
						closeFun: function(){
							this.hide();
						},
						data : {
							tplData:{
								msg:'您的方案已被修改，如果需要根据最新方案进行追号，请点击生成追号计划按钮'
							}
						}
				});
			}
			//盈利追号/盈利率追号每次都清空表格
			me.getAdvancedRowTable().html('');


			//更新表格
			me.updateDetail(orderData['amount']);

			//更新界面金额
			me.updateStatistics();
		},
		//更新详细表格单条金额
		updateDetail:function(amount){
			var me = this,trs = me.getTable().find('tr'),rowDom = null,rowAmountDom = null,rowUserGroupMoneyDom = null,rowWinTotalAmountDom = null,rowYinglilvDom = null,userGroupMoney = 0,tableType = me.getRowTableType(),advancedType;
			//console.log(me.getRowTable());
			//高级追号和普通追号表格结构不一样
			if(tableType == 'trace_advanced_yingli_a' || tableType == 'trace_advanced_yingli_b' || tableType == 'trace_advanced_yinglilv_a' || tableType == 'trace_advanced_yinglilv_b'){
				me.rebuildYinglilvRows();
			}else{

				//翻倍追号自动更新表格
				advancedType = me.getAdvancedRowTable().attr('data-type');
				if(advancedType == 'trace_advanced_fanbei_a' || advancedType == 'trace_advanced_fanbei_b'){
					trs = me.getAdvancedTable().find('tr');
					trs.each(function(){
						rowDom = $(this);
						rowMoney = rowDom.find('.trace-row-money');
						rowMultiple = Number(rowDom.find('.trace-row-multiple').val());
						rowMoney.text(me.formatMoney(rowMultiple * amount));
					});
				}
			}

			//普通追号每次都自动更新表格
			trs = me.getNormalTable().find('tr');
			trs.each(function(){
				rowDom = $(this);
				rowMoney = rowDom.find('.trace-row-money');
				rowMultiple = Number(rowDom.find('.trace-row-multiple').val());
				rowMoney.text(me.formatMoney(rowMultiple * amount));
			});



		},
		//计算投注内容中的预计中奖金额
		//选球内容有可能是不同的玩法内容，需要各自计算中奖将进组金额
		getWinMoney:function(){
			var me = this,orders = me.getOrderData()['orders'],i = 0,len = orders.length,winMoney = 0;
			for(;i < len;i++){
				winMoney += me.getPlayGroupMoneyByGameMethodName(orders[i]['mid']) * orders[i]['moneyUnit'];
			}
			return winMoney;
		},
		//根据追号选择条件生成详细表格
		confirmSetting:function(){
			var me = this;
			me.setOrderData(Games.getCurrentGameOrder().getTotal());
			me.buildDetail();
		},
		//检测当前投注列表中是否全部为同一玩法
		//且元角模式一致
		isSameGameMethod:function(){
			var me = this,orders = me.getOrderData()['orders'],type = '',moneyUnit = -1;
				i = 0,
				len = orders.length;
			for(;i < len;i++){
				if(type != ''){
					if(type != orders[i]['type']){
						return false;
					}
				}else{
					type = orders[i]['type'];
				}

				if(moneyUnit != -1){
					if(moneyUnit != orders[i]['moneyUnit']){
						return false;
					}
				}else{
					moneyUnit = orders[i]['moneyUnit'];
				}
			}
			return true;
		},
		getSameGameMethodName:function(){
			var me = this,orders = me.getOrderData()['orders'];
			if(orders.length > 0){
				return orders[0]['type'];
			}
		},
		getSameGameMoneyUnti:function(){
			var me = this,orders = me.getOrderData()['orders'];
			if(orders.length > 0){
				return orders[0]['moneyUnit'];
			}
		},
		setOrderData:function(data){
			this.orderData = data;
		},
		getOrderData:function(){
			return this.orderData == null ? {'count':0,'amount':0,'orders':[]} : this.orderData;
		},
		//由期号获得期号在列表中的索引值

		getStartNumberIndexByNumber:function(number){
			var me = this,numberList = Games.getCurrentGame().getGameConfig().getInstance().getGameNumbers(),len = numberList.length,i = 0;
			for(;i < len;i++){
				if(numberList[i]['number'] == number){
					return i;
				}
			}
			return -1;
		},
		getStartNumberByIndex:function(index){
			var me = this,numberList = Games.getCurrentGame().getGameConfig().getInstance().getGameNumbers();
			if(numberList.length > index){
				return numberList[index];
			}
			return {};
		},
		//生成追号计划详情内容
		//maxMultipleNum 如果参数中有设置该参数，则最大倍数都使用该值(用于检测倍数超出最大值后重新设置倍数)
		//isAuto 是否自动渲染，自动渲染只适合普通追号
		buildDetail:function(){
			var me = this,
				type = me.getTraceType(),
				msg = Games.getCurrentGameMessage();
			//每次获取最新的投注信息
			me.setOrderData(Games.getCurrentGameOrder().getTotal());
			orderAmount = me.getOrderData()['amount'];


			//投注内容为空
			if(orderAmount <= 0){
				msg.show({
					type : 'mustChoose',
					msg : '请至少选择一注投注号码！',
					data : {
						tplData : {
							msg : '请至少选择一注投注号码！'
						}
					}
				});
				return;
			}
			if($.isFunction(me['trace_' + type])){
				me['trace_' + type].call(me);
			}
			//console.log('trace_' + type);
			me.updateStatistics();
		},
		trace_lirunlv: function() {
			var me = this,
				type = me.getTraceType(),
				tpl = me.defConfig.dataRowTemplate,
				tplArr = [],
				//追号期数
				times = me.getTimes(type),
				timesTemp = times,
				maxNumltipleObj = Games.getCurrentGameOrder().getOrderMaxMultiple(),
				//基础倍数
				multipleBase = me.getMultiple(),
				//盈利率计算结果
				resultData = [],

				//每期必须要达到的盈利率
				yinglilv = Number($('#J-trace-lirunlv-num').val()) / 100,
				len2 = 0,
				//元角模式
				moneyUnit = me.getSameGameMoneyUnti(),
				//用户奖金组中该玩法中每注的中奖金额
				userGroupMoney = 0,
				//玩法中的单注单价
				onePrice = 0,
				//启用另外表头和行模板
				tpl = me.defConfig.dataRowLirunlvTemplate,
				orders = me.getOrderData()['orders'],


				//当前期
				currNumber = Games.getCurrentGame().getGameConfig().getInstance().getCurrentGameNumber(),
				//当前期标识
				currStr = '<span class="icon-period-current"></span>',
				//当前期文本
				currNumberText = '',
				//用户选择的开始期号
				settingStartNumber = me.traceStartNumberSelect.getValue(),
				startIndex,
				i = 0,
				//标记是否已经提示过一次
				isAlerted = false,
				numberData,
				//期号列表
				traceNumberList = Games.getCurrentGame().getGameConfig().getInstance().getGameNumbers();


			//盈利/盈利率追号不支持混投
			if (!me.isSameGameMethod()) {
				Games.getCurrentGameMessage().show({
					type: 'mustChoose',
					msg: '',
					data: {
						tplData: {
							msg: '利润率追号不支持混投<br />请确保您的投注都为同一玩法类型<br />且元角模式一致。'
						}
					}
				});
				return;
			}



			$.each(orders, function() {
				var method = Games.getCurrentGame().getGameConfig().getInstance().getMethodById(this['mid']);
				var prize = Games.getCurrentGame().getGameConfig().getInstance().getPrizeById(this['mid']);
				userGroupMoney += Number(prize['prize']);
				onePrice += this['num'] * Number(method['price']);
			});
			userGroupMoney *= moneyUnit;
			onePrice *= moneyUnit;


			tplArr.push(me.defConfig.dataRowYingliHeader);

			startIndex = me.getStartNumberIndexByNumber(settingStartNumber);

			timesTemp = times;
			resultData = me.getMultipleByYinglilv(yinglilv, userGroupMoney, onePrice, timesTemp, multipleBase, maxNumltipleObj['maxnum']);

			if (resultData.length < 1) {
				alert('您设置的参数无法达到盈利，请重新设置');
				return;
			}

			$.each(resultData, function() {
				if (this['oldMultiple'] > maxNumltipleObj['maxnum']) {
					isAlerted = true;
					alert('生成方案中的倍数超过了系统最大允许设置的倍数，将自动调整为系统最大可设置倍数');
					return false;
				}
			});


			for (i =0; i < resultData.length; i++) {
				currNumberText = traceNumberList[i + startIndex]['number'];
				if (currNumberText == currNumber) {
					currNumberText = currNumberText + currStr;
				}
				rowData = {
					'No': (i + 1),
					'traceNumber': currNumberText,
					'multiple': resultData[i]['multiple'],
					'money': me.formatMoney(onePrice * resultData[i]['multiple']),
					'userGroupMoney': me.formatMoney(userGroupMoney * resultData[i]['multiple']),
					'winTotalAmout': me.formatMoney(resultData[i]['winAmountAll']),
					'yinglilv': Number(resultData[i]['winAmountAll'] / resultData[i]['amountAll'] * 100).toFixed(2)
				};
				tplArr.push(me.formatRow(tpl, rowData));
			}

			me.getRowTable(type).html(tplArr.join(''));
			//在表格上设置最后生成列表的类型，用于区分列表类型
			me.getRowTable(type).attr('data-type', 'lirunlv');
		},
		trace_tongbei:function(){
			var me = this,
				type = me.getTraceType(),
				cfg = me.defConfig,
				tpl = cfg.dataRowTemplate,
				tplArr = [],
				//类型
				type = me.getTraceType(),
				//追号期数
				times = me.getTimes(type),
				//倍数
				multiple = Number($('#J-trace-tongbei-multiple').val()),
				//最大倍数限制
				maxMultiple = Games.getCurrentGameOrder().getOrderMaxMultiple()['maxnum'],
				//投注金额
				orderAmount = 0,
				i = 0,

				//当前期
				currNumber = Games.getCurrentGame().getGameConfig().getInstance().getCurrentGameNumber(),
				currStr = '<span class="icon-period-current"></span>',
				//当前期文本
				currNumberText = '',
				//用户选择的开始期号
				settingStartNumber = me.traceStartNumberSelect.getValue(),
				startIndex,
				numberData,
				//期号列表长度
				numberLength = Games.getCurrentGame().getGameConfig().getInstance().getGameNumbers().length,
				rowData;


			me.setOrderData(Games.getCurrentGameOrder().getTotal());
			orderAmount = me.getOrderData()['amount'];

			tplArr.push(cfg.dataRowHeader);


			startIndex = me.getStartNumberIndexByNumber(settingStartNumber);
			i = startIndex;
			times += i;
			for(;i < times;i++){
				numberData = me.getStartNumberByIndex(i);
				currNumberText = numberData['number'];
				if(currNumberText == currNumber){
					currNumberText = currNumberText + currStr;
				}
				if(numberData['number']){
					rowData = {'No':i+1,'traceNumber':currNumberText,'multiple':multiple,'money':me.formatMoney(orderAmount * multiple),'publishTime':numberData['time']};
					tplArr.push(me.formatRow(tpl, rowData));
				}
			}
			me.getRowTable(type).html(tplArr.join(''));


			//在表格上设置最后生成列表的类型，用于区分列表类型
			me.getRowTable(type).attr('data-type', 'tongbei');
		},
		trace_fanbei:function(){
			var me = this,
				type = me.getTraceType(),
				tpl = me.defConfig.dataRowTemplate,
				tplArr = [],
				//追号期数
				times = me.getTimes(type),
				orders = me.getOrderData()['orders'],
				moneyUnit = me.getSameGameMoneyUnti(),
				maxNumltipleObj = Games.getCurrentGameOrder().getOrderMaxMultiple(),
				//最大倍数限制
				maxMultiple = maxNumltipleObj['maxnum'],
				jiangeNum = Number($('#J-trace-fanbei-jump').val()),
				//间隔变量
				jiangeNum2 = jiangeNum,
				//基础倍数
				multipleBase = Number($('#J-trace-fanbei-multiple').val()),
				//倍数变量
				multiple = multipleBase,
				//间隔倍数
				multiple2 = Number($('#J-trace-fanbei-num').val()),
				//玩法中的单注单价
				onePrice = 0,
				i = 0,
				isAlerted = false,

				//当前期
				currNumber = Games.getCurrentGame().getGameConfig().getInstance().getCurrentGameNumber(),
				currStr = '<span class="icon-period-current"></span>',
				//当前期文本
				currNumberText = '',
				//用户选择的开始期号
				settingStartNumber = me.traceStartNumberSelect.getValue(),
				startIndex,
				numberData,
				//期号列表
				traceNumberList = Games.getCurrentGame().getGameConfig().getInstance().getGameNumbers(),
				//序号列
				traceNo = 1;

				$.each(orders, function(){
					var method = Games.getCurrentGame().getGameConfig().getInstance().getMethodById(this['mid']);
					onePrice += this['num'] * method['price'];
				});
				onePrice *= moneyUnit;


				startIndex = me.getStartNumberIndexByNumber(settingStartNumber);

				tplArr.push(me.defConfig.dataRowHeader);

				i = i + startIndex;
				times = times + startIndex;

				for(;i < times;i++){
					if(jiangeNum2 < 1){
						jiangeNum2 = jiangeNum;
						multiple *= multiple2;
					}
					if(multiple > maxMultiple){
						if(!isAlerted){
							/**
							alert('生成方案中的倍数超过了系统最大允许设置的倍数，将自动调整为系统最大可设置倍数');
							isAlerted = true;
							**/
						}
						multiple = maxMultiple;
					}
					currNumberText = traceNumberList[i]['number'];
					if(currNumberText == currNumber){
						currNumberText = currNumberText + currStr;
					}
					rowData = {'No':traceNo,'traceNumber':currNumberText,'multiple':multiple,'money':me.formatMoney(onePrice * multiple),'publishTime':traceNumberList[i]['time']};

					jiangeNum2 -= 1;
					traceNo++;
					tplArr.push(me.formatRow(tpl, rowData));
				}

				me.getRowTable(type).html(tplArr.join(''));
				//在表格上设置最后生成列表的类型，用于区分列表类型
				me.getRowTable(type).attr('data-type', 'fanbei');
		},
		//普通追号
		trace_normal:function(){
			var me = this,
				cfg = me.defConfig,
				tpl = cfg.dataRowTemplate,
				tplArr = [],
				//类型
				type = me.getTraceType(),
				//追号期数
				times = me.getTimes(),
				//倍数
				multiple = me.getMultiple(),
				//最大倍数限制
				maxMultiple = Games.getCurrentGameOrder().getOrderMaxMultiple()['maxnum'],
				//投注金额
				orderAmount = 0,
				i = 0,

				//当前期
				currNumber = Games.getCurrentGame().getGameConfig().getInstance().getCurrentGameNumber(),
				currStr = '<span class="icon-period-current"></span>',
				//当前期文本
				currNumberText = '',
				//用户选择的开始期号
				settingStartNumber = me.traceStartNumberSelect.getValue(),
				startIndex,
				numberData,
				//期号列表长度
				numberLength = Games.getCurrentGame().getGameConfig().getInstance().getGameNumbers().length,
				rowData;



			me.setOrderData(Games.getCurrentGameOrder().getTotal());
			orderAmount = me.getOrderData()['amount'];

			tplArr.push(cfg.dataRowHeader);


			startIndex = me.getStartNumberIndexByNumber(settingStartNumber);
			i = startIndex;
			times += i;
			for(;i < times;i++){
				numberData = me.getStartNumberByIndex(i);
				currNumberText = numberData['number'];
				if(currNumberText == currNumber){
					currNumberText = currNumberText + currStr;
				}
				if(numberData['number']){
					rowData = {'No':i+1,'traceNumber':currNumberText,'multiple':multiple,'money':me.formatMoney(orderAmount * multiple),'publishTime':numberData['time']};
					tplArr.push(me.formatRow(tpl, rowData));
				}
			}
			me.getRowTable().html(tplArr.join(''));


			//在表格上设置最后生成列表的类型，用于区分列表类型
			me.getRowTable().attr('data-type', 'trace_normal');

		},
		//高级追号
		trace_advanced:function(){
			var me = this,
				type = me.getTraceType(),
				advancedType = me.getAdvancedType(),
				typeTypeType = me.getTypeTypeType(),
				fnName = 'trace_' + type + '_' + advancedType + '_' + typeTypeType;


			//盈利/盈利率追号不支持混投
			if(!me.isSameGameMethod() && (advancedType == 'yingli' || advancedType == 'yinglilv')){
				Games.getCurrentGameMessage().show({
					type : 'mustChoose',
					msg : '',
					data : {
						tplData : {
							msg : '盈利金额追号不支持混投<br />请确保您的投注都为同一玩法类型<br />且元角模式一致。'
						}
					}
				});
				return;
			}

			if($.isFunction(me[fnName])){
				me[fnName]();
			}
			//在表格上设置最后生成列表的类型，用于区分列表类型
			me.getRowTable().attr('data-type', fnName);
		},
		//高级追号 -- 翻倍追号 -- 间隔追号
		trace_advanced_fanbei_a:function(){
			var me = this,
				tpl = me.defConfig.dataRowTemplate,
				tplArr = [],
				//追号期数
				times = me.getTimes(),
				orders = me.getOrderData()['orders'],
				moneyUnit = me.getSameGameMoneyUnti(),
				maxNumltipleObj = Games.getCurrentGameOrder().getOrderMaxMultiple(),
				//最大倍数限制
				maxMultiple = maxNumltipleObj['maxnum'],
				jiangeNum = Number($('#J-trace-advanced-fanbei-a-jiange').val()),
				//间隔变量
				jiangeNum2 = jiangeNum,
				//基础倍数
				multipleBase = me.getMultiple(),
				//倍数变量
				multiple = 1,
				//间隔倍数
				multiple2 = Number($('#J-trace-advanced-fanbei-a-multiple').val()),
				//玩法中的单注单价
				onePrice = 0,
				i = 0,
				isAlerted = false,

				//当前期
				currNumber = Games.getCurrentGame().getGameConfig().getInstance().getCurrentGameNumber(),
				currStr = '<span class="icon-period-current"></span>',
				//当前期文本
				currNumberText = '',
				//用户选择的开始期号
				settingStartNumber = me.traceStartNumberSelect.getValue(),
				startIndex,
				numberData,
				//期号列表
				traceNumberList = Games.getCurrentGame().getGameConfig().getInstance().getGameNumbers(),
				//序号列
				traceNo = 1;

				$.each(orders, function(){
					var method = Games.getCurrentGame().getGameConfig().getInstance().getMethodById(this['mid']);
					onePrice += this['num'] * method['price'];
				});
				onePrice *= moneyUnit;


				startIndex = me.getStartNumberIndexByNumber(settingStartNumber);

				tplArr.push(me.defConfig.dataRowHeader);

				i = i + startIndex;
				times = times + startIndex;

				for(;i < times;i++){
					if(jiangeNum2 < 1){
						jiangeNum2 = jiangeNum;
						multiple *= multiple2;
					}
					if(multiple > maxMultiple){
						if(!isAlerted){
							/**
							alert('生成方案中的倍数超过了系统最大允许设置的倍数，将自动调整为系统最大可设置倍数');
							isAlerted = true;
							**/
						}
						multiple = maxMultiple;
					}
					currNumberText = traceNumberList[i]['number'];
					if(currNumberText == currNumber){
						currNumberText = currNumberText + currStr;
					}
					rowData = {'No':traceNo,'traceNumber':currNumberText,'multiple':multiple,'money':me.formatMoney(onePrice * multiple),'publishTime':traceNumberList[i]['time']};

					jiangeNum2 -= 1;
					traceNo++;
					tplArr.push(me.formatRow(tpl, rowData));
				}

				me.getRowTable().html(tplArr.join(''));
		},
		//高级追号 -- 翻倍追号 -- 前后追号
		trace_advanced_fanbei_b:function(){
			var me = this,
				tpl = me.defConfig.dataRowTemplate,
				tplArr = [],
				//追号期数
				times = me.getTimes(),
				orders = me.getOrderData()['orders'],
				moneyUnit = me.getSameGameMoneyUnti(),
				//最大倍数限制
				maxMultiple = Games.getCurrentGameOrder().getOrderMaxMultiple()['maxnum'],
				jiangeNum = Number($('#J-trace-advanced-fanbei-a-jiange').val()),
				//基础倍数
				multipleBase = me.getMultiple(),
				//中间运算倍数
				multiple = 1,
				//间隔倍数
				multiple2 = Number($('#J-trace-advanced-fanbei-a-multiple').val()),
				//玩法中的单注单价
				onePrice = 0,
				i = 0,
				//间隔临时计数器
				_i = jiangeNum,

				beforeNum = Number($('#J-trace-advanced-fanbei-b-num').val()),
				startMultiple = Number($('#J-trace-advance-multiple').val()),
				afterMultiple = Number($('#J-trace-advanced-fanbei-b-multiple').val()),


				//当前期
				currNumber = Games.getCurrentGame().getGameConfig().getInstance().getCurrentGameNumber(),
				currStr = '<span class="icon-period-current"></span>',
				//当前期文本
				currNumberText = '',
				//用户选择的开始期号
				settingStartNumber = me.traceStartNumberSelect.getValue(),
				startIndex,
				numberData,
				//期号列表长度
				numberLength = Games.getCurrentGame().getGameConfig().getInstance().getGameNumbers().length,
				rowData,
				traceLastNumber = '',//上期号
				traceNo=''; //序号列


				$.each(orders, function(){
					var method = Games.getCurrentGame().getGameConfig().getInstance().getMethodById(this['mid']);
					onePrice += this['num'] * method['price'];
				});
				onePrice *= moneyUnit;


				tplArr.push(me.defConfig.dataRowHeader);

				startIndex = me.getStartNumberIndexByNumber(settingStartNumber);
				i = startIndex;
				times += i;
				numberData = me.getStartNumberByIndex(i);
				for(;i < times;i++){
					if(i < (beforeNum + startIndex)){
						multiple = startMultiple > maxMultiple ? maxMultiple : startMultiple;
					}else{
						multiple = afterMultiple > maxMultiple ? maxMultiple : afterMultiple;
					}

					numberData = me.getStartNumberByIndex(i);
					if(!numberData['number']){
						break;
					}
					currNumberText = numberData['number'];
					if(currNumberText == currNumber){
						currNumberText = currNumberText + currStr;
					}
					traceNo = i +1;
					rowData = {'No':traceNo,'traceNumber':currNumberText,'multiple':multiple,'money':me.formatMoney(onePrice * multiple),'publishTime':numberData['time']};
					traceLastNumber = currNumberText.substr(0,8);

					tplArr.push(me.formatRow(tpl, rowData));
				}
				me.getRowTable().html(tplArr.join(''));
		},
		//高级追号 -- 盈利金额追号 -- 预期盈利金额
		trace_advanced_yingli_a:function(maxnum){
			var me = this,
				tpl = me.defConfig.dataRowTemplate,
				tplArr = [],
				//追号期数
				times = me.getTimes(),
				maxNumltipleObj = Games.getCurrentGameOrder().getOrderMaxMultiple(),
				//最大倍数限制
				maxMultiple = maxnum || maxNumltipleObj['maxnum'],
				typeTitle = Games.getCurrentGame().getGameConfig().getInstance().getMethodFullName(maxNumltipleObj['gameMethod']).join('-'),
				//基础倍数
				multipleBase = me.getMultiple(),
				//中间运算倍数
				multiple = 1,
				testData,
				i = 0,



				//玩法类型
				gameMethodType = me.getSameGameMethodName(),
				//每期必须要达到的盈利金额
				yingliMoney = Number($('#J-trace-advanced-yingli-a-money').val()),
				//元角模式
				moneyUnit = me.getSameGameMoneyUnti(),
				//用户奖金组中该玩法中每注的中奖金额
				userGroupMoney = me.getWinMoney(),
				//基础倍数，盈利追号和盈利率追号通过修改倍数达到预期值，所以初始值设置为1
				multipleBase = 1,
				//启用另外表头和行模板
				tpl = me.defConfig.dataRowYingliTemplate,
				orders = me.getOrderData()['orders'],
				//投注组本金
				orderAmount = 0,
				//所有投注本金
				orderTotalAmount = 0,
				//中奖总金额
				winTotalAmout = 0,
				//盈利率
				yinglilv = 0,


				//当前期
				currNumber = Games.getCurrentGame().getGameConfig().getInstance().getCurrentGameNumber(),
				currStr = '<span class="icon-period-current"></span>',
				//当前期文本
				currNumberText = '',
				//用户选择的开始期号
				settingStartNumber = me.traceStartNumberSelect.getValue(),
				startIndex,
				numberData,
				//期号列表长度
				numberLength = Games.getCurrentGame().getGameConfig().getInstance().getGameNumbers().length,
				rowData,
				traceLastNumber = '',//上期号
				traceNo=''; //序号列


			tplArr.push(me.defConfig.dataRowYingliHeader);

			startIndex = me.getStartNumberIndexByNumber(settingStartNumber);
			i = startIndex;
			times += i;
			numberData = me.getStartNumberByIndex(i);
			for(;i < times;i++){
				orderAmount = 0;
				winTotalAmout = 0;
				//基础倍数，盈利追号和盈利率追号通过修改倍数达到预期值，所以初始值设置为1
				multipleBase = 1;
				//计算预计中奖金额
				$.each(orders, function(i){
					var order = this,
						num = order['num'],
						price = order['onePrice'],
						multiple = order['multiple'],
						//本金
						amount = num * multiple * price,
						//单注中奖金额
						winAmout = userGroupMoney * multiple;

						//该投注组盈利金额
						winTotalAmout += winAmout;

						orderAmount += amount;
				});


				//获得倍数
				multipleBase = me.getMultipleByMoney(userGroupMoney, yingliMoney, orderAmount, orderTotalAmount);
				//无法达到预期目标
				if(multipleBase < 0){
					alert('盈利金额追号无法到达您预期设定的目标值，请修改您的设置');
					return;
				}

				//倍数超限时提示
				if(multipleBase > maxMultiple){
					Games.getCurrentGameMessage().show({
						type : 'normal',
							closeText: '确定',
							closeFun: function(){
								me.trace_advanced_yingli_a(maxMultiple);
								me.updateStatistics();
								this.hide();
							},
							data : {
								tplData:{
									msg:'盈利金额追号中的<b>['+ typeTitle +']</b>的倍数超过了最大倍数限制，系统将自动调整为最大可设置倍数'
								}
							}
					});
					if(!maxnum){
						return;
					}else{
						multipleBase = maxnum;
					}
				}

				//花费本金
				orderAmount *= multipleBase;
				//累计本金
				orderTotalAmount += orderAmount;
				//利润减去累计花费
				winTotalAmout = (userGroupMoney * multipleBase) - orderTotalAmount;
				//盈利率
				yinglilv = winTotalAmout/orderTotalAmount;


				numberData = me.getStartNumberByIndex(i);
				if(!numberData['number']){
					break;
				}
				currNumberText = numberData['number'];
				if(currNumberText == currNumber){
					currNumberText = currNumberText + currStr;
				}
				 //增加隔天期标识
				 /**
				if(traceLastNumber != currNumberText.substr(0,8) && traceLastNumber != ""){
					traceNo ='<div class="icon-chase-mark">明天 ' + currNumberText.substr(0,8) + '</div>';
				}else{
					traceNo = i+1;
				}
				**/
				traceNo = i +1;
				rowData = {'No':traceNo,'traceNumber': currNumberText,
							'multiple':multipleBase,
							'money':me.formatMoney(orderAmount),
							'userGroupMoney':me.formatMoney(userGroupMoney * multipleBase),
							'winTotalAmout':me.formatMoney(winTotalAmout),
							'yinglilv':Number(yinglilv*100).toFixed(2)
							};

				traceLastNumber = currNumberText.substr(0,8);
				tplArr.push(me.formatRow(tpl, rowData));
			}
			me.getRowTable().html(tplArr.join(''));

		},
		//高级追号 -- 盈利金额追号 -- 前后预期盈利金额
		trace_advanced_yingli_b:function(maxnum){
			var me = this,
				tpl = me.defConfig.dataRowTemplate,
				tplArr = [],
				//追号期数
				times = me.getTimes(),
				maxNumltipleObj = Games.getCurrentGameOrder().getOrderMaxMultiple(),
				//最大倍数限制
				maxMultiple = maxnum || maxNumltipleObj['maxnum'],
				typeTitle = Games.getCurrentGame().getGameConfig().getInstance().getMethodFullName(maxNumltipleObj['gameMethod']).join('-'),
				//基础倍数
				multipleBase = me.getMultiple(),
				//中间运算倍数
				multiple = 1,
				testData,
				i = 0,


				//玩法类型
				gameMethodType = me.getSameGameMethodName(),
				//前几期
				yingliNum = Number($('#J-trace-advanced-yingli-b-num').val()),
				//第一期必须要达到的盈利金额
				yingliMoney = Number($('#J-trace-advanced-yingli-b-money1').val()),
				//第二期必须要达到的盈利金额
				yingliMoney2 = Number($('#J-trace-advanced-yingli-b-money2').val()),
				//元角模式
				moneyUnit = me.getSameGameMoneyUnti(),
				//用户奖金组中该玩法中每注的中奖金额
				userGroupMoney = me.getWinMoney(),
				//基础倍数，盈利追号和盈利率追号通过修改倍数达到预期值，所以初始值设置为1
				multipleBase = 1,
				//启用另外表头和行模板
				tpl = me.defConfig.dataRowYingliTemplate,
				orders = me.getOrderData()['orders'],
				//投注组本金
				orderAmount = 0,
				//所有投注本金
				orderTotalAmount = 0,
				//中奖总金额
				winTotalAmout = 0,
				//盈利率
				yinglilv = 0,



				//当前期
				currNumber = Games.getCurrentGame().getGameConfig().getInstance().getCurrentGameNumber(),
				currStr = '<span class="icon-period-current"></span>',
				//当前期文本
				currNumberText = '',
				//用户选择的开始期号
				settingStartNumber = me.traceStartNumberSelect.getValue(),
				startIndex,
				numberData,
				//期号列表长度
				numberLength = Games.getCurrentGame().getGameConfig().getInstance().getGameNumbers().length,
				rowData,
				traceLastNumber = '',//上期号
				traceNo=''; //序号列



				tplArr.push(me.defConfig.dataRowYingliHeader);

				startIndex = me.getStartNumberIndexByNumber(settingStartNumber);
				i = startIndex;
				times += i;
				numberData = me.getStartNumberByIndex(i);
				for(;i < times;i++){
					if((i+1) > (yingliNum + startIndex)){
						yingliMoney = yingliMoney2;
					}
					orderAmount = 0;
					winTotalAmout = 0;
					//基础倍数，盈利追号和盈利率追号通过修改倍数达到预期值，所以初始值设置为1
					multipleBase = 1;
					//计算预计中奖金额
					$.each(orders, function(i){
						var order = this,
						num = order['num'],
						price = order['onePrice'],
						multiple = order['multiple'],
						//本金
						amount = num * multiple * price,
						//单注中奖金额
						winAmout = userGroupMoney * multiple;

						//该投注组盈利金额
						winTotalAmout += winAmout;
						orderAmount += amount;
					});

					//获得倍数
					multipleBase = me.getMultipleByMoney(userGroupMoney, yingliMoney, orderAmount, orderTotalAmount);
					//无法达到预期目标
					if(multipleBase < 0){
						Games.getCurrentGameMessage().show({
							type : 'normal',
								closeText: '确定',
								closeFun: function(){
									this.hide();
								},
								data : {
									tplData:{
										msg:'盈利金额追号无法到达您预期设定的目标值，请修改您的设置'
									}
								}
						});
						return;
					}


					//倍数超限时提示
					if(multipleBase > maxMultiple){
						Games.getCurrentGameMessage().show({
							type : 'normal',
								closeText: '确定',
								closeFun: function(){
									me.trace_advanced_yingli_b(maxMultiple);
									me.updateStatistics();
									this.hide();
								},
								data : {
									tplData:{
										msg:'盈利金额追号中的<b>['+ typeTitle +']</b>的倍数超过了最大倍数限制，系统将自动调整为最大可设置倍数'
									}
								}
						});
						if(!maxnum){
							return;
						}else{
							multipleBase = maxnum;
						}
					}


					//花费本金
					orderAmount *= multipleBase;
					//累计本金
					orderTotalAmount += orderAmount;
					//利润减去累计花费
					winTotalAmout = (userGroupMoney * multipleBase) - orderTotalAmount;
					//盈利率
					yinglilv = winTotalAmout/orderTotalAmount;


					numberData = me.getStartNumberByIndex(i);
					if(!numberData['number']){
						break;
					}
					currNumberText = numberData['number'];
					if(currNumberText == currNumber){
						currNumberText = currNumberText + currStr;
					}
					 //增加隔天期标识
					 /**
					if(traceLastNumber != currNumberText.substr(0,8) && traceLastNumber != ""){
						traceNo ='<div class="icon-chase-mark">明天 ' + currNumberText.substr(0,8) + '</div>';
					}else{
						traceNo = i+1;
					}
					**/
					rowData = {'No':traceNo,'traceNumber': currNumberText,
								'multiple':multipleBase,
								'money':me.formatMoney(orderAmount),
								'userGroupMoney':me.formatMoney(userGroupMoney * multipleBase),
								'winTotalAmout':me.formatMoney(winTotalAmout),
								'yinglilv':Number(yinglilv*100).toFixed(2)
							};
					traceLastNumber = currNumberText.substr(0,8);
					tplArr.push(me.formatRow(tpl, rowData));
				}

				me.getRowTable().html(tplArr.join(''));

		},
		//高级追号 -- 盈利率追号 -- 预期盈利率
		trace_advanced_yinglilv_a:function(){
			var me = this,
				tpl = me.defConfig.dataRowTemplate,
				tplArr = [],
				//追号期数
				times = me.getTimes(),
				maxNumltipleObj = Games.getCurrentGameOrder().getOrderMaxMultiple(),
				//基础倍数
				multipleBase = me.getMultiple(),
				//盈利率计算结果
				resultData = [],

				//每期必须要达到的盈利率
				yinglilv = Number($('#J-trace-advanced-yinglilv-a').val())/100,
				//元角模式
				moneyUnit = me.getSameGameMoneyUnti(),
				//用户奖金组中该玩法中每注的中奖金额
				userGroupMoney = 0,
				//玩法中的单注单价
				onePrice = 0,
				//启用另外表头和行模板
				tpl = me.defConfig.dataRowYingliTemplate,
				orders = me.getOrderData()['orders'],


				//当前期
				currNumber = Games.getCurrentGame().getGameConfig().getInstance().getCurrentGameNumber(),
				//当前期标识
				currStr = '<span class="icon-period-current"></span>',
				//当前期文本
				currNumberText = '',
				//用户选择的开始期号
				settingStartNumber = me.traceStartNumberSelect.getValue(),
				startIndex,
				i = 0,
				numberData,
				//期号列表
				traceNumberList = Games.getCurrentGame().getGameConfig().getInstance().getGameNumbers();

				$.each(orders, function(){
					var method = Games.getCurrentGame().getGameConfig().getInstance().getMethodById(this['mid']);
					var prize = Games.getCurrentGame().getGameConfig().getInstance().getPrizeById(this['mid']);
					userGroupMoney += prize['prize'];
					onePrice += this['num'] * method['price'];
				});
				userGroupMoney *= moneyUnit;
				onePrice *= moneyUnit;


				tplArr.push(me.defConfig.dataRowYingliHeader);

				startIndex = me.getStartNumberIndexByNumber(settingStartNumber);

				resultData = me.getMultipleByYinglilv(yinglilv, userGroupMoney, onePrice, times, multipleBase, maxNumltipleObj['maxnum']);

				if(resultData.length < 1){
					alert('您设置的参数无法达到盈利，请重新设置');
					return;
				}

				$.each(resultData, function(i){
					if(this['oldMultiple'] > maxNumltipleObj['maxnum']){
						alert('生成方案中的倍数超过了系统最大允许设置的倍数，将自动调整为系统最大可设置倍数');
						return false;
					}
				});

				for(;i < resultData.length;i++){
					currNumberText = traceNumberList[i + startIndex]['number'];
					if(currNumberText == currNumber){
						currNumberText = currNumberText + currStr;
					}
					rowData = {'No':(i + 1),
								'traceNumber': currNumberText,
								'multiple':resultData[i]['multiple'],
								'money':me.formatMoney(onePrice * resultData[i]['multiple']),
								'userGroupMoney':me.formatMoney(userGroupMoney * resultData[i]['multiple']),
								'winTotalAmout':me.formatMoney(resultData[i]['winAmountAll']),
								'yinglilv':Number(resultData[i]['winAmountAll']/resultData[i]['amountAll']*100).toFixed(2)
					};

					tplArr.push(me.formatRow(tpl, rowData));
				}
				me.getRowTable().html(tplArr.join(''));

		},
		//高级追号 -- 盈利率追号 -- 前后预期盈利率
		trace_advanced_yinglilv_b:function(maxnum){
			var me = this,
				tpl = me.defConfig.dataRowTemplate,
				tplArr = [],
				//追号期数
				times = me.getTimes(),
				timesTemp = times,
				maxNumltipleObj = Games.getCurrentGameOrder().getOrderMaxMultiple(),
				//基础倍数
				multipleBase = me.getMultiple(),
				//盈利率计算结果
				resultData = [],

				//每期必须要达到的盈利率
				yinglilv1 = Number($('#J-trace-advanced-yingli-b-yinglilv1').val())/100,
				yinglilv2 = Number($('#J-trace-advanced-yingli-b-yinglilv2').val())/100,
				len2 = 0,
				//前多少期应用yinglilv1
				timesPre = Number($('#J-trace-advanced-yinglilv-b-num').val()),
				//元角模式
				moneyUnit = me.getSameGameMoneyUnti(),
				//用户奖金组中该玩法中每注的中奖金额
				userGroupMoney = 0,
				//玩法中的单注单价
				onePrice = 0,
				//启用另外表头和行模板
				tpl = me.defConfig.dataRowYingliTemplate,
				orders = me.getOrderData()['orders'],


				//当前期
				currNumber = Games.getCurrentGame().getGameConfig().getInstance().getCurrentGameNumber(),
				//当前期标识
				currStr = '<span class="icon-period-current"></span>',
				//当前期文本
				currNumberText = '',
				//用户选择的开始期号
				settingStartNumber = me.traceStartNumberSelect.getValue(),
				startIndex,
				i = 0,
				//标记是否已经提示过一次
				isAlerted = false,
				numberData,
				//期号列表
				traceNumberList = Games.getCurrentGame().getGameConfig().getInstance().getGameNumbers();

				$.each(orders, function(){
					var method = Games.getCurrentGame().getGameConfig().getInstance().getMethodById(this['mid']);
					var prize = Games.getCurrentGame().getGameConfig().getInstance().getPrizeById(this['mid']);
					userGroupMoney += prize['prize'];
					onePrice += this['num'] * method['price'];
				});
				userGroupMoney *= moneyUnit;
				onePrice *= moneyUnit;


				tplArr.push(me.defConfig.dataRowYingliHeader);

				startIndex = me.getStartNumberIndexByNumber(settingStartNumber);

				timesTemp = times <= timesPre ? times : timesPre;
				resultData = me.getMultipleByYinglilv(yinglilv1, userGroupMoney, onePrice, timesTemp, multipleBase, maxNumltipleObj['maxnum']);

				if(resultData.length < 1){
					alert('您设置的参数无法达到盈利，请重新设置');
					return;
				}

				$.each(resultData, function(){
					if(this['oldMultiple'] > maxNumltipleObj['maxnum']){
						isAlerted = true;
						alert('生成方案中的倍数超过了系统最大允许设置的倍数，将自动调整为系统最大可设置倍数');
						return false;
					}
				});


				for(;i < resultData.length;i++){
					currNumberText = traceNumberList[i + startIndex]['number'];
					if(currNumberText == currNumber){
						currNumberText = currNumberText + currStr;
					}
					rowData = {'No':(i + 1),
								'traceNumber': currNumberText,
								'multiple':resultData[i]['multiple'],
								'money':me.formatMoney(onePrice * resultData[i]['multiple']),
								'userGroupMoney':me.formatMoney(userGroupMoney * resultData[i]['multiple']),
								'winTotalAmout':me.formatMoney(resultData[i]['winAmountAll']),
								'yinglilv':Number(resultData[i]['winAmountAll']/resultData[i]['amountAll']*100).toFixed(2)
					};
					tplArr.push(me.formatRow(tpl, rowData));
				}
				if(times > timesPre){
					$.each(resultData, function(){
						multipleBase += this['multiple'];
					});
					timesTemp = times - timesPre;
					resultData = me.getMultipleByYinglilv(yinglilv2, userGroupMoney, onePrice, timesTemp, multipleBase, maxNumltipleObj['maxnum']);

					$.each(resultData, function(){
						if(!isAlerted && this['oldMultiple'] > maxNumltipleObj['maxnum']){
							alert('生成方案中的倍数超过了系统最大允许设置的倍数，将自动调整为系统最大倍数');
							return false;
						}
					});

					len2 = i;
					i = 0;
					for(;i < resultData.length;i++){
						currNumberText = traceNumberList[i + len2 + startIndex]['number'];
						if(currNumberText == currNumber){
							currNumberText = currNumberText + currStr;
						}
						rowData = {'No':(i + 1),
									'traceNumber': currNumberText,
									'multiple':resultData[i]['multiple'],
									'money':me.formatMoney(onePrice * resultData[i]['multiple']),
									'userGroupMoney':me.formatMoney(userGroupMoney * resultData[i]['multiple']),
									'winTotalAmout':me.formatMoney(resultData[i]['winAmountAll']),
									'yinglilv':Number(resultData[i]['winAmountAll']/resultData[i]['amountAll']*100).toFixed(2)
						};
						tplArr.push(me.formatRow(tpl, rowData));
					}
				}



				me.getRowTable().html(tplArr.join(''));

		},
		//yinglilv 盈利率
		//prize 所有注单的单倍价格
		//onePrice 单注单价
		//times 需要运行的期数
		//multiple 起始倍数
		//maxnum 最大可设的倍数
		getMultipleByYinglilv:function(yinglilv, prize, onePrice, times, multipleBase, maxnum){
				//总金额
				//debugger;
			var amountAll =  multipleBase * onePrice,
				//标记原始计算出的倍数
				oldMultiple = 0,
				//每次运算结果倍数变量
				multiple,
				i = 0,
				result = [];

			//当期倍数＝ceil((总花销*(1+盈利率)/(单倍奖金-单倍成本*(1+盈利率)))
			for(;i < times;i++){
				multiple = Math.ceil(   amountAll * (1 + yinglilv)  /  (prize - onePrice * (1 + yinglilv))   );
				if(multiple < 1){
					break;
				}

				oldMultiple = multiple;
				if(i == 0){
				// multiple = multiple > maxnum ? maxnum : (multiple==1) ? multiple : multiple-1;
				multiple = multiple > maxnum ? maxnum : 1;
				}else{
				multiple = multiple > maxnum ? maxnum : multiple;
				}
				if(i == 0){
					amountAll = multiple * onePrice;
				}else{
					amountAll = amountAll + (multiple * onePrice);
				}
				result.push({'multiple':multiple, 'amountAll':amountAll,'winAmountAll':prize * multiple - amountAll, 'oldMultiple':oldMultiple});
			}
			return result;
		},
		//通过固定盈利金额得到倍数
		//userGroupMoney 单注中奖金额
		//yingliMoney 需要达到的盈利金额
		//amount 单笔投注成本
		//amountAll 累计投注成本
		getMultipleByMoney:function(userGroupMoney, yingliMoney, amount, amountAll){
			var i = 1,mx = 100000;
			for(;i < mx;i++){
				if((userGroupMoney * i - amountAll - amount * i) > yingliMoney){
					return i;
				}
			}
			//无法达到目标
			return -1;
		},
		//根据玩法名称获得用户当前将进组中奖金额(以元模式为单位)
		//
		getPlayGroupMoneyByGameMethodName:function(mid){
			return Number(Games.getCurrentGame().getGameConfig().getInstance().getPrizeById(mid)['prize']);
		},
		formatRow:function(tpl, data){
			var me = this,o = data,p,reg;
			for(p in o){
				if(o.hasOwnProperty(p)){
					reg = RegExp('<#=' + p + '#>', 'g');
					tpl = tpl.replace(reg, o[p]);
				}
			}
			return tpl;
		},
		//将数字保留两位小数并且千位使用逗号分隔
		formatMoney:function(num){
			var num = Number(num),
				re = /(-?\d+)(\d{3})/;

			if(Number.prototype.toFixed){
				num = (num).toFixed(3);
			}else{
				num = Math.round(num*100)/100
			}
			num  =  '' + num;
			while(re.test(num)){
				num = num.replace(re,"$1,$2");
			}
			return num;
		},
		getAdvancedTable:function(){
			var me = this;
			return me._advancedTable || (me._advancedTable = $('#J-trace-table-advanced'));
		},
		getAdvancedRowTable:function(){
			var me = this;
			return me._advancedTableContainer || (me._advancedTableContainer = $('#J-trace-table-advanced-body'));
		},
		getNormalTable:function(){
			var me = this;
			return me._table || (me._table = $('#J-trace-table'));
		},
		getNormalRowTable:function(){
			var me = this;
			return me._tableContainer || (me._tableContainer = $('#J-trace-table-body'));
		},
		getTable:function(){
			var me = this;
			if(me.isAdvanced()){
				return me._advancedTable || (me._advancedTable = $('#J-trace-table-advanced'));
			}
			return me._table || (me._table = $('#J-trace-table'));
		},
		getRowTable:function(type){
			var me = this;
			return $('#J-trace-table-'+ type +'-body');
		},
		setCurrentTraceNumber:function(v){
			var me = this;
			me.currentTraceNumber = v;
		},
		getCurrentTraceNumber:function(){
			return me.currentTraceNumber;
		},
		//追号起始期号
		setTraceStartNumber:function(v){
			var me = this;
			me.traceStartNumber = v;
		},
		getTraceStartNumber:function(){
			return me.traceStartNumber;
		},
		getMultiple:function(){
			var me = this;
			if(me.isAdvanced()){
				return me.getAdvancedMultiple();
			}
			return me.getNormalMultiple();
		},
		getNormalMultiple:function(){
			return Number(this.normalSelectMultiple.getValue());
		},
		getAdvancedMultiple:function(){
			return Number($('#J-trace-advance-multiple').val());
		},
		setIsWinStop:function(v){
			var me = this;
			this.isWinStop = !!v;
		},
		getTimes:function(type){
			var me = this;
			return Number($('#J-trace-'+ type +'-times').val());
		},
		//获取追号期数(高级)
		getAdvancedTimes:function(){
			return Number($('#J-trace-advanced-times').val());
		},
		//是否为高级追号
		isAdvanced:function(){
			var me = this;
			return me.traceType == 'lirunlv' ||  me.traceType == 'fanbei';
		},
		//切换追号类型
		setTraceType:function(type){
			var me = this;
			me.traceType = type;
		},
		getTraceType:function(){
			return this.traceType;
		},
		//获取已生成列表的追号类型
		getRowTableType:function(type){
			var me = this;
			return me.getRowTable(type).attr('data-type');
		},
		//清空已生成的列表
		emptyRowTable:function(){
			var me = this;
			$('#J-trace-table-body').html('');
			$('#J-trace-table-advanced-body').html('');
			$('#J-trace-statistics-times').html('0');
			$('#J-trace-statistics-lotterys-num').html('0');
			$('#J-trace-statistics-amount').html('0');
			//me.updateStatistics();
		},
		checkTraceAvailabity: function(){
			var me = this,
				orderAmount = Games.getCurrentGameOrder().getTotal()['amount'],
				msg = Games.getCurrentGameMessage();
			// 是否有投注内容
			if(orderAmount <= 0){
				msg.show({
					type : 'mustChoose',
					msg : '请至少选择一注投注号码！',
					data : {
						tplData : {
							msg : '请至少选择一注投注号码！'
						}
					}
				});
				return false;
			}
			// 面板展开时将号码篮倍数设置为1倍
			Games.getCurrentGameOrder().editMultiples(1);
			return true;
		},
		show:function(){
			var me = this,
				orderAmount = Games.getCurrentGameOrder().getTotal()['amount'],msg = Games.getCurrentGameMessage();
			//是否有投注内容
			if(orderAmount <= 0){
				msg.show({
					type : 'mustChoose',
					msg : '请至少选择一注投注号码！',
					data : {
						tplData : {
							msg : '请至少选择一注投注号码！'
						}
					}
				});
				return;
			}
			//面板展开时将号码篮倍数设置为1倍
			Games.getCurrentGameOrder().editMultiples(1);

			me.showPanel();
		},
		hide:function(){
			var me = this;
			me.hidePanel();
			//me.emptyRowTable();
			//console.log(me.getIsTrace());
			if(me.getIsTrace() == 1){
				Games.getCurrentGameOrder().editMultiples(1);
			}else{
				Games.getCurrentGameOrder().restoreMultiples();
			}
		},
		showPanel:function(){
			var me = this;
			host.Mask.getInstance().show();
			// if( me.checkTraceAvailabity() ){
			// 	me.panel.show();
			// 	me.panelIsVisible = true;
			// }else{
			// 	me.hidePanel();
			// }
			me.panel.show();
			// me.panelIsVisible = true;
		},
		hidePanel:function(){
			var me = this;
			host.Mask.getInstance().hide();
			me.panel.hide();
			// me.panelIsVisible = false;
		},
		applyTraceData:function(){
			var me = this,
				times = Number($.trim($('#J-trace-statistics-times').text())),
				num = Number($.trim($('#J-trace-statistics-lotterys-num').text())),
				amount = Number($.trim($('#J-trace-statistics-amount').text().replace(/[^\d|\.]/g,'')));

			//追号有内容
			if(times > 0){
				me.setIsTrace(1);
				Games.getCurrentGameOrder().setTotalLotterysNum(num);
				Games.getCurrentGameOrder().setTotalAmount(amount);
				// $('#J-trace-num-tip-panel').show();
				// $('#J-trace-num-text').text(times);
			}else{
				//内容没有发生改变，恢复原来号码篮原来的倍数
				Games.getCurrentGameOrder().restoreMultiples();

				me.setIsTrace(0);
				// $('#J-trace-num-tip-panel').hide();
				me.hide();
			}

			// me.hidePanel();
			// host.Mask.getInstance().hide();
			// me.panel.hide();

		},
		//删除追号
		deleteTrace:function(){
			var me = this
			Games.getCurrentGameOrder().restoreMultiples();
			me.setIsTrace(0);
			me.emptyRowTable();
			$('#J-trace-num-tip-panel').hide();
			//clear table row
			me.getTbodys().html('');
		},
		getTbodys:function(){
			var me = this;
			return me.panel.find('tbody[data-type]');
		},
		//自动触发删除追号，该方法将触发一个轻提示
		autoDeleteTrace:function(){
			var me = this,tip = new host.Tip({cls:'j-ui-tip-b'});
			me.deleteTrace();
			// tip.setText('由于您对注单进行了修改，追号被自动取消，<br />如需要继续追号，请重新设置追号');
			// tip.show(-90, -60, $('#J-trace-switch'));
			setTimeout(function(){
				tip.getDom().fadeOut();
			},2000);
		},
		//复位追号区的tab以及相关输入框默认值
		reSetTab:function(){
			var me = this,
				tab1 = me.TraceTab,
				tab2 = me.TraceAdvancedTab;
			//追号tab
			tab1.triggers.removeClass(tab1.defConfig.currClass);
			tab1.triggers.eq(0).addClass(tab1.defConfig.currClass);
			tab1.panels.removeClass(tab1.defConfig.currPanelClass);
			tab1.panels.eq(0).addClass(tab1.defConfig.currPanelClass);
			tab1.index = 0;
			//高级追号tab
			tab2.triggers.removeClass(tab2.defConfig.currClass);
			tab2.triggers.eq(0).addClass(tab2.defConfig.currClass);
			tab2.panels.removeClass(tab2.defConfig.currPanelClass);
			tab2.panels.eq(0).addClass(tab2.defConfig.currPanelClass);
			tab2.index = 0;

			//恢复输入框默认值
			$('#J-trace-normal-times').val(10);
			$('#J-function-select-tab .function-select-title li').removeClass('current').eq(1).addClass('current');
			// 此被注释
			// me.normalSelectMultiple.setValue(1);

			$('#J-trace-advanced-times').val(10);
			$('#J-trace-advance-multiple').val(1);
			$('#J-trace-advanced-fanbei-a-jiange').val(2);
			$('#J-trace-advanced-fanbei-a-multiple').val(2);
			$('#J-trace-advanced-fanbei-b-num').val(5);
			$('#J-trace-advanced-fanbei-b-multiple').val(3);
			$('#J-trace-advanced-yingli-a-money').val(100);
			$('#J-trace-advanced-yingli-b-num').val(2);
			$('#J-trace-advanced-yingli-b-money1').val(100);
			$('#J-trace-advanced-yingli-b-money2').val(50);
			$('#J-trace-advanced-yinglilv-a').val(10);
			$('#J-trace-advanced-yinglilv-b-num').val(5);
			$('#J-trace-advanced-yingli-b-yinglilv1').val(30);
			$('#J-trace-advanced-yingli-b-yinglilv2').val(10);


			//设置对应的tab标记属性
			me.setTraceType(me.opts.defaultType);
			me.advancedType = me.defConfig.advancedTypeHas[0];
			me.typeTypeType = 'a';

			//恢复默认的高级选项
			$('#J-trace-advanced-type-panel').find('input[type="radio"]').each(function(i){
				if((i+1)%2 != 0){
					var el = $(this),par = el.parent(),pars = par.parent().children(),_par;
					this.checked = true;
					pars.each(function(i){
						_par = pars.get(i);
						if(par.get(0) != _par){
							$(_par).find('input[type="text"]').attr('disabled', 'disabled');
						}else{
							$(_par).find('input[type="text"]').attr('disabled', false);
						}
					});
				}
			});

		}
	};

	var Main = host.Class(pros, Event);
		Main.defConfig = defConfig;
		Main.getInstance = function(cfg){
			return instance || (instance = new Main(cfg));
		};
	host[name] = Main;

})(dsgame, "GameTrace", dsgame.Event);
//游戏订单模块
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
				len2 = traceInfo['traceData'].length,
				jsId = 0;
			result['gameId'] = Games.getCurrentGame().getGameConfig().getInstance().getGameId();
			//result['gameType'] = Games.getCurrentGame().getName();
			result['isTrace'] = Games.getCurrentGameTrace().getIsTrace();
			result['traceWinStop'] = Games.getCurrentGameTrace().getIsWinStop();
			result['traceStopValue'] = Games.getCurrentGameTrace().getTraceWinStopValue();
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
								'multiple'  : balldata['multiple'],
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
					// 		'multiple'  : balldata['multiple'],
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
								'multiple'  : balldata['multiple'],
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
						'multiple'  : balldata['multiple'],
						'prizeGroup': balldata['prizeGroup']
					});
				}
			});
			// console.log(result);

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
			// console.log(result)
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

})(dsgame, "GameSubmit", dsgame.Event);