@extends('l.base')

@section('title')
链接开户
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
      <a href="{{route('mobile-links.index')}}?is_agent=1" class="history-back"><span class="unicode-icon-prev"></span></a>
    </div>
    <h1 class="media-body">链接开户</h1>
  </div>
  <div id="section">
    <div class="ds-form">
      <form action="{{ route('mobile-links.create') }}" method="post" id="J-form">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="ds-form-group">
          <label>账户类型</label>
          <div class="dropdown">
            <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">
              <span data-choose-text>选择账户类型</span>
              <input data-choose-value
                type="hidden" name="is_agent"
                value="{{ Input::old('is_agent', 0) }}">
              <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" data-dsform-dropdown>
              @if( !Session::get('is_top_agent') )
              <li data-init data-value="0" data-text="玩家账号">
                <a>玩家账号</a>
              </li>
              @endif
              @if( Session::get('is_agent') )
              <li data-init data-value="1" data-text="代理账号">
                <a>代理账号</a>
              </li>
              @endif
            </ul>
          </div>
        </div>

        <div class="ds-form-group">
          <label for="valid-days">链接有效期</label>
          <div class="dropdown">
            <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">
              <span data-choose-text>选择链接有效期</span>
              <input data-choose-value
                name="valid_days" id="valid-days"
                type="hidden" required
                value="{{ Input::old('valid_days') }}">
              <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" data-dsform-dropdown>
            <?php
            $days = array(
              array(0, '永久有效'), array(1, '1天'), array(7, '7天'),
              array(30, '30天'), array(90, '90天')
            );
            $iLen = count( $days );
            for( $i=0; $i < $iLen; $i++ ){
              $day = $days[$i];
            ?>
              <li {{ $i==0 ? 'data-init' : '' }} data-value="{{ $day[0] }}" data-text="{{ $day[1] }}">
                <a>{{$day[1]}}</a>
              </li>
            <?php } ?>
            </ul>
          </div>
        </div>

        <div class="ds-form-group">
          <label for="channel">推广渠道</label>
          <input name="channel" id="channel" type="text" required
          placeholder="请填写推广渠道">
          <span class="unicode-icon-info"
            data-toggle="popover"
            data-placement="left"
            data-content="比如微信、QQ群、论坛等"
          ></span>
        </div>

        <?php $qqs = Input::old('agent_qqs'); ?>
        <div class="ds-form-group">
          <label for="agent-qq">推广QQ</label>
          <input name="agent_qqs[]" id="agent-qq" type="text"
            value="{{ isset($qqs[0]) ? $qqs[0] : '' }}" required
            placeholder="请填写推广QQ">
          <span class="unicode-icon-info"
            data-toggle="popover"
            data-placement="left"
            data-content="方便客户与您联系，建议您填写真实的推广QQ并开通临时会话功能。此QQ会显示在该链接开户页面上"
          ></span>
        </div>

        <div class="ds-form-group">
          <label>奖金组套餐</label>
          <div class="dropdown">
            <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">
              <span data-choose-text>选择奖金组</span>
              <input data-choose-id
                name="prize_group_id"
                type="hidden" required>
              <input data-choose-value
                name="prize_group"
                type="hidden" required>
              <input name="prize_group_type" type="hidden"
                value="{{ Input::old('prize_group_type', 1) }}">
              <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" data-dsform-dropdown>
            <?php
            $iArrLen = count( $oPossiblePrizeGroups );
            for ( $index = 0; $index < $iArrLen; $index++ ){
              $oPrizeGroup = $oPossiblePrizeGroups[$index];
              $prizeGroup = $oPrizeGroup->classic_prize;
              $prizeRate = number_format( ($currentUserPrizeGroup-$prizeGroup) / 2000*100, 2 ) . '%';
              if( $index > 0 ){
                echo '<li role="separator" class="divider"></li>';
              }
            ?>
              <li data-id="{{ $oPrizeGroup->id }}"
                data-value="{{ $prizeGroup }}"
                {{ $index == 0 ? 'data-init' : '' }}
                data-text="{{$prizeGroup}} ~ {{$prizeRate}}">
                <a>
                  <small>当前奖金组</small>
                  <big class="c-highlight">{{ $prizeGroup }}</big><br>
                  <small>预计返点率</small>
                  <big class="c-highlight">{{ $prizeRate }}</big>
                </a>
              </li>
            <?php
            }
            ?>
            </ul>
          </div>
        </div>

        <div class="ds-form-button">
          <button class="ds-btn" type="submit">生成链接</button>
        </div>

      </form>
    </div>
  </div>
</div>
@stop

@section('scripts')
@parent
<script>
$(function(){
  var touchEvent = DSGLOBAL['touchEvent'];
  $('[data-toggle="popover"]').popover();

  // 表单
  $('.ds-form-button button[type="submit"]').on(touchEvent, function(){
    var message = '';
    var $channel = $('input[name="channel"]');
    var $qqs = $('input[name="agent_qqs[]"]');
    var qq = $.trim( $qqs.val() );
    var $focus = $(null);

    if( !$.trim($channel.val()) ){
      message = '请填写推广渠道';
      $focus = $channel;
    }
    else if( !qq ){
      message = '请填写推广QQ';
      $focus = $qqs;
    }else if( isNaN(+qq) || qq < 50000 ){
      message = '请填写真实有效的QQ';
      $focus = $qqs;
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
  });
});
</script>
@stop
