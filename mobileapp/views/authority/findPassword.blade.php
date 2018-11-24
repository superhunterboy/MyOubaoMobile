@extends('l.base')

@section('title')
找回登录密码
@parent
@stop

@section('styles')
@parent
{{ style('ucenter') }}
@stop

@section ('container')
<div class="main-page show-page">
  <div data-fixed-top class="top-nav media">
    <div class="media-left media-middle">
      <a href="/" class="history-back"><span class="unicode-icon-prev"></span></a>
    </div>
    <h1 class="media-body">找回登录密码</h1>
  </div>

  <div id="section">

    <div class="ds-form">
      <form action="{{route('find-password')}}" method="post">
        <input type="hidden" name="_method" value="PUT">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <div class="ds-form-group">
          <label for="username">登录账号</label>
          <input type="text" id="username" class="input" name="username" placeholder="请输入登录账号" required>
        </div>
        <div class="ds-form-group">
          <label for="fund_password">资金密码</label>
          <input type="password" id="fund_password" name="fund_password" placeholder="请输入资金密码" required>
        </div>

        <div class="ds-form-group">
          <label for="password">新登录密码</label>
          <input name="new_password" id="password" type="password" placeholder="请输入新登录密码" required>
        </div>
        <div class="ds-form-group">
          <label for="new_password_confirmation">确认密码</label>
          <input name="new_password_confirmation" id="new_password_confirmation" type="password" placeholder="确认新登录密码" required>
        </div>
        <div class="ds-form-group ds-form-captcha">
          <label for="vcode">验证码</label>
          <input class="small" name="captcha" id="vcode" type="text" placeholder="请输入验证码" required>
          <img data-captcha src="{{ Captcha::img() }}">
        </div>
        <div class="ds-form-info ds-form-info-bottom">
          <span class="unicode-icon-info"></span>
          <!-- <span class="glyphicon glyphicon-info-sign"></span> -->
          <small>如果本页面无法帮助到您，请登录电脑版联系在线客服并按照流程指示提供相关资料后，即可找回密码哦。</small>
        </div>
        <div class="ds-form-button">
          <button class="ds-btn" type="submit">找回登录密码</button>
        </div>
      </form>
    </div>

  </div>
</div>
@stop

@section('scripts')
@parent
<script>
$(function () {
  var touchEvent = DSGLOBAL['touchEvent'];

  $('[data-captcha]').on(touchEvent, function(){
    this.src = "{{ URL::to('captcha?') }}" + ((Math.random() * 9 + 1) * 100000).toFixed(0);
  });

  var $username = $('#username');
  var $fundpassword = $('#fund_password');
  var $password = $('#password');
  var $password2 = $('#new_password_confirmation');
  var $vcode = $('#vcode');
  $('.ds-form-button button[type="submit"]').on(touchEvent, function () {
    var message = '';
    var $focus;
    if ($username.val() == '') {
      message = '请输入登录账号';
      $focus = $username;
    }else if ($fundpassword.val() == '') {
      message = '请输入资金密码';
      $focus = $fundpassword;
    }else if ($password.val() == '') {
      message = '请输入新登录密码';
      $focus = $password;
    }else if ($password2.val() == '' || $password1.val() != $password2.val()) {
      message = '两次输入的密码不一致';
      $focus = $password2;
    }else if ($vcode.val() == '') {
      message = '请输入验证码';
      $focus = $vcode;
    }

    if (message) {
      BootstrapDialog.alert({
        title: '温馨提示',
        message: message,
        type: BootstrapDialog.TYPE_WARNING,
        closable: true,
        buttonLabel: '确定',
        callback: function (result) {
          setTimeout(function () {
            $focus.focus();
          }, 100);
        }
      });
      return false;
    }
  });
});
</script>
@stop
