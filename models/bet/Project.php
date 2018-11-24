<?php
use Illuminate\Support\Facades\Redis;

class Project extends BaseModel {

    protected static $cacheLevel = self::CACHE_LEVEL_FIRST;
    protected static $cacheMinutes = 1;
    protected $table = 'projects';
    public static $resourceName = 'Project';
    public static $amountAccuracy = 4;
    public static $htmlNumberColumns = [
        'amount' => 4,
        'prize' => 4
    ];
    public static $columnForList = [
        'id',
        'serial_number',
        'trace_id',
        'username',
        'multiple',
        'lottery_id',
        'issue',
        'end_time',
        'title',
        'bet_number',
        'coefficient',
        'amount',
        'prize',
        'bought_at',
        'ip',
        'status',
    ];
    public static $totalColumns = [
        'amount',
        'prize',
    ];
    public static $listColumnMaps = [
        'end_time' => 'friendly_end_time'
    ];
    protected $fillable = [
        'trace_id',
        'user_id',
        'username',
        'is_tester',
        'prize_group',
        'account_id',
        'multiple',
        'serial_number',
        'user_forefather_ids',
        'issue',
        'end_time',
        'title',
        'way_total_count',
        'single_count',
        'bet_rate',
        'bet_number',
        'display_bet_number',
        'lottery_id',
        'method_id',
        'way_id',
        'coefficient',
        'single_amount',
        'amount',
        'status',
        'prize_set',
        'ip',
        'proxy_ip',
        'bought_at',
        'bet_commit_time',
        'canceled_at',
        'canceled_by',
        'bought_time',
    ];
    public static $rules = [
        'trace_id' => 'integer',
        'user_id' => 'required|integer',
        'account_id' => 'required|integer',
        'multiple' => 'required|integer',
        'serial_number' => 'required|max:32',
        'user_forefather_ids' => 'max:1024',
        'bet_number' => 'required',
        'note' => 'max:250',
        'lottery_id' => 'required|integer',
        'issue' => 'required|max:12',
        'end_time' => 'integer',
        'way_id' => 'required|integer',
        'title' => 'required|max:100',
        'coefficient' => 'required|in:1.00,0.50,0.10,0.01',
        'single_amount' => 'regex:/^[\d]+(\.[\d]{0,4})?$/',
        'amount' => 'regex:/^[\d]+(\.[\d]{0,4})?$/',
        'status' => 'in:0,1,2,3',
        'ip' => 'required|ip',
        'proxy_ip' => 'required|ip',
        'bought_at' => 'date_format:Y-m-d H:i:s',
        'canceled_at' => 'date_format:Y-m-d H:i:s',
        'canceled_by' => 'max:16',
        'way_total_count' => 'integer',
        'bet_count' => 'integer',
        'bet_rate' => 'numeric',
    ];
    public $orderColumns = [
        'id' => 'desc'
    ];

    const STATUS_NORMAL = 0;
    const STATUS_DROPED = 1;
    const STATUS_LOST = 2;
    const STATUS_WON = 3;
    const STATUS_PRIZE_SENT = 4;
    const STATUS_DROPED_BY_SYSTEM = 5;
    const DROP_BY_USER = 1;
    const DROP_BY_ADMIN = 2;
    const DROP_BY_SYSTEM = 3;
    const COMMISSION_STATUS_WAITING = 0;
    const COMMISSION_STATUS_SENDING = 1;
    const COMMISSION_STATUS_PARTIAL = 2;
    const COMMISSION_STATUS_SENT = 4;
    const PRIZE_STATUS_WAITING = 0;
    const PRIZE_STATUS_SENDING = 1;
    const PRIZE_STATUS_PARTIAL = 2;
    const PRIZE_STATUS_SENT = 4;

