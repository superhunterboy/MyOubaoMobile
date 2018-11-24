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


    <div class="panel panel-default">
        <table class="table table-striped table-hover">

            <thead class="thead-mini  thead-inverse">
                <tr>
                @foreach( $aColumnForList as $sColumn )
                    <th>{{ (__($sLangPrev . $sColumn, null, 3)) }}
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
            @if ($bSequencable)
                { Form::open(['action' => $sSetOrderRoute ]) }}
            @endif
            <tbody>
                @foreach ($datas as $data)
                <tr>
                    <?php
                    foreach ($aColumnForList as $sColumn){
                        if (isset($aTotalColumns)){
                            is_null($aTotalColumnMap[$sColumn]) or $aTotals[$aTotalColumnMap[$sColumn]] += $data->$sColumn;
                        }
                        if (isset($aListColumnMaps[ $sColumn ])){
                            $sDisplayValue = $data->{$aListColumnMaps[ $sColumn ]};
                        }
                        else{
                            if ($sColumn == 'sequence'){
                                $sDisplayValue = Form::text('sequence[' . $data->id . ']',$data->sequence,['class' => 'form-control','style' => 'width:70px;text-align:right']);
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
                                        default:
                                            $sDisplayValue = is_array($data->$sColumn) ? implode(',',$data->$sColumn) : $data->$sColumn;
                                    }
                                }
                                else{
                                    $sDisplayValue = $data->$sColumn;
                                }
                                if (array_key_exists($sColumn,$aNumberColumns)){
                                    $sDisplayValue = number_format($sDisplayValue,$aNumberColumns[ $sColumn ]);
                                }
                            }
                        }
                        echo "<td>$sDisplayValue</td>";
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
    </div>

    {{ pagination($datas->appends(Input::except('page')), 'p.slider-3') }}

    @if ($bSequencable)
    {{ Form::close() }}
    @endif

    <?php
        $modalData['modal'] = array(
            'id'      => 'myModal',
            'title'   => '系统提示',
            'message' => '确认删除此'.$resourceName.'？',
            'footer'  =>
                Form::open(['id' => 'real-delete', 'method' => 'delete']).'
                    <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">取消</button>
                    <button type="submit" class="btn btn-sm btn-danger">确认删除</button>'.
                Form::close(),
        );
        $modalData2['modal'] = [
            'id'      => 'myModal2',
            'title'   => __('_withdrawal.refuse-withdrawal-request'),
            'action'  => 'refuse-withdrawal',
            'method'  => 'put',
            'message' =>
                join('',
                [
                '<div class="form-group">',
                    '<label for="error_msg" class="col-sm-3 control-label">' . __('_withdrawal.refuse-message') . '</label>',
                    '<div class="col-sm-5">',
                            '<textarea name="error_msg" id="error_msg"></textarea>',
                    '</div>',
                '</div>'
                ]),
            'footer'  =>
                '<button type="button" class="btn btn-sm btn-default" data-dismiss="modal">' . __('_function.Cancel') . '</button>' .
                '<button type="submit" class="btn btn-sm btn-danger">' . __('_function.Confirm') . '</button>'
        ];
        $modalData3['modal'] = [
            'id'      => 'myModal3',
            'title'   => __('_withdrawal.waiting-for-comfirmation'),
            'action'  => 'waiting-withdrawal',
            'method'  => 'put',
            'message' =>
                join('',
                [
                '<div class="form-group">',
                    '<label for="remark" class="col-sm-3 control-label">' . __('_withdrawal.remark-message') . '</label>',
                    '<div class="col-sm-5">',
                            '<textarea name="remark" id="remark"></textarea>',
                    '</div>',
                '</div>'
                ]),
            'footer'  =>
                '<button type="button" class="btn btn-sm btn-default" data-dismiss="modal">' . __('_function.Cancel') . '</button>' .
                '<button type="submit" class="btn btn-sm btn-danger">' . __('_function.Confirm') . '</button>'
        ];
    ?>
    @include('w.modal', $modalData)
    @include('w.formModal', $modalData2)
    @include('w.formModal', $modalData3)

@stop


@section('end')
    @parent
    <script>
        function modal(href)
        {
            if (! href || href == 'javascript:void(0);') return false;
            $('#real-delete').attr('action', href);
            $('#myModal').modal();
        }
        function refuseWithdrawal(href)
        {
            if (! href || href == 'javascript:void(0);') return false;
            $('#refuse-withdrawal').attr('action', href);
            $('#myModal2').modal();
        }
        function waitingForConfirmation(href)
        {
            if (! href || href == 'javascript:void(0);') return false;
            $('#waiting-withdrawal').attr('action', href);
            $('#myModal3').modal();
        }
    </script>
@stop


