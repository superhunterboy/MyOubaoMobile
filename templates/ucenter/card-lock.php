<!DOCTYPE HTML>
<html lang="en-US">
<head>
<meta charset="UTF-8">
<title>锁定银行卡 -- CC彩票</title>
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
			<div class="title-normal">锁定银行卡</div>
		</div>
		
		<div class="content">
			<div class="prompt-text">
				为了账户的资金安全，建议锁定银行卡信息。<br>
				锁定后不能增加新卡绑定，已绑定的银行信息不能进行修改和删除。
			</div>
			<form action="?">
			<table width="100%" class="table-field">
				<tr>
					<td align="right">已绑卡1：</td>
					<td>中国农业银行 -- **** **** **** 0000</td>
				</tr>
				<tr>
					<td align="right">已绑卡2：</td>
					<td>中国农业银行 -- **** **** **** 0000</td>
				</tr>
				<tr>
					<td align="right">资金密码：</td>
					<td>
						<input type="password" class="input w-2" id="J-input-password" />
					</td>
				</tr>
				<tr>
					<td align="right"></td>
					<td>
						<input type="submit" value="提交锁定" class="btn" id="J-submit">
						<input type="button" value="返 回" class="btn btn-normal" id="J-button-back">
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
		$('#J-submit').click(function(){
			var password = $('#J-input-password'),v = $.trim(password.val());
			if(v == ''){
				alert('资金密码不能为空');
				password.focus();
				return false;
			}
			return true;
		});
		
		
		$('#J-button-back').click(function(){
			history.back(-1);
		});
			
	})(jQuery);
</script>




</body>
</html>
