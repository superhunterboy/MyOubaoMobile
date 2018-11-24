(function(host, undefined) {
	var ConfigData = gameConfigData,
		defConfig = {},
		nodeCache = {},
		methodCacheById = {},
		methodCacheByName = {},
		ballLists = [],
		instance;

		//ConfigData['jsPath'] = ConfigData['jsPath'].replace('ssc', 'K3');
	ballLists = gameSelfConfig['gamediceBallLists'];

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
			return ConfigData['issueHistory']['last_number'] ? ConfigData['issueHistory']['last_number']['wn_number'] : '';
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
(function($){
	function F(t, o){
		this.opts = $.extend({
			sheetElement: '#J-dice-sheet',
			barElement: '#J-dice-bar',
			chipsAnimationDelay: 600, // 筹码动画时间
			chipsAnimationDelay2: 100, // 筹码抽离时间
			chipSize: [50, 46], // width/height
			chipStep: 2, // 筹码重叠间距
			chipZindex: 2,
			actionTipsTxt: '该注单超过限额,无法再增加筹码',
			actionTipsDelay: 600,
			chips: [1,2,5,10,20,50,100,500,1000,5000],
			chipsSelected: [10,20,50,100,500],
			prizeGroup: 1800, // 暂未用
			gameConfig: function(){},
			message: function(){},
			allowPrinted: false,
			gameHistory: function(){},
			createOddsTips: function(){},
			initContinus: 1, // 默认连投数
			initMultiple: 1, // 默认倍投数
			maxMultiple: 9999, // 最大倍数
			multipleCheckDisabled: false,
			debugs: true // 是否支持debug [0/false, 1=>对象级输出, 2=>字符串级输出]
		}, o);
		this.slides = [];
		this.$t = $(t);
		// 投注金额
		this.betAmount = 0;
		// 投注总金额
		this.betCountAmount = 0;
		// 连投次数
		this.continusTimes = 1;
		// 倍投数
		this.multipleTimes = 1;
		this.gamelimit = {};
		this.debugs = this.opts.debugs;
		// this.isIE6 = $.browser.msie && parseFloat($.browser.version) < 7;
		this.init();
	}

	F.prototype = {
		init: function(){
			var me = this,
				opts = me.opts;
			me.gameConfig = opts.gameConfig;
			me.message = opts.message;
			me.gameHistory = opts.gameHistory;
			me.setGameLimit(me.gameConfig.getGameLimit());
			// 设置money unit
			me.setMoneyUnit(me.gameConfig.getDefaultCoefficient());
			// 设置用户奖金组
			me.setUserPrizeGroup();

			var config = me.gameConfig.getConfig()
			me.gameMethods = config.gameMethods;
			// me.setConfig(config);

			me.revocationIsEnabled = true;
			me.multipleCheckDisabled = opts.multipleCheckDisabled;

			// 操作记录
			me.actionLogs = [];
			// 投注信息
			me.betData = {};

			me.$sheetWrap = $(opts.sheetElement);
			me.$bar = $(opts.barElement);
			// 桌布玩法面板
			me.createDiceSheet();
			// 投注余额区
			me.createBalance();
			// 筹码区块
			me.createDiceChip();
			// 连投
			me.$continus = me.counterHtml();
			me.continusCounter = me.$continus.counter({
				max: me.gameConfig.getTraceMaxTimes()
			});
			// 倍投
			me.$multiple = me.counterHtml();
			me.multipleCounter = me.$multiple.counter({
				max: opts.maxMultiple
			});
			// 按钮操作区
			me.createActionButtons();
			// 投注历史toggle按钮
			me.createHistoryToggle();
			// Game Tips
			me.createGameTips();
			// Odds Tips
			me.createOddsTips();
			// Action Tips
			me.createActionTips();
			me.setActionTipsTxt(opts.actionTipsTxt);

			// 筹码金额数组，主要用于rebuildChip计算用
			me.chips = opts.chips.reverse();
			// 当前筹码金额
			me.setChipValue( opts.chipsSelected[0] );
			// 投注金额
			me.setBetAmount(0);
			// 连投次数
			me.setContinusTimes(opts.initContinus);
			// 倍投数
			me.setMultipleTimes(opts.initMultiple);
			me.createMaxMultipleTips();

			/*状态值*/
			// 是否还在执行动画，因为动画较多，动画执行过程中是不允许下单等操作的进行
			me.setAnimationStatus(false);

			// event
			me.checkActionsStatus();
			me.bindEvent();
		},
		// 生成玩法区
		createDiceSheet: function(){
			var html = '';
			// 从0开始
			$.each(this.gameConfig.getBallLists(), function(i, n){
				html += '<div data-view="' + n['viewBalls'] +  '" data-methodid="' + n['id'] + '" class="dice-sheet dice-sheet-' + i + '" data-name="' + n['name'] + '">';
					html += '<div class="dice-sheet-bg"></div>';
				html += '</div>';
			});
			this.$sheetWrap.append(html);
			return this.$sheets = this.$sheetWrap.find('.dice-sheet');
		},
		// 生成余额区
		createBalance: function(){
			var html =
				'<div class="dice-balance">' +
					'<div class="bet-amount"><label>下注额:</label>￥<span data-count-amount>0.00</span></div>' +
					'<div class="bet-balance"><label>余额:</label>￥<span data-user-account-balance>0</span>' +
						'<i class="ui-icon bet-balance-refresh" data-refresh-balance>刷新</i>' +
						'<a class="ui-icon bet-balance-recharge" data-action="recharge" href="javascript:void(0)">充值</a>' +
					'</div>' +
				'</div>';
			this.$bar.append(html);
			this.$betCountAmount = this.$bar.find('[data-count-amount]');
			this.$balancerecharge = this.$bar.find('[data-action="recharge"]');
		},
		// 生成筹码区
		createDiceChip: function(){
			var me = this,
				opts = me.opts,
				chips = opts.chips,
				chipsSelected = opts.chipsSelected,
				html = '<div class="dice-chip-wrap">';
				html1 = '<div class="dice-chip-choose">',
				html2 = '<div class="dice-chip-custom">';
			// me.debug(chips)
			$.each(chips, function(idx, val){
				var cl = $.inArray(val, chipsSelected) < 0 ? ' dice-chip-hide' : '';
				html1 += '<div data-value="' + val+ '" class="dice-chip dice-chip-' + val + cl + '">' + val + '</div>';
				html2 += '<div data-value="' + val+ '" class="dice-chip-mirror dice-chip-' + val + cl +  '">' + val + '</div>';
			});
			html += html1 + '<div class="dice-chip-shadow"></div></div>';
			html += '<div class="dice-chip-button">自定义</div>';
			html += html2 + '</div>';
			me.$bar.append(html);

			this.$chipsWrap = this.$bar.find('.dice-chip-choose');
			this.$chipsButton = this.$bar.find('.dice-chip-button');
			this.$chipsCustom = this.$bar.find('.dice-chip-custom');
			this.$chipsMirror = this.$bar.find('.dice-chip-mirror');
			this.$chips = this.$bar.find('.dice-chip');
			var arr = [];
			this.$chipsMirror.each(function(){
				if( !$(this).hasClass('dice-chip-hide') ){
					arr.push($(this));
				}
			});
			this.setChipsMirror(arr);
		},
		// 生成事件按钮区
		createActionButtons: function(){
			var html ='<div class="action-buttons">';
			// 下注
			html += '<button class="ui-button ui-button-primary button-bet" data-action="bet">下注</button>';
			// 撤销
			html += '<button class="ui-button button-revocation" data-action="revocation">撤销</button>';
			// 清空
			html += '<button class="ui-button button-clear" data-action="clear">清空</button>';

			html += '</div>';
			this.$bar.append(html);
			return this.$actions = this.$bar.find('button[data-action]');
		},
		// 生成投注历史开关按钮
		createHistoryToggle: function(){
			var html =
				'<div class="history-toggle"> \
					<span>投注记录</span> \
					<i></i> \
				</div>';
			this.$bar.append(html);
		},
		// 生成游戏玩法tips
		createGameTips: function(){
			var gameMethods = this.gameConfig.getGameMethods('byName'),
				html = '';
			// console.log(gameMethods)
			$.each(gameMethods, function(k, n){
				// console.log(k,n);
				html += '<div class="ui-icon game-tips game-tips-' +n.fullname_en[2]+ '" data-name="' + n.fullname_en.join('.') + '" data-tips-title="' + (n.bet_note || n.name_cn) + '"></div>';
			});
			this.$sheetWrap.append(html);
			return this.$tips = this.$sheetWrap.find('.game-tips');
		},
		// 生成赔率tips
		createOddsTips: function(){
			var ballLists = this.gameConfig.getBallLists(),
				gamelimit = this.getGameLimit(),
				prizeGroup = Number(this.getUserPrizeGroup()),
				maxPrizeGroup = this.getMaxPrizeGroup(),
				html = '';

			html = this.opts.createOddsTips(ballLists, gamelimit, prizeGroup, maxPrizeGroup);
			
			this.$sheetWrap.append(html);
			return this.$oddsTips = this.$sheetWrap.find('.odds-tips');
		},
		// 生成筹码操作提示tips
		createActionTips: function(){
			this.$actionTips = $('<div class="ui-tips ui-tips-alert ui-tips-bottom"><span class="ui-tips-text"></span><i class="ui-tips-arrow"></i></div>');
			this.$actionTips.css({
				position: 'absolute',
				zIndex: 100
			}).appendTo('body').animate({opacity: 'hide'}, 0);
		},
		// 生成筹码操作提示tips
		createMaxMultipleTips: function(){
			this.$maxMultipleTips = $('<div class="ui-tips ui-tips-alert ui-tips-top"><span class="ui-tips-text"></span><i class="ui-tips-arrow"></i></div>');
			this.$maxMultipleTips.css({
				position: 'absolute',
				zIndex: 100
			}).appendTo('body').animate({opacity: 'hide'}, 0);
		},
		// 生成计数器html
		counterHtml: function(){
			var html =
				'<div class="ui-simulation-wrap">' +
					'<div class="ui-simulation-title" data-counter-title></div>' +
					'<div class="ui-simulation-counter">' +
						'<span class="ui-icon counter-action counter-decrease" data-counter-action="decrease">－</span>' +
						'<input type="text" value="1" class="J_counter">' +
						'<span class="ui-icon counter-action counter-increase" data-counter-action="increase">＋</span>' +
					'</div>' +
				'</div>';
			return $(html).appendTo(this.$bar);
		},
		/* 获取dom相关接口 */
		// 获取当前容器
		getTargetElement: function(){
			return this.$t;
		},
		// 获取筹码（可投放筹码）
		getChipsElements: function(){
			return this.$chips;
		},
		// 获取筹码外围容器
		getChipsWrapElement: function(){
			return this.$chipsWrap;
		},
		// 自定义按钮
		getChipsButtonElements: function(){
			return this.$chipsButton;
		},
		// 自定义筹码区（外围容器）
		getChipsCustomElements: function(){
			return this.$chipsCustom;
		},
		// 自定义筹码
		getChipsMirrorElements: function(){
			return this.$chipsMirror;
		},
		// 获取所有玩法元素
		getSheetsElements: function(){
			return this.$sheets;
		},
		// 获取操作按钮（下注、撤销、清空）
		getActionsElements: function(){
			return this.$actions;
		},
		// // 获取余额刷新按钮
		// getBalanceRefreshElements: function(){
		// 	return this.$balanceRefresh;
		// },
		// 获取充值按钮
		getBalanceRechargeElements: function(){
			return this.$balancerecharge;
		},
		// 获取游戏玩法元素
		getTipsElements: function(){
			return this.$tips;
		},
		// 获取赔率tips元素
		getOddsTipsElements: function(){
			return this.$oddsTips;
		},
		// 设置当前选中的筹码元素
		setSelectedChipElements: function($selected){
			this.$selectedChip = $selected;
		},
		// 获取当前选中的筹码元素
		getSelectedChipElements: function(){
			return this.$selectedChip;
		},
		// 获取操作tips元素
		getActionTipsElements: function(){
			return this.$actionTips;
		},
		// 获取最大倍数tips元素
		getMaxMultipleTipsElements: function(){
			return this.$maxMultipleTips;
		},
		/* 获取参数相关 */
		// 获取连投组件，为jQuery对象
		getContinusCounter: function(){
			return this.continusCounter;
		},
		// 获取倍投组件，为jQuery对象
		getMultipleCounter: function(){
			return this.multipleCounter;
		},
		// 设置筹码动画状态
		setAnimationStatus: function(animation){
			this.isAnimation = animation;
		},
		// 获取筹码动画状态
		getAnimationStatus: function(){
			return this.isAnimation;
		},
		// 设置操作tips内容
		setActionTipsTxt: function(txt){
			this.actionTipsTxt = txt;
		},
		// 获取操作tips内容
		getActionTipsTxt: function(){
			return this.actionTipsTxt;
		},
		// 设置选中的自定义筹码数组
		setChipsMirror: function(arr){
			this.chipsMirror = arr;
		},
		// 获取选中的自定义筹码[数组]
		getChipsMirror: function(){
			return this.chipsMirror;
		},
		// 设置当前选择筹码的金额值
		setChipValue: function(value){
			this.chipValue = value;
		},
		// 获取当前选中筹码的金额数
		getChipValue: function(value){
			return this.chipValue;
		},
		// 设置moneyunit
		setMoneyUnit: function(unit){
			this.moneyunit = Number(unit || '0.50');
		},
		// 获取当前moneyunit
		getMoneyUnit: function(){
			return this.moneyunit;
		},
		// 设置玩法限额列表(全局)
		setGameLimit: function(limit){
			if( limit ){
				return this.gamelimit = limit;
			}
		},
		// 获取玩法限额列表
		getGameLimit: function(){
			return this.gamelimit;
		},
		setUserPrizeGroup: function(prizeGroup){
			if( !prizeGroup ){
				var optionalPrizes = this.gameConfig.getOptionalPrizes(),
					maxPrizeGroup = this.gameConfig.getMaxPrizeGroup(),
					prizeGroup = Number(optionalPrizes[optionalPrizes.length-1]['prize_group'] || this.opts.prizeGroup);
			}
			this.prizeGroup = Number(prizeGroup);
			this.maxPrizeGroup = Number(maxPrizeGroup);
		},
		getUserPrizeGroup: function(){
			return this.prizeGroup;
		},
		getMaxPrizeGroup: function(){
			return this.maxPrizeGroup;
		},
		disableRevocation: function(){
			this.revocationIsEnabled = false;
			this.getActionsElements().filter('[data-action="revocation"]').addClass('disabled');
		},
		enableRevocation: function(){
			this.revocationIsEnabled = true;
			// this.checkActionsStatus();
			if( this.actionLogs.length ){
				this.getActionsElements().filter('[data-action="revocation"]').addClass('disabled');
			}
		},
		// 设置玩法投注金额(val为变化后数值)
		setSheetData: function($t, val){
			var v = this.getSheetData($t);
			val = parseFloat(val) || 0;
			if( val != 0 ){
				// this.debug(v, val);
				// 缓存当前数据
				$t.data('value', v + val );
				// 重构当前节点下筹码
				this.rebuildChip($t);
				// 设置投注总金额
				this.setBetAmount(val);
				// 重构当前投注信息
				var key = this.getSheetsElements().index( $t.eq(0) );
				this.setBetData(key, val);
				if( $t.tips() ){
					$t.tips().setText(v+val);
				}

				this.checkActionsStatus();
			}
		},
		// 获取玩法投注金额
		getSheetData: function($t){
			return parseFloat( $t.data('value') ) || 0;
		},
		// 设置投注总金额
		setBetCountAmount: function(){
			var amount = this.getBetAmount(),
				multiple = this.getMultipleTimes(),
				continus = this.getContinusTimes(),
				betCountAmount = amount * multiple * continus;
			this.$betCountAmount.text(this.currency(betCountAmount));
			return this.betCountAmount = betCountAmount;
		},
		// 获取投注总金额
		getBetCountAmount: function(){
			return this.betCountAmount;
		},
		// 设置投注金额（单倍、单次）
		setBetAmount: function(val){
			val = parseFloat(val) || 0;
			this.betAmount += val;
			this.setBetCountAmount();
		},
		// 获取投注金额（单倍、单次）
		getBetAmount: function(){
			return this.betAmount;
		},
		// 设置连投次数
		setContinusTimes: function(times){
			times = parseFloat(times) || 0;
			// this.debug(times);
			this.continusTimes = times;
			this.setBetCountAmount();
		},
		// 获取连投次数
		getContinusTimes: function(){
			return this.continusTimes || 1;
		},
		// 设置投注信息倍投数
		setBetDataMultiple: function(key, times){
			var me = this,
				betData = me.getBetData()[key] || {};

			if( !$.isEmptyObject(betData) ){
				betData['multiple'] = times * betData['amount'] / ( betData['onePrice'] * betData['moneyunit'] );
			}
		},
		// 设置倍投次数
		setMultipleTimes: function(times){
			var me = this,
				times = parseFloat(times) || 1;
			// me.debug(times);
			me.multipleTimes = times;
			me.setBetCountAmount();
			$.each(me.getBetData(), function(key, value){
				me.setBetDataMultiple(key, times);
			});
		},
		// 获取倍投次数
		getMultipleTimes: function(){
			return this.multipleTimes;
		},
		// 设置投注信息（val为金额变化值，如果变化后为0，删除该条信息）
		setBetData: function(key, val){
			var me = this,
				betData = me.getBetData()[key] || {};

			if( $.isEmptyObject(betData) ){
				me.getBetData()[key] = betData;
			}

			var amount = betData.amount ? betData.amount + val : val,
				prizeGroup = me.getUserPrizeGroup(),
				maxPrizeGroup = me.getMaxPrizeGroup();
			if( prizeGroup > maxPrizeGroup ){
				prizeGroup = maxPrizeGroup;
			}
			if( !amount ){
				delete me.betData[key];
			}else{
				var balls = me.gameConfig.getBallLists()[key],
					wayid = me.getSheetsElements().eq(key).data('methodid'),
					moneyunit = me.getMoneyUnit(),
					mTimes = me.getMultipleTimes(),
					onePrice = me.gameConfig.getOnePriceById(wayid);
				betData = {
					ball: balls['ball'],
					viewBalls: balls['viewBalls'],
					jsId: key, // 从0开始
					wayId: wayid,
					moneyunit: moneyunit,
					multiple: mTimes * amount / ( onePrice * moneyunit ),
					amount: amount, // 投注额，后台不需要此数据
					onePrice: onePrice,
					num: 1, // 注数，默认为1注
					prizeGroup: prizeGroup,
					type: balls['name']
				};
				return me.betData[key] = betData;
			}
			// me.debug(me.betData);
		},
		// 获取投注信息
		getBetData: function(){
			return this.betData;
		},
		// 更新投注信息的wayid
		updateBetDataWayId: function(key, wayid){
			return this.betData[key] && (this.betData[key]['wayId'] = wayid);
		},
		// // 获取账户余额
		getBalance: function($t){
			$('[data-refresh-balance]').eq(0).trigger('click');
		},
		// 重新获取服务器端动态配置
		getServerDynamicConfig: function(){
			var me = this;
			if( me.isLogout ) return;
			$.ajax({
				url: me.gameConfig.getUpdateUrl(),
				dataType: 'JSON',
				success:function(data){
					data = ($.type(data) == 'string') ? $.parseJSON(data) : data;
					var message = me.message;
					if(data['type'] == 'loginTimeout'){
						me.isLogout = true;
						me.getTargetElement().trigger('dsgame.dice.logout');
					}else if(Number(data['isSuccess']) == 1){
						var conf = data.data;
						me.gameConfig.updateConfig(conf);
						me.getContinusCounter().setMaxValue( me.gameConfig.getTraceMaxTimes() );
						me.setGameLimit( me.gameConfig.getGameLimit() );
						me.updateSheetsData();

						var newConfig = me.gameConfig.getConfig();
						me.getTargetElement().trigger('dsgame.dice.dynamicConfigChange', newConfig);
					}
				}
			});
		},
		// 获取最新的开奖号码和奖期
		getServerIssues: function(){
			var me = this;
			if( me.isLogout ) return;
			$.ajax({
				url: me.gameConfig.getLoadIssueUrl(),
				dataType: 'JSON',
				success:function(data){
					data = ($.type(data) == 'string') ? $.parseJSON(data) : data;
					if(data['type'] == 'loginTimeout'){
						me.isLogout = true;
						me.getTargetElement().trigger('dsgame.dice.logout');
					}else{
						me.getTargetElement().trigger('dsgame.dice.serverIssuesChange', data);
					}
				}
			});
		},
		updateSheetsData: function(){
			var me = this,
				balls = me.gameConfig.getBallLists(),
				$sheets = me.getSheetsElements();
			$.each(balls, function(i, n){
				var $sheet = $sheets.eq(i),
					id = $sheet.data('methodid'),
					mid = n['id'],
					value ;
				if( id != mid ){
					$sheet.attr('data-methodid', mid).data('methodid', mid);
					me.updateBetDataWayId(i, mid);
				}
			});
			// return this.$sheets = this.$sheetWrap.find('.dice-sheet');
		},
		// 初始化绑定事件
		bindEvent: function(){
			var me = this;
			// 连投
			me.getContinusCounter().setOnSetValue(function(value){
				me.setContinusTimes(value);
			});
			// 倍投
			var $ctrl = me.getMultipleCounter().$ctrl.filter('[data-counter-action="increase"]'),
				maxTipsText = '当前投注方案下无法再增加倍数了';
			me.getMultipleCounter().setBeforeSetValue(function(value){
				var newValue = me.checkMultipleTimes(value);
				if( newValue < value ){
					me.showMaxMultipleTips($ctrl, maxTipsText, 1500);
				}
				return newValue;
			});
			me.getMultipleCounter().setOnSetValue(function(value){
				me.setMultipleTimes(value);
			});

			me.$t.on('animate.start', function(){
				return me.setAnimationStatus(true);
			}).on('animate.end', function(){
				return me.setAnimationStatus(false);
			});
			me.isReady = true;
		},
		ready: function(callback){
			var me = this;
			if( callback && Object.prototype.toString.call(callback) == '[object Function]' ){
				(function(){
					if( me.isReady ){
						callback();
					}else{
						setTimeout(arguments.callee, 10);
					}
				})();
			}
		},
		// 检查投注是否已经超过该玩法的限额（超过返回ture）
		chipIsOverLimit: function($t, val){
			var me = this,
				data = $t && $t.data() || {},
				gamelimit = me.getGameLimit(),
				methodid = data['methodid'] || -1,
				multiple = me.getMultipleTimes(),
				val = Number(val) || 0;
			if( !gamelimit[methodid] || !gamelimit[methodid]['max_multiple'] ){
				return false;
			}
			var limit = gamelimit[methodid]['max_multiple'] * ( me.gameConfig.getOnePriceById(methodid) || 2 ),
				value = Number(data['value'] || 0);

			/*me.getSheetsElements().filter('[data-methodid="' +methodid+ '"]').each(function(){
				value += parseFloat( $(this).data('value') || 0 );
			});*/

			if( (value + val) * multiple > limit ){
				return true;
			}else{
				return false;
			}
		},
		checkMultipleTimes: function(times){
			var me = this;
			if( times <= me.getMultipleTimes() || me.multipleCheckDisabled ){
				return times;
			}
			me.getSheetsElements().each(function(idx, sheet){
				var value = $(sheet).data('value'),
					methodId = $(sheet).data('methodid');
				if( value && methodId ){
					times = Math.min(times, me.getAvailableTimes(value, methodId));
				}
			});
			return times;
		},
		// 根据投注额和玩法id获取可用倍数
		getAvailableTimes: function(value, methodId){
			var me = this,
				gamelimit = me.getGameLimit(),
				value = Number(value) || 0,
				maxTimes = me.getMultipleCounter().getMaxValue();
			if( !gamelimit[methodId] || !gamelimit[methodId]['max_multiple'] ){
				me.debug('无法获取到玩法id为' + methodId + '的倍数限额！')
				return maxTimes;
			}
			if( value <= 0 ){
				me.debug('当前玩法投注额为0，无需获取倍数限额！')
				return maxTimes;
			}
			var limit = gamelimit[methodId]['max_multiple'] * ( me.gameConfig.getOnePriceById(methodId) || 2 );
			return Math.floor( limit / value );

		},
		// 检查投注清单是否被允许（主要是倍数）
		checkOrder: function(){
			var me = this,
				betData = me.getBetData(),
				gamelimit = me.getGameLimit(),
				limitOverText = [];

			if( $.isEmptyObject(betData) ) return [];

			$.each(betData, function(idx, data){
				var wayId = data['wayId'],
					amount = Number(data['amount']),
					limit = gamelimit[wayId]['max_multiple'] * ( me.gameConfig.getOnePriceById(wayId) || 2 );
				if( amount > limit ){
					limitOverText.push({
						idx: idx,
						viewBalls: data['viewBalls'],
						name: gamelimit[wayId]['name'],
						limit: limit
					});
				}
			});
			return limitOverText;
		},
		// 显示操作提示tips
		showActionTips: function($t, msg, delay){
			var me = this,
				$tips = me.getActionTipsElements(),
				offset = $t.offset(),
				fix = 10,
				delay = delay || me.opts.actionTipsDelay;
			if( me.actionTipsTimer ){
				clearTimeout(me.actionTipsTimer);
				me.actionTipsTimer = null;
			}
			if( msg ) $tips.find('.ui-tips-text').html(msg);
			$tips.css({
				left: offset.left + ( $t.outerWidth() - $tips.outerWidth() ) / 2,
				top: offset.top + $t.outerHeight() + fix
			}).animate({
				opacity: 'show'
			}, function(){
				me.actionTipsTimer = setTimeout(function(){
					$tips.animate({
						opacity: 'hide'
					});
				}, delay);
			});
		},
		// 显示操作提示tips
		showMaxMultipleTips: function($t, msg, delay){
			var me = this,
				$tips = me.getMaxMultipleTipsElements(),
				offset = $t.offset(),
				fix = 40,
				delay = delay || me.opts.actionTipsDelay;
			if( me.maxMultipleTipsTimer ){
				clearTimeout(me.maxMultipleTipsTimer);
				me.maxMultipleTipsTimer = null;
			}
			if( msg ) $tips.find('.ui-tips-text').html(msg);
			$tips.css({
				left: offset.left + ( $t.outerWidth() - $tips.outerWidth() ) / 2,
				top: offset.top - $t.outerHeight() - fix
			}).animate({
				opacity: 'show'
			}, function(){
				me.maxMultipleTipsTimer = setTimeout(function(){
					$tips.animate({
						opacity: 'hide'
					});
				}, delay);
			});
		},
		// 点击玩法下筹码操作动画
		moveChip: function($t){
			if( !$t || !$t.length ) return;

			var me = this,
				$selectedChip = me.getSelectedChipElements(),
				$chip = $selectedChip.clone(),
				value = $chip.data('value'),
				offset1 = $t.offset(),
				offset2 = $selectedChip.offset();
			me.getTargetElement().trigger('animate.start');
			$chip.appendTo(me.$t);
			var css = {
					position: 'absolute',
					top: offset2.top,
					left: offset2.left,
					marginTop: 0,
					zIndex: me.opts.chipZindex
				},
				css1 = {
					top: offset2.top - 20
				},
				css2 = {
					top: offset1.top + ( $t.outerHeight() - $chip.outerHeight() ) / 2,
					left: offset1.left + ( $t.outerWidth() - $chip.outerWidth() ) / 2
				};
			if( me.chipIsOverLimit($t, value) ){
				var methodid = $t.data('methodid'),
					msg = me.getActionTipsTxt(),
					gamelimit = me.getGameLimit();
				if( gamelimit[methodid] ){
					var gamelimit = gamelimit[methodid],
						times = me.getMultipleTimes(),
						limit = gamelimit['max_multiple'] * me.gameConfig.getOnePriceById(methodid);
					msg += '<br/>当前倍投数:' + times + '&nbsp;&nbsp;当前可投注额:' + Math.floor(limit / times);
					msg += '<br/>' + gamelimit['name'] + '玩法的总投注限额为' + limit;
				}
				$chip
					.css(css)
					.animate(css1, me.opts.chipsAnimationDelay2)
					.animate(css2, me.opts.chipsAnimationDelay)
					.animate(offset2, me.opts.chipsAnimationDelay, function(){
						$(this).remove();
						me.getTargetElement().trigger('animate.end');
					});
				me.showActionTips($t, msg, 1500);
			}else{
				$chip
					.css(css)
					.animate(css1, me.opts.chipsAnimationDelay2)
					.animate(css2, me.opts.chipsAnimationDelay, function(){
						me.addActionLog({
							from   : me.getSelectedChipElements(),
							to     : $t,
							amount : value,
							type   : 'bet'
						});
						me.setSheetData($t, value);
						$(this).remove();
						me.getTargetElement().trigger('animate.end');
					});
			}

		},
		// 重建已投筹码DOM
		rebuildChip: function($t, value){
			if( !$t.length ) return;
			var me = this,
				value = value || me.getSheetData($t),
				_chips = me.getChipCombination(value),
				html = '',
				mtop = -me.opts.chipSize[1] / 2,
				step = me.opts.chipStep;
			me.removeAllChips($t);
			// 根据新的数组来生成DOM
			$.each(_chips, function(idx, val){
				var $chip = $( '<div data-value="' + val+ '" class="dice-chip dice-chip-' + val + '">' + val + '</div>' );
				$chip.css({
					marginTop: mtop - idx * step
				}).appendTo($t);
			});
		},
		// 根据金额获取筹码组合
		getChipCombination: function(value){
			value = parseFloat(value) || 0;
			var chips = this.chips,
				_chips = [];

			$.each(chips, function(idx, chip){
				// me.debug(value)
				var k = Math.floor( value / chip );
				// _chips[idx] = k;
				if( k >= 1 ){
					value = value % chip;
					for(; k>0; k--){
						_chips.push(chip);
					}
				}
			});
			return _chips;
		},
		// 从桌上移除所有的筹码
		removeAllChips: function($t){
			$t.find('.dice-chip').remove();
		},
		// 禁止某dom元素
		disabledDom: function(dom){
			var $t = $(dom);
			if( $t.length ){
				$t.prop('disable', true).addClass('disabled');
			}
		},
		// enable某dom元素
		enabledDom: function(dom){
			var $t = $(dom);
			if( $t.length ){
				$t.prop('disable', false).removeClass('disabled');
			}
		},
		// 检查操作按钮状态
		checkActionsStatus: function(){
			var me = this;
			// 检查下注
			var bet = !$.isEmptyObject(me.getBetData());
			// 检查撤销
			var revocation = me.revocationIsEnabled && me.actionLogs.length ? true : false;
			// 检查清空
			var clear = bet;

			$.each({
				bet: bet,
				revocation: revocation,
				clear: clear
			}, function(key, value){
				var $t = me.$actions.filter('[data-action="' + key + '"]');
				if( value ){
					$t.prop('disable', false).removeClass('disabled');
				}else{
					$t.prop('disable', true).addClass('disabled');
				}
			});
		},
		// 添加log至数组
		// {from,to,amount,type}
		addActionLog: function(log){
			this.actionLogs.push(log);
		},
		// 从数组中移除log并返回
		removeActionLog: function(){
			return this.actionLogs.pop();
		},
		// 移动所有的筹码至指定offset（下注和清空时需要用到）
		moveAllChips: function(offset, callback){
			var me = this,
				$chips = me.$sheets.find('.dice-chip'),
				len = $chips.length,
				offset = offset || {top:280,left:'50%'};
			$chips.each(function(i, n){
				var $t = $(this),
					_offset = $t.offset(),
					$chip = $t.clone();

				$chip
					.css({
						position: 'absolute',
						left: _offset.left,
						top: _offset.top,
						zIndex: me.opts.chipZindex
					})
					.appendTo('body')
					.animate({
						top: offset.top,
						left: offset.left,
						opacity: 0
					}, me.opts.chipsAnimationDelay, function(){
						$(this).remove();
					});

				$t.remove();
				if( i >= len - 1 ){
					me.resetData();
					if( callback && $.isFunction(callback) ){
						setTimeout(callback, me.opts.chipsAnimationDelay+200);
					}
				}
			});
		},
		// 撤销投注操作
		actionRevocation: function(){
			var me = this,
				log = me.removeActionLog(),
				type = log['type'] || '',
				amount = log['amount'] || 0,
				$from = log['from'] || $(null),
				$to = log['to'] || $(null);

			me.getTargetElement().trigger('animate.start');
			console.log(type)
			if( type != 'recycle' ){
				me.setSheetData($to, -amount);
			}

			if( type == 'bet' ){
				var $chip = $from.clone(),
					offset1 = $to.offset(),
					offset2 = $from.offset();
				if( $from.hasClass('dice-chip-hide') ){
					offset2 = $from.parent().offset();
				}
				$chip.appendTo(me.$t);
				var css1 = {
						top: offset1.top + $to.outerHeight()
					},
					css2 = {
						top: offset2.top,
						left: offset2.left,
						opacity: 0
					};
				// me.debug(css1, css2);
				$chip
					.css({
						position: 'absolute',
						top: offset1.top + ( $to.outerHeight() - $chip.outerHeight() ) / 2,
						left: offset1.left + ( $to.outerWidth() - $chip.outerWidth() ) / 2,
						zIndex: me.opts.chipZindex
					})
					// .animate(css1, me.opts.chipsAnimationDelay2)
					.animate(css2, me.opts.chipsAnimationDelay, function(){
						$(this).remove();
						me.getTargetElement().trigger('animate.end');
					});
			}else if( type == 'move' || type == 'recycle' ){
				var _chips = me.getChipCombination(amount),
					offset1 = $to.offset(),
					offset2 = $from.offset();
				$.each(_chips, function(idx, val){
					var $chip = $( '<div data-value="' + val+ '" class="dice-chip dice-chip-' + val + '">' + val + '</div>' ).appendTo(me.$t),
						w = $chip.outerWidth(),
						h = $chip.outerHeight();

					$chip.css({
						position: 'absolute',
						top: offset1.top + ( $to.outerHeight() - h ) / 2,
						left: offset1.left + ( $to.outerWidth() - w ) / 2,
						zIndex: me.opts.chipZindex
					}).animate({
						top: offset2.top + ( $from.outerHeight() - h ) / 2,
						left: offset2.left + ( $from.outerWidth() - w ) / 2
					}, me.opts.chipsAnimationDelay, function(){
						me.setSheetData($from, val);
						$(this).remove();
						me.getTargetElement().trigger('animate.end');
					});
				});
			}
			me.checkActionsStatus();
		},
		// 清空操作
		actionClear: function(){
			var $t = this.getChipsWrapElement(),
				_offset = $t.offset(),
				offset = {
					top: _offset.top + $t.outerHeight() / 2,
					left: _offset.left + $t.outerWidth() / 2
				};
			this.moveAllChips(offset);
		},
		// 下注操作
		actionBet: function(){
			var me = this,
				limitOverText = me.checkOrder();

			if( limitOverText.length ){
				var names = [], limits = [];
				$.each(limitOverText, function(i,n){
					names.push(n['name'] + n['viewBalls']);
					limits.push({
						idx: n['idx'],
						value: n['limit']
					});
				});
				me.message.show({
					type : 'normal',
					title: '投注超出了倍数限制！',
					confirmIsShow: true,
					confirmText: '自动调整',
					closeText: '手动调整',
					confirmFun: function () {
						var $sheets = me.getSheetsElements();
						/*$.each(wayIds, function(i,wid){
							$sheets.filter('[data-methodid="' +wid+ '"]').each(function(){
								// console.log($(this))
								var $this = $(this),
									value = $this.data('value');
								if( value > 0 ){
									me.setSheetData($this, -value);
									me.disableRevocation();
								}
							});
						});*/
						$.each(limits, function(i, n){
							var $t = $sheets.eq(n['idx']),
								value = $t.data('value');
							me.setSheetData( $t, -(value - n['value']) );
							me.disableRevocation();
						});
						me.message.hide();
					},
					data : {
						tplData : {
							msg: '您的投注内容中“' + names.join('|') + '”超出倍数限制，请选择调整方式！'
						}
					}
				});
				return;
			}

			var $t = this.$sheetWrap,
				_offset = $t.offset(),
				offset = {
					top: _offset.top - 50,
					left: _offset.left + $t.outerWidth() / 2
				},
				data = me.getSubmitData();

			// me.debug(data);

			// 提示至少选择一注
			if( $.isEmptyObject(data) || $.isEmptyObject(data.balls) ){
				me.message.show({
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

			var isTure = true;
			me.message.show({
				type: 'checkLotters',
				msg: '请核对您的投注信息！',
				confirmIsShow: true,
				confirmFun: function () {
					//判断加锁
					if( me.postLock ){
						return;
					}
					$.ajax({
						url: me.gameConfig.getSubmitUrl(),
						// data: JSON.stringify(data),
						data: data,
						dataType: 'json',
						method: 'POST',
						cache: false,
						// contentType: 'application/json; charset=utf-8',
						beforeSend: function(){
							// 请求加锁
							me.doPostLock();
							me.getTargetElement().trigger('dsgame.dice.beforeSend', me.message);
						},
						success: function(r){
							r['printIsShow'] = me.opts.allowPrinted;
							if (Number(r['isSuccess']) == 1) {
								me.message.hide();
								me.moveAllChips(offset, function(){
									setTimeout(function(){
										me.message.show(r);
										me.resetData();
									}, me.chipsAnimationDelay);
									me.afterSubmitSuccess(r);
									me.getTargetElement().trigger('dsgame.dice.afterSubmitSuccess', me.message);
								});
							} else {
								me.message.show(r);
							}
							if( !me.opts.allowPrinted ){
								me.message.win.hidePrintButton();
							}
							// 请求解锁
							me.cancelPostLock();
						},
						complete: function () {
							me.getTargetElement().trigger('dsgame.dice.afterSubmit', me.message);
						},
						error: function (xhr) {
							me.cancelPostLock();
						}
					});
				},
				cancelIsShow: true,
				cancelFun: function () {
					//请求解锁
					me.cancelPostLock();
					this.hide();
				},
				normalCloseFun: function () {
					//请求解锁
					me.cancelPostLock();
				},
				callback: function (){

				},
				data: {
					tplData: {
						//当期彩票详情
						lotteryDate: data['ordersNumber'],
						//彩种名称
						lotteryName: me.gameConfig.getGameNameCn(),
						//投注详情
						lotteryInfo: function () {
							var html = '',
								balls = data['balls'];
							for (var i = 0; i < balls.length; i++) {
								var current = balls[i];
								html += '<div class="game-submit-confirm-list">' + me.gameConfig.getBallLists()[current['jsId']]['typeName'] + ' ' + current['viewBalls'] + '</div>';
							};
							return html;
						},
						// 彩种金额
						lotteryamount: data['amount'],
						//付款账号
						// lotteryAcc: Games.getCurrentGame().getGameConfig().getInstance().getUserName(),
						// lotterOptionalPrizes:Games.getCurrentGame().getGameConfig().getInstance().setOptionalPrizes()
					}
				}
			});
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
		// 重置所有数据
		resetData: function(){
			this.removeAllChips(this.$sheetWrap);
			this.betData = {};
			this.actionLogs = [];
			this.checkActionsStatus();
			this.betAmount = 0;
			// 连投
			this.continusCounter.setValue(0);
			this.getContinusCounter().setValue(0);
			// 倍投
			this.multipleCounter.setValue(1);
			this.getMultipleCounter().setValue(1);
			this.setBetCountAmount();
			this.$sheets.data('value', 0);
			this.getBalance();
		},
		// 获取投注信息
		getSubmitData: function(){
			var me = this,
				orders = {},
				traceTimes = me.getContinusTimes(),
				balls = [],
				betData = me.getBetData(),
				result = {};

			if( $.isEmptyObject(betData) ){
				return {};
			}
			$.each(betData, function(i,n){
				balls.push(n);
			});

			var gamenumbers = me.gameConfig.getGameNumbers();
			$.each(gamenumbers, function(i,n){
				if( i >= traceTimes ){
					return;
				}
				orders[n['number']] = 1;
			});

			result = {
				gameId: me.gameConfig.getGameId(),
				traceWinStop: 0,
				traceStopValue: 0,
				isTrace: me.getContinusTimes() > 1 ? 1 : 0,
				// prizeGroup: me.opts.prizeGroup, // 最近投注选择的的奖金组，在此没有实际意义
				multiple: me.getMultipleTimes(), // 倍投数，仅作反向生成筹码时用，不会传到后台
				trace: traceTimes, // 连投数，仅作反向生成筹码时用，不会传到后台
				amount: me.currency(me.getBetCountAmount()),
				balls: balls,
				orders: orders
			}
			return result;
		},
		// 根据下单数据生成投注
		/*
		{"gameId":15,"traceWinStop":0,"traceStopValue":0,"isTrace":1,"multiple":3,"trace":2,"amount":"1,320.00","balls":[{"ball":"1","viewBalls":"大","jsId":0,"wayId":165,"moneyunit":0.5,"multiple":30,"amount":10,"onePrice":2,"num":1,"prizeGroup":"1800","type":"dx.dx.fs"},{"ball":"5","viewBalls":"555","jsId":6,"wayId":158,"moneyunit":0.5,"multiple":150,"amount":50,"onePrice":2,"num":1,"prizeGroup":"1800","type":"sthdx.sthdx.fs"},{"ball":"0","viewBalls":"小","jsId":15,"wayId":165,"moneyunit":0.5,"multiple":150,"amount":50,"onePrice":2,"num":1,"prizeGroup":"1800","type":"dx.dx.fs"},{"ball":"14","viewBalls":"14","jsId":20,"wayId":157,"moneyunit":0.5,"multiple":30,"amount":10,"onePrice":2,"num":1,"prizeGroup":"1800","type":"hz.hz.fs"},{"ball":"12","viewBalls":"12","jsId":22,"wayId":157,"moneyunit":0.5,"multiple":150,"amount":50,"onePrice":2,"num":1,"prizeGroup":"1800","type":"hz.hz.fs"},{"ball":"3","viewBalls":"3","jsId":49,"wayId":167,"moneyunit":0.5,"multiple":150,"amount":50,"onePrice":2,"num":1,"prizeGroup":"1800","type":"bdw.bdw.fs"}],"orders":{"20150606030":1,"20150606031":1}}
		*/
		renderSheetFromData: function(data){
			// console.log(data)
			var me = this,
				balls = data['balls'] || {},
				moneyunit = me.getMoneyUnit();
			if( $.isEmptyObject(balls) ) return;
			// 重置数据
			me.resetData();
			$.each(balls, function(i, n){
				var $t = me.getSheetsElements().filter('.dice-sheet-' + n['jsId']);
				me.setSheetData( $t, n['amount'] );
			});
			me.setContinusTimes(data['trace']);
			me.setMultipleTimes(data['multiple']);
			// console.log(me.getSubmitData());
		},
		// 注单成功后，更新我的方案，我的追号及余额
		afterSubmitSuccess: function (r) {
			// 更新余额
			this.getBalance();
			// 插入投注记录
			// this.gameHistory.append(r.data);
		},
		letterCapitalize: function(string){
			return string.charAt(0).toUpperCase() + string.slice(1);
		},
		/**
		 * currency(num, n, x) *
		 * @param integer n: length of decimal
		 * @param integer x: length of sections
		 */
		currency: function(num, n, x){
			n = n || 2;
			x = x || 3;
			if( isNaN(num) || num <= 0 ){
				return '0.00';
			}else{
				var re = '\\d(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\.' : '$') + ')';
				return num.toFixed(Math.max(0, ~~n)).replace(new RegExp(re, 'g'), '$&,');
			}
		},
		// 将被格式的金额返回成float型
		moneyForamtToFloat: function(num){
			return parseFloat( num.replace(/[^\d\.-]/g, '') );
		},
		// debug
		debug: function(){
			this.debugs && window.console && console.log && console.log( arguments );
		}
	}

	$.fn.dsgamedice = function(o) {
		var instance;
		this.each(function() {
			instance = $.data( this, 'dsgamedice' );
			// instance = $(this).data( 'dsgamedice' );
			if ( instance ) {
				// instance.init();
			} else {
				instance = $.data( this, 'dsgamedice', new F(this, o) );
			}
		});
		return instance;
	}
})(jQuery);
// 开奖号码跑马灯效果
;(function($) {
	function F(t, o) {
		this.opts = $.extend({
			ballsize: 5, // 彩球个数
			initball: '0,0,0,0,0', // 初始化彩球数据
			loop: 5, // 彩球滚动循环次数（必须为整数）
			timeout: 5000, // 彩球滚动动画执行时间基数
			delay: 150, // 每个彩球动画执行延迟时间基数
			offset: [80, 110], // 球的宽高
			showHandbar: true,
			showLamp: true,
			handbar: '.handle_hand', // 拉杆元素
			lamp: '.lamp', // 跑马灯元素
			debugs: true // 是否支持debug [0/false, 1=>对象级输出, 2=>字符串级输出]
		}, o);
		this.slides = [];
		this.size = this.opts.ballsize;
		this.$t = $(t);
		this.balls = [];
		// CALLBACK
		this.callback = function(){};
		this.errors = {
			'invalidBallFormat': '彩球数据格式错误'
		};
		this.debugs = this.opts.debugs;
		this.init();
	}

	F.prototype = {
		init: function() {
			// alert('fdadffd');
			var me = this,
				opts = me.opts;
			if (me.checkballs(opts.initball) != me.size) {
				alert(me.errors['invalidBallFormat']);
			}
			if( me.opts.showHandbar ){
				me.$handles = $(opts.handbar).children();
			}
			me.createdom();
			// me.flip(me.balls, false);
			if( me.opts.showLamp ){
				me.preloadLightImg();
			}
		},
		checkballs: function(balls) {
			var me = this,
				k = 0;
			if( balls && typeof balls === 'string' ){
				balls = balls.split(',');
			}
			// balls存在、为数组，且其长度为size
			if (balls &&
				Object.prototype.toString.call(balls) === '[object Array]' &&
				balls.length == me.size
			) {
				me.balls = balls;
				for (var i = 0; i < balls.length; i++) {
					var ball = Number(balls[i]);
					if (ball < 0 || ball > 9) {
						break;
					}
					k++;
				}
			}
			// me.debug(k);
			return k;
		},
		createdom: function() {
			var me = this,
				opts = me.opts,
				balls = me.balls;
			for (var i = 0; i < me.size; i++) {
				var _style = 'position:absolute;top:0;left:' + i*me.opts.offset[0] + 'px;float:none;';
					/* ball_number*ball_height*(ball_max_loop+3) */
					_style += 'height:' + 10 * opts.offset[1] * (opts.loop + 3) + 'px';
				me.slides.push(
					$('<div>', {
						'class': 'flipball flipball_' + (i + 1),
						'style' : _style,
						text: balls[i]
					}).appendTo(me.$t)
				);
			}
		},
		preloadLightImg: function() {
			var me = this,
				$img = $('img', this.opts.lamp),
				src = $img.data('imgholder');
			$('<img/>').load(function() {
				me.$lampimg = $img;
				me.originsrc = $img.attr('src');
				me.lampsrc = src;
			}).attr('src', src);
		},
		// 跑马灯效果
		marquee: function(status) {
			if (this.lampsrc && this.$lampimg.length) {
				if (status == 'on') {
					this.$lampimg.attr('src', this.lampsrc);
				} else if (status == 'off') {
					this.$lampimg.attr('src', this.originsrc);
				}
			}
		},
		// 拉杆动画效果
		drawbar: function(callback) {
			this.$handles.eq(0).animate({
				opacity: 'hide'
			}, 300, function() {
				$(this).animate({
					opacity: 'show'
				}, 300, function(){
					callback && callback();
				});
			});
		},
		play: function() {
			if( this.opts.showLamp ){
				this.marquee('on');
			}
			if( this.showHandbar ){
				this.drawbar();
			}
		},
		stop: function() {
			if( this.opts.showLamp ){
				this.marquee('off');
			}
		},        
		// 数字球滚动效果
		flip: function(balls, anim, callback) {
			var me = this,
				opts = me.opts,
				balls = balls || me.balls,
				callback = callback || me.callback;
			if (me.checkballs(balls) != me.size) {
				return alert(me.errors['invalidBallFormat']);
			}
			if( !me.$t.hasClass('.hasball') ) me.$t.addClass('hasball');
			balls = me.balls;
			me.callback = callback;
			if (anim === false || anim === 'undefined') {
				me.stop();
				$.each(me.slides, function(idx, slide) {
					var ball_num = Number(balls[idx]);
					slide.stop().css('marginTop', -(10 + ball_num) * opts.offset[1]);
				});
				me.doCallback(me.callback);
			} else {
				me.play();
				$.each(me.slides, function(idx, slide) {
					var ball_num = Number(balls[idx]),
						timeout = opts.timeout + opts.delay * idx,
						// 一圈是10个数，循环opts.loop圈后，在移动ball_num单位个高度(opts.offset[1])
						step = (opts.loop * 10 + ball_num) * opts.offset[1];
					slide.stop().animate({
						marginTop: '+=' + (opts.offset[1] * .6)
					}).stop().animate({
						marginTop: -step
					}, timeout, function() {
						$(this).css('marginTop', -(10 + ball_num) * opts.offset[1]);
						if( idx == me.size - 1 ){
							me.stop();
							me.doCallback(me.callback);
						}
					});
				});
			}
		},
		quickflip: function(callback1){
			var me = this,
				opts = me.opts,
				balls = balls || me.balls,
				callback = callback || me.callback;
			//快速开奖后立即重置掉当前的CALLBACK缓存
			//防止正常开奖逻辑再次执行回调
			me.callback = null;
			if (me.checkballs(balls) != me.size) {
				return alert(me.errors['invalidBallFormat']);
			}
			$.each(me.slides, function(idx, slide) {
				var ball_num = Number(balls[idx]);
				slide.stop().css({
					marginTop: -(10 + ball_num) * opts.offset[1]
				}).animate({
					marginTop: -(10 + ball_num + 10) * opts.offset[1]
				}, 1000, function(){
					
					if( idx == me.size - 1 ){
						me.doCallback(callback);
						callback1 && callback1();
					}
				});
			});
		},
		doCallback: function( callback ){
			if( callback && Object.prototype.toString.call(callback) === '[object Function]' ){
				callback();
			}
		},
		// debug
		debug: function() {
			this.debugs && window.console && console.log && console.log('[flipball] ' + Array.prototype.join.call(arguments, ' '));
		}
	}

	$.fn.flipball = function(o) {
		var instance;
		this.each(function() {
			instance = $.data(this, 'flipball');
			// instance = $(this).data( 'flipball' );
			if (instance) {
				// instance.init();
			} else {
				instance = $.data(this, 'flipball', new F(this, o));
			}
		});
		return instance;
	}
})(jQuery);

/* counter */
;(function($) {
	function F(t, o) {
		this.opts = $.extend({
			max: 99999,
			min: 1,
			step: 1,
			init: 1,
			debugs: true // 是否支持debug [0/false, 1=>对象级输出, 2=>字符串级输出]
		}, o);
		// console.log(this.opts)
		this.slides = [];
		this.$t = $(t);
		this.beforeSetValue = function(val){return val};
		this.onSetValue = function(){};
		this.debugs = this.opts.debugs;
		this.init();
	}

	F.prototype = {
		init: function() {
			var me = this;
			me.$ctrl = me.$t.find('[data-counter-action]');
			me.$title = me.$t.find('[data-counter-title]');
			me.$input = me.$t.find('input.J_counter');
			//me.$valueInput = me.$t.siblings('[data-valueInput]');
			if (!me.$input.length) return me.debug('No input element!');
			me.setMaxValue(me.opts.max);
			me.setMinValue(me.opts.min);
			me.checkCtrl();
			me.bindEvent();

			var init = me.opts.init;
			if( init > me.opts.max ){
				init = me.opts.max
			}else if( init < me.opts.min ){
				init = me.opts.min
			}
			me.setInitValue(init);
			me.setValue(init);
		},
		lowerCase: function(s) {
			return (s || '').toLowerCase();
		},
		setTitle: function(title){
			this.$title.text(title);
		},
		addClass: function(classname){
			this.$t.addClass(classname);
		},
		setOnSetValue: function(fn){
			var me = this;
			me.onSetValue = fn;
		},
		setBeforeSetValue: function(fn){
			var me = this;
			me.beforeSetValue = fn;
		},
		setMinValue: function( num ){
			this.minValue = num;
			this.checkCtrl();
		},
		getMinValue: function(){
			return this.minValue;
		},
		setMaxValue: function( num ){
			this.maxValue = num;
			this.checkCtrl();
		},
		getMaxValue: function(){
			return this.maxValue;
		},
		setInitValue: function( num ){
			this.initValue = num;
		},
		getInitValue: function(){
			return this.initValue;
		},
		setValue: function(val) {
			var me = this,
				dom = me.$input,
				val = me.checkCtrl(val);
			val = me.beforeSetValue(val);
			dom.val(val);
			me.onSetValue(val);
		},
		getValue: function() {
			return this.$input.val();
		},
		setButtonStatus: function(button, status){
			var $ctrl = this.$ctrl.filter('[data-counter-action="' + button + '"]');
			if( status == 'disabled' ){
				$ctrl.addClass('disabled');
			}else{
				$ctrl.removeClass('disabled');
			}
		},
		checkCtrl: function(val) {
			var me = this,
				opts = me.opts;
			if( val == 'undefined' ){
				val = me.getInitValue();
			}
			// me.debug(val);
			if (val <= me.getMinValue()) {
				me.setButtonStatus('decrease', 'disabled');
				val = me.getMinValue();
			} else {
				me.setButtonStatus('decrease');
			}
			if (val >= me.getMaxValue()) {
				me.setButtonStatus('increase', 'disabled');
				val = me.getMaxValue();
			} else {
				me.setButtonStatus('increase');
			}
			return val;
		},
		reset: function(){
			var me = this;
			me.setValue(me.getInitValue());
			me.$input.val(me.getInitValue());
			me.checkCtrl();
		},
		bindEvent: function() {
			var me = this,
				opts = me.opts;
			me.$ctrl.on('click', function(e) {
				if ($(this).hasClass('disabled')) return false;
				var val = parseInt(me.$input.val()),
					action = $(this).data('counter-action');
				if (action == 'increase') val += opts.step;
				else if (action == 'decrease') val -= opts.step;
				// me.debug(val)
				me.setValue(val);
			});
			me.$input.on('change', function() {
				var val = parseInt(this.value);
				me.setValue(val);
			});
		},
		// debug
		debug: function() {
			this.debugs && window.console && console.log && console.log('[counter] ' + Array.prototype.join.call(arguments, ' '));
		}
	}

	$.fn.counter = function(o) {
		var instance;
		this.each(function() {
			instance = $.data(this, 'counter');
			// instance = $(this).data( 'counter' );
			if (instance) {
				// instance.init();         
			} else {
				instance = $.data(this, 'counter', new F(this, o));
			}
		});
		return instance;
	}
})(jQuery);

/* tips */
/*
$('body').tips({
	attr: 'value',
	autoinitialize: true,
	showCase: function(me){
		return me.getText() != '￥0';
	},
	beforeSetText: function(text){
		if( !text ){
			text = 0;
		}
		return text = '￥' + text;
	}
});
*/
;(function($){
	function F(t, o){
		this.opts = $.extend({
			attr: 'tips-title', // data('tips-title')
			direction: 'top', //[top,right,bottom,left]
			target: 'body',
			event: 'mouseover', // [mouseover, click]
			offsetFix: 10, // 位置修正量
			zIndex: 500,
			className: '',
			animationDelay: 300,
			autoinitialize: false,
			maxLetter: 20,
			beforeSetText: function(text){
				return text;
			},
			showCase: function(){
				return true;
			},
			debugs: true // 是否支持debug [0/false, 1=>对象级输出, 2=>字符串级输出]
		}, o);
		this.slides = [];
		this.$t = $(t);
		this.text = '';
		this.debugs = this.opts.debugs;
		// this.isIE6 = $.browser.msie && parseFloat($.browser.version) < 7;
		this.init();
	}

	F.prototype = {
		init: function(){
			var opts = this.opts;

			this.$tips = $('<div class="ui-tips ui-tips-' +opts.direction+ '"><span class="ui-tips-text"></span><i class="ui-tips-arrow"></i></div>');
			if( opts.className ){
				this.$tips.addClass(opts.className);
			}
			this.$tips.css({
				position: 'absolute',
				zIndex: opts.zIndex
			}).appendTo(opts.target).animate({opacity: 'hide'}, 0);

			this.beforeSetText = opts.beforeSetText;
			this.timer = null;
			
			this.$text = this.$tips.find('.ui-tips-text');
			this.fontSize = parseFloat(this.$text.css('fontSize'));
			this.setText(this.$t.data(opts.attr));

			this.bindEvent();
		},
		getHandler: function(){
			return this.$t;
		},
		getDom: function(){
			return this.$tips;
		},
		setText: function(text){
			text = this.beforeSetText(text);
			if( !text ){
				text = '';
			}
			if( this.text != text ){
				this.text = text;
				this.$text.html(text);
			}
		},
		getText: function(){
			return this.text;
		},
		setStyle: function(){
			var me = this,
				offset = me.$t.offset(),
				fix = me.opts.offsetFix,
				maxLetter = me.opts.maxLetter,
				left = 0,
				top = 0,
				width = me.getText().length > maxLetter ? maxLetter * me.fontSize : 'auto';
			switch( me.opts.direction ){
				case 'right':
					left = offset.left + me.$t.outerWidth() + fix;
					top = offset.top + ( me.$t.outerHeight() - me.$tips.outerHeight() ) / 2;
					break;
				case 'bottom':
					left = offset.left + ( me.$t.outerWidth() - me.$tips.outerWidth() ) / 2;
					top = offset.top + me.$t.outerHeight() + fix;
					break;
				case 'left':
					left = offset.left - me.$tips.outerWidth() - fix;
					top = offset.top + ( me.$t.outerHeight() - me.$tips.outerHeight() ) / 2;
					break;
				case 'top':
				default:
					left = offset.left + ( me.$t.outerWidth() - me.$tips.outerWidth() ) / 2;
					top = offset.top - me.$tips.outerHeight() - fix;
					break;
			}
			me.$tips.css({
				left: left,
				top: top,
				width: width
			});
		},
		show: function(){
			var me = this;
			if( me.opts.autoinitialize ){
				me.setText(me.$t.data(me.opts.attr));
			}
			if( !me.opts.showCase(me) ) return false;
			me.setStyle();
			me.timer = setTimeout(function(){
				$(me.$tips).animate({
					opacity: 'show'
				});
			}, me.opts.animationDelay);
		},
		hide: function(){
			var me = this;
			if( me.timer ){
				clearTimeout(me.timer);
				me.timer = null;
			}
			me.$tips.animate({
				opacity: 'hide'
			});
		},
		bindEvent: function(){
			var me = this,
				event = me.opts.event;
			if( event === 'mouseover' ){
				me.$t.on({
					mouseover: function(){
						me.show();
					},
					mouseout: function(){
						me.hide();
					}
				});
			}else{
				me.$t.toggle(function(){
					me.show();
				}, function(){
					me.hide();
				});
			}
			return false;
		},
		// debug
		debug: function(){
			// this.debugs && window.console && console.log && console.log( '[tips] ' + Array.prototype.join.call(arguments, ' ') );
			this.debugs && window.console && console.log && console.log( '[tips]', arguments );
		}
	}

	$.fn.tips = function(o) {
		var instance;
		this.each(function() {
			instance = $.data( this, 'tips' );
			// instance = $(this).data( 'tips' );
			if ( instance ) {
				// instance.init();
			} else {
				instance = $.data( this, 'tips', new F(this, o) );
			}
		});
		return instance;
	}
})(jQuery);

/* diceAnimation */
;(function($){
	function F(t, o){
		this.opts = $.extend({
			balls: [2,4,5],
			animationDelay: 300,
			animationTimes: 5, // 动画执行次数
			debugs: false // 是否支持debug [0/false, 1=>对象级输出, 2=>字符串级输出]
		}, o);
		this.slides = [];
		this.$t = $(t);
		this.debugs = this.opts.debugs;
		// this.isIE6 = $.browser.msie && parseFloat($.browser.version) < 7;
		this.init();
	}

	F.prototype = {
		init: function(){
			this.$dices = this.$t.children();
			this.posArr = [[33,92],[55,53],[84,86],[13,53]];
			this.setBallsNum(this.opts.balls);
			this.randomPosition(true);
			//单骰子动画
			this.singleDiceAnimate = null;
			//骰子循环动画
			this.groupDiceAnimate = null;
		},
		setBallsNum: function(balls){
			balls = balls || this.balls || this.opts.balls;
			this.$dices.each(function(i,n){
				var ball = balls[i];
				$(this).attr('class', 'dice-ball-' + ball ).text(ball);
			});
			this.balls = balls;
		},
		getCurrentBalls: function(){
			return this.balls;
		},
		randomPosition: function(init){
			var me = this,
				posArr = me.posArr,
				position = [];

			if( init ){
				// 取前三个作为position
				me.$dices.each(function(i){
					var pos = posArr[i];
					$(this).css({
						left: pos[0],
						top : pos[1]
					});
					position.push([pos[0], pos[1]]);
				});
			}else{
				var rands = me.randomBelle(3, posArr.length-1, 0);
				for(i=0; i<rands.length; i++){
					var pos = posArr[rands[i]];
					position.push([pos[0], pos[1]]);
				}
				return position;
			}
		},
		doDice: function(balls, callback){
			var me = this;
			// 执行骰子动画
			me.diceAnimation('start');
			// 定时结束
			setTimeout(function(){
				// 开奖结束后的操作
				me.diceAnimation('stop', balls, callback);
			}, (me.opts.animationTimes + 1) * me.opts.animationDelay);
		},
		singleAnimateProcess: function(){
			var me = this,
				maxNum = 6;
			if(me.singleDiceAnimate){
				return;
			}
			//单球转动
			me.singleDiceAnimate = setInterval(function(){
				var balls = me.getRandomBalls();
				me.$dices.each(function(i, n){
					var ball = balls[i];
					$(this).attr('class', 'dice-ball-' + ball).text(ball);
				})
			}, 100);   
		},
		animateProcess: function(){
			var position, dom, left, currentPosition, rands,
				me = this,
				animationDelay = me.opts.animationDelay;
			if( me.groupDiceAnimate ){
				return;
			}
			//变动位置
			me.groupDiceAnimate = setInterval(function(){
				position = me.randomPosition(),
				// 开启骰子转动
				me.singleAnimateProcess();
				me.$dices.each(function(i){
					(function(s){
						dom = me.$dices.eq(s);
						currentPosition = position[s];
						left = Number(currentPosition[0] - dom.position().left);
						// 跳起
						dom.animate({
								'top': currentPosition[1] - 50,
								'left': dom.position().left + left * 0.8
							}, animationDelay * 0.28, function() {
								dom = me.$dices.eq(s);
								currentPosition = position[s];
								left = Number(currentPosition[0]-dom.position().left);
								// 落下
								dom.animate({
									'top': currentPosition[1],
									'left': dom.position().left + left
								}, animationDelay * 0.3);
						});
					})(i);
				});
			}, animationDelay);
		},
		stopAllAnimate: function(){
			var me = this;

			clearInterval(me.singleDiceAnimate);
			clearInterval(me.groupDiceAnimate);
			me.singleDiceAnimate = null;
			me.groupDiceAnimate = null;
			// me.randomPosition(true);
		},
		diceAnimation: function(type, balls, callback){
			var me = this;
			if( type == 'start' ){
				//开始循环动画
				me.animateProcess();
			}else if( type == 'stop' ){
				if( balls 
					&& Object.prototype.toString.call(balls) === '[object Array]' 
					&& balls.length == me.$dices.length
				){
					me.stopAllAnimate();
					me.setBallsNum(balls);
					if( callback && Object.prototype.toString.call(callback) === '[object Function]' ){
						callback();
					}
				}else{
					alert('开奖号码错误');
				}
			}
		},
		getRandomBalls: function(){
			var me = this;
			return me.randomBelle(me.$dices.length, 6, 1);
		},
		randomBelle :function(count, maxs, mins){
			var numArray = new Array();
			//getArray(4,27,0); //4是生成4个随机数,27和0是指随机生成数是从0到27的数
			function getArray(count, maxs, mins){
				while(numArray.length < count){
					var temp = getRandom(maxs,mins);
					if(!search(numArray,temp)){
						numArray.push(temp);
					}
				}
				//alert("生成的数组为:"+numArray);
				return numArray;
			}
			function getRandom(maxs, mins){  //随机生成maxs到mins之间的数
				return Math.round(Math.random()*(maxs-mins))+mins;
			}
			function search(numArray, num){   //array是否重复的数
				for(var i=0; i<numArray.length; i++){
					if(numArray[i] == num){
						return true;
					}
				}
				return false;
			}
			return getArray(count, maxs, mins);
		},
		// debug
		debug: function(){
			// this.debugs && window.console && console.log && console.log( '[diceAnimation] ' + Array.prototype.join.call(arguments, ' ') );
			this.debugs && window.console && console.log && console.log( '[diceAnimation]', arguments );
		}
	}

	$.fn.diceAnimation = function(o) {
		var instance;
		this.each(function() {
			instance = $.data( this, 'diceAnimation' );
			// instance = $(this).data( 'diceAnimation' );
			if ( instance ) {
				// instance.init();
			} else {
				instance = $.data( this, 'diceAnimation', new F(this, o) );
			}
		});
		return instance;
	}
})(jQuery);

/* gameRecord */
;(function($){
	function F(t, o){
		this.opts = $.extend({
			markup: '',
			callback: function(){},
			debugs: false // 是否支持debug [0/false, 1=>对象级输出, 2=>字符串级输出]
		}, o);
		this.slides = [];
		this.$t = $(t);
		this.markup = 
			'<li>' +
				'<div class="rec1">' +
					'<span class="dice-number dice-number-<#=ball1#>"><#=ball1#></span>' +
					'<span class="dice-number dice-number-<#=ball2#>"><#=ball2#></span>' +
					'<span class="dice-number dice-number-<#=ball3#>"><#=ball3#></span>' +
				'</div>' +
				'<div class="rec2"><#=num#></div>' +
				'<div class="rec3"><#=size#></div>' +
				'<div class="rec4"><#=oddEven#></div>'  +
				'<div class="rec5"><#=number#></div>' +
			'</li>';
		this.debugs = this.opts.debugs;
		// this.isIE6 = $.browser.msie && parseFloat($.browser.version) < 7;
		this.init();
	}

	F.prototype = {
		init: function(){
			var markup = this.opts.markup;
			if( markup ){
				this.setMarkup(markup);
			}
		},
		getDom: function(){
			return this.$t;
		},
		setMarkup: function(markup){
			this.markup = markup;
		},
		getMarkup: function(){
			return this.markup;
		},
		getHTML: function(data){
			var html = this.getMarkup();
			for(p in data){
				if(data.hasOwnProperty(p)){
					reg = RegExp('<#=' + p + '#>', 'g');
					html = html.replace(reg, data[p]);
				}
			}
			return html;
		},
		append: function(data){
			var html = this.getHTML(data);
			this.$t.append(html);
			this.afterInsert();
		},
		prepend: function(data){
			var html = this.getHTML(data);
			this.$t.prepend(html);
			this.afterInsert();
		},
		afterInsert: function(){
			var callback = this.opts.callback;
			if( callback && Object.prototype.toString.call(callback) === '[object Function]' ){
				callback();
			}
		},
		// debug
		debug: function(){
			// this.debugs && window.console && console.log && console.log( '[gameRecords] ' + Array.prototype.join.call(arguments, ' ') );
			this.debugs && window.console && console.log && console.log( '[gameRecords]', arguments );
		}
	}

	$.fn.gameRecords = function(o) {
		var instance;
		this.each(function() {
			instance = $.data( this, 'gameRecords' );
			// instance = $(this).data( 'gameRecords' );
			if ( instance ) {
				// instance.init();
			} else {
				instance = $.data( this, 'gameRecords', new F(this, o) );
			}
		});
		return instance;
	}
})(jQuery);

/* gamehistory */
;(function($) {
	function F(t, o) {
		this.opts = $.extend({
			showNum: 5, // 记录显示条数
			ballurl: 'javascript:void(0);', // 号码详情链接
			markup: 
				'<li>' +
					'<div class="cell1" data-history-project="<#=projectId#>"><#=projectId#></div>' +
					'<div class="cell2"><#=number#></div>' +
					'<div class="cell3"><#=writeTime#></div>' +
					'<div class="cell4"><dfn>¥</dfn><#=totalprice#></div>' +
					'<div class="cell5" data-history-balls>-,-,-</div>' +
					'<div class="cell6" data-history-result>等待开奖</div>' +
					'<div class="cell7">' +
						'<a href="<#=ballurl#>?orderId=<#=orderId#>" target="_blank">投注详情</a>' +
					'</div>' +
				'</li>',
			ballMarkup: '<span class="dice-number dice-number-<#=ball#>"><#=ball#></span>',
			debugs: false // 是否支持debug [0/false, 1=>对象级输出, 2=>字符串级输出]
		}, o);
		this.slides = [];
		this.$t = $(t);
		this.debugs = this.opts.debugs;
		this.init();
	}

	F.prototype = {
		init: function() {
			var opts = this.opts;
		},
		getLength: function(){
			this.$items = this.$t.children();
			return this.$items.length;
		},
		render: function(data){
			var me = this,
				opts = me.opts,
				markup = opts.markup;
			data['ballurl'] = opts.ballurl;
			for (p in data) {
				if (data.hasOwnProperty(p)) {
					markup = me.template( markup, p, ( p == 'totalprice' || p == 'winMoney' ? me.currency(data[p]/10000) : data[p]) );
				}
			}
			return markup;
		},
		template: function(markup, key, value, reg){
			reg = reg || RegExp('<#=' + key + '#>', 'g');
			return markup.replace(reg, value);
		},
		append: function(data) {
			var me = this;
			// console.log(data);
			// 是否判断data的合法性？
			me.$render = $(me.render(data)).prependTo(me.$t);
			if( me.getLength() > me.opts.showNum ){
				me.$items.filter(function(idx){
					return idx >= me.opts.showNum;
				}).remove();
			}
		},
		/*
		data = {
			balls: [1, 3, 6],
			winlists: [
				{
					projectId: "DCDSGSGDFHGDFHFDF",
					winMoney: 95194573
				},{
					projectId: "DCDSGSGDFHGDFHFDK",
					winMoney: 15663161
				}
			]
		}
		*/
		update: function(data){
			var me = this,
				winlists = data['winlists'],
				balls = data['balls'] || [],
				ballhtml = '';

			if( balls.length ){
				$.each(balls, function(i, n){
					var markup = me.opts.ballMarkup
					ballhtml += me.template( markup, 'ball', n) + '\n';
				});			
			}
			$.each(winlists, function(i, n){
				var projectId = n['projectId'],
					winMoney = n['winMoney'] || 0;
				me.$t.find('[data-history-project="' + projectId + '"]').each(function(){
					var _win = '未中奖';
					if( winMoney > 0 ){
						_win = '<span class="price"><dfn>¥</dfn>' +  me.currency(winMoney/10000) + '</span>';
					}
					$(this).siblings('[data-history-result]').html(_win);
					$(this).siblings('[data-history-balls]').html(ballhtml);
				});
			});
		},
		/**
		 * currency(num, n, x) * 
		 * @param integer n: length of decimal
		 * @param integer x: length of sections
		 */
		currency: function(num, n, x){
			n = n || 2;
			x = x || 3;
			if( isNaN(num) || num <= 0 ){
				return '0.00';
			}else{
				var re = '\\d(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\.' : '$') + ')';
				return num.toFixed(Math.max(0, ~~n)).replace(new RegExp(re, 'g'), '$&,');
			}
		},
		// debug
		debug: function() {
			this.debugs && window.console && console.log && console.log('[gameHistory] ' + Array.prototype.join.call(arguments, ' '));
		}
	}

	$.fn.gameHistory = function(o) {
		var instance;
		this.each(function() {
			instance = $.data(this, 'gameHistory');
			// instance = $(this).data( 'gameHistory' );
			if (instance) {
				// instance.init();
			} else {
				instance = $.data(this, 'gameHistory', new F(this, o));
			}
		});
		return instance;
	}
	// $('[data-simulation="gameHistory"]').gameHistory();
})(jQuery);
;(function(gameSelfConfig){
	var gameSelfConfig = gameSelfConfig || {}, // 单彩种配置
		$body = $('body'),
		rechargeUrl = $('#recharge-url').val(),
		gameMessage = new dsgame.GameMessage(),
		gameConfig = new GameConfig(),
		dsgamediceConf = gameSelfConfig['dsgamediceConf'] || {},
		// 开奖记录
		gameRecords = $('#J-lottery-records').gameRecords();

	dsgamediceConf = $.extend({
		gameConfig: gameConfig,
		// gameHistory: k3History,
		message: gameMessage
	}, dsgamediceConf);

	// 骰宝游戏类
	var dsgamedice = $body.dsgamedice(dsgamediceConf);

	var $lotteryNumber = $('#J-lottery-info-number'),
		$timeDom = $('.lottery-countdown'),
		countDownTimer = null,
		issueTimer = null,
		issueTimeout = gameSelfConfig['issueTimeout'] || 10000,
		isFirst = true, // 初始化加载
		ballsNeedSorted = gameSelfConfig['ballsNeedSorted'],
		currentNumber = dsgamedice.gameConfig.getCurrentGameNumber(), // 当前期号
		currentBalls = dsgamedice.gameConfig.getLotteryBalls(); // 当前开奖号码

	issueTimer = setInterval(function(){
		dsgamedice.getServerIssues();
	}, issueTimeout);

	// 开奖动画
	if( gameSelfConfig['diceAnimationType'] == 'flipball' ){
		var _conf = gameSelfConfig['flipballConf'] || {};
		var flipball = $('#flipball').flipball(_conf);
	}else if( gameSelfConfig['diceAnimationType'] == 'dice' ){
		var diceAnimation = $('#J-lottery-info-balls').diceAnimation();
	}

	// 重置开奖记录html结构
	if( gameSelfConfig['recordMarkup'] ){
		gameRecords.setMarkup(gameSelfConfig['recordMarkup']);
	}

	// 生成单条开奖记录
	var createRecordRowData = gameSelfConfig['createRecordRowData'] || function(){return '没有生成数据的方法';};
	// 开奖
	var showWinNumber = function(lastballs, number, isFirst){
		lastballs = lastballs.split('');
		if( ballsNeedSorted ){
			lastballs.sort(function(a, b){
				return parseInt(a) - parseInt(b);
			});
		}
		$('#show-balls-number').html(number);
		if( flipball ){
			flipball.flip(lastballs, true, function(){
				afterShowNumber(lastballs, number, isFirst);
			});
		}else if( diceAnimation ){
			diceAnimation.doDice(lastballs, function(){
				afterShowNumber(lastballs, number, isFirst);
			});
		}
	};
	// 开奖记录生成
	var createAllRecords = function(issues){
		issues = issues || dsgamedice.gameConfig.getLotteryNumbers();
		var html = '';
		// console.log(issues);
		$.each(issues, function(idx, issue){
			if( idx === 0 ){
				issueCached['issue'] = issue['issue'];
				issueCached['wn_number'] = issue['wn_number'];
			}
			balls = (issue['wn_number'] + '').split('');
			if( balls.length ) html += gameRecords.getHTML( createRecordRowData( balls, issue['issue'] ) );
		});
		gameRecords.getDom().empty().html(html);
	};
	// 开奖后执行方法
	var afterShowNumber = function(lastballs, number, isFirst){
		// console.log(lastballs,createRecordRowData(lastballs, number))
		if( !isFirst ){
			gameRecords.prepend( createRecordRowData(lastballs, number) );
		}
		if( gameSelfConfig['afterShowNumber'] && typeof gameSelfConfig['afterShowNumber'] === 'function' ){
			gameSelfConfig['afterShowNumber']();
		}
	};

	// 获取到初始数据后
	dsgamedice.ready(function(){
		// 筹码相关事件
		var $chips = dsgamedice.getChipsElements();
		$chips.draggable({
				revert: 'invalid',
				delay: 600,
				//refreshPositions: true,
				opacity: 0.5,
				helper: 'clone',
				zIndex: 100
			})
			.on('longclick', function(){
				var $this = $(this);
				dsgamedice.$chips.removeClass('dice-chip-draggable');
				$this.addClass('dice-chip-draggable');
				$this.trigger('chip.selected');
			})
			.on('click', function(){
				$(this).trigger('chip.selected');
			})
			.on('chip.selected', function(){
				var $this = $(this);
				dsgamedice.$chips.removeClass('dice-chip-selected');
				$this.addClass('dice-chip-selected');
				dsgamedice.setChipValue($this.data('value'));
				dsgamedice.setSelectedChipElements($this);
			})
			.on('chip.bet', function(event, offset){

			})
			.filter('[data-value="' + dsgamedice.getChipValue() + '"]').trigger('chip.selected');

		// 自定义筹码按钮
		var $chipsButton = dsgamedice.getChipsButtonElements(),
			$chipsCustom = dsgamedice.getChipsCustomElements();
		$chipsButton.addClass('active').on('click', function(){
			if( $(this).hasClass('active') ){
				$chipsCustom.animate({
					top: '+=20px',
					opacity: 'hide'
				});
				$(this).removeClass('active');
			}else{
				$chipsCustom.animate({
					top: '-=20px',
					opacity: 'show'
				});
				$(this).addClass('active');
			}
		}).trigger('click');

		// 隐藏自定义筹码
		$(document).on('click', function(e){
			var $el = $(e.target);
			if( !$el.parents('.dice-chip-wrap').length || $el.parents('.dice-chip-choose').length){
				if( $chipsButton.hasClass('active') ){
					$chipsCustom.animate({
						top: '+=20px',
						opacity: 'hide'
					});
					$chipsButton.removeClass('active');
				}
			}
		});

		// 筹码自定义
		var $chipsMirror = dsgamedice.getChipsMirrorElements();
		$chipsMirror.on('click', function(){
			if( $(this).hasClass('dice-chip-hide') ){
				var chipsMirror = dsgamedice.getChipsMirror(),
					$shifted = chipsMirror.shift();
				$shifted.addClass('dice-chip-hide');
				chipsMirror.push($(this).removeClass('dice-chip-hide'));
				dsgamedice.setChipsMirror(chipsMirror);
				var value1 = $shifted.data('value'),
					value2 = $(this).data('value'),
					$chips = dsgamedice.getChipsElements();
				$chips.filter('[data-value="' + value1 + '"]').addClass('dice-chip-hide');
				$chips.filter('[data-value="' + value2 + '"]').removeClass('dice-chip-hide');
				var $selected = $chips.filter('.dice-chip-selected')
				if( $selected.hasClass('dice-chip-hide') ){
					$selected.removeClass('dice-chip-selected');
					var $_selected = $chips.filter(':not(.dice-chip-hide)').eq(0),
						_value = $_selected.data('value');
					$_selected.addClass('dice-chip-selected');
					dsgamedice.setChipValue(_value);
					dsgamedice.setSelectedChipElements($_selected);
				}
			}
			return false;
		});

		// 回收站
		var $recycle = $('.dice-recycle');
		$recycle.droppable({
			accept: '.dice-chip, .dice-sheet',
			hoverClass: 'dice-recycle-hover',
			tolerance: 'pointer',
			drop: function( event, ui ) {
				var $ui = $(ui.draggable),
					value = dsgamedice.getSheetData($ui),
					$this = $(this);
				if( $ui.parent().hasClass('dice-chip-choose') ) return false;
				$ui.removeClass('dice-sheet-draggable');
				dsgamedice.setSheetData($ui, -value);

				dsgamedice.addActionLog({
					from   : $ui,
					to     : $this,
					amount : value,
					type   : 'recycle'
				});
			}
		});
		// 玩法盘相关事件
		var $sheets = dsgamedice.getSheetsElements();
		$sheets.droppable({
				accept: '.dice-chip, .dice-sheet',
				hoverClass: 'dice-sheet-hover',
				tolerance: 'pointer',
				drop: function( event, ui ) {
					var $ui = $(ui.draggable),
						value = dsgamedice.getSheetData($ui),
						$this = $(this),
						type = 'bet';

					if( dsgamedice.chipIsOverLimit($this, value) ){
						var $helper = $(ui.helper).clone().css({
							position: 'absolute',
							display: 'block',
							zIndex: 1,
							left: ui.offset.left,
							top: ui.offset.top
						}).appendTo('body');
						$helper.find('.dice-sheet-bg').css({opacity: 0});
						$helper.animate( $ui.offset(), function(){
							$helper.remove();
						});
						dsgamedice.showActionTips($this, '该注单超过限额了');
						return false;
					}

					if( $ui.hasClass('dice-sheet') ){
						// $this.append( $ui.removeClass('dice-sheet-draggable').find('.dice-chip') );
						$ui.removeClass('dice-sheet-draggable');
						dsgamedice.setSheetData($ui, -value);
						type = 'move';
					}else{
						// $this.append( $ui.clone() );
						type = 'bet';
					}
					dsgamedice.addActionLog({
						from   : $ui,
						to     : $this,
						amount : value,
						type   : type
					});
					dsgamedice.setSheetData($this, value);
					// dsgamedice.rebuildChip($this);
				}
			})
			.draggable({
				revert: 'invalid',
				delay: 500,
				//refreshPositions: true,
				opacity: 0.5,
				helper: 'clone'
			})
			.on('longclick', function(){
				if( !$(this).find('.dice-chip').length ){
					return false;
				}
				$sheets.removeClass('dice-sheet-draggable');
				$(this).addClass('dice-sheet-draggable');
			})
			.on('click', function(){
				if( dsgamedice.getAnimationStatus() ) return false;
				var chipValue = dsgamedice.getChipValue(),
					$this = $(this);
				// if( !dsgamedice.chipIsOverLimit($this, chipValue) ){
					dsgamedice.moveChip($this);
				// }
			})
			.tips({
				attr: 'value',
				autoinitialize: true,
				showCase: function(me){
					return me.getText() != '￥0';
				},
				beforeSetText: function(text){
					if( !text ){
						text = 0;
					}
					return text = '￥' + text;
				}
			});

		// 操作按钮相关
		dsgamedice.getActionsElements()
			.on('click', function(){
				if( $(this).hasClass('disabled') || $(this).prop('disable') || dsgamedice.getAnimationStatus() ) return false;
				var action = $(this).data('action');
				if( action ){
					actionString = 'action' + dsgamedice.letterCapitalize(action);
					// dsgamedice.debug(actionString)
					if( dsgamedice[actionString] ){
						dsgamedice[actionString]();
					}
				}
			});

		// 连投
		var continusCounter = dsgamedice.getContinusCounter();
		continusCounter.setTitle('连  投');
		continusCounter.addClass('continus-counter');

		// 倍投
		var multipleCounter = dsgamedice.getMultipleCounter();
		multipleCounter.setTitle('倍  投');
		multipleCounter.addClass('multiple-counter');

		// 设置充值链接
		dsgamedice.getBalanceRechargeElements().attr({
			href: rechargeUrl,
			target: '_blank'
		});

		// 游戏玩法tips
		dsgamedice.getTipsElements().tips({
			direction: 'right'
		});
		// 赔率玩法tips
		dsgamedice.getOddsTipsElements().tips({
			direction: 'bottom',
			maxLetter: 15,
			beforeSetText: function(text){
				var _text = '<span>开奖赔率：' + this.getHandler().text() + '</span>';
				return text = _text + '<span>投注2元可中奖金：' + text + '元</span>';
			}
		});
	});

	// 服务器数据发生变化时
	dsgamedice.getTargetElement().on('dsgame.dice.dynamicConfigChange', function(e, dynamicConfig){
		// 停售
		if( dynamicConfig.isstop ){
			$('.lottery-status').find('.soldout').show();
			$('.lottery-status').find('.lottery-countdown').hide();
		}else{
			$('.lottery-status').find('.soldout').hide();
			$('.lottery-status').find('.lottery-countdown').show();
		}

		// 更新奖期
		var newCurrentNumber = dynamicConfig['currentNumber'];
		$lotteryNumber.html( newCurrentNumber );

		// 期号发生变化提示用户
		if(currentNumber && currentNumber != newCurrentNumber){
			var message = dsgamedice.message,
				time = 5,
				html = '<div class="tipdom-cont">' + 
							'<p>当前已进入第<span>' + newCurrentNumber +'</span>期</p>' + 
							'<p>请留意期号变化(<span id="J-gamenumber-change-s-num">5</span>)</p>' +
						'</div>';
			// message.showTip(html);
			message.show({
				mask: false,
				cancelIsShow: false,
				title: '温馨提示',
				content: html,
				closeIsShow: true,
				closeFun: function() {
					message.hide();
				}
			});
			(function(){
				time--;
				if(time < 0){
					message.hide();
					return;
				}
				$('#J-gamenumber-change-s-num').text(time);
				setTimeout(arguments.callee, 1000);
			})();
		}
		currentNumber = newCurrentNumber;

		// 倒计时
		var seconds = dynamicConfig['currentNumberTime'] - dynamicConfig['currentTime'];
		if( countDownTimer ){
			clearTimeout(countDownTimer);
			countDownTimer = null;
		}
		countDownTimer = setInterval(function(){
			seconds--;
			if( seconds <= 0 ){
				dsgamedice.getServerDynamicConfig();
			}
			// 还剩10s时
			if( seconds <= 10 ) {
				$timeDom.addClass('caution-countdown');
			}else{
				$timeDom.removeClass('caution-countdown');
			}
			// h = Math.floor(seconds / 3600), // 小时数
			var m = Math.floor(seconds % 3600 / 60), // 分钟数
				s = seconds % 3600 % 60;
			if( m < 10 ){
				m = '0' + m;
			}
			if( s < 10 ){
				s = '0' + s;
			}
			m += '';
			s += '';
			//渲染时间输出
			var m1 = m.substring(0, 1),
				m2 = m.substring(1, 2),
				s1 = s.substring(0, 1),
				s2 = s.substring(1, 2);
			$timeDom.find('[data-time="m1"]').text(m1).attr('class', 'time-'+m1);
			$timeDom.find('[data-time="m2"]').text(m2).attr('class', 'time-'+m2);
			$timeDom.find('[data-time="s1"]').text(s1).attr('class', 'time-'+s1);
			$timeDom.find('[data-time="s2"]').text(s2).attr('class', 'time-'+s2);
		}, 1000);

	}).trigger('dsgame.dice.dynamicConfigChange', dsgamedice.gameConfig.getConfig());

	// 开奖机制
	var issueCached = {issue: '', wn_number: ''}; // 当前开奖的期号和号码 
	dsgamedice.getTargetElement().on('dsgame.dice.serverIssuesChange', function(e, data){
		var issues = data['issues'],
			lastNumber = data['last_number'];

		if( lastNumber['issue'] != issueCached['issue'] ){
			// 期号变化，有开奖号码，执行开奖动画
			if( lastNumber['wn_number'] ){
				showWinNumber(lastNumber['wn_number'], lastNumber['issue']);
				issueCached['issue'] = lastNumber['issue'];
				issueCached['wn_number'] = lastNumber['wn_number'];
			}
		}else{
			// 期号相同，开奖号码不同，执行开奖动画
			if( lastNumber['wn_number'] && lastNumber['wn_number'] != issueCached['wn_number'] ){
				showWinNumber(lastNumber['wn_number'], lastNumber['issue']);
				issueCached['issue'] = lastNumber['issue'];
				issueCached['wn_number'] = lastNumber['wn_number'];
			}
		}

		if( !lastNumber['wn_number'] ){
			// 等待开奖中...
			// console.log('等待开奖中...');
		}		
	});

	// 初始化显示
	showWinNumber(currentBalls, dsgamedice.gameConfig.getLastGameNumber(), isFirst);
	createAllRecords();

	// 登录超时
	dsgamedice.getTargetElement().on('dsgame.dice.logout', function(e, data){
		var message = dsgamedice.message;
		message.hide();
		message.show({
			mask: true,
			confirmIsShow: true,
			confirmText: '立即登录',
			confirmFun: function(){
				window.location.reload();
			},
			content:'<div class="pop-waring"><i class="ico-waring"></i><h4 class="pop-text">登录超时，请重新登录平台！</h4></div>'
		});
	});

	// 开奖记录滚动条
	$('.scroll-pane').jScrollPane({
		autoReinitialise: true,
		showArrows: true,
		arrowScrollOnHover: true,
		autoReinitialiseDelay: 5000
	});

	// 游戏记录开关
	var $history = $('.game-history-wrap').slideUp(0);
	$('.dice-bar').on('click', '.history-toggle', function(){
		$(this).toggleClass('history-toggle-active');
		$history.slideToggle();
		return false;
	});
	$history.on('click', '.history-close', function(){
		$('.history-toggle').trigger('click');
		return false;
	});

	dsgamedice.getTargetElement().on('dsgame.dice.beforeSend', function(e, msg){
		var panel = msg.win.dom.find('.pop-control'),
			comfirmBtn = panel.find('a.confirm'),
			cancelBtn = panel.find('a.cancel');
			comfirmBtn.addClass('btn-disabled');
			comfirmBtn.text('提交中...');
			msg.win.hideCancelButton();
	}).on('dsgame.dice.afterSubmit', function(e, msg){
		var panel = msg.win.dom.find('.pop-control'),
			comfirmBtn = panel.find('a.confirm'),
			cancelBtn = panel.find('a.cancel');
			comfirmBtn.removeClass('btn-disabled');
			comfirmBtn.text('确 认');

			// 刷新投注记录
			document.getElementById('record-iframe').contentWindow.location.reload();
			// 刷新余额
			$('[data-refresh-balance]').eq(0).trigger('click');
	});

	// 筹码区位置
	(function(){
		var isIE6 = dsgame.util.isIE6,
			minHeight = 700,
			maxHeight = 1098,
			$wrap = $('.dice-wrap'),
			$ctrl = $('.dice-ctrl'),
			$footer = $('#footer'),
			f_h = $footer.outerHeight() || 0,
			scrollTop = $wrap.offset().top;

		var extraTop = $ctrl.outerHeight() + f_h + scrollTop;

		function renderPosition(){
			var height = $(window).height(),
				width = $(window).width();

			// 在某些浏览器下窗口宽度为奇数时会出现一些奇怪的样式bug
			// 需要修正为偶数像素宽度
			if( width % 2 ){
				$body.width(width-1);
			}

			if( height < extraTop + minHeight ){
				$wrap.height(minHeight);
				$ctrl.css({
					position: 'relative',
					bottom: 'auto',
					left: 0
				});
				$footer.css({
					position: 'relative',
					bottom: 'auto',
					left: 0
				});
			}else if( height > extraTop + minHeight ){
				if( !isIE6 ){
					$ctrl.css({
						position: 'fixed',
						bottom: f_h,
						left: 0
					});
					$footer.css({
						position: 'fixed',
						bottom: 0,
						left: 0
					});
				}
				if( height > extraTop + maxHeight ){
					$wrap.height(maxHeight);
				}else{
					$wrap.height(height - extraTop);
				}
			}
		}
		var resizeTimer = null;
		$(window).on( 'resize', function () {
			// renderPosition();
			if ( resizeTimer ) {
				clearTimeout(resizeTimer);
			}
			resizeTimer = setTimeout(function(){
				renderPosition();
			}, 100);
		}).trigger('resize');

		$(function(){
			setTimeout( function(){
				$('html,body').animate({scrollTop: scrollTop}, 400);
			}, 1000);
		});

	})();

})(window.gameSelfConfig);
