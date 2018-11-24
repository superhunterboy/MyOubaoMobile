<!DOCTYPE HTML>
<html lang="en-US">
<head>
<meta charset="UTF-8">
<title>个人资料 -- CC彩票</title>
<link type="text/css" rel="stylesheet" href="../images/global/global.css" />
<link type="text/css" rel="stylesheet" href="../images/ucenter/ucenter.css" />

<script type="text/javascript" src="../js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="../js/dsgame.base.js"></script>
<script type="text/javascript" src="../js/dsgame.Timer.js"></script>
<script type="text/javascript" src="../js/dsgame.Mask.js"></script>
<script type="text/javascript" src="../js/dsgame.Message.js"></script>

</head>

<body>

<?php include_once("../header.php"); ?>


<div class="g_33 main clearfix">
	<div class="main-sider">
		
		<?php include_once("../uc-sider.php"); ?>
		
	</div>
	<div class="main-content">
		
		<div class="nav-bg">
			<div class="title-normal">账户资料</div>
		</div>
		
		<div class="content clearfix">
			<div class="item-detail user-balance-detail">
				<div class="item-title">
					<a class="right c-important" href="/transactions">查看资金明细&gt; </a>
					<i class="item-icon-8"></i>资金信息
				</div>
				<div class="item-info">
					<div class="all-balance">
						<p>账户总余额<span class="c-green fs-25 balance-amount" data-money-format>4839934.775100</span>元</p>
					</div>
					<div class="balance-detail">
						<dl class="clearfix">
							<dt>可用余额</dt>
							<dd>
								<p><label>可提取余额</label>￥<span data-money-format>1,692,629.0000</span></p>
								<p><label>不可提取余额</label>￥<span data-money-format>1,692,629.0000</span></p>
								<p><label class="fs-12 c-black">合计</label>￥<span class="c-important" data-money-format>1,692,629.0000</span></p>
							</dd>
							<dt>不可用余额</dt>
							<dd>
								<p><label>暂时冻结余额</label>￥<span data-money-format>1,692,629.0000</span></p>
								<p><label class="fs-12 c-black">合计</label>￥<span class="c-important" data-money-format>1,692,629.0000</span></p>
							</dd>
						</dl>
					</div>
				</div>
			</div>

			<div class="item-detail user-info-detail">
				<div class="item-title">
					<i class="item-icon-10"></i>个人资料
				</div>
				<div class="item-info">
					<p>
						<label>账户名</label>
						testop
					</p>
					<p>
						<label>昵称</label>
						风起云涌&nbsp;&nbsp;<a href="/users/personal">修改</a>
					</p>
					<p>
						<label>当前奖金组</label>
						1940&nbsp;&nbsp;<a href="/prize-sets/game-prize-set">查看</a>
					</p>
					<p>
						<label>邮箱</label>
						未绑定&nbsp;&nbsp;<a href="/users/bind-email" title="立即绑定">立即绑定</a>
					</p>
					<p>
						<label>站内信</label>
						<a href="/users/bind-email" title="查看站内信">查看站内信</a>
					</p>
					<p>
						<label>注册时间</label>
						2014-11-28 00:16:25
					</p>
					<p>
						<label>上次登陆</label>
						2015-04-06 15:27:32
					</p>
					<p>
						<label>访问IP</label>
						234.1.42.136 广东省广州市天河区
					</p>
				</div>
			</div>
			<div class="item-detail user-safety-detail">
				<div class="item-title">
					<i class="item-icon-12"></i>账户安全
				</div>
				<div class="item-info">
					<p>
						<label>登陆密码</label>
						<a href="/users/password-management">修改登陆密码</a>
					</p>
					<p>
						<label>资金密码</label>
						未设置&nbsp;&nbsp;<a href="/users/password-management">设置资金密码</a>  OR
						<a href="/users/password-management">修改资金密码</a>
					</p>
				</div>
			</div>

			<div class="item-detail agent-limit-detail">
				<div class="item-title">
					<i class="item-icon-4"></i>开户配额
				</div>
				<div class="item-info">
					<table class="table table-info" style="border:1px solid #eaeaea;width:auto;">
						<tr>
							<th style="width:80px;" class="text-center">奖金组</th>
							<td style="width:50px;" class="text-center">1950</td>
							<td style="width:50px;" class="text-center">1951</td>
							<td style="width:50px;" class="text-center">1952</td>
							<td style="width:50px;" class="text-center">1953</td>
							<td style="width:50px;" class="text-center">1954</td>
							<td style="width:50px;" class="text-center">1955</td>
							<td style="width:50px;" class="text-center">1956</td>
						</tr>
						<tr >
							<th class="text-center">配额</th>
							<td class="text-center"><span class="c-important">123</span></td>
							<td class="text-center"><span class="c-important">232</span></td>
							<td class="text-center"><span class="c-important">43</span></td>
							<td class="text-center"><span class="c-important">234</span></td>
							<td class="text-center"><span class="c-important">32</span></td>
							<td class="text-center"><span class="c-important">43</span></td>
							<td class="text-center"><span class="c-important">22</span></td>
						</tr>
					</table>
				</div>
			</div>

		</div>
	</div>
</div>


<?php include_once("../footer.php"); ?>


<script>
(function($){
	
	$('#J-button-submit').click(function(){
		var v = $.trim($('#J-input-nickname').val());
		if(v.length < 2 || v.length > 6){
			alert('昵称必须由2至6个字符组成，请重新输入');
			$('#J-input-nickname').focus();
			return false;
		}
		return true;
	});
	
})(jQuery);
</script>






</body>
</html>
















