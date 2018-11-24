@extends('l.admin', array('active' => $resource))

@section('title')
@parent
{{ __(' ') }}
@stop

@section('container')
<div class="col-md-12">
    <div class="h2">{{ __('_user.withdraw_title') }}</div>

    @include('w.breadcrumb')
    @include('w.notification')

    <div class="panel panel-default">
        <div class=" panel-body">
            {{ Form::open(array('method' => 'post', 'class'=>'form form-horizontal') ) }}
            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
            <input type="hidden" name="_method" value="PUT" />
            <div class="form-group">
                <label class="col-sm-3 control-label ">{{ __('_user.username') }}：</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" name="username" value="{{$oUser->username}}" readonly="true">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label ">{{ __('_account.fund') }}：</label>
                <div class="col-sm-5">
                    <table class="table table-bordered">
                        <tr>
                            <th class="success">{{ __('_account.balance') }}：</th>
                            <td class="active">{{$oAccount->balance_formatted}}</td>
                            <th class="success">{{ __('_account.frozen') }}：</th>
                            <td class="active">{{$oAccount->frozen_formatted}}</td>
                        </tr>
                        <tr>
                            <th class="success">{{ __('_account.available') }}：</th>
                            <td class="active">{{$oAccount->available_formatted}}</td>
                            <th class="success">{{ __('_account.withdrawable') }}：</th>
                            <td class="active">{{$oAccount->withdrawable_formatted}}</td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label ">{{ __('_account.withdrawal_amount') }}（{{__('_account.figure')}}）：</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" id="j-numtochina"  name="amount">
                    <h3 class="j-china" style="color:red"></h3>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label ">{{ __('_account.transaction_type') }}：</label>
                <div class="col-sm-5">
                    <label class="btn btn-b btn-default btn-sm">
                        <input type="radio" name="transaction_type" checked value="25"> 人工扣减
                    </label>
                    <label class="btn btn-b btn-default btn-sm">
                        <input type="radio" name="transaction_type" value="19">管理员提现
                    </label>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label ">{{ __('_transaction.note') }}：</label>
                <div class="col-sm-5">
                    <input name="note"  class="form-control"  type="text">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-5">
                    <button type="reset" class="btn btn-default">{{ __('Reset') }}</button>
                    <button type="submit" id="J-submit" class="btn btn-success" >{{ __('Submit') }}</button>
                </div>
            </div>
            {{Form::close()}}
        </div>
    </div>
</div>
@stop
@section('end')
{{ script('numtochinese') }}
@parent
<script>
    $(function () {

        $('#j-numtochina').keyup(function () {
            $(this).val($(this).val().replace(/[^0-9.]/g, ''));
            $('.j-china').text(numtochinese($(this).val()));
        });

        // $('#J-submit').click(function(){
        //     $('#myModal').modal('show')
        // });
    })
</script>
@stop