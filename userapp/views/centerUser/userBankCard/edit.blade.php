@extends('l.base')

@section('title')
    修改银行卡信息
@parent
@stop

@section('scripts')
@parent
    {{ script('dsgame.Tip')}}
    {{ script('dsgame.Select')}}
@stop

@section('container')

<div class="content">

    <form action="{{ route('bank-cards.modify-card', [2, $iCardId]) }}" method="post" id="J-form" autocomplete="off">
        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
        <input type="hidden" name="bank" id="J-input-bank-name" value="{{ $data->bank }}" />
        <table width="100%" class="table-field">
            <tr>
                <td align="right">开户银行：</td>
                <td>
                    <select id="J-select-banks" name="bank_id">
                        <option value>请选择开户银行</option>
                        @foreach($aBanks as $key => $val)
                        <option value="{{$key}}" >{{$val}}</option>
                        @endforeach
                    </select>
                </td>
            </tr>
            <tr>
                <td align="right">开户银行区域：</td>
                <td>
                    @include('widgets.widget', ['aSelectorData' => $aSelectorData])
                </td>
            </tr>
            <tr>
                <td align="right">支行名称：</td>
                <td>
                    <input type="text" class="input w-3" id="J-input-bankname" name="branch" value="{{ $data->branch }}">
                    <span class="ui-text-prompt">由1至20个字符或汉字组成，不能使用特殊字符</span>
                </td>
            </tr>
            <tr>
                <td align="right">开户人姓名：</td>
                <td>
                    <input type="text" class="input w-3" id="J-input-name" name="account_name" value="{{ $data->account_name }}">
                    <span class="ui-text-prompt">由1至20个字符或汉字组成，不能使用特殊字符</span>
                </td>
            </tr>
            <tr>
                <td align="right">银行账号：</td>
                <td>
                    <input type="text" class="input w-3" id="J-input-card-number" name="account" value="{{ $data->account }}">
                    <span class="ui-text-prompt">银行卡卡号由16位或19位数字组成</span>
                </td>
            </tr>
            <tr>
                <td align="right">确认银行账号：</td>
                <td>
                    <input type="text" class="input w-3" id="J-input-card-number2" name="account_confirmation">
                    <span class="ui-text-prompt">银行账号只能手动输入，不能粘贴</span>
                </td>
            </tr>
            <tr>
                <td align="right"></td>
                <td>

                    <a class="btn btn-important" id="J-submit" href="javascript:void(0);">下一步</a>

                </td>
            </tr>
        </table>
    </form>

</div>
@stop

@section('end')
@parent
<?php
    $selectedBank = $data->bank_id;
    print("<script language=\"javascript\">var selectedBank = $selectedBank;</script>\n");
?>
<script>
    (function($){

        $('#J-select-banks').css('display', 'none').val(selectedBank);
        var tip             = new dsgame.Tip({cls:'j-ui-tip-b j-ui-tip-input-floattip'}),
            cardInput       = $('#J-input-card-number, #J-input-card-number2'),
            bankNameInput   = $('#J-input-bank-name'),
            bankSelect      = new dsgame.Select({realDom:'#J-select-banks',cls:'w-3'}),
            makeBigNumber;
            bankSelect.addEvent('change', function(e, value, text) {
            bankNameInput.val(text);
        });


        cardInput.keyup(function(e){
            var el = $(this),v = this.value.replace(/^\s*/g, ''),arr = [],code = e.keyCode;
            if(code == 37 || code == 39){
                return;
            }
            v = v.replace(/[^\d|\s]/g, '').replace(/\s{2}/g, ' ');
            this.value = v;
            if(v == ''){
                v = '&nbsp;';
            }else{
                v = makeBigNumber(v);
                this.value = v;
            }
            tip.setText(v);
            tip.getDom().css({left:el.offset().left + el.width()/2 - tip.getDom().width()/2});
            if(v != '&nbsp;'){
                tip.show(el.width()/2 - tip.getDom().width()/2, tip.getDom().height() * -1 - 20, this);
            }else{
                tip.hide();
            }
        });
        cardInput.focus(function(){
            var el = $(this),v = $.trim(this.value);
            if(v == ''){
                v = '&nbsp;';
            }else{
                v = makeBigNumber(v);
            }
            tip.setText(v);
            if(v != '&nbsp;'){
                tip.show(el.width()/2 - tip.getDom().width()/2, tip.getDom().height() * -1 - 20, this);
            }else{
                tip.hide();
            }
        });
        cardInput.blur(function(){
            this.value = makeBigNumber(this.value);
            tip.hide();
        });
        cardInput.keydown(function(e){
            if(e.ctrlKey && e.keyCode == 86){
                return false;
            }
        });
        cardInput.bind("contextmenu",function(e){
            return false;
        });
        //每4位数字增加一个空格显示
        makeBigNumber = function(str){
            var str = str.replace(/\s/g, '').split(''),len = str.length,i = 0,newArr = [];
            for(;i < len;i++){
                if(i%4 == 0 && i != 0){
                    newArr.push(' ');
                    newArr.push(str[i]);
                }else{
                    newArr.push(str[i]);
                }
            }
            return newArr.join('');
        };


        $('#J-submit').click(function(){
            var bank = $('#J-select-banks'),
                province = $('#J-select-province'),
                city = $('#J-select-city'),
                bankname = $('#J-input-bankname'),
                name = $('#J-input-name'),
                cardnumber = $('#J-input-card-number'),
                cardnumber2 = $('#J-input-card-number2');

            if($.trim(bank.val()) == ''){
                alert('请选择开户银行');
                return false;
            }
            if($.trim(province.val()) == '0'){
                alert('请选择开户银行省份');
                return false;
            }
            // if($.trim(city.val()) == '0'){
            //     alert('请选择开户银行城市');
            //     return false;
            // }
            if($.trim(bankname.val()) == ''){
                alert('请填写支行名称');
                bankname.focus();
                return false;
            }
            if($.trim(name.val()) == ''){
                alert('请填写开户人姓名');
                name.focus();
                return false;
            }
            if($.trim(cardnumber.val()) == ''){
                alert('请填写银行账号');
                cardnumber.focus();
                return false;
            }
            if($.trim(cardnumber2.val()) == ''){
                alert('请填写确认银行账号');
                cardnumber2.focus();
                return false;
            }
            if($.trim(cardnumber.val()) != $.trim(cardnumber2.val())){
                alert('两次填写的银行账号不一致');
                cardnumber2.focus();
                return false;
            }
            $('#J-form').submit();
            return true;
        });
        // setTimeout(function() {
        //     $('#J-select-province').val(selectedProvince);
        //     $('#J-select-city').val(selectedCity);
        // }, 1000);
        var objBankAccount = $('#J-input-card-number');
            if(objBankAccount.val()!=''){
                objBankAccount.val(makeBigNumber(objBankAccount.val()));
            }
    })(jQuery);
    </script>
@stop