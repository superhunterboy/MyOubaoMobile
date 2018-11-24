<?php

class PrizeGroup extends BaseModel {

    public static $resourceName = 'Prize Group';
    protected static $cacheLevel = self::CACHE_LEVEL_FIRST;

    /**
     * the columns for list page
     * @var array
     */
    public static $columnForList = [
        'series_id',
        'type',
        'name',
        'classic_prize',
        'water',
    ];
    public $orderColumns = [
        'name' => 'asc'
    ];
    public static $listColumnMaps = [
        'water' => 'water_formatted',
    ];
    public static $viewColumnMaps = [
        'water' => 'water_formatted',
    ];

    /**
     * The rules to be applied to the data.
     *
     * @var array
     */
    public static $rules = [
        'series_id' => 'required|integer',
//        'name' => 'required|max:20',
        'classic_prize' => 'required|numeric|max:2000',
        'water' => 'required|numeric|max:0.5',
    ];
    protected $fillable = [
        'series_id',
        'type',
        'name',
        'classic_prize',
        'water',
    ];
    protected $table = 'prize_groups';

    protected function getWaterFormattedAttribute() {
        return ($this->water * 100) . '%';
    }

    /**
     * 下拉列表框字段配置
     * @var array
     */
    public static $htmlSelectColumns = [
        'series_id' => 'aSeries',
//        'type' => 'aLotteryTypes',
    ];
    public static $mainParamColumn = 'series_id';
    public static $titleColumn = 'name';

    protected function beforeValidate() {
        $oSeries = Series::find($this->series_id);
        if (!$this->water) {
            $this->water = self::countWater($oSeries->classic_amount, $this->classic_prize);
        } else {
            if (!self::checkWater($oSeries->classic_amount, $this->classic_prize, $this->water)) {
                $this->validationErrors->add('water', __('_prize.water-error'));
                return false;
            }
        }
        if (empty($this->classic_prize)) {
            $this->validationErrors->add('classic_prize', __('_prize.missing-classic-prize'));
            return false;
        }
//        pr($this->getAttributes());
//        die($this->water);
        if (empty($this->series_id)) {
            return false;
        }
        $this->type = $oSeries->type;
        if (empty($this->name)) {
            $this->name = $this->classic_prize;
        }
        return true;
    }

    public static function checkWater($iClassicAmount, $iClassicPrize, $fWater) {
        $fTrue = number_format(1 - $iClassicPrize / $iClassicAmount, 4);
        $fWater = number_format($fWater, 4);
        return $fTrue == $fWater;
    }

    public static function countWater($iClassicAmount, $iClassicPrize) {
        return number_format(1 - $iClassicPrize / $iClassicAmount, 4);
    }

