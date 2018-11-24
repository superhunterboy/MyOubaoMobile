<div class="form-group">
    <label for="username" class="col-sm-3 control-label">*{{ __('_user.username') }}</label>
    <div class="col-sm-5">
      <input type="text" class="form-control" id="username" name="username" value="{{ Input::old('username', isset($data) ? $data->username : '') }}"/>
    </div>
</div>

<div class="form-group">
    <label for="nickname" class="col-sm-3 control-label">*{{ __('_user.nickname') }}</label>
    <div class="col-sm-5">
        <input class="form-control" type="text" name="nickname" id="nickname" value="{{ Input::old('nickname', isset($data) ? $data->nickname : '') }}" />
    </div>
</div>
<div class="form-group">
    <label for="email" class="col-sm-3 control-label">*{{ __('_user.email') }}</label>
    <div class="col-sm-5">
        <input class="form-control" type="text" name="email" id="email" value="{{ Input::old('email', isset($data) ? $data->email : '') }}" />
    </div>
</div>
<div class="form-group">
    <label for="prize_group" class="col-sm-3 control-label">*{{ __('_user.prize_group') }}</label>
    <div class="col-sm-5">
        <select name="prize_group" id="prize_group" class="form-control">
            @foreach($aTopAgentPrizeGroups as $iPrizeGroup)
            <option value="{{ $iPrizeGroup }}" {{ $iDefaultGroup == $iPrizeGroup ? 'selected' : '' }}>{{ $iPrizeGroup }}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="form-group" id="j-quota" style="display:none">
    <label for="prize_group" class="col-sm-3 control-label">*设置配额</label>
    <div class="col-sm-5">
        <table class="table table-bordered text-center">
            <tr class="warning" id="j-prize-group">
            </tr>
            <tr id="j-prize-group-input">
            </tr>
        </table>
    </div>
</div>

@if (!$isEdit)
<div class="form-group">
    <label for="password"  class="col-sm-3 control-label">*{{ __('_user.password') }}</label>

    <div class="col-sm-5">
        <input class="form-control"type="password" name="password" id="password" value="" />
    </div>

</div>

<div class="form-group">
    <label for="password_confirmation"  class="col-sm-3 control-label">*{{ __('_user.password_confirmation') }}</label>

    <div class="col-sm-5">
        <input class="form-control"type="password" name="password_confirmation" id="password_confirmation" value="" />
    </div>
</div>
@endif
<div class="form-group">
    <label for="channel" class="col-sm-3 control-label">{{ __('_user.is_tester') }}</label>
    <div class="col-sm-5">
            <input type="checkbox" class="boot-checkbox" name="is_tester" id="is_tester" value="1"
                {{ Input::old('is_tester', (isset($data) ? $data->is_tester : 0 )) ? 'checked': '' }}>
    </div>
</div>

