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
	<script src="js/global.js"></script>
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

	<div id="reg-content" class="wrap">
		<div class="wrap-inner clearfix">
			<div class="slogan-text">
				<h2>CC彩票出品，必属精品</h2>
				<p>CC彩票志在打造亚洲最佳精品游戏平台，为您创造安全、稳定、便捷的游戏世界。无限财富等您赢取！</p>
			</div>
			<div class="reg-wrap">
				<div class="reg-nav left">
					<ul>
						<li class="avatar" data-action="avatar">
							<i></i>
							<span>选择头像</span>
						</li>
						<li class="account" data-action="account">
							<i></i>
							<span>账号密码</span>
						</li>
						<li class="email" data-action="email">
							<i></i>
							<span>填写邮箱</span>
						</li>
					</ul>
				</div>
					
				<div class="reg-box" id="J-form-panel">
					<!-- <h1>注册CC彩票</h1> -->
					<div class="form-text">
						<h2>用户资料</h2>
						<p>请填写完整的用户资料，以确保您的账户安全</p>
					</div>
					<form action="http://ds.test.com/auth/signup?prize=ec0a26f5d895a83e7dc2bec16d750028" method="post" id="signupForm">
						<input type="hidden" name="_token" value="U42jMma2bTmXv9oaEMEGnFR8pbfG1srAInZEAYSV">
						<input type="hidden" name="_random" value="$2y$10$SgAfhQh9/pxuO2/ZX72IOe/hx6jT2cEiKfhHcckMUlLVd2RpJ6C/O_8aJ0Z8">
						<!-- <div class="service">
							<h4>咨询CC彩票代理</h4>
							<a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=222333&site=qq&menu=yes"><img border="0" src="http://wpa.qq.com/pa?p=2:222333:51" alt="点击这里给我发消息" title="点击这里给我发消息" /></a>
						</div> -->
						<ul class="form-ul">
							<li class="avatar-li" data-action="avatar">
								<label>选择头像</label>
								<div class="avatar-show">
									<img class="J-show-img" src="data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" alt="" />
								</div>
								<div class="avatar-list">
									<a data-id="1" href="javascript:;">
										<i data-ds-avatar="1"></i>
										<span></span>
									</a>
									<a data-id="2" href="javascript:;">
										<i data-ds-avatar="2"></i>
										<span></span>
									</a>
									<a data-id="3" href="javascript:;">
										<i data-ds-avatar="3"></i>
										<span></span>
									</a>
									<a data-id="4" href="javascript:;">
										<i data-ds-avatar="4"></i>
										<span></span>
									</a>
									<a data-id="5" href="javascript:;">
										<i data-ds-avatar="5"></i>
										<span></span>
									</a>
									<a data-id="6" href="javascript:;">
										<i data-ds-avatar="6"></i>
										<span></span>
									</a>
								</div>
								<input type="hidden" name="avatarid" class="J-avatar-id" />
							</li>
							<li class="username-li space-li" data-action="account">
								<label>登录账号</label>
								<div class="input-group">
									<input type="text" tabindex="1" id="J-username" class="input" name="username" value="" />
									<span class="ui-text-prompt">用户名格式不对，请重新输入</span>
									<span class="ico-right"></span>
								</div>
								<span class="feild-static-tip">第一个字母必须为字母，由0-9，a-z，A-Z组成的6-16个字符</span>
							</li>
							<li class="password-li" data-action="account">
								<label>登录密码</label>
								<div class="input-group">
									<input type="password" name="password" tabindex="2" id="J-password" class="input" value="">
									<!-- <input type="text" tabindex="2" id="J-password-hidden" class="input password-text" name="password" /> -->
									<i class="J-checkbox-showpas show-password" title="显示密码"></i>
									<span class="ico-right"></span>
									<span class="ui-text-prompt">密码输入有误，请重新输入</span>
								</div>
								<span class="feild-static-tip">由字母和数字组成6-16个字符； 且必须包含数字和字母，不允许连续三位相同</span>
							</li>
							<li class="repassword-li" data-action="account">
								<label>确认密码</label>
								<div class="input-group">
									<input type="password" tabindex="3" class="input" id="J-password2" name="password_confirmation" />
									<span class="ico-right"></span>
									<span class="ui-text-prompt">两次输入密码不一致，请重新输入</span>
								</div>
							</li>
							<li class="email-li space-li" data-action="email">
								<label>邮箱地址</label>
								<div class="input-group">
									<input type="text" tabindex="4" class="input" id="J-email" placeholder="" name="email" value="" />
									<span class="ico-right"></span>
									<span class="ui-text-prompt">邮箱地址格式不正确，请重新输入</span>
								</div>
							</li>
							<li class="vcode-li space-li" data-action="vcode">
								<label>验证码</label>
								<div class="input-group">
									<input type="text" tabindex="5" id="J-vcode" name="captcha" class="input" />
									<span class="ico-right"></span>
									<span class="ui-text-prompt">验证码不能为空</span>
								</div>
								<a class="verify" href="javascript:changeCaptcha();" title="点击图片刷新验证码">
									<img id="captchaImg" class="reg-img-vcode" src="http://ds.test.com/captcha?902668" /></a>
							</li>
							<li class="button-li">
								<label>&nbsp;</label>
								<button type="submit" tabindex="6" id="J-button-submit">提交注册信息</button>
							</li>
						</ul>
						
					</form>
				</div>
			</div>
				
		</div>
	</div>
	
	<?php include_once("footer.php"); ?>

