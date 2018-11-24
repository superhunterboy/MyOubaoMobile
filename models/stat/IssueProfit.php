<?php

/**
 * 单期盈亏
 *
 * @author white
 */
class IssueProfit extends BaseModel {
    protected $table = 'issue_profits';
    public static $resourceName = 'IssueProfit';
    protected $fillable = [
        'lottery_id',
        'issue',
        'end_time',
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
        'profit_margin'
    ];
    public static $rules = [
        'lottery_id' => 'required|integer',
        'issue'             => 'required|max:15',
        'end_time'          => 'integer',
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
        'profit_margin' => 'numeric|max:1'
    ];
    public $orderColumns = [
        'end_time' => 'desc',
        'lottery_id' => 'asc',
        'issue' => 'desc'
    ];
    public static $mainParamColumn = 'lottery_id';
    public static $titleColumn = 'issue';

    protected function beforeValidate(){
        if (is_null($this->prj_count)){
            $this->prj_count = $this->tester_prj_count = $this->net_prj_count = 0;
        }
    }
    /**
     * 返回IssueProfit对象
     * @param int       $iLotteryId
     * @param string    $sIssue
     * @return UserProfit
     */
    public static function getProfitObject($iLotteryId, $sIssue) {
        $obj = self::where('lottery_id', '=', $iLotteryId)->where('issue', '=', $sIssue)->get()->first();

        if (!is_object($obj)) {
            $oIssue = Issue::getIssue($iLotteryId, $sIssue);
            $data = [
                'lottery_id' => $iLotteryId,
                'issue'      => $sIssue,
                'end_time'   => $oIssue->end_time
            ];
            $obj = new IssueProfit($data);
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
        return $this->save();
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

    public static function updateProfitData($sType, $iLotteryId, $sIssue, $oUser, $fAmount) {
        $sFunction = 'add' . ucfirst($sType);
        $bSucc = true;
        $oIssueProfit = self::getProfitObject($iLotteryId, $sIssue);
        return $oIssueProfit->$sFunction($fAmount, $oUser->is_tester);
    }

}
