<!DOCTYPE HTML>
<html lang="en-US">
<head>
<meta charset="UTF-8">
<title>绑定结果 -- 增加绑定 -- CC彩票</title>
<link type="text/css" rel="stylesheet" href="../images/global/global.css" />
<link type="text/css" rel="stylesheet" href="../images/ucenter/ucenter.css" />
<style>
	body{background:transparent;}
	.table-field{margin-bottom:0;margin-top:0;}
	.txt h4{font-size:16px;font-weight:normal;}
	.alert{width:400px;border-radius:3px;border:none;background-color:transparent;margin-top:0;}
	.content{padding:20px;overflow:auto;}
</style>
<script type="text/javascript" src="../js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="../js/dsgame.base.js"></script>
<script type="text/javascript" src="../js/dsgame.Select.js"></script>
<script type="text/javascript" src="../js/dsgame.Tip.js"></script>

</head>

<body>
<div class="content">

	<div class="alert alert-success">
		<i></i>
		<div class="txt">
			<h4>恭喜你，银行卡绑定成功。</h4>
			<p>新的银行卡将在2小时0分后可以发起“平台提现”</p>
			<div>现在您可以：  <a href="/" target="_top" class="btn btn-small">充值</a>&nbsp;&nbsp;<a href="/" target="_top" class="btn btn-small">银行卡管理</a></div>
		</div>
	</div>
	
	
	<div class="alert alert-error">
		<i></i>
		<div class="txt">
			<h4>银行卡绑定失败。</h4>
			<div>现在您可以：  <a href="/" target="_top" class="btn btn-small">重新绑定</a></div>
		</div>
	</div>

</div>

<script>
(function($){
	// 设置父级弹窗标题
	var addCardMiniwindow = window.parent.addCardMiniwindow;
	addCardMiniwindow.setTitle('银行绑定成功');
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
