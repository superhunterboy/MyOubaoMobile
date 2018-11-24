<!DOCTYPE HTML>
<html lang="en-US">
    <head>
        <meta charset="UTF-8">
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

    <body style="background:none">
    <table width="100%" class="table" id="J-table">
    <tbody>
        <tr>
            <th>编号</th>
            <th>时间</th>
            <th>账变类型</th>
            <th>游戏</th>
            <th>玩法</th>
            <th>模式</th>
            <th>变动金额</th>
            <th>余额</th>
        </tr>
        @foreach ($datas as $data)
        <tr>
                <td>
                    <?php $link = $data->project_id ? route('projects.view',$data->project_id) : '#'; ?>
                    <a class="view-detail" href="{{ $link }}">{{ $data->serial_number_short }}</a>
                    <textarea class="data-textarea" style="display:none;">{{ $data->serial_number }} </textarea>
                </td>
                <td>
                    <?php $aCreatedAt = explode(' ', $data->created_at); ?>
                    {{ $aCreatedAt[0] }}
                    {{ $aCreatedAt[1] }}
                </td>
                <td>{{ $data->friendly_description }}</td>
                <td>{{ $aLotteries[$data->lottery_id] or null }}</td>
                <td>{{ $aSeriesWays[$data->way_id] or ''}}</td>
                <td>{{ $data->formatted_coefficient}}</td>
                <td><span class="{{ $data->amount_formatted < 0 ? 'c-green' : 'c-red' }}">{{ $data->amount_formatted }}</span></td>
                <td>{{ $data->available_formatted }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

@section('end')
<script>
(function($){
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

