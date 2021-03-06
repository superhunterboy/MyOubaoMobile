@extends('l.home')

@section('title')
   链接开户
@parent
@stop

@section('scripts')
@parent
    {{ script('dsgame.DatePicker') }}
    {{ script('dsgame.Tab') }}
    {{ script('dsgame.SliderBar') }}
@stop

@section('main')
<div class="nav-bg nav-bg-tab">
    <div class="title-normal">用户管理</div>
    <ul class="tab-title clearfix">
        <li><a href="{{ route('users.accurate-create') }}" ><span>精准开户</span></a></li>
        <li class="current"><a href="{{ route('user-links.create') }}"><span>链接开户</span></a></li>
        <li><a href="{{ route('users.index') }}"><span>用户列表</span></a></li>
        <li><a href="{{ route('user-links.index') }}"><span>链接管理</span></a></li>
    </ul>
</div>


<form action="{{ route('user-links.create') }}" method="post" id="J-form">
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
    <input type="hidden" name="is_agent" id="J-input-userType" value="{{ Input::old('is_agent', 0) }}" />
    <input type="hidden" name="prize_group_id" id="J-input-groupid" value="" />
    <input type="hidden" id="J-input-prize" value="">
    <input type="hidden" name="prize_group_type" id="J-input-group-type" value="{{ Input::old('prize_group_type', 1) }}" />
    <input type="hidden" name="agent_prize_set_quota" id="J-agent-quota-limit-json" value="" />

    <div class="content link-create-wrap" id="J-panel-cont">

        <div class="item-detail user-type-choose">
            <div class="item-title">
                <i class="item-icon-13"></i>选择账户类型
            </div>
            <div class="item-info filter-tabs-cont" id="J-user-type-switch-panel">
                @if(!Session::get('is_top_agent'))
                <a data-userTypeId="0" href="javascript:void(0);">
                    <i class="user-type-icon-player"></i>
                    <span>玩家账号</span>
                </a>
                @endif
                @if (Session::get('is_agent'))
                <a data-userTypeId="1" href="javascript:void(0);">
                    <i class="user-type-icon-agent"></i>
                    <span>代理账号</span>
                </a>
                @endif
            </div>
        </div>

        <div class="item-detail user-info-config">
            <div class="item-title">
                <i class="item-icon-9"></i>设置用户账号信息
            </div>
            <div class="item-info">
                <p>
                    <label>链接有效期：</label>
                    <select id="J-select-link-valid" style="display:none;" name="valid_days">
                        <option value="">请选择</option>
                        <option value="1" {{ Input::old('valid_days') == 1 ? 'selected' : '' }}>1天</option>
                        <option value="7" {{ Input::old('valid_days') == 7 ? 'selected' : '' }}>7天</option>
                        <option value="30" {{ Input::old('valid_days') == 30 ? 'selected' : '' }}>30天</option>
                        <option value="90" {{ Input::old('valid_days') == 90 ? 'selected' : '' }}>90天</option>
                        <option value="0" {{ Input::old('valid_days') === '0' ? 'selected' : '' }}>永久有效</option>
                    </select>
                </p>
                <p>
                    <label>推广渠道：</label>
                        <select id="J-select-channel-name" style="display:none;">
                            <option value="">请选择</option>
                            <option value="论坛" {{ Input::old('channel') == '论坛' ? 'selected' : '' }}>论坛</option>
                            <option value="qq群" {{ Input::old('channel') == 'qq群' ? 'selected' : '' }}>qq群</option>
                            <option value="0">自定义</option>
                        </select>
                        &nbsp;&nbsp;
                        <input type="text" class="input w-3" value="" id="J-input-custom"  name="channel" style="display:none;" />
                </p>
                <p>
                    <?php
                        $aAgentQQ = Input::old('agent_qqs');
                    ?>
                    <label>推广QQ：<i data-qq-tips class="alert-icon">为方便客户与您联系，建议您填写真实的推广QQ并开通临时会话功能。此QQ会显示在该链接开户页面上</i></label>
                    <input name="agent_qqs[]" class="input w-1 agentQQ" value="{{ isset($aAgentQQ[0]) ? $aAgentQQ[0] : '' }}" type="text">
                    <a href="javascript;" data-add-qq class="btn" data-tips="最多只能添加4个推广QQ">+</a>
                </p>
            </div>
        </div>

        @include('centerUser.link._prizeGroupSetting')

        <div class="item-detail agent-user-limit J-agent-user-limit" style="display: none;">
            <div class="item-title">
                <i class="item-icon-3"></i>设置奖金组开户配额
            </div>
            <div class="item-info">
                <p>通过此链接注册的用户最多可以拥有的相应奖金配额如下，1950以下奖金组开户无配额限制</p>
                <ul class="agent-quota-list">
                    @foreach($aUserAllPrizeSetQuota as $prizeGroup => $quota)
                    <li>
                        <h3>{{$prizeGroup}}</h3>
                        <input type="text" class="input w-1"
                            data-quota="{{$quota}}"
                            data-prize="{{$prizeGroup}}"
                            value="0">
                        <p>最大允许<span class="quota-max">{{$quota}}</span></p>
                    </li>
                    @endforeach
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
            <input type="button" class="btn btn-important" value="生成链接" id="J-button-submit" />
        </div>

    </div>

