@extends('l.thome')

@section('title')
	{{ $sLotteryName . '-' . $sTrendTypeName }}-走势图
@parent
@stop


@section ('container')
	<div class="header">
		<div class="header-inner">
			<ul>
				@foreach ($aLotteries as $key => $aLottery)
				<li class="{{ $iLotteryId == $aLottery['id'] ? 'current' : '' }}"><a href="{{ route('user-trends.trend-view', [$aLottery['id']]) }}">{{ $aLottery['name'] }}</a></li>
				@endforeach
			</ul>
		</div>
	</div>


	<div class="select-section-content clearfix" id="J-panel-control">
		<div class="select-section-content-inner">
			<div class="function">
				<label class="label"><input data-action="guides" type="checkbox" class="checkbox" checked="checked">辅助线</label>
				<label class="label"><input data-action="lost" type="checkbox" class="checkbox" checked="checked">遗漏</label>
			</div>
			<div class="time" id="J-periods-data">
				<a data-value="30" data-type="count"  href="javascript:void(0);" class="current">近30期</a>
				<a data-value="50" data-type="count" href="javascript:void(0);">近50期</a>
				<a data-value="" data-type="today" href="javascript:void(0);">今日数据</a>
				<a data-value="2" data-type="day" href="javascript:void(0);">近2天</a>
				<a data-value="5" data-type="day" href="javascript:void(0);">近5天</a>
			</div>
			<div class="search">
				<input type="text" value="" id="J-date-star" class="input"> 至 <input id="J-date-end" type="text" value="" class="input">
				<a id="J-time-periods" class="btn" href="javascript:void(0);">搜索</a>
			</div>
		</div>

	</div>
	<!-- Star 快三 -->
	<div class="chart-section" id="J-chart-area">
	   <table class="chart-table" id="J-chart-table">
			<thead class="thead">
				<tr class="title-text">
					<th rowspan="2" class="ball-none border-bottom"></th>
					<th rowspan="2" class="border-bottom">期号</th>
					<th rowspan="2" class="ball-none border-bottom border-right"></th>
					<th rowspan="2" class="ball-none border-bottom"></th>
					<th rowspan="2" class="border-bottom">开奖号码</th>
					<th rowspan="2" class="ball-none border-bottom border-right"></th>
					<th colspan="12" class="border-bottom border-right">号码走势</th>
					<th colspan="2" class="border-bottom border-right">第一球</th>
					<th colspan="2" class="border-bottom border-right">第二球</th>
					<th colspan="2" class="border-bottom border-right">第三球</th>
					<th colspan="2" class="border-bottom border-right">第四球</th>
					<th colspan="2" class="border-bottom border-right">第五球</th>
					<th colspan="2" class="border-bottom border-right">总和</th>
					<th rowspan="2" class="border-bottom border-right">龙虎和</th>
					<th rowspan="2" class="border-bottom border-right">前三球</th>
					<th rowspan="2" class="border-bottom border-right">中三球</th>
					<th rowspan="2" class="border-bottom">后三球</th>
				</tr>
				<tr class="title-number">
					<th class="ball-none border-bottom"></th>
					<th class="border-bottom"><i class="ball-noraml">0</i></th>
					<th class="border-bottom"><i class="ball-noraml">1</i></th>
					<th class="border-bottom"><i class="ball-noraml">2</i></th>
					<th class="border-bottom"><i class="ball-noraml">3</i></th>
					<th class="border-bottom"><i class="ball-noraml">4</i></th>
					<th class="border-bottom"><i class="ball-noraml">5</i></th>
					<th class="border-bottom"><i class="ball-noraml">6</i></th>
					<th class="border-bottom"><i class="ball-noraml">7</i></th>
					<th class="border-bottom"><i class="ball-noraml">8</i></th>
					<th class="border-bottom"><i class="ball-noraml">9</i></th>
					<th class="ball-none border-bottom border-right"></th>
					<th class="border-bottom border-right">球号</th>
					<th class="border-bottom border-right">形态</th>
					<th class="border-bottom border-right">球号</th>
					<th class="border-bottom border-right">形态</th>
					<th class="border-bottom border-right">球号</th>
					<th class="border-bottom border-right">形态</th>
					<th class="border-bottom border-right">球号</th>
					<th class="border-bottom border-right">形态</th>
					<th class="border-bottom border-right">球号</th>
					<th class="border-bottom border-right">形态</th>
					<th class="border-bottom border-right">和值</th>
					<th class="border-bottom border-right">形态</th>
				</tr>
			</thead>
			<tbody class="tbody table-guides"  id="J-chart-content"></tbody>

			<tbody class="tbody tbody-footer-header">
				<tr class="auxiliary-area title-text">
					<th class="border-right border-bottom" colspan="3" rowspan="2">期号</th>
					<th class="border-right border-bottom" colspan="3" rowspan="2">开奖号码</th>                    
					<td class="ball-none border-bottom"></td>
					<td class="border-bottom"><i class="ball-noraml">0</i></td>
					<td class="border-bottom"><i class="ball-noraml">1</i></td>
					<td class="border-bottom"><i class="ball-noraml">2</i></td>
					<td class="border-bottom"><i class="ball-noraml">3</i></td>
					<td class="border-bottom"><i class="ball-noraml">4</i></td>
					<td class="border-bottom"><i class="ball-noraml">5</i></td>
					<td class="border-bottom"><i class="ball-noraml">6</i></td>
					<td class="border-bottom"><i class="ball-noraml">7</i></td>
					<td class="border-bottom"><i class="ball-noraml">8</i></td>
					<td class="border-bottom"><i class="ball-noraml">9</i></td>
					<td class="ball-none border-bottom border-right"></td>
					<td class="border-bottom border-right">球号</td>
					<td class="border-bottom border-right">形态</td>
					<td class="border-bottom border-right">球号</td>
					<td class="border-bottom border-right">形态</td>
					<td class="border-bottom border-right">球号</td>
					<td class="border-bottom border-right">形态</td>
					<td class="border-bottom border-right">球号</td>
					<td class="border-bottom border-right">形态</td>
					<td class="border-bottom border-right">球号</td>
					<td class="border-bottom border-right">形态</td>
					<td class="border-bottom border-right">和值</td>
					<td class="border-bottom border-right">形态</td>
					<th rowspan="2" class="border-bottom border-right">龙虎和</th>
					<th rowspan="2" class="border-bottom border-right">前三球</th>
					<th rowspan="2" class="border-bottom border-right">中三球</th>
					<th rowspan="2" class="border-bottom">后三球</th>
				</tr>
				<tr class="auxiliary-area title-text">
					<th colspan="12" class="border-bottom border-right">号码走势</th>
					<th colspan="2" class="border-bottom border-right">第一球</th>
					<th colspan="2" class="border-bottom border-right">第二球</th>
					<th colspan="2" class="border-bottom border-right">第三球</th>
					<th colspan="2" class="border-bottom border-right">第四球</th>
					<th colspan="2" class="border-bottom border-right">第五球</th>
					<th colspan="2" class="border-bottom border-right">总和</th>
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
	CHART = new dsgame.GameCharts({currentGameType:'nssc', currentGameMethod: 'chart', expands:{
		getDataUrl:function(){
			var dt1 = Date.parse(new Date($('#J-date-star').val())),
				dt2 = Date.parse(new Date($('#J-date-end').val()));
			dt1 = isNaN(dt1) ? '' : dt1/1000;
			dt2 = isNaN(dt2) ? '' : dt2/1000;
			var arr = [sysConfig.queryBaseUrl + '?'],
			p,
			param = {
				'lottery_id':sysConfig.lotteryId,
				'num_type':sysConfig.wayId,
				'count':30,
				'begin_time':dt1,
				'end_time':dt2
			};

			for(p in param){
				if(param.hasOwnProperty(p)){
					arr.push(p + '=' + param[p]);
				}
			}
			return arr.join('&');
		},
		nsscchartRender:function(data, currentNum){

			var styleName = currentNum % this.getSeparateNum() == 0 ? ' border-bottom' : '';

			return this.getHtmlFragment(data, currentNum,styleName);
		},
		nsscchartRenderStatistics: function(data){
			// var me = this,
			//     index = 0,
			//     i = 0,
			//     len = 0,
			//     j = 0,
			//     len2 = 0,
			//     n = 0,
			//     tdstr = '<td class="ball-none border-right"></td><td class="ball-none"></td>',
			//     frame1 = [],
			//     frame2 = [],
			//     frame3 = [],
			//     frame4 = [];
			// frame1.push('<tr class="auxiliary-area"><td class="ball-none"></td><td class="border-bottom border-top">出现总次数</td><td class="ball-none border-right border-bottom"></td><td class="ball-none  border-bottom"></td><td class="border-bottom"></td><td class="ball-none border-right border-bottom"></td><td class="ball-none border-bottom"></td>');
			// frame2.push('<tr class="auxiliary-area"><td class="ball-none border-bottom"></td><td class="border-bottom">平均遗漏值</td><td class="ball-none border-right border-bottom"></td><td class="ball-none border-bottom"></td><td class="border-bottom"></td><td class="ball-none border-right border-bottom"></td><td class="ball-none border-bottom"></td>');
			// frame3.push('<tr class="auxiliary-area"><td class="ball-none border-bottom"></td><td class="border-bottom">最大遗漏值</td><td class="ball-none border-right border-bottom"></td><td class="ball-none border-bottom"></td><td class="border-bottom"></td><td class="ball-none border-right border-bottom"></td><td class="ball-none border-bottom"></td>');
			// frame4.push('<tr class="auxiliary-area"><td class="ball-none border-bottom"></td><td class="border-bottom">最大连出值</td><td class="ball-none border-right border-bottom"></td><td class="ball-none border-bottom"></td><td class="border-bottom"></td><td class="ball-none border-right border-bottom"></td><td class="ball-none border-bottom"></td>');


			// for(i = 0, len = 40; i < len; i++){
			//     tdstr = ((i+1)%10 == 0) ? '<td class="ball-none border-right border-bottom"></td><td class="ball-none border-bottom"></td>' : '';
			//     tdstr = (i == (len - 1)) ? '<td class="border-right border-bottom"></td>' : tdstr;

			//     frame1.push('<td class="border-bottom"><i class="ball-noraml">'+ data[0][i] +'</i></td>' + tdstr);
			//     frame2.push('<td class="border-bottom"><i class="ball-noraml">'+ data[1][i] +'</i></td>' + tdstr);
			//     frame3.push('<td class="border-bottom"><i class="ball-noraml">'+ data[2][i] +'</i></td>' + tdstr);
			//     frame4.push('<td class="border-bottom"><i class="ball-noraml">'+ data[3][i] +'</i></td>' + tdstr);
			// }

			// for(i = 0; i < 10; i++){
			//     //形态
			//     if(i > 3 && i < 7){
			//         frame1.push('<td class="border-bottom border-right"><i class="ball-noraml">'+ data[0][40 + i - 4] +'</i></td>');
			//         frame2.push('<td class="border-bottom border-right"><i class="ball-noraml">'+ data[1][40 + i - 4] +'</i></td>');
			//         frame3.push('<td class="border-bottom border-right"><i class="ball-noraml">'+ data[2][40 + i - 4] +'</i></td>');
			//         frame4.push('<td class="border-bottom border-right"><i class="ball-noraml">'+ data[3][40 + i - 4] +'</i></td>');
			//     }else{
			//         frame1.push('<td class="border-right border-bottom"></td>');
			//         frame2.push('<td class="border-right border-bottom"></td>');
			//         frame3.push('<td class="border-right border-bottom"></td>');
			//         frame4.push('<td class="border-right border-bottom"></td>');
			//     }
			// }

			// frame1.push('</tr>');
			// frame2.push('</tr>');
			// frame3.push('</tr>');
			// frame4.push('</tr>');
			// $(me.getBallContainer()).append($(frame1.join(''))).append($(frame2.join(''))).append($(frame3.join(''))).append($(frame4.join('')));
		},
		nsscchartTrendCanvas:function(dom, data){
			// var positionCount = 0,
			//     me = this,
			//     currentBallLeft = 0,
			//     currentBallTop = 0;

			//     var canvasPoint = $(".canvas-point");
			//     canvasPoint.each(function(j){
			//         if((j+1) < canvasPoint.length){
			//         var unitSize = me.getUnitSize($(this)),
			//             top = unitSize.topNum,
			//             left = unitSize.leftNum,
			//             width = unitSize.widthNum,
			//             height = unitSize.heightNum;


			//         var paramLeft = left + width / 2;
			//         var paramTop = top+height/2;

			//         var unitSize = me.getUnitSize(canvasPoint.eq(j+1)),
			//         top = unitSize.topNum,
			//         left = unitSize.leftNum,
			//         width = unitSize.widthNum,
			//         height = unitSize.heightNum;

			//         var forwardparamLeft = left + width / 2;
			//         var forwardparamTop = top+height/2;
			//         me.draw.line(paramTop, paramLeft, forwardparamTop, forwardparamLeft,width);

			//     }
			// });
			// positionCount = 0;
		},
		getHtmlFragment:function(data, currentNum, styleName){
			var html = '<tr>',                
				chartBalls = {}, // 统计号码球出现次数{'0': 0, 1': 0, '2': 0, '3': 0, '4': 0, '5': 0, '6': 0, ...};
				balls = [],
				hz = 0,
				sanqiuText = ['顺子','对子','半顺','杂六','豹子'];
			for(var x = 0; x < 10; x++){
				chartBalls[x] = 0;
			}             
			$.each(data, function(i,d){

				if( i == 2 || i == 8 ){
					html += '<td class="ball-none border-bottom"></td>';
				}
				// 添加第一球~第五球以及和值、龙虎和
				if( i == 11 ){
					var sumdx = '大', sumds = '双', lhh = '和';
					$.each(balls, function(idx, ball){
						var dx = '大', ds = '双';
						if( ball <= 4 ){
							dx = '小';
						}
						if( ball % 2 ){
							ds = '单';
						}
						hz += parseInt(this);
						html += '<td class="bg-red border-bottom border-right">' +ball+ '</td>';
						html += '<td class="bg-blue border-bottom border-right">' +dx+ds+ '</td>';
					});
					// 和值
					if( hz <= 22 ){
						sumdx = '小';
					}
					if( hz % 2 ){
						sumds = '单';
					}
					html += '<td class="bg-red border-bottom border-right">' +hz+ '</td>';
					html += '<td class="bg-blue border-bottom border-right">' +sumdx+sumds+ '</td>';
					// 龙虎和
					if( balls[0] > balls[4] ){
						lhh = '龙';
					}else if( balls[0] < balls[4] ){
						lhh = '虎';
					}
					html += '<td class="bg-green border-bottom border-right">' +lhh+ '</td>';
				}

				// 期号
				if( i == 0 ){
					html += '<td class="border-right border-bottom" colspan="3">' + d + '</td>';
				}
				// 开奖号码
				else if( i == 1 ){
					balls = d.split('');
					html += '<td class="border-right border-bottom" colspan="3">' +
								balls[0]+ ' ' + 
								balls[1]+ ' ' + 
								balls[2]+ ' ' + 
								balls[3]+ ' ' + 
								balls[4]+ ' ' + 
							'</td>';
					$.each(balls, function(){
						chartBalls[''+this] += 1;
					});
				}
				// 号码走势
				else if( i < 11 ){
					var ballnum = i - 2;
					if( d == 0 ){
						if( chartBalls[ballnum] > 1 ){
							html += '<td class="border-bottom"><i class="ball-noraml f-1"><i class="ball-mark">' + chartBalls[ballnum] + '</i>' + ballnum +'</i></td>';
						}else{
							html += '<td class="border-bottom"><i class="ball-noraml f-1">' + ballnum +'</i></td>';
						}
						// html += '<td class="border-bottom"><i class="ball-noraml f-1">' + theads[i] +'</i></td>';
					}else{
						html += '<td class="border-bottom"><i class="ball-noraml">' + d +'</i></td>';
					}
				}
				else if( i >= 12 ){                    
					html += '<td class="bg-blue border-bottom border-right">' +sanqiuText[d]+ '</td>';
				}

				if( i == 10 || i == 23 ){
					html += '<td class="ball-none border-right border-bottom"></td>';
				}
			});
			html += '</tr>';
			return $(html)[0];
		}
	}});

	CHART.addEvent('afterRenderChartHtml', function(){
		var me = this,tds = $(me.getContainer()).find('tr:last').children();
		tds.addClass('border-bottom');
	});
	CHART.show();
	CHART.sysConfig = sysConfig;

	//提交选球数据
	$('#J-form-submit').submit(function(e){
		var trs = $('#J-select-content').find('.select-area'),its,result = [],arrRow = [],arr = [],resultStr = '',
			cls = 'ball-orange',
			i = 0,
			len = 0;
		trs.each(function(k){
			arrRow = [];
			its = $(this).find('.ball-noraml');
			for(i = 0,len = its.length; i < len; i++){
				//arr[i] = its[i].className.indexOf(cls) != -1 ? 1 : 0;
				if(its[i].className.indexOf(cls) != -1){
					arr.push(i%10);
				}
				if((i+1) % 10 == 0){
					arrRow.push(arr.join(''));
					arr = [];
				}
			}
			if($.trim(arrRow.join('')) != ''){
				result.push(arrRow.join('-'));
			}
		});
		resultStr = result.join('_');
		$('#J-input-submit-value').val(resultStr);

		if(resultStr == ''){
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