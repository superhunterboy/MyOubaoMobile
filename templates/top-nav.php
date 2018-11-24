<div id="nav" class="wrap">
		<div class="wrap-inner">
			<a href="/" class="left" id="logo">CC彩票</a>
			<ul class="nav-content right">
				<li data-gamelist>
					<a class="nav-lobby" href="">
						<i></i>
						<span>游戏大厅<b class="caret"></b></span>						
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
				<li>
					<a class="nav-fund" href="">
						<i></i>
						<span>资金明细</span>
					</a>
				</li>
				<li>
					<a class="nav-hongbao" href="">
						<i></i>
						<span>红包中心</span>
					</a>
				</li>
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
			</ul>
		</div>
		<div class="nav-game-lists">
			<div class="nav-arrow"></div>
			<ul class="clearfix">
				<li>
					<h3>时时彩</h3>
					<div class="list-link">
						<a class="hot-game" href="../userpublic/buy/bet/13">CC彩票分分彩<span class="nav-icon-24h"></span></a>
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
						<a class="hot-game" href="../userpublic/buy/bet/14">CC彩票11选5<span class="nav-icon-24h"></span></a>
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
		var $lotteryUrl = '{{URL::full()}}';

		// 游戏大厅下拉
		$('#nav').overdropdown({
			handler: 'li[data-gamelist] > a',
			dropdown: '.nav-game-lists'
		});

        // 下拉水平位置
        var $lobby = $('#nav .nav-lobby'),
            $gameLists = $('.nav-game-lists');
        $gameLists.css({
            marginLeft: ($lobby.offset().left + $lobby.outerWidth()/2) - $(window).outerWidth()/2 - $gameLists.outerWidth()/2
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