<!DOCTYPE HTML>
<html lang="en-US">
<head>
<meta charset="UTF-8">
<title>邮箱管理 -- CC彩票</title>
<link type="text/css" rel="stylesheet" href="../images/global/global.css" />
<link type="text/css" rel="stylesheet" href="../images/ucenter/ucenter.css" />

<script type="text/javascript" src="../js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="../js/dsgame.base.js"></script>
<script type="text/javascript" src="../js/dsgame.Select.js"></script>

</head>

<body>

<?php include_once("../header.php"); ?>


<div class="g_33 main clearfix">
	<div class="main-sider">
		
		<?php include_once("../uc-sider.php"); ?>
		
	</div>
	<div class="main-content">
		
		<div class="nav-bg">
			<div class="title-normal">邮箱管理</div>
		</div>
		
		<div class="content">
			<div class="alert alert-error">
				<i></i>
				<div class="txt">
					<h4>验证失败，邮件激活链接已过期。</h4>
					<div><a class="btn btn-small" href="#">重新绑定</a></div>
				</div>
			</div>
			<div class="alert alert-error">
				<i></i>
				<div class="txt">
					<h4>您已经激活成功过了，无需重复激活。</h4>
					<div><a class="btn btn-small" href="#">重新绑定</a></div>
				</div>
			</div>
			<div class="alert alert-error">
				<i></i>
				<div class="txt">
					<h4>验证失败，请重试。</h4>
					<div><a class="btn btn-small" href="#">重新绑定</a></div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php include_once("../footer.php"); ?>
</body>
</html>
