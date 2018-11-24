<!DOCTYPE HTML>
<html lang="en-US">
<head>
<meta charset="UTF-8">
<title>汇款确认 -- 充值 -- CC彩票</title>
<link type="text/css" rel="stylesheet" href="../images/global/global.css" />
<link type="text/css" rel="stylesheet" href="../images/ucenter/ucenter.css" />

<script type="text/javascript" src="../js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="../js/dsgame.base.js"></script>
<script type="text/javascript" src="../js/dsgame.Select.js"></script>
<script type="text/javascript" src="../js/ZeroCLipboard.js"></script>
<script type="text/javascript" src="../js/dsgame.Mask.js"></script>
<script type="text/javascript" src="../js/dsgame.Message.js"></script>

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
				汇款确认
			</div>
		</div>
		
		<div class="content clearfix">
			<div class="recharge-box">
				<div class="row-head">
					<div class="item-title"><i class="item-icon-8"></i>充值确认</div>
					<div class="item-info">
						<p>
							<label>订单金额</label>
							<dfn>￥</dfn>
							<span class="c-important" data-money-format style="font-size:20px;">10243.00</span>
						</p>
						<p>
							<label>平台收款银行</label>
							<!-- <label class="img-bank" for="J-bank-name-CMB" style="cursor:default;">
								<input name="bank[]" id="J-bank-name-CMB" type="radio" style="visibility:hidden;" />
								<span class="ico-bank CMB"></span>
							</label> -->
							<span class="ico-bank CMB"></span>
							您目前选择的是 <span class="c-important">中国工商银行</span> 跨行汇款到 <span class="c-important">招商银行</span> 充值服务
						</p>
					</div>
				</div>
				<div class="item-detail">
					<div class="item-title">
						<i class="item-icon-9"></i>收款方信息
						<span class="item-tips">以下信息是确保您充值到账的重要信息</span>
					</div>
					<div class="item-info">
						<table width="100%" class="table-field" id="J-table">
							<tr>
							  <td align="right" valign="top">收款账户名：</td>
							  <td>
								<span class="field-value-width data-copy">
								 张振兴
								 </span>
								 <input type="button" class="btn btn-small" value="点击复制" id="J-button-name" />
							  </td>
						  </tr>
							<tr>
							  <td align="right" valign="top">收款账号：</td>
							  <td>
									<span class="field-value-width data-copy">6225 8820 1946 1448
									</span>
									<input type="button" class="btn btn-small" value="点击复制" id="J-button-card" />
							  </td>
						  </tr>
							<tr>
							  <td align="right" valign="top">开户城市：</td>
							  <td>
								<span class="field-value-width data-copy">广州分行东风支行</span>
							  </td>
						  </tr>
							<tr>
							  <td align="right" valign="top">订单金额：</td>
							  <td>
								<span class="field-value-width" data-money-format>5,475.00</span>
								<span class="field-value-width data-copy" style="display:none;">5,475.00</span>
								<input type="button" class="btn btn-small" value="点击复制" id="J-button-money" />
							  </td>
						  </tr>
							<tr>
							  <td align="right" valign="top">附言(充值订单号)：</td>
							  <td>
								<span class="field-value-width">
									<span class="c-red data-copy">I9AH聚美优品</span>
								</span>
								<input type="button" class="btn btn-small" value="点击复制" id="J-button-msg" />
								<span class="ui-text-prompt">(中信跨行附言区分大小写，请正确复制)</span>
							  </td>
						  </tr>
							<tr>
							  <td align="right" valign="top"></td>
							  <td>
								<span class="f12">您也可以复制打开链接：<a class="link-url" href="#">https://e.bank.ecitic.com/perbank5/signIn.do</a></span>
							  </td>
						  </tr>
							<tr>
							  <td align="right" valign="top">&nbsp;</td>
							  <td>
								<a href="#" class="btn btn-important">确认，去银行页面充值</a>
							  </td>
						  </tr>
						</table>
					</div>
				</div>
			</div>
			<div class="recharge-sidebar">
				<div class="item-title"><i class="item-icon-14"></i>充值倒计时</div>
				<div class="item-info">
					<p style="float:right;margin-top:30px;width:150px;">为保障充值成功，请在30分钟之内完成充值。</p>
					<div id="residual-issue" style="margin-right:150px;"></div>
					<input type="hidden" value="1800" id="J-time-second" />
				</div>
			</div>
			<div class="prompt-text" style="clear:both;">
				<div class="item-title"><i class="item-icon-15"></i>充值说明</div>
				<ol class="item-info">
					<li>1、请点击中信银行页面“转账支付”—“跨行转账”。</li>
					<li>2、在汇款页面中，“收款银行开户行名称”请选择“招商银行股份有限公司”。</li>
					<li>3、请务必复制“充值订单号”到中信银行汇款页面的“摘要”栏中进行粘帖。 (建议采取键盘复制功能 CTRL+V) ，否则充值将无法到账。</li>
					<li>4、充值订单号由系统随机生成，一个订单号只能充值一次，请您在申请到充值信息的15分钟内进行充值操作。超过15分钟或重复使用充值信息将无法到账。</li>
					<li>5、收款账户名和账号会不定期更换，请在获取最新信息后充值，如果充值到旧卡号，可能会造成您的损失。</li>
					<li>6、“订单金额”与网银转账金额不符，充值将无法到账。</li>
					<li>7、充值金额为100元，充值金额小于规定金额，充值将无法到账。</li>
				</ol>					
			</div>
		</div>
		
	</div>
