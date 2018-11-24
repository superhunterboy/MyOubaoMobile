<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class CalculateDailySalary extends BaseCommand {

    protected $name = 'daily-salary:calculate';
    protected $description = 'calculate daily salary for top agent';

    public function doCommand(& $sMsg = null) {
        $this->writeLog('start command');
        $sBeginDate = $sEndDate = date('Y-m-d', strtotime('-1 day'));
//        $sBeginDate = $sEndDate = '2015-06-23';
        $this->writeLog('calculate date=' . $sBeginDate);
        $aTeamProfits = TeamProfit::getTopAgentProfitByDate($sBeginDate, $sEndDate);
        DB::connection()->beginTransaction();
        $bSucc = false;
        foreach ($aTeamProfits as $oTeamProfit) {
            $this->writeLog('username=' . $oTeamProfit->username . ', total_turnover=' . $oTeamProfit->total_turnover);
            if ($oTeamProfit->total_turnover < 50000) {
                continue;
            }
            $fBonus = $this->getBonus($oTeamProfit->total_turnover);
            $this->writeLog('bonus=' . $fBonus);

            if ($fBonus == 0) {
                continue;
            }
            $oReportDailySalary = ActivityReportDailySalaryTopAgent::getObjectByParams(['user_id' => $oTeamProfit->user_id, 'rebate_date' => $sBeginDate]);
            if (is_object($oReportDailySalary)) {
                continue;
            }
            $bSucc = $this->createUserPrize($fBonus, $oTeamProfit);
            !$bSucc or $bSucc = $this->createReportDailySalary($fBonus, $oTeamProfit, $sBeginDate);
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

    public function getBonus($fTurnover) {
        $sExp = $this->getExpression($fTurnover);
        $sExp = str_replace('x', '$fTurnover', $sExp);
        $sExp = str_replace('y', '$fBonus', $sExp);
        eval($sExp);
        return $fBonus;
    }

    private function getExpression($fTurnover) {
        return $sExp = 'x<50000&&y=0;x>=50000&&x<100000&&y=150;x>=100000&&x<200000&&y=350;x>=200000&&x<300000&&y=800;x>=300000&&x<500000&&y=1350;x>=500000&&x<700000&&y=2500;x>=700000&&x<1000000&&y=3500;x>=1000000&&x<2000000&&y=5000;x>=2000000&&x<5000000&&y=10000;x>=5000000&&y=30000;';
    }

    private function createUserPrize($fBonus, $oTeamProfit) {
        $oUserPrize = new ActivityUserPrize();
        $oUserPrize->prize_id = ActivityPrize::PRIZE_TOP_AGENT_DAILY_SALARY;
        $oActivityPrize = ActivityPrize::find($oUserPrize->prize_id);
        $oUserPrize->activity_id = $oActivityPrize->activity_id;
        $aExtraData = [
            'rebate_amount' => $fBonus,
            'username' => $oTeamProfit->username,
            'team_turnover' => $oTeamProfit->total_turnover,
            'team_profit' => $oTeamProfit->total_profit,
        ];
        $oUserPrize->data = json_encode($aExtraData);
        $oUserPrize->count = 1;
        $oUserPrize->user_id = $oTeamProfit->user_id;
        $oUserPrize->source = ActivityUserPrize::SOURCE_COMMAND;
        $oUserPrize->status = ActivityUserPrize::STATUS_NO_SEND;
        return $oUserPrize->save();
    }

    private function createReportDailySalary($fBonus, $oTeamProfit, $sDate) {
        $oReportDailySalary = new ActivityReportDailySalaryTopAgent;
        $oReportDailySalary->user_id = $oTeamProfit->user_id;
        $oReportDailySalary->username = $oTeamProfit->username;
        $oReportDailySalary->is_tester = $oTeamProfit->is_tester ? 1 : 0;
        $oReportDailySalary->rebate_amount = $fBonus;
        $oReportDailySalary->rebate_date = $sDate;
        $oReportDailySalary->team_turnover = $oTeamProfit->total_turnover;
        $oReportDailySalary->team_profit = $oTeamProfit->total_profit;
        return $oReportDailySalary->save();
    }

}
