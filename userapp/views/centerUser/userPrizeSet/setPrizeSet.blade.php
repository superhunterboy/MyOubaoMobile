@extends('l.home')

@section('title')
设置下级奖金组
@parent
@stop

@section ('styles')
@parent
<style>
    .detail_pop_win{width:600px;height:400px}
</style>
@stop

@section('scripts')
@parent
{{ script('jquery.jscrollpane') }}
{{ script('dsgame.SliderBar') }}
@stop

@section('main')
<div class="nav-bg">
    <div class="title-normal">奖金组管理</div>
    <!-- <a id="J-button-goback" class="" href="{{-- route('user-user-prize-sets.game-prize-set') --}}">我的奖金组详情</a> -->
</div>
<form action="{{ route('user-user-prize-sets.set-prize-set', [$iUserId]) }}" method="post" id="J-form">
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
    <input type="hidden" name="_method" value="PUT" />
    <input type="hidden" name="{{$iIsAgent? 'series_id' :'lottery_id' }}" value="1" />
    <input type="hidden" name="{{$iIsAgent? 'series_prize_group_json' :'lottery_prize_group_json' }}" id="prize_group_json" />
    <input type="hidden" id="J-input-prize" value="">
    <input type="hidden" name="agent_prize_set_quota" id="J-agent-quota-limit-json" value="" />

    <div class="content" id="J-panel-cont">
        <div class="bonusgroup-title" style="margin-top:0;">
            <table width="100%">
                <tr>
                    <td>{{ $aUserPrizeSet['username'] }}<br /><span class="tip">用户名称</span></td>
                    <td>{{ $aUserPrizeSet['nickname'] }}<br /><span class="tip">用户昵称</span></td>
                    <td>{{ $aUserPrizeSet['is_agent_formatted'] }}<br /><span class="tip">用户类型</span></td>
                    <td>{{ $aUserPrizeSet['available_formatted'] }} 元<br /><span class="tip">可用余额</span></td>
                    @if ($aUserPrizeSet['is_agent'] == 0)
                    <td class="last">{{ $aUserPrizeSet['bet_max_prize'] }} 元<br /><span class="tip">奖金限额</span></td>
                    @endif
                </tr>
            </table>
        </div>

        <div class="prompt-text" style="padding:5px 10px;margin-top:20px;">
            <div class="item-title" style="margin-bottom:0;"><i class="item-icon-15"></i>特别提示：调整用户奖金组时，一旦调高并保存后，将不允许恢复或调低，请谨慎操作！</div>
        </div>

        <div class="row-title">奖金组设置</div>

        @if (! $iIsAgent)
        @if (isset($aLotteriesPrizeSets))
        <div class="bonusgroup-game-type clearfix" style="padding-top:0">
            @foreach ($aLotteriesPrizeSets as $aSeries)
            <div class="bonusgroup-list">
                <h3>设置{{$aSeries['friendly_name'] }}奖金组</h3>

                <ul class="clearfix gametype-row">
                    <li class="slider-range slider-range-global" data-id="{{ $aSeries['id'] }}" data-itemType="all" onselectstart="return false;" data-slider-step="1">
                        <div class="slider-range-scale">
                            <span class="slider-title">统一设置</span>
                            <a href="" data-bonus-scan class="c-important">查 看</a>
                            <span class="small-number" data-slider-min>{{$iMinPrizeGroup}}</span>
                            <span class="percent-number" data-slider-percent>0%</span>
                            <span class="big-number" data-slider-max>{{$iMaxPrizeGroup}}</span>
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
                    @foreach ($aSeries['children'] as $key => $aLotteryPrizeSet)
                    <li class="slider-range" data-id="{{ $aLotteryPrizeSet['id'] }}" data-itemType="game" onselectstart="return false;" data-slider-step="1">
                        <div class="slider-range-scale">
                            <span class="slider-title">{{ $aLotteryPrizeSet['name'] }}</span>
                            <a href="" data-bonus-scan class="c-important">查 看</a>
                            <span class="small-number" data-slider-min>{{$iMinPrizeGroup}}</span>
                            <span class="percent-number" data-slider-percent>0%</span>
                            <span class="big-number" data-slider-max>{{$iMaxPrizeGroup}}</span>
                        </div>
                        <div class="slider-current-value" data-slider-value>{{$aLotteryPrizeSet['classic_prize']}}</div>
                        <div class="slider-action">
                            <div class="slider-range-sub" data-slider-sub>-</div>
                            <div class="slider-range-add" data-slider-add>+</div>
                            <div class="slider-range-wrapper" data-slider-cont>
                                <div class="slider-range-inner" data-slider-inner></div>
                                <div class="slider-range-btn" data-slider-handle></div>
                            </div>
                        </div>
                    </li>
                    @endforeach
                </ul>

            </div>
            @endforeach
        </div>
        @endif
        @endif

        @if ($iIsAgent)
        <div class="bonusgroup-game-type" style="padding-top:0">
            <div class="bonusgroup-list bonusgroup-list-line">
                <h3>设置全部彩种奖金组</h3>
                <ul>
                    <li class="slider-range slider-range-global" onselectstart="return false;" data-itemType="all" data-id="1" data-slider-step="1">
                        <div class="slider-range-scale">
                            <span class="slider-title">统一设置</span>
                            <a href="" data-bonus-scan class="c-important">查 看</a>
                            <span class="small-number" data-slider-min>{{$iMinPrizeGroup}}</span>
                            <span class="percent-number" data-slider-percent>0%</span>
                            <span class="big-number" data-slider-max>{{$iMaxPrizeGroup}}</span>
                        </div>
                        <div class="slider-current-value" data-slider-value>{{$sCurrentUserPrizeGroup}}</div>
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
        <div class="item-detail agent-user-limit J-agent-user-limit" style="display: none">
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
                            data-quota="{{ $quota + array_get($aSelfAllPrizeSetQuota,$prizeGroup) }}"
                            data-prize="{{$prizeGroup}}"
                            value="{{ intval(array_get($aSelfAllPrizeSetQuota,$prizeGroup))}}">
                        <p>最大允许<span class="quota-max">{{$quota + array_get($aSelfAllPrizeSetQuota,$prizeGroup) }}</span></p>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
        @endif

        <div class="row-lastsubmit">
            <input type="button" class="btn btn-important" value="保存奖金组设置" id="J-button-submit">
        </div>
    </div>
