<!DOCTYPE HTML>
<html lang="en-US">
<head>
<meta charset="UTF-8">
<title>验证老银行卡 -- 增加绑定 -- CC彩票</title>
<link type="text/css" rel="stylesheet" href="../images/global/global.css" />
<link type="text/css" rel="stylesheet" href="../images/ucenter/ucenter.css" />
<style>
	body{background:transparent;}
	.table-field{margin-bottom:0;margin-top:0;}
	.table-field .btn[type='submit']{width:210px;}
	.content{overflow:auto;}
</style>
<script type="text/javascript" src="../js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="../js/jquery.easing.1.3.js"></script>
<script type="text/javascript" src="../js/jquery.mousewheel.min.js"></script>
<script type="text/javascript" src="../js/dsgame.base.js"></script>
<script type="text/javascript" src="../js/dsgame.Select.js"></script>
<script type="text/javascript" src="../js/dsgame.Tip.js"></script>

</head>

<body>
		
<div class="content">
	<div id="J-error-msg" class="prompt" style="display:none;"></div>
	<form action="card-add-bind-2.php" method="post" id="J-form">
	<table width="100%" class="table-field">
		<tr>
			<td align="right">选择验证银行卡：</td>
			<td>
				<select id="J-select-bank-card" style="display:none;">
					<option value="0" selected="selected">请选择你要验证的银行卡</option>
					<option value="1">**** **** **** 9988</option>
					<option value="2">**** **** **** 5484</option>
				</select>
			</td>
		</tr>
		<tr>
			<td align="right">开户人姓名：</td>
			<td>
				<input type="text" class="input w-4" id="J-input-name">
				<span class="ui-text-prompt">请输入旧的银行卡开户人姓名</span>
			</td>
		</tr>
		<tr>
			<td align="right">银行账号：</td>
			<td>
				<input type="text" class="input w-4" id="J-input-card-number">
				<span class="ui-text-prompt">请输入旧的银行卡卡号</span>
			</td>
		</tr>
		<tr>
			<td align="right">资金密码：</td>
			<td>
				<input type="password" class="input w-4" id="J-input-password">
				<span class="ui-text-prompt">请输入您的资金密码</span>
			</td>
		</tr>
		<tr>
			<td align="right"></td>
			<td>
				<input type="submit" value="下一步" class="btn" id="J-submit">
			</td>
		</tr>
	</table>
	</form>
</div>

<script>
(function($){

	// 设置父级弹窗标题
	var addCardMiniwindow = window.parent.addCardMiniwindow;
	addCardMiniwindow.setTitle('验证老银行卡');
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
	var tip = new dsgame.Tip({cls:'j-ui-tip-b j-ui-tip-input-floattip'}),
		cardInput = $('#J-input-card-number'),
		makeBigNumber;
	
	new dsgame.Select({realDom:'#J-select-bank-card',cls:'w-4'});
	
	cardInput.keyup(function(e){
		var el = $(this),v = this.value.replace(/^\s*/g, ''),arr = [],code = e.keyCode;
		if(code == 37 || code == 39){
			return;
		}
		v = v.replace(/[^\d|\s]/g, '').replace(/\s{2}/g, ' ');
		this.value = v;
		if(v == ''){
			v = '&nbsp;';
		}else{
			v = makeBigNumber(v);
			this.value = v;
		}
		tip.setText(v);
		tip.getDom().css({left:el.offset().left + el.width()/2 - tip.getDom().width()/2});
		if(v != '&nbsp;'){
			tip.show(el.width()/2 - tip.getDom().width()/2, tip.getDom().height() * -1 - 20, this);
		}else{
			tip.hide();
		}
		
	});
	cardInput.focus(function(){
		var el = $(this),v = $.trim(this.value);
		if(v == ''){
			v = '&nbsp;';
		}else{
			v = makeBigNumber(v);
		}
		tip.setText(v);
		if(v != '&nbsp;'){
			tip.show(el.width()/2 - tip.getDom().width()/2, tip.getDom().height() * -1 - 20, this);
		}else{
			tip.hide();
		}
	});
	cardInput.blur(function(){
		this.value = makeBigNumber(this.value);
		tip.hide();
	});
	//每4位数字增加一个空格显示
	makeBigNumber = function(str){
		var str = str.replace(/\s/g, '').split(''),len = str.length,i = 0,newArr = [];
		for(;i < len;i++){
			if(i%4 == 0 && i != 0){
				newArr.push(' ');
				newArr.push(str[i]);
			}else{
				newArr.push(str[i]);
			}
		}
		return newArr.join('');
	};
	
	
	$('#J-submit').click(function(){
		var bankCard = $('#J-select-bank-card'),
			name = $('#J-input-name'),
			password = $('#J-input-password');
		if($.trim(bankCard.val()) == '0'){
			showError('请选择需要进行验证的银行卡');
			return false;
		}
		if($.trim(name.val()) == ''){
			showError('请填写开户人姓名');
			name.focus();
			return false;
		}
		if($.trim(cardInput.val()) == ''){
			showError('请填写银行账号');
			cardInput.focus();
			return false;
		}
		if($.trim(password.val()) == ''){
			showError('请填写资金密码');
			password.focus();
			return false;
		}
		return true;
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
