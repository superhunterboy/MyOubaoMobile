@extends('l.base')

@section('title')
绑定银行卡
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
      <a href="{{route('mobile-user-bank-cards.index')}}" class="history-back"><span class="unicode-icon-prev"></span></a>
    </div>
    <h1 class="media-body">绑定银行卡</h1>
  </div>

  <div id="section">

    <div class="ds-form">
      {{--
      <ol class="breadcrumb breadcrumb-top">
        @if($iBindedCardsNum>0)<li>验证卡</li>@endif
        <li class="active"><a href="javascript:void(0);">添加卡</a></li>
        <li>确认信息</li>
        <li>绑卡成功</li>
      </ol>
      --}}

      <form action="{{ route('mobile-user-bank-cards.bind-card', 2) }}" method="post" autocomplete="off">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <div class="ds-cells dropdown" data-bank-list>
          <div class="ds-cell dropdown-toggle" data-toggle="dropdown">
            <div class="ds-cell-hd">
              <div class="ds-cell-icon bank-icon-box">
                <i data-choose-bank-icon class="bank-icon-icbc"></i>
              </div>
            </div>
            <div class="ds-cell-bd">
              <!-- <span data-choose-bank-name>中国工商银行</span> -->
              <input type="text" readonly name="bank" data-choose-bank-name value="{{ Input::old('bank') }}" required>
              <input type="hidden" name="bank_id" data-choose-bank-id required>
            </div>
            <div class="ds-cell-ft">选择开户行</div>
          </div>
          <div class="dropdown-menu dropdown-menu-bank-list">
          @foreach($aBanks as $oBank)
          <div class="ds-cell" data-bank-name="{{ $oBank->name }}" data-bank-icon="{{ strtolower($oBank->identifier) }}" data-bank-id="{{ $oBank->id }}">
            <div class="ds-cell-hd">
              <div class="ds-cell-icon bank-icon-box">
                <i class="bank-icon-{{ strtolower($oBank->identifier) }}"></i>
              </div>
            </div>
            <div class="ds-cell-bd">
              {{ $oBank->name }}
            </div>
          </div>
          @endforeach
          </div>
        </div>

        <div class="ds-form-group">
          <label for="branch-name">开户行区域</label>
          <div class="dropdown">
            <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">
              <span data-choose-provice>选择省份</span>
              <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" data-province-content>
              <!-- <li><a data-id="1">北京</a></li> -->
            </ul>
          </div>
          <input name="province_id" id="province-id" type="hidden" required>
          <input name="province" id="province-name" type="hidden" required>
          <span>&nbsp;</span>
          <div class="dropdown">
            <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">
              <span data-choose-city>选择城市</span>
              <span class="caret"></span>
            </button>
            <ul class="dropdown-menu dropdown-menu-right" data-city-content>
              <!-- <li><a data-id="1">东城区</a></li> -->
            </ul>
          </div>
          <input name="city_id" id="city-id" type="hidden" required>
          <input name="city" id="city-name" type="hidden" required>
        </div>

        <div class="ds-form-group">
          <label for="branch-name">支行名称</label>
          <input name="branch" id="branch-name" type="text" placeholder="请输入支行名称" value="{{ Input::old('branch') }}" required>
        </div>

        <div class="ds-form-group">
          <label for="account-name">开户人姓名</label>
          <input name="account_name" id="account-name" type="text" placeholder="请输入开户人姓名" value="{{ Input::old('account_name') }}" required>
        </div>
        <div class="ds-form-group">
          <label for="card-number">银行卡号</label>
          <input name="account" id="card-number" type="text" placeholder="请输入银行卡号" value="{{ Input::old('account') }}" required>
        </div>

        <div class="ds-form-group">
          <label for="card-number-confirmation">确认卡号</label>
          <input name="account_confirmation" id="card-number-confirmation" type="text" placeholder="请确认银行卡号" value="{{ Input::old('account_confirmation') }}" required>
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
{{ script('districts') }}
<script>
$(function(){

  var touchEvent = DSGLOBAL['touchEvent'];
  var $cardNumber = $('#card-number, #card-number-confirmation');
  var $bankName = $('[data-choose-bank-name]');
  var $bankId = $('[data-choose-bank-id]');
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
    var $bankId = $('input[name="bank_id"]');
    var $bankName = $('input[name="bank"]');
    var $bankBranchName = $('#branch-name');
    var $username = $('#account-name');
    var $cardNumber = $('#card-number');
    var $cardNumber2 = $('#card-number-confirmation');
    var $provinceId = $('#province-id');
    var $cityId = $('#city-id');
    var $focus = $(null);

    if( !$bankId.val() || !$bankName.val() ){
      message = '请选择开户银行';
    }
    else if( !$provinceId.val() ){
      message = '请选择开户银行省份';
    }
    else if( !$cityId.val() ){
      message = '请选择开户银行城市';
    }
    else if( !$.trim($bankBranchName.val()) ){
      message = '请填写支行名称';
      $focus = $bankBranchName;
    }
    else if( !$.trim($username.val()) ){
      message = '请填写开户人姓名';
      $focus = $username;
    }
    else if( !$.trim($cardNumber.val()) ){
      message = '请填写银行卡号';
      $focus = $cardNumber;
    }
    else if( !$.trim($cardNumber2.val()) ){
      message = '请填写确认银行卡号';
      $focus = $cardNumber2;
    }
    else if( $cardNumber.val().replace(/\s/g,'').length < 16){
      message = '银行卡卡号由16、18或19位数字组成';
      $focus = $cardNumber;
    }
    else if( $.trim($cardNumber.val()) != $.trim($cardNumber2.val())){
      message = '两次填写的银行卡号不一致';
      $focus = $cardNumber2;
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
  $('.dropdown-menu-bank-list .ds-cell').on(touchEvent, function(){
    if( $(this).hasClass('active') ) return false;
    var name = $(this).data('bank-name');
    var icon = $(this).data('bank-icon');
    var id = $(this).data('bank-id');
    $('[data-choose-bank-icon]').removeClass().addClass('bank-icon-' + icon);
    $('[data-choose-bank-name]').val(name);
    $('[data-choose-bank-id]').val(id);
    $(this).addClass('active').siblings().removeClass('active');
  }).eq(0).trigger(touchEvent);

  // 省市渲染
  var $provinceSelector = $('[data-province-content]');
  var $citySelector = $('[data-city-content]');
  var renderSelector = function(data){
    var html = [];
    $.each(data, function(key, value){
      html.push('<li data-id="' +value['id']+ '" data-name="' +value['name']+ '"><a>' + value['name'] + '</a></li>');
    });
    $provinceSelector.html(html.join(''));
  };
  var renderCity = function(data){
    var html = [];
    if( data ){
      $.each(data, function(idx, value){
        html.push('<li data-id="' +value['id']+ '" data-name="' +value['name']+ '"><a>' + value['name'] + '</a></li>');
      });
    }else{
      html.push('<li><a>请选择开户银行城市</a></li>');
    }
    $citySelector.html(html.join(''));
  };

  // init
  renderSelector(dsDistricts);
  renderCity();

  $provinceSelector.on(touchEvent, '[data-id]', function(e){
    if( $(this).hasClass('active') ) return false;
    var id = $(this).data('id');
    var name = $(this).data('name');
    $('[data-choose-provice]').text(name);
    $('#province-name').val(name);
    $('#province-id').val(id);
    renderCity( dsDistricts[id]['children'] );
    $(this).addClass('active').siblings().removeClass('active');
  });

  $citySelector.on(touchEvent, '[data-id]', function(e){
    if( $(this).hasClass('active') ) return false;
    var id = $(this).data('id');
    var name = $(this).data('name');
    $('[data-choose-city]').text(name);
    $('#city-name').val(name);
    $('#city-id').val(id);
    $(this).addClass('active').siblings().removeClass('active');
  });
});
</script>
@stop