</div>
</form>
@stop

@section('end')
@parent

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

$(function () {
    // 是否可以设置
    var setAble = {{$bSetable ? '1' : '0' }};
    if( !setAble ) alert('当前用户的奖金组已经无法再修改');
    // 奖金组数据
    var bonusData = {{ $sAllPossiblePrizeGroups ? $sAllPossiblePrizeGroups : '[]' }};
//    console.log(bonusData);
    var isPlayer = {{$iIsAgent ? '0' : '1' }};
    // var isTopAgent = {{intval(Session::get('is_top_agent'))}};

    var maxPrizeGroup = {{ $iMaxPrizeGroup }};
    var minPrizeGroup = {{ $iMinPrizeGroup }};
    
    var checkQuotaLimitStatus, getQuotaData;

    var prizeGroupUrl = "{{ route('user-user-prize-sets.prize-set-detail') }}"  ; //查看奖金组连接缓存
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
    
    // 配额输入验证
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

    // 通过奖金组来判断某配额设置是否显示
    checkQuotaLimitStatus = function( prize ){
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
        });
        if( showNum > 0 && !isPlayer ){
            $('.J-agent-user-limit').show();
        }else{
            $('.J-agent-user-limit').hide();
        }
    }

    // 获取当前配额设置数据对象
    getQuotaData = function(){
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
    
    if( setAble ){
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
                    $('#J-input-prize').val(nowBound);
                    //设置奖金组详情连接
                    if( isPlayer ){
                        $parent.find('[data-bonus-scan]').attr('href', prizeGroupUrl + '/' +nowBound+ '/'+ ($parent.attr('data-id')) );
                    }else{
                        checkQuotaLimitStatus(nowBound);
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
    }else if( !isPlayer ){
        var value = parseInt($.trim($('.slider-current-value').text()));
        $('#J-input-prize').val( value );
        checkQuotaLimitStatus( value );
    }

    // 表单提交
    $('#J-button-submit').click(function(){
//        if( !setAble ) return alert('当前用户的奖金组已经无法再修改');
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
        
         $('#J-agent-quota-limit-json').val( JSON.stringify(getQuotaData()) );

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
@stop