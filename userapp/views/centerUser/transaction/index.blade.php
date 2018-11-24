@extends('l.home')

@section('title')
            账变记录 - 资金明细
@parent
@stop

@section('scripts')
@parent
    {{ script('jquery.jscrollpane')}}
    {{ script('dsgame.DatePicker')}}
    {{ script('dsgame.Tip')}}
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
                <li @if($reportName=='profits')class="current"@endif><a href="{{route('user-profits.myself') }}"><span>我的盈亏</span></a></li>
                @if(Session::get('is_agent'))<li @if($reportName=='transfer')class="current"@endif><a href="{{route('user-transactions.mytransfer') }}"><span>我的转帐</span></a></li>@endif
            </ul>
        </div>

        <div class="content">
            @include('centerUser.transaction._search')
            @include('centerUser.transaction._list')
            {{ pagination($datas->appends(Input::except('page')), 'w.pages') }}
        </div>
@stop


@section('end')
@parent
<script>
(function($){
      $('#J-date-start').focus(function(){
        (new dsgame.DatePicker({input:'#J-date-start',isShowTime:true, startYear:2013})).show();
    });
    $('#J-date-end').focus(function(){
        (new dsgame.DatePicker({input:'#J-date-end',isShowTime:true, startYear:2013})).show();
    });
    new dsgame.Select({realDom:'#J-select-bill-type',cls:'w-2'});
    @if($reportName=='transaction')
    var table = $('#J-table'),
        details = table.find('.view-detail'),
        tip         = new dsgame.Tip({cls:'j-ui-tip-b j-ui-tip-page-records'}),
        selectIssue = new dsgame.Select({realDom:'#J-select-issue',cls:'w-2'});

    new dsgame.Select({realDom:'#J-select-game-mode',cls:'w-2'});



    details.hover(function(e){
        var el = $(this),
            text = el.parent().find('.data-textarea').val();
        tip.setText(text);
        tip.show(-90, tip.getDom().height() * -1 - 22, el);

        e.preventDefault();
    },function(){
        tip.hide();
    });
    @endif

})(jQuery);
</script>

@stop