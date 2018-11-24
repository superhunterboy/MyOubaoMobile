@extends('l.base')

@section('title')
   帮助中心
@parent
@stop

@section ('styles')
@parent
    {{ style('ucenter') }}
    {{ style('help') }}
@stop

@section('container')

@include('w.public-header')

<div class="g_33 main clearfix">
    <div class="main-sider">
       @include('w.help-sider')
    </div>

    <div class="main-content">

        <div class="nav-bg">
            <div class="title-normal">帮助中心</div>
        </div>
        <div class="content help-center-content clearfix">

            @include('w.help-sider')

            <div class="help-content help-content-detail">
                @if (count($datas))
                @foreach($datas as $data)
                <div class="article-page-title text-left">
                    <h1 id="{{$data['id']}}">{{ $data['title'] }}</h1>
                </div>

                    <div class="article-page-content">{{ $data['content'] }}</div>
               @endforeach
               @endif
               <div class="help-feedback">
                    <p>
                        <i class="alert-icon"></i>
                        <span>如果以上内容无法解决您的问题，请联系我们的客服</span>
                    </p>
                    <p>
                        <a href="javascript:void(0);" data-call-center class="btn btn-important">在线咨询</a>
                    </p>
                </div>
            </div>
        </div>

    </div>
</div>
    @include('w.footer')
@stop

@section('end')
<script>
(function($){
    var dom = $('#J-help-sider'),as = dom.find('.ul-first > li > a'),CLS = 'open',CLSA = 'current';
    as.click(function(e){
        var li = $(this).parent();
        if(li.hasClass(CLS)){
            li.removeClass(CLS);
        }else{
            li.addClass(CLS);
        }
        e.preventDefault();
    });
   dom.find('.ul-second > li >a').click(function(e){
        var li = $(this);
        if(li.hasClass(CLSA)){
            li.removeClass(CLSA);
        }else{
            dom.find('.ul-second > li>a').removeClass(CLSA);
            li.addClass(CLSA);
        }
    })
})(jQuery);
</script>
@parent
@stop