</form>

@stop

@section('end')
@parent
<script>

/**全局变量**/

// slider事件是否已经绑定，
// 因为slider插件中要获取元素的宽度，
// 在tab切换中该元素display:none导致获取宽度为0，
// 所以需要在其父元素显示后绑定slider对象
var sliderEventBinded_player = sliderEventBinded_agent = false;

// 用户类型
var userModel;
//var isTopAgent = {{intval(Session::get('is_top_agent'))}};

var confirmWin = new dsgame.Message({cls: 'w-12'});
var dataInfo = ['',''];//数据缓存

var prizeGroupUrl = "{{ route('user-user-prize-sets.prize-set-detail') }}"  ; //查看奖金组连接缓存
// 代理奖金组数据
var agentPrizeGroup = {{$oAllPossibleAgentPrizeGroups}};
//玩家奖金组数据
var playerPrizeGroup = {{$oAllPossiblePrizeGroups}};

//判断用户角色滑动控件初始化方法
var checkSlider =function (){
    if( !sliderEventBinded_player && $('.J-bonusgroup-player').is(':visible') ){
        bindAllSlider($('.J-bonusgroup-player'));
        sliderEventBinded_player = true;
    }else if( !sliderEventBinded_agent && $('.J-bonusgroup-agent').is(':visible') ){
        bindAllSlider($('.J-bonusgroup-agent'));
        sliderEventBinded_agent = true;
    }
};

//开户连接切换方法
var switchUser =function(){
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
        clearChooseGroup();
        checkSlider();
        $('.J-user-type').text($(this).text());
    }).eq(0).trigger('click');
};

// 重置选中的套餐
var clearChooseGroup = function(){
    $('.bonus-group li.current').removeClass('current');
    $('#J-input-prize').val('');
}

// 固定奖金组和自定义奖金组切换
var switchBonus = function(){
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
        clearChooseGroup();
    });
};

// 选择某个奖金组套餐
var bonusGroupFun = function () {
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
};

