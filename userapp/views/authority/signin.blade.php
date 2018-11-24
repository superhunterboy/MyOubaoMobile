@extends('l.login', array('active' => 'signin'))

@section('title') 安全登录 @parent  @stop

@section ('styles')
@parent
    {{ style('login') }}
@stop

@section ('container')

<div id="header" class="wrap">
    <div class="wrap-inner">
        <div class="logo"></div>
        <div class="nav">
            <a href="{{ route('help.index') }}">帮助中心</a>
            |
            <a data-call-center style="cursor: pointer">在线客服</a>
        </div>
    </div>
</div>

<div class="content">
    <div class="ad-box">
        <img src="/ad/eb8d0ede6c435b8a1335b035c7c5f1b0.jpeg"></div>
    <div class="login-box">
        <h2>安全登录</h2>
    {{ Form::open(array('role' => 'form', 'target' => '_top', 'name' => 'signinForm')) }}
        <input type="hidden" name="_random" value="{{ createRandomStr() }}" />

         <div class="login-error {{ $errors->first('attempt')?'':'hidden'; }}">
            {{ $errors->first('attempt') }}
        </div> 
        <ul class="form-ul">
            <li class="username-li">
                <i class="input-icon"></i>
                <input name="username" class="input" id="login-name" value="{{ Input::old('username') }}" placeholder="用户名" required autofocus/>
            </li>
            <li class="password-li">
                <i class="input-icon"></i>
                <input class="input" name="" id="login-pass" type="password" placeholder="密码" required />
                <input name="password" id="login-pass-real" type="hidden" required />
            </li>
            @if ($bCapcha = Session::get('LOGIN_TIMES') && Session::get('LOGIN_TIMES') > 2)
           <li class="captcha-li">
                <i class="input-icon"></i>
                <input class="input" name="captcha" type="text" placeholder="验证码" />
                <a class="verify" href="javascript:changeCaptcha();" title="{{ Lang::get('transfer.Captcha') }}"><img id="captchaImg" src="{{ Captcha::img() }}"/></a>
                <a href="javascript:changeCaptcha();">换一张</a>
            </li>
            @endif
            <li class="button-li">
                <button id="loginButton" type="button">登&nbsp;录</button>
            </li>
            <li class="option-li">
                <a href="{{route('find-password')}}">忘记密码?</a>
            </li>
        </ul>
    {{ Form::close() }}
    </div>
    <div class="clearfix"></div>

</div>

@include('w.footer')
@stop

@section('scripts')
@parent
    {{ script('md5') }}
    {{ script('jquery.cycle2')}}
    {{ script('cycle2.scrollVert')}}
@stop

@section('end')

<script type="text/javascript">
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
    captchaImg.src = "{{ URL::to('captcha?') }}" + ((Math.random()*9 +1)*100000).toFixed(0);
};

$(function(){
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
@parent
@stop





