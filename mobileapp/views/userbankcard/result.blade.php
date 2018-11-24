@extends('l.base')

@section('title')
绑卡{{$bSucceed ? '成功': '失败'}}
@parent
@stop

@section('styles')
  @parent
  {{ style('ucenter') }}
@stop

@section ('container')
<div class="main-page show-page">
  <div data-fixed-top class="top-nav media">
    <h1 class="media-body">绑卡{{$bSucceed ? '成功': '失败'}}</h1>
  </div>

  <div id="section">

    <div class="ds-form">
      {{--
      <ol class="breadcrumb breadcrumb-top">
        @if($iBindedCardsNum>0)<li>验证卡</li>@endif
        <li>添加卡</li>
        <li>确认信息</li>
        <li class="active"><a href="javascript:void(0);">绑卡{{$bSucceed ? '成功': '失败'}}</a></li>
      </ol>
      --}}

      @if ($bSucceed)
      <div class="form-submit-callback media">
        <div class="media-left media-middle">
          <span class="glyphicon glyphicon-ok-circle"></span>
        </div>
        <div class="media-body">
          <h2>绑卡成功！</h2>
          <p>新的银行卡可以立即发起“平台提现”</p>
        </div>
      </div>
      
      <div class="ds-form-button ds-button-group-2">
        <a href="{{ route('mobile-user-bank-cards.bind-card', 0) }}" target="_top" class="ds-btn btn-primary">继续绑卡</a>
        <a href="{{ route('mobile-user-bank-cards.index') }}" target="_top" class="ds-btn">银行卡管理</a>
      </div>
      @else
      <div class="form-submit-callback media">
        <div class="media-left media-middle">
          <span class="glyphicon glyphicon-remove-circle"></span>
        </div>
        <div class="media-body">
          <h2>绑卡失败！</h2>
        </div>
      </div>
      <div class="ds-form-button">
        <a href="{{ route('mobile-user-bank-cards.bind-card', 0) }}" class="ds-btn">重新绑定</a>
      </div>
      @endif
    </div>

  </div>
</div>
@stop 

@section('scripts')
@parent
{{ script('districts') }}
<script>
$(function(){
  
  
});
</script>
@stop
