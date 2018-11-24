<!DOCTYPE HTML>
<html lang="en-US">
<head>
<meta charset="UTF-8">
<title>奖金组管理 -- CC彩票</title>
<link type="text/css" rel="stylesheet" href="../images/global/global.css" />
<link type="text/css" rel="stylesheet" href="../images/ucenter/ucenter.css" />

<script type="text/javascript" src="../js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="../js/jquery.jscroll.js"></script>
<script type="text/javascript" src="../js/dsgame.base.js"></script>
<script type="text/javascript" src="../js/dsgame.Select.js"></script>
<script type="text/javascript" src="../js/dsgame.Tab.js"></script>
<script type="text/javascript" src="../js/dsgame.SliderBar.js"></script>
<script type="text/javascript" src="../js/dsgame.DatePicker.js"></script>

</head>

<body>

<?php include_once("../header.php"); ?>


<div class="g_33 main clearfix">
	<div class="main-sider">
		
		<?php include_once("../uc-sider.php"); ?>
		
	</div>
	<div class="main-content">
		
		<div class="nav-bg">
			<div class="title-normal">奖金组管理</div>
		</div>
		
		
		<input type="hidden" value="<?=$root_path?>/data/groupbonus.php" id="J-loadGroupData-url" />
		<form action="http://ds.test.com/prize-sets/set-prize-set/8" method="post" id="J-form">
			<input type="hidden" name="_token" value="azTL34X7ZxA0QO701uOfQLj8tf793Bfugx0SXxes">
			<input type="hidden" name="_method" value="PUT">
			<input type="hidden" name="lottery_id" value="1">
			<input type="hidden" name="lottery_prize_group_json" id="prize_group_json">
			<div class="content" id="J-panel-cont">
				<div class="bonusgroup-title">
					<table width="100%">
						<tbody>
							<tr>
								<td>nickshabi
									<br><span class="tip">用户名称</span></td>
								<td>nick
									<br><span class="tip">用户昵称</span></td>
								<td>玩家
									<br><span class="tip">用户类型</span></td>
								<td>9,998,156.019800 元
									<br><span class="tip">可用余额</span></td>
								<td class="last">400000 元
									<br><span class="tip">奖金限额</span></td>
							</tr>
						</tbody>
					</table>
				</div>
				
				<div class="row-title">奖金组设置</div>

				<div class="prompt-text" style="padding:5px 10px;">
					<div class="item-title" style="margin-bottom:0;"><i class="item-icon-15"></i>特别提示：调整用户奖金组时，一旦调高并保存后，将不允许恢复或调低，请谨慎操作！</div>
				</div>

				<div class="bonusgroup-game-type clearfix">
					<div class="bonusgroup-list">
						<h3>设置时时彩奖金组</h3>
						<ul class="clearfix gametype-row">
							<li class="slider-range slider-range-global" data-id="1" data-itemtype="all" onselectstart="return false;" data-slider-step="1">
								<div class="slider-range-scale">
									<span class="slider-title">统一设置</span>
									<a href="" data-bonus-scan="" data-path="http://ds.test.com/prize-sets/prize-set-detail" class="c-important">查 看</a>
									<span class="small-number" data-slider-min="">0</span>
									<span class="percent-number" data-slider-percent="">11.00%</span>
									<span class="big-number" data-slider-max="">34</span>
								</div>
								<div class="slider-current-value" data-slider-value="">0</div>
								<div class="slider-action">
									<div class="slider-range-sub" data-slider-sub="">-</div>
									<div class="slider-range-add" data-slider-add="">+</div>
									<div class="slider-range-wrapper" data-slider-cont="">
										<div class="slider-range-inner" data-slider-inner="" style="width: 59.2941176470588px;"></div>
										<div class="slider-range-btn" data-slider-handle="" style="left: 59.2941176470588px;"></div>
									</div>
								</div>
							</li>
							<li class="slider-range" data-id="1" data-itemtype="game" onselectstart="return false;" data-slider-step="1">
								<div class="slider-range-scale">
									<span class="slider-title">重庆时时彩</span>
									<a href="" data-bonus-scan="" data-path="http://ds.test.com/prize-sets/prize-set-detail" class="c-important">查 看</a>
									<span class="small-number" data-slider-min="">0</span>
									<span class="percent-number" data-slider-percent="">0%</span>
									<span class="big-number" data-slider-max="">34</span>
								</div>
								<div class="slider-current-value" data-slider-value="">1800</div>
								<div class="slider-action">
									<div class="slider-range-sub" data-slider-sub="">-</div>
									<div class="slider-range-add" data-slider-add="">+</div>
									<div class="slider-range-wrapper" data-slider-cont="">
										<div class="slider-range-inner" data-slider-inner="" style="width: 98.8235294117647px;"></div>
										<div class="slider-range-btn" data-slider-handle="" style="left: 98.8235294117647px;"></div>
									</div>
								</div>
							</li>
							<li class="slider-range" data-id="3" data-itemtype="game" onselectstart="return false;" data-slider-step="1">
								<div class="slider-range-scale">
									<span class="slider-title">黑龙江时时彩</span>
									<a href="" data-bonus-scan="" data-path="http://ds.test.com/prize-sets/prize-set-detail" class="c-important">查 看</a>
									<span class="small-number" data-slider-min="">0</span>
									<span class="percent-number" data-slider-percent="">0%</span>
									<span class="big-number" data-slider-max="">34</span>
								</div>
								<div class="slider-current-value" data-slider-value="">1800</div>
								<div class="slider-action">
									<div class="slider-range-sub" data-slider-sub="">-</div>
									<div class="slider-range-add" data-slider-add="">+</div>
									<div class="slider-range-wrapper" data-slider-cont="">
										<div class="slider-range-inner" data-slider-inner="" style="width: 98.8235294117647px;"></div>
										<div class="slider-range-btn" data-slider-handle="" style="left: 98.8235294117647px;"></div>
									</div>
								</div>
							</li>
							<li class="slider-range" data-id="5" data-itemtype="game" onselectstart="return false;" data-slider-step="1">
								<div class="slider-range-scale">
									<span class="slider-title">江西时时彩</span>
									<a href="" data-bonus-scan="" data-path="http://ds.test.com/prize-sets/prize-set-detail" class="c-important">查 看</a>
									<span class="small-number" data-slider-min="">0</span>
									<span class="percent-number" data-slider-percent="">3.00%</span>
									<span class="big-number" data-slider-max="">34</span>
								</div>
								<div class="slider-current-value" data-slider-value="">1880</div>
								<div class="slider-action">
									<div class="slider-range-sub" data-slider-sub="">-</div>
									<div class="slider-range-add" data-slider-add="">+</div>
									<div class="slider-range-wrapper" data-slider-cont="">
										<div class="slider-range-inner" data-slider-inner="" style="width: 138.352941176471px;"></div>
										<div class="slider-range-btn" data-slider-handle="" style="left: 138.352941176471px;"></div>
									</div>
								</div>
							</li>
							<li class="slider-range" data-id="6" data-itemtype="game" onselectstart="return false;" data-slider-step="1">
								<div class="slider-range-scale">
									<span class="slider-title">新疆时时彩</span>
									<a href="" data-bonus-scan="" data-path="http://ds.test.com/prize-sets/prize-set-detail" class="c-important">查 看</a>
									<span class="small-number" data-slider-min="">0</span>
									<span class="percent-number" data-slider-percent="">0%</span>
									<span class="big-number" data-slider-max="">34</span>
								</div>
								<div class="slider-current-value" data-slider-value="">1800</div>
								<div class="slider-action">
									<div class="slider-range-sub" data-slider-sub="">-</div>
									<div class="slider-range-add" data-slider-add="">+</div>
									<div class="slider-range-wrapper" data-slider-cont="">
										<div class="slider-range-inner" data-slider-inner="" style="width: 98.8235294117647px;"></div>
										<div class="slider-range-btn" data-slider-handle="" style="left: 98.8235294117647px;"></div>
									</div>
								</div>
							</li>
							<li class="slider-range" data-id="7" data-itemtype="game" onselectstart="return false;" data-slider-step="1">
								<div class="slider-range-scale">
									<span class="slider-title">天津时时彩</span>
									<a href="" data-bonus-scan="" data-path="http://ds.test.com/prize-sets/prize-set-detail" class="c-important">查 看</a>
									<span class="small-number" data-slider-min="">0</span>
									<span class="percent-number" data-slider-percent="">0%</span>
									<span class="big-number" data-slider-max="">34</span>
								</div>
								<div class="slider-current-value" data-slider-value="">1800</div>
								<div class="slider-action">
									<div class="slider-range-sub" data-slider-sub="">-</div>
									<div class="slider-range-add" data-slider-add="">+</div>
									<div class="slider-range-wrapper" data-slider-cont="">
										<div class="slider-range-inner" data-slider-inner="" style="width: 98.8235294117647px;"></div>
										<div class="slider-range-btn" data-slider-handle="" style="left: 98.8235294117647px;"></div>
									</div>
								</div>
							</li>
							<li class="slider-range" data-id="11" data-itemtype="game" onselectstart="return false;" data-slider-step="1">
								<div class="slider-range-scale">
									<span class="slider-title">3D</span>
									<a href="" data-bonus-scan="" data-path="http://ds.test.com/prize-sets/prize-set-detail" class="c-important">查 看</a>
									<span class="small-number" data-slider-min="">0</span>
									<span class="percent-number" data-slider-percent="">0%</span>
									<span class="big-number" data-slider-max="">34</span>
								</div>
								<div class="slider-current-value" data-slider-value="">1800</div>
								<div class="slider-action">
									<div class="slider-range-sub" data-slider-sub="">-</div>
									<div class="slider-range-add" data-slider-add="">+</div>
									<div class="slider-range-wrapper" data-slider-cont="">
										<div class="slider-range-inner" data-slider-inner="" style="width: 98.8235294117647px;"></div>
										<div class="slider-range-btn" data-slider-handle="" style="left: 98.8235294117647px;"></div>
									</div>
								</div>
							</li>
							<li class="slider-range" data-id="12" data-itemtype="game" onselectstart="return false;" data-slider-step="1">
								<div class="slider-range-scale">
									<span class="slider-title">排列五</span>
									<a href="" data-bonus-scan="" data-path="http://ds.test.com/prize-sets/prize-set-detail" class="c-important">查 看</a>
									<span class="small-number" data-slider-min="">0</span>
									<span class="percent-number" data-slider-percent="">0%</span>
									<span class="big-number" data-slider-max="">34</span>
								</div>
								<div class="slider-current-value" data-slider-value="">1800</div>
								<div class="slider-action">
									<div class="slider-range-sub" data-slider-sub="">-</div>
									<div class="slider-range-add" data-slider-add="">+</div>
									<div class="slider-range-wrapper" data-slider-cont="">
										<div class="slider-range-inner" data-slider-inner="" style="width: 98.8235294117647px;"></div>
										<div class="slider-range-btn" data-slider-handle="" style="left: 98.8235294117647px;"></div>
									</div>
								</div>
							</li>
							<li class="slider-range" data-id="13" data-itemtype="game" onselectstart="return false;" data-slider-step="1">
								<div class="slider-range-scale">
									<span class="slider-title">CC彩票分分彩</span>
									<a href="" data-bonus-scan="" data-path="http://ds.test.com/prize-sets/prize-set-detail" class="c-important">查 看</a>
									<span class="small-number" data-slider-min="">0</span>
									<span class="percent-number" data-slider-percent="">0%</span>
									<span class="big-number" data-slider-max="">34</span>
								</div>
								<div class="slider-current-value" data-slider-value="">1800</div>
								<div class="slider-action">
									<div class="slider-range-sub" data-slider-sub="">-</div>
									<div class="slider-range-add" data-slider-add="">+</div>
									<div class="slider-range-wrapper" data-slider-cont="">
										<div class="slider-range-inner" data-slider-inner="" style="width: 98.8235294117647px;"></div>
										<div class="slider-range-btn" data-slider-handle="" style="left: 98.8235294117647px;"></div>
									</div>
								</div>
							</li>
						</ul>
					</div>
					<div class="bonusgroup-list">
						<h3>设置11选5奖金组</h3>
						<ul class="clearfix gametype-row">
							<li class="slider-range slider-range-global" data-id="2" data-itemtype="all" onselectstart="return false;" data-slider-step="1">
								<div class="slider-range-scale">
									<span class="slider-title">统一设置</span>
									<a href="" data-bonus-scan="" data-path="http://ds.test.com/prize-sets/prize-set-detail" class="c-important">查 看</a>
									<span class="small-number" data-slider-min="">0</span>
									<span class="percent-number" data-slider-percent="">0%</span>
									<span class="big-number" data-slider-max="">34</span>
								</div>
								<div class="slider-current-value" data-slider-value="">0</div>
								<div class="slider-action">
									<div class="slider-range-sub" data-slider-sub="">-</div>
									<div class="slider-range-add" data-slider-add="">+</div>
									<div class="slider-range-wrapper" data-slider-cont="">
										<div class="slider-range-inner" data-slider-inner=""></div>
										<div class="slider-range-btn" data-slider-handle=""></div>
									</div>
								</div>
							</li>
							<li class="slider-range" data-id="2" data-itemtype="game" onselectstart="return false;" data-slider-step="1">
								<div class="slider-range-scale">
									<span class="slider-title">山东11选5</span>
									<a href="" data-bonus-scan="" data-path="http://ds.test.com/prize-sets/prize-set-detail" class="c-important">查 看</a>
									<span class="small-number" data-slider-min="">0</span>
									<span class="percent-number" data-slider-percent="">0%</span>
									<span class="big-number" data-slider-max="">34</span>
								</div>
								<div class="slider-current-value" data-slider-value="">1830</div>
								<div class="slider-action">
									<div class="slider-range-sub" data-slider-sub="">-</div>
									<div class="slider-range-add" data-slider-add="">+</div>
									<div class="slider-range-wrapper" data-slider-cont="">
										<div class="slider-range-inner" data-slider-inner="" style="width: 163.058823529412px;"></div>
										<div class="slider-range-btn" data-slider-handle="" style="left: 163.058823529412px;"></div>
									</div>
								</div>
							</li>
							<li class="slider-range" data-id="8" data-itemtype="game" onselectstart="return false;" data-slider-step="1">
								<div class="slider-range-scale">
									<span class="slider-title">江西11选5</span>
									<a href="" data-bonus-scan="" data-path="http://ds.test.com/prize-sets/prize-set-detail" class="c-important">查 看</a>
									<span class="small-number" data-slider-min="">0</span>
									<span class="percent-number" data-slider-percent="">0%</span>
									<span class="big-number" data-slider-max="">34</span>
								</div>
								<div class="slider-current-value" data-slider-value="">1830</div>
								<div class="slider-action">
									<div class="slider-range-sub" data-slider-sub="">-</div>
									<div class="slider-range-add" data-slider-add="">+</div>
									<div class="slider-range-wrapper" data-slider-cont="">
										<div class="slider-range-inner" data-slider-inner="" style="width: 163.058823529412px;"></div>
										<div class="slider-range-btn" data-slider-handle="" style="left: 163.058823529412px;"></div>
									</div>
								</div>
							</li>
							<li class="slider-range" data-id="9" data-itemtype="game" onselectstart="return false;" data-slider-step="1">
								<div class="slider-range-scale">
									<span class="slider-title">广东11选5</span>
									<a href="" data-bonus-scan="" data-path="http://ds.test.com/prize-sets/prize-set-detail" class="c-important">查 看</a>
									<span class="small-number" data-slider-min="">0</span>
									<span class="percent-number" data-slider-percent="">0%</span>
									<span class="big-number" data-slider-max="">34</span>
								</div>
								<div class="slider-current-value" data-slider-value="">1830</div>
								<div class="slider-action">
									<div class="slider-range-sub" data-slider-sub="">-</div>
									<div class="slider-range-add" data-slider-add="">+</div>
									<div class="slider-range-wrapper" data-slider-cont="">
										<div class="slider-range-inner" data-slider-inner="" style="width: 163.058823529412px;"></div>
										<div class="slider-range-btn" data-slider-handle="" style="left: 163.058823529412px;"></div>
									</div>
								</div>
							</li>
							<li class="slider-range" data-id="10" data-itemtype="game" onselectstart="return false;" data-slider-step="1">
								<div class="slider-range-scale">
									<span class="slider-title">重庆11选5</span>
									<a href="" data-bonus-scan="" data-path="http://ds.test.com/prize-sets/prize-set-detail" class="c-important">查 看</a>
									<span class="small-number" data-slider-min="">0</span>
									<span class="percent-number" data-slider-percent="">0%</span>
									<span class="big-number" data-slider-max="">34</span>
								</div>
								<div class="slider-current-value" data-slider-value="">1830</div>
								<div class="slider-action">
									<div class="slider-range-sub" data-slider-sub="">-</div>
									<div class="slider-range-add" data-slider-add="">+</div>
									<div class="slider-range-wrapper" data-slider-cont="">
										<div class="slider-range-inner" data-slider-inner="" style="width: 163.058823529412px;"></div>
										<div class="slider-range-btn" data-slider-handle="" style="left: 163.058823529412px;"></div>
									</div>
								</div>
							</li>
							<li class="slider-range" data-id="14" data-itemtype="game" onselectstart="return false;" data-slider-step="1">
								<div class="slider-range-scale">
									<span class="slider-title">CC彩票11选5</span>
									<a href="" data-bonus-scan="" data-path="http://ds.test.com/prize-sets/prize-set-detail" class="c-important">查 看</a>
									<span class="small-number" data-slider-min="">0</span>
									<span class="percent-number" data-slider-percent="">0%</span>
									<span class="big-number" data-slider-max="">34</span>
								</div>
								<div class="slider-current-value" data-slider-value="">1830</div>
								<div class="slider-action">
									<div class="slider-range-sub" data-slider-sub="">-</div>
									<div class="slider-range-add" data-slider-add="">+</div>
									<div class="slider-range-wrapper" data-slider-cont="">
										<div class="slider-range-inner" data-slider-inner="" style="width: 163.058823529412px;"></div>
										<div class="slider-range-btn" data-slider-handle="" style="left: 163.058823529412px;"></div>
									</div>
								</div>
							</li>
						</ul>
					</div>

					<div class="bonusgroup-list">
						<h3>设置全部彩种奖金组（测试代理账号用）</h3>
						<ul class="clearfix gametype-row">
							<li class="slider-range slider-range-global" data-id="2" data-itemtype="all" onselectstart="return false;" data-slider-step="1">
								<div class="slider-range-scale">
									<span class="slider-title">统一设置</span>
									<a href="" data-bonus-scan="" data-path="http://ds.test.com/prize-sets/prize-set-detail" class="c-important">查 看</a>
									<span class="small-number" data-slider-min="">0</span>
									<span class="percent-number" data-slider-percent="">0%</span>
									<span class="big-number" data-slider-max="">34</span>
								</div>
								<div class="slider-current-value" data-slider-value="">1860</div>
								<div class="slider-action">
									<div class="slider-range-sub" data-slider-sub="">-</div>
									<div class="slider-range-add" data-slider-add="">+</div>
									<div class="slider-range-wrapper" data-slider-cont="">
										<div class="slider-range-inner" data-slider-inner=""></div>
										<div class="slider-range-btn" data-slider-handle=""></div>
									</div>
								</div>
							</li>
						</ul>
					</div>
				</div>
				<div class="row-lastsubmit">
					<input type="button" class="btn" value="保存奖金组设置" id="J-button-submit">
				</div>
			</div>
		</form>

	</div>
