<!DOCTYPE HTML>
<html lang="en-US">
<head>
<meta charset="UTF-8">
<title>我的红包 -- CC彩票</title>
<link type="text/css" rel="stylesheet" href="../images/global/global.css" />
<link type="text/css" rel="stylesheet" href="../images/ucenter/ucenter.css" />

<script src="../js/jquery-1.9.1.min.js"></script>
<script src="../js/dsgame.base.js"></script>
<script src="../js/global.js"></script>
<script src="../js/jquery.mousewheel.min.js"></script>
<script src="../js/jquery.jscrollpane.js"></script>
<script src="../js/dsgame.Mask.js"></script>
<script src="../js/dsgame.Message.js"></script>
<script src="../js/dsgame.Select.js"></script>

</head>

<body>

<?php include_once("../header.php"); ?>


<div class="g_33 main clearfix">
	<div class="main-sider">
		
		<?php include_once("../uc-sider.php"); ?>
		
	</div>
	<div class="main-content">
		
		<div class="nav-bg">
			<div class="title-normal">我的红包</div>
		</div>
		
		<div class="content myhongbao clearfix">
			
			<span data-event-push style="dispaly:none;"></span>

			<!-- <div class="event-push">
				<span class="push-close right c-important">关闭提示</span>
				<label class="left">当前热门活动</label>
				<a href="">天天拿红包，奖金您做主！</a>|<a href="">骰宝江苏快3狂欢周，活动红包天天发～</a>
			</div> -->

			<!-- <div class="left hongbao-sidebar">
				<h2>
					<i class="hb-icon hb-icon-hb"></i>
					<span>全部红包</span>
				</h2>
				<ul>
					<li><a href="">可领取</a></li>
					<li><a href="">暂不可领取</a></li>
					<li><a href="">已领取</a></li>
					<li><a href="">已过期</a></li>
				</ul>
				<h2>
					<i class="hb-icon hb-icon-record"></i>
					<span>全部记录</span>
				</h2>
				<ul>
					<li><a href="">获取记录</a></li>
					<li><a href="">领取记录</a></li>
				</ul>
			</div> -->

			<div class="hongbao-box">
				<div class="hb-top">
					<div class="right">
						<!-- <select id="J-hongbao-select" style="display: none;">
							<option value="2015">2015年</option>
							<option value="2014">2014年</option>
							<option value="2013">2013年</option>
						</select> -->
						<div class="list-show-mode">
							<a href="javascript:void(0);" data-mode="view" class="view-mode">图片模式</a>
							<a href="javascript:void(0);" data-mode="list" class="list-mode">列表模式</a>
						</div>
					</div>
					<!-- <h3>全部红包</h3> -->
					<div class="filter-tabs">
						<!-- <span class="filter-tabs-title">状态</span> -->
						<div class="filter-tabs-cont">
							<a href="" class="current">全部(15)</a>
							<a href="{{route('user-activity-user-prizes.available')}}?type=pic">可领取(0)</a>
							<!-- <a href="{{route('user-activity-user-prizes.received')}}?type=pic">暂不可领取(0)</a> -->
							<a href="{{route('user-activity-user-prizes.received')}}?type=pic">已领取(0)</a>
							<a href="{{route('user-activity-user-prizes.expired')}}?type=pic">已过期(0)</a>
						</div>
					</div>
				</div>
				<!-- <div class="hb-subtotal">
					<span>共有<em class="c-important">10</em>个红包</span>
					<span>可领取<em class="c-important">7</em>个</span>
					<span>暂不可领取<em class="c-important">10</em>个</span>
					<span>已领取<em class="c-important">10</em>个</span>
				</div> -->
				<div class="hb-list" data-show-mode="list" style="display:none;">
					<table class="table">
	                    <tbody><tr>
	                        <th>红包编号</th>
	                        <th>红包类型</th>
	                        <th>获得途径</th>
	                        <th>获得时间</th>
	                        <th>红包金额（元）</th>
	                        <th>剩余有效期</th>
	                        <th>红包状态</th>
	                    </tr>
	                    <tr>
	                        <td>MKGBAG124415</td>
	                        <td>活动红包</td>
	                        <td>天天拿红包，奖金您做主！</td>
	                        <td>2015-05-24 17:18:46</td>
	                        <td><span>20,000.00</span>元</td>
	                        <td>0天</td>
	                        <td>已领取</td>
	                    </tr>
	                    <tr>
	                        <td>MKGBAG124415</td>
	                        <td>活动红包</td>
	                        <td>天天拿红包，奖金您做主！</td>
	                        <td>2015-05-24 17:18:46</td>
	                        <td><span>20,000.00</span>元</td>
	                        <td>0天</td>
	                        <td><a data-button="4" href="javascript:void(0);" class="c-important">领取红包</a></td>
	                    </tr>
	                    <tr>
	                        <td>MKGBAG124415</td>
	                        <td>活动红包</td>
	                        <td>天天拿红包，奖金您做主！</td>
	                        <td>2015-05-24 17:18:46</td>
	                        <td><span>20,000.00</span>元</td>
	                        <td>0天</td>
	                        <td>已领取</td>
	                    </tr>
	                    <tr>
	                        <td>MKGBAG124415</td>
	                        <td>活动红包</td>
	                        <td>天天拿红包，奖金您做主！</td>
	                        <td>2015-05-24 17:18:46</td>
	                        <td><span>20,000.00</span>元</td>
	                        <td>0天</td>
	                        <td><a data-button="4" href="javascript:void(0);" class="c-important">领取红包</a></td>
	                    </tr>
	                    <tr>
	                        <td>MKGBAG124415</td>
	                        <td>活动红包</td>
	                        <td>天天拿红包，奖金您做主！</td>
	                        <td>2015-05-24 17:18:46</td>
	                        <td><span>20,000.00</span>元</td>
	                        <td>0天</td>
	                        <td>已领取</td>
	                    </tr>
	                    <tr>
	                        <td>MKGBAG124415</td>
	                        <td>活动红包</td>
	                        <td>天天拿红包，奖金您做主！</td>
	                        <td>2015-05-24 17:18:46</td>
	                        <td><span>20,000.00</span>元</td>
	                        <td>0天</td>
	                        <td><a data-button="4" href="javascript:void(0);" class="c-important">领取红包</a></td>
	                    </tr>
	                    <tr>
	                        <td>MKGBAG124415</td>
	                        <td>活动红包</td>
	                        <td>天天拿红包，奖金您做主！</td>
	                        <td>2015-05-24 17:18:46</td>
	                        <td><span>20,000.00</span>元</td>
	                        <td>0天</td>
	                        <td>已领取</td>
	                    </tr>
	                    <tr>
	                        <td>MKGBAG124415</td>
	                        <td>活动红包</td>
	                        <td>天天拿红包，奖金您做主！</td>
	                        <td>2015-05-24 17:18:46</td>
	                        <td><span>20,000.00</span>元</td>
	                        <td>0天</td>
	                        <td><a data-button="4" href="javascript:void(0);" class="c-important">领取红包</a></td>
	                    </tr>
	                </tbody></table>
	            </div>
				<ul class="hb-list clearfix" id="J-hb-list" data-show-mode="view" style="display:none;">
					<li class="hb-rebate">
						<div class="css-flip css-flip-x">
							<div class="flip-front hb-cover">
								<span class="hb-icon"></span>
							</div>
							<div class="flip-back">
								<dl>
									<dt><span class="c-important">活动红包</span></dt>
									<dt>获得于：</dt>
									<dd>2015年05月29日</dd>
									<dt>获得自：</dt>
									<dd><span class="c-important">为爱再吃一口瓜</span></dd>
									<dt>剩余领取时间：</dt>
									<dd><span class="c-important">7</span>天</dd>
								</dl>
							</div>
						</div>
						<p><span data-money-format>1000.00</span>元</p>
						<p><a data-button="4" class="btn btn-important" href="javascript:void(0);">领取红包</a></p>
					</li>
					<li class="hb-expired">
						<div class="css-flip css-flip-x">
							<div class="flip-front hb-cover"></div>
							<div class="flip-back">
								<dl>
									<dt><span class="c-important">活动红包</span></dt>
									<dt>获得于：</dt>
									<dd>2015年05月29日</dd>
									<dt>获得自：</dt>
									<dd><span class="c-important">为爱再吃一口瓜</span></dd>
									<dt>剩余领取时间：</dt>
									<dd><span class="c-important">7</span>天</dd>
								</dl>
							</div>
						</div>
						<p><span data-money-format>1000.00</span>元</p>
						<p><a class="btn" href="javascript:void(0);">已过期</a></p>
					</li>
					<li class="hb-rebate">
						<div class="css-flip css-flip-x">
							<div class="flip-front hb-cover">
								<span class="hb-icon"></span>
							</div>
							<div class="flip-back">
								<dl>
									<dt><span class="c-important">活动红包</span></dt>
									<dt>获得于：</dt>
									<dd>2015年05月29日</dd>
									<dt>获得自：</dt>
									<dd><span class="c-important">为爱再吃一口瓜</span></dd>
									<dt>剩余领取时间：</dt>
									<dd><span class="c-important">7</span>天</dd>
								</dl>
							</div>
						</div>
						<p><span data-money-format>1000.00</span>元</p>
						<p><a data-button="4" class="btn btn-important" href="javascript:void(0);">领取红包</a></p>
					</li>
					<li class="hb-claimed">
						<div class="css-flip css-flip-x">
							<div class="flip-front hb-cover"></div>
							<div class="flip-back">
								<dl>
									<dt><span class="c-important">活动红包</span></dt>
									<dt>获得于：</dt>
									<dd>2015年05月29日</dd>
									<dt>获得自：</dt>
									<dd><span class="c-important">为爱再吃一口瓜</span></dd>
									<dt>剩余领取时间：</dt>
									<dd><span class="c-important">7</span>天</dd>
								</dl>
							</div>
						</div>
						<p><span data-money-format>1000.00</span>元</p>
						<p><a class="btn" href="javascript:void(0);">已领取</a></p>
					</li>
					<li class="hb-rebate">
						<div class="css-flip css-flip-x">
							<div class="flip-front hb-cover">
								<span class="hb-icon"></span>
							</div>
							<div class="flip-back">
								<dl>
									<dt><span class="c-important">活动红包</span></dt>
									<dt>获得于：</dt>
									<dd>2015年05月29日</dd>
									<dt>获得自：</dt>
									<dd><span class="c-important">为爱再吃一口瓜</span></dd>
									<dt>剩余领取时间：</dt>
									<dd><span class="c-important">7</span>天</dd>
								</dl>
							</div>
						</div>
						<p><span data-money-format>1000.00</span>元</p>
						<p><a data-button="4" class="btn btn-important" href="javascript:void(0);">领取红包</a></p>
					</li>
					<li class="hb-expired">
						<div class="css-flip css-flip-x">
							<div class="flip-front hb-cover"></div>
							<div class="flip-back">
								<dl>
									<dt><span class="c-important">活动红包</span></dt>
									<dt>获得于：</dt>
									<dd>2015年05月29日</dd>
									<dt>获得自：</dt>
									<dd><span class="c-important">为爱再吃一口瓜</span></dd>
									<dt>剩余领取时间：</dt>
									<dd><span class="c-important">7</span>天</dd>
								</dl>
							</div>
						</div>
						<p><span data-money-format>1000.00</span>元</p>
						<p><a class="btn" href="javascript:void(0);">已过期</a></p>
					</li>
					<li class="hb-rebate">
						<div class="css-flip css-flip-x">
							<div class="flip-front hb-cover">
								<span class="hb-icon"></span>
							</div>
							<div class="flip-back">
								<dl>
									<dt><span class="c-important">活动红包</span></dt>
									<dt>获得于：</dt>
									<dd>2015年05月29日</dd>
									<dt>获得自：</dt>
									<dd><span class="c-important">为爱再吃一口瓜</span></dd>
									<dt>剩余领取时间：</dt>
									<dd><span class="c-important">7</span>天</dd>
								</dl>
							</div>
						</div>
						<p><span data-money-format>1000.00</span>元</p>
						<p><a data-button="4" class="btn btn-important" href="javascript:void(0);">领取红包</a></p>
					</li>
					<li class="hb-claimed">
						<div class="css-flip css-flip-x">
							<div class="flip-front hb-cover"></div>
							<div class="flip-back">
								<dl>
									<dt><span class="c-important">活动红包</span></dt>
									<dt>获得于：</dt>
									<dd>2015年05月29日</dd>
									<dt>获得自：</dt>
									<dd><span class="c-important">为爱再吃一口瓜</span></dd>
									<dt>剩余领取时间：</dt>
									<dd><span class="c-important">7</span>天</dd>
								</dl>
							</div>
						</div>
						<p><span data-money-format>1000.00</span>元</p>
						<p><a class="btn" href="javascript:void(0);">已领取</a></p>
					</li>
					<li class="hb-rebate">
						<div class="css-flip css-flip-x">
							<div class="flip-front hb-cover">
								<span class="hb-icon"></span>
							</div>
							<div class="flip-back">
								<dl>
									<dt><span class="c-important">活动红包</span></dt>
									<dt>获得于：</dt>
									<dd>2015年05月29日</dd>
									<dt>获得自：</dt>
									<dd><span class="c-important">为爱再吃一口瓜</span></dd>
									<dt>剩余领取时间：</dt>
									<dd><span class="c-important">7</span>天</dd>
								</dl>
							</div>
						</div>
						<p><span data-money-format>1000.00</span>元</p>
						<p><a data-button="4" class="btn btn-important" href="javascript:void(0);">领取红包</a></p>
					</li>
					<li class="hb-expired">
						<div class="css-flip css-flip-x">
							<div class="flip-front hb-cover"></div>
							<div class="flip-back">
								<dl>
									<dt><span class="c-important">活动红包</span></dt>
									<dt>获得于：</dt>
									<dd>2015年05月29日</dd>
									<dt>获得自：</dt>
									<dd><span class="c-important">为爱再吃一口瓜</span></dd>
									<dt>剩余领取时间：</dt>
									<dd><span class="c-important">7</span>天</dd>
								</dl>
							</div>
						</div>
						<p><span data-money-format>1000.00</span>元</p>
						<p><a class="btn" href="javascript:void(0);">已过期</a></p>
					</li>
				</ul>

				<div class="page-wrapper clearfix">
					<div class="page page-right">
						<a href="#" class="prev">&lt;&nbsp;上一页</a>
						<a href="#">...</a>
						<a href="#">1</a>
						<a href="#">2</a>
						<a href="#">3</a>
						<a class="current" href="#">4</a>
						<a href="#">5</a>
						<a href="#">6</a>
						<a href="#">7</a>
						<a href="#">8</a>
						<a href="#">9</a>
						<a href="#">...</a>
						<a href="#" class="next">下一页&nbsp;&gt;</a>
						<span class="page-few">第1页，共145条</span>
					</div>
				</div>

				<div class="hb-list">
					<div class="no-data">暂时没有找到符合当前条件的红包哦～</div>
				</div>
				<div class="hb-list">
					<table class="table">
	                    <tbody><tr>
	                        <th>红包名称</th>
	                        <th>红包金额</th>
	                        <th>获取时间</th>
	                        <th>过期时间</th>
	                    </tr>
	                    <tr>
	                        <td>每日充每日送</td>
	                        <td>200元</td>
	                        <td>2015-05-17 17:18:46</td>
	                        <td>2015-05-24 17:18:46</td>
	                    </tr>
	                </tbody></table>
	            </div>

			</div>

		</div>
	</div>
