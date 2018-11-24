<?php

/**
 * 用户盈亏表
 *
 * @author white
 */
class UserMonthProfit extends BaseModel {

    protected $table = 'user_month_profits';
    public static $resourceName = 'UserMonthProfit';
    public static $amountAccuracy    = 6;
    public static $htmlNumberColumns = [
        'deposit'           => 2,
        'withdrawal'        => 2,
        'turnover' => 4,
        'prize' => 4,
        'profit'            => 6,
        'commission'        => 6,
    ];
    public static $columnForList = [
        'year',
        'month',
        'username',
        'is_tester',
        'user_type',
        'parent_user',
        'prize_group',
        'deposit',
        'withdrawal',
        'turnover',
        'prize',
        'bonus',
        'commission',
        'profit',
    ];

    public static $totalColumns = [
        'deposit',
        'withdrawal',
        'turnover',
        'prize',
        'bonus',
        'commission',
        'profit',
    ];

    public static $listColumnMaps = [
        'user_type' => 'user_type_formatted',
        'turnover' => 'turnover_formatted',
        'prize' => 'prize_formatted',
        'bonus' => 'bonus_formatted',
        'commission' => 'commission_formatted',
        'profit' => 'profit_formatted',
    ];
    protected $fillable = [
        'year',
        'month',
        'user_id',
        'is_agent',
        'is_tester',
        'prize_group',
        'user_level',
        'username',
        'parent_user_id',
        'parent_user',
        'deposit',
        'withdrawal',
        'turnover',
        'prize',
        'bonus',
        'commission',
        'profit',
    ];
    public static $rules = [
        'year' => 'required|integer|min:2014|max:2050',
        'month' => 'required|integer|min:1|max:12',
        'user_id' => 'required|integer',
        'is_agent ' => 'in:0,1',
        'prize_group' => 'integer',
        'user_level' => 'required|min:0|max:2',
        'username' => 'required|max:16',
        'parent_user_id' => 'integer',
        'parent_user' => 'max:16',
        'deposit' => 'numeric|min:0',
        'withdrawal' => 'numeric|min:0',
        'turnover' => 'numeric',
        'prize' => 'numeric',
        'bonus' => 'numeric',
        'profit' => 'numeric',
        'commission' => 'numeric',
    ];
    public $orderColumns = [
        'year' => 'desc',
        'month' => 'desc',
        'turnover' => 'desc',
    ];
    public static $mainParamColumn = 'user_id';
    public static $titleColumn = 'username';
    public static $aUserTypes = ['-1' => 'Top Agent', '0' => 'Agent'];

    // 按钮指向的链接，查询列名和实际参数来源的列名的映射
    // public static $aButtonParamMap = ['parent_user_id' => 'user_id'];

    /**
     * 返回UserProfit对象
     *
     * @param string $sDate
     * @param string $iUserId
     * @return UserProfit
     */
    public static function getUserMonthProfitObject($iYear, $iMonth, $iUserId) {
        $obj = self::where('user_id', '=', $iUserId)->where('year', '=', $iYear)->where('month','=',$iMonth)->get()->first();
        $oUser = User::find($iUserId);
        if (!is_object($obj)) {
//            $oUser = User::find($iUserId);
//            pr($oUser->toArray());
//            pr($oUser->toArray());
            $data = [
                'user_id' => $oUser->id,
                'is_agent' => $oUser->is_agent,
                'is_tester' => $oUser->is_tester,
                'prize_group' => $oUser->prize_group,
                'user_level' => $oUser->user_level,
                'username' => $oUser->username,
                'parent_user_id' => $oUser->parent_id,
                'parent_user' => $oUser->parent,
                'year' => $iYear,
                'month' => $iMonth,
            ];
            $obj = new UserMonthProfit($data);
        } else {
            $obj->user_level = $oUser->user_level;
            $obj->prize_group = $oUser->prize_group;
        }
//        pr($obj->toArray());
//        exit;
        return $obj;
    }

    /**
     * 返回包含直接销售额，直接盈亏记录和团队销售额的数组
     *
     * @param string $sDate     只有年和月,格式：2014-01-01
     * @param string $iUserId   用户id
     * @return array
     */
    public static function getUserProfitByDate($sBeginDate, $sEndDate, $iUserId) {
        $oQuery = self::where('user_id', '=', $iUserId);
        if (!is_null($sBeginDate)) {
            $oQuery->where('date', '>=', $sBeginDate);
        }
        if (!is_null($sEndDate)) {
            $oQuery->where('date', '<=', $sEndDate);
        }
        $aUserProfits = $oQuery->get(['team_turnover', 'turnover', 'profit']);
        $data = [];
        $i = 0;
        foreach ($aUserProfits as $oUserProfit) {
            $data[$i]['team_turnover'] = $oUserProfit->team_turnover;
            $data[$i]['turnover'] = $oUserProfit->turnover;
            $data[$i]['profit'] = $oUserProfit->profit;
            $i++;
        }
        return $data;
    }

    /**
     * 获取指定用户的销售总额
     * @param int $iUserId  用户id
     * @return float        销售总额
     */
    public static function getUserTotalTurnover($sBeginDate, $sEndDate, $iUserId) {
        $aUserProfits = self::getUserProfitByDate($sBeginDate, $sEndDate, $iUserId);
        $aTurnovers = [];
        foreach ($aUserProfits as $data) {
            $aTurnovers[] = $data['turnover'];
        }
        $fTotalTurnover = array_sum($aTurnovers);
        return $fTotalTurnover;
    }

