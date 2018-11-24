
<div class="item-detail user-bonus-choose">
    <div class="item-title">
        <i class="item-icon-4"></i>配置用户奖金组
    </div>
    <div class="item-info">
        <div class="filter-tabs-cont J-group-bonus-tab">
            <a href="javascript:void(0);"><span>选择奖金组套餐</span></a>
            <a href="javascript:void(0);"><span>自定义奖金组</span></a>
        </div>
    </div>
</div>

<ul class="tab-panels">
    <li class="tab-panel-li panel-current">
        <div class="bonus-group">
            <ul class="clearfix" id="J-panel-group">
                @foreach ($oPossiblePrizeGroups as $oPrizeGroup)
                <li>
                    <div class="bonus-group-wrap">
                        <div class="bonus"><strong class="data-bonus">{{ $oPrizeGroup->classic_prize }}</strong>当前奖金</div>
                        <div class="rebate"><strong class="data-feedback"> {{number_format(($currentUserPrizeGroup-$oPrizeGroup->classic_prize)/2000*100,2).'%'}}</strong>预计平均返点率</div>
                        <input type="button" class="btn button-selectGroup" value="选 择" data-groupid="{{ $oPrizeGroup->id }}" />
                    </div>
                    <a href="{{ route('user-user-prize-sets.prize-set-detail', $oPrizeGroup->classic_prize) }}" data-bonus-scan>查看奖金组详情</a>
                </li>
                @endforeach
            </ul>
            <ul class="clearfix" id="J-panel-group-agent" style='display:none;'>
                @foreach ($oPossibleAgentPrizeGroups as $oPrizeGroup)
                <li>
                    <div class="bonus-group-wrap">
                        <div class="bonus"><strong class="data-bonus">{{ $oPrizeGroup->classic_prize }}</strong>当前奖金</div>
                        <div class="rebate"><strong class="data-feedback">  {{number_format(($currentUserPrizeGroup-$oPrizeGroup->classic_prize)/2000*100,2).'%'}}</strong>预计平均返点率</div>
                        <input type="button" class="btn button-selectGroup" value="选 择" data-groupid="{{ $oPrizeGroup->id }}" />
                    </div>
                    <a href="{{ route('user-user-prize-sets.prize-set-detail', $oPrizeGroup->classic_prize) }}" data-bonus-scan >查看奖金组详情</a>
                </li>
                @endforeach
            </ul>
        </div>
    </li>

    <li class="tab-panel-li">
        <input type="hidden" name="series_id" id="J-input-custom-type" value="{{ Input::old('series_id') }}" />
        <input type="hidden" name="lottery_id" id="J-input-custom-id" value="{{ Input::old('lottery_id') }}" />

        <div class="bonusgroup-game-type clearfix J-bonusgroup-player">
            @if (isset($aLotteriesPrizeSets))
                @foreach ($aLotteriesPrizeSets as $aSeries)
                <div class="bonusgroup-list">
                <h3>设置{{$aSeries['friendly_name'] }}奖金组</h3>

                <ul class="clearfix gametype-row">
                    <li class="slider-range slider-range-global" data-id="{{ $aSeries['id'] }}" data-itemType="all" onselectstart="return false;" data-slider-step="1">
                        <div class="slider-range-scale">
                            <span class="slider-title">统一设置</span>
                            <a href="" data-bonus-scan class="c-important">查 看</a>
                            <span class="small-number" data-slider-min>{{$iPlayerMinPrizeGroup}}</span>
                            <span class="percent-number" data-slider-percent>0%</span>
                            <span class="big-number" data-slider-max>{{$iCurrentPrize}}</span>
                        </div>
                        <div class="slider-current-value" data-slider-value>{{$iPlayerMinPrizeGroup}}</div>
                        <div class="slider-action">
                            <div class="slider-range-sub" data-slider-sub>-</div>
                            <div class="slider-range-add" data-slider-add>+</div>
                            <div class="slider-range-wrapper" data-slider-cont>
                                <div class="slider-range-inner" data-slider-inner></div>
                                <div class="slider-range-btn" data-slider-handle></div>
                            </div>
                        </div>
                    </li>
                    @foreach ($aSeries['children'] as $key => $aLotteryPrizeSet)
                    <li class="slider-range" data-id="{{ $aLotteryPrizeSet['id'] }}" data-itemType="game" onselectstart="return false;" data-slider-step="1">
                        <div class="slider-range-scale">
                            <span class="slider-title">{{ $aLotteryPrizeSet['name'] }}</span>
                            <a href="" data-bonus-scan class="c-important">查 看</a>
                            <span class="small-number" data-slider-min>{{$iPlayerMinPrizeGroup}}</span>
                            <span class="percent-number" data-slider-percent>0%</span>
                            <span class="big-number" data-slider-max>{{$iCurrentPrize}}</span>
                        </div>
                        <div class="slider-current-value" data-slider-value>{{$iPlayerMinPrizeGroup}}</div>
                        <div class="slider-action">
                            <div class="slider-range-sub" data-slider-sub>-</div>
                            <div class="slider-range-add" data-slider-add>+</div>
                            <div class="slider-range-wrapper" data-slider-cont>
                                <div class="slider-range-inner" data-slider-inner></div>
                                <div class="slider-range-btn" data-slider-handle></div>
                            </div>
                        </div>
                    </li>
                    @endforeach
                </ul>

                </div>
                @endforeach
                @endif
        </div>
        @if (Session::get('is_agent'))
        <div class="bonusgroup-game-type J-bonusgroup-agent">
            <div class="bonusgroup-list bonusgroup-list-line">
                <h3>设置全部彩种奖金组</h3>
                <ul>
                    <li class="slider-range slider-range-global" onselectstart="return false;" data-slider-step="1">
                        <div class="slider-range-scale">
                            <span class="slider-title">统一设置</span>
                            <a href="" data-bonus-scan class="c-important">查 看</a>
                            <span class="small-number" data-slider-min>{{$iAgentMinPrizeGroup}}</span>
                            <span class="percent-number" data-slider-percent>0%</span>
                            <span class="big-number" data-slider-max>{{$iCurrentPrize}}</span>
                        </div>
                        <div class="slider-current-value" data-slider-value>{{$iAgentMinPrizeGroup}}</div>
                        <div class="slider-action">
                            <div class="slider-range-sub" data-slider-sub>-</div>
                            <div class="slider-range-add" data-slider-add>+</div>
                            <div class="slider-range-wrapper" data-slider-cont>
                                <div class="slider-range-inner" data-slider-inner></div>
                                <div class="slider-range-btn" data-slider-handle></div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        @endif
        <input type="hidden" id="J-input-bonusgroup-gameid" value="" />
        <input type="hidden" id="J-input-lottery-json" name="lottery_prize_group_json" />
        <input type="hidden" id="J-input-series-json" name="series_prize_group_json" />
    </li>
</ul>

