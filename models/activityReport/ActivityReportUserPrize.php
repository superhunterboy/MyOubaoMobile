<?php

/**
 * 用户中奖信息报表
 */
class ActivityReportUserPrize extends BaseModel {

    protected $table = 'activity_report_user_prizes';
    public static $resourceName = 'ActivityReportUserPrize';
    public static $columnForList = [
        'prize_name',
        'username',
        'parent_name',
        'top_agent_name',
        'is_tester',
        'amount',
        'ip',
//        'need_review',
//        'need_get',
        'created_at',
    ];
    public static $totalColumns = [
        'amount',
    ];

    protected function beforeValidate() {
        if ($this->user_id) {
            $oUser = User::find($this->user_id);
            $this->parent_user_id = $oUser->parent_id;
            $this->parent_name = $oUser->parent;
            $this->top_agent_id = $oUser->getTopAgentId();
            $this->top_agent_name = $oUser->getTopAgentUserName();
        }
        if ($this->prize_id && $this->user_prize_id) {
            $oPrize = ActivityPrize::find($this->prize_id);
            $aPrizeData = json_decode($oPrize->params, true);
            $oUserPrize = ActivityUserPrize::find($this->user_prize_id);
            $aUserPrizeData = json_decode($oUserPrize->data, true);

            $fAmount = array_get($aUserPrizeData, array_get($aPrizeData, 'amount_column'));
            $fAmount != null or $fAmount = $oPrize->value;
            $this->amount = $fAmount;
            $this->need_review = $oUserPrize->need_review;
            $this->need_get = $oUserPrize->need_get;
        }
        return parent::beforeValidate();
    }

    public static function getUserPrizeSumInfo($aConditions) {
        $oQuery = DB::table('activity_report_user_prizes')->select(DB::raw('sum(amount) total_amount'));
        $aResult = self::queryByConditions($oQuery, $aConditions)->first();
        return objectToArray($aResult);
    }

    /**
     * 批量设置查询条件，返回Query实例
     *
     * @param array $aConditions
     * @return Query
     */
    public static function queryByConditions($oQuery, $aConditions = []) {
        is_array($aConditions) or $aConditions = [];
        foreach ($aConditions as $sColumn => $aCondition) {
            $statement = '';
            switch ($aCondition[0]) {
                case '=':
                    if (is_null($aCondition[1])) {
                        $oQuery = $oQuery->whereNull($sColumn);
                    } else {
                        $oQuery = $oQuery->where($sColumn, '=', $aCondition[1]);
                    }
                    break;
                case 'in':
                    $array = is_array($aCondition[1]) ? $aCondition[1] : explode(',', $aCondition[1]);
                    $oQuery = $oQuery->whereIn($sColumn, $array);
                    break;
                case '>=':
                case '<=':
                case '<':
                case '>':
                case 'like':
                    if (is_null($aCondition[1])) {
                        $oQuery = $oQuery->whereNotNull($sColumn);
                    } else {
                        $oQuery = $oQuery->where($sColumn, $aCondition[0], $aCondition[1]);
                    }
                    break;
                case '<>':
                case '!=':
                    if (is_null($aCondition[1])) {
                        $oQuery = $oQuery->whereNotNull($sColumn);
                    } else {
                        $oQuery = $oQuery->where($sColumn, '<>', $aCondition[1]);
                    }
                    break;
                case 'between':
                    $oQuery = $oQuery->whereBetween($sColumn, $aCondition[1]);
                    break;
            }
        }
//        exit;
        if (!isset($oQuery)) {
            $oQuery = self::where('id', '>', '0');
        }
        return $oQuery;
    }

}
