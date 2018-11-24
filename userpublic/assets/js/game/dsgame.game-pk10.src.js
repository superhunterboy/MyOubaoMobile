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

})(dsgame, "PK10", dsgame.Game);












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




(function(host, name, message, undefined){
	var defConfig = {

	},
	Games = host.Games,
	instance;

	var pros = {
		init: function(cfg){
			var me = this;
			Games.setCurrentGameMessage(me);
		}
	};

	var Main = host.Class(pros, message);
		Main.defConfig = defConfig;
		//游戏控制单例
		Main.getInstance = function(cfg){
			return instance || (instance = new Main(cfg));
		};
	host.Games.PK10[name] = Main;

})(dsgame, "Message", dsgame.GameMessage);











(function(host, name, GameMethod, undefined) {
		var defConfig = {
				name: 'wuxing.zhixuan.danshi',
				//iframe编辑器
				editorobj: '.content-text-balls',
				//FILE上传按钮
				uploadButton: '#file',
				//单式导入号码示例
				exampleText: '12345 33456 87898 <br />12345 33456 87898 <br />12345 33456 87898 ',
				//玩法提示
				tips: '五星直选单式玩法提示',
				//选号实例
				exampleTip: '这是单式弹出层提示',
				//中文 全角符号  中文
				checkFont: /[\u4E00-\u9FA5]|[/\n]|[/W]/g,
				//过滤方法
				filtration: /[\s]|[,]|[;]|[<br>]|[，]|[；]/g,
				//验证是否纯数字
				checkNum: /^[0-9]*$/,
				//单式玩法提示
				normalTips:['说明：',
					'1、每一注号码之间的间隔符支持 回车  空格[ ]    逗号[,]   分号[;]',
					'2、文件格式必须是.txt格式,大小不超过200KB。',
					'3、将文件拖入文本框即可快速实现文件上传,大文件拖拽上传效果更佳。',
					'4、导入文本内容后将覆盖文本框中现有的内容。',
					'5、一次投注支持100,000注！',
				].join('\n')

			},
			gameCaseName = 'PK10',
			Games = host.Games,
			//游戏类
			gameCase = host.Games[gameCaseName];

	//定义方法
	var pros = {
		init:function(cfg){
			var me = this;
			//IE Range对象
			me.ieRange = '';
			//正确结果
			me.vData = [];
			//所有结果
			me.aData = [];

			me.tData = [];
			//出错提示记录
			me.errorData = [];
			//重复记录
			me.sameData = [];
			//初级触发
			me.firstfocus = true;
			//机选标记
			me.ranNumTag = false;
			//是否初次进行投注
			me.isFirstAdd = true;

			Games.getCurrentGameOrder().addEvent('beforeAdd', function(e, orderData){
				var that = this,
					data = me.tData,
					html = '';

				if(orderData['type'] == me.defConfig.name){

					//使用去重后正确号码进行投注
					if(me.isFirstAdd){
						if(!me['ranNumTag']){
							orderData['lotterys'] = [];
							me.isFirstAdd = null;
							//重新输出去重后号码
							me.updateData();
							Games.getCurrentGameOrder().add(Games.getCurrentGameStatistics().getResultData());
						}
					}else{
						//如果存在重复和错误号进行提示
						if(me.errorData.join('') != '' || me.sameData.join('') != ''){
							me.ballsErrorTip();
						}
						me.isFirstAdd = true;
					}
				}
			});
		},
		//启用textarea的单式输入方式，以支持十万级别的单式
		initTextarea:function(){
			var me = this,
				CLS = 'content-textarea-balls-def',
				cfg = me.defConfig,
				defText = $.trim(cfg.normalTips);
			me.importTextarea = $('<textarea class="content-textarea-balls '+CLS+'">'+defText+'</textarea>');
			me.container.find('.panel-select').html('').append(me.importTextarea);

			//绑定输入框事件
			me.importTextarea.focus(function(){
				var v = $.trim(this.value);
				if(v == defText){
					this.value = '';
					me.importTextarea.removeClass(CLS);
				}
			}).blur(function(){
				var v = $.trim(this.value);
				if(v == ''){
					me.removeOrderAll();
					me.showNormalTips();
				}
			}).keyup(function(){
				me.updateData();
			});

		},
		//废除使用iframe形式的单式
		initFrame:function(){
			var me = this;
			//由iframe模式改成textarea模式
			me.initTextarea();
			//文件上传事件
			me.bindPressTextarea();
			//拖拽上传
			me.dragUpload();

		},
		getExampleText:function(){
			return this.defConfig.exampleText;
		},
		rebuildData:function(){
			var me = this;
			me.balls = [
						[-1,-1,-1,-1,-1,-1,-1,-1,-1,-1],
						[-1,-1,-1,-1,-1,-1,-1,-1,-1,-1],
						[-1,-1,-1,-1,-1,-1,-1,-1,-1,-1],
						[-1,-1,-1,-1,-1,-1,-1,-1,-1,-1],
						[-1,-1,-1,-1,-1,-1,-1,-1,-1,-1]
						];
		},
		buildUI:function(){
			var me = this;
			me.container.html(me.getHTML());
		},
		//单式不能反选
		reSelect:function(){

		},
		//单式没有选球dom
		batchSetBallDom:function(){

		},
		//获取默认提示文案
		getNormalTips: function(){
			return this.defConfig.normalTips
		},
		//显示默认提示文案
		showNormalTips: function(){
			var me = this,
				CLS = 'content-textarea-balls-def';
			if(me.importTextarea){
				me.importTextarea.addClass(CLS);
			}
			me.replaceText(me.getNormalTips.call(me));
		},
		//建立可编辑的文字区域
		_bulidEditDom: function(){
			var me = this,
				headHTML =	'';

			me.doc.designMode = 'On';//可编辑
			me.doc.contentEditable = true;
			//但是IE与FireFox有点不同，为了兼容FireFox，所以必须创建一个新的document。
			me.doc.open();
			headHTML='<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
			headHTML=headHTML+'<style>*{margin:0;padding:0;font-size:14px;}</style>';
			headHTML=headHTML+'</head>';
			me.doc.writeln('<html>'+headHTML+'<body style="word-break: break-all">' + me.getNormalTips() + '</body></html>');
			me.doc.close();
			// //FOCUS光标
			// if(!document.all){
			// 	me.win.focus();
			// }else{
			// 	me.doc.body.focus();
			// }
			//绑定事件
			me.bindPress();
			//IE回车输出<br> 与 FF 统一；
			if(document.all){
				me.doc.onkeypress = function(){
					return me._ieEnter()
				};
			};

			me.dragUpload();
		},
		dragUpload:function(){
			var me = this,iframeBody = me.importTextarea;
			//拖拽上传
			if(window.FileReader){
				iframeBody.bind("dragover", function(e){
					e.preventDefault();
					e.stopPropagation();
				});
				iframeBody.get(0).addEventListener('drop', function(e){
					e.preventDefault();
					e.stopPropagation();
					var files = e.dataTransfer.files,file = files[0],
						reader = new FileReader(),
						fType = file.type ? file.type : 'n/a';

					if(fType != 'text/plain'){
						return;
					}

					reader.onload = function(e){
						var text = e.target.result;
						if($.trim(text) != ''){
							me.replaceText(text);
							me.updateData();
						}
					};
					reader.readAsText(file);
				},false);
			}
		},

		//IE回车修改
		_ieEnter: function(){
			var me = this,
				e = me.win.event;
			if(e.keyCode == 13){
				this._saveRange();
				this._insert("<br/>");
				return false;
			}
		},
		//编辑器中插入文字
		_insert: function(text) {//插入替换字符串
			var me = this;

			if (!!me.ieRange) {
				me.ieRange.pasteHTML(text);
				me.ieRange.select();
				me.ieRange = false; //清空下range对象
			} else {//焦点不在html编辑器内容时
				me.win.focus();
				if (document.all) {
					me.doc.body.innerHTML += text; //IE插入在最后
				} else {//Firefox
					var sel = win.getSelection();
					var rng = sel.getRangeAt(0);
					var frg = rng.createContextualFragment(text);
					rng.insertNode(frg);
				}
			}
		},
		//IE下保存Range对象
		_saveRange: function(){
			if(!!document.all&&!me.ieRange){//是否IE并且判断是否保存过Range对象
				var sel = me.doc.selection;
				me.ieRange = sel.createRange();
				if(sel.type!='Control'){//选择的不是对象
					var p = me.ieRange.parentElement();//判断是否在编辑器内
					if(p.tagName=="INPUT"||p == document.body)me.ieRange=false;
				}
			}
		},
		//返回结果HTML
		getHtml: function(){
			var me = this,v = !!me.importTextarea ? me.importTextarea.val() : '';

			return v;

			//由iframe模式改成textarea模式
			//return me.doc ? $(me.doc.body).html() : '';
		},
		//修改HTML
		//返回结果HTML
		replaceText: function(text){
			var me = this;
			if(me.importTextarea){
				me.importTextarea.val(text);
			}
		},
		bindPressTextarea:function(){
			var me = this,
				uploadButton = me.container.find(me.defConfig.uploadButton),
				agentValue = window.navigator.userAgent.toLowerCase();
			//绑定用户上传按钮
			uploadButton.bind('change', function(){
				var form = $(this).parent();
				me.checkFile(this, form);
			});
		},
		//绑定IFRAME按钮PRESS
		bindPress: function(){
			var me = this,
				uploadButton = me.container.find(me.defConfig.uploadButton),
				agentValue = window.navigator.userAgent.toLowerCase();
			// 绑定按钮事件
			$(me.doc).bind('input',function(){
				me.updateData();
			})
			// iE不支持INPUT事件
			// 而且IE propertychange事件不能绑定该DOM类型
			if(agentValue.indexOf('msie')>0){
				$(me.doc.body).bind('keyup',function(){
					me.updateData();
				})
				$(me.doc.body).bind('blur',function(){
					me.updateData();
				})
			}
			$(me.doc).bind('focus',function(){
				if(me.firstfocus){
					me.replaceText(' ');
					me.firstfocus = false;
				}
			})
			$(me.doc).bind('blur',function(){

				var content = me.getText();
				if($.trim(content) == ''){
					me.showNormalTips();
				}else{

					me.updateData();
				}


			})
			$(me.doc.body).bind('focus',function(){
				if(me.firstfocus){
					me.replaceText(' ');
					me.firstfocus = false;
				}
			})
			$(me.doc.body).bind('blur', function() {
				var content = me.getText();
				if ($.trim(content) == '') {
					me.showNormalTips();
				}else{

					me.updateData();
				}
			})
			//绑定用户上传按钮
			uploadButton.bind('change', function(){
				var form = $(this).parent();
				me.checkFile(this, form);
			})

		},
		//用拆分符号拆分成单注
		iterator: function(data) {
			var me= this,
				cfg = me.defConfig,
				temp,
				last = [],
				result = [];

			data = $.trim(data);
			data = data.replace(cfg.filtration, '|');
			data = data.replace(/\s+/g, ' ');
			data = $.trim(data);

			result = data.split('|');

			$.each(result, function(i){
				temp = $.trim(this);
				if(temp != ''){
					last.push(temp);
				}
			});
			return last;
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
		//正则过滤输入框HTML
		//提取正确的投注号码
		filterLotters : function(data){
			var me = this,
				result = '';

			result = data.replace(/<br>+|&nbsp;+/gi, ' ');
			result = result.replace(/\s\s|[\s]|[,]+|[;]+|[，]+|[；]+/gi, ' ');
			result = result.replace(/<(?:"[^"]*"|'[^']*'|[^>'"]*)+>/g, ' ');
			result = result.replace(me.defConfig.checkFont,'') +  ' ';

			return result;
		},
		//检测单注号码是否通过
		checkSingleNum: function(lotteryNum){
			var me = this;
			return me.defConfig.checkNum.test(lotteryNum) && lotteryNum.length == me.balls.length;
		},
		//检测选球是否完整，是否能形成有效的投注
		//并设置 isBallsComplete
		checkBallIsComplete:function(data){
			var me = this;
				me.aData = [];
				me.vData = [];
				me.sameData = [];
				me.errorData = [];
				me.tData = [];
				result = [];
				result = me.iterator(me.filterLotters(data)).sort() || [];
			var i=result.length;
				//按规则进行拆分结果
				while(i--){
					if(me.checkSingleNum(result[i])){
						var a = result[i];
						if(a == result[i+1]){
							me.sameData.push(result[i].split(''));
						}else{
							me.tData.push(result[i].split(''));
						}
						me.vData.push(result[i].split(''));
					}else{
						me.errorData.push(result[i].split(''));
					}
					me.aData.push(result[i].split(''));
				}
				//校验
				if(me.tData.length > 0){
					me.isBallsComplete = true;
					if(me.isFirstAdd){
						return me.vData;
					}else{
						return me.tData;
					}

				}else{
					me.isBallsComplete = false;
					return [];
				}
		},
		//返回正确的索引
		countInstances: function(mainStr, subStr){
			var count = [];
			var offset = 0;
			do{
				offset = mainStr.indexOf(subStr, offset);
				if(offset != -1){
					count.push(offset);
					offset += subStr.length;
				}
			}while(offset != -1)
			return count;
		},
		//三项操作提示
		//显示正确项
		//排除错误项
		removeOrderError: function(){
			var me  = this,str = [],i = 0,len = me.tData.length;
			for(i = 0; i < len; i++){
				str[i] = me.tData[i].join('');
			}
			str = $.trim(str.join(' '));
			me.errorDataTips();
			me.replaceText(str);
			me.errorData = [];
			me.sameData = [];
			if(str == ''){
				me.showNormalTips();
			}
		},
		removeOrderSame: function(){
			var me  = this,str = [],i = 0,len = me.tData.length;
			for(i = 0; i < len; i++){
				str[i] = me.tData[i].join('');
			}
			str = $.trim(str.join(' '));
			me.sameDataTips();
			me.replaceText(str);
			me.errorData = [];
			me.sameData = [];
			if(str == ''){
				me.showNormalTips();
			}
		},
		filterOrder: function(hideTips){
			var me  = this,str = [],i = 0,len = me.tData.length;
			for(i = 0; i < len; i++){
				str[i] = me.tData[i].join('');
			}
			str = $.trim(str.join(' '));
			if( hideTips != 'hide' && (me.errorData.length || me.sameData.length) ){
				me.ballsErrorTip();
			}
			me.replaceText(str);
			me.errorData = [];
			me.sameData = [];
			if(str == ''){
				me.showNormalTips();
			}
		},
		//清空选区
		removeOrderAll: function(){
			var me=this;
			me.replaceText(' ');
			me.sameData = [];
			me.aData = [];
			me.tData = [];
			me.vData = [];
			//清空选号状态
			Games.getCurrentGameStatistics().reSet();
			me.showNormalTips();
		},
		//检测上传
		checkFile: function(dom, form){
			var result = dom.value,
				fileext=result.substring(result.lastIndexOf("."),result.length),
				fileext=fileext.toLowerCase();
			if (fileext != '.txt') {
				alert("对不起，导入数据格式必须是.txt格式文件哦，请您调整格式后重新上传，谢谢 ！");
				return false;
			}
			form[0].submit();
		},
		//接收文件
		getFile: function(result){
			var me = this,
				resetDom = me.container.find(':reset');

				if(!result){return};
				me.replaceText(result);
				me.firstfocus = false;
				me.updateData();
				resetDom.click();
		},
		//出错提示
		//暂时搁置
		errorTip: function(html, data){
			var me = this,
				start, end,
				indexData = [];

			alert(me.errorData.join())
		},
		sameDataTips: function(){
			var me = this,
				sameData = me.sameData,
				sameDataHtmlText = '',
				sameGroupText = '',
				msg = Games.getCurrentGameMessage(),
				saveSameData = [],
				indexData = [];

			if(sameData.join('') == ''){return};


			for (var i = 0; i < sameData.length; i++) {
				if($.trim(sameData[i].join(''))){
					saveSameData.push(sameData[i].join(''));
				}
			};
			sameDataHtmlText = '<h4 class="pop-text" style="display:block;font-weight:bold">以下号码重复，已进行自动过滤</h4><p class="pop-text" style="display:block">' + saveSameData.join(', ') + '</p>';

			msg.show({
				mask: true,
				content : ['<div class="bd text-center">',
								'<div class="pop-waring">',
									'<i class="ico-waring <#=icon-class#>"></i>',
									'<div style="display:inline-block;*zoom:1;*display:inline;vertical-align:middle">' + sameDataHtmlText + '</div>',
								'</div>',
							'</div>'].join(''),
				closeIsShow: true,
				closeFun: function(){
					this.hide();
				}
			})
		},
		errorDataTips: function(){
			var me = this,
				errorData = me.errorData,
				errorDataHtmlText = '',
				errorGroupText = '',
				msg = Games.getCurrentGameMessage(),
				saveError = [],
				indexData = [];

			if(errorData.join('') == ''){return};

			for (var i = 0; i < errorData.length; i++) {
				if($.trim(errorData[i].join(''))){
					saveError.push(errorData[i].join(''));
				}
			};
			errorDataHtmlText = '<h4 class="pop-text" style="display:block;font-weight:bold">以下号码错误，已进行自动过滤</h4><p class="pop-text" style="display:block">' + saveError.join(', ') + '</p>';
			msg.show({
				mask: true,
				content : ['<div class="bd text-center">',
								'<div class="pop-waring">',
									'<i class="ico-waring <#=icon-class#>"></i>',
									'<div style="display:inline-block;*zoom:1;*display:inline;vertical-align:middle">' + errorDataHtmlText + '</div>',
								'</div>',
							'</div>'].join(''),
				closeIsShow: true,
				closeFun: function(){
					this.hide();
				}
			})
		},
		//单式出错提示
		ballsErrorTip: function(html, data){
			var me = this,
				errorData = me.errorData,
				sameData = me.sameData,
				errorDataHtmlText = '',
				sameDataHtmlText = '',
				errorGroupText = '',
				sameGroupText = '',
				msg = Games.getCurrentGameMessage(),
				saveError = [],
				saveSameData = [],
				indexData = [];

			//重复号码
			if(sameData.join('') != ''){
				for (var i = 0; i < sameData.length; i++) {
					if($.trim(sameData[i].join(''))){
						saveSameData.push(sameData[i].join(''));
					}
				};
				sameDataHtmlText = '<h4 class="pop-text" style="display:block;font-weight:bold">以下号码重复，已进行自动过滤</h4><p class="pop-text" style="display:block">' + saveSameData.join(', ') + '</p>';
			}
			//错误号码
			if(errorData.join('') != ''){
				for (var i = 0; i < errorData.length; i++) {
					if($.trim(errorData[i].join(''))){
						saveError.push(errorData[i].join(''));
					}
				};
				errorDataHtmlText = '<h4 class="pop-text" style="display:block;font-weight:bold">以下号码错误，已进行自动过滤</h4><p class="pop-text" style="display:block">' + saveError.join(', ') + '</p>';
			}

			msg.show({
				mask: true,
				content : ['<div class="bd text-center">',
								'<div class="pop-waring">',
									'<i class="ico-waring <#=icon-class#>"></i>',
									'<div style="display:inline-block;*zoom:1;*display:inline;vertical-align:middle">' + sameDataHtmlText + errorDataHtmlText + '</div>',
								'</div>',
							'</div>'].join(''),
				closeIsShow: true,
				closeFun: function(){
					this.hide();
				}
			});
		},
		//复位
		//单式需提到子类方法实现
		reSet:function(){
			var me = this;
			me.isBallsComplete = false;
			me.rebuildData();
			me.updateData();
			if(!me.ranNumTag){
				me.showNormalTips();
			};
			//重置机选标记
			me.removeRanNumTag();
		},
		formatViewBalls: function(original) {
			var me = this,
				result = [],
				len = original.length,
				i = 0;
			for (; i < len; i++) {
				result[i] = original[i].join('');
			}
			var r = result.join('|');
			return r;
			// return result.join('|');
		},
		//生成后端参数格式
		makePostParameter: function(data, order){
			var me = this,
				result = [],
				data = order['lotterys'],
				len = data.length,
				i = 0;

			for (; i < len; i++) {
				result[i] = data[i].join('');
			}
			return result.join('|');
		},
		//获取组合结果
		getLottery:function(){
			var me = this, data = me.getHtml();
			if(data == ''){
				return;
			}
			//返回投;
			return me.checkBallIsComplete(data);
		},
		//单组去重处理
		removeSameNum: function(data) {
			var i = 0, result, me = this,
				numLen = this.getBallData()[0].length;
				len = data.length;
			result = Math.floor(Math.random() * numLen);
			for(;i<data.length;i++){
				if(result == data[i]){
					return arguments.callee.call(me, data);
				}
			}
			return result;
		},
		//清空重复号码记录
		emptySameData: function(){
			this.sameData  = [];
		},
		//清空错误号码记录
		emptyErrorData: function(){
			this.errorData = [];
		},
		//增加单式机选标记
		addRanNumTag: function(){
			var me = this;
			me.ranNumTag = true;
			me.emptySameData();
			me.emptyErrorData();
		},
		getTdata : function(){
			return this.tData;
		},
		getOriginal:function(){
			return this.getTdata();
		},
		//去除单式机选标记
		removeRanNumTag: function(){
			this.ranNumTag = false;
		},
		//限制随机投注重复
		checkRandomBets: function(hash,times){
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
			if(Number(times) > Number(me.getRandomBetsNum())){
				return current;
			}

			//建立索引
			if(allowTag){
				for (var i = 0; i < order.length; i++) {
					if(order[i]['type'] == me.defConfig.name){
						var name = order[i]['original'].join('').replace(/,/g,'');
						hash[name] = name;
					}
				};
			}
			//对比结果
			if(hash[current.join('')]){
				times++;
				return arguments.callee.call(me, hash, times);
			}

			return current;
		},
		//生成一个当前玩法的随机投注号码
		//该处实现复式，子类中实现其他个性化玩法
		//返回值： 按照当前玩法生成一注标准的随机投注单(order)
		randomNum:function(){
			var me = this,
				i = 0,
				current = [],
				currentNum,
				ranNum,
				order = null,
				dataNum = me.getBallData(),
				name = me.defConfig.name,
				name_en = Games.getCurrentGame().getCurrentGameMethod().getName(),
				methodid = Games.getCurrentGame().getCurrentGameMethod().getId(),
				rate = Games.getCurrentGameStatistics().getPrizeGroupRate(),
				lotterys = [],
				original = [];

			//增加机选标记
			me.addRanNumTag();

			current  = me.checkRandomBets();
			original = current;
			lotterys = me.combination(original);

			//生成投注格式
			order = {
				'mid': methodid,
				'type': name_en,
				'original':original,
				'lotterys':lotterys,
				'moneyUnit': Games.getCurrentGameStatistics().getMoneyUnit(),
				'multiple': Games.getCurrentGameStatistics().getMultip(),
				'onePrice': Games.getCurrentGame().getGameConfig().getInstance().getOnePriceById(methodid),
				'num': lotterys.length
			};
			var amount = order['num'] * order['moneyUnit'] * order['multiple'] * order['onePrice'];
			order['amountText'] = host.util.formatMoney(amount);
			order['prizeGroupVal'] = (amount * rate).toFixed(4);;
			return order;
		},
		getHTML:function(){
			//html模板
			var iframeSrc = Games.getCurrentGame().getGameConfig().getInstance().getUploadPath();
			var token = Games.getCurrentGame().getGameConfig().getInstance().getToken();
			var html_all = [];
				html_all.push('<div class="number-select-title balls-type-title clearfix"><div class="number-select-link"><a href="#" class="pick-rule">选号规则</a><a href="#" class="win-info">中奖说明</a></div></div>');
				html_all.push('<div class="balls-import clearfix">');
					html_all.push('<form id="form1" name="form1" enctype="multipart/form-data" method="post" action="'+ iframeSrc +'" target="check_file_frame" style="position:relative;padding-bottom:10px;">');
					html_all.push('<input name="betNumber" type="file" id="file" size="40" hidefocus="true" value="导入" style="outline:none;-ms-filter:progid:DXImageTransform.Microsoft.Alpha(Opacity=0);filter:alpha(opacity=0);opacity: 0;position:absolute;top:0px; left:0px; width:115px; height:30px;z-index:1;background:#000;cursor: pointer;" />');
					html_all.push('<input name="_token" type="hidden" value="'+ token +'" />');
					html_all.push('<input type="button" class="btn balls-import-input" style="cursor: pointer;" value="导入注单" onclick=document.getElementById("form1").file.click()>&nbsp;&nbsp;&nbsp;&nbsp;<a style="display:none;" class="balls-example-danshi-tip" href="#">查看标准格式样本</a>');
					html_all.push('<input type="reset" style="outline:none;-ms-filter:progid:DXImageTransform.Microsoft.Alpha(Opacity=0);filter:alpha(opacity=0);opacity: 0;width:0px; height:0px;z-index:1;background:#000" />');
					html_all.push('<iframe src="'+ iframeSrc +'" name="check_file_frame" style="display:none;"></iframe>');
					html_all.push('</form>');
					html_all.push('<div class="panel-select"><iframe style="width:100%;height:100%;border:0 none;background-color:#F9F9F9;" class="content-text-balls"></iframe></div>');
					html_all.push('<div class="panel-btn">');
					html_all.push('<a class="btn filter-order" href="javascript:void(0);">清除错误或重复项</a>');
					// html_all.push('<a class="btn remove-error" href="javascript:void(0);">删除错误项</a>');
					// html_all.push('<a class="btn remove-same" href="javascript:void(0);">删除重复项</a>');
					html_all.push('<a class="btn remove-all" href="javascript:void(0);">清空文本框</a>');
					html_all.push('</div>');
				html_all.push('</div>');
			return html_all.join('');
		}
	};



	var Main = host.Class(pros, GameMethod);
	Main.defConfig = defConfig;
	gameCase[name] = Main;

})(dsgame, 'Danshi', dsgame.GameMethod);


