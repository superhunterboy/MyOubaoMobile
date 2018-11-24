;(function(){
	var gameSelfConfig = {};
	// 投注玩法配置信息
	gameSelfConfig['gamediceBallLists'] = [
		{"name":"sumdxds.sumdxds.sumdxds", "ball": "0", "viewBalls":"总和大", "odds":1},
		{"name":"sumdxds.sumdxds.sumdxds", "ball": "1", "viewBalls":"总和小", "odds":1},
		{"name":"sumdxds.sumdxds.sumdxds", "ball": "2", "viewBalls":"总和单", "odds":1},
		{"name":"sumdxds.sumdxds.sumdxds", "ball": "3", "viewBalls":"总和双", "odds":1},

		{"name":"longhuhe.longhuhe.longhuhe", "ball": "0", "viewBalls":"龙", "odds":1.2},
		{"name":"longhuhe.longhuhe.longhuhe", "ball": "1", "viewBalls":"虎", "odds":1.2},
		{"name":"longhuhe.longhuhe.longhuhe", "ball": "2", "viewBalls":"和", "odds":9},

		{"name":"firstball.firstball.firstball", "ball": "0", "viewBalls":"0", "odds":9},
		{"name":"firstball.firstball.firstball", "ball": "1", "viewBalls":"1", "odds":9},
		{"name":"firstball.firstball.firstball", "ball": "2", "viewBalls":"2", "odds":9},
		{"name":"firstball.firstball.firstball", "ball": "3", "viewBalls":"3", "odds":9},
		{"name":"firstball.firstball.firstball", "ball": "4", "viewBalls":"4", "odds":9},
		{"name":"firstball.firstball.firstball", "ball": "5", "viewBalls":"5", "odds":9},
		{"name":"firstball.firstball.firstball", "ball": "6", "viewBalls":"6", "odds":9},
		{"name":"firstball.firstball.firstball", "ball": "7", "viewBalls":"7", "odds":9},
		{"name":"firstball.firstball.firstball", "ball": "8", "viewBalls":"8", "odds":9},
		{"name":"firstball.firstball.firstball", "ball": "9", "viewBalls":"9", "odds":9},
		{"name":"firstball.firstball.firstballdxds", "ball": "0", "viewBalls":"大", "odds":1},
		{"name":"firstball.firstball.firstballdxds", "ball": "1", "viewBalls":"小", "odds":1},
		{"name":"firstball.firstball.firstballdxds", "ball": "2", "viewBalls":"单", "odds":1},
		{"name":"firstball.firstball.firstballdxds", "ball": "3", "viewBalls":"双", "odds":1},

		{"name":"secondball.secondball.secondball", "ball": "0", "viewBalls":"0", "odds":9},
		{"name":"secondball.secondball.secondball", "ball": "1", "viewBalls":"1", "odds":9},
		{"name":"secondball.secondball.secondball", "ball": "2", "viewBalls":"2", "odds":9},
		{"name":"secondball.secondball.secondball", "ball": "3", "viewBalls":"3", "odds":9},
		{"name":"secondball.secondball.secondball", "ball": "4", "viewBalls":"4", "odds":9},
		{"name":"secondball.secondball.secondball", "ball": "5", "viewBalls":"5", "odds":9},
		{"name":"secondball.secondball.secondball", "ball": "6", "viewBalls":"6", "odds":9},
		{"name":"secondball.secondball.secondball", "ball": "7", "viewBalls":"7", "odds":9},
		{"name":"secondball.secondball.secondball", "ball": "8", "viewBalls":"8", "odds":9},
		{"name":"secondball.secondball.secondball", "ball": "9", "viewBalls":"9", "odds":9},
		{"name":"secondball.secondball.secondballdxds", "ball": "0", "viewBalls":"大", "odds":1},
		{"name":"secondball.secondball.secondballdxds", "ball": "1", "viewBalls":"小", "odds":1},
		{"name":"secondball.secondball.secondballdxds", "ball": "2", "viewBalls":"单", "odds":1},
		{"name":"secondball.secondball.secondballdxds", "ball": "3", "viewBalls":"双", "odds":1},

		{"name":"thirdball.thirdball.thirdball", "ball": "0", "viewBalls":"0", "odds":9},
		{"name":"thirdball.thirdball.thirdball", "ball": "1", "viewBalls":"1", "odds":9},
		{"name":"thirdball.thirdball.thirdball", "ball": "2", "viewBalls":"2", "odds":9},
		{"name":"thirdball.thirdball.thirdball", "ball": "3", "viewBalls":"3", "odds":9},
		{"name":"thirdball.thirdball.thirdball", "ball": "4", "viewBalls":"4", "odds":9},
		{"name":"thirdball.thirdball.thirdball", "ball": "5", "viewBalls":"5", "odds":9},
		{"name":"thirdball.thirdball.thirdball", "ball": "6", "viewBalls":"6", "odds":9},
		{"name":"thirdball.thirdball.thirdball", "ball": "7", "viewBalls":"7", "odds":9},
		{"name":"thirdball.thirdball.thirdball", "ball": "8", "viewBalls":"8", "odds":9},
		{"name":"thirdball.thirdball.thirdball", "ball": "9", "viewBalls":"9", "odds":9},
		{"name":"thirdball.thirdball.thirdballdxds", "ball": "0", "viewBalls":"大", "odds":1},
		{"name":"thirdball.thirdball.thirdballdxds", "ball": "1", "viewBalls":"小", "odds":1},
		{"name":"thirdball.thirdball.thirdballdxds", "ball": "2", "viewBalls":"单", "odds":1},
		{"name":"thirdball.thirdball.thirdballdxds", "ball": "3", "viewBalls":"双", "odds":1},

		{"name":"fourthball.fourthball.fourthball", "ball": "0", "viewBalls":"0", "odds":9},
		{"name":"fourthball.fourthball.fourthball", "ball": "1", "viewBalls":"1", "odds":9},
		{"name":"fourthball.fourthball.fourthball", "ball": "2", "viewBalls":"2", "odds":9},
		{"name":"fourthball.fourthball.fourthball", "ball": "3", "viewBalls":"3", "odds":9},
		{"name":"fourthball.fourthball.fourthball", "ball": "4", "viewBalls":"4", "odds":9},
		{"name":"fourthball.fourthball.fourthball", "ball": "5", "viewBalls":"5", "odds":9},
		{"name":"fourthball.fourthball.fourthball", "ball": "6", "viewBalls":"6", "odds":9},
		{"name":"fourthball.fourthball.fourthball", "ball": "7", "viewBalls":"7", "odds":9},
		{"name":"fourthball.fourthball.fourthball", "ball": "8", "viewBalls":"8", "odds":9},
		{"name":"fourthball.fourthball.fourthball", "ball": "9", "viewBalls":"9", "odds":9},
		{"name":"fourthball.fourthball.fourthballdxds", "ball": "0", "viewBalls":"大", "odds":1},
		{"name":"fourthball.fourthball.fourthballdxds", "ball": "1", "viewBalls":"小", "odds":1},
		{"name":"fourthball.fourthball.fourthballdxds", "ball": "2", "viewBalls":"单", "odds":1},
		{"name":"fourthball.fourthball.fourthballdxds", "ball": "3", "viewBalls":"双", "odds":1},

		{"name":"fifthball.fifthball.fifthball", "ball": "0", "viewBalls":"0", "odds":9},
		{"name":"fifthball.fifthball.fifthball", "ball": "1", "viewBalls":"1", "odds":9},
		{"name":"fifthball.fifthball.fifthball", "ball": "2", "viewBalls":"2", "odds":9},
		{"name":"fifthball.fifthball.fifthball", "ball": "3", "viewBalls":"3", "odds":9},
		{"name":"fifthball.fifthball.fifthball", "ball": "4", "viewBalls":"4", "odds":9},
		{"name":"fifthball.fifthball.fifthball", "ball": "5", "viewBalls":"5", "odds":9},
		{"name":"fifthball.fifthball.fifthball", "ball": "6", "viewBalls":"6", "odds":9},
		{"name":"fifthball.fifthball.fifthball", "ball": "7", "viewBalls":"7", "odds":9},
		{"name":"fifthball.fifthball.fifthball", "ball": "8", "viewBalls":"8", "odds":9},
		{"name":"fifthball.fifthball.fifthball", "ball": "9", "viewBalls":"9", "odds":9},
		{"name":"fifthball.fifthball.fifthballdxds", "ball": "0", "viewBalls":"大", "odds":1},
		{"name":"fifthball.fifthball.fifthballdxds", "ball": "1", "viewBalls":"小", "odds":1},
		{"name":"fifthball.fifthball.fifthballdxds", "ball": "2", "viewBalls":"单", "odds":1},
		{"name":"fifthball.fifthball.fifthballdxds", "ball": "3", "viewBalls":"双", "odds":1},

		{"name":"qiansanqiu.qiansanqiu.qiansanqiu", "ball": "1", "viewBalls":"顺子", "odds":18.33},
		{"name":"qiansanqiu.qiansanqiu.qiansanqiu", "ball": "2", "viewBalls":"对子", "odds":3.4},
		{"name":"qiansanqiu.qiansanqiu.qiansanqiu", "ball": "3", "viewBalls":"半顺", "odds":2.33},
		{"name":"qiansanqiu.qiansanqiu.qiansanqiu", "ball": "4", "viewBalls":"杂六", "odds":3.0},
		{"name":"qiansanqiu.qiansanqiu.qiansanqiu", "ball": "0", "viewBalls":"豹子", "odds":99},

		{"name":"zhongsanqiu.zhongsanqiu.zhongsanqiu", "ball": "1", "viewBalls":"顺子", "odds":18.33},
		{"name":"zhongsanqiu.zhongsanqiu.zhongsanqiu", "ball": "2", "viewBalls":"对子", "odds":3.4},
		{"name":"zhongsanqiu.zhongsanqiu.zhongsanqiu", "ball": "3", "viewBalls":"半顺", "odds":2.33},
		{"name":"zhongsanqiu.zhongsanqiu.zhongsanqiu", "ball": "4", "viewBalls":"杂六", "odds":3.0},
		{"name":"zhongsanqiu.zhongsanqiu.zhongsanqiu", "ball": "0", "viewBalls":"豹子", "odds":99},

		{"name":"housanqiu.housanqiu.housanqiu", "ball": "1", "viewBalls":"顺子", "odds":18.33},
		{"name":"housanqiu.housanqiu.housanqiu", "ball": "2", "viewBalls":"对子", "odds":3.4},
		{"name":"housanqiu.housanqiu.housanqiu", "ball": "3", "viewBalls":"半顺", "odds":2.33},
		{"name":"housanqiu.housanqiu.housanqiu", "ball": "4", "viewBalls":"杂六", "odds":3.0},
		{"name":"housanqiu.housanqiu.housanqiu", "ball": "0", "viewBalls":"豹子", "odds":99},
	];

	// 开奖号码请求间隔（毫秒）
	gameSelfConfig['issueTimeout'] = 15000;

	// 开奖动画类型
	gameSelfConfig['diceAnimationType'] = 'flipball';
	// 开奖动画Flipball配置，只针对flipball类型才有
	gameSelfConfig['flipballConf'] = {
		ballsize: 5, // 彩球个数
		initball: '0,0,0,0,0', // 初始化彩球数据
		loop: 5, // 彩球滚动循环次数（必须为整数）
		timeout: 5000, // 彩球滚动动画执行时间基数
		delay: 150, // 每个彩球动画执行延迟时间基数
		offset: [48, 60] // 球的宽高
	};

	// 开奖记录
	gameSelfConfig['recordMarkup'] =
		'<li>' +
			'<div class="rec1"><#=ball1#><#=ball2#><#=ball3#><#=ball4#><#=ball5#></div>' +
			'<div class="rec2"><#=sum#></div>' +
			'<div class="rec3"><#=dxds#></div>'  +
			'<div class="rec4"><#=longHu#></div>'  +
			'<div class="rec5"><#=number#></div>' +
		'</li>';

	// 单行开奖记录生成
	gameSelfConfig['createRecordRowData'] = function(balls, number){
		// balls = balls || currentBalls;
		// number = number || currentNumber;
		var records = {}, sum = 0,
			dxds = '-', longHu = '-';
		records['number'] = number.substr(-3) + '期';
		$.each(balls, function(i,n){
			var key = 'ball' + (i+1);
			records[key] = n;
			sum += parseInt(n);
		});
		var dx = '大', ds = '双';
		dxds = '';
		longHu = '和';
		if( sum <= 22 ){
			dx = '小';
		}
		if( sum % 2 ){
			ds = '单';
		}
		if( Number(balls[0]) > Number(balls[4]) ){
			longHu = '龙';
		}else if( Number(balls[0]) < Number(balls[4]) ){
			longHu = '虎';
		}
		dxds += dx + ',' + ds;
		records['sum'] = sum;
		records['dxds'] = dxds;
		records['longHu'] = longHu;
		return records;
	};

	// 开奖动画结束后执行方法
	gameSelfConfig['afterShowNumber'] = function(){};

	// 赔率tips生成方法
	gameSelfConfig['createOddsTips'] = function(ballLists, gamelimit, prizeGroup, maxPrizeGroup){
		var html = '', methods = {};
		$.each(ballLists, function(idx, ball){
			var prize = parseFloat(gamelimit[ball['id']]['prize']),
				odds = prize / 2 - 1,
				baseOdds = '1赔',
				n = ball['name'].split('.')[2];
			if( prizeGroup > maxPrizeGroup ){
				prize *= (maxPrizeGroup / prizeGroup);
			}
			if( (ball['name'] == 'sumdxds.sumdxds.sumdxds' && !methods['sumdxds']) ){
                                                                        odds = prize / 2 - 1;
				prize = prize.toFixed(2);
				odds = baseOdds + odds.toFixed(2);
				html += '<div class="odds-tips odds-tips-' +n+ '" data-tips-title="' + prize + '">' + odds + '</div>';
				methods[ball['name'].split('.')[2]] = 1;
			}else if( ball['name'] == 'longhuhe.longhuhe.longhuhe' ){
				methods[n] = methods[n] ? methods[n] + 1 : 1;
				n = n + '-' + methods[n];
				// 最高赔率1:9
				prize *= ((ball['odds']+1)/ 10);
				odds = prize / 2 - 1;
				prize = prize.toFixed(2);
				odds = baseOdds + odds.toFixed(2);
				html += '<div class="odds-tips odds-tips-' +n+ '" data-tips-title="' + prize + '">' + odds + '</div>';
			}else if(
				( ball['name'] == 'firstball.firstball.firstball' && !methods['firstball']) ||
				( ball['name'] == 'secondball.secondball.secondball' && !methods['secondball']) ||
				( ball['name'] == 'thirdball.thirdball.thirdball' && !methods['thirdball']) ||
				( ball['name'] == 'fourthball.fourthball.fourthball' && !methods['fourthball']) ||
				( ball['name'] == 'fifthball.fifthball.fifthball' && !methods['fifthball'])
			){
				methods[n] = methods[n] ? methods[n] + 1 : 1;
				n = n + '-' + methods[n];
				odds = prize / 2 - 1;
				prize = prize.toFixed(2);
				odds = baseOdds + odds.toFixed(2);
				html += '<div class="odds-tips odds-tips-' +n+ '" data-tips-title="' + prize + '">' + odds + '</div>';
			}else if(
				( ball['name'] == 'firstball.firstball.firstballdxds' && !methods['firstballdxds']) ||
				( ball['name'] == 'secondball.secondball.secondballdxds' && !methods['secondballdxds']) ||
				( ball['name'] == 'thirdball.thirdball.thirdballdxds' && !methods['thirdballdxds']) ||
				( ball['name'] == 'fourthball.fourthball.fourthballdxds' && !methods['fourthballdxds']) ||
				( ball['name'] == 'fifthball.fifthball.fifthballdxds' && !methods['fifthballdxds'])
			){
				methods[n] = methods[n] ? methods[n] + 1 : 1;
				n = n + '-' + methods[n];
				odds = prize / 2 - 1;
				prize = prize.toFixed(2);
				odds = baseOdds + odds.toFixed(2);
				html += '<div class="odds-tips odds-tips-' +n+ '" data-tips-title="' + prize + '">' + odds + '</div>';
			}else if(
				ball['name'] == 'qiansanqiu.qiansanqiu.qiansanqiu' || 
				ball['name'] == 'zhongsanqiu.zhongsanqiu.zhongsanqiu' ||
				ball['name'] == 'housanqiu.housanqiu.housanqiu'
			){
				methods[n] = methods[n] ? methods[n] + 1 : 1;
				n = n + '-' + methods[n];
				// 最高赔率1:99
				prize *= ((ball['odds']+1) / 100);
				odds = prize / 2 - 1;
				prize = prize.toFixed(2);
				odds = baseOdds + odds.toFixed(2);
				html += '<div class="odds-tips odds-tips-' +n+ '" data-tips-title="' + prize + '">' + odds + '</div>';
			}
		});
		return html;
	};

	// dsgamedice conf
	gameSelfConfig['dsgamediceConf'] = {
		chips: [1,2,5,10,20,50,100,500,1000,5000],
		chipsSelected: [10,20,50,100,500],
		createOddsTips: gameSelfConfig['createOddsTips']
	};

	return window.gameSelfConfig = gameSelfConfig;
})();