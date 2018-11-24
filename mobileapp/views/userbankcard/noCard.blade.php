@extends('l.base')

@section('title')
银行卡管理
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
    <h1 class="media-body">银行卡管理</h1>
    <div class="media-right media-middle">
      <span class="unicode-icon-info"></span>
      <!-- <span class="glyphicon glyphicon-info-sign"></span> -->
    </div>
  </div>

  <div id="section">

    <div class="ds-form">
      <div class="form-status-tips">
        <span class="glyphicon glyphicon-credit-card"></span>
        <p>您还没有绑定银行卡</p>
      </div>
      <div class="ds-form-button">
        <a class="ds-btn" href="{{route('mobile-user-bank-cards.bind-card',1)}}">立即绑卡</a>
      </div>
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
    $(this).addClass('card-checked').siblings('.card-checked').removeClass('card-checked');
    return false;
  }).eq(0).trigger('click');
});
</script>
@stop