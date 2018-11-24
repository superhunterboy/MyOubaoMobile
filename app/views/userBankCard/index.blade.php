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



    @foreach($aWidgets as $sWidget)
    @include($sWidget)
    @endforeach
    <div class="panel panel-default">
        <table class="table table-striped table-hover">
            <thead class="thead-mini  thead-inverse">
                <tr>
                    @if ($bCheckboxForBatch)
                    <th><input type="checkbox" id="allCheckbox" name="allCheckbox"></th>
                    @endif
                    @foreach( $aColumnForList as $sColumn )
                    <th class="text-center">{{ (__($sLangPrev . $sColumn, null, 3)) }}
                        @if (!in_array($sColumn, $aNoOrderByColumns))
                        {{ order_by($sColumn) }}
                        @endif
                    </th>
                    <?php
                    if (isset($aTotalColumns)) {
                        in_array($sColumn, $aTotalColumns) or $aTotalColumnMap[$sColumn] = null;
                    }
                    ?>
                    @endforeach
                    <th>{{ __('_basic.actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($datas as $data)
                <tr>
                    @if ($bCheckboxForBatch)
                    <td ><input type="checkbox" name="selectFlag" value="{{$data->id}}">
                    @endif
                    <?php
                    foreach ($aColumnForList as $sColumn) {
                        if (isset($aTotalColumns)) {
                            if (!is_null($aTotalColumnMap[$sColumn])) {
                                $fResult = $data->is_income==='0' ? -$data->$sColumn : $data->$sColumn;
                                $aTotals[$aTotalColumnMap[$sColumn]] += $fResult;
                            }
                        }
                    //    $sDisplayColumn = isset($aColumnDisplayMaps[ $sColumn ]) ? $aColumnDisplayMaps[ $sColumn ] : $sColumn;
                        $sClass = '';
                        if (isset($aListColumnMaps[ $sColumn ])){
                            $sDisplayValue = $data->{$aListColumnMaps[ $sColumn ]};
                        }
                        else{
                            if ($sColumn == 'sequence'){
                                $sDisplayValue = Form::text('sequence[' . $data->id . ']',$data->sequence,['class' => 'form-control input-xs','style' => 'width:50px;text-align:right']);
                            }
                            else{
                                if (isset($aColumnSettings[ $sColumn ][ 'type' ])){
                                    $sDisplayValue = $sColumn . $aColumnSettings[ $sColumn ][ 'type' ];
                                    switch ($aColumnSettings[ $sColumn ][ 'type' ]){
                                        case 'bool':
                                            $sDisplayValue = !is_null($data->$sColumn) ? ($data->$sColumn ? __('Yes') : __('No')) : null;
                                            break;
                                        case 'select':
                                            $sDisplayValue = !is_null($data->$sColumn) ? ${$aColumnSettings[ $sColumn ][ 'options' ]}[ $data->$sColumn ] : null;
                                            break;
                                        case 'numeric':
                                            if (!isset($aNumberColumns[$sColumn])){
                                                $aNumberColumns[$sColumn] = $iDefaultAccuracy;
                                            }
                                        default:
                                            $sDisplayValue = is_array($data->$sColumn) ? implode(',',$data->$sColumn) : $data->$sColumn;
                                    }
                                }
                                else{
                                    $sDisplayValue = $data->$sColumn;
                                }
                                if (!in_array($sColumn, $aOriginalNumberColumns) && array_key_exists($sColumn,$aNumberColumns)){
                                    $sDisplayValue = number_format($sDisplayValue,$aNumberColumns[ $sColumn ]);
                                }
                            }
                        }
                        if (isset($aColumnSettings[ $sColumn ][ 'type' ]) && $aColumnSettings[ $sColumn ][ 'type' ] == 'numeric'){
                            $sClass = 'text-right';
                        }
                        else{
                            $sClass = 'text-center';
                        }

                        if (in_array($sColumn,$aWeightFields)){
                            $sClass .= ' text-weight';
                        }
                        if (in_array($sColumn,$aClassGradeFields)){
                            $sClass .= ' ' .  ($data->$sColumn >= 0 ? '' : 'text-red');
                        }
                        $aClassForColumns[$sColumn] = $sClass;
                        echo "<td class='$sClass'";
                        if (in_array($sColumn,$aFloatDisplayFields)){
                            echo " title='{$data->$sColumn}'";
                        }
                        echo ">$sDisplayValue</td>";
                    }
                    ?>
                    <td>
                        @include('w.item_link')
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ pagination($datas->appends(Input::except('page')), 'p.slider-3') }}
</div>

<?php
$modalData['modal'] = array(
    'id' => 'myModal',
    'title' => '系统提示',
    'message' => '确认删除此' . $resourceName . '？',
    'footer' =>
    Form::open(['id' => 'real-delete', 'method' => 'delete']) . '
            <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">取消</button>
            <button type="submit" class="btn btn-sm btn-danger">确认删除</button>' .
    Form::close(),
);
$modalData2['modal'] = [
    'id' => 'myModal2',
    'title' => __('_ruserbankcard.bad-record-title'),
    'action' => 'bad-record',
    'method' => 'post',
    'message' =>
    join('', [
        '<div class="form-group">',
        '<label for="blocked" class="col-sm-5 control-label">' . __('_bankcard.note') . '</label>',
        '</div>',
        '<div class="form-group">',
        '<textarea name="note" cols="30" rows="2"></textarea>',
        '</div>',
    ]),
    'footer' =>
    '<button type="button" class="btn btn-sm btn-default" data-dismiss="modal">' . __('_function.cancel') . '</button>' .
    '<button type="submit" class="btn btn-sm btn-danger">' . __('_function.confirm') . '</button>'
];
?>
@include('w.modal', $modalData)
@include('w.formModal', $modalData2)
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
    function putBadRecord(href)
    {
        $('#bad-record').attr('action', href);
        $('#myModal2').modal();
    }

</script>
@stop