@extends('l.home')

@section('title')
    游戏记录
@parent
@stop

@section('scripts')
@parent
    {{ script('jquery.jscrollpane')}}
    {{ script('dsgame.Tip')}}
    {{ script('dsgame.DatePicker')}}
@stop


@section ('main')
    <div class="nav-bg nav-bg-tab">
        <div class="title-normal">
            游戏记录
        </div>
        <ul class="tab-title clearfix">
            <li class="current"><a href="{{route('projects.index')}}"><span>游戏记录</span></a></li>
            <li><a href="{{route('traces.index')}}"><span>追号记录</span></a></li>
        </ul>
    </div>

    <div class="content">
    @include('centerUser.bet._search')
    @include('centerUser.bet._list')
    {{ pagination($datas->appends(Input::except('page')), 'w.pages') }}
    </div>
@stop


@section('end')
@parent
<script>
(function($){
    var table = $('#J-table'),
        details = table.find('.view-detail'),
        tip = new dsgame.Tip({cls:'j-ui-tip-b j-ui-tip-page-records'}),
        // selectGameType = new dsgame.Select({realDom:'#J-select-game-type',cls:'w-3'}),
        // selectMethodGroup = new dsgame.Select({realDom:'#J-select-method-group',cls:'w-3'}),
        // selectMethod = new dsgame.Select({realDom:'#J-select-method',cls:'w-3'}),
        selectIssue = new dsgame.Select({realDom:'#J-select-issue',cls:'w-2'}),
        selectStatus = new dsgame.Select({realDom:'#J-select-status',cls:'w-2'}),
        loadMethodgroup,
        loadMethod;

    $('#J-date-start').focus(function(){
        (new dsgame.DatePicker({input:'#J-date-start',isShowTime:true, startYear:2013})).show();
    });
    $('#J-date-end').focus(function(){
        (new dsgame.DatePicker({input:'#J-date-end',isShowTime:true, startYear:2013})).show();
    });

    details.hover(function(e){
        var el = $(this),
            text = el.parent().find('.data-textarea').val();
        tip.setText(text);
        tip.show(-90, tip.getDom().height() * -1 - 22, el);

        e.preventDefault();
    },function(){
        tip.hide();
    });


    /**
    setTimeout(function(){
        $(".choose-list-cont").jscroll({Btn:{btn:false}});
    }, 0);
    **/


})(jQuery);
</script>
@stop