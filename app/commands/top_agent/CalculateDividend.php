<?php

/**
 * 计算总代分红
 */
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class CalculateDividend extends BaseCommand {

    protected $name = 'dividend:calculate';
    protected $description = 'calculate dividends for top agent';

    public function doCommand(& $sMsg = null) {
        $this->writeLog('start command');
        $iCurrentDay = date('d');
        if ($iCurrentDay >= 1 && $iCurrentDay < 16) {
            $sFirstday = date('Y-m-01');
            $sBeginDate = date('Y-m-01', strtotime('-1 month'));
            $sEndDate = date('Y-m-d', strtotime("$sFirstday -1 day"));
        } else if ($iCurrentDay >= 16 && $iCurrentDay <= 31) {
            $sBeginDate = date('Y-m-01');
            $sEndDate = date('Y-m-15');
        }
        $this->writeLog('calculate beginDate=' . $sBeginDate . ', endDate=' . $sEndDate);

        $aTeamProfits = TeamProfit::getTopAgentProfitByDate($sBeginDate, $sEndDate);
        DB::connection()->beginTransaction();
        $bSucc = false;
        foreach ($aTeamProfits as $oTeamProfit) {
            if ($oTeamProfit->total_profit >= 0) {
                continue;
            }
            $oOldDividend = Dividend::getDividendByMonthUser($oTeamProfit->user_id, $sBeginDate, $sEndDate);
            if (is_object($oOldDividend)) {
                continue;
            }
            $fAbsProfit = abs($oTeamProfit->total_profit);
            $oDividendRule = DividendRule::getRuleObjectByProfit($oTeamProfit->total_turnover);
            $fDividend = $oDividendRule->rate * $fAbsProfit;
            $bSucc = $this->_createDividend($oTeamProfit, $oDividendRule, $fDividend, $sBeginDate, $sEndDate);
            if (!$bSucc) {
                break;
            }
        }
        if ($bSucc) {
            DB::connection()->commit();
        } else {
            DB::connection()->rollback();
        }
    }

    private function _createDividend($oTeamProfit, $oDividendRule, $fDividend, $sBeginDate, $sEndDate) {
        $oDividend = new Dividend;
        $oDividend->year = date('Y');
        $oDividend->month = date('m');
        $oDividend->begin_date = $sBeginDate;
        $oDividend->end_date = $sEndDate;
        $oDividend->user_id = $oTeamProfit->user_id;
        $oDividend->username = $oTeamProfit->username;
        $oDividend->is_tester = $oTeamProfit->is_tester;
        $oDividend->turnover = $oTeamProfit->total_turnover;
        $oDividend->prize = $oTeamProfit->total_prize;
        $oDividend->profit = $oTeamProfit->total_profit;
        $oDividend->bonus = $oTeamProfit->total_bonus;
        $oDividend->rate = $oDividendRule->rate;
        $oDividend->amount = $fDividend;
        $oDividend->status = Dividend::STATUS_WAITING_AUDIT;
        return $oDividend->save();
    }

}
