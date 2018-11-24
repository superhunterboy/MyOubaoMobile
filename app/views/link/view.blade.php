@extends('l.admin', array('active' => $resource))

@section('title')
@parent
{{ $sPageTitle }}
@stop

@section('scripts')
@parent

@stop

@section('container')
<div class="col-md-12">
    @include('w.breadcrumb')
    @include('w._function_title')
    @include('w.notification')

<div class="panel panel-default">
<div class=" panel-body">
    <div class="content">

        <div class="col-xs-6">
            <div class="callout callout-warning">
                  <h4>您当前查看的注册链接详情如下：</h4>
                  <p><i class="glyphicon glyphicon-link"></i> <a target="_blank" href="{{ (strpos($data->url, 'http') === false ? 'http://' : '') . $data->url }}">{{ $data->url }}</a></p>
            </div>
        </div>
        <div class="col-xs-3">
           <div class="callout callout-info">
                <h4>开户类型：</h4>
                <p>{{ $data->{$aListColumnMaps['is_agent']} }}</p>
            </div>
            </div>
        <div class="col-xs-3">
            <div class="callout callout-info">
                <h4>链接状态：</h4>
                 <p>{{ $data->{$aListColumnMaps['status']} }}</p>
            </div>
        </div>

        <div class="col-xs-12">
            <h4>开户配额：<samp>1950以下奖金组不限配额</samp></h4>
            <table class="table table-bordered">
            <tr>
            @foreach(objectToArray(json_decode($data->agent_prize_set_quota)) as $iPrizeGroup=>$iCount)
                <th class="warning">{{$iPrizeGroup}}</th>
                <td>{{$iCount}}个</td>
            @endforeach
            </tr>

            </table>
        </div>

        <div class="col-xs-12">
        @foreach ($aSeriesLotteries as $aSeries)

        <h2>
            {{ $aSeries['name'] }}奖金组详情：
        </h2>
        <hr/>
        <table width="100%" class="table table-toggle table-bordered">
            <thead>
                <tr>
                    <th>彩种类型/名称</th>
                    <th>奖金组</th>
                </tr>
            </thead>
            <tbody>
            @if (isset($aSeries['children']) && $aSeries['children'])
                @foreach ($aSeries['children'] as $aLottery)
                <?php
                    // pr($data->prize_group_sets_json);exit;
                    $aPres = ['lottery_id_', 'series_id_'];
                    $sPre  = $aPres[$data->is_agent];
                    $sPre .= $data->is_agent ? $aSeries['id'] : $aLottery['id'];
                ?>
                @if ($aPrizeGroup = (isset( $data->prize_group_sets_json[$sPre] ) ? $data->prize_group_sets_json[$sPre] : ''))
                <tr>
                    <td>{{ $aLottery['name'] }}</td>
                    <td>{{ $aPrizeGroup['prize_group'] }}</td>
                </tr>
                @endif
                @endforeach
            @endif
            </tbody>
        </table>
        @endforeach
        </div>
    </div>
    </div>
    </div>
</div>
@stop

@section('end')
@parent
@stop

