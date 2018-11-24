<div class="panel panel-default">
    <div class="panel-body">
        {{ Form::open(array('method' => 'get', 'class' => 'form-inline', 'id'=>'project_search_form')) }}
        <input id="download_flag" name="download_flag"  value="" type="hidden" />
        <table style="width:100%"><tr>
                <td>
                    <table>
                        <tr>
                            <td style="width:100px" class="text-right">注单编号：</td>
                            <td  style="width:150px">
                                <input class="form-control input-xs" type="text" name="serial_number" value="{{@$aSearchFields['serial_number']}}">
                            </td>
                            <td style="width:100px" class="text-right">游戏时间：</td>
                            <td  style="width:150px">
                                <input class="form-control input-xs boot-time" type="text" name="created_at[]" value="{{@$aSearchFields['created_at'][0]}}" >
                            </td>
                            <td style="width:100px" class="text-right">至：</td>
                            <td  style="width:150px">
                                <input class="form-control input-xs boot-time" type="text" name="created_at[]" value="{{@$aSearchFields['created_at'][1]}}"  >
                            </td>
                            <td style="width:100px" class="text-right">测试用户：</td>
                            <td  style="width:150px">
                                <select name="is_tester" style="width:100%" class="form-control input-xs">
                                    <option value>不限</option>
                                    <option value="1" {{ @$aSearchFields['is_tester'] === '1' ? 'selected' : '' }}>是</option>
                                    <option value="0" {{ @$aSearchFields['is_tester'] === '0' ? 'selected' : '' }}>否</option>
                                </select>
                            </td>

                        </tr>

                        <tr>
                            <td class="text-right">用户搜索：</td>
                            <td>
                                <select name="user_search_type" class="form-control input-xs j-select">
                                    <option value="1" {{ @$aSearchFields['user_search_type'] == 1 ? 'selected' : '' }} >手工输入用户名</option>
                                    <option value="2" {{ @$aSearchFields['user_search_type'] == 2 ? 'selected' : '' }} >总代列表</option>
                                </select>
                            </td>
                            <td colspan="2" class="j-none" @if(!isset($aSearchFields['user_search_type'])||$aSearchFields['user_search_type']==1)style="display: none;"@endif>
                                <div class="form-group">
                                    <select name="root_agent" class="form-control input-xs">
                                        <option value>所有总代</option>
                                        @foreach($aRootAgent as $id => $name)
                                        <option value="{{ $name }}" {{ @$aSearchFields['root_agent']==$name ? 'selected' : '' }} >{{ $name }}</option>
                                        @endforeach
                                    </select>
                                    <label >
                                        <input name="ra_include_children" type="checkbox" name="sel" value="1" checked="checked" disabled="true">含下级
                                    </label>
                                </div>
                            </td>
                            <td colspan="2" class="j-none" @if(isset($aSearchFields['user_search_type'])&&$aSearchFields['user_search_type']==2)style="display: none;"@endif>
                                <div class="form-group">
                                    <input  class="form-control input-xs" type="text" name="username" value="{{@$aSearchFields['username']}}">
                                    <label >
                                        <input name="un_include_children" type="checkbox" name="sel" value="1"@if(@$aSearchFields['un_include_children']==1)checked @endif>含下级
                                    </label>
                                </div>
                            </td>
                            <td class="text-right">元角模式：</td>
                            <td >
                                <select name="coefficient" style="width:100%" class="form-control input-xs">
                                    <option value>不限</option>
                                    @foreach($aCoefficients as $id => $value)
                                    <option value="{{ $id }}" {{ @$aSearchFields['coefficient'] == $id ? 'selected' : '' }} >{{ $value }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td style="width:80px" class="text-right">状态：</td>
                            <td  style="width:180px">
                                <?php
                                $aStatusDescs = [];
                                foreach ($aStatusDesc as $key => $value) {
                                    $aStatusDescs[$key] = __('_project.' . strtolower(Str::slug($value)));
                                }
                                ?>
                                <select name="status" style="width:100%" class="form-control input-xs">
                                    <option value>不限</option>
                                    @foreach ($aStatusDescs as $key => $value)
                                    <option value="{{ $key }}" {{ @$aSearchFields['status'] === (string)$key ? 'selected' : '' }}>{{ $value }}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>

                        <tr>
                            <td class="text-right">游戏名称：</td>
                            <td>
                                <select id="lottery_id" name="lottery_id" style="width:100%" class="form-control input-xs">
                                    <option value>所有游戏</option>
                                    @foreach($aLotteries as $id =>$name)
                                    <option value="{{ $id }}" {{ @$aSearchFields['lottery_id'] == $id ? 'selected' : '' }} >{{ $name }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="text-right">游戏玩法：</td>
                            <td>
                                <select id="way_id" name="way_id" style="width:100%" class="form-control input-xs">
                                    <option value>所有玩法</option>
                                    @if(isset($aLotteryWays))
                                    @foreach($aLotteryWays as $val)
                                    <option value="{{ $val['id'] }}" {{ $val['id'] == $aSearchFields['way_id'] ? 'selected' : '' }} >{{ $val['name'] }}
                                    </option>
                                    @endforeach
                                    @endif
                                </select>
                            </td>
                            <td class="text-right">游戏奖期：</td>
                            <td>
                                <select id="issue" name="issue" style="width:100%" class="form-control input-xs">
                                    <option value>所有奖期</option>
                                    @if(isset($aIssues))
                                    @foreach($aIssues as $val)
                                    <option value="{{ $val['name'] }}" {{ $val['name'] == $aSearchFields['issue'] ? 'selected' : '' }} >{{ $val['name'] }}</option>
                                    @endforeach
                                    @endif
                                </select>
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
                        </tr>
                        <tr>
                            <td style="width:100px" class="text-right">投注金额：</td>
                            <td  style="width:150px">
                                <input class="form-control input-xs" type="text" name="amount[]" value="{{@$aSearchFields['amount'][0]}}">
                            </td>
                            <td style="width:100px" class="text-right">至：</td>
                            <td  style="width:150px">
                                <input class="form-control input-xs boot-time" type="text" name="amount[]" value="{{@$aSearchFields['amount'][1]}}"  >
                            </td>
                            <td style="width:100px" class="text-right">&nbsp;</td>
                            <td  style="width:150px">&nbsp;</td>
                        </tr>
                    </table>
                </td>
                <td class="text-right">
                    <input class="btn btn-success" type="submit" id="submitForm" value="搜索"/>
                    <a class="btn btn-default" id="download">下载数据报表</a>
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
        $('#download').click(function () {
            $('#project_search_form').attr('action', '/projects/download');
            $('#project_search_form').submit();
        });
        $('#submitForm').click(function (event) {
            $('#project_search_form').attr('action', '/projects');
            $('#project_search_form').submit();
        });

        //切换
        $('.j-select').change(function () {
            if ($(this).val() == 1) {
                $('.j-none').hide().eq('1').show();
            } else {
                $('.j-none').hide().eq('0').show();
            }
        });
        function resetSelectForm(selectId, title) {
            var selectDom = $("#" + selectId);
            selectDom.html("<option value>" + title + "</option>");
        }
        function setDatatoSelectForm(selectId, title, data) {
            var selectDom = $("#" + selectId);
            resetSelectForm(selectId, title);
            var optstr = "";
            $(data).each(function () {
                if (selectId == 'way_id') {
                    optstr += "<option value='" + this.id + "'>" + this.name + "</option>";
                } else if (selectId == 'issue') {
                    optstr += "<option value='" + this.name + "'>" + this.name + "</option>";
                }
            });
            selectDom.append(optstr);
        }

        $('#lottery_id').change(function () {
            var lottery_id = $("#lottery_id").val();
            if (lottery_id > 0) {
                $.ajax({
                    url: '/projects/?action=ajax&lottery_id=' + lottery_id,
                    type: 'GET',
                }).done(function (data) {
                    jsonObj = eval("(" + data + ")");
                    lotteryWays = jsonObj.lottery_ways;
                    setDatatoSelectForm('way_id', '所有玩法', lotteryWays);
                    issues = jsonObj.issues;
                    setDatatoSelectForm('issue', '所有奖期', issues);
                }).fail(function (data) {
                    alert('Getl Data Failed!', 'Tip');
                });
            } else {
                resetSelectForm('way_id', '所有玩法');
                resetSelectForm('issue', '所有奖期');
            }
        });
    });
</script>

@stop