<?php

class UserPrizeSet extends BaseModel {

    const ERRNO_MISSING_PRIZE_SET = -940;
    const ERRNO_PRIZE_GROUP_ERROR = -941;

    protected static $cacheLevel = self::CACHE_LEVEL_FIRST;
    protected static $cacheMinutes = 1440;
    protected $table = 'user_prize_sets';

    /**
     * 软删除
     * @var boolean
     */
    protected $softDelete = false;
    protected $fillable = [
        'user_id',
        'username',
        'user_parent_id',
        'user_parent',
        'lottery_id',
        'group_id',
        'prize_group',
        'classic_prize',
        'valid',
        'is_agent'
    ];
    public static $resourceName = 'User Prize Set';
    public static $ignoreColumnsInEdit = ['user_id'];

    /**
     * the columns for list page
     * @var array
     */
    public static $columnForList = [
        'username',
        'lottery_id',
//        'prize_group',
        'classic_prize',
        'valid',
    ];

    /**
     * 下拉列表框字段配置
     * @var array
     */
    public static $htmlSelectColumns = [
        'lottery_id' => 'aLotteries',
        'group_id' => 'aPrizeGroups',
    ];

    /**
     * order by config
     * @var array
     */
    public $orderColumns = [
        'user_id' => 'asc'
    ];

    /**
     * If Tree Model
     * @var Bool
     */
    public static $treeable = false;

    /**
     * the main param for index page
     * @var string
     */
    public static $mainParamColumn = '';
    public static $rules = [
        'user_id' => 'required|integer',
        'group_id' => 'required|integer',
    ];
    public static $aUserTypes = ['top-agent', 'Agent'];

    protected function beforeValidate() {
        if (intval($this->user_id)) {
            $oUser = User::find($this->user_id);
            // 如果更新用户上下级关系，需要更新该部分数据
            $this->user_parent_id = $oUser->parent_id;
            $this->user_parent = $oUser->parent;
            if (!$this->username) {
                $this->username = $oUser->username;
            }
            if (!$this->is_agent) {
                $this->is_agent = $oUser->is_agent;
            }
        }
    }

    protected function getUserTypeFormattedAttribute() {
        return static::$aUserTypes[intval($this->user_parent_id != null)];
    }

    /**
     * 获取用户奖金组ID
     * @param int $iUserId
     * @param int $iLotteryId
     * @param string $sGroupName        用以保存奖金组名称
     * @return int | false
     */
    public static function getGroupId($iUserId, $iLotteryId, & $sGroupName) {
        $oPrizeSet = self::getUserPrizeSet($iUserId, $iLotteryId);
        $sGroupName = $oPrizeSet->prize_group;
        return $oPrizeSet->group_id;
    }

    public static function getUserPrizeSet($iUserId, $iLotteryId) {
        $bReadDb = true;
        $bPutCache = false;
        if (static::$cacheLevel != self::CACHE_LEVEL_NONE) {
            Cache::setDefaultDriver(static::$cacheDrivers[static::$cacheLevel]);
            $sCacheKey = self::compileCacheKeyOfUserLottery($iUserId, $iLotteryId);
            if ($aGroupInfo = Cache::get($sCacheKey)) {
                $oGroup = new static;
                $oGroup = $oGroup->newFromBuilder($aGroupInfo);
                $bReadDb = false;
            } else {
                $bPutCache = true;
            }
        }
        if ($bReadDb) {
            $oGroup = self::where('user_id', '=', $iUserId)->where('lottery_id', '=', $iLotteryId)->get()->first();
            if (!is_object($oGroup)) {
                return false;
            }
        }
        if ($bPutCache) {
            Cache::forever($sCacheKey, $oGroup->toArray());
        }
        return $oGroup;
    }

//    public static function getGroupIdOfUsers($aUsers, $iLotteryId){
//        
//        $aGroups = [];
//        $oSettings = self::whereIn('user_id', $aUsers)->where('lottery_id' , '=', $iLotteryId)->get(['user_id','group_id','prize_group']);
//        if ($oSettings){
//            foreach($oSettings as $oSet){
//                $aGroups[$oSet->user_id] = [$oSet->group_id,$oSet->prize_group];
//            }
//        }
//        return $aGroups;
//    }

