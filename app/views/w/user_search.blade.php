<div class="panel panel-default">
    <div class=" panel-body">
        {{ Form::open(array('method' => 'get', 'class' => 'form-inline', 'id'=>'user_search_form')) }}
            <table style="width:100%">
            <tr>
                <td >
                    <table>
                        <tr>
                            <td class="text-right">用户名称：</td>
                            <td >
                                <input class="form-control input-xs" type="text" name="username" value="{{@$aSearchFields['username']}}">
                            </td>
                            <td class="text-right">用户组：</td>
                            <td>
                                <select name="user_group" style="width:100%" class="form-control input-xs"><option value>不限</option>
                                    @foreach($aUserTypes as $id =>$name) <option value="{{$id}}" @if(isset($aSearchFields['user_group']) && @$aSearchFields['user_group']===$id.'')selected='selected' @endif>{{__('_user.'.$name)}}</option> @endforeach</select>
                            </td>
                            <td class="text-right">可用余额 ：</td>
                            <td >
                                <input class="form-control input-xs" type="text" style="width:80px;" name="amount[]" value="{{@$aSearchFields['amount'][0]}}"> 至
                                <input class="form-control input-xs" type="text" style="width:80px;" name="amount[]" value="{{@$aSearchFields['amount'][1]}}">(元)
                            </td>
                            <td style="width:80px" class="text-right">测试用户：</td>
                            <td>
                                <select name="is_tester" class="form-control input-xs">
                                    <option value>不限</option>
                                    <option value="1" {{ @$aSearchFields['is_tester'] === '1' ? 'selected' : '' }}>是</option>
                                    <option value="0" {{ @$aSearchFields['is_tester'] === '0' ? 'selected' : '' }}>否</option>
                                </select>
                            </td>
                        </tr>

                        <tr>
                            <td  class="text-right">注册时间：</td>
                            <td >
                                <input class="form-control boot-time input-xs" type="text" name="created_at_from" data-date-format="yyyy-mm-dd hh:ii" value="{{@$aSearchFields['created_at_from']}}">
                            </td>
                            <td class="text-right">至：</td>
                            <td >
                                    <input class="form-control boot-time input-xs" data-date-format="yyyy-mm-dd hh:ii" type="text" name="created_at_to" value="{{@$aSearchFields['created_at_to']}}">
                            </td>
                            <td  class="text-right">每页条数：</td>
                            <td>
                                <select name="pagesize" style="width:100%" class="form-control input-xs">
                                    <option value="15"  {{ @$aSearchFields['pagesize'] == 15 ?  'selected' : '' }}>15</option>
                                    <option value="30"  {{ @$aSearchFields['pagesize'] == 30 ?  'selected' : '' }}>30</option>
                                    <option value="50"  {{ @$aSearchFields['pagesize'] == 50 ?  'selected' : '' }}>50</option>
                                    <option value="100" {{ @$aSearchFields['pagesize'] == 100 ? 'selected' : '' }}>100</option>
                                </select>
                            </td>
                            <td class="text-right">&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                    </table>
                </td>
                <td class="text-right">
                    <input class="btn btn-success unLoding" type="submit" id="submitForm" value="搜索"/>
                    <a class="btn btn-default"  id="download">下载数据报表</a>
                </td>
            </tr>
        </table>
        <?php
        echo Form::hidden('is_search');
        echo Form::close();
        ?>
    </div>
</div>

@section('end')
@parent
<script type="text/javascript">
    $(function () {
        $('#download').click(function () {
            $('#user_search_form').attr('action','/users/download');
            $('#user_search_form').submit();
        });
        $('#submitForm').click(function(event) {
            $('#user_search_form').attr({'action':'/users','target':'iframe'});
            $('#user_search_form').submit();
        });
    });
</script>
@stop