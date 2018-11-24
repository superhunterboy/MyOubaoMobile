@extends('l.admin', array('active' => $resource))

@section('title')
@parent
{{ __('Edit') . $resourceName }}
@stop

@section('container')
<div class="col-md-12">
  <div class="h2">{{ __('Edit') . $resourceName }}
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
      <form class="form-horizontal" method="post" action="{{ route($resource.'.edit', $data->id) }}" autocomplete="off">
        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
        <input type="hidden" name="_method" value="PUT" />

        @include('admin.role.detailForm')

        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-5">
              <a class="btn btn-default" href="{{ route($resource.'.edit') }}">{{ __('Reset') }}</a>
              <button type="submit" class="btn btn-success">{{ __('Submit') }}</button>
            </div>
        </div>
      </form>
    </div>
  </div>
</div>
@stop