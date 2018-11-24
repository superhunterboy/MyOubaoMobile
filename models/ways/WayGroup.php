<?php

class WayGroup extends BaseModel {

    protected static $cacheLevel = self::CACHE_LEVEL_FIRST;
    protected $table = 'way_groups';

    /**
     * 软删除
     * @var boolean
     */
    protected $softDelete = false;
    protected $fillable = [
        'series_id',
        'parent_id',
        'title',
        'en_title',
        'sequence',
    ];
    public static $resourceName = 'Way Group';
    public static $titleColumn = 'title';
    public static $sequencable = true;

    /**
     * the columns for list page
     * @var array
     */
    public static $columnForList = [
        'series_id',
        'parent',
        'title',
        'en_title',
        'sequence',
    ];

    /**
     * 下拉列表框字段配置
     * @var array
     */
    public static $htmlSelectColumns = [
        'series_id' => 'aSeries',
        'parent_id' => 'aMainGroups',
    ];

    /**
     * order by config
     * @var array
     */
    public $orderColumns = [
        'sequence' => 'asc',
        'id' => 'asc'
    ];

    /**
     * the main param for index page
     * @var string
     */
    public static $mainParamColumn = 'series_id';
    public static $rules = [
        'parent_id' => 'integer',
        'title' => 'required|max:20',
        'en_title' => 'max:20',
        'sequence' => 'integer',
    ];
    public static $treeable = true;

    protected function beforeValidate() {
        if ($this->parent_id) {
            $oGroup = WayGroup::find($this->parent_id);
            $this->series_id = $oGroup->series_id;
        }
        parent::beforeValidate();
    }

    public function getWays() {
        $oWayGroupWay = new WayGroupWay;
        $oQuery = $oWayGroupWay->doWhere(['group_id' => ['=', $this->id]]);
        $oQuery = $oWayGroupWay->doOrderBy($oQuery, $oWayGroupWay->orderColumns);
        return $oQuery->get()->toArray();
    }

    /**
     * 取得玩法设置数组，供奖金页面使用
     * @param int $iGroupId
     * @return array &
     */
    public static function & getWaySettings($oLottery, $iPrizeGroupId) {
        $aPrizes = & PrizeGroup::getPrizeDetails($iPrizeGroupId);
        return WayGroup::getWayInfos($oLottery, $aPrizes);
    }

    private static function & getWayGroups($iSeriesId) {
        $bReadDb = true;
        $bPutCache = false;
        if (static::$cacheLevel != self::CACHE_LEVEL_NONE) {
            Cache::setDefaultDriver(static::$cacheDrivers[static::$cacheLevel]);
            $sCacheKey = self::makeCacheKeyLottery($iSeriesId);
            if ($aWayGroups = Cache::get($sCacheKey)) {
                $bReadDb = false;
            } else {
                $bPutCache = true;
            }
        }
        if ($bReadDb) {
            $aWayGroups = self::getWayGroupsFromDB($iSeriesId);
        }
        if ($bPutCache) {
            Cache::forever($sCacheKey, $aWayGroups);
        }
        return $aWayGroups;
    }

    private static function & getWayGroupsFromDB($iSeriesId) {
        $oWayGroup = new WayGroup;
        $aConditions = [
            'series_id' => ['=', $iSeriesId]
        ];
        $aMainGroups = & $oWayGroup->getSubObjectArray(null, $aConditions);
        foreach ($aMainGroups as $oMainGroup) {
            $data = [
                'id' => $oMainGroup->id,
                'pid' => intval($oMainGroup->parent_id),
                'name_cn' => $oMainGroup->title,
                'name_en' => $oMainGroup->en_title,
            ];
            $aSubGroups = & $oWayGroup->getSubObjectArray($oMainGroup->id);
//            foreach($aSubGroups as $a){
//                pr($a->getAttributes());
//            }
//            continue;
//            exit;
            $aSubs = [];
//            pr($aSubs);
            foreach ($aSubGroups as $oSubGroup) {
                $sub = [
                    'id' => $oSubGroup->id,
                    'pid' => $oSubGroup->parent_id,
                    'name_cn' => $oSubGroup->title,
                    'name_en' => $oSubGroup->en_title,
                ];
                $aWays = $oSubGroup->getWays();
                $ways = [];
                foreach ($aWays as $aWay) {
//                    echo $aWay['series_way_id'],',';
                    $oSeriesWay = SeriesWay::find($aWay['series_way_id']);
                    $sBasicMethodIds = $oSeriesWay->getAttribute('basic_methods');
                    $aBasicMethodIds = explode(',', $sBasicMethodIds);
//                    $aWayPrizes = [];
//                    foreach($aBasicMethodIds as $iBasicMethodId){
//                        $aWayPrizes[] = $aPrizes[$iBasicMethodId]['prize'];
//                    }
                    $waydata = [
                        'id' => $aWay['series_way_id'],
                        'pid' => $aWay['group_id'],
                        'series_way_id' => $aWay['series_way_id'],
//                        'relation_series_way_ids' => $aWay['relation_series_way_ids'],
                        'name_cn' => $aWay['title'],
                        'is_mobile' => $aWay['is_mobile'],
                        'name_en' => $aWay['en_title'],
                        'price' => $oSeriesWay->price,
                        'bet_note' => $oSeriesWay->bet_note,
                        'bonus_note' => $oSeriesWay->bonus_note,
                    ];
//                    if ($fMaxPrize){
//                        $waydata['prize'] = min($aWayPrizes);
//                        $waydata['max_multiple'] = intval($fMaxPrize / min($aWayPrizes));
//                    }
//                    else{
//                        $waydata['prize'] = implode(',', $aWayPrizes);
//                    }

                    $ways[] = $waydata;

//                    pr($sBasicMethodIds->toArray());
//                    exit;
//        ->get(['basic_methods'])->first()->getAttribute('basic_methods');
//                    pr($sBasicMethodIds);
                    // prize
                }
                $sub['children'] = $ways;
                $aSubs[] = $sub;
//                pr($sub);
//                break;
            }
            $data['children'] = $aSubs;
            $aWayGroups[] = $data;
        }
        return $aWayGroups;
    }

