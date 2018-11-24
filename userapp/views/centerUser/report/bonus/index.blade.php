@extends('l.home')

@section('title')
代理分红报表
@parent
@stop

@section('scripts')
@parent
{{ script('jquery.jscrollpane') }}
{{ script('dsgame.DatePicker') }}
@stop


@section ('main')
<div class="nav-bg nav-bg-tab">
    <div class="title-normal">用户管理</div>
    <ul class="tab-title clearfix">
        <li><a href="{{ route('users.accurate-create') }}" ><span>精准开户</span></a></li>
        <li><a href="{{ route('user-links.create') }}"><span>链接开户</span></a></li>
        <li><a href="{{ route('users.index') }}"><span>用户列表</span></a></li>
        <li><a href="{{ route('user-links.index') }}"><span>链接管理</span></a></li>
    </ul>
</div>


    <div class="content">
    <div class="filter-tabs" style="margin-bottom:10px;">
        <div class="filter-tabs-cont">
                <a href="{{ route('user-profits.commission') }}">返点报表</a>
                <a href="{{ route('user-profits.index') }}">盈亏报表</a>
                <a class="current" href="{{ route('user-dividends.index') }}">分红报表</a>
        </div>
    </div>

    <div class="area-search">
        <form action="{{ route('user-dividends.index') }}" class="form-inline" method="get">
            <div class="search-buttons">
                    <button class="btn btn-important btn-search" type="submit"><span>搜索用户</span></button>
                    <!-- <a class="reset-link" href=""><span>恢复默认项</span></a> -->
            </div>
            <div class="search-content small-search-content">
                    <p class="row">
                            查询日期：
                            <input type="text" value=" " class="input w-3" id="J-date-start">
                    </p>
            </div>
        </form>
    </div>
    <table width="100%" class="table">
        <thead>
            <tr>
                <th>用户名</th>
                <th>分红时间</th>
                <th>当前销售总额</th>
                <th>当前分红比例</th>
                <th>输额总计</th>
                <th>分红金额</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($datas as $data)
            <tr>
                <td>{{ $data->username }}</td>
                <td>{{ $data->verified_at }}</td>
                <td>{{ $data->turnover }}</td>
                <td>{{ $data->rate }}</td>
                <td>{{ number_format($data->direct_profit, 4) }}</td>
                <td>{{ number_format($data->bonus, 4) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
@if($datas->getLastPage()>1){{pagination($datas->appends(Input::except('page')), 'w.pages') }}@endif
</div>
@stop

@section('end')
@parent
<script>
    (function ($) {
        $('#J-date-start').focus(function () {
            (new dsgame.DatePicker({input: '#J-date-start', isShowTime: false, startYear: 2013})).show();
        });
        // $('#J-date-end').focus(function () {
        //     (new dsgame.DatePicker({input: '#J-date-end', isShowTime: false, startYear: 2013})).show();
        // });

    })(jQuery);
</script>
@stop