</div>

<?php include_once("../footer.php"); ?>

<script src="../js/raphael-min.js"></script>
<script>
$(function(){
	ZeroClipboard.setMoviePath('../js/ZeroClipboard.swf');
	
	var clip_name = new ZeroClipboard.Client(),
		clip_card = new ZeroClipboard.Client(),
		clip_money = new ZeroClipboard.Client(),
		clip_msg = new ZeroClipboard.Client(),
		table = $('#J-table'),
		fn = function(client){
			var el = $(client.domElement),value = $.trim(el.parent().find('.data-copy').text());
			client.setText(value);
			alert('复制成功:\n\n' + value);
		};
	
	clip_name.setCSSEffects( true );
	clip_card.setCSSEffects( true );
	clip_money.setCSSEffects( true );
	clip_msg.setCSSEffects( true );
	
	clip_name.addEventListener( "mouseUp", fn);
	clip_card.addEventListener( "mouseUp", fn);
	clip_money.addEventListener( "mouseUp", fn);
	clip_msg.addEventListener( "mouseUp", fn);
	
	clip_name.glue('J-button-name');
	clip_card.glue('J-button-card');
	clip_money.glue('J-button-money');
	clip_msg.glue('J-button-msg');

	// 倒计时
	var cpoint = 50,
		r = Raphael("residual-issue", cpoint*2, cpoint*2),
		strokeWidth = 5,
		R = cpoint,
		init = true,
		lefttime = count = Number($('#J-time-second').val()),
		param = {stroke: "#fff", "stroke-width": strokeWidth},
		marksAttr = {fill: "#444", stroke: "none"},
		txtAttr1 = {font: '28px "Helvetica Neue","Hiragino Sans GB","Microsoft Yahei",arial', fill: '#e0562c'},
		txtAttr2 = {font: '12px "Helvetica Neue","Hiragino Sans GB","Microsoft Yahei",arial', fill: '#666'};
	// Custom Attribute
	r.customAttributes.arc = function (value, total, R) {
		var alpha = 360 / total * value,
			a = (90 - alpha) * Math.PI / 180,
			x = cpoint + R * Math.cos(a),
			y = cpoint - R * Math.sin(a),
			// color = "hsb(".concat(Math.round(R) / R, ",", value / total, ", .75)"),
			color = '#ce481f',
			path;
		if (total == value) {
			path = [["M", cpoint, cpoint - R], ["A", R, R, 0, 1, 1, R-0.01, cpoint - R]];
		} else {
			path = [["M", cpoint, cpoint - R], ["A", R, R, 0, +(alpha > 180), 1, x, y]];
		}
		return {path: path, stroke: color};
	};
	// 总期数圆环
	var ra = r.circle(cpoint, cpoint, R).attr({stroke: "none", fill: '#ebf2fa'});
	// 背景圆环
	var rc = r.circle(cpoint, cpoint, R-strokeWidth).attr({stroke: "none", fill: '#fff'});
	// 已过期数圆环
	var rr = r.path().attr(param).attr({arc: [0, cpoint, R]});
	// 剩余期数（文字）
	var rt = r.text(cpoint, cpoint-10, 256).attr(txtAttr1);
	// 剩余期数（描述）
	var rd = r.text(cpoint, cpoint+15, '充值倒计时').attr(txtAttr2);


	function updateVal(value, total, R, hand, timeArr) {
		var color = "hsb(".concat(Math.round(R) / R, ",", value / total, ", .75)");
		if (init) {
			hand.animate({arc: [value, total, R]}, 900, ">");
		} else {
			if (!value || value == total) {
				value = total;
				hand.animate({arc: [value, total, R]}, 750, "bounce", function () {
					hand.attr({arc: [0, total, R]});
				});
			} else {
				hand.animate({arc: [value, total, R]}, 750, "elastic");
			}
		}
		var timeTxt = timeArr[0] + timeArr[1] + ':' + timeArr[2] + timeArr[3];
		rt.attr({text: timeTxt, fill: '#e0562c'});
		// rt.attr({text: total - value, fill: Raphael.getRGB(color).hex});
		// html[id].innerHTML = (value < 10 ? "0" : "") + value;
		// html[id].style.color = Raphael.getRGB(color).hex;
	}
	function showTimeout(){
		console.log('done!')
		// location.href = 'recharge-netbank.php';
	}
	(function () {
		if( lefttime < 0 ){
			showTimeout();
		}else{
			m = Math.floor(lefttime/60);
			s = lefttime%60;

			m = m < 10 ? '0' + m : '' + m;
			s = s < 10 ? '0' + s : '' + s;
			timeStr = '' + m + s;
			timeArr = timeStr.split('');

			updateVal(lefttime--, count, R-strokeWidth/2, rr, timeArr);
			setTimeout(arguments.callee, 1000);
			init = false;
		}
	})();
});
</script>
</body>
</html>
