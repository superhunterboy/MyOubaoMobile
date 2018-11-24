@extends('l.admin')

@section('title')
@parent

@stop

@section('javascripts')
@parent
@stop

@section('container')
<div class="col-md-12">

@include('w.breadcrumb')
<div class="h2">{{ __($sLangKey,['resource' => $resourceName]) }}
</div>


@include('w.notification')


{{ Form::open(array('method' => 'post', 'class'=>'form form-horizontal', 'action'=>'prize-set-float-rules.update') ) }}
<div class="panel panel-default">
    <div class=" panel-body">
        <div  class="form-inline" >
            <label for="float_enabled" class=""><input type="checkbox" name="float_enabled" @if($floatEnabled==1)checked@endif data-toggle="switch" />总开关</label>
            <div class="pull-right">
                <label><input name="lottery_series_ssc" type="checkbox" @if(str_contains($floatSeries,'1'))checked@endif/> 时时彩</label>
                <label><input name="lottery_series_11y" type="checkbox" @if(str_contains($floatSeries,'2'))checked@endif/> 11选5</label>
            </div>
        </div>
    </div>
</div>



<div class="panel panel-default">
    <table class="table table-hover table-bordered">
        <thead class="thead-mini  thead-inverse">
            <tr id="j-tr-dome">
                <th width="120px">目标奖金组</th>
                <th>周期(单位:天)</th>
                @foreach($aTopAgentPrizeGroups as $val)
                <th>{{$val}}(单位:万)</th>
                @endforeach
                <th>{{ __('_basic.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            <?php $iUp = $iDown = 1; ?>
            @foreach($aLiftRules as $bUp => $aTurnovers)
                @foreach($aTurnovers as $iDays => $aTurnover)
                <tr>
                    <input type="hidden" name="liftType[]" value="{{$bUp}}" disabled />
                    <td class="j-type">@if($bUp==1)升点条件{{$iUp++}}@elseif($bUp==0)保点条件{{$iDown++}}@endif</td>
                    <td class="j-date"><input type="text" name="day[]" class="form-control td-input input-xs" value="{{$iDays}}" readonly/></td>
                        @foreach($aTopAgentPrizeGroups as $val)
                            <td class="j-f">
                                <input type="text" name="turnover{{$val}}[]" class="form-control td-input input-xs" value="{{@$aTurnover[$val]}}" disabled/>
                            </td>
                        @endforeach
                    <td>
                        <a href="javascript:void(0);" id="cancle" class="btn btn-xs  btn-danger j-delete" onclick="modal('{{route('prize-set-float-rules.delete')}}?day={{$iDays}}&is_up={{$bUp}}');">删除</a>
                    </td>
                </tr>
                @endforeach
            @endforeach

        </tbody>
    </table>
    <div class="panel-footer">
            <span id="j-add-btn" class="btn  btn-xs btn-default">增加条件</span>

            <div class="pull-right">
                <span id="revise" class="btn  btn-xs btn-danger">修改</span>
                <input type="submit" class="btn  btn-xs btn-success" value="保存设置" />
                <a href="{{route('prize-set-float-rules.index')}}" id="cancle" class="btn btn-xs btn-default">取消</a>
            </div>
    </div>
</div>
{{form::close()}}

<?php
$modalData['modal'] = array(
    'id' => 'myModal',
    'title' => '系统提示',
    'message' => __('_basic.delete-confirm', $aLangVars) . '？',
    'footer' =>
    Form::open(['id' => 'real-delete', 'method' => 'delete']) . '
            <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">取消</button>
            <button type="submit" class="btn btn-sm btn-danger">确认删除</button>' .
    Form::close(),
);
?>
@include('w.modal', $modalData)

</div>
@stop

@section('end')
@parent
<script type="text/javascript">
    $(function () {

        function dHtml(i) {
            return '<td class="j-f">'
                    + '<input type="text" name="turnover' + i + '[]" class="form-control td-input input-xs" value=""/>'
                    + '</td>';
        }
        var tdType = '<td class="j-type">'
                + '<select class="form-control input-xs" name="liftType[]">'
                + '<option value="1" selected="selected">升点条件</option>'
                + '<option value="0" selected="selected">保点条件</option>'
                + '</select>'
                + '</td>'
                + '<td class="j-date"><input name="day[]" type="text" class="form-control td-input input-xs" value=""/></td>';
        var delBtn = '<td >'
                + '<span class="btn btn-xs btn-danger j-delete" onclick="removeDiv(this);">删除</span>'
                + '</td>';
        //html结构
        function html(n) {
            var tHtml = [];
            tHtml.push(tdType);
            for (var i = 2; i < n; i++) {
                tHtml.push(dHtml(1954 + i));
            }
            tHtml.join(',');
            return '<tr class="j-tr warning">' + tHtml + delBtn + '</tr>';
        }
        ;

        $('#j-add-btn').click(function () {
            var thLength = $('#j-tr-dome').find('th').length;
            $('tbody').append(html(thLength - 1));
            $('input').attr("disabled", false);
        });
        $('#revise').click(function () {
            $('input').attr("disabled", false);
        });

    });
    function removeDiv(dome) {
        $(dome).parent().parent('tr.j-tr').remove();
    }

    function modal(href)
    {
        $('#real-delete').attr('action', href);
        $('#myModal').modal();
    }
</script>

@stop
