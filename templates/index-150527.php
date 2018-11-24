<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>CC彩票 - 首页</title>
	<link rel="stylesheet" href="images/global/global.css">
	<link rel="stylesheet" href="images/index-150527/index.css">
	<script src="js/jquery-1.9.1.min.js"></script>
	<script src="js/jquery.easing.1.3.js"></script>
	<script src="js/jquery.cycle2.min.js"></script>
	<script src="js/jquery.marquee.min.js"></script>
	<!--<script src="js/jquery.cycle2.carousel.min.js"></script>-->
	<script src="js/dsgame.base.js"></script>
    <script src="js/dsgame.Ernie.js"></script>
    <script src="js/dsgame.Mask.js"></script>
    <script src="js/dsgame.Message.js"></script>
	<script src="js/dsgame.Tab.js"></script>
</head>
<body>

<?php include_once("header.php"); ?>

<div id="banner" class="wrap cycle-slideshow"
	data-cycle-slides="> a"
	data-cycle-pager="> .cycle-pager"
	data-cycle-prev="> .cycle-prev"
	data-cycle-next="> .cycle-next"
	data-cycle-fx="scrollHorz"
	data-cycle-timeout="4000"
	data-cycle-random="false"
	data-cycle-loader="wait"
	data-cycle-speed="800"
	data-cycle-log="false"
	data-cycle-auto-height="1920:550"
>
    <a href=""><img src="images/home/banner-1.jpg"></a>
    <a href=""><img src="images/home/banner-1.jpg"></a>
	<div class="cycle-pager"></div>
	<span class="cycle-prev">&#139;</span>
	<span class="cycle-next">&rsaquo;</span>
</div>

