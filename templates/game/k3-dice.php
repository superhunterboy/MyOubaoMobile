<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<title>骰宝</title>
<link rel="stylesheet" href="../images/global/global.css" />
<link rel="stylesheet" href="../images/game/k3-dice/jquery.jscrollpane.css">
<link rel="stylesheet" href="../images/game/k3-dice/game.css">

<script src="../js/jquery-1.9.1.min.js"></script>
<!-- <script src="../js/jquery-migrate-1.1.0.min.js"></script> -->
<script src="../js/jquery.tmpl.min.js"></script>
<script src="../js/jquery.jscrollpane.min.js"></script>
<script src="../js/dsgame.base.js"></script>
<script src="../js/dsgame.Tab.js"></script>
<script src="../js/dsgame.Hover.js"></script>
<script src="../js/dsgame.Select.js"></script>
<script src="../js/dsgame.Countdown.js"></script>
<script src="../js/dsgame.Timer.js"></script>
<script src="../js/dsgame.Mask.js"></script>
<script src="../js/dsgame.MiniWindow.js"></script>
<script src="../js/dsgame.Tip.js"></script>
<script src="../js/global.js"></script>

<script src="../js/game/k3-dice/config.js"></script>

</head>
<body>



<div class="main">

	<div class="dice-wrap">

		<div class="dice-panel">
			<div class="logo">江苏快三</div>
			<div class="shortcuts">
				<a href="">游戏规则</a>
				<a href="">切换到基础版</a>
			</div>
			<div class="lottery-info-number">
				<span id="J-lottery-info-number">-</span>期
			</div>
			<div class="lottery-status">
				<div class="soldout">停售中</div>
				<div class="lottery-countdown" id="J-lottery-countdown">
					<span data-time="m1" class="time-0"></span>
					<span data-time="m2" class="time-0"></span>
					<span class="time-colon"></span>
					<span data-time="s1" class="time-0"></span>
					<span data-time="s2" class="time-0"></span>
				</div>
			</div>
			<div class="lottery-number" id="J-lottery-info-balls">
				<span></span>
				<span></span>
				<span></span>
			</div>
			<div class="lottery-records">
				<div class="record-top">
					<a href="">查看更多</a>
					<strong>开奖记录</strong>
				</div>
				<div class="record-content scroll-pane">
					<ul id="J-lottery-records">
						<li>
							<div class="rec1">
								<span class="dice-number dice-number-1">1</span>
								<span class="dice-number dice-number-3">3</span>
								<span class="dice-number dice-number-5">5</span>
							</div>
							<div class="rec2">15</div>
							<div class="rec3">大</div>
							<div class="rec4">单</div>
							<div class="rec5">045期</div>
						</li>
						<li>
							<div class="rec1">
								<span class="dice-number dice-number-1">1</span>
								<span class="dice-number dice-number-3">3</span>
								<span class="dice-number dice-number-5">5</span>
							</div>
							<div class="rec2">15</div>
							<div class="rec3">大</div>
							<div class="rec4">单</div>
							<div class="rec5">045期</div>
						</li>
						<li>
							<div class="rec1">
								<span class="dice-number dice-number-1">1</span>
								<span class="dice-number dice-number-3">3</span>
								<span class="dice-number dice-number-5">5</span>
							</div>
							<div class="rec2">15</div>
							<div class="rec3">大</div>
							<div class="rec4">单</div>
							<div class="rec5">045期</div>
						</li>
						<li>
							<div class="rec1">
								<span class="dice-number dice-number-1">1</span>
								<span class="dice-number dice-number-3">3</span>
								<span class="dice-number dice-number-5">5</span>
							</div>
							<div class="rec2">15</div>
							<div class="rec3">大</div>
							<div class="rec4">单</div>
							<div class="rec5">045期</div>
						</li>
						<li>
							<div class="rec1">
								<span class="dice-number dice-number-1">1</span>
								<span class="dice-number dice-number-3">3</span>
								<span class="dice-number dice-number-5">5</span>
							</div>
							<div class="rec2">15</div>
							<div class="rec3">大</div>
							<div class="rec4">单</div>
							<div class="rec5">045期</div>
						</li>
						<li>
							<div class="rec1">
								<span class="dice-number dice-number-1">1</span>
								<span class="dice-number dice-number-3">3</span>
								<span class="dice-number dice-number-5">5</span>
							</div>
							<div class="rec2">15</div>
							<div class="rec3">大</div>
							<div class="rec4">单</div>
							<div class="rec5">045期</div>
						</li>
					</ul>
				</div>
			</div>
		</div>

		<!-- <div class="lottery-notice">
			<p>凤凰娱乐平台小天使温馨提醒您，由于网银维护，平台将暂停以下时间部分银行的充值、提款服务</p>
			<span class="notice-close">&times;</span>
		</div> -->

		<div id="J-dice-sheet" class="dice-table"></div>

		<div class="dice-recycle"></div>

	</div>

