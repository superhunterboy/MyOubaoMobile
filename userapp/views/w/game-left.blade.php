
<div id="aside" class="left">
    <div class="user-info">
        <h2>{{ Session::get('nickname') }}</h2>
        <p><small>账户余额：</small></p>
        <p class="user-balance" id="J-user-balance">
            <span data-user-account-balance>0.00</span>
            <span>元</span>
            <i data-refresh-balance>Refresh</i>
        </p>
        <p>
            <a href="{{ route('user-recharges.quick', $iDefaultPaymentPlatformId) }}" class="ui-button">立即充值</a>
        </p>
    </div>
    <div class="bet-trend" id="J-minitrend-cont">
        <p class="text-right more">
            <a target="_blank" href="{{ route('user-trends.trend-view', [$iLotteryId]) }}">查看完整走势...</a>
        </p>
    </div>


</div>