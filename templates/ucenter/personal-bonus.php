<!DOCTYPE HTML>
<html lang="en-US">
<head>
<meta charset="UTF-8">
<title>个人资料 -- CC彩票</title>
<link type="text/css" rel="stylesheet" href="../images/global/global.css" />
<link type="text/css" rel="stylesheet" href="../images/ucenter/ucenter.css" />

<script type="text/javascript" src="../js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="../js/dsgame.base.js"></script>
<script type="text/javascript" src="../js/dsgame.Timer.js"></script>
<script type="text/javascript" src="../js/dsgame.Mask.js"></script>
<script type="text/javascript" src="../js/dsgame.Message.js"></script>
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
			<div class="title-normal">我的奖金</div>
		</div>
		
		<div class="content">
			<dl class="bonus-item">
				<dt>重庆时时彩</dt>
				<dd class="bet-selected">
					<span class="bonus-desc">奖金组<span class="fs-15">1800</span></span>
					<a class="c-important" data-bonus-scan href="personal-bonus-detail.php">查看详情&gt;</a>
				</dd>
			</dl>
			<dl class="bonus-item">
				<dt>山东11选5</dt>
				<dd class="bet-selected">
					<span class="bonus-desc">奖金组<span class="fs-15">1800</span></span>
					<a class="c-important" data-bonus-scan href="personal-bonus-detail.php">查看详情&gt;</a>
				</dd>
			</dl>
			<dl class="bonus-item">
				<dt>3D</dt>
				<dd class="bet-selected">
					<span class="bonus-desc">奖金组<span class="fs-15">1800</span></span>
					<a class="c-important" data-bonus-scan href="personal-bonus-detail.php">查看详情&gt;</a>
				</dd>
			</dl>
			<dl class="bonus-item">
				<dt>P3/P5</dt>
				<dd class="bet-selected">
					<span class="bonus-desc">奖金组<span class="fs-15">1800</span></span>
					<a class="c-important" data-bonus-scan href="personal-bonus-detail.php">查看详情&gt;</a>
				</dd>
			</dl>
			<dl class="bonus-item">
				<dt>CC彩票时时彩</dt>
				<dd class="bet-selected">
					<span class="bonus-desc">奖金组<span class="fs-15">1800</span></span>
					<a class="c-important" data-bonus-scan href="personal-bonus-detail.php">查看详情&gt;</a>
				</dd>
			</dl>
			<dl class="bonus-item">
				<dt>CC彩票11选5</dt>
				<dd class="bet-selected">
					<span class="bonus-desc">奖金组<span class="fs-15">1800</span></span>
					<a class="c-important" data-bonus-scan href="personal-bonus-detail.php">查看详情&gt;</a>
				</dd>
			</dl>
			<dl class="bonus-item">
				<dt>黑龙江时时彩</dt>
				<dd class="bet-selected">
					<span class="bonus-desc">奖金组<span class="fs-15">1800</span></span>
					<a class="c-important" data-bonus-scan href="personal-bonus-detail.php">查看详情&gt;</a>
				</dd>
			</dl>
			<dl class="bonus-item">
				<dt>江西11选5</dt>
				<dd class="bet-selected">
					<span class="bonus-desc">奖金组<span class="fs-15">1800</span></span>
					<a class="c-important" data-bonus-scan href="personal-bonus-detail.php">查看详情&gt;</a>
				</dd>
			</dl>
			<dl class="bonus-item">
				<dt>新疆时时彩</dt>
				<dd class="bet-selected">
					<span class="bonus-desc">奖金组<span class="fs-15">1800</span></span>
					<a class="c-important" data-bonus-scan href="personal-bonus-detail.php">查看详情&gt;</a>
				</dd>
			</dl>
			<dl class="bonus-item">
				<dt>重庆11选5</dt>
				<dd class="bet-selected">
					<span class="bonus-desc">奖金组<span class="fs-15">1800</span></span>
					<a class="c-important" data-bonus-scan href="personal-bonus-detail.php">查看详情&gt;</a>
				</dd>
			</dl>
			<dl class="bonus-item">
				<dt>广东11选5</dt>
				<dd class="bet-selected">
					<span class="bonus-desc">奖金组<span class="fs-15">1800</span></span>
					<a class="c-important" data-bonus-scan href="personal-bonus-detail.php">查看详情&gt;</a>
				</dd>
			</dl>
			<dl class="bonus-item">
				<dt>江西时时彩</dt>
				<dd class="bet-selected">
					<span class="bonus-desc">奖金组<span class="fs-15">1800</span></span>
					<a class="c-important" data-bonus-scan href="personal-bonus-detail.php">查看详情&gt;</a>
				</dd>
			</dl>
		</div>
	</div>
</div>


<?php include_once("../footer.php"); ?>
<script>
(function($){
	// 查看奖金详情
	var mask = new dsgame.Mask(),
		miniwindow = new dsgame.MiniWindow({ cls: 'w-13 iframe-miniwindow' });

	var hideMask = function(){
		miniwindow.hide();
		mask.hide();
	};

	var getContent = function(url){
		return '<iframe src="' + url + '" id="bonus-scan-frame" ' +
		'width="100%" height="450" frameborder="0" allowtransparency="true" scrolling="no"></iframe>'
	}

	miniwindow.setTitle('玩法奖金详情');
	// miniwindow.showCancelButton();
	// miniwindow.showConfirmButton();
	miniwindow.showCloseButton();

	miniwindow.doNormalClose = hideMask;
	miniwindow.doConfirm     = hideMask;
	miniwindow.doClose       = hideMask;
	miniwindow.doCancel      = hideMask;

	$('[data-bonus-scan]').on('click', function(e){
		e.preventDefault();
		var $this = $(this),
			href = $this.attr('href');
		if( !href ) return false;
		miniwindow.setContent( getContent(href) );
		mask.show();
		miniwindow.show();
	});

})(jQuery);
</script>
</body>
</html>
