</div>

<div class="dice-ctrl">
	<div class="dice-bar-wrap">
		<div id="J-dice-bar" class="dice-bar"></div>
	</div>
	<div class="game-history-wrap">
		<div class="game-history">
			<div class="history-top">
				<a class="history-more">查看更多</a>
				<span class="history-close">&times;</span>
			</div>
			<div class="history-content">
				<ul class="program-chase-list program-chase-list-header">
					<li>
						<div class="cell1">方案编号</div>
						<div class="cell2">期号</div>
						<div class="cell3">投单时间</div>
						<div class="cell4">投注金额（元）</div>
						<div class="cell5">开奖号码</div>
						<div class="cell6">中奖状态</div>
						<div class="cell7">投注内容</div>
					</li>
				</ul>
				<ul class="program-chase-list program-chase-list-body" data-simulation="gameHistory">
					<li>
						<div class="cell1" data-history-project="DCDSGSGDFHGDFHFDK">DCDSGSGDFHGDFHFDK</div>
						<div class="cell2">20150112-023</div>
						<div class="cell3">2014-04-20 11:44:55</div>
						<div class="cell4"><dfn>¥</dfn>30000000.00</div>
						<div class="cell5" data-history-balls>
							<span class="dice-number dice-number-1">1</span>
							<span class="dice-number dice-number-3">3</span>
							<span class="dice-number dice-number-5">5</span>
						</div>
						<div class="cell6" data-history-result>未中奖</div>
						<div class="cell7">
							<a href="xxx.php?DCDSGSGDFHGDFHFDG" target="_blank">投注详情</a>
						</div>
					</li>
					<li>
						<div class="cell1" data-history-project="DCDSGSGDFHGDFHFDG">DCDSGSGDFHGDFHFDG</div>
						<div class="cell2">20150112-023</div>
						<div class="cell3">2014-04-20 11:44:55</div>
						<div class="cell4"><dfn>¥</dfn>30000000.00</div>
						<div class="cell5" data-history-balls>
							<span class="dice-number dice-number-1">1</span>
							<span class="dice-number dice-number-3">3</span>
							<span class="dice-number dice-number-5">5</span>
						</div>
						<div class="cell6" data-history-result>未中奖</div>
						<div class="cell7">
							<a href="xxx.php?DCDSGSGDFHGDFHFDG" target="_blank">投注详情</a>
						</div>
					</li>
					<li>
						<div class="cell1" data-history-project="DCDSGSGDFHGDFHFDG">DCDSGSGDFHGDFHFDG</div>
						<div class="cell2">20150112-023</div>
						<div class="cell3">2014-04-20 11:44:55</div>
						<div class="cell4"><dfn>¥</dfn>30000000.00</div>
						<div class="cell5" data-history-balls>
							<span class="dice-number dice-number-1">1</span>
							<span class="dice-number dice-number-3">3</span>
							<span class="dice-number dice-number-5">5</span>
						</div>
						<div class="cell6" data-history-result>未中奖</div>
						<div class="cell7">
							<a href="xxx.php?DCDSGSGDFHGDFHFDG" target="_blank">投注详情</a>
						</div>
					</li>
					<li>
						<div class="cell1" data-history-project="DCDSGSGDFHGDFHFDG">DCDSGSGDFHGDFHFDG</div>
						<div class="cell2">20150112-023</div>
						<div class="cell3">2014-04-20 11:44:55</div>
						<div class="cell4"><dfn>¥</dfn>30000000.00</div>
						<div class="cell5" data-history-balls>
							<span class="dice-number dice-number-1">1</span>
							<span class="dice-number dice-number-3">3</span>
							<span class="dice-number dice-number-5">5</span>
						</div>
						<div class="cell6" data-history-result>
							<span class="price"><dfn>¥</dfn>300.00</span>
						</div>
						<div class="cell7">
							<a href="xxx.php?DCDSGSGDFHGDFHFDG" target="_blank">投注详情</a>
						</div>
					</li>
				</ul>
			</div>
		</div>
	</div>
</div>




<script src="../js/game/dsgame.GameMessage.js"></script>
<!-- <script src="js/game/k3-dice/k3-GameMessage.js"></script> -->
<script src="../js/game/k3-dice/dsgame.Games.K3dice.config.js"></script>

<script src="../js/jquery.longclick.min.js"></script>
<script src="../js/jquery-ui-custom.min.js"></script>
<script src="../js/game/k3-dice/dsgame.Games.K3dice.utils.js"></script>
<script src="../js/game/k3-dice/dsgame.Games.K3dice.js"></script>
<script src="../js/game/k3-dice/dsgame.Games.K3dice.init.js"></script>
</body>
</html>