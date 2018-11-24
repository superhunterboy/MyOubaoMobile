<?php

/**
 * Send Deposit Commission
 *
 * @author dev
 */
class SendDepositCommission extends BaseTask {

    protected $delayOnRelease = 2;
    protected $errorFiles = ['system', 'fund', 'account'];

    function doCommand() {
//        pr($this->data);
//        exit;
        extract($this->data, EXTR_PREFIX_ALL, 'com');
        $oDeposit = Deposit::find($com_id);
//        pr($oDeposit->toArray());
//        exit;
        if (empty($oDeposit)) {
            $this->log = ' Deposit Missing, Exiting';
            return self::TASK_SUCCESS;
        }
        if ($oDeposit->status != Deposit::DEPOSIT_STATUS_SUCCESS) {
            $this->log = ' Deposit Status Is Not Success, Exiting';
            return self::TASK_KEEP;
        }
        if ($oDeposit->commission <= 0) {
            $this->log = ' Commission Amount Invalid, Exiting';
            return self::TASK_SUCCESS;
        }

        $oMessage = new Message($this->errorFiles);

        $oUser = User::find($oDeposit->user_id);
        if (is_object($oUser)) {
            $iParentId = $oUser->parent_id;
            $oParent = User::find($iParentId);
        }

//        $oBeneficiary = User::find($oUser->parent_id);
        $oBeneficiary = User::find($oDeposit->top_agent_id);
        $oAccount = Account::lock($oBeneficiary->account_id, $iLocker);
        $bSameUser = $oBeneficiary->id == $oParent->id;
        $fCommission = $bSameUser ? $oDeposit->commission * 2 : $oDeposit->commission;
        if (empty($oAccount)) {
            $this->log = $oMessage->getResponseMsg(Account::ERRNO_LOCK_FAILED);
            return self::TASK_KEEP;
        }
        $bSameUser or $oParentAccount = Account::lock($oParent->account_id, $iLocker);
        if (!$bSameUser && empty($oParentAccount)) {
            $this->log = $oMessage->getResponseMsg(Account::ERRNO_LOCK_FAILED);
            return self::TASK_KEEP;
        }
        DB::connection()->beginTransaction();
        $aExtraData = [
            'note' => 'deposit: ' . $oDeposit->id,
        ];
        $iReturn = Transaction::addTransaction($oBeneficiary, $oAccount, TransactionType::TYPE_DEPOSIT_COMMISSION, $fCommission, $aExtraData);
        $bSameUser or $iReturn2 = Transaction::addTransaction($oParent, $oParentAccount, TransactionType::TYPE_DEPOSIT_COMMISSION, $fCommission, $aExtraData);
        if ($iReturn != Transaction::ERRNO_CREATE_SUCCESSFUL || (!$bSameUser && $iReturn2 != Transaction::ERRNO_CREATE_SUCCESSFUL)) {
            DB::connection()->rollback();
            Account::unlock($oBeneficiary->account_id, $iLocker);
            $bSameUser or Account::unlock($oParent->account_id, $iLocker);
            $this->log = 'Add Commission Error, Exiting';
            return self::TASK_KEEP;
        }

        if (!$oDeposit->setCommissionSent()) {
            DB::connection()->rollback();
            Account::unlock($oBeneficiary->account_id, $iLocker);
            $bSameUser or Account::unlock($oParent->account_id, $iLocker);
            $this->log = 'Set Commission Status to Sent Error, Exiting';
            return self::TASK_KEEP;
        }
        DB::connection()->commit();
        $this->addProfitTask('commission', date('Y-m-d'), $oBeneficiary->id, $fCommission);
        $bSameUser or $this->addProfitTask('commission', date('Y-m-d'), $oParent->id, $fCommission);
        Account::unlock($oBeneficiary->account_id, $iLocker);
        $bSameUser or Account::unlock($oParent->account_id, $iLocker);

        $this->log = 'Commission Added, Exiting';
        return self::TASK_SUCCESS;
    }

    protected function addProfitTask($sType, $sDate, $iUserId, $fAmount) {
        $aTaskData = [
            'type' => $sType,
            'user_id' => $iUserId,
            'amount' => $fAmount,
            'date' => substr($sDate, 0, 10),
        ];
        return BaseTask::addTask('StatUpdateProfit', $aTaskData, 'stat');
    }

}
