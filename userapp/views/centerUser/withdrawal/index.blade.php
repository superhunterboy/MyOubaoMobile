@extends('l.home')

@section('title')
            我的提现
@parent
@stop

@section('scripts')
@parent
    {{ script('jquery.jscrollpane')}}
    {{ script('dsgame.DatePicker')}}
@stop


@section ('main')
<div class="nav-bg nav-bg-tab">
    <div class="title-normal">
        资金明细
    </div>
    <ul class="tab-title">
        <li @if($reportName=='transaction')class="current"@endif><a href="{{ route('user-transactions.index') }}"><span>账变记录</span></a></li>
        <li @if($reportName=='deposit')class="current"@endif><a href="{{ route('user-transactions.mydeposit',Session::get('user_id')) }}"><span>我的充值</span></a></li>
        <li @if($reportName=='depositApply')class="current"@endif><a href="{{ route('user-recharges.index') }}"><span>充值申请</span></a></li>
        <li @if($reportName=='withdraw')class="current"@endif><a href="{{ route('user-transactions.mywithdraw',Session::get('user_id')) }}"><span>我的提现</span></a></li>
        <li @if($reportName=='withdrawApply')class="current"@endif><a href="{{ route('user-withdrawals.index') }}"><span>提现申请</span></a></li>
        <li ><a href="{{route('user-profits.myself') }}"><span>我的盈亏</span></a></li>
        @if(Session::get('is_agent'))<li @if($reportName=='transfer')class="current"@endif><a href="{{route('user-transactions.mytransfer') }}"><span>我的转帐</span></a></li>@endif
    </ul>
</div>

        <div class="content">
            @include('centerUser.withdrawal._search')
            @include('centerUser.withdrawal._list')
            {{ pagination($datas->appends(Input::except('page')), 'w.pages') }}
        </div>
@stop

@section('end')
@parent
<script>
(function($){

    // new dsgame.Select({realDom:'#J-select-recharge',cls:'w-2'});

    $('#J-date-start').focus(function(){
        (new dsgame.DatePicker({input:'#J-date-start',isShowTime:true, startYear:2013})).show();
    });
    $('#J-date-end').focus(function(){
        (new dsgame.DatePicker({input:'#J-date-end',isShowTime:true, startYear:2013})).show();
    });
    // var getAmountSumPerPage = function ()
    // {
    //     var amountSum = 0, transactionAmountSum = 0, transactionChargeSum = 0;
    //     $('.changeAmount').each(function() {
    //         var amountDesc = $.trim($(this).text()).split(' ');
    //         if (amountDesc[0] == '+') amountSum += +amountDesc[1];
    //         if (amountDesc[0] == '-') amountSum -= +amountDesc[1];
    //     });
    //     $('#fundChangeNum').html(fmoney(amountSum, 4));
    // }
    // getAmountSumPerPage();


})(jQuery);
</script>
@stop