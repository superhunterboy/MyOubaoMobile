<div class="area-search">
    <form action="{{ route('users.index') }}" method="get" id="J-form" autocomplete="off">
        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
        <p class="row">
            用户组：
            <select id="J-select-user-groups" style="display:none;" name="is_agent">
                <option value="">全部用户</option>
                <option value="0" {{ Input::get('is_agent') === '0' ? 'selected' : '' }}>玩家</option>
                <option value="1" {{ Input::get('is_agent') == 1 ? 'selected' : '' }}>代理</option>
            </select>
            &nbsp;
            用户名：<input class="input w-2" type="text" value="{{ Input::get('username') }}" name="username" />
            &nbsp;&nbsp;
            用户余额：<input class="input w-1" type="text" value="{{ Input::get('account_from') }}" name="account_from" /> - <input class="input w-1" type="text" value="{{ Input::get('account_to') }}" name="account_to" /> 元
            &nbsp;&nbsp;
            团队余额：<input class="input w-1" type="text" value="{{ Input::get('group_account_from') }}" name="group_account_from" /> - <input class="input w-1" type="text" value="{{ Input::get('group_account_to') }}" name="group_account_to" /> 元
            &nbsp;&nbsp;
            <input type="submit" value="搜 索" class="btn btn-important" id="J-submit">
        </p>
    </form>
</div>