@extends('l.base')

@section('title')
验证老银行卡
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
        <a onclick="history.back();" class="left history-back"><span class="unicode-icon-prev"></span></a>
    </div>
    <h1 class="media-body">验证老银行卡</h1>
  </div>

  <div id="section">

    <div class="ds-form">
      {{--
      <ol class="breadcrumb breadcrumb-top">
        @if($iBindedCardsNum>0)<li class="active"><a href="javascript:void(0);">验证卡</a></li>@endif
        <li>添加卡</li>
        <li>确认信息</li>
        <li>绑卡成功</li>
      </ol>
      --}}

      <?php (isset($iCardId) && $iCardId) ? $url = route('mobile-user-bank-cards.modify-card', [0, $iCardId]) : $url = route('mobile-user-bank-cards.bind-card', 0); ?>
      <form action="{{ $url }}" method="post" autocomplete="off">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        @if(isset($iCardId) && $iCardId)
        <div class="ds-form-group">
          <label>银行卡号</label>
          <input type="hidden" name="id" value="{{ $data->id }}">
          <span>{{ $data->account_hidden }}</span>
        </div>
        @else
        <div class="ds-form-group">
          <label>选择银行卡</label>
          <div class="dropdown">
            <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">
              <span data-choose-card-number>选择要验证的银行卡</span>
              <input type="hidden" name="id" value data-choose-card-id>
              <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" data-card-content>
              @foreach ($aBindedCards as $key => $oCard)
              <li data-id="{{ $oCard->id }}" {{ $oCard->id == Input::get('id') ? 'data-init' : '' }} data-number="{{ $oCard->account_hidden }}"><a>{{ $oCard->account_hidden }}</a></li>
              @endforeach
            </ul>
          </div>
        </div>
        @endif

        <div class="ds-form-group">
          <label for="account-name">开户人姓名</label>
          <input name="account_name" id="account-name" type="text" placeholder="请输入开户人姓名" value="{{ Input::get('account_name') }}" required>
        </div>
        <div class="ds-form-group">
          <label for="card-number">银行卡号</label>
          <input name="account" id="card-number" type="text" placeholder="请输入银行卡号" value="{{ Input::get('account') }}" required>
        </div>
        <div class="ds-form-group">
          <label for="fund-password">资金密码</label>
          <input name="fund_password" id="fund-password" type="password" placeholder="请输入资金密码" value="" required>
        </div>

        <div class="ds-form-button">
          <button class="ds-btn" type="submit">下一步</button>
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
  var $cardNumber = $('#card-number');
  var makeBigNumber = function(str){
    var str = str.replace(/\s/g, '').split(''),
        len = str.length,
        i = 0,
        newArr = [];
    for(;i < len;i++){
      if(i%4 == 0 && i != 0){
        newArr.push(' ');
        newArr.push(str[i]);
      }else{
        newArr.push(str[i]);
      }
    }
    return newArr.join('');
  };

  // 银行卡
  $cardNumber.on({
    keyup: function(e){
      var el = $(this),v = this.value.replace(/^\s*/g, ''),arr = [],code = e.keyCode;
      if(code == 37 || code == 39){
        return;
      }
      v = v.replace(/[^\d|\s]/g, '').replace(/\s{2}/g, ' ');
      this.value = v;
      if(v == ''){
        v = '&nbsp;';
      }else{
        v = makeBigNumber(v);
        v = v.substr(0, 23);
        this.value = v;
      }
    },
    focus: function(){
      var el = $(this),v = $.trim(this.value);
      if(v == ''){
        v = '&nbsp;';
      }else{
        v = makeBigNumber(v);
      }
    },
    blur: function(){
      this.value = makeBigNumber(this.value);
    }
  });

  // 表单
  $('.ds-form-button button[type="submit"]').on(touchEvent, function(){
    var message = '';
    var $cardId = $('[data-choose-card-id]');
    var $username = $('#account-name');
    var $cardNumber = $('#card-number');
    var $fundPassword = $('#fund-password');
    var $focus = $(null);

    if( !$cardId.val() ){
      message = '请选择你要验证的银行卡';
    }
    else if( !$.trim($username.val()) ){
      message = '请填写开户人姓名';
      $focus = $username;
    }
    else if( !$.trim($cardNumber.val()) ){
      message = '请填写银行卡号';
      $focus = $cardNumber;
    }
    else if( $cardNumber.val().replace(/\s/g,'').length < 16){
      message = '银行卡卡号由16、18或19位数字组成';
      $focus = $cardNumber;
    }
    else if( !$.trim($fundPassword.val()) ){
      message = '请输入您的资金密码';
      $focus = $fundPassword;
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

  // 银行渲染
  $('[data-card-content]').on(touchEvent, '[data-id]', function(){
    if( $(this).hasClass('active') ) return false;
    var id = $(this).data('id');
    var number = $(this).data('number');
    $('[data-choose-card-number]').text(number);
    $('[data-choose-card-id]').val(id);
    $(this).addClass('active').siblings().removeClass('active');
  }).find('[data-init]').trigger(touchEvent);

});
</script>
@stop
