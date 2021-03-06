@extends('l.base')

@section('title')
修改资金密码
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
      <a href="{{route('mobile-users.index')}}" class="history-back"><span class="unicode-icon-prev"></span></a>
    </div>
    <h1 class="media-body">修改资金密码</h1>
  </div>

  <div id="section">

    <div class="ds-form">
      <form action="{{ route('mobile-users.change-fund-password') }}" method="post">
        <input type="hidden" name="_method" value="PUT" />
        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
        <div class="ds-form-group">
          <label for="old_fund_password">输入旧资金密码</label>
          <input name="old_fund_password" id="old_fund_password" type="password" placeholder="请输入旧资金密码" required>
        </div>
        <div class="ds-form-group">
          <label for="fund_password">输入新资金密码</label>
          <input name="fund_password" id="fund_password" type="password" placeholder="请输入新资金密码" required>
        </div>
        <div class="ds-form-info ds-form-info-bottom">
          <span class="unicode-icon-info"></span>
          <!-- <span class="glyphicon glyphicon-info-sign"></span> -->
          <small>由字母和数字组成6-16个字符；且必须包含数字和字母，不允许连续三位相同，不能和资金密码相同</small>
        </div>
        <div class="ds-form-group">
          <label for="fund_password_confirmation">确认新资金密码</label>
          <input name="fund_password_confirmation" id="fund_password_confirmation" type="password" placeholder="确认新资金密码" required>
        </div>
        <div class="ds-form-button">
          <button class="ds-btn" type="submit">确认</button>
        </div>
      </form>
    </div>
  </div>
</div>
@stop 

@section('scripts')
@parent
<script>
$(function(){
  var touchEvent = DSGLOBAL['touchEvent'];
  var $old = $('#old_fund_password');
  var $new = $('#fund_password');
  var $confirm = $('#fund_password_confirmation');
  $('.ds-form-button button[type="submit"]').on(touchEvent, function(){
    var message = '';
    var password = $.trim($new.val());
    var $focus;
    if( $.trim($old.val()) == ''){
      message = '请输入旧资金密码';
      $focus = $old;
    }else if( password == '' ){
      message = '请输入新资金密码';
      $focus = $new;
    }else if( !(/^(?=.*\d+)(?=.*[a-zA-Z]+)(?!.*?([a-zA-Z0-9]{1})\1\1).{6,16}$/).test(password) ){
      message = '新资金密码格式不符合要求';
      $focus = $new;
    }else if( $.trim($confirm.val()) != password ){
      message = '两次输入的密码不一致';
      $focus = $confirm;
    }

    if( message ){
      BootstrapDialog.alert({
        title: '温馨提示',
        message: message,
        type: BootstrapDialog.TYPE_WARNING,
        closable: true,
        buttonLabel: '确定',
        callback: function(result) {
          setTimeout(function(){
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