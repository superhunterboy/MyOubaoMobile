<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
<title>银行卡管理 -- CC彩票</title>
<link type="text/css" rel="stylesheet" href="../images/global/global.css" />
<link type="text/css" rel="stylesheet" href="../images/ucenter/ucenter.css" />

<script src="../js/jquery-1.9.1.min.js"></script>
<script src="../js/jquery.mousewheel.min.js"></script>
<script src="../js/dsgame.base.js"></script>
<script src="../js/dsgame.Select.js"></script>
<script src="../js/dsgame.Mask.js"></script>
<script src="../js/dsgame.MiniWindow.js"></script>
<script src="../js/dsgame.Message.js"></script>
<script src="../js/dsgame.Tip.js"></script>
<script src="../js/dsgame.Select.js"></script>
<script src="../js/global.js"></script>

</head>

<body>

<?php include_once("../header.php"); ?>

<div class="g_33 main clearfix">
    <div class="main-content">
        <div class="main-content">
            <div class="nav-bg">
                <div class="title-normal">转账</div>
            </div>
            <div class="content recharge-confirm recharge-netbank">
            	<div class="recharge-box">
	                <form action="" method="post" id="J-form">
	                    <input type="hidden" name="_token" value="i7CpInZPPq0JFg2IzGBUJVcdDJ9BijUjTG4q2Qhf" />
	                    <table width="100%" class="table-field">
	                        <tr>
	                            <td width="200" align="right" valign="top">
	                                <span class="field-name">可用余额：</span>
	                            </td>
	                            <td>
	                                <span class="c-red"><b>1,076,681.232718</b> 元</span>
	                            </td>
	                        </tr>
	                        <tr>
	                            <td align="right" valign="top">
	                                <span class="field-name">收款人：</span>
	                            </td>
	                            <td>
	                                <input id="J-input-payee" type="text" class="input w-4" name="username" placeholder="请输入收款人用户名" />
	                                <span data-showuser class="icon-users">点击选择收款人</span>
	                                <input type="hidden" name="userid" id="J-input-payee-id" />
	                            </td>
	                        </tr>
	                        <tr>
	                            <td align="right" valign="top">
	                                <span class="field-name">转账金额：</span>
	                            </td>
	                            <td>
	                                <input id="J-input-transfer-money" type="text" class="input w-2 input-ico-money" name="amount" />&nbsp; 元
	                            </td>
	                        </tr>
	                        <tr>
	                            <td align="right" valign="top">
	                                <span class="field-name">转账说明：</span>
	                            </td>
	                            <td>
	                                <select name="desc" id="J-transfer-desc" style="display:none;">
				                        <option value="为下级充值">为下级充值</option>
				                        <option value="发放工资">发放工资</option>
				                        <option value="其他">其他</option>
	                                </select>
	                            </td>
	                        </tr>
	                        <tr>
	                            <td align="right" valign="top">
	                                <span class="field-name">资金密码：</span>
	                            </td>
	                            <td>
	                                <input type="password" class="input w-4" name="fund_password" />
	                            </td>
	                        </tr>
	                        <tr>
	                            <td align="right" valign="top">&nbsp;</td>
	                            <td>
	                                <input type="submit" class="btn" value="立即转账" id="J-submit" />
	                            </td>
	                        </tr>
	                    </table>
	                </form>
	            </div>
	            <div class="recharge-help">
			        <h3>转账提示</h3>
			        <div class="prompt">代理向下级转账的金额，该下级用户需要完成此部分转账金额相应流水，才可提款</div>
			        <h4>举例：</h4>
			        <p>您向下级A用户转账500元，则A用户在提款时需要完成这500元的相应流水才可提款。向下级转账均被视为充值行为。</p>
			    </div>
            </div>
        </div>
        <!--下级列表-->
        <div id="J-transfer-html" style="display:none;">
            <div class="transfer-pop-search-bar">
                <input id="J-search-btn" type="text" class="input" placeholder="通过账号搜索下级用户" />
            </div>
            <div class="transfer-choose-wrap">
                <ul class="transfer-tab">
                    <li class="current">
                        <span>用户列表</span>
                    </li>
                </ul>
                <div class="transfer-user-list">
                    <div class="transfer-filter-info"></div>
                    <div class="transfer-panel">
                        <ul>
                            <li>
                                <label>
                                    <input data-id="33" data-type="1" type="radio" name="transfer-user" />
                                    <span> a12233</span>
                                </label>
                            </li>
                            <li>
                                <label>
                                    <input data-id="73" data-type="1" type="radio" name="transfer-user" />
                                    <span> a19149574</span>
                                </label>
                            </li>
                            <li>
                                <label>
                                    <input data-id="75" data-type="1" type="radio" name="transfer-user" />
                                    <span> botest</span>
                                </label>
                            </li>
                            <li>
                                <label>
                                    <input data-id="3" data-type="1" type="radio" name="transfer-user" />
                                    <span> cpdtest</span>
                                </label>
                            </li>
                            <li>
                                <label>
                                    <input data-id="4" data-type="1" type="radio" name="transfer-user" />
                                    <span> cstest</span>
                                </label>
                            </li>
                            <li>
                                <label>
                                    <input data-id="30" data-type="1" type="radio" name="transfer-user" />
                                    <span> dstest001</span>
                                </label>
                            </li>
                            <li>
                                <label>
                                    <input data-id="34" data-type="1" type="radio" name="transfer-user" />
                                    <span> dstest002</span>
                                </label>
                            </li>
                            <li>
                                <label>
                                    <input data-id="31" data-type="1" type="radio" name="transfer-user" />
                                    <span> fagent0501801</span>
                                </label>
                            </li>
                            <li>
                                <label>
                                    <input data-id="32" data-type="1" type="radio" name="transfer-user" />
                                    <span> fagent0501802</span>
                                </label>
                            </li>
                            <li>
                                <label>
                                    <input data-id="36" data-type="1" type="radio" name="transfer-user" />
                                    <span> fagent0501811</span>
                                </label>
                            </li>
                            <li>
                                <label>
                                    <input data-id="40" data-type="1" type="radio" name="transfer-user" />
                                    <span> fagent0501815</span>
                                </label>
                            </li>
                            <li>
                                <label>
                                    <input data-id="37" data-type="1" type="radio" name="transfer-user" />
                                    <span> linkagent0501</span>
                                </label>
                            </li>
                            <li>
                                <label>
                                    <input data-id="97" data-type="1" type="radio" name="transfer-user" />
                                    <span> mina2015</span>
                                </label>
                            </li>
                            <li>
                                <label>
                                    <input data-id="14" data-type="1" type="radio" name="transfer-user" />
                                    <span> nicksb</span>
                                </label>
                            </li>
                            <li>
                                <label>
                                    <input data-id="18" data-type="1" type="radio" name="transfer-user" />
                                    <span> oatest</span>
                                </label>
                            </li>
                            <li>
                                <label>
                                    <input data-id="23" data-type="1" type="radio" name="transfer-user" />
                                    <span> sallytest</span>
                                </label>
                            </li>
                            <li>
                                <label>
                                    <input data-id="10" data-type="1" type="radio" name="transfer-user" />
                                    <span> user002</span>
                                </label>
                            </li>
                            <li>
                                <label>
                                    <input data-id="11" data-type="1" type="radio" name="transfer-user" />
                                    <span> user003</span>
                                </label>
                            </li>
                            <li>
                                <label>
                                    <input data-id="12" data-type="1" type="radio" name="transfer-user" />
                                    <span> user004</span>
                                </label>
                            </li>
                        </ul>
                    </div>
                    <!-- <div class="transfer-panel" style="display:none;">
            <ul>
                <li>
                    <label>
                        <input data-id="12" data-type="1" type="radio" name="transfer-user" />
                        <span>Lampard(曼城名宿)</span>
                    </label>
                </li>
                <li>
                    <label>
                        <input data-id="12" data-type="0" type="radio" name="transfer-user" />
                        <span>Zjsifdd(黄图小王子)</span>
                    </label>
                </li>
                <li>
                    <label>
                        <input data-id="12" data-type="1" type="radio" name="transfer-user" />
                        <span>Wdafdsfd(秃顶男)</span>
                    </label>
                </li>
            </ul>
        </div> -->
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once("../footer.php"); ?>

