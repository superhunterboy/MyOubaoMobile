@extends('l.base')

@section('title')
确认银行卡信息
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
      <a onclick="history.back();" class="history-back"><span class="unicode-icon-prev"></span></a>
    </div>
    <h1 class="media-body">确认银行卡信息</h1>
  </div>

  <div id="section">

    <div class="ds-form">
      {{--
      <ol class="breadcrumb breadcrumb-top">
        @if($iBindedCardsNum>0)<li>验证卡</li>@endif
        <li>添加卡</li>
        <li class="active"><a href="javascript:void(0);">确认信息</a></li>
        <li>绑卡成功</li>
      </ol>
      --}}

      <form action="{{ $iCardId ? route('mobile-user-bank-cards.modify-card', [3, $iCardId]) : route('mobile-user-bank-cards.bind-card', 3) }}" method="post" autocomplete="off">
        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
        @if ($iCardId)
        <input type="hidden" name="method" value="PUT" />
        @endif
        <input type="hidden" name="bank_id" value="{{ isset($aFormData['bank_id']) ? $aFormData['bank_id'] : Input::get('bank_id') }}" />
        <input type="hidden" name="bank" value="{{ isset($aFormData['bank']) ? $aFormData['bank'] : Input::get('bank') }}" />
        <input type="hidden" name="province_id" value="{{ isset($aFormData['province_id']) ? $aFormData['province_id'] : Input::get('province_id') }}" />
        <input type="hidden" name="province" value="{{ isset($aFormData['province']) ? $aFormData['province'] : Input::get('province') }}" />
        <input type="hidden" name="city_id" value="{{ isset($aFormData['city_id']) ? $aFormData['city_id'] : Input::get('city_id') }}" />
        <input type="hidden" name="city" value="{{ isset($aFormData['city']) ? $aFormData['city'] : Input::get('city') }}" />
        <input type="hidden" name="branch" value="{{ isset($aFormData['branch']) ? $aFormData['branch'] : Input::get('branch') }}" />
        <input type="hidden" name="account_name" value="{{ isset($aFormData['account_name']) ? $aFormData['account_name'] : Input::get('account_name') }}" />
        <input type="hidden" name="account" value="{{ isset($aFormData['account']) ? $aFormData['account'] : Input::get('account') }}" />
        <input type="hidden" name="account_confirmation" value="{{ isset($aFormData['account_confirmation']) ? $aFormData['account_confirmation'] : Input::get('account_confirmation') }}" />
        
        <div class="ds-form-group">
          <label>开户银行</label>
          <input readonly type="text" value="{{ isset($aFormData['bank']) ? $aFormData['bank'] : Input::get('bank') }}">
        </div>

        <div class="ds-form-group">
          <label>开户行区域</label>
          <input readonly type="text" value="{{ isset($aFormData['province']) ? $aFormData['province'] : Input::get('province') }}&nbsp;&gt;&nbsp;{{ isset($aFormData['city']) ? $aFormData['city'] : Input::get('city') }}">
        </div>

        <div class="ds-form-group">
          <label>支行名称</label>
          <input readonly type="text" value="{{ isset($aFormData['branch']) ? $aFormData['branch'] : Input::get('branch') }}">
        </div>

        <div class="ds-form-group">
          <label>开户人姓名</label>
          <input readonly type="text" value="{{ isset($aFormData['account_name']) ? $aFormData['account_name'] : Input::get('account_name') }}">
        </div>

        <div class="ds-form-group">
          <label>银行卡号</label>
          <input readonly type="text" value="{{ isset($aFormData['account']) ? $aFormData['account'] : Input::get('account') }}">
        </div>

        <div class="ds-form-button">
          <button class="ds-btn" type="submit">确认提交</button>
        </div>
    </form>
    </div>

  </div>
</div>
@stop 

@section('scripts')
@parent
{{ script('districts') }}
<script>
$(function(){
  
  
});
</script>
@stop
