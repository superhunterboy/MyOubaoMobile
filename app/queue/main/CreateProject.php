<?php

class CreateProject extends BaseTask {
    private $accountLocker;
    private $account_id;
//    private $dbThreadId;


    protected function doCommand(){
        extract($this->data,EXTR_PREFIX_ALL,'ctp');
//        pr($this->data);
        if (!isset($ctp_trace_id)) {
            return self::TASK_SUCCESS;
        }
        $oTrace = ManTrace::find($ctp_trace_id);
        if (empty($oTrace)) {
            $this->log .= " Missing Trace";
            return self::TASK_SUCCESS;
        }
        if ($oTrace->status != ManTrace::STATUS_RUNNING){
            $this->log .= " Trace Not Running";
            return self::TASK_SUCCESS;
        }
        if ($oTrace->stop_on_won && $oTrace->won_issue){
            $this->log .= " Trace was be setted to STOP_ON_WON, and it Won already";
            return self::TASK_SUCCESS;
        }
        $oUser = User::find($oTrace->user_id);

        // 检查奖期是否合法
        $sIssue       = $oTrace->getNextIssue();
        $sOnSaleIssue = ManIssue::getOnSaleIssue($oTrace->lottery_id);
        if ($sIssue > $sOnSaleIssue) {
            $this->log .= " Too Early";
            return self::TASK_RESTORE;
        }

        $oAccount = Account::lock($oTrace->account_id, $iLocker);

            if (empty($oAccount)){
            $this->log .= " Lock Account Failed";
            return self::TASK_RESTORE;
        }

        $this->account_id    = $oTrace->account_id;
        $this->accountLocker = $iLocker;
//        BetThread::addThread($oTrace->lottery_id,$sIssue,$iLocker);
        $oTrace->setAccount($oAccount);
        $oTrace->setUser($oUser);
        $DB                  = DB::connection();
        $DB->beginTransaction();
        $oProject          = $oTrace->generateProjectOfIssue(null, $iErrno);
        $bSucc               = (is_object($oProject) || $iErrno == Trace::ERRNO_PRJ_GERENATE_FAILED_NO_DETAIL);
        if ($bSucc) {
            $DB->commit();
            if (is_object($oProject)) {
                $oProject->setCommited();
//                $oProject->addTurnoverStatTask(true);  // 建立更新销售量任务
                $this->log .= " Success Project {$oProject->id}";
            } else {
                $this->log .= " No Detail";
            }
        }
        else{
            $DB->rollback();
            $this->log .= " ERROR: $iErrno";
        }
        Account::unlock($oTrace->account_id, $iLocker, false);
//        BetThread::deleteThread($oTrace->lottery_id, $sIssue, $this->accountLocker);
        $this->accountLocker = null;
        return $bSucc ? self::TASK_SUCCESS : self::TASK_RESTORE;
    }

    /**
     * 析构
     * 1 自动解锁
     * 2 自动删除交易线程
     */
    function __destruct() {
        if ($this->accountLocker) {
            Account::unLock($this->account_id, $this->accountLocker, false);
//            BetThread::deleteThread($this->accountLocker);
        }
        parent::__destruct();
    }

}
