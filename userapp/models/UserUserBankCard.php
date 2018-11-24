<?php

class UserUserBankCard extends UserBankCard {

    public static $columnForList = ['bank', 'account', 'updated_at', 'status'];
    protected static $cacheUseParentClass = true;
    protected $isAdmin = false;
    public static $customMessages = [
        'bank_id.integer' => '请选择开户银行',
        'province_id.integer' => '请选择开户银行区域省份',
        'city_id.integer' => '请选择开户银行区域城市',
        'branch.required' => '请填写支行名称',
        'branch.regex' => '支行名称必须由字母，数字或汉字组成',
        'branch.between' => '支行名称长度必须介于 :min - :max 之间',
        'account_name.required' => '请填写开户人姓名',
        'account_name.regex' => '开户人姓名必须由字母，数字或汉字组成',
        'account_name.between' => '开户人姓名长度必须介于 :min - :max 之间',
        'account.between' => '银行账号由16位或19位数字组成',
        'account.confirmed' => '银行账号两次输入不一致',
        'account.required' => '请填写银行账号',
        'account.unique' => '银行账号已存在',
        'account_confirmation.between' => '确认银行账号由16位或19位数字组成',
        'account_confirmation.required' => '请填写确认银行账号',
    ];

    protected function beforeValidate() {

        $this->account = str_replace(' ', '', $this->account);
        $this->account_confirmation = str_replace(' ', '', $this->account_confirmation);
        $this->user_id = Session::get('user_id');
        $this->username = Session::get('username');
        // pr($this->toArray());exit;
        return parent::beforeValidate();
    }

    /**
     * [getAccountHiddenAttribute 访问器方法, 生成只显示末尾4位的银行卡账号信息, 且每4位空格隔开]
     * @return [String]          [只显示末尾4位的银行卡账号信息,且每4位空格隔开]
     */
    protected function getAccountHiddenAttribute() {
        $str = str_repeat('*', (strlen($this->account) - 4));
        $account_hidden = preg_replace('/(\*{4})(?=\*)/', '$1 ', $str) . ' ' . substr($this->account, -4);
        return $account_hidden;
    }

    /**
     * 获取用户绑定银行卡数量
     * @param int $iUserId 用户id
     * @return int      绑卡数量
     */
    public static function getUserBankCardsCount($iUserId = null) {
        $iUserId or $iUserId = Session::get('user_id');
        Cache::setDefaultDriver(static::$cacheDrivers[static::$cacheLevel]);
        $key = self::createUserBankCardCountCacheKey($iUserId);
        if (static::$cacheLevel == self::CACHE_LEVEL_NONE) {
            $oQuery = self::getUserBankCards($iUserId);
            return $oQuery->count();
        }
        $iUserBankCardCount = 0;
        if (!($iUserBankCardCount = Cache::get($key))) {
            $oQuery = self::getUserBankCards($iUserId);
            $iUserBankCardCount = $oQuery->count();
            if (static::$cacheMinutes) {
                Cache::put($key, $data, static::$cacheMinutes);
            } else {
                Cache::forever($key, $iUserBankCardCount);
            }
        }
        return $iUserBankCardCount;
    }

    public static function createUserBankCardCountCacheKey($iUserId) {
        $sPrefix = self::getCachePrefix();
        return $sPrefix . 'user-bank-card-count' . $iUserId;
    }

    /**
     * [getUserCardInfoById 根据绑定的银行卡id查询可用的用户银行卡信息]
     * @param  [Integer] $iCardId [绑定的银行卡id]
     * @return [Object]          [银行卡号信息]
     */
    public static function getUserCardInfoById($iCardId) {
        $oQuery = self::where('id', '=', $iCardId)->whereIn('status', [self::STATUS_IN_USE, self::STATUS_LOCKED]);
        return $oQuery->first();
    }

    public function flushUserBankCardCount() {
        $key = self::createUserBankCardCountCacheKey($this->user_id);
        Cache::setDefaultDriver(static::$cacheDrivers[static::$cacheLevel]);
        !Cache::has($key) or Cache::forget($key);
    }

    /**
     * [getUserBankCardAccount 根据银行卡号查询可用的用户银行卡信息]
     * @param  [String] $sAccount [银行卡号]
     * @return [Object]           [银行卡号信息]
     */
    public static function getUserBankCardAccount($sAccount) {
        $oQuery = UserUserBankCard::where('account', '=', $sAccount)->whereIn('status', [self::STATUS_IN_USE, self::STATUS_LOCKED]);
        return $oQuery->first();
    }

    /**
     * [getUserCardsLockStatus 获取用户银行卡的锁定状态]
     * @return [Int] [0: 未锁定, 1: 锁定 ]
     */
    public static function getUserCardsLockStatus($iUserId) {
        $oQuery = self::getUserBankCards($iUserId);
        $aStatus = $oQuery->get(['status'])->toArray();
        $aLocked = [];
        foreach ($aStatus as $iStatus) {
            if ($iStatus['status'] == self::STATUS_LOCKED) {
                $aLocked[] = $iStatus;
            }
        }
        return count($aLocked);
    }

    protected function afterDelete($oDeletedModel) {
        $oDeletedModel->flushUserBankCardCount();
        return parent::afterDelete($oDeletedModel);
    }

    protected function afterSave($oDeletedModel) {
        $oDeletedModel->flushUserBankCardCount();
        return parent::afterSave($oDeletedModel);
    }

}
