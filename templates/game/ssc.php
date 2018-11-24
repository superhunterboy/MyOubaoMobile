<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<title>时时彩</title>
	<link rel="stylesheet" href="../images/global/global.css" />
	<link rel="stylesheet" href="../images/game/game.css" />

	<!-- 工具类 -->
	<script src="../js/jquery-1.9.1.min.js"></script>
	<script src="../js/raphael-min.js"></script>
	<script src="../js/jquery.easing.1.3.js"></script>
	<script src="../js/jquery.mousewheel.min.js"></script>
	<script src="../js/jquery.jscrollpane.js"></script>
	<script src="../js/jquery.marquee.min.js"></script>
	<script src="../js/dsgame.base.js"></script>
	<script src="../js/dsgame.Ernie.js"></script>
	<script src="../js/dsgame.Tab.js"></script>
	<script src="../js/dsgame.Hover.js"></script>
	<script src="../js/dsgame.Select.js"></script>
	<script src="../js/dsgame.Timer.js"></script>
	<script src="../js/dsgame.Mask.js"></script>
	<script src="../js/dsgame.Message.js"></script>
	<script src="../js/dsgame.MiniWindow.js"></script>
	<script src="../js/dsgame.SliderBar.js"></script>
	<script src="../js/dsgame.Tip.js"></script>
	<!-- Games命名空间 -->
	<script src="../js/game/dsgame.Games.js"></script>
	<!-- 游戏父类 -->
	<script src="../js/game/dsgame.Game.js"></script>
	<script src="../js/game/dsgame.GameMethod.js"></script>
	<script src="../js/game/dsgame.GameMessage.js"></script>
	<script src="../js/game/ssc/dsgame.Games.SSC.js"></script>

