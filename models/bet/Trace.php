<?php
use Illuminate\Support\Facades\Redis;

class Trace extends BaseModel {
    protected static $cacheLevel = self::CACHE_LEVEL_FIRST;
    protected $table = 'traces';

    /**
     * 资源名称
     * @var string
     */
    public static $resourceName = 'Trace';
    public static $amountAccuracy    = 4;
    public static $htmlNumberColumns = [
        'amount' => 2,
        'finished_amount' => 2,
        'canceled_amount' => 2,
        'prize'           => 4
    ];
    public static $columnForList     = [
        'id',
        'serial_number',
        'username',
        'lottery_id',
        'total_issues',
        'title',
        'bet_number',
        'coefficient',
        'amount',
        'prize',
        'status',
        'ip',
        'bought_at',
    ];
    public static $listColumnMaps    = [
        'serial_number' => 'serial_number_short',
        'status'        => 'formatted_status',
    ];
    public static $viewColumnMaps    = [
        'serial_number' => 'serial_number_short',
        'status'        => 'formatted_status',
        'stop_on_won'        => 'stop_on_won_formatted',
    ];
    protected $fillable = [
        'user_id',
        'username',
        'user_forefather_ids',
        'account_id',
        'prize_group',
        'prize_set',
        'prize_group',
        'total_issues',
        'finished_issues',
        'canceled_issues',
        'stop_on_won',
        'lottery_id',
        'way_id',
        'title',
        'way_total_count',
        'single_count',
        'bet_rate',
        'bet_number',
        'display_bet_number',
        'start_issue',
        'won_issue',
        'prize',
        'won_count',
        'coefficient',
        'single_amount',
        'amount',
        'finished_amount',
        'canceled_amount',
        'status',
        'ip',
        'proxy_ip',
        'bought_at',
        'canceled_at',
        'stoped_at',
    ];

    public static $rules = [
        'user_id'       => 'required|integer',
        'account_id'    => 'required|integer',
        'serial_number' => 'required|max:32',
        'user_forefather_ids'    => 'max:1024',
        'title'         => 'required|max:100',
        'bet_number'    => 'required',
        'note'          => 'max:250',
        'lottery_id'    => 'required|integer',
        'way_id'        => 'required|integer',
        'prize_added'   => 'numeric',
        'coefficient' => 'required|in:1.00,0.50,0.10,0.01',
        'single_amount' => 'regex:/^[\d]+(\.[\d]{0,4})?$/',
        'amount'        => 'regex:/^[\d]+(\.[\d]{0,4})?$/',
        'status'        => 'in:0,1,2,3',
        'ip'            => 'required|ip',
        'proxy_ip'      => 'required|ip',
        'bought_at'     => 'date_format:Y-m-d H:i:s',
        'way_total_count' => 'integer',
        'bet_count' => 'integer',
        'bet_rate' => 'numeric',
    ];
    public $orderColumns = [
        'id' => 'desc'
    ];

    const STATUS_RUNNING = 0;
    const STATUS_FINISHED = 1;
    const STATUS_USER_STOPED = 2;
    const STATUS_ADMIN_STOPED  = 3;
    const STATUS_SYSTEM_STOPED = 4;

    public static $validStatuses = [
        self::STATUS_RUNNING => 'Running',
        self::STATUS_FINISHED => 'Finished',
        self::STATUS_USER_STOPED => 'User Stoped',
        self::STATUS_ADMIN_STOPED  => 'Admin Stoped',
        self::STATUS_SYSTEM_STOPED => 'System Stoped'
    ];
    public static $cancelStatuses = [
        self::STATUS_USER_STOPED,
        self::STATUS_ADMIN_STOPED,
        self::STATUS_SYSTEM_STOPED,
    ];
    public static $aHiddenColumns = [];
    public static $aReadonlyInputs = [];
    public static $ignoreColumnsInView = [];
    public static $ignoreColumnsInEdit = [];
    public static $mainParamColumn = 'user_id';
    public static $titleColumn = 'serial_number';

    /**
     * 下拉列表框字段配置
     * @var array
     */
    public static $htmlSelectColumns = [
        'lottery_id' => 'aLotteries',
        'status' => 'aStatuses',
        'coefficient' => 'aCoefficients',
    ];

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

