<div class="area-search">
    <form action="{{ route('team-profits.index') }}" class="form-inline" method="get">
        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
        <p class="row">
            查询日期：
            <input type="text" name="date_from" value="{{ Input::get('date_from') ? Input::get('date_from') : Carbon::today()->toDateString() }}" class="input w-3" id="J-date-start">
            &nbsp;&nbsp;
            <!--            用户类型：
                        <select id="J-select-user-groups" style="display:none;" name="is_agent">
                            <option value="" {{ Input::get('is_agent') === '' ? 'selected' : '' }}>全部用户</option>
                            <option value="1" {{ Input::get('is_agent') === '1' ? 'selected' : '' }}>代理</option>
                            <option value="0" {{ Input::get('is_agent') === '0' ? 'selected' : '' }}>玩家</option>
                        </select>-->
            至：
            <input type="text" name="date_to" value="{{ Input::get('date_to') ? Input::get('date_to') : Carbon::today()->toDateString() }}" class="input w-3" id="J-date-end">
            &nbsp;&nbsp;&nbsp;&nbsp;用户名：
            <input type="submit" value="搜 索" class="btn btn-important" id="J-submit">
        </p>
<!--        <p class="row">
            <a href="#" target="_blank">报表下载</a>
        </p>-->
    </form>
</div>
<div class="search-report">
    <!--                <a class="btn row-right-btn" href="#" target="_blank">报表下载</a>-->
    <ul>
        <li class="report-title"><strong>合计</strong></li>
        <li>
            <label>充值总额</label><dfn>￥</dfn><span data-money-format>{{ number_format($oAgentSumInfo['total_deposit'],2) }}</span><br>
            <label>提现总额</label><dfn>￥</dfn><span data-money-format>{{ number_format($oAgentSumInfo['total_withdrawal'],2) }}</span>
        </li>
        <li>
            <label>销售总额</label><dfn>￥</dfn><span data-money-format>{{ number_format($oAgentSumInfo['total_turnover'],2) }}</span><br>
            <label>返点总额</label><dfn>￥</dfn><span data-money-format>{{number_format($oAgentSumInfo['total_commission'],2) }}</span>
        <li>
            <label>中奖总额</label><dfn>￥</dfn><span data-money-format>{{ number_format($oAgentSumInfo['total_prize'],2) }}</span><br>
            <label>游戏总盈亏</label><dfn>￥</dfn><span data-money-format class="fs-15 {{ $oAgentSumInfo['total_profit'] < 0 ? 'c-red' : 'c-green' }}">{{ ($oAgentSumInfo['total_profit'] < 0 ? '-' : '+') }}  {{ number_format(abs($oAgentSumInfo['total_profit']), 2) }}</span>
        </li>
    </ul>
</div>