</head>
<body>
<div class="body">
	<?php include_once("../header.php"); ?>
	<div class="g_33 main">
		<div class="game-block">
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
						<li class="choose-btn"><button type="button" id="J-add-order" class="ui-button">&#8595;&nbsp;确认号码&nbsp;&#8595;</button></li>
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
								<option value="0.01">分</option>
							</select>
						</li>
						<li class="choose-bet">已选<em id="J-balls-statistics-lotteryNum">0</em>注,</li>
						<li class="total-money">共<em id="J-balls-statistics-amount">0.00</em>元</li>
					</ul>

				</div>
			</div>

			<div class="panel-section">
				<div class="panel-section-inner">
					<div class="pannel-title">
						<a href="#" class="close" title="删除全部" id="J-button-clearall"></a>
						投注清单
					</div>
					<div class="panel-select">
						<div class="panel-select-title clearfix">
							<span class="name">玩法</span>
							<span class="number">投注内容</span>
							<span class="unit">模式</span>
							<span class="bet">注数</span>
							<span class="multiple">倍数</span>
							<span class="price">金额</span>
						</div>
						<div class="panel-order-list-cont" id="J-panel-order-list-cont">
							<ul id="J-balls-order-container">

							</ul>
						</div>
					</div>
					<!-- <div class="chase-site">
						<a href="javascript:void(0)" class="chase-site-btn" id="J-trace-switch"><i></i>设置追号</a>
						<span class="chase-site-content" id="J-trace-num-tip-panel">共追号 <span id="J-trace-num-text">10</span> 期</span>
					</div> -->
					<div class="bet-statistics">
						<div class="bet-subtotal">
							已选<em id="J-gameOrder-lotterys-num">0</em>注，共<em id="J-gameOrder-amount">0.00</em>元
						</div>
						<!-- 设置奖金组及返点-->
						<div id="J-bonus-group-select" class="dropbox-like" data-dropbox tabindex="0">
							<div class="dropbox-handler">
								<div class="toggle-icon">
									<span>选择奖金组</span>
									<i></i>
								</div>
								<input id="J-bonus-select-value-show" class="toggle-value" type="text" value="" disabled>
							</div>
							<div class="dropbox-content">
								<div class="slider-range" onselectstart="return false;">
									<div class="slider-range-sub" id="J-slider-minDom">-</div>
									<div class="slider-range-add" id="J-slider-maxDom">+</div>

									<div class="slider-range-wrapper" id="J-slider-cont">
										<div class="slider-range-inner" id="J-slider-innerbg"></div>
										<div class="slider-range-btn" id="J-slider-handle"></div>
									</div>
									<div class="slider-range-scale">
										<span class="small-number" id="J-slider-num-min">1900</span>
										<span class="percent-number" id="J-slider-num-percent">5%</span>
										<span class="big-number" id="J-slider-num-max">1955</span>
									</div>
								</div>
							</div>
							<input id="J-bonus-select-value" type="hidden" value="">
						</div>
					</div>

					<div class="trace-panel" id="J-trace-panel">
						<div class="trace-radio">
							<label><strong>购买方式：</strong></label>
							<a href="javascript:void(0);" data-value="notrace"><i class="mkg-game-icon"></i>常规购买</a>
							<a href="javascript:void(0);" data-value="tongbei"><i class="mkg-game-icon"></i>同倍追号</a>
							<a href="javascript:void(0);" data-value="lirunlv"><i class="mkg-game-icon"></i>利润率追号</a>
							<a href="javascript:void(0);" data-value="fanbei"><i class="mkg-game-icon"></i>翻倍追号</a>
							<div class="chase-stop" id="J-trace-iswintimesstop-panel">
								<label class="label"><input type="checkbox" class="checkbox" id="J-trace-iswintimesstop" checked="checked" >中奖后停止追号</label><input type="text" value="1" class="input" id="J-trace-iswintimesstop-times" style="display:none;">&nbsp;
								<i id="J-trace-iswintimesstop-hover" class="icon-question" style="display:none;">
									玩法提示
									<div class="chase-stop-tip" id="chase-stop-tip-1">
										当追号计划中，一个方案内的任意注单中奖时，即停止继续追号。<br>
										如果您希望考虑追号的实际盈利，<a id="J-chase-stop-switch-1" href="#">点这里</a>。
									</div>
								</i>
							</div>
						</div>
						<div class="trace-content">
							<div class="chase-tab">
								<!-- <div class="chase-tab-title clearfix" style="display:none;">
									<ul class="clearfix">
										<li class="chase-tab-t">同倍追号</li>
										<li class="chase-tab-t">利润率追号</li>
										<li class="chase-tab-t">翻倍追号</li>
									</ul>
									<div style="display:none;" class="chase-stop" id="J-trace-iswinstop-panel">
										<label for="J-trace-iswinstop" class="label"><input type="checkbox" class="checkbox" id="J-trace-iswinstop">累计盈利</label>
										&gt;
										&nbsp;<input type="text" value="1000" class="input" disabled="disabled" id="J-trace-iswinstop-money" style="width:30px;text-align:center;padding:0 4px;">&nbsp;元时停止追号
										<i id="J-trace-iswinstop-hover" class="icon-question" style="display:none;">
											玩法提示
											<div class="chase-stop-tip" id="chase-stop-tip-2">
													当追号计划中，累计盈利金额（已获奖金扣除已投本金）大于设定值时，即停止继续追号。<br>
													如果您不考虑追号的盈利情况，<a id="J-chase-stop-switch-2" href="#">点这里</a>。
											</div>
										</i>
									</div>
								</div> -->

								<div class="chase-tab-content">
									<!-- 没有追号 -->
								</div>

								<!-- 同倍追号 -->
								<div class="chase-tab-content">
									<div class="trace-title-param">
										<div class="filter-tabs">
											<span class="filter-tabs-title">连续追:</span>
											<div class="filter-tabs-cont J-trace-tongbei-times-filter">
												<a href="javascript:void(0);" data-value="1">1期</a>
												<a href="javascript:void(0);" data-value="5">5期</a>
												<a href="javascript:void(0);" data-value="10">10期</a>
												<a href="javascript:void(0);" data-value="15">15期</a>
												<a href="javascript:void(0);" data-value="20">20期</a>
											</div>
										</div>
										<label class="param">
											已选:&nbsp;<input id="J-trace-tongbei-times" class="input w-1" type="text" value="10" />&nbsp;期
										</label>
										<label class="param">
											倍数:
											<select id="J-trace-tongbei-multiple-select" style="display:none;">
												<option value="1">1</option>
												<option value="5">5</option>
												<option value="10">10</option>
												<option value="15">15</option>
												<option value="20">20</option>
											</select>
											倍
											<input id="J-trace-tongbei-multiple" class="input" type="hidden" value="1" />
										</label>
										<input type="button" class="btn trace-button-detail" value="生成追号计划" />
									</div>

									<div class="chase-table-container">
										<table class="table chase-table" id="J-trace-table">
											<tbody id="J-trace-table-tongbei-body" data-type="tongbei">
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

								<!-- 利润率追号 -->
								<div class="chase-tab-content">
									<div class="trace-title-param">
										<label class="param">
											最低收益率:
											<input id="J-trace-lirunlv-num" class="input w-1" type="text" value="50" /> %
										</label>
										<label class="param">
											追号期数:
											<input id="J-trace-lirunlv-times" class="input w-1" type="text" value="10" />
										</label>
										<input type="button" class="btn trace-button-detail" value="生成追号计划" />
									</div>

									<div class="chase-table-container">
										<table id="J-trace-table-lirunlv" class="table chase-table">
											<tbody data-type="lirunlv" id="J-trace-table-lirunlv-body">
												<tr><th class="text-center">序号</th><th><input  checked="checked" data-action="checkedAll" type="checkbox"> 追号期次</th><th>倍数</th><th>金额</th><th>奖金</th><th>预期盈利金额</th><th>预期盈利率</th></tr>
											</tbody>
										</table>
									</div>
								</div>

								<!-- 翻倍追号 -->
								<div class="chase-tab-content">
									<div class="trace-title-param">
										<label class="param">
											起始倍数:
											<input id="J-trace-fanbei-multiple" class="input w-1" type="text" value="1" />
										</label>
										<label class="param">
											隔
											<input id="J-trace-fanbei-jump" class="input w-1" type="text" value="2" />
										</label>
										<label class="param">
											期 倍x
											<input id="J-trace-fanbei-num" class="input w-1" type="text" value="2" />
										</label>
										<label class="param">
											追号期数:
											<input id="J-trace-fanbei-times" class="input w-1" type="text" value="10" />
										</label>
										<input type="button" class="btn trace-button-detail" value="生成追号计划" />
									</div>

									<div class="chase-table-container">
									<table class="table chase-table" id="J-trace-table">
										<tbody id="J-trace-table-fanbei-body" data-type="fanbei">
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
										<div class="title">基本参数</div>
										<ul class="base-parameter">
											<li>
												起始期号：
												<select id="J-traceStartNumber" style="display: none;"></select>
											</li>
											<li>
												追号期数：
												<input id="J-trace-advanced-times" type="text" class="input" value="10">&nbsp;&nbsp;期（最多可以追<span id="J-trace-number-max">14</span>期）
											</li>
											<li>
												起始倍数：
												<input id="J-trace-advance-multiple" type="text" class="input" value="1">&nbsp;&nbsp;倍
											</li>
										</ul>

										<div class="title">高级参数</div>
										<div id="J-trace-advanced-type-panel" class="high-parameter">
											<ul class="tab-title">
												<li class="current">翻倍追号</li>
												<li>盈利金额追号</li>
												<li>盈利率追号</li>
											</ul>
											<ul class="tab-content">
												<li class="panel-current">
													<p data-type="a">
														<input class="trace-advanced-type-switch" type="radio" name="trace-advanced-type1" checked="checked">
														每隔&nbsp;<input id="J-trace-advanced-fanbei-a-jiange" type="text" class="input" value="2">&nbsp;期
														倍数x<input id="J-trace-advanced-fanbei-a-multiple" type="text" class="input trace-input-multiple" value="2">
													</p>
													<p data-type="b">
														<input class="trace-advanced-type-switch" type="radio" name="trace-advanced-type1">
														前&nbsp;<input id="J-trace-advanced-fanbei-b-num" type="text" class="input" value="5" disabled="disabled">&nbsp;期
														倍数=起始倍数，之后倍数=<input id="J-trace-advanced-fanbei-b-multiple" type="text" class="input trace-input-multiple" value="2" disabled="disabled">
													</p>
												</li>
												<li>
													<p data-type="a">
														<input class="trace-advanced-type-switch" type="radio" name="trace-advanced-type2" checked="checked">
														预期盈利金额≥&nbsp;<input id="J-trace-advanced-yingli-a-money" type="text" class="input" value="100">&nbsp;元
													</p>
													<p data-type="b">
														<input class="trace-advanced-type-switch" type="radio" name="trace-advanced-type2">
														前&nbsp;<input id="J-trace-advanced-yingli-b-num" type="text" class="input" value="2" disabled="disabled">&nbsp;期
														预期盈利金额≥&nbsp;<input id="J-trace-advanced-yingli-b-money1" type="text" class="input" value="100" disabled="disabled">&nbsp;元，之后≥&nbsp;<input id="J-trace-advanced-yingli-b-money2" type="text" class="input" value="50" disabled="disabled">&nbsp;元
													</p>
												</li>
												<li>
													<p data-type="a">
														<input class="trace-advanced-type-switch" type="radio" name="trace-advanced-type3" checked="checked">
														预期盈利率≥&nbsp;<input id="J-trace-advanced-yinglilv-a" type="text" class="input" value="10">&nbsp;%
													</p>
													<p data-type="b">
														<input class="trace-advanced-type-switch" type="radio" name="trace-advanced-type3">
														前&nbsp;<input id="J-trace-advanced-yinglilv-b-num" type="text" class="input" value="5" disabled="disabled">&nbsp;期
														预期盈利率≥&nbsp;<input id="J-trace-advanced-yingli-b-yinglilv1" type="text" class="input" value="30" disabled="disabled">&nbsp;%，之后≥&nbsp;<input id="J-trace-advanced-yingli-b-yinglilv2" disabled="disabled" type="text" class="input" value="10">&nbsp;%
													</p>
												</li>
											</ul>
										</div>
									</div>

									<div class="chase-table-container">
										<table id="J-trace-table-advanced" class="table chase-table">
												<tbody id="J-trace-table-advanced-body">
													<tr>
														<th style="width:125px;" class="text-center">序号</th>
														<th><label class="label"><input type="checkbox" class="checkbox">追号期次</label>
														</th><th>倍数</th>
														<th>金额</th>
														<th>预计开奖时间</th>
													</tr>
												</tbody>
										</table>
									</div>
								</div>
							</div>

							<ul class="bet-statistics">
								<li>共追号 <span id="J-trace-statistics-times">0</span> 期，<em><span id="J-trace-statistics-lotterys-num">0</span> </em>注，</li>
								<li>总投注金额 <strong class="price"><dfn>&yen;</dfn><span id="J-trace-statistics-amount">0.00</span></strong> 元</li>
								<!-- <li>
									<a href="javascript:void(0);" class="btn btn-important" id="J-button-trace-confirm">保存追号方案</a>
									<a href="javascript:void(0);" class="btn btn-normal closeBtn" style="">取 消</a>
								</li> -->
							</ul>
						</div>

					</div>

				</div>
			</div>

			<div class="submit-panel">
				<div class="user-balance">账户余额：<dfn>￥</dfn><span class="J-user-balance">23223.00</span></div>
				<button type="button" id="J-submit-order" class="ui-button btn-bet btn-bet-disable">&#10003;&nbsp;立即投注</button>
				<div class="bet-countdown"><div class="bet-countdown-inner" id="J-bet-countdown"></div></div>
			</div>
		</div>

		<!-- 右侧彩票信息 -->
		<div class="lottery-block" id="lottery-info">
			<div class="lottery-info-basic">
				<div class="lottery-info-logo"><img src="../images/game/logo/cqssc.png" alt="重庆时时彩" title="重庆时时彩" /></div>
				<div class="lottery-info-issue">
					<p>当前销售期次</p>
					<div class="lottery-info-issue-box">
						<span>第</span>
						<span id="J-header-currentNumber">------</span>
						<span>期</span>
					</div>
					<!-- <a href="" class="color-highlight">游戏说明&gt;</a> -->
				</div>
				<div class="lottery-info-cutdown">
					<div id="cutdown"></div>
					<div id="residual-issue" class="residual-issue"></div>
					<p>投注截止时间</p>
					<h2>重庆时时彩</h2>
				</div>
			</div>
			<div class="lottery-info-winning-number">
				<a class="more-link" href=""><!-- <i class="mkg-game-icon"></i> -->查看走势图&gt;</a>
				<div class="winning-number-issue">
					<h3><i class="mkg-game-icon"></i>重庆时时彩近期开奖号码</h3>
				</div>
				<div class="winning-number-numbers">
					<ul id="J-lottery-balls-lasttime" >
						<li><span class="ball-num">--</span></li>
						<li><span class="ball-num">--</span></li>
						<li><span class="ball-num">--</span></li>
						<li><span class="ball-num">--</span></li>
						<li><span class="ball-num">--</span></li>
					</ul>
					<p>
						<span>第</span>
						<span id="J-header-newnum"></span>
						<span>期开奖号码</span>
					</p>
				</div>
				<table class="table">
					<thead>
						<tr>
							<th>奖期</th>
							<th>开奖号码</th>
							<th>十位</th>
							<th>个位</th>
							<th>后三</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>150106054</td>
							<td class="color-highlight">开奖中</td>
							<td>大小</td>
							<td>小单</td>
							<td>组三</td>
						</tr>
						<tr>
							<td>150106054</td>
							<td class="color-highlight">7|7|7</td>
							<td>大小</td>
							<td>小单</td>
							<td>组三</td>
						</tr>
					</tbody>
				</table>
			</div>

			<div class="lottery-winner">
				<h3><i class="mkg-game-icon"></i>最新中奖动态</h3>
				<div class="J-prize-marquee">
					<ul class="winner-marquee" id="J-prize-projects">
						<li>
							<span class="username">testop</span>
							<span class="gametype">后三组选和值</span>
							<span class="prizedesc">喜中<dfn>￥</dfn><strong class="color-highlight">1266.9200</strong></span>
						</li>
						<li><span class="username">testop</span>
							<span class="gametype">四星组选12</span>
							<span class="prizedesc">喜中<dfn>￥</dfn><strong class="color-highlight">1616.6700</strong></span>
						</li>
						<li><span class="username">testop</span>
							<span class="gametype">五星组选60</span>
							<span class="prizedesc">喜中<dfn>￥</dfn><strong class="color-highlight">3167.3500</strong></span>
						</li>
						<li><span class="username">testop</span>
							<span class="gametype">四星组选12</span>
							<span class="prizedesc">喜中<dfn>￥</dfn><strong class="color-highlight">1616.6700</strong></span>
						</li>
						<li><span class="username">testop</span>
							<span class="gametype">后二组选和值</span>
							<span class="prizedesc">喜中<dfn>￥</dfn><strong class="color-highlight">97.0000</strong></span>
						</li>
						<li><span class="username">testop</span>
							<span class="gametype">前二直选复式</span>
							<span class="prizedesc">喜中<dfn>￥</dfn><strong class="color-highlight">194.0000</strong></span>
						</li>
						<li><span class="username">testop</span>
							<span class="gametype">后三直选和值</span>
							<span class="prizedesc">喜中<dfn>￥</dfn><strong class="color-highlight">1940.0000</strong></span>
						</li>
						<li><span class="username">testop</span>
							<span class="gametype">后三直选和值</span>
							<span class="prizedesc">喜中<dfn>￥</dfn><strong class="color-highlight">1940.0000</strong></span>
						</li>
						<li><span class="username">testop</span>
							<span class="gametype">四星直选复式</span>
							<span class="prizedesc">喜中<dfn>￥</dfn><strong class="color-highlight">19400.0000</strong></span>
						</li>
						<li><span class="username">testop</span>
							<span class="gametype">后三直选复式</span>
							<span class="prizedesc">喜中<dfn>￥</dfn><strong class="color-highlight">1940.0000</strong></span>
						</li>
						<li><span class="username">testop</span>
							<span class="gametype">前二组选复式</span>
							<span class="prizedesc">喜中<dfn>￥</dfn><strong class="color-highlight">97.0000</strong></span>
						</li>
						<li><span class="username">testwc003</span>
							<span class="gametype">定位胆</span>
							<span class="prizedesc">喜中<dfn>￥</dfn><strong class="color-highlight">19.4000</strong></span>
						</li>
						<li><span class="username">testwc003</span>
							<span class="gametype">后三一码不定位</span>
							<span class="prizedesc">喜中<dfn>￥</dfn><strong class="color-highlight">6.9800</strong></span>
						</li>
						<li><span class="username">testwc004</span>
							<span class="gametype">定位胆</span>
							<span class="prizedesc">喜中<dfn>￥</dfn><strong class="color-highlight">194.0000</strong></span>
						</li>
						<li><span class="username">testwc003</span>
							<span class="gametype">后三组选包胆</span>
							<span class="prizedesc">喜中<dfn>￥</dfn><strong class="color-highlight">316.7300</strong></span>
						</li>
					</ul>
				</div>
			</div>

			<div class="lottery-my-record">
				<h3><i class="mkg-game-icon"></i>我的游戏记录</h3>
				<p>近7日累计投注总额<span class="color-highlight"><dfn>￥</dfn>2,600.00</span></p>
				<a class="more-link" href="">查看全部游戏记录&gt;</a>
				<table class="table">
					<thead>
						<tr>
							<th>奖期</th>
							<th>投注内容</th>
							<th>金额</th>
							<th>状态</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>150106054</td>
							<td>123|45|25..</td>
							<td><dfn>￥</dfn>2,000.00</td>
							<td class="color-blue">开奖中</td>
						</tr>
						<tr>
							<td>150106054</td>
							<td>123|45|25..</td>
							<td><dfn>￥</dfn>2,000.00</td>
							<td class="color-highlight">中奖</td>
						</tr>
						<tr>
							<td>150106054</td>
							<td>123|45|25..</td>
							<td><dfn>￥</dfn>2,000.00</td>
							<td>未中奖</td>
						</tr>
					</tbody>
				</table>
			</div>

		</div>
	</div>
