<!DOCTYPE HTML>
<html lang="en-US">
<head>
<meta charset="UTF-8">
<title>提现 -- CC彩票</title>
<link type="text/css" rel="stylesheet" href="../images/global/global.css" />
<link type="text/css" rel="stylesheet" href="../images/ucenter/ucenter.css" />

<script type="text/javascript" src="../js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="../js/dsgame.base.js"></script>
<script type="text/javascript" src="../js/dsgame.Select.js"></script>
<script type="text/javascript" src="../js/dsgame.Tip.js"></script>
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
				提现
			</div>
		</div>

		<div class="content">
			<!-- <div class="prompt" style="background-position:170px center;padding:60px 0;padding-left:200px;">
				您还没有绑定银行卡， <a href="#" class="btn">立即绑定</a>
			</div> -->
			<?php
				$rand = rand(0,20);
				// $rand = 20;
			?>
			<?php if( $rand < 10 ){ ?>
			<!-- 未添加银行卡时 -->
			<div class="no-bank-card">
				<p class="alert-message"><i class="alert-icon"></i><span>添加一张银行卡开始提现吧</span></p>
				<a href="javascript:void(0);" data-add-bankcard>+  添加银行卡</a>
			</div>
			<?php }else{ ?>
			<!-- 已绑定有银行卡时 -->
			<div class="row-head">
				<p class="row-desc alert-message"><i class="alert-icon"></i><span>今日剩余提现次数：<span class="c-black">4/4</span></span></p>
				<p>尊敬的<span class="c-important">Terence</span>，您现在正在提现到您的银行卡，目前账户可用提现余额：<span data-money-format class="c-red fs-20">3434.12</span>元</p>
			</div>

			<table width="100%" class="table-field">
				<tr>
					<td class="text-right vertical-top">选择银行卡：</td>
					<td class="vertical-middle">
						<div class="card-info-list">
							<label class="img-bank">
								<span class="check-icon"></span>
								<span data-id="1" class="ico-bank ICBC">中国工商银行</span>
								<span>尾号：3705</span>
								<span>[ 特仑苏 ]</span>
							</label>
						</div>
						<div class="card-info-list">
							<label class="img-bank">
								<span class="check-icon"></span>
								<span data-id="1" class="ico-bank ICBC">中国工商银行</span>
								<span>尾号：3705</span>
								<span>[ 特仑苏 ]</span>
							</label>
						</div>
						<div class="card-info-list">
							<label class="img-bank disabled">
								<span class="check-icon"></span>
								<span data-id="2" class="ico-bank CMB">中国工商银行</span>
								<span>尾号：3705</span>
								<span>[ 特仑苏 ]</span>
							</label>
							<span class="card-info-tips c-gray">新绑定的银行卡<span class="c-black" data-countdown>1小时59分</span>后可用于提现</span>
							<input type="hidden" value="720" data-lefttime-second>
						</div>
						<div class="card-info-list">
							<label class="img-bank disabled">
								<span class="check-icon"></span>
								<span data-id="3" class="ico-bank CCB">中国工商银行</span>
								<span>尾号：3705</span>
								<span>[ 王阿萌 ]</span>
							</label>
							<span class="card-info-tips c-gray">新绑定的银行卡<span class="c-black" data-countdown>1小时59分</span>后可用于提现</span>
							<input type="hidden" value="7200" data-lefttime-second>
						</div>
						<input name="bank" value="12" id="J-bank-name" type="hidden">
						<a class="btn" href="javascript:void(0);" data-add-bankcard>+ 添加银行卡</a>
					</td>
				</tr>
				<tr>
					<td class="text-right">提现金额：</td>
					<td><input class="input w-3 input-ico-money" id="J-input-money" name="amount" type="text"></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td><input class="btn w-3" type="submit" value=" 下&nbsp;一&nbsp;步 " id="J-submit"></td>
				</tr>
			</table>

			<?php }	?>

		</div>

	</div>
</div>

<?php include_once("../footer.php"); ?>

<script>
$(function(){
	var $bankname = $('#J-bank-name');
	$('body').on('click', 'label.img-bank', function(){
		var $this = $(this);
		if( $this.hasClass('active') || $this.hasClass('disabled') ) return false;
		$('label.img-bank').removeClass('active');
		$this.addClass('active');
		var id = parseInt($this.find('.ico-bank').data('id')) || 0;
		$bankname.val(id);
	});
	var tip = new dsgame.Tip({cls:'j-ui-tip-b j-ui-tip-input-floattip'}),
		$moneyInput = $('#J-input-money');

	$moneyInput.keyup(function(e){
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
		tip.getDom().css({left:$moneyInput.offset().left + $moneyInput.width()/2 - tip.getDom().width()/2});
	});
	$moneyInput.focus(function(){
		var v = $.trim(this.value);
		if(v == ''){
			v = '&nbsp;';
		}
		tip.setText(v);
		tip.show($moneyInput.width()/2 - tip.getDom().width()/2, tip.getDom().height() * -1 - 20, this);
	});
	$moneyInput.blur(function(){
		var v = Number(this.value),
			//minNum = Number($('#J-money-min').text().replace(/,/g, '')),
			maxNum = Number('70,000.00'.replace(/,/g, ''))//Number($('#J-money-max').text().replace(/,/g, ''));
		//v = v < minNum ? minNum : v;
		v = v > maxNum ? maxNum : v;
		this.value = dsgame.util.formatMoney(v).replace(/,/g, '');
		tip.hide();
	});

	// 倒计时
	$('[data-countdown]').each(function(){
		var $this = $(this),
			$parent = $this.parents('.card-info-list:eq(0)'),
			lefttime = Number($parent.find('[data-lefttime-second]').val());

		(function () {
			if( lefttime <= 0 ){
				// 倒计时结束
				$parent.find('.img-bank').removeClass('disabled');
				$parent.find('.card-info-tips').hide();
			}
			var h = Math.floor(lefttime/3600),
				m = Math.floor((lefttime%3600)/60),
				s = lefttime%60,
				html = '';
			m = m < 10 ? '0' + m : '' + m;
			s = s < 10 ? '0' + s : '' + s;
			html = m + '分' + s + '秒';
			if( h > 0 ){
				html = h + '小时' + html;
			}
			$this.html(html);
			lefttime--;
			setTimeout(arguments.callee, 1000);
		})();

	});

});
</script>

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
