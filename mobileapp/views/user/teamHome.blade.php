@extends('l.base')

@section('title')
综合统计
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
        <a href="{{ route('mobile-users.index') }}" class="history-back"><span class="unicode-icon-prev"></span></a>
    </div>
    <h1 class="media-body">综合统计</h1>
</div>

<div id="section">
    <div class="overall-list">
    <table width="98%" class="table">
    <tr>
        <td>总下级人数：</td>
        <td style="text-align: left"><code>{{$iSubUserCount}}</code></td>
    </tr>
    <tr>
        <td>今日新注册人数：</td>
        <td style="text-align: left"><code>{{$iRegistUserCount}}</code></td>
    </tr>
    <tr>
        <td>当前在线人数：</td>
        <td style="text-align: left"><code>{{$iTeamOnlineCount}}</code></td>
    </tr>
    <tr>
        <td>团队今日投注人数：</td>
        <td style="text-align: left"><code>{{ $iTeamTodayBetUsers }}</code></td>
    <tr>
    <tr>
        <td>团队今日首充人数：</td>
        <td style="text-align: left"><code>{{ $iTeamDepositUsers }}</code></td>
    <tr>
    <tr>
        <td>团队历史投注人数：</td>
        <td style="text-align: left"><code>{{$iTeamHistoryBetUsers}}</code></td>
    <tr>
    <tr>
        <td>团队总余额：</td>
        <td style="text-align: left"><code>{{number_format($fTeamAvailableBalance,2,'.','')}}</code></td>
    </tr>
    <tr>
        <td>团队今日投注总额：</td>
        <td style="text-align: left"><code>
        @if($aTeamProfit)
        {{ number_format($aTeamProfit->turnover,2,'.','') }}
        @else
        0.00
        @endif</code></td>
    <tr>
    <tr>
        <td>团队今日中奖金额：</td>
        <td style="text-align: left"><code>
        @if($aTeamProfit)
        {{ number_format($aTeamProfit->prize,2,'.','') }}
        @else
        0.00
        @endif</code></td>
    </tr>
    <tr>
        <td>团队今日返点总额：</td>
        <td style="text-align: left"><code>@if($aTeamProfit) {{ number_format($aTeamProfit->commission,2,'.','') }} @else 0.00 @endif</code></td>
    </tr>
	<tr>
        <td>团队今日盈亏总额：</td>
        <td style="text-align: left"><code>@if($aTeamProfit) {{ number_format($aTeamProfit->profit,2,'.','') }} @else 0.00 @endif</code></td>
    </tr>
    <tr>
        <td>团队今日充值总额：</td>
        <td style="text-align: left"><code>@if($aTeamProfit){{ number_format($aTeamProfit->deposit,2,'.','') }}@else 0.00 @endif</code></td>
    </tr>
    <tr>
        <td>团队今日提现总额：</td>
        <td style="text-align: left"><code>@if($aTeamProfit){{ number_format($aTeamProfit->withdrawal,2,'.','') }}@else 0.00@endif</code></td>
    </tr>
	<tr>
        <td>团队今日活动总额：</td>
        <td style="text-align: left"><code>@if($aTeamProfit){{ number_format($aTeamProfit->bonus,2,'.','') }}@else 0.00@endif</code></td>
    </tr>
	<tr>
        <td>彩票今日投注笔数：</td>
        <td style="text-align: left"><code>{{$iTeamTodayBets}}</code></td>
    </tr>
    <tr>
        <td>电子游戏投注笔数：</td>
        <td style="text-align: left"><code>{{$iTeamTodayCasinoBets}}</code></td>
    </tr>
    </table>
    </div>
</div>
</div>
@stop