    /**
     * 获取指定用户用户盈亏
     * @param int $iUserId  用户id
     * @return float        用户盈亏
     */
    public static function getUserTotalProfit($sBeginDate, $sEndDate, $iUserId) {
        $aUserProfits = self::getUserProfitByDate($sBeginDate, $sEndDate, $iUserId);
        $aProfits = [];
        foreach ($aUserProfits as $data) {
            $aProfits[] = $data['profit'];
        }
        $fTotalProfit = array_sum($aProfits);
        return $fTotalProfit;
    }

    /**
     * 累加充值额
     * @param float $fAmount
     * @return boolean
     */
    public function addDeposit($fAmount) {
        $this->deposit += $fAmount;
        return $this->save();
    }

    /**
     * 累加提现额
     * @param float $fAmount
     * @return boolean
     */
    public function addWithdrawal($fAmount) {
        $this->withdrawal += $fAmount;
        return $this->save();
    }

    /**
     * 累加个人销售额
     * @param float $fAmount
     * @return boolean
     */
    public function addTurnover($fAmount) {
        $this->turnover += $fAmount;
        $this->profit = $this->countProfit();
        return $this->save();
    }

    /**
     * 累加奖金
     *
     * @param float $fAmount
     * @return boolean
     */
    public function addPrize($fAmount) {
        $this->prize += $fAmount;
        $this->profit = $this->countProfit();
        return $this->save();
    }

    /**
     * 累加促销奖金
     *
     * @param float $fAmount
     * @return boolean
     */
    public function addBonus($fAmount) {
        $this->bonus += $fAmount;
        $this->profit = $this->countProfit();
        return $this->save();
    }

    public function countProfit(){
        return $this->prize + $this->bonus + $this->commission - $this->turnover;
    }

    /**
     * 累加个人佣金
     * @param float $fAmount
     * @return boolean
     */
    public function addCommission($fAmount) {
        $this->commission += $fAmount;
        $this->profit = $this->countProfit();
        return $this->save();
    }

    public static function & comipleTurnover($oUser, $fAmount) {
        $aForeFathers = explode(',', $oUser->forefather_ids);
        $aTurnovers = [];
        foreach ($aForeFathers as $iForeFatherId) {
            $aTurnovers[$iForeFatherId] = $fAmount;
        }
        $aTurnovers[$oUser->id] = $fAmount;
        return $aTurnovers;
    }

    public static function updateTurnOver($sDate, $oUser, $fAmount) {
        return self::updateProfitData('turnover', $sDate, $oUser, $fAmount);
    }

    public static function updatePrize($sDate, $oUser, $fAmount) {
        return self::updateProfitData('prize', $sDate, $oUser, $fAmount);
    }

    public static function updateBonus($sDate, $oUser, $fAmount) {
        return self::updateProfitData('bonus', $sDate, $oUser, $fAmount);
    }

    public static function updateCommission($sDate, $oUser, $fAmount) {
        return self::updateProfitData('commission', $sDate, $oUser, $fAmount);
    }

    public static function updateProfitData($sType, $sDate, $oUser, $fAmount) {
        $sFunction = 'add' . ucfirst($sType);
        $oProfit = self::getUserProfitObject($sDate, $oUser->id);
//            pr($oUserProfit->validationErrors->toArray());
        $bSucc = $oProfit->$sFunction($fAmount);
//        pr($bSucc);
        return $bSucc;
    }

    public static function clearProfitData($sDate, $oUser){
        $oProfit = self::getUserProfitObject($sDate, $oUser->id);
        if ($oProfit->id){
            $oProfit->deposit = $oProfit->withdrawal = $oProfit->turnover = $oProfit->prize = $oProfit->bonus - $oProfit->commission = $oProfit->profit = 0;
            $oProfit->save();
        }
    }
    // protected function getUserTypeFormattedAttribute() {
    //     // return static::$aUserTypes[($this->parent_user_id != null ? 'not_null' : 'null')];
    //     return __('_userprofit.' . strtolower(static::$aUserTypes[intval($this->parent_user_id != null) - 1]));
    // }

    protected function getUserTypeFormattedAttribute() {
        if ($this->parent_user_id)
            $sUserType = User::$aUserTypes[$this->is_agent];
        else
            $sUserType = User::$aUserTypes[User::TYPE_TOP_AGENT];
        return __('_user.' . $sUserType);
    }

    protected function getDepositFormattedAttribute() {
        return $this->getFormattedNumberForHtml('deposit');
    }

    protected function getWithdrawalFormattedAttribute() {
        return $this->getFormattedNumberForHtml('withdrawal');
    }

    protected function getTurnoverFormattedAttribute() {
        return $this->getFormattedNumberForHtml('turnover');
    }

    protected function getPrizeFormattedAttribute() {
        return $this->getFormattedNumberForHtml('prize');
    }

    protected function getBonusFormattedAttribute() {
        return $this->getFormattedNumberForHtml('bonus');
    }

    protected function getCommissionFormattedAttribute() {
        return $this->getFormattedNumberForHtml('commission');
    }

    protected function getProfitFormattedAttribute() {
        return $this->getFormattedNumberForHtml('profit');
    }

}