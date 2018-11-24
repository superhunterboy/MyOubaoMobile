@extends('l.home')

@section('title')
   昵称修改
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
        <li class="current"><a href="{{ route('users.personal') }}" ><span>昵称管理</span></a></li>
        <li><a href="{{ route('users.change-password') }}"><span>登录密码管理</span></a></li>
        @if ( $oUser->fund_password)
        <li><a href="{{ route('users.change-fund-password') }}"><span>资金密码管理</span></a></li>
        @else
        <li><a href="{{ route('users.safe-reset-fund-password') }}"><span>资金密码设置</span></a></li>
        @endif
    </ul>
</div>


<div class="content">
    <form action="{{ route('users.personal') }}" method="post" id="J-form-login">
        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
        <input type="hidden" name="_method" value="PUT" />
        <table width="100%" class="table-field">
            <tr>
                <td align="right" style="width:350px;">用户名：</td>
                <td>
                     {{ Session::get('username') }}
                </td>
            </tr>

            <tr>
                <td align="right">昵称：</td>
                <td>
                    <input id="J-input-nickname" type="text" class="input w-2" name="nickname" value="{{ $oUser->nickname }}">
                    &nbsp;&nbsp;
                    <span class="tip">由2至16个字符组成</span>
                </td>
            </tr>
            <tr>
                <td align="right"></td>
                <td>
                    <input id="J-button-submit" type="submit" value="保存" class="btn" />
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

    $('#J-button-submit').click(function(){
        var v = $.trim($('#J-input-nickname').val());
        if(v.length < 2 || v.length > 16){
            alert('昵称必须由2至6个字符组成，请重新输入');
            $('#J-input-nickname').focus();
            return false;
        }
        return true;
    });

})(jQuery);
</script>
@stop