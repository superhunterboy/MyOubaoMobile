<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<title>时时彩</title>
	<link rel="stylesheet" href="../images/global/global.css" />
	<link rel="stylesheet" href="../dsgame/css/style.css" />
	<link rel="stylesheet" href="../images/game/game.css" />

<!-- 工具类 -->
<script type="text/javascript" src="../js/jquery-1.9.1.min.js" ></script>
<script type="text/javascript" src="../js/jquery.tmpl.min.js" ></script>
<script type="text/javascript" src="../js/jquery.mousewheel.min.js" ></script>
<script type="text/javascript" src="../js/jquery.jscrollpane.js" ></script>
<script type="text/javascript" src="../js/dsgame.base.js" ></script>
<script type="text/javascript" src="../js/dsgame.Tab.js" ></script>
<script type="text/javascript" src="../js/dsgame.Hover.js" ></script>
<script type="text/javascript" src="../js/dsgame.Select.js" ></script>
<script type="text/javascript" src="../js/dsgame.Timer.js" ></script>
<script type="text/javascript" src="../js/dsgame.Mask.js" ></script>
<script type="text/javascript" src="../js/dsgame.MiniWindow.js" ></script>
<script type="text/javascript" src="../js/dsgame.Tip.js" ></script>
<!-- Games命名空间 -->
<script type="text/javascript" src="../js/game/dsgame.Games.js" ></script>
<!-- 游戏父类 -->
<script type="text/javascript" src="../js/game/dsgame.Game.js" ></script>
<script type="text/javascript" src="../js/game/dsgame.GameMethod.js" ></script>
<script type="text/javascript" src="../js/game/dsgame.GameMessage.js" ></script>

