@extends('l.admin', array('active' => $resource))

@section('title')
@parent
{{ $sPageTitle }}
@stop

@section('container')
<div class="col-md-12">

    @include('w.breadcrumb')
    @include('w._function_title')
    @include('w.notification')
<div class="panel panel-default">
<div class=" panel-body">
    @include('series.way-group.detailForm')
</div></div></div>
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
