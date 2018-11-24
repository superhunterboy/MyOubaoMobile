<?php

/**
 * Description of UserPrizeSetQuota
 *
 */
class UserPrizeSetQuota extends BaseModel {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'user_prize_set_quota';
    public static $resourceName = 'UserPrizeSetQuota';

    /**
     * 软删除
     * @var boolean
     */
    protected $softDelete = false;

    /**
     * 下拉列表框字段配置
     * @var array
     */
    public static $htmlSelectColumns = [
    ];

    /**
     * 可写字段
     * @var array 
     */
    protected $fillable = [
        'user_id',
        'user_forefather_ids',
        'username',
        'prize_group',
        'total_quota',
        'left_quota',
    ];

    /**
     * 字段验证规则
     * @var array 
     */
    public static $rules = [
        'user_id' => 'required|integer|min:1',
        'username' => 'required|alpha_num|between:6,16',
        'prize_group' => 'required|numeric|between:1950,1960',
        'total_quota' => 'required|numeric',
        'left_quota' => 'required|numeric',
    ];
    public static $columnForList = [
        'username',
        'prize_group',
        'total_quota',
        'left_quota',
    ];

    /**
     * 获取指定用户的奖金组配额
     * @param type $userId  用户id
     */
    public static function getUserAllPrizeSetQuota($userId) {
        $oQuery = self::where('user_id', '=', $userId)
                ->orderBy('prize_group', 'asc');
        $aModels = $oQuery->get();
        $data = [];
        foreach ($aModels as $oModel) {
            $data[$oModel->prize_group] = $oModel->left_quota;
        }
        return $data;
    }

    /**
     * 获取指定用户的指定奖金组配额
     * @param int $userId  用户id
     */
    public static function getUserThePrizeGroupQuota($userId, $iPrizeGroup) {
        return self::where('user_id', '=', $userId)->where('prize_group', '=', $iPrizeGroup)->get()->first();
    }

    /**
     * 更新用户奖金组配额数据
     * @param int $userId      用户id
     * @param array $aPrizeSet   奖金组配额数组信息，如：[1956=>10,1955=>5]
     */
    public static function updateUserPrizeSetQuota($userId, $aPrizeSet, $operator = 'minus') {
        if (count($aPrizeSet) == 0)
            return true;
        $bSucc = true;
        foreach ($aPrizeSet as $iPrizeGroup => $iCount) {
            $oUserPrizeSetQuota = self::getUserThePrizeGroupQuota($userId, $iPrizeGroup);
            if (empty($oUserPrizeSetQuota)) {
                continue;
            }
            if ($operator == 'minus') {
                $oUserPrizeSetQuota->left_quota = $oUserPrizeSetQuota->left_quota - $iCount;
            } else if ($operator == 'plus') {
                $oUserPrizeSetQuota->left_quota = $oUserPrizeSetQuota->left_quota + $iCount;
            }
            if (!$bSucc = $oUserPrizeSetQuota->save()) {
                break;
            }
        }
        return $bSucc;
    }

    /**
     * 新增用户奖金组配额数据
     * @param type $userId      用户id
     * @param type $aPrizeSet   奖金组配额数组信息，如：[1956=>10,1955=>5]
     */
    public static function insertUserPrizeSetQuota($oUser, $aPrizeSet) {
        $bSucc = true;
        foreach ($aPrizeSet as $iPrizeGroup => $iCount) {
            $oUserPrizeSetQuota = self::getUserThePrizeGroupQuota($oUser->id, $iPrizeGroup);
            if (!is_object($oUserPrizeSetQuota)) {
                $oUserPrizeSetQuota = new UserPrizeSetQuota;
                $oUserPrizeSetQuota->total_quota = intval($iCount);
                $oUserPrizeSetQuota->left_quota = intval($iCount);
            } else {
                $oUserPrizeSetQuota->left_quota = $oUserPrizeSetQuota->left_quota + $iCount;
                $oUserPrizeSetQuota->total_quota = $oUserPrizeSetQuota->total_quota + $iCount;
            }
            $oUserPrizeSetQuota->user_id = $oUser->id;
            $oUserPrizeSetQuota->user_forefather_ids = $oUser->forefather_ids;
            $oUserPrizeSetQuota->username = $oUser->username;
            $oUserPrizeSetQuota->prize_group = $iPrizeGroup;
            $bSucc = $oUserPrizeSetQuota->save();
            if (!$bSucc)
                break;
        }
        return $bSucc;
    }

    /**
     * 
     *  核查奖金组配额是否符合要求
     * @param array $aPrizeSetQuota        奖金组配额数组
     * @param int $iParenId                      上级id
     * @return boolean  配额符合要求，返回true；不符合要求，返回false
     * 
     */
    public static function checkQuota($aPrizeSetQuota, $iParenId) {
        $aParentPrizeSetQuota = self::getUserAllPrizeSetQuota($iParenId);
        foreach ($aPrizeSetQuota as $iPrizeGroup => $iQuota) {
            if ($iQuota == 0) {
                continue;
            }
            $iParentQuota = array_get($aParentPrizeSetQuota, $iPrizeGroup);
            if ($iParentQuota === null) {
                return false;
            }
            if ($iParentQuota < $iQuota) {
                return false;
            }
        }
        return true;
    }

}