    public static $validStatuses = [
        self::STATUS_NORMAL => 'Normal',
        self::STATUS_DROPED => 'Canceled',
        self::STATUS_LOST => 'Lost',
        self::STATUS_WON => 'Counted',
        self::STATUS_PRIZE_SENT => 'Prize Sent',
        self::STATUS_DROPED_BY_SYSTEM => 'Canceled By System'
    ];
    public static $commissionStatuses = [
        self::COMMISSION_STATUS_WAITING => 'Waiting',
        self::COMMISSION_STATUS_SENDING => 'Sending',
        self::COMMISSION_STATUS_PARTIAL => 'Partial',
        self::COMMISSION_STATUS_SENT => 'Done',
    ];
    public static $prizeStatuses = [
        self::PRIZE_STATUS_WAITING => 'Waiting',
        self::PRIZE_STATUS_SENDING => 'Sending',
        self::PRIZE_STATUS_PARTIAL => 'Partial',
        self::PRIZE_STATUS_SENT => 'Done',
    ];
    public static $aHiddenColumns = [];
    public static $aReadonlyInputs = [];
    public static $mainParamColumn = 'user_id';
    public static $titleColumn = 'serial_number';

    /**
     * User
     * @var User|Model
     */
    public $User;

    /**
     * Account
     * @var Account|Model
     */
    public $Account;

    /**
     * Lottery
     * @var Lottery|Model
     */
    public $Lottery;

    /**
     * 下拉列表框字段配置
     * @var array
     */
    public static $htmlSelectColumns = [
        'lottery_id' => 'aLotteries',
        'status' => 'aStatusDesc',
//        'coefficient' => 'aCoefficients',
    ];

    const ERRNO_BET_SUCCESSFUL = -200;
    const ERRNO_PROJECT_MISSING = -201;
    const ERRNO_BET_SLAVE_DATA_SAVED = -202;
    const ERRNO_SLAVE_DATA_CANCELED = -203;
    const ERRNO_COUNT_ERROR = -204;
    const ERRNO_PRIZE_OVERFLOW = -205;
    const ERRNO_BET_ERROR_SAVE_ERROR = -210;
    const ERRNO_BET_ERROR_COMMISSIONS = -211;
    const ERRNO_BET_ERROR_DATA_ERROR = -213;
    const ERRNO_BET_ERROR_LOW_BALANCE = -214;
    const ERRNO_DROP_SUCCESS = -230;
    const ERRNO_DROP_ERROR_STATUS = -231;
    const ERRNO_DROP_ERROR_NOT_YOURS = -232;
    const ERRNO_DROP_ERROR_STATUS_UPDATE_ERROR = -233;
    const ERRNO_DROP_ERROR_PRIZE = -234;
    const ERRNO_DROP_ERROR_COMMISSIONS = -235;
    const ERRNO_BET_TURNOVER_UPDATE_FAILED = -236;
    const ERRNO_BET_ALL_CREATED = -500;
    const ERRNO_BET_PARTLY_CREATED = -501;
    const ERRNO_BET_FAILED = -502;
    const ERRNO_BET_DATA_ERROR = -503;
    const ERRNO_BET_LOW_AMOUNT = -504;
    const ERRNO_BET_NO_RIGHT = -999;
    const ERRNO_BET_SERVER_ERROR = -1999;

    /**
     * check project data
     * @return boolean
     */
    public function checkProject() {
        return true;
    }

    /**
     * save prize setting of this project
     * @return boolean
     */
    protected function saveCommissions() {
        if (!$this->id) {
            return false;
//            return self::ERRNO_PROJECT_MISSING;
        }
        $aCommissions = & $this->compileCommissions();
        if ($aCommissions) {
//                $rules = Commission::compileRules();
            foreach ($aCommissions as $data) {
                $oPrjCommission = new Commission($data);
                //            pr($oPrjCommission->getAttributes());

                if (!$bSucc = $oPrjCommission->save()) {
                    pr(get_class($this));
                    pr(__LINE__);
                    pr($oPrjCommission->validationErrors->toArray());
                    return false;
//                    return self::ERRNO_BET_ERROR_COMMISSIONS;
                }
            }
        }
        return true;
//        return self::ERRNO_BET_SLAVE_DATA_SAVED;
    }

