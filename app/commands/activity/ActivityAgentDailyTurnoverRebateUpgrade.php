<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

/**
 * 代理消费佣金
 */
class ActivityAgentDailyTurnoverRebateUpgrade extends BaseCommand {

    protected $sFileName = 'activityproxydailyturnoverrebateupgrade';

    /**
     * The activity cash back command name.
     *
     * @var string
     */
    protected $name = 'activity:everyday-turnover-rebate-upgrade';

    /**
     * The activity cash back description.
     *
     * @var string
     */
    protected $description = 'activity proxy daily turnover daily rebate upgrade';

    public function doCommand(& $sMsg = null) {
        $aUsers = User::getAllUserArrayByUserType('all', ['forefather_ids', 'forefathers']);
        $sYesterDay = date('Y-m-d', strtotime('-1 day'));
//        $sYesterDay = '2015-06-23';
        $this->writeLog('start command, calculate date is ' . $sYesterDay);
        foreach ($aUsers as $oUser) {
            //总代不参加活动
            if ($oUser->parent_id == null) {
                continue;
            }
            $oReportAgentRebate = ActivityReportDailyDepositAgent::getObjectByParams(['source_user_id' => $oUser->id, 'rebate_date' => $sYesterDay]);
            // 不能重复计算
            if (is_object($oReportAgentRebate)) {
                continue;
            }
            $oUserProfit = UserProfit::getUserProfitObject($sYesterDay, $oUser->id);
            if (!is_object($oUserProfit)) {
                $this->writeLog('no profit data');
                continue;
            }
            if ($oUserProfit->turnover < 1000) {
                continue;
            }
            $this->writeLog(" date=$sYesterDay, username=$oUserProfit->username, turnover=$oUserProfit->turnover");
            $fFirstAgentBonus = $this->getTopAgentBonus($oUserProfit->turnover);
            $fGrandpaBonus = $this->getGrandpaBonus($oUserProfit->turnover);
            $fParentBonus = $this->getParentBonus($oUserProfit->turnover);
            $this->writeLog("the first agent bonus=$fFirstAgentBonus, grandpa bonus=$fGrandpaBonus, parent bonus=$fParentBonus");
            DB::connection()->beginTransaction();
            $aForeFatherIds = explode(',', $oUser->forefather_ids);
            if (count($aForeFatherIds) == 1) {
                // 总代
                $oParent = User::find($oUser->parent_id);
                $bSucc = $this->saveData($oParent, $oUserProfit, $sYesterDay, $fFirstAgentBonus + $fGrandpaBonus + $fParentBonus, $oUser);
            } else if (count($aForeFatherIds) == 2) {
                //上级
                $oParent = User::find($oUser->parent_id);
                $bSucc = $this->saveData($oParent, $oUserProfit, $sYesterDay, $fParentBonus, $oUser);
                // 总代
                $oTopAgent = User::find($oParent->parent_id);
                $fBonus = $fGrandpaBonus + $fFirstAgentBonus;
                $this->writeLog("bonus=$fBonus");
                !$bSucc or $bSucc = $this->saveData($oTopAgent, $oUserProfit, $sYesterDay, $fBonus, $oUser);
            } else if (count($aForeFatherIds) >= 3) {
                //上级
                $oParent = User::find($oUser->parent_id);
                $bSucc = $this->saveData($oParent, $oUserProfit, $sYesterDay, $fParentBonus, $oUser);
                //上上级
                $oGranpaAgent = User::find($oParent->parent_id);
                !$bSucc or $bSucc = $this->saveData($oGranpaAgent, $oUserProfit, $sYesterDay, $fGrandpaBonus, $oUser);
                //上上上级
                $oFirstAgent = User::find($oGranpaAgent->parent_id);
                !$bSucc or $bSucc = $this->saveData($oFirstAgent, $oUserProfit, $sYesterDay, $fFirstAgentBonus, $oUser);
            }
            if ($bSucc) {
                DB::connection()->commit();
            } else {
                DB::connection()->rollback();
            }
        }
    }

    private function getTopAgentBonus($fAmount) {
        $fBonus = 0;
        $sfeeExpressions = 'x>=1000&&x<3000&&y=3;x>=3000&&x<5000&&y=9;x>=5000&&x<10000&&y=12;x>=10000&&x<30000&&y=19;x>=30000&&x<50000&&y=42;x>=50000&&x<100000&&y=65;x>=100000&&x<300000&&y=100;x>=300000&&x<500000&&y=240;x>=500000&&y=300;';
        $sFeeExpressions = str_replace('x', '$fAmount', $sfeeExpressions);
        $sFeeExpressions = str_replace('y', '$fBonus', $sFeeExpressions);
        eval($sFeeExpressions);
        return $fBonus;
    }

