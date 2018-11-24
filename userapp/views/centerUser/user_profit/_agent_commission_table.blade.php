<table width="100%" class="table">
    <thead>
        <tr>
            <th>用户名</th>
            <th>所属组</th>
            <th>日期</th>
            <th>有效投注金额</th>
            <th>返点总额</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($datas as $data)
        <tr>
            <td>{{ $data->username }}</td>
            <td>{{ $data->user_type_formatted }}</td>
            <td>{{ $data->date }}</td>
            <td>{{ number_format($data->turnover, 4) }}</td>
            <td>{{ number_format($data->commission, 4) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