    const ERRNO_TRACE_SAVE_SUCCESSFUL          = -300;
    const ERRNO_TRACE_MISSING                  = -301;
    const ERRNO_TRACE_DETAIL_SAVED             = -302;
    const ERRNO_TRACE_DETAIL_SAVE_FAILED       = -303;
    const ERRNO_TRACE_ERROR_SAVE_ERROR         = -310;
    const ERRNO_TRACE_ERROR_DATA_ERROR         = -320;
    const ERRNO_TRACE_ERROR_LOW_BALANCE        = Project::ERRNO_BET_ERROR_LOW_BALANCE;
    const ERRNO_STOP_SUCCESS                    = -330;
    const ERRNO_STOP_ERROR_STATUS              = -331;
    const ERRNO_STOP_ERROR_NOT_YOURS           = -332;
    const ERRNO_STOP_ERROR_STATUS_UPDATE_ERROR = -333;
    const ERRNO_STOP_ERROR_DETAIL_CANCEL_FAILED = -334;
    const ERRNO_DETAIL_CANCELED                 = -335;
    const ERRNO_DETAIL_CANCEL_FAILED            = -336;
    const ERRNO_PRJ_GERENATED                   = -340;
    const ERRNO_PRJ_GERENATE_FAILED_NO_DETAIL   = -341;
    const ERRNO_PRJ_GERENATE_FAILED_PRJ_ERROR   = -342;

    protected function setStopOnWonAttribute($bool){
        $this->attributes[ 'stop_on_won' ] = intval((bool) $bool);
    }

    protected function afterUpdate(){
        parent::afterUpdate();
        $this->deleteUserDataListCache();
    }
    
    protected function beforeValidate()
    {
        if (!$this->single_amount || !$this->amount || !$this->user_id || !$this->lottery_id || !$this->total_issues || !$this->way_id || !$this->coefficient){
            pr('data-error');
            return false;
        }
        if (!$this->user_forefather_ids || !$this->account_id){
            $oUser = User::find($this->user_id);
            $this->user_forefather_ids = $oUser->forefather_ids;
            $this->account_id = $oUser->account_id;
        }
        $this->serial_number or $this->serial_number = self::makeSeriesNumber($this->user_id);
        return parent::beforeValidate();
    }

    /**
     * check Trace data
     * @return boolean
     */
    public function checkTrace(){
        //todo:
        return true;
    }

    /**
     * save prize setting of this project
     * @return boolean
     */
    protected function savePrizeSettings(){
        //todo:
        return true;
    }

    /**
     * save prize saveCommissions of this project
     * @return boolean
     */
    protected function saveCommissions(){
        //todo:
        return true;
    }

    /**
     * set status to counted
     *
     * @param decimal $fPrize
     * @return boolean
     */
    protected function setPrizeCounted($fPrize){
        //todo:
        return true;
    }

    /**
     * set prize status to finished
     * @return boolean
     */
    protected function setPrized(){
        return true;
    }

    protected function setSingleAmountAttribute($fAmount){
        $this->attributes[ 'single_amount' ] = formatNumber($fAmount,static::$amountAccuracy);
    }

    protected function setAmountAttribute($fAmount){
        $this->attributes[ 'amount' ] = formatNumber($fAmount,static::$amountAccuracy);
    }

    protected function setTotalIssuesAttribute($iCount){
        $this->attributes['total_issues']= intval($iCount);
    }

    protected function setCoefficientAttribute($fCoefficient){
        $aCoefficient = Coefficient::getValidCoefficientValues();
//        $aCoefficient = Config::get('bet.coefficients');
        $fCoefficient = formatNumber($fCoefficient, 4);
        if (!in_array($fCoefficient, $aCoefficient)){
            return false;
        }
        return $this->attributes['coefficient'] = $fCoefficient;
    }

    protected function setSerialNumberAttribute($sSerialNumber){
        $this->attributes[ 'serial_number' ] = strtoupper($sSerialNumber);
    }

    protected function getSerialNumberShortAttribute(){
        return substr($this->attributes[ 'serial_number' ], -6);
    }

    protected function getAmountFormattedAttribute() {
        return $this->getFormattedNumberForHtml('amount');
    }

    protected function getStopOnWonFormattedAttribute() {
        return __('_basic.' . strtolower(Config::get('var.boolean')[$this->attributes['stop_on_won']]));
    }

