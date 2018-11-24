<div class="area-search">

    <form action="{{ route('projects.index') }}" class="form-inline" method="get">
        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
        <p class="row">
            游戏时间：<input id="J-date-start" class="input w-3" type="text" name="bought_at_from" value="{{Input::get('bought_at_from') ? Input::get('bought_at_from') : date('Y-m-d 00:00:00') }}" /> 至 <input id="J-date-end" class="input w-3" type="text" name="bought_at_to" value="{{ Input::get('bought_at_to') ? Input::get('bought_at_to') : date('Y-m-d H:i:s') }}" />
            &nbsp;&nbsp;
            <select id="J-select-issue" style="display:none;" name="number_type">
                <option value="serial_number" {{ Input::get('number_type') == 'serial_number' ? 'selected' : '' }}>注单编号</option>
                <option value="issue" {{ Input::get('number_type') == 'issue' ? 'selected' : '' }}>奖期编号</option>
            </select>
            <input class="input w-3" type="text" value="{{ Input::get('number_value') }}" name="number_value" />
            @if (Session::get('is_agent'))
            &nbsp;&nbsp;
            游戏用户：<input class="input w-3" type="text" name="username" value="{{ Input::get('username') }}" />            
            <input name="un_include_children" type="checkbox" value="1" @if(Input::get('un_include_children')==1)checked @endif>包含下级
            @endif
        </p>
        <p class="row">
            @include('widgets.lottery-group-ways')
            &nbsp;&nbsp;
            状态：<select id="J-select-status" style="display:none;" name="status">
                            <option value="">不限</option>
                            <option value="0" {{ Input::get('status') === '0' ? 'selected' : '' }}>待开奖</option>
                            <option value="1" {{ Input::get('status') === '1' ? 'selected' : '' }}>已撤销</option>
                            <option value="2" {{ Input::get('status') === '2' ? 'selected' : '' }}>未中奖</option>
                            <option value="3" {{ Input::get('status') === '3' ? 'selected' : '' }}>已中奖</option>
                            <option value="4" {{ Input::get('status') === '4' ? 'selected' : '' }}>已派奖</option>
                            <option value="5" {{ Input::get('status') === '5' ? 'selected' : '' }}>系统撤销</option>
                        </select>
            &nbsp;&nbsp;
            <input type="submit" value="搜 索" class="btn btn-important" id="J-submit">
        </p>
    </form>
</div>