</div>

	<?php include_once("../footer.php"); ?>


<script src="../game/simulatedata/config.js" ></script>
<!-- 实例类 -->
<script src="../js/game/ssc/dsgame.Games.SSC.Message.js" ></script>
<!-- 单例类 -->
<script src="../js/game/dsgame.GameTypes.js" ></script>
<script src="../js/game/dsgame.GameStatistics.js" ></script>
<script src="../js/game/dsgame.GameOrder.js" ></script>
<script src="../js/game/dsgame.GameTrace.js" ></script>
<script src="../js/game/dsgame.GameSubmit.js" ></script>
<!-- 额外的单式父类 -->
<script src="../js/game/ssc/dsgame.Games.SSC.Danshi.js" ></script>

<!-- 初始化页面开始 -->
<script>
(function(){
	if ($('#popWindow').length) {
		// $('#myModal').modal();
		var popWindow = new dsgame.Message();
		var data = {
			title          : '提示',
			content        : $('#popWindow').find('.pop-bd > .pop-content').html(),
			closeIsShow    : true,
			closeButtonText: '关闭',
			closeFun       : function() {
				this.hide();
			}
		};
		popWindow.show(data);
	}
})();

$('[data-dropbox]').on({
	mousedown: function(e){
		if( $(this).hasClass('open') ) return false;
		$(this).addClass('open');
		// return false;
	},
	// 点击
	click: function( e ){
		e.preventDefault();
	},
	// 失去焦点
	blur: function( e ){
		// console.log('失去焦点');
		$(this).removeClass('open');
	}
});
</script>
<!-- 初始化页面开始 -->
<script>
(function(){


	var init = function(config){
			//游戏公共访问对象
		var Games = dsgame.Games;
			//游戏实例
			dsgame.Games.SSC.getInstance({'jsNameSpace': 'dsgame.Games.SSC.'});
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

		// var GameRecords = dsgame.GameRecords.getInstance({
		// 	dom:'#J-record-panel',
		// 	iframe:'#record-iframe',
		// 	url:'/baughts/mini-window'
		// });


			//number 当前要设置的数字
			//lastNumebr 上一次的数字
			var flipCard = function(dom, number){
				var dom = $(dom),
					numDoms = dom.find('.inner');
				numDoms.eq(0).text(number);
				numDoms.eq(1).text(number);
				dom.addClass('min-left-anim');
				setTimeout(function(){
					numDoms.eq(2).text(number);
					numDoms.eq(3).text(number);
					dom.removeClass('min-left-anim');
				}, 800);
			};

			//更新界面显示内容
			var isTimeEndAlertShow = false;
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

			// RaphealJS 倒计时
			var cpoint = 45,
				r = Raphael("residual-issue", cpoint*2, cpoint*2),strokeWidth = 5,
				R = cpoint,
				initClock = true,
				param = {stroke: "#fff", "stroke-width": strokeWidth},
				marksAttr = {fill: "#444", stroke: "none"},
				txtAttr1 = {font: '16px "Helvetica Neue","Hiragino Sans GB","Microsoft Yahei",arial', fill: '#666'},
				txtAttr2 = {font: '12px "Helvetica Neue","Hiragino Sans GB","Microsoft Yahei",arial', fill: '#999'};
			// Custom Attribute
			r.customAttributes.arc = function (value, total, R) {
				var alpha = 360 / total * value,
					a = (90 - alpha) * Math.PI / 180,
					x = cpoint + R * Math.cos(a),
					y = cpoint - R * Math.sin(a),
					// color = "hsb(".concat(Math.round(R) / R, ",", value / total, ", .75)"),
					color = '#ff4200',
					path;
				if (total == value) {
					path = [["M", cpoint, cpoint - R], ["A", R, R, 0, 1, 1, R-0.01, cpoint - R]];
				} else {
					path = [["M", cpoint, cpoint - R], ["A", R, R, 0, +(alpha > 180), 1, x, y]];
				}
				return {path: path, stroke: color};
			};
			// 总期数圆环
			var ra = r.circle(cpoint, cpoint, R).attr({stroke: "none", fill: '#ebf2fa'});
			// 背景圆环
			var rc = r.circle(cpoint, cpoint, R-strokeWidth).attr({stroke: "none", fill: '#fff'});
			// 已过期数圆环
			var rr = r.path().attr(param).attr({arc: [0, cpoint, R]});
			// 剩余期数（文字）
			var rt = r.text(cpoint, cpoint, 256).attr(txtAttr1);
			// 剩余期数（描述）
			// var rd = r.text(cpoint, cpoint+20, '截止时间').attr(txtAttr2);

			function updateClockRaphael(value, total, R, hand, timeArr) {
				// var color = "hsb(".concat(Math.round(R) / R, ",", value / total, ", .75)");
				var color = '#ff4200';
				if (initClock) {
					initClock = false;
					hand.animate({arc: [value, total, R]}, 900, ">");
				} else {
					if (!value || value == total) {
						value = total;
						hand.animate({arc: [value, total, R]}, 750, "bounce", function () {
							hand.attr({arc: [0, total, R]});
						});
					} else {
						hand.animate({arc: [value, total, R]}, 750, "elastic");
					}
				}
				// rt.attr({text: timeTxt, fill: Raphael.getRGB('color').hex});
				if( parseInt(timeArr[0]) ){
					var timeTxt = parseInt(timeArr[0]) + '时' + timeArr[1] + '分' + timeArr[2] + '秒';
					rt.attr({font: '12px "Helvetica Neue","Hiragino Sans GB","Microsoft Yahei",arial', text: timeTxt, fill: color});
				}else{
					var timeTxt = timeArr[1] + '分' + timeArr[2] + '秒';
					rt.attr({font: '16px "Helvetica Neue","Hiragino Sans GB","Microsoft Yahei",arial', text: timeTxt, fill: color});
				}
			}
			// 按钮下倒计时进度条
			var $progress = $('#J-bet-countdown');
			function buttonProgressBar(part, all){
				var p = part / all * 100 + '%';
				$progress.animate({
					width: p
				});
			}

			// 更新最新开奖记录
			var updateWinRecords = function(data){
				var html = '';
				if( data ){
					$.each(data, function(i,n){
						html += '<tr><td>' + n['issue'] + '</td> <td>' + n['wn_number'] + '</td><td>' + n['offical_time'] + '</td></tr>';
					});
				}
				$('#J-last-win-number').html(html);
			}

			// 更新中奖记录
			var updatePrizeProjects = function(data){
				var html = '';
				if( data ){
					$.each(data, function(i,n){
						html += '<li><span class="username">' + n['username'] + '</span>' +
								'<span class="gametype">' + n['title'] + '</span>' +
								'<span class="prizedesc">喜中<dfn>￥</dfn><strong class="c-important">' + n['prize'] + '</strong></span></li>'
					});
				}
				$('.J-prize-marquee').replaceWith('<div class="J-prize-marquee"><ul class="winner-marquee" id="J-prize-projects">' + html + '</ul></div>');
				// 名单滚动
				marqueePrizeProjects();
			}

			// 获奖名单滚动
			function marqueePrizeProjects(){
				$('.J-prize-marquee').marquee({
					auto: true,
					interval: 1000,
					speed: 500,
					showNum: 2,
					stepLen: 1,
					type: 'vertical'
				});
			}
			marqueePrizeProjects();

			var updateView = function(){
				var cfg = Games.getCurrentGame().getGameConfig().getInstance(),
					time = cfg.getCurrentLastTime(),
					timeNow = cfg.getCurrentTime(),
					surplusTime = time - timeNow,
					alltime = surplusTime,
					timer,
					fn,
					currentNumber = '' + cfg.getCurrentGameNumber(),
					lastBalls = ('' + cfg.getLotteryBalls()).split(''),
					timeDoms = $('#J-deadline-panel').children('em'),
					buttonTimeDom = $('#J-button-btn-time');

				fn = function(){
					if(surplusTime < 0){
						timer.stop();
						Games.getCurrentGameTrace().hide();
						Games.getCurrentGameTrace().deleteTrace();
						if(isTimeEndAlertShow){
							return;
						}
						isTimeEndAlertShow = true;
						Games.getCurrentGameMessage().show({
							mask:true,
							cancelIsShow:true,
							cancelText:'保留',
							cancelFun:function(){
								var me = this;
								Games.getCurrentGame().getServerDynamicConfig(function(){
									me.hide();
								}, updateConfigError);
								isTimeEndAlertShow = false;
								initClock = true;
							},
							confirmIsShow:true,
							confirmText:'清空',
							confirmFun:function(){
								var me = this;
								Games.getCurrentGameOrder().reSet().cancelSelectOrder();
								Games.getCurrentGame().getCurrentGameMethod().reSet();
								Games.getCurrentGame().getServerDynamicConfig(function(){
									me.hide();
								}, updateConfigError);
								isTimeEndAlertShow = false;
								initClock = true;
							},
							content:'<div class="pop-waring"><i class="ico-waring"></i><h4 class="pop-text">当前期结束,进入下一期,是否清空投注项？<br />要清空投注项请点击"清空"，不需要清空请点击"保留"<br></h4></div>'
						});
						return;
					}
					var timeStrArr = [],
						h = Math.floor(surplusTime / 3600), // 小时数
						m = Math.floor(surplusTime % 3600 / 60), // 分钟数
						s = surplusTime%3600%60;
					// console.log(surplusTime,h,m,s)

					h = h < 10 ? '0' + h : '' + h;
					m = m < 10 ? '0' + m : '' + m;
					s = s < 10 ? '0' + s : '' + s;
					timeStrArr.push(h);
					timeStrArr.push(m);
					timeStrArr.push(s);

					// 更新时钟倒计时
					updateClockRaphael(surplusTime, alltime, R-strokeWidth/2, rr, timeStrArr);
					// 更新按钮下进度条
					buttonProgressBar(surplusTime, alltime);

					surplusTime--;
				};
				timer = new dsgame.Timer({time:1000, fn:fn});

				$('#J-header-currentNumber').html(currentNumber);
				var lastBallsDomStr = [];
				$.each(lastBalls, function(i){
					lastBallsDomStr[i] = '<li><span class="ball-num">' + this + '</span></li>';
				});
				$('#J-lottery-balls-lasttime').html(lastBallsDomStr.join(''));
				$('#J-header-newnum').text(cfg.getLastGameNumber());
				// updateWinRecords(cfg.getLast5Issues());
				// updatePrizeProjects(cfg.getPrizeProjects());
				// $('#J-7days-profit').html("<dfn>￥</dfn>"+cfg.get7DaysProfit());

				/**
				$('#J-lottery-balls-lasttime').find('em').each(function(i){
					var el = $(this);
					el.text(lastBalls[i]);

					//取消翻转动画
					setTimeout(function(){
						el.addClass('flip').text(lastBalls[i]);
						setTimeout(function(){
							el.removeClass('flip');
						}, 1000);
					}, i * 100);
				});
				**/
				//setPropressTime((surplusTime + 1) * 1000);
			};

			/*// 开奖结果出来后
			var lotteryBoard = new dsgame.MiniWindow({
					cls: 'w-9 lottery-board-pop',
					effectShow: boardShowFn,
					effectHide: boardHideFn
				}),
				numberErnie,
				ballErnie = [0,1,2,3,4,5,6,7,8,9],
				ballHeight = 36;
				// ballErnie = ['00','01','02','03','04','05','06','07','08','09','10','11'],
				// ballHeight = 52;
			
			function showLotteryBoard(number, ballsArr){
				lotteryBoard.setTitle('第<b>' + number + '</b>期开奖结果');
				if( !numberErnie ){
					lotteryBoard.setContent( getLotteryBoardHtml(ballsArr.length) );
					numberErnie = new dsgame.Ernie({
						dom      : $('#J-lottery-ernie-board li'),
						height   : ballHeight,
						length   : ballErnie.length,
						callback : ernieCallback
					});
				}
				lotteryBoard.show();
				numberErnie.start();
				numberErnie.stop(ballsArr);
			}
			function ernieCallback(){
				setTimeout(function(){
					lotteryBoard.hide();
					updateView();
				}, 3000);
			}
			function boardShowFn(){
				var me = this;
				me.dom.css({
					display: 'block',
					left: '50%',
					marginLeft: -me.dom.outerWidth() / 2,
					top: -me.dom.outerHeight() * 2
				}).animate({
					top: 206
				});
			}
			function boardHideFn(){
				var me = this;
				me.dom.animate({
					top: -me.dom.outerHeight() * 2
				}, function(){
					me.dom.hide();
				});
			}
			function getLotteryBoardHtml(len){
				var html = ['<ul id="J-lottery-ernie-board" class="lottery-ernie-board">'];
				// var html = ['<ul id="J-lottery-ernie-board" class="lottery-ernie-board lottery-ernie-board-double-digit">'];
				for(var i=0; i<len; i++){
					var _html = '<li>';
					$.each( ballErnie, function(i, ball){
						_html += '<span>' + ball + '</span>';
					});
					_html += '</li>'
					html.push(_html);
				}
				html.push('</ul>');
				return html.join('');
			}

			//当最新的配置信息和新的开奖号码出现后，进行界面更新
			Games.getCurrentGame().addEvent('changeDynamicConfig', function(e, cfg){
				// updateView();
				// 开奖结果出来后，弹出开奖结果
				showLotteryBoard( cfg['currentNumber'], cfg['lotteryBalls'].split('') );
			});*/
			//当最新的配置信息和新的开奖号码出现后，进行界面更新
			Games.getCurrentGame().addEvent('changeDynamicConfig', function(e, cfg){
				updateView();
			});

			// 本地测试
			// var CFG = Games.getCurrentGame().getGameConfig().getInstance();
			// showLotteryBoard(CFG.getCurrentGameNumber(), CFG.getLotteryBalls());
			// showLotteryBoard(currentNumber, ['02','08','09','10','11']);		

			//初次手动更新一次界面
			updateView();

			//玩法菜单区域的高亮处理
			Games.getCurrentGameTypes().addEvent('beforeChange', function(e, id){
				var panel = $('#J-panel-gameTypes'),dom = panel.find('[data-id="'+ id +'"]'),
					li,
					name_cn = Games.getCurrentGame().getGameConfig().getInstance().getMethodCnNameById(id),
					cls = 'current';

				if(dom.size() > 0){
					panel.find('dd').removeClass(cls).end().find('li').removeClass('hover');
					dom.addClass(cls);
					li = dom.parents('li');
					li.addClass('hover');
					dom.parents('li').addClass(cls);
					li.find('.content').show();
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


			//加载默认玩法
			Games.getCurrentGameTypes().addEvent('endShow', function() {
				this.changeMode(Games.getCurrentGame().getGameConfig().getInstance().getDefaultMethodId());
			});

			//将选球数据添加到号码篮
			//启用了动画
			$('#J-add-order').click(function(){
				var method = Games.getCurrentGame().getCurrentGameMethod(),
					bd,
					result = Games.getCurrentGameStatistics().getResultData(),
					slectedBalls = method.container.find('.ball-number-current'),
					time = 500,
					orderPanel,
					targetPos,
					copyBalls;
				if(!result['mid']){
					return;
				}

				/*if(slectedBalls.size() < 1){
					Games.getCurrentGameOrder().add(result);
				}else{
					copyBalls = slectedBalls.clone().addClass('ball-number-animation-fly');
					orderPanel = $('#J-panel-order-list-cont');
					targetPos = orderPanel.find('.game-order-current');
					targetPos = targetPos.size() > 0 ? targetPos.offset() : orderPanel.offset();

					bd = $('body');
					copyBalls.appendTo($('body'));
					copyBalls.each(function(i){
						var el = $(this),targetBall = slectedBalls.eq(i),offset = targetBall.offset();
						if(!targetBall.parent().is(':hidden')){
							el.css({left:offset.left, top:offset.top});
							el.animate({left:targetPos.left, top:targetPos.top}, time, function(){
								el.remove();
							});
						}
					});
					setTimeout(function(){
						Games.getCurrentGameOrder().add(result);
					}, time);

				}*/
				Games.getCurrentGameOrder().add(result);

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
			//设置倍数$ 模式
			Games.getCurrentGameStatistics().setMultiple(Games.getCurrentGame().getGameConfig().getInstance().getDefaultMultiple());
			Games.getCurrentGameStatistics().setMoneyUnitDom((Games.getCurrentGame().getGameConfig().getInstance().getDefaultCoefficient()));


			//设置奖金组
			var bonusGroup = Games.getCurrentGame().getGameConfig().getInstance().getOptionalPrizes();

			var bonusLength = bonusGroup.length;
			//自定义奖金组设置组件
			var slider = new dsgame.SliderBar({
				'minDom'   :'#J-slider-minDom',
				'maxDom'   :'#J-slider-maxDom',
				'contDom'  :'#J-slider-cont',
				'handleDom':'#J-slider-handle',
				'innerDom' :'#J-slider-innerbg',
				'minNumDom':'#J-slider-num-min',
				'maxNumDom':'#J-slider-num-max',
				'step'     : 1,
				'minBound' : 0,
				'maxBound' : bonusLength-1,
				'value'    : bonusLength-1
			});

			$('#J-slider-num-min').text(bonusGroup[0]['prize_group']);
			$('#J-slider-num-max').text(bonusGroup[bonusLength-1]['prize_group']);
			slider.addEvent('change', function(){
				var me = this,
					bonus = bonusGroup[me.getValue()]['prize_group'],
					rate = bonusGroup[me.getValue()]['rate'];
				setBonusDom(bonus, rate);
			});
			function setBonusDom(bonus, rate){
				rate = (rate*100).toFixed(2) +'%';
				$('#J-bonus-select-value').val(bonus);
				$('#J-slider-num-percent').text(rate);
				$('#J-bonus-select-value-show').val(bonus + '/' + rate);
			};
			setBonusDom(bonusGroup[bonusLength-1]['prize_group'],bonusGroup[bonusLength-1]['rate']);

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
				//由关闭和取消按钮触发，恢复原来号码篮原来的倍数
				Games.getCurrentGameTrace().hide();
				Games.getCurrentGameTrace().deleteTrace();
			});
			// 追号确定按钮
			// 已经将保存方案的代码移入到原始对象中实现
			// hostGameTrace.js中搜"生成追号计划事件"
			// $('#J-button-trace-confirm').click(function(){
			// 	Games.getCurrentGameTrace().applyTraceData();
			// });
			//删除追号内容
			$('#J-chase-site-trace-delete').click(function(e){
				e.preventDefault();
				Games.getCurrentGameTrace().deleteTrace();
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

				//刷新投注记录
				$("#record-iframe").attr("src",$("#record-iframe").attr("src"));
			});

	};

	init();

})();
</script>
</body>
</html>


