@extends('l.admin', ['active' => $resource])
@section('title')
@parent
{{ $sPageTitle }}
@stop



@section('container')
<?php
        isset($sDataUpdatedTime) or $sDataUpdatedTime = date('Y-m-d H:i:s');
    ?>
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


    @if ($bSequencable)
            {{ Form::open(['action' => $sSetOrderRoute ]) }}
        @endif

    <?php
        $aClassForColumns = [];
    ?>
    <div>
    <div class=" time-top">
            <i class="glyphicon glyphicon-time"></i>
            {{ __('_basic.data-time') }} : {{ $sDataUpdatedTime }}
    </div>
    </div>
    <div class="panel panel-default J-tab-chart">
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
            @if (isset($aTotalColumns))
            <tfoot>
                <tr>
                    <td>{{ __('_basic.total-of-page') }}</td>
                    @for($i = 1; $i < count($aColumnForList); $i++)
                    <?php
                    $sColumn = $aColumnForList[$i];
//                    $sClass = $aClassForColumns[$sColumn];
                    $sClass = '';
                    if (in_array($sColumn,$aWeightFields)){
                        $sClass .= ' text-weight';
                    }
                    if (in_array($sColumn,$aClassGradeFields)){
                        $sClass .= ' ' .  ($aTotals[$i] >= 0 ? '' : 'text-red');
                    }
                    !is_numeric($aTotals[$i]) or $sClass .= ' text-right';
                    ?>
                    <td class="{{ $sClass }}">{{  is_null($aTotals[$i]) ? ' ' : number_format($aTotals[$i], (array_key_exists($aColumnForList[$i], $aNumberColumns) ? $aNumberColumns[$aColumnForList[$i]] : 2)) }}</td>
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
    <br/><br/>
    @if ($bSequencable)
        {{ Form::close() }}
    @endif


        <?php
        $modalData['modal'] = array(
            'id'      => 'myModal',
            'title'   => '系统提示',
            'message' => __('_basic.delete-confirm',$aLangVars) . '？',
            'footer'  =>
                Form::open(['id' => 'real-delete', 'method' => 'delete']).'
                    <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">取消</button>
                    <button type="submit" class="btn btn-sm btn-danger">确认删除</button>'.
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

