@extends('l.home')

@section('title')
代理盈亏报表
@parent
@stop

@section('scripts')
@parent
{{ script('jquery.jscrollpane') }}
{{ script('dsgame.DatePicker') }}
@stop


@section ('main')

<div class="nav-bg nav-bg-tab">
    <div class="title-normal">团队盈亏报表</div>
    <ul class="tab-title clearfix">
        <li class="current"><a href="{{ route('team-profits.group') }}"><span>团队盈亏报表</span></a></li>
        <li><a href="{{ route('team-profits.index') }}"><span>团队日结报表</span></a></li>
        <li><a href="{{ route('user-profits.index') }}"><span>个人日结报表</span></a></li>
        <!--<li><a href="{{ route('user-dividends.index') }}"><span>分红报表</span></a></li>-->
    </ul>
</div>
<div class="content">
    @include('centerUser.team_profit._agent_search_group')
    @include('centerUser.team_profit._agent_table_group')

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
        $('#J-date-end').focus(function () {
            (new dsgame.DatePicker({input: '#J-date-end', isShowTime: false, startYear: 2013})).show();
        });

        //new dsgame.Select({realDom: '#J-select-user-groups', cls: 'w-2'});

    })(jQuery);
</script>
@stop