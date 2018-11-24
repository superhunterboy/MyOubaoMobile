<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>CC彩票</title>
<link type="text/css" rel="stylesheet" href="images/global/global.css" />
<link rel="stylesheet" type="text/css" href="images/login/login.css"/>
<script src="js/jquery-1.9.1.min.js"></script>
<script src="../userpublic/assets/js/md5.js"></script>
</head>

<body>

<div id="header" class="wrap">
	<div class="wrap-inner">
		<div class="logo"></div>
		<div class="nav">
			<a href="{{ route('help.index') }}">帮助中心</a>
			<!-- |
			<a href="" target="_blank">在线客服</a> -->
		</div>
	</div>
</div>

<div class="content">
	<div class="login-box">
		<h2>安全登录</h2>
		<form action="">
		<ul class="form-ul">
			<li class="username-li">
				<i class="input-icon"></i>
				<input name="username" class="input" id="login-name" value="" placeholder="用户名" required autofocus/>
			</li>
			<li class="password-li">
				<i class="input-icon"></i>
				<input class="input" name="" id="login-pass" type="password" placeholder="密码" required />
				<input name="password" id="login-pass-real" type="hidden" required />
			</li>
			<li class="captcha-li">
				<i class="input-icon"></i>
				<input class="input" name="captcha" type="text" placeholder="验证码" />
				<a class="verify" href="javascript:changeCaptcha();" title="点击图片刷新验证码"><img id="captchaImg"  src="http://ds.test.com/captcha?988177"/></a>
				<a href="javascript:changeCaptcha();">换一张</a>
			</li>
			<li class="button-li">
				<button id="loginButton" type="button">登 录</button>
			</li>
			<li class="option-li">
				<!-- <label><input type="radio">记住账号</label> -->
				<a href="">忘记密码?</a>
			</li>
		</ul>
		<div class="form-error-tips">
			<h3>账号或密码错误</h3>
			<ol>
				<li>请检查账号拼写，是否输入有误</li>
				<li>请检查您的密码是否大小写输入有误</li>
				<li>若您忘记密码，请联系客服找回密码</li>
				<li>若看不清验证码，请点击“换一张”刷新</li>
			</ol>
		</div>
		</form>
	</div>
	
	<div class="monkey">
		<div class="eye"></div>
		<div class="eye eye-r"></div>
	</div>
	<div class="ds-login">
		<div class="hand"></div>
		<div class="hand hand-r"></div>
		<div class="arms">
			<div class="arm"></div>
			<div class="arm arm-r"></div>
		</div>
	</div>
	
</div>


<?php include_once("footer.php"); ?>

<script>
// login page responsive
$(function(){
	var $ft = $('#footer'),
		minH = $ft.offset().top + $ft.outerHeight();

	function loginResponsive(){
		var bh = $(window).height();
		if( bh > minH ){
			$ft.css({
				marginTop: bh - minH
			});
		}			
	}
	loginResponsive();

	var resizeTimer = null;
	$(window).on('resize', function () {
		if ( resizeTimer ) {
			clearTimeout(resizeTimer);
		}
		resizeTimer = setTimeout(function(){
			loginResponsive();
		}, 100);
	});

});

// 错误提示眼睛朝上
var $tips = $('.form-error-tips'),
	$eyes = $('.monkey');
if( $tips.length ){
	$eyes.addClass('eye-up');
	$tips.addClass('fade');
}

// 蒙眼睛
var $target = $('.ds-login');
$('#login-pass').on({
	focus: function(){
		$target.addClass('password');
		$eyes.removeClass('eye-up');
	},
	blur: function(){
		$target.removeClass('password');
	}
});

// login form
function changeCaptcha () {
	// debugger;
	captchaImg.src = "http://ds.test.com/captcha?" + ((Math.random()*9 +1)*100000).toFixed(0);
};

$(function(){

	// TODO 调整开户流程中，调整完成后打开注释以便实现Username+password登录
	// $('#login-pass').blur(function(event) {
	//     debugger;
	//     var pwd = $(this).val();
	//     var username = $('#login-name').val();
	//     $(this).val(md5(md5(md5(username + pwd))));
	// });
	// $('form[name=signinForm]').submit(function (e) {
	//     var pwd = $('#login-pass').val();
	//     var username = ($('#login-name').val()).toLowerCase();
	//     $('#login-pass').val(md5(md5(md5(username + pwd))));
	// });
	$('#loginButton').click(function (e) {
		var pwd = $('#login-pass').val();
		var username = ($('#login-name').val()).toLowerCase();
		$(this).text('登录中...');
		$('#login-pass-real').val(md5(md5(md5(username + pwd))));
		$('form[name=signinForm]').submit();
	});
	$('form[name=signinForm]').keydown(function(event) {
		if (event.keyCode == 13) $('#loginButton').click();
	});
});

</script>

</body>
</html>
