@extends('l.base')

@section('title')
银行卡管理
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
        <h1 class="media-body">银行卡管理</h1>
        <div class="media-right media-middle">
            <span data-toggle="modal" data-target="#cardInfoModal" class="unicode-icon-info"></span>
            <!-- <span class="glyphicon glyphicon-info-sign"></span> -->
        </div>
    </div>

    <div id="section">
        <div class="ds-cells">
            @foreach ($datas as $data)
            <div class="ds-cell">
                <div class="ds-cell-hd">
                    <div class="ds-cell-icon bank-icon-box">
                        <i class="bank-icon-{{strtolower($aBanks[$data->bank_id])}}"></i>
                    </div>
                </div>
                <div class="ds-cell-bd">
                    <span>{{ $data->bank }}<br><small>{{ $data->account_hidden }}</small></span>
                </div>
                <div class="ds-cell-ft">{{ $data->{$aListColumnMaps['status']} }}</div>
            </div>
            @endforeach
        </div>

        @if ($bLocked==0)
        @if(isset($iBindedCardsNum) && (int)$iBindedCardsNum < $iLimitCardsNum)
        <div class="ds-cells ds-cells-info ds-button-group-2">
          <!-- <button class="ds-btn btn-primary" type="button" data-page-tab=".card-bind-page"><span class="glyphicon glyphicon-plus"></span>添加银行卡</button>
          <button class="ds-btn" type="button" data-page-tab=".card-lock-page"><span class="glyphicon glyphicon-lock"></span>锁定银行卡</button> -->
            <a class="ds-btn btn-primary" href="{{route('mobile-user-bank-cards.bind-card', 0) }}"><span class="glyphicon glyphicon-plus"></span>添加银行卡</a>
            <a class="ds-btn" href="{{route('mobile-user-bank-cards.card-lock') }}"><span class="glyphicon glyphicon-lock"></span>锁定银行卡</a>
        </div>
        @endif
        @endif

        <div class="ds-cells ds-cells-info">
            <p>为了您的账户资金安全，银行卡“新增”和“修改”将在操作完成2小时0分后，新卡才能发起“向平台提现”。</p>
        </div>

    </div>
</div>

{{--
<!-- 绑卡操作页 -->
<div class="card-bind-page hide-page">
  <div data-fixed-top class="top-nav media">
    <div class="media-left media-middle">
      <div data-page-tab=".main-page" class="action-back"><span class="unicode-icon-prev"></span></div>
    </div>
    <h2 class="media-body">添加银行卡</h2>
  </div>
  <div class="page-iframe">
    <script type="html/text" data-page-load-content>
      <iframe src="{{route('mobile-user-bank-cards.bind-card', 0) }}" width="100%" height="100%" frameborder="0" allowtransparency="true" scrolling="no"></iframe>
</script>
</div>
</div>

<!-- 绑卡操作页 -->
<div class="card-lock-page hide-page">
    <div data-fixed-top class="top-nav media">
        <div class="media-left media-middle">
            <div data-page-tab=".main-page" class="action-back"><span class="unicode-icon-prev"></span></div>
        </div>
        <h2 class="media-body">锁定银行卡</h2>
    </div>
    <div class="page-iframe">
        <script type="html/text" data-page-load-content>
            <iframe src="{{route('mobile-user-bank-cards.card-lock') }}" width="100%" height="100%" frameborder="0" allowtransparency="true" scrolling="no"></iframe>
        </script>
    </div>
</div>
--}}

<!-- 温馨提示/绑卡说明 -->
<div class="modal fade" id="cardInfoModal" tabindex="-1" role="dialog" aria-labelledby="cardInfoModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="cardInfoModalLabel">温馨提示</h4>
            </div>
            <div class="modal-body">
                <p>一个游戏账户最多绑定 {{ $iLimitCardsNum }}  张银行卡， 您目前绑定了{{ $iBindedCardsNum }}张卡，还可以绑定{{ $iLimitCardsNum - $iBindedCardsNum }}张。</p>
                <p>银行卡信息锁定后，不能增加新卡绑定，已绑定的银行卡信息不能进行修改和删除。</p>
                <p>为了您的账户资金安全，银行卡“新增”和“修改”将在操作完成2小时0分后，新卡才能发起“向平台提现”。</p>
            </div>
        </div>
    </div>
</div>
@stop 

@section('scripts')
@parent
{{--
<script>
$(function(){
  $('.page-iframe').height( $(window).height() - $('.card-bind-page [data-fixed-top]').height() );
});
</script>
--}}
@stop