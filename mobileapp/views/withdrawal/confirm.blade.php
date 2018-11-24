@extends('l.base')

@section('title')
提现确认
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
    <h1 class="media-body">提现确认</h1>
    <div class="media-right media-middle">
      <span data-toggle="modal" data-target="#withdrawInfoModal" class="unicode-icon-info"></span>
      <!-- <span class="glyphicon glyphicon-info-sign"></span> -->
    </div>
  </div>

  <div id="section">

    <div class="ds-form">
      <form action="{{ route('mobile-withdrawals.withdraw', 2) }}" method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="step" value="2">
        <input type="hidden" name="id" value="{{ $oBankCard->id }}">
        <input type="hidden" name="amount" value="{{ $aInputData['amount'] }}">

        <div class="ds-form-group">
          <label>用户名</label>
          <input type="text" readonly value="{{ $oBankCard->username }}">
        </div>
        
        <div class="ds-form-group">
          <label>可用提现余额</label>
          <input type="text" readonly value="{{ $oAccount->withdrawable_formatted }} 元">
        </div>
        
        <div class="ds-form-group">
          <label>本次提现金额</label>
          <input type="text" readonly value="{{ $aInputData['amount'] }} 元">
        </div>
        
        <div class="ds-form-group">
          <label>开户银行</label>
          <input type="text" readonly value="{{ $oBankCard->bank }}">
        </div>
        
        <div class="ds-form-group">
          <label>开户地址</label>
          <input type="text" readonly value="{{ $oBankCard->province . '  ' . $oBankCard->city }}">
        </div>
        
        <div class="ds-form-group">
          <label>开户人</label>
          <input type="text" readonly value="{{ $oBankCard->formatted_account_name }}">
        </div>
        
        <div class="ds-form-group">
          <label>提现银行卡号</label>
          <input type="text" readonly value="{{ $oBankCard->account_hidden }}">
        </div>
        
        <div class="ds-form-info ds-form-info-top c-highlight">
          <span class="unicode-icon-info"></span>
          <!-- <span class="glyphicon glyphicon-info-sign"></span> -->
          <small>为了确保您的资金安全，请输入资金密码以便确认您的身份！</small>
        </div>
        <div class="ds-form-group">
          <label>资金密码</label>
          <input name="fund_password" id="funds-passowrd" type="password" placeholder="请输入资金密码" required>
        </div>

        <div class="ds-form-button">
          <button class="ds-btn" type="submit">确认提现</button>
        </div>
        
        {{--
        <!-- <div class="ds-form-title">
          <span>提现金额</span>
          <span class="c-highlight">160元</span>
        </div>
        <div class="ds-form-group">
          <div class="card-show">
            <h3>
              <div class="bank-icon-box">
                <i class="bank-icon-cmbc"></i>
              </div>
              <span>民生银行</span>
              <small>快捷卡</small>
            </h3>
            <p>8888 **** **** 8888</p>
          </div>
        </div>
        <div class="ds-form-info ds-form-info-top">
          <span class="unicode-icon-info"></span>
          <span>密码输错3次，账户将被锁定，当天不能操作</span>
        </div>
        <div class="ds-form-group">
          <label for="funds-passowrd">交易密码</label>
          <input id="funds-passowrd" type="password" placeholder="请输入交易密码" required>
        </div>
        <div class="ds-form-button">
          <button class="ds-btn ds-btn-disabled" type="button">确认提现</button>
        </div>

        <div class="form-status-tips">
          <span class="glyphicon glyphicon-ok-circle"></span>
          <p>提现申请已提交，24小时内到账</p>
        </div>
        <div class="ds-form-group">
          <table class="table">
            <tr>
              <td class="text-left">储蓄卡</td>
              <td class="text-right"><small>尾号8888</small>&nbsp;&nbsp;<span class="c-dark">招商银行</span></td>
            </tr>
            <tr>
              <td class="text-left">提现金额</td>
              <td class="text-right"><span class="c-highlight">160元</span></td>
            </tr>
          </table>
        </div>
        <div class="ds-form-button">
          <button class="ds-btn" type="button">完成</button>
        </div> -->
        --}}
      </form>
    </div>

  </div>
</div>
@stop 

@section('scripts')
@parent
<script>
</script>
@stop