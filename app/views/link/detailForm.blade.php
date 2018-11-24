<?php
    $sSubmitUrl = $isEdit ? route('register-links.edit', $data->id) : route('register-links.create');

?>

<form action="{{ $sSubmitUrl }}" method="post" id="J-form" class="col-md-12 ">
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
    @if ($isEdit)
    <input type="hidden" name="_method" value="PUT" />
    @endif
    <input type="hidden" name="prize_group_id" id="J-input-groupid" value="{{ $iCurrentPrizeId }}" />
    <input type="hidden" name="prize_group_type" id="J-input-group-type" value="{{ Input::old('prize_group_type', 1) }}" />
    <div class="panel panel-default">
      <div class="panel-body form-horizontal">
            <div class="form-group">
                <label for="J-select-link-url" class="col-sm-3 control-label">{{ __('_registerlink.binded-domain') }}:</label>
                <div class="col-sm-5">
                    <select class="form-control" name="url" id="J-select-link-url" >
                        <option value="">{{ __('_basic.please-select') }}</option>
                        @foreach ($aDomains as $oDomain)
                        <option value="{{ $oDomain->domain }}" {{ (isset($data->url) && stripos($data->url, $oDomain->domain) > -1) ? 'selected' : '' }} >{{ $oDomain->domain }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="J-select-link-valid" class="col-sm-3 control-label">{{ __('_registerlink.expired-after') }}:</label>
                <div class="col-sm-5">
                    <select class="form-control" name="valid_days" id="J-select-link-valid" >
                            <option value="">{{ __('_basic.please-select') }}</option>
                            <option value="1" {{ (isset($data->valid_days) && $data->valid_days == 1) ? 'selected' : '' }} >1{{ __('_basic.day') }}</option>
                            <option value="7" {{ (isset($data->valid_days) && $data->valid_days == 7) ? 'selected' : '' }} >7{{ __('_basic.days') }}</option>
                            <option value="30" {{ (isset($data->valid_days) && $data->valid_days == 30) ? 'selected' : '' }} >30{{ __('_basic.days') }}</option>
                            <option value="90" {{ (isset($data->valid_days) && $data->valid_days == 90) ? 'selected' : '' }} >90{{ __('_basic.days') }}</option>
                            <option value="0" {{ (isset($data->valid_days) && $data->valid_days === '0') ? 'selected' : '' }} >{{ __('_registerlink.valid-forever') }}</option>
                    </select>
                </div>
            </div>
            <input type="hidden" name="channel" value="{{ __('_registerlink.admin-open-top-agent') }}" />

    <hr/>
    <ul class="nav nav-tabs" role="tablist" id="J-panel-cont">
        <li class="active"><a href="#tab1" role="tab" data-toggle="tab">{{ __('_registerlink.select-prize-group') }}</a></li><!-- 选择奖金组套餐 -->
        <li ><a href="#tab2" role="tab" data-toggle="tab">{{ __('_registerlink.custom-prize-group') }}</a></li><!-- 自定义奖金组 -->
    </ul>

    <div class="tab-content">
        <div class="tab-pane active" id="tab1">
            <div  class=" panel-body  row" id="J-panel-group">
                @foreach ($oPossiblePrizeGroups as $oPrizeGroup)
                <div class="col-sm-2">
                    <div class="thumbnail J-panBox">
                        <div class="panel-body text-center">
                            <h2>{{ $oPrizeGroup->name }}</h2>
                            <p>{{ __('_registerlink.current-prize-group') }}</p><!-- 当前奖金 -->
                            <hr/>
                            <?php $bSelected = ($sCurrentUserPrize && $sCurrentUserPrize == $oPrizeGroup->classic_prize); ?>
                            <a class="btn btn-primary  btn-block button-selectGroup {{ $bSelected ? 'btn-success' : '' }}" data-groupid="{{ $oPrizeGroup->id }}" data-group="{{ $oPrizeGroup->name }}">
                                {{ $bSelected ? __('_basic.selected') : __('_basic.select') }} <!-- 已选择/选 择 -->
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        <div class="tab-pane" id="tab2">
                <input type="hidden" name="series_id" id="J-input-custom-type" value="{{ Input::old('series_id') }}" />
                <input type="hidden" name="lottery_id" id="J-input-custom-id" value="{{ Input::old('lottery_id') }}" />
                <input type="hidden" id="J-input-lottery-json" name="lottery_prize_group_json" />
                <input type="hidden" id="J-input-series-json" name="series_prize_group_json" />

                <div class="panel-body" id="J-group-gametype-panel">
                    <a href="javascript:void(0);" data-id="1" id="all_lotteries" data-itemType="all" class="btn btn-ms btn-default item-game ">
                        {{ __('_lotteries.all-lotteries') }}
                    </a>
                    <!-- <a href="#" class="btn btn-ms  btn-default">
                      全部SSC
                    </a>
                    <a href="#" class="btn btn-ms btn-success">
                      <span class="badge pull-right">1960</span>
                      CQCCS
                    </a> -->
                </div>
                <hr/>
                <div class=" panel-body">
                    <div class="bg-success  panel-body">
                        <div class="col-xs-8">
                            <p><font class="text-danger">设置奖金</font> 奖金组一旦上调后则无法降低，请谨慎操作。</p>
                            <span class="btn btn-info" style="float:left" id="J-slider-num-min">-</span>
                            <span class="btn btn-info" style="float:right" id="J-slider-num-max">+</span>
                            <div style="margin:20px 50px;">
                                <div id="slider" class="ui-slider"></div>
                                <p>
                                    <font style="float:left">{{ $aDefaultPrizeGroups['classic_prize'] }}</font>
                                    <font style="float:right">{{ $aDefaultMaxPrizeGroups['classic_prize'] }}</font>
                                </p>
                            </div>
                        </div>
                        <div class="col-xs-3">
                            <p>{{ __('_userprizeset.prize_group') }}</p>
                            <input type="text" id="J-input-custom-bonus-value" class="form-control" style="width:60px;" value="{{ $aDefaultPrizeGroups['classic_prize'] }}" />
                        </div>
                    </div>
                </div>

        </div>
    </div>
    <div class="col-md-12" id="j-quota" style="display:none">
        <h4>设置配额</h4>
        <table class="table table-bordered text-center">
            <tr class="warning" id="j-prize-group">
            </tr>
            <tr id="j-prize-group-input">
            </tr>
        </table>
    </div>
    <div class="row-lastsubmit">
        <input type="button" class="btn btn-block btn-lg btn-danger" value="{{ __('_registerlink.generate') }}" id="J-button-submit" /> <!-- 生成链接 -->
    </div>


    </div>
    </div>
</form>