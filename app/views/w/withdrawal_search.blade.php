<div class="panel panel-default">
    <div class=" panel-body">
        {{ Form::open(array('method' => 'get', 'class' => 'form-inline','id'=>'withdraw_search_form')) }}
            <input id="download_flag" name="download_flag"  value="" type="hidden" />
            <table style="width:100%">
                <tr>
                    <td>
                        <table>
                            <tr>
                                <td style="width:80px" class="text-right">处理状态：</td>
                                <td  style="width:160px">
                                    <select name="status" class="form-control input-xs j-select">
                                        <option value>全部</option>
                                        @foreach($validStatuses as $id =>$name) <option value="{{$id}}"@if(@strlen($aSearchFields['status'])>0&&@$aSearchFields['status']==$id)selected='selected' @endif>{{$name}}</option> @endforeach
                                    </select>
                                </td>
                                <td style="width:80px" class="text-right">处理人员：</td>
                                <td  style="width:160px">
                                    <input class="form-control input-xs" type="text" name="auditor" value="{{@$aSearchFields['auditor']}}">
                                </td>
                                <td style="width:80px" class="text-right">网络地址：</td>
                                <td  style="width:160px">
                                    <input class="form-control input-xs" type="text" name="serial_number" value="{{@$aSearchFields['serial_number']}}">
                                </td>
                                <td style="width:80px" class="text-right">用户身份：</td>
                                <td style="width:160px">
                                    <select id="way_id" name="role_id" class="form-control input-xs"> <option value>全部</option>@if(isset($aUserIds)) @foreach($aUserIds as $key => $val)<option value="{{$key}}"@if($key==@$aSearchFields['role_id'])selected="selected"@endif>{{$val}}</option> @endforeach @endif</select>
                                </td>
                            </tr>

                <tr>
                    <td  class="text-right">发起时间：</td>
                    <td >
                        <input class="form-control input-xs boot-time" type="text"  data-date-format="yyyy-mm-dd hh:ii" name="request_time[]"  value="{{@$aSearchFields['request_time'][0]}}">
                    </td>
                    <td class="text-right">至：</td>
                    <td >
                        <input class="form-control input-xs boot-time" type="text" data-date-format="yyyy-mm-dd hh:ii" name="request_time[]" value="{{@$aSearchFields['request_time'][1]}}">
                    </td>
                    <td class="text-right">提现用户：</td>
                    <td >
                        <input class="form-control input-xs" type="text"  data-date-format="yyyy-mm-dd hh:ii" name="username" value="{{@$aSearchFields['username']}}">
                    </td>
                    <td class="text-right">提现银行：</td>
                    <td>
                        <select id="way_id" name="bank_id" class="form-control input-xs"><option value>所有银行</option>
                            @foreach($aBanks as $id =>$name) <option value="{{$id}}"@if(@$aSearchFields['bank_id']==$id)selected='selected' @endif>{{$name}}</option> @endforeach</select>
                    </td>
                </tr>

                <tr>
                    <td  class="text-right">处理时间：</td>
                    <td >
                            <input class="form-control input-xs boot-time" type="text"  data-date-format="yyyy-mm-dd hh:ii" name="verified_time[]"  value="{{@$aSearchFields['verified_time'][0]}}">

                    </td>
                    <td class="text-right">至：</td>
                    <td >
                            <input class="form-control input-xs boot-time" type="text"  data-date-format="yyyy-mm-dd hh:ii" name="verified_time[]"   value="{{@$aSearchFields['verified_time'][1]}}">

                    </td>
                    <td class="text-right">总代：</td>
                    <td >
                        <input class="form-control input-xs" type="text" name="top_agent" value="{{@$aSearchFields['top_agent']}}">
                    </td>
                    <td class="text-right">测试账户：</td>
                    <td>
                        <select name="is_tester" class="form-control input-xs">
                            <option value>不限</option>
                            <option value="1" {{ @$aSearchFields['is_tester'] === '1' ? 'selected' : '' }}>是</option>
                            <option value="0" {{ @$aSearchFields['is_tester'] === '0' ? 'selected' : '' }}>否</option>
                        </select>
                    </td>
                </tr>

            </table>
        </td>
        <td class="text-left">
            <a class="btn btn-success" id='submit_withdraw'>搜索</a>
            <a class="btn btn-default" id='download_withdraw'>下载数据报表</a>
        </td>
    </tr></table>
<?php
echo Form::hidden('is_search');
echo Form::close();
?>

</div>
</div>

@section('end')
@parent
<script type="text/javascript">
    $('#download_withdraw').click(function () {
        $('#withdraw_search_form').attr('action', '/withdrawals/download');
        $('#withdraw_search_form').submit();
    });
    $('#submit_withdraw').click(function (event) {
        $('#withdraw_search_form').attr('action', '{{route(Route::current()->getName())}}');
        $('#withdraw_search_form').submit();
    });
</script>

@stop