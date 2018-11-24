<div class="area-search">
    @if($reportName=='transaction')<form action="{{ route('user-transactions.index') }}" class="form-inline" method="get">
        @elseif($reportName=='deposit')<form action="{{ route('user-transactions.mydeposit',Session::get('user_id')) }}" class="form-inline" method="get">
            @elseif($reportName=='withdraw')<form action="{{ route('user-transactions.mywithdraw',Session::get('user_id')) }}" class="form-inline" method="get">
            @elseif($reportName=='transfer')<form action="{{ route('user-transactions.mytransfer', Session::get('user_id')) }}" class="form-inline" method="get">@endif
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <p class="row">
                    游戏时间：<input id="J-date-start" class="input w-3" type="text" name="created_at_from" value="{{ Input::get('created_at_from') ? Input::get('created_at_from') : date('Y-m-d 00:00:00') }}" /> 至 <input id="J-date-end" class="input w-3" type="text" name="created_at_to" value="{{ Input::get('created_at_to') ? Input::get('created_at_to') : date('Y-m-d H:i:s') }}" />
                    &nbsp;&nbsp;
                    @if($reportName=='transaction')
                    <select id="J-select-issue" style="display:none;" name="number_type">
                        <option value="serial_number" {{ Input::get('number_type') == 'serial_number' ? 'selected' : '' }}>账变编号</option>
                        <option value="project_no" {{ Input::get('number_type') == 'project_no' ? 'selected' : '' }}>注单编号</option>
                        <option value="trace_id" {{ Input::get('number_type') == 'trace_id' ? 'selected' : '' }}>追号编号</option>
                        <option value="issue" {{ Input::get('number_type') == 'issue' ? 'selected' : '' }}>奖期编号</option>
                    </select>
                    <input class="input w-3" type="text" name="number_value" value="{{ Input::get('number_value') }}" />
                </p>
                <p class="row">
                    @include('widgets.lottery-group-ways')
                </p>
                <p class="row">
                    游戏模式：<select id="J-select-game-mode" style="display:none;" name="coefficient">
                        <option value="">所有</option>
                        @foreach ($aCoefficients as $key => $desc)
                        <option value="{{ $key }}" {{ Input::get('coefficient') == $key ? 'selected' : '' }}>{{ $desc }}</option>
                        @endforeach
                    </select>
                    &nbsp;&nbsp;
                    @endif
                    账变类型：
                    <select id="J-select-bill-type" style="display:none;" name="type_id">
                        <option value="">所有类型</option>
                        @foreach ($aTransactionTypes as $oTransactionType)
                        @if($reportName=='transaction' || in_array($oTransactionType->id, $transactionType))
                        <option value="{{ $oTransactionType->id }}" {{ Input::get('type_id') == $oTransactionType->id ? 'selected' : '' }}>{{ $oTransactionType->friendly_description }}</option>
                        @endif
                        @endforeach
                    </select>
                    @if (Session::get('is_agent') && $reportName=='transaction')
                    游戏用户：<input class="input w-3" type="text" name="username" value="{{ isset($sJumpUsername) ? $sJumpUsername : Input::get('username')  }}" />
                    <input name="un_include_children" type="checkbox" value="1" @if(Input::get('un_include_children')==1)checked @endif>包含下级
                    &nbsp;&nbsp;
                    @endif
                    <input type="submit" value="搜 索" class="btn btn-important" id="J-submit">
                </p>
            </form>
            </div>