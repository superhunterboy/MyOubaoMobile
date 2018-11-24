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
        <div class="panel-body">
            {{ Form::model($oQuota, array('method' => 'post', 'class' => 'form-horizontal')) }}
            <input type="hidden" name="id" value="{{$oQuota->id}}" />
            <div class="form-group">
                <label for="username" class="col-sm-3 control-label">用户名</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" id="username" name="username" value="{{$oQuota->username}}" readonly="true">
                </div>
            </div>
            <div class="form-group">
                <label for="username" class="col-sm-3 control-label">奖金组</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" id="prize_group" name="prize_group" value="{{$oQuota->prize_group}}" readonly="true">
                </div>
            </div>
            <div class="form-group">
                <label for="username" class="col-sm-3 control-label">总配额</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" id="total_quota" name="total_quota" value="{{$oQuota->total_quota}}" readonly="true">
                </div>
            </div>
            <div class="form-group">
                <label for="username" class="col-sm-3 control-label">剩余配额</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" id="left_quota" name="left_quota" value="{{$oQuota->left_quota}}" readonly="true">
                </div>
            </div>
            <div class="form-group">
                <label for="username" class="col-sm-3 control-label">增加配额</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" id="quota_add" name="quota_add" value="">
                </div>
            </div>
            <div class="col-sm-offset-3 col-sm-5">
                <button type="reset" class="btn btn-default">重置</button>
                <button type="submit" class="btn btn-success">提交</button>
            </div>
            {{Form::close()}}
        </div>
    </div>
</div>
@stop

@section('end')

@parent

<script>
    function modal(href)
    {
        $('#real-delete').attr('action', href);
        $('#myModal').modal();
    }
</script>
@stop