    protected function getFinishedAmountFormattedAttribute() {
        return $this->getFormattedNumberForHtml('finished_amount');
    }

    protected function getCanceledAmountFormattedAttribute() {
        return $this->getFormattedNumberForHtml('canceled_amount');
    }
    /**
     * after save, need save prize and commission settings
     * @param project $oSavedModel
     */
    protected function afterSave($oSavedModel) {
        parent::afterSave($oSavedModel);
        $oSavedModel->deleteUserDataListCache();
    }

   /**
     * 生成序列号
     * @param int $iUserId
     * @return string
     */
   public static function makeSeriesNumber($iUserId){
        return uniqid($iUserId,true);
//        return md5($iUserId . microtime(true) . mt_rand());
    }

    /**
     * 获取预约清单
     * @param int $iStatus
     * @return Collection|TraceDetail
     */
    public function getDetails($sBeginIssue = null, $iStatus = null, $iCount = -1){
        $oQuery = TraceDetail::where('trace_id', '=', $this->id);
        !$sBeginIssue or $oQuery = $oQuery->where('issue' , '>=', $sBeginIssue);
        is_null($iStatus) or $oQuery = $oQuery->where('status','=',$iStatus);
        $oQuery = $oQuery->orderby('issue','asc');
        $iCount < 0 or $oQuery = $oQuery->limit($iCount);
        return $oQuery->get();
    }

    public function getNextIssue(){
        $oDetails = $this->getDetails(null,TraceDetail::STATUS_WAITING,1);
        return $oDetails->count() ? $oDetails->first()->issue : false;
    }

    /**
     * 将指定奖期的预约实例化
     *
     * @param string $sIssue
     * @return Project|int Project: Success; -1: 数据错误; -2: 账变保存失败; -3: 账户余额保存失败; -4: 余额不足 -5: 注单保存失败 -6: 佣金数据保存失败 -7: 奖金数据保存失败 -8: 预约状态更新失败; -11: 无符合条件的预约 -12: trace info update fail
     */
    public function generateProjectOfIssue($sIssue = null, & $iErrno, $oBetTime = null){
        $oDetails = $this->getDetails($sIssue,TraceDetail::STATUS_WAITING,1);
//        pr($oDetails->toArray());
//        exit;
        if ($oDetails->count()){
            $oDetail = $oDetails[ 0 ];
//            pr($oDetail->toArray());
//            exit;
            if ($oProject = $oDetail->generateProject($this,$this->User,$this->Account, $iErrno, $oBetTime)){
//            if (is_object($mReturn)){
//                $oProject = $mReturn;
//                $this->finished_issues ++;
//                $this->finished_amount += $oProject->amount;
//                if ($this->finished_issues + $this->canceled_issues == $this->total_issues){
////                    $this->setFinished();
//                    $this->status = self::STATUS_FINISHED;
//                }
                if ($bSucc = $this->updateFinishedInformation(1,$oProject->amount, $iErrno)){
//                if ($this->save()){
                    return $oProject;
                }
//                $iErrno = self::ERRNO_TRACE_ERROR_SAVE_ERROR;
//                return self::ERRNO_TRACE_ERROR_SAVE_ERROR;
            }
            else{
                $bSucc = false;
            }
            return $bSucc;
        }
        $iErrno = self::ERRNO_PRJ_GERENATE_FAILED_NO_DETAIL;
        return true;
    }

