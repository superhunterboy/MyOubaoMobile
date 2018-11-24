@extends('l.base')

@section('title')
验证老银行卡 -- 增加绑定
@parent
@stop

@section('scripts')
@parent
{{ script('dsgame.Message') }}
{{ script('dsgame.Tip')}}
{{ script('dsgame.Select')}}
{{ script('jquery.easing.1.3')}}
{{ script('jquery.mousewheel')}}
@stop

@section('container')


<div class="content">
    <div id="J-error-msg" class="prompt" style="display:none;"></div>

    <?php (isset($iCardId) && $iCardId) ? $url = route('bank-cards.modify-card', [0, $iCardId]) : $url = route('bank-cards.bind-card', 0); ?>
    <form action="{{ $url }}" method="post" id="J-form" autocomplete="off">
        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
        <table width="100%" class="table-field">
            @if(isset($iCardId) && $iCardId)
            <tr>
                <td align="right">卡号：</td>
                <td>
                    <input type="hidden" name="id" value="{{ $data->id }}">
                    {{ $data->account_hidden }}
                </td>
            </tr>
            @else
            <tr>
                <td align="right">选择验证银行卡：</td>
                <td>
                    <select id="J-select-bank-card" style="display:none;" name="id">
                        <option value="" selected="selected">请选择你要验证的银行卡</option>
                        @foreach ($aBindedCards as $key => $oCard)
                        <option value="{{ $oCard->id }}" {{ $oCard->id == Input::get('id') ? 'selected' : '' }}>{{ $oCard->account_hidden }}</option>
                        @endforeach
                    </select>
                </td>
            </tr>
            @endif
            <tr>
                <td align="right">开户人姓名：</td>
                <td>
                    <input type="text" class="input w-4" id="J-input-name" name="account_name" value="{{ Input::get('account_name') }}">
                    <span class="ui-text-prompt">请输入旧的银行卡开户人姓名</span>
                </td>
            </tr>
            <tr>
                <td align="right">银行账号：</td>
                <td>
                    <input type="hidden" name="account" value="{{ Input::get('account') }}">
                    <input type="text" class="input w-4" id="J-input-card-number" value="{{ Input::get('account') }}">
                    <span class="ui-text-prompt">请输入旧的银行卡卡号</span>
                </td>
            </tr>
            <tr>
                <td align="right">资金密码：</td>
                <td>
                    <input type="password" class="input w-4" id="J-input-password" name="fund_password">
                    <span class="ui-text-prompt">请输入您的资金密码</span>
                </td>
            </tr>
            <tr>
                <td align="right"></td>
                <td>
                    <a href="javascript:void(0);"  class="btn btn-important" id="J-submit">下一步</a>
                </td>
            </tr>
        </table>
    </form>
</div>





@stop

@section('end')
<script type="text/javascript">
    (function () {
        if ($('#popWindow').length) {
            // $('#myModal').modal();
            var popWindow = new dsgame.Message();
            var data = {
                title: '提示',
                content: $('#popWindow').find('.pop-bd > .pop-content').html(),
                closeIsShow: true,
                closeButtonText: '关闭',
                closeFun: function () {
                    this.hide();
                }
            };
            popWindow.show(data);
        }
    })();
</script>
@parent
<?php
// $hasAlertInfo = (int)isset($message);
// print("<script language=\"javascript\">var hasAlertInfo = $hasAlertInfo;</script>\n");
?>
<script>
    (function ($) {
        var tip = new dsgame.Tip({cls: 'j-ui-tip-b j-ui-tip-input-floattip'}),
                cardInput = $('#J-input-card-number'),
                makeBigNumber;
        if ($('#J-select-bank-card').length)
            new dsgame.Select({realDom: '#J-select-bank-card', cls: 'w-4'});

        cardInput.keyup(function (e) {
            $('input[name=account]').val(this.value.replace(/\s+/g, ''));
            var el = $(this), v = this.value.replace(/^\s*/g, ''), arr = [], code = e.keyCode;
            if (code == 37 || code == 39) {
                return;
            }
            v = v.replace(/[^\d|\s]/g, '').replace(/\s{2}/g, ' ');
            this.value = v;
            if (v == '') {
                v = '&nbsp;';
            } else {
                v = makeBigNumber(v);
                this.value = v;
            }
            tip.setText(v);
            tip.getDom().css({left: el.offset().left + el.width() / 2 - tip.getDom().width() / 2});
            if (v != '&nbsp;') {
                tip.show(el.width() / 2 - tip.getDom().width() / 2, tip.getDom().height() * -1 - 20, this);
            } else {
                tip.hide();
            }

        });
        cardInput.focus(function () {
            var el = $(this), v = $.trim(this.value);
            if (v == '') {
                v = '&nbsp;';
            } else {
                v = makeBigNumber(v);
            }
            tip.setText(v);
            if (v != '&nbsp;') {
                tip.show(el.width() / 2 - tip.getDom().width() / 2, tip.getDom().height() * -1 - 20, this);
            } else {
                tip.hide();
            }
        });
        cardInput.blur(function () {
            this.value = makeBigNumber(this.value);
            tip.hide();
        });
        //每4位数字增加一个空格显示
        makeBigNumber = function (str) {
            var str = str.replace(/\s/g, '').split(''), len = str.length, i = 0, newArr = [];
            for (; i < len; i++) {
                if (i % 4 == 0 && i != 0) {
                    newArr.push(' ');
                    newArr.push(str[i]);
                } else {
                    newArr.push(str[i]);
                }
            }
            return newArr.join('');
        };


        $('#J-submit').click(function () {
            var bankCard = $('#J-select-bank-card'),
                    name = $('#J-input-name'),
                    password = $('#J-input-password');
            if ($('#J-select-bank-card').length) {
                if (!$.trim(bankCard.val())) {
                    alert('请选择需要进行验证的银行卡');
                    return false;
                }
            }

            if ($.trim(name.val()) == '') {
                alert('请填写开户人姓名');
                name.focus();
                return false;
            }
            if ($.trim(cardInput.val()) == '') {
                alert('请填写银行账号');
                cardInput.focus();
                return false;
            }
            if ($.trim(password.val()) == '') {
                alert('请填写资金密码');
                password.focus();
                return false;
            }
            $('#J-form').submit();
            return true;
        });

    })(jQuery);
</script>
@stop