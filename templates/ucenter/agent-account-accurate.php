<!DOCTYPE HTML>
<html lang="en-US">
<head>
<meta charset="UTF-8">
<title>链接开户 -- CC彩票</title>
<link type="text/css" rel="stylesheet" href="../images/global/global.css" />
<link type="text/css" rel="stylesheet" href="../images/ucenter/ucenter.css" />

<script type="text/javascript" src="../js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="../js/jquery.jscroll.js"></script>
<script type="text/javascript" src="../js/dsgame.base.js"></script>
<script type="text/javascript" src="../js/dsgame.Select.js"></script>
<script type="text/javascript" src="../js/dsgame.Tab.js"></script>
<script type="text/javascript" src="../js/dsgame.SliderBar.js"></script>
<script type="text/javascript" src="../js/dsgame.DatePicker.js"></script>
<script type="text/javascript" src="../js/dsgame.Mask.js"></script>
<script type="text/javascript" src="../js/dsgame.MiniWindow.js"></script>
<script type="text/javascript" src="../js/dsgame.Tip.js"></script>

</head>

<body>

<?php include_once("../header.php"); ?>


<div class="g_33 main clearfix">
	<div class="main-sider">
		
	<?php include_once("../uc-sider.php"); ?>
		
		
	</div>
	<div class="main-content">
		
		<div class="nav-bg nav-bg-tab">
			<div class="title-normal">代理中心</div>
			<ul class="tab-title clearfix">
				<li><a href="agent-user-management.php"><span>用户管理</span></a></li>
				<li><a href="agent-account-link.php"><span>链接开户</span></a></li>
				<li class="current"><a href="agent-account-accurate.php"><span>精准开户</span></a></li>
				<li><a href="agent-link-management.php"><span>链接管理</span></a></li>
				<li><a href="agent-report-rebate.php"><span>代理报表</span></a></li>
			</ul>
		</div>
		<form action="?" method="post" id="J-form">
			<input type="hidden" id="J-input-userType" value="1" />
			<input type="hidden" id="J-input-group-type" value="1" />
			<input type="hidden" id="J-input-groupid" value="" />
			<input type="hidden" id="J-input-custom-type" value="" />
			<input type="hidden" id="J-input-custom-id" value="" />
		
		<div class="content link-create-wrap" id="J-panel-cont">
			<div class="item-detail user-type-choose">
				<div class="item-title">
					<i class="item-icon-13"></i>选择账户类型
				</div>
				<div class="item-info filter-tabs-cont" id="J-user-type-switch-panel">
					<a data-userTypeId="0" href="#"><i class="user-type-icon-player"></i>玩家账号</a>
					<a data-userTypeId="1" href="#"><i class="user-type-icon-agent"></i>代理账号</a>
				</div>
			</div>
			<div class="item-detail user-info-config">
				<div class="item-title">
					<i class="item-icon-9"></i>设置用户账号信息
				</div>
				<div class="item-info">
					<p>
						<label>设置登录账号：</label>
						<input type="text" id="J-input-userName" name="username" class="input input-big w-3">
						<span style="display:none;" class="ui-text-prompt-multiline w-7">第一个字符必须为字母，由0-9，a-z，A-Z组成的6-16个字符</span>
					</p>
					<p>
						<label>设置登录密码：</label>
						<input type="text" id="J-input-password" name="password" class="input input-big w-3">
						<span style="display:none;" class="ui-text-prompt-multiline w-7">由字母和数字组成6-16个字符；且必须包含数字和字母，不允许连续三位相同</span>
					</p>
					<p>
						<label>设置昵称：</label>
						<input type="text" id="J-input-nickName" name="nickname" class="input input-big w-3">
						<span style="display:none;" class="ui-text-prompt">由2-16个字符组成</span>
					</p>
				</div>
			</div>
			<div class="item-detail user-bonus-choose">
				<div class="item-title">
					<i class="item-icon-4"></i>配置用户奖金组
				</div>
				<div class="item-info">
					<div class="filter-tabs-cont J-group-bonus-tab">
						<a href="javascript:void(0);"><span>选择奖金组套餐</span></a>
						<a href="javascript:void(0);"><span>自定义奖金组</span></a>
					</div>
				</div>
			</div>

			<ul class="tab-panels">
				<li class="tab-panel-li">
					<div class="bonus-group">
						<ul class="clearfix" id="J-panel-group">
							<li>
								<div class="bonus-group-wrap">
									<div class="bonus"><strong class="data-bonus">1930</strong>初始奖金组</div>
									<div class="rebate"><strong class="data-feedback"> 0.50%</strong>预计平均返点率</div>
									<input class="btn button-selectGroup" value="已选择" data-groupid="231" type="button">
								</div>
								<a data-bonus-scan href="prize-sets/prize-set-detail/1930">查看奖金组详情</a>
							</li>
							<li>
								<div class="bonus-group-wrap">
									<div class="bonus"><strong class="data-bonus">1920</strong>初始奖金组</div>
									<div class="rebate"><strong class="data-feedback"> 1.00%</strong>预计平均返点率</div>
									<input class="btn button-selectGroup" value="选 择" data-groupid="221" type="button">
								</div>
								<a data-bonus-scan href="prize-sets/prize-set-detail/1920">查看奖金组详情</a>
							</li>
							<li>
								<div class="bonus-group-wrap">
									<div class="bonus"><strong class="data-bonus">1910</strong>初始奖金组</div>
									<div class="rebate"><strong class="data-feedback"> 1.50%</strong>预计平均返点率</div>
									<input class="btn button-selectGroup" value="选 择" data-groupid="211" type="button">
								</div>
								<a data-bonus-scan href="prize-sets/prize-set-detail/1910">查看奖金组详情</a>
							</li>
							<li>
								<div class="bonus-group-wrap">
									<div class="bonus"><strong class="data-bonus">1900</strong>初始奖金组</div>
									<div class="rebate"><strong class="data-feedback"> 2.00%</strong>预计平均返点率</div>
									<input class="btn button-selectGroup" value="选 择" data-groupid="201" type="button">
								</div>
								<a data-bonus-scan href="prize-sets/prize-set-detail/1900">查看奖金组详情</a>
							</li>
							<li>
								<div class="bonus-group-wrap">
									<div class="bonus"><strong class="data-bonus">1890</strong>初始奖金组</div>
									<div class="rebate"><strong class="data-feedback"> 2.50%</strong>预计平均返点率</div>
									<input class="btn button-selectGroup" value="选 择" data-groupid="191" type="button">
								</div>
								<a data-bonus-scan href="prize-sets/prize-set-detail/1890">查看奖金组详情</a>
							</li>
							<li>
								<div class="bonus-group-wrap">
									<div class="bonus"><strong class="data-bonus">1880</strong>初始奖金组</div>
									<div class="rebate"><strong class="data-feedback"> 3.00%</strong>预计平均返点率</div>
									<input class="btn button-selectGroup" value="选 择" data-groupid="181" type="button">
								</div>
								<a data-bonus-scan href="prize-sets/prize-set-detail/1880">查看奖金组详情</a>
							</li>
							<li>
								<div class="bonus-group-wrap">
									<div class="bonus"><strong class="data-bonus">1870</strong>初始奖金组</div>
									<div class="rebate"><strong class="data-feedback"> 3.50%</strong>预计平均返点率</div>
									<input class="btn button-selectGroup" value="选 择" data-groupid="171" type="button">
								</div>
								<a data-bonus-scan href="prize-sets/prize-set-detail/1870">查看奖金组详情</a>
							</li>
							<li>
								<div class="bonus-group-wrap">
									<div class="bonus"><strong class="data-bonus">1860</strong>初始奖金组</div>
									<div class="rebate"><strong class="data-feedback"> 4.00%</strong>预计平均返点率</div>
									<input class="btn button-selectGroup" value="选 择" data-groupid="161" type="button">
								</div>
								<a data-bonus-scan href="prize-sets/prize-set-detail/1860">查看奖金组详情</a>
							</li>
						</ul>
						<ul class="clearfix" id="J-panel-group-agent" style="display:none">
							<li>
								<div class="bonus-group-wrap">
									<div class="bonus"><strong class="data-bonus">1940</strong>初始奖金组</div>
									<div class="rebate"><strong class="data-feedback">  0.00%</strong>预计平均返点率</div>
									<input class="btn button-selectGroup" value="选 择" data-groupid="241" type="button">
								</div>
								<a data-bonus-scan href="prize-sets/prize-set-detail/1940">查看奖金组详情</a>
							</li>
							<li>
								<div class="bonus-group-wrap">
									<div class="bonus"><strong class="data-bonus">1930</strong>初始奖金组</div>
									<div class="rebate"><strong class="data-feedback">  0.50%</strong>预计平均返点率</div>
									<input class="btn button-selectGroup" value="选 择" data-groupid="231" type="button">
								</div>
								<a data-bonus-scan href="prize-sets/prize-set-detail/1930">查看奖金组详情</a>
							</li>
							<li>
								<div class="bonus-group-wrap">
									<div class="bonus"><strong class="data-bonus">1920</strong>初始奖金组</div>
									<div class="rebate"><strong class="data-feedback">  1.00%</strong>预计平均返点率</div>
									<input class="btn button-selectGroup" value="选 择" data-groupid="221" type="button">
								</div>
								<a data-bonus-scan href="prize-sets/prize-set-detail/1920">查看奖金组详情</a>
							</li>
							<li>
								<div class="bonus-group-wrap">
									<div class="bonus"><strong class="data-bonus">1910</strong>初始奖金组</div>
									<div class="rebate"><strong class="data-feedback">  1.50%</strong>预计平均返点率</div>
									<input class="btn button-selectGroup" value="选 择" data-groupid="211" type="button">
								</div>
								<a data-bonus-scan href="prize-sets/prize-set-detail/1910">查看奖金组详情</a>
							</li>
							<li>
								<div class="bonus-group-wrap">
									<div class="bonus"><strong class="data-bonus">1900</strong>初始奖金组</div>
									<div class="rebate"><strong class="data-feedback">  2.00%</strong>预计平均返点率</div>
									<input class="btn button-selectGroup" value="选 择" data-groupid="201" type="button">
								</div>
								<a data-bonus-scan href="prize-sets/prize-set-detail/1900">查看奖金组详情</a>
							</li>
						</ul>
					</div>
				</li>
				<li class="tab-panel-li">
					<input name="series_id" id="J-input-custom-type" value="1" type="hidden">
					<input name="lottery_id" id="J-input-custom-id" value="" type="hidden">
					<div class="bonusgroup-game-type clearfix J-bonusgroup-player">
						<div class="bonusgroup-list bonusgroup-list-1">
							<h3>设置时时彩奖金组</h3>
							<ul>
							<?php
								$ssc = array(
									array(
										'isglobal' => true,
										'name' => '统一设置',
										'step' => 1,
										'min'  => 1500,
										'max'  => 1940,
										'value'=> 1800
									),
									array(
										'isglobal' => false,
										'name' => '重庆时时彩',
										'step' => 1,
										'min'  => 1500,
										'max'  => 1940,
										'value'=> 1800
									),
									array(
										'isglobal' => false,
										'name' => '黑龙江时时彩',
										'step' => 1,
										'min'  => 1500,
										'max'  => 1940,
										'value'=> 1800
									),
									array(
										'isglobal' => false,
										'name' => '江西时时彩',
										'step' => 1,
										'min'  => 1500,
										'max'  => 1940,
										'value'=> 1800
									),
									array(
										'isglobal' => false,
										'name' => '新疆时时彩',
										'step' => 1,
										'min'  => 1500,
										'max'  => 1940,
										'value'=> 1800
									),
									array(
										'isglobal' => false,
										'name' => '天津时时彩',
										'step' => 1,
										'min'  => 1500,
										'max'  => 1940,
										'value'=> 1800
									)
								);
								foreach ($ssc as $key => $value) {
									$cl = '';
									if( $value['isglobal'] ){
										$cl = ' slider-range-global';
									}
							?>
								<li class="slider-range<?=$cl?>" onselectstart="return false;" data-slider-step="<?=$value['step']?>">
									<div class="slider-range-scale">
										<span class="slider-title"><?=$value['name']?></span>
										<span class="small-number" data-slider-min><?=$value['min']?></span>
										<span class="percent-number" data-slider-percent>5%</span>
										<span class="big-number" data-slider-max><?=$value['max']?></span>
										<a href="" class="c-important">查 看</a>
									</div>
									<div class="slider-current-value" data-slider-value><?=$value['value']?></div>
									<div class="slider-action">
										<div class="slider-range-sub" data-slider-sub>-</div>
										<div class="slider-range-add" data-slider-add>+</div>
										<div class="slider-range-wrapper" data-slider-cont>
											<div class="slider-range-inner" data-slider-inner></div>
											<div class="slider-range-btn" data-slider-handle></div>
										</div>
									</div>
								</li>
							<?php		
								}
							?>
							</ul>
						</div>
						<div class="bonusgroup-list bonusgroup-list-2">
							<h3>设置11选5奖金组</h3>
							<ul>
							<?php
								$ssc = array(
									array(
										'isglobal' => true,
										'name' => '统一设置',
										'step' => 1,
										'min'  => 1500,
										'max'  => 1940,
										'value'=> 1800
									),
									array(
										'isglobal' => false,
										'name' => '山东11选5',
										'step' => 1,
										'min'  => 1500,
										'max'  => 1940,
										'value'=> 1800
									),
									array(
										'isglobal' => false,
										'name' => '江西11选5',
										'step' => 1,
										'min'  => 1500,
										'max'  => 1940,
										'value'=> 1800
									),
									array(
										'isglobal' => false,
										'name' => '广东11选5',
										'step' => 1,
										'min'  => 1500,
										'max'  => 1940,
										'value'=> 1800
									),
									array(
										'isglobal' => false,
										'name' => '重庆11选5',
										'step' => 1,
										'min'  => 1500,
										'max'  => 1940,
										'value'=> 1800
									)
								);
								foreach ($ssc as $key => $value) {
									$cl = '';
									if( $value['isglobal'] ){
										$cl = ' slider-range-global';
									}
							?>
								<li class="slider-range<?=$cl?>" onselectstart="return false;" data-slider-step="<?=$value['step']?>">
									<div class="slider-range-scale">
										<span class="slider-title"><?=$value['name']?></span>
										<span class="small-number" data-slider-min><?=$value['min']?></span>
										<span class="percent-number" data-slider-percent>5%</span>
										<span class="big-number" data-slider-max><?=$value['max']?></span>
										<a href="" class="c-important">查 看</a>
									</div>
									<div class="slider-current-value" data-slider-value><?=$value['value']?></div>
									<div class="slider-action">
										<div class="slider-range-sub" data-slider-sub>-</div>
										<div class="slider-range-add" data-slider-add>+</div>
										<div class="slider-range-wrapper" data-slider-cont>
											<div class="slider-range-inner" data-slider-inner></div>
											<div class="slider-range-btn" data-slider-handle></div>
										</div>
									</div>
								</li>
							<?php		
								}
							?>
							</ul>
						</div>
						<div class="bonusgroup-list bonusgroup-list-3">
							<h3>设置其他游戏奖金组</h3>
							<ul>
							<?php
								$ssc = array(
									array(
										'isglobal' => true,
										'name' => '3D',
										'step' => 1,
										'min'  => 1500,
										'max'  => 1940,
										'value'=> 1800
									),
									array(
										'isglobal' => false,
										'name' => 'P3/P5',
										'step' => 1,
										'min'  => 1500,
										'max'  => 1940,
										'value'=> 1800
									),
									array(
										'isglobal' => false,
										'name' => '双色球',
										'step' => 1,
										'min'  => 1500,
										'max'  => 1940,
										'value'=> 1800
									)
								);
								foreach ($ssc as $key => $value) {
									$cl = '';
									if( $value['isglobal'] ){
										$cl = ' slider-range-global';
									}
							?>
								<li class="slider-range<?=$cl?>" onselectstart="return false;" data-slider-step="<?=$value['step']?>">
									<div class="slider-range-scale">
										<span class="slider-title"><?=$value['name']?></span>
										<span class="small-number" data-slider-min><?=$value['min']?></span>
										<span class="percent-number" data-slider-percent>5%</span>
										<span class="big-number" data-slider-max><?=$value['max']?></span>
										<a href="" class="c-important">查 看</a>
									</div>
									<div class="slider-current-value" data-slider-value><?=$value['value']?></div>
									<div class="slider-action">
										<div class="slider-range-sub" data-slider-sub>-</div>
										<div class="slider-range-add" data-slider-add>+</div>
										<div class="slider-range-wrapper" data-slider-cont>
											<div class="slider-range-inner" data-slider-inner></div>
											<div class="slider-range-btn" data-slider-handle></div>
										</div>
									</div>
								</li>
							<?php		
								}
							?>
							</ul>
						</div>
						<!-- <div id="J-group-gametype-panel">
							<ul class="clearfix gametype-row">
								<li class="item-all-series current">
									<a class="item-game" data-id="1" data-itemtype="all" href="javascript:void(0);"><span class="name">全部时时彩</span></a>
								</li>
								<li class="item-lottery">
									<a class="item-game" data-id="1" data-itemtype="game" href="javascript:void(0);"><span class="name">重庆时时彩</span><span class="group">1870</span></a>
								</li>
								<li class="item-lottery">
									<a class="item-game" data-id="3" data-itemtype="game" href="javascript:void(0);"><span class="name">黑龙江时时彩</span><span class="group">1870</span></a>
								</li>
								<li class="item-lottery">
									<a class="item-game" data-id="5" data-itemtype="game" href="javascript:void(0);"><span class="name">江西时时彩</span><span class="group">1870</span></a>
								</li>
								<li class="item-lottery">
									<a class="item-game" data-id="6" data-itemtype="game" href="javascript:void(0);"><span class="name">新疆时时彩</span><span class="group">1870</span></a>
								</li>
								<li class="item-lottery">
									<a class="item-game" data-id="7" data-itemtype="game" href="javascript:void(0);"><span class="name">天津时时彩</span><span class="group">1870</span></a>
								</li>
								<li class="item-lottery">
									<a class="item-game" data-id="11" data-itemtype="game" href="javascript:void(0);"><span class="name">3D</span><span class="group">1870</span></a>
								</li>
								<li class="item-lottery">
									<a class="item-game" data-id="12" data-itemtype="game" href="javascript:void(0);"><span class="name">排列五</span><span class="group">1870</span></a>
								</li>
								<li class="item-lottery">
									<a class="item-game" data-id="13" data-itemtype="game" href="javascript:void(0);"><span class="name">CC彩票分分彩</span><span class="group">1870</span></a>
								</li>
							</ul>
							<ul class="clearfix gametype-row">
								<li class="item-all-series">
									<a class="item-game" data-id="2" data-itemtype="all" href="javascript:void(0);"><span class="name">全部11选5</span></a>
								</li>
								<li class="item-lottery">
									<a class="item-game" data-id="2" data-itemtype="game" href="javascript:void(0);"><span class="name">山东11选5</span><span class="group">1600</span></a>
								</li>
								<li class="item-lottery">
									<a class="item-game" data-id="8" data-itemtype="game" href="javascript:void(0);"><span class="name">江西11选5</span><span class="group">1600</span></a>
								</li>
								<li class="item-lottery">
									<a class="item-game" data-id="9" data-itemtype="game" href="javascript:void(0);"><span class="name">广东11选5</span><span class="group">1600</span></a>
								</li>
								<li class="item-lottery">
									<a class="item-game" data-id="10" data-itemtype="game" href="javascript:void(0);"><span class="name">重庆11选5</span><span class="group">1600</span></a>
								</li>
								<li class="item-lottery">
									<a class="item-game" data-id="14" data-itemtype="game" href="javascript:void(0);"><span class="name">CC彩票11选5</span><span class="group">1600</span></a>
								</li>
							</ul>
						</div> -->
					</div>
					<div class="bonusgroup-game-type J-bonusgroup-agent">
						<div class="bonusgroup-list bonusgroup-list-line">
							<h3>设置时时彩奖金组</h3>
							<ul>
							<?php
								$ssc = array(
									array(
										'isglobal' => true,
										'name' => '统一设置',
										'step' => 1,
										'min'  => 1500,
										'max'  => 1940,
										'value'=> 1800
									)
								);
								foreach ($ssc as $key => $value) {
									$cl = '';
									if( $value['isglobal'] ){
										$cl = ' slider-range-global';
									}
							?>
								<li class="slider-range<?=$cl?>" onselectstart="return false;" data-slider-step="<?=$value['step']?>">
									<div class="slider-range-scale">
										<span class="slider-title"><?=$value['name']?></span>
										<span class="small-number" data-slider-min><?=$value['min']?></span>
										<span class="percent-number" data-slider-percent>5%</span>
										<span class="big-number" data-slider-max><?=$value['max']?></span>
										<a href="" class="c-important">查 看</a>
									</div>
									<div class="slider-current-value" data-slider-value><?=$value['value']?></div>
									<div class="slider-action">
										<div class="slider-range-sub" data-slider-sub>-</div>
										<div class="slider-range-add" data-slider-add>+</div>
										<div class="slider-range-wrapper" data-slider-cont>
											<div class="slider-range-inner" data-slider-inner></div>
											<div class="slider-range-btn" data-slider-handle></div>
										</div>
									</div>
								</li>
							<?php		
								}
							?>
							</ul>
						</div>
					</div>
					<!-- <input id="J-input-bonusgroup-gameid" value="" type="hidden">
					<input id="J-input-lottery-json" name="lottery_prize_group_json" type="hidden">
					<input id="J-input-series-json" name="series_prize_group_json" type="hidden">
					<div class="bonusgroup-title">
						<table width="100%">
							<tbody>
								<tr>
									<td class="last">
										<div class="bonus-setup">
											<div class="bonus-setup-title">
												<strong>设置奖金</strong>
												<span class="tip">奖金组一旦上调后则无法降低，请谨慎操作。</span>
											</div>
											<div class="bonus-setup-content">
												<div class="slider-range" onselectstart="return false;">
													<div class="slider-range-sub" id="J-slider-minDom"></div>
													<div class="slider-range-add" id="J-slider-maxDom"></div>
													<div class="slider-range-wrapper" id="J-slider-cont">
														<div class="slider-range-inner" style="width: 199.636px;" id="J-slider-innerbg"></div>
														<div class="slider-range-btn" style="left: 199.636px;" id="J-slider-handle"></div>
													</div>
													<div class="slider-range-scale">
														<span class="small-number" id="J-slider-num-min">1600</span>
														<span class="big-number" id="J-slider-num-max">1930</span>
													</div>
												</div>
											</div>
										</div>
									</td>
									<td>
										<input class="input w-1" style="text-align:center;" value="" id="J-input-custom-bonus-value" type="text">
										<br><span class="tip">&nbsp;&nbsp;&nbsp;<a href="#" target="_blank" data-path="prize-sets/prize-set-detail" id="J-link-bonusgroup-detail">查看详情</a>&nbsp;&nbsp;&nbsp;</span>
									</td>
									<td class="last"><strong id="J-custom-feedback-value">3.50%</strong>
										<br><span class="tip">预计平均返点率</span></td>
								</tr>
							</tbody>
						</table>
					</div> -->
				</li>
			</ul>

			<div class="item-detail agent-user-limit J-agent-user-limit">
				<div class="item-title">
					<i class="item-icon-3"></i>设置奖金组开户配额
				</div>
				<div class="item-info">
					<p>1950及以下奖金组开户无配额限制</p>
					<ul class="agent-quota-list">
					<?php
						$quota = array(
							array(
								'id'    => 1,
								'bonus' => 1951,
								'max'   => 5
							),
							array(
								'id'    => 2,
								'bonus' => 1952,
								'max'   => 6
							),
							array(
								'id'    => 3,
								'bonus' => 1953,
								'max'   => 5
							),
							array(
								'id'    => 4,
								'bonus' => 1954,
								'max'   => 7
							),
							array(
								'id'    => 5,
								'bonus' => 1955,
								'max'   => 4
							),
							array(
								'id'    => 6,
								'bonus' => 1956,
								'max'   => 5
							)
						);
						foreach ($quota as $key => $value) { ?>
						<li>
							<h3><?=$value['bonus']?></h3>
							<input type="text" class="input w-1"
								data-quota="<?=$value['max']?>"
								data-prize="<?=$value['bonus']?>" 
								value="<?=$value['max']?>">
							<p>最大允许<span class="quota-max"><?=$value['max']?></span></p>
						</li>
					<?php } ?>
					</ul>
				</div>
			</div>

			<div class="bonus-config-result">
				<strong>账号设置结果：</strong>
				<label>账户类型<span class="J-user-type">----</span></label>
				<label>初始奖金组<span class="J-init-bonusgroup">----</span></label>
				<label>预计平均返点率<span class="J-rebates-average">----</span></label>
			</div>
			
			<div class="row-lastsubmit">
				<input type="submit" class="btn btn-important w-3" value="生成账户" id="J-button-submit" />
			</div>
			
		</div>
		</form>
		
		
		
	</div>
