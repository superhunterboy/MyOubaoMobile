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
			<table width="100%" class="table-field">
				<tr>
					<td align="right"></td>
					<td>
						已经向您的邮箱：tere*******@qq.com发送了一封确认绑定邮件，请前往查看并按提示完成绑定！<br />
						<span class="ui-prompt">（您的激活链接在24小时内有效）</span>
					</td>
				</tr>
				<tr>
					<td align="right"></td>
					<td>
						<input type="button" value="没收到邮件？重新发送" class="btn">
					</td>
				</tr>
			</table>
			<table width="100%" class="table-field">
				<tr>
					<td align="right"></td>
					<td>
						已经向您的邮箱：tere*******@qq.com发送了一封确认绑定邮件，请前往查看并按提示完成绑定！<br />
						<span class="ui-prompt">（您的激活链接在24小时内有效）</span>
					</td>
				</tr>
				<tr>
					<td align="right"></td>
					<td>
						<input type="hidden" id="J-time-num" value="10" />
						<input id="J-button-disabled" type="button" value="59 秒后可重新发送" class="btn btn-disabled">
					</td>
				</tr>
			</table>
		</div>
	</div>
</div>

<?php include_once("../footer.php"); ?>
<script>
(function($){
	var num = Number($('#J-time-num').val()),
		button = $('#J-button-disabled'),
		timer = setInterval(function(){
			if(num <= 0){
				clearInterval(timer);
				button.val('没收到邮件？重新发送');
				button.removeClass('btn-disabled');
				return;
			}
			num--;
			button.val(num + ' 秒后可重新发送');
		}, 1000);
})(jQuery);
</script>

</body>
</html>
