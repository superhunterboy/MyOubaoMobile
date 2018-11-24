<!DOCTYPE HTML>
<html lang="en-US">
<head>
<meta charset="UTF-8">
<title>代理返点报表 -- CC彩票</title>
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
			<div class="title-normal">代理中心</div>
			<ul class="tab-title clearfix">
				<li><a href="agent-user-management.php"><span>用户管理</span></a></li>
				<li><a href="agent-account-link.php"><span>链接开户</span></a></li>
				<li><a href="agent-account-accurate.php"><span>精准开户</span></a></li>
				<li><a href="agent-link-management.php"><span>链接管理</span></a></li>
				<li class="current"><a href="agent-report-rebate.php"><span>代理报表</span></a></li>
			</ul>
		</div>
		
		<div class="content">
			<div class="filter-tabs" style="margin-bottom:10px;">
				<div class="filter-tabs-cont">
					<a class="current" href="agent-report-rebate.php">返点报表</a>
					<a href="agent-report-loss.php">盈亏报表</a>
					<a href="agent-report-dividend.php">分红报表</a>
				</div>
			</div>
			<div class="area-search">
				<div class="search-buttons">
					<button class="btn btn-important btn-search" type="submit"><span>搜索用户</span></button>
					<a class="reset-link" href=""><span>恢复默认项</span></a>
				</div>
				<div class="search-content">
					<p class="row">
						用户类型：<select id="J-select-user-groups" style="display:none;">
								  <option selected="selected" value="">全部用户</option>
								  <option value="1">代理</option>
								  <option value="2">玩家</option>
							</select>
						&nbsp;&nbsp;&nbsp;&nbsp;用户名：
						<input type="text" class="input w-2" />
					</p>
					<p class="row">
						查询日期：
						<input type="text" value="2014-06-10  00:00:00" class="input w-3" id="J-date-start">
					</p>
				</div>
			</div>
			<table width="100%" class="table">
				<thead>
					<tr>
						<th>用户名</th>
						<th>所属组</th>
						<th>日期</th>
						<th>有效投注金额（元）</th>
						<th>返点总额（元）</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>刘德华</td>
						<td>玩家</td>
						<td>2013-06-01</td>
						<td><dfn>￥</dfn><span data-money-format>88,888.00</span></td>
						<td><dfn>￥</dfn><span class="c-important" data-money-format>88,888.00</span></td>
					</tr>
					<tr>
						<td>刘德华</td>
						<td>玩家</td>
						<td>2013-06-01</td>
						<td><dfn>￥</dfn><span data-money-format>88,888.00</span></td>
						<td><dfn>￥</dfn><span class="c-important" data-money-format>88,888.00</span></td>
					</tr><tr>
						<td>刘德华</td>
						<td>玩家</td>
						<td>2013-06-01</td>
						<td><dfn>￥</dfn><span data-money-format>88,888.00</span></td>
						<td><dfn>￥</dfn><span class="c-important" data-money-format>88,888.00</span></td>
					</tr><tr>
						<td>刘德华</td>
						<td>玩家</td>
						<td>2013-06-01</td>
						<td><dfn>￥</dfn><span data-money-format>88,888.00</span></td>
						<td><dfn>￥</dfn><span class="c-important" data-money-format>88,888.00</span></td>
					</tr><tr>
						<td>刘德华</td>
						<td>玩家</td>
						<td>2013-06-01</td>
						<td><dfn>￥</dfn><span data-money-format>88,888.00</span></td>
						<td><dfn>￥</dfn><span class="c-important" data-money-format>88,888.00</span></td>
					</tr><tr>
						<td>刘德华</td>
						<td>玩家</td>
						<td>2013-06-01</td>
						<td><dfn>￥</dfn><span data-money-format>88,888.00</span></td>
						<td><dfn>￥</dfn><span class="c-important" data-money-format>88,888.00</span></td>
					</tr><tr>
						<td>刘德华</td>
						<td>玩家</td>
						<td>2013-06-01</td>
						<td><dfn>￥</dfn><span data-money-format>88,888.00</span></td>
						<td><dfn>￥</dfn><span class="c-important" data-money-format>88,888.00</span></td>
					</tr><tr>
						<td>刘德华</td>
						<td>玩家</td>
						<td>2013-06-01</td>
						<td><dfn>￥</dfn><span data-money-format>88,888.00</span></td>
						<td><dfn>￥</dfn><span class="c-important" data-money-format>88,888.00</span></td>
					</tr><tr>
						<td>刘德华</td>
						<td>玩家</td>
						<td>2013-06-01</td>
						<td><dfn>￥</dfn><span data-money-format>88,888.00</span></td>
						<td><dfn>￥</dfn><span class="c-important" data-money-format>88,888.00</span></td>
					</tr><tr>
						<td>刘德华</td>
						<td>玩家</td>
						<td>2013-06-01</td>
						<td><dfn>￥</dfn><span data-money-format>88,888.00</span></td>
						<td><dfn>￥</dfn><span class="c-important" data-money-format>88,888.00</span></td>
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
