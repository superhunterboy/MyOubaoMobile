@extends('l.home')

@section('title')
    注单详情
@parent
@stop

@section ('styles')

@section ('main')

    <div class="nav-bg">
        <div class="title-normal">
            游戏记录
        </div>
        <a id="J-button-goback" class="button-goback" href="javascript:history.back(-1);">返回</a>
    </div>

    <div class="content">
        <div class="row row-head">
            <a href="{{route('projects.index')}}" class="row-desc c-important">返回游戏记录列表></a>
            <span><strong>注单详情</strong>（{{ $data->serial_number }}）</span>
        </div>
            
        <div class="item-detail">
            <div class="item-left">
                <div class="item-title"><i class="item-icon-1"></i>游戏信息</div>
                <div class="lottery-info">
                    <img src="/assets/images/game/logo/{{ $aLotteryIdentifierList[$data->lottery_id] }}.png" alt="{{ $aLotteries[$data->lottery_id] }}" title="{{ $aLotteries[$data->lottery_id] }}">
                    <p class="c-gray">{{ $data->title }}</p>
                    <p class="lottery-info-number">第{{ $data->issue }}期</p>
                </div>
            </div>
            <div class="item-right">
                <div class="item-title"><i class="item-icon-5"></i>开奖信息</div>
                <div class="item-info">
                    <div class="item-info-balls">
                    @if( $data->splitted_winning_number )
                        @foreach ($data->splitted_winning_number as $number)
                        <span class="ball">{{ $number }}</span>
                        @endforeach
                    @else
                        <span class="ball">-</span>
                        <span class="ball">-</span>
                        <span class="ball">-</span>
                        <span class="ball">-</span>
                        <span class="ball">-</span>
                    @endif
                    </div>

                    @if( $data->prize_formatted )
                    <div class="lottery-result">恭喜您，中奖了！</div>
                    @endif
                </div>
            @if( $data->prize_formatted )
                <div class="item-title"><i class="item-icon-6"></i>奖金<span class="item-tips">哇塞~ 鸿运当头啊，秒秒钟变土豪</span></div>
                <div class="item-info">
                    <p class="item-money-count text-center"><span class="c-important" data-money-format>{{ $data->prize_formatted }}</span>元</p>
                    <p class="text-center"><a href="{{route('bets.betform', $data->lottery_id)}}" class="btn btn-important btn-wide">手气旺，继续买</a></p>
                </div>
            @endif
            </div>
            <div class="item-center">
                <div class="item-title"><i class="item-icon-2"></i>投注信息</div>
                <div class="item-info">
                    <p class="hidden-when-printed"><label>奖金组</label>{{ $data->prize_group}}</p>
                    <p class="hidden-when-printed"><label>奖金标准</label>{{ $data->prize_set_formatted}}</p>
                    <p><label>投注金额</label><dfn>￥</dfn><span data-money-format>{{ $data->amount_formatted }}</span></p>
                    <p><label>倍数</label>{{ $data->multiple}}倍</p>
                    <p><label>注数</label>{{ $data->amount/$data->coefficient/2}}注</p>
                    <p><label>货币模式</label>{{ $aCoefficients[$data->coefficient] }}</p>
                    <p><label>投注时间</label><span class="c-gray">{{ $data->created_at }}</span></p>
                    <p><label>状态</label><span class="c-gray">{{ $data->formatted_status }}</span>
                    @if ($data->status == Project::STATUS_NORMAL)&nbsp;&nbsp;<a class="btn btn-small" id="cancelProject" href="javascript:void(0);">撤单</a>@endif</p>
                </div>
                <div class="item-title"><i class="item-icon-3"></i>投注号码</div>
                <div class="item-info">
                    <textarea disabled="disabled" class="textarea-lotterys-detail input">{{ $data->display_bet_number }}</textarea>
                </div>
                <div class="item-title"><i class="item-icon-4"></i>追号管理</div>
                <div class="item-info">
                @if ($data->trace_id)
                <?php 
                    $oTrace = UserTrace::find($data->trace_id);
                ?>
                    <p><label>是否追号</label><span class="ui-status-okay">是</span></p>
                    <p><label>追号设置</label>@if($oTrace->stop_on_won)中奖即停@else中奖后继续追号@endif</p>
                    <p><label>&nbsp;</label><a href="{{ route('traces.view', $data->trace_id) }}" class="btn btn-small">查看追号详情</a></p>
                @else
                    <p><label>是否追号</label><span class="ui-status-no">否</span></p>
                @endif
                </div>
            </div>
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
  
  $('#cancelProject').click(function(event) {
        var popWindowNew = dsgame.Message.getInstance();
        var data = {
            title          : '确认',
            content        : "<i class=\"ico-waring\"></i><p class=\"pop-text\">你确定要撤单么？</p>",
            isShowMask     : true,
            cancelIsShow   : true,
            confirmIsShow  : true,
            cancelButtonText: '取消',
            confirmButtonText: '确认',
            confirmFun     : function() {
                location.href = "{{ route('projects.drop',['id' => $data->id]) }}";
            },
            cancelFun      : function() {
                this.hide();
            }
        };
        popWindowNew.show(data);
    });
  
})(jQuery);
</script>
@stop