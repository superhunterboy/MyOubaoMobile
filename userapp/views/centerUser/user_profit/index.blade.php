@extends('l.home')

@section('title')
个人盈亏报表
@parent
@stop

@section('scripts')
@parent
{{ script('jquery.jscrollpane') }}
{{ script('dsgame.DatePicker') }}
@stop


@section ('main')

<div class="nav-bg nav-bg-tab">
    <div class="title-normal">
        个人日结报表
    </div>
    @if(Session::get('is_agent'))
        <ul class="tab-title clearfix">
        <li><a href="{{ route('team-profits.group') }}"><span>团队盈亏报表</span></a></li>
        <li><a href="{{ route('team-profits.index') }}"><span>团队日结报表</span></a></li>
        <li class="current"><a href="{{ route('user-profits.index') }}"><span>个人日结报表</span></a></li>
        <!--<li><a href="{{ route('user-dividends.index') }}"><span>分红报表</span></a></li>-->
    </ul>
    @else
    <ul class="tab-title">
        <li @if($reportName=='transaction')class="current"@endif><a href="{{ route('user-transactions.index') }}"><span>账变记录</span></a></li>
        @if(!Session::get('is_agent'))
        <li @if($reportName=='deposit')class="current"@endif><a href="{{ route('user-transactions.mydeposit',Session::get('user_id')) }}"><span>我的充值</span></a></li>
        <li @if($reportName=='depositApply')class="current"@endif><a href="{{ route('user-recharges.index') }}"><span>充值申请</span></a></li>
        @endif
        <li @if($reportName=='withdraw')class="current"@endif><a href="{{ route('user-transactions.mywithdraw',Session::get('user_id')) }}"><span>我的提现</span></a></li>
        <li @if($reportName=='withdrawApply')class="current"@endif><a href="{{ route('user-withdrawals.index') }}"><span>提现申请</span></a></li>
        <li class="current"><a href="{{route('user-profits.index') }}"><span>我的盈亏</span></a></li>
    </ul>
    @endif
</div>



<div class="content">
    @if (Session::get('is_agent'))
    @include('centerUser.user_profit._agent_search')
    @include('centerUser.user_profit._agent_table')
    @else
    @include('centerUser.user_profit._user_search')
    @include('centerUser.user_profit._user_table')
    @endif

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

        // new dsgame.Select({realDom: '#J-select-user-groups', cls: 'w-2'});

    })(jQuery);
</script>
@stop