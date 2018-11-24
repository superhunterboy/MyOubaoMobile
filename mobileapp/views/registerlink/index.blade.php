@extends('l.base')

@section('title')
开户中心
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
    <h1 class="media-body">链接开户</h1>
    <div class="media-right media-middle">
      <a href="{{route('mobile-links.create')}}">
        <span class="glyphicon glyphicon-link"></span>
      </a>
    </div>
  </div>

  <div id="section">
    <div class="ds-cells text-center ds-cells-info">
      <div class="btn-group" role="group">
        <?php
          $sAgentClass =  $sPlayerClass = 'btn btn-default';
          if(Input::get('is_agent')){
            $sAgentClass .= ' btn-primary';
          }else{
            $sPlayerClass .= ' btn-primary';
          }
        ?>
        <a href="{{ route('mobile-links.index') }}?is_agent=1" class="{{$sAgentClass}}">代理</a>
        @if(!Session::get('is_top_agent'))<a href="{{ route('mobile-links.index') }}?is_agent=0" class="{{$sPlayerClass}}">玩家</a>@endif
      </div>
    </div>

    <div class="ds-cells">
    @if( count($datas) > 0 )
      @foreach ($datas as $data)
      <?php if( $data->title ){
        $title = $data->title;
      }else{
        $title = '开户链接[' . $data->id . ']';
      }?>
      <a href="{{ route('mobile-links.view', $data->id) }}" class="ds-cell">
        <div class="ds-cell-bd">
          <p class="c-light-dark">{{ $title }} - {{ $data->channel }}</p>
          <div class="ds-cell-bd-desc">
            <small class="c-gray">创建于:{{ $data->created_at }}</small>
            <small class="c-green">已注册({{ $data->created_count }})</small>
            <!-- <small class="c-gray">{{ $data->{$aListColumnMaps['status']} }}</small> -->
          </div>
        </div>
        <div class="ds-cell-ft"></div>
      </a>
      @endforeach
    @else
      <div class="ds-cell">
        <div class="ds-cell-bd">暂无数据
          <a href="{{route('mobile-links.create')}}">立即开户</a>
        </div>
      </div>
    @endif
    </div>

  </div>
</div>

@stop

@section('scripts')
@parent
<script>
$(function(){
  var touchEvent = DSGLOBAL['touchEvent'];
});
</script>
@stop