    /**
     * run after save
     * @return boolean
     */
    protected function afterSave($bSucc, $bNew = false) {
        if (!$bSucc)
            return $bSucc;

        $oPrizeLevel = new PrizeLevel;
        $aConditions = [
            'lottery_type_id' => ['=', $this->type],
            'series_id' => ['=',$this->series_id]
        ];
        $aFields = [
            'basic_method_id', 'level', 'probability', 'full_prize', 'max_prize', 'max_group', 'min_water'
        ];
        $aPrizeLevels = $oPrizeLevel->doWhere($aConditions)->get($aFields)->toArray();
//        pr($aPrizeLevels);
//        EXIT;
        $oSeries = Series::find($this->series_id);
//        pr($this->classic_prize);
//        pr($oSeries->classic_amount);
//        pr($aPrizeLevels);
//        exit;
        foreach ($aPrizeLevels as $aBasicLevel) {
//            pr($aBasicLevel);
//            $fPrize = formatNumber($this->classic_prize / $oSeries->classic_amount * $aBasicLevel['full_prize'], 4);
            $fPrize = PrizeDetail::countPrize($oSeries, $this->classic_prize, 1960, $aBasicLevel);
//            if ($aBasicLevel['basic_method_id']== 53){
//                pr($aBasicLevel['full_prize']);
//                $fPrize = self::countPrize($oSeries,$this->classic_prize,1960,$aBasicLevel);
//                pr($fPrize);
//            exit;
//            }
//            $fPrize = $this->classic_prize / 2000 * $aBasicLevel[ 'full_prize' ],PrizeDetail::$amountAccuracy);
//            $fPrize <= $aBasicLevel['max_prize'] or $fPrize = $aBasicLevel['max_prize'];
//            $aBasicLevel['max_group'] >= 1960 or $fPrize *= $aBasicLevel['max_group'] / 1960;
//            if ($aBasicLevel['basic_method_id']== 53){
//                pr($fPrize);
//                exit;
//            }
//            $fPrize = formatNumber($fPrize, PrizeDetail::$amountAccuracy);
            $aAttributes = [
                'series_id' => $this->series_id,
                'group_id' => $this->id,
                'method_id' => $aBasicLevel['basic_method_id'],
                'level' => $aBasicLevel['level'],
                'probability' => $aBasicLevel['probability'],
                'classic_prize' => $this->classic_prize,
                'group_name' => $this->name,
                'prize' => $fPrize,
                'full_prize' => $aBasicLevel['full_prize'],
            ];
            $oPrizeDetail = new PrizeDetail;
            $aConditions = [
                'group_id' => ['=', $this->id],
                'method_id' => ['=', $aBasicLevel['basic_method_id']],
                'level' => ['=', $aBasicLevel['level']],
            ];
            $oExistsDetail = $oPrizeDetail->doWhere($aConditions)->get(['id'])->first();
            empty($oExistsDetail) or $oPrizeDetail = $oExistsDetail;
//            unset($oExistsDetail);
//            pr($aAttributes);
            $oPrizeDetail->fill($aAttributes);
//            pr($aAttributes['id']);
//            $oPrizeDetail->id = $aAttributes['id'];
//            $oPrizeDetail = new PrizeDetail($aAttributes);
//            pr($oPrizeDetail->getAttributes());
//            pr($oPrizeDetail->id);exit;
//            $aDetails[] = $aAttributes;
//            pr($aAttributes);
            if (!$bSucc = $oPrizeDetail->save(PrizeDetail::$rules)) {
                return false;
            }
//            pr($oPrizeDetail->getAttributes());
//            if ($i++ >= 5) break;
        }
//        pr($aDetails);
//        exit;
        return $bSucc;
    }

    /**
     * [getPrizeGroupByClassicPrize 根据奖金值获取奖金组详情]
     * @param  [Integer]  $iClassicPrize [经典奖金值]
     * @param  [Integer]  $iLotteryType  [彩种类型]
     * @return [Object]                  [奖金组详情]
     */
    public static function getPrizeGroupByClassicPrize($iClassicPrize, $iSeriesId) {
        if (!$iClassicPrize || !$iSeriesId){
            return false;
        }
        $bReadDb = true;
        $bPutCache = false;
        if (static::$cacheLevel != self::CACHE_LEVEL_NONE){
            Cache::setDefaultDriver(static::$cacheDrivers[static::$cacheLevel]);
            $sCacheKey = self::compilePrizeGroupCacheKey($iClassicPrize, $iSeriesId);
            if ($aGroup = Cache::get($sCacheKey)) {
                $oGroup = new static;
                $oGroup = $oGroup->newFromBuilder($aGroup);
                $bReadDb = false;
            }
            else{
                $bPutCache = true;
            }
        }
        if ($bReadDb){
            $oGroup = self::where('classic_prize', '=', $iClassicPrize)->where('series_id', '=', $iSeriesId)->get()->first();
            if (!is_object($oGroup)) {
                return false;
            }
        }

        if ($bPutCache){
            Cache::forever($sCacheKey, $oGroup->toArray());
        }
        return $oGroup;
//        return self::where('classic_prize', '=', $iClassicPrize)->where('type', '=', $iLotteryType)->get()->first();
    }

    private static function compilePrizeGroupCacheKey($iClassicPrize, $iSeriesId){
        return self::getCachePrefix(true) . $iSeriesId . '-' . $iClassicPrize;
    }
    
    /**
     * [getPrizeGroupByName 根据奖金名获取奖金组详情]
     * @param  [String]  $sPrizeGroup  [奖金组名称]
     * @param  [Integer] $iLotteryType [彩种类型]
     * @return [Object]                [奖金组详情]
     */
    public static function getPrizeGroupByName($sPrizeGroup) {
        if (!$sPrizeGroup)
            return false;
        return self::where('name', '=', $sPrizeGroup)->get(); // ->where('type', '=', $iLotteryType)
    }

