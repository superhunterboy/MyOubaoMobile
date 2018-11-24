@extends('l.home')

@section('title')
向下级转账
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
            <div class="recharge-box">
                <form action="" method="post" id="J-form">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <table width="100%" class="table-field">
                        <tr>
                            <td width="200" align="right" valign="top">
                                <span class="field-name">可用余额：</span>
                            </td>
                            <td>
                                <span class="c-red"><b>{{ $oAccount->available_formatted }}</b> 元</span>
                            </td>
                        </tr>
                        <tr>
                            <td width="200" align="right" valign="top">
                                <span class="field-name">可提余额：</span>
                            </td>
                            <td>
                                <span class="c-red"><b>{{ $oAccount->withdrawable_formatted }}</b> 元</span>
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
                                    @foreach($aDesc as $key => $desc)
                                    <option value="{{$key}}">{{$desc}}</option>
                                    @endforeach
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
            @if( !Session::get('is_top_agent') )
            <div class="recharge-help">
                <h3>转账提示</h3>
                <div class="prompt">代理向下级转账的金额，该下级用户需要完成此部分转账金额相应流水，才可提款</div>
                <h4>举例：</h4>
                <p>您向下级A用户转账500元，则A用户在提款时需要完成这500元的相应流水才可提款。向下级转账均被视为充值行为。</p>
            </div>
            @endif
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
                        @foreach( $aChildren as $key => $data )
                        <li>
                            <label>
                                <input data-id="{{$key}}" data-type="1" type="radio" name="transfer-user" />
                                <span> {{$data}}</span>
                            </label>
                        </li>
                        @endforeach
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
@stop

@section('end')
@parent
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
    $('#J-submit').click(function(e) {
        e.preventDefault();
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
                '<p class="text-center">转账说明：' + transferInfoSelect.getText() + '</p>',
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
                return false;
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
@stop