    private static function makeCacheKeyLottery($iLotteryId) {
        return self::getCachePrefix(true) . 'Lottery-' . $iLotteryId;
    }

    /**
     * 取得玩法设置数组，供渲染投注页面或奖金页面使用
     *
     * @param Lottery   $oLottery
     * @param array     $aPrizes
     * @param int       $fMaxPrize
     * @return array &
     */
    public static function & getWayInfos($iSeriesId, & $aPrizes, $fMaxPrize = null) {
        $aWayGroups = self::getWayGroups($iSeriesId);
        for ($i = 0; $i < count($aWayGroups); $i++) {
            $aSubGroups = & $aWayGroups[$i]['children'];
            for ($j = 0; $j < count($aSubGroups); $j++) {
                $aWays = & $aSubGroups[$j]['children'];
                foreach ($aWays as $k => $aWay) {
//                    echo $aWay['series_way_id'],',';
                    $oSeriesWay = SeriesWay::find($aWay['series_way_id']);
                    $sBasicMethodIds = $oSeriesWay->getAttribute('basic_methods');
                    $aBasicMethodIds = explode(',', $sBasicMethodIds);
                    $aWayPrizes = [];
                    foreach ($aBasicMethodIds as $iBasicMethodId) {
                        $aWayPrizes[] = $aPrizes[$iBasicMethodId]['prize'];
                    }
                    if ($fMaxPrize) {
                        $aWays[$k]['prize'] = min($aWayPrizes);
                        $aWays[$k]['max_multiple'] = intval($fMaxPrize / min($aWayPrizes));
                    } else {
                        $aWays[$k]['prize'] = implode(',', $aWayPrizes);
                        $aWays[$k]['max_multiple'] = 0;
                    }
                }
            }
        }
        return $aWayGroups;
    }

    public static function & getWayGroupSettings($iSeriesId, $bMobile = false) {
        $aWayGroups = self::getWayGroups($iSeriesId);
        for ($i = 0; $i < count($aWayGroups); $i++) {
            if (in_array($aWayGroups[$i]['id'], [109, 110, 111])) {
                $aWayGroups[$i]['isRenxuan'] = true;
            } else {
                $aWayGroups[$i]['isRenxuan'] = false;
            }
            $aSubGroups = & $aWayGroups[$i]['children'];
            for ($j = 0; $j < count($aSubGroups); $j++) {
                $aWays = & $aSubGroups[$j]['children'];
                foreach ($aWays as $k => $aWay) {
                    if ($bMobile && $aWay['is_mobile'] == false) {
                        unset($aWays[$k]);
                        continue;
                    }
                    $oSeriesWay = SeriesWay::find($aWay['series_way_id']);
                    $aWays[$k]['basic_methods'] = $oSeriesWay->getAttribute('basic_methods');
//                    if ($aWay['relation_series_way_ids']) {
//                        $aSeriesWays = SeriesWay::whereIn('id', explode(',', $aWay['relation_series_way_ids']))->get();
//                        foreach ($aSeriesWays as $key => $val) {
//                            $aWays[$k]['relation_series_ids'][$key]['series_way_id'] = $val->id;
//                            $aWays[$k]['relation_series_ids'][$key]['basic_methods'] = $val->basic_methods;
//                            $aWays[$k]['relation_series_ids'][$key]['index'] = $val->fixed_index;
//                        }
//                    }
                }
//                foreach($aWays as $k => $aWay){
////                    echo $aWay['series_way_id'],',';
//                    $oSeriesWay = SeriesWay::find($aWay['series_way_id']);
//                    $sBasicMethodIds = $oSeriesWay->getAttribute('basic_methods');
//                    $aBasicMethodIds = explode(',', $sBasicMethodIds);
//                    $aWayPrizes = [];
//                    foreach($aBasicMethodIds as $iBasicMethodId){
//                        $aWayPrizes[] = $aPrizes[$iBasicMethodId]['prize'];
//                    }
//                    if ($fMaxPrize){
//                        $aWays[$k]['prize'] = min($aWayPrizes);
//                        $aWays[$k]['max_multiple'] = intval($fMaxPrize / min($aWayPrizes));
//                    }
//                    else{
//                        $aWays[$k]['prize'] = implode(',', $aWayPrizes);
//                        $aWays[$k]['max_multiple'] = 0;
//                    }
//                }
            }
        }
        return $aWayGroups;
    }

}
