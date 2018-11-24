@extends('l.home')

@section('title')
    确认银行卡信息
@parent
@stop

@section('scripts')
@parent
    {{ script('dsgame.Tip')}}
@stop

@section('container')

    <div class="content">
    <div id="J-error-msg" class="prompt" style="display:none;"></div>
     <form action="{{ $iCardId ? route('bank-cards.modify-card', [3, $iCardId]) : route('bank-cards.bind-card', 3) }}" method="post" id="J-form" autocomplete="off">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                @if ($iCardId)
                <input type="hidden" name="method" value="PUT" />
                @endif
                <input type="hidden" name="bank_id" value="{{ isset($aFormData['bank_id']) ? $aFormData['bank_id'] : Input::get('bank_id') }}" />
                <input type="hidden" name="bank" value="{{ isset($aFormData['bank']) ? $aFormData['bank'] : Input::get('bank') }}" />
                <input type="hidden" name="province_id" value="{{ isset($aFormData['province_id']) ? $aFormData['province_id'] : Input::get('province_id') }}" />
                <input type="hidden" name="province" value="{{ isset($aFormData['province']) ? $aFormData['province'] : Input::get('province') }}" />
                <input type="hidden" name="city_id" value="{{ isset($aFormData['city_id']) ? $aFormData['city_id'] : Input::get('city_id') }}" />
                <input type="hidden" name="city" value="{{ isset($aFormData['city']) ? $aFormData['city'] : Input::get('city') }}" />
                <input type="hidden" name="branch" value="{{ isset($aFormData['branch']) ? $aFormData['branch'] : Input::get('branch') }}" />
                <input type="hidden" name="account_name" value="{{ isset($aFormData['account_name']) ? $aFormData['account_name'] : Input::get('account_name') }}" />
                <input type="hidden" name="account" value="{{ isset($aFormData['account']) ? $aFormData['account'] : Input::get('account') }}" />
                <input type="hidden" name="account_confirmation" value="{{ isset($aFormData['account_confirmation']) ? $aFormData['account_confirmation'] : Input::get('account_confirmation') }}" />

    <table width="100%" class="table-field">
        <tr>
            <td align="right">开户银行：</td>
            <td>{{ isset($aFormData['bank']) ? $aFormData['bank'] : Input::get('bank') }}</td>
        </tr>
        <tr>
            <td align="right">开户银行区域：</td>
            <td>{{ isset($aFormData['province']) ? $aFormData['province'] : Input::get('province') }}&nbsp;&nbsp;{{ isset($aFormData['city']) ? $aFormData['city'] : Input::get('city') }}</td>
        </tr>
        <tr>
            <td align="right">支行名称：</td>
            <td>{{ isset($aFormData['branch']) ? $aFormData['branch'] : Input::get('branch') }}</td>
        </tr>
        <tr>
            <td align="right">开户人姓名：</td>
            <td>{{ isset($aFormData['account_name']) ? $aFormData['account_name'] : Input::get('account_name') }}</td>
        </tr>
        <tr>
            <td align="right">银行账号：</td>
            <td>{{ isset($aFormData['account']) ? $aFormData['account'] : Input::get('account') }}</td>
        </tr>
        <tr>
            <td align="right"></td>
            <td>
                <input type="submit" value="确认提交" class="btn" id="J-submit">
                <!-- <input type="button" value="返回上一步" class="btn btn-normal" id="J-button-back"> -->
                <a class="btn btn-normal" href="{{ $iCardId ? route('bank-cards.modify-card', [1, $iCardId]) : route('bank-cards.bind-card', 1) }}">返回上一步</a>
            </td>
        </tr>
    </table>
    </form>
</div>

@stop

@section('end')
@parent
<script>
    (function($){

        $('#J-button-back').click(function(){
            history.back(-1);
        });

if ($('#popWindow').length) {
        // $('#myModal').modal();
        var popWindow = new dsgame.Message();
        var data = {
            title          : '提示',
            content        : $('#popWindow').find('.pop-bd > .pop-content').html(),
            closeIsShow    : true,
            closeButtonText: '关闭',
            closeFun       : function() {
                this.hide();
            }
        };
        popWindow.show(data);
    }
    })(jQuery);

</script>
@stop