</head>
<body>

	<?php include_once("../header.php"); ?>
	<div class="header">
		<div class="g_33">
			<a class="logo-lottery"><img src="<?=$root_path?>/images/game/logo-lottery.jpg" alt="重庆时时彩" title="重庆时时彩" /></a>
			<div class="deadline">
				<div class="deadline-text">第<strong id="">0146299</strong>期<br>投注截止</div>
				<div class="deadline-number">
					<em class="min-left"><b class="deadline-number-mask"></b>1</em>
					<em class="min-right"><b class="deadline-number-mask"></b>9</em>
					<span>:</span>
					<em class="sec-left"><b class="deadline-number-mask"></b>5</em>
					<em class="sec-right"><b class="deadline-number-mask"></b>5</em>
				</div>
			</div>
			<div class="lottery">
				<div class="lottery-text">上期号码</div>
				<div id="J-lottery-info-balls" class="lottery-number">
					<em>7</em>
					<em>0</em>
					<em>2</em>
					<em>7</em>
					<em>5</em>
				</div>
				<div class="lottery-link">
					<a href="#" target="_blank" class="info">冷热遗漏</a>
					<a href="#" target="_blank" class="info">玩法说明</a>
					<a href="#" target="_blank" class="chart">走势图</a>
				</div>
			</div>
		</div>
	</div>
	<div class="g_33 main">
		<div class="panel-section">
			<div class="panel-section-inner">
				<div class="pannel-title">
					<a href="#" class="close" title="删除全部" id="J-button-clearall"></a>
					购彩篮
				</div>
				<div class="panel-select">
					<div class="panel-select-title clearfix">
							<span class="name">玩法</span>
							<span class="number">号码</span>
							<span class="bet">注</span>
							<span class="multiple">倍</span>
							<span class="price">金额</span>
					</div>
					<div class="panel-order-list-cont" id="J-panel-order-list-cont">
						<ul id="J-balls-order-container">

						</ul>
					</div>
				</div>
				<div class="chase-site">
					<a href="javascript:void(0)" class="chase-site-btn" id="J-trace-switch"><i></i>设置追号</a>
					<span class="chase-site-content" id="J-trace-num-tip-panel">共追号 <span id="J-trace-num-text">10</span> 期</span>
				</div>
				<div class="bet-statistics">
					注数<em id="J-gameOrder-lotterys-num">0</em>注，共<em id="J-gameOrder-amount">0.00</em>元
				</div>
				<div class="btn-bet-bg">
					<span class="btn-progress-topright"></span>
					<span class="btn-progress-right"></span>
					<span class="btn-progress-bottom"></span>
					<span class="btn-progress-left"></span>
					<span class="btn-progress-topleft"></span>
					<a id="J-submit-order" class="btn-bet btn-bet-disable" href="javascript:void(0)"><span class="btn-bet-text">投注截止时间 07:28:35</span></a>
				</div>
			</div>
		</div>
		<div class="play-section">
			<div class="play-select">
				<ul class="play-select-title clearfix" id="J-panel-gameTypes">


				</ul>
			</div>
		</div>
		<!-- 选球统计开始 -->
		<div class="number-section">
			<div id="J-balls-main-panel" class="number-section-balls-main-panel">


			</div>
			<div id="J-balls-statistics-panel">

				<ul class="bet-statistics clearfix">
					<li>
						<select id="J-balls-statistics-multiple" style="display:none;">
							<option value="1">1</option>
							<option value="5">5</option>
							<option value="10">10</option>
						</select>
						<span id="J-balls-statistics-multiple-text" class="game-statistics-multiple-text">1</span>
						<span class="choose-model-text">倍</span>
					</li>
					<li>
						<select id="J-balls-statistics-moneyUnit" style="display:none;">
							<option value="1">元</option>
							<option value="0.1">角</option>
						</select>
					</li>
					<li class="choose-bet">已选<em id="J-balls-statistics-lotteryNum">0</em>注,</li>
					<li class="total-money">共<em id="J-balls-statistics-amount">300.00</em>元</li>
					<li class="choose-btn"><input type="button" value="" id="J-add-order" class="disable" /></li>
				</ul>

			</div>
		</div>
	</div>



	<div id="J-trace-panel" class="j-ui-miniwindow pop pop-panel-trace" style="z-index:700;position:fixed;top:0;width:900px;height:630px;left:50%;top:50%;margin-left:-450px;margin-top:-315px;display:none;">
		<div class="pop-hd">
			<i class="pop-close closeBtn"></i>
			<h3 class="pop-title"><i class="pop-title-ico"></i>设置追号</h3>
		</div>
		<div class="pop-bd">
			<div class="chase-tab">
				<div class="chase-tab-title clearfix">
					<ul class="clearfix">
						<li class="current">普通追号</li>
						<li class="">高级追号</li>
					</ul>



					<div style="display:none;" class="chase-stop" id="J-trace-iswinstop-panel">
						<label for="J-trace-iswinstop" class="label"><input type="checkbox" class="checkbox" id="J-trace-iswinstop">累计盈利</label>
						&gt;
						&nbsp;<input type="text" value="1000" class="input" disabled="disabled" id="J-trace-iswinstop-money" style="width:30px;text-align:center;padding:0 4px;">&nbsp;元时停止追号
						<i id="J-trace-iswinstop-hover" class="icon-question">
							玩法提示
							<div class="chase-stop-tip" id="chase-stop-tip-2">
									当追号计划中，累计盈利金额（已获奖金扣除已投本金）大于设定值时，即停止继续追号。<br>
									如果您不考虑追号的盈利情况，<a id="J-chase-stop-switch-2" href="#">点这里</a>。
							</div>
						</i>
					</div>



					<div class="chase-stop" id="J-trace-iswintimesstop-panel">
						<label class="label"><input type="checkbox" class="checkbox" id="J-trace-iswintimesstop">中奖后停止追号</label><input type="text" value="1" disabled="disabled" class="input" id="J-trace-iswintimesstop-times" style="display:none;">&nbsp;
						<i id="J-trace-iswintimesstop-hover" class="icon-question">
							玩法提示
							<div class="chase-stop-tip" id="chase-stop-tip-1">
									当追号计划中，一个方案内的任意注单中奖时，即停止继续追号。<br>
									如果您希望考虑追号的实际盈利，<a id="J-chase-stop-switch-1" href="#">点这里</a>。
							</div>
						</i>
					</div>


				</div>
				<div class="chase-tab-content chase-tab-content-current">


				<ul class="chase-select-normal clearfix">
						<li id="J-function-select-tab">
							连续追：
							<ul class="function-select-title">
								<li class="current">5期</li>
								<li class="">10期</li>
								<li>15期</li>
								<li>20期</li>
							</ul>
							<ul class="function-select-panel" style="display:none;">
								<li class="panel-current"></li>
								<li class=""></li>
								<li></li>
								<li></li>
							</ul>
						</li>
						<li>
							<input id="J-trace-normal-times" type="text" class="input" value="10">&nbsp;&nbsp;期
						</li>
						<li>
							倍数：
							<select id="J-trace-normal-multiple" style="display: none;">
								<option>1</option>
								<option>5</option>
								<option>10</option>
								<option>15</option>
								<option>20</option>
								<option>30</option>
								<option>50</option>
							</select>
						</li>
					</ul>





					<div class="chase-table-container">
					<table class="table chase-table" id="J-trace-table">
						<tbody id="J-trace-table-body" data-type="trace_normal">
							<tr>
								<th class="text-center">
									序号
								</th>
								<th>
									<input type="checkbox" checked="checked" class="checkbox" data-action="checkedAll">
									追号期次
								</th>
								<th>
									倍数
								</th>
								<th>
									金额
								</th>
								<th>
									预计开奖时间
								</th>
							</tr>
						</tbody>
					</table>
					</div>

				</div>





				<div class="chase-tab-content">
					<div class="chase-select-high">
						<ul class="base-parameter">
							<li>
								起始期号：

								<div class="choose-model chase-trace-startNumber-select w-4"><div style="display:none;" class="choose-list"><a href="javascript:void(0);" data-value="201301021215">201301021215(当前期)</a><a href="javascript:void(0);" data-value="201301021216">201301021216</a><a href="javascript:void(0);" data-value="201301021217">201301021217</a><a href="javascript:void(0);" data-value="201301021218">201301021218</a><a href="javascript:void(0);" data-value="201301021219">201301021219</a><a href="javascript:void(0);" data-value="201301021220">201301021220</a><a href="javascript:void(0);" data-value="201301021221">201301021221</a><a href="javascript:void(0);" data-value="201301021222">201301021222</a><a href="javascript:void(0);" data-value="201301021223">201301021223</a><a href="javascript:void(0);" data-value="201301021224">201301021224</a><a href="javascript:void(0);" data-value="201301021225">201301021225</a><a href="javascript:void(0);" data-value="201301021226">201301021226</a><a href="javascript:void(0);" data-value="201301021227">201301021227</a><a href="javascript:void(0);" data-value="201301021228">201301021228</a></div><span class="info"><input type="text" value="201301021215(当前期)" disabled="disabled" class="choose-input" data-realvalue="201301021215"></span><i></i></div><select style="display:none;" id="J-traceStartNumber"><option selected="selected" value="201301021215">201301021215(当前期)</option><option value="201301021216">201301021216</option><option value="201301021217">201301021217</option><option value="201301021218">201301021218</option><option value="201301021219">201301021219</option><option value="201301021220">201301021220</option><option value="201301021221">201301021221</option><option value="201301021222">201301021222</option><option value="201301021223">201301021223</option><option value="201301021224">201301021224</option><option value="201301021225">201301021225</option><option value="201301021226">201301021226</option><option value="201301021227">201301021227</option><option value="201301021228">201301021228</option></select>

							</li>
							<li>
								追号期数：
								<input type="text" value="10" class="input" id="J-trace-advanced-times">&nbsp;&nbsp;期（最多可以追<span id="J-trace-number-max">14</span>期）
							</li>
							<li>
								起始倍数：
								<input type="text" value="1" class="input" id="J-trace-advance-multiple">&nbsp;&nbsp;倍
							</li>
						</ul>

						<div class="high-parameter" id="J-trace-advanced-type-panel">
							<ul class="tab-title">
								<li class="current">翻倍追号</li>
								<li>盈利金额追号</li>
								<li>盈利率追号</li>
							</ul>
							<ul class="tab-content">
								<li class="panel-current">
									<p data-type="a">
										<input type="radio" checked="checked" name="trace-advanced-type1" class="trace-advanced-type-switch">
										每隔&nbsp;<input type="text" value="2" class="input" id="J-trace-advanced-fanbei-a-jiange">&nbsp;期
										倍数x<input type="text" value="2" class="input trace-input-multiple" id="J-trace-advanced-fanbei-a-multiple">
									</p>
									<p data-type="b">
										<input type="radio" name="trace-advanced-type1" class="trace-advanced-type-switch">
										前&nbsp;<input type="text" disabled="disabled" value="5" class="input" id="J-trace-advanced-fanbei-b-num">&nbsp;期
										倍数=起始倍数，之后倍数=<input type="text" disabled="disabled" value="3" class="input trace-input-multiple" id="J-trace-advanced-fanbei-b-multiple">
									</p>
								</li>
								<li>
									<p data-type="a">
										<input type="radio" checked="checked" name="trace-advanced-type2" class="trace-advanced-type-switch">
										预期盈利金额≥&nbsp;<input type="text" value="100" class="input" id="J-trace-advanced-yingli-a-money">&nbsp;元
									</p>
									<p data-type="b">
										<input type="radio" name="trace-advanced-type2" class="trace-advanced-type-switch">
										前&nbsp;<input type="text" disabled="disabled" value="2" class="input" id="J-trace-advanced-yingli-b-num">&nbsp;期
										预期盈利金额≥&nbsp;<input type="text" disabled="disabled" value="100" class="input" id="J-trace-advanced-yingli-b-money1">&nbsp;元，之后预期盈利金额≥&nbsp;<input type="text" disabled="disabled" value="50" class="input" id="J-trace-advanced-yingli-b-money2">&nbsp;元
									</p>
								</li>
								<li>
									<p data-type="a">
										<input type="radio" checked="checked" name="trace-advanced-type3" class="trace-advanced-type-switch">
										预期盈利率≥&nbsp;<input type="text" value="10" class="input" id="J-trace-advanced-yinglilv-a">&nbsp;%
									</p>
									<p data-type="b">
										<input type="radio" name="trace-advanced-type3" class="trace-advanced-type-switch">
										前&nbsp;<input type="text" disabled="disabled" value="5" class="input" id="J-trace-advanced-yinglilv-b-num">&nbsp;期
										预期盈利率≥&nbsp;<input type="text" disabled="disabled" value="30" class="input" id="J-trace-advanced-yingli-b-yinglilv1">&nbsp;%，之后预期盈利率≥&nbsp;<input type="text" value="10" class="input" disabled="disabled" id="J-trace-advanced-yingli-b-yinglilv2">&nbsp;%
									</p>
								</li>
							</ul>
						</div>
					</div>

					<div class="chase-btn"><input type="button" value="" id="J-trace-builddetail"></div>


					<div class="chase-table-container">
						<table class="table chase-table" id="J-trace-table-advanced">
							<tr>
								<th>序号</th>
								<th><label class="label"><input type="checkbox" class="checkbox">追号期次</label></th>
								<th>倍数</th>
								<th>金额</th>
								<th>预计开奖时间</th>
							</tr>
							<tr>
								<td class="text-center">1</td>
								<td>
									<input type="checkbox" checked="checked" class="checkbox" data-action="checkedRow">
									<span class="trace-row-number">201301021215<span class="icon-period-current"></span></span>
								</td>
								<td><input type="text" style="width:30px;text-align:center;" value="1" class="input"> 倍</td>
								<td>&yen;<span class="trace-row-money">10.00</span> 元</td>
								<td><span class="trace-row-time">2013/12/10 08:14:23</span></td>
							</tr>
						</table>
					</div>
				</div>
			</div>


			<ul class="bet-statistics">
					<li>共追号 <span id="J-trace-statistics-times">10</span> 期，<em><span id="J-trace-statistics-lotterys-num">10</span> </em>注，</li>
					<li>总投注金额 <strong class="price"><dfn>&yen;</dfn><span id="J-trace-statistics-amount">20.00</span></strong> 元</li>
			</ul>


		</div>
		<div class="pop-btn">
			<a href="javascript:void(0);" class="btn btn-important closeBtn" style="">确 认</a>
			<a href="javascript:void(0);" class="btn btn-normal closeBtn" style="">取 消</a>
		</div>
	</div>




	<?php include_once("../footer.php"); ?>



