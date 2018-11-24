@extends('l.base')

@section('meta')
@parent
{{--<!-- <meta http-equiv="Expires" CONTENT="0">
<meta http-equiv="Cache-Control" CONTENT="no-cache">
<meta http-equiv="Pragma" CONTENT="no-cache"> -->--}}
@stop

@section('styles')
  @parent
  {{ style('game') }}
@stop

@section ('container')
  <div class="main-page show-page">

    <div data-fixed-top class="top-nav media">
      <div class="media-left media-middle">
        <a href="/" class="history-back"><span class="unicode-icon-prev"></span></a>
      </div>
      <h2 class="media-body">
          <span id="topGameMethodName"></span>
          <div class="game-method-drop-toggle" data-toggle="modal" data-target="#methodModal">
              <span class="glyphicon glyphicon-menu-down"></span>
          </div>
      </h2>
      <div class="media-right media-middle">
        <span data-method-instruction class="unicode-icon-info"></span>
        {{-- <!-- <span class="glyphicon glyphicon-info-sign"></span> --> --}}
      </div>
    </div>

    <div id="section">
      <!-- 游戏状态 -->
      <div class="game-status-panel">
        <div class="topGameSelect">
                <select id="gotoNewGame">
                    @foreach($aLotteryData as $oLottery)
                    <option value="{{ route('mobile-bets.betform', $oLottery['id']) }}" @if($oLottery['id'] == $iLotteryId) selected @endif>{{$oLottery['name']}}</option>
                    @endforeach
                </select>
            </div>

        {{-- <!-- <div class="money-unit right" data-money-unit>
          <label><input type="radio" name="money-unit" value="1">元</label>
          <label><input type="radio" name="money-unit" value="0.1">角</label>
          <label><input type="radio" name="money-unit" value="0.01">分</label>
        </div> --> --}}
        <div class="game-current-issue">
          <span>第</span><span data-current-issue></span><span>期</span></div>
        <div class="game-countdown">
          <span class="glyphicon glyphicon-time c-light"></span>
          <span class="c-highlight" data-countdown>00:00:00</span>
        </div>
      </div>
            <!-- 开奖记录 -->
      <div class="game-trend-pannel">
          <div class="collapse" id="collapseExample">
              <div class="bet-table-well"  id="J-minitrend-cont">
              </div>
          </div>
          <a class="bet-table-trend-btn collapsed"  data-toggle="collapse" href="#collapseExample" aria-expanded="true"
             aria-controls="collapseExample">
              <span class="glyphicon glyphicon-chevron-down" aria-hidden="true"></span>
              <span class="glyphicon glyphicon-chevron-up" aria-hidden="false"></span>
          </a>
      </div>
      
      
      <!-- 选号区 -->
      <div class="ball-select-panel" id="J-balls-main-panel">
        {{-- <!-- <div class="ball-section">
          <div class="ball-section-top">
            <div class="ball-control">
              <span class="action-large current">大</span>
              <span class="action-small">小</span>
              <span class="action-odd">单</span>
              <span class="action-even">双</span>
              <span class="action-clear">清</span>
            </div>
            <h2 class="decimal-name">万</h2>
          </div>
          <div class="ball-section-content">
            <label data-value="0" class="ball-number"></label>
            <label data-value="1" class="ball-number"></label>
            <label data-value="2" class="ball-number ball-number-current"></label>
            <label data-value="3" class="ball-number"></label>
            <label data-value="4" class="ball-number"></label>
            <label data-value="5" class="ball-number"></label>
            <label data-value="6" class="ball-number"></label>
            <label data-value="7" class="ball-number"></label>
            <label data-value="8" class="ball-number"></label>
            <label data-value="9" class="ball-number"></label>
          </div>
        </div> --> --}}

      </div>

    </div>

    <!-- 统计区 -->
    <div class="bounsInfo">
        <div class="unit">
                <span class="unit-box" data-money-unit></span>
            <span>模式</span>
        </div>
        <div class="multiple">
            <span>
                <span class="select-counter-action counter-decrease" data-counter-action="decrease">－</span>
                <input data-multiple-value type="number" value="1">
                <span class="select-counter-action counter-increase" data-counter-action="increase">+</span>
            </span>
            <span>倍</span>
        </div>
        <div class="bonus-choose">
            <div class="slider-range J-prize-group-slider" onselectstart="return false;" data-slider-step="1">
                <div class="slider-range-scale">
                    <span class="small-number" data-slider-min=""></span>
                    <span class="percent-number" data-slider-percent="">0.00%</span>
                    <span class="big-number" data-slider-max=""></span>
                </div>
                <div class="right">
                    <span class="slider-current-value" data-slider-value="">1999</span>
                </div>
                <div class="slider-action">
                    <div class="slider-range-sub" data-slider-sub="">-</div>
                    <div class="slider-range-add" data-slider-add="">+</div>
                    <div class="slider-range-wrapper" data-slider-cont="">
                        <div class="slider-range-inner" data-slider-inner=""></div>
                        <div class="slider-range-btn" data-slider-handle=""></div>
                    </div>
                </div>
            </div>
            <input id="J-bonus-select-value" type="hidden" value="1956">
        </div>
    </div>

    <div data-fixed-bottom class="statistics-panel media">
      <div class="bet-statistics media-body media-middle">
          <span data-choose-num class="c-highlight">0</span><span>注,</span>
          <span id="J-balls-statistics-multipleNum">0</span><span>倍,</span>
          <span>返</span>
          <span id="J-balls-statistics-rebate">0</span>
          <span>元,</span>
          <span>共</span><span data-choose-money class="c-highlight">0.000</span><span>元</span>
      </div>
      <div class="bet-buttons media-right media-middle">
        <button data-button-fast-submit class="btn btn-fast-submit disabled">投注</button>
        <button data-button-choose class="btn btn-choose disabled">选定</button>
      </div>
    </div>

  </div>

  <!-- 购彩篮 -->
  <div class="cart-panel hide-page">
    <div data-fixed-top class="top-nav media">
      <div class="media-left media-middle">
        <div class="left action-back"><span class="unicode-icon-prev"></span></div>
      </div>
      <h2 class="media-body">购彩篮</h2>
    </div>
    <div class="cart-content">
       <div class="game-status-panel">
          <div class="game-current-issue">
            <span>第</span><span data-current-issue></span><span>期</span></div>
          <div class="game-countdown">
            <span class="glyphicon glyphicon-time c-light"></span>
            <span class="c-highlight" data-countdown>00:00:00</span>
          </div>
       </div>

      <div class="cart-top">
        <button class="btn" data-action="randomone">机选一注</button>
        <button class="btn" data-action="randomfive">机选五注</button>
        <button class="btn" data-action="back">继续选号</button>
      </div>
      <div class="cart-inner">
        <div class="cart-wrap">
          <ul class="order-detail" data-order-detail>
            {{-- <!-- <li data-id="3">
              <span class="number">6|7|8|8|8</span>
              <span class="name">五星直选复式</span>
              <span class="amount">1注x2元=2元</span>
              <span class="delete unicode-icon-delete"></span>
            </li>
            <li data-id="4">
              <span class="number">66666|77777|88888|88888|88888|66666|77777|88888|88888|88888</span>
              <span class="name">五星直选复式</span>
              <span class="amount">100000注x2元=200,000.000元</span>
              <span class="delete unicode-icon-delete"></span>
            </li> --> --}}
          </ul>
          <div class="order-clear" data-order-clear>
            <span class="glyphicon glyphicon-trash"></span>
            <span>清空投注内容</span>
          </div>
          <div class="order-empty" data-order-empty>
            <span class="glyphicon glyphicon-shopping-cart"></span>
            <span>老板！您的购彩篮空空如也！</span>
          </div>
        </div>
      </div>
      {{-- <!-- <div class="cart-bottom">
        <label>投<input data-multiple-value type="number" value="1">倍</label>
        <label>追<input data-trace-value type="number" value="1">期</label>
        <label><input data-trace-win-stop type="checkbox">中奖停追</label>
      </div> --> --}}
    </div>
    <div data-fixed-bottom class="statistics-panel">
              <div class="bet-buttons media-left">
        <button id="J-advance-trace" class="btn btn-choose">追号</button>
      </div>
      <div class="bet-statistics media-body media-middle">
        <span data-order-num class="c-highlight">0</span><span>注</span>
        <span>共</span><span data-order-money class="c-highlight">0.000</span><span>元</span>
      </div>
      <div class="bet-buttons media-right media-middle">
        <button data-button-submit class="btn btn-submit disabled">投注</button>
      </div>
    </div>
  </div>

  <!-- 高级追号 -->
  <div class="trace-panel hide-page">
      <div data-fixed-top class="top-nav media">
        <div class="media-left media-middle">
          <div class="left action-back"><span class="unicode-icon-prev"></span></div>
        </div>
        <h2 class="media-body">追号</h2>
      </div>
      <div class="trace-inner">
         <div id="J-trace-panel" class="panel-trace">
             		<div class="pop-bd">
             			<div class="chase-tab">
             				<div class="chase-tab-title clearfix">
             					<ul class="clearfix">
             						<li class="chase-tab-t current">同倍追号</li>
             						<li class="chase-tab-t" style="border-left:0;">利润率追号</li>
             						<li class="chase-tab-t " style="border-left:0;">翻倍追号</li>
             					</ul>

             				</div>

             				<div class="chase-tab-content  chase-tab-content-current">

             					<div class="trace-title-param">
             						<label class="param">
             							起始倍数:
             							<input id="J-trace-tongbei-multiple" class="input w-1" type="text" value="1">
             						</label>
             						<label class="param">
             							追号期数:
             							<input id="J-trace-tongbei-times" class="input w-1" type="text" value="10">
             						</label>
             						<input type="button" class="btn trace-button-detail" value="生成追号计划">
             					</div>


             					<div class="chase-table-container">
             					<table class="chase-table" id="J-trace-table">
             						<tbody id="J-trace-table-tongbei-body" data-type="tongbei">
             						</tbody>
             					</table>
             					</div>
             				</div>
                                    
                                    
             				<div class="chase-tab-content">
             					<div class="trace-title-param">
             						<label class="param">
             							最低收益率:
             							<input id="J-trace-lirunlv-num" class="input w-1" type="text" value="50"> %
             						</label>
             						<label class="param">
             							追号期数:
             							<input id="J-trace-lirunlv-times" class="input w-1" type="text" value="10">
             						</label>
             						&nbsp;&nbsp;<input type="button" class="btn trace-button-detail" value="生成追号计划">
             					</div>

             					<div class="chase-table-container">
             						<table id="J-trace-table-lirunlv" class="chase-table">
             								<tbody data-type="lirunlv" id="J-trace-table-lirunlv-body">
             								</tbody>
             						</table>
             					</div>
             				</div>

             				<div class="chase-tab-content">
             					<div class="trace-title-param">
             						<label class="param">
             							起始倍数:
             							<input id="J-trace-fanbei-multiple" class="input w-1" type="text" value="1">
             						</label>
             						<label class="param">
             							隔
             							<input id="J-trace-fanbei-jump" class="input w-1" type="text" value="2">
             						</label>
             						<label class="param">
             							期 倍x
             							<input id="J-trace-fanbei-num" class="input w-1" type="text" value="2">
             						</label>
             						<label class="param">
             							追号期数:
             							<input id="J-trace-fanbei-times" class="input w-1" type="text" value="10">
             						</label>
             						<input type="button" class="btn trace-button-detail" value="生成追号计划">
             					</div>

             					<div class="chase-table-container">
             					<table class="chase-table" id="J-trace-table">
             						<tbody id="J-trace-table-fanbei-body" data-type="fanbei">
             						</tbody>
             					</table>
             					</div>
             				</div>

             				<div class="chase-tab-content">
             						<div class="chase-select-high">
             							<div class="title">基本参数</div>
             							<ul class="base-parameter">
             								<li>
             									起始期号：

             									<select id="J-traceStartNumber" style="display: none;"></select>

             								</li>
             								<li>
             									追号期数：
             									<input id="J-trace-advanced-times" type="text" class="input" value="10">&nbsp;&nbsp;期（最多可以追<span id="J-trace-number-max">14</span>期）
             								</li>
             								<li>
             									起始倍数：
             									<input id="J-trace-advance-multiple" type="text" class="input" value="1">&nbsp;&nbsp;倍
             								</li>
             							</ul>

             							<div class="title">高级参数</div>
             							<div id="J-trace-advanced-type-panel" class="high-parameter">
             								<ul class="tab-title">
             									<li class="current">翻倍追号</li>
             									<li>盈利金额追号</li>
             									<li>盈利率追号</li>
             								</ul>
             								<ul class="tab-content">
             									<li class="panel-current">
             										<p data-type="a">
             											<input class="trace-advanced-type-switch" type="radio" name="trace-advanced-type1" checked="checked">
             											每隔&nbsp;<input id="J-trace-advanced-fanbei-a-jiange" type="text" class="input" value="2">&nbsp;期
             											倍数x<input id="J-trace-advanced-fanbei-a-multiple" type="text" class="input trace-input-multiple" value="2">
             										</p>
             										<p data-type="b">
             											<input class="trace-advanced-type-switch" type="radio" name="trace-advanced-type1">
             											前&nbsp;<input id="J-trace-advanced-fanbei-b-num" type="text" class="input" value="5" disabled="disabled">&nbsp;期
             											倍数=起始倍数，之后倍数=<input id="J-trace-advanced-fanbei-b-multiple" type="text" class="input trace-input-multiple" value="2" disabled="disabled">
             										</p>
             									</li>
             									<li>
             										<p data-type="a">
             											<input class="trace-advanced-type-switch" type="radio" name="trace-advanced-type2" checked="checked">
             											预期盈利金额≥&nbsp;<input id="J-trace-advanced-yingli-a-money" type="text" class="input" value="100">&nbsp;元
             										</p>
             										<p data-type="b">
             											<input class="trace-advanced-type-switch" type="radio" name="trace-advanced-type2">
             											前&nbsp;<input id="J-trace-advanced-yingli-b-num" type="text" class="input" value="2" disabled="disabled">&nbsp;期
             											预期盈利金额≥&nbsp;<input id="J-trace-advanced-yingli-b-money1" type="text" class="input" value="100" disabled="disabled">&nbsp;元，之后≥&nbsp;<input id="J-trace-advanced-yingli-b-money2" type="text" class="input" value="50" disabled="disabled">&nbsp;元
             										</p>
             									</li>
             									<li>
             										<p data-type="a">
             											<input class="trace-advanced-type-switch" type="radio" name="trace-advanced-type3" checked="checked">
             											预期盈利率≥&nbsp;<input id="J-trace-advanced-yinglilv-a" type="text" class="input" value="10">&nbsp;%
             										</p>
             										<p data-type="b">
             											<input class="trace-advanced-type-switch" type="radio" name="trace-advanced-type3">
             											前&nbsp;<input id="J-trace-advanced-yinglilv-b-num" type="text" class="input" value="5" disabled="disabled">&nbsp;期
             											预期盈利率≥&nbsp;<input id="J-trace-advanced-yingli-b-yinglilv1" type="text" class="input" value="30" disabled="disabled">&nbsp;%，之后≥&nbsp;<input id="J-trace-advanced-yingli-b-yinglilv2" disabled="disabled" type="text" class="input" value="10">&nbsp;%
             										</p>
             									</li>
             								</ul>
             							</div>
             						</div>
             						<div class="chase-table-container">

             						<table id="J-trace-table-advanced" class="chase-table">
             								<tbody id="J-trace-table-advanced-body">
             									<tr>
             										<th style="width:125px;" class="text-center">序号</th>
             										<th><label class="label"><input type="checkbox" class="checkbox">追号期次</label>
             										</th><th>倍数</th>
             										<th>金额</th>
             										<!--<th>预计开奖时间</th>-->
             									</tr>
             								</tbody>
             						</table>
             						</div>
             					</div>
             					<div class="trace-info-panel clearfix">
             						<ul class="bet-statistics">
             							<li>共追号 <span id="J-trace-statistics-times">0</span> 期，<em><span id="J-trace-statistics-lotterys-num">0</span> </em>注，</li>
             							<li>金额 <strong class="price"><dfn>¥</dfn><span id="J-trace-statistics-amount">0.00</span></strong> 元</li>
             						</ul>
             					</div>
             			</div>
             		</div>
             	</div>
      </div>
      <div data-fixed-bottom class="statistics-panel media">
          <div class="bet-buttons media-right media-middle">
            <button data-button-submit class="btn btn-submit disabled">确认追号投注</button>
            <div class="chase-stop" id="J-trace-iswintimesstop-panel">
                    <label class="label"><input type="checkbox" class="checkbox" id="J-trace-iswintimesstop" checked="checked"> 中奖后停止追号</label><input type="text" value="1" disabled="disabled" class="input" id="J-trace-iswintimesstop-times" style="display:none;">&nbsp;
            </div>
          </div>
      </div>
  </div>
  <!-- 游戏玩法 -->
  <div class="modal fade game-method-modal" id="methodModal" tabindex="-1" role="dialog" aria-labelledby="methodModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="methodModalLabel">游戏玩法</h4>
        </div>
        <div class="modal-body">
          <div class="game-method-list" id="J-gametyes-menu-panel"></div>
        </div>
      </div>
    </div>
  </div>
@stop

@section('scripts')
@parent
  @section('game-config')
  <script>var gameConfigData = {{ $sLotteryConfig }};</script>
  @show
  {{ script('betgame.Games.all') }}
  @section('game-self-config')
  @show
  {{ script('betgame.Games.bootstrap') }}
@stop
