<div class="form-group">
    <label for="username" class="col-sm-3 control-label">*{{ __('_adminuser.username') }}</label>
    <div class="col-sm-5">
      <input type="text" class="form-control" id="username" name="username" value="{{ Input::old('username', isset($data) ? $data->username : '') }}"/>
    </div>
</div>

<div class="form-group">
    <label for="name" class="col-sm-3 control-label">{{ __('_adminuser.name') }}</label>
    <div class="col-sm-5">
        <input class="form-control" type="text" name="name" id="name" value="{{ Input::old('name', isset($data) ? $data->name : '') }}" />
    </div>
</div>
<div class="form-group">
    <label for="email" class="col-sm-3 control-label">{{ __('_adminuser.email') }}</label>
    <div class="col-sm-5">
        <input class="form-control" type="text" name="email" id="email" value="{{ Input::old('email', isset($data) ? $data->email : '') }}" />
    </div>
</div>

@if (!$isEdit)
<div class="form-group">
    <label for="password"  class="col-sm-3 control-label">*{{ __('_adminuser.password') }}</label>

    <div class="col-sm-5">
        <input class="form-control"type="password" name="password" id="password" value="" />
    </div>
</div>

<div class="form-group">
    <label for="password_confirmation"  class="col-sm-3 control-label">*{{ __('_adminuser.password-confirm') }}</label>
    <div class="col-sm-5">
        <input class="form-control"type="password" name="password_confirmation" id="password_confirmation" value="" />
    </div>
</div>
@endif

<div class="form-group">
    <label for="language" class="col-sm-3 control-label">{{ __('_adminuser.language') }}</label>
    <div class="col-sm-5">
        <select class="form-control" name="language" id="language" >
            @foreach ($aLanguages as $id => $title)
                <option value="{{ $id }}" {{ Input::old('language', isset($data) ? $data->language : '') == $id ? 'selected' : ''}}>{{ $title }}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="form-group">
    <label for="menu_link" class="col-sm-3 control-label">{{ __('_adminuser.menu_link') }}</label>
    <div class="col-sm-5">
        <input type="checkbox" class="boot-checkbox" name="menu_link" id="menu_link" value="1" {{ Input::old('menu_link', (isset($data) ? $data->menu_link : 0 )) ? 'checked': '' }} >
    </div>
</div>
<div class="form-group">
    <label for="menu_context" class="col-sm-3 control-label">{{ __('_adminuser.menu_context') }}</label>
    <div class="col-sm-5">
        <input type="checkbox" class="boot-checkbox" name="menu_context" id="menu_context" value="1" {{ Input::old('menu_context', (isset($data) ? $data->menu_context : 0 )) ? 'checked': '' }}>

    </div>
</div>
<div class="form-group">
    <label for="actived" class="col-sm-3 control-label">{{ __('_adminuser.actived') }}</label>
    <div class="col-sm-5">
        <input type="checkbox" class="boot-checkbox" name="actived" id="actived" value="1" {{ Input::old('actived', (isset($data) ? $data->actived : 0 )) ? 'checked': '' }}>
    </div>
</div>
<div class="form-group">
    <label for="secure_card_number" class="col-sm-3 control-label">{{ __('_adminuser.secure_card_number') }}</label>
    <div class="col-sm-5">
        <input class="form-control" type="text" name="secure_card_number" id="secure_card_number" value="{{ Input::old('secure_card_number', isset($data) ? $data->secure_card_number : '') }}" />
    </div>
</div>
