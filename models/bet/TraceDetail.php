<?php

class TraceDetail extends BaseModel {
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'trace_details';

    /**
     * 资源名称
     * @var string
     */
    public static $resourceName = 'Trace';

    public static $columnForList = [
        'id',
        'trace_id',
        'lottery_id',
        'issue',
        'end_time',
        'multiple',
        'amount',
        'project_id',
        'amount',
        'prize',
        'status',
        'bought_at',
        'canceled_at',
    ];

    protected $fillable = [
        'user_id',
        'account_id',
        'trace_id',
        'issue',
        'end_time',
        'multiple',
        'project_id',
        'lottery_id',
        'amount',
        'status',
        'bought_at',
        'canceled_at',
    ];

    public static $rules = [
        'user_id'       => 'required|integer',
        'account_id'    => 'required|integer',
        'multiple'      => 'required|integer',
        'issue'         => 'required|max:12',
        'end_time' => 'required|integer',
        'lottery_id'    => 'required|integer',
        'amount'        => 'regex:/^[\d]+(\.[\d]{0,4})?$/',
        'status'        => 'in:0,1,2,3',
        'bought_at'     => 'date_format:Y-m-d H:i:s',
        'canceled_at'   => 'date_format:Y-m-d H:i:s',
    ];

    public $orderColumns = [
        'updated_at' => 'asc'
    ];

    const ERRNO_STATUS_WRONG = -4000;
    const ERRNO_UPDATE_ERROR = -4001;
    // const PAGE_SIZE = 15;

    const STATUS_WAITING         = 0;
    const STATUS_FINISHED        = 1;
    const STATUS_USER_CANCELED   = 2;
    const STATUS_ADMIN_CANCELED  = 3;
    const STATUS_SYSTEM_CANCELED = 4;
    const STATUS_USER_DROPED     = 5;

    public static $validStatuses = [
        self::STATUS_WAITING         => 'Running',
        self::STATUS_FINISHED        => 'Finished',
        self::STATUS_USER_CANCELED   => 'User Canceled',
        self::STATUS_ADMIN_CANCELED  => 'Admin Canceled',
        self::STATUS_SYSTEM_CANCELED => 'System Canceled',
        self::STATUS_USER_DROPED     => 'Droped'
    ];
    public static $cancelStatuses  = [
        self::STATUS_USER_CANCELED,
        self::STATUS_ADMIN_CANCELED,
        self::STATUS_SYSTEM_CANCELED,
    ];
    public static $aHiddenColumns  = [];
    public static $aReadonlyInputs = [];
    public static $ignoreColumnsInView = [];
    public static $ignoreColumnsInEdit = [];
    public static $mainParamColumn = 'user_id';
    public static $titleColumn            = 'serial_number';
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
    public $Trace;

    /**
     * 下拉列表框字段配置
     * @var array
     */
    public static $htmlSelectColumns = [
        'lottery_id' => 'aLotteries',
        'status' => 'aStatuses',
    ];

    protected function beforeValidate()
    {
//        pr($this->getAttributes());
        if (!$this->amount || !$this->user_id || !$this->lottery_id || !$this->issue || !$this->multiple){
            return false;
        }
        if (!$this->account_id){
            $oUser = User::find($this->user_id);
            $this->account_id = $oUser->account_id;
        }
        return parent::beforeValidate();
    }

    protected function setAmountAttribute($fAmount){
        $this->attributes['amount'] = formatNumber($fAmount);
    }

    public function setMultiple($iMultiple){
        $this->attributes['multiple'] = intval($iMultiple);
    }

    protected function getFormattedStatusAttribute(){
        return __('_tracedetail.' . strtolower(Str::slug(static::$validStatuses[ $this->attributes[ 'status' ] ])));
    }

    public static function addDetails($oTrace, & $aDetails, & $aEndTimes){
//        pr($aDetails);
        foreach($aDetails as $sIssue => $iMultiple){
            $aDetail = self::makeDetailData($oTrace, $sIssue, $iMultiple, $aEndTimes[$sIssue]);
            $oTraceDetail = new TraceDetail($aDetail);
            if (!$bSucc = $oTraceDetail->save()){
                pr($oTraceDetail->validationErrors->toArray());
                break;
            }
        }
        return $bSucc;
    }

