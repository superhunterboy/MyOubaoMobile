<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<title>前二-时时彩-走势图</title>
	<link rel="stylesheet" href="../images/global/global.css" />
	<link rel="stylesheet" href="../images/chart/chart.css" />
	<script type="text/javascript" src="../js/jquery-1.9.1.min.js" ></script>
	<script type="text/javascript" src="../js/jquery.mousewheel.min.js" ></script>
	<script type="text/javascript" src="../js/dsgame.base.js" ></script>
	<!--[if IE]><script type="text/javascript" src="../js/excanvas.js"></script><![endif]-->
	<script type="text/javascript" src="../js/dsgame.Select.js" ></script>
	<script type="text/javascript" src="../js/dsgame.DatePicker.js" ></script>
	<script type="text/javascript" src="../js/game/dsgame.GameChart.js" ></script>
</head>
<body class="table-trend">


	<div class="header">
		<div class="header-inner">
			<ul>
				<li class="current"><a href="#">重庆时时彩</a></li>
				<li><a href="#">黑龙江时时彩</a></li>
				<li><a href="#">11选五</a></li>
			</ul>
		</div>
	</div>
	<div class="select-section">
		<div class="select-section-inner clearfix">
			<ul class="select-list">
				<li><a href="ssc_wuxing.php">五星</a></li>
				<li><a href="ssc_sixing.php">四星</a></li>
				
				<li><a href="ssc_qiansan.php">前三</a></li>
				<li><a href="ssc_housan.php">后三</a></li>
				
				<li class="current"><a href="ssc_qianer.php">前二</a></li>
				<li><a href="ssc_houer.php">后二</a></li>
			</ul>
			<div class="select-function">
				<i class="arrow-down"></i><a class="arrow-button" href="#" id="J-button-showcontrol">展开</a>
				<!-- <a target="_blank" id="report-download" class="select-download" href="http://www.ph158.com/reportDownload/gametype=cqssc?dataType=periods?dataNum=30">报表下载</a> -->
			</div>
		</div>
	</div>
	
	
	<div class="select-section-content clearfix" id="J-panel-control">
		<div class="select-section-content-inner">
			<div class="function">
				<label class="label"><input data-action="guides" type="checkbox" class="checkbox" checked="checked">辅助线</label>
				<label class="label"><input data-action="lost" type="checkbox" class="checkbox" checked="checked">遗漏</label>
				<label class="label"><input data-action="lost-post" type="checkbox" class="checkbox">遗漏条</label>
				<label class="label"><input data-action="trend" type="checkbox" class="checkbox" checked="checked">走势</label>
				<label class="label"><input data-action="temperature" type="checkbox" class="checkbox">号温</label>
			</div>
			<div class="time" id="J-periods-data">
				<select id="J-select-param-day">
					<option value="30">近30期</option>
					<option value="50">近50期</option>
					<option value="1">今日数据</option>
					<option value="2">近2天</option>
					<option value="5">近5天</option>
				</select>
				<!--
				<a data-action="periods-30" href="javascript:void(0);">近30期</a>
				<a data-action="periods-50" href="javascript:void(0);">近50期</a>
				<a data-action="day-1" href="javascript:void(0);">今日数据</a>
				<a data-action="day-2" href="javascript:void(0);">近2天</a>
				<a data-action="day-5" href="javascript:void(0);">近5天</a>
				-->
			</div>
			<div class="search">
				<input type="text" value="" id="J-date-star" class="input w-2"> 至 <input id="J-date-end" type="text" value="" class="input w-2">
				<a id="J-time-periods" class="btn" href="javascript:void(0);">搜索</a>
			</div>
		</div>
	</div>
	
	
	<!-- Star 五星 -->
	<div class="chart-section" id="J-chart-area">
		<table class="chart-table" id="J-chart-table">
			<thead class="thead">
				<tr class="title-text">
					<th rowspan="2" colspan="3" class="border-bottom border-right">期号</th>
					<th colspan="3" class="border-right">开奖号码</th>
					<th colspan="12" class="border-right">万位</th>
					<th colspan="12" class="border-right">千位</th>
					<th rowspan="2" class="border-bottom border-right td-bg">对子</th>
					<th colspan="12" class="border-right">号码分布</th>
					<th colspan="12" class="border-right">跨度走势</th>
					<th rowspan="2" class="border-bottom">和值</th>
				</tr>
				<tr class="title-number">
					<th class="ball-none border-bottom-header"></th>
					<th class="border-bottom-header"><label class="label"><input type="checkbox" class="checkbox">全部</label></th>
					<th class="ball-none border-bottom-header border-right"></th>
					<th class="ball-none border-bottom-header td-bg"></th>
					<th class="border-bottom-header td-bg"><i class="ball-noraml">0</i></th>
					<th class="border-bottom-header td-bg"><i class="ball-noraml">1</i></th>
					<th class="border-bottom-header td-bg"><i class="ball-noraml">2</i></th>
					<th class="border-bottom-header td-bg"><i class="ball-noraml">3</i></th>
					<th class="border-bottom-header td-bg"><i class="ball-noraml">4</i></th>
					<th class="border-bottom-header td-bg"><i class="ball-noraml">5</i></th>
					<th class="border-bottom-header td-bg"><i class="ball-noraml">6</i></th>
					<th class="border-bottom-header td-bg"><i class="ball-noraml">7</i></th>
					<th class="border-bottom-header td-bg"><i class="ball-noraml">8</i></th>
					<th class="border-bottom-header td-bg"><i class="ball-noraml">9</i></th>
					<th class="ball-none border-bottom-header border-right td-bg"></th>
					<th class="ball-none border-bottom-header td-bg"></th>
					<th class="border-bottom-header td-bg"><i class="ball-noraml">0</i></th>
					<th class="border-bottom-header td-bg"><i class="ball-noraml">1</i></th>
					<th class="border-bottom-header td-bg"><i class="ball-noraml">2</i></th>
					<th class="border-bottom-header td-bg"><i class="ball-noraml">3</i></th>
					<th class="border-bottom-header td-bg"><i class="ball-noraml">4</i></th>
					<th class="border-bottom-header td-bg"><i class="ball-noraml">5</i></th>
					<th class="border-bottom-header td-bg"><i class="ball-noraml">6</i></th>
					<th class="border-bottom-header td-bg"><i class="ball-noraml">7</i></th>
					<th class="border-bottom-header td-bg"><i class="ball-noraml">8</i></th>
					<th class="border-bottom-header td-bg"><i class="ball-noraml">9</i></th>
					<th class="ball-none border-bottom-header border-right td-bg"></th>
					<th class="ball-none border-bottom-header td-bg"></th>
					<th class="border-bottom-header td-bg"><i class="ball-noraml">0</i></th>
					<th class="border-bottom-header td-bg"><i class="ball-noraml">1</i></th>
					<th class="border-bottom-header td-bg"><i class="ball-noraml">2</i></th>
					<th class="border-bottom-header td-bg"><i class="ball-noraml">3</i></th>
					<th class="border-bottom-header td-bg"><i class="ball-noraml">4</i></th>
					<th class="border-bottom-header td-bg"><i class="ball-noraml">5</i></th>
					<th class="border-bottom-header td-bg"><i class="ball-noraml">6</i></th>
					<th class="border-bottom-header td-bg"><i class="ball-noraml">7</i></th>
					<th class="border-bottom-header td-bg"><i class="ball-noraml">8</i></th>
					<th class="border-bottom-header td-bg"><i class="ball-noraml">9</i></th>
					<th class="ball-none border-bottom-header border-right td-bg"></th>
					<th class="ball-none border-bottom-header td-bg"></th>
					<th class="border-bottom-header td-bg"><i class="ball-noraml">0</i></th>
					<th class="border-bottom-header td-bg"><i class="ball-noraml">1</i></th>
					<th class="border-bottom-header td-bg"><i class="ball-noraml">2</i></th>
					<th class="border-bottom-header td-bg"><i class="ball-noraml">3</i></th>
					<th class="border-bottom-header td-bg"><i class="ball-noraml">4</i></th>
					<th class="border-bottom-header td-bg"><i class="ball-noraml">5</i></th>
					<th class="border-bottom-header td-bg"><i class="ball-noraml">6</i></th>
					<th class="border-bottom-header td-bg"><i class="ball-noraml">7</i></th>
					<th class="border-bottom-header td-bg"><i class="ball-noraml">8</i></th>
					<th class="border-bottom-header td-bg"><i class="ball-noraml">9</i></th>
					<th class="ball-none border-bottom-header td-bg"></th>
				</tr>
			</thead>
			<tbody id="J-chart-content" class="chart table-guides tbody">
				<tr></tr>
			</tbody>
			
			
			<tbody id="J-ball-content" class="tbody">

			

			</tbody>
			
			<tbody class="tbody tbody-footer-header">
				<tr class="auxiliary-area title-number">
					<td rowspan="2" colspan="3" class="border-right border-bottom">期号</td>
					<td rowspan="2" colspan="3" class="border-right border-bottom" >开奖号码</td>
					<td class="ball-none border-bottom td-bg"></td>
					<td class="border-bottom td-bg"><i class="ball-noraml">0</i></td>
					<td class="border-bottom td-bg"><i class="ball-noraml">1</i></td>
					<td class="border-bottom td-bg"><i class="ball-noraml">2</i></td>
					<td class="border-bottom td-bg"><i class="ball-noraml">3</i></td>
					<td class="border-bottom td-bg"><i class="ball-noraml">4</i></td>
					<td class="border-bottom td-bg"><i class="ball-noraml">5</i></td>
					<td class="border-bottom td-bg"><i class="ball-noraml">6</i></td>
					<td class="border-bottom td-bg"><i class="ball-noraml">7</i></td>
					<td class="border-bottom td-bg"><i class="ball-noraml">8</i></td>
					<td class="border-bottom td-bg"><i class="ball-noraml">9</i></td>
					<td class="ball-none border-right border-bottom td-bg"></td>
					<td class="ball-none border-bottom td-bg"></td>
					<td class="border-bottom td-bg"><i class="ball-noraml">0</i></td>
					<td class="border-bottom td-bg"><i class="ball-noraml">1</i></td>
					<td class="border-bottom td-bg"><i class="ball-noraml">2</i></td>
					<td class="border-bottom td-bg"><i class="ball-noraml">3</i></td>
					<td class="border-bottom td-bg"><i class="ball-noraml">4</i></td>
					<td class="border-bottom td-bg"><i class="ball-noraml">5</i></td>
					<td class="border-bottom td-bg"><i class="ball-noraml">6</i></td>
					<td class="border-bottom td-bg"><i class="ball-noraml">7</i></td>
					<td class="border-bottom td-bg"><i class="ball-noraml">8</i></td>
					<td class="border-bottom td-bg"><i class="ball-noraml">9</i></td>
					<td class="ball-none border-right border-bottom td-bg"></td>
					<td class="border-right border-bottom td-bg"></td>
					<td class="ball-none border-bottom td-bg"></td>
					<td class="border-bottom td-bg"><i class="ball-noraml">0</i></td>
					<td class="border-bottom td-bg"><i class="ball-noraml">1</i></td>
					<td class="border-bottom td-bg"><i class="ball-noraml">2</i></td>
					<td class="border-bottom td-bg"><i class="ball-noraml">3</i></td>
					<td class="border-bottom td-bg"><i class="ball-noraml">4</i></td>
					<td class="border-bottom td-bg"><i class="ball-noraml">5</i></td>
					<td class="border-bottom td-bg"><i class="ball-noraml">6</i></td>
					<td class="border-bottom td-bg"><i class="ball-noraml">7</i></td>
					<td class="border-bottom td-bg"><i class="ball-noraml">8</i></td>
					<td class="border-bottom td-bg"><i class="ball-noraml">9</i></td>
					<td class="ball-none border-right border-bottom td-bg"></td>
					<td class="ball-none border-bottom td-bg"></td>
					<td class="border-bottom td-bg"><i class="ball-noraml">0</i></td>
					<td class="border-bottom td-bg"><i class="ball-noraml">1</i></td>
					<td class="border-bottom td-bg"><i class="ball-noraml">2</i></td>
					<td class="border-bottom td-bg"><i class="ball-noraml">3</i></td>
					<td class="border-bottom td-bg"><i class="ball-noraml">4</i></td>
					<td class="border-bottom td-bg"><i class="ball-noraml">5</i></td>
					<td class="border-bottom td-bg"><i class="ball-noraml">6</i></td>
					<td class="border-bottom td-bg"><i class="ball-noraml">7</i></td>
					<td class="border-bottom td-bg"><i class="ball-noraml">8</i></td>
					<td class="border-bottom td-bg"><i class="ball-noraml">9</i></td>
					<td class="ball-none border-right border-bottom td-bg"></td>
					<td class="border-bottom" rowspan="2">和值</td>
					
				</tr>
				<tr class="auxiliary-area title-text">
					<td colspan="12" class="border-right border-bottom">万位</td>
					<td colspan="12" class="border-right border-bottom">千位</td>
					<td class="border-right border-bottom">对子</td>
					<td colspan="12" class="border-right border-bottom">号码分布</td>
					<td colspan="12" class="border-right border-bottom">跨度</td>
				</tr>
			
			</tbody>
			

		</table>
		
		
	</div>
	<!-- End 五星 -->

