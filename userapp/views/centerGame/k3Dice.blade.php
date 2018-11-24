@extends('l.base')

@section('title')
    {{$sLotteryName }}
@parent
@stop

@section ('styles')
@parent
    {{ style('jquery.jscrollpane')}}
    {{ style('gamedice')}}
    {{ style('k3-dice')}}
@stop

@section ('container')
	@include('w.top-header')
	@include('w.nav')
	<div class="main">

	<div class="dice-wrap">

		<div class="dice-panel">
			<div class="logo">{{ $sLotteryName }}</div>
			<div class="shortcuts">
				<a href="/help/7#88" target="_blank">游戏规则</a>
				<a href="{{route('bets.betform', 15)}}">切换到基础版</a>
			</div>
			<div class="lottery-info-number">
				<span id="J-lottery-info-number">-</span>期
			</div>
			<div class="lottery-status">
				<div class="soldout">停售中</div>
				<div class="lottery-countdown" id="J-lottery-countdown">
					<span data-time="m1" class="time-0"></span>
					<span data-time="m2" class="time-0"></span>
					<span class="time-colon"></span>
					<span data-time="s1" class="time-0"></span>
					<span data-time="s2" class="time-0"></span>
				</div>
			</div>
			<div class="lottery-number" id="J-lottery-info-balls">
				<span></span>
				<span></span>
				<span></span>
			</div>
			<div class="lottery-records">
				<div class="record-top">
					<a target="_blank" href="{{ route('user-trends.trend-view', [$iLotteryId]) }}">查看更多</a>
					<strong>开奖记录</strong>
				</div>
				<div class="record-content scroll-pane">
					<ul id="J-lottery-records">
						<li>
							<div class="rec1">
								<span class="dice-number dice-number-1">1</span>
								<span class="dice-number dice-number-3">3</span>
								<span class="dice-number dice-number-5">5</span>
							</div>
							<div class="rec2">15</div>
							<div class="rec3">大</div>
							<div class="rec4">单</div>
							<div class="rec5">045期</div>
						</li>
					</ul>
				</div>
			</div>
		</div>

		<div id="J-dice-sheet" class="dice-table"></div>

		<div class="dice-recycle"></div>

	</div>

</div>

<div class="dice-ctrl">
	<div class="dice-bar-wrap">
		<div id="J-dice-bar" class="dice-bar"></div>
		<input id="recharge-url" type="hidden" value="{{ route('user-recharges.quick', $iDefaultPaymentPlatformId) }}"></input>
	</div>
	<div class="game-history-wrap">
		<div class="game-history">
			<div class="history-top">
				<a target="_blank" class="history-more" href="{{ route('projects.index') }}">查看更多</a>
				<span class="history-close">&times;</span>
			</div>
			<div class="history-content">
				<iframe id="record-iframe" src="{{route('projects.mini-window', 16)}}" width="100%" height="220px" frameborder="0"></iframe>
			</div>
		</div>
	</div>
</div>
@stop

@section('scripts')
	<script type="text/javascript">var gameConfigData = {{ $sLotteryConfig }};</script>
@parent
{{ script('jquery.tmpl')}}
{{ script('dsgame.Tab')}}
{{ script('dsgame.Hover')}}
{{ script('dsgame.Select')}}
{{ script('dsgame.Countdown')}}
{{ script('dsgame.Timer')}}
{{ script('dsgame.Tip')}}
@stop

@section('end')
{{ script('jquery.longclick')}}
{{ script('jquery-ui-custom')}}
@parent
{{ script('dsgame.GameMessage')}}
{{ script('dsgame.Gamedices.K3.Config')}}
{{ script('dsgame.Gamedices')}}
@stop


