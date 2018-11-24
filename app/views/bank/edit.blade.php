@extends('l.admin', array('active' => $resource))

@section('title')
@parent
{{ $sPageTitle }}
@stop

@section ('styles')
    @parent
    {{ style('ueditor') }}
@stop


@section('container')

    <div class="col-md-12">
    @include('w.breadcrumb')
    @include('w._function_title')
    @include('w.notification')
    <div class="panel panel-default">
<div class=" panel-body">
    @include('bank.detailForm')
    </div></div>
</div>

@stop

@section('javascripts')
    @parent
    {{ script('ueditor.config') }}
    {{ script('ueditor.min') }}
    {{ script('zh-cn') }}
@stop

@section('end')
     {{ script('bootstrap-switch') }}
    @parent

    <script>

       UE.getEditor('editorBank');
    </script>
@stop
