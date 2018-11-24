@extends('l.admin', ['active' => $resource])
@section('title')
@parent
{{ $sPageTitle }}
@stop

@section('container')
<div class="col-md-12">
    @include('w._function_title')
    @include('w.breadcrumb')
    @include('w.notification')
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class=" panel-body">
                <table class="table table-bordered table-striped">
                    <tr>
                        <th  class="text-right col-xs-2">{{ __('_activityuserprize.username') }}</th>
                        <td>{{ $oUserPrize->username }}</td>
                    </tr>
                    <?php
                    $aData = json_decode($oUserPrize->data, true);
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
                    @if(key_exists('max_deposit', $aData))
                    <tr>
                        <th  class="text-right col-xs-2">{{ __('_activityuserprize.max_deposit') }}</th>
                        <td>{{ array_get($aData, 'max_deposit') }}元</td>
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
                    <tr>
                        <th  class="text-right col-xs-2">{{ __('_activityuserprize.created_at') }}</th>
                        <td>{{ $oUserPrize->created_at }}</td>
                    </tr>
                </table>
            </div>
        </div>

    </div>
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading"style="position: relative; height: 110px;">
                <form action="{{route('activity-user-prizes.reject', $oUserPrize->id)}}" method="get" >
                    <div class="form-group">
                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                        <input type="text" name='note' class="form-control" placeholder="请填写拒绝理由">
                    </div>
                    <button type="submit" class="btn btn-danger">拒绝</button>
                </form>
                <form action="{{route('activity-user-prizes.audit', $oUserPrize->id)}}" style="position: absolute;right: 15px;bottom: 15px;" method="post">
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                    <input class="btn btn-success" type="submit" value="通过" />
                </form>
            </div>
        </div>
    </div>
</div>
@stop

@section('end')
@parent
<script>
    $('[data-toggle="popover"]').popover()
    function modal(href)
    {
        $('#real-delete').attr('action', href);
        $('#myModal').modal();
    }
</script>
@stop