    /**
     * 获得奖金设置详情数组
     * @param int $iClassicPrize
     * @return array &
     */
    public static function & getPrizeDetails($iGroupId) {
        return PrizeDetail::getDetails($iGroupId);
    }

    /**
     * [getPrizeGroupsBelowExistGroup 获取某个奖金组以下的n个奖金组]
     * @param  [integer] $iPrizeGroup [奖金组]
     * @param  [integer] $iSeriesId   [彩系id]
     * @return [Array]                [奖金组数组]
     */
    public static function & getPrizeGroupsBelowExistGroup($iPrizeGroup, $iSeriesId, $iCount = null, $iPrizeGroupMin = 1600, $sOrderByClassicPrize = 'asc', $bIncludePrizeGroup=1) {
        if (!$iPrizeGroup || !$iSeriesId)
            return false;
        $aColumns = ['id', 'type', 'name', 'classic_prize', 'water'];
        $oQuery = self::where('series_id', '=', $iSeriesId)
                ->where('classic_prize', '>=', $iPrizeGroupMin);
        if ($bIncludePrizeGroup) {
            $oQuery = $oQuery->where('classic_prize', '<=', $iPrizeGroup);
        } else {
            $oQuery = $oQuery->where('classic_prize', '<', $iPrizeGroup);
        }
        $oQuery = $oQuery->orderBy('classic_prize', $sOrderByClassicPrize);
        empty($iCount) or $oQuery = $oQuery->limit($iCount);
        $data = $oQuery->get($aColumns);
        return $data;
    }

    public static function & getPrizeGroupWaterMap() {
        $aColumns = ['classic_prize', 'water'];
        $aPrizeGroupWaters = self::all($aColumns);
        $data = [];
        foreach ($aPrizeGroupWaters as $key => $value) {
            $data[$value->classic_prize] = ($value->water * 100) . '%';
        }
        return $data;
    }

    public static function getPrizeGroupsByParams($aParams, $iSeriesId = null, $aColumns = null) {
        $aColumns or $aColumns = ['id', 'series_id', 'name', 'classic_prize'];
        // foreach ($aParams as $aParam) {
        //     foreach ($aParam as $key => $value) {
        //         if (! isset($oQuery)) {
        //             $oQuery = self::where($key, '=', $value);
        //         } else {
        //             $oQuery->where($key, '=', $value);
        //         }
        //     }
        // }
        $oQuery = self::whereIn('classic_prize', $aParams);
        if ($iSeriesId)
            $oQuery->where('series_id', '=', $iSeriesId);
        $aData = $oQuery->get($aColumns);
        // $queries = DB::getQueryLog();
        // $last_query = end($queries);
        // pr($last_query);exit;
        return $aData;
    }

    public static function getPrizeGroupsWithOnlyKey($aParams, $iSeriesId = null, $aColumns = null) {
        $aGroups = [];
        $aPrizeGroups = self::getPrizeGroupsByParams($aParams);
        foreach ($aPrizeGroups as $value) {
            $key = $value->series_id . '_' . $value->classic_prize;
            $aGroups[$key] = $value;
        }
        return $aGroups;
    }

    /**
     * 根据系统配置参数，生成总代奖金组信息
     * @return array
     */
    public static function getTopAgentPrizeGroups() {
        $iMinGroup = SysConfig::readValue('top_agent_min_grize_group') + 1;
        $iMaxGroup = SysConfig::readValue('top_agent_max_grize_group');
        $aTopAgentPrizeGroups = range($iMinGroup, $iMaxGroup);
        return $aTopAgentPrizeGroups;
    }

    /**
     * 根据彩种系列id和奖金组名称获取奖金组信息
     * @param int $iSeriesId        彩种系列id
     * @param string $sName       奖金组名称
     * @return object PrizeGroup
     */
    public static function getPrizeGroupsBySeriesName($iSeriesId, $sName) {
        $aColumns = ['id', 'series_id', 'name', 'classic_prize'];
        $oSeries = Series::find($iSeriesId);
        if (!is_null($oSeries->link_to)) {
            $iSeriesId = $oSeries->link_to;
        }
        $oQuery = self::where('series_id', '=', $iSeriesId)->where('name', '=', $sName);
        $aData = $oQuery->get($aColumns)->first();
        return $aData;
    }

