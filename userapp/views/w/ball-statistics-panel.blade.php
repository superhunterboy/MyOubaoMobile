<div id="J-balls-statistics-panel">
	<ul class="bet-statistics clearfix">
		<li class="choose-btn right">
			<button type="button" id="J-add-order" class="ui-button"><i></i><span>选好了</span></button>
		</li>
		<li class="moneyunit-choose">
			<select id="J-balls-statistics-moneyUnit" style="display: none;">
				@foreach(objectToArray($availableCoefficients) as $iPrizeGroup=>$iCount)
	                <option value="{{$iPrizeGroup}}">{{$iCount}}</option>
	            @endforeach
			</select>
			<div class="filter-tabs-cont" id="J-balls-statistics-moneyUnit-trigger">
				@foreach(objectToArray($availableCoefficients) as $iPrizeGroup=>$iCount)
					<a href="javacript:;" data-value="{{$iPrizeGroup}}">{{$iCount}}</a>
	            @endforeach
			</div>
		</li>
		<li class="multiple-choose">
			<span>倍数</span>
			<select id="J-balls-statistics-multiple" style="display:none;">
				<option value="1">1</option>
				<option value="5">5</option>
				<option value="10">10</option>
			</select>
			<span id="J-balls-statistics-multiple-text" class="game-statistics-multiple-text">1</span>
		</li>
		<!-- 设置奖金组及返点-->
		<li class="bonus-choose">
			<div class="slider-range J-prize-group-slider" onselectstart="return false;" data-slider-step="1">
                <div class="slider-range-scale">
                	<span>返点</span>
                    <span class="small-number" data-slider-min></span>
                    <span class="percent-number" data-slider-percent>0%</span>
                    <span class="big-number" data-slider-max></span>
                </div>
				<div class="right">
                	<span class="slider-current-value" data-slider-value></span>
					<span>奖金组</span>
                </div>
                <div class="slider-action">
                    <div class="slider-range-sub" data-slider-sub>-</div>
                    <div class="slider-range-add" data-slider-add>+</div>
                    <div class="slider-range-wrapper" data-slider-cont>
                        <div class="slider-range-inner" data-slider-inner></div>
                        <div class="slider-range-btn" data-slider-handle></div>
                    </div>
                </div>
			</div>
			<input id="J-bonus-select-value" type="hidden" value="1960">
		</li>
		<li class="choose-bet">
			<span>您选择了</span>
			<em id="J-balls-statistics-lotteryNum">0</em>
			<span>注,</span>
			<em id="J-balls-statistics-multipleNum">0</em>
			<span>倍，返还</span>
			<em id="J-balls-statistics-rebate">0.00</em>
			<span>元，共投注</span>
			<em id="J-balls-statistics-amount">0.00</em>
			<span>元</span>
		</li>
	</ul>
</div>

