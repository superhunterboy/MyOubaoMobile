<!DOCTYPE HTML>
<html lang="en-US">
<head>
<meta charset="UTF-8">
<title>提现确认 -- CC彩票</title>
<link type="text/css" rel="stylesheet" href="../images/global/global.css" />
<link type="text/css" rel="stylesheet" href="../images/ucenter/ucenter.css" />

<script type="text/javascript" src="../js/jquery-1.9.1.min.js"></script>


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
				提现确认
			</div>
		</div>
		
		<div class="content recharge-confirm recharge-netbank">
			<form action="?" method="post" id="J-form">
			<table width="100%" class="table-field">
				<tr>
					<td width="50%" align="right" valign="top"><span class="field-name">用户名：</span></td>
					<td>
						wahaha
					</td>
				</tr>
				<tr>
					<td align="right" valign="top"><span class="field-name">可用提现余额：</span></td>
					<td>
						1200.00 元
					</td>
				</tr>
				<tr>
					<td align="right" valign="top"><span class="field-name">本次提现金额：</span></td>
					<td>
						1200.00 元
					</td>
				</tr>
				<tr>
					<td align="right" valign="top"><span class="field-name">开户银行：</span></td>
					<td>
						中国工商银行
					</td>
				</tr>
				<tr>
					<td align="right" valign="top"><span class="field-name">开户地址：</span></td>
					<td>
						广东 广州
					</td>
				</tr>
				<tr>
					<td align="right" valign="top"><span class="field-name">开户人：</span></td>
					<td>
						张振兴
					</td>
				</tr>
				<tr>
					<td align="right" valign="top"><span class="field-name">提现银行卡号：</span></td>
					<td>
						**** **** **** 1448
					</td>
				</tr>
				<tr>
					<td colspan="2">&nbsp;</td>
				</tr>
				<tr>
					<td colspan="2" class="text-center"><span class="c-red">为了确保您的资金安全，请输入资金密码以便确认您的身份！</span></td>
				</tr>
				<tr>
					<td align="right" valign="top"><span class="field-name">验证资金密码：</span></td>
					<td>
						<input type="password" class="input w-2 input-ico-lock" id="J-input-passowrd" />						
					</td>
				</tr>
				<tr>
					<td colspan="2" class="text-center">
						<input type="submit" class="btn" value=" 确认提现 " id="J-submit" />
						<a href="javascript:history.back(-1);" class="btn">返回修改</a>
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
	var ipt1 = $('#J-input-passowrd');
	$('#J-submit').click(function(){
		var v1 = $.trim(ipt1.val());
		if(v1 == ''){
			alert('资金密码不能为空');
			ipt1.focus();
			return false;
		}
		return true;
	});
})(jQuery);
</script>

</body>
</html>