//自定义奖金组设置组件
var bindAllSlider = function ($parent){
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
    $('.bonusgroup-list', $parent).each(function(idx){
        var $this = $(this),
            globalSlider, // 统一设置slider
            sliders = []; // 分段设置slider
        if( $parent.hasClass('J-bonusgroup-agent') ){
            var bonusData = agentPrizeGroup;
        }else{
            var bonusData = playerPrizeGroup;
        }
        $this.find('.slider-range').each(function(_idx){
            var $that = $(this),
                settings = $.extend({}, sliderConfig, {
                    'parentDom': $that,
                    'step'     : 1,
                    'minBound' : 0,
                    'maxBound' : bonusData.length - 1,
                    'value'    : 0
                });
            if( $that.hasClass('slider-range-global') ){
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
                var maxBound = bonusData[this.maxBound]['classic_prize'],
                    nowBound = bonusData[value]['classic_prize'];
                var rate = ( maxBound - nowBound ) / 2000;
                $parent.find('[data-slider-percent]').text((rate*100).toFixed(2) +'%');
                // 设置值
                $parent.find('[data-slider-value]').text(nowBound);
                $('#J-input-prize').val(nowBound);
                // 设置平均返点率
                $('.J-init-bonusgroup').text('已针对不同游戏分别设置奖金组');
                if( userModel == 'agent' ){
                    checkQuotaLimitStatus(nowBound);
                }
                // 设置奖金组详情连接
                setWinGroupUrl($parent.find('[data-bonus-scan]'), nowBound);
                // $parent.find('[data-bonus-scan]').attr('href', prizeGroupUrl + '/' +nowBound+ '/'+ ($parent.attr('data-id')) );
            });
            globalSlider.setValue(0);
        }
        // 单游戏设置
        $.each(sliders, function(i,s){
            s.addEvent('change', function(){
                var value = this.getValue(),
                    $parent = this.getDom();
                // 设置返奖率
                var maxBound = bonusData[this.maxBound]['classic_prize'],
                    nowBound = bonusData[value]['classic_prize'];
                var rate = ( maxBound - nowBound ) / 2000;
                $parent.find('[data-slider-percent]').text((rate*100).toFixed(2) +'%');
                // 设置值
                $parent.find('[data-slider-value]').text(nowBound);
                $('#J-input-prize').val(nowBound);
                // 设置平均返点率
                $('.J-init-bonusgroup').text('已针对不同游戏分别设置奖金组');
                // 设置奖金组详情连接
                setWinGroupUrl($parent.find('[data-bonus-scan]'), nowBound, $parent.attr('data-id'));
                // $parent.find('[data-bonus-scan]').attr('href', prizeGroupUrl + '/' +nowBound+ '/'+ ($parent.attr('data-id')) );
            });
            s.setValue(0);
        });
    });
    sliderEventBinded = true;
}

//查看奖金组详情
var setWinGroupUrl = function( t, bonus, gameId){
    var el = $(t), param = '', arr = [];
    if( bonus ) arr.push(bonus);
    if( gameId ) arr.push(gameId);
    if( arr.length ) param = arr.join('/');
    var url = prizeGroupUrl + '/' + param;
    el.attr('href', url);
};

// 下拉框组件
var selectFun = function(){
    var selectDays = new dsgame.Select({realDom:'#J-select-link-valid',cls:'w-2'});
    var selectChannel = new dsgame.Select({realDom:'#J-select-channel-name',cls:'w-2'});
    selectDays.addEvent('change', function(e, value, text){
        dataInfo[0] = selectDays.getValue();
    });
    selectChannel.addEvent('change', function(e, value, text){
        if(value == '0'){

            $('#J-input-custom').show();
        }else{
            $('#J-input-custom').hide();
        }
        dataInfo[1] = selectChannel.getValue();
    });
};

// 配额输入验证
var bindQuotaInput = function(){
    $('input[data-quota]').on('change', function(){
        var $this = $(this),
            val = parseInt( $this.val() ) || 0,
            max = parseInt( $this.data('quota') );
        if( val < 1 ){
            val = 0;
        }else if( val > max ){
            val = max
        }
        $this.val(val);
    });
};