//新init重构
$(function(){

	/*
	 *实例化个方法模块
	 */
	dsgame.Games.PK10.getInstance({'jsNameSpace': 'dsgame.Games.PK10.'});//游戏实例
	dsgame.GameTypes.getInstance();//游戏玩法切换
	dsgame.GameStatistics.getInstance();//统计实例
	dsgame.GameOrder.getInstance();//号码篮实例
	dsgame.GameTrace.getInstance();//追号实例
	dsgame.GameSubmit.getInstance();//提交
	dsgame.Games.PK10.Message.getInstance();//消息类

	/*
	 *全局变量
	 */
	var Games = dsgame.Games;//初始化公共访问对象
	var isTimeEndAlertShow = false; //超时后提示信息
	var gData = Games.getCurrentGame().getGameConfig().getInstance(); //config数据缓存
	var gConfig = gData;// 新配置数据会更新
	var gCNumber = gData.getCurrentGameNumber();//当前期号
	var timerNum;//开奖动作定时器名称
	var numbersIsVisible = false;// 开奖号码是否显示
	var isFirstLottery = true; //一次标识
	var minAmountTip = new dsgame.Tip({cls:'j-ui-tip-alert j-ui-tip-b j-ui-tip-showrule',text:'使用厘模式进行投注，单注注单最小金额为0.02元'});


	// 开奖号码（配置窗口）
	var lotteryPopBoard = new dsgame.MiniWindow({
			cls: 'lottery-board-pop',
			effectShow: function (){
							var me = this;
							me.dom.css({
								display: 'block',
								left: '50%',
								marginLeft: -me.dom.outerWidth() / 2,
								top: -me.dom.outerHeight() * 2
							}).animate({
								top: 206
							});
						},
			effectHide: function (){
							var me = this;
							me.dom.animate({
								top: -me.dom.outerHeight() * 2
							}, function(){
								me.dom.hide();
							});
						}
		}),numberErnie,numberPopErnie,ballErnie = ['00','01','02','03','04','05','06','07','08','09','10','11'],ballHeight = 64,ballPopHeight = 74;

	//开奖号码显示1（反转）
	var showLotteryBoard =function(number, ballsArr){
			var $dom = $('#lottery-numbers-board');
			$('#J-ernie-issue').html(number);
			if( ballsArr && ballsArr.length ){
				if( !numberErnie ){
					$dom.find('[data-lottery-ernie-numbers]').replaceWith( getLotteryBoardHtml(ballsArr.length) );
					numberErnie = new dsgame.Ernie({
						dom      : $dom.find('li'),
						height   : ballHeight,
						length   : ballErnie.length,
						callback : ernieCallback
					});
				}
				$('#J-lottery-ernie-numbers').show();
				$('.J-loading-lottery').hide();
				numberErnie.start();
				numberErnie.stop(ballsArr);
			}else{
				$('#J-lottery-ernie-numbers').hide();
				$('.J-loading-lottery').show();
			}
		};
	//开奖号码动作完成后执行
	var ernieCallback=function (){
			// setTimeout(function(){
			// 	if( !numbersIsVisible ){
			// 		lotteryPopBoard.hide();
			// 		lotteryPopBoard.dom.find('.hand-up').fadeIn('fast');
			// 		lotteryPopBoard.dom.find('.hand-down').fadeOut('fast');
			// 	}
			// }, 2000);
			//更新缓存当前期号
			gCNumber = gData.getCurrentGameNumber();
		};
	//号码反转dom结构
	var getLotteryBoardHtml=function(len){
			var html = ['<ul style="display:none;" id="J-lottery-ernie-numbers" class="lottery-ernie-numbers lottery-ernie-numbers-' +len+ '">'];
			for(var i=0; i<len; i++){
				var _html = '<li>';
				$.each( ballErnie, function(i, ball){
					_html += '<span>' + ball + '</span>';
				});
				_html += '</li>';
				html.push(_html);
			}
			html.push('</ul>');
			return html.join('');
		};
	//定时跑开奖动作
	var newLotteryFun = function(){
		    var me = this;
		    // console.log(gCNumber);
		    //如果是第一次开奖则使用上一期的开奖奖期
		    if(isFirstLottery){
		    	gCNumber = gData.getLastGameNumber();
		    	isFirstLottery = false;
		    }
		    // console.log(gCNumber);
			$.ajax({
				url:gData.getLoadIssueUrl(),
				dataType:'JSON',
				success:function(data){
					if(data['last_number']['issue'] - gCNumber >0 ){ //如果差居在2期以上进行修正
						gCNumber = data['last_number']['issue'];
					};
					if (data['last_number']['issue'] == gCNumber){
						timerNum.stop();
						gConfig = data;
						showLotteryBoard( data['last_number']['issue'], (''+data['last_number']['wn_number']).split(' ') );

						if(gConfig['issues'][0]['issue'] == gConfig['last_number']['issue'] && gConfig['issues'][0]['wn_number'] == '' ){
							gConfig['issues'][0]['wn_number'] = gConfig['last_number']['wn_number']
						}

						gameConfigData['issueHistory']['issues'] = gConfig['issues'];
						Games.getCurrentGame().getCurrentGameMethod().miniTrend_updateTrend();

					}else{
						showLotteryBoard(gCNumber);
					}
				}
			});
		};
	//登陆超时提醒
	var updateConfigError = function(data){
			if(data['type'] == 'loginTimeout'){
				var msgwd = Games.getCurrentGameMessage();
				msgwd.hide();
				msgwd.show({
					mask:true,
					confirmIsShow:true,
					confirmText:'关 闭',
					confirmFun:function(){
						location.href = "/";
					},
					closeFun:function(){
						location.href = "/";
					},
					content:'<div class="pop-waring"><i class="ico-waring"></i><h4 class="pop-text">登录超时，请重新登录平台！</h4></div>'
				});
			}
		};
	//界面渲染加载
	var updateView = function(){
			var time = gData.getCurrentLastTime(),
				timeNow = gData.getCurrentTime(),
				surplusTime = time - timeNow,
				timer,
				fn,
				currentNumber = '' + gData.getCurrentGameNumber(),
				timeDoms = $('.J-lottery-countdown li em'),
				traceTimeDom = $('#J-trace-statistics-countdown'),
				message = Games.getCurrentGameMessage();

			fn = function(){
				if(surplusTime < 0){
					timer.stop();
					Games.getCurrentGame().getServerDynamicConfig(function(){
						var newCurrentNumber = '' + gData.getCurrentGameNumber(),
							timer,
							sNum = 2;

                        //关闭未下单弹窗
                        message.hide();
                        //清空追号数据
                        Games.getCurrentGameTrace().autoDeleteTrace();
						Games.getCurrentGameTrace().hide();

						//当当前期期号不同时,提示用户期号变化
						if(currentNumber != newCurrentNumber){
							message.showTip('<div class="tipdom-cont">当前已进入第<div class="row" style="color:#F60;font-size:18px;">'+ newCurrentNumber +' 期</div><div class="row">请留意期号变化 (<span id="J-gamenumber-change-s-num">3</span>)</div></div>');
							timer = setInterval(function(){
								$('#J-gamenumber-change-s-num').text(sNum);
								sNum -= 1;
								if(sNum < -1){
									clearInterval(timer);
									message.hideTip();
								}
							}, 1 * 1000);
						};
					});
					return;
				}
				var timeStrArr = [],
					h = Math.floor(surplusTime / 3600), // 小时数
					m = Math.floor(surplusTime % 3600 / 60), // 分钟数
					s = surplusTime%3600%60;

				h = h < 10 ? '0' + h : '' + h;
				m = m < 10 ? '0' + m : '' + m;
				s = s < 10 ? '0' + s : '' + s;
				timeStrArr.push(h);
				timeStrArr.push(m);
				timeStrArr.push(s);

				timeDoms.each(function(i,n){
					$(this).text(timeStrArr[i]);
				});
				traceTimeDom.html(timeStrArr.join(':'));
				surplusTime--;
			};
			timer = new dsgame.Timer({time:1000, fn:fn});

			$('#J-header-currentNumber').html(currentNumber);
		};
	//游戏记录tab
	var recordTab = function(){
		$("div.game-record-section>ul>li").click(function(){
			var me= $(this);
			$("div.game-record-section>ul>li").removeClass('current');
			me.addClass('current');
			$('#record-iframe').attr("src",me.attr("srclink"));
		})
	};
	var switchBoardFun = function(){
			var lastNumber = gConfig['last_number'] ? gConfig['last_number']['issue'] : gConfig.getLastGameNumber();
			var lotteryBalls = gConfig['last_number']? (''+gConfig['last_number']['wn_number']).split(' ') :(''+gConfig.getLotteryBalls()).split(' ');

			if( gConfig.getLotteryBalls() == '' ){
				// showLotteryBoard(lastNumber, lotteryBalls);
				timerNum = new dsgame.Timer({time:5000,isNew:true,fn:newLotteryFun});
			}else{
				showLotteryBoard(lastNumber, lotteryBalls);
			}
			return false;
	};

	/*
	 * 自执行
	 */
	 // createLotteryNumbers();
	 updateView();
	 recordTab();
	 switchBoardFun();
	/*
	 *触发事件类
	 */
	//当最新的配置信息和新的开奖号码出现后，进行界面更新
	Games.getCurrentGame().addEvent('changeDynamicConfig', function(e, cfg){
		//跑定时器
		timerNum = new dsgame.Timer({time:5000,isNew:true,fn:newLotteryFun});
		updateView();
	});
	// 切换开奖记录／开奖号码面板

	// 玩法菜单区域的高亮处理
	Games.getCurrentGameTypes().addEvent('beforeChange', function(e, id){
		var $tabs = $('#J-panel-gameTypes li'),
			$panel = $('#J-gametyes-menu-panel'),
			dom = $panel.find('[data-id="'+ id +'"]'),
			li,
			name_cn = Games.getCurrentGame().getGameConfig().getInstance().getMethodCnNameById(id),
			cls = 'current';
		if(dom.size() > 0){
			$panel.find('dd').removeClass(cls).end();
			dom.addClass(cls);
			li = dom.parents('li').addClass('current').show();
			$tabs.removeClass('current').eq(li.index()).addClass('current');
		}
	});
	//玩法规则，中奖说明的tips提示
	var tipRule = new dsgame.Tip({cls:'j-ui-tip-b j-ui-tip-showrule'});
	$('#J-balls-main-panel').on('mouseover', '.pick-rule, .win-info', function(){
		var el = $(this),
			currentMethodId = Games.getCurrentGame().getCurrentGameMethod().getId(),
			methodCfg = Games.getCurrentGame().getGameConfig().getInstance().getMethodById(currentMethodId),
			text = el.hasClass('pick-rule') ? methodCfg['bet_note'] : methodCfg['bonus_note'] ;
		tipRule.setText(text);
		tipRule.show(tipRule.getDom().width()/2 * -1 + el.width()/2, tipRule.getDom().height() * -1 - 20, el);
	});
	$('#J-balls-main-panel').on('mouseleave', '.pick-rule, .win-info', function(){
		tipRule.hide();
	});
	$('#J-balls-main-panel').on('click', '.pick-rule, .win-info', function(){
		return false;
	});
	// 选球区域的玩法名称显示
	var methodPrize = 0;
	Games.getCurrentGame().addEvent('afterSwitchGameMethod', function(e, id) {
		var id = Games.getCurrentGame().getCurrentGameMethod().getId(),
			unit = Games.getCurrentGameStatistics().getMoneyUnit(),
			maxv = Games.getCurrentGame().getGameConfig().getInstance().getLimitByMethodId(id, unit),
			methodCfg = Games.getCurrentGame().getGameConfig().getInstance().getPrizeById(id),
			MaxPrizeGroup = Games.getCurrentGame().getGameConfig().getInstance().getMaxPrizeGroup(),
			maxUserPrizeLength =  Games.getCurrentGame().getGameConfig().getInstance().getOptionalPrizes().length,
			maxUserPrize = Games.getCurrentGame().getGameConfig().getInstance().getOptionalPrizes()[maxUserPrizeLength-1]['prize_group'],
			prize = 0,
			showPrize=false;

		methodPrize = Number(methodCfg['prize']);
		showPrize = methodCfg['display_prize'];
		if(maxUserPrize>MaxPrizeGroup){
			prize = methodPrize * unit*MaxPrizeGroup /maxUserPrize;
		}else{
			prize = methodPrize * unit ;
		};
		// console.log(prize)
		Games.getCurrentGameStatistics().getMultipleDom().setMaxValue(maxv);

		if(showPrize){
			$('#J-method-prize').show();
			$('#J-method-prize').find('span').html( dsgame.util.formatMoney(prize) );
		}else{
			$('#J-method-prize').hide();
		};
		Games.getCurrentGame().getCurrentGameMethod().miniTrend_updateTrend();
	});
	//加载默认玩法
	Games.getCurrentGameTypes().addEvent('endShow', function() {
		this.changeMode(Games.getCurrentGame().getGameConfig().getInstance().getDefaultMethodId());
	});
	// 将选球数据添加到号码篮
	$('#J-add-order').click(function(){
		var result = Games.getCurrentGameStatistics().getResultData();
		if(!result['mid'] || result['amount']<'0.02'){
			return;
		}
		Games.getCurrentGameOrder().add(result);
	});
	//根据选球内容更新添加按钮的状态样式
	Games.getCurrentGameStatistics().addEvent('afterUpdate', function(e, num, money){
		var me = this, button = $('#J-add-order'),
			MaxPrizeGroup = Games.getCurrentGame().getGameConfig().getInstance().getMaxPrizeGroup(),
			maxUserPrizeLength =  Games.getCurrentGame().getGameConfig().getInstance().getOptionalPrizes().length,
			maxUserPrize = Games.getCurrentGame().getGameConfig().getInstance().getOptionalPrizes()[maxUserPrizeLength-1]['prize_group'];

		if(num > 0){
			if(money>='0.02'){

				button.removeClass('btn-disable');
				// 计算返点
				var rate = me.getPrizeGroupRate() || 0;
				me.setRebate(money, rate);
				minAmountTip.hide();
			}else{
				minAmountTip.show(minAmountTip.getDom().width()/2 * -1 + button.width()/2, minAmountTip.getDom().height() * -1 - 20, button);
				button.addClass('btn-disable');
				me.setRebate(0);
			}
		}else{
			button.addClass('btn-disable');
			me.setRebate(0);
			minAmountTip.hide();
		};

		var prize = methodPrize * Number( me.getMoneyUnit());
		// 计算最低单注奖金
		if(maxUserPrize>MaxPrizeGroup){
			prize = methodPrize * Number( me.getMoneyUnit() )*MaxPrizeGroup /maxUserPrize;
		};
		$('#J-method-prize').find('span').html( dsgame.util.formatMoney(prize) );
	});

	//号码蓝模拟滚动条(该滚动条初始化使用autoReinitialise: true参数也可以达到自动调整的效果，但是是用的定时器检测)
	var gameOrderScroll = $('#J-panel-order-list-cont'),
		gameOrderScrollAPI;
	gameOrderScroll.jScrollPane();
	gameOrderScrollAPI = gameOrderScroll.data('jsp');

	//注单提交按钮的禁用和启用
	//数字改变闪烁动画
	Games.getCurrentGameOrder().addEvent('afterChangeLotterysNum', function(e, lotteryNum){
		var me = this,subButton = $('#J-submit-order'),traceButton = $('#J-trace-switch'),rederData=e.data['orderData'],unitType = false;
		var cartEmpty = $('.J-cart-empty');
		if(lotteryNum > 0){
			for(var i = 0 ;i<rederData.length; i++){
				(rederData[i]['moneyUnit'] == 0.001 ) ? unitType = true : '';
			}
			if(unitType ){
				subButton.removeClass('btn-bet-disable');
				traceButton.addClass('btn-bet-disable');
			}else{
				subButton.add(traceButton).removeClass('btn-bet-disable');
			}
			cartEmpty.hide();
			gameOrderScrollAPI.reinitialise();
		}else{
			subButton.add(traceButton).addClass('btn-bet-disable');
			cartEmpty.show();
		}
	});


	//单式上传的删除、去重、清除功能
	$('body').on('click', '.remove-error', function(){
		Games.getCurrentGame().getCurrentGameMethod().removeOrderError();
	}).on('click', '.remove-same', function(){
		Games.getCurrentGame().getCurrentGameMethod().removeOrderSame();
	}).on('click', '.remove-all', function(){
		Games.getCurrentGame().getCurrentGameMethod().removeOrderAll();
	});
	//设置倍数$ 模式
	Games.getCurrentGameStatistics().setMultiple(Games.getCurrentGame().getGameConfig().getInstance().getDefaultMultiple());
	Games.getCurrentGameStatistics().setMoneyUnitDom((Games.getCurrentGame().getGameConfig().getInstance().getDefaultCoefficient()));

	//投注按钮操作
	$('body').on('click', '#J-submit-order', function(){
		Games.getCurrentGameTrace().deleteTrace();
		Games.getCurrentGameSubmit().submitData();
	});

	//追号区域的显示
	$('#J-trace-switch').click(function(){
		var orderData = Games.getCurrentGameOrder().orderData, moneyUnit = false;
		for(var i = 0 ; i<orderData.length; i++){
			(orderData[i].moneyUnit == '0.001')? moneyUnit = true : '';
		}
		if(moneyUnit){
			return false;
		}
		// 更新追号区的余额显示
		$('#J-trace-statistics-balance').html($('[data-user-account-balance]').html());
		// 弹出追号窗口
		Games.getCurrentGameTrace().show();
		return false;
	});
	//追号窗口关闭
	$('#J-trace-panel').on('click', '.closeBtn', function(){
		//由关闭和取消按钮触发，恢复原来号码篮原来的倍数
		Games.getCurrentGameTrace().hide();
		Games.getCurrentGameTrace().deleteTrace();
	});
	// 追号投注
	$('#J-button-trace-confirm').click(function(){
		if( Games.getCurrentGameTrace().getIsTrace() ){
			Games.getCurrentGameTrace().hide();
			Games.getCurrentGameSubmit().submitData();
			Games.getCurrentGameTrace().deleteTrace();
		};
	});
	//submit loading
	Games.getCurrentGameSubmit().addEvent('beforeSend', function(e, msg){
		var panel = msg.win.dom.find('.pop-control'),
		comfirmBtn = panel.find('a.confirm'),
		cancelBtn = panel.find('a.cancel');
		comfirmBtn.addClass('btn-disabled');
		comfirmBtn.text('提交中...');
		msg.win.hideCancelButton();

	});
	Games.getCurrentGameSubmit().addEvent('afterSubmit', function(e, msg){
		var panel = msg.win.dom.find('.pop-control'),
		comfirmBtn = panel.find('a.confirm'),
		cancelBtn = panel.find('a.cancel');
		comfirmBtn.removeClass('btn-disabled');
		comfirmBtn.text('确 认');
		// 刷新投注记录
		$('#record-iframe').attr("src",$(".game-record-section >ul.tabs >li.current").attr("srclink"));
		// 刷新余额
		$('[data-refresh-balance]:eq(0)').trigger('click');
	});
	//延迟一秒执行页面上滚定位到投注区
	setTimeout( function(){
		$('html,body').animate({scrollTop: 140}, 400);
	}, 1000)


});