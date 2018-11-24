<div class="area-search">		
        <form action="{{ route('user-profits.index') }}" class="form-inline" method="get">
        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
        <div class="search-buttons">
                <button class="btn btn-important btn-search" type="submit"><span>搜索用户</span></button>
        </div>
        <div class="search-content small-search-content">
                <p class="row">
                        用户类型：            <select id="J-select-user-groups" style="display:none;" name="is_agent">
                <option value="" {{ Input::get('is_agent') === '' ? 'selected' : '' }}>全部用户</option>
                <option value="1" {{ Input::get('is_agent') === '1' ? 'selected' : '' }}>代理</option>
                <option value="0" {{ Input::get('is_agent') === '0' ? 'selected' : '' }}>玩家</option>
            </select>					
                        &nbsp;&nbsp;&nbsp;&nbsp;用户名：
                        <input type="text" class="input w-2" name="username" value="{{ Input::get('username') }}" />		
                         &nbsp;&nbsp;&nbsp;&nbsp;查询日期：
                        <input type="text" name="date" value="{{ Input::get('date') ? Input::get('date') : Carbon::yesterday()->toDateString() }}" class="input w-3" id="J-date-start">
                </p>
        </div>
        <div class="search-report">
<!--                <a class="btn row-right-btn" href="#" target="_blank">报表下载</a>-->
                <ul>
                        <li class="report-title"><strong>当日<br>合计</strong></li>
                        <li>
                                <label>充值总额</label><dfn>￥</dfn><span data-money-format>{{ $oAgentSumPerDay->team_deposit_formatted }}</span><br>
                                <label>提现总额</label><dfn>￥</dfn><span data-money-format>{{ $oAgentSumPerDay->team_withdrawal_formatted }}</span>
                        </li>
                        <li>
                                <label>销售总额</label><dfn>￥</dfn><span data-money-format>{{ $oAgentSumPerDay->team_turnover_formatted }}</span><br>
                                <label>返点总额</label><dfn>￥</dfn><span data-money-format>{{ $oAgentSumPerDay->team_commission_formatted }}</span>
                        <li>
                                <label>中奖总额</label><dfn>￥</dfn><span data-money-format>{{ $oAgentSumPerDay->team_prize_formatted }}</span><br>
                                <label>游戏总盈亏</label><dfn>￥</dfn><span data-money-format class="fs-15 {{ $oAgentSumPerDay->team_profit < 0 ? 'c-red' : 'c-green' }}">{{ ($oAgentSumPerDay->team_profit < 0 ? '-' : '+') }}  {{ number_format(abs($oAgentSumPerDay->team_profit), 2) }}</span>
                        </li>
                </ul>
        </div>
    </form>
</div>