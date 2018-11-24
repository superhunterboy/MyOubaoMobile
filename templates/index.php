<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>CC彩票 - 首页</title>
	<link rel="stylesheet" href="images/global/global.css">
	<link rel="stylesheet" href="images/index/index.css">
	<script src="js/jquery-1.9.1.min.js"></script>
	<script src="js/jquery.easing.1.3.js"></script>
	<script src="js/jquery.cycle2.min.js"></script>
	<script src="js/jquery.marquee.min.js"></script>
	<script src="js/global.js"></script>
	<!--<script src="js/jquery.cycle2.carousel.min.js"></script>-->
	<script src="js/dsgame.base.js"></script>
	<script src="js/dsgame.Ernie.js"></script>
	<script src="js/dsgame.Mask.js"></script>
	<script src="js/dsgame.Message.js"></script>
	<!-- // <script src="js/dsgame.Tab.js"></script> -->
</head>
<body>

<?php include_once("header.php"); ?>

<div id="banner" class="wrap">
	<div class="cycle-slideshow"
		data-cycle-slides="> a"
		data-cycle-pager="> .cycle-pager"
		data-cycle-prev="> .cycle-prev"
		data-cycle-next="> .cycle-next"
		data-cycle-fx="fade"
		data-cycle-timeout="4000"
		data-cycle-random="false"
		data-cycle-loader="wait"
		data-cycle-speed="800"
		data-cycle-log="false"
	>
		<a href=""><img src="images/index/banner.jpg"></a>
		<a href=""><img src="images/index/banner.jpg"></a>
		<div class="cycle-pager"></div>
		<!-- <span class="cycle-prev">&#139;</span> -->
		<!-- <span class="cycle-next">&rsaquo;</span> -->
	</div>

	<div id="ucenter">
		<div class="user-avatar">
			<!-- <img src="images/index/avatar.png" alt=""> -->
			<i data-ds-avatar="1"></i>
			<div class="user-info">
				<h2><a href="">取金代言人特能作</a>，开始您的取金之旅吧</h2>
				<p><a class="right" href="">提高</a>账户安全评分：<span id="J-safety-score"></span></p>
				<div data-safety="4" class="safety-percent"><span></span></div>
				<p>
                    <!-- <a class="user-action-1" href="" title="修改邮箱"></a> -->
                    <a class="user-action-2 active" href="" title="修改密码"></a>
                    <a class="user-action-3" href="" title="修改资金密码"></a>
                    <a class="user-action-4" href="" title="银行卡管理"></a>
                </p>
			</div>
		</div>
		<div class="user-balance left">
			<h3><a class="right" href="">查看资金明细</a>账户余额</h3>
			<input id="J-user-balance-value" type="hidden" value="12131.0">
			<div class="balance-box">
				<ul>
				<?php for( $i=0; $i<9; $i++ ){ ?>
					<li>
					<?php for($j=0; $j<10; $j++){ ?>
						<span><?=$j?></span>
					<?php } ?>
					</li>
				<?php }	?>
					<li class="money-dot"><span>.</span></li>
				<?php for( $i=0; $i<4; $i++ ){ ?>
					<li class="money-small">
					<?php for($j=0; $j<10; $j++){ ?>
						<span><?=$j?></span>
					<?php } ?>
					</li>
				<?php }	?>
				</ul>
				<div class="balance-hammer">
					<div class="hammer-up"></div>
					<div class="hammer-down"></div>
				</div>
			</div>
			<div class="account-actions">
				<a href="" class="u-button u-button-highlight recharge"><i class="mkg-icon"></i>充值</a>
				<a href="" class="u-button withdraw"><i class="mkg-icon"></i>提现</a>
				<a href="" class="u-button card-manage"><i class="mkg-icon"></i>银行卡</a>
			</div>
		</div>
		<div class="user-hongbao left">
			<h3><a class="right" href="">3个</a>可领红包</h3>
			<a href="" class="hongbao-bg">我的红包</a>
		</div>
	</div>
</div>

