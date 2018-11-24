@extends('l.base')

@section ('title')
欢迎来到
@parent
@stop


@section ('styles')
@parent
{{ style('index')}}
@stop

@section ('container')
@include('w.top-header')
@include('w.nav')
<div id="banner" class="wrap">
    <div class="cycle-slideshow"
         data-cycle-slides="> a"
         data-cycle-pager="> .cycle-pager"
         data-cycle-prev="> .cycle-prev"
         data-cycle-next="> .cycle-next"
         data-cycle-fx="fade"
         data-cycle-timeout="4000"
         data-cycle-random="false"
         data-cycle-loader="wait"
         data-cycle-speed="800"
         data-cycle-log="false"
         >
        @include('adTemp.3')
        <div class="cycle-pager"></div>
        <!-- <span class="cycle-prev">&#139;</span>
        <span class="cycle-next">&rsaquo;</span> -->
    </div>

    <div id="ucenter">
        <div class="user-avatar">
            <!-- <img src="/assets/images/index/avatar.png" alt=""> -->
            <i data-ds-avatar="{{intval(Session::get('portraitCode'))}}"></i>
            <div class="user-info">
                <h2><a href="{{ route('users.user') }}">{{ Session::get('nickname') }}</a>，开始您的取金之旅吧</h2>
                <p>@if($iSafeRate<4)<a class="right" href="{{route('users.user')}}">提高@endif</a>账户安全评分：<span id="J-safety-score"></span></p>
                <div data-safety="{{$iSafeRate}}" class="safety-percent"><span></span></div>
                <p>
                    <!-- <a class="user-action-1" href="{{ route('users.bind-email') }}" title="绑定邮箱"></a> -->
                    <a class="user-action-2 active" href="{{ route('users.change-password') }}" title="修改密码"></a>
                    <a class="user-action-3 @if($oUser->fund_password) active@endif" href="{{ route('users.change-fund-password') }}" title="修改资金密码"></a>
                    <a class="user-action-4 @if($iUserBankCardCount) active@endif" href="{{ route('bank-cards.index') }}" title="银行卡管理"></a>
                </p>
            </div>
        </div>
        <div class="user-balance left">
            <h3><a class="right" href="{{ route('user-transactions.index') }}">查看资金明细</a>账户余额</h3>
            <input id="J-user-balance-value" type="hidden" value="{{$fAvailable}}">
            <div class="balance-box">
                <ul>
                    <?php for ($i = 0; $i < 9; $i++) { ?>
                        <li>
                            <?php for ($j = 0; $j < 10; $j++) { ?>
                                <span><?= $j ?></span>
                            <?php } ?>
                        </li>
                    <?php } ?>
                    <li class="money-dot"><span>.</span></li>
                    <?php for ($i = 0; $i < 4; $i++) { ?>
                        <li class="money-small">
                            <?php for ($j = 0; $j < 10; $j++) { ?>
                                <span><?= $j ?></span>
                            <?php } ?>
                        </li>
                    <?php } ?>
                </ul>
                <div class="balance-hammer">
                    <div class="hammer-up"></div>
                    <div class="hammer-down"></div>
                </div>
            </div>
            <div class="account-actions">
                <a href="{{ route('user-recharges.quick', $iDefaultPaymentPlatformId) }}" class="u-button recharge">充值</a>
                <a href="{{ route('user-withdrawals.withdraw') }}" class="u-button withdraw">提现</a>
                @if (Session::get('is_agent'))
                <a href="{{route('transfer.transfer')}}" class="u-button transfer">转账</a>
                @else
                <a href="{{ route('bank-cards.index') }}" class="u-button card-manage">银行卡</a>
                @endif
            </div>
        </div>
        <div class="user-hongbao left">
            <h3><a class="right" href="{{ route('user-activity-user-prizes.available') }}">{{$iHongBaoCount}}个</a>可领红包</h3>
            <a href="{{ route('user-activity-user-prizes.index') }}" class="hongbao-bg">我的红包</a>
        </div>
    </div>
</div>

