@extends('l.admin', ['active' => $resource])
@section('title')
@parent
{{ $sPageTitle }}
@stop

@section('container')
<div class="col-md-12">
    @include('w.breadcrumb')
    @include('w._function_title', ['id' => $data->id , 'parent_id' => $data->parent_id])

    @include('w.notification')
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading">注单基本信息:</div>
                <div class=" panel-body">
                    <table class="table table-bordered table-striped">
                        <tbody>
                            <?php
                            $i = 0;
                            $aBasicInfo = ['serial_number', 'trace_id', 'username', 'is_tester', 'prize_group', 'lottery_id', 'issue', 'title', 'display_bet_number', 'coefficient', 'single_count', 'multiple', 'way_total_count', 'bet_rate', 'single_amount', 'amount', 'bought_at'];
                            foreach ($aBasicInfo as $sColumn) {
                                $aSetting = $aColumnSettings[$sColumn];
//                            foreach ($aColumnSettings as $sColumn => $aSetting) {
//                                if (!in_array($sColumn, $aBasicInfo)) {
//                                    continue;
//                                }
                                $sClass = '';
                                if (in_array($sColumn, $aWeightFields)) {
                                    $sClass .= ' text-weight';
                                }
                                if (in_array($sColumn, $aClassGradeFields)) {
                                    $sClass .= ' ' . ($data->$sColumn >= 0 ? 'text-red' : 'text-green');
                                }
                                if (isset($aViewColumnMaps[$sColumn])) {
                                    $sDisplayValue = $data->{$aViewColumnMaps[$sColumn]};
                                } else {
                                    if (isset($aSetting['type'])) {
                                        switch ($aSetting['type']) {
                                            case 'ignore':
                                                continue 2;
                                                break;
                                            case 'bool':
                                                $sDisplayValue = $data->$sColumn ? __('Yes') : __('No');
                                                break;
                                            case 'text':
                                                $sDisplayValue = nl2br($data->$sColumn);
                                                break;
                                            case 'select':
                                                $sDisplayValue = !is_null($data->$sColumn) ? ${$aSetting['options']}[$data->$sColumn] : null;
                                                break;
                                            case 'numeric':
                                            case 'date':
                                            default:
                                                $sDisplayValue = $data->$sColumn;
                                        }
                                    } else {
                                        $sDisplayValue = $data->$sColumn;
                                    }
                                }
                                if (array_key_exists($sColumn, $aNumberColumns) && !array_key_exists($sColumn, $aViewColumnMaps)) {
                                    $sDisplayValue = number_format($sDisplayValue, $aNumberColumns[$sColumn]);
                                }
                                ?>
                                <tr>

                                    <th  class="text-right col-xs-2">{{ __($sLangPrev . $sColumn, null, 2) }}</th>
                                    @if($sColumn=='display_bet_number' && !is_null($data->display_bet_number))
                                    <td><pre style="width: 400px;">{{ $sDisplayValue }}</pre></td>
                                    @else
                                    <td >{{ $sDisplayValue }}</td>
                                    @endif
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="panel panel-primary">
                <div class="panel-heading">中奖信息:</div>
                <div class=" panel-body">
                    <table class="table table-bordered table-striped">
                        <tbody>
                            <?php
                            $i = 0;
                            $aPrizeInfo = ['winning_number', 'prize_set', 'amount', 'prize', 'status', 'status_prize', 'status_commission', 'won_count', 'single_won_count', 'won_data'];
                            foreach ($aPrizeInfo as $sColumn) {
                                $aSetting = $aColumnSettings[$sColumn];
//                            foreach ($aColumnSettings as $sColumn => $aSetting) {
//                                if (!in_array($sColumn, $aPrizeInfo)) {
//                                    continue;
//                                }
                                if($sColumn=='prize_set'){
                                }
                                $sClass = '';
                                if (in_array($sColumn, $aWeightFields)) {
                                    $sClass .= ' text-weight';
                                }
                                if (in_array($sColumn, $aClassGradeFields)) {
                                    $sClass .= ' ' . ($data->$sColumn >= 0 ? 'text-red' : 'text-green');
                                }
                                if (isset($aViewColumnMaps[$sColumn])) {
                                    $sDisplayValue = $data->{$aViewColumnMaps[$sColumn]};
                                } else {
                                    if (isset($aSetting['type'])) {
                                        switch ($aSetting['type']) {
                                            case 'ignore':
                                                continue 2;
                                                break;
                                            case 'bool':
                                                $sDisplayValue = $data->$sColumn ? __('Yes') : __('No');
                                                break;
                                            case 'text':
                                                $sDisplayValue = nl2br($data->$sColumn);
                                                break;
                                            case 'select':
                                                $sDisplayValue = !is_null($data->$sColumn) ? ${$aSetting['options']}[$data->$sColumn] : null;
                                                break;
                                            case 'numeric':
                                            case 'date':
                                            default:
                                                $sDisplayValue = $data->$sColumn;
                                        }
                                    } else {
                                        $sDisplayValue = $data->$sColumn;
                                    }
                                }
                                if (array_key_exists($sColumn, $aNumberColumns) && !array_key_exists($sColumn, $aViewColumnMaps)) {
                                    $sDisplayValue = number_format($sDisplayValue, $aNumberColumns[$sColumn]);
                                }
                                ?>
                                <tr>
                                    <th  class="text-right col-xs-4">{{ __($sLangPrev . $sColumn, null, 2) }}</th>
                                    <td class="{{ $sClass }}">{{ $sDisplayValue }}</td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="panel panel-primary">
                <div class="panel-heading">其它信息:</div>
                <div class=" panel-body">
                    <table class="table table-bordered table-striped">
                        <tbody>
                            <?php
                            $i = 0;
                            $aOtherInfo = ['ip', 'proxy_ip', 'end_time', 'canceled_by', 'canceled_at', 'prize_sent_at', 'commission_sent_at', 'bet_commit_time', 'created_at'];
                            foreach ($aOtherInfo as $sColumn) {
//                                $aSetting = $aColumnSettings[$sColumn];
//                            foreach ($aColumnSettings as $sColumn => $aSetting) {
//                                if (!in_array($sColumn, $aOtherInfo)) {
//                                    continue;
//                                }
                                $sClass = '';
                                if (in_array($sColumn, $aWeightFields)) {
                                    $sClass .= ' text-weight';
                                }
                                if (in_array($sColumn, $aClassGradeFields)) {
                                    $sClass .= ' ' . ($data->$sColumn >= 0 ? 'text-red' : 'text-green');
                                }
                                if (isset($aViewColumnMaps[$sColumn])) {
                                    $sDisplayValue = $data->{$aViewColumnMaps[$sColumn]};
                                } else {
                                    if (isset($aSetting['type'])) {
                                        switch ($aSetting['type']) {
                                            case 'ignore':
                                                continue 2;
                                                break;
                                            case 'bool':
                                                $sDisplayValue = $data->$sColumn ? __('Yes') : __('No');
                                                break;
                                            case 'text':
                                                $sDisplayValue = nl2br($data->$sColumn);
                                                break;
                                            case 'select':
                                                $sDisplayValue = !is_null($data->$sColumn) ? ${$aSetting['options']}[$data->$sColumn] : null;
                                                break;
                                            case 'numeric':
                                            case 'date':
                                            default:
                                                $sDisplayValue = $data->$sColumn;
                                        }
                                    } else {
                                        $sDisplayValue = $data->$sColumn;
                                    }
                                }
                                if (array_key_exists($sColumn, $aNumberColumns) && !array_key_exists($sColumn, $aViewColumnMaps)) {
                                    $sDisplayValue = number_format($sDisplayValue, $aNumberColumns[$sColumn]);
                                }
                                ?>
                                <tr>
                                    <th  class="text-right col-xs-5">{{ __($sLangPrev . $sColumn, null, 2) }}</th>
                                    <td class="{{ $sClass }}">{{ $sDisplayValue }}</td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
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
