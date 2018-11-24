
<!DOCTYPE HTML>
<html lang="en-US">
<head>
<meta charset="UTF-8">
<title>奖金组详情 --博狼娱乐</title>
{{ style('global')}}
{{ style('ucenter')}}
<style>
body {background-image:none;}
.table {width:80%;margin:20px auto;}
.table caption { text-align:center;font-size:14px;font-weight:bold;height:32px;line-height:32px;}
</style>
</head>
<body>
@if (isset($aLotteries))
<ul class="clearfix prize-set-row">
    @foreach ($aLotteries as $key => $sLotteryName)
    <li class="{{ ( isset($iCurrentLotteryId) and $iCurrentLotteryId == $key ) ? 'current' : '' }}">
        <a href="{{ route('user-user-prize-sets.prize-set-detail', [$iCurrentPrizeGroup,$key]) }}"><span class="name">{{ $sLotteryName }}</span><span class="group">{{ $iCurrentPrizeGroup }}</span></a>
    </li>
    @endforeach
</ul>
@endif
<!-- <div class="prompt-text">
    <table width="100%">
        <tr>
            <td class="text-center">{{ $iCurrentPrizeGroup }}<br /><span class="tip">&nbsp;&nbsp;&nbsp;当前奖金&nbsp;&nbsp;&nbsp;</span></td>
            @if (Session::get('is_agent'))
            <td class="text-center last"> -- {{-- $iWater --}}<br /><span class="tip">预计平均返点率</span></td>
            @endif
        </tr>
    </table>
</div> -->
@include('centerUser.userPrizeSet.lotteryPrizeSet')

</body>
</html>