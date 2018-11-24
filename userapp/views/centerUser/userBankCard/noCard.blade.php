@extends('l.home')

@section('title')
            银行卡管理
@parent
@stop



@section ('main')
<div class="nav-bg">
    <div class="title-normal">
        银行卡管理
    </div>
</div>

<div class="content">

    <div class="no-bank-card">
				<p class="alert-message"><i class="alert-icon"></i><span>添加一张银行卡吧</span></p>
				<a href="javascript:void(0);" data-add-bankcard>+  添加银行卡</a>
			</div>
</div>

@stop

@section('end')
    @parent
    <script>
        // 添加银行卡
        // 变量必须保证为全局变量，以便iframe内调用
        var addCardMask = new dsgame.Mask(),
            addCardMiniwindow = new dsgame.MiniWindow({ cls: 'w-13 add-card-miniwindow' });
            addCardURL = "{{ route('bank-cards.bind-card', 1) }}" ;

        (function(){
            var hideMask = function(){
                addCardMiniwindow.hide();
                addCardMask.hide();
            };

            addCardMiniwindow.setContent('<iframe src="'+addCardURL+'" width="100%" height="360" frameborder="0" allowtransparency="true" scrolling="no"></iframe>');
            addCardMiniwindow.setTitle('添加银行卡');
            // addCardMiniwindow.showCancelButton();
            // addCardMiniwindow.showConfirmButton();

            addCardMiniwindow.doNormalClose = hideMask;
            addCardMiniwindow.doConfirm     = hideMask;
            addCardMiniwindow.doClose       = hideMask;
            addCardMiniwindow.doCancel      = hideMask;

            $('[data-add-bankcard]').on('click', function(){
                addCardMask.show();
                addCardMiniwindow.show();

            });

        })();

    </script>

@stop