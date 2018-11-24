<?php

/**
 * 彩种盈亏表
 *
 * @author white
 */
class LotteryProfit extends BaseModel {
    protected $table = 'lottery_profits';
    public static $resourceName = 'LotteryProfit';
    protected $fillable = [
        'date',
        'lottery_id',
        'prj_count',
        'tester_prj_count',
        'net_prj_count',
        'turnover',
        'prize',
        'profit',
        'commission',
        'tester_turnover',
        'tester_prize',
        'tester_profit',
        'tester_commission',
        'net_turnover',
        'net_prize',
        'net_commission',
        'net_profit',
        'profit_margin',
        'turnover_ratio',
    ];
    public static $rules = [
        'date' => 'required|date',
        'lottery_id' => 'required|integer',
        'prj_count' => 'integer',
        'turnover' => 'numeric',
        'prize' => 'numeric',
        'commission' => 'numeric',
        'profit' => 'numeric',
        'tester_prj_count' => 'integer',
        'tester_turnover' => 'numeric',
        'tester_prize' => 'numeric',
        'tester_commission' => 'numeric',
        'tester_profit' => 'numeric',
        'net_prj_count' => 'integer',
        'net_turnover' => 'numeric',
        'net_prize' => 'numeric',
        'net_commission' => 'numeric',
        'net_profit' => 'numeric',
        'profit_margin' => 'numeric',
        'turnover_ratio' => 'numeric',
        'profit_ratio' => 'numeric',
    ];
    public $orderColumns = [
        'date' => 'desc',
        'turnover_ratio' => 'desc',
        'lottery_id' => 'asc',
    ];
    public static $mainParamColumn = 'date';
    public static $titleColumn = 'date';

    protected function beforeValidate(){
        if (is_null($this->prj_count)){
            $this->prj_count = $this->tester_prj_count = $this->net_prj_count = 0;
        }
    }
    /**
     * 返回对象
     * @param string $sDate
     * @param int       $iLotteryId
     * @return UserProfit
     */
    public static function getProfitObject($sDate,$iLotteryId) {
        $obj = self::where('date', '=', $sDate)->where('lottery_id', '=', $iLotteryId)->get()->first();

        if (!is_object($obj)) {
            $data = [
                'lottery_id' => $iLotteryId,
                'date' => $sDate,
            ];
            $obj = new LotteryProfit($data);
        }
        return $obj;
    }

    /**
     * 累加销售额
     * @param float $fAmount
     * @param boolean $bTester
     * @return boolean
     */
    public function addTurnover($fAmount, $bTester = false) {
        $this->turnover += $fAmount;
        $fAmount > 0 ? $this->prj_count++ : $this->prj_count--;
        if ($bTester){
            $this->tester_turnover += $fAmount;
            $fAmount > 0 ? $this->tester_prj_count++ : $this->tester_prj_count--;
        }
        $this->net_prj_count = $this->prj_count - $this->tester_prj_count;
        $this->calculateProfit($bTester);
        $this->setRatio();
        if (!$bSucc = $this->save()){
            file_put_contents('/tmp/lottery_profit', var_export($this->validationErrors->toArray(),true));
        }
        return $bSucc;
    }

    private function calculateProfit($bTester = false) {
        $this->profit = $this->turnover - $this->prize - $this->commission;
        !$bTester or $this->tester_profit = $this->tester_turnover - $this->tester_prize - $this->tester_commission;
        $this->net_turnover = $this->turnover - $this->tester_turnover;
        $this->net_prize = $this->prize - $this->tester_prize;
        $this->net_commission = $this->commission - $this->tester_commission;
        $this->net_profit = $this->net_turnover - $this->net_prize - $this->net_commission;
//        pr($this->toArray());
        $this->profit_margin = $this->net_turnover ? $this->net_profit / $this->net_turnover : 0;
    }

    /**
     * 累加奖金
     *
     * @param float $fAmount
     * @param boolean $bTester
     * @return boolean
     */
    public function addPrize($fAmount, $bTester = false) {
        $this->prize += $fAmount;
        !$bTester or $this->tester_prize += $fAmount;
        $this->calculateProfit($bTester);
        return $this->save();
    }

    /**
     * 累加团队佣金
     * @param float $fAmount
     * @param boolean $bDirect
     * @return boolean
     */
    public function addCommission($fAmount, $bTester = false) {
        $this->commission += $fAmount;
        !$bTester or $this->tester_commission += $fAmount;
        $this->calculateProfit($bTester);
        return $this->save();
    }

    public static function updateProfitData($sType, $sDate, $iLotteryId, $oUser, $fAmount) {
        $sFunction = 'add' . ucfirst($sType);
        $bSucc = true;
        $oLotteryProfit = self::getProfitObject($sDate, $iLotteryId);
        return $oLotteryProfit->$sFunction($fAmount, $oUser->is_tester);
    }

    public function setRatio($oDailyProfit = null){
        if (is_null($oDailyProfit)){
            $fTurnover = Profit::getTurnoverFromCache($this->date);
        }
        else{
            $fTurnover = $oDailyProfit->net_turnover;
        }
        $this->turnover_ratio = $fTurnover > 0 ? $this->net_turnover / $fTurnover : null;
//        return $this->isDirty('turnover_ratio') ? $this->save() : true ;
    }
}
