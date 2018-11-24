@extends('l.base')

@section('title')
提现
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
      <a href="{{route('mobile-users.index')}}" class="left history-back"><span class="unicode-icon-prev"></span></a>
    </div>
    <h1 class="media-body">提现</h1>
    {{--
    <div class="media-right media-middle">
      <span data-toggle="modal" data-target="#withdrawInfoModal" class="unicode-icon-info"></span>
      <!-- <span class="glyphicon glyphicon-info-sign"></span> -->
    </div>
    --}}
  </div>

  <div id="section">

    <div class="ds-form">
      <form action="{{ route('mobile-withdrawals.withdraw', 1) }}" method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="step" value="1">

        <div class="ds-form-prompt">
          <p>今日剩余提现次数：<span class="c-highlight">{{ $iWithdrawLimitNum - $iWithdrawalNum }}</span> / {{ $iWithdrawLimitNum }}</p>
          <p>&nbsp;&nbsp;&nbsp;&nbsp;当前总余额：<big class="c-highlight" data-money-format>{{ $oAccount->available_formatted }}</big> 元</p>
          <p>&nbsp;&nbsp;&nbsp;&nbsp;可提现金额：<big class="c-highlight" data-money-format>{{ $oAccount->withdrawable_formatted }}</big> 元</p>
        </div>

        <div class="ds-form-title">
          <span>选择银行卡</span>
        </div>
        <div class="ds-form-group">
          @foreach($aBankCards as $oBankCard)
          <div class="media card-detail" data-id="{{ $oBankCard->id }}">
            <div class="media-left bank-icon-box">
              <i class="bank-icon-{{strtolower($aBanks[$oBankCard->bank_id])}}"></i>
            </div>
            <div class="media-body media-middle">
              <h3>{{$oBankCard->bank}}</h3>
              <p>
                <span>尾号：**** **** **** *** {{ substr($oBankCard->account,15)}}</span>&nbsp;<span>[ {{$oBankCard->formatted_account_name}} ]</span>
              </p>
            </div>
            <div class="media-right media-middle">
              <span class="glyphicon glyphicon-ok"></span>
            </div>
          </div>
          @endforeach
        </div>
        <input name="id" value="" data-choose-card-id type="hidden">

        <div class="ds-form-info ds-form-info-top">
          <span class="unicode-icon-info"></span>
          <!-- <span class="glyphicon glyphicon-info-sign"></span> -->
          <small>{{ $sWithdrawalTime }}期间提现，15分钟内到账</small>
        </div>
        <div class="ds-form-group">
          <label for="money-amount">提现金额</label>
          <input id="money-amount" name="amount" type="text" placeholder="请输入提现金额" required>
          <span>元</span>
        </div>
        <div class="ds-form-info ds-form-info-bottom">
          <span class="unicode-icon-info"></span>
          <!-- <span class="glyphicon glyphicon-info-sign"></span> -->
          <small>单笔最低提现金额
            <span class="c-highlight">{{ $iMinWithdrawAmount ? $iMinWithdrawAmount : 100.00 }}</span>元，最高
            <span class="c-highlight">{{ $iMaxWithdrawAmount ? $iMaxWithdrawAmount : 1500000.00}}</span>元
          </small>
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
  $('.card-detail').on('click', function(){
    if( $(this).hasClass('card-checked') ) return false;
    var id = $(this).data('id');
    $(this).addClass('card-checked').siblings('.card-checked').removeClass('card-checked');
    $('[data-choose-card-id]').val(id);
    return false;
  }).eq(0).trigger('click');
});
</script>
@stop
