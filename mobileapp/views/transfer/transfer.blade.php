@extends('l.base')

@section('title')
向下级转账
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
      <a href="{{route('mobile-users.index')}}" class="history-back"><span class="unicode-icon-prev"></span></a>
    </div>
    <h1 class="media-body">向下级转账</h1>
    <?php if( !Session::get('is_top_agent') ){ ?>
    <div class="media-right media-middle">
      <span data-toggle="modal" data-target="#transferInfoModal" class="unicode-icon-info"></span>
      <!-- <span class="glyphicon glyphicon-info-sign"></span> -->
    </div>
    <?php } ?>
  </div>

  <div id="section">

    <form action="{{route('mobile-transfer.transfer')}}" method="post">
      <input type="hidden" name="_token" value="{{ csrf_token() }}">

      <div class="ds-cells">
        <div class="ds-cell">
          <div class="ds-cell-bd">
            <span>可用余额</span>
          </div>
          <div class="ds-cell-ft ds-cell-ft-end">
            <span class="c-highlight" data-money-format>{{ $oAccount->available_formatted }}元</span>
          </div>
        </div>
        <div class="ds-cell">
          <div class="ds-cell-bd">
            <span>可提现余额</span>
          </div>
          <div class="ds-cell-ft ds-cell-ft-end">
            <span class="c-highlight" data-money-format>{{ $oAccount->withdrawable_formatted }}元</span>
          </div>
        </div>
      </div>
      
      <div class="ds-form-group">
        <label for="username">收款人</label>
        <input type="text" name="username" placeholder="请输入收款人用户名" required>
      </div>

      <div class="ds-form-group">
        <label for="money-amount">转账金额</label>
        <input id="money-amount" type="number" name="amount" placeholder="请输入转账金额" required>
        <span>元</span>
      </div>

      <div class="ds-form-group">
        <label>转账说明</label>
        <div class="dropdown">
          <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">
            <span data-choose-info-desc>选择转账说明</span>
            <span class="caret"></span>
          </button>
          <ul class="dropdown-menu" data-desc-content>
            @foreach($aDesc as $key => $desc)
            <li data-id="{{$key}}" data-desc="{{$desc}}"><a>{{$desc}}</a></li>
            @endforeach
          </ul>
        </div>
        <input type="hidden" name="desc" data-choose-info-id>
      </div>

      <div class="ds-form-group">
        <label for="fund-password">资金密码</label>
        <input id="fund-password" type="password" name="fund_password" placeholder="请输入资金密码" required>
      </div>

      <div class="ds-form-button">
        <button class="ds-btn" type="submit">立即转账</button>
      </div>
    </form>
  </div>
</div>

@if( !Session::get('is_top_agent') )
<!-- 温馨提示/转账提示 -->
<div class="modal fade" id="transferInfoModal" tabindex="-1" role="dialog" aria-labelledby="transferInfoModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="transferInfoModalLabel">转账提示</h4>
      </div>
      <div class="modal-body">
        <p>代理向下级转账的金额，该下级用户需要完成此部分转账金额相应流水，才可提款</p>
        <p>比如：您向下级A用户转账500元，则A用户在提款时需要完成这500元的相应流水才可提款。向下级转账均被视为充值行为。</p>
      </div>
    </div>
  </div>
</div>
@endif

@stop

@section('scripts')
@parent
<script>
$(function(){
  var touchEvent = DSGLOBAL['touchEvent'];
  // 转账说明
  $('[data-desc-content]').on(touchEvent, '[data-id]', function(){
    if( $(this).hasClass('active') ) return false;
    var desc = $(this).data('desc');
    var id = $(this).data('id');
    $('[data-choose-info-desc]').text(desc);
    $('[data-choose-info-id]').val(id);
    $(this).addClass('active').siblings().removeClass('active');
  });

  // 表单
  $('.ds-form-button button[type="submit"]').on(touchEvent, function(){
    var $this = $(this);
    var message = '';
    var $username = $('input[name="username"]');
    var $amount = $('input[name="amount"]');
    var $desc = $('input[name="desc"]');
    var $fundPassword = $('input[name="fund_password"]');
    var $focus = $(null);

    if( !$username.val() ){
      message = '请填写收款人';
      $focus = $username;
    }
    else if( !$amount.val() ){
      message = '请输入转账金额';
      $focus = $amount;
    }
    else if( $amount.val() < 0 ){
      message = '转账金额不能小于0';
      $focus = $amount;
    }
    else if( !$desc.val() ){
      message = '请选择转账说明';
    }
    else if( !$fundPassword.val() ){
      message = '资金密码不能为空';
      $focus = $fundPassword;
    }

    if( message ){
      BootstrapDialog.alert({
        title: '温馨提示',
        message: message,
        type: BootstrapDialog.TYPE_WARNING,
        closable: true,
        buttonLabel: '确定',
        callback: function(result) {
          setTimeout(function(){
            $focus.focus();
          }, 100);
        }
      });
      return false;
    }

    var html = [];
    html.push('<p>您确定要转账给<span class="c-highlight">' +$username.val()+ '</span>吗？');
    html.push('<p>转账金额：<span class="c-highlight">' +$amount.val()+ '</span>元');
    html.push('<p>转账说明：' + $('[data-choose-info-desc]').text());
    BootstrapDialog.show({
      title: '转账确认',
      message: html.join(''),
      buttons: [{
        icon: 'glyphicon glyphicon-share',
        label: '转账',
        cssClass: 'btn-primary',
        autospin: true,
        action: function(dialogRef) {
          dialogRef.enableButtons(false);
          dialogRef.setClosable(false);
          $this.parents('form:eq(0)').submit();
        }
      },{
        label: '取消',
        action: function(dialogRef) {
          dialogRef.close();
        }
      }]
    });
    return false;
  });
});
</script>
@stop
