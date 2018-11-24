@extends('l.home')

@section('title')
个人资料
@parent
@stop

@section('scripts')
@parent
{{ script('dsgame.Timer') }}
{{ script('dsgame.Message') }}
{{ script('dsgame.Mask') }}
{{ script('dsgame.Tab') }}
@stop

@section('main')

<div class="main-content">

    <div class="nav-bg">
        <div class="title-normal">个人中心</div>
    </div>

    <div class="content user-center">
        <div class="user-data clearfix">
            <!-- 账号信息 -->
            <div class="user-account">
                <a data-id="{{intval(Session::get('portraitCode'))}}" data-action="avatar" class="user-avater">
                    <i data-ds-avatar="{{intval(Session::get('portraitCode'))}}"></i>
                    <span>整容</span>
                </a>
                <span class="uc-icon uc-account-icon"></span>
                <div class="uc-row">
                    <label>账号信息：</label>
                    <p>
                        <strong class="user-nickname">{{ Session::get('username') }}</strong> &nbsp;&nbsp;
                        <a class="uc-link" href="{{ route('station-letters.index') }}">查看站内信</a>
                    </p>
                </div>

                <div class="uc-row">
                    <label>我的奖金组：</label>
                    <p>
                        <?php
                        $i = 0;
                        ?>
                        @foreach ($oLotteriesPrizeSets as $key => $oLotteryPrizeSet)
                        @if($i++>1)
                        <?php
                        continue;
                        ?>
                        @endif
                        <span>{{ $aLotteries[$oLotteryPrizeSet->lottery_id] }}：{{ $oLotteryPrizeSet->prize_group }}</span> &nbsp;&nbsp;
                        @endforeach
                        <a class="uc-link" href="{{ route('user-user-prize-sets.game-prize-set') }}">查看全部</a>
                    </p>
                </div>
                @if(Session::get('is_agent'))
                <div class="uc-row">
                    <label>我的配额：</label>
                    <table class="table">
                        <tbody><tr>
                                <th width="80">奖金组</th>
                                @foreach($aQuota as $iPrizeGroup=>$iCount)
                                <td width="50">{{$iPrizeGroup}}</td>
                                @endforeach
                            </tr>
                            <tr>
                                <th>配额</th>
                                @foreach($aQuota as $iPrizeGroup=>$iCount)
                                <td><span class="c-important">{{$iCount}}</span></td>
                                @endforeach
                            </tr>
                        </tbody></table>
                </div>
                @endif
            </div>
            <!-- 账户余额 -->
            <div class="user-balance">
                <span class="uc-icon uc-balance-icon"></span>
                <div class="uc-row">
                    <label>账户余额：</label>
                    <p><span class="c-important fs-15" data-money-format>{{ $oAccount ->balance_formatted }}</span>元</p>
                    <p>
                        <a href="{{ route('user-recharges.quick', $iDefaultPaymentPlatformId) }}" class="btn btn-important">充值</a>
                        <a href="{{ route('user-withdrawals.withdraw') }}" class="btn">提现</a>
                        @if (Session::get('is_top_agent'))
                        <a href="{{route('transfer.transfer')}}" class="btn">转账</a>
                        @endif
                        &nbsp;&nbsp;<a class="uc-link" href="{{ route('user-transactions.index') }}">查看资金明细</a>
                    </p>
                </div>
                <ul class="user-data-ul">
                    <li>
                        <label>可提现余额：</label>
                        <span data-money-format>{{ $oAccount ->withdrawable_formatted }}</span>元
                    </li>
                    <li>
                        <label>暂时冻结余额：<i data-tips="系统为保证您的提款或追号订单能够顺利完成，将暂时冻结此部分金额。" class="alert-icon"></i></label>
                        <span data-money-format>{{ $oAccount ->frozen_formatted }}</span>元
                    </li>
                    <li>
                        <label>不可提现余额：<i data-tips="每次充值金额的固定比例在未达到消费要求前，将无法立即提现！" class="alert-icon"></i></label>
                        <span data-money-format>{{ $oAccount ->prohibit_amount_formatted }}</span>元
                    </li>
                </ul>
            </div>
            <!-- 我的红包 -->
            <div class="user-hongbao">
                <span class="uc-icon uc-hongbao-icon"></span>
                <div class="uc-row">
                    <label>我的红包：</label>
                    <p><span class="c-important fs-15" data-money-format>{{$fAvailableHBTotalAmount}}</span>元</p>
                    <p>
                        <a href="{{ route('user-activity-user-prizes.index') }}" class="btn">红包中心</a>
                    </p>
                </div>
                <ul class="user-data-ul">
                    <li>
                        <label>可领取红包数量：</label>
                        <span>{{$iAvailableHBCount}}</span>个 &nbsp;&nbsp;
                        <a class="uc-link" href="{{route('user-activity-user-prizes.available')}}">立即领取</a>
                    </li>
                    <li>
                        <label>已领取红包数量：</label>
                        <span>{{$iReceivedHBCount}}</span>个 &nbsp;&nbsp;
                        <a class="uc-link" href="{{route('user-activity-user-prizes.received')}}">查看红包获取记录</a>
                    </li>
                </ul>
            </div>

        </div>

        <div class="user-config">
            <div class="uc-subnav left">
                <a href="javascript:;">
                    <i class="uc-icon uc-safety-icon"></i>
                    <strong>安全设置</strong><br>
                    <span>保障账户资金安全</span>
                </a>
                <!-- <a href="javascript:;">
                    <i class="uc-icon uc-address-icon"></i>
                    <strong>收货地址</strong><br>
                    <span>收取官方贴心礼物</span>
                </a>
                <a href="javascript:;">
                    <i class="uc-icon uc-event-icon"></i>
                    <strong>我的活动</strong><br>
                    <span>查看取金奋斗史</span>
                </a> -->
            </div>
            <div class="user-config-content">
                <div class="uc-panel uc-safety-panel">
                    <ul class="clearfix">
                        <li class="change-login-psw uc-safety-ok">
                            <a href="{{ route('users.change-password') }}">
                                <i class="uc-icon"></i>
                                <i class="uc-safety-config-icon"></i>
                                <span>修改登录密码</span>
                            </a>
                        </li>
                        @if ( $oUser->fund_password)
                        <li class="change-fund-psw uc-safety-ok">
                            <a href="{{ route('users.change-fund-password') }}">
                                <i class="uc-icon"></i>
                                <i class="uc-safety-config-icon"></i>
                                <span>修改资金密码</span>
                            </a>
                        </li>
                        @else
                        <li class="change-fund-psw">
                            <a href="{{ route('users.safe-reset-fund-password') }}">
                                <i class="uc-icon"></i>
                                <i class="uc-safety-config-icon"></i>
                                <span>设置资金密码</span>
                            </a>
                        </li>
                        @endif

                        <!-- @if ( $oUser->isActivated())
                        <li class="bind-email uc-safety-ok">
                            <a>
                                <i class="uc-icon"></i>
                                <i class="uc-safety-config-icon"></i>
                                <span>已填写：dsgame***@163.com</span>
                            </a>
                        </li>
                        @else
                        <li class="bind-email">
                            <a href="{{ route('users.bind-email') }}">
                                <i class="uc-icon"></i>
                                <i class="uc-safety-config-icon"></i>
                                <span>立即绑定邮箱</span>
                            </a>
                        </li>
                        @endif -->
                        @if($iUserBankCardCount>0)
                        <li class="bind-bank-card  uc-safety-ok">
                            <a href="{{ route('bank-cards.index') }}">
                                <i class="uc-icon"></i>
                                <i class="uc-safety-config-icon"></i>
                                <span>已绑定银行卡</span>
                            </a>
                        </li>
                        @else
                        <li class="bind-bank-card">
                            <a href="{{ route('bank-cards.index') }}">
                                <i class="uc-icon"></i>
                                <i class="uc-safety-config-icon"></i>
                                <span>绑定银行卡</span>
                            </a>
                        </li>
                        @endif
                        <li class="change-nickname uc-safety-ok">
                            <a href="{{ route('users.personal') }}">
                                <i class="uc-icon"></i>
                                <i class="uc-safety-config-icon"></i>
                                <span>{{ $oUser->nickname }}&nbsp;&nbsp;修改法号</span>
                            </a>
                        </li>
                        <!-- <li class="bind-phone uc-safety-ok">
                            <a href="">
                                <i class="uc-icon"></i>
                                <i class="uc-safety-config-icon"></i>
                                <span>绑定手机</span>
                            </a>
                        </li> -->
                    </ul>
                </div>
                <!-- <div class="uc-panel uc-address-panel">uc-address-panel</div>
                <div class="uc-panel uc-event-panel">uc-event-panel</div> -->
            </div>
        </div>

    </div>
