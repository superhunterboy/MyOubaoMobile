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
    <h1 class="media-body">追号详情</h1>
    <div class="media-right media-middle">
      <span data-toggle="modal" data-target="#traceListModal" class="unicode-icon-info"></span>
      <!-- <span class="glyphicon glyphicon-info-sign"></span> -->
    </div>
  </div>

  <div id="section">

    <div class="game-order">
      
      <div class="media order-top">
        <div class="media-left game-icon-box">
          <img src="/assets/dist/images/game/logo/{{ $aLotteryIdentifierList[$data->lottery_id] }}.png" alt="">
        </div>
        <div class="media-body media-middle">
          <h3>{{ $aLotteries[$data->lottery_id] }}</h3>
          <p>
            <span>{{ $data->title }}</span>&nbsp;&nbsp;
            <span class="font-code"><dnf>￥</dnf><span data-money-format="">{{ $data->amount_formatted }}</span></span>
          </p>
        </div>
        <div class="media-right media-middle">
          <span class="c-highlight">{{ $data->formatted_status }}</span>
        </div>
      </div>

      <ul class="order-detail">
        <li>
          <label>订单编号</label>
          <span class="font-code">{{ $data->serial_number }}</span>
        </li>
        <li>
          <label>追号金额</label>
          <span data-money-format>{{ $data->finished_amount_formatted }}元</span>
          <span>/</span>
          <span data-money-format>{{ $data->amount_formatted }}元</span>
        </li>
        <li>
          <label>取消金额</label>
          <span data-money-format>{{ $data->canceled_amount_formatted }}元</span>
        </li>
        <!-- <li>
          <label>开始期号</label>
          <span>{{ $data->start_issue }}</span>
        </li> -->
        <li>
          <label>开始期号</label>
          <span>{{ $data->start_issue }}</span>
        </li>
        <li>
          <label>追号期数</label>
          <span>{{ $data->finished_issues }}期</span>
          <span>/</span>
          <span>{{ $data->total_issues }}期</span>
        </li>
        <li>
          <label>取消期数</label>
          <span>{{ $data->canceled_issues }}期</span>
        </li>
        <li>
          <label>货币模式</label>
          <span>{{ $aCoefficients[$data->coefficient] }}</span>
        </li>
        <li>
          <label>追号设置</label>
          <span>中奖后终止任务&nbsp;&nbsp;{{ $data->formatted_stop_on_won }}</span>
          @if ($data->status == Trace::STATUS_RUNNING)
          <span data-trace-stop="{{ route('mobile-traces.stop', $data->id) }}" class="right btn btn-primary btn-xs">终止追号</span>
          @endif
        </li>
        <li>
          <label>追号号码</label>
          <textarea class="lottery-detail-textarea form-control" disabled>{{ $data->display_bet_number }}</textarea>
        </li>
        <li>
          <a href="{{route('mobile-bets.betform', $data->lottery_id)}}" class="ds-btn">再玩一次</a>
        </li>
      </ul>

    </div>

  </div>
</div>

<!-- 追号清单 -->
<div class="modal fade" id="traceListModal" tabindex="-1" role="dialog" aria-labelledby="traceListModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="traceListModalLabel">追号清单</h4>
      </div>
      <div class="modal-body">
        <table class="table table-striped">
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
                <a data-trace-cancel="{{ route('mobile-traces.cancel', [$oTraceDetail->trace_id, $oTraceDetail->id]) }}" data-trace-issue="{{ $oTraceDetail->issue }}">取消本期追号</a>
                @endif
                @if ((int)$oTraceDetail->project_id)
                &nbsp;&nbsp;<a href="{{ route('mobile-projects.view', $oTraceDetail->project_id) }}">详情</a>
                @endif
              </td>
            </tr>
            @endforeach
          </tbody>
      </table>
      </div>
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
  $('[data-trace-cancel], [data-trace-stop]').on(touchEvent, function(){
    var $this = $(this);
    if( $this.hasClass('disabled') ) return false;
    if( $this.data('trace-stop') ){
      actionText = '终止追号';
      actionTitle = '终止追号';
      url = $this.data('trace-stop');
    }else{
      actionText = '撤销第' +$this.data('trace-issue')+ '期追号' ;
      actionTitle = '撤销注单';
      url = $this.data('trace-cancel');
    }
    var message = '&nbsp;&nbsp;' + second + '秒后将自动关闭弹窗。';
    if( url ){
      BootstrapDialog.show({
        title: '温馨提示',
        message: '您确定要' +actionText+ '吗？',
        buttons: [{
          label: '再想想',
          cssClass: 'btn-primary',
          action: function(dialogRef) {
            dialogRef.close();
          }
        }, {
          icon: 'glyphicon glyphicon-share',
          label: actionText,
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
                  dialogRef.setTitle( actionText + '成功');
                  dialogRef.setType(BootstrapDialog.TYPE_SUCCESS);
                  dialogRef.getModalBody().html( actionText + '成功！' + message);
                  // 更新状态
                  if( $this.data('trace-stop') ){
                    window.location.reload();
                    // $this.hide().addClass('disabled');
                    // $('[data-status]').text('用户终止');
                  }else{
                    $this.text('用户终止').addClass('disabled').parent().prev().text('用户取消');
                  }
                }else{
                  dialogRef.setTitle( actionText + '失败');
                  dialogRef.setType(BootstrapDialog.TYPE_WARNING);
                  dialogRef.getModalBody().html(resp['Msg'] + '!' + message);
                }
                setTimeout(function(){
                  dialogRef.close();
                }, second * 1000);
              },
              error: function(){
                dialogRef.setTitle( actionText + '失败');
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