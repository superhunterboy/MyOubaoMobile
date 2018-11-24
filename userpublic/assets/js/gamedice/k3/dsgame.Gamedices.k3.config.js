;(function(){
	var gameSelfConfig = {};
	// 投注玩法配置信息
	gameSelfConfig['gamediceBallLists'] = [
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

	// 开奖号码请求间隔（毫秒）
	gameSelfConfig['issueTimeout'] = 10000;

	// 开奖动画类型
	gameSelfConfig['diceAnimationType'] = 'dice';

	// 开奖号码生成开奖记录时是否需要排序
	gameSelfConfig['ballsNeedSorted'] = true;

	// 单行开奖记录生成
	gameSelfConfig['createRecordRowData'] = function(balls, number){
		// balls = balls || currentBalls;
		// number = number || currentNumber;
		// 需要排序
		balls.sort(function(a, b){
			return parseInt(a) - parseInt(b);
		});
		var records = {}, num = 0,
			size = '-', oddEven = '-';
		records['number'] = number.substr(-3) + '期';
		$.each(balls, function(i,n){
			var key = 'ball' + (i+1);
			records[key] = n;
			num += parseInt(n);
		});
		size = '小';
		oddEven = '双';
		if( num >= 10 ){
			size = '大';
		}
		if( num % 2 ){
			oddEven = '单';
		}
		records['num'] = num;
		records['size'] = size;
		records['oddEven'] = oddEven;
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
				baseOdds = '1赔';
			if( prizeGroup > maxPrizeGroup ){
				prize *= (maxPrizeGroup / prizeGroup);
			}
			if( (ball['name'] == 'sthdx.sthdx.fs' && !methods['sthdx']) ||
				(ball['name'] == 'sthtx.sthtx.fs' && !methods['sthtx']) ||
				(ball['name'] == 'ebth.ebth.fs'   && !methods['ebth']) ||
				(ball['name'] == 'bdw.bdw.fs'     && !methods['bdw'])
			){
				prize = prize.toFixed(2);
				odds = baseOdds + odds.toFixed(2);
				html += '<div class="odds-tips odds-tips-' +idx+ '" data-tips-title="' + prize + '">' + odds + '</div>';
				methods[ball['name'].split('.')[0]] = 1;
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
				// odds *= (ball['odds'] / 180);
				prize *= (ball['odds'] / 180);
				odds = prize / 2 - 1;
				prize = prize.toFixed(2);
				odds = baseOdds + odds.toFixed(2);
				html += '<div class="odds-tips odds-tips-' +idx+ '" data-tips-title="' + prize + '">' + odds + '</div>';
			}else if( ball['name'] == 'dx.dx.fs' || ball['name'] == 'ds.ds.fs' ){
				prize = prize.toFixed(2);
				odds = baseOdds + odds.toFixed(2);
				html += '<div class="odds-tips odds-tips-' +idx+ '" data-tips-title="' + prize + '">' + odds + '</div>';
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