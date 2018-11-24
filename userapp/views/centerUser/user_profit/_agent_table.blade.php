<table width="100%" class="table">
    <thead>
        <tr>
            <th>用户名</th>
            <th>日期</th>
            <th>充值总额</th>
            <th>提现总额</th>
            <th>销售总额</th>
            <th>中奖总额</th>
            <th>活动奖金总额</th>
            <th>返点总额</th>
            <th>游戏总盈亏</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $fTotalDeposit = 0;
        $fTotalWithdrawal = 0;
        $fTotalTurnover = 0;
        $fTotalPrize = 0;
        $fTotalBonus = 0;
        $fTotalCommission = 0;
        $fTotalProfit = 0;
        ?>
        @foreach ($datas as $data)
        <tr>
            <?php
            unset($search_params['parent_user']);
            $search_params['username'] = $data->username;
            ?>
            <td><a href="{{route('user-profits.index',$search_params) }}">{{ $data->username }}</a></td>
            <td>{{ $data->date }}</td>
            <td>{{ $data->deposit }}</td>
            <td>{{ $data->withdrawal }}</td>
            <td>{{ $data->turnover_formatted }}</td>
            <td>{{ $data->prize_formatted }}</td>
            <td>{{ $data->bonus_formatted }}</td>
            <td>{{ $data->commission_formatted }}</td>
            <td><span class="{{ $data->profit < 0 ? 'c-red' : 'c-green' }}">{{ ($data->profit < 0 ? '-' : '+') }}{{ number_format($data->profit, 2) }}</span></td>
        </tr>
        <?php
        $fTotalDeposit += $data->deposit;
        $fTotalWithdrawal += $data->withdrawal;
        $fTotalTurnover += $data->turnover;
        $fTotalPrize += $data->prize;
        $fTotalBonus += $data->bonus;
        $fTotalCommission += $data->commission;
        $fTotalProfit += $data->profit;
        ?>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td>本页资本变动</td>
            <td></td>
            <td>{{ number_format($fTotalDeposit,6) }}</td>
            <td>{{ number_format($fTotalWithdrawal,6) }}</td>
            <td>{{ number_format($fTotalTurnover,6) }}</td>
            <td>{{ number_format($fTotalPrize,6) }}</td>
            <td>{{ number_format($fTotalBonus,6) }}</td>
            <td>{{ number_format($fTotalCommission,6) }}</td>
            <td><span class="{{ $fTotalProfit < 0 ? 'c-red' : 'c-green' }}">{{ ($fTotalProfit < 0 ? '' : '+') }}{{ number_format($fTotalProfit,6) }}</span></td>
        </tr>
    </tfoot>
</table>

