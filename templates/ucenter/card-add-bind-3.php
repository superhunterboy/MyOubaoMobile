<!DOCTYPE HTML>
<html lang="en-US">
<head>
<meta charset="UTF-8">
<title>确认新银行卡信息 -- 增加绑定 -- CC彩票</title>
<link type="text/css" rel="stylesheet" href="../images/global/global.css" />
<link type="text/css" rel="stylesheet" href="../images/ucenter/ucenter.css" />
<style>
	body{background:transparent;}
	.table-field{margin-bottom:0;margin-top:0;}
	.table-field .btn[type='submit']{width:100px;}
</style>
<script type="text/javascript" src="../js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="../js/dsgame.base.js"></script>
<script type="text/javascript" src="../js/dsgame.Select.js"></script>
<script type="text/javascript" src="../js/dsgame.Tip.js"></script>

</head>

<body>
<div class="content">
	<div id="J-error-msg" class="prompt" style="display:none;"></div>
	<form action="card-add-bind-4.php">
	<table width="100%" class="table-field">
		<tr>
			<td align="right">开户银行：</td>
			<td>中国农业银行</td>
		</tr>
		<tr>
			<td align="right">开户银行区域：</td>
			<td>广西&nbsp;&nbsp;北海</td>
		</tr>
		<tr>
			<td align="right">支行名称：</td>
			<td>中华街支行</td>
		</tr>
		<tr>
			<td align="right">开户人姓名：</td>
			<td>张麻子</td>
		</tr>
		<tr>
			<td align="right">银行账号：</td>
			<td>6225758303225555</td>
		</tr>
		<tr>
			<td align="right"></td>
			<td>
				<input type="submit" value="确认提交" class="btn" id="J-submit">
				<input type="button" value="返回上一步" class="btn btn-normal" id="J-button-back">
			</td>
		</tr>
	</table>
	</form>
</div>

<script>
(function($){
	// 设置父级弹窗标题
	var addCardMiniwindow = window.parent.addCardMiniwindow;
	addCardMiniwindow.setTitle('确认银行卡信息');
	// iframe自适应高度
	var $iframe = $('#card-add-bind-frame', window.parent.document);
	function reinitHeight(){
		$iframe.css('height', $('.content').outerHeight());
	}
	if( $iframe.length ){		
		$(window).on('resize', function(){
			reinitHeight();
		}).trigger('resize');
	}
	/*××××××××××××××××××××××××××××××××××××××*/

	// 其他的代码开始	
	$('#J-button-back').click(function(){
		history.back(-1);
	});

	var $error = $('#J-error-msg');
	function showError(text){
		if( text ){
			$error.text(text);
		}
		$error.show();
		reinitHeight();
	}
		
})(jQuery);
</script>

</body>
</html>
