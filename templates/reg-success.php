<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="description" content="">
	<meta name="keywords" content="" />
	<title>注册 -- CC彩票</title>
	<link media="all" type="text/css" rel="stylesheet" href="images/global/global.css">
	<link media="all" type="text/css" rel="stylesheet" href="images/reg/reg.css">
	<script src="js/jquery-1.9.1.min.js"></script>
	<script src="js/dsgame.base.js"></script>
	<script src="js/dsgame.Mask.js"></script>
	<script src="js/dsgame.Message.js"></script>
	<script src="js/dsgame.Tip.js"></script>
</head>
<body>
	<div id="header" class="wrap">
		<div class="wrap-inner">
			<a href="/" id="logo">CC彩票</a>
			<div class="right">
				<ul class="top-account">
					<li class="contact-us">
						<a class="ui-button" href="javascript:void(0);">联系CC彩票代理</a>
						<div class="submenu">
							<a href="">代理一</a>
							<a href="">代理二</a>
							<a href="">代理三</a>
						</div>
					</li>
				</ul>
			</div>
		</div>
	</div>
	
	<div class="reg-result">
		<div class="alert alert-success">
			<i></i>
			<div class="txt">
				<h4>恭喜您，注册成功!</h4>
				<p>请妥善保管您的密码，如有问题请联系客服</p>
				<!-- <p>我们已经向您注册时填写的邮箱<b>{{ $sRegisterMail }}</b>发送了一封与CC彩票账号绑定的确认邮件，请按提示完成绑定操作！</p> -->
				<div><a class="btn btn-small" href="{{ route('signin') }}">进入CC彩票首页</a></div>
			</div>
		</div>
	</div>
	
	<?php include_once("footer.php"); ?>

</body>
</html>
