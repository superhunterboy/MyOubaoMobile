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
	<script src="../js/global.js"></script>
	<!-- Games命名空间 -->
	<script src="../js/game/dsgame.Games.js"></script>
	<!-- 游戏父类 -->
	<script src="../js/game/dsgame.Game.js"></script>
	<script src="../js/game/dsgame.GameMethod.js"></script>
	<script src="../js/game/dsgame.GameMessage.js"></script>
	<script src="../js/game/ssc/dsgame.Games.SSC.js"></script>

</head>
<body>

<?php include_once("../header.php"); ?>

<div class="main-content wrap">
	<div class="wrap-inner clearfix">

		<div id="aside" class="right">
			<div class="user-info">
				<h2>施主</h2>
				<p><small>账户余额：</small></p>
				<p class="user-balance" id="J-user-balance">
					<span data-user-account-balance>989,899,000.0000</span>
					<span>元</span>
					<i data-refresh-balance>Refresh</i>
				</p>
				<p>
					<a href="" class="ui-button">立即充值</a>
				</p>
			</div>
			<!-- <div class="game-nav">
				<ul>
					<li><a href="">重庆时时彩</a></li>
					<li><a href="">江西时时彩</a></li>
					<li><a href="">黑龙江时时彩</a></li>
					<li><a href="">天津时时彩</a></li>
					<li><a href="">新疆时时彩</a></li>
				</ul>
			</div> -->
			<div class="bet-trend" id="J-minitrend-cont">
				<table class="table bet-table-trend" id="J-minitrend-trendtable-112">
					<thead>
						<tr>
							<th><span class="number">奖期</span></th>
							<th><span class="balls">开奖</span></th>
							<th><span>和值</span></th>
						</tr>
					</thead>
					<tbody>
						<tr class="first">
							<td><span class="number">052213 期</span></td>
							<td><span class="balls"><i>02</i><i>05</i><i class="curr">11</i><i class="curr">08</i><i class="curr">09</i></span></td>
							<td>19</td>
						</tr>
						<tr class="">
							<td><span class="number">052212 期</span></td>
							<td><span class="balls"><i>10</i><i>08</i><i class="curr">07</i><i class="curr">11</i><i class="curr">02</i></span></td>
							<td>19</td>
						</tr>
						<tr class="">
							<td><span class="number">052211 期</span></td>
							<td><span class="balls"><i>08</i><i>06</i><i class="curr">09</i><i class="curr">02</i><i class="curr">01</i></span></td>
							<td>19</td>
						</tr>
						<tr class="">
							<td><span class="number">052210 期</span></td>
							<td><span class="balls"><i>08</i><i>04</i><i class="curr">07</i><i class="curr">11</i><i class="curr">06</i></span></td>
							<td>19</td>
						</tr>
						<tr class="last">
							<td><span class="number">052209 期</span></td>
							<td><span class="balls"><i>03</i><i>06</i><i class="curr">05</i><i class="curr">01</i><i class="curr">08</i></span></td>
							<td>19</td>
						</tr>
					</tbody>
				</table>
				<p class="text-right more">
					<a href="">查看完整走势</a>
				</p>
			</div>
			<div class="events-list">
				<h2>最新热门活动</h2>
				<ul>
					<li><a href="">充多少送多少，奖金您做主</a></li>
					<li><a href="">充多少送多少，奖金您做主</a></li>
					<li><a href="">充多少送多少，奖金您做主</a></li>
				</ul>
			</div>
		</div>
		<div id="content" class="left">
			<div class="game-info">
				<div class="lottery-info-basic">
					<div class="lottery-info-logo">
						<img src="../images/game/logo/cqssc.png" alt="重庆时时彩" title="重庆时时彩">
					</div>
					<div class="lottery-info-issue-box">
						<span>第</span>
						<span id="J-header-currentNumber">------</span>
						<span>期</span>
					</div>
				</div>

				<div class="lottery-countdown J-lottery-countdown">
					<ul>
						<li class="countdown-hour">
							<i>时</i>
							<em>00</em>
						</li>
						<li class="countdown-minute">
							<i>分</i>
							<em>21</em>
						</li>
						<li class="countdown-second">
							<i>秒</i>
							<em>48</em>
						</li>
					</ul>
				</div>
				<div class="lottery-board css-flip css-flip-x">
					<div class="lottery-issue-board flip-front">
						<div id="J-lottery-numbers">
						</div>
					</div>
					<div class="lottery-numbers-board flip-back" id="lottery-numbers-board"></div>
					<a href="javascript:;" class="switch-board J-switch-board">切换</a>
				</div>

			</div>

			<!-- 投注选号区 -->
			<div class="game-board">
				<div class="play-section">
					<div class="section-label"><span>玩法</span></div>
					<div class="section-inner">
						<div class="play-select">
							<ul class="play-select-title clearfix" id="J-panel-gameTypes"></ul>
							<ul class="gametypes-menu-ul" id="J-gametyes-menu-panel"></ul>
						</div>
					</div>
				</div>

				<!-- 选球统计开始 -->
				<div class="number-section">
					<div class="section-label"><span>选择幸运号码</span></div>
					<div class="section-inner">
						<div class="game-method-prize">单注最低奖金<span class="c-highlight" id="J-method-prize">0.00</span>元</div>
						<div id="J-balls-main-panel" class="number-section-balls-main-panel">


						</div>
						<div id="J-balls-statistics-panel">

							<ul class="bet-statistics clearfix">
								<li class="choose-btn right">
									<button type="button" id="J-add-order" class="ui-button"><i></i><span>选好了</span></button>
								</li>
								<li class="moneyunit-choose">
									<select id="J-balls-statistics-moneyUnit" style="display: none;">
										<option value="1.000">2元</option>
										<option value="0.500">1元</option>
										<option value="0.100">2角</option>
										<option value="0.050">1角</option>
										<option value="0.010">2分</option>
										<option value="0.001">2厘</option>
									</select>
									<div class="filter-tabs-cont" id="J-balls-statistics-moneyUnit-trigger">
										<a href="javacript:;" data-value="1.000">2元</a>
										<a href="javacript:;" data-value="0.500">1元</a>
										<a href="javacript:;" data-value="0.100">2角</a>
										<a href="javacript:;" data-value="0.050">1角</a>
										<a href="javacript:;" data-value="0.010">2分</a>
										<a href="javacript:;" data-value="0.001">2厘</a>
									</div>
								</li>
								<!-- 设置奖金组及返点-->
								<li class="bonus-choose">
									<div class="slider-range J-prize-group-slider" onselectstart="return false;" data-slider-step="1">
				                        <div class="slider-range-scale">
				                        	<span>返点</span>
				                            <span class="small-number" data-slider-min></span>
				                            <span class="percent-number" data-slider-percent>0%</span>
				                            <span class="big-number" data-slider-max></span>
				                        </div>
										<div class="right">
				                        	<span class="slider-current-value" data-slider-value></span>
                    						<span>奖金</span>
				                        </div>
				                        <div class="slider-action">
				                            <div class="slider-range-sub" data-slider-sub>-</div>
				                            <div class="slider-range-add" data-slider-add>+</div>
				                            <div class="slider-range-wrapper" data-slider-cont>
				                                <div class="slider-range-inner" data-slider-inner></div>
				                                <div class="slider-range-btn" data-slider-handle></div>
				                            </div>
				                        </div>
                    				</div>
									<input id="J-bonus-select-value" type="hidden" value="1956">
								</li>
								<li class="multiple-choose">
									<span>倍数</span>
									<select id="J-balls-statistics-multiple" style="display:none;">
										<option value="1">1</option>
										<option value="5">5</option>
										<option value="10">10</option>
									</select>
									<span id="J-balls-statistics-multiple-text" class="game-statistics-multiple-text">1</span>
								</li>
								<li class="choose-bet">
									<span>您选择了</span>
									<em id="J-balls-statistics-lotteryNum">0</em>
									<span>注,</span>
									<em id="J-balls-statistics-multipleNum">0</em>
									<span>倍，返还</span>
									<em id="J-balls-statistics-rebate">0.00</em>
									<span>元，共投注</span>
									<em id="J-balls-statistics-amount">0.00</em>
									<span>元</span>
								</li>
							</ul>

						</div>
					</div>
				</div>

				<div class="panel-section">
					<div class="section-label"><span>号码篮</span></div>
					<div class="section-right">
						<div class="bet-statistics">
							<div class="bet-subtotal bet-subtotal-rebate text-right">
								<label>返点总金额</label>
								共<em id="J-rebate-amount">0.00</em>元
							</div>
							<div class="bet-subtotal text-right">
								<label>投注总金额</label>
								<em id="J-gameOrder-lotterys-num">0</em>注，共<em id="J-gameOrder-amount">0.00</em>元
							</div>
						</div>
						<div class="submit-panel">
							<button type="button" id="J-trace-switch" class="ui-button btn-bet-disable">追号投注</button>
							<button type="button" id="J-submit-order" class="ui-button btn-bet-disable">确认投注</button>
						</div>
					</div>
					<div class="section-inner">
						<div class="panel-select">
							<div class="panel-order-list-cont" id="J-panel-order-list-cont">
								<ul id="J-balls-order-container">

								</ul>
							</div>
							<div class="J-cart-empty cart-empty">大爷，选几个幸运号码来一发嘛，伦家还等着您中奖呢～</div>
						</div>

					</div>
				</div>

				<div class="game-record-section">
					<ul class="tabs clearfix">
						<li><a href="javascript:;">游戏记录</a></li>
						<li><a href="javascript:;">追号记录</a></li>
						<li><a href="javascript:;">资金明细</a></li>
					</ul>
					<div class="record-content">
						<div class="tab-panel">
							<table class="table">
								<thead>
									<tr>
										<th>玩法</th>
										<th>奖期</th>
										<th>方案</th>
										<th>模式</th>
										<th>倍数</th>
										<th>投注金额(元)</th>
										<th>中奖状态</th>
										<th>操作</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>五星直选复式</td>
										<td>0407-089</td>
										<td>12345|13546|23525|11255|15...</td>
										<td>元</td>
										<td>1</td>
										<td>7,000,000.0000</td>
										<td>中奖<br><span class="c-important">+18,561,980.0000</span></td>
										<td><a href="">详细</a></td>
									</tr>
									<tr>
										<td>五星直选复式</td>
										<td>0407-089</td>
										<td>12345|13546|23525|11255|15...</td>
										<td>元</td>
										<td>1</td>
										<td>7,000,000.0000</td>
										<td>中奖<br><span class="c-important">+18,561,980.0000</span></td>
										<td><a href="">详细</a></td>
									</tr>
									<tr>
										<td>五星直选复式</td>
										<td>0407-089</td>
										<td>12345|13546|23525|11255|15...</td>
										<td>元</td>
										<td>1</td>
										<td>7,000,000.0000</td>
										<td>未中奖</td>
										<td><a href="">详细</a></td>
									</tr>
									<tr>
										<td>五星直选复式</td>
										<td>0407-089</td>
										<td>12345|13546|23525|11255|15...</td>
										<td>元</td>
										<td>1</td>
										<td>7,000,000.0000</td>
										<td>中奖<br><span class="c-important">+18,561,980.0000</span></td>
										<td><a href="">详细</a></td>
									</tr>
									<tr>
										<td>五星直选复式</td>
										<td>0407-089</td>
										<td>12345|13546|23525|11255|15...</td>
										<td>元</td>
										<td>1</td>
										<td>7,000,000.0000</td>
										<td>中奖<br><span class="c-important">+18,561,980.0000</span></td>
										<td><a href="">详细</a></td>
									</tr>
								</tbody>
							</table>
						</div>

						<div class="tab-panel">
							<div class="no-data">No Data!</div>
						</div>

						<div class="tab-panel">
							<div class="no-data">No Data!</div>
						</div>
					</div>
				</div>

			</div>

		</div>

	</div>