<div id="main-content" class="wrap">
	<div class="wrap-inner">
		<div class="main-left left">
			<div class="ui-box user-account">
				<div class="user-avatar">
					<img src="images/index/avatar.png" alt="">
					<h2><a class="right" href=""><span class="c-important">我的红包</span></a>子弥陈</h2>
					<!-- <p>登录账号：Realbig******</p> -->
					<p>
						<a href="" class="user-action-1"></a>
						<a href="" class="user-action-2"></a>
						<a href="" class="user-action-3"></a>
						<a href="" class="user-action-4"></a>
					</p>
				</div>
				<div class="user-balance">
					<h3>目前账户可用余额</h3>
					<input id="J-user-balance-value" type="hidden" value="12131.0">
					<div class="balance-box">
						<ul>
						<?php for( $i=0; $i<9; $i++ ){ ?>
							<li>
							<?php for($j=0; $j<10; $j++){ ?>
								<span><?=$j?></span>
						<?php
							}
						}
						?>
							<li class="money-dot"><span>.</span></li>
						<?php for( $i=0; $i<4; $i++ ){ ?>
							<li class="money-small">
							<?php for($j=0; $j<10; $j++){ ?>
								<span><?=$j?></span>
						<?php
							}
						}
						?>
						</ul>
						<div class="balance-hammer">
							<div class="hammer-up"></div>
							<div class="hammer-down"></div>
						</div>
					</div>
					<div class="account-actions">
						<a href="" class="u-button recharge"><i class="mkg-icon"></i>充值</a>
						<a href="" class="u-button withdraw"><i class="mkg-icon"></i>提现</a>
						<a href="" class="u-button card-manage"><i class="mkg-icon"></i>银行卡</a>
					</div>
				</div>
			</div>

			<div class="ui-box record-board">
				<div class="mkg-tabs">
					<a href="javascript:void(0);" class="tab1"><i class="mkg-icon"></i>游戏记录</a>
					<a href="javascript:void(0);" class="tab2"><i class="mkg-icon"></i>追号记录</a>
					<a href="javascript:void(0);" class="tab3"><i class="mkg-icon"></i>资金明细</a>
				</div>
                <div class="mkg-tabcont">
                    <div class="mkg-panel panel-current" style="display: block;">
                        <div class="no-data">暂无历史记录，先去<a href="">投注</a>吧～</div>
                        <!-- <table class="mkg-table">
                            <thead>
                                <tr>
                                    <th class="cell-1">游戏</th>
                                    <th class="cell-2">奖期</th>
                                    <th class="cell-3">投注金额</th>
                                    <th class="cell-4">状态</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><a href="http://ds.test.com/baughts/152957/view " class="color-blue">重庆时时彩</a></td>
                                    <td>2.00</td>
                                    <td>待开奖</td>
                                    <td>04-16 14:10</td>
                                </tr>
                                <tr>
                                    <td><a href="http://ds.test.com/baughts/152956/view " class="color-blue">重庆时时彩</a></td>
                                    <td>2.00</td>
                                    <td>待开奖</td>
                                    <td>04-16 14:10</td>
                                </tr>
                                <tr>
                                    <td><a href="http://ds.test.com/baughts/152955/view " class="color-blue">重庆时时彩</a></td>
                                    <td>0.02</td>
                                    <td>待开奖</td>
                                    <td>04-16 08:33</td>
                                </tr>
                                <tr>
                                    <td><a href="http://ds.test.com/baughts/152954/view " class="color-blue">重庆时时彩</a></td>
                                    <td>0.02</td>
                                    <td>待开奖</td>
                                    <td>04-16 08:33</td>
                                </tr>
                                <tr>
                                    <td><a href="http://ds.test.com/baughts/152953/view " class="color-blue">重庆时时彩</a></td>
                                    <td>0.02</td>
                                    <td>待开奖</td>
                                    <td>04-16 08:32</td>
                                </tr>
                                <tr>
                                    <td><a href="http://ds.test.com/baughts/152950/view " class="color-blue">CC彩票分分彩</a></td>
                                    <td>1,120.00</td>
                                    <td>未中奖</td>
                                    <td>04-16 07:53</td>
                                </tr>
                                <tr>
                                    <td><a href="http://ds.test.com/baughts/152949/view " class="color-blue">CC彩票分分彩</a></td>
                                    <td>320.00</td>
                                    <td>未中奖</td>
                                    <td>04-16 07:52</td>
                                </tr>
                                <tr>
                                    <td><a href="http://ds.test.com/baughts/152948/view " class="color-blue">CC彩票分分彩</a></td>
                                    <td>1,680.00</td>
                                    <td>已中奖</td>
                                    <td>04-16 07:50</td>
                                </tr>
                            </tbody>
                        </table>
                        <a href="http://ds.test.com/baughts" class="more-button">查看近期详细记录&gt;&gt;</a> -->
                    </div>

                    <div class="mkg-panel" style="display: none;">
                        <table class="mkg-table">
                            <thead>
                                <tr>
                                    <th class="cell-1">时间</th>
                                    <th class="cell-2">游戏</th>
                                    <th class="cell-3">追号期数</th>
                                    <th class="cell-4">状态</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>04-15 &nbsp;14:01</td>
                                    <td><a href="http://ds.test.com/tasks/9601/view" class="color-blue">CC彩票分分彩</a></td>
                                    <td>2/5</td>
                                    <td>系统终止</td>
                                </tr>
                                <tr>
                                    <td>04-15 &nbsp;13:58</td>
                                    <td><a href="http://ds.test.com/tasks/9600/view" class="color-blue">CC彩票分分彩</a></td>
                                    <td>1/5</td>
                                    <td>系统终止</td>
                                </tr>
                                <tr>
                                    <td>04-15 &nbsp;13:42</td>
                                    <td><a href="http://ds.test.com/tasks/9593/view" class="color-blue">CC彩票分分彩</a></td>
                                    <td>4/10</td>
                                    <td>系统终止</td>
                                </tr>
                                <tr>
                                    <td>04-15 &nbsp;13:19</td>
                                    <td><a href="http://ds.test.com/tasks/9580/view" class="color-blue">CC彩票分分彩</a></td>
                                    <td>1/10</td>
                                    <td>系统终止</td>
                                </tr>
                                <tr>
                                    <td>04-15 &nbsp;13:14</td>
                                    <td><a href="http://ds.test.com/tasks/9579/view" class="color-blue">CC彩票分分彩</a></td>
                                    <td>3/10</td>
                                    <td>系统终止</td>
                                </tr>
                                <tr>
                                    <td>04-15 &nbsp;13:10</td>
                                    <td><a href="http://ds.test.com/tasks/9578/view" class="color-blue">CC彩票分分彩</a></td>
                                    <td>2/6</td>
                                    <td>系统终止</td>
                                </tr>
                                <tr>
                                    <td>04-15 &nbsp;13:08</td>
                                    <td><a href="http://ds.test.com/tasks/9577/view" class="color-blue">CC彩票分分彩</a></td>
                                    <td>1/6</td>
                                    <td>系统终止</td>
                                </tr>
                                <tr>
                                    <td>04-15 &nbsp;13:05</td>
                                    <td><a href="http://ds.test.com/tasks/9564/view" class="color-blue">CC彩票分分彩</a></td>
                                    <td>1/7</td>
                                    <td>系统终止</td>
                                </tr>
                                                                                                
                            </tbody>
                        </table>
                        <a href="http://ds.test.com/tasks" class="more-button">查看近期详细记录&gt;&gt;</a>
                    </div>

                    <div class="mkg-panel" style="display: none;">
                        <table class="mkg-table">
                            <thead>
                                <tr>
                                    <th class="cell-1">时间</th>
                                    <th class="cell-2">账变类型</th>
                                    <th class="cell-3">金额</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>04-16 &nbsp;14:10</td>
                                    <td><span class="color-blue" <a="" href="http://ds.test.com/transactions/536779/view">加入游戏</span></td>
                                    <td>-2.00</td>
                                </tr>
                                <tr>
                                    <td>04-16 &nbsp;14:10</td>
                                    <td><span class="color-blue" <a="" href="http://ds.test.com/transactions/536778/view">加入游戏</span></td>
                                    <td>-2.00</td>
                                </tr>
                                <tr>
                                    <td>04-16 &nbsp;08:33</td>
                                    <td><span class="color-blue" <a="" href="http://ds.test.com/transactions/536773/view">加入游戏</span></td>
                                    <td>-0.02</td>
                                </tr>
                                <tr>
                                    <td>04-16 &nbsp;08:33</td>
                                    <td><span class="color-blue" <a="" href="http://ds.test.com/transactions/536772/view">加入游戏</span></td>
                                    <td>-0.02</td>
                                </tr>
                                <tr>
                                    <td>04-16 &nbsp;08:32</td>
                                    <td><span class="color-blue" <a="" href="http://ds.test.com/transactions/536771/view">加入游戏</span></td>
                                    <td>-0.02</td>
                                </tr>
                                <tr>
                                    <td>04-16 &nbsp;08:28</td>
                                    <td><span class="color-blue" <a="" href="http://ds.test.com/transactions/536768/view">人工充值</span></td>
                                    <td>+10,000,000.00</td>
                                </tr>
                                <tr>
                                    <td>04-16 &nbsp;07:52</td>
                                    <td><span class="color-blue" <a="" href="http://ds.test.com/transactions/536488/view">加入游戏</span></td>
                                    <td>-1,120.00</td>
                                </tr>
                                <tr>
                                    <td>04-16 &nbsp;07:51</td>
                                    <td><span class="color-blue" <a="" href="http://ds.test.com/transactions/536402/view">加入游戏</span></td>
                                    <td>-320.00</td>
                                </tr>
                            </tbody>
                        </table>
                        <a href="http://ds.test.com/transactions" class="more-button">查看近期详细记录&gt;&gt;</a>
                    </div>
                </div>
			</div>

			<div class="ui-box notice-board">
				<h3><a href="">更多>></a>最新公告</h3>
				<ul class="news-list">
					<li class="even"><a href="">【游戏撤单】重庆时时彩官方未开奖撤单公告</a></li>
					<li><a href="">【新人专享】10元体验金4月继续免费领！</a></li>
					<li class="even"><a href="">【重磅活动】天天有返利 日返高达1.5%</a></li>
					<li><a href="">【彩种停售】重庆11选5官方停售公告</a></li>
					<li class="even"><a href="">【彩种停售】重庆11选5官方停售公告</a></li>
					<li><a href="">【彩种停售】重庆11选5官方停售公告</a></li>
					<li class="even"><a href="">【彩种停售】重庆11选5官方停售公告</a></li>
				</ul>
			</div>

		</div>
		<div class="main-right right">
			<div class="brand clearfix">
				<a href="">
					<img src="images/index/lottery-entrance-k3.jpg" alt="">
					<span>第<em class="lottery-issue">20150408-045</em>期</span>
				</a>
				<a href="">
					<img src="images/index/lottery-entrance-ffc.jpg" alt="">
					<span>第<em class="lottery-issue">20150408-045</em>期</span>
				</a>
				<a href="">
					<img src="images/index/lottery-entrance-11n5.jpg" alt="">
					<span>第<em class="lottery-issue">20150408-045</em>期</span>
				</a>
			</div>

			<div class="ui-box winner-list">
				<div class="winner-scroll-warp J-prize-marquee">
					<ul>
						<li>恭喜 baymax***** 在CC彩票分分彩的游戏中，喜中<span class="color-highlight">1,000.00</span>元</li>
						<li>恭喜 baymax***** 在CC彩票分分彩的游戏中，喜中<span class="color-highlight">1,000.00</span>元</li>
						<li>恭喜 baymax***** 在CC彩票分分彩的游戏中，喜中<span class="color-highlight">1,000.00</span>元</li>
						<li>恭喜 baymax***** 在CC彩票分分彩的游戏中，喜中<span class="color-highlight">1,000.00</span>元</li>
						<li>恭喜 baymax***** 在CC彩票分分彩的游戏中，喜中<span class="color-highlight">1,000.00</span>元</li>
					</ul>
				</div>
			</div>

			<div class="ui-box game-lists">
				<div class="ui-box-top">
					<h2>游戏列表</h2>
				</div>
				<div class="game-wrap">
					<div class="filter-aside">
						<h3>按类别选择游戏</h3>
						<ul class="filter-list" data-filter-name="category">
							<li class="active">全部类别</li>
							<li data-filter="high">高频游戏</li>
							<li data-filter="low">低频游戏</li>
							<li data-filter="auto">自主游戏</li>
						</ul>
						<h3>按特色选择游戏</h3>
						<ul class="filter-list" data-filter-name="feature">
							<li class="active">全部特色</li>
							<!-- <li data-filter="quick">开奖快</li>
							<li data-filter="long">奖期长</li>
							<li data-filter="alltime">趣味性</li> -->
						</ul>
					</div>

					<ul class="filter-cont">
						<li data-category="high" data-feature="">
							<a href=""><img src="images/game/logo/CQSSC.png" alt=""></a>
							<span>重庆时时彩</span>
						</li>
						<li data-category="high" data-feature="rebate">
							<a href=""><img src="images/game/logo/SD11Y.png" alt=""></a>
							<span>山东11选5</span>
						</li>
						<li data-category="low" data-feature="long">
							<a href=""><img src="images/game/logo/F3D.png" alt=""></a>
							<span>3D</span>
						</li>
						<li data-category="low" data-feature="long">
							<a href=""><img src="images/game/logo/PLW.png" alt=""></a>
							<span>P3/P5</span>
						</li>
						<li data-category="auto" data-feature="">
							<a href=""><img src="images/game/logo/DSFFC.png" alt=""></a>
							<span>CC彩票分分彩</span>
						</li>
						<li data-category="auto" data-feature="">
							<a href=""><img src="images/game/logo/DS115.png" alt=""></a>
							<span>CC彩票11选5</span>
						</li>
						<li data-category="high" data-feature="">
							<a href=""><img src="images/game/logo/HLJSSC.png" alt=""></a>
							<span>黑龙江时时彩</span>
						</li>
						<li data-category="high" data-feature="rebate">
							<a href=""><img src="images/game/logo/JX11Y.png" alt=""></a>
							<span>江西11选5</span>
						</li>
						<li data-category="high" data-feature="">
							<a href=""><img src="images/game/logo/XJSSC.png" alt=""></a>
							<span>新疆时时彩</span>
						</li>
						<li data-category="high" data-feature="rebate">
							<a href=""><img src="images/game/logo/CQ11Y.png" alt=""></a>
							<span>重庆11选5</span>
						</li>
						<li data-category="high" data-feature="rebate">
							<a href=""><img src="images/game/logo/GD11Y.png" alt=""></a>
							<span>广东11选5</span>
						</li>
						<li data-category="high" data-feature="">
							<a href=""><img src="images/game/logo/JXSSC.png" alt=""></a>
							<span>江西时时彩</span>
						</li>
					</ul>
				</div>
			</div>

			<div class="ui-box left jump-cloud" style="display:none;">
                <a class="ui-download" href="">立即下载</a>
                <!-- <a class="ui-download opensoon" href="">即将推出</a> -->
            </div>

            <div class="ui-box left hongbao">
                <a class="ui-download" href="">立即查看</a>
                <!-- <a class="ui-download opensoon" href="">即将推出</a> -->
            </div>

			<div class="ui-box right dl-app">
				<a class="ui-download opensoon">即将推出</a>
				<!-- <a class="ui-download" href="">立即下载</a> -->
			</div>

			<div class="ui-box right follow-us">
				<div class="wx-qr"></div>
				<a href="" class="flink-fb">facebook</a>
				<a href="http://www.weibo.com/mkg888" target="_blank" class="flink-wb">weibo</a>
				<span class="fnum-fb">3423</span>
				<span class="fnum-wb">3423433</span>
			</div>

		</div>

	</div>

	<!-- <div class="wrap-inner">
		<div class="ui-box partner">
			<ul>
				<li><a href="">Visa</a></li>
				<li><a href="">支付宝</a></li>
				<li><a href="">财付通</a></li>
				<li><a href="">渣打银行</a></li>
				<li><a href="">阿里云</a></li>
				<li><a href="">IBM</a></li>
				<li><a href="">Visa</a></li>
				<li><a href="">支付宝</a></li>
				<li><a href="">财付通</a></li>
			</ul>
		</div>
	</div> -->

