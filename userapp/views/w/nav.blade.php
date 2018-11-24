<div id="nav" class="wrap">

    <div class="wrap-inner">
        <div class="nav-top-content">
            <a href="/home" class="left" id="logo">CC游戏</a>
            <div class="user-box">
                <div class="user-name"><a href="{{ route('users.user') }}">{{Session::get('nickname')}}</a></div>
                <div class="user-account-balance">

                    <span class=""><i data-tips-top="竞彩余额：¥--" class="alert-icon"></i></span>
                    <span class="user-cash balance-a" style="display: inline;">余额：<span data-user-account-balance="" class="num">0.00</span> 元<i data-refresh-balance=""></i></span>
                    <span style="display: none;" class="balance-b">余额已隐藏</span>
                    <span class="balance-toggle highlight-color">隐藏</span>
                </div>
                <div class="user-btn">
                    <a href="{{ route('user-recharges.quick', $iDefaultPaymentPlatformId) }}" class=" recharge"><i></i> <font>充值</font></a>
                    <a href="{{ route('user-withdrawals.withdraw') }}" class=" withdraw"><i></i> <font>提现</font></a>
                    @if (Session::get('is_agent'))<a href="{{route('transfer.transfer')}}" class=" transfer"><i></i> <font>转账</font></a>@endif
                    <a href="{{ route('station-letters.index') }}" class="messsage"><i></i>  <font>消息</font></a>
                    <a href="{{ route('users.user') }}" class="user-centent"><i></i> <font>个人中心</font> </a>
                </div>
            </div>

        </div>

    </div>
    <div class="nav-wrap">
        <div class="wrap-inner">
            <ul class="nav-content">
                <li data-gamelist="" class="nav-gamelist">
                    <a class="nav-lobby" href="">
                        <span>游戏大厅<b class="caret"></b></span>
                    </a>
                </li>
                <li>
                    <a class="nav-record  " href="/home">
                        <span>首页</span>
                    </a>
                </li>
                <li>
                    <a class="nav-record  " href="{{ route('projects.index') }}">
                        <span>游戏记录</span>
                    </a>
                </li>
                <li>
                    <a class="nav-number " href="{{ route('traces.index') }}">
                        <span>追号记录</span>
                    </a>
                </li>
                <li>
                    <a class="nav-fund " href="{{ route('user-transactions.index') }}">
                        <span>资金明细</span>
                    </a>
                </li>
                <li>
                    <a class="nav-hongbao " href="{{ route('user-activity-user-prizes.index') }}">
                        <span>红包中心</span>
                    </a>
                </li> 
                <li>
                    <a class=" " href="{{ route('users.user') }}">
                        <span>个人中心</span>
                    </a>
                </li>
                @if (Session::get('is_agent'))
                <li>
                    <a class="nav-form " href="{{ route('team-profits.index') }}">
                        <span>团队报表</span>
                    </a>
                </li>
                <li>
                    <a class="nav-agency active" href="{{ route('users.index') }}">
                        <span>用户管理</span>
                    </a>
                </li>
                @endif
            </ul>
        </div>
    </div>    
    <div class="nav-game-lists" style="display: none;">
        <ul class="clearfix">
            <li>
                <h3 class="recommand">推荐彩种 (12) </h3>
                <div class="list-link">
                    <!--<a class="hot-game" href="{{ route('bets.betform', 18) }}" target="ga_game_26">CC秒秒彩<span class="nav-icon-24h"></span></a>-->
                    <a class="hot-game" href="{{ route('bets.betform', 13) }}" target="_self">CC分分彩<span class="nav-icon-24h"></span></a>
                    <a class="hot-game" href="{{ route('bets.betform', 20) }}" target="_self">CC三分彩<span class="nav-icon-24h"></span></a>
                    <a class="hot-game" href="{{ route('bets.betform', 21) }}" target="_self">CC五分彩<span class="nav-icon-24h"></span></a>
                    <a class="hot-game" href="{{ route('bets.betform', 1) }}" target="_self">重庆时时彩<span class="nav-icon-hot"></span></a>
                    <a class="hot-game" href="{{ route('bets.betform', 17) }}" target="_self">新重庆时时彩<span class="nav-icon-hot"></span></a>
                    <a class="hot-game" href="{{ route('bets.betform', 14) }}" target="_self">CC11选5<span class="nav-icon-hot"></span></a>
                    <a class="hot-game" href="{{ route('bets.betform', 22) }}" target="_self">北京PK10<span class="nav-icon-hot"></span></a>
                    <a class="hot-game" href="{{ route('bets.betform', 35) }}" target="_self">CC快3分分彩<span class="nav-icon-hot"></span></a>
                    <a class="hot-game" href="{{ route('bets.betform', 15) }}" target="_self">江苏快3<span class="nav-icon-hot"></span></a>
                    <a class="hot-game" href="{{ route('bets.betform', 16) }}" target="_self">江苏骰宝<span class="nav-icon-hot"></span></a>
                    <div class="clearfix"></div>
                </div>
            </li>
            <li>
                <h3 class="ssc">时时彩 ({{count($aCategoryLotteries[Lottery::LOTTERY_CATEGORY_OFFICIAL]) + count($aCategoryLotteries[Lottery::LOTTERY_CATEGORY_SSC])}}) </h3>
                <div class="list-link">
                    @foreach($aCategoryLotteries[Lottery::LOTTERY_CATEGORY_OFFICIAL] as $aLottery)
                    <a class="hot-game" href="{{ route('bets.betform', $aLottery['id']) }}" target="_self">{{$aLottery['name']}}@if($aLottery['is_self'])<span class="nav-icon-24h"></span>@endif</a>
                    @endforeach
                    @foreach($aCategoryLotteries[Lottery::LOTTERY_CATEGORY_SSC] as $aLottery)
                    <a class="hot-game" href="{{ route('bets.betform', $aLottery['id']) }}" target="_self">{{$aLottery['name']}}@if($aLottery['is_self'])<span class="nav-icon-24h"></span>@endif</a>
                    @endforeach
                    <div class="clearfix"></div>
                </div>
            </li>
            <li>
                <h3 class="11x5">11选5 (({{count($aCategoryLotteries[Lottery::LOTTERY_CATEGORY_11Y])}}) </h3>
                <div class="list-link">
                    @foreach($aCategoryLotteries[Lottery::LOTTERY_CATEGORY_11Y] as $aLottery)
                    <a class="hot-game" href="{{ route('bets.betform', $aLottery['id']) }}" target="_self">{{$aLottery['name']}}@if($aLottery['is_self'])<span class="nav-icon-24h"></span>@endif</a>
                    @endforeach
                    <div class="clearfix"></div>
                </div>
            </li>
            <li>
                <h3 class="k3">快三 ({{count($aCategoryLotteries[Lottery::LOTTERY_CATEGORY_K3])}}) </h3>
                <div class="list-link">
                    @foreach($aCategoryLotteries[Lottery::LOTTERY_CATEGORY_K3] as $aLottery)
                    <a class="hot-game" href="{{ route('bets.betform', $aLottery['id']) }}" target="_self">{{$aLottery['name']}}@if($aLottery['is_self'])<span class="nav-icon-24h"></span>@endif</a>
                    @endforeach
                    <div class="clearfix"></div>
                </div>
            </li>
            <li>
                <h3 class="other">其他(PK10,竞彩,低频) (3) </h3>
                <div class="list-link">
                    <a class="" href="{{ route('bets.betform', 22) }}" target="_self">北京PK拾</a>
                    <a class="" href="{{ route('bets.betform', 11) }}" target="_self">3D</a>
                    <a class="" href="{{ route('bets.betform', 12) }}" target="_self">排列三/五</a>
                    <div class="clearfix"></div>
                </div>
            </li>
        </ul>    </div>
</div>