</div>

<?php include_once("../footer.php"); ?>


<!-- <script type="text/javascript" src="../js/dsgame.ucenter.groupgame.js"></script> -->

<script>
(function(){
	// slider事件是否已经绑定
	// 因为slider插件中要获取元素的宽度
	// 在tab切换中该元素display:none导致获取宽度为0
	// 所以需要在其父元素显示后绑定slider对象
	var sliderEventBinded_player = sliderEventBinded_agent = false;

	// 用户类型
	var userModel;

	// 开户类型切换
	var switchHandles = $('#J-user-type-switch-panel').find('a');
	switchHandles.on('click', function(e){
		var index = switchHandles.index(this),userTypeId = $.trim($(this).attr('data-userTypeId'));
		e.preventDefault();
		switchHandles.removeClass('current');
		switchHandles.eq(index).addClass('current');
		$('#J-input-userType').val(userTypeId);
		// 代理
		if( userTypeId == '1' ){
			userModel = 'agent';
			$('#J-panel-group').hide();
			$('#J-panel-group-agent').show();
			$('.J-bonusgroup-player').hide();
			$('.J-bonusgroup-agent').show();
			$('.J-agent-user-limit').show();
		}else{
		// 玩家
			userModel = 'player';
			$('#J-panel-group').show();
			$('#J-panel-group-agent').hide();
			$('.J-bonusgroup-player').show();
			$('.J-bonusgroup-agent').hide();
			$('.J-agent-user-limit').hide();
		}
		checkSlider();
		$('.J-user-type').text($(this).text());
		// defaultPrizeGroup = aDefaultPrizeGroups[+userTypeId];
		// defaultMaxPrizeGroup = aDefaultMaxPrizeGroups[+userTypeId];
		// $('#J-input-custom-bonus-value').val(defaultPrizeGroup['classic_prize']);
		// loadGroupDataByUserTypeId(userTypeId);
	}).eq(0).trigger('click');

	// 固定奖金组和自定义奖金组切换
	var tab = new dsgame.Tab({
		par:'#J-panel-cont',
		triggers:'.J-group-bonus-tab > a',
		panels:'.tab-panels > li',
		eventType:'click',
		index: 0
	});
	tab.addEvent('afterSwitch', function(e, index){
		$('#J-input-group-type').val(index + 1);
		// 自定义设置
		if( tab.getTriggerIndex() == 1 ){
			$('.J-rebates-average').parent().hide();
			checkSlider();
		}else{
		// 奖金组套餐组
			$('.J-rebates-average').parent().show();
		}
	});

	function checkSlider(){
		if( !sliderEventBinded_player && $('.J-bonusgroup-player').is(':visible') ){
			bindAllSlider($('.J-bonusgroup-player'));
			sliderEventBinded_player = true;
		}else if( !sliderEventBinded_agent && $('.J-bonusgroup-agent').is(':visible') ){
			bindAllSlider($('.J-bonusgroup-agent'));
			sliderEventBinded_agent = true;
		}
	}

	// 选择某个奖金组套餐
	$('#J-panel-group, #J-panel-group-agent').on('click', '.bonus-group-wrap', function(){
		var $this = $(this),
			$input = $this.find('.button-selectGroup'),
			groupid = $.trim($input.attr('data-groupid')),
			prize = $this.find('.data-bonus').text(),
			feedback = $this.find('.data-feedback').text();
		$('#J-input-groupid').val(groupid);
		$('#J-input-prize').val(prize);
		$('#J-panel-group').find('.bonus-group-wrap').removeClass('current');
		$('#J-panel-group-agent').find('.bonus-group-wrap').removeClass('current');
		// $('#J-panel-group').find('input[type="button"]').val('选 择')
		$this.addClass('current');
		// $input.val('已选择');
		$('.J-init-bonusgroup').text(prize);
		$('.J-rebates-average').text(feedback);
		checkQuotaLimitStatus( prize );
	});

	//自定义奖金组设置组件
	var sliderConfig = {
		// 'isUpOnly' : true,
		'minDom'   : '[data-slider-sub]',
		'maxDom'   : '[data-slider-add]',
		'contDom'  : '[data-slider-cont]',
		'handleDom': '[data-slider-handle]',
		'innerDom' : '[data-slider-inner]',
		'minNumDom': '[data-slider-min]',
		'maxNumDom': '[data-slider-max]'
	};
	function bindAllSlider($parent){
		$('.bonusgroup-list', $parent).each(function(idx){
			var $this = $(this),
				globalSlider, // 统一设置slider
				sliders = []; // 分段设置slider
			$this.find('.slider-range').each(function(_idx){
				var $this = $(this),
					settings = $.extend({}, sliderConfig, {
						'parentDom': $this,
						'step'     : parseFloat($this.data('slider-step')),
						'minBound' : parseFloat($this.find('[data-slider-min]').text()),
						'maxBound' : parseFloat($this.find('[data-slider-max]').text()),
						'value'    : parseFloat($this.find('[data-slider-value]').text())
					});
				// console.log(settings)
				if( $(this).hasClass('slider-range-global') ){
					globalSlider = new dsgame.SliderBar( settings );
				}else{
					sliders.push(new dsgame.SliderBar( settings ));
				}
			});
			// 全局设置
			if( globalSlider ){				
				globalSlider.addEvent('change', function(){
					var value = this.getValue(),
						$parent = this.getDom();
					$.each(sliders, function(i,s){
						if( s && s.setValue ){
							s.setValue(value);
						}
					});
					// 设置返奖率
					var rate = (this.maxBound - value) / 2000;
					$parent.find('[data-slider-percent]').text((rate*100).toFixed(2) +'%');
					// 设置值
					$parent.find('[data-slider-value]').text(value);
					// 设置平均返点率
					$('.J-init-bonusgroup').text('已针对不同游戏分别设置奖金组');
					if( userModel == 'agent' ){
						checkQuotaLimitStatus(value);
					}
				});
				globalSlider.setValue(parseFloat(globalSlider.getDom().find('[data-slider-value]').text()));
			}
			// 单游戏设置
			$.each(sliders, function(i,s){
				// if( s && s.setValue ){
				// 	s.setValue(value);
				// }
				s.addEvent('change', function(){
					var value = this.getValue(),
						$parent = this.getDom();
					// 设置返奖率
					var rate = (this.maxBound - value) / 2000;
					$parent.find('[data-slider-percent]').text((rate*100).toFixed(2) +'%');
					// 设置值
					$parent.find('[data-slider-value]').text(value);
					// 设置平均返点率
					$('.J-init-bonusgroup').text('已针对不同游戏分别设置奖金组');
				});
				s.setValue(parseFloat(s.getDom().find('[data-slider-value]').text()));
			});
		});
		sliderEventBinded = true;
	}

	// 配额输入验证
	$('input[data-quota]').on('change', function(){
		var $this = $(this),
			val = parseInt( $this.val() ) || 0,
			max = parseInt( $this.data('quota') );
		if( val < 1 || val > max ){
			val = max
		}
		$this.val(val);
	});

	// 通过奖金组来判断某配额设置是否显示
	var checkQuotaLimitStatus = function( prize ){
		var prizeGroup = parseInt( prize ) || 0,
			showNum = 0;
		$('input[data-quota]').each(function(){
	        var prize = $(this).data('prize');
	        console.log(prize, prizeGroup)
	        if( prize <= prizeGroup ){
	            $(this).parent().show();
	            showNum++;
	        }else{
	        	$(this).parent().hide();
	        }
	    });
	    if( showNum > 0 && userModel == 'agent' ){
	    	$('.J-agent-user-limit').show();
	    }else{
	    	$('.J-agent-user-limit').hide();
	    }
	}

	// 获取当前配额设置数据对象
	var getQuotaData = function(){
	    // 只有代理才有配额设定，所以可以直接指定获取该DOM的value值，作为最大奖金组
	    var prizeGroup = parseInt( $('#J-input-prize').val() ),
	        // 代理用户配额限制数据变量
	        dataObj = {};
	    $('input[data-quota]:visible').each(function(){
	        var quota = $(this).data('quota'),
	            prize = $(this).data('prize');
	        if( prize <= prizeGroup ){
	            dataObj[prize] = quota;
	        }
	    });
	    return dataObj;
	};

	// Tip
	var inputTip = new dsgame.Tip({cls:'j-ui-tip-b w-4'});
	$('.user-info-config input').on({
		focus: function(e){
			var $this = $(this),
				text = $this.siblings('span[class|="ui-text-prompt"]').text();
			inputTip.setText(text);
			inputTip.show(-30, inputTip.getDom().height() * -1 - 22, $this);
			e.preventDefault();
		},
		blur: function(){
			inputTip.hide();
		}
	});
	
	//表单提交
	/*$('#J-button-submit').click(function(e) {
		var userType = $.trim($('#J-input-userType').val()),
			userName = $.trim($('#J-input-userName').val()),
			password = $.trim($('#J-input-password').val()),
			nickName = $.trim($('#J-input-nickName').val()),
			panelType = +userType == 1 ? 'J-panel-group-agent' : 'J-panel-group',
			returnRebate = $('#' + panelType).find('li.current').find('.data-feedback').text(),
			prizeGroup = 0,
			//套餐还是自定义
			groupType = $.trim($('#J-input-group-type').val());
		var lotteriesJsonData = JSON.stringify(lotteryPrizeGroupCache),
			seriesJsonData = JSON.stringify(seriesPrizeGroupCache);
		if (lotteriesJsonData != '{}') $('#J-input-lottery-json').val(lotteriesJsonData);
		if (seriesJsonData != '{}') $('#J-input-series-json').val(seriesJsonData);
		// return false;
		if (userName == '') {
			alert('请输入登录账号');
			return false;
		}
		if (password == '') {
			alert('请输入登录密码');
			return false;
		} else if (!(/^(?=.*\d+)(?=.*[a-zA-Z]+)(?!.*?([a-zA-Z0-9]{1})\1\1).{6,16}$/).test(password)) {
			alert('密码格式不正确，请重新输入');
			return false;
		}
		if (nickName == '') {
			alert('请输入用户昵称');
			return false;
		}
		//套餐
		if (groupType == '1') {
			if ($.trim($('#J-input-groupid').val()) == '') {
				alert('请选择一个奖金组套餐');
				return false;
			}
			prizeGroup = $.trim($('#J-input-prize').val());
		} else {
			if ($.trim($('#J-input-custom-type').val()) == '' && $.trim($('#J-input-custom-id').val()) == '') {
				alert('请选择一个游戏或者彩种进行设置');
				return false;
			}
			if (seriesPrizeGroupCache) {
				for (var m in seriesPrizeGroupCache) {
					var prize = seriesPrizeGroupCache[m];
					prizeGroup = Math.max(prizeGroup, prize);
				}
			}
			if (lotteryPrizeGroupCache) {
				for (var m in lotteryPrizeGroupCache) {
					var prize = lotteryPrizeGroupCache[m];
					prizeGroup = Math.max(prizeGroup, prize);
				}
			}
		}
		var data = {
			title: '信息确认',
			content: generateConfirmInfo(userType, userName, password, nickName, prizeGroup, returnRebate),
			confirmIsShow: true,
			cancelIsShow: true,
			confirmButtonText: '确认',
			cancelButtonText: '取消',
			cssName: 'w-13',
			confirmFun: function() {
				$('#J-form').submit();
			},
			cancelFun: function() {
				confirmWin.hide();
			}
		};
		confirmWin.show(data);
		// return true;
	});*/
	
})();
</script>

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
