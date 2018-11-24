<!DOCTYPE HTML>
<html lang="en-US">
<head>
<meta charset="UTF-8">
<title>密码管理 -- CC彩票</title>
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
			<div class="title-normal">密码管理</div>
		</div>
		
		<div class="content">
			<form action="?" method="post" id="J-form-login">
			<div class="title-field">
				<i class="ico-title ico-title-lock"></i><span class="title-text">登录密码修改</span>
			</div>
			<table width="100%" class="table-field">
				<tr>
					<td align="right" style="width:350px;">输入旧登录密码：</td>
					<td>
						<input id="J-input-login-password-old" type="password" class="input w-4">
						
					</td>
				</tr>
				<tr>
					<td align="right">输入新登录密码：</td>
					<td>
						<input id="J-input-login-password-new" type="password" class="input w-4">
						<span class="ui-text-prompt-multiline w-6">由字母和数字组成6-16个字符；且必须包含数字和字母，不允许连续三位相同，不能和资金密码相同</span>
					</td>
				</tr>
				<tr>
					<td align="right">确认新登录密码：</td>
					<td>
						<input id="J-input-login-password-new2" type="password" class="input w-4">
					</td>
				</tr>
				<tr>
					<td align="right"></td>
					<td>
						<input id="J-button-submit-login" type="submit" value="确认修改" class="btn" />
					</td>
				</tr>
			</table>
			</form>
			<div class="title-field">
				<i class="ico-title ico-title-safe"></i><span class="title-text">资金密码修改</span>
			</div>
			<form action="?" method="post" id="J-form-money">
			<table width="100%" class="table-field">
				<tr>
					<td align="right" style="width:350px;">输入旧资金密码：</td>
					<td>
						<input id="J-input-money-password-old" type="password" class="input w-4">
						
					</td>
				</tr>
				<tr>
					<td align="right">输入新资金密码：</td>
					<td>
						<input id="J-input-money-password-new" type="password" class="input w-4">
						<span class="ui-text-prompt-multiline w-6">由字母和数字组成6-16个字符；且必须包含数字和字母，不允许连续三位相同，不能和资金密码相同</span>
					</td>
				</tr>
				<tr>
					<td align="right">确认新资金密码：</td>
					<td>
						<input id="J-input-money-password-new2" type="password" class="input w-4">
					</td>
				</tr>
				<tr>
					<td align="right"></td>
					<td>
						<input id="J-button-submit-money" type="submit" value="确认修改" class="btn">
					</td>
				</tr>
			</table>
			
			
			<table width="100%" class="table-field">
				<tr>
					<td align="right" style="width:350px;">&nbsp;</td>
					<td>
						<span class="f14">您还没有设置资金密码哦！</span>
					</td>
				</tr>
				<tr>
					<td align="right">&nbsp;</td>
					<td>
						<a href="#" class="btn" />立即设置</a>
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
	
	$('#J-button-submit-login').click(function(){
		var passwordOld = $('#J-input-login-password-old'),
			passwordNew = $('#J-input-login-password-new'),
			passwordNewV = $.trim(passwordNew.val()),
			passwordNew2 = $('#J-input-login-password-new2');
		if($.trim(passwordOld.val()) == ''){
			alert('旧登陆密码不能为空');
			passwordOld.focus();
			return false;
		}
		if(passwordNewV == ''){
			alert('新登陆密码不能为空');
			passwordNew.focus();
			return false;
		}
		if(!(/^(?![^a-zA-Z]+$)(?!\D+$).{6,16}$/).test(passwordNewV)){
			alert('新登陆密码格式不符合要求');
			passwordNew.focus();
			return false;
		}
		if($.trim(passwordNew2.val()) != passwordNewV){
			alert('两次输入的密码不一致');
			passwordNew2.focus();
			return false;
		}
		
		return true;
		
	});
	
	
	$('#J-button-submit-money').click(function(){
		var passwordOld = $('#J-input-money-password-old'),
			passwordNew = $('#J-input-money-password-new'),
			passwordNewV = $.trim(passwordNew.val()),
			passwordNew2 = $('#J-input-money-password-new2');
		if($.trim(passwordOld.val()) == ''){
			alert('旧资金密码不能为空');
			passwordOld.focus();
			return false;
		}
		if(passwordNewV == ''){
			alert('新资金密码不能为空');
			passwordNew.focus();
			return false;
		}
		if(!(/^(?![^a-zA-Z]+$)(?!\D+$).{6,16}$/).test(passwordNewV)){
			alert('新资金密码格式不符合要求');
			passwordNew.focus();
			return false;
		}
		if($.trim(passwordNew2.val()) != passwordNewV){
			alert('两次输入的密码不一致');
			passwordNew2.focus();
			return false;
		}
		
		return true;
		
	});
	
	
})(jQuery);
</script>



<script>
(function($){
	var msg = dsgame.Message.getInstance();
	
	msg.show({
		isShowMask:true,
		title:'温馨提示',
		content:'<i class="ico-waring"></i><i class="ico-success"></i><i class="ico-error"></i><p class="pop-text">哈哈哈</p>',
		confirmIsShow:true,
		confirmText:'确定',
		confirmFun:function(){
			msg.hide();
		}
	});

	
})(jQuery);
</script>


</body>
</html>
















