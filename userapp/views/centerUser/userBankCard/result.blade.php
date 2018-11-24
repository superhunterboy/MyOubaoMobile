@extends('l.home')

@section('title')
    绑定结果 -- 增加绑定
@parent
@stop

@section('scripts')
@parent
    {{ script('dsgame.MiniWindow')}}
@stop

@section('container')

<div class="content">

     @if ($bSucceed)
    <div class="alert alert-success">
        <i></i>
        <div class="txt">
            <h4>恭喜你，银行卡绑定成功。</h4>
            <p>新的银行卡可以立即发起“平台提现”</p>
            <div>现在您可以：
                @if(Session::get('is_player'))
                <a href="{{ route('user-recharges.quick', $iDefaultPaymentPlatformId) }}" class="btn btn-small" data-Jump>充值</a>
                @endif
                &nbsp;&nbsp;<a href="{{ route('bank-cards.index') }}" class="btn btn-small" data-Jump>银行卡管理</a></div>
        </div>
    </div>
    @else

    <div class="alert alert-error">
        <i></i>
        <div class="txt">
            <h4>银行卡绑定失败。</h4>
            <div>现在您可以：  <a href="{{ route('bank-cards.bind-card', 0) }}" class="btn btn-small">重新绑定</a></div>
        </div>
    </div>
    @endif

@stop


@section('end')
@parent
<script>
    (function($){

        var URL = "{{ route('bank-cards.index') }}";

        var addCardMiniwindow = window.parent.addCardMiniwindow;
        addCardMiniwindow.setTitle('银行绑定成功');
        $('[data-Jump]').click(function(){
            var URL  = $(this).attr('href');
            window.parent.location.href= URL;
        })


    })(jQuery);
</script>
@stop