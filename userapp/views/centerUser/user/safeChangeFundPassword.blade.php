@extends('l.home')

@section('title')
    资金密码设置
@parent
@stop



@section ('main')
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
    <div class="prompt">
        为了你的账户安全，充值之前请先设置资金密码。
    </div>
    <form action="{{ route('users.safe-reset-fund-password') }}" method="post" id="J-form">
        <input type="hidden" name="_method" value="PUT" />
        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
        <table width="100%" class="table-field">
            <tr>
                <td align="right">设置资金密码：</td>
                <td><input type="password" class="input w-3" id="J-input-passowrd" name="fund_password" /></td>
                <td>
                    <span class="ui-text-prompt-multiline w-6">由字母和数字组成6-16个字符；且必须包含数字和字母，不允许连续三位相同，不能和登录密码相同</span>
                    <div class="col-sm-4">
                        {{ $errors->first('fund_password', '<label class="text-danger control-label">:message</label>') }}
                    </div>
                </td>
            </tr>
            <tr>
                <td align="right">确认资金密码：</td>
                <td><input type="password" class="input w-3"id="J-input-passowrd2" name="fund_password_confirmation" /></td>
                <td>
                    <span class="ui-text-prompt-multiline w-6">再次输入资金密码</span>
                    <div class="col-sm-4">
                        {{ $errors->first('fund_password_confirmation', '<label class="text-danger control-label">:message</label>') }}
                    </div>
                </td>
            </tr>
            <tr>
                <td align="right">&nbsp;</td>
                <td><input class="btn" type="submit" value=" 提 交 " id="J-submit" /></td>
            </tr>
        </table>
    </form>

</div>
@stop

@section('end')
@parent
<script>
(function($){
    var ipt1 = $('#J-input-passowrd'),
    ipt2 = $('#J-input-passowrd2');

    $('#J-submit').click(function(){
        var v1 = $.trim(ipt1.val()),
          v2 = $.trim(ipt2.val());
        if(v1 == ''){
          alert('资金密码不能为空');
          ipt1.focus();
          return false;
        }
        if(v2 == ''){
          alert('确认资金密码不能为空');
          ipt2.focus();
          return false;
        }
        if(v1 != v2){
          alert('两次输入的资金密码不一致');
          ipt2.focus();
          return false;
        }
        if(!(/^(?=.*\d+)(?=.*[a-zA-Z]+)(?!.*?([a-zA-Z0-9]{1})\1\1).{6,16}$/).test(passwordNewV)){
            alert('资金密码格式不符合要求');
            ipt2.focus();
            return false;
        }
        return true;
    });


})(jQuery);
</script>
@stop