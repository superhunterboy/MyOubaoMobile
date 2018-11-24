@extends('l.home')

@section('title')
            提现
@parent
@stop

@section('scripts')
@parent
    {{ script('jquery.easing.1.3')}}
    {{ script('jquery.mousewheel')}}
    {{ script('dsgame.Tip')}}
@stop



@section ('main')
<div class="nav-bg">
            <div class="title-normal">
                提现
            </div>
</div>

<div class="content recharge-confirm recharge-netbank">

    @if ($iWithdrawLimitNum)
    <div class="row-head">
        <p class="row-desc alert-message"><i class="alert-icon"></i><span>今日剩余提现次数：<span class="c-black">{{ $iWithdrawLimitNum - $iWithdrawalNum }}/{{ $iWithdrawLimitNum }}</span></span></p>
        <p>尊敬的<span class="c-important">{{ $sUsername }}</span>，您现在正在提现到您的银行卡，目前账户可用提现余额：
            <span data-money-format class="c-red fs-20" id="J-money-withdrawable">{{ $oAccount->withdrawable_formatted }}</span> 元
        </p>
    </div>
    @endif
    <form action="{{ route('user-withdrawals.withdraw', 1) }}" method="post" id="J-form">
        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
        <input type="hidden" name="step" value="1" />
        <table width="100%" class="table-field">
            <tr>
                    <td class="text-right vertical-top">请选择收款银行卡：</td>
                    <td class="vertical-middle">
                    @foreach($aBankCards as $oBankCard)
                        <div class="card-info-list">
                            <label class="img-bank">
                                <span class="check-icon"></span>
                                <span data-id="{{ $oBankCard->id }}" class="ico-bank {{$aBanks[$oBankCard->bank_id]}}">{{$oBankCard->bank}}</span>
                                <span>尾号：{{ substr($oBankCard->account_hidden,15)}}</span>
                                <span>[ {{$oBankCard->formatted_account_name}} ]</span>
                            </label>
                        </div>
                        @endforeach
                        <!-- <span class="card-info-tips c-gray">新绑定的银行卡<span class="c-black">1小时59分</span>后可用于提现</span> -->

                        <input name="id" value="" id="J-bank-name" type="hidden">
                        @if(isset($iBindedCardsNum) && (int)$iBindedCardsNum < $iLimitCardsNum && $bLocked==0)
                        <a class="btn" href="javascript:void(0);" data-add-bankcard>+ 添加银行卡</a>
                        @endif
                    </td>
                </tr>

            <tr>
              <td align="right" valign="top"><span class="field-name">提现金额：</span></td>
              <td>
                    <input id="J-input-money" type="text" class="input w-2 input-ico-money" name="amount" />&nbsp; 元
                    <br />
                    <span class="tip">单笔最低提现金额：<span id="J-money-min">{{ $iMinWithdrawAmount ? $iMinWithdrawAmount : 100.00 }}</span>元，最高<span id="J-money-max">{{ $iMaxWithdrawAmount ? $iMaxWithdrawAmount : 1500000.00}}</span>元</span>

                </td>
          </tr>
            <tr>
              <td align="right" valign="top">&nbsp;</td>
              <td>
                <input type="submit" class="btn" value=" 下一步 " id="J-submit" />
                </td>
          </tr>
        </table>
    </form>
</div>
@stop

