<div class="area-search">
    <form action="{{ route('user-withdrawals.index') }}" class="form-inline" method="get">
        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
        <p class="row">
            时间：<input id="J-date-start" class="input w-3" type="text" name="request_time_from" value="{{ Input::get('request_time_from') }}" /> 至 <input id="J-date-end" class="input w-3" type="text" name="request_time_to" value="{{ Input::get('request_time_to') }}" />

            @if (Session::get('is_agent'))
            游戏用户：<input class="input w-3" type="text" name="username" value="{{ Input::get('username') }}" />
            &nbsp;&nbsp;
            @endif
            <input type="submit" value="搜 索" class="btn btn-important" id="J-submit">
        </p>
    </form>
</div>