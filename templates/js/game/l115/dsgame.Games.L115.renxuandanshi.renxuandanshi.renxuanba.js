﻿(function(host, Danshi, undefined) {
	var defConfig = {
			name: 'renxuandanshi.renxuandanshi.renxuanba',
			UIContainer: '#J-balls-main-panel'
		},
		gameCaseName = 'L115',
		Games = host.Games,
		//游戏类
		gameCase = host.Games[gameCaseName].getInstance();


	//定义方法
	var pros = {
		init: function(cfg) {
			var me = this;
			//建立编辑器DOM
			//防止绑定事件失败加入定时器
			setTimeout(function() {
				me.initFrame();
			}, 25);
		},
		rebuildData: function() {
			var me = this;
			me.balls = [
				[-1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1]
			];
		},
		//检测单注号码是否通过
		checkSingleNum: function(lotteryNum) {
			var me = this,
				isPass = true,
				lotteryNum = lotteryNum.sort(),
				len = lotteryNum.length,
				i = 0;
			if(len != 8){
				return isPass = false;
			}

			for(i = 0;i < len;i++){
				if(lotteryNum[i] == lotteryNum[i+1]){
					return isPass = false;
				}
			}

			$.each(lotteryNum, function() {
				if (!me.defConfig.checkNum.test(this)  || Number(this) < 1 || Number(this) > 11) {
					return isPass = false;
				}
			});
			return isPass;
		}
	};

	//继承Danshi
	var Main = host.Class(pros, Danshi);
	Main.defConfig = defConfig;
	//将实例挂在游戏管理器上
	gameCase.setLoadedHas(defConfig.name, new Main());



})(dsgame, dsgame.Games.L115.Danshi);