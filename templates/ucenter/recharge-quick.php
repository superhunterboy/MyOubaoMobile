<!DOCTYPE HTML>
<html lang="en-US">
<head>
<meta charset="UTF-8">
<title>快速充值 -- 充值 -- CC彩票</title>
<link type="text/css" rel="stylesheet" href="../images/global/global.css" />
<link type="text/css" rel="stylesheet" href="../images/ucenter/ucenter.css" />

<script type="text/javascript" src="../js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="../js/dsgame.base.js"></script>
<script type="text/javascript" src="../js/dsgame.Tip.js"></script>

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
				充值
			</div>
			<ul class="tab-title">
				<li><a href="http://dsgame188.com/deposit/netbank"><span>银行转账</span></a></li>
				<li class="current"><a href="http://dsgame188.com/deposit/quick"><span>快捷充值</span></a></li>
			</ul>
		</div>
		<div class="content recharge-netbank">
			<div class="recharge-box">

				<form action="http://dsgame188.com/deposit/quick" method="post" id="J-form">
					<input type="hidden" name="_token" value="5S028bFotaZxBDg1Pjjhp4E5INwfHCJ9uSyNuTH1">
				<input type="hidden" name="deposit_mode" value="2">
				<table width="100%" class="table-field">
					<tbody><tr>
						<td width="120" align="right" valign="top"><span class="field-name">选择充值银行：</span></td>
						<td>
							<div class="bank_dropdown" tabindex="0">
								<p class="dropdown_toggle" data-toggle="dropdown">
									<i class="toggle_icon">选择银行</i>
									<span data-id=" " class="ico-bank UN-bank">请选择银行</span>
								</p>
								<div class="bank-list" id="J-bank-list">
									<label class="img-bank" for="J-bank-name-ICBC">
										<span data-id="1" class="ico-bank ICBC">中国工商银行</span>
									</label>
									<label class="img-bank" for="J-bank-name-CCB">
										<span data-id="2" class="ico-bank CCB">中国建设银行</span>
									</label>
									<label class="img-bank" for="J-bank-name-ABC">
										<span data-id="3" class="ico-bank ABC">中国农业银行</span>
									</label>
									<label class="img-bank" for="J-bank-name-BOC">
										<span data-id="4" class="ico-bank BOC">中国银行</span>
									</label>
									<label class="img-bank" for="J-bank-name-CMB">
										<span data-id="5" class="ico-bank CMB">招商银行</span>
									</label>
									<label class="img-bank" for="J-bank-name-BCOM">
										<span data-id="6" class="ico-bank BCOM">交通银行</span>
									</label>
									<label class="img-bank" for="J-bank-name-CMBC">
										<span data-id="7" class="ico-bank CMBC">中国民生银行</span>
									</label>
									<label class="img-bank" for="J-bank-name-ECITIC">
										<span data-id="8" class="ico-bank ECITIC">中信银行</span>
									</label>
									<label class="img-bank" for="J-bank-name-SPDB">
										<span data-id="9" class="ico-bank SPDB">上海浦东发展银行</span>
									</label>
									<label class="img-bank" for="J-bank-name-GDB">
										<span data-id="10" class="ico-bank GDB">广东发展银行</span>
									</label>
									<label class="img-bank" for="J-bank-name-PAB">
										<span data-id="11" class="ico-bank PAB">平安银行</span>
									</label>
									<label class="img-bank" for="J-bank-name-BEA">
										<span data-id="12" class="ico-bank BEA">东亚银行</span>
									</label>
									<label class="img-bank" for="J-bank-name-CIB">
										<span data-id="13" class="ico-bank CIB">兴业银行</span>
									</label>
									<label class="img-bank" for="J-bank-name-HXB">
										<span data-id="14" class="ico-bank HXB">华夏银行</span>
									</label>
									<label class="img-bank" for="J-bank-name-CEBB">
										<span data-id="15" class="ico-bank CEBB">中国光大银行</span>
									</label>
									<label class="img-bank" for="J-bank-name-PSBC">
										<span data-id="16" class="ico-bank PSBC">中国邮政储蓄银行</span>
									</label>
									<input name="bank" value="1" id="bank-name" type="hidden">
								</div>

							</div>
						</td>
					</tr>
					<tr>
						<td></td>
						<td>
							<table class="table border-table small-table">
								<thead>
									<tr>
										<th>最低限额（元）</th>
										<th>最高限额（元）</th>
										<th>充值时限（分钟）</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td><span class="c-important" data-money-format>2.00</span></td>
										<td><span class="c-important" data-money-format>2600.00</span></td>
										<td>30分钟</td>
									</tr>
								</tbody>
							</table>
						</td>
					</tr>
					<tr>
						<td align="right" valign="top"><span class="field-name">选择充值金额：</span></td>
						<td>
							<input type="text" class="input w-2 input-ico-money" id="J-input-money" name="amount">
							<br>
						   <!--  <span class="tip">充值额度限定：最低 <span id="J-money-min">2.00</span>,最高 <span id="J-money-max">70,000.00</span> 元</span> -->
						</td>
					</tr>
					<tr>
						<td align="right" valign="top">&nbsp;</td>
						<td>
							<input id="J-submit" class="btn" type="submit" value="   立即充值   ">
						</td>
					</tr>
				</tbody></table>
			</form>
			</div>
			<div class="recharge-help">
				<h3>常见问题</h3>
				<h4>为什么银行充值成功了无法到账？</h4>
				<p>
				平台填写金额必须和银行转账金额一致（不包含手续费），否则充值无法到账。
				</p>
				<h4>每次充值的额度限定是多少？</h4>
				<p>所有银行充值额度限定最低是 2.00 元，最高额度限定根据不同银行有不同的标准，具体可以查看相应银行的充值额度限定标准。</p>
			</div>
		</div>

	</div>