    private function getGrandpaBonus($fAmount) {
        $fBonus = 0;
        $sfeeExpressions = 'x>=1000&&x<3000&&y=5;x>=3000&&x<5000&&y=12;x>=5000&&x<10000&&y=20;x>=10000&&x<30000&&y=30;x>=30000&&x<50000&&y=75;x>=50000&&x<100000&&y=100;x>=100000&&x<300000&&y=170;x>=300000&&x<500000&&y=390;x>=500000&&y=500;';
        $sFeeExpressions = str_replace('x', '$fAmount', $sfeeExpressions);
        $sFeeExpressions = str_replace('y', '$fBonus', $sFeeExpressions);
        eval($sFeeExpressions);
        return $fBonus;
    }

    private function getParentBonus($fAmount) {
        $fBonus = 0;
        $sfeeExpressions = 'x>=1000&&x<3000&&y=8;x>=3000&&x<5000&&y=22;x>=5000&&x<10000&&y=30;x>=10000&&x<30000&&y=52;x>=30000&&x<50000&&y=138;x>=50000&&x<100000&&y=200;x>=100000&&x<300000&&y=300;x>=300000&&x<500000&&y=750;x>=500000&&y=1000;';
        $sFeeExpressions = str_replace('x', '$fAmount', $sfeeExpressions);
        $sFeeExpressions = str_replace('y', '$fBonus', $sFeeExpressions);
        eval($sFeeExpressions);
        return $fBonus;
    }

    private function saveData($oUser, $oUserProfit, $sCurrentDate, $fBonus, $oSubUser = null) {
        $fRebateLimit = SysConfig::readValue('deposit_agent_rebate_limit');
        $fTotalLeftBonus = $fRebateLimit - ActivityReportDailyDepositAgent::getCurrentDayTotalBonus($oUser->id, $sCurrentDate);
        if ($fTotalLeftBonus <= 0) {
            return false;
        } else if ($fTotalLeftBonus < $fBonus) {
            $fBonus = $fTotalLeftBonus;
        }
        $oUserPrize = $this->createUserPrize($fBonus, $oUserProfit, $oUser, $oSubUser);
        $oReportAgentRebate = $this->createReportAgentRebate($fBonus, $oUserProfit->deposit, $oUser, $sCurrentDate, $oSubUser);
        $bSucc = $oUserPrize->save();
        !$bSucc or $bSucc = $oReportAgentRebate->save();
        return $bSucc;
    }

    /**
     *  创建用户奖品对象
     */
    private function createUserPrize($fBonus, $oUserProfit, $oUser, $oSubUser = null) {
        $oUserPrize = new ActivityUserPrize();
        $oUserPrize->prize_id = SysConfig::readValue('agent_turnover_rebate_prize_id');
        $oActivityPrize = ActivityPrize::find($oUserPrize->prize_id);
        $oUserPrize->activity_id = $oActivityPrize->activity_id;
        $aExtraData = [
            'rebate_amount' => $fBonus,
            'turnover_username' => $oSubUser->username,
            'usernames' => $oSubUser->forefathers,
            'turnover' => $oUserProfit->turnover,
            'source_user_id' => $oUser->id,
            'source_username' => $oUser->username,
        ];
        $oUserPrize->data = json_encode($aExtraData);
        $oUserPrize->count = 1;
        $oUserPrize->user_id = $oUser->id;
        $oUserPrize->source = ActivityUserPrize::SOURCE_COMMAND;
        $oUserPrize->status = ActivityUserPrize::STATUS_NO_SEND;
        return $oUserPrize;
    }

    /**
     * 创建活动报表对象
     */
    private function createReportAgentRebate($fBonus, $fAmount, $oUser, $sDate, $oSubUser = null) {
        $oReportAgentRebate = new ActivityReportDailyDepositAgent;
        $oReportAgentRebate->user_id = $oUser->id;
        $oReportAgentRebate->username = $oUser->username;
        $oReportAgentRebate->is_tester = $oUser->is_tester ? 1 : 0;
        $oReportAgentRebate->rebate_amount = $fBonus;
        $oReportAgentRebate->rebate_date = $sDate;
        $oReportAgentRebate->source_user_id = $oSubUser != null ? $oSubUser->id : null;
        $oReportAgentRebate->source_username = $oSubUser != null ? $oSubUser->username : null;
        $oReportAgentRebate->deposit_amount = $fAmount;
        return $oReportAgentRebate;
    }

}
