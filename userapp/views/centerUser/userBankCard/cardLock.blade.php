@extends('l.home')

@section('title')
锁定银行卡
@parent
@stop

@section('main')
<div class="nav-bg">
    <div class="title-normal">锁定银行卡</div>
</div>

<div class="content">
    <div class="prompt-text">
        为了账户的资金安全，建议锁定银行卡信息。<br>
        锁定后不能增加新卡绑定，已绑定的银行信息不能进行修改和删除。
    </div>
    <form action="{{ route('bank-cards.card-lock') }}" method="post" id="J-form" autocomplete="off">
        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
        <table width="100%" class="table-field">
            @foreach($aBindedCards as $key => $oCard)
            <tr>
                <td align="right">已绑卡{{ $key + 1 }}：</td>
                <td>
                    <!-- <input type="hidden" name="id[]" value="{{-- $oCard->id --}}"> -->
                    {{ $oCard->bank . '--' . $oCard->account_hidden }}
                </td>
            </tr>
            @endforeach
            <tr>
                <td align="right">资金密码：</td>
                <td>
                    <input type="password" class="input w-2" id="J-input-password" name="fund_password" />
                </td>
            </tr>
            <tr>
                <td align="right"></td>
                <td>
                    <a href="javascript:void(0);" class="btn" id="J-submit">锁定</a>
                    <a href="{{ route('bank-cards.index') }}" class="btn">返 回</a>
                </td>
            </tr>
        </table>
    </form>
</div>
@stop

@section('end')
@parent
<script>
    (function ($) {
        $('#J-submit').click(function () {
            var password = $('#J-input-password'), v = $.trim(password.val());
            if (v == '') {
                alert('资金密码不能为空');
                password.focus();
                return false;
            }
            $('#J-form').submit();
            return true;
        });
    })(jQuery);
</script>
@stop