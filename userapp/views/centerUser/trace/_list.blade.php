<table width="100%" class="table" id="J-table">
    <thead>
        <tr>
            <th>订单编号</th>
            <th>用户名</th>
            <th>投注时间</th>
            <th>游戏与玩法</th>
            <th>追号信息</th>
            <th>追号金额（元）</th>
            <th>中奖即停</th>
            <th>状态</th>
        </tr>
    </thead>
    <tbody>
        <?php $fTotalAmount = $fFinishAmount = $fCancelAmount = 0; ?>
        @if (count($datas))
            @foreach ($datas as $data)
            <tr>
                <td><a href="{{ route('traces.view', $data->id) }}">{{ $data->serial_number }}</a></td>
                <td>{{$data->username}}</a></td>
                <td>{{$data->bought_at}}</a></td>
                <td>
                    <span class="c-important">{{ $aLotteries[$data->lottery_id] }}</span><br/>
                    <span>{{ $data->title }}</span>
                </td>
                <td>
                    <span class="cell-label">期号</span>{{ $data->start_issue }}<br/>
                    <span class="cell-label">追号</span>{{ $data->finished_issues }} / {{ $data->total_issues }}  期
                </td>
                <td>
                    <span class="c-important">总金额</span><dfn>￥</dfn><span class="c-important" data-money-format>{{ $data->amount_formatted }}</span><br/>
                    <span>已完成</span><dfn>￥</dfn><span data-money-format>{{ $data->finished_amount_formatted }}</span><br/>
                    <span class="c-gray">已取消</span><dfn>￥</dfn><span class="c-gray" data-money-format>{{ $data->canceled_amount_formatted }}</span>
                </td>
                <!-- <td><span class="ui-status-no">终止</span></td>
                <td><span class="status-wait">已完成</span></td> -->
                <td>{{ $data->formatted_stop_on_won }}</td>
                <td>{{ $data->formatted_status }}</td>
            </tr>
            <?php $fTotalAmount += $data->amount; ?>
            <?php $fFinishAmount += $data->finished_amount; ?>
            <?php $fCancelAmount += $data->canceled_amount; ?>
            @endforeach
        @else
            <tr><td colspan="10">没有符合条件的记录，请更改查询条件</td></tr>
        @endif

    </tbody>
    <tfoot>
        <tr>
            @if (isset($bHasSumRow) && $bHasSumRow)
            <td colspan="8" class="text-center">
                <span>小结</span>&nbsp;&nbsp;&nbsp;&nbsp;
                <span class="c-important">总金额</span><dfn>￥</dfn><span class="c-important" data-money-format>{{ number_format($fTotalAmount, 2) }}</span>&nbsp;&nbsp;&nbsp;&nbsp;
                <span>已完成</span><dfn>￥</dfn><span data-money-format>{{ number_format($fFinishAmount, 2) }}</span>&nbsp;&nbsp;&nbsp;&nbsp;
                <span class="c-gray">已取消</span><dfn>￥</dfn><span class="c-gray" data-money-format>{{ number_format($fCancelAmount, 2) }}</span>
            </td>
            @endif
        </tr>
    </tfoot>
</table>