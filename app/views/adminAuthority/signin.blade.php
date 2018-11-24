@extends('l.admin', array('active' => 'signin'))

@section('title') 登录 @parent @stop


@section('container')

<div style="margin-top:100px;">
        <div class="col-md-4 col-md-offset-4">
        <div class="panel panel-default">
          <div class="panel-heading h3">
            博狼娱乐登录
          </div>
          <div class="panel-body">

            {{ Form::open(array('class' => 'form-horizontal', 'role' => 'form', 'target' => '_top', 'name' => 'signinForm')) }}

                <div class="form-group">
                    <label class="col-sm-3 control-label">{{ __('_user.username',[],1,'zh-CN') }} :</label>
                    <div class="col-sm-6">
                        <input name="username" id="login-name" value="{{ Input::old('username') }}" type="text" class="form-control  login-field" placeholder="" required autofocus>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label">{{ __('_user.password',[],1,'zh-CN') }} :</label>
                    <div class="col-sm-6">
                    <input class="form-control login-field" name="" id="login-pass" type="password" placeholder="{{ __('_user.password',[],1,'zh-CN') }}" required />
                    <input name="password" id="login-pass-real" type="hidden" required />
                    </div>
                </div>

                @if ($bSecureCard)
                <div class="form-group">
                    <label class="col-sm-3 control-label">{{ __('_basic.secure-password') }} :</label>
                    <div class="col-sm-6">
                        <input name="secure_password" id="securd-password" type="password" class="form-control login-field" placeholder="" required>
                    </div>
                </div>
                @elseif ($bCaptcha)
                <div class="form-group">
                    <label class="col-sm-3 control-label">{{ __('_basic.captcha') }} :</label>
                    <div class="col-sm-6">
                        <input name="captcha" type="text" class="form-control login-field" placeholder="{{ __('_basic.captcha') }}" required >
                    </div>
                    <a href="javascript:changeCaptcha();" class="login-captcha" title="{{ __('_basic.captcha') }}"><img id="captchaImg" src="{{ Captcha::img() }}" alt=""></a>

                </div>
                @endif
              <div class="form-group">
                <div class="col-sm-6 col-sm-offset-3">
                    <button id="loginButton" class="btn btn-primary btn-large btn-block login-btn" type="button">{{ __('_function.login',[],1,'zh-CN') }}</button>
                </div>
              </div>

            {{ Form::close() }}
            

        </div>
        <div class="alert alert-warning alert-dismissable {{ Session::get('error') ? '' : 'hidden'; }}">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong>{{ Session::get('error') }}</strong>
            </div>
      </div>
    </div>
    <div style="position:fixed;right:10px;bottom:10px;">汇赢科技版权所有</div>
@stop
@section('javascripts')
    @parent
    {{ script('md5') }}
@stop
@section('end')
<script>
    function changeCaptcha () {
        captchaImg.src = {{ '"'.URL::to('captcha?').'"' }} + ((Math.random()*9 +1)*100000).toFixed(0);
    }
    // TODO 调整开户流程中，调整完成后打开注释以便实现Username+password登录
    $('#loginButton').click(function (e) {
        var pwd = $('#login-pass').val();
        var username = ($('#login-name').val()).toLowerCase();
        $(this).text("{{ Lang::get('transfer.Login') }}...");
        $('#login-pass-real').val(md5(md5(md5(username + pwd))));
        $('form[name=signinForm]').submit();
    });
    $('form[name=signinForm]').keydown(function(event) {
        if (event.keyCode == 13) $('#loginButton').click();
    });
</script>
@parent
@stop