    /**
     * 更新状态为撤单
     * @return int 0: success; -1 to -3: return of Transaction::addTransaction; -4: Cancel details error; -5: change status fail
     */
    public function terminate($iType = 0){
        if ($this->status != self::STATUS_RUNNING){
            return false;
        }
        if (!in_array($iType,array_keys(static::$cancelStatuses))){
            return false;
        }
        $iToStatus         = static::$cancelStatuses[ $iType ];
        // refund
        if ($iNeedRewordAmount = $this->amount - $this->finished_amount - $this->canceled_amount){
            $aExtraData             = $this->getAttributes();
            unset($aExtraData[ 'id' ]);
            $aExtraData[ 'trace_id' ] = $this->id;
            if (($iReturn                  = Transaction::addTransaction($this->User,$this->Account,TransactionType::TYPE_UNFREEZE_FOR_TRACE,$iNeedRewordAmount,$aExtraData)) != Transaction::ERRNO_CREATE_SUCCESSFUL){
                return $iReturn;
            }
        }

        // cancel details
        if (!TraceDetail::setAllCanceled($this->id,$iToStatus)){
            return self::ERRNO_STOP_ERROR_DETAIL_CANCEL_FAILED;
        }
        $aExtraData            = [
            'canceled_issues' => $iCanceledIssues  = $this->total_issues - $this->finished_issues,
            'canceled_amount' => $fCanceledAmount  = $this->amount - $this->finished_amount,
            'stoped_at'       => $dStopdAt         = Carbon::now()->toDateTimeString()
        ];
        // set status
        if (!$this->setStatus($iToStatus,self::STATUS_RUNNING,$aExtraData)){
            return self::ERRNO_TRACE_ERROR_SAVE_ERROR;
        }
        $this->status          = $iToStatus;
        $this->canceled_issues = $iCanceledIssues;
        $this->canceled_amount = $fCanceledAmount;
        $this->stoped_at       = $dStopdAt;
        return true;
    }

    /**
     * 更新状态
     *
     * @param int $iToStatus
     * @param int $iFromStatus
     * @return int  0: success; -1: prize set cancel fail; -2: commissions cancel fail
     */
    protected function setStatus($iToStatus,$iFromStatus,$aExtraData = null){
        $aConditions = [
            'id'     => ['=',$this->id],
            'status' => ['=',$iFromStatus]
        ];
        $data = [
            'status' => $iToStatus,
        ];
        empty($aExtraData) or $data        = array_merge($data,$aExtraData);
        return $this->strictUpdate($aConditions, $data);
//        return self::doWhere($aConditions)->update($data) > 0;
    }

    /**
     * set Account Model
     * @param Account $oAccount
     */
    public function setAccount($oAccount){
        $this->Account = $oAccount;
    }

    /**
     * set User Model
     * @param User $oUser
     */
    public function setUser($oUser){
        $this->User = $oUser;
    }

    protected function getFormattedStatusAttribute(){
        return __('_trace.' . strtolower(Str::slug(static::$validStatuses[ $this->attributes[ 'status' ] ])));
    }

//    protected function getFormattedAmountAttribute(){
//        return number_format($this->attributes[ 'amount' ],4);
//    }
//
//    protected function getFormattedFinishedAmountAttribute(){
//        return number_format($this->attributes[ 'finished_amount' ],4);
//    }
//
//    protected function getFormattedCanceledAmountAttribute(){
//        return number_format($this->attributes[ 'canceled_amount' ],4);
//    }

    protected function getFormattedStopOnWonAttribute(){
        return __('_basic.' . strtolower(Config::get('var.boolean')[ $this->attributes[ 'stop_on_won' ] ]));
    }

    /**
     * 取消预约
     * @param array $aDetailIds
     * @return boolean
     */
    public function cancelDetail($aDetailIds){
        is_array($aDetailIds) or $aDetailIds = [$aDetailIds];
        if (empty($aDetailIds)){
            return false;
        }
        $bSucc           = false;
        $iCanceledIssues = $fCanceledAmount = 0;
        foreach ($aDetailIds as $iDetailId){
            $oDetail = TraceDetail::find($iDetailId);
            if ($this->status != TraceDetail::STATUS_WAITING){
                return false;
            }
            $oIssue  = Issue::getIssue($this->lottery_id, $oDetail->issue);
            if (time() > $oIssue->end_time) {
                return false;
            }
            if ($oDetail->trace_id != $this->id) {
                return false;
            }
            $oDetail->setAccount($this->Account);
            $oDetail->setUser($this->User);
            $oDetail->setTrace($this);
            if (!$bSucc = $oDetail->cancel(0)){
                break;
            }
            $iCanceledIssues ++;
            $fCanceledAmount += $oDetail->amount;
        }
        if ($bSucc = $bSucc && $this->updateCanceledInformation($iCanceledIssues,$fCanceledAmount)){
//            if ($this->finished_issues + $this->canceled_issues == $this->total_issues){
//                $bSucc = $this->setFinished();
//            }
        }
        return $bSucc ? self::ERRNO_DETAIL_CANCELED : self::ERRNO_DETAIL_CANCEL_FAILED;
    }

