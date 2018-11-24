<!DOCTYPE HTML>
<html lang="en-US">
<head>
<meta charset="UTF-8">
<title>奖金组管理 -- CC彩票</title>
<link type="text/css" rel="stylesheet" href="../images/global/global.css" />
<link type="text/css" rel="stylesheet" href="../images/ucenter/ucenter.css" />

<script src="../js/jquery-1.9.1.min.js"></script>
<script src="../js/jquery.easing.1.3.js"></script>
<script src="../js/jquery.mousewheel.min.js"></script>
<script src="../js/jquery.jscrollpane.js"></script>
<script src="../js/dsgame.base.js"></script>
<script src="../js/dsgame.Ernie.js"></script>
<script src="../js/dsgame.Mask.js"></script>
<script src="../js/dsgame.MiniWindow.js"></script>
<!-- <script src="../js/global.js"></script> -->

<script src="../js/dsgame.Select.js"></script>
<script src="../js/dsgame.Message.js"></script>
<script src="../js/dsgame.Tip.js"></script>

<script src="../js/jquery.jscrollpane.js"></script>
<script src="../js/dsgame.SliderBar.js"></script>

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
		<form action="http://dsgame168.com/prize-sets/set-prize-set/265" method="post" id="J-form">
		    <input type="hidden" name="_token" value="1TjljPrWZbI6b97me8N5zrIRoE1jXrK2imz6fijT" />
		    <input type="hidden" name="_method" value="PUT" />
		    <input type="hidden" name="lottery_id" value="1" />
		    <input type="hidden" name="lottery_prize_group_json" id="prize_group_json" />
		    <div class="content" id="J-panel-cont">
		        <div class="bonusgroup-title" style="margin-top:0;">
		            <table width="100%">
		                <tr>
		                    <td>a123123
		                        <br /><span class="tip">用户名称</span></td>
		                    <td>123
		                        <br /><span class="tip">用户昵称</span></td>
		                    <td>玩家
		                        <br /><span class="tip">用户类型</span></td>
		                    <td>1,193.983100 元
		                        <br /><span class="tip">可用余额</span></td>
		                    <td class="last">400000 元
		                        <br /><span class="tip">奖金限额</span></td>
		                </tr>
		            </table>
		        </div>
		        <div class="prompt-text" style="padding:5px 10px;margin-top:20px;">
		            <div class="item-title" style="margin-bottom:0;"><i class="item-icon-15"></i>特别提示：调整用户奖金组时，一旦调高并保存后，将不允许恢复或调低，请谨慎操作！</div>
		        </div>
		        <div class="row-title">奖金组设置</div>
		        <div class="bonusgroup-game-type clearfix" style="padding-top:0">
		            <div class="bonusgroup-list">
		                <h3>设置时时彩奖金组</h3>
		                <ul class="clearfix gametype-row">
		                    <li class="slider-range slider-range-global" data-id="1" data-itemType="all" onselectstart="return false;" data-slider-step="1">
		                        <div class="slider-range-scale">
		                            <span class="slider-title">统一设置</span>
		                            <a href="" data-bonus-scan class="c-important">查 看</a>
		                            <span class="small-number" data-slider-min>1600</span>
		                            <span class="percent-number" data-slider-percent>0%</span>
		                            <span class="big-number" data-slider-max>1949</span>
		                        </div>
		                        <div class="slider-current-value" data-slider-value>0</div>
		                        <div class="slider-action">
		                            <div class="slider-range-sub" data-slider-sub>-</div>
		                            <div class="slider-range-add" data-slider-add>+</div>
		                            <div class="slider-range-wrapper" data-slider-cont>
		                                <div class="slider-range-inner" data-slider-inner></div>
		                                <div class="slider-range-btn" data-slider-handle></div>
		                            </div>
		                        </div>
		                    </li>
		                    <li class="slider-range" data-id="1" data-itemType="game" onselectstart="return false;" data-slider-step="1">
		                        <div class="slider-range-scale">
		                            <span class="slider-title">重庆时时彩</span>
		                            <a href="" data-bonus-scan class="c-important">查 看</a>
		                            <span class="small-number" data-slider-min>1600</span>
		                            <span class="percent-number" data-slider-percent>0%</span>
		                            <span class="big-number" data-slider-max>1949</span>
		                        </div>
		                        <div class="slider-current-value" data-slider-value>1950</div>
		                        <div class="slider-action">
		                            <div class="slider-range-sub" data-slider-sub>-</div>
		                            <div class="slider-range-add" data-slider-add>+</div>
		                            <div class="slider-range-wrapper" data-slider-cont>
		                                <div class="slider-range-inner" data-slider-inner></div>
		                                <div class="slider-range-btn" data-slider-handle></div>
		                            </div>
		                        </div>
		                    </li>
		                    <li class="slider-range" data-id="3" data-itemType="game" onselectstart="return false;" data-slider-step="1">
		                        <div class="slider-range-scale">
		                            <span class="slider-title">黑龙江时时彩</span>
		                            <a href="" data-bonus-scan class="c-important">查 看</a>
		                            <span class="small-number" data-slider-min>1600</span>
		                            <span class="percent-number" data-slider-percent>0%</span>
		                            <span class="big-number" data-slider-max>1949</span>
		                        </div>
		                        <div class="slider-current-value" data-slider-value>1950</div>
		                        <div class="slider-action">
		                            <div class="slider-range-sub" data-slider-sub>-</div>
		                            <div class="slider-range-add" data-slider-add>+</div>
		                            <div class="slider-range-wrapper" data-slider-cont>
		                                <div class="slider-range-inner" data-slider-inner></div>
		                                <div class="slider-range-btn" data-slider-handle></div>
		                            </div>
		                        </div>
		                    </li>
		                    <li class="slider-range" data-id="5" data-itemType="game" onselectstart="return false;" data-slider-step="1">
		                        <div class="slider-range-scale">
		                            <span class="slider-title">江西时时彩</span>
		                            <a href="" data-bonus-scan class="c-important">查 看</a>
		                            <span class="small-number" data-slider-min>1600</span>
		                            <span class="percent-number" data-slider-percent>0%</span>
		                            <span class="big-number" data-slider-max>1949</span>
		                        </div>
		                        <div class="slider-current-value" data-slider-value>1950</div>
		                        <div class="slider-action">
		                            <div class="slider-range-sub" data-slider-sub>-</div>
		                            <div class="slider-range-add" data-slider-add>+</div>
		                            <div class="slider-range-wrapper" data-slider-cont>
		                                <div class="slider-range-inner" data-slider-inner></div>
		                                <div class="slider-range-btn" data-slider-handle></div>
		                            </div>
		                        </div>
		                    </li>
		                    <li class="slider-range" data-id="6" data-itemType="game" onselectstart="return false;" data-slider-step="1">
		                        <div class="slider-range-scale">
		                            <span class="slider-title">新疆时时彩</span>
		                            <a href="" data-bonus-scan class="c-important">查 看</a>
		                            <span class="small-number" data-slider-min>1600</span>
		                            <span class="percent-number" data-slider-percent>0%</span>
		                            <span class="big-number" data-slider-max>1949</span>
		                        </div>
		                        <div class="slider-current-value" data-slider-value>1950</div>
		                        <div class="slider-action">
		                            <div class="slider-range-sub" data-slider-sub>-</div>
		                            <div class="slider-range-add" data-slider-add>+</div>
		                            <div class="slider-range-wrapper" data-slider-cont>
		                                <div class="slider-range-inner" data-slider-inner></div>
		                                <div class="slider-range-btn" data-slider-handle></div>
		                            </div>
		                        </div>
		                    </li>
		                    <li class="slider-range" data-id="7" data-itemType="game" onselectstart="return false;" data-slider-step="1">
		                        <div class="slider-range-scale">
		                            <span class="slider-title">天津时时彩</span>
		                            <a href="" data-bonus-scan class="c-important">查 看</a>
		                            <span class="small-number" data-slider-min>1600</span>
		                            <span class="percent-number" data-slider-percent>0%</span>
		                            <span class="big-number" data-slider-max>1949</span>
		                        </div>
		                        <div class="slider-current-value" data-slider-value>1950</div>
		                        <div class="slider-action">
		                            <div class="slider-range-sub" data-slider-sub>-</div>
		                            <div class="slider-range-add" data-slider-add>+</div>
		                            <div class="slider-range-wrapper" data-slider-cont>
		                                <div class="slider-range-inner" data-slider-inner></div>
		                                <div class="slider-range-btn" data-slider-handle></div>
		                            </div>
		                        </div>
		                    </li>
		                    <li class="slider-range" data-id="11" data-itemType="game" onselectstart="return false;" data-slider-step="1">
		                        <div class="slider-range-scale">
		                            <span class="slider-title">3D</span>
		                            <a href="" data-bonus-scan class="c-important">查 看</a>
		                            <span class="small-number" data-slider-min>1600</span>
		                            <span class="percent-number" data-slider-percent>0%</span>
		                            <span class="big-number" data-slider-max>1949</span>
		                        </div>
		                        <div class="slider-current-value" data-slider-value>1950</div>
		                        <div class="slider-action">
		                            <div class="slider-range-sub" data-slider-sub>-</div>
		                            <div class="slider-range-add" data-slider-add>+</div>
		                            <div class="slider-range-wrapper" data-slider-cont>
		                                <div class="slider-range-inner" data-slider-inner></div>
		                                <div class="slider-range-btn" data-slider-handle></div>
		                            </div>
		                        </div>
		                    </li>
		                    <li class="slider-range" data-id="12" data-itemType="game" onselectstart="return false;" data-slider-step="1">
		                        <div class="slider-range-scale">
		                            <span class="slider-title">排列五</span>
		                            <a href="" data-bonus-scan class="c-important">查 看</a>
		                            <span class="small-number" data-slider-min>1600</span>
		                            <span class="percent-number" data-slider-percent>0%</span>
		                            <span class="big-number" data-slider-max>1949</span>
		                        </div>
		                        <div class="slider-current-value" data-slider-value>1950</div>
		                        <div class="slider-action">
		                            <div class="slider-range-sub" data-slider-sub>-</div>
		                            <div class="slider-range-add" data-slider-add>+</div>
		                            <div class="slider-range-wrapper" data-slider-cont>
		                                <div class="slider-range-inner" data-slider-inner></div>
		                                <div class="slider-range-btn" data-slider-handle></div>
		                            </div>
		                        </div>
		                    </li>
		                    <li class="slider-range" data-id="13" data-itemType="game" onselectstart="return false;" data-slider-step="1">
		                        <div class="slider-range-scale">
		                            <span class="slider-title">CC彩票分分彩</span>
		                            <a href="" data-bonus-scan class="c-important">查 看</a>
		                            <span class="small-number" data-slider-min>1600</span>
		                            <span class="percent-number" data-slider-percent>0%</span>
		                            <span class="big-number" data-slider-max>1949</span>
		                        </div>
		                        <div class="slider-current-value" data-slider-value>1950</div>
		                        <div class="slider-action">
		                            <div class="slider-range-sub" data-slider-sub>-</div>
		                            <div class="slider-range-add" data-slider-add>+</div>
		                            <div class="slider-range-wrapper" data-slider-cont>
		                                <div class="slider-range-inner" data-slider-inner></div>
		                                <div class="slider-range-btn" data-slider-handle></div>
		                            </div>
		                        </div>
		                    </li>
		                </ul>
		            </div>
		            <div class="bonusgroup-list">
		                <h3>设置11选5奖金组</h3>
		                <ul class="clearfix gametype-row">
		                    <li class="slider-range slider-range-global" data-id="2" data-itemType="all" onselectstart="return false;" data-slider-step="1">
		                        <div class="slider-range-scale">
		                            <span class="slider-title">统一设置</span>
		                            <a href="" data-bonus-scan class="c-important">查 看</a>
		                            <span class="small-number" data-slider-min>1600</span>
		                            <span class="percent-number" data-slider-percent>0%</span>
		                            <span class="big-number" data-slider-max>1949</span>
		                        </div>
		                        <div class="slider-current-value" data-slider-value>0</div>
		                        <div class="slider-action">
		                            <div class="slider-range-sub" data-slider-sub>-</div>
		                            <div class="slider-range-add" data-slider-add>+</div>
		                            <div class="slider-range-wrapper" data-slider-cont>
		                                <div class="slider-range-inner" data-slider-inner></div>
		                                <div class="slider-range-btn" data-slider-handle></div>
		                            </div>
		                        </div>
		                    </li>
		                    <li class="slider-range" data-id="2" data-itemType="game" onselectstart="return false;" data-slider-step="1">
		                        <div class="slider-range-scale">
		                            <span class="slider-title">山东11选5</span>
		                            <a href="" data-bonus-scan class="c-important">查 看</a>
		                            <span class="small-number" data-slider-min>1600</span>
		                            <span class="percent-number" data-slider-percent>0%</span>
		                            <span class="big-number" data-slider-max>1949</span>
		                        </div>
		                        <div class="slider-current-value" data-slider-value>1945</div>
		                        <div class="slider-action">
		                            <div class="slider-range-sub" data-slider-sub>-</div>
		                            <div class="slider-range-add" data-slider-add>+</div>
		                            <div class="slider-range-wrapper" data-slider-cont>
		                                <div class="slider-range-inner" data-slider-inner></div>
		                                <div class="slider-range-btn" data-slider-handle></div>
		                            </div>
		                        </div>
		                    </li>
		                    <li class="slider-range" data-id="8" data-itemType="game" onselectstart="return false;" data-slider-step="1">
		                        <div class="slider-range-scale">
		                            <span class="slider-title">江西11选5</span>
		                            <a href="" data-bonus-scan class="c-important">查 看</a>
		                            <span class="small-number" data-slider-min>1600</span>
		                            <span class="percent-number" data-slider-percent>0%</span>
		                            <span class="big-number" data-slider-max>1949</span>
		                        </div>
		                        <div class="slider-current-value" data-slider-value>1945</div>
		                        <div class="slider-action">
		                            <div class="slider-range-sub" data-slider-sub>-</div>
		                            <div class="slider-range-add" data-slider-add>+</div>
		                            <div class="slider-range-wrapper" data-slider-cont>
		                                <div class="slider-range-inner" data-slider-inner></div>
		                                <div class="slider-range-btn" data-slider-handle></div>
		                            </div>
		                        </div>
		                    </li>
		                    <li class="slider-range" data-id="9" data-itemType="game" onselectstart="return false;" data-slider-step="1">
		                        <div class="slider-range-scale">
		                            <span class="slider-title">广东11选5</span>
		                            <a href="" data-bonus-scan class="c-important">查 看</a>
		                            <span class="small-number" data-slider-min>1600</span>
		                            <span class="percent-number" data-slider-percent>0%</span>
		                            <span class="big-number" data-slider-max>1949</span>
		                        </div>
		                        <div class="slider-current-value" data-slider-value>1945</div>
		                        <div class="slider-action">
		                            <div class="slider-range-sub" data-slider-sub>-</div>
		                            <div class="slider-range-add" data-slider-add>+</div>
		                            <div class="slider-range-wrapper" data-slider-cont>
		                                <div class="slider-range-inner" data-slider-inner></div>
		                                <div class="slider-range-btn" data-slider-handle></div>
		                            </div>
		                        </div>
		                    </li>
		                    <li class="slider-range" data-id="10" data-itemType="game" onselectstart="return false;" data-slider-step="1">
		                        <div class="slider-range-scale">
		                            <span class="slider-title">重庆11选5</span>
		                            <a href="" data-bonus-scan class="c-important">查 看</a>
		                            <span class="small-number" data-slider-min>1600</span>
		                            <span class="percent-number" data-slider-percent>0%</span>
		                            <span class="big-number" data-slider-max>1949</span>
		                        </div>
		                        <div class="slider-current-value" data-slider-value>1948</div>
		                        <div class="slider-action">
		                            <div class="slider-range-sub" data-slider-sub>-</div>
		                            <div class="slider-range-add" data-slider-add>+</div>
		                            <div class="slider-range-wrapper" data-slider-cont>
		                                <div class="slider-range-inner" data-slider-inner></div>
		                                <div class="slider-range-btn" data-slider-handle></div>
		                            </div>
		                        </div>
		                    </li>
		                    <li class="slider-range" data-id="14" data-itemType="game" onselectstart="return false;" data-slider-step="1">
		                        <div class="slider-range-scale">
		                            <span class="slider-title">CC彩票11选5</span>
		                            <a href="" data-bonus-scan class="c-important">查 看</a>
		                            <span class="small-number" data-slider-min>1600</span>
		                            <span class="percent-number" data-slider-percent>0%</span>
		                            <span class="big-number" data-slider-max>1949</span>
		                        </div>
		                        <div class="slider-current-value" data-slider-value>1945</div>
		                        <div class="slider-action">
		                            <div class="slider-range-sub" data-slider-sub>-</div>
		                            <div class="slider-range-add" data-slider-add>+</div>
		                            <div class="slider-range-wrapper" data-slider-cont>
		                                <div class="slider-range-inner" data-slider-inner></div>
		                                <div class="slider-range-btn" data-slider-handle></div>
		                            </div>
		                        </div>
		                    </li>
		                </ul>
		            </div>
		        </div>
		        <div class="row-lastsubmit">
		            <input type="button" class="btn btn-important" value="保存奖金组设置" id="J-button-submit">
		        </div>
		    </div>
		    </div>
		</form>

	</div>
