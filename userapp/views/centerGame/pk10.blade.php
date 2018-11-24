@extends('l.ghome')

@section('title')
    {{$sLotteryName }}
@parent
@stop

@section ('centerGame')
<div id="J-balls-main-panel" class="number-section-balls-main-panel">
</div>
@stop

@section('scripts')
    <script type="text/javascript">var gameConfigData = {{ $sLotteryConfig }};</script>
    @parent
    {{ script('raphael-min')}}
    {{ script('marquee-min')}}
@stop


@section('end')

@parent
    {{ script('dsgame.Games.pk10.min')}}
<!--  <script src="/assets/js/game/pk10/dsgame.Games.PK10.js"></script>
  <script src="/assets/js/game/pk10/dsgame.Games.PK10.init.js"></script>
  <script src="/assets/js/game/pk10/dsgame.Games.PK10.config.js"></script>
  <script src="/assets/js/game/pk10/dsgame.Games.PK10.Message.js"></script>
  <script src="/assets/js/game/pk10/dsgame.Games.PK10.Danshi.js"></script>-->
@stop