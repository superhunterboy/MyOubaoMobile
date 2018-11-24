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

    <div class="panel panel-default">
        <div class=" panel-body">
            <table class="table table-bordered table-striped">
                <tbody>
                    <?php
                    $i = 0;
                    foreach ($aColumnSettings as $sColumn => $aSetting) {
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
                        <?php
                        if ($sColumn == 'data' && !is_null($data->data)) {
                            $aData = json_decode($data->data, true);
                            ?>
                            @if(key_exists('first_deposit_amount', $aData))
                            <tr>
                                <th  class="text-right col-xs-2">{{ __('_activityuserprize.first_deposit_amount') }}</th>
                                <td>{{ array_get($aData, 'first_deposit_amount') }}元</td>
                            </tr>
                            @endif
                            @if(key_exists('turnover', $aData))
                            <tr>
                                <th  class="text-right col-xs-2">{{ __('_activityuserprize.turnover') }}</th>
                                <td>{{ array_get($aData, 'turnover') }}元</td>
                            </tr>
                            @endif
                            @if(key_exists('turnover_from_time', $aData))
                            <tr>
                                <th  class="text-right col-xs-2">{{ __('_activityuserprize.turnover_from_time') }}</th>
                                <td>{{ array_get($aData, 'turnover_from_time') }}</td>
                            </tr>
                            @endif
                            @if(key_exists('turnover_to_time', $aData))
                            <tr>
                                <th  class="text-right col-xs-2">{{ __('_activityuserprize.turnover_to_time') }}</th>
                                <td>{{ array_get($aData, 'turnover_to_time') }}</td>
                            </tr>
                            @endif
                            @if(key_exists('times', $aData))
                            <tr>
                                <th  class="text-right col-xs-2">{{ __('_activityuserprize.times') }}</th>
                                <td>{{ array_get($aData, 'times') }}倍</td>
                            </tr>
                            @endif
                            @if(key_exists('rebate_percent', $aData))
                            <tr>
                                <th  class="text-right col-xs-2">{{ __('_activityuserprize.rebate_percent') }}</th>
                                <td>{{ (array_get($aData, 'rebate_percent') * 100).'%' }}</td>
                            </tr>
                            @endif
                            @if(key_exists('user_deposit', $aData))
                            <tr>
                                <th  class="text-right col-xs-2">{{ __('_activityuserprize.user_deposit') }}</th>
                                <td>{{ array_get($aData, 'user_deposit') }}元</td>
                            </tr>
                            @endif
                            @if(key_exists('rebate_amount', $aData))
                            <tr>
                                <th  class="text-right col-xs-2">{{ __('_activityuserprize.rebate_amount') }}</th>
                                <td>{{ array_get($aData, 'rebate_amount') }}元</td>
                            </tr>
                            @endif
                            @if(key_exists('deposit_username', $aData))
                            <tr>
                                <th  class="text-right col-xs-2">{{ __('_activityuserprize.deposit_username') }}</th>
                                <td>{{ array_get($aData, 'deposit_username') }}</td>
                            </tr>
                            @endif
                            @if(key_exists('turnover_username', $aData))
                            <tr>
                                <th  class="text-right col-xs-2">{{ __('_activityuserprize.turnover_username') }}</th>
                                <td>{{ array_get($aData, 'turnover_username') }}</td>
                            </tr>
                            @endif
                            @if(key_exists('usernames', $aData))
                            <tr>
                                <th  class="text-right col-xs-2">{{ __('_activityuserprize.usernames') }}</th>
                                <td>{{ array_get($aData, 'usernames') }}</td>
                            </tr>
                            @endif
                            @if(key_exists('team_profit', $aData))
                            <tr>
                                <th  class="text-right col-xs-2">{{ __('_activityuserprize.team_profit') }}</th>
                                <td>{{ array_get($aData, 'team_profit') }}</td>
                            </tr>
                            @endif
                            @if(key_exists('team_turnover', $aData))
                            <tr>
                                <th  class="text-right col-xs-2">{{ __('_activityuserprize.team_turnover') }}</th>
                                <td>{{ array_get($aData, 'team_turnover') }}</td>
                            </tr>
                            @endif
                            <?php
                            continue;
                        }
                        ?>
                        <tr>
                            <th  class="text-right col-xs-2">{{ __($sLangPrev . $sColumn, null, 2) }}</th>
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
