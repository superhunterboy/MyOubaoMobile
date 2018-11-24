<div id="header" class="wrap">
	<div class="wrap-inner">
		<div class="left top-nav">
			<!-- 用户中心 -->
			<div class="top-nav-user">
				<em>欢迎您,&nbsp;&nbsp;</em>
				<a href="{{ route('users.user') }}" class="top-nav-toggle" data-overdropdown="handler">
					<span>{{ Session::get('nickname') }}</span>
					<i class="caret"></i>
				</a>
				<div class="top-nav-menu" data-overdropdown="dropdown">
					<!-- <p class="text-right">
						<a href="{{ route('users.user') }}">个人中心</a>
						<span>｜</span>
						<a href="{{ route('logout') }}">退出</a>
					</p> -->
					<div class="top-user-links clearfix">
						<a href="{{ route('users.change-password') }}" class="tul-link1">
							<i></i>
							<span>登录密码</span>
						</a>
						<a href="{{ route('users.change-fund-password') }}" class="tul-link2">
							<i></i>
							<span>资金密码</span>
						</a>
						<a href="{{ route('users.personal') }}" class="tul-link3">
							<i></i>
							<span>修改法号</span>
						</a>
						<a href="{{ route('bank-cards.index') }}" class="tul-link4">
							<i></i>
							<span>银行卡</span>
						</a>
						<a href="{{ route('user-activity-user-prizes.index') }}" class="tul-link5">
							<i></i>
							<span>我的红包</span>
						</a>
						<a href="{{ route('user-user-prize-sets.game-prize-set') }}" class="tul-link6">
							<i></i>
							<span>我的奖金组</span>
						</a>
					</div>
				</div>
				<!-- <a href="{{ route('users.user') }}">个人中心</a>
				<em>|</em> -->
				<a class="highlight-color" href="{{ route('logout') }}">退出</a>
			</div>
			<!-- <div class="top-nav-user">
				<em>欢迎您,</em>
				<a href="{{ route('users.user') }}" class="top-nav-toggle">
					<span>{{ Session::get('nickname') }}</span>
				</a>
				<a href="{{ route('logout') }}">退出</a>
			</div> -->
			<!-- 站内信 -->
			<div class="top-nav-msg">
				<a href="{{ route('station-letters.index') }}" class="top-nav-toggle" data-overdropdown="handler">
					<i></i>
					<span>站内信<b id="J-top-msg-num" class="highlight-color"></b></span>
					<em class="caret"></em>
				</a>

				<div class="top-nav-menu" data-overdropdown="dropdown" id="J-top-msg-box"></div>


			</div>
			<!-- 我的红包 -->
			<!-- <div class="top-nav-hongbao">
				<a href="{{ route('user-activity-user-prizes.index') }}" class="top-nav-toggle">
					<i></i>
					<span>我的红包</span>
				</a>
			</div> -->
		</div>
		<div class="right">
			<ul class="top-account">
				<li class="top-account-balance">
					<span class="balance-a" style="display:none;">余额：<span data-user-account-balance class="highlight-color">0</span> 元<i data-refresh-balance></i></span>
					<span class="balance-b" style="display:none;">余额已隐藏</span>
					<span class="balance-toggle highlight-color">隐藏</span>
				</li>
				<li class="top-account-deposit">
					<a href="{{ route('user-recharges.quick', $iDefaultPaymentPlatformId) }}">
						<i></i><span>充值</span>
				</a></li>
				<li class="top-account-withdraw">
					<a href="{{ route('user-withdrawals.withdraw') }}">
						<i></i><span>提款</span>
				</a></li>
				@if (Session::get('is_agent'))
				<li class="top-account-transfer">
					<a href="{{route('transfer.transfer')}}">
						<i></i><span>转账</span>
				</a></li>
				@endif
				<li class="top-account-gm">
					<a data-call-center href="http://kefu.qycn.com/vclient/chat/?websiteid=121683" target="_blank">在线客服</a>
				</li>
			</ul>
		</div>
	</div>
</div>