</div>
<script>
$(function () {

    // Tips
    var tips = new dsgame.Tip({cls: 'j-ui-tip-b w-4'});
    $('[data-tips]').hover(function (e) {
        var el = $(this),
                text = el.data('tips');
        tips.setText(text);
        tips.show(-102, tips.getDom().height() * -1 - 22, el);
        e.preventDefault();
    }, function () {
        tips.hide();
    });

    // Tabs
    var tabs = new dsgame.Tab({
        currClass: 'active',
        par: '.user-config',
        triggers: '.uc-subnav a',
        panels: '.user-config-content .uc-panel',
        eventType: 'click'
    });

    var $avatar = $('[data-action="avatar"]'),
        $link, $avatarid, $avatarMsg;

    var mask = new dsgame.Mask(),
        miniWindow = new dsgame.MiniWindow({ cls: 'w-10 avatar-miniwindow' });

    var hideMask = function(){
        miniWindow.hide();
        mask.hide();
    };
    var getAvatarHtml = function(){
        var html = [];
        $.each(dsAvatars, function(i,n){
            html.push('<a data-id="' + (i+1) + '" href="javascript:;">' +
                        '<img src="' + dsAvatarPath + n + '" alt="">' +
                      '</a>');
        });
        html.push('<p class="J-avatar-msg c-important" style="display:none;"></p>');
        html.push('<input type="hidden" name="avatarid" class="J-avatar-id" value="1">');
        return html.join('');
    };
    var submitAvatar = function(){
        var id = $avatarid.val();
        $.ajax({
         type: 'POST',
         url: '{{route("users.portrait")}}',
         data: 'portrait=' + id +'&_token={{ csrf_token() }}',
         success: function (resp) {
             resp = $.parseJSON(resp);
             if (resp.msgType == 'success') {
                 $avatar.find('img').attr('src', $link.filter('.active').find('img').attr('src'));
                 $avatarMsg.html('头像修改成功！').show();
             }else{
                 $avatarMsg.html('头像修改失败！').show();
             }
         }
        });
    }

    miniWindow.setContent( getAvatarHtml() );
    miniWindow.setTitle('修改头像');
    miniWindow.setConfirmName('修改头像');
    miniWindow.setCancelName('关 闭');
    miniWindow.showCancelButton();
    miniWindow.showConfirmButton();

    miniWindow.doNormalClose = hideMask;
    miniWindow.doConfirm     = submitAvatar;
    miniWindow.doClose       = hideMask;
    miniWindow.doCancel      = hideMask;

    $link = miniWindow.getContentDom().find('a');
    $avatarid = miniWindow.getContentDom().find('.J-avatar-id');
    $avatarMsg = miniWindow.getContentDom().find('.J-avatar-msg');

    $avatar.on('click', function(){
        var id = $(this).data('id');
        $link.removeClass('active').filter('[data-id="' +id+ '"]').addClass('active');
        $avatarMsg.hide();
        mask.show();
        miniWindow.show();
    });
    $link.on('click', function(){
        var $this = $(this),
            id = $this.data('id');
        if( $this.hasClass('active') ) return false;
        $this.addClass('active').siblings('.active').removeClass('active');
        $avatarid.val(id);
    });

});
</script>
@stop

