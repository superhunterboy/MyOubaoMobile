@extends('l.admin', ['active' => $resource])
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
if (isset($aTotalColumns)){
    $aTotals = array_fill(0, count($aColumnForList),null);
    $aTotalColumnMap = array_flip($aColumnForList);
}
?>
@foreach($aWidgets as $sWidget)
@include($sWidget)
@endforeach
<?php //    die($sSetOrderRoute); ?>
@if ($bSequencable)
{{ Form::open(['action' => $sSetOrderRoute ]) }}
@endif

<div class="panel panel-default">
<table class="table table-striped table-hover table-bordered">
    <thead class="thead-mini  thead-inverse">
        <tr style="border-bottom: 1px solid #fff;">
            <th class="text-center" colspan="12">充值平台信息</th>
            <th class="text-center" colspan="5">渠道查询信息</th>
        </tr>
        <tr>
            @foreach( $aColumnForList as $sColumn )
            <th>{{ (__($sLangPrev . $sColumn, null, 3)) }}</th>
            <?php
                if (isset($aTotalColumns)){
                    in_array($sColumn, $aTotalColumns) or $aTotalColumnMap[$sColumn] = null;
                }
            ?>
            @endforeach
            <th>{{ __('_basic.actions') }}</th>
        </tr>
    </thead>
    <tbody>

        @foreach ($datas as $data)
            <?php
            $bHighlight = (time() - strtotime($data->created_at) > 1800) && ($data->status == Deposit::DEPOSIT_STATUS_RECEIVED);
            ?>
            <tr @if($bHighlight)style='color:red'@endif>
            @foreach ($aColumnForList as $sColumn)
            <?php
                if (isset($aTotalColumns)){
                    is_null($aTotalColumnMap[$sColumn]) or $aTotals[$aTotalColumnMap[$sColumn]] += $data->$sColumn;
                }
//    $sDisplayColumn = isset($aColumnDisplayMaps[ $sColumn ]) ? $aColumnDisplayMaps[ $sColumn ] : $sColumn;
                if (isset($aListColumnMaps[$sColumn])) {
                    $sDisplayValue = $data->{$aListColumnMaps[$sColumn]};
                } else {
                    if ($sColumn == 'sequence') {
                        $sDisplayValue = Form::text('sequence[' . $data->id . ']', $data->sequence, ['class' => 'form-control', 'style' => 'width:70px;text-align:right']);
                    } else {
                        if (isset($aColumnSettings[$sColumn]['type'])) {
                            $sDisplayValue = $sColumn . $aColumnSettings[$sColumn]['type'];
                            switch ($aColumnSettings[$sColumn]['type']) {
                                case 'bool':
                                    $sDisplayValue = $data->$sColumn ? __('Yes') : __('No');
                                    break;
                                case 'select':
                                    //                                        $sDisplayValue = (isset($data->$sColumn) && !is_null($data->$sColumn)) ? ${$aColumnSettings[$sColumn]['options']}[$data->$sColumn] : null;
                                    $sDisplayValue = !is_null($data->$sColumn) ? ${$aColumnSettings[$sColumn]['options']}[$data->$sColumn] : null;
                                    break;
                                default:
                                    $sDisplayValue = is_array($data->$sColumn) ? implode(',', $data->$sColumn) : $data->$sColumn;
                            }
                            if ($sColumn == 'updated_at') {
                                if($data->status==Deposit::DEPOSIT_STATUS_SUCCESS){
                                        $sDisplayValue = $data->updated_at;
                                    }else{
                                        $sDisplayValue = '';
                                    }
                            }
                        }
                        if (array_key_exists($sColumn, $aNumberColumns)) {
                            $sDisplayValue = number_format($sDisplayValue, $aNumberColumns[$sColumn]);
                        }
                    }
                }
                ?>
                <td>{{$sDisplayValue}}</td>
           @endforeach
            <td>
                @include('w.item_link')
            </td>
        </tr>
        @endforeach
    </tbody>
        @if (isset($aTotalColumns))
        <tfoot>
            <tr>
                <td>{{ __('grand-total-per-page') }}</td>
                @for($i = 1; $i < count($aColumnForList); $i++)
                <td class="">{{  is_null($aTotals[$i]) ? ' ' : number_format($aTotals[$i], (array_key_exists($aColumnForList[$i], $aNumberColumns) ? $aNumberColumns[$aColumnForList[$i]] : 2)) }}</td>
                @endfor
                <td></td>
            </tr>
        </tfoot>
        @endif

</table>
</div>

<div class="pull-left">
    @if ($bSequencable)
        {{ Form::submit(__('_basic.set-order',null,2), ['class' => 'btn btn-success btn-b btn-xs']) }}
    @endif
    @include('w.page_batch_link')
</div>
{{ pagination($datas->appends(Input::except('page')), 'p.slider-3') }}

@if ($bSequencable)
{{ Form::close() }}
@endif
<?php
//pr($aLangVars);
//exit;
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
<script>
    function modal(href)
    {
    $('#real-delete').attr('action', href);
            $('#myModal').modal();
    }

</script>
@stop

