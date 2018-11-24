@extends('l.home')

@section('title')
    网银汇款--充值
@parent
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
        <!-- <div class="prompt">
            平台填写金额必须和网银汇款金额一致（不包含手续费），否则充值无法到账。
        </div> -->
        <form action="{{ route('user-recharges.netbank') }}" method="post" id="J-form">
            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
            <table width="100%" class="table-field">
                <tr>
                    <td width="120" align="right" valign="top">选择充值银行：</td>
                    <td>
                        <div class="bank_dropdown" tabindex="0">
                            <p class="dropdown_toggle" data-toggle="dropdown">
                                <i class="toggle_icon">选择银行</i>
                                <span data-id=" " class="ico-bank UN-bank">请选择银行</span>
                            </p>
                            <div class="bank-list" id="J-bank-list">
                                <input name="bank" value="" id="bank-name" type="hidden">
                                @foreach($oAllBanks as $bank)
                                <label class="img-bank" for="J-bank-name-{{$bank->identifier}}" >
                                    <!-- <input name="bank-type" id="J-bank-name-{{$bank->identifier}}" type="radio" value="{{$bank->id}}" style="visibility:hidden;"> -->
                                    <span data-id="{{$bank->id}}" class="ico-bank {{$bank->identifier}}">{{$bank->name}}</span>
                                </label>
                                @endforeach
                        <!-- <label class="img-bank" for="J-bank-name-OTHER" >
                            <input name="bank-type" id="J-bank-name-OTHER"  type="radio" value="OTHER" style="visibility:hidden;">
                            <span class="ico-bank OTHER">其他银行</span>
                        </label> -->
                        </div>
                    </td>
                </tr>

                <!-- <tr>
                    <td align="right" valign="top">充值金额：</td>
                    <td>
                        <input type="text" class="input w-2 input-ico-money" id="J-input-money" name="amount" />
                        <br />
                        <span class="tip">充值额度限定：最低 <span id="J-money-min">20.00</span>,最高 <span id="J-money-max">30,000.00</span> 元</span>
                    </td>
                </tr>

                <tr>
                    <td align="right" valign="top">充值返送说明：</td>
                    <td>
                        <span class="prompt-text" id="J-bank-text">银行相关说明</span>
                    </td>
                </tr> -->
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
                                    <td><span class="c-important" id="J-money-min"></span></td>
                                    <td><span class="c-important" id="J-money-max"></span></td>
                                    <td>30分钟</td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td align="right" valign="top">&nbsp;</td>
                    <td><input id="J-submit" class="btn" type="submit" value="   下一步   " />
                </tr>
            </table>
        </form>
    </div>
    <div class="recharge-help">
        <h3>常见问题</h3>
        <div class="prompt">
            单日充值总额无上限，充值无手续费
        </div>
        <h4>为什么银行充值成功了无法到账？</h4>
        <p>
        平台填写金额必须和银行转账金额一致（不包含手续费），否则充值无法到账。
        </p>
        <h4>每次充值的额度限定是多少？</h4>
        <p>充值额度限定根据不同银行有不同的标准，具体可以查看相应银行的充值额度限定标准。</p>
    </div>
</div>
@stop

@section('end')
@parent
<script>
(function($){

    var bankCache = {{$sAllBanksJs}};
    var banks = $('#J-bank-list').children(),
        inputs = banks.find('input'),
        loadBankInfoById, buildingView;

    loadBankInfoById = function(id, callback){
        var data = bankCache[id];
        if( callback && typeof callback == 'function' ){
            callback(data);
        }
    };
    buildingView = function(bankData){
        $('#J-money-min').text(dsgame.util.formatMoney(Number(bankData['min'])));
        $('#J-money-max').text(dsgame.util.formatMoney(Number(bankData['max'])));
        // $('#J-input-money').val('');
        // $('#J-input-password').val('');
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

        loadBankInfoById(value, buildingView);

    }).eq(0).trigger('click');

    $('#J-submit').click(function(){
        var banks = $('input[name="bank"]').val();

        if(banks == undefined || banks == ''){
            alert('请选择充值银行');
            return false;
        }

        return true;
    });

})(jQuery);
</script>

@stop