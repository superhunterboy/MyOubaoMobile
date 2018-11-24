@extends('l.admin', array('active' => $resource))

@section('title')
@parent
{{ __('Edit') . $resourceName }}
@stop

@section('container')
<div class="col-md-12">
    @include('w.breadcrumb')
    @include('w._function_title')
    @include('w.notification')

<div class="panel panel-default">
<div class=" panel-body">
    <form class="form-horizontal" method="post" enctype="multipart/form-data" action="{{  route($resource.'.edit', $data->id) }}"  autocomplete="off">
            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
            <input type="hidden" name="_method" value="PUT" />
        @include('advertisement.editForm')


        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
              <a class="btn btn-default" href="{{  route($resource.'.edit', $data->id) }}">{{ __('Reset') }}</a>
              <button type="submit" class="btn btn-success">{{ __('Submit') }}</button>
            </div>
        </div>
    </form>
</div>
</div>
<?php
$modalData['modal'] = array(
    'id'      => 'myModal',
    'title'   => '系统提示',
    'message' => '确认删除此'.$resourceName.'？',
    'footer'  =>
        Form::open(['id' => 'real-delete', 'method' => 'delete']).
            '<button class="btn btn-sm btn-default" type="submit">确认上传</button>'.
            '<button type="submit" class="btn btn-sm btn-danger">取消</button>'.
        Form::close(),
);
?>

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
        };
    </script>
@stop
