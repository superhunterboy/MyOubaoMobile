<!DOCTYPE HTML>
<html lang="en-US">
    <head>
        <meta charset="UTF-8">
        <title>追号记录</title>
        @section ('styles')
            {{ style('global')}}
            {{ style('ucenter') }}
        @show
        @section('scripts')
            {{ script('jquery-1.9.1') }}
            {{ script('dsgame.base') }}
            {{ script('dsgame.Select') }}
            {{ script('dsgame.Tip') }}
        @show
    </head>

    <body style="background:none">
    <table width="100%" class="table" id="J-table">
    <tbody>
        <tr>
            <th>投注时间</th>
            <th>游戏玩法</th>
            <th>追号信息</th>
            <th>追号金额（元）</th>
            <th>中奖即停</th>
            <th>状态</th>
            <th>操作</th>
        </tr>
        @foreach ($datas as $data)
        <tr>
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
                <td>{{ $data->formatted_stop_on_won }}</td>
                <td>{{ $data->formatted_status }}</td>
                <td>
                    <a href="{{ route('traces.view', $data->id) }}" target="_blank">详情</a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

@section('end')

@show

    </body>
</html>