</div>

<?php include_once("../footer.php"); ?>

<div class="j-ui-miniwindow pop pop-panel-trace trace-panel" id="J-trace-panel">
	<div class="trace-radio pop-hd">
		<i class="pop-close closeBtn"></i>
		<h2>追号投注</h2>
		<div class="trace-tabs">
			<!-- <label><strong>购买方式：</strong></label>
			<a href="javascript:void(0);" data-value="notrace"><i class="mkg-game-icon"></i>常规购买</a> -->
			<a href="javascript:void(0);" data-value="tongbei">同倍追号</a>
			<a href="javascript:void(0);" data-value="lirunlv">利润率追号</a>
			<a href="javascript:void(0);" data-value="fanbei">翻倍追号</a>
		</div>
	</div>
	<div class="trace-content">
		<div class="chase-tab">
			<!-- <div class="chase-tab-title clearfix">
				<ul class="clearfix">
					<li class="chase-tab-t">同倍追号</li>
					<li class="chase-tab-t">利润率追号</li>
					<li class="chase-tab-t">翻倍追号</li>
				</ul>
			</div> -->

			<!-- 没有追号 -->
			<!-- <div class="chase-tab-content"></div> -->

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
								<th class="text-center">序号</th>
								<th><input type="checkbox" checked="checked" class="checkbox" data-action="checkedAll">追号期次</th>
								<th>倍数</th>
								<th>金额</th>
								<th>预计开奖时间</th>
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
								<th class="text-center">序号</th>
								<th><input type="checkbox" checked="checked" class="checkbox" data-action="checkedAll">追号期次</th>
								<th>倍数</th>
								<th>金额</th>
								<th>预计开奖时间</th>
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

		<div class="bet-statistics">
			<table class="table">
				<th><span id="J-trace-statistics-times">0</span><br>期数</th>
				<th><span id="J-trace-statistics-lotterys-num">0</span><br>注数</th>
				<th><span id="J-trace-statistics-amount">0.00</span><br>追号方案总金额(元)</th>
				<th><span id="J-trace-statistics-balance">0.00</span><br>账户可用余额(元)</th>
				<th><span id="J-trace-statistics-countdown">00:01:35</span><br>本期投注截止</th>
			</table>
		</div>

		<div class="pop-btn">
			<a href="javascript:void(0);" class="btn btn-submit disable" id="J-button-trace-confirm">确认追号投注</a>
			<div class="trace-switch-label">
				<div class="chase-stop" id="J-trace-iswintimesstop-panel">
					<label class="label">
						<input type="checkbox" class="checkbox" id="J-trace-iswintimesstop" checked="checked">
						<span>中奖后停止追号</span>
					</label>
					<input type="text" value="1" class="input" id="J-trace-iswintimesstop-times" style="display:none;">&nbsp;
					<i id="J-trace-iswintimesstop-hover" class="icon-question" style="display:none;">
						玩法提示
						<div class="chase-stop-tip" id="chase-stop-tip-1">
							当追号计划中，一个方案内的任意注单中奖时，即停止继续追号。<br>
							如果您希望考虑追号的实际盈利，<a id="J-chase-stop-switch-1" href="#">点这里</a>。
						</div>
					</i>
				</div>
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
			</div>
		</div>
	</div>

</div>

<script src="../game/simulatedata/config.js"></script>
<!-- 实例类 -->
<script src="../js/game/ssc/dsgame.Games.SSC.Message.js"></script>
<!-- 单例类 -->
<script src="../js/game/dsgame.GameTypes.js"></script>
<script src="../js/game/dsgame.GameStatistics.js"></script>
<script src="../js/game/dsgame.GameOrder.js"></script>
<script src="../js/game/dsgame.GameTrace.js"></script>
<script src="../js/game/dsgame.GameSubmit.js"></script>
<!-- 额外的单式父类 -->
<script src="../js/game/ssc/dsgame.Games.SSC.Danshi.js"></script>

<!-- 初始化页面开始 -->
<script src="../js/game/ssc/init.js"></script>
</body>
</html>


