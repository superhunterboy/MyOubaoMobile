@extends('l.thome')

@section('title')
{{ $sLotteryName . '-' . $sTrendTypeName }}-走势图
@parent
@stop

@section ('container')
@include('centerTrend.ssc.ssc-ways')
@include('centerTrend.pk10.pk10-search')

<div class="chart-section" id="J-chart-area">
    <table class="chart-table" id="J-chart-table">
        <thead class="thead">
            <tr class="title-text">
                <th rowspan="2" class="ball-none border-bottom"></th>
                <th rowspan="2" class="border-bottom">期号</th>
                <th rowspan="2" class="ball-none border-bottom border-right"></th>
                <th rowspan="2" class="ball-none border-bottom"></th>
                <th colspan="10" class="border-bottom">名次</th>
                <th rowspan="2" class="ball-none border-bottom border-right"></th>
                <th colspan="3" class="border-bottom border-right">大小</th>
                <th colspan="3" class="border-bottom border-right">单双</th>
                <th colspan="3" class="border-bottom border-right">龙虎</th>
            </tr>
            <tr class="title-number">
                <th class="border-bottom"><i class="ball-noraml">冠</i></th>
                <th class="border-bottom"><i class="ball-noraml">亚</i></th>
                <th class="border-bottom"><i class="ball-noraml">季</i></th>
                <th class="border-bottom"><i class="ball-noraml">四</i></th>
                <th class="border-bottom"><i class="ball-noraml">五</i></th>
                <th class="border-bottom"><i class="ball-noraml">六</i></th>
                <th class="border-bottom"><i class="ball-noraml">七</i></th>
                <th class="border-bottom"><i class="ball-noraml">八</i></th>
                <th class="border-bottom"><i class="ball-noraml">九</i></th>
                <th class="border-bottom"><i class="ball-noraml">十</i></th>
                <th class="border-bottom">第一名</th>
                <th class="border-bottom">第二名</th>
                <th class="border-bottom">第三名</th>
                <th class="border-bottom">第一名</th>
                <th class="border-bottom">第二名</th>
                <th class="border-bottom">第三名</th>
                <th class="border-bottom">第一名</th>
                <th class="border-bottom">第二名</th>
                <th class="border-bottom">第三名</th>
            </tr>
        </thead>
        <tbody class="tbody table-guides"  id="J-chart-content"></tbody>

        <tbody class="tbody tbody-footer-header">
            <tr class="auxiliary-area title-number">
                <th rowspan="2" class="ball-none border-bottom"></th>
                <th rowspan="2" class="border-bottom">期号</th>
                <th rowspan="2" class="ball-none border-bottom border-right"></th>
                <th rowspan="2" class="ball-none border-bottom"></th>
                <th class="border-bottom"><i class="ball-noraml">冠</i></th>
                <th class="border-bottom"><i class="ball-noraml">亚</i></th>
                <th class="border-bottom"><i class="ball-noraml">季</i></th>
                <th class="border-bottom"><i class="ball-noraml">四</i></th>
                <th class="border-bottom"><i class="ball-noraml">五</i></th>
                <th class="border-bottom"><i class="ball-noraml">六</i></th>
                <th class="border-bottom"><i class="ball-noraml">七</i></th>
                <th class="border-bottom"><i class="ball-noraml">八</i></th>
                <th class="border-bottom"><i class="ball-noraml">九</i></th>
                <th class="border-bottom"><i class="ball-noraml">十</i></th>
                <th rowspan="2" class="ball-none border-bottom border-right"></th>
                <th class="border-bottom">第一名</th>
                <th class="border-bottom">第二名</th>
                <th class="border-bottom">第三名</th>
                <th class="border-bottom">第一名</th>
                <th class="border-bottom">第二名</th>
                <th class="border-bottom">第三名</th>
                <th class="border-bottom">第一名</th>
                <th class="border-bottom">第二名</th>
                <th class="border-bottom">第三名</th>
            </tr>
            <tr class="auxiliary-area title-text">
                <th colspan="10" rowspan="2" class="border-bottom">名次</th>
                <th colspan="3" class="border-bottom border-right">大小</th>
                <th colspan="3" class="border-bottom border-right">单双</th>
                <th colspan="3" class="border-bottom border-right">龙虎</th>
            </tr>
        </tbody>
    </table>



</div>
<!-- End 后三 -->
@stop

