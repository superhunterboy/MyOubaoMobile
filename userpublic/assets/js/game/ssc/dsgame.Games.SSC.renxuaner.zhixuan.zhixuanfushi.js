

//五星直选复式玩法实现类
(function(host, GameMethod, undefined){
	var defConfig = {
		//名称
		name:'renxuaner.zhixuan.zhixuanfushi',
		//玩法提示
		tips:'直选复式玩法提示',
		//选号实例
		exampleTip: '五星直选复式范例',
		orderSplitType: 'renxuan_zhixuan_fs'
	};
		//游戏类
	var SSC = host.Games.SSC.getInstance();

	//定义方法
	var pros = {
		init:function(cfg){
			var me = this;
			if( defConfig.orderSplitType ){
				host.Games.getCurrentGame().getCurrentGameMethod().setOrderSplitType(defConfig.orderSplitType);	
			}			
		},
		//时时彩复式结构为5行10列
		//复位选球数据
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
			me.container.html(html_all.join(''));
		},
		//获取总注数/获取组合结果
		//isGetNum=true 只获取数量，返回为数字
		//isGetNum=false 获取组合结果，返回结果为单注数组
		getLottery:function(isGetNum){
			var me = this,
				data = me.getBallData(),
				i = 0,
				len = data.length,
				row,
				_tempRow = [],
				j = 0,
				len2 = 0,
				result = [],
				//普通组合结果
				combinationResult = [],
				//最终结果
				finalResult = [],
				tempArr = [],
				//总注数
				total = 1,
				rowNumNeed = 2, // 需要至少选择两行的数据
				rowNum = 0;
			me.isBallsComplete = true;
			//检测球是否完整
			for(;i < len;i++){
				var temp = [];
				row = data[i];
				len2 = row.length;
				for(j = 0;j < len2;j++){
					// console.log(j,row[j])
					if(row[j] > 0){
						//需要计算组合则推入结果
						if(!isGetNum){
							temp.push( i + '' + j );
						}
					}
				}
				if( temp.length ){
					result[rowNum] = temp;
					rowNum++;
				}
			}
			// console.log(JSON.stringify(result))
			if( rowNum >= rowNumNeed ){
				var combs = SSC.k_combinations(result,rowNumNeed);
				// console.log(JSON.stringify(combs))
				$.each(combs, function(i, comb){
					finalResult = finalResult.concat( SSC.zx_combinations(comb) );
				});
				// console.log(JSON.stringify(finalResult))
				// 组合结果
				return finalResult;
					
			}else{
				return [];
			}
		}

	};

	//html模板
	var html_head = [];
		//头部
		html_head.push('<div class="number-select-title balls-type-title clearfix"><div class="number-select-link"><a href="#" class="pick-rule">选号规则</a><a href="#" class="win-info">中奖说明</a></div><div class="function-select-title"></div></div>');
		html_head.push('<div class="number-select-content">');
		html_head.push('<ul class="ball-section">');
		//每行
	var html_row = [];
		html_row.push('<li>');
		html_row.push('<div class="ball-title"><strong><#=title#>位</strong><span></span></div>');
		html_row.push('<ul class="ball-content">');
			$.each([0,1,2,3,4,5,6,7,8,9], function(i){
				html_row.push('<li><a class="ball-number" data-param="action=ball&value='+ this +'&row=<#=row#>" href="javascript:void(0);">'+ this +'</a></li>');
			});
		html_row.push('</ul>');
		html_row.push('<div class="ball-control">');
		html_row.push('<a href="javascript:void(0);" class="circle"></a>');
		html_row.push('<a href="javascript:void(0);" data-param="action=batchSetBall&amp;row=<#=row#>&amp;bound=all" class="all">全</a>');
		html_row.push('<a href="javascript:void(0);" data-param="action=batchSetBall&amp;row=<#=row#>&amp;bound=big" class="big">大</a>');
		html_row.push('<a href="javascript:void(0);" data-param="action=batchSetBall&amp;row=<#=row#>&amp;bound=small" class="small">小</a>');
		html_row.push('<a href="javascript:void(0);" data-param="action=batchSetBall&amp;row=<#=row#>&amp;bound=odd" class="odd">奇</a>');
		html_row.push('<a href="javascript:void(0);" data-param="action=batchSetBall&amp;row=<#=row#>&amp;bound=even" class="even">偶</a>');
		html_row.push('<a href="javascript:void(0);" data-param="action=batchSetBall&amp;row=<#=row#>&amp;bound=none" class="none">清</a>');
		html_row.push('</div>');
		html_row.push('</li>');

	var html_bottom = [];
		html_bottom.push('</ul>');
		html_bottom.push('</div>');
		//拼接所有
	var html_all = [],rowStr = html_row.join('');
		html_all.push(html_head.join(''));
		$.each(['万','千','百','十','个'], function(i){
			html_all.push(rowStr.replace(/<#=title#>/g, this).replace(/<#=row#>/g, i));
		});
		html_all.push(html_bottom.join(''));



	//继承GameMethod
	var Main = host.Class(pros, GameMethod);
		Main.defConfig = defConfig;
	//将实例挂在游戏管理器实例上
	SSC.setLoadedHas(defConfig.name, new Main());

})(dsgame, dsgame.GameMethod);

