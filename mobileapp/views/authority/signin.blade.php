@extends('l.base')
@section('title')
安全登录
@parent
@stop

@section('styles')
@parent
{{ style('login') }}
@stop

@section ('container')

<div class="login-bg">
    <div class="login-logo">
        <img src="/assets/dist/images/login/logo.png" />
    </div>
    <div class="login-form">
        {{ Form::open(array('role' => 'form', 'target' => '_top', 'name' => 'signinForm', 'action'=>'mobile-auth.login')) }}
        <input type="hidden" name="_random" value="{{ createRandomStr() }}" />
        <h3>安全登录</h3>
        <div class="form-li">
            <i class="icon-usename "></i>
            <input type="text" name="username" id="username" value="{{ Input::old('username') }}" placeholder="用户名" required autofocus/>
        </div>
        <div class="form-li">
            <i class="icon-psw"></i>
            <input id="password" type="password" id="password" class="form-control" placeholder="密码" required>
            <input name="password" id="password-real" type="hidden" required />
        </div>
        @if ($bCapcha = Session::get('LOGIN_TIMES') && Session::get('LOGIN_TIMES') > 2)
        <div class="form-li">
            <input name="captcha" type="text" class="form-code form-control" placeholder="{{ __('Captcha') }}" required>
            <a class="input-group-addon" href="javascript:changeCaptcha();"><img id="captchaImg" src="{{ Captcha::img() }}"/></a>
        </div>
        @endif
        <button type="submit" class="btn btn-primary w-15">{{ Lang::get('transfer.Login') }}</button>
        <div class="ps-nav">
            <div class="float-left">
                <a href='{{SysConfig::readValue("KFURL")}}'>在线客服</a>
            </div>
            <a href="{{route('find-password')}}">忘记密码?</a>
        </div>
        {{ Form::close() }}
    </div>
    <div class="login-bottom"></div>
</div>

@stop

@section('scripts')
@parent
{{ script('md5') }}
<script>
    // login form
    function changeCaptcha() {
        // debugger;
        captchaImg.src = "{{ URL::to('captcha?') }}" + ((Math.random() * 9 + 1) * 100000).toFixed(0);
    }
    ;

    var $errorTips = $('.error-tips');
    function showError(error) {
        BootstrapDialog.show({
            title: '温馨提示',
            message: error,
            type: BootstrapDialog.TYPE_WARNING,
            buttons: [{
                    label: '关闭',
                    action: function (dialog) {
                        dialog.close();
                    }
                }]
        });
    }

    $(function () {
        var
                $button = $('button[type="submit"]'),
                $username = $('#username'),
                $password = $('#password'),
                $passwordReal = $('#password-real'),
                $form = $('form[name=signinForm]'),
                $captcha = $('input[name=captcha]');

        $button.on('click', function (e) {
            e.preventDefault();
            var username = $.trim($username.val()).toLowerCase();
            var pwd = $.trim($password.val());
            
            if (!username) {
                return showError('用户名不能为空');
            }
            if (!pwd) {
                return showError('密码不能为空');
            }
            if ($captcha.length && !$captcha.val()) {
                return showError('请输入验证码');
            }
            $username.val(username);
            $(this).text('登录中...');
            $passwordReal.val(md5(md5(md5(username + pwd))));
            $form.submit();
        });
        $form.keydown(function (event) {
            if (event.keyCode == 13) {
                $button.trigger('click');
            }
        });
    });

</script>
@stop