<script>
$(function() {
	// 顶部用户菜单下拉
	$('.top-nav-user, .top-nav-msg').overdropdown({
		activeClass: 'top-nav-toggle-active',
		handlerIsLink: true
	});
                // 游戏大厅下拉
                $('#nav').overdropdown({
                    handler: 'li[data-gamelist] > a',
                    dropdown: '.nav-game-lists'
                });


	// 余额显示隐藏
	var $balanceHandler = $('#balance-toggle, .balance-toggle');
	// 显示余额
	if( dsCookie.readCookie('userBalanceIsVisible') ){
		// $('[data-refresh-balance]').trigger('click');
		userBalanceOfTopNav('show');
	}else{
		userBalanceOfTopNav('hide');
	}
	$balanceHandler.on('click', function(){
		if( dsCookie.readCookie('userBalanceIsVisible') ){
			userBalanceOfTopNav('hide');
			dsCookie.eraseCookie('userBalanceIsVisible');
		}else{
			userBalanceOfTopNav('show');
			dsCookie.createCookie('userBalanceIsVisible', true, 7);
		}
		return false;
	});

	// 账户余额
	var balanceUrl ="{{route('users.user-monetary-info')}}";
	$('body').on('click', '[data-refresh-balance]', function() {
		var me = this;
		if ($(me).hasClass('onhandled')) return false;
		$(me).addClass('onhandled');

		var st = new Date().getTime(),
			delay = 2000,
			handler = function(resp){
				if (resp.isSuccess != 0 && resp.data.available) {
					var b = formatMoney(resp.data.available);
					//$('.ui-balance[data-balance-type="html"]').html(handleBalance(b));
					$('[data-user-account-balance]').html(b);
				}else if(resp.type == 'loginTimeout'){
					if(confirm(resp.Msg)){
						window.location.reload();
					}
				}else{
//					alert(resp.Msg || '网络繁忙请稍后再试');
				}
				$(me).removeClass('onhandled');
			};

		$.ajax({
			url: balanceUrl,
			type: 'GET',
			success: function(resp){ 
				var resp = $.parseJSON(resp);
				var st2 = new Date().getTime() - st;
				if( st2 > delay ){
					handler(resp);
				}else{
					setTimeout(function(){
						handler(resp);
					}, delay - st2);
				}
			},
			error: function(resp){
				alert('网络出错，请检查您的网络！')
				$(me).removeClass('onhandled');
			}
		});
		return false;
	}).find('[data-refresh-balance]').eq(0).trigger('click');

	// 定时刷新余额
	setInterval(function(){
		$('body').find('[data-refresh-balance]').eq(0).trigger('click');
	}, 15 * 1000);

	function userBalanceOfTopNav(type){
		var type = type || 'show',
			$spans = $balanceHandler.siblings('span');
		if( type == 'show' ){
			$('.balance-a').show();
			$('.balance-b').hide();
			$balanceHandler.text('隐藏');
		}else{
			$('.balance-a').hide();
			$('.balance-b').show();
			$balanceHandler.text('显示');
		}
	}
	function getSiteMsg(){
		var unreaded = 0,
			html = '';
		$.ajax({
			type: 'GET',
			url: "{{ route('station-letters.get-user-messages') }}",
			dataType: 'json',
			success: function(resp){
				if( Object.prototype.toString.call( resp ) === '[object Array]' && resp.length ){
					html += '<ul class="clearfix"> \
								<li class="tnm-title"> \
									<span class="tnm-time">时间</span> \
									<span>内容</span> \
								</li>';
					$.each(resp, function(i,msg){
						var cl = '';
						if( msg.is_readed == '0' ){
							cl = ' class="un-read"';
							unreaded++;
						}
						html += '<li' +cl+ '> \
								<span class="tnm-time">' + msg.created_at + '</span> \
								<a href="' + msg.url + '"><i></i>' + msg.msg_title + '</a> \
							</li>';
					});
					html += '</ul><p class="text-right"><a href="' + '{{ route("station-letters.index") }}' + '">查看更多>></a></p>';
					// html = '<p>未读新消息<a href="' + '{{ route("station-letters.index") }}' + '" class="highlight-color">(' + unreaded + ')</a></p>' + html;
				}else{
					html += '<p class="text-center">未读新消息<a class="highlight-color">(0)</a></p><div class="top-nav-no-msg">没有新消息了！</div>';
				}
				$('#J-top-msg-box').html(html);
				if( unreaded > 0 ){
					$('#J-top-msg-num').html('(' + unreaded + ')').show();
				}
			}
		});
	}
	getSiteMsg();
	setInterval(getSiteMsg, 5 * 60 * 1000);
});
</script>
