<?php

/**
 * 账变模型
 */
use Illuminate\Support\Facades\Redis;

class Transaction extends BaseModel {

    protected $table = 'transactions';
    protected $softDelete = false;
    protected $fillable = [
        'serial_number',
        'user_id',
        'username',
        'is_tester',
        'is_agent',
        'top_agent_id',
        'user_forefather_ids',
        'account_id',
        'type_id',
        'is_income',
        'trace_id',
        'lottery_id',
        'issue',
        'method_id',
        'way_id',
        'coefficient',
        'description',
        'project_id',
        'project_no',
        'amount',
        'note',
        'previous_balance',
        'previous_frozen',
        'previous_available',
        'previous_withdrawable',
        'previous_prohibit_amount',
        'balance',
        'frozen',
        'available',
        'withdrawable',
        'prohibit_amount',
        'tag',
        'admin_user_id',
        'administrator',
        'ip',
        'proxy_ip',
    ];
    public static $resourceName = 'Transaction';
    public static $amountAccuracy = 6;
    public static $htmlNumberColumns = [
        'amount' => 6,
        'available' => 6,
        'balance' => 6,
        'frozen' => 6,
        'withdrawable' => 6,
        'prohibit_amount' => 2,
        'previous_available' => 6,
        'previous_frozen' => 6,
        'previous_balance' => 6,
        'previous_withdrawable' => 6,
        'previous_prohibit_amount' => 2,
    ];

    /**
     * the columns for list page
     * @var array
     */
    public static $columnForList = [
        'serial_number',
        'created_at',
        'username',
        'is_tester',
        'description',
        'lottery_id',
        'way_id',
        'coefficient',
        'amount',
        'available',
        'note',
        'tag',
        'ip',
        'administrator',
    ];
    public static $totalColumns = [
        'amount',
    ];
    public static $listColumnMaps = [
        'description' => 'friendly_description',
        'amount' => 'amount_formatted',
        'available' => 'available_formatted',
        'is_tester' => 'formatted_is_tester',
        'serial_number' => 'serial_number_short',
    ];
    public static $viewColumnMaps = [
        'is_tester' => 'formatted_is_tester',
        'is_agent' => 'formatted_is_agent',
        'description' => 'friendly_description',
        'amount' => 'amount_formatted',
        'available' => 'available_formatted',
        'frozen' => 'frozen_formatted',
        'balance' => 'balance_formatted',
        'withdrawable' => 'withdrawable_formatted',
        'prohibit_amount' => 'prohibit_amount_formatted',
        'previous_available' => 'previous_available_formatted',
        'previous_frozen' => 'previous_frozen_formatted',
        'previous_balance' => 'previous_balance_formatted',
        'previous_withdrawable' => 'previous_withdrawable_formatted',
        'previous_prohibit_amount' => 'previous_prohibit_amount_formatted',
        'serial_number' => 'serial_number_short',
    ];

    /**
     * 下拉列表框字段配置
     * @var array
     */
    public static $htmlSelectColumns = [
        'lottery_id' => 'aLotteries',
        'way_id' => 'aWays',
        'coefficient' => 'aCoefficients',
//        'admin_user_id' => 'aAdminUsers',
    ];
    public static $ignoreColumnsInView = [
        'account_id',
        'user_id',
        'user_forefather_ids',
        'type_id',
        'method_id',
        'is_income',
        'bet_number',
        'prize_added',
        'total_prize',
        'locked_prize',
        'locked_commission',
        'prize_set',
        'admin_user_id',
        'previous_balance',
        'previous_frozen',
        'previous_available',
        'previous_withdrawable',
        'balance',
        'frozen',
        'withdrawable',
        'safekey',
    ];

