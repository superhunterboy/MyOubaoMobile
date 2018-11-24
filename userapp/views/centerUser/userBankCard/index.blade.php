@extends('l.home')

@section('title')
    银行卡管理
@parent
@stop



@section('main')
<div class="nav-bg">
    <div class="title-normal">
        银行卡管理
    </div>
</div>

<div class="content">
    <div class="prompt-text">
        一个游戏账户最多绑定 {{ $iLimitCardsNum }} 张银行卡， 您目前绑定了{{ $iBindedCardsNum }}张卡，还可以绑定{{ $iLimitCardsNum - $iBindedCardsNum }}张。<br />
        银行卡信息锁定后，不能增加新卡绑定，已绑定的银行卡信息不能进行修改和删除。<br />
        为了您的账户资金安全，银行卡“新增”和“修改”将在操作完成2小时0分后，新卡才能发起“向平台提现”。
    </div>
    <table class="table">
        <tr>
            <th>银行名称</th>
            <th>卡号</th>
            <th>绑定时间</th>
            <th>银行卡状态</th>
            @if ($bLocked==0)
            <th>操作</th>
            @endif
        </tr>
        @foreach ($datas as $data)
        <tr>
            <td>{{ $data->bank }}</td>
            <td>{{ $data->account_hidden }}</td>
            <td>{{ $data->updated_at }}</td>
            <td>{{ $data->{$aListColumnMaps['status']} }}</td>
            @if($bLocked==0)
            <td><a href="javascript:void(0);" data-edit-bankcard  data-url="{{ route('bank-cards.modify-card', [0,$data->id]) }}">修改</a>  |  <a href="{{ route('bank-cards.destroy', $data->id) }}">删除</a></td>
            @endif
        </tr>
        @endforeach
    </table>
    @if ($bLocked==0)
    <div class="area-search" style="margin-top:10px;">
        <p class="row">
            @if(isset($iBindedCardsNum) && (int)$iBindedCardsNum < $iLimitCardsNum)
                <a  class="btn" href="javascript:void(0);" data-add-bankcard>+ 增加绑定</a>
            @endif
            <a href="{{ route('bank-cards.card-lock') }}" class="btn">锁定银行卡</a>
        </p>
    </div>

    @endif
</div>
@stop
@if($bLocked==0)
@section('end')
    @parent
    <script>
        // 添加银行卡
        // 变量必须保证为全局变量，以便iframe内调用
        var addCardMask = new dsgame.Mask(),
            addCardMiniwindow = new dsgame.MiniWindow({ cls: 'w-13 add-card-miniwindow' });

        (function(){
            var hideMask = function(){
                addCardMiniwindow.hide();
                addCardMask.hide();
            };

            addCardMiniwindow.doNormalClose = hideMask;
            addCardMiniwindow.doConfirm     = hideMask;
            addCardMiniwindow.doClose       = hideMask;
            addCardMiniwindow.doCancel      = hideMask;

            $('[data-add-bankcard]').on('click', function(){
                addCardMask.show();
                addCardMiniwindow.setContent('<iframe src="{{ route('bank-cards.bind-card', 0) }}" width="100%" height="360" frameborder="0" allowtransparency="true" scrolling="no"></iframe>');
                addCardMiniwindow.setTitle('添加银行卡');
                addCardMiniwindow.show();
            });

            $('[data-edit-bankcard]').on('click',function(){
                var url=$(this).attr('data-url'); 
                addCardMask.show();
                addCardMiniwindow.setContent('<iframe src="'+url+'" width="100%" height="360" frameborder="0" allowtransparency="true" scrolling="no"></iframe>');
                addCardMiniwindow.setTitle('修改银行卡');
                addCardMiniwindow.show();
            })

        })();

    </script>

@stop
@endif