<div id="main-content" class="wrap">
    <div class="wrap-inner">
        <div class="main-left left">
            <div class="ui-box notice-board">
                <div class="ui-box-top">
                    <a class="right" href="{{route('announcements.index')}}">更多>></a><h2>官方公告</h2>
                </div>
                <ul class="news-list">
                    <!-- 显示8条数据 -->
                    @foreach($aLatestAnnouncements as $key => $oAnnouncement)
                    @if( $key <= 7 )
                    <li @if( $key % 2 == 0 ) class="even"@endif>
                         <span class="time">{{$oAnnouncement->created_at_day}}</span>
                        <a href="{{route('announcements.view', $oAnnouncement->id)}}">{{$oAnnouncement->title}}@if( $oAnnouncement->created_at_day== date('m/d') )<i class="c-important">&nbsp;&nbsp;New</i>@endif</a>
                    </li>
                    @endif
                    @endforeach
                    @if(count($aLatestAnnouncements)<=0)
                    <li class="no-data">暂未数据</li>
                    @endif
                </ul>
            </div>
        </div>

        <div class="main-right right">
            <div class="ui-box game-lists left">
                <div class="ui-box-top">
                    <h2>CC热门彩票列表</h2>
                </div>
                <ul class="game-wrap clearfix">
                    <li>
                        <h3>CC官方游戏</h3>
                        <div class="games-box">
                            @foreach($aCategoryLotteries[Lottery::LOTTERY_CATEGORY_OFFICIAL] as $aLottery)
                            @if(in_array($aLottery['id'], [13,14,18]))
                            <a href="{{route('bets.betform', $aLottery['id'])}}">{{ $aLottery['name'] }}<i class="game-24h"></i><i class="ds-game">Z</i></a>
                            @endif
                            @endforeach
                        </div>
                    </li>
                    <li>
                        <h3>时时彩</h3>
                        <div class="games-box">
                            @foreach($aCategoryLotteries[Lottery::LOTTERY_CATEGORY_SSC] as $aLottery)
                            @if(in_array($aLottery['id'], [1,6,17]))
                            <a href="{{route('bets.betform', $aLottery['id'])}}">{{ $aLottery['name'] }}<i class="hot-game">H</i></a>
                            @endif
                            @endforeach
                        </div>
                    </li>
                    <li>
                        <h3>11选5</h3>
                        <div class="games-box">
                            @foreach($aCategoryLotteries[Lottery::LOTTERY_CATEGORY_11Y] as $aLottery)
                            @if(in_array($aLottery['id'], [2,9]))
                            <a href="{{route('bets.betform', $aLottery['id'])}}">{{ $aLottery['name'] }}<i class="hot-game">H</i></a>
                            @endif
                            @endforeach
                        </div>
                    </li>
                    <li>
                        <h3>其他游戏</h3>
                        <div class="games-box">
                            @foreach($aCategoryLotteries[Lottery::LOTTERY_CATEGORY_PK10] as $aLottery)
                            <a href="{{route('bets.betform', $aLottery['id'])}}">{{ $aLottery['name'] }}<i class="hot-game">H</i></a>
                            @endforeach
                        </div>
                    </li>
                </ul>
                <ul class="game-tips">
                    <li><i class="ds-game">Z</i>官方游戏</li>
                    <li><i class="new-game">N</i>最新游戏</li>
                    <li><i class="hot-game">H</i>热门游戏</li>
                </ul>
            </div>

            <div class="ui-box ds-honor left">
                <!-- <div class="ui-box-top">
                    <h2>荣誉榜</h2>
                </div> -->
                <div class="honor-bg"></div>
                <div class="winner-list">
                    <div class="winner-scroll-warp J-prize-marquee">
                        <ul>
                            @foreach($aPrizePrj as $prizePrj)
                            <li>恭喜 {{$prizePrj->username_hidden}} 在{{$aLotteries[$prizePrj->lottery_id]}}<br>喜中<span class="color-highlight">{{$prizePrj->prize}}</span>元</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>

@include('w.footer')
@stop


@section('scripts')
@parent
{{ script('jquery.cycle2') }}
{{ script('dsgame.Tab') }}
{{ script('dsgame.Message') }}
{{ script('marquee-min')}}

@stop

@section('end')
@parent
<script type="text/javascript">
    (function () {
        if ($('#popWindow').length) {
            var popWindow = new dsgame.Message();
            var data = {
                title: '提示',
                content: $('#popWindow').find('.pop-bd > .pop-content').html(),
                closeIsShow: true,
                closeButtonText: '关闭',
                closeFun: function () {
                    this.hide();
                }
            };
            popWindow.show(data);
        }
    })();
</script>
<script>
    $(function () {
        // 安全评分
        var $safetyPercent = $('#ucenter [data-safety]'),
                $score = $('#J-safety-score'),
                $safetySpan = $safetyPercent.find('span'),
                safetyScore = parseInt($safetyPercent.data('safety')) || 0,
                score = safetyScore / 4 * 100;
        $score.text(score);
        if (score >= 100) {
            score = 100;
            $safetySpan.css({'background-color': 'green'});
        }
        $safetySpan.animate({
            width: score + '%'
        }, 1000, function () {
            // if( score >= 100 ){
            //  $safetySpan.animate({
            //      opacity: 0
            //  }, function(){
            //      $safetySpan.css({'background-color': 'green'}).animate({
            //          opacity: 1
            //      });
            //  });
            // }
        });

        // 账户余额
        var ernie,
                $button = $('.balance-hammer'),
                nums = $.trim($('#J-user-balance-value').val()).replace('.', ''),
                numStr = '0000000000000', // '000,000,000.0000'
                locked = false;

        nums = numStr.substr(0, numStr.length - nums.length) + nums;
        nums = nums.split('');
        ernie = new dsgame.Ernie({
            dom: $('.balance-box li:not(".money-dot")'),
            height: 24,
            length: 10,
            callback: function () {
                $button.find('.hammer-down').hide();
                $button.find('.hammer-up').show();
            }
        });

        $button.on('click', function () {
            if (locked) {
                return;
            }
            $.ajax({
                url: '/users/user-monetary-info',
                //type: 'POST',
                dataType: 'json',
                beforeSend: function () {
                    locked = true;
                    $button.find('.hammer-up').hide();
                    $button.find('.hammer-down').show();
                    ernie.start();
                },
                success: function (data) {
                    if (Number(data['isSuccess']) == 1) {
                        var monetary = '' + data['data']['available']; // isAgent ? data['data']['team_turnover'] : data['data']['available']
                        var decimals = '0000';
                        monetary = monetary.split('.');
                        if (monetary[1]) {
                            decimals = (monetary[1] + '0000').substr(0, 4);
                        }
                        var num = monetary[0] + decimals;
                        monetary = monetary[0] + '.' + decimals;
                        num = numStr.substr(0, numStr.length - num.length) + num;
                        ernie.stop(num.split(''));
                        $('[data-user-account-balance]').html(formatMoney(monetary));
                    }
                },
                complete: function () {
                    locked = false;
                }
            });
        }).trigger('click');
        ernie.start();
        ernie.stop(nums);

        // 获奖名单滚动
        $('.J-prize-marquee').marquee({
            auto: true,
            interval: 3000,
            speed: 1000,
            showNum: 3,
            stepLen: 1,
            type: 'vertical'
        });

    });
</script>
@stop