    protected function setPrizeAttribute($fAmount) {
        $this->attributes['prize'] = formatNumber($fAmount, static::$amountAccuracy);
    }

    protected function getSerialNumberShortAttribute() {
        return substr($this->attributes[ 'serial_number' ], -6);
    }

    /**
     * 撤单
     * @param int $iType self::DROP_BY_USER | self::DROP_BY_ADMIN | self::DROP_BY_SYSTEM
     * @return int errno self::ERRNO_DROP_SUCCESS 成功
     */
    public function drop($iType = self::DROP_BY_USER) {
        if ($this->status != self::STATUS_NORMAL) {
            return self::ERRNO_DROP_ERROR_STATUS;
        }
        if ($iType == self::DROP_BY_USER) {
            if ($this->user_id != Session::get('user_id')) {
                return self::ERRNO_DROP_ERROR_NOT_YOURS;
            }
            $oIssue = Issue::getIssue($this->lottery_id, $this->issue);
            if (empty($oIssue)) {
                return Issue::ERRNO_ISSUE_MISSING;
            }
            if (time() > $oIssue->end_time) {
                return Issue::ERRNO_ISSUE_EXPIRED;
            }
            unset($oIssue);
        }
        is_object($this->User) or $this->User = User::find($this->user_id);
        is_object($this->Account) or $this->Account = Account::find($this->account_id);
        $aExtraData = $this->getAttributes();
        $aExtraData['project_id'] = $this->id;
        $aExtraData['project_no'] = $this->serial_number;
//        if ($iType == self::DROP_BY_ADMIN){
//            $aExtraData['admin_user_id'] = Session::get('admin_user_id');
//            $aExtraData['canceled_by'] = Session::get('admin_username');
//        }
        unset($aExtraData['id']);
        $iReturn = Transaction::addTransaction($this->User, $this->Account, TransactionType::TYPE_DROP, $this->amount, $aExtraData);
        $iReturn != Transaction::ERRNO_CREATE_SUCCESSFUL or $iReturn = $this->setDroped($iType);
//        $iReturn != self::ERRNO_DROP_SUCCESS or $this->addBackTask(false);      // 修正用户销售额
        return $iReturn;
    }

    /**
     * 更新状态为撤单
     * @return bool
     */
    protected function setDroped($iType = self::DROP_BY_USER) {
        if (($iReturn = $this->cancelCommissons()) != self::ERRNO_SLAVE_DATA_CANCELED) {
            return $iReturn;
        }
        $data = ['canceled_at' => date('Y-m-d H:i:s')];
        $iType != self::DROP_BY_ADMIN or $data['canceled_by'] = Session::get('admin_username');
        $iStatus = $iType == self::DROP_BY_SYSTEM ? self::STATUS_DROPED_BY_SYSTEM : self::STATUS_DROPED;
        if (!$this->setStatus($iStatus, self::STATUS_NORMAL, $data)) {
            return self::ERRNO_DROP_ERROR_STATUS_UPDATE_ERROR;
        }
        $this->canceled_at = $data['canceled_at'];
        $this->status = $iStatus;
        $iType != self::DROP_BY_ADMIN or $this->canceled_by = $data['canceled_by'];
        return self::ERRNO_DROP_SUCCESS;
    }

    /**
     * 更新状态
     *
     * @param int $iToStatus
     * @param int $iFromStatus
     * @param $aExtraData
     * @return int  0: success; -1: prize set cancel fail; -2: commissions cancel fail
     */
    protected function setStatus($iToStatus, $iFromStatus, $aExtraData = []) {
        $aExtraData['status'] = $iToStatus;
        $aConditions = [
            'id' => ['=', $this->id],
            'status' => ['=', $iFromStatus],
            'status' => ['<>', $iToStatus],
        ];
        if ($bSucc = $this->strictUpdate($aConditions, $aExtraData)){
            $this->status = $iToStatus;
        }
//        if ($bSucc = Project::where('id', '=', $this->id)->where('status', '=', $iFromStatus)->where('status', '<>', $iToStatus)->update($aExtraData)) {
//            $this->deleteCache();
//        }
        return $bSucc;
    }

