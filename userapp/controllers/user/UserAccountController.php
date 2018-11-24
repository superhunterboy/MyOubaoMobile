<?php

class UserAccountController extends UserBaseController {

    protected $resourceView = 'centerUser.transfer';
    public $resourceName = '';
    protected $modelName = 'Account';
    protected $errorFiles = ['system', 'fund', 'account'];

    const DESC_DEPOSIT_BY_PARENT = 1;
    const DESC_SEND_SALARY = 2;
    
    public static $aDesc = [
        self::DESC_SEND_SALARY => '发放工资',
        self::DESC_DEPOSIT_BY_PARENT => '为下级充值',
    ];
    public function beforeRender() {
        parent::beforeRender();
        switch ($this->action) {
            case 'transfer':
                $oUser = User::find(Session::get('user_id'));
                $oAccount = Account::find($oUser->account_id);
                $aChildren = $oUser->getDirectChildrenArray();
                $this->setVars('aDesc', self::$aDesc);
                $this->setVars(compact('aChildren', 'oAccount'));
        }
    }

    function transfer() {
        $iUserId = Session::get('user_id');
        $oUser = UserUser::find($iUserId);
        if (!is_object($oUser)) {
            return $this->goBack('error', __('_user.missing-user'));
        }
        // 绑卡前先设置资金密码
        if ($oUser->fund_password == null) {
            $this->saveUrlToSession();
            Session::put('curPage-UserUser', route('users.safe-reset-fund-password'));
            return Redirect::route('users.safe-reset-fund-password', 0);
        }
        if ($oUser->blocked == UserUser::BLOCK_FUND_OPERATE) {
            return $this->goBack('error', __('_user.withdraw-now-allowed'));
        }
        if (Request::method() == 'POST') {
//            if (isset($this->params['dotransfer'])) {
            return $this->doTransfer();
            exit;
            //            } else {
//                return $this->confirm();
//            }
        } else {
            Session::put($this->redictKey, Request::fullUrl());
            return $this->transferForm();
        }
    }

    private function transferForm() {
        return $this->render();
    }

    protected function doTransfer() {
//        if (!Session::get('is_top_agent')) {
//            return $this->goBack('error', __('_account.transfer-not-allowed'));
//        }
        $fAmount = formatNumber($this->params['amount'], 6);
        if ($fAmount <= 0 || $fAmount != $this->params['amount']) {
            return $this->goBack('error', __('_account.transfer-failed-amount-error'));
        }
        $iToUserId = $this->params['userid'];
        $iFromUserId = Session::get('user_id');
        if ($iToUserId == $iFromUserId) {
            return $this->goBack('error', __('_account.transfer-failed-to-self'));
        }
        $oFromUser = User::find($iFromUserId);
        if (!$oFromUser->checkFundPassword(array_get($this->params, 'fund_password'))) {
            return $this->goBack('error', __('_basic.validate-fund-password-fail'));
        }
        if (!$oFromUser->isChild($iToUserId, true, $oToUser)) {
            return $this->goBack('error', __('_account.transfer-failed-not-direct-children', ['username' => $oToUser->username]));
        }
        $this->Message = new Message($this->errorFiles);
        $oFromAccount = Account::lock($oFromUser->account_id, $iFromLocker);
        if (empty($oFromAccount)) {
            return $this->goBack('error', $this->Message->getResponseMsg(Account::ERRNO_LOCK_FAILED));
        }
        //如果上级在转帐白名单中或者是为下级充值，使用该用户账户的可用余额
        $bCheckRole = RoleUser::checkUserRoleRelation(Role::TRANSFER_WHITE, $iFromUserId);
        if($this->params['desc']==self::DESC_DEPOSIT_BY_PARENT || $bCheckRole){
            $fFromAmount = $oFromAccount->available;
            $bDeposit = true;
        }else if($this->params['desc']==self::DESC_SEND_SALARY){
            $fFromAmount = $oFromAccount->getWithdrawableAmount();
            $bDeposit = false;
        }else{
            Account::unLock($oFromAccount->id, $iFromLocker);
            return $this->goBack('error', '转账金额不得大于自己的可用余额');
        }
        if ($fFromAmount < $fAmount) {
            Account::unLock($oFromAccount->id, $iFromLocker);
            return $bDeposit == true?  $this->goBack('error', '转账金额不得大于自己的可用余额') : $this->goBack('error', '转账金额不得大于自己的可提余额');
        }
        $oToAccount = Account::lock($oToUser->account_id, $iToLocker);
        if (empty($oToAccount)) {
            Account::unLock($oFromAccount->id, $iFromLocker);
            return $this->goBack('error', $this->Message->getResponseMsg(Account::ERRNO_LOCK_FAILED));
        }
        DB::connection()->beginTransaction();
        try {
            $aExtraData = [
                'note' => self::$aDesc[$this->params['desc']],
                'tag' => $oToUser->username,
                'ip' => $this->clientIP,
                'proxy_ip' => $this->proxyIP
            ];
            $iReturn = Transaction::addTransaction($oFromUser, $oFromAccount, TransactionType::TYPE_TRANSFER_OUT, $fAmount, $aExtraData);
            // 添加状态是否成功
            if ($iReturn != Transaction::ERRNO_CREATE_SUCCESSFUL) {
                throw new Exception(__('_account.transfer-failed-reduct'));
            }
            $aExtraData['tag'] = $oFromUser->username;
            $iReturn = Transaction::addTransaction($oToUser, $oToAccount, TransactionType::TYPE_TRANSFER_IN, $fAmount, $aExtraData);
            if ($iReturn != Transaction::ERRNO_CREATE_SUCCESSFUL) {
                throw new Exception(__('_account.transfer-failed-add'));
            }
        } catch (Exception $e) {
            DB::connection()->rollback();
            Account::unlock($oFromUser->id, $iFromLocker);
            Account::unlock($oToUser->id, $iToLocker);
            return $this->goBack('error', $e->getMessage());
        }
        DB::connection()->commit();
        if($this->params['desc']==self::DESC_SEND_SALARY || $bCheckRole){
            BaseTask::addTask('AdjustProhibitAmount', ['user_id' => $oToUser->id, 'amount' => -$fAmount], 'withdraw');
        }
        if($this->params['desc']==self::DESC_DEPOSIT_BY_PARENT  || $bCheckRole){
            BaseTask::addTask('AdjustProhibitAmount', ['user_id' => $oFromUser->id, 'amount' => -$fAmount], 'withdraw');
        }
        Account::unlock($oFromUser->id, $iFromLocker);
        Account::unlock($oToUser->id, $iToLocker);
        return $this->goBack('success', __('_account.transfer-success', ['username' => $oToUser->username, 'amount' => $fAmount]));
    }

}
