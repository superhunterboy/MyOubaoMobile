<table width="100%" class="table">
    <thead>
        <tr>
            <th>用户名</th>
            <th>日期</th>
            <th>充值总额</th>
            <th>提现总额</th>
            <th>销售总额</th>
            <th>返点总额</th>
            <th>中奖总额</th>
            <th>游戏总盈亏</th>
        </tr>
    </thead>
    <tbody>
        <!-- current agent -->
<!--        <tr>
            <td>{{ $oAgentSumPerDay->username }}</td>
            <td>{{ $oAgentSumPerDay->date }}</td>
            <td>{{ '--' }}</td>
            <td>{{ '--' }}</td>
            <td>{{ number_format($oAgentSumPerDay->team_turnover, 4) }}</td>
            <td>{{ number_format($oAgentSumPerDay->commission, 4) }}</td>
            <td>{{ number_format($oAgentSumPerDay->team_profit, 4) }}</td>
            <td><span class="{{ $oAgentSumPerDay->team_profit < 0 ? 'c-red' : 'c-green' }}">{{ ($oAgentSumPerDay->team_profit < 0 ? '-' : '+') }}  {{ number_format(abs($oAgentSumPerDay->team_profit), 2) }}</span></td>
        </tr>-->
        <!-- current agent -->
        @foreach ($datas as $data)
        <?php
            // $fTotalDepositNum  = $data->is_agent ? $data->team_deposit : $data->deposit;
            // $fTotalWithdrawNum = $data->is_agent ? $data->team_withdrawal : $data->withdrawal;
            $fTotalTurnOverNum   = $data->is_agent ? $data->team_turnover   : $data->turnover;
            $fTotalPrizeNum      = $data->is_agent ? $data->team_prize      : $data->prize;
            $fTotalProfitNum     = $data->is_agent ? $data->team_profit     : $data->profit;
            $fTotalCommissionNum = $data->is_agent ? $data->team_commission : $data->commission;
        ?>
        <tr>
            <td>{{ $data->username }}</td>
            <td>{{ $data->date }}</td>
            <td>{{ '--' }}</td>
            <td>{{ '--' }}</td>
            <td>{{ number_format($fTotalTurnOverNum, 4) }}</td>
            <td>{{ number_format($fTotalCommissionNum, 4) }}</td>
            <td>{{ number_format($fTotalPrizeNum, 4) }}</td>
            <td><span class="{{ $fTotalProfitNum < 0 ? 'c-red' : 'c-green' }}">{{ ($fTotalProfitNum < 0 ? '-' : '+') }}  {{ number_format(abs($fTotalProfitNum), 2) }}</span></td>
        </tr>
        @endforeach
    </tbody>
</table>

