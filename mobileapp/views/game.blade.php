@extends('l.base')

@section('title')
游戏大厅
@parent
@stop

@section('styles')
@parent
{{ style('game') }}
@stop

@section('bodyClass')
<body class="game">
@stop

@section ('container')
<div class="main-page show-page">
  <div data-fixed-top class="top-nav media">
    <h1 class="media-body">游戏大厅</h1>
  </div>

  <div id="section">

    <div class="ds-tabs game-lobby-tabs">
      <ul class="nav nav-tabs nav-tabs3" role="tablist">
        <li class="active"><a href="#game-ssc" data-toggle="tab">时时彩</a></li>
        <li><a href="#game-11l5" data-toggle="tab">11选5</a></li>
        <li><a href="#game-other" data-toggle="tab">其他游戏</a></li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane fade in active" id="game-ssc">
          @foreach($allLotteries as $lottery)
          @if($lottery['series_id']==1 && $lottery['id']!=12)
          <a href="{{route('mobile-bets.betform', $lottery['id'])}}" class="item">
            <div class="item-left">
              <img src="/assets/dist/images/game/logo/{{$lottery['identifier']}}.png" alt="">
            </div>
            <div class="item-body">
              <h2>{{$lottery['name']}}</h2>
              @if($lottery['introduction'])
              <p>{{$lottery['introduction']}}</p>
              @endif
            </div>
            <div class="item-right"><span class="glyphicon glyphicon-menu-right"></span></div>
          </a>
          @endif
          @endforeach
        </div>
        <!-- 11选5 -->
        <div class="tab-pane fade" id="game-11l5">
          @foreach($allLotteries as $lottery)
          @if($lottery['series_id']==2)
          <a href="{{route('mobile-bets.betform', $lottery['id'])}}" class="item">
            <div class="item-left">
              <img src="/assets/dist/images/game/logo/{{$lottery['identifier']}}.png" alt="">
            </div>
            <div class="item-body">
              <h2>{{$lottery['name']}}</h2>
              @if($lottery['introduction'])
              <p>{{$lottery['introduction']}}</p>
              @endif
            </div>
            <div class="item-right"><span class="glyphicon glyphicon-menu-right"></span></div>
          </a>
          @endif
          @endforeach
        </div>
        <!-- 其他游戏 -->
        <div class="tab-pane fade" id="game-other">
        <?php 
        	$arr = array();
        	foreach ( $allLotteries as $lottery ){
		     $arr[] = $lottery ['series_id'];
			}
			array_multisort($arr, SORT_DESC, $allLotteries);
        ?>
          @foreach($allLotteries as $lottery)
          @if(in_array($lottery['series_id'], [13, 15]) || in_array($lottery['id'],[13,53]))
          <a href="{{route('mobile-bets.betform', $lottery['id'])}}" class="item">
            <div class="item-left">
              <img src="/assets/dist/images/game/logo/{{$lottery['identifier']}}.png" alt="">
            </div>
            <div class="item-body">
              <h2>{{$lottery['name']}}</h2>
              @if($lottery['introduction'])
              <p>{{$lottery['introduction']}}</p>
              @endif
            </div>
            <div class="item-right"><span class="glyphicon glyphicon-menu-right"></span></div>
          </a>
          @endif
          @endforeach
        </div>
      </div>
    </div>

  </div>

  @include('w.bottom-nav')
</div>
@stop

@section('scripts')
@parent
<script>

</script>
@stop
