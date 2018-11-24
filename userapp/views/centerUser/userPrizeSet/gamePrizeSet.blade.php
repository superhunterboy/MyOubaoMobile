@extends('l.home')

@section('title')
    我的奖金组
@parent
@stop

@section('main')

<div class="main-content">

        <div class="nav-bg">
            <div class="title-normal">我的奖金组</div>
        </div>

        <div class="content">
            @if (isset($oLotteriesPrizeSets))
                @foreach ($oLotteriesPrizeSets as $key => $oLotteryPrizeSet)
                <?php 
                    $oLottery = ManLottery::find($oLotteryPrizeSet->lottery_id);
                    if(is_object($oLottery) && $oLottery->status == Lottery::STATUS_AVAILABLE){
                ?>
                <dl class="bonus-item">
                <dt>{{ $aLotteries[$oLotteryPrizeSet->lottery_id] }}</dt>
                <dd class="bet-selected">
                    <span class="bonus-desc">奖金组<span class="fs-15">{{ $oLotteryPrizeSet->prize_group }}</span></span>
                    <a class="c-important" data-bonus-scan href="{{ route('user-user-prize-sets.game-prize-set', $oLotteryPrizeSet->lottery_id) }}">查看详情&gt;</a>
                </dd>
                </dl>
                <?php
                    }
                ?>
                @endforeach
            @endif
        </div>
</div>

<!-- <div class="content">

    @ if (Session::get('is_agent'))
    @ include('centerUser.userPrizeSet.agentUpDownPrize')
    @ endif

    @ include('centerUser.userPrizeSet.lotteryPrizeSet')
</div> -->
@stop

@section('end')
@parent
<script>
(function($){
    // 查看奖金详情
    var mask = new dsgame.Mask(),
        miniwindow = new dsgame.MiniWindow({ cls: 'w-13 iframe-miniwindow' });

    var hideMask = function(){
        miniwindow.hide();
        mask.hide();
    };

    var getContent = function(url){
        return '<iframe src="' + url + '" id="bonus-scan-frame" ' +
        'width="100%" height="350" frameborder="0" allowtransparency="true" scrolling="no"></iframe>'
    }

    miniwindow.setTitle('玩法奖金详情');
    // miniwindow.showCancelButton();
    // miniwindow.showConfirmButton();
    miniwindow.showCloseButton();

    miniwindow.doNormalClose = hideMask;
    miniwindow.doConfirm     = hideMask;
    miniwindow.doClose       = hideMask;
    miniwindow.doCancel      = hideMask;

    $('[data-bonus-scan]').on('click', function(e){
        e.preventDefault();
        var $this = $(this),
            href = $this.attr('href');
        if( !href ) return false;
        miniwindow.setContent( getContent(href) );
        mask.show();
        miniwindow.show();
    });

})(jQuery);
</script>
@stop