<div class="panel panel-default">
      <div class=" panel-body">
{{ Form::open(array('method' => 'get', 'class' => 'form-inline','id'=>'deposit_search_form')) }}
<input id="download_flag" name="download_flag"  value="" type="hidden" />
<input name='deposit_mode' value='{{$aSearchFields['deposit_mode']}}' type='hidden'/>
<table style="width:100%"><tr>
        <td style="width:980px">
            <table>
                <tr>
                    <td style="width:80px" class="text-right">充值用户：</td>
                    <td  style="width:180px">
                        <input class="form-control input-xs" type="text" name="username" value="{{@$aSearchFields['username']}}">
                    </td>
                    <td style="width:100px" class="text-right">平台充值时间：</td>
                    <td  style="width:160px">
                        <input class="form-control boot-time input-xs" type="text" name="created_at[]" value="{{@$aSearchFields['created_at'][0]}}" >
                    </td>
                    <td style="width:80px" class="text-right">至：</td>
                    <td  style="width:180px">
                            <input class="form-control boot-time input-xs"  type="text" name="created_at[]" value="{{@$aSearchFields['created_at'][1]}}"  >
                        </div>
                    </td>
                    <td style="width:80px" class="text-right">附言：</td>
                    <td><input class="form-control input-xs" type="text" name="postscript" value="{{@$aSearchFields['postscript']}}" ></td>

                </tr>
                <tr>
                    <td class="text-right">发起银行：</td>
                    <td>
                        <select name="bank_id" class="form-control input-xs j-select">
                            <option value>所有银行</option>
                            @foreach($aBanks as $id =>$name) <option value="{{$id}}"@if(@$aSearchFields['bank_id']==$id)selected='selected' @endif>{{$name}}</option> @endforeach
                        </select>
                    </td>
                    <td style="width:100px" class="text-right">银行到账时间：</td>
                    <td  style="width:160px">
                            <input class="form-control boot-time input-xs" type="text" name="pay_time[]" value="{{@$aSearchFields['pay_time'][0]}}" >
                    </td>
                    <td style="width:80px" class="text-right">至：</td>
                    <td  style="width:180px">
                            <input class="form-control boot-time input-xs" type="text" name="pay_time[]" value="{{@$aSearchFields['pay_time'][1]}}"  >
                    </td>
                    @if($deposit_mode==2)
                    <td class="text-right">第三方平台：</td>
                    <td>
                        <select  name="platform_id"  class="form-control input-xs"><option value>所有方式</option>@foreach($aPaymentPlatform as $id =>$name) <option value="{{$id}}"@if(@strlen($aSearchFields['platform_id'])>0&&@$aSearchFields['platform_id']==$id)selected='selected' @endif>{{__('_deposit.'.$name)}}</option> @endforeach</select>
                        <input name='deposit_mode' value='{{$aSearchFields['deposit_mode']}}' type='hidden'/>
                    </td>
                    @endif
                </tr>
                <tr>
                    <td class="text-right">处理状态：</td>
                    <td>
                        <select  name="status"  class="form-control input-xs"><option value>所有状态</option>@foreach($validStatuses as $id =>$name) <option value="{{$id}}"@if(@strlen($aSearchFields['status'])>0&&@$aSearchFields['status']==$id)selected='selected' @endif>{{__('_deposit.'.$name)}}</option> @endforeach</select>
                    </td>
                    <td class="text-right">订单号：</td>
                    <td>
                        <input class="form-control input-xs" type="text" name="order_no" value="{{@$aSearchFields['order_no']}}">
                    </td>
                    <td  class="text-right">每页条数：</td>
                    <td><select name="pagesize"  class="form-control input-xs"><option value="15" @if(@$aSearchFields['pagesize']==15)selected='selected' @endif>15</option><option value="30"@if(@$aSearchFields['pagesize']==30)selected='selected' @endif>30</option><option value="50"@if(@$aSearchFields['pagesize']==50)selected='selected' @endif>50</option><option value="100"@if(@$aSearchFields['pagesize']==100)selected='selected' @endif>100</option></select></td>
                    <td class="text-right">测试账户：</td>
                    <td>
                        <select name="is_tester" style="width:100%" class="form-control input-xs">
                            <option value>不限</option>
                            <option value="1" {{ @$aSearchFields['is_tester'] === '1' ? 'selected' : '' }}>是</option>
                            <option value="0" {{ @$aSearchFields['is_tester'] === '0' ? 'selected' : '' }}>否</option>
                        </select>
                    </td>
                </tr>


            </table>
        </td>
        <td class="text-right">
            <a class="btn btn-success"  id='submit_deposit'>搜索</a>
            <a class="btn btn-default"  id="download_deposit">下载数据报表</a>
        </td>
    </tr></table>
<?php
echo Form::hidden('is_search');
echo Form::close();
?>
</div></div>
@section('end')
@parent
<script type="text/javascript">
    $(function () {
        //切换
        $('.j-select').change(function () {
            if ($(this).val() == 1) {
                $('.j-none').hide().eq('1').show();
            } else {
                $('.j-none').hide().eq('0').show();
            }
        });

        $('#download_deposit').click(function () {
            $('#deposit_search_form').attr('action','/deposits/download');
            $('#deposit_search_form').submit();
        });

        $('#submit_deposit').click(function () {
            $('#deposit_search_form').attr('action','/deposits');
            $('#deposit_search_form').submit();
        });
    });
</script>

@stop