</div>

<?php include_once("../footer.php"); ?>

<script>
(function($){

	var bankCache = {"1":{"id":"1","identifier":"ICBC","name":"\u4e2d\u56fd\u5de5\u5546\u94f6\u884c","min":"2.00","max":"45000.00"},"2":{"id":"2","identifier":"CCB","name":"\u4e2d\u56fd\u5efa\u8bbe\u94f6\u884c","min":"2.00","max":"45000.00"},"3":{"id":"3","identifier":"ABC","name":"\u4e2d\u56fd\u519c\u4e1a\u94f6\u884c","min":"2.00","max":"45000.00"},"4":{"id":"4","identifier":"BOC","name":"\u4e2d\u56fd\u94f6\u884c","min":"2.00","max":"45000.00"},"5":{"id":"5","identifier":"CMB","name":"\u62db\u5546\u94f6\u884c","min":"2.00","max":"45000.00"},"6":{"id":"6","identifier":"BCOM","name":"\u4ea4\u901a\u94f6\u884c","min":"2.00","max":"45000.00"},"7":{"id":"7","identifier":"CMBC","name":"\u4e2d\u56fd\u6c11\u751f\u94f6\u884c","min":"2.00","max":"45000.00"},"8":{"id":"8","identifier":"ECITIC","name":"\u4e2d\u4fe1\u94f6\u884c","min":"2.00","max":"45000.00"},"9":{"id":"9","identifier":"SPDB","name":"\u4e0a\u6d77\u6d66\u4e1c\u53d1\u5c55\u94f6\u884c","min":"2.00","max":"45000.00"},"10":{"id":"10","identifier":"GDB","name":"\u5e7f\u4e1c\u53d1\u5c55\u94f6\u884c","min":"2.00","max":"45000.00"},"11":{"id":"11","identifier":"PAB","name":"\u5e73\u5b89\u94f6\u884c","min":"2.00","max":"45000.00"},"12":{"id":"12","identifier":"BEA","name":"\u4e1c\u4e9a\u94f6\u884c","min":"2.00","max":"50000.00"},"13":{"id":"13","identifier":"CIB","name":"\u5174\u4e1a\u94f6\u884c","min":"2.00","max":"45000.00"},"14":{"id":"14","identifier":"HXB","name":"\u534e\u590f\u94f6\u884c","min":"2.00","max":"45000.00"},"15":{"id":"15","identifier":"CEBB","name":"\u4e2d\u56fd\u5149\u5927\u94f6\u884c","min":"2.00","max":"45000.00"},"16":{"id":"16","identifier":"PSBC","name":"\u4e2d\u56fd\u90ae\u653f\u50a8\u84c4\u94f6\u884c","min":"2.00","max":"45000.00"}};
	var banks = $('#J-bank-list').children(),inputs = banks.find('input'),loadBankInfoById,buildingView,
		moneyInput = $('#J-input-money'),
		tip = new dsgame.Tip({cls:'j-ui-tip-b j-ui-tip-input-floattip'});

	loadBankInfoById = function(id, callback){
		var data = bankCache[id];
		callback(data);
	};
	buildingView = function(bankData){
		// $('#J-money-min').text(dsgame.util.formatMoney(Number(bankData['min'])));
		// $('#J-money-max').text(dsgame.util.formatMoney(Number(70,000.00)));//bankData['max']
		$('#J-input-money').val('');
		$('#J-input-password').val('');
	};

	// 选择银行卡下拉
	var $dropdown = $('.bank_dropdown');
	var $banklists = $dropdown.find('.bank-list');
	var initBankId = $('#bank-name').val();
	$dropdown.on({
		mousedown: function(e){
			if( $(this).hasClass('open') ) return false;
			$(this).addClass('open');
			// return false;
		}
		// 点击
		, click: function( e ){
			e.preventDefault();
		}
		// 失去焦点
		, blur: function( e ){
			console.log('失去焦点');
			$(this).removeClass('open');
		}
	});
	$banklists.find('label').on('click', function(){
		var $bank = $(this).find('.ico-bank');
		var value = $bank.data('id');

		// addClass/removeClass active
		$(this).siblings('.active').removeClass('active').end()
			.addClass('active');

		// replace html
		$('.dropdown_toggle .ico-bank').replaceWith( $bank.clone() );

		// change input value
		$('#bank-name').val( value );


		$dropdown.removeClass('open');

		//loadBankInfoById(value, buildingView);

	}).eq(0).trigger('click');


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
		tip.setText(v);
		tip.getDom().css({left:moneyInput.offset().left + moneyInput.width()/2 - tip.getDom().width()/2});
	});
	moneyInput.focus(function(){
		var v = $.trim(this.value);
		if(v == ''){
			v = '&nbsp;';
		}
		tip.setText(v);
		tip.show(moneyInput.width()/2 - tip.getDom().width()/2, tip.getDom().height() * -1 - 20, this);
	});
	moneyInput.blur(function(){
		var v = Number(this.value),
			//minNum = Number($('#J-money-min').text().replace(/,/g, '')),
			maxNum = Number('70,000.00'.replace(/,/g, ''))//Number($('#J-money-max').text().replace(/,/g, ''));
		//v = v < minNum ? minNum : v;
		v = v > maxNum ? maxNum : v;
		this.value = dsgame.util.formatMoney(v).replace(/,/g, '');
		tip.hide();
	});

	$('#J-submit').click(function(){
		var money = $('#J-input-money'),
			password = $('#J-input-password'),
			banks = $('input[name="bank"]').val();
			// bankCard = $('.choose-input-disabled');
		//if没有开启银行卡判断

		if(banks == undefined || banks == ''){
			alert('请选择充值银行');

			return false;
		}

		if($.trim(money.val()) == ''){
			alert('金额不能为空');
			money.focus();
			return false;
		}
		return true;
	});


})(jQuery);
</script>

</body>
</html>
