<?php

/**
 * 更新盈亏程序
 *
 * @author frank
 */
class SetWithdrawable extends BaseTask {

    protected function doCommand() {
//        pr($this->job->id);
        extract($this->data);
        pr($this->data);
//        exit;

        if (!$lottery_id || !$issue) {
            $this->log = "ERROR: Invalid Data, Exiting";
            return self::TASK_RESTORE;
        }

//        $DB = DB::connection();
//        pr($oUser->toArray());
//        $DB->beginTransaction();
//        $type  = $this->data['type'];
        $aUserTurnovers = UserTurnover::getIssueUserTurnOvers($lottery_id, $issue);
        pr($aUserTurnovers);
//        exit;
        if (empty($aUserTurnovers)) {
            return self::TASK_SUCCESS;
        }
//Array
//(
//    [0] => Array
//        (
//            [user_id] => 35
//            [turnover] => 2.0000
//        )
//
//)
        $iTotal = count($aUserTurnovers);
        $iSucc = $iFail = 0;
        $fCoefficient = 5;

//        pr($aUserTurnovers);
//        exit;
        $DB = DB::connection();


        foreach ($aUserTurnovers as $aTurnover) {
            $oAccount = Account::lock($aTurnover['account_id'], $iLocker);
            if (empty($oAccount)) {
                $iFail++;
                continue;
            }
            $DB->beginTransaction();
            $fProhibitAmountReduceSpeed = SysConfig::readValue('prohibit_amount_reduce_speed');
            $fProhibitReduceAmount = $aTurnover['turnover'] * $fProhibitAmountReduceSpeed;
            if ($bSucc = $oAccount->setWithdrawable($fProhibitReduceAmount) && $oAccount->setProhibitAmount(-$fProhibitReduceAmount)) {
                $bSucc = UserTurnover::setToUsed($aTurnover['id']);
//                BaseTask::addTask('EventTaskQueue', ['event' => 'ds.activity.dailyBet', 'user_id' => $aTurnover['user_id'], 'data' => []], 'activity');
            } else {
                $this->log = 'Errors: ' . $oAccount->getValidationErrorString();
            }
            if ($bSucc) {
                $this->log = 'Seted';
                $iSucc++;
                $DB->commit();
            } else {
                $DB->rollback();
            }
            Account::unLock($oAccount->id, $iLocker, false);
//            $oAccount->s
        }
        $this->log .= "Total: $iTotal Succ: $iSucc Fail: $iFail";
        $this->log .= $iFail ? ' Restore' : ' Delete';
        return $iFail > 0 ? self::TASK_RESTORE : self::TASK_SUCCESS;
//        if (!$bSucc = UserProfit::updateProfitData($type, $date, $oUser, $amount)) {
//            $DB->rollback();
//            $this->log = "User Profit Update Failed";
//            return self::TASK_RESTORE;
//        }
        // 更新与奖期关联的销售额
    }

}
