	<div id="header" class="wrap">
		<div class="wrap-inner">
			<a href="/" id="logo">CC彩票</a>
			<div class="right">
				<div class="top-user">
					欢迎回来，幕后大老板，继续赢取真金吧！
					<a href="" class="logout">我的红包</a>
					<a href="" class="logout">站内信</a>
					<a href="" class="logout">安全退出</a>
				</div>
				<ul class="top-account">
					<li class="top-account-balance">余额：<span data-user-account-balance>1,890.0000</span> 元<i data-refresh-balance></i></li>
					<li class="top-account-deposit">
						<a href="">
							<i></i><span>充值</span>
					</a></li>
					<li class="top-account-withdraw">
						<a href="">
							<i></i><span>提现</span>
					</a></li>
					<!-- 如果是代理显示 -->
					<li class="top-account-transfer">
						<a href="">
							<i></i><span>转账</span>
					</a></li>
				</ul>
			</div>
		</div>
	</div>
	
	<script>
	$(function(){
		$('[data-refresh-balance]').on('click', function() {
			var me = this;
			if ($(me).hasClass('onhandled')) return false;
			$(me).addClass('onhandled');

			// $.get(balanceUrl, function(resp) {
			// 	var resp = $.parseJSON(resp);
			// 	if (resp.isSuccess != 0 && resp.data.available) {
			// 		var b = formatMoney(resp.data.available);
			// 		//$('.ui-balance[data-balance-type="html"]').html(handleBalance(b));
			// 		$('[data-user-account-balance]').html(b);
			// 	} else {
			// 		alert(resp.msg || '网络繁忙请稍后再试');
			// 	}
			// 	$(me).removeClass('onhandled');
			// });
			return false;
		}).trigger('click');
	});
	</script>

	<div id="nav" class="wrap">
		<div class="wrap-inner">
			<ul class="nav-content">
				<li>
					<a class="nav-home" href="">
						<i></i>
						<span>首页</span>
					</a>
				</li>
				<li data-gamelist>
					<a class="nav-lobby" href="">
						<i></i>
						<span>游戏大厅<b class="caret"></b></span>						
					</a>
				</li>
				<li>
					<a class="nav-fund" href="">
						<i></i>
						<span>资金明细</span>
					</a>
				</li>
				<li>
					<a class="nav-record " href="">
						<i></i>
						<span>游戏记录</span>
					</a>
				</li>
				<li>
					<a class="nav-number" href="">
						<i></i>
						<span>追号记录</span>
					</a>
				</li>
				<!-- <li>
					<a class="nav-lottery" href="">
						<i></i>
						<span>开奖走势</span>
					</a>
				</li>
				<li>
					<a class="nav-bonus" href="">
						<i></i>
						<span>奖金详情</span>
					</a>
				</li> -->
				<li>
					<a class="nav-account" href="">
						<i></i>
						<span>账户资料</span>
					</a>
				</li>
				<li>
					<a class="nav-bankcard" href="">
						<i></i>
						<span>银行卡管理</span>
					</a>
				</li>
				<!-- 以下为玩家显示 -->
				<!-- <li>
					<a class="nav-message" href="">
						<i></i>
						<span>站内信</span>
					</a>
				</li>
				<li>
					<a class="nav-notice" href="">
						<i></i>
						<span>公告</span>
					</a>
				</li> -->
				<!-- 以下为代理 -->
				<li>
					<a class="nav-form" href="">
						<i></i>
						<span>团队报表</span>
					</a>
				</li>
				<li>
					<a class="nav-agency" href="">
						<i></i>
						<span>用户管理</span>
					</a>
				</li>
				<!-- <li>
					<a class="nav-help" href="">
						<i></i>
						<span>帮助中心</span>
					</a>
				</li> -->
			</ul>
		</div>
		<div class="nav-game-lists">
			<div class="nav-arrow"></div>
			<ul class="clearfix">
				<li>
					<h3>时时彩</h3>
					<div class="list-link">
						<a class="hot-game" href="../userpublic/buy/bet/13">CC彩票分分彩</a>
						<a href="../userpublic/buy/bet/1">重庆时时彩</a>
						<a href="../userpublic/buy/bet/3">黑龙江时时彩</a>
						<a href="../userpublic/buy/bet/5">江西时时彩</a>
						<a href="../userpublic/buy/bet/6">新疆时时彩</a>
						<a href="../userpublic/buy/bet/7">天津时时彩</a>
					</div>
				</li>
				<li>
					<h3>11选5</h3>
					<div class="list-link">
						<a class="hot-game" href="../userpublic/buy/bet/14">CC彩票11选5</a>
						<a href="../userpublic/buy/bet/2">山东11选5</a>
						<a href="../userpublic/buy/bet/8">江西11选5</a>
						<a href="../userpublic/buy/bet/9">广东11选5</a>
						<a href="../userpublic/buy/bet/10">重庆11选5</a>
					</div>
				</li>
				<li>
					<h3>其他游戏</h3>
					<div class="list-link">
						<a class="hot-game" href="../userpublic/buy/bet/11">骰宝江苏快三</a>
						<a href="../userpublic/buy/bet/11">3D</a>
						<a href="../userpublic/buy/bet/12">P3/P5</a>
					</div>
				</li>
			</ul>
		</div>
	</div>

	<script>
	$(function(){
		var $navHandler = $('#nav li[data-gamelist] > a'),
			$navList = $('#nav .nav-game-lists').fadeOut('fast'),
			$lotteryUrl = '{{URL::full()}}';

		// Hover下拉
		$navHandler.hover(function(){
			var $t = $(this),
				timerOut = $t.data('timerOut');
			if( timerOut ){
				clearTimeout(timerOut);
			}
			var timerIn = setTimeout(function(){
				$t.addClass('active');
				$navList.fadeIn('fast');
			}, 300);
			$t.data('timerIn', timerIn);
		}, function(){
			var $t = $(this),
				timerIn = $t.data('timerIn');
			if( timerIn ){
				clearTimeout(timerIn);
			}
			var timerOut = setTimeout(function(){
				$t.removeClass('active');
				$navList.fadeOut('fast');
			}, 300);
			$t.data('timerOut', timerOut);
		}).on('click', function(){
			return false;
		});

		$navList.hover(function(){
			if( $navList.is(':visible') ){
				var timerOut = $navHandler.data('timerOut');
				if( timerOut ){
					clearTimeout(timerOut);
				}
			}else{
				$navHandler.fadeIn('fast');
			}
		}, function(){
			if( $navList.is(':visible') ){
				var timerOut = setTimeout(function(){
					$navHandler.removeClass('active');
					$navList.fadeOut('fast');
				}, 300);
				$navHandler.data('timerOut', timerOut);
			}
		});

		// 当前游戏高亮
		$('.list-link-box a').each(function(i){
			if($(this).attr('href') == $lotteryUrl){
				$(this).addClass('active')
			};
		});

		// 
		$('[data-money-format]').each(function(){
			var $this = $(this);
				html = $this.html(),
				re = /(\d+)\.(\d+)/,
				fontSize = parseInt($this.css('fontSize'));
			// console.log(fontSize);
			if( fontSize <= 12 ){
				$this.css({ 'font-size': '14px' });
			}
			html = html.replace(re, '$1' + '.' + '<small>' + '$2' + '</small>');
			$this.html(html);
		});
	});
	</script>