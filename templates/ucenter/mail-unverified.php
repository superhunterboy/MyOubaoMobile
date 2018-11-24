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
			<form action="mail-verified.php" id="J-form">
			<table width="100%" class="table-field">
				<tr>
					<td align="right">您的邮箱：</td>
					<td>
						<input type="text" class="input w-4" id="J-input-mail">
						<span class="ui-text-prompt">示例：abc@163.com</span>
					</td>
				</tr>
				<tr>
					<td align="right"></td>
					<td>
						<input type="submit" value="立即验证" class="btn" id="J-submit">
					</td>
				</tr>
			</table>
			</form>
		</div>
	</div>
</div>

<?php include_once("../footer.php"); ?>

<script>
(function($){
	var mail = $('#J-input-mail');
	
	$('#J-submit').click(function(){
		var mailv = $.trim(mail.val());
		if(!(/\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/).test(mailv)){
			alert('邮箱格式填写不正确');
			mail.focus();
			return false;
		}
		return true;
	});
	
	
})(jQuery);
</script>



</body>
</html>