</body>
<script type="text/javascript">
(function() {
	if ($('#popWindow').length) {
		// $('#myModal').modal();
		var popWindow = new dsgame.Message();
		var data = {
			title: '提示',
			content: $('#popWindow').find('.pop-bd > .pop-content').html(),
			closeIsShow: true,
			closeButtonText: '关闭',
			closeFun: function() {
				this.hide();
			}
		};
		popWindow.show(data);
	}
})();
</script>
<script>
function changeCaptcha() {
	// debugger;
	captchaImg.src = "http://ds.test.com/captcha?" + ((Math.random() * 9 + 1) * 100000).toFixed(0);
};
(function($) {

	// 联系代理
	$('.contact-us').on('click', function(){
		$(this).find('.submenu').slideToggle();
	});

	// 头像点击
	var $avatarid = $('.J-avatar-id'),
		$showImg = $('.J-show-img');
	$('.avatar-list a').on('click', function(){
		var $this = $(this),
			id = $this.data('id');
		if( $this.hasClass('active') ) return false;
		$this.addClass('active').siblings('.active').removeClass('active');
		$avatarid.val(id);
		var img = $this.find('img').attr('src') || (dsAvatarPath + dsAvatars[0]);
		$showImg.attr('src', img);
	}).eq(0).trigger('click');

	// 左侧导航高亮
	var $regnav = $('.reg-nav li');
	$('.form-ul li').on('click', function(){
		var action = $(this).data('action');
		$regnav.removeClass('active').filter('[data-action="' + action + '"]').addClass('active');
	});

	var inputTip = new dsgame.Tip({cls:'j-ui-tip-b w-4'});
	function showTips($t){
		if( !$t || !$t.length ) return false;
		var $tips = $t.parents('li:eq(0)').find('.feild-static-tip');
		if( $tips.length ){
			var text = $tips.text();
			inputTip.setText(text);
			inputTip.show(5, inputTip.getDom().height() * -1 - 22, $t);
		}
	}

	$('.input').on('focus', function(){
		showTips($(this));
		$(this).siblings('.ui-text-prompt').hide();
	}).on('blur', function(){
		inputTip.hide();
	});

	var username = $('#J-username'),
		password = $('#J-password'),
		// passwordHidden = $('#J-password-hidden'),
		password2 = $('#J-password2'),
		email = $('#J-email'),
		vcode = $('#J-vcode'),
		showPass = $('.J-checkbox-showpas'),
		errors = $('.ui-text-prompt');

	username.blur(function() {
		var dom = username,
			v = $.trim(dom.val()),
			tip = dom.siblings('.ui-text-prompt'),
			right = dom.siblings('.ico-right');
		if (!(/^[a-zA-Z][a-zA-Z0-9]{5,15}$/).test(v)) {
			// errors.hide();
			tip.html('用户名格式不对，请重新输入').show();
			right.hide();
			return;
		}else{
			tip.hide();
			right.show();
		}
		// $.ajax({
		// 	url: $.trim($('#J-check-username-url').val()),
		// 	dataType: 'json',
		// 	method: 'POST',
		// 	data: {
		// 		'username': v
		// 	},
		// 	success: function(data) {
		// 		if (Number(data['isSuccess']) == 1) {
		// 			tip.hide();
		// 			right.show();
		// 		} else {
		// 			tip.html('用户名已经被其他用户使用');
		// 			tip.show();
		// 			right.hide();
		// 		}
		// 	},
		// 	error: function() {
		// 		tip.hide();
		// 		right.show();
		// 	}
		// });
	});
	password.blur(function() {
		var dom = password,
			v = $.trim(dom.val()),
			tip = dom.siblings('.ui-text-prompt'),
			right = dom.siblings('.ico-right'),
			v2;
		if( !v ){
			tip.html('密码不能为空，请输入密码').show();
			right.hide();
			return;
		}
		if (!(/^(?=.*\d+)(?=.*[a-zA-Z]+)(?!.*?([a-zA-Z0-9]+?)\1\1).{6,16}$/).test(v)) {
			tip.html('密码格式不正确，请重新输入').show();
			right.hide();
			return;
		}
		tip.hide();
		right.show();

		v2 = $.trim(password2.val());
		if (v2 != '') {
			if (v != v2) {
				password2.siblings('.ui-text-prompt').show();
				password2.siblings('.ico-right').hide();
			} else {
				password2.siblings('.ui-text-prompt').hide();
				password2.siblings('.ico-right').show();
			}
		}
	});
	// }).keyup(function() {
	// 	passwordHidden.val(this.value);
	// });
	// passwordHidden.keyup(function() {
	// 	password.val(this.value);
	// });
	/*passwordHidden.blur(function() {
		var dom = passwordHidden,
			v = $.trim(dom.val()),
			tip = dom.siblings('.ui-text-prompt'),
			right = dom.siblings('.ico-right'),
			v2;
		if (!(/^.{6,16}$/).test(v)) {
			tip.show();
			right.hide();
			return;
		}
		if (!(/\d/g).test(v) || !(/[a-zA-Z]/g).test(v) || (/(.)\1{2}/g).test(v)) {
			tip.show();
			return;
		}
		tip.hide();
		right.show();

		v2 = $.trim(password2.val());
		if (v2 != '' && v != v2) {
			password2.siblings('.ui-text-prompt').show();
			password2.siblings('.ico-right').hide();
		}
	});*/
	password2.blur(function() {
		var dom = password2,
			v = $.trim(dom.val()),
			tip = dom.siblings('.ui-text-prompt'),
			right = dom.siblings('.ico-right');
		if (v != $.trim(password.val())) {
			tip.html('两次输入的密码不相同，请重新输入');
			tip.show();
			right.hide();
			return;
		}
		if (v != '') {
			tip.hide();
			right.show();
		}
	});
	email.blur(function() {
		var dom = email,
			v = $.trim(dom.val()),
			tip = dom.siblings('.ui-text-prompt'),
			right = dom.siblings('.ico-right');
		if (v != '' && !(/\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/).test(v)) {
			tip.html('邮箱地址输入不正确，请重新输入').show();
			return;
		}
		tip.hide();
		if (v != '') {
			right.show();
		}
	});
	vcode.blur(function() {
		var dom = vcode,
			v = $.trim(dom.val()),
			tip = dom.siblings('.ui-text-prompt'),
			right = dom.siblings('.ico-right');
		if (!(/^[a-zA-Z0-9]{5}$/).test(v)) {
			tip.html('验证码格式不正确，请重新输入').show();
			return;
		}
		tip.hide();

		// $.ajax({
		//     url:$.trim($('#J-check-vcode-url').val()),
		//     dataType:'json',
		//     method:'POST',
		//     data:{'vcode':v},
		//     success:function(data){
		//         if(Number(data['isSuccess']) == 1){
		//             tip.hide();
		//             right.show();
		//         }else{
		//             tip.find('.feild-tip-text').html('您输入的验证码不正确');
		//             tip.show();
		//             right.hide();
		//             $('#J-img-vcode').attr('src', $('#J-img-vcode').attr('data-src') + '?rd=' + Math.random());
		//         }
		//     }
		// });
	});

	// 显示隐藏密码
	showPass.on('click', function() {
		if( $(this).hasClass('active') ){
			password.prop('type', 'password');
			// passwordHidden.hide();
			$(this).attr('title', '显示密码');
		}else{
			password.prop('type', 'text');
			// passwordHidden.show();
			$(this).attr('title', '隐藏密码');
		}
		$(this).toggleClass('active');
		return false;
	});


	$('#J-button-submit').click(function() {
		if ($('#J-form-panel').find('.ico-error:visible').size() > 0) {
			return false;
		}
		if (username.val() == '') {
            username.siblings('.ui-text-prompt').show().end()
                .siblings('.ico-right').hide();
            username.focus();
            return false;
        }
        if (password.val() == '') {
            password.siblings('.ui-text-prompt').show().end()
                .siblings('.ico-right').hide();
            password.focus();
            return false;
        }
        if (password2.val() == '') {
            password2.siblings('.ui-text-prompt').show().end()
                .siblings('.ico-right').hide();
            password2.focus();
            return false;
        }
        if (vcode.val() == '') {
            vcode.siblings('.ui-text-prompt').show().end()
                .siblings('.ico-right').hide();
            vcode.focus();
            return false;
        }
		$('#signupForm').submit();
		return false; // TIP return false可以去除button type = image时, form提交出现的button的x,y座标值

	});

	username.click().focus();
})(jQuery);
</script>

</html>
