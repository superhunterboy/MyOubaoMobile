@extends('l.home')

@section('title')
            汇款确认--充值
@parent
@stop

@section('scripts')
@parent
    {{ script('jquery.mousewheel')}}
    {{ script('dsgame.Tip')}}
@stop
@section ('main')

	<div class="main-content">

        <div class="nav-bg">
            <div class="title-normal">转账</div>
        </div>

        <div class="content recharge-confirm recharge-netbank">
            <!-- <div class="prompt">每天限提 300 次，今天您已经成功发起了 <span class="c-red">0</span> 次提现申请</div> -->
            <form action="" method="get" id="J-form">
                <input type="hidden" name="_token" value="cCIQUeV13slwj4elpC6si19pFoS9rKOtQhm3eo16" />
                <table width="100%" class="table-field">
                    <tr>
                        <td width="200" align="right" valign="top">
                            <span class="field-name">可用余额：</span>
                        </td>
                        <td>
                            <span class="c-red"><b>3,0sfs00,000.00</b> 元</span>
                        </td>
                    </tr>
                    <tr>
                        <td align="right" valign="top">
                            <span class="field-name">收款人：</span>
                        </td>
                        <td>
                            <input id="J-input-payee" type="text" class="input w-4" name="amount" placeholder="请输入收款人用户名" />
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
                            <input type="text" class="input w-4" name="desc" />
                        </td>
                    </tr>
                    <tr>
                        <td align="right" valign="top">&nbsp;</td>
                        <td>
                            <input type="submit" class="btn" value="下一步" id="J-submit" />
                        </td>
                    </tr>
                </table>
            </form>
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
            <!-- <li>
                <span>最近转账</span>
            </li> -->
        </ul>
        <div class="transfer-user-list">
            <div class="transfer-filter-info"></div>
            <div class="transfer-panel">
                <!-- <div class="transfer-select-wrap">
                    <select id="J-select-user-groups" style="display:none;" name="transfer-user-groups">
                        <option value="">全部下级用户(128)</option>
                        <option value="1">一级代理(89)</option>
                        <option value="0">玩家(39)</option>
                    </select>
                </div> -->
                <!--
                    data-id=用户的id，需要传到隐藏input中
                    data-type=用户分组类型（一级代理/玩家）
                -->
                <ul>
                    <li>
                        <label>
                            <input data-id="12" data-type="1" type="radio" name="transfer-user" />
                            <span>Wdafdsfd(秃顶男)</span>
                        </label>
                    </li>
                    <li>
                        <label>
                            <input data-id="12" data-type="1" type="radio" name="transfer-user" />
                            <span>Zjsifdd(黄图小王子)</span>
                        </label>
                    </li>
                    <li>
                        <label>
                            <input data-id="12" data-type="0" type="radio" name="transfer-user" />
                            <span>Wdafdsfd(秃顶男)</span>
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
                    <li>
                        <label>
                            <input data-id="12" data-type="1" type="radio" name="transfer-user" />
                            <span>Zjsifdd(黄图小王子)</span>
                        </label>
                    </li>
                    <li>
                        <label>
                            <input data-id="12" data-type="0" type="radio" name="transfer-user" />
                            <span>Wdafdsfd(秃顶男)</span>
                        </label>
                    </li>
                    <li>
                        <label>
                            <input data-id="12" data-type="1" type="radio" name="transfer-user" />
                            <span>Zjsifdd(黄图小王子)</span>
                        </label>
                    </li>
                    <li>
                        <label>
                            <input data-id="12" data-type="1" type="radio" name="transfer-user" />
                            <span>Wdafdsfd(秃顶男)</span>
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
                    <li>
                        <label>
                            <input data-id="12" data-type="0" type="radio" name="transfer-user" />
                            <span>Zjsifdd(黄图小王子)</span>
                        </label>
                    </li>
                </ul>
            </div>
            <div class="transfer-panel" style="display:none;">
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
            </div>
        </div>
    </div>
</div>
@stop

@section('end')
@parent
<script type="text/javascript">
(function($){
    alert();
    var $money = $('#J-input-transfer-money'),
        tip = new dsgame.Tip({cls:'j-ui-tip-b j-ui-tip-input-floattip'});

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
        if(!isNaN(Number(v))){
            v = dsgame.util.formatMoney(v);
        }
        tip.setText(v);
        tip.getDom().css({left:$money.offset().left + $money.width()/2 - tip.getDom().width()/2});
    });
    $money.focus(function(){
        var v = $.trim(this.value);
        if(v == ''){
            v = '&nbsp;';
        }
        if(!isNaN(Number(v))){
            v = dsgame.util.formatMoney(v);
        }
        tip.setText(v);
        tip.show($money.width()/2 - tip.getDom().width()/2, tip.getDom().height() * -1 - 20, this);
    });
    $money.blur(function(){
        var v = Number(this.value),minNum = Number($('#J-money-min').text().replace(/,/g, '')),maxNum = Number($('#J-money-max').text().replace(/,/g, '')),withdrawable = Number($('#J-money-withdrawable').text().replace(/,/g, ''));
        v = v < minNum ? minNum : v;
        v = v > maxNum ? maxNum : v;
        v = v > withdrawable ? withdrawable : v;
        this.value = dsgame.util.formatMoney(v).replace(/,/g, '');
        tip.hide();
    });

    // 表单验证（未写）
    $('#J-submit').click(function(){
        var v1 = $.trim($money.val());
        if(v1 == ''){
            alert('提款金额不能为空');
            $money.focus();
            return false;
        }
        return true;
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
    // transferWin.showConfirmButton();
    // transferWin.showCancelButton();

    // var transferSelect = new dsgame.Select({realDom:'#J-select-user-groups',cls:'w-3'});

    $payeeInput.on('focusin', function(){
        // mask.show();
        transferWin.show();
    });
    $('span[data-showuser]').on('click', function(){
        // mask.show();
        transferWin.show();
    });

    // 选中收款人
    $('input[name="transfer-user"]').on('change', function(){
        var $me = $(this),
            id = $me.data('id'),
            name = $me.siblings('span').text();
        $payeeInput.val(name);
        $payeeIdInput.val(id);
        transferWin.hide();
    });

    // 筛选
    $('#J-search-btn').on('keyup', function(){
        var val = $(this).val(),
            $lis = $('.transfer-panel:visible').find('li'),
            $f = $lis.filter(':contains("'+val+'")');
        if( val ){
            $lis.hide();
            $f.show();
            if( !$f.length ){
                $('.transfer-filter-info').html('没有符合<span class="c-red">' + val + '</span>的用户名').show();
            }else{
                $('.transfer-filter-info').hide();
            }
        }else{
            $lis.show();
        }
    });

})(jQuery);
</script>
@stop
