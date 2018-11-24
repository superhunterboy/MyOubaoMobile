@extends('l.admin', array('active' => $resource))

@section('title')
@parent
{{ __('Edit') . $resourceName }}
@stop


@section('container')
<div class="col-md-12">
    <div class="h2">{{ __('_user.admin-reset-fund-passwd') }}
        <div class=" pull-right" role="toolbar" >
            <a href="{{ route($resource.'.index') }}" class="btn btn-sm btn-default">
                {{ __('_q_win_loses.return') .  $resourceName }}
            </a>
        </div>
    </div>
    @include('w.breadcrumb')
    @include('w.notification')
    <div class="panel panel-default">
         <div class=" panel-body">
            <form class="form-horizontal" method="post" action="{{ route($resource.'.reset-fund-password', $data->id) }}" autocomplete="off">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <input type="hidden" name="_method" value="PUT" />
                <div class="form-group">
                    <label class="col-sm-3 control-label">{{ __('_user.username') }}</label>
                    <label class="col-sm-5 ">
                        <span class="form-control">{{ $data->username }}</span>
                    </label>
                </div>
                <div class="form-group">
                    <label for="fund_password"  class="col-sm-3 control-label">*{{ __('_user.new') }}{{ __('_user.fund_password') }}</label>
                    <div class="col-sm-5">
                        <input class="form-control" type="password" name="fund_password" id="fund_password" value="" />
                    </div>
                </div>

                <div class="form-group">
                    <label for="fund_password_confirmation"  class="col-sm-3 control-label">*{{ __('_user.new') }}{{ __('_user.fund_password_confirmation') }}</label>
                    <div class="col-sm-5">
                        <input class="form-control" type="password" name="fund_password_confirmation" id="fund_password_confirmation" value="" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="description"  class="col-sm-3 control-label">{{ __('_user.description') }}</label>

                    <div class="col-sm-5">
                        <input class="form-control" type="text" name="description" id="description" value="" />
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-5">
                      <button type="reset" class="btn btn-default" >{{ __('Reset') }}</button>
                      <button type="submit" class="btn btn-success">{{ __('Submit') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@stop