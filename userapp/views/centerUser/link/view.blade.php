@extends('l.home')

@section('title')
   链接开户
@parent
@stop

@section('scripts')
@parent
    {{ script('jquery.jscrollpane') }}
    {{ script('dsgame.DatePicker') }}
@stop

@section('main')
<div class="nav-bg nav-bg-tab">
    <div class="title-normal">代理中心</div> <a id="J-button-goback" class="button-goback" href="#">返回</a>
    <ul class="tab-title clearfix">
        <li><a href="{{ route('users.accurate-create') }}" ><span>精准开户</span></a></li>
        <li><a href="{{ route('user-links.create') }}"><span>链接开户</span></a></li>
        <li><a href="{{ route('users.index') }}"><span>用户管理</span></a></li>
        <li class="current"><a href="{{ route('user-links.index') }}"><span>链接管理</span></a></li>
    </ul>

</div>

<div class="content">
    
    <div class="bonusgroup-title" style="margin-top:0;">
        <table width="100%">
            <tbody><tr>
                <td class="text-left" width="45%">当前查看的注册链接<br><span class="tip"><a target="_blank" href="{{ (strpos($data->url, 'http') === false ? 'http://' : '') . $data->url }}">{{ $data->url }}</a></span></td>
                <td>开户类型<br><span class="tip">{{ $data->{$aListColumnMaps['is_agent']} }}</span></td>
                <td>链接状态<br><span class="tip">{{ $data->{$aListColumnMaps['status']} }}</span></td>
            </tr></tbody>
        </table>
    </div>
    @if( !$data->agent_prize_set_quota || $data->agent_prize_set_quota!='{}' )
    <div class="bonus-limit-list">
        <h3>开户配额情况</h3>
        <ul>
            @foreach(objectToArray(json_decode($data->agent_prize_set_quota)) as $iPrizeGroup=>$iCount)
            <li>
                <span>{{$iCount}}</span>
                <p>{{$iPrizeGroup}}</p>
            </li>
            @endforeach
        </ul>
    </div>
    @endif
    
    <div class="clearfix" style="margin-top:20px;">
    @foreach ($aSeriesLotteries as $aSeries)
        <div class="bonusgroup-list">
            <h3>{{ $aSeries['name'] }}奖金组详情</h3>
            <table width="100%" class="table table-toggle">
                <thead>
                    <tr>
                        <th>彩种类型/名称</th>
                        <th>奖金组</th>
                        @if ($data->is_agent)
                        <th>返点</th>
                        @endif
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
                        <td>{{ $aPrizeGroup ? $aPrizeGroup['prize_group'] : '' }}</td>
                        @if ($data->is_agent)
                        <td> -- {{-- $aPrizeGroup['water'] --}}</td>
                        @endif
                    </tr>
                    @endif
                    @endforeach
                @endif
                    <!-- <tr>
                        <td>重庆时时彩</td>
                        <td>1950</td>
                        <td>2.7%</td>
                    </tr>
                    <tr>
                        <td>重庆时时彩</td>
                        <td>1950</td>
                        <td>2.7%</td>
                    </tr> -->
                </tbody>
            </table>
        </div>
    @endforeach
    </div>
</div>
@stop

@section('end')
@parent
<script>
(function($){
  $('#J-button-goback ,.goback').click(function(e){
    history.back(-1);
    e.preventDefault();
  });
})(jQuery);
</script>
@stop

