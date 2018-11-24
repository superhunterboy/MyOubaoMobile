<table width="100%" class="table" id="J-table">
    <thead>
        <tr>
            <th>订单编号</th>
            <th>用户名</th>
            <th>游戏与玩法</th>
            <th>投注奖金组</th>
            <th>注单信息</th>
            <th>投注号码</th>
            <th>开奖号码</th>
            <th>注单金额（元）</th>
            <th>奖金（元）</th>
            <th>状态</th>
        </tr>
    </thead>
    <tbody>
        <?php $fTotalAmount = $fTotalPrize = 0; ?>

        @if (count($datas))

            @foreach ($datas as $data)
            <tr>
                <td><a href="{{route('projects.view', $data->id)}}">{{ $data->serial_number }}</td>
                <td>{{ $data->username }}</td>
                <td>
                    <span class="c-important">{{ $aLotteries[$data->lottery_id] }}</span><br/>
                    <span>{{ $data->title }}</span>
                </td>
                <td>
                    {{ $data->prize_group }}
                </td>
                <td>
                    <span class="cell-label">期号</span>{{ $data->issue }}<br/>
                </td>
                <td>
                    @if ( strlen( $data->display_bet_number) > 5 )
                        <a class="view-detail" href="javascript:void(0);">详细号码</a><textarea class="data-textarea" style="display:none;">{{ $data->display_bet_number }} </textarea>
                    @else
                        {{ $data->display_bet_number }}
                    @endif
                </td>
                <td>
                    <span class="c-important">{{$data->winning_number}}</span>
                </td>
                <td><span data-money-format><dfn>￥</dfn>{{ $data->amount_formatted }}</span></td>
                <!--判断是否有奖金-->
                @if( $data->prize_formatted )
                <td><dfn>￥</dfn><span class="c-important" data-money-format>{{ $data->prize_formatted }}</span></td>
                <td><span class="c-important">{{ $data->formatted_status }}</span></td>
                @else
                <td>{{ $data->prize_formatted }}</td>
                <td>{{ $data->formatted_status }}</td>
                @endif
            </tr>
            <?php $fTotalAmount += $data->amount; ?>
            <?php $fTotalPrize += $data->prize; ?>
            @endforeach
        @else
            <tr><td colspan="10">没有符合条件的记录，请更改查询条件</td></tr>
        @endif
    </tbody>
    <tfoot>
        @if (isset($bHasSumRow) && $bHasSumRow)
            <td>小结</td>
            <td colspan="6">&nbsp;</td>
            <td>
                <dfn>￥</dfn><span class="c-important" data-money-format>{{ number_format($fTotalAmount,2) }}</span>
            </td>
            <td>
                <dfn>￥</dfn><span class="c-important" data-money-format>{{ number_format($fTotalPrize,4) }}</span>
            </td>
            <td>&nbsp;</td>
        @endif
    </tfoot>
</table>