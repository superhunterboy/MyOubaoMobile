@extends('l.home')

@section('title')
    用户管理 --博狼娱乐
@parent
@stop

@section('scripts')
@parent
    {{ script('jquery.jscrollpane') }}
    {{ script('dsgame.DatePicker') }}
@stop


@section('main')
<div class="nav-bg nav-bg-tab">
    <div class="title-normal">用户管理</div>
    <ul class="tab-title clearfix">
        <li><a href="{{ route('users.accurate-create') }}" ><span>精准开户</span></a></li>
        <li><a href="{{ route('user-links.create') }}"><span>链接开户</span></a></li>
        <li class="current"><a href="{{ route('users.index') }}"><span>用户列表</span></a></li>
        <li><a href="{{ route('user-links.index') }}"><span>链接管理</span></a></li>
    </ul>
</div>

<div class="content">
    @include('centerUser.user._search')
    @include('centerUser.user._list')

    {{ pagination($datas->appends(Input::except('page')), 'w.pages') }}
</div>
@stop

@section('end')
@parent
<script>
(function($){

    new dsgame.Select({realDom:'#J-select-user-groups',cls:'w-2'});
    // new dsgame.Select({realDom:'#J-select-user-add',cls:'w-2'});

    $('#J-date-start').focus(function(){
        (new dsgame.DatePicker({input:'#J-date-start',isShowTime:true, startYear:2013})).show();
    });
    $('#J-date-end').focus(function(){
        (new dsgame.DatePicker({input:'#J-date-end',isShowTime:true, startYear:2013})).show();
    });

})(jQuery);
</script>
@stop