</div>

<?php include_once("../footer.php"); ?>

<script>
$(function () {
	// 奖金组数据
	var bonusData = [{"id":"623","type":"1","name":"1600","classic_prize":"1600","water":"0.2000"},{"id":"633","type":"1","name":"1610","classic_prize":"1610","water":"0.1950"},{"id":"643","type":"1","name":"1620","classic_prize":"1620","water":"0.1900"},{"id":"653","type":"1","name":"1630","classic_prize":"1630","water":"0.1850"},{"id":"663","type":"1","name":"1640","classic_prize":"1640","water":"0.1800"},{"id":"673","type":"1","name":"1650","classic_prize":"1650","water":"0.1750"},{"id":"683","type":"1","name":"1660","classic_prize":"1660","water":"0.1700"},{"id":"693","type":"1","name":"1670","classic_prize":"1670","water":"0.1650"},{"id":"703","type":"1","name":"1680","classic_prize":"1680","water":"0.1600"},{"id":"713","type":"1","name":"1690","classic_prize":"1690","water":"0.1550"},{"id":"1","type":"1","name":"1700","classic_prize":"1700","water":"0.1500"},{"id":"11","type":"1","name":"1710","classic_prize":"1710","water":"0.1450"},{"id":"21","type":"1","name":"1720","classic_prize":"1720","water":"0.1400"},{"id":"31","type":"1","name":"1730","classic_prize":"1730","water":"0.1350"},{"id":"41","type":"1","name":"1740","classic_prize":"1740","water":"0.1300"},{"id":"51","type":"1","name":"1750","classic_prize":"1750","water":"0.1250"},{"id":"61","type":"1","name":"1760","classic_prize":"1760","water":"0.1200"},{"id":"71","type":"1","name":"1770","classic_prize":"1770","water":"0.1150"},{"id":"81","type":"1","name":"1780","classic_prize":"1780","water":"0.1100"},{"id":"91","type":"1","name":"1790","classic_prize":"1790","water":"0.1050"},{"id":"101","type":"1","name":"1800","classic_prize":"1800","water":"0.1000"},{"id":"111","type":"1","name":"1810","classic_prize":"1810","water":"0.0950"},{"id":"121","type":"1","name":"1820","classic_prize":"1820","water":"0.0900"},{"id":"131","type":"1","name":"1830","classic_prize":"1830","water":"0.0850"},{"id":"141","type":"1","name":"1840","classic_prize":"1840","water":"0.0800"},{"id":"151","type":"1","name":"1850","classic_prize":"1850","water":"0.0750"},{"id":"161","type":"1","name":"1860","classic_prize":"1860","water":"0.0700"},{"id":"171","type":"1","name":"1870","classic_prize":"1870","water":"0.0650"},{"id":"181","type":"1","name":"1880","classic_prize":"1880","water":"0.0600"},{"id":"191","type":"1","name":"1890","classic_prize":"1890","water":"0.0550"},{"id":"201","type":"1","name":"1900","classic_prize":"1900","water":"0.0500"},{"id":"211","type":"1","name":"1910","classic_prize":"1910","water":"0.0450"},{"id":"221","type":"1","name":"1920","classic_prize":"1920","water":"0.0400"},{"id":"231","type":"1","name":"1930","classic_prize":"1930","water":"0.0350"},{"id":"241","type":"1","name":"1940","classic_prize":"1940","water":"0.0300"}];

	var isPlayer = 1;

	// Slider控件全局配置
	var sliderConfig = {
		'isUpOnly': true,
		'minDom': '[data-slider-sub]',
		'maxDom': '[data-slider-add]',
		'contDom': '[data-slider-cont]',
		'handleDom': '[data-slider-handle]',
		'innerDom': '[data-slider-inner]',
		'minNumDom': '[data-slider-min]',
		'maxNumDom': '[data-slider-max]'
	};

	// 根据value值获取在数组中的索引值，默认返回0
	function getBonusIndex( value, arr ){
		var i = 0, len = arr.length;
		for(i; i < len; i++){
			if(arr[i]['classic_prize'] == value ){
				return i;
			}
		}
		return 0;
	}

	$('.bonusgroup-list').each(function(){
		// 检查玩家各奖金组是否相同，并返回最大值
		// 只针对玩家设置时，但此段代码不影响代理设置
		var maxValue,
			isSameValue = true,
			globalSlider,
			sliders = [];

		$('.slider-range', this).each(function(idx){
			var value = parseInt($(this).find('[data-slider-value]').text());
			// 修改最大值
			if( !maxValue ) maxValue = value;
			if( value > maxValue ){
				maxValue = value;
				isSameValue = false;
			}
		});

		$('.slider-range', this).each(function(idx){
			var $that = $(this),
				isPlayerGlobal = isPlayer && $that.hasClass('slider-range-global'),
				defaultBouns = ( isPlayerGlobal && maxValue ) ? maxValue : parseInt($that.find('[data-slider-value]').text()),
				defaultValue = getBonusIndex( defaultBouns, bonusData ),
				settings = $.extend({}, sliderConfig, {
					'parentDom': $that,
					'step'     : 1,
					'minBound' : 0,
					'maxBound' : bonusData.length - 1,
					'value'    : defaultValue
				});
			// 创建slider实例
			var slider = new dsgame.SliderBar(settings);
			slider.addEvent('change', function(){
				var value = this.getValue(),
					$parent = this.getDom();
				// 设置返奖率
				var maxBound = bonusData[this.maxBound]['classic_prize'],
					nowBound = bonusData[value]['classic_prize'];
				var rate = (maxBound - nowBound) / 2000;
				$parent.find('[data-slider-percent]').text((rate * 100).toFixed(2) + '%');
				// 设置值
				$parent.find('[data-slider-value]').text(nowBound);
			});
			slider.setValue(defaultValue);
			if( isPlayerGlobal ){
				globalSlider = slider;
			}else{
				sliders.push( slider );
			}
		});

		if( globalSlider ){
			var $p = globalSlider.getDom();
			$p.addClass('silder-range-disabled');
			globalSlider.addEvent('change', function(){
				var value = this.getValue();
				$.each(sliders, function(idx, slider){
					slider.setValue(value);
				});
				$p.removeClass('silder-range-disabled');
			});
		}

	});

	// 表单提交
	$('#J-button-submit').click(function(){
		var userType = $.trim($('#J-input-userType').val()), //用户类型
			prizeGroup = 0;

		var PrizeGroupCache = {};
		$('[data-itemType="game"]').each(function(){
			PrizeGroupCache[$(this).attr('data-id')] = $(this).find('[data-slider-value]').html() ;
		});
		$('[data-itemType="all"]').each(function(){
			PrizeGroupCache[$(this).attr('data-id')] = $(this).find('[data-slider-value]').html() ;
		});

		var JsonData = JSON.stringify(PrizeGroupCache);
		if (PrizeGroupCache != '{}') $('#prize_group_json').val(JsonData);

		if (!PrizeGroupCache) {
			alert('请选择彩种奖金组');
			return false;
		}
		$('#J-form').submit();
	});
});

</script>

</body>
</html>