<div id="main-content" class="wrap">
	<div class="wrap-inner">
		<div class="main-left left">

			<div class="ui-box notice-board">
				<div class="ui-box-top">
					<a class="right" href="">更多>></a><h2>官方公告</h2>
				</div>
				<ul class="news-list">
					<li><span class="time">05/17</span><a href="">天天拿红包，奖金您做主！<i class="c-important">New</i></a></li>
					<li><span class="time">05/26</span><a href="">官方未开奖，重庆时时彩撤单通知</a></li>
					<li><span class="time">05/24</span><a href="">官方未开奖，重庆时时彩撤单通知</a></li>
					<li><span class="time">05/23</span><a href="">官方未开奖，重庆时时彩撤单通知</a></li>
					<li><span class="time">05/23</span><a href="">CC彩票娱乐平台暂停充值 、提现公告</a></li>
					<li><span class="time">05/20</span><a href="">施主请注意，避免被山寨平台钓鱼！</a></li>
					<li><span class="time">05/19</span><a href="">官方未开奖，重庆时时彩撤单通知</a></li>
					<li><span class="time">05/19</span><a href="">官方未开奖，重庆时时彩撤单通知</a></li>
					<!-- <li class="no-data">暂未数据</li> -->
				</ul>
			</div>

		</div>
		<div class="main-right right">
			<div class="ui-box game-lists left">
				<div class="ui-box-top">
					<h2>CC彩票列表</h2>
				</div>
				<ul class="game-wrap clearfix">
					<li>
						<h3>CC彩票官方游戏</h3>
						<div class="games-box">
							<a href="">CC彩票分分彩<i class="game-24h"></i><i class="ds-game">Z</i></a>
							<a href="">CC彩票11选5<i class="game-24h"></i><i class="ds-game">Z</i></a>
						</div>
					</li>
					<li>
						<h3>时时彩</h3>
						<div class="games-box">
							<a href="">重庆时时彩<i class="hot-game">H</i></a>
							<a href="">黑龙江时时彩<i class="hot-game">H</i></a>
							<a href="">天津时时彩</a>
							<a href="">新疆时时彩</a>
							<a href="">江西时时彩</a>
						</div>
					</li>
					<li>
						<h3>11选5</h3>
						<div class="games-box">
							<a href="">山东11选5<i class="hot-game">H</i></a>
							<a href="">江西11选5</a>
							<a href="">广东11选5</a>
						</div>
					</li>
					<li>
						<h3>其他游戏</h3>
						<div class="games-box">
							<a href="">江苏快三<i class="new-game">N</i></a>
							<a href="">3D</a>
							<a href="">排列五</a>
						</div>
					</li>
				</ul>
				<ul class="game-tips">
					<li><i class="ds-game">Z</i>官方游戏</li>
					<li><i class="new-game">N</i>最新游戏</li>
					<li><i class="hot-game">H</i>热门游戏</li>
				</ul>
			</div>

			<div class="ui-box ds-honor left">
				<div class="ui-box-top">
					<h2>荣誉榜</h2>
				</div>
				<div class="honor-bg"></div>
				<div class="winner-list">
					<div class="winner-scroll-warp J-prize-marquee">
						<ul>
							<li>恭喜 baymax1***** 在CC彩票分分彩<br>喜中<span class="color-highlight">1,000.00</span>元</li>
							<li>恭喜 baymax2***** 在CC彩票分分彩<br>喜中<span class="color-highlight">1,000.00</span>元</li>
							<li>恭喜 baymax3***** 在CC彩票分分彩<br>喜中<span class="color-highlight">1,000.00</span>元</li>
							<li>恭喜 baymax4***** 在CC彩票分分彩<br>喜中<span class="color-highlight">1,000.00</span>元</li>
							<li>恭喜 baymax5***** 在CC彩票分分彩<br>喜中<span class="color-highlight">1,000.00</span>元</li>
						</ul>
					</div>
				</div>
			</div>

		</div>

	</div>

</div>

<?php include_once("footer.php"); ?>

