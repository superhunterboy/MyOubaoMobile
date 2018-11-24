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
            @include('cms.article.detailForm')
        </div>
    </div>
</div>
    <?php
    $modalData['modal'] = array(
        'id'      => 'myModal',
        'title'   => '系统提示',
        'message' => '确认删除此'.$resourceName.'？',
        'footer'  =>
            Form::open(['id' => 'real-delete', 'method' => 'delete']).'
                <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">取消</button>
                <button type="submit" class="btn btn-sm btn-danger">确认删除</button>'.
            Form::close(),
    );
    ?>
    @include('w.modal', $modalData)

@stop

@section('javascripts')
    @parent
    {{ script('ueditor.config') }}
    {{ script('ueditor.min') }}
    {{ script('zh-cn') }}
@stop

@section('end')
    @parent

    <script>
        function modal(href)
        {
            $('#real-delete').attr('action', href);
            $('#myModal').modal();
        }
       UE.getEditor('editor');
    </script>
@stop
