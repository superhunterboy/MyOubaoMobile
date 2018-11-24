@extends('l.admin', array('active' => $resource))

@section('title')
@parent
{{ __('View') . $resourceName }}
@stop


@section('container')
<div class="col-md-12">
    <div class="h2">{{ __('View') . $resourceName }}
        <div class=" pull-right" role="toolbar" >
            <a href="{{ route($resource.'.index') }}" class="btn btn-sm btn-default">
               {{ __('Return') . $resourceName . __('List') }}
            </a>
        </div>
    </div>
    @include('w.breadcrumb')
    @include('w.notification')

    <div class="panel panel-default">
        <div class=" panel-body">
            <div class="form-horizontal">
                <div class="form-group">
                    <label for="name" class="col-sm-3 control-label">*{{ __('Role Name') }}</label>
                    <div class="col-sm-5">
                        <input class="form-control" type="text" value="{{ isset($data) ? $data->name : '' }}" disabled>
                    </div>
                </div>

                <div class="form-group">
                    <label for="rights" class="col-sm-3 control-label">*{{ __('Rights') }}</label>
                    <div class="col-sm-5">
                        <input class="form-control" type="text" value="{{ isset($data) ? $data->rights : '' }}" disabled>
                    </div>
                </div>

                <div class="form-group">
                    <label for="description" class="col-sm-3 control-label">*{{ __('Description') }}</label>
                    <div class="col-sm-5">
                        <input class="form-control" type="text" value="{{ isset($data) ? $data->description : '' }}" disabled>
                    </div>
                </div>


                <div class="form-group">
                    <label for="priority" class="col-sm-3 control-label">*{{ __('Priority') }}</label>
                    <div class="col-sm-5">
                        <input class="form-control" type="text" value="{{ isset($data) ? $data->priority : '' }}" disabled>
                    </div>
                </div>

                <div class="form-group">
                    <label for="is_system" class="col-sm-3 control-label">* {{ __('Is System') }}</label>
                    <div class="col-sm-5">
                       <input class="form-control" type="text" value="{{ ((isset($data) ? $data->is_system : 0 )) ? __('Yes'): __('No') }}" disabled>
                    </div>
                </div>

                <div class="form-group">
                    <label for="right_settable" class="col-sm-3 control-label">*{{ __('Right Settable') }}</label>
                    <div class="col-sm-5">
                        <input class="form-control" type="text" value="{{ ((isset($data) ? $data->right_settable : 0 )) ? __('Yes'): __('No') }}" disabled>
                    </div>
                </div>

                <div class="form-group">
                    <label for="user_settable" class="col-sm-3 control-label">*{{ __('User Settable') }}</label>
                    <div class="col-sm-5">
                        <input class="form-control" type="text" value="{{ ((isset($data) ? $data->user_settable : 0 )) ? __('Yes'): __('No') }}" disabled>
                    </div>
                </div>

                <div class="form-group">
                    <label for="disabled" class="col-sm-3 control-label">*{{ __('Disabled') }}</label>
                    <div class="col-sm-5">
                        <input class="form-control" type="text" value="{{ ((isset($data) ? $data->disabled : 0 )) ? __('Yes'): __('No') }}" disabled>
                    </div>
                </div>

                <div class="form-group">
                    <label for="sequence" class="col-sm-3 control-label">{{ __('Sequence') }}</label>
                    <div class="col-sm-5">
                        <input class="form-control" type="text" value="{{ isset($data) ? $data->sequence : 0 }}" disabled>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@stop

