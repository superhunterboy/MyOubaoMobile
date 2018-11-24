@extends('l.home')

@section('title')
            快捷充值-充值
@parent
@stop

@section('scripts')
@parent
    {{ script('jquery.jscrollpane')}}
    {{ script('dsgame.Tip')}}
    {{ script('dsgame.DatePicker')}}
@stop

@section ('main')
<div class="nav-bg nav-bg-tab">
    <div class="title-normal">
        充值
    </div>
    <ul class="tab-title">
        @include('w.deposit-nav')
    </ul>
</div>
<div class="content recharge-netbank">
    <div class="recharge-box">
        <form action="{{ route('user-recharges.quick', $oPlatform->id) }}" method="post" id="J-form">
            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
        <input type="hidden" name="deposit_mode" value="{{ UserDeposit::DEPOSIT_MODE_THIRD_PART }}" />
        <table width="100%" class="table-field">
            <tr>
                <td align="right">充值渠道：</td>
                <td align="left">{{ $oPlatform->display_name }}</td>
            </tr>
            @if ( $oPlatform->need_bank) 
            <tr>
                <td width="120" align="right" valign="top"><span class="field-name">选择充值银行：</span></td>
                <td>
                    <div class="bank_dropdown" tabindex="0">
                        <p class="dropdown_toggle" data-toggle="dropdown">
                            <i class="toggle_icon">选择银行</i>
                            <span data-id=" " class="ico-bank UN-bank">请选择银行</span>
                        </p>
                        <div class="bank-list" id="J-bank-list">

                            @foreach($oAllBanks as $oBank)
                            <label class="img-bank" for="J-bank-name-{{ $oBank->identifier }}">
                                <span data-id="{{ $oBank->id }}" class="ico-bank {{ $oBank->identifier }}">{{ $oBank->name }}</span>
                            </label>
                            @endforeach
                            <input name="bank" value="" id="bank-name" type="hidden">
                        </div>

                    </div>
                </td>
            </tr>
            @endif
            <tr>
                <td align="right">充值说明：</td>
                <td>
                    <table class="table border-table small-table">
                        <thead>
                            <tr>
                                <th>最低限额（元）</th>
                                <th>最高限额（元）</th>
                                <th>充值时限（分钟）</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><span class="c-important" id="J-money-min" data-money-format>{{ $fMinLoad }}</span></td>
                                <td><span class="c-important" id="J-money-max" data-money-format>{{ $fMaxLoad }}</span></td>
                                <td>30分钟</td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td align="right" valign="top"><span class="field-name">充值金额：</span></td>
                <td>
                    <input type="text" class="input w-2 input-ico-money" id="J-input-money" name="amount" />
                    <br />
                    <!-- <span class="tip">充值额度限定：最低 <span id="J-money-min">{{ $fMinLoad }}</span>,最高 <span >{{ $fMaxLoad }}</span> 元</span> -->

                </td>
            </tr>
            @if($bCheckFundPassword)
            <tr>
                <td align="right" valign="top">资金密码：</td>
                <td>
                    <input type="password" maxlength="16" class="input w-2 input-ico-lock" id="J-input-password" name="fund_password" />
                </td>
            </tr>
            @endif
            <tr>
                <td align="right" valign="top">&nbsp;</td>
                <td>
                    <input id="J-submit" class="btn" type="submit" value="   立即充值   " />
                </td>
            </tr>
        </table>
    </form>
    </div>
    <div class="recharge-help">
        <h3>常见问题</h3>
        <div class="prompt">
            单笔充值最高限额 {{$fMaxLoad}} 元，单日充值总额无上限，充值无手续费
            <!--充值额度为 {{$fMinLoad}} 至 {{$fMaxLoad}} 元，给您带来的不便，敬请谅解。-->
        </div>
        <h4>为什么银行充值成功了无法到账？</h4>
        <p>
        平台填写金额必须和银行转账金额一致（不包含手续费），否则充值无法到账。
        </p>
        <h4>每次充值的额度限定是多少？</h4>
        <p>所有银行充值额度限定最低是 {{ $fMinLoad }} 元，最高额度限定根据不同银行有不同的标准，具体可以查看相应银行的充值额度限定标准。</p>
    </div>
</div>

