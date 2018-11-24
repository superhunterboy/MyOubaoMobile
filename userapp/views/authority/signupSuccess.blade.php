@extends('l.login', array('active' => 'signin'))

@section('title') 注册成功 @parent @stop

@section ('styles')
    @parent
    {{ style('reg') }}
    <style type="text/css">
        .center
        {
            text-align: center;
        }
    </style>

@stop

@section('container')
    @include('authority.signupHeader')
    
    <div class="reg-result">
        <div class="alert alert-success">
            <i></i>
            <div class="txt">
                <h4>恭喜您，注册成功!</h4>
                <p>请妥善保管您的密码，如有问题请联系客服</p>
                <!-- <p>我们已经向您注册时填写的邮箱<b>{{ $sRegisterMail }}</b>发送了一封与博狼娱乐账号绑定的确认邮件，请按提示完成绑定操作！</p> -->
                <div><a class="btn btn-small" href="{{ route('signin') }}">进入博狼娱乐首页</a></div>
            </div>
        </div>
    </div>

    @include('w.footer')
@stop