    /**
     * 撤销佣金记录
     * @return int  self::ERRNO_SLAVE_DATA_CANCELED or self::ERRNO_DROP_ERROR_COMMISSIONS
     */
    protected function cancelCommissons() {
        if (!Commission::setDroped($this->id)) {
            return self::ERRNO_DROP_ERROR_COMMISSIONS;
        }
        return self::ERRNO_SLAVE_DATA_CANCELED;
//        return self::errno;
    }

    /**
     * set Account Model
     * @param Account $oAccount
     */
    public function setAccount($oAccount) {
        if (!empty($this->account_id) && $this->account_id == $oAccount->id) {
            $this->Account = $oAccount;
        }
    }

    /**
     * set User Model
     * @param User $oUser
     */
    public function setUser($oUser) {
        if (!empty($this->user_id) && $this->user_id == $oUser->id) {
            $this->User = $oUser;
        }
    }

    /**
     * set Lottery Model
     * @param Lottery $oLottery
     */
    public function setLottery($oLottery) {
        $this->Lottery = $oLottery;
    }

    public static function getUnCalcutatedCount($iLotteryId, $sIssue, $mSeriesWayId = null, $bTask = null) {
        $aCondtions = [
            'lottery_id' => $iLotteryId,
            'issue' => $sIssue,
            'status' => self::STATUS_NORMAL
        ];
        is_null($mSeriesWayId) or $aCondtions['way_id'] = $mSeriesWayId;
        if (!is_null($bTask)) {
            $sOperator = $bTask ? '<>' : '=';
            $aCondtions["trace_id"] = [$sOperator, null];
        }
        return self::getCount($aCondtions);
    }

    public static function getCount($aParams) {
        $aCondtions = [];
        foreach ($aParams as $sColumn => $mValue) {
            $a = explode(' ', $sColumn);
            if (count($a) == 1) {
                $sOperator = is_array($mValue) ? 'in' : '=';
            } else {
                $sColumn = $a[0];
                $sOperator = $a[1];
            }
            $aCondtions[$sColumn] = [$sOperator, $mValue];
        }
//        exit;
        return self::doWhere($aCondtions)->count();
    }

    protected function getPrizeSetFormattedAttribute() {
        $aPrizeSets = json_decode($this->attributes['prize_set'], true);
        $aDisplay = [];
//        pr($aPrizeSets);
//        exit;
        foreach($aPrizeSets as $iBasicMethodId => $aPrizes){
            $oBasicMethod = BasicMethod::find($iBasicMethodId);
            $oBasicMethod->name;
            $a = [];
            foreach($aPrizes as $iLevel => $fPrize){
                $a[] = getChinese($iLevel) . '等奖: ' . $fPrize * $this->coefficient . '元';
            }
            $aDisplay[$oBasicMethod->name] = $oBasicMethod->name . ' : ' . implode(' ; ' , $a);
        }
        return implode('<br />',$aDisplay);
    }

    protected function getFormattedStatusAttribute() {
        return __('_project.' . strtolower(Str::slug(static::$validStatuses[$this->attributes['status']])));
    }

    protected function getPrizeFormattedAttribute() {
        return $this->attributes['prize'] ? $this->getFormattedNumberForHtml('prize') : null;
    }

    protected function getAmountFormattedAttribute() {
        return $this->getFormattedNumberForHtml('amount');
    }

    protected function getUpdatedAtTimeAttribute() {
        return substr($this->updated_at, 5, -3);
    }

