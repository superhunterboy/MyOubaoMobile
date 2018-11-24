<!DOCTYPE HTML>
<html lang="en-US">
<head>
<meta charset="UTF-8">
<title>代理升降点报表 -- CC彩票</title>
<link type="text/css" rel="stylesheet" href="../images/global/global.css" />
<link type="text/css" rel="stylesheet" href="../images/ucenter/ucenter.css" />

<script type="text/javascript" src="../js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="../js/jquery.jscroll.js"></script>
<script type="text/javascript" src="../js/dsgame.base.js"></script>
<script type="text/javascript" src="../js/dsgame.Select.js"></script>
<script type="text/javascript" src="../js/dsgame.DatePicker.js"></script>

</head>

<body>

<?php include_once("../header.php"); ?>


<div class="g_33 main clearfix">
	<div class="main-sider">
		
	<?php include_once("../uc-sider.php"); ?>
		
		
	</div>
	<div class="main-content">
		
		<div class="nav-bg nav-bg-tab">
			<div class="title-normal">报表查询</div>
			<ul class="tab-title clearfix">
				<li><a href="agent-report-rebate.php"><span>代理返点报表</span></a></li>
				<li><a href="agent-report-loss.php"><span>代理盈亏报表</span></a></li>
				<li><a href="agent-report-dividend.php"><span>代理分红报表</span></a></li>
				<li class="current"><a href="agent-report-updown.php"><span>代理升降点报表</span></a></li>
			</ul>
		</div>
		
		<div class="content">
			<div class="area-search">
				<p class="row">
					查询日期：
					<input type="text" value="2014-06-10  00:00:00" class="input w-3" id="J-date-start">
					&nbsp;&nbsp;
					升降点类型：<select id="J-select-user-groups" style="display:none;">
							  <option selected="selected" value="">全部</option>
							  <option value="1">升点</option>
							  <option value="2">降点</option>
						</select>
					&nbsp;
					<input type="button" class="btn" value="搜 索" />
					&nbsp;
					<a href="#" target="_blank">报表下载</a>
				</p>
			</div>
			<table width="100%" class="table">
				<thead>
					<tr>
						<th>升降点日期</th>
						<th>升降点类型</th>
						<th>变化前奖金组</th>
						<th>变化后奖金组</th>
						<th>升降点要求销量</th>
						<th>当期销量</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>2014-9-1</td>
						<td>升点</td>
						<td>1957</td>
						<td>1958</td>
						<td>100,000.00</td>
						<td>100,000.00</td>
					</tr>
					<tr>
						<td>2014-9-1</td>
						<td>升点</td>
						<td>1957</td>
						<td>1958</td>
						<td>100,000.00</td>
						<td>100,000.00</td>
					</tr>
					<tr>
						<td>2014-9-1</td>
						<td>升点</td>
						<td>1957</td>
						<td>1958</td>
						<td>100,000.00</td>
						<td>100,000.00</td>
					</tr>
					<tr>
						<td>2014-9-1</td>
						<td>升点</td>
						<td>1957</td>
						<td>1958</td>
						<td>100,000.00</td>
						<td>100,000.00</td>
					</tr>
					<tr>
						<td>2014-9-1</td>
						<td>升点</td>
						<td>1957</td>
						<td>1958</td>
						<td>100,000.00</td>
						<td>100,000.00</td>
					</tr>
					<tr>
						<td>2014-9-1</td>
						<td>升点</td>
						<td>1957</td>
						<td>1958</td>
						<td>100,000.00</td>
						<td>100,000.00</td>
					</tr>
					<tr>
						<td>2014-9-1</td>
						<td>升点</td>
						<td>1957</td>
						<td>1958</td>
						<td>100,000.00</td>
						<td>100,000.00</td>
					</tr>
					<tr>
						<td>2014-9-1</td>
						<td>升点</td>
						<td>1957</td>
						<td>1958</td>
						<td>100,000.00</td>
						<td>100,000.00</td>
					</tr>
				</tbody>
			</table>
			
			
			
			<?php include_once("../pages.php"); ?>
		</div>
		
	</div>
</div>

<?php include_once("../footer.php"); ?>




<script>
(function($){
	new dsgame.Select({realDom:'#J-select-user-groups',cls:'w-2'});
	
	$('#J-date-start').focus(function(){
		(new dsgame.DatePicker({input:'#J-date-start',isShowTime:true, startYear:2013})).show();
	});
})(jQuery);
</script>



</body>
</html>
