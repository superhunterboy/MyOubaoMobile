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
    //add-AD-img
    var i=2;
    $('a[name=plus-img]').click(function(){

        var html = '<div class="file-img-box">'
                  +'<input type="file" class="form-control" style="padding:5px;" name="image'+i+'" >'
                  +'<span class="glyphicon glyphicon-remove form-control-feedback-img" onclick="removeDiv(this);"></span>'
                  +'<div>';

        $('div[name=file-img]').append(html);
        $('input[name=btnCount]').val(i);
        return i++;
    })

    function removeDiv(dome){
        $(dome).parent().remove();

    };
            UE.getEditor('editor');
</script>
@stop
