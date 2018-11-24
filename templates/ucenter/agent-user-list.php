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
			<div class="title-normal">用户管理</div>
			<ul class="tab-title clearfix">
				<li class="current"><a href="agent-user-management.php"><span>用户管理</span></a></li>
				<li><a href="agent-link-management.php"><span>开户链接管理</span></a></li>
			</ul>
			<a id="J-button-goback" class="button-goback" href="#">返回</a>
		</div>
		
		<div class="content">
			<div class="area-search">
				<p class="row">
					用户类型：<select id="J-select-user-groups" style="display:none;">
							  <option selected="selected" value="">全部用户</option>
							  <option value="1">代理</option>
							  <option value="2">玩家</option>
						</select>
					&nbsp;
					用户名：<input class="input w-2" type="text" value="" />
					&nbsp;&nbsp;
					用户余额：<input class="input w-1" type="text" value="" /> - <input class="input w-1" type="text" value="" /> 元
					&nbsp;&nbsp;
					<input class="btn" type="button" value=" 搜 索 " />
				</p>
			</div>

			<div class="breadcrumb">
				<a href="http://u.d.com/users">testop</a>
				<a href="http://u.d.com/users">testop</a>
			</div>
			
			<table width="100%" class="table table-toggle">
				<thead>
					<tr>
						<th><a href="#">用户名<i class="ico-up-down"></i></a></th>
						<th><a href="#">所属用户组</a></th>
						<th><a href="#">下级人数<i class="ico-up-current"></i></a></th>
						<th><a href="#">团队余额<i class="ico-down-current"></i></a></th>
						<th>操作</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><a href="#">个梵蒂冈和吃蛋黄</a></td>
						<td>代理</td>
						<td>0</td>
						<td>0.00</td>
						<td>
							<a href="#">账变列表</a>
						</td>
					</tr>
					<tr>
						<td><a href="#">个梵蒂冈和吃蛋黄</a></td>
						<td>代理</td>
						<td><a href="#">10</a></td>
						<td>0.00</td>
						<td>
							<a href="#">账变列表</a>
						</td>
					</tr>
					<tr>
						<td><a href="#">个梵蒂冈和吃蛋黄</a></td>
						<td>代理</td>
						<td>0</td>
						<td>0.00</td>
						<td>
							<a href="#">账变列表</a>
						</td>
					</tr>
					<tr>
						<td><a href="#">个梵蒂冈和吃蛋黄</a></td>
						<td>代理</td>
						<td><a href="#">10</a></td>
						<td>0.00</td>
						<td>
							<a href="#">账变列表</a>
						</td>
					</tr>
					<tr>
						<td><a href="#">个梵蒂冈和吃蛋黄</a></td>
						<td>代理</td>
						<td>0</td>
						<td>0.00</td>
						<td>
							<a href="#">账变列表</a>
						</td>
					</tr>
					<tr>
						<td><a href="#">个梵蒂冈和吃蛋黄</a></td>
						<td>代理</td>
						<td><a href="#">10</a></td>
						<td>0.00</td>
						<td>
							<a href="#">账变列表</a>
						</td>
					</tr>
					<tr>
						<td><a href="#">个梵蒂冈和吃蛋黄</a></td>
						<td>代理</td>
						<td>0</td>
						<td>0.00</td>
						<td>
							<a href="#">账变列表</a>
						</td>
					</tr>
					<tr>
						<td><a href="#">个梵蒂冈和吃蛋黄</a></td>
						<td>代理</td>
						<td><a href="#">10</a></td>
						<td>0.00</td>
						<td>
							<a href="#">账变列表</a>
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

	new dsgame.Select({realDom:'#J-select-user-groups',cls:'w-2'});
	
	$('#J-button-goback').click(function(e){
		history.back(-1);
		e.preventDefault();
	});

	
})(jQuery);
</script>


</body>
</html>
