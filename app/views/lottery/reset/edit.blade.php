@extends('l.admin', array('active' => $resource))

@section('title')
@parent
{{ __('Edit') . $resourceName }}
@stop


@section('container')
<div class="col-md-12">

    <div class="h2">{{ __('Edit') . $resourceName }}
        <div class=" pull-right" role="toolbar" >
          @include('w.page_link')
        </div>
    </div>

    @include('w.breadcrumb')
    @include('w.notification')
    <div class="panel panel-default">

        @include('default.detailForm')
        </div>
</div>
@stop

@section('end')
     {{ script('bootstrap-switch') }}
    @parent

    <script>
        function modal(href)
        {
            $('#real-delete').attr('action', href);
            $('#myModal').modal();
        }
    </script>
@stop
