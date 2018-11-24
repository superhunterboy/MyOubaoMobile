@extends('l.admin', ['active' => $resource])
@section('title')
@parent
{{ $sPageTitle }}
@stop
@section('container')

<div class="col-md-12">
    @include('w._function_title')
    @include('w.breadcrumb')
    @include('w.notification')

    <div class="panel panel-default">
        <div class=" panel-body">

            {{ Form::open(array('url' => route('exception-deposits.submit-document', ['id' => $data->id]), 'method' => 'post', 'files' => true, 'class' => 'form-horizontal')) }}
            <input type="hidden" name="id" value="{{ $data->id }}" />
            <div class="form-group">
                <label class="col-sm-3 control-label">{{ __('_exceptiondeposit.username') }}</label>
                <div class="col-sm-5">
                    <span class="form-control"  disabled/>{{ $data->username }}</span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">{{ __('_exceptiondeposit.order_no') }}</label>
                <div class="col-sm-5">
                    <span class="form-control"  disabled/>{{ $data->order_no }}</span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">{{ __('_exceptiondeposit.amount') }}</label>
                <div class="col-sm-5">
                    <span class="form-control"  disabled/>{{ $data->amount }}</span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">{{ __('_exceptiondeposit.accepter') }}</label>
                <div class="col-sm-5">
                    <span class="form-control"  disabled/>{{ $data->accepter }}</span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">{{ __('_exceptiondeposit.accepted_at') }}</label>
                <div class="col-sm-5">
                    <span class="form-control"  disabled/>{{ $data->accepted_at }}</span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label" for="transaction_pic">{{ __('_exceptiondeposit.transaction_pic_url') }}</label>
                <div class="col-sm-5">
                    <input class="form-control" name="transaction_pic" id="transaction_pic" type="file" />
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-5">
                    {{ Form::submit(__('Submit'), ['class' => 'btn btn-success']) }}
                </div>
            </div>

            {{ Form::close() }}

        </div>
    </div>
</div>
@stop
@section('end')
@parent
@stop