    /**
     * order by config
     * @var array
     */
    public $orderColumns = [
        'id' => 'desc'
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
    public static $mainParamColumn = 'user_id';
    public static $rules = [
        'type_id' => 'required|integer',
        'is_income' => 'required|in:0,1',
        'serial number' => 'max:20',
        'username' => 'max:16',
        'lottery_id' => 'integer',
        'method_id' => 'integer',
        'coefficient' => 'numeric|in:1.00,0.50,0.10,0.01',
        'amount' => 'required|numeric|min:0',
        'previous_balance' => 'numeric',
        'previous_frozen' => 'numeric',
        'previous_available' => 'numeric',
        'previous_withdrawable' => 'numeric',
        'balance' => 'numeric',
        'frozen' => 'numeric',
        'withdrawable' => 'numeric',
        'available' => 'numeric',
        'ip' => 'ip',
        'proxy_ip' => 'ip',
        'note' => 'max:100',
        'tag' => 'max:30',
        'admin_user_id' => 'integer',
        'administrator' => 'max:16',
        'description' => 'required|max:50',
    ];
    public static $aReportType = [
        ReportDownloadConfig::TYPE_TRANSACTION => 0,
        ReportDownloadConfig::TYPE_TRANSACTION_DEPOSIT => TransactionType::TYPE_DEPOSIT,
        ReportDownloadConfig::TYPE_TRANSACTION_WITHDRAWAL => TransactionType::TYPE_WITHDRAW,
    ];

    const ERRNO_CREATE_SUCCESSFUL = -100;
    const ERRNO_CREATE_ERROR_DATA = -101;
    const ERRNO_CREATE_ERROR_SAVE = -102;
    const ERRNO_CREATE_ERROR_BALANCE = -103;
    const ERRNO_CREATE_LOW_BALANCE = -104;

    protected function afterSave($oSavedModel) {
        parent::afterSave($oSavedModel);
        $oSavedModel->deleteUserDataListCache();
    }

    public static function makeSeriesNumber($iUserId) {
        return uniqid($iUserId, true);
//        return md5($iUserId . microtime(true) . mt_rand());
    }

    protected function beforeValidate() {
//        pr($this->toArray());
//        exit;
        $this->serial_number = self::makeSeriesNumber($this->user_id);
        $this->makeSafeKey();
        return parent::beforeValidate();
    }

//    public function addTransaction($aAttributes, & $aNewBalance){
//        if (!$this->compileData($aAttributes, $aNewBalance)){
//            return false;
//        }
//        return $this->save(static::$rules);
//    }

    private static function compileData($oUser, $oAccount, $iTypeId, $fAmount, & $aNewBalance, & $aExtraData = []) {
        $oTransactionType = TransactionType::find($iTypeId);
        $fAmount = formatNumber($fAmount, static::$amountAccuracy);
//        pr($aExtraData);
//        exit;
        isset($aExtraData['trace_id']) or $aExtraData['trace_id'] = null;
        $aAttributes = [
            'trace_id' => $aExtraData['trace_id'],
            'user_id' => $oUser->id,
            'is_tester' => $oUser->is_tester,
            'is_agent' => $oUser->is_agent,
            'top_agent_id' => $oUser->getTopAgentId(),
            'amount' => $fAmount,
            'type_id' => $iTypeId,
            'is_income' => $oTransactionType->credit,
            'previous_frozen' => $oAccount->frozen,
            'previous_balance' => $oAccount->balance,
            'previous_available' => $oAccount->available,
            'previous_withdrawable' => $oAccount->withdrawable,
            'previous_prohibit_amount' => $oAccount->prohibit_amount,
            'frozen' => $oAccount->frozen,
            'balance' => $oAccount->balance,
            'available' => $oAccount->available,
            'withdrawable' => $oAccount->withdrawable,
            'prohibit_amount' => $oAccount->prohibit_amount,
            'user_forefather_ids' => $oUser->forefather_ids,
            'account_id' => $oAccount->id,
            'username' => $oUser->username,
            'description' => $oTransactionType->description,
        ];

//        pr($aAttributes);
//        exit;
        if (isset($aExtraData['clent_ip'])) {
            $aAttributes['ip'] = $aExtraData['client_ip'];
        }
        if (isset($aExtraData['proxy_ip'])) {
            $aAttributes['proxy_ip'] = $aExtraData['proxy_ip'];
        }
        if ($oTransactionType->trace_linked) {
            if (!isset($aExtraData['lottery_id']) || !isset($aExtraData['way_id']) || !isset($aExtraData['coefficient'])
            ) {
                return false;
            }
            $aAttributes['trace_id'] = $aExtraData['trace_id'];
        }
//        pr($aExtraData);
        if ($oTransactionType->project_linked) {
            if (!isset($aExtraData['project_id']) || !isset($aExtraData['project_no']) || !isset($aExtraData['lottery_id']) || !isset($aExtraData['issue']) || !isset($aExtraData['way_id']) || !isset($aExtraData['coefficient'])
            ) {
                return false;
            }
            $aAttributes['project_id'] = $aExtraData['project_id'];
            $aAttributes['project_no'] = $aExtraData['project_no'];
            isset($aExtraData['trace_id']) or $aAttributes['trace_id'] = $aExtraData['trace_id'];
        }
//        exit;
        if ($oTransactionType->trace_linked || $oTransactionType->project_linked) {
            $aAttributes['lottery_id'] = $aExtraData['lottery_id'];
            $aAttributes['way_id'] = $aExtraData['way_id'];
            $aAttributes['coefficient'] = $aExtraData['coefficient'];
        }
        !isset($aExtraData['issue']) or $aAttributes['issue'] = $aExtraData['issue'];
        !isset($aExtraData['admin_user_id']) or $aAttributes['admin_user_id'] = $aExtraData['admin_user_id'];
        !isset($aExtraData['administrator']) or $aAttributes['administrator'] = $aExtraData['administrator'];
        !isset($aExtraData['note']) or $aAttributes['note'] = $aExtraData['note'];
        !isset($aExtraData['tag']) or $aAttributes['tag'] = $aExtraData['tag'];

// deal amount
        $aSubAccounts = ['balance', 'available', 'frozen', 'withdrawable', 'prohibit_amount'];
//        pr($aAttributes);
        foreach ($aSubAccounts as $sField) {
            if (!$oTransactionType->$sField) {
                continue;
            }
            $aAttributes[$sField] += $oTransactionType->$sField * $fAmount;
            $aNewBalance[$sField] = $aAttributes[$sField];
        }
        $aAttributes['withdrawable'] >= 0 or $aNewBalance['withdrawable'] = $aAttributes['withdrawable'] = 0;
        $aAttributes['prohibit_amount'] >= 0 or $aNewBalance['prohibit_amount'] = $aAttributes['prohibit_amount'] = 0;
//        pr('dow');
//        pr($aAttributes);
//        pr($aNewBalance);
//        pr($oAccount->toArray());
//        exit;
        return $aAttributes;
    }

    public function makeSafeKey() {
        $aFields = [
            'user_id',
            'type_id',
            'account_id',
            'trace_id',
            'amount',
            'lottery_id',
            'issue',
            'way_id',
            'coefficient',
            'description',
            'project_id',
            'amount',
            'admin_user_id',
            'ip',
            'proxy_ip'
        ];
        $aData = [];
        foreach ($aFields as $sField) {
            $aData[] = $this->$sField;
        }
        return $this->safekey = md5(implode('|', $aData));
    }

    protected function setAmountAttribute($fAmount) {
        $this->attributes['amount'] = formatNumber($fAmount, static::$amountAccuracy);
    }

    protected function setBalanceAttribute($fAmount) {
        $this->attributes['balance'] = formatNumber($fAmount, static::$amountAccuracy);
    }

    protected function setAvailableAttribute($fAmount) {
        $this->attributes['available'] = formatNumber($fAmount, static::$amountAccuracy);
    }

    protected function setFrozenAttribute($fAmount) {
        $this->attributes['frozen'] = formatNumber($fAmount, static::$amountAccuracy);
    }

    protected function setWithdrawableAttribute($fAmount) {
        $this->attributes['withdrawable'] = formatNumber($fAmount, static::$amountAccuracy);
    }

    protected function setPreviousBalanceAttribute($fAmount) {
        $this->attributes['previous_balance'] = formatNumber($fAmount, static::$amountAccuracy);
    }

    protected function setPreviousAvailableAttribute($fAmount) {
        $this->attributes['previous_available'] = formatNumber($fAmount, static::$amountAccuracy);
    }

    protected function setPreviousFrozenAttribute($fAmount) {
        $this->attributes['previous_frozen'] = formatNumber($fAmount, static::$amountAccuracy);
    }

    protected function setPreviousWithdrawableAttribute($fAmount) {
        $this->attributes['previous_withdrawable'] = formatNumber($fAmount, static::$amountAccuracy);
    }

    protected function setSerialNumberAttribute($sSerialNumber) {
        $this->attributes['serial_number'] = strtoupper($sSerialNumber);
    }

    protected function getAmountFormattedAttribute() {
        return ($this->is_income ? '+' : '-') . $this->getFormattedNumberForHtml('amount');
    }

    protected function getDirectAmountAttribute() {
        return ($this->is_income ? '' : '-') . formatNumber($this->attributes['amount'], static::$htmlNumberColumns['amount']);
    }

    protected function getSerialNumberShortAttribute() {
        return substr($this->attributes['serial_number'], -6);
    }

    protected function getAvailableFormattedAttribute() {
        return $this->getFormattedNumberForHtml('available');
    }

    protected function getFrozenFormattedAttribute() {
        return $this->getFormattedNumberForHtml('frozen');
    }

    protected function getBalanceFormattedAttribute() {
        return $this->getFormattedNumberForHtml('balance');
    }

    protected function getWithdrawableFormattedAttribute() {
        return $this->getFormattedNumberForHtml('withdrawable');
    }

    protected function getProhibitAmountFormattedAttribute() {
        return $this->getFormattedNumberForHtml('prohibit_amount');
    }

    protected function getPreviousBalanceFormattedAttribute() {
        return $this->getFormattedNumberForHtml('previous_balance');
    }

    protected function getPreviousFrozenFormattedAttribute() {
        return $this->getFormattedNumberForHtml('previous_frozen');
    }

    protected function getPreviousAvailableFormattedAttribute() {
        return $this->getFormattedNumberForHtml('previous_available');
    }

    protected function getPreviousWithdrawableFormattedAttribute() {
        return $this->getFormattedNumberForHtml('previous_withdrawable');
    }

    protected function getPreviousProhibitAmountFormattedAttribute() {
        return $this->getFormattedNumberForHtml('previous_prohibit_amount');
    }

//    protected function getBalanceFormattedAttribute() {
//        return $this->getFormattedNumberForHtml('balance');
//    }

    protected function getUpdatedAtDayAttribute() {
// $sDay = explode(' ', $this->updated_at);
        return substr($this->updated_at, 5, 5);
    }

    protected function getUpdatedAtTimeAttribute() {
        return substr($this->updated_at, 11, 5);
    }

    /**
     * 增加新的账变
     * @param User      $oUser
     * @param Account   $oAccount
     * @param int      $iTypeId
     * @param float     $fAmount
     * @param array     $aExtraData
     * @return int      0: 成功; -1: 数据错误; -2: 账变保存失败; -3: 账户余额保存失败
     */
    public static function addTransaction($oUser, $oAccount, $iTypeId, $fAmount, $aExtraData = []) {
//        $aNewBalance = [];
//        pr('ddd' . $fAmount);
//        exit;
        if ($fAmount <= 0) {
            return self::ERRNO_CREATE_ERROR_DATA;
        }
        if (!$aAttributes = self::compileData($oUser, $oAccount, $iTypeId, $fAmount, $aNewBalance, $aExtraData)) {
            return self::ERRNO_CREATE_ERROR_DATA;
        }
//        exit;
        $oNewTransaction = new Transaction($aAttributes);
        $rules = & self::compileRules();
        if (!$oNewTransaction->save($rules)) {
//            pr($oNewTransaction->validationErrors->toArray());
            return self::ERRNO_CREATE_ERROR_SAVE;
        }
//        pr($aNewBalance);
        $oAccount->fill($aNewBalance);
//        pr($oAccount->toArray());
        if (!$oAccount->save()) {
//            pr($oNewTransaction->validationErrors->toArray());
            return self::ERRNO_CREATE_ERROR_BALANCE;
        }
        return self::ERRNO_CREATE_SUCCESSFUL;
    }

    protected function getFriendlyDescriptionAttribute() {
        return __('_transactiontype.' . strtolower(Str::slug($this->attributes['description'])));
    }

    /**
     * 反转，即进行逆操作
     *
     * @param Account $oAccount
     * @return int      0: 成功; -1: 数据错误; -2: 账变保存失败; -3: 账户余额保存失败
     */
    public function reverse($oAccount) {
        $oType = TransactionType::find($this->type_id);
        if (empty($oType) || empty($oType->reverse_type)) {
            return true;
        }
        $oUser = User::find($this->user_id);
        $aExtractData = $this->getAttributes();
        unset($aExtractData['id']);
//        if ($this->project_id){
//            $aExtractData[ 'serial_number' ] = $this->project_no;
//        }
        return self::addTransaction($oUser, $oAccount, $oType->reverse_type, $this->amount, $aExtractData);
    }

    public static function getTransactions($iTypeId, $iLotteryId, $sIssue, $iProjectId = null, $iOffset = null, $iLimit = null) {
        $aConditions = [
            'type_id' => ['=', $iTypeId],
            'lottery_id' => ['=', $iLotteryId],
            'issue' => ['=', $sIssue],
        ];
        is_null($iProjectId) or $aConditions['project_id'] = ['=', $iProjectId];
        $oQuery = self::doWhere($aConditions)->orderBy('id', 'asc');
        empty($iOffset) or $oQuery = $oQuery->offset($iOffset);
        empty($iLimit) or $oQuery = $oQuery->limit($iLimit);
//        pr($aConditions);
//        exit;
        return $oQuery->get();
    }

    protected function getFormattedIsTesterAttribute() {
        return __('_basic.' . strtolower(Config::get('var.boolean')[$this->attributes['is_tester']]));
    }

    protected function getFormattedIsAgentAttribute() {
        return __('_basic.' . strtolower(Config::get('var.boolean')[$this->attributes['is_agent']]));
    }

    protected function getFormattedCoefficientAttribute() {
        return !is_null($this->coefficient) ? Coefficient::getCoefficientText($this->coefficient) : '';
    }

    private static function & compileRules() {
        $rules = self::$rules;
        $rules['coefficient'] = 'numeric|in:' . implode(',', Coefficient::getValidCoefficientValues());
        return $rules;
    }

    protected static function compileListCacheKeyPrefix() {
        return self::getCachePrefix(true) . 'for-user-';
    }

    protected static function compileListCacheKey($iUserId = null, $iPage = 1) {
        $sKey = self::compileUserDataListCachePrefix($iUserId);
        empty($iPage) or $sKey .= $iPage;
        return $sKey;
    }

    protected static function compileUserDataListCachePrefix($iUserId) {
        return self::compileListCacheKeyPrefix() . $iUserId . '-';
    }

    public function deleteUserDataListCache() {
        $sKeyPrifix = self::compileUserDataListCachePrefix($this->user_id);
        $redis = Redis::connection();
        if ($aKeys = $redis->keys($sKeyPrifix . '*')) {
            foreach ($aKeys as $sKey) {
                $redis->del($sKey);
            }
        }
    }

    /**
     * 下载报表实现类，根据不同model，下载报表内容不同
     * @param int $iReportType      报表类型
     * @param int $iFreqType        下载频率类型，如：每天，每周，每月等
     */
    public function download($iReportType, $aDownloadTime, $sFileName, $sDir = './') {
        $oQuery = self::whereBetween('created_at', array_values($aDownloadTime))->where('is_tester', '=', 0);
        $iReportType == 0 or $oQuery->where('type_id', '=', $iReportType);
//         $queries = DB::getQueryLog();
//         $last_query = end($queries);
//         pr($last_query);exit;
        $aConvertFields = [
            'lottery_id' => 'lottery',
            'way_id' => 'way',
            'amount' => 'transaction_amount_formatted',
            'coefficient' => 'coefficient',
            'description' => 'friendly_description',
            'is_tester' => 'boolean',
        ];

        $aLotteries = Lottery::getTitleList();
        $aWays = SeriesWay::getTitleList();
        $aData = $oQuery->get(array_merge(['is_income'], Transaction::$columnForList))->toArray();
        $aData = $this->makeData($aData, Transaction::$columnForList, $aConvertFields, $aWays, $aLotteries);
        return $this->downloadCSV(Transaction::$columnForList, $aData, $sFileName, $sDir);
    }

    public function makeData($aData, $aFields, $aConvertFields, $aWays = null, $aLotteries = null) {
        $aResult = array();
        foreach ($aData as $oDeposit) {
            $a = [];
            foreach ($aFields as $key) {
                if ($oDeposit[$key] === '') {
                    $a[] = $oDeposit[$key];
                    continue;
                }
                if (array_key_exists($key, $aConvertFields)) {
                    switch ($aConvertFields[$key]) {
                        case 'transaction_amount_formatted':
                            $a[] = ($oDeposit['is_income'] ? '+' : '-') . $oDeposit['amount'];
                            break;
                        case 'lottery':
                            if (array_key_exists($oDeposit[$key], $aLotteries)) {
                                $a[] = $aLotteries[$oDeposit[$key]];
                            } else {
                                $a[] = '';
                            }
                            break;
                        case 'boolean':
                            $a[] = $oDeposit[$key] ? __('Yes') : __('No');
                            break;
                        case 'way':
                            if (array_key_exists($oDeposit[$key], $aWays)) {
                                $a[] = $aWays[$oDeposit[$key]];
                            } else {
                                $a[] = '';
                            }
                            break;
                        case 'coefficient':
                            $aCoefficients = Coefficient::$coefficients;
                            $a[] = key_exists($oDeposit[$key], $aCoefficients) ? $aCoefficients[$oDeposit[$key]] : null;
                            break;
                        case 'friendly_description':
                            $a[] = __('_transactiontype.' . strtolower(Str::slug($oDeposit['description'])));
                            break;
                    }
                } else {
                    $a[] = $oDeposit[$key];
                }
            }
            $aResult[] = $a;
        }
        return $aResult;
    }

}
