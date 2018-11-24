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



<?php
$oFormHelper->setErrorObject($errors);
$oFormHelper->setModel(new ManIssue);

?>
<div class="panel panel-default">

{{ Form::open(array('url' => route('issues.batch-delete'), 'method' => 'POST', 'class' => 'form-horizontal', 'onsubmit'=>'return confirmDelete();')) }}
{{$oFormHelper->input('lottery_id', $lottery_id, ['id' => 'lottery_id', 'class' => 'form-control', 'options' => ${$aColumnSettings['lottery_id']['options']},'type'=>'select', 'empty' => true]);}}
{{$oFormHelper->input('begin_time',null,['id' => 'begin_time', 'class' => 'form-control','type'=>'date']);}}
{{$oFormHelper->input('end_time',null,['id' => 'end_time', 'class' => 'form-control','type'=>'date']);}}
{{$oFormHelper->input('begin_issue',null,['id' => 'begin_issue', 'class' => 'form-control','type'=>'text']);}}
{{$oFormHelper->input('end_issue',null,['id' => 'end_issue', 'class' => 'form-control','type'=>'text']);}}

<div class="form-group">
    <div class="col-sm-offset-2 col-sm-6">
        {{ Form::submit(__('Submit'), ['class' => 'btn btn-success']) }}
    </div>
</div>
{{Form::close()}}

</div>
</div>
@stop
@section('end')
<script>
    function confirmDelete() {
        if (confirm("确认要删除？")) {
            return true;
        } else {
            return false;
        }
    }

</script>
@parent

@stop
