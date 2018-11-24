<!DOCTYPE HTML>
<html lang="en-US">
    <head>
        <meta charset="UTF-8">
        <META HTTP-EQUIV="Refresh" content="30">
        <title>投注记录</title>
        @section ('styles')
            {{ style('global')}}
            {{ style('ucenter') }}
        @show

        @section('scripts')
            {{ script('jquery-1.9.1') }}
            {{ script('dsgame.base') }}
            {{ script('dsgame.Select') }}
            {{ script('dsgame.Tip') }}
        @show
    </head>
    @if( $lotteryId == 16 || $lotteryId == 17 )
    <body style="background:transparent;" class="miniWindow-page-dice">
    @else
    <body style="background:transparent;">
    @endif    
    <table width="100%" class="table" id="J-table">
    <tbody>
        <tr>
            <th>游戏</th>
            <th>玩法</th>
            <th>奖期</th>
            @if( $lotteryId == 16 )<th>开奖号码</th>@else<th>奖金组</th>@endif
            <th>方案</th>
            <th>模式</th>
            <th>倍数</th>
            <th>金额</th>
            <th>状态</th>
            <th>操作</th>
        </tr>
        @foreach ($datas as $data)
        <tr>
            <td> {{ $aLotteries[$data->lottery_id] }} </td>
            <td> {{ $data->title }} </td>
            <td> {{ $data->issue }} </td>
            @if( $lotteryId == 16 )
            <td data-dice-number>{{$data->winning_number}}</td>
            @else
            <td> {{ $data->prize_group }} </td>
            @endif
            <td>
                @if ( strlen( $data->display_bet_number) > 5 )
                    <a class="view-detail" href="javascript:void(0);">详细号码</a><textarea class="data-textarea" style="display:none;">{{ $data->display_bet_number }} </textarea>
                @else
                    {{ $data->display_bet_number }}
                @endif
            </td>
            <td> {{ $data->formatted_coefficient }} </td>
            <td>{{ $data->multiple}}倍</td>
            <td>{{ $data->amount_formatted }} </td>
            <?php
            $sWinOrLose = $data->formatted_status ;
            $sStyle = $sWinOrLose == '已中奖' ? 'color:red' : '';
            ?>
            <td style="{{ $sStyle }}}">{{ $sWinOrLose }}</td>
            <td>
                <a href="{{route('projects.view', $data->id)}}" target="_blank">详情</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@section('end')
<script>
(function($){
    @if( $lotteryId == 16 )
    // 骰宝版开奖号码
    $('[data-dice-number]').each(function(){
        var balls = $.trim($(this).text()).split(''),
            html = '';
        if( balls.length ){
            $.each(balls, function(idx,ball){
                html += '<span class="dice-number dice-number-' + ball + '">' + ball + '</span>';
            });
            $(this).addClass('dice-number-wrap').html(html);
        }else{
            $(this).html('开奖中...');
        }
    });
    @endif

    var table = $('#J-table'),
        details = table.find('.view-detail'),
        tip = new dsgame.Tip({cls:'j-ui-tip-l j-ui-tip-page-records'});

    details.hover(function(e){
        var el = $(this),
            text = el.parent().find('.data-textarea').val();
        tip.setText(text);
        tip.show(50, -(tip.getDom().height()/2), el);

        e.preventDefault();
    },function(){
        tip.hide();
    });
})(jQuery);
</script>
@show

    </body>
</html>

