<!DOCTYPE HTML>
<html lang="en-US">
<head>
<meta charset="UTF-8">
<title>输入新银行卡信息 -- 增加绑定 -- CC彩票</title>
<link type="text/css" rel="stylesheet" href="../images/global/global.css" />
<link type="text/css" rel="stylesheet" href="../images/ucenter/ucenter.css" />
<style>
	body{background:transparent;}
	.table-field{margin-bottom:0;margin-top:0;}
	.table-field .btn[type='submit']{width:160px;}
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
	<form action="card-add-bind-3.php" method="post" id="J-form">
	<table width="100%" class="table-field">
		<tr>
			<td align="right">开户银行：</td>
			<td>
				<select id="J-select-bank-name" style="display:none;">
					<option value="0" selected="selected">请选择开户银行</option>
					<option value="1">招商银行</option>
					<option value="2">中国银行</option>
					<option value="3">建设银行</option>
					<option value="4">浦发银行</option>
				</select>
			</td>
		</tr>
		<tr>
			<td align="right">开户银行区域：</td>
			<td>
				<select id="J-select-province" style="display:none;">
					<option value="0" selected="selected">请选择省份</option>
					<option value="北京">北京市</option>
					<option value="浙江省">浙江省</option>
					<option value="天津市">天津市</option>
					<option value="安徽省">安徽省</option>
					<option value="上海市">上海市</option>
					<option value="福建省">福建省</option>
					<option value="重庆市">重庆市</option>
					<option value="江西省">江西省</option>
					<option value="山东省">山东省</option>
					<option value="河南省">河南省</option>
					<option value="湖北省">湖北省</option>
					<option value="湖南省">湖南省</option>
					<option value="广东省">广东省</option>
					<option value="海南省">海南省</option>
					<option value="山西省">山西省</option>
					<option value="青海省">青海省</option>
					<option value="江苏省">江苏省</option>
					<option value="辽宁省">辽宁省</option>
					<option value="吉林省">吉林省</option>
					<option value="台湾省">台湾省</option>
					<option value="河北省">河北省</option>
					<option value="贵州省">贵州省</option>
					<option value="四川省">四川省</option>
					<option value="云南省">云南省</option>
					<option value="陕西省">陕西省</option>
					<option value="甘肃省">甘肃省</option>
					<option value="黑龙江省">黑龙江省</option>
					<option value="香港特别行政区">香港</option>
					<option value="澳门特别行政区">澳门</option>
					<option value="广西壮族自治区">广西</option>
					<option value="宁夏回族自治区">宁夏</option>
					<option value="新疆维吾尔自治区">新疆</option>
					<option value="内蒙古自治区">内蒙古区</option>
					<option value="西藏自治区">西藏</option>
				</select>
				&nbsp;
				<select id="J-select-city" style="display:none;">
					<option value="0" selected="selected">请选择城市</option>
				</select>
			</td>
		</tr>
		<tr>
			<td align="right">支行名称：</td>
			<td>
				<input type="text" class="input w-3" id="J-input-bankname">
				<span class="ui-text-prompt">由1至20个字符或汉字组成，不能使用特殊字符</span>
			</td>
		</tr>
		<tr>
			<td align="right">开户人姓名：</td>
			<td>
				<input type="text" class="input w-3" id="J-input-name">
				<span class="ui-text-prompt">由1至20个字符或汉字组成，不能使用特殊字符</span>
			</td>
		</tr>
		<tr>
			<td align="right">银行账号：</td>
			<td>
				<input type="text" class="input w-3" id="J-input-card-number">
				<span class="ui-text-prompt">银行卡卡号由16位或19位数字组成</span>
			</td>
		</tr>
		<tr>
			<td align="right">确认银行账号：</td>
			<td>
				<input type="text" class="input w-3" id="J-input-card-number2">
				<span class="ui-text-prompt">银行账号只能手动输入，不能粘贴</span>
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
	addCardMiniwindow.setTitle('填写银行卡信息');
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
		cardInput = $('#J-input-card-number, #J-input-card-number2'),
		bankSelect = new dsgame.Select({realDom:'#J-select-bank-name',cls:'w-3'}),
		provinceSelect = new dsgame.Select({realDom:'#J-select-province',cls:'w-3'}),
		citySelect = new dsgame.Select({realDom:'#J-select-city',cls:'w-3'}),
		cityCache = {},
		makeBigNumber;
	
	
	provinceSelect.addEvent('change', function(e, value, text){
		var id = $.trim(value);
		if(id == '0'){
			citySelect.reBuildSelect([{value:0, text:'请选择城市',checked:true}]);
			return;
		}
		if(cityCache[id]){
			citySelect.reBuildSelect(cityCache[id]);
		}else{
			$.ajax({
				url:'../data/city.php?id=' + id,
				timeout:30000,
				dataType:'json',
				beforeSend:function(){
					
				},
				success:function(data){
					if(Number(data['isSuccess']) == 1){
						var list = [];
						$.each(data['data'], function(i){
							list[i] = {value:this['id'], text:this['name'], checked: this['isdefault'] ? true : false};
						});
						cityCache[id] = list;
						citySelect.reBuildSelect(cityCache[id]);
					}else{
						alert(data['msg']);
					}
				},
				error:function(){
					alert('网络请求失败，请稍后重试');
				}
			});
		}
	});
	
	
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
	cardInput.keydown(function(e){
		if(e.ctrlKey && e.keyCode == 86){
			return false;
		}
	});
	cardInput.bind("contextmenu",function(e){
		return false;   
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
		var bank = $('#J-select-bank-name'),
			province = $('#J-select-province'),
			city = $('#J-select-city'),
			bankname = $('#J-input-bankname'),
			name = $('#J-input-name'),
			cardnumber = $('#J-input-card-number'),
			cardnumber2 = $('#J-input-card-number2');
			
		if($.trim(bank.val()) == ''){
			showError('请选择开户银行');
			return false;
		}
		if($.trim(province.val()) == '0'){
			showError('请选择开户银行省份');
			return false;
		}
		if($.trim(city.val()) == '0'){
			showError('请选择开户银行城市');
			return false;
		}
		if($.trim(bankname.val()) == ''){
			showError('请填写支行名称');
			bankname.focus();
			return false;
		}
		if($.trim(name.val()) == ''){
			showError('请填写开户人姓名');
			name.focus();
			return false;
		}
		if($.trim(cardnumber.val()) == ''){
			showError('请填写银行账号');
			cardnumber.focus();
			return false;
		}
		if($.trim(cardnumber2.val()) == ''){
			showError('请填写确认银行账号');
			cardnumber2.focus();
			return false;
		}
		if($.trim(cardnumber.val()) != $.trim(cardnumber2.val())){
			showError('两次填写的银行账号不一致');
			cardnumber2.focus();
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