    public static function getPrizeSetOfUsers($aUsers, $iLotteryId, $iWayId, & $aGroupNames) {
//        $aGroupIds = self::getGroupIdOfUsers($aUsers, $iLotteryId, $aGroupNames);
        $oSeriesWay = SeriesWay::find($iWayId);
        $aMethodIds = explode(',', $oSeriesWay->basic_methods);
//        $aPrizeSettingOfMethods = [];
        $data = [];
        $aGroupNames = [];
        foreach ($aUsers as $iUserId) {
            $iGroupId = self::getGroupId($iUserId, $iLotteryId, $sGroupName);
//            list($iGroupId, $sGroupName) = $aGroupInfo;
            $aGroupNames[$iUserId] = $sGroupName;
            foreach ($aMethodIds as $iMethodId) {
                $data[$iUserId][$iMethodId] = PrizeDetail::getPrizeSetting($iGroupId, $iMethodId);
            }
        }
        return $data;
    }

    /**
     * 返回多个用户的指定游戏的奖金组名称数组
     * @param array $aUsers
     * @param integer $iLotteryId
     * @return array
     */
    public static function & getPrizeGroupOfUsers($aUsers, $iLotteryId) {
        $aGroups = [];
        foreach ($aUsers as $iUserId) {
            $iGroupId = self::getGroupId($iUserId, $iLotteryId, $sGroupName);
            $aGroups[$iUserId] = $sGroupName;
        }
        return $aGroups;
    }

    /**
     * [getUserLotteriesPrizeSets 获取用户的彩种奖金组]
     * @param  [Integer] $iUserId    [用户id]
     * @param  [Integer] $iLotteryId [彩种id]
     * @return [Array]               [彩种奖金组]
     */
    public static function getUserLotteriesPrizeSets($iUserId, $iLotteryId = null, $aColumns = null) {
        if (!$iUserId)
            return false;
        $aColumns or $aColumns = ['id', 'user_id', 'lottery_id', 'group_id', 'prize_group', 'classic_prize'];
        $oQuery = self::where('user_id', '=', $iUserId);
        if ($iLotteryId)
            $oUserPrizeSets = $oQuery->where('lottery_id', '=', $iLotteryId)->first($aColumns);
        else
            $oUserPrizeSets = $oQuery->get($aColumns);
        return $oUserPrizeSets;
    }

    /**
     * [generateLotteriesPrizeWithSeries 生成用户的彩系->彩种奖金组数据]
     * @param  [Integer] $iUserId [用户id]
     * @return [Array]            [彩系->彩种奖金组数据]
     */
    public static function generateLotteriesPrizeWithSeries($iUserId, & $iMinGroup) {
//        $iUserId or $iUserId = Session::get('user_id');
        $oUserPrizeSets = self::getUserLotteriesPrizeSets($iUserId);
        $aLotteriesPrize = [];
        if ($oUserPrizeSets) {
            foreach ($oUserPrizeSets as $key => $oUserPrizeSet) {
                $aLotteriesPrize[$oUserPrizeSet->lottery_id] = $oUserPrizeSet->getAttributes(['id', 'type']);
            }
        }
//        pr($aLotteriesPrize);
//        exit;
        $aSeriesLotteries = & Series::getSeriesLotteriesArray(true, ['id', 'name', 'type', 'max_prize_group'], ['id', 'name', 'type', 'series_id']);
//        pr($aSeriesLotteries);
//        exit;
        $result = [];
        // pr($aSeriesLotteries[0]->children);exit;
        $iMinGroup = 1960;
        foreach ($aSeriesLotteries as $key => $aSeries) {
            $iMinGroupOfSeries = 1960;
            $aNewChildren = [];
            $aChildren = $aSeries['children'];
            // pr(count($aChildren));exit;
            for ($i = 0, $l = count($aChildren); $i < $l; $i++) {
                // pr($oLottery['id']);exit;
                $data = $aLottery = $aChildren[$i];
                if (isset($aLotteriesPrize[$aLottery['id']]) && $aLotteriesPrize[$aLottery['id']]) {
                    $data['prize_group'] = $aLotteriesPrize[$aLottery['id']]['prize_group'];
                    $data['classic_prize'] = $aLotteriesPrize[$aLottery['id']]['classic_prize'];
                    $data['group_id'] = $aLotteriesPrize[$aLottery['id']]['group_id'];
                    $aNewChildren[] = $data;
                    $iMinGroup <= $aLotteriesPrize[$aLottery['id']]['prize_group'] or $iMinGroup = $aLotteriesPrize[$aLottery['id']]['prize_group'];
                    $iMinGroupOfSeries <= $aLotteriesPrize[$aLottery['id']]['prize_group'] or $iMinGroupOfSeries = $aLotteriesPrize[$aLottery['id']]['prize_group'];
                }
            }
            $aSeries['children'] = $aNewChildren;
            $aSeries['min_group'] = $iMinGroupOfSeries;
            $result[] = $aSeries;
        }
//         pr($result);exit;
        return $result;
    }

    function getMinGroupOfUser($iUserId) {
        
    }

