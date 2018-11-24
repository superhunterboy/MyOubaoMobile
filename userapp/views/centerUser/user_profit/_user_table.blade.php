<table width="100%" class="table">
    <thead>
        <tr>
            <th>时间</th>
            <th>充值总额</th>
            <th>提现总额</th>
            <th>投注总额</th>
            <th>中奖总额</th>
            <th>游戏总盈亏</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $fTotalDepositNum = $fTotalWithdrawNum = $fTotalBetNum = $fTotalPrizeNum = $fTotalProfitNum = 0;
        ?>
        @foreach ($datas as $data)
        <tr>
            <td>{{ $data->date }}</td>
            <td>{{ $data->deposit }}</td>
            <td>{{ $data->withdrawal }}</td>
            <td>{{ $data->turnover_formatted }}</td>
            <td>{{ $data->prize_formatted }}</td>
            <td><span class="{{ $data->profit < 0 ? 'c-red' : 'c-green' }}">{{ ($data->profit < 0 ? '-' : '+') }}  {{ number_format(abs($data->profit), 4) }}</span></td>
        </tr>
        <?php
        $fTotalDepositNum += $data->deposit;
        $fTotalWithdrawNum += $data->withdrawal;
        $fTotalBetNum += $data->turnover;
        $fTotalPrizeNum += $data->prize;
        $fTotalProfitNum += $data->profit;
        ?>
        @endforeach
        @if($datas->getTotal()>0)
    <tfoot>
        <tr>
            <td>小结</td>
            <td><span>{{ number_format($fTotalDepositNum, 2) }}</span></td>
            <td><span>{{ number_format($fTotalWithdrawNum, 2) }}</span></td>
            <td><span>{{ number_format($fTotalBetNum, 2) }}</span></td>
            <td><span>{{ number_format($fTotalPrizeNum, 2) }}</span></td>
            <td><span class="{{ $fTotalProfitNum < 0 ? 'c-red' : 'c-green' }}">{{ ($fTotalProfitNum < 0 ? '-' : '+') }}  {{ number_format(abs($fTotalProfitNum), 2) }}</span></td>
        </tr>
    </tfoot>
    @endif
</tbody>
</table>