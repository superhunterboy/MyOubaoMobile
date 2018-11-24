
<div class="game-info">
    <div class="lottery-info-basic">
        <div class="lottery-info-logo">
            <img id='J-lottery-logo' src="/assets/images/game/logo/{{ $sLotteryCode }}.png" alt="{{ $sLotteryName }}" title="{{ $sLotteryName }}" />
        </div>
        <div class="lottery-info-issue-box">
            <span>第</span>
            <span id="J-header-currentNumber"></span>
            <span>期</span>
        </div>
    </div>

    <div class="lottery-countdown J-lottery-countdown">
        <ul>
            <li class="countdown-hour">
                <i>时</i>
                <em>00</em>
            </li>
            <li class="countdown-minute">
                <i>分</i>
                <em>00</em>
            </li>
            <li class="countdown-second">
                <i>秒</i>
                <em>00</em>
            </li>
        </ul>
    </div>
    <div class="lottery-board css-flip css-flip-x flip-hover">
        <!-- <div class="lottery-issue-board flip-front">
            <div id="J-lottery-numbers"></div>
        </div> -->
        <div class="lottery-numbers-board flip-back" id="lottery-numbers-board">
            <h3>第<span id="J-ernie-issue"></span>期<br>开奖结果</h3>
            <div data-lottery-ernie-numbers style="display:none;"></div>
            <div class="loading-lottery J-loading-lottery">开奖中...</div>
        </div>
        <!-- <a href="javascript:;" class="switch-board J-switch-board">切换</a> -->
    </div>

</div>