    /**
     * 向后台任务队列增加任务
     * @param boolean $bPlus
     */
    public function addTurnoverStatTask($bPlus = true) {
        $sField = $bPlus ? 'bought_at' : 'canceled_at';
        $aTaskData = [
            'type' => 'turnover',
            'user_id' => $this->user_id,
            'amount' => $bPlus ? $this->amount : -$this->amount,
            'date' => substr($this->$sField, 0, 10),
            'lottery_id' => $this->lottery_id,
            'issue' => $this->issue,
        ];
        return BaseTask::addTask('StatUpdateProfit', $aTaskData, 'stat');
    }

    /**
     * 获取用户当前时间的有效投注金额
     * @param int $iUserId     用户id
     * @param string $currentDateTime     当前时间
     */
    public static function getCurrentDayTurnover($iUserId, $currentDateTime, $endDateTime = null) {
        $oQuery = self::where('user_id', $iUserId)->where('bought_at', '>=', $currentDateTime);
        !$endDateTime or $oQuery->where('bought_at', '<=', $endDateTime);
        $aTurnover = $oQuery->whereIn('status', [Project::STATUS_LOST, Project::STATUS_WON, Project::STATUS_PRIZE_SENT])->get(['amount']);
        $aTotalTurnover = [];
        foreach ($aTurnover as $data) {
            $aTotalTurnover[] = $data['amount'];
        }
        $fTotalTurnover = array_sum($aTotalTurnover);
        return $fTotalTurnover;
    }

    protected static function & compileRules($oProject) {
        $rules = self::$rules;
        $rules['coefficient'] = 'required|in:' . implode(',', Coefficient::getValidCoefficientValues());
        if (!$oProject->trace_id) {
            $rules['bought_time'] = 'required|integer|max:' . $oProject->end_time;
        }
        return $rules;
    }

    protected function getUsernameHiddenAttribute() {
        return substr($this->attributes['username'], 0, 2) . '***' . substr($this->attributes['username'], -2);
    }

    protected static function compileListCacheKeyPrefix(){
        return self::getCachePrefix(true) . 'for-user-';
    }
    
    protected static function compileListCacheKey($iUserId = null, $iPage = 1, $iLotteryId=''){
        $sKey = self::compileUserDataListCachePrefix($iUserId, $iLotteryId);
        empty($iPage) or $sKey .= $iPage;
        return $sKey;
    }

    protected static function compileUserDataListCachePrefix($iUserId, $iLotteryId = ''){
        return self::compileListCacheKeyPrefix() . $iUserId . '-' .$iLotteryId;
    }
    
    public function setCommited(){
        $this->updateBuyCommitTime();
        $this->addTurnoverStatTask(true);
        $this->deleteUserDataListCache($this->user_id);
//        $this->updateUserBetList();
    }
    
    public function updateBuyCommitTime() {
        $data = ['bet_commit_time' => Carbon::now()->timestamp];
        if ($bSucc = $this->update($data)) {
            $this->bet_commit_time = $data['bet_commit_time'];
        }
        return $bSucc;
    }

    public function updateUserBetList(){
        $redis = Redis::connection();
        $sKey = self::compileListCacheKey($this->user_id,1);
        $redis->llen($sKey) < $this->maxBetListLength or $redis->ltrim($sKey,0,$this->maxBetListLength - 1);
        $redis->lpush($sKey, json_encode($this->toArray()));
    }

    public static function deleteUserDataListCache($iUserId){
        $sKeyPrifix = self::compileUserDataListCachePrefix($iUserId);
        $redis = Redis::connection();
        if ($aKeys = $redis->keys($sKeyPrifix . '*')){
            foreach($aKeys as $sKey){
                $redis->del($sKey);
            }
        }
    }

    protected function getFormattedCoefficientAttribute() {
        return !is_null($this->coefficient) ?  Coefficient::getCoefficientText($this->coefficient) : '';
    }

}