<div class="pop" id="popWindow" style="display:none;">
    <div class="pop-hd">
        <!-- <a href="#" class="pop-close"></a> -->
        <button type="button" class="pop-close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h3 class="pop-title">标题</h3>
    </div>
    <div class="pop-bd">
        <div class="pop-content">
            <i class="ico-success"></i>
            <p class="pop-text">已成功向 a19149574 转账 111.000000 元</p>
        </div>
        <div class="pop-btn">
            <input type="button" value="确 定" class="btn">
            <input type="button" value="取 消" class="btn btn-normal">
        </div>
    </div>
</div>
<script type="text/javascript">
(function($) {

    var $money = $('#J-input-transfer-money'),
        tip = new dsgame.Tip({
            cls: 'j-ui-tip-b j-ui-tip-input-floattip'
        }),
        confirmWin = new dsgame.Message({cls: 'w-8'}),
        transferInfoSelect = new dsgame.Select({realDom:'#J-transfer-desc', cls:'w-4'});

    $money.keyup(function(e){
        var v = $.trim(this.value),arr = [],code = e.keyCode;
        if(code == 37 || code == 39){
            return;
        }
        v = v.replace(/[^\d|^\.]/g, '');
        arr = v.split('.');
        if(arr.length > 2){
            v = '' + arr[0] + '.' + arr[1];
        }
        arr = v.split('.');
        if(arr.length > 1){
            arr[1] = arr[1].substring(0, 2);
            v = arr.join('.');
        }
        this.value = v;
        v = v == '' ? '&nbsp;' : v;
        tip.setText(v);
        tip.getDom().css({left:$money.offset().left + $money.width()/2 - tip.getDom().width()/2});
    });
    $money.focus(function(){
        var v = $.trim(this.value);
        if(v == ''){
            v = '&nbsp;';
        }
        tip.setText(v);
        tip.show($money.width()/2 - tip.getDom().width()/2, tip.getDom().height() * -1 - 20, this);
    });
    $money.blur(function(){
        var v = Number(this.value),
            //minNum = Number($('#J-money-min').text().replace(/,/g, '')),
            maxNum = Number('70,000.00'.replace(/,/g, ''))//Number($('#J-money-max').text().replace(/,/g, ''));
        //v = v < minNum ? minNum : v;
        v = v > maxNum ? maxNum : v;
        this.value = dsgame.util.formatMoney(v).replace(/,/g, '');
        tip.hide();
    });

    // 表单验证（未写）
    $('#J-submit').click(function() {
        var v1 = $.trim($money.val()),
            $userDom = $('#J-input-payee-id'),
            user = $userDom.val(),
            $fundPassword = $('input[name="fund_password"]');
        if (user == '') {
            alert('收款人不能为空');
            transferWin.show();
            return false;
        }
        if (v1 == '') {
            alert('转账金额不能为空');
            $money.focus();
            return false;
        }
        if ($fundPassword.val() == '') {
            alert('资金密码不能为空');
            $fundPassword.focus();
            return false;
        }
        var html = [
        	'<div class="pop-content">',
            	'<h3>确定要转账给<span class="c-important">' + $('#J-input-payee').val() + '</span>吗？</h3>',
            	'<p class="text-center">本次转账金额：' + v1 + '</p>',
            	'<p class="text-center">转账说明：' + transferInfoSelect.getValue() + '</p>',
            '</div>'
        ];
        html.join('');

        var data = {
            title            : '转账确认',
            content          : html,
            confirmIsShow    : true,
            cancelIsShow     : true,
            confirmButtonText: '确认',
            cancelButtonText : '取消',
            confirmFun: function () {
                $('#J-form').submit();
            },
            cancelFun: function() {
                confirmWin.hide();
                mask.hide();
            }
        };
        confirmWin.show(data);
        mask.show();
        return false;
    });

    // 选择收款人
    var transferWin = new dsgame.MiniWindow(),
        transferHtml = $('#J-transfer-html').html(),
        $payeeInput = $('#J-input-payee'),
        $payeeIdInput = $('#J-input-payee-id'),
        mask = new dsgame.Mask();
    $('#J-transfer-html').remove();
    transferWin.setTitle('选择收款人');
    transferWin.setContent(transferHtml);

    $payeeInput.on('focusin', function() {
        // mask.show();
        transferWin.show();
    });
    $('span[data-showuser]').on('click', function() {
        // mask.show();
        transferWin.show();
    });

    // 选中收款人
    $('input[name="transfer-user"]').on('change', function() {
        var $me = $(this),
            id = $me.data('id'),
            name = $.trim($me.siblings('span').text());
        $payeeInput.val(name);
        $payeeIdInput.val(id);
        transferWin.hide();
    });

    // 筛选
    $('#J-search-btn').on('keyup', function() {
        var val = $(this).val(),
            $lis = $('.transfer-panel:visible').find('li'),
            $f = $lis.filter(':contains("' + val + '")');
        if (val) {
            $lis.hide();
            $f.show();
            if (!$f.length) {
                $('.transfer-filter-info').html('没有符合<span class="c-red">' + val + '</span>的用户名').show();
            } else {
                $('.transfer-filter-info').hide();
            }
        } else {
            $lis.show();
        }
    });

})(jQuery);
</script>

</body>
</html>