@section('end')
@parent
<script>
    var CHART;
            (function($){
            var sysConfig = {{ $sConfigs }};
                    var theads = ['期号', '1', '2', '3', '4', '5', '6', '3', '4', '5', '6', '7', '8', '9', '10'];
                    CHART = new dsgame.GameCharts({currentGameType:'pk10', currentGameMethod: 'chart', expands:{
                    getDataUrl:function(){
                    var dt1 = Date.parse(new Date($('#J-date-star').val())),
                            dt2 = Date.parse(new Date($('#J-date-end').val()));
                            dt1 = isNaN(dt1) ? '' : dt1 / 1000;
                            dt2 = isNaN(dt2) ? '' : dt2 / 1000;
                            var arr = [sysConfig.queryBaseUrl + '?'],
                            p,
                            param = {
                            'lottery_id':sysConfig.lotteryId,
                                    'num_type':sysConfig.wayId,
                                    'count':30,
                                    'begin_time':dt1,
                                    'end_time':dt2
                            };
                            for (p in param){
                    if (param.hasOwnProperty(p)){
                    arr.push(p + '=' + param[p]);
                    }
                    }
                    return arr.join('&');
                    },
                            pk10chartRender:function(data, currentNum){

                            var styleName = currentNum % this.getSeparateNum() == 0 ? ' border-bottom' : '';
                                    return this.getHtmlFragment(data, currentNum, styleName);
                            },
                            getHtmlFragment:function(data, currentNum, styleName){
                            var html = '<tr>';
                                    $.each(data, function(i, d){
                                    if (i == 1){
                                    html += '<td class="ball-none border-bottom"></td>';
                                    }

                                    // 期号
                                    if (i == 0){
                                    html += '<td class="border-right border-bottom" colspan="3">' + d + '</td>';
                                    }
                                    // 开奖号码
                                    else if (i < 11){
                                    html += '<td class="border-bottom"><i class="pk10-number pk10-number-' + d + '">' + d + '</i></td>';
                                    }
                                    // 号码形态
                                    else if (i < 14){
                                    if (d == 1){
                                    html += '<td class="bg-green border-right">大</td>';
                                    } else{
                                    html += '<td class="bg-zise border-right"><i class="ball-noraml">小</i></td>';
                                    }
                                    }
                                    else if (i < 17){
                                    if (d == 1){
                                    html += '<td class="bg-blue border-right">单</td>';
                                    } else{
                                    html += '<td class="bg-red border-right"><i class="ball-noraml">双</i></td>';
                                    }
                                    }
                                    //龙虎
                                    else if (i >= 17){
                                    if (d == 0){
                                    html += '<td class="border-right"><i class="ball-noraml c-0-3">龙</i></td>';
                                    } else{
                                    html += '<td class="border-right"><i class="ball-noraml f-1">虎</i></td>';
                                    }
                                    }

                                    if (i == 10){
                                    html += '<td class="ball-none border-right border-bottom"></td>';
                                    }
                                    });
                                    html += '</tr>';
                                    return $(html)[0];
                            }
                    }});
                    CHART.addEvent('afterRenderChartHtml', function(){
                    var me = this, tds = $(me.getContainer()).find('tr:last').children();
                            tds.addClass('border-bottom');
                    });
                    CHART.show();
                    CHART.sysConfig = sysConfig;
                    //提交选球数据
                    $('#J-form-submit').submit(function(e){
            var trs = $('#J-select-content').find('.select-area'), its, result = [], arrRow = [], arr = [], resultStr = '',
                    cls = 'ball-orange',
                    i = 0,
                    len = 0;
                    trs.each(function(k){
                    arrRow = [];
                            its = $(this).find('.ball-noraml');
                            for (i = 0, len = its.length; i < len; i++){
                    //arr[i] = its[i].className.indexOf(cls) != -1 ? 1 : 0;
                    if (its[i].className.indexOf(cls) != - 1){
                    arr.push(i % 10);
                    }
                    if ((i + 1) % 10 == 0){
                    arrRow.push(arr.join(''));
                            arr = [];
                    }
                    }
                    if ($.trim(arrRow.join('')) != ''){
                    result.push(arrRow.join('-'));
                    }
                    });
                    resultStr = result.join('_');
                    $('#J-input-submit-value').val(resultStr);
                    if (resultStr == ''){
            return false;
            }
            });
                    $('#J-button-submit').click(function(e){
            e.preventDefault();
                    $('#J-form-submit').submit();
            });
            })(jQuery);
</script>
@stop
