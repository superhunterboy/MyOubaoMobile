</table><table width="100%" class="table">
    <thead>
        <tr>
            <th>编号</th>
            <th>时间</th>
            <th>账户</th>
            <th>金额</th>
            <th>实际提现</th>
            <th>手续费</th>
            <th>状态</th>
        </tr>
    </thead>
    <tbody>
        <?php $fTotalAmount = $fTotalTransAmount = $fTotalCharge = 0; ?>
        @foreach ($datas as $key => $data)
        <tr class="withdrawalRow">
            <td><a href="#" title="{{ $data->serial_number }}">{{ $data->serial_number_short }}</a></td>
            <td>
                {{ $data->request_time }}
            </td>
            <td>{{ $data->account_name }}</td>
            <td><span class="c-green amount"> {{ $data->formatted_amount }}</span></td>
            <td><span class="c-green transaction_amount"> {{ $data->formatted_transaction_amount }}</span></td>
            <td><span class="c-red transaction_charge"> {{ $data->formatted_transaction_charge }}</span></td>
            <td>{{ $data->formatted_status }}</td>
        </tr>
        <?php
            $fTotalAmount      += $data->amount;
            $fTotalTransAmount += $data->transaction_amount;
            $fTotalCharge      += $data->transaction_charge;
        ?>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td>小结</td>
            <td>本页资金变动</td>
            <td></td>
            <td>{{  number_format($fTotalAmount, 2) }}</td>
            <td>{{  number_format($fTotalTransAmount, 2) }}</td>
            <td>{{  number_format($fTotalCharge, 2) }}</td>
            <td></td>
        </tr>
    </tfoot>
</table>