@extends('l.admin', array('active' => $resource))

@section('title')
@parent
{{ __('Create') . $resourceName }}
@stop

@section('container')
<div class="col-md-12">

    <div class="h2">{{ __('Create') . $resourceName }}
        <div class=" pull-right" role="toolbar" >
          @include('w.page_link')
        </div>
    </div>

    @include('w.breadcrumb')
    @include('w.notification')

    <div class="panel panel-default">
      @include('lottery.reset.detailForm')
    </div>
</div>
@stop

@section('end')
    {{ script('bootstrap-switch') }}
    @parent

@stop
