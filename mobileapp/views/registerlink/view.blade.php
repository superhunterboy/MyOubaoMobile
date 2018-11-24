@extends('l.base')

@section('title')
链接详情
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
    <h1 class="media-body">链接详情</h1>
    <div class="media-right media-middle">
      <span class="unicode-icon-info" data-page-tab=".prize-detail-page"></span>
      <!-- <span class="glyphicon glyphicon-info-sign"></span> -->
    </div>
  </div>
  <div id="section">

    <div class="ds-form-info">
      <?php
      if(!file_exists(public_path().'/qrcode/'.$data->id)){
        QRcode::png($data->url,public_path().'/qrcode/'.$data->id.'.png','L',10,2);
      }
      ?>
      <img src="/qrcode/{{$data->id}}.png" alt="" class="ds-share-img">
    </div>
    <!-- <div class="ds-form-info ds-form-info-bottom">
      <span class="unicode-icon-info"></span>
      <span><small>长按将图片保存到手机相册</small></span>
    </div> -->

    <div class="ds-form-info">
      <div class="ds-share-url">
        <textarea id="share-url" readonly>{{ $data->url }}</textarea>
      </div>
      <!-- <button class="ds-btn ds-btn-sm"
        data-clipboard-dom
        data-clipboard-target="#share-url"
        data-toggle="popover"
        data-placement="top"
        data-content
      >复制</button> -->
    </div>

    <div class="ds-form">
      <div class="ds-form-group">
        <label>开户类型</label>
        <span>{{ $data->{$aListColumnMaps['is_agent']} }}</span>
        <label>链接状态</label>
        <span>{{ $data->{$aListColumnMaps['status']} }}</span>
      </div>
    </div>

  </div>
</div>

<div class="prize-detail-page hide-page">
  <div data-fixed-top class="top-nav media">
    <div class="media-left media-middle">
      <div class="action-back" data-page-tab=".main-page"><span class="unicode-icon-prev"></span></div>
    </div>
    <h2 class="media-body">返点详情</h2>
  </div>
  <div class="prize-detail-content">
    <div class="ds-tabs">
      <ul class="nav nav-tabs nav-tabs{{ count($aSeriesLotteries) }}" role="tablist">
        <?php
        $sPre = $data->is_agent ? 'series_id_' : 'lottery_id_';
        $sLotteryIdx = $data->is_agent ? 'series_id' : 'id';
        $aPrizeGroupSet = $data->prize_group_sets_json;
        $iArrLen = count($aSeriesLotteries);
        for ($index=0; $index<$iArrLen; $index++){
        ?>
        <li role="presentation" {{ $index == 1 ? 'class="active"' : '' }}><a href="#prize-{{  $aSeriesLotteries[$index]['name'] }}"role="tab" data-toggle="tab">{{  __('_series.'.$aSeriesLotteries[$index]['identifier']) }}</a></li>
        <?php
        }
        ?>
      </ul>
      <div class="tab-content">
        <?php
        for ($index=0; $index<$iArrLen; $index++){
        ?>
        <div role="tabpanel" class="tab-pane {{ $index == 1 ? 'active' : '' }}" id="prize-{{ $aSeriesLotteries[$index]['name'] }}">
          <table class="table table-striped">
            <thead>
              <tr>
                  <th>彩种类型/名称</th>
                  <th>奖金组</th>
                  <th>返点</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($aSeriesLotteries[$index]['children'] as $aLottery)
              <tr>
                <td>{{ $aLottery['name'] }}</td>
                <td>{{$aPrizeGroupSet[$sPre. $aLottery[$sLotteryIdx]]['prize_group'] }}</td>
                <td> {{$aPrizeGroupSet[$sPre. $aLottery[$sLotteryIdx]]['water'] }}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        <?php
        }
        ?>
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