    /**
     * [createUserPrizeGroup 创建用户奖金组, 必须在数据库事务中进行]
     * @param  [Object] $oUser      [新建的用户对象]
     * @param  [Array] $aPrizeGroup [奖金组数组]
     * @param  [Array] $aExistUserPrizeGroups [用户已存在的奖金组数组, 代理设置下级时使用]
     * @return [Array]            [成功/失败信息]
     */
    public static function createUserPrizeGroup($oUser, $aPrizeGroup, $aExistUserPrizeGroups = null) {
//        pr($aExistUserPrizeGroups);
        $aLotteryPrizeGroups = $oUser->generateLotteryPrizeGroup($aPrizeGroup);
//         pr($aLotteryPrizeGroups);
        $aUserPrizeGroups = $oUser->generateUserPrizeGroups($aLotteryPrizeGroups);
//         pr($aUserPrizeGroups);exit;
        $aReturnMsg = ['success' => true, 'msg' => __('_basic.updated')];
        foreach ($aUserPrizeGroups as $value) {
            $bSucc = true;
            if ($aExistUserPrizeGroups && $aExistUserPrizeGroups[$value['lottery_id']]) {
                $oUserPrizeSet = $aExistUserPrizeGroups[$value['lottery_id']];
                if ($oUserPrizeSet->classic_prize > $value['classic_prize']) {
                    $bSucc = false;
                    $aReturnMsg = ['success' => $bSucc, 'msg' => __('_userprizeset.less-than-exist-prize-group')];
                    break;
                }
            } else {
                $oUserPrizeSet = new UserPrizeSet;
            }
            if ($bSucc) {
                $oUserPrizeSet->fill($value);
                if (!$bSucc = $oUserPrizeSet->save()) {
                    $aReturnMsg = ['success' => $bSucc, 'msg' => __('_basic.update-fail')];
                    break;
                }
            }
        }
        return $aReturnMsg;
    }

    private static function compileCacheKeyOfUserLottery($iUserId, $iLotteryId) {
        return self::getCachePrefix(true) . $iUserId . '-' . $iLotteryId;
    }

    protected function afterSave($oSavedModel) {
        $this->deleteOtherCache();
        return parent::afterSave($oSavedModel);
    }

    protected function deleteOtherCache() {
        if (static::$cacheLevel != self::CACHE_LEVEL_NONE) {
            Cache::setDefaultDriver(static::$cacheDrivers[static::$cacheLevel]);
            $sCacheKey = $this->compileCacheKeyOfUserLottery($this->user_id, $this->lottery_id);
            !Cache::has($sCacheKey) or Cache::forget($sCacheKey);
        }
    }

    // public static function getTopAgentPrizeGroupDistribution()
    // {
    //     $aColumns = ['prize_group', 'num'];
    //     $oQuery = self::selectRaw(' *, count(distinct user_id) as num ')->where('valid', '=', 1)->whereNull('parent_id')->orWhere('parent_id', '=', '')->groupBy('prize_group');
    //     return $oQuery->get($aColumns);
    // }
    // public static function getAllAgentPrizeGroup($sUsername = null, $sPrizeGroupStart = null, $sPrizeGroupEnd = null, $sAgentType = null)
    // {
    //     $oQuery = self::where('valid', '=', 1)->where('is_agent', '=', 1);
    //     if ($sUsername) {
    //         $oQuery->where('username', 'like', $sUsername);
    //     }
    //     $oQuery->groupBy('user_id')->orderByRaw(' parent_id, username ');
    //     return $oQuery->get();
    // }

    /**
     * 修改奖金组
     * @param int $iUserId                  用户id
     * @param object $oPrizeGroup   奖金组对象
     * @return boolean                          
     */
    public static function updateAgentPrizeGroup($iUserId, $oPrizeGroup) {
        $aUserPrizeSet = UserPrizeSet::getUserLotteriesPrizeSets($iUserId);
        $bSucc = true;
        foreach ($aUserPrizeSet as $oUserPrizeSet) {
            $oOldPrizeGroup = PrizeGroup::find($oUserPrizeSet->group_id);
            if (!is_object($oOldPrizeGroup)) {
                return false;
            }
            $oNewPrizeGroup = PrizeGroup::getPrizeGroupByClassicPrize($oPrizeGroup->classic_prize, $oOldPrizeGroup->series_id);
            if (!is_object($oNewPrizeGroup)) {
                return false;
            }
            $oUserPrizeSet->prize_group = $oUserPrizeSet->classic_prize = $oNewPrizeGroup->classic_prize;
            $oUserPrizeSet->group_id = $oNewPrizeGroup->id;
            $bSucc = $oUserPrizeSet->save();
            if (!$bSucc) {
                break;
            }
        }
        return $bSucc;
    }

}