<!-- 实例类 -->
<script type="text/javascript" src="../js/game/ssc/dsgame.Games.SSC.js" ></script>
<script type="text/javascript" src="../js/game/ssc/dsgame.Games.SSC.Config.php" ></script>
<script type="text/javascript" src="../js/game/ssc/dsgame.Games.SSC.Message.js" ></script>
<!-- 单例类 -->
<script type="text/javascript" src="../js/game/dsgame.GameTypes.js" ></script>
<script type="text/javascript" src="../js/game/dsgame.GameStatistics.js" ></script>
<script type="text/javascript" src="../js/game/dsgame.GameOrder.js" ></script>
<script type="text/javascript" src="../js/game/dsgame.GameTrace.js" ></script>
<script type="text/javascript" src="../js/game/dsgame.GameSubmit.js" ></script>
<!-- 额外的单式父类 -->
<script type="text/javascript" src="../js/game/ssc/dsgame.Games.SSC.Danshi.js" ></script>

<!-- 初始化页面开始 -->
<script>
(function(){


	var init = function(config){
			//游戏公共访问对象
		var Games = dsgame.Games;
			//游戏实例
			dsgame.Games.SSC.getInstance();
			//游戏玩法切换
			dsgame.GameTypes.getInstance();
			//统计实例
			dsgame.GameStatistics.getInstance();
			//号码篮实例
			dsgame.GameOrder.getInstance();
			//追号实例
			dsgame.GameTrace.getInstance();
			//提交
			dsgame.GameSubmit.getInstance();
			//消息类
			dsgame.Games.SSC.Message.getInstance();


			//服务器端输出的游戏配置
			var serverConfig = config;


			//当最新的配置信息和新的开奖号码出现后，进行界面更新
			Games.getCurrentGame().addEvent('changeDynamicConfig', function(e, cfg){
				var lastballs = cfg['lastballs'].split(',');
				//当前期号
				$('#J-lotter-info-number').text(cfg['number']);
				//上期期号
				$('#J-lotter-info-lastnumber').text(cfg['lastnumber']);
				//上期开奖号码
				$('#J-lotter-info-balls').find('em').each(function(i){
					this.innerHTML = lastballs[i];
				});

				//重新启动/更新新一轮定时器
				topTimer.setStartTime(new Date(cfg['nowtime']));
				topTimer.setEndTime(new Date(cfg['nowstoptime']));
				topTimer.continueCount();

			});



			//加载默认玩法
			Games.getCurrentGameTypes().addEvent('endShow', function() {
				this.changeMode(Games.getCurrentGame().getGameConfig().getInstance().getDefaultMethod());
			});

			//将选球数据添加到号码篮
			$('#J-add-order').click(function(){
				Games.getCurrentGameOrder().add(Games.getCurrentGameStatistics().getResultData());

			});
			//根据选球内容更新添加按钮的状态样式
			Games.getCurrentGameStatistics().addEvent('afterUpdate', function(e, num, money){
				var button = $('#J-add-order');
				if(num > 0){
					button.removeClass('disable');
				}else{
					button.addClass('disable');
				}
			});

			//号码蓝模拟滚动条(该滚动条初始化使用autoReinitialise: true参数也可以达到自动调整的效果，但是是用的定时器检测)
			var gameOrderScroll = $('#J-panel-order-list-cont'),gameOrderScrollAPI;
				gameOrderScroll.jScrollPane();
			gameOrderScrollAPI = gameOrderScroll.data('jsp');
			//注单提交按钮的禁用和启用
			//当投注内容发生改变时，重新绘制滚动条
			//数字改变闪烁动画
			Games.getCurrentGameOrder().addEvent('afterChangeLotterysNum', function(e, lotteryNum){
				var me = this,subButton = $('#J-submit-order');
				if(lotteryNum > 0){
					subButton.removeClass('btn-bet-disable');
				}else{
					subButton.addClass('btn-bet-disable');
				}
				gameOrderScrollAPI.reinitialise();
				me.totalLotterysNumDom.addClass('blink');
				me.totalAmountDom.addClass('blink');
				setTimeout(function(){
					me.totalLotterysNumDom.removeClass('blink');
					me.totalAmountDom.removeClass('blink');
				}, 600);
			});


			//清空号码篮
			$('#J-button-clearall').click(function(e){
				e.preventDefault();
				Games.getCurrentGameOrder().reSet().cancelSelectOrder();
				Games.getCurrentGame().getCurrentGameMethod().reSet();
			});

			//单式上传的删除、去重、清除功能
			$('body').on('click', '.remove-error', function(){
				Games.getCurrentGame().getCurrentGameMethod().removeOrderError();
			}).on('click', '.remove-same', function(){
				Games.getCurrentGame().getCurrentGameMethod().removeOrderSame();
			}).on('click', '.remove-all', function(){
				Games.getCurrentGame().getCurrentGameMethod().removeOrderAll();
			});


			//投注按钮操作
			$('body').on('click', '#J-submit-order', function(){
				Games.getCurrentGameSubmit().submitData();
			});

			//辅助批量选球面板的显示和隐藏
			$('#J-balls-main-panel').on('mouseover', '.ball-control', function(){
				$(this).addClass('ball-control-current');
			});
			$('#J-balls-main-panel').on('mouseleave', '.ball-control', function(){
				$(this).removeClass('ball-control-current');
			});

			//追号区域的显示
			$('#J-trace-switch').click(function(){
				Games.getCurrentGameTrace().show();
			});
			//追号窗口关闭
			$('#J-trace-panel').on('click', '.closeBtn', function(){
				Games.getCurrentGameTrace().hide();
			});


	};

	init();

})();
</script>

</body>
</html>


