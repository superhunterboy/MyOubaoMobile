<!DOCTYPE HTML>
<html lang="en-US">
<head>
<meta charset="UTF-8">
<title>追号详情 -- CC彩票</title>
<link type="text/css" rel="stylesheet" href="../images/global/global.css" />
<link type="text/css" rel="stylesheet" href="../images/ucenter/ucenter.css" />

<script type="text/javascript" src="../js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="../js/dsgame.base.js"></script>

</head>

<body>

<?php include_once("../header.php"); ?>


<div class="g_33 main clearfix">
	<div class="main-sider">
		
		<?php include_once("../uc-sider.php"); ?>
		
		
	</div>
	<div class="main-content">
		<div class="nav-bg">
			<div class="title-normal">
				追号记录
			</div>
			<a id="J-button-goback" class="button-goback" href="#">返回</a>
		</div>
		
		<div class="content">
			<div class="row row-head">
				<a href="" class="row-desc c-important">返回追号记录列表></a>
				<span><strong>追号详情</strong>（D499862829F4DC3F243E69F6551BA93C）</span>
			</div>
			
			<div class="item-detail">
				<div class="item-left">
					<div class="item-title"><i class="item-icon-1"></i>游戏信息</div>
					<div class="lottery-info">
						<img src="../../userpublic/assets/images/game/logo/cqssc.png" alt="重庆时时彩" title="重庆时时彩">
						<h2>重庆时时彩</h2>
						<p class="c-gray">五星直选复式</p>
						<p class="lottery-info-number">第150106054期</p>
					</div>
				</div>
				<div class="item-right">
					<div class="item-title"><i class="item-icon-7"></i>追号清单</div>
					<div class="item-info">
						<table class="table small-table">
							<thead>
								<tr>
									<th>奖期</th>
									<th>倍数</th>
									<th>状态</th>
									<th>注单详情</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>15010605</td>
									<td>1倍</td>
									<td><span class="c-important">已投注</span></td>
									<td><a href="">查看&gt;</a></td>
								</tr>
								<tr>
									<td>15010605</td>
									<td>1倍</td>
									<td><span class="c-important">已投注</span></td>
									<td><a href="">查看&gt;</a></td>
								</tr>
								<tr>
									<td>15010605</td>
									<td>1倍</td>
									<td>等待中</td>
									<td><a href="">查看&gt;</a></td>
								</tr>
								<tr>
									<td>15010605</td>
									<td>1倍</td>
									<td>等待中</td>
									<td><a href="">查看&gt;</a></td>
								</tr>
								<tr>
									<td>15010605</td>
									<td>1倍</td>
									<td>等待中</td>
									<td><a href="">查看&gt;</a></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				<div class="item-center">
					<div class="item-title"><i class="item-icon-2"></i>追号信息</div>
					<div class="item-info">
						<p><label>追号金额</label><dfn>￥</dfn><span data-money-format>200,000.00</span></p>
						<p><label>完成金额</label><dfn>￥</dfn><span data-money-format>200,000.00</span></p>
						<p><label>取消金额</label><dfn>￥</dfn><span data-money-format>0.00</span></p>
						<p><label>货币模式</label>元</p>
						<p><label>开始期号</label>122333</p>
						<p><label>追号期数</label>100期</p>
						<p><label>完成期数</label>1期</p>
						<p><label>取消期数</label>0期</p>
						<p><label>追号状态</label><span class="ui-status-okay">已完成</span></p>
					</div>
					<div class="item-title"><i class="item-icon-4"></i>追号设置</div>
					<div class="item-info">
						<p><label>中奖后终止任务</label><span class="ui-status-okay">是</span></p>
					</div>
					<div class="item-title"><i class="item-icon-3"></i>追号号码</div>
					<div class="item-info">
						<textarea disabled="disabled" class="textarea-lotterys-detail input">0123456789|0123456789|0123456789|0123456789|0123456789</textarea>
					</div>
				</div>
			</div>
			
		</div>
		
	</div>
</div>

<?php include_once("../footer.php"); ?>

<script>
(function($){
	$('#J-button-goback').click(function(e){
		history.back(-1);
		e.preventDefault();
	});
})(jQuery);
</script>

</body>
</html>
