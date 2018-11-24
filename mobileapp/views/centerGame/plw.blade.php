@extends('l.ghome')

@section('title')
  {{ __($sLotteryName) }}
@parent
@stop

@section('game-config')
@parent
{{--
<!-- <script src="/assets/simulated/gameConfigData.js"></script> -->
<script>
gameConfigData['jsPath'] = '/assets/dist/js/game/ssc/';
// gameConfigData['availableCoefficients'] = {
//   "1.000": "2元",
//   "0.100": "2角",
//   "0.010": "2分"
//   };
gameConfigData['issueHistory'] = null;
</script>
--}}

@stop

@section('game-self-config')
{{ script('betgame.Games.SSC') }}
<script>
var GAMENAMESPACE = 'SSC';
</script>
@stop
