<?php

# 追号

class MobileTraceController extends UserTraceController {

    protected $resourceView = 'trace';

    protected function beforeRender() {
        $fAmount = number_format(Account::getAvaliable(Session::get('user_id')), 2);
        $oProfit = UserProfit::getUserProfitObject(date('Y-m-d'), Session::get('user_id'));
        if (is_object($oProfit)) {
            $fProfit = $oProfit->profit == null ? 0 : $oProfit->profit;
        } else {
            $fProfit = 0.00;
        }
        $fProfit = number_format($fProfit, 2);
        $this->setVars(compact('fProfit', 'fAmount'));
        switch ($this->action) {
            case 'processIndex':
                $this->action = 'index';
                break;
            case 'cancelIndex':
                $this->action = 'index';
                break;
            case 'endIndex':
                $this->action = 'index';
                break;
        }
        parent::beforeRender();
    }

    /**
     * 终止追号任务
     * @param int $iTraceId
     * @return Redirect
     */
    public function stop($iTraceId) {
        $oTrace = Trace::find($iTraceId);
        if (empty($oTrace)) {
            return $this->halt(false, 'error', Trace::ERRNO_TRACE_MISSING);
        }
        if ($oTrace->user_id != Session::get('user_id')) {
            return $this->halt(false, 'error', Trace::ERRNO_STOP_ERROR_NOT_YOURS);
        }
        if ($oTrace->status != Trace::STATUS_RUNNING) {
            return $this->halt(false, 'error', Trace::ERRNO_STOP_ERROR_STATUS);
        }
        $oAccount = Account::lock($oTrace->account_id, $iLocker);
        if (empty($oAccount)) {
            return $this->halt(false, 'error', Trace::ERRNO_STOP_ERROR_DETAIL_CANCEL_FAILED);
        }
        $oUser = User::find($oTrace->user_id);
        $oTrace->setAccount($oAccount);
        $oTrace->setUser($oUser);
        $DB = DB::connection();
        $DB->beginTransaction();
        if (($iReturn = $oTrace->terminate()) === true) {
            $DB->commit();
            $iErrno = Trace::ERRNO_STOP_SUCCESS;
            $sMsgType = 'success';
        } else {
            $DB->rollback();
            $iErrno = Trace::ERRNO_STOP_ERROR_DETAIL_CANCEL_FAILED;
            $sMsgType = 'error';
        }
        Account::unLock($oTrace->account_id, $iLocker, false);
        return $this->halt($sMsgType == 'success', $sMsgType, $iErrno);
    }

    /**
     * 取消预约
     * @param int $iTraceId
     * @param array $aDetailId
     * @return Redirect
     */
    public function cancel($iTraceId, $aDetailId) {
        is_array($aDetailId) or $aDetailId = [$aDetailId];
        $oTrace = UserTrace::find($iTraceId);
        if ($oTrace->user_id != Session::get('user_id')) {
            return $this->halt(false, 'error', Trace::ERRNO_STOP_ERROR_NOT_YOURS);
        }
        $oAccount = Account::lock($oTrace->account_id, $iLocker);
        if (empty($oAccount)) {
            return $this->halt(false, 'error', Trace::ERRNO_STOP_ERROR_DETAIL_CANCEL_FAILED);
        }
        $oUser = User::find($oTrace->user_id);
        $oTrace->setAccount($oAccount);
        $oTrace->setUser($oUser);
        $DB = DB::connection();
        $DB->beginTransaction();
        if (($iReturn = $oTrace->cancelDetail($aDetailId)) == Trace::ERRNO_DETAIL_CANCELED) {
            $DB->commit();
            $iErrno = Trace::ERRNO_DETAIL_CANCELED;
            $sMsgType = 'success';
        } else {
            $DB->rollback();
            $iErrno = Trace::ERRNO_DETAIL_CANCEL_FAILED;
            $sMsgType = 'error';
        }
        Account::unLock($oTrace->account_id, $iLocker, false);
        return $this->halt($sMsgType == 'success', $sMsgType, $iErrno);
//        return $this->goBack($sMsgType,__($sLangKey));
    }

}
