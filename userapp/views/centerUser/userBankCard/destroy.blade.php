@extends('l.home')

@section('title')
    删除银行卡
@parent
@stop

@section('scripts')
@parent
    {{ script('dsgame.Tip')}}
@stop

@section('main')
<div class="nav-bg">
            <div class="title-normal">删除银行卡</div>
        </div>

        <div class="content">


            <form action="{{ route('bank-cards.destroy', $iCardId) }}" method="post" id="J-form">
            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
            <input type="hidden" name="method" value="DELETE" />
            <table width="100%" class="table-field">
                <tr>
                    <td align="right">卡号：</td>
                    <td>
                        <input type="hidden" name="id" value="{{ $iCardId }}">
                        {{ $sAccountHidden }}
                    </td>
                </tr>
                <tr>
                    <td align="right">开户人姓名：</td>
                    <td>
                        <input type="text" class="input w-4" id="J-input-name" name="account_name">
                        <span class="ui-text-prompt">请输入旧的银行卡开户人姓名</span>
                    </td>
                </tr>
                <tr>
                    <td align="right">银行账号：</td>
                    <td>
                        <input type="text" class="input w-4" id="J-input-card-number" name="account">
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
                        <!-- <input type="submit" value="删除" class="btn" id="J-submit"> -->
                        <a href="javascript:void(0);"  value="删 除" class="btn" id="J-submit">删除</a>
                        <a href="{{ route('bank-cards.index') }}"  value="取 消" class="btn btn-normal">取消</a>
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
        var tip = new dsgame.Tip({cls:'j-ui-tip-b j-ui-tip-input-floattip'}),
            cardInput = $('#J-input-card-number'),
            makeBigNumber;


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


        $('#J-submit').click(function(e){
            var name = $('#J-input-name'),
                password = $('#J-input-password');
            e.preventDefault();
            if($.trim(name.val()) == ''){
                alert('请填写开户人姓名');
                name.focus();
                return false;
            }
            if($.trim(cardInput.val()) == ''){
                alert('请填写银行账号');
                cardInput.focus();
                return false;
            }
            if($.trim(password.val()) == ''){
                alert('请填写资金密码');
                password.focus();
                return false;
            }
            $('#J-form').submit();
        });


    })(jQuery);
    </script>
@stop