</div>

<?php include_once("footer.php"); ?>

<div class="pop" id="popWindow" style="display:none;">
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
</div>
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

	// 游戏列表筛选
	var FILTER_OBJECT = {},
		$gamelists = $('.filter-cont li');
	$('.filter-aside .filter-list').each(function(){
		var name = $(this).data('filter-name');
		$(this).find('> li').on('click', function(){
			var $t = $(this);
			if( $t.hasClass('active') ) return false;
			var filter = $t.data('filter');
			FILTER_OBJECT[name] = filter;
			$t.addClass('active').siblings('.active').removeClass('active');
			gameFiltrate();
			return false;
		});
	});

	function gameFiltrate(){
		var $filter = $gamelists,
			filterString = [];
		$.each(FILTER_OBJECT, function(key, val){
			if( key && val ){
				filterString.push('[data-' + key + '="' + val + '"]');
			}
		});
		if( filterString.length ){
			$gamelists.fadeTo('normal', .1);
			filterString = filterString.join(',');
			$gamelists.filter(filterString).fadeTo('normal', 1);
		}else{
			$gamelists.fadeTo('normal', 1);
		}
	}

	// 获奖名单滚动
	$('.J-prize-marquee').marquee({
		auto: true,
		interval: 4000,
		speed: 2000,
		showNum: 3,
		stepLen: 1,
		type: 'horizontal'
	});

	// 游戏记录tab切换
	var recordTab = new dsgame.Tab({
		currClass: 'active',
		par: '.record-board',
		triggers: '.mkg-tabs a',
		panels: '.mkg-tabcont .mkg-panel',
		eventType: 'click'
	});
	recordTab.addEvent('afterSwitch', function(e, i){
		this.getPanel(i).show().siblings().hide();
	});

});
</script>

</body>
</html>