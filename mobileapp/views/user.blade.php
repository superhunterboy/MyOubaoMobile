@extends('l.base')

@section('title')
个人中心
@parent
@stop

@section('styles')
@parent
{{ style('account') }}
@stop

@section('bodyClass')
<body class="account">
    @stop

    @section ('container')
    <div class="main-page show-page">
        <div id="section">

            <div class="account-head">
                <a class="link-customer" href='{{SysConfig::readValue("KFURL")}}'>客服</a>
                <div class="nickname">{{session::get('nickname')}}</div>
                <div class="avatar">
                    <img src="/assets/dist/images/avatar/avatar.png" alt="">
                </div>
                <a class="link-logout" href="{{ route('mobile-auth.logout') }}">退出</a>
                <div class="balance-box">
                    <div class="left">
                        <span>余额</span>
                        <span data-money-format data-user-balance
                              data-refresh-balance="{{route('mobile-users.user-monetary-info')}}" id="J-top-user-balance">{{$fAmount}}</span>
							
                    </div>
                    <div class="right">
                        <span>盈利</span>
                        <span data-money-format data-user-profit
                              data-refresh-balance="{{route('mobile-users.user-monetary-info')}}">{{$fProfit}}</span>
                    </div>
                    <!-- <div data-funds-safe class="link-visible"></div> -->
                    <div data-funds-safe><span class="glyphicon glyphicon-eye-open"></span></div>
                </div>
            </div>

            <div class="quick-link">
                <a class="deposit" href="{{ route('mobile-deposits.quick', $iDefaultPaymentPlatformId) }}"><i></i><span>充值</span></a>
                <a class="withdraw" href="{{ route('mobile-withdrawals.withdraw') }}"><i></i><span>提现</span></a>
                @if (Session::get('is_agent'))
                <a class="transfer" href="{{route('mobile-transfer.transfer')}}"><i></i><span>转账</span></a>
                <!--<a class="create" href="{{ route('mobile-links.index') }}?is_agent=1"><i></i><span>链接开户</span></a>-->
                @endif
                <a class="funds" href="{{route('mobile-transactions.index')}}"><i></i><span>资金明细</span></a>
                <a class="record" href="{{ route('mobile-projects.index') }}"><i></i><span>投注记录</span></a>
                <a class="notice" href="{{ route('mobile-announcements.index') }}"><i></i><span>官方公告</span></a>
                <a class="email" href="{{route('mobile-station-letters.index')}}"><i></i><span>站内信</span></a>
                <a class="password" href="{{ route('mobile-users.change-password') }}"><i></i><span>登入密码</span></a>
                <a class="funds-password" href="{{ route('mobile-users.change-fund-password') }}"><i></i><span>资金密码</span></a>
                <a class="bankcard" href="{{ route('mobile-user-bank-cards.index') }}"><i></i><span>银行卡</span></a>
                <a class="record" href="{{ route('mobile-users.team-home') }}"><i></i><span>综合统计</span></a>
            </div>

        </div>
        @include('w.bottom-nav')
    </div>

    @stop

    @section('scripts')
    @parent
    <script>
        $(function () {

            var touchEvent = DSGLOBAL['touchEvent'];

            // 余额的显示隐藏
            $('[data-funds-safe] .glyphicon').on(touchEvent, function (e) {
                e.preventDefault();
                var $this = $(this);
                if ($this.hasClass('glyphicon-eye-open')) {
                    $this.removeClass('glyphicon-eye-open').addClass('glyphicon-eye-close');
                    $('[data-money-format]').hide();
                } else {
                    $this.removeClass('glyphicon-eye-close').addClass('glyphicon-eye-open');
                    $('[data-money-format]').show();
                }
            });

            /*$(document).on('dsTabShown:callback', function(event, $tabs, $tab){
             $tabs.parent().removeClass('active');
             $tab.parent().addClass('active');
             var $text = $tab.parents('.dropdown:eq(0)').find('[data-tab-choose-value]');
             var cl = $tab.attr('href').split('-')[1];
             $text.text($tab.text());
             if( cl == 'game' ){
             $('.nav-tab-for-trace').removeClass('in').addClass('hide');
             $('.nav-tab-for-game').removeClass('hide').addClass('in');
             }else if( cl == 'trace' ){
             $('.nav-tab-for-game').removeClass('in').addClass('hide');
             $('.nav-tab-for-trace').removeClass('hide').addClass('in');
             }
             });
             
             $(document).on('dsTabLoad:success', function(event, $target, resp, $loading){
             $loading.remove();
             $target.html(resp);
             });
             
             // init
             $('[data-tabload="init"]').trigger(touchEvent);*/
        });
    </script>
    @stop
