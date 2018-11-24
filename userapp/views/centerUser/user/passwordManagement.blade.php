@extends('l.home')

@section('title')
            密码管理
@parent
@stop

@section('scripts')
@parent
    {{ script('dsgame.Timer') }}
    {{ script('dsgame.Message') }}
    {{ script('dsgame.Mask') }}
@stop

@section ('main')
<div class="nav-bg">
    <div class="title-normal">密码管理</div>
    <a id="J-button-goback" class="button-goback" href="#">返回</a>
</div>



<div class="content">

    <div class="filter-tabs" style="margin-bottom:10px;">
        <div class="filter-tabs-cont">
                <a class="current" href="">修改登录密码</a>
                <a href="1">修改资金密码</a>
        </div>
    </div>



@include('centerUser.user.resetPassword')
@include('centerUser.user.resetSafeChangePassword')

</div>
@stop

@section('end')
@parent
<script>
(function($){

    $('#J-button-submit-login').click(function(){
        var passwordOld = $('#J-input-login-password-old'),
            passwordNew = $('#J-input-login-password-new'),
            passwordNewV = $.trim(passwordNew.val()),
            passwordNew2 = $('#J-input-login-password-new2');
        if($.trim(passwordOld.val()) == ''){
            alert('旧登录密码不能为空');
            passwordOld.focus();
            return false;
        }
        if(passwordNewV == ''){
            alert('新登录密码不能为空');
            passwordNew.focus();
            return false;
        }
        if(!(/^(?=.*\d+)(?=.*[a-zA-Z]+)(?!.*?([a-zA-Z0-9]{1})\1\1).{6,16}$/).test(passwordNewV)){
            alert('新登录密码格式不符合要求');
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

    $('#J-button-goback , .goback').click(function(e){
        history.back(-1);
        e.preventDefault();
      });

})(jQuery);
</script>


@stop