<!-- <div class="pop" id="popWindow" style="display:none;">
	<div class="pop-hd">
		<a href="#" class="pop-close"></a>
		<h3 class="pop-title">标题</h3>
	</div>
	<div class="pop-bd">
		<div class="pop-content">
			<i class="ico-error"></i>
			<p class="pop-text">您的资金密码错误，暂时不能提现</p>
		</div>
		<div class="pop-btn">
			<input type="button" value="确 定" class="btn">
			<input type="button" value="取 消" class="btn btn-normal">
		</div>
	</div>
</div> -->
<script type="text/javascript">
(function(){
	if ($('#popWindow').length) {
		var popWindow = new dsgame.Message();
		var data = {
			title          : '提示',
			content        : $('#popWindow').find('.pop-bd > .pop-content').html(),
			closeIsShow    : true,
			closeButtonText: '关闭',
			closeFun       : function() {
				this.hide();
			}
		};
		popWindow.show(data);
	}
})();
</script>

<script>
$(function(){
	// 安全评分
	var $safetyPercent = $('#ucenter [data-safety]'),
		$score = $('#J-safety-score'),
		$safetySpan = $safetyPercent.find('span'),
		safetyScore = parseInt($safetyPercent.data('safety')) || 0,
		score = safetyScore / 4 * 100;
	$score.text( score );
	if( score >= 100 ){
		score = 100;
		$safetySpan.css({'background-color': 'green'});
	}
	$safetySpan.animate({
		width: score + '%'
	}, 1000, function(){
		// if( score >= 100 ){
		// 	$safetySpan.animate({
		// 		opacity: 0
		// 	}, function(){
		// 		$safetySpan.css({'background-color': 'green'}).animate({
		// 			opacity: 1
		// 		});
		// 	});
		// }
	});


	// 账户余额
	var ernie,
		$button = $('.balance-hammer'),
		nums = $.trim($('#J-user-balance-value').val()).replace('.', ''),
		numStr = '0000000000000', // '000,000,000.0000'
		locked = false;

	nums = numStr.substr(0, numStr.length - nums.length) + nums;
	nums = nums.split('');
	ernie = new dsgame.Ernie({
		dom      : $('.balance-box li:not(".money-dot")'),
		height   : 24,
		length   : 10,
		callback :function(){
			$button.find('.hammer-down').hide();
			$button.find('.hammer-up').show();
		}
	});

	$button.on('click', function(){
		if(locked){
			return;
		}
		$.ajax({
			url:'/users/user-monetary-info',
			//type: 'POST',
			dataType:'json',
			beforeSend:function(){
				locked = true;
				$button.find('.hammer-up').hide();
				$button.find('.hammer-down').show();
				ernie.start();
			},
			success:function(data){
				if(Number(data['isSuccess']) == 1){
					var monetary = '' + data['data']['available']; // isAgent ? data['data']['team_turnover'] : data['data']['available']
					var decimals = '0000';
					monetary = monetary.split('.');
					if( monetary[1] ){
						decimals = (monetary[1] + '0000').substr(0,4);
					}
					var num = monetary[0] + decimals;
					monetary = monetary[0] + '.' + decimals;
					num = numStr.substr(0, numStr.length - num.length) + num;
					ernie.stop(num.split(''));
					$('[data-user-account-balance]').html( formatMoney(monetary) );
				}
			},
			complete:function(){
				locked = false;
			}
		});
	});
	ernie.start();
	ernie.stop(nums);

	function formatMoney(num) {
		var num = Number(num),
			re = /(-?\d+)(\d{3})/;
		if (Number.prototype.toFixed) {
			num = (num).toFixed(2)
		} else {
			num = Math.round(num * 100) / 100
		}
		num = '' + num;
		while (re.test(num)) {
			num = num.replace(re, "$1,$2")
		}
		return num
	}

	// 获奖名单滚动
	$('.J-prize-marquee').marquee({
		auto: true,
		interval: 3000,
		speed: 1000,
		showNum: 1,
		stepLen: 1,
		type: 'vertical'
	});

});
</script>

</body>
</html>