    private static function makeDetailData($oTrace, $sIssue, $iMultiple, $iEndTime){
        return [
            'trace_id'      => $oTrace->id,
            'lottery_id'    => $oTrace->lottery_id,
            'account_id'    => $oTrace->account_id,
            'user_id'       => $oTrace->user_id,
            'issue'         => $sIssue,
            'end_time' => $iEndTime,
            'multiple'      => $iMultiple,
            'status'        => self::STATUS_WAITING,
            'amount'        => $oTrace->single_amount * $iMultiple
        ];
    }

    /**
     * 完成当期预约的实例化
     *
     * @param Trace $oTrace
     * @param User $oUser
     * @param Account $oAccount
     * @return UserProject|int                  UserProject: Success; -1: 数据错误; -2: 账变保存失败; -3: 账户余额保存失败; -4: 余额不足 -5: 注单保存失败 -6: 佣金数据保存失败 -7: 奖金数据保存失败 -8: 预约状态更新失败
     */
    function generateProject($oTrace, $oUser, $oAccount, & $iErrno, $oBetTime = null){
        if ($this->status != self::STATUS_WAITING){
            $iErrno = self::ERRNO_STATUS_WRONG;
            return false;
        }
        if (!in_array(get_class($oTrace),[ 'ManTrace','UserTrace'])){
            return false;
        }
        $oSeriesWay = SeriesWay::find($oTrace->way_id);
        $oLottery = Lottery::find($oTrace->lottery_id);
        $aOrder                       = [
            'issue' => $this->issue,
            'multiple' => $this->multiple
        ];
        $aAttributes = $this->getAttributes();
        unset($aAttributes['id']);
        $aAttributes['way_id'] = $oTrace->way_id;
        $aAttributes['bet_number'] = $oTrace->bet_number;
        $aAttributes['display_bet_number'] = $oTrace->display_bet_number;
        $aAttributes['coefficient'] = $oTrace->coefficient;
        $aAttributes['single_amount'] = $oTrace->single_amount;
        $aAttributes['way_total_count'] = $oTrace->way_total_count;
        $aAttributes['single_count'] = $oTrace->single_count;
        $aAttributes['bet_rate'] = $oTrace->bet_rate;
        $aAttributes[ 'username' ]     = $oUser->username;
        $aAttributes[ 'user_forefather_ids' ] = $oUser->forefather_ids;
        $aAttributes[ 'account_id' ]          = $oAccount->id;
        $aAttributes['prize_group']           = $oTrace->prize_group;
        $aAttributes['prize_set']             = $oTrace->prize_set;
        $oSeriesWay = SeriesWay::find($oTrace->way_id);
        $oLottery = Lottery::find($this->lottery_id);
//        pr($oTrace->getAttributes());exit;
//        $aAttributes['bet_number'] => $
//        $aAttributes = array_merge($aAttributes, $this->getAttributes());
//        pr($aAttributes);
//        exit;
        if (($iReturn = Transaction::addTransaction($oUser, $oAccount, TransactionType::TYPE_UNFREEZE_FOR_BET, $this->amount, $aAttributes)) != Transaction::ERRNO_CREATE_SUCCESSFUL) {
//            pr($iReturn);
            $iErrno = $iReturn;
            return false;
        }
        $aAttributes['end_time'] = $this->end_time;
        
        $aExtradata = [
            'trace_id' => $this->trace_id,
            'is_tester' => $oUser->is_tester,
            'client_ip' => '127.0.0.1',
            'proxy_ip' => '127.0.0.1'
        ];
        $aProjctInfo = UserProject::compileProjectData($aAttributes,$oSeriesWay,$oLottery,$aExtradata,$oBetTime);
        $oProject = new UserProject($aProjctInfo);
        $oProject->setAccount($oAccount);
        $oProject->setUser($oUser);
        $oProject->setLottery($oLottery);

//        if (($iReturn = $oProject->addProject(false)) == UserProject::ERRNO_BET_SUCCESSFUL){
        if ($bSucc = $oProject->addProject(false, $iErrno)){
            $this->project_id = $oProject->id;
            $this->bought_at = $oProject->bought_at;
            $this->status = self::STATUS_FINISHED;
            if ($bSucc = $this->save()){
                return $oProject;
            }
            else{
                $iErrno = self::ERRNO_UPDATE_ERROR;
            }
            return false;
//            return Trace::ERRNO_PRJ_GERENATED;
        }
        else{
            return false;
//            return Trace::ERRNO_PRJ_GERENATE_FAILED_PRJ_ERROR;
        }
        return $bSucc;
    }

