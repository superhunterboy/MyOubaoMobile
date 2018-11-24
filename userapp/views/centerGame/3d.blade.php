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
	{{ script('dsgame.Games.SSC') }}
	{{ script('dsgame.Games.SSC.init') }}
	{{ script('dsgame.Games.SSC.config') }}
	{{ script('dsgame.Games.SSC.Danshi') }}
	{{ script('dsgame.Games.SSC.Message') }}
@stop