    /**
     * 工具方法,检验指定奖金组是否在指定范围内
     * @param int $prizeGroup               需验证的奖金组
     * @param int $minPrizeGroup        最小奖金组
     * @param int $maxPrizeGroup        最大奖金组
     * @return boolean                  是否在最小与最大之间
     */
    public static function checkExistPrizeGroup($prizeGroup, $minPrizeGroup, $maxPrizeGroup) {
        if ($minPrizeGroup <= $prizeGroup && $prizeGroup <= $maxPrizeGroup) {
            return true;
        } else {
            return false;
        }
    }

    public static function & getPrizeGroups($iSeriesId, $iMaxGroup, $iMinGroup = null, $iCount = null) {
        $aAllPrizeGroups = & self::getAllPrizeGroups($iSeriesId);
        $aGroups = [];
        foreach($aAllPrizeGroups as $aPrizeGroup){
            if ($aPrizeGroup['classic_prize'] < $iMinGroup || $aPrizeGroup['classic_prize'] > $iMaxGroup){
                continue;
            }
            $aGroups[] = $aPrizeGroup;
        }
        return $aGroups;
//        $oQuery = self::where('series_id', '=', $iSeriesId)->where('classic_prize', '<=', $iMaxGroup);
//        empty($iMinGroup) or $oQuery = $oQuery->where('classic_prize', '>=', $iMinGroup);
//        $oQuery = $oQuery->orderBy('name', 'asc');
//        empty($iCount) or $oQuery = $oQuery->limit($iCount);
//        return $oQuery->get();
    }

    protected static function compileAllPrizeGroupCacheKey($iSeriesId){
        return self::getCachePrefix(true) . 'all-prize-groups-'.$iSeriesId;
    }
    
    public static function & getAllPrizeGroups($iSeriesId){
        $bReadDb = true;
        $bPutCache = false;
        if (static::$cacheLevel != self::CACHE_LEVEL_NONE){
            Cache::setDefaultDriver(static::$cacheDrivers[static::$cacheLevel]);
            $sCacheKey = self::compileAllPrizeGroupCacheKey($iSeriesId);
            if ($aGroups = Cache::get($sCacheKey)) {
                $bReadDb = false;
            }
            else{
                $bPutCache = true;
            }
        }
        if ($bReadDb){
            $aGroups = [];
            $oPrizeGroups = self::where('series_id', '=', $iSeriesId)->orderBy('name','asc')->get();

            foreach ($oPrizeGroups as $oPrizeGroup) {
                $aGroups[$oPrizeGroup->id] = $oPrizeGroup->toArray();
            }
        }

        if ($bPutCache){
            Cache::forever($sCacheKey, $aGroups);
        }
//        pr($aAllTypes);
//        exit;
        return $aGroups;
    }
    
    public static function & getPrizeGroupArray($iSeriesId, $iMaxGroup, $iMinGroup = null, $iCount = null) {
        $aPrizeGroups = [];
        $oPrizeGroups = self::getPrizeGroups($iSeriesId, $iMaxGroup, $iMinGroup, $iCount);
        foreach ($oPrizeGroups as $oPrizeGroup) {
            $aPrizeGroups[] = $oPrizeGroup['name'];
        }
        return $aPrizeGroups;
    }

    public static function & getPrizeCommissions($iSeriesId, $iMaxGroup, $iMinGroup = null, $iCount = null) {
        $oSeries = Series::find($iSeriesId);
        !$oSeries->link_to or $iSeriesId = $oSeries->link_to;
//        $oPrizeGroups = self::getPrizeGroups($iSeriesId, $iMaxGroup, $iMinGroup, $iCount);
        $aPrizeGroups = & self::getPrizeGroups($iSeriesId, $iMaxGroup, $iMinGroup, $iCount);
//        $oQuery       = self::where('series_id', '=', $iSeriesId)->where('classic_prize', '<=', $iMaxGroup);
//        empty($iMinGroup) or $oQuery       = $oQuery->where('classic_prize', '>=', $iMinGroup);
//        $oQuery       = $oQuery->orderBy('name', 'asc');
//        empty($iCount) or $oQuery       = $oQuery->limit($iCount);
//        $oPrizeGroups = $oQuery->get();
        $aSettings = [];
        foreach ($aPrizeGroups as $aGroup) {
            $aSettings[] = [
                'prize_group' => $aGroup['name'],
                'rate' => number_format(($iMaxGroup - $aGroup['classic_prize']) / 2000, 4)
            ];
        }
        return $aSettings;
    }

}