    public function setFinished($bByCancel = false) {
        $aConditions = [
            'id'     => [ '=',$this->id],
            'status' => [ '=',self::STATUS_RUNNING]
        ];
        $data = [
            'status' => $bByCancel ? self::STATUS_USER_STOPED : self::STATUS_FINISHED
        ];
//        if ($bSucc = $this->doWhere($aConditions)->update($data) > 0){
        if ($bSucc = $this->strictUpdate($aConditions, $data)){
            $this->status = self::STATUS_FINISHED;
        }
        return $bSucc;
    }

    public function updateFinishedInformation($iIncrementCount,$fIncrementAmount, & $iErrno){
        if ($iIncrementCount <= 0 || $fIncrementAmount <= 0){
            $iErrno = self::ERRNO_TRACE_ERROR_DATA_ERROR;
            return false;
        }
        $aConditions = [
            'id'     => [ '=',$this->id],
            'status' => [ '=',self::STATUS_RUNNING]
        ];
        $data = [
            'finished_issues'    => $iFinishedIssueCount = $this->finished_issues + $iIncrementCount,
            'finished_amount'    => $fFinishedAmount     = $this->finished_amount + $fIncrementAmount,
        ];
        file_put_contents('/tmp/trace-update-' . $this->id, var_export($data,true) . "\n");
        if ($bSucc = $this->strictUpdate($aConditions, $data)){
//        if ($bSucc       = $this->doWhere($aConditions)->update($data) > 0){
//            $this->afterUpdate();
//        if ($bSucc = $this->update($data)){
            file_put_contents('/tmp/trace-update-' . $this->id, 'update finished_amount:' . "\n", FILE_APPEND);
            file_put_contents('/tmp/trace-update-' . $this->id, var_export($bSucc,true) . "\n", FILE_APPEND);
            if ($iFinishedIssueCount + $this->canceled_issues == $this->total_issues){
                $bSucc = $this->setFinished();
            }
        }
        else {
            file_put_contents('/tmp/trace-update-' . $this->id, var_export($this->validationErrors->toArray(),true));
            $iErrno = self::ERRNO_TRACE_DETAIL_SAVE_FAILED;
        }
        file_put_contents('/tmp/trace-update-' . $this->id, var_export($bSucc,true) . "\n", FILE_APPEND);
        if ($bSucc){
            $this->finished_issues = $iFinishedIssueCount;
            $this->finished_amount = $fFinishedAmount;
        }
        return $bSucc;
    }

    function updateCanceledInformation($iDecrementCount,$fDecrementAmount){
        if ($iDecrementCount <= 0 || $fDecrementAmount <= 0){
            return false;
        }
        $aConditions = [
            'id'     => [ '=',$this->id],
            'status' => [ '=',self::STATUS_RUNNING]
        ];
        $data        = [
            'canceled_issues'    => $iCanceledIssueCount = $this->canceled_issues + $iDecrementCount,
            'canceled_amount'    => $fCanceledAmount     = $this->canceled_amount + $fDecrementAmount,
        ];
        if ($bSucc       = $this->strictUpdate($aConditions, $data)){
            if ($iCanceledIssueCount + $this->finished_issues == $this->total_issues) {
                $bSucc = $this->setFinished(true);
            }
        }
        if ($bSucc){
            $this->canceled_issues = $iCanceledIssueCount;
            $this->canceled_issues = $fCanceledAmount;
        }
        return $bSucc;
    }

    protected static function & compileRules(){
        $rules = self::$rules;
        $rules['coefficient'] = 'required|in:' . implode(',',Coefficient::getValidCoefficientValues());
        return $rules;
    }

    protected static function compileListCacheKeyPrefix(){
        return self::getCachePrefix(true) . 'for-user-';
    }
    
    protected static function compileListCacheKey($iUserId = null, $iPage = 1){
        $sKey = self::compileUserDataListCachePrefix($iUserId);
        empty($iPage) or $sKey .= $iPage;
        return $sKey;
    }

    protected static function compileUserDataListCachePrefix($iUserId){
        return self::compileListCacheKeyPrefix() . $iUserId . '-';
    }

    public function deleteUserDataListCache(){
        $sKeyPrifix = self::compileUserDataListCachePrefix($this->user_id);
        $redis = Redis::connection();
        if ($aKeys = $redis->keys($sKeyPrifix . '*')){
            foreach($aKeys as $sKey){
                $redis->del($sKey);
            }
        }
    }

}
