@extends('l.base')

@section('title')
支付宝充值
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
      &nbsp;
    </div>
    <h1 class="media-body">充值</h1>
  </div>

  <div id="section">
    <div class="ds-form">
        <div class="ds-form-group" style="color: green; text-align: center;">充值申请成功!</div>
        <br><div class="ds-btn"">
        <a href="/mobile-users/index" style="color: rgb(255, 255, 255); text-decoration: none;">返回个人中心</a>
        </div>
    </div>
  </div>
</div>
@stop
