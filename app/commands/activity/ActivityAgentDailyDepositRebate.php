<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

/**
 * 每日充，每日返
 */
class ActivityAgentDailyDepositRebate extends BaseCommand {

    protected $sFileName = 'activityproxydailydepositrebate';

    /**
     * The activity cash back command name.
     *
     * @var string
     */
    protected $name = 'activity:everyday-agent-rebate';

    /**
     * The activity cash back description.
     *
     * @var string
     */
    protected $description = 'activity proxy daily deposit daily rebate';

    public function doCommand(& $sMsg = null) {
        $aUsers = User::getAllUserArrayByUserType('all', ['forefather_ids', 'forefathers']);
        $sYesterDay = date('Y-m-d', strtotime('-1 day'));
        $this->writeLog('start command, calculate date is ' . $sYesterDay);
        foreach ($aUsers as $oUser) {
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
            $fBonus = $this->getBonusByDeposit($oUserProfit->deposit);
            //奖金不满足条件，退出
            if ($fBonus == 0) {
                continue;
            }
            //流水不够一倍，退出
            if ($oUserProfit->deposit > $oUserProfit->turnover) {
                $this->writeLog('userame=' . $oUser->username . ',date=' . $oUserProfit->date . ',turnover=' . $oUserProfit->turnover . ' is less than deposit amount');
                continue;
            }
            //总代不参加活动
            if ($oUser->parent_id == null) {
                continue;
            }
            DB::connection()->beginTransaction();
            $aForeFatherIds = explode(',', $oUser->forefather_ids);
            if ($aForeFatherIds[0] != $oUser->parent_id) {
                $oParent = User::find($oUser->parent_id);
                $bSucc = $this->saveData($oParent, $oUserProfit, $sYesterDay, $fBonus, $oUser);
                $oTopAgent = User::find($aForeFatherIds[0]);
                !$bSucc or $bSucc = $this->saveData($oTopAgent, $oUserProfit, $sYesterDay, $fBonus, $oUser);
            } else {
                $oParent = User::find($oUser->parent_id);
                $bSucc = $this->saveData($oParent, $oUserProfit, $sYesterDay, $fBonus * 2, $oUser);
            }
            if ($bSucc) {
                DB::connection()->commit();
            } else {
                DB::connection()->rollback();
            }
        }
    }

    private function getBonusByDeposit($fAmount) {
        if ($fAmount >= 1000 && $fAmount < 3000) {
            return 10;
        } else if ($fAmount >= 3000 && $fAmount < 5000) {
            return 30;
        } else if ($fAmount >= 5000 && $fAmount < 10000) {
            return 49;
        } else if ($fAmount >= 10000 && $fAmount < 20000) {
            return 98;
        } else if ($fAmount >= 20000) {
            return 188;
        } else {
            return 0;
        }
    }

    private function saveData($oUser, $oUserProfit, $sCurrentDate, $fBonus, $oSubUser = null) {
        $fRebateLimit = SysConfig::readValue('deposit_agent_rebate_limit');
        $fTotalLeftBonus = $fRebateLimit - ActivityReportDailyDepositAgent::getCurrentDayTotalBonus($oUser->id, $sCurrentDate);
        if ($fTotalLeftBonus < 0) {
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
        $oUserPrize->prize_id = SysConfig::readValue('agent_deposit_rebate_prize_id');
        $oActivityPrize = ActivityPrize::find($oUserPrize->prize_id);
        $oUserPrize->activity_id = $oActivityPrize->activity_id;
        $aExtraData = [
            'rebate_amount' => $fBonus,
            'user_deposit' => $oUserProfit->deposit,
            'deposit_username' => $oSubUser->username,
            'usernames' => $oSubUser->forefathers,
            'turnover' => $oUserProfit->turnover,
        ];
        $oUserPrize->data = json_encode($aExtraData);
        $oUserPrize->count = 1;
        $oUserPrize->user_id = $oUser->id;
        $oUserPrize->source = ActivityUserPrize::SOURCE_TASK_SYSTEM;
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
