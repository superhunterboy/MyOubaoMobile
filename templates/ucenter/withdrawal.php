<!DOCTYPE HTML>
<html lang="en-US">
<head>
<meta charset="UTF-8">
<title>提现 -- CC彩票</title>
<link type="text/css" rel="stylesheet" href="../images/global/global.css" />
<link type="text/css" rel="stylesheet" href="../images/ucenter/ucenter.css" />

<script type="text/javascript" src="../js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="../js/jquery.easing.1.3.js"></script>
<script type="text/javascript" src="../js/jquery.mousewheel.min.js"></script>
<script type="text/javascript" src="../js/dsgame.base.js"></script>
<script type="text/javascript" src="../js/dsgame.Select.js"></script>
<script type="text/javascript" src="../js/dsgame.Tip.js"></script>

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
				提现
			</div>
		</div>
		
		<div class="content recharge-confirm recharge-netbank">
			<div class="prompt">
				每天限提 3 次，今天您已经成功发起了 <span class="c-red">0</span> 次提现申请
			</div>
			<form action="?" method="post" id="J-form">
			<table width="100%" class="table-field">
				<tr>
					<td width="200" align="right" valign="top"><span class="field-name">用户名：</span></td>
				    <td>
						wahaha
					</td>
				</tr>
				<tr>
					<td align="right" valign="top"><span class="field-name">可提现余额：</span></td>
				    <td>
						<span id="J-money-available">1200.00</span> 元
					</td>
				</tr>
				<tr>
					<td align="right" valign="top"><span class="field-name">收款银行卡信息：</span></td>
				    <td>
					<select id="J-select-bank" style="display:none;">
						<option value="0" selected="selected">-- 请选择收款银行卡 --</option>
						<option value="1">张云方 **** **** **** 6585</option>
						<option value="2">董建华 **** **** **** 3525</option>
						<option value="3">周润发 **** **** **** 3585</option>
					</select>
					</td>
				</tr>
				<tr>
				  <td align="right" valign="top"><span class="field-name">提现金额：</span></td>
				  <td>
				  		<input id="J-input-money" type="text" class="input w-2 input-ico-money" />&nbsp; 元
						<br />
						<span class="tip">单笔最低提现金额：<span id="J-money-min">100.00</span>元，最高<span id="J-money-max">1,000,000.00</span>元</span>
								  
					</td>
			  </tr>
				<tr>
				  <td align="right" valign="top">&nbsp;</td>
			      <td>
					<input type="submit" class="btn" value=" 下一步 " id="J-submit" />
					</td>
			  </tr>
			</table>
			</form>

			
		</div>
		
	</div>
</div>

<?php include_once("../footer.php"); ?>


<script>
(function($){
	
	var ipt1 = $('#J-input-money'),
		moneyInput = $('#J-input-money'),
		tip = new dsgame.Tip({cls:'j-ui-tip-b j-ui-tip-input-floattip'}),
		bankSelect = new dsgame.Select({realDom:'#J-select-bank',cls:'w-5'});
	
	bankSelect.addEvent('change', function(e, value, text){
		var id = $.trim(value);
		if(id == '' || id == '0'){
			return;
		}
		$.ajax({
				url:'../data/bank.php?action=getBankInfoById&id=' + id,
				timeout:30000,
				dataType:'json',
				beforeSend:function(){
					
				},
				success:function(data){
					if(Number(data['isSuccess']) == 1){
						$('#J-money-min').text(dsgame.util.formatMoney(data['data']['min']));
						$('#J-money-max').text(dsgame.util.formatMoney(data['data']['max']));
					}else{
						alert(data['msg']);
					}
				},
				error:function(){
					alert('网络请求失败，请稍后重试');
				}
		});
		
	});
	
	
	moneyInput.keyup(function(e){
		var v = $.trim(this.value),arr = [],code = e.keyCode;
		if(code == 37 || code == 39){
			return;
		}
		v = v.replace(/[^\d|^\.]/g, '');
		arr = v.split('.');
		if(arr.length > 2){
			v = '' + arr[0] + '.' + arr[1];
		}
		arr = v.split('.');
		if(arr.length > 1){
			arr[1] = arr[1].substring(0, 2);
			v = arr.join('.');
		}
		this.value = v;
		v = v == '' ? '&nbsp;' : v;
		if(!isNaN(Number(v))){
			v = dsgame.util.formatMoney(v);
		}
		tip.setText(v);
		tip.getDom().css({left:moneyInput.offset().left + moneyInput.width()/2 - tip.getDom().width()/2});
	});
	moneyInput.focus(function(){
		var v = $.trim(this.value);
		if(v == ''){
			v = '&nbsp;';
		}
		if(!isNaN(Number(v))){
			v = dsgame.util.formatMoney(v);
		}
		tip.setText(v);
		tip.show(moneyInput.width()/2 - tip.getDom().width()/2, tip.getDom().height() * -1 - 20, this);
	});
	moneyInput.blur(function(){
		var v = Number(this.value),minNum = Number($('#J-money-min').text().replace(/,/g, '')),maxNum = Number($('#J-money-max').text().replace(/,/g, '')),available = Number($('#J-money-available').text().replace(/,/g, ''));
		v = v < minNum ? minNum : v;
		v = v > maxNum ? maxNum : v;
		v = v > available ? available : v;
		this.value = dsgame.util.formatMoney(v).replace(/,/g, '');
		tip.hide();
	});
	
	
	
	
	$('#J-submit').click(function(){
		var v1 = $.trim(ipt1.val());
		if(v1 == ''){
			alert('提款金额不能为空');
			ipt1.focus();
			return false;
		}
		return true;
	});
	
	
	
	
	
	
})(jQuery);
</script>


</body>
</html>
