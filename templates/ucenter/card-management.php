<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
<title>银行卡管理 -- CC彩票</title>
<link type="text/css" rel="stylesheet" href="../images/global/global.css" />
<link type="text/css" rel="stylesheet" href="../images/ucenter/ucenter.css" />

<script type="text/javascript" src="../js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="../js/dsgame.base.js"></script>
<script type="text/javascript" src="../js/dsgame.Select.js"></script>
<script type="text/javascript" src="../js/dsgame.Mask.js"></script>
<script type="text/javascript" src="../js/dsgame.MiniWindow.js"></script>

</head>

<body>

<?php include_once("../header.php"); ?>


<div class="g_33 main clearfix">
	<div class="main-sider">
		
		<?php include_once("../uc-sider.php"); ?>
		
	</div>
	<div class="main-content">
		
		<div class="nav-bg">
			<div class="title-normal">
				银行卡管理
			</div>
		</div>
		
		<div class="content">
			<?php
				$rand = rand(0,20);
				// $rand = 20;
			?>
			<?php if( $rand < 10 ){ ?>
			<div class="no-bank-card">
				<p class="alert-message"><i class="alert-icon"></i><span>您还没有绑定银行卡</span></p>
				<a href="javascript:void(0);" data-add-bankcard>+  添加银行卡</a>
			</div>

			<?php }else{ ?>
			<div class="row-head" style="border-bottom:none;">
				<p>添加或修改绑定的银行卡，需要1小时后才能进行提现。</p>
				<p>已绑定的银行卡<span class="c-important">（1/4）</span></p>
				<a href="#" data-add-bankcard class="btn btn-important row-right-btn">+ 添加银行卡</a>
			</div>
			<table class="table">
				<tr>
					<th>开户行</th>
					<th>银行卡号</th>
					<th>开户人姓名</th>
					<th>绑定时间</th>
					<th>银行卡状态</th>
					<th>操作</th>
				</tr>
				<tr>
					<td>中国银行</td>
					<td>**** **** **** **** 999</td>
					<td>陈紫米</td>
					<td>2014-05-27 16:45:56</td>
					<td><span class="ui-status-okay">使用中</span><span class="ui-status-no">停止</span></td>
					<td>
						<a class="ui-action-edit" href="#">修改</a>
						<a class="ui-action-lock" href="#">锁定</a>
						<a class="ui-action-delete" href="#">删除</a>
					</td>
				</tr>
				<tr>
					<td>中国银行</td>
					<td>**** **** **** **** 999</td>
					<td>陈紫米</td>
					<td>2014-05-27 16:45:56</td>
					<td>尚未生效</td>
					<td>
						<a class="ui-action-edit" href="#">修改</a>
						<a class="ui-action-lock" href="#">锁定</a>
						<a class="ui-action-delete" href="#">删除</a>
					</td>
				</tr>
				<tr>
					<td>中国银行</td>
					<td>**** **** **** **** 999</td>
					<td>陈紫米</td>
					<td>2014-05-27 16:45:56</td>
					<td>尚未生效</td>
					<td>
						<a class="ui-action-edit" href="#">修改</a>
						<a class="ui-action-lock" href="#">锁定</a>
						<a class="ui-action-delete" href="#">删除</a>
					</td>
				</tr>
				<tr>
					<td>中国银行</td>
					<td>**** **** **** **** 999</td>
					<td>陈紫米</td>
					<td>2014-05-27 16:45:56</td>
					<td>尚未生效</td>
					<td>
						<a class="ui-action-edit" href="#">修改</a>
						<a class="ui-action-lock" href="#">锁定</a>
						<a class="ui-action-delete" href="#">删除</a>
					</td>
				</tr>
				<tr>
					<td>中国银行</td>
					<td>**** **** **** **** 999</td>
					<td>陈紫米</td>
					<td>2014-05-27 16:45:56</td>
					<td>尚未生效</td>
					<td>
						<a class="ui-action-edit" href="#">修改</a>
						<a class="ui-action-lock" href="#">锁定</a>
						<a class="ui-action-delete" href="#">删除</a>
					</td>
				</tr>
				<tr>
					<td>中国银行</td>
					<td>**** **** **** **** 999</td>
					<td>陈紫米</td>
					<td>2014-05-27 16:45:56</td>
					<td>尚未生效</td>
					<td>
						<a class="ui-action-edit" href="#">修改</a>
						<a class="ui-action-lock" href="#">锁定</a>
						<a class="ui-action-delete" href="#">删除</a>
					</td>
				</tr>
				<tr>
					<td>中国银行</td>
					<td>**** **** **** **** 999</td>
					<td>陈紫米</td>
					<td>2014-05-27 16:45:56</td>
					<td>尚未生效</td>
					<td>
						<a class="ui-action-edit" href="#">修改</a>
						<a class="ui-action-lock" href="#">锁定</a>
						<a class="ui-action-delete" href="#">删除</a>
					</td>
				</tr>
				<tr>
					<td>中国银行</td>
					<td>**** **** **** **** 999</td>
					<td>陈紫米</td>
					<td>2014-05-27 16:45:56</td>
					<td>尚未生效</td>
					<td>
						<a class="ui-action-edit" href="#">修改</a>
						<a class="ui-action-lock" href="#">锁定</a>
						<a class="ui-action-delete" href="#">删除</a>
					</td>
				</tr>
				<tr>
					<td>中国银行</td>
					<td>**** **** **** **** 999</td>
					<td>陈紫米</td>
					<td>2014-05-27 16:45:56</td>
					<td>尚未生效</td>
					<td>
						<a class="ui-action-edit" href="#">修改</a>
						<a class="ui-action-lock" href="#">锁定</a>
						<a class="ui-action-delete" href="#">删除</a>
					</td>
				</tr>
				<tr>
					<td>中国银行</td>
					<td>**** **** **** **** 999</td>
					<td>陈紫米</td>
					<td>2014-05-27 16:45:56</td>
					<td>尚未生效</td>
					<td>
						<a class="ui-action-edit" href="#">修改</a>
						<a class="ui-action-lock" href="#">锁定</a>
						<a class="ui-action-delete" href="#">删除</a>
					</td>
				</tr>
			</table>

			<div class="prompt-text">
				提示：银行卡已锁定，解除锁定请联系客服。
			</div>
			
			
			<div class="alert alert-error alert-noresult">
				<i></i>
				<div class="txt">
					<h4>您还没有绑定银行卡，<a href="#" class="btn">立即绑定</a></h4>
				</div>
			</div>
			
			
			<div class="area-search" style="margin-top:10px;">
				<p class="row">&nbsp;&nbsp;&nbsp;<a href="#" class="btn">增加绑定</a>  <a href="#" class="btn">锁定银行卡</a></p>
			</div>

			<div class="prompt-text" style="clear:both;">
				<div class="item-title"><i class="item-icon-11"></i>提示</div>
				<ol class="item-info">
					<li>1、一个游戏账户最多绑定 4 张银行卡， 您目前绑定了1张卡，还可以绑定3张。</li>
					<li>2、银行卡信息锁定后，不能增加新卡绑定，已绑定的银行卡信息不能进行修改和删除。</li>
					<li>3、为了您的账户资金安全，银行卡“新增”和“修改”将在操作完成2小时0分后，新卡才能发起“向平台提现”。</li>
					<li>4、当您已经绑定过一张银行卡后，再进行添加银行卡，需要验证您第一张卡的信息，请务必牢记。</li>
				</ol>					
			</div>
			<?php }	?>
		</div>
	</div>
</div>

<?php include_once("../footer.php"); ?>

<script>
// 添加银行卡
// 变量必须保证为全局变量，以便iframe内调用
var addCardMask = new dsgame.Mask(),
	addCardMiniwindow = new dsgame.MiniWindow({ cls: 'w-12 add-card-miniwindow' });

(function(){
	var hideMask = function(){
		addCardMiniwindow.hide();
		addCardMask.hide();
	};

	addCardMiniwindow.setContent(
		'<iframe src="card-add-bind-1.php" id="card-add-bind-frame" ' +
		'width="100%" height="360" frameborder="0" allowtransparency="true" scrolling="no"></iframe>'
	);
	addCardMiniwindow.setTitle('添加银行卡');
	addCardMiniwindow.showCancelButton();
	// addCardMiniwindow.showConfirmButton();

	addCardMiniwindow.doNormalClose = hideMask;
	addCardMiniwindow.doConfirm     = hideMask;
	addCardMiniwindow.doClose       = hideMask;
	addCardMiniwindow.doCancel      = hideMask;

	$('[data-add-bankcard]').on('click', function(){
		addCardMask.show();
		addCardMiniwindow.show();
	});

})();

</script>

</body>
</html>
