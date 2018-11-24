@extends('l.home')

@section('title')
            追号记录 -- 详情
@parent
@stop

@section ('main')
<div class="nav-bg">
    <div class="title-normal">
        追号记录
    </div>
    <!-- <a class="button-goback" href="{{ route('traces.index') }}">返回</a> -->
</div>

<div class="content">
    <div class="row row-head">
        <a href="{{ route('traces.index') }}" class="row-desc c-important">返回追号记录列表></a>
        <span><strong>追号详情</strong>（{{ $data->serial_number }}）</span>
    </div>

    <div class="item-detail">
        <div class="item-left">
            <div class="item-title"><i class="item-icon-1"></i>游戏信息</div>
            <div class="lottery-info">
                <img src="/assets/images/game/logo/{{ $aLotteryIdentifierList[$data->lottery_id] }}.png" alt="{{ $aLotteries[$data->lottery_id] }}" title="{{ $aLotteries[$data->lottery_id] }}">
                <h2>{{ $aLotteries[$data->lottery_id] }}</h2>
                <p class="c-gray">{{ $data->title }}</p>
                <!-- <p class="lottery-info-number">第[]期</p> -->
            </div>
        </div>
        <div class="item-right">
            <div class="item-title"><i class="item-icon-7"></i>追号清单</div>
            <div class="item-info">
                <table class="table small-table">
                    <thead>
                        <tr>
                            <th>奖期</th>
                            <th>倍数</th>
                            <th>状态</th>
                            <th>注单详情</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($aTraceDetailList as $oTraceDetail)
                        <tr>
                            <td>{{ $oTraceDetail->issue }}</td>
                            <td>{{ $oTraceDetail->multiple }}倍</td>
                            <td>{{ $oTraceDetail->formatted_status }}</td>
                            <td>
                                @if ($oTraceDetail->status == TraceDetail::STATUS_WAITING)
                                <a href="{{ route('traces.cancel', [$oTraceDetail->trace_id, $oTraceDetail->id]) }}">取消本期追号</a>
                                @endif
                                @if ((int)$oTraceDetail->project_id)
                                &nbsp;&nbsp;
                                <a href="{{ route('projects.view', $oTraceDetail->project_id) }}">详情&gt;</a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ pagination($aTraceDetailList->appends(Input::except('page')), 'w.pages') }}
            </div>
        </div>
        <div class="item-center">
            <div class="item-title"><i class="item-icon-2"></i>追号信息</div>
            <div class="item-info">
                <p><label>追号金额</label><dfn>￥</dfn><span data-money-format>{{ $data->amount_formatted }}</span></p>
                <p><label>完成金额</label><dfn>￥</dfn><span data-money-format>{{ $data->finished_amount_formatted }}</span></p>
                <p><label>取消金额</label><dfn>￥</dfn><span data-money-format>{{ $data->canceled_amount_formatted }}</span></p>
                <p><label>货币模式</label>{{ $aCoefficients[$data->coefficient] }}</p>
                <p><label>开始期号</label>{{ $data->start_issue }}</p>
                <p><label>追号期数</label>{{ $data->total_issues }}期</p>
                <p><label>完成期数</label>{{ $data->finished_issues }}期</p>
                <p><label>取消期数</label>{{ $data->canceled_issues }}期</p>
                <p><label>追号状态</label>{{ $data->formatted_status }}</p>
            </div>
            <div class="item-title"><i class="item-icon-4"></i>追号设置</div>
            <div class="item-info">
                <p>
                    <label>中奖后终止任务</label>
                    {{ $data->formatted_stop_on_won }}
                    @if ($data->status == Trace::STATUS_RUNNING)
                    &nbsp;&nbsp;<a class="btn btn-small" href="{{ route('traces.stop', $data->id) }}">终止追号</a>
                    @endif
                </p>
            </div>
            <div class="item-title"><i class="item-icon-3"></i>追号号码</div>
            <div class="item-info">
                <textarea disabled="disabled" class="textarea-lotterys-detail input">{{ $data->display_bet_number }}</textarea>
            </div>
        </div>
    </div>
    
</div>
@stop

@section('end')
@parent
<script>
(function($){
  // $('#J-button-goback').click(function(e){
  //   history.back(-1);
  //   e.preventDefault();
  // });
})(jQuery);
</script>

@stop