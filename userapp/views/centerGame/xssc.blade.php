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
	{{ script('dsgame.Games.nssc.min') }}
@stop