@section ('end')
@parent
<script type="text/javascript">
(function($){





    var ipt1 = $('#J-input-money'),
        moneyInput = $('#J-input-money'),
        tip = new dsgame.Tip({cls:'j-ui-tip-b j-ui-tip-input-floattip'}),
        $bankname = $('#J-bank-name');
    $('body').on('click', 'label.img-bank', function(){
        var $this = $(this);
        if( $this.hasClass('active') || $this.hasClass('disabled') ) return false;
        $('label.img-bank').removeClass('active');
        $this.addClass('active');
        var id = parseInt($this.find('.ico-bank').data('id')) || 0;
        $bankname.val(id);
    });


    moneyInput.keyup(function(e){
        var v = $.trim(this.value),arr = [],code = e.keyCode;
        if(code == 37 || code == 39){
            return;
        }
        v = v.replace(/[^\d|^\.]/g, '');
        arr = v.split('.');
        if(arr.length > 2){
            v = '' + arr[0] + '.' + arr[1];
        }
        arr = v.split('.');
        if(arr.length > 1){
            arr[1] = arr[1].substring(0, 2);
            v = arr.join('.');
        }
        this.value = v;
        v = v == '' ? '&nbsp;' : v;
        if(!isNaN(Number(v))){
            v = dsgame.util.formatMoney(v);
        }
        tip.setText(v);
        tip.getDom().css({left:moneyInput.offset().left + moneyInput.width()/2 - tip.getDom().width()/2});
    });
    moneyInput.focus(function(){
        var v = $.trim(this.value);
        if(v == ''){
            v = '&nbsp;';
        }
        if(!isNaN(Number(v))){
            v = dsgame.util.formatMoney(v);
        }
        tip.setText(v);
        tip.show(moneyInput.width()/2 - tip.getDom().width()/2, tip.getDom().height() * -1 - 20, this);
    });
    moneyInput.blur(function(){
        var v = Number(this.value),minNum = Number($('#J-money-min').text().replace(/,/g, '')),maxNum = Number($('#J-money-max').text().replace(/,/g, '')),withdrawable = Number($('#J-money-withdrawable').text().replace(/,/g, ''));
        v = v < minNum ? minNum : v;
        v = v > maxNum ? maxNum : v;
        v = v > withdrawable ? withdrawable : v;
        this.value = dsgame.util.formatMoney(v).replace(/,/g, '');
        tip.hide();
    });




    $('#J-submit').click(function(){
        var bankcard = $bankname.val();
        var v1 = $.trim(ipt1.val());
        if(v1 == ''){
            alert('提款金额不能为空');
            ipt1.focus();
            return false;
        }
        if(bankcard == ''){
            alert('请选择收款银行卡');
            return false;
        }
        return true;
    });

    // 倒计时
    $('[data-countdown]').each(function(){
        var $this = $(this),
            $parent = $this.parents('.card-info-list:eq(0)'),
            lefttime = Number($parent.find('[data-lefttime-second]').val());

        (function () {
            if( lefttime <= 0 ){
                // 倒计时结束
                $parent.find('.img-bank').removeClass('disabled');
                $parent.find('.card-info-tips').hide();
            }
            var h = Math.floor(lefttime/3600),
                m = Math.floor((lefttime%3600)/60),
                s = lefttime%60,
                html = '';
            m = m < 10 ? '0' + m : '' + m;
            s = s < 10 ? '0' + s : '' + s;
            html = m + '分' + s + '秒';
            if( h > 0 ){
                html = h + '小时' + html;
            }
            $this.html(html);
            lefttime--;
            setTimeout(arguments.callee, 1000);
        })();

    });

@if($bLocked==0)
// 添加银行卡
// 变量必须保证为全局变量，以便iframe内调用
var addCardMask = new dsgame.Mask(),
    addCardMiniwindow = new dsgame.MiniWindow({ cls: 'w-12 add-card-miniwindow' });

var cardAddFun=function(url){
    var hideMask = function(){
        addCardMiniwindow.hide();
        addCardMask.hide();
    };

    addCardMiniwindow.setContent(
        '<iframe src="'+url+'" id="card-add-bind-frame" ' +
        'width="100%" height="360" frameborder="0" allowtransparency="true" scrolling="no"></iframe>'
    );
    addCardMiniwindow.setTitle('添加银行卡');
    addCardMiniwindow.showCancelButton();
    // addCardMiniwindow.showConfirmButton();

    addCardMiniwindow.doNormalClose = hideMask;
    addCardMiniwindow.doConfirm     = hideMask;
    addCardMiniwindow.doClose       = hideMask;
    addCardMiniwindow.doCancel      = hideMask;

    $('[data-add-bankcard]').on('click', function(){
        addCardMask.show();
        addCardMiniwindow.show();
    });

}//添加绑定银行卡urlFunction
        cardAddFun( '{{ route('bank-cards.bind-card', 0) }} ');
@endif
})(jQuery);
</script>
@stop








