<!DOCTYPE HTML>
<html lang="en-US">
<head>
<meta charset="UTF-8">
<title>追号记录 -- CC彩票</title>
<link type="text/css" rel="stylesheet" href="../images/global/global.css" />
<link type="text/css" rel="stylesheet" href="../images/ucenter/ucenter.css" />

<script type="text/javascript" src="../js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="../js/jquery.easing.1.3.js"></script>
<script type="text/javascript" src="../js/jquery.mousewheel.min.js"></script>
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
			<div class="title-normal">
				追号记录
			</div>
			<ul class="tab-title clearfix">
				<li><a href="records-game.php"><span>游戏记录</span></a></li>
				<li class="current"><a href="records-trace.php"><span>追号记录</span></a></li>
			</ul>
		</div>

		<div class="content">
			<div class="area-search">
				<div class="search-head">
					<p class="row">
						<span class="row-desc">最近一周总奖金<span class="c-red" data-money-format>628,000.00</span>元</span>
						<span class="row-desc">最近一周投注总金额<span class="c-green" data-money-format>2,500.00</span>元</span>
						<select id="J-select-period" style="display:none;">
							<option value="weekly">最近一周</option>
							<option value="month">最近一月</option>
						</select>
					</p>
				</div>
				<div class="search-buttons">
					<button class="btn btn-important btn-search" type="submit"><span>查 询</span></button>
					<a class="reset-link" href=""><span>恢复默认项</span></a>
				</div>
				<div class="search-content">
					<div class="row">
						<div class="filter-tabs">
							<span class="filter-tabs-title">状态</span>
							<div class="filter-tabs-cont">
								<a href="" class="current">全部</a>
								<a href="">已中奖</a>
								<a href="">未中奖</a>
								<a href="">待开奖</a>
							</div>
						</div>
						游戏：<select id="J-select-game-type" style="display:none;">
								<option value="0" selected="selected">所有游戏</option>
								<option value="1">重庆时时彩</option>
								<option value="2">江西时时彩</option>
								<option value="3">黑龙江时时彩</option>
								<option value="4">新疆时时彩</option>
								<option value="5">上海时时乐</option>
								<option value="6">乐利时时彩</option>
								<option value="7">天津时时彩</option>
								<option value="8">吉利分分彩</option>
								<option value="9">顺利秒秒彩</option>
							</select>
						&nbsp;&nbsp;
						游戏时间：<input id="J-date-start" class="input w-2" type="text" value="2014-06-10  00:00:00" /> 至 <input id="J-date-end" class="input w-2" type="text" value="2014-06-11  00:00:00" />
					</div>
					<p class="row">
						期号：<input class="input w-2" type="text" value=""/>
						&nbsp;&nbsp;
						注单编号：<input class="input w-2" type="text" value=""/>
					</p>
					<p class="row" style="display:none;">
						<select id="J-select-issue" style="display:none;">
							<option value="1">注单编号</option>
							<option value="2">奖期编号</option>
						</select>
						<input class="input w-3" type="text" value="" />
					</p>
					<p class="row" style="display:none;">
						游戏名称：<select id="J-select-game-type" style="display:none;">
								<option value="0" selected="selected">所有游戏</option>
								<option value="1">重庆时时彩</option>
								<option value="2">江西时时彩</option>
								<option value="3">黑龙江时时彩</option>
								<option value="4">新疆时时彩</option>
								<option value="5">上海时时乐</option>
								<option value="6">乐利时时彩</option>
								<option value="7">天津时时彩</option>
								<option value="8">吉利分分彩</option>
								<option value="9">顺利秒秒彩</option>
							</select>
						&nbsp;&nbsp;
						玩法群：
							<select id="J-select-method-group" style="display:none;">
								<option value="0" selected="selected">所有玩法群</option>
							</select>
						&nbsp;&nbsp;
						玩法：
							<select id="J-select-method" style="display:none;">
								<option value="0" selected="selected">所有玩法</option>
							</select>
					</p>
					<p class="row" style="display:none;">
						游戏用户：<input class="input w-3" type="text" value="">
					</p>
				</div>
			</div>

			<table width="100%" class="table" id="J-table">
				<thead>
					<tr>
						<th>订单编号</th>
						<th>游戏与玩法</th>
						<th>追号信息</th>
						<th>追号金额（元）</th>
						<th>中奖即停</th>
						<th>状态</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><a href="records-game-detail.php">D140523034VFBCBIIJAB</a></td>
						<td>
							<span class="c-important">重庆时时彩</span><br/>
							<span>后三一码不定位</span>
						</td>
						<td>
							<span class="cell-label">期号</span>141211060<br/>
							<span class="cell-label">追号</span>1/10	期
						</td>
						<td>
							<span class="c-important">总金额</span><dfn>￥</dfn><span class="c-important" data-money-format>30.0000</span><br/>
							<span>已完成</span><dfn>￥</dfn><span data-money-format>30.0000</span><br/>
							<span class="c-gray">已取消</span><dfn>￥</dfn><span class="c-gray" data-money-format>30.0000</span>
						</td>
						<td><span class="ui-status-no">终止</span></td>
						<td><span class="status-wait">已完成</span></td>
					</tr>
					<tr>
						<td><a href="records-game-detail.php">D140523034VFBCBIIJAB</a></td>
						<td>
							<span class="c-important">重庆时时彩</span><br/>
							<span>后三一码不定位</span>
						</td>
						<td>
							<span class="cell-label">期号</span>141211060<br/>
							<span class="cell-label">追号</span>1/10	期
						</td>
						<td>
							<span class="c-important">总金额</span><dfn>￥</dfn><span class="c-important" data-money-format>30.0000</span><br/>
							<span>已完成</span><dfn>￥</dfn><span data-money-format>30.0000</span><br/>
							<span class="c-gray">已取消</span><dfn>￥</dfn><span class="c-gray" data-money-format>30.0000</span>
						</td>
						<td><span class="ui-status-okay">继续</span></td>
						<td><span class="status-wait">未完成</span></td>
					</tr>
					<tr>
						<td><a href="records-game-detail.php">D140523034VFBCBIIJAB</a></td>
						<td>
							<span class="c-important">重庆时时彩</span><br/>
							<span>后三一码不定位</span>
						</td>
						<td>
							<span class="cell-label">期号</span>141211060<br/>
							<span class="cell-label">追号</span>1/10	期
						</td>
						<td>
							<span class="c-important">总金额</span><dfn>￥</dfn><span class="c-important" data-money-format>30.0000</span><br/>
							<span>已完成</span><dfn>￥</dfn><span data-money-format>30.0000</span><br/>
							<span class="c-gray">已取消</span><dfn>￥</dfn><span class="c-gray" data-money-format>30.0000</span>
						</td>
						<td><span class="ui-status-no">终止</span></td>
						<td><span class="status-wait">未完成</span></td>
					</tr>
					<tr>
						<td><a href="records-game-detail.php">D140523034VFBCBIIJAB</a></td>
						<td>
							<span class="c-important">重庆时时彩</span><br/>
							<span>后三一码不定位</span>
						</td>
						<td>
							<span class="cell-label">期号</span>141211060<br/>
							<span class="cell-label">追号</span>1/10	期
						</td>
						<td>
							<span class="c-important">总金额</span><dfn>￥</dfn><span class="c-important" data-money-format>30.0000</span><br/>
							<span>已完成</span><dfn>￥</dfn><span data-money-format>30.0000</span><br/>
							<span class="c-gray">已取消</span><dfn>￥</dfn><span class="c-gray" data-money-format>30.0000</span>
						</td>
						<td><span class="ui-status-no">终止</span></td>
						<td><span class="status-wait">未完成</span></td>
					</tr>
					<tr>
						<td><a href="records-game-detail.php">D140523034VFBCBIIJAB</a></td>
						<td>
							<span class="c-important">重庆时时彩</span><br/>
							<span>后三一码不定位</span>
						</td>
						<td>
							<span class="cell-label">期号</span>141211060<br/>
							<span class="cell-label">追号</span>1/10	期
						</td>
						<td>
							<span class="c-important">总金额</span><dfn>￥</dfn><span class="c-important" data-money-format>30.0000</span><br/>
							<span>已完成</span><dfn>￥</dfn><span data-money-format>30.0000</span><br/>
							<span class="c-gray">已取消</span><dfn>￥</dfn><span class="c-gray" data-money-format>30.0000</span>
						</td>
						<td><span class="ui-status-no">终止</span></td>
						<td><span class="status-wait">未完成</span></td>
					</tr>
					<tr>
						<td><a href="records-game-detail.php">D140523034VFBCBIIJAB</a></td>
						<td>
							<span class="c-important">重庆时时彩</span><br/>
							<span>后三一码不定位</span>
						</td>
						<td>
							<span class="cell-label">期号</span>141211060<br/>
							<span class="cell-label">追号</span>1/10	期
						</td>
						<td>
							<span class="c-important">总金额</span><dfn>￥</dfn><span class="c-important" data-money-format>30.0000</span><br/>
							<span>已完成</span><dfn>￥</dfn><span data-money-format>30.0000</span><br/>
							<span class="c-gray">已取消</span><dfn>￥</dfn><span class="c-gray" data-money-format>30.0000</span>
						</td>
						<td><span class="ui-status-no">终止</span></td>
						<td><span class="status-wait">未完成</span></td>
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
	var table = $('#J-table'),
		selectPeriod = new dsgame.Select({realDom:'#J-select-period',cls:'w-2'}),
		selectGameType = new dsgame.Select({realDom:'#J-select-game-type',cls:'w-2'}),
		selectMethodGroup = new dsgame.Select({realDom:'#J-select-method-group',cls:'w-2'}),
		selectMethod = new dsgame.Select({realDom:'#J-select-method',cls:'w-2'}),
		selectIssue = new dsgame.Select({realDom:'#J-select-issue',cls:'w-2'}),
		loadMethodgroup,
		loadMethod;

	$('#J-date-start').focus(function(){
		(new dsgame.DatePicker({input:'#J-date-start',isShowTime:true, startYear:2013})).show();
	});
	$('#J-date-end').focus(function(){
		(new dsgame.DatePicker({input:'#J-date-end',isShowTime:true, startYear:2013})).show();
	});


	selectGameType.addEvent('change', function(e, value, text){
		var id = $.trim(value);
		if(id == '' || id == '0'){
			if(id == '0'){
				selectMethodGroup.reBuildSelect([{'value':'0', 'text':'所有玩法群', 'checked':true}]);
			}
			return;
		}
		loadMethodgroup(id, function(data){
			var list = [];
			$.each(data, function(i){
				list[i] = {value:data[i]['id'], text:data[i]['name'], checked: data[i]['isdefault'] ? true : false};
			});
			selectMethodGroup.reBuildSelect(list);
		});
	});
	loadMethodgroup = function(gameid, callback){
		var id = gameid;
		$.ajax({
			url:'../data/methodgroup.php?id=' + id,
			timeout:30000,
			dataType:'json',
			beforeSend:function(){

			},
			success:function(data){
				if(Number(data['isSuccess']) == 1){
					callback(data['data']);
				}else{
					alert(data['msg']);
				}
			},
			error:function(){
				alert('网络请求失败，请稍后重试');
			}
		});
	};


	selectMethodGroup.addEvent('change', function(e, value, text){
		var id = $.trim(value);
		if(id == '' || id == '0'){
			if(id == '0'){
				selectMethod.reBuildSelect([{'value':'0', 'text':'所有玩法', 'checked':true}]);
			}
			return;
		}
		loadMethod(id, function(data){
			var list = [];
			$.each(data, function(i){
				list[i] = {value:data[i]['id'], text:data[i]['name'], checked: data[i]['isdefault'] ? true : false};
			});
			selectMethod.reBuildSelect(list);
		});
	});
	loadMethod = function(groupid, callback){
		var id = groupid;
		$.ajax({
			url:'../data/method.php?id=' + id,
			timeout:30000,
			dataType:'json',
			beforeSend:function(){

			},
			success:function(data){
				if(Number(data['isSuccess']) == 1){
					callback(data['data']);
				}else{
					alert(data['msg']);
				}
			},
			error:function(){
				alert('网络请求失败，请稍后重试');
			}
		});
	};




})(jQuery);
</script>


</body>
</html>