    /**
     * 更新状态为Canceled
     * @param bool $bBySystem if by system, default false
     * @return bool
     */
    public static function setCanceled($bBySystem = false){
        $iToStatus = $bBySystem ? self::STATUS_SYSTEM_CANCELED : self::STATUS_USER_CANCELED;
        return self::setStatus($iToStatus, self::STATUS_WAITING);
    }

    /**
     * 更新状态
     *
     * @param int $iToStatus
     * @param int $iFromStatus
     * @return bool
     */
    protected static function setStatus($iToStatus, $iFromStatus){
        return self::where('id' , '=', $this->id)->where('status', '=', $iFromStatus)->where('status', '<>', $iToStatus)->update(['status' => $iToStatus]);
    }

    /**
     * 更新指定TRACE下的所有预约的状态为Canceled
     *
     * @param int $iTraceId Trace Id
     * @param bool $bBySystem if by system, default false
     * @return bool
     */
    public static function setAllCanceled($iTraceId,$iToStatus){
        $data = [
            'status'      => $iToStatus,
            'canceled_at' => Carbon::now()->toDateTimeString()
        ];
        return self::where('trace_id','=',$iTraceId)->where('status','=',self::STATUS_WAITING)->update($data);
    }

    /**
     * 更新指定TRACE下的所有预约的状态
     *
     * @param int $iTraceId Trace Id
     * @param int $iToStatus
     * @param int $iFromStatus
     * @return bool
     */
    protected static function setAllStatus($iTraceId, $iToStatus, $iFromStatus){
        return self::where('trace_id' , '=', $iTraceId)->where('status', '=', $iFromStatus)->where('status', '<>', $iToStatus)->update(['status' => $iToStatus]);
    }
    /**
     * [getListByTraceId 根据追号记录id以及每页条数, 分页查询追号记录所生成的注单列表]
     * @param  [integer] $iTraceId  [追号记录id]
     * @param  [integer] $iPageSize [每页条数]
     * @return [Object]             [Laravel Collection 数据对象]
     */
    public static function getListByTraceId($iTraceId, $iPageSize = 15)
    {
        $aColumns = ['issue', 'multiple', 'project_id', 'status', 'trace_id'];
        return self::where('trace_id', '=', $iTraceId)->paginate($iPageSize);
    }


    /**
     * 取消某期预约
     * @param int $iType 0：user 1: admin 2: system
     * @return boolean
     */
    public function cancel($iType = 0){
        if ($this->status != self::STATUS_WAITING){
            return false;
        }
        if (!in_array($iType,array_keys(static::$cancelStatuses))){
            return false;
        }
        if ($iNeedRewordAmount = $this->amount){
            $aExtraData               = $this->Trace->getAttributes();
            unset($aExtraData[ 'id' ]);
            $aExtraData[ 'trace_id' ] = $this->trace_id;
            $aExtraData[ 'issue' ]    = $this->issue;
            if (($iReturn                  = Transaction::addTransaction($this->User,$this->Account,TransactionType::TYPE_UNFREEZE_FOR_TRACE,$iNeedRewordAmount,$aExtraData)) != Transaction::ERRNO_CREATE_SUCCESSFUL){
                return false;
            }
        }
        $aConditions = [
            'id'     => ['=',$this->id],
            'status' => ['=',self::STATUS_WAITING],
        ];
        $data = [
            'status'      => static::$cancelStatuses[ $iType ],
            'canceled_at' => Carbon::now()->toDateTimeString()
        ];
        return self::where('id','=',$this->id)->where('status','=',self::STATUS_WAITING)->update($data) > 0;
    }

    public static function getUnGenerateDetailCount($iLotteryId,$sIssue){
        return self::where('lottery_id','=',$iLotteryId)->where('issue','=',$sIssue)->where('status','=',self::STATUS_WAITING)->get(['id'])->count();
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
    
    public function setTrace($oTrace){
        $this->Trace = $oTrace;
    }

}