@extends('l.home')

@section('title')
            提现确认
@parent
@stop

@section ('main')
<div class="nav-bg">
            <div class="title-normal">
                提现确认
            </div>
        </div>

        <div class="content recharge-confirm recharge-netbank">
            <form action="{{ route('user-withdrawals.withdraw', 1) }}" method="post" id="J-form">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <input type="hidden" name="step" value="2" />
                <input type="hidden" name="id" value="{{ $oBankCard->id }}" />
                <input type="hidden" name="amount" value="{{ $aInputData['amount'] }}" />
                <table width="100%" class="table-field">
                    <tr>
                        <td width="50%" align="right" valign="top"><span class="field-name">用户名：</span></td>
                        <td>
                            {{ $oBankCard->username }}
                        </td>
                    </tr>
                    <tr>
                        <td align="right" valign="top"><span class="field-name">可用提现余额：</span></td>
                        <td>
                            {{ $oAccount->withdrawable_formatted }} 元
                        </td>
                    </tr>
                    <tr>
                        <td align="right" valign="top"><span class="field-name">本次提现金额：</span></td>
                        <td>
                            {{ $aInputData['amount'] }} 元
                        </td>
                    </tr>
                    <tr>
                        <td align="right" valign="top"><span class="field-name">开户银行：</span></td>
                        <td>
                            {{ $oBankCard->bank }}
                        </td>
                    </tr>
                    <tr>
                        <td align="right" valign="top"><span class="field-name">开户地址：</span></td>
                        <td>
                            {{ $oBankCard->province . '  ' . $oBankCard->city }}
                        </td>
                    </tr>
                    <tr>
                        <td align="right" valign="top"><span class="field-name">开户人：</span></td>
                        <td>
                            {{ $oBankCard->formatted_account_name }}
                        </td>
                    </tr>
                    <tr>
                        <td align="right" valign="top"><span class="field-name">提现银行卡号：</span></td>
                        <td>
                            {{ $oBankCard->account_hidden }}
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="2" class="text-center"><span class="c-red">为了确保您的资金安全，请输入资金密码以便确认您的身份！</span></td>
                    </tr>
                    <tr>
                        <td align="right" valign="top"><span class="field-name">验证资金密码：</span></td>
                        <td>
                            <input type="password" class="input w-2 input-ico-lock" id="J-input-passowrd" name="fund_password" />
                        </td>
                    </tr>
                    <tr>
                        <td valign="top">&nbsp;</td>
                        <td>
                            <input type="submit" class="btn" value=" 确认提现 " id="J-submit" />
                            <!-- <a href="javascript:history.back(-1);" class="btn">返回修改</a> -->
                        </td>
                    </tr>
                </table>
            </form>

        </div>
@stop
@section ('end')
@parent
<script>
(function($){
    var ipt1 = $('#J-input-passowrd');
    $('#J-submit').click(function(){
        var v1 = $.trim(ipt1.val());
        if(v1 == ''){
            alert('资金密码不能为空');
            ipt1.focus();
            return false;
        }
        return true;
    });
})(jQuery);
</script>
@stop