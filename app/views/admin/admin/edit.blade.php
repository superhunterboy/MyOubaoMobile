@extends('l.admin', array('active' => $resource))

@section('title')
@parent
{{ $sPageTitle }}
@stop


@section('container')
<div class="col-md-12">
  <div class="h2">{{ __('Edit') . $resourceName }}
    <div class=" pull-right" role="toolbar" >
      <a href="{{ route($resource.'.index') }}" class="btn btn-sm btn-default">
            &laquo; {{ __('Return') .  $resourceName }}
        </a>
    </div>
  </div>
    @include('w.breadcrumb')
    @include('w.notification')

  <div class="panel panel-default">
    <div class="panel-body">
      <form class="form-horizontal" method="post" action="{{ route($resource.'.edit', $data->id) }}" autocomplete="off">
        <!-- CSRF Token -->
        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
        <input type="hidden" name="_method" value="PUT" />

          @include('admin.admin.detailForm')

        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-8">
              <button type="reset" class="btn btn-default" >{{ __('Reset') }}</button>
              <button type="submit" class="btn btn-success">{{ __('Submit') }}</button>
            </div>
        </div>
      </form>
    </div>
  </div>
</div>
@stop