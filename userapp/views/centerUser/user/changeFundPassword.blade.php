@extends('l.home')

@section('title')
   登录密码管理
@parent
@stop

@section('scripts')
@parent
    {{ script('dsgame.Timer') }}
    {{ script('dsgame.Message') }}
    {{ script('dsgame.Mask') }}
@stop

@section('main')
<div class="nav-bg nav-bg-tab">
    <div class="title-normal">个人中心</div>

    <ul class="tab-title clearfix">
        <!-- <li><a href="{{ route('users.user') }}" ><span>个人中心</span></a></li> -->
        <li><a href="{{ route('users.personal') }}" ><span>昵称管理</span></a></li>
        <li><a href="{{ route('users.change-password') }}"><span>登录密码管理</span></a></li>
         @if ( $oUser->fund_password) 
        <li class="current"><a href="{{ route('users.change-fund-password') }}"><span>资金密码管理</span></a></li>
         @else 
        <li class="current"><a href="{{ route('users.safe-reset-fund-password') }}"><span>资金密码设置</span></a></li>
         @endif 
    </ul>
</div>

<div class="content">
@if ($bFundPasswordSetted)
    <form action="{{ route('users.change-fund-password') }}" method="post" id="J-form-money">
        <input type="hidden" name="_method" value="PUT" />
        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
        <table width="100%" class="table-field">

            <tr>
                <td align="right" style="width:350px;">输入旧资金密码：</td>
                <td>
                    <input id="J-input-money-password-old" type="password" class="input w-4" name="old_fund_password">
                </td>
                <td>
                    <div class="col-sm-4">
                        {{ $errors->first('old_fund_password', '<label class="text-danger control-label">:message</label>') }}
                    </div>
                </td>
            </tr>
            <tr>
                <td align="right">输入新资金密码：</td>
                <td>
                    <input id="J-input-money-password-new" type="password" class="input w-4" name="fund_password">
                    <span class="ui-text-prompt-multiline w-6">由字母和数字组成6-16个字符；且必须包含数字和字母，不允许连续三位相同，不能和登录密码相同</span>
                    <div class="col-sm-4">
                        {{ $errors->first('fund_password', '<label class="text-danger control-label">:message</label>') }}
                    </div>
                </td>
            </tr>
            <tr>
                <td align="right">确认新资金密码：</td>
                <td>
                    <input id="J-input-money-password-new2" type="password" class="input w-4" name="fund_password_confirmation">
                </td>
                <td>
                    <div class="col-sm-4">
                        {{ $errors->first('fund_password_confirmation', '<label class="text-danger control-label">:message</label>') }}
                    </div>
                </td>
            </tr>
            <tr>
                <td align="right"></td>
                <td>
                    <input id="J-button-submit-money" type="submit" value="修 改" class="btn">
                </td>
            </tr>
        </table>
    </form>
@else
    <span class="ui-text-prompt">您还没有设置资金密码，<a href="{{ route('users.safe-reset-fund-password') }}">立即设置</a></span>
@endif

</div>
@stop


@section('end')
@parent
<script>
(function($){
    $('#J-button-submit-money').click(function(){
        var passwordOld = $('#J-input-money-password-old'),
            passwordNew = $('#J-input-money-password-new'),
            passwordNewV = $.trim(passwordNew.val()),
            passwordNew2 = $('#J-input-money-password-new2');
        if($.trim(passwordOld.val()) == ''){
            alert('旧资金密码不能为空');
            passwordOld.focus();
            return false;
        }
        if(passwordNewV == ''){
            alert('新资金密码不能为空');
            passwordNew.focus();
            return false;
        }
       if(!(/^(?=.*\d+)(?=.*[a-zA-Z]+)(?!.*?([a-zA-Z0-9]{1})\1\1).{6,16}$/).test(passwordNewV)){
            alert('新资金密码格式不符合要求');
            passwordNew.focus();
            return false;
        }
        if($.trim(passwordNew2.val()) != passwordNewV){
            alert('两次输入的密码不一致');
            passwordNew2.focus();
            return false;
        }

        return true;

    });

})(jQuery);
</script>
@stop