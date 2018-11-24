<!DOCTYPE HTML>
<html lang="en-US">
<head>
<meta charset="UTF-8">
<title>站内信 -- CC彩票</title>
<link type="text/css" rel="stylesheet" href="../images/global/global.css" />
<link type="text/css" rel="stylesheet" href="../images/ucenter/ucenter.css" />

<script type="text/javascript" src="../js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="../js/dsgame.base.js"></script>
<script type="text/javascript" src="../js/dsgame.Select.js"></script>

</head>

<body>

<?php include_once("../header.php"); ?>


<div class="g_33 main clearfix">
	<div class="main-sider">
		
		<?php include_once("../uc-sider.php"); ?>
		
	</div>
	<div class="main-content">
		
		<div class="nav-bg nav-bg-tab">
			<div class="title-normal">通知</div>
			<ul class="tab-title clearfix">
				<li><a href="notice.php"><span>公告</span></a></li>
				<li class="current"><a href="station-letters.php"><span>站内信</span></a></li>
			</ul>
		</div>
		
		<div class="content">
			<div class="table-edit-area clearfix">
				<div class="right">
					<a href="javascript:;" class="btn" data-action-delete>&times;&nbsp;删除</a>
					<a href="javascript:;" class="btn" data-action-status>标记已读</a>
				</div>
				<div class="left">
					<a href="javascript:;" class="btn" data-action-toggle>编辑</a>
					<a href="javascript:;" class="btn" data-action-checkbox><i class="checkbox-icon"></i><span>全选</span></a>
				</div>
				<!-- 删除站内信表单 -->
				<form action="/" id="J-form-delete">
					<input type="hidden" name="mailid">
				</form>
				<!-- 标记已读表单 -->
				<form action="/" id="J-form-status">
					<input type="hidden" name="mailid">
				</form>
			</div>
			<table width="100%" class="table table-border station-letters-table">
				<thead>
					<tr>
						<th>&nbsp;&nbsp;&nbsp;&nbsp;标题</th>
						<th>发件人</th>
						<th>发送时间</th>
						<th>状态</th>
					</tr>
				</thead>
				<tbody>
					<tr class="mail-unread">
						<td>
							<i class="checkbox-icon" data-id="1"></i>
							<a href="station-letters-detail.php">518凤凰大赢家  第二期赢家名单出炉 1年1次 错过再等1年</a>
						</td>
						<td>站内消息</td>
						<td>2014-05-26 14:01</td>
						<td>未读</td>
					</tr>
					<tr>
						<td>
							<i class="checkbox-icon" data-id="2"></i>
							<a href="station-letters-detail.php"></i>518凤凰大赢家  第二期赢家名单出炉 1年1次 错过再等1年</a>
						</td>
						<td>站内消息</td>
						<td>2014-05-26 14:01</td>
						<td>已读</td>
					</tr>
					<tr>
						<td>
							<i class="checkbox-icon" data-id="3"></i>
							<a href="station-letters-detail.php">518凤凰大赢家  第二期赢家名单出炉 1年1次 错过再等1年</a>
						</td>
						<td>站内消息</td>
						<td>2014-05-26 14:01</td>
						<td>已读</td>
					</tr>
					<tr>
						<td>
							<i class="checkbox-icon" data-id="4"></i>
							<a href="station-letters-detail.php">518凤凰大赢家  第二期赢家名单出炉 1年1次 错过再等1年</a>
						</td>
						<td>站内消息</td>
						<td>2014-05-26 14:01</td>
						<td>已读</td>
					</tr>
					<tr>
						<td>
							<i class="checkbox-icon" data-id="5"></i>
							<a href="station-letters-detail.php">518凤凰大赢家  第二期赢家名单出炉 1年1次 错过再等1年</a>
						</td>
						<td>站内消息</td>
						<td>2014-05-26 14:01</td>
						<td>已读</td>
					</tr>
					<tr>
						<td>
							<i class="checkbox-icon" data-id="6"></i>
							<a href="station-letters-detail.php">518凤凰大赢家  第二期赢家名单出炉 1年1次 错过再等1年</a>
						</td>
						<td>站内消息</td>
						<td>2014-05-26 14:01</td>
						<td>已读</td>
					</tr>
					<tr>
						<td>
							<i class="checkbox-icon" data-id="7"></i>
							<a href="station-letters-detail.php">518凤凰大赢家  第二期赢家名单出炉 1年1次 错过再等1年</a>
						</td>
						<td>站内消息</td>
						<td>2014-05-26 14:01</td>
						<td>已读</td>
					</tr>
					<tr>
						<td>
							<i class="checkbox-icon" data-id="8"></i>
							<a href="station-letters-detail.php">518凤凰大赢家  第二期赢家名单出炉 1年1次 错过再等1年</a>
						</td>
						<td>站内消息</td>
						<td>2014-05-26 14:01</td>
						<td>已读</td>
					</tr>
					<tr>
						<td>
							<i class="checkbox-icon" data-id="9"></i>
							<a href="station-letters-detail.php">518凤凰大赢家  第二期赢家名单出炉 1年1次 错过再等1年</a>
						</td>
						<td>站内消息</td>
						<td>2014-05-26 14:01</td>
						<td>已读</td>
					</tr>
					<tr>
						<td>
							<i class="checkbox-icon" data-id="10"></i>
							<a href="station-letters-detail.php">518凤凰大赢家  第二期赢家名单出炉 1年1次 错过再等1年</a>
						</td>
						<td>站内消息</td>
						<td>2014-05-26 14:01</td>
						<td>已读</td>
					</tr>
					
				</tbody>
			</table>
			<?php include_once("../pages.php"); ?>
		</div>
	</div>
</div>

<?php include_once("../footer.php"); ?>

<script>
$(function(){
	var $actions = $('.table-edit-area .btn:not("[data-action-toggle]")'),
		$toggle = $('[data-action-toggle]').addClass('active'),
		$checkboxToggle = $('[data-action-checkbox]'),
		$checkboxs = $('td .checkbox-icon'),
		$input = $('input[name="mailid"]');

	$toggle.on('click', function(){
		var $this = $(this);
		if( $this.hasClass('active') ){			
			$this.text('编辑');
		}else{
			$this.text('取消编辑');
		}
		$this.toggleClass('active');
		$actions.toggle();
		$checkboxs.toggle();
	}).trigger('click');

	// 全选
	$checkboxToggle.on('click', function(){
		$(this).toggleClass('active');
		$checkboxs.toggleClass('active');
		setMailId();
	});
	$checkboxs.on('click', function(){
		$(this).toggleClass('active');
		if( $('td .checkbox-icon.active').length != $checkboxs.length ){
			$checkboxToggle.removeClass('active');
		}else{
			$checkboxToggle.addClass('active');
		}
		setMailId();
	});
	// setMailId
	function setMailId(){
		var ids = [];
		$checkboxs.filter('.active').each(function(){
			var id = $(this).data('id');
			ids.push(id);
		});
		ids.join(',');
		$input.val(ids);
	}

	var $deleteForm = $('#J-form-delete'),
		$statusForm = $('#J-form-status');
	$('[data-action-delete]').on('click', function(){
		if( !$deleteForm.find('[name="mailid"]').val() ){
			return alert('请选择要删除的站内信~');
		}
		$deleteForm[0].submit();
	});
	$('[data-action-status]').on('click', function(){
		if( !$statusForm.find('[name="mailid"]').val() ){
			return alert('请选择要标记为未读的站内信~');
		}
		$statusForm[0].submit();
	});
});
</script>

</body>
</html>
