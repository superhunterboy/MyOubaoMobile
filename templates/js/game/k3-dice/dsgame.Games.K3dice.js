;(function($){
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
			prizeGroup: '1800',
			gameConfig: function(){},
			message: function(){},
			gameHistory: function(){},
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
				html += '<div data-methodid="' + n['id'] + '" class="dice-sheet dice-sheet-' + i + '" data-name="' + n['name'] + '">';
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
					'<div class="bet-balance"><label>余额:</label>￥<span data-user-account-balance>21,500,000.00</span>' +
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
				html += '<div class="ui-icon game-tips game-tips-' +n.fullname_en[0]+ '" data-name="' + n.fullname_en.join('.') + '" data-tips-title="' + (n.bet_note || n.name_cn) + '"></div>';
			});
			this.$sheetWrap.append(html);
			return this.$tips = this.$sheetWrap.find('.game-tips');
		},
		// 生成赔率tips
		createOddsTips: function(){
			var balllsits = this.gameConfig.getBallLists(),
				gamelimit = this.getGameLimit(),
				// 给出的数据就是1800奖金组的，不需计算
				// maxPrizeGroup = this.gameConfig.getMaxPrizeGroup(),
				// prizeGroup = parseInt(this.opts.prizeGroup),
				html = '',
				methods = {},
				gameInfos = {};
			// console.log(gameMethods)
			$.each(balllsits, function(idx, ball){
				// 给出的数据就是1800奖金组的，不需计算
				// var prize = parseFloat(gamelimit[ball['id']]['prize']) * prizeGroup / maxPrizeGroup, // 根据奖金组计算的单注最高奖金
				var prize = parseFloat(gamelimit[ball['id']]['prize']),
					odds = prize / 2 - 1,
					baseOdds = '1赔';
				if( (ball['name'] == 'sthdx.sthdx.fs' && !methods['sthdx']) ||
					(ball['name'] == 'sthtx.sthtx.fs' && !methods['sthtx']) ||
					(ball['name'] == 'ebth.ebth.fs'   && !methods['ebth']) ||
					(ball['name'] == 'bdw.bdw.fs'     && !methods['bdw'])
				){
					prize = prize.toFixed(2);
					odds = baseOdds + odds.toFixed(2);
					html += '<div class="odds-tips odds-tips-' +idx+ '" data-tips-title="' + prize + '">' + odds + '</div>';
					methods[ball['name'].split('.')[0]] = 1;
					// gameInfos[ball['name']] = '\n';
				}else if( ball['name'] == 'ethfx.ethfx.fs' ){
					methods['ethfx'] = methods['ethfx'] || 0;
					prize = prize.toFixed(2);
					odds = baseOdds + odds.toFixed(2);
					if( methods['ethfx'] % 3 == 0 ){
						html += '<div class="odds-tips odds-tips-' +idx+ '" data-tips-title="' + prize + '">' + odds + '</div>';
					}
					methods['ethfx'] += 1; 
				}else if( ball['name'] == 'hz.hz.fs' ){
					// 最高赔率1:180(和值3和18)
					odds *= (ball['odds'] / 180);
					prize *= (ball['odds'] / 180);
					prize = prize.toFixed(2);
					odds = baseOdds + odds.toFixed(2);
					html += '<div class="odds-tips odds-tips-' +idx+ '" data-tips-title="' + prize + '">' + odds + '</div>';
				}else if( ball['name'] == 'dx.dx.fs' || ball['name'] == 'ds.ds.fs' ){
					prize = prize.toFixed(2);
					odds = baseOdds + odds.toFixed(2);
					html += '<div class="odds-tips odds-tips-' +idx+ '" data-tips-title="' + prize + '">' + odds + '</div>';
				}
				// console.log(methods)			
			});
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
				
			var amount = betData.amount ? betData.amount + val : val;
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
					prizeGroup: me.opts.prizeGroup,
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
						me.getTargetElement().trigger('k3.logout');
					}else if(Number(data['isSuccess']) == 1){
						var conf = data.data;
						me.gameConfig.updateConfig(conf);
						me.getContinusCounter().setMaxValue( me.gameConfig.getTraceMaxTimes() );
						me.setGameLimit( me.gameConfig.getGameLimit() );
						me.updateSheetsData();

						var newConfig = me.gameConfig.getConfig();
						me.getTargetElement().trigger('k3.dynamicConfigChange', newConfig);
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
						me.getTargetElement().trigger('k3.logout');
					}else{
						me.getTargetElement().trigger('k3.serverIssuesChange', data);
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
							me.getTargetElement().trigger('k3.beforeSend', me.message);
						},
						success: function(r){
							if (Number(r['isSuccess']) == 1) {
								me.message.hide();
								me.moveAllChips(offset, function(){
									setTimeout(function(){
										me.message.show(r);
										me.resetData();
									}, me.chipsAnimationDelay);
									me.afterSubmitSuccess(r);
									me.getTargetElement().trigger('k3.afterSubmitSuccess', me.message);
								});
							} else {
								me.message.show(r);
							}
							// 请求解锁
							me.cancelPostLock();
						},
						complete: function () {
							me.getTargetElement().trigger('k3.afterSubmit', me.message);
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
			this.gameHistory.append(r.data);
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

	$.fn.k3dice = function(o) {
		var instance;
		this.each(function() {
			instance = $.data( this, 'k3dice' );
			// instance = $(this).data( 'k3dice' );
			if ( instance ) {
				// instance.init();
			} else {
				instance = $.data( this, 'k3dice', new F(this, o) );
			}
		});
		return instance;
	}
})(jQuery);