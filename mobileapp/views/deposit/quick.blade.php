@extends('l.base')

@section('title')
充值
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
    <h1 class="media-body">充值</h1>
    {{--<div class="media-right media-middle">
      <span class="unicode-icon-info"></span>
      <!-- <span class="glyphicon glyphicon-info-sign"></span> -->
    </div>--}}
  </div>

  <div id="section">

    <div class="ds-form">
      <form action="{{ route('mobile-deposits.quick') }}" method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="deposit_mode" value="{{ UserDeposit::DEPOSIT_MODE_THIRD_PART }}">

        <div class="ds-cells dropdown">
          <div class="ds-cell dropdown-toggle" data-toggle="dropdown">
            <div class="ds-cell-bd">
              <span class="way-img way-img-{{PaymentPlatform::$aIconTypes[$oPlatform->icon]}}" data-choose-platform-name></span>
              <span class="way-text">{{ $oPlatform->display_name }}</span>
              <input type="hidden" name="platform" data-choose-platform-id value="{{ $oPlatform->id }}" required>
            </div>
            <div class="ds-cell-ft">选择充值渠道</div>
          </div>
          <div class="dropdown-menu dropdown-menu-platform-list">
          {{--
          @if($isOpenBankDeposit)
          <!-- <div class="ds-cell">
            <div class="ds-cell-bd">
              <span>银行卡充值</span>
            </div>
          </div> -->
          @endif
          --}}
          @foreach ($oPlatforms as $oNavPlatform)
          <!-- <div class="ds-cell" -->
          <a class="ds-cell {{ $oNavPlatform->id == $oPlatform->id ? 'active' : '' }}"
            href="{{ route('mobile-deposits.quick', $oNavPlatform->id) }}"
            data-platform-id="{{ $oNavPlatform->id }}"
            data-platform-name="{{ $oNavPlatform->display_name }}"
            data-bank-need="{{$oNavPlatform->need_bank}}"
          >
            <div class="ds-cell-bd">
              <span class="way-img way-img-{{PaymentPlatform::$aIconTypes[$oNavPlatform->icon]}}" ></span>
              <span class="way-text">{{ $oNavPlatform->display_name }}</span>
            </div>
          <!-- </div> -->
          </a>
          @endforeach
          </div>
        </div>
        {{--
        <!-- <div class="ds-form-title">
          <span>选择充值银行</span>
        </div>

        <div class="ds-form-group">
          <div class="media card-detail">
            <div class="media-left bank-icon-box">
              <i class="bank-icon-cmb"></i>
            </div>
            <div class="media-body media-middle">
              <h3>招商银行</h3>
              <p>
                <span>尾号88888快捷</span>
                <a data-unbind-card href="">解除绑定</a>
              </p>
            </div>
            <div class="media-right media-middle">
              <span class="glyphicon glyphicon-ok"></span>
            </div>
          </div>

          <div class="media card-detail">
            <div class="media-left bank-icon-box">
              <i class="bank-icon-icbc"></i>
            </div>
            <div class="media-body media-middle">
              <h3>工商银行</h3>
              <p>
                <span>尾号88888快捷</span>
                <a data-unbind-card href="">解除绑定</a>
              </p>
            </div>
            <div class="media-right media-middle">
              <span class="glyphicon glyphicon-ok"></span>
            </div>
          </div>
        </div> -->
        --}}
        @if($oPlatform->need_bank)
        <div class="ds-cells dropdown fade in" data-bank-list>
          <div class="ds-cell" data-toggle="dropdown">
            <div class="ds-cell-hd">
              <div class="ds-cell-icon bank-icon-box">
                <i data-choose-bank-icon class="bank-icon-icbc"></i>
              </div>
            </div>
            <div class="ds-cell-bd">
              <span data-choose-bank-name>中国工商银行</span>
              <input type="hidden" name="bank" data-choose-bank-id required>
            </div>
            <div class="ds-cell-ft">选择银行卡</div>
          </div>
          <div class="dropdown-menu dropdown-menu-bank-list">
          @foreach($oAllBanks as $oBank)
          <div class="ds-cell" data-bank-name="{{ $oBank->name }}" data-bank-icon="{{ strtolower($oBank->identifier) }}" data-bank-id="{{ $oBank->id }}">
            <div class="ds-cell-hd">
              <div class="ds-cell-icon bank-icon-box">
                <i class="bank-icon-{{ strtolower($oBank->identifier) }}"></i>
              </div>
            </div>
            <div class="ds-cell-bd">
              <span>{{ $oBank->name }}</span>
            </div>
          </div>
          @endforeach
          </div>
        </div>
        @endif

        <div class="ds-form-info ds-form-info-top">
          <span class="unicode-icon-info"></span>
          <!-- <span class="glyphicon glyphicon-info-sign"></span> -->
          <span><small>单次最低充值{{ $fMinLoad }}元，最高{{ $fMaxLoad }}元，请在30分钟内完成</small></span>
        </div>
        <div class="ds-form-group">
          <label for="money-amount">充值金额</label>
          <input name="amount" id="money-amount" type="number" placeholder="请输入充值金额" required>
        </div>
        @if($bCheckFundPassword)
        <div class="ds-form-group">
          <label for="funds-passowrd">资金密码</label>
          <input name="fund_password" id="fund-password" type="password" placeholder="请输入资金密码" required>
        </div>
        @endif
        <div class="ds-form-button">
          <button class="ds-btn" type="submit">立即充值</button>
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
  {{--
  // $('.dropdown-menu-platform-list .ds-cell').on(touchEvent, function(){
  //   if( $(this).hasClass('active') ) return false;
  //   var name = $(this).data('platform-name');
  //   var id = $(this).data('platform-id');
  //   var bankneed = $(this).data('bank-need');
  //   $('[data-choose-platform-name]').text(name);
  //   $('[data-choose-platform-id]').val(id);
  //   $(this).addClass('active').siblings().removeClass('active');
  //   if( bankneed ){
  //     $('[data-bank-list]').removeClass('hide').addClass('in');
  //   }else{
  //     $('[data-bank-list]').addClass('hide').removeClass('in');
  //   }
  // }).filter('[data-platform-id="{{$iPlatformId}}"]').trigger(touchEvent);
  --}}

  @if($oPlatform->need_bank)
  $('.dropdown-menu-bank-list .ds-cell').on(touchEvent, function(){
    if( $(this).hasClass('active') ) return false;
    var name = $(this).data('bank-name');
    var icon = $(this).data('bank-icon');
    var id = $(this).data('bank-id');
    $('[data-choose-bank-icon]').removeClass().addClass('bank-icon-' + icon);
    $('[data-choose-bank-name]').text(name);
    $('[data-choose-bank-id]').val(id);
    $(this).addClass('active').siblings().removeClass('active');
  }).eq(0).trigger(touchEvent);
  @endif

  $('.ds-form-button button[type="submit"]').on(touchEvent, function(){
    var message = '';
    var $platformId = $('[data-choose-platform-id]');
    var $bankId = $('[data-choose-bank-id]');
    var $moneyInput = $('#money-amount');
    var $password = $('#fund-password');
    var moneyMin = Number('{{$fMinLoad}}'.replace(/,/g, ''));
    var moneyMax = Number('{{$fMaxLoad}}'.replace(/,/g, ''));

    if( $platformId.val() == '' ){
      message = '请选择充值渠道';
    }
    else if( $bankId.val() == '' ){
      message = '请选择充值银行卡';
    }
    else if( $moneyInput.val() == '' ){
      message = '请输入充值金额';
    }
    else if( $moneyInput.val() < moneyMin || $moneyInput.val() > moneyMax ){
      message = '单次最低充值{{ $fMinLoad }}元，最高{{ $fMaxLoad }}元';
    }
    @if($bCheckFundPassword)
    else if( $.trim($password.val()) == '' ){
        message = '请输入资金密码';
    }
    @endif

    if( message ){
      BootstrapDialog.alert({
        title: '温馨提示',
        message: message,
        type: BootstrapDialog.TYPE_WARNING,
        closable: true,
        buttonLabel: '确定',
        callback: function(result) {
          // setTimeout(function(){
          //   $focus.focus();
          // }, 100);
        }
      });
      return false;
    }
  });
});
</script>
@stop
