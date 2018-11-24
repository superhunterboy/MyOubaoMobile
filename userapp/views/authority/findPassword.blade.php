@extends('l.login', array('active' => 'signin'))

@section('title') 找回密码 - @parent  @stop

@section ('styles')
@parent
{{ style('reg') }}
@stop

@section('container')


@include('authority.signupHeader')

<div id="reg-content" class="wrap">
    <div class="wrap-inner clearfix">
        <div class="reg-wrap findpassword-wrap">

            <div class="reg-box findpassword-box" id="J-form-panel">
                <div class="form-text">
                    <h2>找回登录密码</h2>
                </div>
                <form id="signupForm" action="{{route('find-password')}}" method="post">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <input type="hidden" name="_method" value="PUT" />
                    <ul class="form-ul">
                        <li class="username-li space-li" style="margin-top:0;">
                            <label>登录账号</label>
                            <div class="input-group">
                                <input type="text" tabindex="1" id="J-username" class="input" name="username" value="" />
                                <span class="ui-text-prompt">用户名格式不对，请重新输入</span>
                                <span class="ico-right"></span>
                            </div>
                            <span class="feild-static-tip">请输入您的账号名</span>
                        </li>
                        <li class="fundpassword-li">
                            <label>资金密码</label>
                            <div class="input-group">
                                <input type="password" tabindex="2" class="input" id="J-fundpassword" name="fund_password" />
                                <span class="ui-text-prompt">资金密码不能为空</span>
                                <span class="ico-right"></span>
                            </div>
                            <span class="feild-static-tip">请输入您的资金密码</span>
                        </li>
                        <li class="password-li space-li">
                            <label>新的登录密码</label>
                            <div class="input-group">
                                <input type="password" name="new_password" tabindex="3" id="J-password" class="input" value="">
                                <!-- <input type="text" tabindex="3" id="J-password-hidden" class="input password-text" name="password" /> -->
                                <i class="J-checkbox-showpas show-password" title="显示密码"></i>
                                <span class="ico-right"></span>
                                <span class="ui-text-prompt">密码输入有误，请重新输入</span>
                            </div>
                            <span class="feild-static-tip">由字母和数字组成6-16个字符； 且必须包含数字和字母，不允许连续三位相同</span>
                        </li>
                        <li class="repassword-li">
                            <label>确认登录密码</label>
                            <div class="input-group">
                                <input type="password" tabindex="4" class="input" id="J-password2" name="new_password_confirmation" />
                                <span class="ico-right"></span>
                                <span class="ui-text-prompt">两次输入密码不一致，请重新输入</span>
                            </div>
                        </li>
                        <li class="vcode-li space-li">
                            <label>验证码</label>
                            <div class="input-group">
                                <input type="text" tabindex="5" id="J-vcode" name="captcha" class="input" />
                                <span class="ico-right"></span>
                                <span class="ui-text-prompt">验证码不能为空</span>
                            </div>
                            <a class="verify" href="javascript:changeCaptcha();" title="点击图片刷新验证码">
                                <img id="captchaImg" class="reg-img-vcode" src="{{ Captcha::img() }}" /></a>
                        </li>
                        <li class="button-li">
                            <label>&nbsp;</label>
                            <button type="submit" tabindex="6" id="J-button-submit">找回登录密码</button>
                        </li>
                    </ul>
                </form>
            </div>
        </div>

    </div>
</div>
@include('w.notification')
@include('w.footer')
@stop


@section('end')
@parent

<script>
    function changeCaptcha() {
        // debugger;
        captchaImg.src = "{{ URL::to('captcha?') }}" + ((Math.random() * 9 + 1) * 100000).toFixed(0);
    }
    ;
    (function ($) {

        // 联系代理
        $('.contact-us').on('click', function () {
            $(this).find('.submenu').slideToggle();
        });

        var inputTip = new dsgame.Tip({cls: 'j-ui-tip-b w-4'});
        function showTips($t) {
            if (!$t || !$t.length)
                return false;
            var $tips = $t.parents('li:eq(0)').find('.feild-static-tip');
            if ($tips.length) {
                var text = $tips.text();
                inputTip.setText(text);
                inputTip.show(5, inputTip.getDom().height() * -1 - 22, $t);
            }
        }

        $('.input').on('focus', function () {
            showTips($(this));
            $(this).siblings('.ui-text-prompt').hide();
        }).on('blur', function () {
            inputTip.hide();
        });

        var username = $('#J-username'),
                fundpassword = $('#J-fundpassword'),
                password = $('#J-password'),
                // passwordHidden = $('#J-password-hidden'),
                password2 = $('#J-password2'),
                vcode = $('#J-vcode'),
                showPass = $('.J-checkbox-showpas'),
                errors = $('.ui-text-prompt');

        username.blur(function () {
            var dom = username,
                    v = $.trim(dom.val()),
                    tip = dom.siblings('.ui-text-prompt'),
                    right = dom.siblings('.ico-right');
            if (!(/^[a-zA-Z][a-zA-Z0-9]{5,15}$/).test(v)) {
                // errors.hide();
                tip.html('用户名格式不对，请重新输入').show();
                right.hide();
                return;
            } else {
                tip.hide();
                right.show();
            }
        });
        password.blur(function () {
            var dom = password,
                    v = $.trim(dom.val()),
                    tip = dom.siblings('.ui-text-prompt'),
                    right = dom.siblings('.ico-right'),
                    v2;
            if (!v) {
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
        password2.blur(function () {
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
        fundpassword.blur(function () {
            var dom = fundpassword,
                    v = $.trim(dom.val()),
                    tip = dom.siblings('.ui-text-prompt'),
                    right = dom.siblings('.ico-right');
            if (!v) {
                tip.show();
                right.hide();
                return;
            }
            tip.hide();
            if (v != '') {
                right.show();
            }
        });
        vcode.blur(function () {
            var dom = vcode,
                    v = $.trim(dom.val()),
                    tip = dom.siblings('.ui-text-prompt'),
                    right = dom.siblings('.ico-right');
            if (!(/^[a-zA-Z0-9]{5}$/).test(v)) {
                tip.html('验证码格式不正确，请重新输入').show();
                return;
            }
            tip.hide();
        });

        // 显示隐藏密码
        showPass.on('click', function () {
            if ($(this).hasClass('active')) {
                password.prop('type', 'password');
                // passwordHidden.hide();
                $(this).attr('title', '显示密码');
            } else {
                password.prop('type', 'text');
                // passwordHidden.show();
                $(this).attr('title', '隐藏密码');
            }
            $(this).toggleClass('active');
            return false;
        });


        $('#J-button-submit').click(function () {
            if ($('#J-form-panel').find('.ico-error:visible').size() > 0) {
                return false;
            }
            if (username.val() == '') {
                username.siblings('.ui-text-prompt').show().end()
                        .siblings('.ico-right').hide();
                username.focus();
                return false;
            }
            if (fundpassword.val() == '') {
                fundpassword.siblings('.ui-text-prompt').show().end()
                        .siblings('.ico-right').hide();
                fundpassword.focus();
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
@stop