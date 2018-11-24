@extends('l.admin', array('active' => $resource))

@section('title')
@parent
{{ __('Group Info') }}
@stop


@section('container')
<div class="col-md-12">
  <div class="h2">{{ __('Group Info') }}
        <div class=" pull-right" role="toolbar" >
            <a href="{{ route($resource.'.index') }}" class="btn btn-sm btn-default">
                {{ __('Return') .  $resourceName }}
            </a>
        </div>
    </div>
    @include('w.breadcrumb')
    @include('w.notification')
    <div class="panel panel-default">
        <div class=" panel-body">
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th  class="text-right col-xs-2">{{ __('User Type') }}</th>
                        <td>{{ $data->user_type_formatted }}</td>
                    </tr>
                    <tr>
                        <th  class="text-right col-xs-2">{{ __('User Name') }}</th>
                        <td>{{ $data->username }}</td>
                    </tr>
                    <tr>
                        <th  class="text-right col-xs-2">{{ __('Nick Name') }}</th>
                        <td>{{ $data->nickname }}</td>
                    </tr>
                    <tr>
                        <th  class="text-right col-xs-2">{{ __('Created At') }}</th>
                        <td>{{ $data->created_at }}</td>
                    </tr>
                    <tr>
                        <th  class="text-right col-xs-2">{{ __('Signin At') }}</th>
                        <td>{{ $data->signin_at }}</td>
                    </tr>
                    <tr>
                        <th  class="text-right col-xs-2">{{ __('Group Account Sum') }}</th>
                        <td>{{ number_format($data->group_account_sum, 4) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@stop