<?php include_once("game-tips.php"); ?>

<?php include_once("../footer.php"); ?>

<script>

var CHART;
(function($){
	CHART = new dsgame.GameCharts({currentGameType:'cqssc', getDataUrl: '../js/json/ssc_qianer.php', currentGameMethod: 'Qianer', expands:{
		cqsscQianerRender:function(data, currentNum){
			var td,
				current,
				me = this,
				i = 0,
				len = 0,
				styleName = currentNum % me.getSeparateNum() == 0 ? ' border-bottom' : '',
				htmlTextArr = new Array(),
				allowCount = me.getRenderLength(),
				parentDom = document.createElement('tr');
			
			td = document.createElement('td');
			td.className = "ball-none " + styleName;
			parentDom.appendChild(td);

			//期号
			td = document.createElement('td');
			td.className = "issue-numbers " + styleName;
			td.innerHTML = data[0];
			parentDom.appendChild(td);

			td = document.createElement('td');
			td.className = "ball-none border-right" + styleName;
			parentDom.appendChild(td);

			td = document.createElement('td');
			td.className = "ball-none " + styleName;
			parentDom.appendChild(td);

			//开奖号码
			td = document.createElement('td');
			td.className = styleName;
			td.innerHTML = '<span class="lottery-numbers">' + data[1] + '</span>';
			parentDom.appendChild(td);

			td = document.createElement('td');
			td.className = 'ball-none border-right' + styleName;
			parentDom.appendChild(td);
			
			
			//万位
			parentDom.appendChild(me.singleLotteryBall(data[2], styleName));
			//千位
			parentDom.appendChild(me.singleLotteryBall(data[3], styleName));
			
			
			
			
			//对子
			td = document.createElement('td');
			td.className = 'border-right ' + styleName;
			td.innerHTML = data[4] == 0 ? '<i class="group-current"></i>' : data[4];
			parentDom.appendChild(td);
			
			
			//号码分布
			parentDom.appendChild(me.layoutLotteryBall(data[5], styleName));
			
			td = document.createElement('td');
			td.className = "ball-none border-right " + styleName;
			parentDom.appendChild(td);
			
			
			//跨度走势
			td = document.createElement('td');
			td.className = "ball-none " + styleName;	
			parentDom.appendChild(td);
			for(i = 0,len = 10; i < len; i++){
				if(data[6][i][0] == 0){
					td = document.createElement('td');
					td.className = "bg-blue " + styleName;
					td.innerHTML = '<i class="ball-noraml">'+ data[6][i][1] +'</i>';
					parentDom.appendChild(td);
				}else{
					td = document.createElement('td');
					td.className = "omission " + styleName;
					td.innerHTML = data[6][i][0];
					parentDom.appendChild(td);
				}
			}
			
			td = document.createElement('td');
			td.className = "ball-none border-right " + styleName;
			parentDom.appendChild(td);
			
			
			//和值
			td = document.createElement('td');
			td.className = styleName;
			td.innerHTML = data[7];
			parentDom.appendChild(td);
			

			//返回完整的单行TR结构
			return parentDom;
		},
		cqsscQianerRenderStatistics: function(data){
			var me = this,
				index = 0,
				i = 0,
				len = 0,
				j = 0,
				len2 = 0,
				n = 0,
				tdstr = '<td class="ball-none border-right"></td><td class="ball-none"></td>',
				frame1 = [],
				frame2 = [],
				frame3 = [],
				frame4 = [];
			frame1.push('<tr class="auxiliary-area"><td class="ball-none"></td><td class="border-bottom border-top">出现总次数</td><td class="ball-none border-right border-bottom"></td><td class="ball-none  border-bottom"></td><td class="border-bottom"></td><td class="ball-none border-right border-bottom"></td><td class="ball-none border-bottom"></td>');
			frame2.push('<tr class="auxiliary-area"><td class="ball-none border-bottom"></td><td class="border-bottom">平均遗漏值</td><td class="ball-none border-right border-bottom"></td><td class="ball-none border-bottom"></td><td class="border-bottom"></td><td class="ball-none border-right border-bottom"></td><td class="ball-none border-bottom"></td>');
			frame3.push('<tr class="auxiliary-area"><td class="ball-none border-bottom"></td><td class="border-bottom">最大遗漏值</td><td class="ball-none border-right border-bottom"></td><td class="ball-none border-bottom"></td><td class="border-bottom"></td><td class="ball-none border-right border-bottom"></td><td class="ball-none border-bottom"></td>');
			frame4.push('<tr class="auxiliary-area"><td class="ball-none border-bottom"></td><td class="border-bottom">最大连出值</td><td class="ball-none border-right border-bottom"></td><td class="ball-none border-bottom"></td><td class="border-bottom"></td><td class="ball-none border-right border-bottom"></td><td class="ball-none border-bottom"></td>');
			
			
			for(i = 0, len = 20; i < len; i++){
				tdstr = ((i+1)%10 == 0) ? '<td class="ball-none border-right border-bottom"></td><td class="ball-none border-bottom"></td>' : '';
				tdstr = (i == (len - 1)) ? '<td class="border-right border-bottom"></td>' : tdstr;

				frame1.push('<td class="border-bottom"><i class="ball-noraml">'+ data[0][i] +'</i></td>' + tdstr);
				frame2.push('<td class="border-bottom"><i class="ball-noraml">'+ data[1][i] +'</i></td>' + tdstr);
				frame3.push('<td class="border-bottom"><i class="ball-noraml">'+ data[2][i] +'</i></td>' + tdstr);
				frame4.push('<td class="border-bottom"><i class="ball-noraml">'+ data[3][i] +'</i></td>' + tdstr);
			}
			
			
			frame1.push('<td class="border-bottom border-right"><i class="ball-noraml">'+ data[0][20] +'</i></td><td class="border-bottom"></td>');
			frame2.push('<td class="border-bottom border-right"><i class="ball-noraml">'+ data[1][20] +'</i></td><td class="border-bottom"></td>');
			frame3.push('<td class="border-bottom border-right"><i class="ball-noraml">'+ data[2][20] +'</i></td><td class="border-bottom"></td>');
			frame4.push('<td class="border-bottom border-right"><i class="ball-noraml">'+ data[3][20] +'</i></td><td class="border-bottom"></td>');
				
			
			for(i = 0, len = 20; i < len; i++){
				tdstr = ((i+1)%10 == 0) ? '<td class="ball-none border-right border-bottom"></td><td class="ball-none border-bottom"></td>' : '';
				tdstr = (i == (len - 1)) ? '<td class="border-right border-bottom"></td>' : tdstr;

				frame1.push('<td class="border-bottom"><i class="ball-noraml">'+ data[0][i + 21] +'</i></td>' + tdstr);
				frame2.push('<td class="border-bottom"><i class="ball-noraml">'+ data[1][i + 21] +'</i></td>' + tdstr);
				frame3.push('<td class="border-bottom"><i class="ball-noraml">'+ data[2][i + 21] +'</i></td>' + tdstr);
				frame4.push('<td class="border-bottom"><i class="ball-noraml">'+ data[3][i + 21] +'</i></td>' + tdstr);
			}
			
			
			frame1.push('<td class="border-bottom border-right"></td>');
			frame2.push('<td class="border-bottom border-right"></td>');
			frame3.push('<td class="border-bottom border-right"></td>');
			frame4.push('<td class="border-bottom border-right"></td>');
			

			frame1.push('</tr>');
			frame2.push('</tr>');
			frame3.push('</tr>');
			frame4.push('</tr>');
			$(me.getBallContainer()).append($(frame1.join(''))).append($(frame2.join(''))).append($(frame3.join(''))).append($(frame4.join('')));
		},
		cqsscQianerTrendCanvas:function(dom, data){
			var positionCount = 0,
				me = this,
				currentBallLeft = 0,
				currentBallTop = 0,
				chartTrendPosition = me.getChartTrendPosition();


			//遍历分段渲染数据
			for (var i = 0, current; i < data.length; i++) {
				current = data[i];

				for (var k = 0; k < current.length; k++) {
					//选球区域
					if (k > 1 && k < 5) {
						for (var j = 0; j < current[k].length; j++) {
						
							if(j == 0)	{
								var currentDom = dom.getElementsByTagName('i')[positionCount].parentNode,
									unitSize = me.getUnitSize(currentDom),
									top = unitSize.topNum,
									left = unitSize.leftNum,
									width = unitSize.widthNum,
									height = unitSize.heightNum;
							}

							//当前位置球
							positionCount ++;

							//当前号码
							if (current[k][j][0] == 0) {
								//第一排渲染
								if (typeof chartTrendPosition[k] == 'undefined') {

									//当前球的坐标
									currentBallLeft = left + (j + 1) * width - width / 2;
									currentBallTop = top + height / 2;

									chartTrendPosition[k] = {};
									chartTrendPosition[k]['top'] = currentBallTop;
									chartTrendPosition[k]['left'] = currentBallLeft;
								} else {

									//当前球的坐标
									currentBallLeft = left + (j + 1) * width - width / 2;
									currentBallTop = chartTrendPosition[k]['top'] + height;

									//绘制画布
									//绘制走势图线
									me.draw.setOption({
										parentContainer: $('#J-chart-area')[0]
									});
									me.draw.line(chartTrendPosition[k]['top'], chartTrendPosition[k]['left'], currentBallTop, currentBallLeft);

									chartTrendPosition[k]['top'] = currentBallTop;
									chartTrendPosition[k]['left'] = currentBallLeft;
								}
							}
						};
					}
				};

				positionCount = 0;
			};
		}
	}});
	CHART.addEvent('afterRenderChartHtml', function(){
		var me = this,tds = $(me.getContainer()).find('tr:last').children();
		tds.addClass('border-bottom');
	});
	CHART.show();
	
	
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
	
	var selectParam = new dsgame.Select({
		realDom:'#J-select-param-day',
		cls:'w-2'
	});
	
})(jQuery);

</script>
<script type="text/javascript" src="../js/game/dsgame.GameChart.case.js"></script>

</body>
</html>