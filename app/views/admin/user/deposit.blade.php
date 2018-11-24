@extends('l.admin', array('active' => $resource))

@section('title')
@parent
{{ __(' ') }}
@stop


@section('container')
<div class="col-md-12">
    <div class="h2">{{ __('_user.deposit_title') }}</div>
    @include('w.breadcrumb')
    @include('w.notification')

    <div class="panel panel-default">
        <div class=" panel-body">
            {{ Form::open(array('method' => 'post', 'class'=>'form form-horizontal', 'onkeydown'=> 'if(event.keycode==13)return false;') ) }}
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
                                <td class="default">{{$oAccount->balance_formatted}}</td>
                                <th class="success">{{ __('_account.frozen') }}：</th>
                                <td class="default">{{$oAccount->frozen_formatted}}</td>
                            </tr>
                            <tr>
                                <th class="success">{{ __('_account.available') }}：</th>
                                <td class="default">{{$oAccount->available_formatted}}</td>
                                <th class="success">{{ __('_account.withdrawable') }}：</th>
                                <td class="default">{{$oAccount->withdrawable_formatted}}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label ">{{ __('_account.deposit_amount') }}（{{__('_account.figure')}}）：</label>
                    <div class="col-sm-5">
                        <input type="text" data-toggle="tooltip" data-placement="top" class="form-control" id="j-numtochina"  name="amount" value="" title="" >
                        <h4 class="j-china" style="color:red"></h4>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label ">{{ __('_account.transaction_type') }}：</label>
                    <div class="col-sm-5">
                        <label class="btn btn-b btn-default btn-sm">
                            <input type="radio" name="transaction_type" checked value="18"> 人工充值
                        </label>
                        <label class="btn btn-b btn-default btn-sm">
                            <input type="radio" name="transaction_type" value="22"> 理赔充值
                        </label>
                        <label class="btn btn-b btn-default btn-sm">
                            <input type="radio" name="transaction_type" value="23"> 促销派奖
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label ">{{ __('_transaction.note') }}：</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control"  name="note" value="">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-6">
                        <button type="reset" class="btn btn-default">{{ __('Reset') }}</button>
                        <button type="button" id="J-submit" class="btn btn-success" >{{ __('Submit') }}</button>
                    </div>
                </div>
                <!--充值提醒-->
                <div class="modal fade" role="dialog" aria-labelledby="gridSystemModalLabel" aria-hidden="true"data-keyboard="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                          <h4 class="modal-title" id="gridSystemModalLabel">充值确认</h4>
                        </div>
                        <div class="modal-body">
                            <table class="table table-bordered">
                                <tr>
                                    <th style="width:120px;">{{ __('_user.username') }}：</th>
                                    <td>{{$oUser->username}}</td>
                                </tr>
                                <tr>
                                    <th style="width:120px;">{{ __('_account.deposit_amount') }}：</th>
                                    <td class="num">asdf</td>
                                </tr>
                            </table>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                          <button type="submit" class="btn btn-primary">确认</button>
                        </div>
                      </div>
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
        var inputText = function(dome){
            $(dome).val($(dome).val().replace(/[^0-9.]/g, ''));
            if(String($(dome).val()).split(".")[1] != null){
                $(dome).val((String($(dome).val()).split(".")[1].length >6) ? String($(dome).val()).split(".")[0]+'.'+String($(dome).val()).split(".")[1].substr(0,6) : $(dome).val());
            }
            $('.j-china').html(numtochinese($(dome).val()));
            $(dome).attr('title',$('.j-china').html());
        };
        $('#j-numtochina').keyup(function(){
            inputText(this)
        });
        $('#j-numtochina').blur(function () {
            inputText(this);
        });

        $('#J-submit').click(function(){
            $('.num').html($('#j-numtochina').val()+' (<font style="color:red">'+ $('.j-china').html()+'</font>)');
            $('.modal').modal()
        });
    });

</script>
@stop