<script>
(function($){
    {{-- 未设置资金密码 --}}
    @if(!$bSetFundPassword)
    var msg = dsgame.Message.getInstance();
    msg.show({
        content:"<div style='padding-bottom:10px;font-size:14px;'>使用充值前需设置资金密码，是否现在进行设置？</div>",
        confirmIsShow:true,
        cancelIsShow:true,
        isShowMask:true,
        confirmFun:function(){
            location.href = "{{ route('users.safe-reset-fund-password') }}";
        },
        cancelFun:function(){
            msg.hide();
        }
    });
    /**
    if(confirm("使用充值前需设置资金密码，是否现在进行设置？")) {
        location.href = "{{ route('users.safe-reset-fund-password') }}";
    } else {
        location.href = "/";
    }
    **/
    @endif

    {{-- 银行及用户银行卡JS数据接口 --}}
    var bankCache = {{$sAllBanksJs}};
    var banks = $('#J-bank-list').children(),inputs = banks.find('input'),loadBankInfoById,buildingView,
        moneyInput = $('#J-input-money'),
        tip = new dsgame.Tip({cls:'j-ui-tip-b j-ui-tip-input-floattip'});

    loadBankInfoById = function(id, callback){
        var data = bankCache[id];
        callback(data);
    };
    buildingView = function(bankData){
        // $('#J-money-min').text(dsgame.util.formatMoney(Number(bankData['min'])));
        // $('#J-money-max').text(dsgame.util.formatMoney(Number({{$fMaxLoad}})));//bankData['max']
        $('#J-input-money').val('');
        $('#J-input-password').val('');
    };

    // 选择银行卡下拉
    var $dropdown = $('.bank_dropdown');
    var $banklists = $dropdown.find('.bank-list');
    var initBankId = $('#bank-name').val();
    $dropdown.on({
        mousedown: function(e){
            if( $(this).hasClass('open') ) return false;
            $(this).addClass('open');
            // return false;
        }
        // 点击
        , click: function( e ){
            e.preventDefault();
        }
        // 失去焦点
        , blur: function( e ){
            console.log('失去焦点');
            $(this).removeClass('open');
        }
    });
    $banklists.find('label').on('click', function(){
        var $bank = $(this).find('.ico-bank');
        var value = $bank.data('id');

        // addClass/removeClass active
        $(this).siblings('.active').removeClass('active').end()
            .addClass('active');

        // replace html
        $('.dropdown_toggle .ico-bank').replaceWith( $bank.clone() );

        // change input value
        $('#bank-name').val( value );


        $dropdown.removeClass('open');

        //loadBankInfoById(value, buildingView);

    }).eq(0).trigger('click');


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
        tip.setText(v);
        tip.getDom().css({left:moneyInput.offset().left + moneyInput.width()/2 - tip.getDom().width()/2});
    });
    moneyInput.focus(function(){
        var v = $.trim(this.value);
        if(v == ''){
            v = '&nbsp;';
        }
        tip.setText(v);
        tip.show(moneyInput.width()/2 - tip.getDom().width()/2, tip.getDom().height() * -1 - 20, this);
    });
    moneyInput.blur(function(){
        var v = Number(this.value),
            //minNum = Number($('#J-money-min').text().replace(/,/g, '')),
            maxNum = Number('{{$fMaxLoad}}'.replace(/,/g, ''))//Number($('#J-money-max').text().replace(/,/g, ''));
        //v = v < minNum ? minNum : v;
        v = v > maxNum ? maxNum : v;
        this.value = dsgame.util.formatMoney(v).replace(/,/g, '');
        tip.hide();
    });

    $('#J-submit').click(function(){
        var money = $('#J-input-money'),
            password = $('#J-input-password'),
            banks = $('input[name="bank"]').val();
            // bankCard = $('.choose-input-disabled');
        //if没有开启银行卡判断

        @if ($oPlatform->need_bank)
        if(banks == undefined || banks == ''){
            alert('请选择充值银行');

            return false;
        }
        @endif

        if($.trim(money.val()) == ''){
            alert('金额不能为空');
            money.focus();
            return false;
        }
        @if($bCheckFundPassword)
        if($.trim(password.val()) == ''){
            alert('资金密码不能为空');
            password.focus();
            return false;
        }
        @endif
        return true;
    });


})(jQuery);
</script>
@stop