</div>


<?php include_once("../footer.php"); ?>

<script>
(function($){

	var $lists = $('#J-hb-list');

	// Flip添加class
	$('li .css-flip', $lists).hover(function(){
		$(this).addClass('flip-hover');
	}, function(){
		$(this).removeClass('flip-hover');
	});

	// 下拉组件
	// var selectYear = new dsgame.Select({
	// 	cls:'select-game-statics-multiple w-2',
	// 	realDom: '#J-hongbao-select',
	// });
	// selectYear.addEvent('change', function(e, value, text){
	// 	console.log(value, text);
	// });

	// 列表显示方式
	var $modes = $('[data-mode]'),
		mode = dsCookie.readCookie('hongbaoListMode'),
		$lists = $('[data-show-mode]').fadeOut(0);
	if( mode != 'view' && mode != 'list' ){
		mode = 'view';
	}
	$modes.on('click', function(){
		var mode = $(this).data('mode');
		console.log(mode)
		if( !mode || (mode != 'view' && mode != 'list') || $(this).hasClass('active') ) return false;
		$lists.fadeOut(0).filter('[data-show-mode="' + mode + '"]').fadeIn();
		dsCookie.eraseCookie('hongbaoListMode');
		dsCookie.createCookie('hongbaoListMode', mode, 100);
		$(this).addClass('active').siblings().removeClass('active');
	}).filter('[data-mode="' + mode + '"]').trigger('click');

	// 领取红包
	var hbWindow = new dsgame.Message();
	var hbMask = new dsgame.Mask();
	$('[data-button]', $lists).on('click', function(e){
		e.preventDefault();
		/*var $this = $(this),
            id = $this.data('button');
        $.ajax({
            type: 'POST',
            url:  'some.php',
            data: 'id=' + id
            success: function(resp){
                // resp = $.parseJSON(resp);
                var data = {
                    closeIsShow    : true,
                    closeButtonText: '关闭',
                    closeFun       : function() {
                        this.hide();
                        hbMask.hide();
                    }
                };
                if( resp.msgType == 'error' ){
                    data['title'] = '红包领取失败';
                    data['content'] = resp.msg;
                }else{
                    data['title'] = '红包领取成功';
                    data['content'] = '价值' + resp.money + '元的红包礼金已经发放到您的账户中了，请在<a class="c-important" href="">账户余额</a>中查看。';
                    if( $this.hasClass('btn') ){
                        $this.parents('li:eq(0)').addClass('hb-claimed').end()
                                .replaceWith('<a class="btn" href="javascript:void(0);">已领取</a>');
                    }else{
                        $this.replaceWith('已领取');
                    }
                }
                hbWindow.show(data);
                hbMask.show();
            }
        });*/
		var data = {
			title : '红包领取成功',
			content: '价值1,000.00元的红包礼金已经发放到您的账户中了，请在<a class="c-important" href="">账户余额</a>中查看。',
			closeIsShow    : true,
			closeButtonText: '关闭',
			closeFun       : function() {
				this.hide();
				hbMask.hide();
			}
		};
		$(this).parents('li:eq(0)').addClass('hb-claimed').end()
				.replaceWith('<a class="btn" href="javascript:void(0);">已领取</a>');
		hbWindow.show(data);
		hbMask.show();
	});
	
})(jQuery);
</script>

</body>
</html>