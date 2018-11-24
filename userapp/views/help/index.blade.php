@extends('l.base')

@section('title')
   帮助中心
@parent
@stop

@section ('styles')
@parent
    {{ style('ucenter') }}
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
            <div class="help-subside">
                <h3>在线咨询</h3>
                <div class="help-ask-box">
                    <img src="/assets/images/ucenter/help-ask.png" alt="在线咨询">
                    <a href="javascript:void(0);" data-call-center class="btn btn-important">点击开始&nbsp;</a>
                    <p>以下是我们的客服人员，我们绝对不会以任何形式向您索要您的账号和密码，请妥善保管好您的账号信息：）</p>
                </div>
            </div>

            <div class="help-content">
                <ul class="help-shortcuts">
                    <li class="help-sc-1">
                        <span><i class="shortcut-icon-1"></i></span>
                        <a href="{{route('users.change-password')}}">修改登录密码</a>
                    </li>
                    <li class="help-sc-1">
                        <span><i class="shortcut-icon-2"></i></span>
                        @if ( $oUser!=null && $oUser->fund_password)
                        <a  href="{{ route('users.change-fund-password') }}">修改资金密码</a>
                        @else
                        <a href="{{ route('users.safe-reset-fund-password') }}">设置资金密码</a>
                        @endif
                    </li>
                    <li class="help-sc-1">
                        <span><i class="shortcut-icon-3"></i></span>
                        <a href="{{route('users.personal')}}">修改用户昵称</a>
                    </li>
                </ul>
                <h3>热门问题</h3>
                <ul class="help-list">
                    <li><a href="/help/8#17">如何在博狼娱乐平台进行游戏？</a></li>
                    <li><a href="/help/5#6">怎么注册博狼娱乐平台的账号？</a></li>
                    <li><a href="/help/9#18">博狼娱乐平台的时时彩开奖时间和官方一致吗？</a></li>
                    <li><a href="/help/9#19">博狼娱乐的派奖流程是什么样的？</a></li>
                    <li><a href="/help/9#21">博狼娱乐的奖金限额是多少？</a></li>
                    <li><a href="/help/10#26">在博狼娱乐购彩安全吗？</a></li>
                    <li><a href="/help/6#11">博狼娱乐支持工商银行充值吗？</a></li>
                    <li><a href="/help/6#13">提现的限额是多少？</a></li>
                </ul>
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