// 通过奖金组来判断某配额设置是否显示
var checkQuotaLimitStatus = function( prize ){
    var prizeGroup = parseInt( prize ) || 0,
        showNum = 0;
    $('input[data-quota]').each(function(){
        var prize = $(this).data('prize'),
            quota = $(this).data('quota');
        // console.log(prize, prizeGroup)
        // if( prize < prizeGroup || (isTopAgent && prize == prizeGroup) ){
        if( prize < prizeGroup ){
            $(this).parent().show();
            showNum++;
        }else{
            $(this).parent().hide();
        }
        // if( prize == prizeGroup && !isTopAgent ){
        if( prize == prizeGroup ){
            $(this).siblings('p').find('.quota-max').text(Math.max(quota-1, 0));
        }else{
            $(this).siblings('p').find('.quota-max').text(quota);
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
        var quota = $(this).val(),
            prize = $(this).data('prize');
         // if( prize < prizeGroup || (isTopAgent && prize == prizeGroup) ){
         if( prize < prizeGroup ){
            dataObj[prize] = quota;
        }
    });
    return dataObj;
};

//联系qq-tip
var addQQFun = function(){
    var max_qq_num = 4;
    var qq_html = '<input name="agent_qqs[]" class="input w-1 agentQQ" value="" type="text">&nbsp;';
    $('[data-add-qq]').on('click', function(){
        if( $('.agentQQ').length < max_qq_num  && !$(this).hasClass('btn-disabled') ){
            $(this).before(qq_html);
        }
        if( $('.agentQQ').length >= max_qq_num ){
            $(this).addClass('btn-disabled');
        }
        return false;
    });
    var tip_btn = new dsgame.Tip({cls:'j-ui-tip-b w-3'});
    $('[data-add-qq]').hover(function(e){
        if( $(this).hasClass('btn-disabled') ){
            var el = $(this),
                text = el.data('tips');
            tip_btn.setText(text);
            tip_btn.show(-75, tip_btn.getDom().height() * -1 - 22, el);
            e.preventDefault();
        }
    },function(){
        tip_btn.hide();
    });

    // 添加qq tips
    var tip_qq = new dsgame.Tip({cls:'j-ui-tip-b w-6'});
    $('[data-qq-tips]').hover(function(e){
        var el = $(this),
            text = el.text();
        tip_qq.setText(text);
        tip_qq.show(-150, tip_qq.getDom().height() * -1 - 22, el);
        e.preventDefault();
    },function(){
        tip_qq.hide();
    });
};
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
};

//确认window
var generateConfirmInfo = function (userType, validDays, spreadChannel, prizeGroup, agentQQ, agentQuota) {
    var userTypes = ['玩家', '代理'];
    var validDaysDesc = +validDays ? validDays + '天' : '永久有效';
    var htmlQuota = ['<div class="bonusgroup-title" style="margin-top:10px;">',
                        '<table width="100%">',
                            '<tbody><tr>'];
    $.each(agentQuota, function(i,n){
        htmlQuota.push('<td>' + n + '<br><span class="tip">' + i + '奖金组配额数</span></td>');
    });
    htmlQuota.push('</tr></tbody></table></div>');
    var html = [
        '<div class="pop-content">',
            '<p class="pop-text">该链接的具体信息如下，是否立即生成链接？</p>',
            '<div class="bonusgroup-title" style="margin-top:10px;">',
                '<table width="100%">',
                    '<tr>',
                        '<td>' + userTypes[userType] + '<br><span class="tip">用户类型</span></td>',
                        '<td>' + validDaysDesc + '<br><span class="tip">链接有效期</span></td>',
                        '<td>' + spreadChannel + '<br><span class="tip">推广渠道</span></td>',
                        // '<td class="last">' + nickName + '<br><span class="tip">用户昵称</span></td>',
                    '</tr>',
                '</table>',
            '</div>',
            '<div class="bonusgroup-title" style="margin-top:10px;">',
                '<table width="100%">',
                    '<tr>',
                        '<td>' + prizeGroup + '<br><span class="tip">最高奖金组</span></td>',
                        // '<td class="last">' + returnRebate + '<br><span class="tip">预计平均返点率</span></td>',
                    '</tr>',
                '</table>',
            '</div>',
            '<div class="bonusgroup-title" style="margin-top:10px;">',
                '<table width="100%">',
                    '<tr>',
                        '<td>' + (agentQQ[0] ? agentQQ[0] : '') + '<br><span class="tip">推广QQ1</span></td>',
                        '<td>' + (agentQQ[1] ? agentQQ[1] : '') + '<br><span class="tip">推广QQ2</span></td>',
                        '<td>' + (agentQQ[2] ? agentQQ[2] : '') + '<br><span class="tip">推广QQ3</span></td>',
                        '<td>' + (agentQQ[3] ? agentQQ[3] : '') + '<br><span class="tip">推广QQ4</span></td>',
                    '</tr>',
                '</table>',
            '</div>',
            htmlQuota.join(''),
        '</div>'
    ];
    return html.join('');
};

