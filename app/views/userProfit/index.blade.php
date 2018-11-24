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
<?php
$aTotals = array_fill(0, count($aColumnForList),null);
$aTotalColumnMap = array_flip($aColumnForList);
?>
    <div class="panel panel-default">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    @foreach( $aColumnForList as $i => $sColumn )
                    <th>{{ (__($sLangPrev . $sColumn, null, 3)) }}
                        @if (!in_array($sColumn, $aNoOrderByColumns))
                        {{ order_by($sColumn) }}
                        @endif
                    </th>
                    <?php
                    in_array($sColumn, $aTotalColumns) or $aTotalColumnMap[$sColumn] = null;
                    ?>
                    @endforeach
                    <th>{{ __('_basic.actions') }}</th>
                </tr>
            </thead>
            <?php
//            pr($aTotalColumnMap);
//            exit ?>
            <tbody>
                <?php
                    $fTeamDeposit = $fTeamWithdrawal = $fDirectDeposit = $fDirectWithdrawal = $fTeamTurnover = $fDirectTurnover = $fDirectCommission = 0;
                    // $iDirectTurnover = 0;
                ?>
                @foreach ($datas as $data)
                <tr>
                    <?php
                    $fTeamDeposit += $data->team_deposit;
                    $fTeamWithdrawal += $data->team_withdrawal;
                    $fTeamTurnover += $data->team_turnover;
                    $fDirectDeposit += $data->direct_deposit;
                    $fDirectWithdrawal += $data->direct_withdrawal;
                    $fDirectTurnover += $data->direct_turnover;
                    $fDirectCommission += $data->direct_commission;
                    foreach ($aColumnForList as $sColumn) {
                        is_null($aTotalColumnMap[$sColumn]) or $aTotals[$aTotalColumnMap[$sColumn]] += $data->$sColumn;
                        if (isset($aListColumnMaps[ $sColumn ])) {
                            $sDisplayValue = $data->{$aListColumnMaps[ $sColumn ]};
                        } else {
                            if ($sColumn == 'sequence'){
                                $sDisplayValue = Form::text('sequence[' . $data->id . ']',$data->sequence,['class' => 'form-control','style' => 'width:70px;text-align:right']);
                            } else {
                                if (isset($aColumnSettings[ $sColumn ][ 'type' ])) {
                                    $sDisplayValue = $sColumn . $aColumnSettings[ $sColumn ][ 'type' ];
                                    switch ($aColumnSettings[ $sColumn ][ 'type' ]) {
                                        case 'bool':
                                            $sDisplayValue = $data->$sColumn ? __('Yes') : __('No');
                                            break;
                                        case 'select':
                                            //                                        $sDisplayValue = (isset($data->$sColumn) && !is_null($data->$sColumn)) ? ${$aColumnSettings[$sColumn]['options']}[$data->$sColumn] : null;
                                            $sDisplayValue = !is_null($data->$sColumn) ? ${$aColumnSettings[ $sColumn ][ 'options' ]}[ $data->$sColumn ] : null;
                                            break;
                                        default:
                                            $sDisplayValue = is_array($data->$sColumn) ? implode(',',$data->$sColumn) : $data->$sColumn;
                                    }
                                } else {
                                    $sDisplayValue = $data->$sColumn;
                                }
                            }
                        }
//                        if (array_key_exists($sColumn,$aNumberColumns)) {
//                            switch ($sColumn) {
//                                case 'team_turnover':
//                                    $iTeamTurnover += $data->$sColumn;
//                                    break;
//                                case 'direct_turnover':
//                                    $iDirectTurnover += $data->$sColumn;
//                                    break;
//                                case 'direct_commission':
//                                    $iDirectCommission += $data->$sColumn;
//                                    break;
//                            }
//                            // $sDisplayValue = number_format($sDisplayValue,$aNumberColumns[ $sColumn ]);
//                        }
                        echo "<td>$sDisplayValue</td>";
                    }
                    ?>
                    <td>
                        @foreach ($buttons['itemButtons'] as $element)
                            @if ($element->isAvailable($data))
                            <a  href="{{ $element->route_name ? route($element->route_name, [$element->para_name => $data->user_id]) : 'javascript:void(0);'
            }}" class="btn btn-xs   btn-default" > {{ __( $element->label) }}</a>
                            @endif
                        @endforeach
                    </td>
                </tr>
                @endforeach
                <tr>
                    <td>{{ __('Total Of Page') }}</td>
                    @for($i = 1; $i < count($aTotals); $i++)
                    <td>{{  is_null($aTotals[$i]) ? ' ' : number_format($aTotals[$i],4) }}</td>
                    @endfor
                    <td></td>
                </tr>
            </tbody>
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
 </div>
@stop

@section('javascripts')
@parent

@stop

@section('end')
    @parent
    <script>
    jQuery(document).ready(function($) {
        function modal(href)
        {
            $('#real-delete').attr('action', href);
            $('#myModal').modal();
        }
    });
    </script>
@stop

