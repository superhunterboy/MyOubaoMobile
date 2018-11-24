@extends('l.base')

@section('title')
快捷充值
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
        <h1 class="media-body">快捷充值</h1>
    </div>
<?php $oBankcard = PaymentBankCard::getBankcardForDeposit(1);?>
    <div id="section">
        <div class="ds-form">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <div class="ds-form-group">
                    <label>收款方</label>
                    <input readonly type="text" value="{{ $oBankcard->bank }}">
                </div>
                <div class="ds-form-group">
                    <label>收款账号</label>
                    <input readonly type="text" value="{{ $oBankcard->account_no }}">
                </div>
                <div class="ds-form-group">
                    <label>收款人</label>
                    <input readonly type="text" value="{{ $oBankcard->owner }}">
                </div>
                <div class="ds-form-group">
                    <label>充值金额</label>
                    <input readonly type="text" value="{{ $oDeposit->amount }} 元">
                </div>
                <div class="ds-form-group">
                    <label>附言(充值订单号)</label>
                    <input readonly type="text" id="share-url" value="{{ $oDeposit->postscript }}">
                </div>

                <div class="ds-form-button">
                    <button class="ds-btn ds-btn-sm"
                            data-clipboard-dom
                            data-clipboard-target="#share-url"
                            data-toggle="popover"
                            data-placement="top"
                            data-content
                            >复制附言</button> 
                </div>
        </div>
    </div>
</div>
@stop
<script src="/assets/third/clipboard.js/clipboard.min.js"></script>
@section('scripts')
@parent
<script>
$(function(){
  var touchEvent = DSGLOBAL['touchEvent'];
  var clipboards = new Clipboard('[data-clipboard-dom]');

  clipboards.on('success', function(e) {
    e.clearSelection();
    var $t = $(e.trigger);
    $t.data('content', '复制成功!').popover('show');
    setTimeout(function(){
      $t.popover('hide');
    }, 2000);
  });

  clipboards.on('error', function(e) {
    var $t = $(e.trigger);
    $t.data('content', '已选中请长按复制!').popover('show');
    setTimeout(function(){
      $t.popover('hide');
    }, 2000);
  });
});
</script>

@stop