//加载完成执行方法
$(function(){

    //执行函数方法
    checkSlider();
    switchUser();
    switchBonus();
    bonusGroupFun();
    selectFun();
    addQQFun();
    openWindow();
    bindQuotaInput();

    //表单提交
    $('#J-button-submit').click(function(){
        var userType = $.trim($('#J-input-userType').val()), //用户类型
            validDays = $.trim(dataInfo[0]),  //有效期
            spreadChannel = $.trim(dataInfo[1]),  //推广方式
            spreadChannelValue = $.trim($('#J-input-custom').val()),   //自定义推广渠道
            //套餐还是自定义
            groupType = $.trim($('#J-input-group-type').val()),
            prizeGroup = 0,
            agentQuota = getQuotaData(), // 代理用户配额限制数据变量
            agentQQ = []; // 推广qq

        var lotteryPrizeGroupCache = {},seriesPrizeGroupCache = {};
        $('[data-itemType="game"]').each(function(){
            lotteryPrizeGroupCache[$(this).attr('data-id')] = $(this).find('[data-slider-value]').html() ;
        });
        if( userModel == 'agent' ){
            seriesPrizeGroupCache[1] = $('#J-input-prize').val() || $('.J-bonusgroup-agent .slider-current-value').text();
        }else{
            $('[data-itemType="all"]').each(function(){
                seriesPrizeGroupCache[$(this).attr('data-id')] = $(this).find('[data-slider-value]').html() ;
            });
        }
        // console.log(seriesPrizeGroupCache);
        var lotteriesJsonData = JSON.stringify(lotteryPrizeGroupCache),
            seriesJsonData    = JSON.stringify(seriesPrizeGroupCache),
            agentQuotaLimitJson = JSON.stringify( agentQuota );

        if (lotteriesJsonData != '{}') $('#J-input-lottery-json').val(lotteriesJsonData);
        if (seriesJsonData    != '{}') $('#J-input-series-json').val(seriesJsonData);
        $('#J-agent-quota-limit-json').val(agentQuotaLimitJson);
        //推广qq
        $('.agentQQ').each(function(index, el) {
            agentQQ.push($(this).val());
        });

        if(validDays == ''){
            alert('请选择链接有效期');
            return false;
        }
        if(spreadChannel == ''){
            alert('请选择推广渠道');
            return false;
        }
        if(spreadChannel == '0' && spreadChannelValue == ''){
            alert('自定义推广渠道，请填写渠道名称');
            return false;
        }else if(spreadChannel != '0') {
            $('#J-input-custom').val(spreadChannel);
        }else{
          spreadChannelValue = spreadChannel  ;
        }
        var QQcorrect = true;
        for (var i = 0, l = agentQQ.length; i < l; i++) {
            var qqText = agentQQ[i];
            if (qqText && (isNaN(+qqText) || qqText < 50000 )) { // || qqText > QQ_NUM_MAX
                QQcorrect = false;
                break;
            }
        }
        if (! QQcorrect) {
            alert('请填写真实的QQ');
            return false;
        }
        // 套餐
        if(groupType == '1'){
            prizeGroup = $('#J-input-prize').val();
            if(!prizeGroup || $.trim($('#J-input-groupid').val()) == ''){
                alert('请选择一个奖金组套餐');
                return false;
            }
        }else{
            if( userModel == 'agent' ){
                prizeGroup = $('.J-bonusgroup-agent').find('[data-slider-value]').text();
            }else{
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
        }
        var data = {
            title            : '信息确认',
            content          : generateConfirmInfo(userType, validDays, spreadChannel, prizeGroup, agentQQ, agentQuota),
            confirmIsShow    : true,
            cancelIsShow     : true,
            confirmButtonText: '确认',
            cancelButtonText : '取消',
            confirmFun: function () {
                $('#J-form').submit();
            },
            cancelFun: function() {
                confirmWin.hide();
            }
        };
        confirmWin.show(data);
        return true;
    });
});
</script>

@stop