	<div id="header" class="wrap">
		<div class="wrap-inner">
			<div class="left top-nav">
				<!-- 用户中心 -->
				<div class="top-nav-user">
					<a href="" class="top-nav-toggle" data-overdropdown="handler">
						<span>用户名用户名用户名</span>
						<i class="caret"></i>
					</a>
					<div class="top-nav-menu" data-overdropdown="dropdown">
						<p class="text-right">
							<a href="">个人中心</a>
							<span>｜</span>
							<a href="">退出</a>
						</p>
						<div class="top-user-links clearfix">
							<a href="" class="tul-link1">
								<i></i>
								<span>登录密码</span>
							</a>
							<a href="" class="tul-link2">
								<i></i>
								<span>资金密码</span>
							</a>
							<a href="" class="tul-link3">
								<i></i>
								<span>修改法号</span>
							</a>
							<a href="" class="tul-link4">
								<i></i>
								<span>银行卡</span>
							</a>
							<a href="" class="tul-link5">
								<i></i>
								<span>我的红包</span>
							</a>
							<a href="" class="tul-link6">
								<i></i> 
								<span>我的奖金</span>
							</a>
						</div>
					</div>
				</div>
				<!-- 站内信 -->
				<div class="top-nav-msg">
					<a href="" class="top-nav-toggle" data-overdropdown="handler">
						<i></i>
						<span>站内信<b id="J-top-msg-num" class="highlight-color"></b></span>
						<em class="caret"></em>
					</a>
					<div class="top-nav-menu" data-overdropdown="dropdown" id="J-top-msg-box"></div>
					<!-- <div class="top-nav-menu" data-overdropdown="dropdown">
						<p>未读新消息<a href="" class="highlight-color">(2)</a></p>
						<ul class="clearfix">
							<li class="tnm-title">
								<span class="tnm-time">时间</span>
								<span>内容</span>
							</li>
							<li class="un-read">
								<span class="tnm-time">05-06 20:30:32</span>
								<a href=""><i></i>您购买的重庆时时彩中奖啦！</a>
							</li>
							<li class="un-read">
								<span class="tnm-time">05-06 20:30:32</span>
								<a href=""><i></i>您购买的重庆时时彩中奖啦！</a>
							</li>
							<li>
								<span class="tnm-time">05-06 20:30:32</span>
								<a href=""><i></i>您购买的重庆时时彩中奖啦！您购买的重庆时时彩中奖啦！</a>
							</li>
							<li>
								<span class="tnm-time">05-06 20:30:32</span>
								<a href=""><i></i>您购买的重庆时时彩中奖啦！</a>
							</li>
							<li>
								<span class="tnm-time">05-06 20:30:32</span>
								<a href=""><i></i>您购买的重庆时时彩中奖啦！</a>
							</li>
							<li>
								<span class="tnm-time">05-06 20:30:32</span>
								<a href=""><i></i>您购买的重庆时时彩中奖啦！</a>
							</li>
						</ul>
						<p class="text-right"><a href="">查看更多>></a></p>
					</div> -->
					<!-- 没有消息 -->
					<!-- <div class="top-nav-menu" data-overdropdown="dropdown">
						<p class="text-center">未读新消息<a href="" class="highlight-color">(0)</a></p>
						<div class="top-nav-no-msg">没有新消息了！</div>
					</div> -->
				</div>
				<!-- 我的红包 -->
				<div class="top-nav-hongbao">
					<a class="top-nav-toggle" href="">
						<i></i>
						<span>我的红包</span>
					</a>
				</div>
			</div>
			<div class="right">
				<ul class="top-account">
					<li class="top-account-balance">
						<span style="display:none;">余额：<span data-user-account-balance>1,890.0000</span> 元<i data-refresh-balance></i></span>
						<span style="display:none;">余额已隐藏</span>
						<span class="balance-toggle highlight-color">隐藏</span>
					</li>
					<li class="top-account-deposit">
						<a href="">
							<i></i><span>充值</span>
					</a></li>
					<li class="top-account-withdraw">
						<a href="">
							<i></i><span>提款</span>
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
		// 顶部用户菜单下拉
		$('.top-nav-user, .top-nav-msg').overdropdown({
			activeClass: 'top-nav-toggle-active',
			handlerIsLink: true
		});

		// 余额显示隐藏
		var $balanceHandler = $('#header .balance-toggle');
		// 显示余额
		if( dsCookie.readCookie('userBalanceIsVisible') ){
			$('[data-refresh-balance]').trigger('click');
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

		// 刷新余额
		$('body').on('click', '[data-refresh-balance]', function() {
			var me = this;
			if ($(me).hasClass('onhandled')) return false;
			$(me).addClass('onhandled');
			
			var st = new Date().getTime(),
				delay = 2000,
				handler = function(resp){
					// if (resp.isSuccess != 0 && resp.data.available) {
					// 	var b = formatMoney(resp.data.available);
					// 	//$('.ui-balance[data-balance-type="html"]').html(handleBalance(b));
					// 	$('[data-user-account-balance]').html(b);
					// } else {
					// 	alert(resp.msg || '网络繁忙请稍后再试');
					// }
					$(me).removeClass('onhandled');
				};

			// $.get(balanceUrl, function(resp) {
			// 	var resp = $.parseJSON(resp);
			// 	var st2 = new Date().getTime() - st;
			// 	if( st2 > delay ){
			// 		handler(resp);
			// 	}else{
			// 		setTimeout(function(){
			// 			handler(resp);
			// 		}, delay - st2);
			// 	}
			// });

			var st2 = new Date().getTime() - st;
			if( st2 > delay ){
				handler();
			}else{
				setTimeout(function(){
					handler();
				}, delay - st2);
			}
			return false;
		});

		function userBalanceOfTopNav(type){
			var type = type || 'show',
				$spans = $balanceHandler.siblings('span');
			if( type == 'show' ){
				$spans.eq(0).show();
				$spans.eq(1).hide();
				$balanceHandler.text('隐藏');
			}else{
				$spans.eq(0).hide();
				$spans.eq(1).show();
				$balanceHandler.text('显示');
			}
		}
		function getSiteMsg(){
			var unreaded = 0,
				html = '';
			// $.ajax({
			// 	type: 'GET',
			// 	url: "{{ route('station-letters.get-user-messages') }}",
			// 	dataType: 'json',
			// 	success: function(resp){
					var resp = [{
						"id": "208",
						"msg_title": "test",
						"is_readed": "0",
						"created_at": "2015-06-02 10:56:05",
						"url": '208'
					},{
						"id": "106",
						"msg_title": "123",
						"is_readed": "0",
						"created_at": "2015-05-29 15:57:35",
						"url": '106'
					},{
						"id": "3",
						"msg_title": "123",
						"is_readed": "1",
						"created_at": "2015-05-29 15:50:38",
						"url": '3'
					}];
					$('#J-top-msg-num').hide();
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
				// }
			// });
		}
		getSiteMsg();
		setInterval(getSiteMsg, 5 * 60 * 1000);
	});
	</script>

	