@extends('l.base')

@section('title')
锁定银行卡
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
      <a href="{{route('mobile-user-bank-cards.index')}}" class="history-back"><span class="unicode-icon-prev"></span></a>
    </div>
    <h1 class="media-body">锁定银行卡</h1>
    <div class="media-right media-middle">
      <span data-toggle="modal" data-target="#cardLockInfoModal" class="unicode-icon-info"></span>
      <!-- <span class="glyphicon glyphicon-info-sign"></span> -->
    </div>
  </div>

  <div id="section">
    <div class="ds-form">
      <form action="{{ route('mobile-user-bank-cards.card-lock') }}" method="post" autocomplete="off">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <div class="ds-form-title">
          <span>已绑定银行卡</span>
        </div>
        <div class="ds-cells">
          @foreach($aBindedCards as $key => $oCard)
          <div class="ds-cell">
            <div class="ds-cell-bd">{{ $oCard->bank }}</div>
            <div class="ds-cell-ft ds-cell-ft-end">{{ $oCard->account_hidden }}</div>
          </div>
          @endforeach
        </div>
        <div class="ds-form-group">
          <label for="fund-password">资金密码</label>
          <input name="fund_password" id="fund-password" type="password" placeholder="请输入资金密码" required>
        </div>

        <div class="ds-form-button">
          <button class="ds-btn" type="submit">锁定银行卡</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- 温馨提示/锁卡说明 -->
<div class="modal fade" id="cardLockInfoModal" tabindex="-1" role="dialog" aria-labelledby="cardLockInfoModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="cardLockInfoModalLabel">锁卡说明</h4>
      </div>
      <div class="modal-body">
        <p>为了账户的资金安全，建议锁定银行卡信息。</p>
        <p>锁定后不能增加新卡绑定，已绑定的银行信息不能进行修改和删除。</p>
      </div>
    </div>
  </div>
</div>
@stop 

@section('scripts')
@parent
{{ script('districts') }}
@stop