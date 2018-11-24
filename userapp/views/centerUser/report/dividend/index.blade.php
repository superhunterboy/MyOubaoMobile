@extends('l.home')

@section('title')
分红报表
@parent
@stop

@section('scripts')
@parent
{{ script('jquery.jscrollpane') }}
{{ script('dsgame.DatePicker') }}
@stop


@section ('main')

<div class="nav-bg nav-bg-tab">
    <div class="title-normal">分红报表</div>
    <ul class="tab-title clearfix">
        <li><a href="{{ route('team-profits.groupIndex') }}"><span>团队盈亏报表</span></a></li>
        <li><a href="{{ route('team-profits.index') }}"><span>团队日结报表</span></a></li>
        <li><a href="{{ route('user-profits.index') }}"><span>个人日结报表</span></a></li>
        <!--<li class="current"><a href="{{ route('user-dividends.index') }}"><span>分红报表</span></a></li>-->
    </ul>
</div>
<div class="content">

    <!--    <div class="area-search">
            <p class="row">
                查询日期：
                <input type="text" value="" class="input w-3" id="J-date-start">&nbsp;&nbsp;
                <input type="button" class="btn" value="搜 索" />
            </p>
        </div>-->

    <table width="100%" class="table">
        <thead>
            <tr>
                <th>用户名</th>
                <th>分红时间</th>
                <th>销售总额</th>
                <th>奖金总额</th>
                <th>活动奖金总额</th>
                <th>佣金总额</th>
                <th>盈亏总计</th>
                <th>分红比例</th>
                <th>分红金额</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($datas as $data)
            <tr>
                <td>{{ $data->username }}</td>
                <td>{{ substr($data->created_at,0,10) }}</td>
                <td>{{ $data->turnover_formatted }}</td>
                <td>{{ $data->prize_formatted }}</td>
                <td>{{ $data->bonus_formatted }}</td>
                <td>{{ $data->commission_formatted }}</td>
                <td>{{ $data->profit_formatted }}</td>
                <td>{{ $data->rate }}</td>
                <td>{{ $data->amount_formatted }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ pagination($datas->appends(Input::except('page')), 'w.pages') }}
</div>
@stop

@section('end')
@parent
<script>
    (function ($) {
        $('#J-date-start').focus(function () {
            (new dsgame.DatePicker({input: '#J-date-start', isShowTime: false, startYear: 2013})).show();
        });
        $('#J-date-end').focus(function () {
            (new dsgame.DatePicker({input: '#J-date-end', isShowTime: false, startYear: 2013})).show();
        });

    })(jQuery);
</script>
@stop