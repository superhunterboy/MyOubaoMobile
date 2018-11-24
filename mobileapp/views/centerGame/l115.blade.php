@extends('l.ghome')

@section('title')
  {{ $sLotteryName }}
@parent
@stop

@section('game-config')
@parent
{{-- ------------------------
<script src="/assets/simulated/gameConfigData-l115.js"></script>
<script>
gameConfigData['jsPath'] = '/assets/dist/js/game/l115/';
gameConfigData['availableCoefficients'] = {
  "1.000": "2元",
  "0.100": "2角",
  "0.010": "2分"
  };
gameConfigData['defaultCoefficient'] = "0.100";
</script>
--------------------------- --}}
@stop

@section('game-self-config')
{{ script('betgame.Games.L115') }}
<script>
var GAMENAMESPACE = 'L115';
</script>
@stop
