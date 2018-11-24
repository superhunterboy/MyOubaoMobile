@extends('l.base')

@section('title')
充值
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
      <a href="{{ route('mobile-deposits.quick', $oPlatform->id) }}" class="history-back"><span class="unicode-icon-prev"></span></a>
    </div>
    <h1 class="media-body">充值确认</h1>
  </div>

  <div id="section">
    <div class="ds-form">
      <form action="{{ route('mobile-deposits.quick', $oPlatform->id) }}" method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
        @if ($oPlatform->need_bank)
        <input type="hidden" name="bank" value="{{ $oBank->id }}">
        @endif
        <input type="hidden" name="amount" value="{{ $fAmount }}">
        <input type="hidden" name="dodespoit" value="1">

        <div class="ds-form-group">
          <label>充值渠道</label>
          <input readonly type="text" value="{{ $oPlatform->display_name }}">
        </div>

        @if ($oPlatform->need_bank)
        <div class="ds-form-group">
          <label>充值银行卡</label>
          <input readonly type="text" value="{{$oBank->name}}">
        </div>
        {{--
        <!-- <div class="ds-cells">
          <div class="ds-cell">
            <div class="ds-cell-hd">
              <div class="ds-cell-icon bank-icon-box">
                <i class="bank-icon-{{ strtolower($oBank->identifier) }}"></i>
              </div>
            </div>
            <div class="ds-cell-bd">
              <span>{{$oBank->name}}</span>
            </div>
          </div>
        </div> -->
        --}}
        @endif

        <div class="ds-form-group">
          <label>充值金额</label>
          <input readonly type="text" value="{{ $sDisplayAmount }} 元">
        </div>

        <div class="ds-form-button">
          <button class="ds-btn" type="submit">确认充值</button>
        </div>
      </form>
    </div>
  </div>
</div>
@stop
