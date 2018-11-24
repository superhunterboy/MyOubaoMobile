<div class="area-search">
    <form action="{{ route('user-profits.commission') }}" class="form-inline" method="get">
        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
        <div class="search-buttons">
                <button class="btn btn-important btn-search" type="submit"><span>搜索用户</span></button>
        </div>
        <div class="search-content small-search-content">
                <p class="row">
                        用户类型：
                        <select id="J-select-user-groups" style="display:none;" name="is_agent">
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
     </form>
</div>
