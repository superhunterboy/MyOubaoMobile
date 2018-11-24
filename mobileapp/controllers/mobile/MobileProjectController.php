<?php

class MobileH5ProjectController extends UserProjectController {

    protected $resourceView = 'project';

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
            case 'waitIndex':
                $this->action = 'index';
                break;
            case 'wonIndex':
                $this->action = 'index';
                break;
            case 'lostIndex':
                $this->action = 'index';
                break;
        }
        parent::beforeRender();
    }

    /**
     * 撤单
     * @param int $id
     * @return Redirect
     */
    function drop($id) {
        $oProject = UserProject::find($id);
        $Redirect = Redirect::route('projects.view', ['id' => $oProject->id]);
        if (empty($oProject)) {
            $this->halt(false, 'error', Project::ERRNO_PROJECT_MISSING);
        }
        if (Session::get('user_id') != $oProject->user_id) {
            $this->halt(false, 'error', Project::ERRNO_DROP_ERROR_NOT_YOURS);
        }
        $oAccount = Account::lock($oProject->account_id, $iLocker);
        if (empty($oAccount)) {
            $this->halt(false, 'error', Account::ERRNO_LOCK_FAILED);
        }
        DB::connection()->beginTransaction();
        $this->writeLog('begin DB Transaction');
        if (($iReturn = $oProject->drop()) != Project::ERRNO_DROP_SUCCESS) {
            $this->writeLog($iReturn);
            DB::connection()->rollback();
            $this->writeLog('Rollback');
            Account::unLock($oAccount->id, $iLocker, false);
            $this->halt(false, 'error', $iReturn);
        }
        DB::connection()->commit();
        $this->writeLog('Commit');
        $oProject->addTurnoverStatTask(false);    // 建立销售量更新任务
        Account::unLock($oAccount->id, $iLocker, false);
        $this->halt(true, 'success', Project::ERRNO_DROP_SUCCESS);
    }

}
