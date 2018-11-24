@extends('l.home')

@section('title')
返点报表
@parent
@stop

@section('scripts')
@parent
{{ script('jquery.jscrollpane') }}
{{ script('dsgame.DatePicker') }}
@stop


@section ('main')


<div class="nav-bg nav-bg-tab">
    <div class="title-normal">返点报表</div>
    <ul class="tab-title clearfix">
        <li><a href="{{ route('team-profits.index') }}"><span>团队盈亏报表</span></a></li>
        <li><a href="{{ route('user-profits.index') }}"><span>用户盈亏报表</span></a></li>
        <li><a href="{{ route('user-dividends.index') }}"><span>分红报表</span></a></li>
    </ul>
</div>


<div class="content">
    @include('centerUser.user_profit._agent_commission_search')
    @include('centerUser.user_profit._agent_commission_table')

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

        new dsgame.Select({realDom: '#J-select-user-groups', cls: 'w-2'});

    })(jQuery);
</script>
@stop