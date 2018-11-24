<div class="form-group">
    <label for="domain" class="col-sm-3 control-label">{{ __('_domain.domain') }}</label>
    <div class="col-sm-5">
        <input type="text" class="form-control" id="domain" name="domain" value="{{ Input::old('domain', isset($data) ? $data->domain : '') }}"/>
    </div>
</div>
<div class="form-group">
    <label for="status" class="col-sm-3 control-label">{{ __('_domain.status') }}</label>
    <div class="col-sm-5">
        <select class="form-control" name="status" id="status" >
            @foreach ($aDomainStatus as $key => $value)
                <option value="{{ $key }}" {{ Input::old('status', isset($data) ? $data->status : '') == $key ? 'selected' : ''}}>{{ $value }}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="form-group">
    <label for="type[]" class="col-sm-3 control-label">{{ __('_domain.type') }}</label>
    <div class="col-sm-5">
        <?php
            $aTypes = (isset($data) && (string)$data->type !== '') ? explode(',', (string)$data->type) : [];
        ?>
        @foreach ($aDomainTypes as $key => $value)
            <label class="btn btn-sm btn-default btn-b">
                <input type="checkbox" name="type[]" value="{{ $key }}" {{ in_array($key, $aTypes) ? 'checked' : '' }}> {{ $value }}
            </label>
        @endforeach
    </div>
</div>