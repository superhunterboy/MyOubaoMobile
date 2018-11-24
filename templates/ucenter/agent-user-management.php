<!DOCTYPE HTML>
<html lang="en-US">
<head>
<meta charset="UTF-8">
<title>用户管理 -- CC彩票</title>
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
				<li class="current"><a href="agent-user-management.php"><span>用户管理</span></a></li>
				<li><a href="agent-account-link.php"><span>链接开户</span></a></li>
				<li><a href="agent-account-accurate.php"><span>精准开户</span></a></li>
				<li><a href="agent-link-management.php"><span>链接管理</span></a></li>
				<li><a href="agent-report-rebate.php"><span>代理报表</span></a></li>
			</ul>
		</div>
		
		<div class="content">
			<div class="area-search">
				<div class="search-buttons">
					<button class="btn btn-important btn-search" type="submit"><span>查 询</span></button>
					<a class="reset-link" href=""><span>恢复默认项</span></a>
				</div>
				<div class="search-content">
					<div class="row">
						<div class="filter-tabs filter-tabs-normal">
							<span class="filter-tabs-title">用户类型</span>
							<div class="filter-tabs-cont">
								<a href="" class="current">全部用户</a>
								<a href="">代理</a>
								<a href="">玩家</a>
							</div>
						</div>
					</div>
					<div class="row">
						&nbsp;&nbsp;用户名：<input class="input w-2" type="text" value="" />
						&nbsp;&nbsp;
						用户余额：<input class="input w-1" type="text" value="" /> - <input class="input w-1" type="text" value="" /> 元
					</div>
				</div>
			</div>
			
			<table width="100%" class="table table-toggle">
				<thead>
					<tr>
						<th><a href="#">用户账号<i class="ico-up-down"></i></a></th>
						<th><a href="#">用户类型</a></th>
						<th><a href="#">下级人数<i class="ico-up-current"></i></a></th>
						<th><a href="#">团队余额（元）<i class="ico-down-current"></i></a></th>
						<th>操作</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><a href="#">个梵蒂冈和吃蛋黄</a></td>
						<td>代理</td>
						<td>0</td>
						<td>￥<span class="c-important" data-money-format>2,600.00</span></td>
						<td>
							<a class="ui-action-adjust" href="#">调整奖金组</a>
							<a class="ui-action-check" href="#">查看账变</a>
						</td>
					</tr>
					<tr>
						<td><a href="#">个梵蒂冈和吃蛋黄</a></td>
						<td>代理</td>
						<td><a href="agent-user-list.php">10</a></td>
						<td>￥<span class="c-important" data-money-format>2,600.00</span></td>
						<td>
							<a class="ui-action-adjust" href="#">调整奖金组</a>
							<a class="ui-action-check" href="#">查看账变</a>
						</td>
					</tr>
					<tr>
						<td><a href="#">个梵蒂冈和吃蛋黄</a></td>
						<td>代理</td>
						<td>0</td>
						<td>￥<span class="c-important" data-money-format>2,600.00</span></td>
						<td>
							<a class="ui-action-adjust" href="#">调整奖金组</a>
							<a class="ui-action-check" href="#">查看账变</a>
						</td>
					</tr>
					<tr>
						<td><a href="#">个梵蒂冈和吃蛋黄</a></td>
						<td>代理</td>
						<td><a href="#">10</a></td>
						<td>￥<span class="c-important" data-money-format>2,600.00</span></td>
						<td>
							<a class="ui-action-adjust" href="#">调整奖金组</a>
							<a class="ui-action-check" href="#">查看账变</a>
						</td>
					</tr>
					<tr>
						<td><a href="#">个梵蒂冈和吃蛋黄</a></td>
						<td>代理</td>
						<td>0</td>
						<td>￥<span class="c-important" data-money-format>2,600.00</span></td>
						<td>
							<a class="ui-action-adjust" href="#">调整奖金组</a>
							<a class="ui-action-check" href="#">查看账变</a>
						</td>
					</tr>
					<tr>
						<td><a href="#">个梵蒂冈和吃蛋黄</a></td>
						<td>代理</td>
						<td><a href="#">10</a></td>
						<td>￥<span class="c-important" data-money-format>2,600.00</span></td>
						<td>
							<a class="ui-action-adjust" href="#">调整奖金组</a>
							<a class="ui-action-check" href="#">查看账变</a>
						</td>
					</tr>
					<tr>
						<td><a href="#">个梵蒂冈和吃蛋黄</a></td>
						<td>代理</td>
						<td>0</td>
						<td>￥<span class="c-important" data-money-format>2,600.00</span></td>
						<td>
							<a class="ui-action-adjust" href="#">调整奖金组</a>
							<a class="ui-action-check" href="#">查看账变</a>
						</td>
					</tr>
					<tr>
						<td><a href="#">个梵蒂冈和吃蛋黄</a></td>
						<td>代理</td>
						<td><a href="#">10</a></td>
						<td>￥<span class="c-important" data-money-format>2,600.00</span></td>
						<td>
							<a class="ui-action-adjust" href="#">调整奖金组</a>
							<a class="ui-action-check" href="#">查看账变</a>
						</td>
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

	// new dsgame.Select({realDom:'#J-select-user-groups',cls:'w-2'});
	
})(jQuery);
</script>



</body>
</html>