</div>

<?php include_once("../footer.php"); ?>

<script>
//弹窗
var openWindow = function () {
    var mask = new dsgame.Mask(),
        miniwindow = new dsgame.MiniWindow({ cls: 'w-13 iframe-miniwindow' });

    var hideMask = function(){
        miniwindow.hide();
        mask.hide();
    };
    var getContent = function(url){
        return '<iframe src="' + url + '" id="bonus-scan-frame" ' +
        'width="100%" height="550" frameborder="0" allowtransparency="true" scrolling="no"></iframe>'
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
};


$(function () {
    // 奖金组数据
    var bonusData = [{"id":"251","type":"1","name":"1950","classic_prize":"1950","water":"0.0250"},{"id":"250","type":"1","name":"1949","classic_prize":"1949","water":"0.0255"},{"id":"249","type":"1","name":"1948","classic_prize":"1948","water":"0.0260"},{"id":"248","type":"1","name":"1947","classic_prize":"1947","water":"0.0265"},{"id":"247","type":"1","name":"1946","classic_prize":"1946","water":"0.0270"},{"id":"246","type":"1","name":"1945","classic_prize":"1945","water":"0.0275"},{"id":"245","type":"1","name":"1944","classic_prize":"1944","water":"0.0280"},{"id":"244","type":"1","name":"1943","classic_prize":"1943","water":"0.0285"},{"id":"243","type":"1","name":"1942","classic_prize":"1942","water":"0.0290"},{"id":"242","type":"1","name":"1941","classic_prize":"1941","water":"0.0295"},{"id":"241","type":"1","name":"1940","classic_prize":"1940","water":"0.0300"},{"id":"240","type":"1","name":"1939","classic_prize":"1939","water":"0.0305"},{"id":"239","type":"1","name":"1938","classic_prize":"1938","water":"0.0310"},{"id":"238","type":"1","name":"1937","classic_prize":"1937","water":"0.0315"},{"id":"237","type":"1","name":"1936","classic_prize":"1936","water":"0.0320"},{"id":"236","type":"1","name":"1935","classic_prize":"1935","water":"0.0325"},{"id":"235","type":"1","name":"1934","classic_prize":"1934","water":"0.0330"},{"id":"234","type":"1","name":"1933","classic_prize":"1933","water":"0.0335"},{"id":"233","type":"1","name":"1932","classic_prize":"1932","water":"0.0340"},{"id":"232","type":"1","name":"1931","classic_prize":"1931","water":"0.0345"},{"id":"231","type":"1","name":"1930","classic_prize":"1930","water":"0.0350"},{"id":"230","type":"1","name":"1929","classic_prize":"1929","water":"0.0355"},{"id":"229","type":"1","name":"1928","classic_prize":"1928","water":"0.0360"},{"id":"228","type":"1","name":"1927","classic_prize":"1927","water":"0.0365"},{"id":"227","type":"1","name":"1926","classic_prize":"1926","water":"0.0370"},{"id":"226","type":"1","name":"1925","classic_prize":"1925","water":"0.0375"},{"id":"225","type":"1","name":"1924","classic_prize":"1924","water":"0.0380"},{"id":"224","type":"1","name":"1923","classic_prize":"1923","water":"0.0385"},{"id":"223","type":"1","name":"1922","classic_prize":"1922","water":"0.0390"},{"id":"222","type":"1","name":"1921","classic_prize":"1921","water":"0.0395"},{"id":"221","type":"1","name":"1920","classic_prize":"1920","water":"0.0400"},{"id":"220","type":"1","name":"1919","classic_prize":"1919","water":"0.0405"},{"id":"219","type":"1","name":"1918","classic_prize":"1918","water":"0.0410"},{"id":"218","type":"1","name":"1917","classic_prize":"1917","water":"0.0415"},{"id":"217","type":"1","name":"1916","classic_prize":"1916","water":"0.0420"},{"id":"216","type":"1","name":"1915","classic_prize":"1915","water":"0.0425"},{"id":"215","type":"1","name":"1914","classic_prize":"1914","water":"0.0430"},{"id":"214","type":"1","name":"1913","classic_prize":"1913","water":"0.0435"},{"id":"213","type":"1","name":"1912","classic_prize":"1912","water":"0.0440"},{"id":"212","type":"1","name":"1911","classic_prize":"1911","water":"0.0445"},{"id":"211","type":"1","name":"1910","classic_prize":"1910","water":"0.0450"},{"id":"210","type":"1","name":"1909","classic_prize":"1909","water":"0.0455"},{"id":"209","type":"1","name":"1908","classic_prize":"1908","water":"0.0460"},{"id":"208","type":"1","name":"1907","classic_prize":"1907","water":"0.0465"},{"id":"207","type":"1","name":"1906","classic_prize":"1906","water":"0.0470"},{"id":"206","type":"1","name":"1905","classic_prize":"1905","water":"0.0475"},{"id":"205","type":"1","name":"1904","classic_prize":"1904","water":"0.0480"},{"id":"204","type":"1","name":"1903","classic_prize":"1903","water":"0.0485"},{"id":"203","type":"1","name":"1902","classic_prize":"1902","water":"0.0490"},{"id":"202","type":"1","name":"1901","classic_prize":"1901","water":"0.0495"},{"id":"201","type":"1","name":"1900","classic_prize":"1900","water":"0.0500"},{"id":"200","type":"1","name":"1899","classic_prize":"1899","water":"0.0505"},{"id":"199","type":"1","name":"1898","classic_prize":"1898","water":"0.0510"},{"id":"198","type":"1","name":"1897","classic_prize":"1897","water":"0.0515"},{"id":"197","type":"1","name":"1896","classic_prize":"1896","water":"0.0520"},{"id":"196","type":"1","name":"1895","classic_prize":"1895","water":"0.0525"},{"id":"195","type":"1","name":"1894","classic_prize":"1894","water":"0.0530"},{"id":"194","type":"1","name":"1893","classic_prize":"1893","water":"0.0535"},{"id":"193","type":"1","name":"1892","classic_prize":"1892","water":"0.0540"},{"id":"192","type":"1","name":"1891","classic_prize":"1891","water":"0.0545"},{"id":"191","type":"1","name":"1890","classic_prize":"1890","water":"0.0550"},{"id":"190","type":"1","name":"1889","classic_prize":"1889","water":"0.0555"},{"id":"189","type":"1","name":"1888","classic_prize":"1888","water":"0.0560"},{"id":"188","type":"1","name":"1887","classic_prize":"1887","water":"0.0565"},{"id":"187","type":"1","name":"1886","classic_prize":"1886","water":"0.0570"},{"id":"186","type":"1","name":"1885","classic_prize":"1885","water":"0.0575"},{"id":"185","type":"1","name":"1884","classic_prize":"1884","water":"0.0580"},{"id":"184","type":"1","name":"1883","classic_prize":"1883","water":"0.0585"},{"id":"183","type":"1","name":"1882","classic_prize":"1882","water":"0.0590"},{"id":"182","type":"1","name":"1881","classic_prize":"1881","water":"0.0595"},{"id":"181","type":"1","name":"1880","classic_prize":"1880","water":"0.0600"},{"id":"180","type":"1","name":"1879","classic_prize":"1879","water":"0.0605"},{"id":"179","type":"1","name":"1878","classic_prize":"1878","water":"0.0610"},{"id":"178","type":"1","name":"1877","classic_prize":"1877","water":"0.0615"},{"id":"177","type":"1","name":"1876","classic_prize":"1876","water":"0.0620"},{"id":"176","type":"1","name":"1875","classic_prize":"1875","water":"0.0625"},{"id":"175","type":"1","name":"1874","classic_prize":"1874","water":"0.0630"},{"id":"174","type":"1","name":"1873","classic_prize":"1873","water":"0.0635"},{"id":"173","type":"1","name":"1872","classic_prize":"1872","water":"0.0640"},{"id":"172","type":"1","name":"1871","classic_prize":"1871","water":"0.0645"},{"id":"171","type":"1","name":"1870","classic_prize":"1870","water":"0.0650"},{"id":"170","type":"1","name":"1869","classic_prize":"1869","water":"0.0655"},{"id":"169","type":"1","name":"1868","classic_prize":"1868","water":"0.0660"},{"id":"168","type":"1","name":"1867","classic_prize":"1867","water":"0.0665"},{"id":"167","type":"1","name":"1866","classic_prize":"1866","water":"0.0670"},{"id":"166","type":"1","name":"1865","classic_prize":"1865","water":"0.0675"},{"id":"165","type":"1","name":"1864","classic_prize":"1864","water":"0.0680"},{"id":"164","type":"1","name":"1863","classic_prize":"1863","water":"0.0685"},{"id":"163","type":"1","name":"1862","classic_prize":"1862","water":"0.0690"},{"id":"162","type":"1","name":"1861","classic_prize":"1861","water":"0.0695"},{"id":"161","type":"1","name":"1860","classic_prize":"1860","water":"0.0700"},{"id":"160","type":"1","name":"1859","classic_prize":"1859","water":"0.0705"},{"id":"159","type":"1","name":"1858","classic_prize":"1858","water":"0.0710"},{"id":"158","type":"1","name":"1857","classic_prize":"1857","water":"0.0715"},{"id":"157","type":"1","name":"1856","classic_prize":"1856","water":"0.0720"},{"id":"156","type":"1","name":"1855","classic_prize":"1855","water":"0.0725"},{"id":"155","type":"1","name":"1854","classic_prize":"1854","water":"0.0730"},{"id":"154","type":"1","name":"1853","classic_prize":"1853","water":"0.0735"},{"id":"153","type":"1","name":"1852","classic_prize":"1852","water":"0.0740"},{"id":"152","type":"1","name":"1851","classic_prize":"1851","water":"0.0745"},{"id":"151","type":"1","name":"1850","classic_prize":"1850","water":"0.0750"},{"id":"150","type":"1","name":"1849","classic_prize":"1849","water":"0.0755"},{"id":"149","type":"1","name":"1848","classic_prize":"1848","water":"0.0760"},{"id":"148","type":"1","name":"1847","classic_prize":"1847","water":"0.0765"},{"id":"147","type":"1","name":"1846","classic_prize":"1846","water":"0.0770"},{"id":"146","type":"1","name":"1845","classic_prize":"1845","water":"0.0775"},{"id":"145","type":"1","name":"1844","classic_prize":"1844","water":"0.0780"},{"id":"144","type":"1","name":"1843","classic_prize":"1843","water":"0.0785"},{"id":"143","type":"1","name":"1842","classic_prize":"1842","water":"0.0790"},{"id":"142","type":"1","name":"1841","classic_prize":"1841","water":"0.0795"},{"id":"141","type":"1","name":"1840","classic_prize":"1840","water":"0.0800"},{"id":"140","type":"1","name":"1839","classic_prize":"1839","water":"0.0805"},{"id":"139","type":"1","name":"1838","classic_prize":"1838","water":"0.0810"},{"id":"138","type":"1","name":"1837","classic_prize":"1837","water":"0.0815"},{"id":"137","type":"1","name":"1836","classic_prize":"1836","water":"0.0820"},{"id":"136","type":"1","name":"1835","classic_prize":"1835","water":"0.0825"},{"id":"135","type":"1","name":"1834","classic_prize":"1834","water":"0.0830"},{"id":"134","type":"1","name":"1833","classic_prize":"1833","water":"0.0835"},{"id":"133","type":"1","name":"1832","classic_prize":"1832","water":"0.0840"},{"id":"132","type":"1","name":"1831","classic_prize":"1831","water":"0.0845"},{"id":"131","type":"1","name":"1830","classic_prize":"1830","water":"0.0850"},{"id":"130","type":"1","name":"1829","classic_prize":"1829","water":"0.0855"},{"id":"129","type":"1","name":"1828","classic_prize":"1828","water":"0.0860"},{"id":"128","type":"1","name":"1827","classic_prize":"1827","water":"0.0865"},{"id":"127","type":"1","name":"1826","classic_prize":"1826","water":"0.0870"},{"id":"126","type":"1","name":"1825","classic_prize":"1825","water":"0.0875"},{"id":"125","type":"1","name":"1824","classic_prize":"1824","water":"0.0880"},{"id":"124","type":"1","name":"1823","classic_prize":"1823","water":"0.0885"},{"id":"123","type":"1","name":"1822","classic_prize":"1822","water":"0.0890"},{"id":"122","type":"1","name":"1821","classic_prize":"1821","water":"0.0895"},{"id":"121","type":"1","name":"1820","classic_prize":"1820","water":"0.0900"},{"id":"120","type":"1","name":"1819","classic_prize":"1819","water":"0.0905"},{"id":"119","type":"1","name":"1818","classic_prize":"1818","water":"0.0910"},{"id":"118","type":"1","name":"1817","classic_prize":"1817","water":"0.0915"},{"id":"117","type":"1","name":"1816","classic_prize":"1816","water":"0.0920"},{"id":"116","type":"1","name":"1815","classic_prize":"1815","water":"0.0925"},{"id":"115","type":"1","name":"1814","classic_prize":"1814","water":"0.0930"},{"id":"114","type":"1","name":"1813","classic_prize":"1813","water":"0.0935"},{"id":"113","type":"1","name":"1812","classic_prize":"1812","water":"0.0940"},{"id":"112","type":"1","name":"1811","classic_prize":"1811","water":"0.0945"},{"id":"111","type":"1","name":"1810","classic_prize":"1810","water":"0.0950"},{"id":"110","type":"1","name":"1809","classic_prize":"1809","water":"0.0955"},{"id":"109","type":"1","name":"1808","classic_prize":"1808","water":"0.0960"},{"id":"108","type":"1","name":"1807","classic_prize":"1807","water":"0.0965"},{"id":"107","type":"1","name":"1806","classic_prize":"1806","water":"0.0970"},{"id":"106","type":"1","name":"1805","classic_prize":"1805","water":"0.0975"},{"id":"105","type":"1","name":"1804","classic_prize":"1804","water":"0.0980"},{"id":"104","type":"1","name":"1803","classic_prize":"1803","water":"0.0985"},{"id":"103","type":"1","name":"1802","classic_prize":"1802","water":"0.0990"},{"id":"102","type":"1","name":"1801","classic_prize":"1801","water":"0.0995"},{"id":"101","type":"1","name":"1800","classic_prize":"1800","water":"0.1000"},{"id":"100","type":"1","name":"1799","classic_prize":"1799","water":"0.1005"},{"id":"99","type":"1","name":"1798","classic_prize":"1798","water":"0.1010"},{"id":"98","type":"1","name":"1797","classic_prize":"1797","water":"0.1015"},{"id":"97","type":"1","name":"1796","classic_prize":"1796","water":"0.1020"},{"id":"96","type":"1","name":"1795","classic_prize":"1795","water":"0.1025"},{"id":"95","type":"1","name":"1794","classic_prize":"1794","water":"0.1030"},{"id":"94","type":"1","name":"1793","classic_prize":"1793","water":"0.1035"},{"id":"93","type":"1","name":"1792","classic_prize":"1792","water":"0.1040"},{"id":"92","type":"1","name":"1791","classic_prize":"1791","water":"0.1045"},{"id":"91","type":"1","name":"1790","classic_prize":"1790","water":"0.1050"},{"id":"90","type":"1","name":"1789","classic_prize":"1789","water":"0.1055"},{"id":"89","type":"1","name":"1788","classic_prize":"1788","water":"0.1060"},{"id":"88","type":"1","name":"1787","classic_prize":"1787","water":"0.1065"},{"id":"87","type":"1","name":"1786","classic_prize":"1786","water":"0.1070"},{"id":"86","type":"1","name":"1785","classic_prize":"1785","water":"0.1075"},{"id":"85","type":"1","name":"1784","classic_prize":"1784","water":"0.1080"},{"id":"84","type":"1","name":"1783","classic_prize":"1783","water":"0.1085"},{"id":"83","type":"1","name":"1782","classic_prize":"1782","water":"0.1090"},{"id":"82","type":"1","name":"1781","classic_prize":"1781","water":"0.1095"},{"id":"81","type":"1","name":"1780","classic_prize":"1780","water":"0.1100"},{"id":"80","type":"1","name":"1779","classic_prize":"1779","water":"0.1105"},{"id":"79","type":"1","name":"1778","classic_prize":"1778","water":"0.1110"},{"id":"78","type":"1","name":"1777","classic_prize":"1777","water":"0.1115"},{"id":"77","type":"1","name":"1776","classic_prize":"1776","water":"0.1120"},{"id":"76","type":"1","name":"1775","classic_prize":"1775","water":"0.1125"},{"id":"75","type":"1","name":"1774","classic_prize":"1774","water":"0.1130"},{"id":"74","type":"1","name":"1773","classic_prize":"1773","water":"0.1135"},{"id":"73","type":"1","name":"1772","classic_prize":"1772","water":"0.1140"},{"id":"72","type":"1","name":"1771","classic_prize":"1771","water":"0.1145"},{"id":"71","type":"1","name":"1770","classic_prize":"1770","water":"0.1150"},{"id":"70","type":"1","name":"1769","classic_prize":"1769","water":"0.1155"},{"id":"69","type":"1","name":"1768","classic_prize":"1768","water":"0.1160"},{"id":"68","type":"1","name":"1767","classic_prize":"1767","water":"0.1165"},{"id":"67","type":"1","name":"1766","classic_prize":"1766","water":"0.1170"},{"id":"66","type":"1","name":"1765","classic_prize":"1765","water":"0.1175"},{"id":"65","type":"1","name":"1764","classic_prize":"1764","water":"0.1180"},{"id":"64","type":"1","name":"1763","classic_prize":"1763","water":"0.1185"},{"id":"63","type":"1","name":"1762","classic_prize":"1762","water":"0.1190"},{"id":"62","type":"1","name":"1761","classic_prize":"1761","water":"0.1195"},{"id":"61","type":"1","name":"1760","classic_prize":"1760","water":"0.1200"},{"id":"60","type":"1","name":"1759","classic_prize":"1759","water":"0.1205"},{"id":"59","type":"1","name":"1758","classic_prize":"1758","water":"0.1210"},{"id":"58","type":"1","name":"1757","classic_prize":"1757","water":"0.1215"},{"id":"57","type":"1","name":"1756","classic_prize":"1756","water":"0.1220"},{"id":"56","type":"1","name":"1755","classic_prize":"1755","water":"0.1225"},{"id":"55","type":"1","name":"1754","classic_prize":"1754","water":"0.1230"},{"id":"54","type":"1","name":"1753","classic_prize":"1753","water":"0.1235"},{"id":"53","type":"1","name":"1752","classic_prize":"1752","water":"0.1240"},{"id":"52","type":"1","name":"1751","classic_prize":"1751","water":"0.1245"},{"id":"51","type":"1","name":"1750","classic_prize":"1750","water":"0.1250"},{"id":"50","type":"1","name":"1749","classic_prize":"1749","water":"0.1255"},{"id":"49","type":"1","name":"1748","classic_prize":"1748","water":"0.1260"},{"id":"48","type":"1","name":"1747","classic_prize":"1747","water":"0.1265"},{"id":"47","type":"1","name":"1746","classic_prize":"1746","water":"0.1270"},{"id":"46","type":"1","name":"1745","classic_prize":"1745","water":"0.1275"},{"id":"45","type":"1","name":"1744","classic_prize":"1744","water":"0.1280"},{"id":"44","type":"1","name":"1743","classic_prize":"1743","water":"0.1285"},{"id":"43","type":"1","name":"1742","classic_prize":"1742","water":"0.1290"},{"id":"42","type":"1","name":"1741","classic_prize":"1741","water":"0.1295"},{"id":"41","type":"1","name":"1740","classic_prize":"1740","water":"0.1300"},{"id":"40","type":"1","name":"1739","classic_prize":"1739","water":"0.1305"},{"id":"39","type":"1","name":"1738","classic_prize":"1738","water":"0.1310"},{"id":"38","type":"1","name":"1737","classic_prize":"1737","water":"0.1315"},{"id":"37","type":"1","name":"1736","classic_prize":"1736","water":"0.1320"},{"id":"36","type":"1","name":"1735","classic_prize":"1735","water":"0.1325"},{"id":"35","type":"1","name":"1734","classic_prize":"1734","water":"0.1330"},{"id":"34","type":"1","name":"1733","classic_prize":"1733","water":"0.1335"},{"id":"33","type":"1","name":"1732","classic_prize":"1732","water":"0.1340"},{"id":"32","type":"1","name":"1731","classic_prize":"1731","water":"0.1345"},{"id":"31","type":"1","name":"1730","classic_prize":"1730","water":"0.1350"},{"id":"30","type":"1","name":"1729","classic_prize":"1729","water":"0.1355"},{"id":"29","type":"1","name":"1728","classic_prize":"1728","water":"0.1360"},{"id":"28","type":"1","name":"1727","classic_prize":"1727","water":"0.1365"},{"id":"27","type":"1","name":"1726","classic_prize":"1726","water":"0.1370"},{"id":"26","type":"1","name":"1725","classic_prize":"1725","water":"0.1375"},{"id":"25","type":"1","name":"1724","classic_prize":"1724","water":"0.1380"},{"id":"24","type":"1","name":"1723","classic_prize":"1723","water":"0.1385"},{"id":"23","type":"1","name":"1722","classic_prize":"1722","water":"0.1390"},{"id":"22","type":"1","name":"1721","classic_prize":"1721","water":"0.1395"},{"id":"21","type":"1","name":"1720","classic_prize":"1720","water":"0.1400"},{"id":"20","type":"1","name":"1719","classic_prize":"1719","water":"0.1405"},{"id":"19","type":"1","name":"1718","classic_prize":"1718","water":"0.1410"},{"id":"18","type":"1","name":"1717","classic_prize":"1717","water":"0.1415"},{"id":"17","type":"1","name":"1716","classic_prize":"1716","water":"0.1420"},{"id":"16","type":"1","name":"1715","classic_prize":"1715","water":"0.1425"},{"id":"15","type":"1","name":"1714","classic_prize":"1714","water":"0.1430"},{"id":"14","type":"1","name":"1713","classic_prize":"1713","water":"0.1435"},{"id":"13","type":"1","name":"1712","classic_prize":"1712","water":"0.1440"},{"id":"12","type":"1","name":"1711","classic_prize":"1711","water":"0.1445"},{"id":"11","type":"1","name":"1710","classic_prize":"1710","water":"0.1450"},{"id":"10","type":"1","name":"1709","classic_prize":"1709","water":"0.1455"},{"id":"9","type":"1","name":"1708","classic_prize":"1708","water":"0.1460"},{"id":"8","type":"1","name":"1707","classic_prize":"1707","water":"0.1465"},{"id":"7","type":"1","name":"1706","classic_prize":"1706","water":"0.1470"},{"id":"6","type":"1","name":"1705","classic_prize":"1705","water":"0.1475"},{"id":"5","type":"1","name":"1704","classic_prize":"1704","water":"0.1480"},{"id":"4","type":"1","name":"1703","classic_prize":"1703","water":"0.1485"},{"id":"3","type":"1","name":"1702","classic_prize":"1702","water":"0.1490"},{"id":"2","type":"1","name":"1701","classic_prize":"1701","water":"0.1495"},{"id":"1","type":"1","name":"1700","classic_prize":"1700","water":"0.1500"},{"id":"722","type":"1","name":"1699","classic_prize":"1699","water":"0.1505"},{"id":"721","type":"1","name":"1698","classic_prize":"1698","water":"0.1510"},{"id":"720","type":"1","name":"1697","classic_prize":"1697","water":"0.1515"},{"id":"719","type":"1","name":"1696","classic_prize":"1696","water":"0.1520"},{"id":"718","type":"1","name":"1695","classic_prize":"1695","water":"0.1525"},{"id":"717","type":"1","name":"1694","classic_prize":"1694","water":"0.1530"},{"id":"716","type":"1","name":"1693","classic_prize":"1693","water":"0.1535"},{"id":"715","type":"1","name":"1692","classic_prize":"1692","water":"0.1540"},{"id":"714","type":"1","name":"1691","classic_prize":"1691","water":"0.1545"},{"id":"713","type":"1","name":"1690","classic_prize":"1690","water":"0.1550"},{"id":"712","type":"1","name":"1689","classic_prize":"1689","water":"0.1555"},{"id":"711","type":"1","name":"1688","classic_prize":"1688","water":"0.1560"},{"id":"710","type":"1","name":"1687","classic_prize":"1687","water":"0.1565"},{"id":"709","type":"1","name":"1686","classic_prize":"1686","water":"0.1570"},{"id":"708","type":"1","name":"1685","classic_prize":"1685","water":"0.1575"},{"id":"707","type":"1","name":"1684","classic_prize":"1684","water":"0.1580"},{"id":"706","type":"1","name":"1683","classic_prize":"1683","water":"0.1585"},{"id":"705","type":"1","name":"1682","classic_prize":"1682","water":"0.1590"},{"id":"704","type":"1","name":"1681","classic_prize":"1681","water":"0.1595"},{"id":"703","type":"1","name":"1680","classic_prize":"1680","water":"0.1600"},{"id":"702","type":"1","name":"1679","classic_prize":"1679","water":"0.1605"},{"id":"701","type":"1","name":"1678","classic_prize":"1678","water":"0.1610"},{"id":"700","type":"1","name":"1677","classic_prize":"1677","water":"0.1615"},{"id":"699","type":"1","name":"1676","classic_prize":"1676","water":"0.1620"},{"id":"698","type":"1","name":"1675","classic_prize":"1675","water":"0.1625"},{"id":"697","type":"1","name":"1674","classic_prize":"1674","water":"0.1630"},{"id":"696","type":"1","name":"1673","classic_prize":"1673","water":"0.1635"},{"id":"695","type":"1","name":"1672","classic_prize":"1672","water":"0.1640"},{"id":"694","type":"1","name":"1671","classic_prize":"1671","water":"0.1645"},{"id":"693","type":"1","name":"1670","classic_prize":"1670","water":"0.1650"},{"id":"692","type":"1","name":"1669","classic_prize":"1669","water":"0.1655"},{"id":"691","type":"1","name":"1668","classic_prize":"1668","water":"0.1660"},{"id":"690","type":"1","name":"1667","classic_prize":"1667","water":"0.1665"},{"id":"689","type":"1","name":"1666","classic_prize":"1666","water":"0.1670"},{"id":"688","type":"1","name":"1665","classic_prize":"1665","water":"0.1675"},{"id":"687","type":"1","name":"1664","classic_prize":"1664","water":"0.1680"},{"id":"686","type":"1","name":"1663","classic_prize":"1663","water":"0.1685"},{"id":"685","type":"1","name":"1662","classic_prize":"1662","water":"0.1690"},{"id":"684","type":"1","name":"1661","classic_prize":"1661","water":"0.1695"},{"id":"683","type":"1","name":"1660","classic_prize":"1660","water":"0.1700"},{"id":"682","type":"1","name":"1659","classic_prize":"1659","water":"0.1705"},{"id":"681","type":"1","name":"1658","classic_prize":"1658","water":"0.1710"},{"id":"680","type":"1","name":"1657","classic_prize":"1657","water":"0.1715"},{"id":"679","type":"1","name":"1656","classic_prize":"1656","water":"0.1720"},{"id":"678","type":"1","name":"1655","classic_prize":"1655","water":"0.1725"},{"id":"677","type":"1","name":"1654","classic_prize":"1654","water":"0.1730"},{"id":"676","type":"1","name":"1653","classic_prize":"1653","water":"0.1735"},{"id":"675","type":"1","name":"1652","classic_prize":"1652","water":"0.1740"},{"id":"674","type":"1","name":"1651","classic_prize":"1651","water":"0.1745"},{"id":"673","type":"1","name":"1650","classic_prize":"1650","water":"0.1750"},{"id":"672","type":"1","name":"1649","classic_prize":"1649","water":"0.1755"},{"id":"671","type":"1","name":"1648","classic_prize":"1648","water":"0.1760"},{"id":"670","type":"1","name":"1647","classic_prize":"1647","water":"0.1765"},{"id":"669","type":"1","name":"1646","classic_prize":"1646","water":"0.1770"},{"id":"668","type":"1","name":"1645","classic_prize":"1645","water":"0.1775"},{"id":"667","type":"1","name":"1644","classic_prize":"1644","water":"0.1780"},{"id":"666","type":"1","name":"1643","classic_prize":"1643","water":"0.1785"},{"id":"665","type":"1","name":"1642","classic_prize":"1642","water":"0.1790"},{"id":"664","type":"1","name":"1641","classic_prize":"1641","water":"0.1795"},{"id":"663","type":"1","name":"1640","classic_prize":"1640","water":"0.1800"},{"id":"662","type":"1","name":"1639","classic_prize":"1639","water":"0.1805"},{"id":"661","type":"1","name":"1638","classic_prize":"1638","water":"0.1810"},{"id":"660","type":"1","name":"1637","classic_prize":"1637","water":"0.1815"},{"id":"659","type":"1","name":"1636","classic_prize":"1636","water":"0.1820"},{"id":"658","type":"1","name":"1635","classic_prize":"1635","water":"0.1825"},{"id":"657","type":"1","name":"1634","classic_prize":"1634","water":"0.1830"},{"id":"656","type":"1","name":"1633","classic_prize":"1633","water":"0.1835"},{"id":"655","type":"1","name":"1632","classic_prize":"1632","water":"0.1840"},{"id":"654","type":"1","name":"1631","classic_prize":"1631","water":"0.1845"},{"id":"653","type":"1","name":"1630","classic_prize":"1630","water":"0.1850"},{"id":"652","type":"1","name":"1629","classic_prize":"1629","water":"0.1855"},{"id":"651","type":"1","name":"1628","classic_prize":"1628","water":"0.1860"},{"id":"650","type":"1","name":"1627","classic_prize":"1627","water":"0.1865"},{"id":"649","type":"1","name":"1626","classic_prize":"1626","water":"0.1870"},{"id":"648","type":"1","name":"1625","classic_prize":"1625","water":"0.1875"},{"id":"647","type":"1","name":"1624","classic_prize":"1624","water":"0.1880"},{"id":"646","type":"1","name":"1623","classic_prize":"1623","water":"0.1885"},{"id":"645","type":"1","name":"1622","classic_prize":"1622","water":"0.1890"},{"id":"644","type":"1","name":"1621","classic_prize":"1621","water":"0.1895"},{"id":"643","type":"1","name":"1620","classic_prize":"1620","water":"0.1900"},{"id":"642","type":"1","name":"1619","classic_prize":"1619","water":"0.1905"},{"id":"641","type":"1","name":"1618","classic_prize":"1618","water":"0.1910"},{"id":"640","type":"1","name":"1617","classic_prize":"1617","water":"0.1915"},{"id":"639","type":"1","name":"1616","classic_prize":"1616","water":"0.1920"},{"id":"638","type":"1","name":"1615","classic_prize":"1615","water":"0.1925"},{"id":"637","type":"1","name":"1614","classic_prize":"1614","water":"0.1930"},{"id":"636","type":"1","name":"1613","classic_prize":"1613","water":"0.1935"},{"id":"635","type":"1","name":"1612","classic_prize":"1612","water":"0.1940"},{"id":"634","type":"1","name":"1611","classic_prize":"1611","water":"0.1945"},{"id":"633","type":"1","name":"1610","classic_prize":"1610","water":"0.1950"},{"id":"632","type":"1","name":"1609","classic_prize":"1609","water":"0.1955"},{"id":"631","type":"1","name":"1608","classic_prize":"1608","water":"0.1960"},{"id":"630","type":"1","name":"1607","classic_prize":"1607","water":"0.1965"},{"id":"629","type":"1","name":"1606","classic_prize":"1606","water":"0.1970"},{"id":"628","type":"1","name":"1605","classic_prize":"1605","water":"0.1975"},{"id":"627","type":"1","name":"1604","classic_prize":"1604","water":"0.1980"},{"id":"626","type":"1","name":"1603","classic_prize":"1603","water":"0.1985"},{"id":"625","type":"1","name":"1602","classic_prize":"1602","water":"0.1990"},{"id":"624","type":"1","name":"1601","classic_prize":"1601","water":"0.1995"},{"id":"623","type":"1","name":"1600","classic_prize":"1600","water":"0.2000"}];
    bonusData.reverse();
    console.log(bonusData);
    var isPlayer = 1;

    var prizeGroupUrl = "http://dsgame168.com/prize-sets/prize-set-detail"  ; //查看奖金组连接缓存
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
                //设置奖金组详情连接
                if( isPlayer ){
                    $parent.find('[data-bonus-scan]').attr('href', prizeGroupUrl + '/' +nowBound+ '/'+ ($parent.attr('data-id')) );
                }else{
                    $parent.find('[data-bonus-scan]').attr('href', prizeGroupUrl + '/' +nowBound );
                }
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
        var PrizeGroupCache = {};
        if(isPlayer){
            $('[data-itemType="game"]').each(function(){
                PrizeGroupCache[$(this).attr('data-id')] = $(this).find('[data-slider-value]').html() ;
            });
        }else{
            $('[data-itemType="all"]').each(function(){
                PrizeGroupCache[$(this).attr('data-id')] = $(this).find('[data-slider-value]').html() ;
            });
        };

        var JsonData = JSON.stringify(PrizeGroupCache);
        if (PrizeGroupCache != '{}') $('#prize_group_json').val(JsonData);

        if (!PrizeGroupCache) {
            alert('请选择彩种奖金组');
            return false;
        }
        $('#J-form').submit();
    });
    //加载弹出详情奖金组
    openWindow();
});
</script>

</body>
</html>
