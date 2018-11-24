@extends('l.base')

@section('title')
注单详情
@parent
@stop

@section('styles')
  @parent
  {{ style('ucenter') }}
@stop

@section ('container')
<div class="main-page show-page">
  <div data-fixed-top class="top-nav media">
    <div class="media-left media-middle">
      <a href="{{ route('mobile-users.index') }}" class="history-back"><span class="unicode-icon-prev"></span></a>
    </div>
    <h1 class="media-body">注单详情</h1>
    @if ($data->status == Project::STATUS_NORMAL)
    <div class="media-right media-middle">
      <span data-order-cancel="{{ route('mobile-projects.drop',['id' => $data->id]) }}" class="action-button">撤单</span>
    </div>
    @endif
  </div>

  <div id="section">

    <div class="game-order">

      <div class="media order-top">
        <div class="media-left game-icon-box">
          <img src="/assets/dist/images/game/logo/{{ $aLotteryIdentifierList[$data->lottery_id] }}.png" alt="">
        </div>
        <div class="media-body media-middle">
          <h3>{{ $aLotteries[$data->lottery_id] }} <small>第<span class="c-green">{{ $data->issue }}</span>期</small></h3>
          <p>
            <span>{{ $data->title }}</span>&nbsp;&nbsp;
            <span class="font-code"><dnf>￥</dnf><span data-money-format="">{{ $data->amount_formatted }}</span></span>
          </p>
        </div>
        <div class="media-right media-middle">
          <span class="c-highlight" data-status>{{ $data->formatted_status }}</span>
        </div>
      </div>

      <ul class="order-detail">
        <li>
          <label>订单编号</label>
          <span class="font-code">{{ $data->serial_number }}</span>
        </li>
        <li>
          <label>投注时间</label>
          <span class="font-code">{{ $data->bought_at }}</span>
        </li>
        <li>
          <label>投注倍数</label>
          <span class="font-code">{{ $data->multiple}}倍</span>
        </li>
        <li>
          <label>投注注数</label>
          <span class="font-code">{{ $data->amount/$data->coefficient/2}}注</span>
        </li>
        <li>
          <label>货币模式</label>
          <span class="font-code">{{ $aCoefficients[$data->coefficient] }}</span>
        </li>
        <li>
          <label>开奖号码</label>
          <span class="font-code c-highlight">{{ $data->winning_number ? $data->winning_number : '待开奖' }}</span>
        </li>
         @if( $data->prize_formatted )
        <li>
          <label>中奖金额</label>
          <span class="font-code c-highlight"><span class="c-important" data-money-format>{{ $data->prize_formatted }}</span>元</span>
        </li>
        @endif
        <li>
          <label>投注号码</label>
          <textarea class="lottery-detail-textarea form-control" disabled>{{ $data->display_bet_number }}</textarea>
        </li>
        @if ($data->trace_id)
        <?php
            $oTrace = UserTrace::find($data->trace_id);
        ?>
        <li>
          <label>是否追号</label>
          <span>
            <span class="ui-status-okay">是</span>
            <a href="{{ route('mobile-traces.view', $data->trace_id) }}" class="right btn btn-primary btn-xs">查看追号详情</a>
          </span>
        </li>
        <li>
          <label>追号设置</label>
          <span>@if($oTrace->stop_on_won)中奖即停@else中奖后继续追号@endif</span>
        </li>
        @endif
        <li>
          <a href="{{route('mobile-bets.betform', $data->lottery_id)}}" class="ds-btn">再玩一次</a>
        </li>
      </ul>

    </div>

  </div>
</div>
@stop

@section('scripts')
@parent
<script>
$(function(){
  var touchEvent = DSGLOBAL['touchEvent'];
  var second = DSGLOBAL['modaldelay'];
  $('[data-order-cancel]').on(touchEvent, function(){
    var $this = $(this);
    if( $this.hasClass('disabled') ) return false;
    var url = $(this).data('order-cancel');
    var message = '&nbsp;&nbsp;' + second + '秒后将自动关闭弹窗。';
    if( url ){
      BootstrapDialog.show({
        title: '温馨提示',
        message: '您确定要撤销注单吗？',
        buttons: [{
          label: '再想想',
          cssClass: 'btn-primary',
          action: function(dialogRef) {
            dialogRef.close();
          }
        }, {
          icon: 'glyphicon glyphicon-share',
          label: '撤销注单',
          autospin: true,
          action: function(dialogRef) {
            dialogRef.enableButtons(false);
            dialogRef.setClosable(false);
            $.ajax({
              url: url,
              dataType: 'json',
              method: 'GET',
              success: function(resp){
                if( resp['isSuccess'] ){
                  dialogRef.setTitle('撤销注单成功');
                  dialogRef.setType(BootstrapDialog.TYPE_SUCCESS);
                  dialogRef.getModalBody().html('撤销注单成功！' + message);
                  $('[data-status]').text('用户终止');
                  $this.hide().addClass('disabled');
                }else{
                  dialogRef.setTitle('撤销注单失败');
                  dialogRef.setType(BootstrapDialog.TYPE_WARNING);
                  dialogRef.getModalBody().html(resp['Msg'] + '!' + message);
                }
                setTimeout(function(){
                  dialogRef.close();
                }, second * 1000);
              },
              error: function(){
                dialogRef.setTitle('撤销注单失败');
                dialogRef.setType(BootstrapDialog.TYPE_WARNING);
                dialogRef.getModalBody().html('系统繁忙，请稍后再试！');
              }
            });
          }
        }]
      });
    }
  });
});
</script>
@stop
