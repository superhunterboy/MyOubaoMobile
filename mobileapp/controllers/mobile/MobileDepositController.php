<?php

class MobileDepositController extends UserDepositController {

    protected $resourceView = 'deposit';

    /**
     * 是否需要检查用户绑卡情况（如有需要可改为配置方式）
     * @var boolean
     */
    protected $bCheckUserBankCard = false;

    /**
     * 是否需要验证用户资金密码（如有需要可改为配置方式）
     * @var boolean
     */
    protected $bCheckFundPassword = false;

    /**
     * 充值查询列表
     * @see BaseController::index()
     * @return Response
     */
    public function index() {
        $iLoginUserId = Session::get('user_id');
        if (Session::get('is_agent') && isset($this->params['username']) && $this->params['username']) {
            $oUser = User::getUserByParams(['username' => $this->params['username'], 'forefather_ids' => $iLoginUserId], ['forefather_ids']);
            if ($oUser) {
                $this->params['user_id'] = $oUser->id;
            } else {
                $aReplace = ['username' => $this->params['username']];
                return $this->goBack('error', __('_basic.not-your-user', $aReplace));
            }
        } else {
            $this->params['user_id'] = $iLoginUserId;
        }
        return parent::index();
    }

    // public function create()
    // {
    //     return View::make('l.index');
    // }
    // public function destroy($id)
    // {
    //     return View::make('l.index');
    // }
    // public function edit()
    // {
    //     return View::make('l.index');
    // }
    // public function view()
    // {
    //     return View::make($this->resourceView . '.records-game-detail');
    // }
    /**
     * 银行转账充值
     */
    public function netbank() {
        if (Request::method() == 'POST') {
            if (isset($this->params['dodespoit'])) {
                return $this->doDepositNetBank();
                exit;
            } else {
                return $this->confirmNetBank();
            }
        } else {
            return $this->depositFormNetBank();
        }
    }

    /**
     * 充值确认
     */
    private function confirmNetBank() {
        $oUser = UserUser::find(Session::get('user_id'));
        $iDepositMode = UserDeposit::DEPOSIT_MODE_BANK_CARD; // 充值方式
        $oBank = Bank::find($this->params['bank']);
        if (empty($oBank) || $oBank->status != Bank::BANK_STATUS_AVAILABLE) {
            return $this->goBack('error', __('_deposit.missing-bank'));
        }
        if (!in_array($oBank->mode, [BANK::BANK_MODE_ALL, BANK::BANK_MODE_BANK_CARD])) { // 当前银行是否支持银行卡转账
            return $this->goBack('error', __('_deposit.missing-bank'));
        }
        $oBankcard = PaymentBankCard::getBankcardForDeposit($oBank->id);
//        pr($oBankcard->toArray());
//        exit;
        $oUserDeposit = UserDeposit::addDeposit(Deposit::DEPOSIT_MODE_BANK_CARD, $oUser, $oBank, null, null, $oBankcard->toArray());
        $this->setVars(compact('oBank', 'iDepositMode', 'oUserDeposit'));
        $this->view = $this->resourceView . '.netbankConfirm';
        return $this->render();
    }

    /**
     * 银行转账
     */
    private function depositFormNetBank() {
        $iUserId = Session::get('user_id');
        $oUser = UserUser::find($iUserId);
        if (!is_object($oUser)) {
            return $this->goBack('error', __('_user.missing-user'));
        }
        if ($oUser->blocked == UserUser::BLOCK_FUND_OPERATE) {
            return $this->goBack('error', __('_user.deposit-now-allowed'));
        }
//        if ($oUser->fund_password == null) {
//            $this->saveUrlToSession();
//            return Redirect::route('users.safe-reset-fund-password');
//        }
        $bSetFundPassword = !empty($oUser->fund_password); // 是否已设置资金密码
        $oAllBanks = Bank::getSupportCardBank();
        $aUserBankCards = [];
        $bCheckUserBankCard = $this->bCheckUserBankCard; // 是否需要检查用户绑卡情况（如有需要可改为配置方式）
        if ($bCheckUserBankCard) {
            $oUserBankCards = UserUserBankCard::getUserCardsInfo($iUserId, ['id', 'bank_id', 'account_name', 'account']);
            foreach ($oUserBankCards as $bankcard) {
                $aUserBankCards[$bankcard->bank_id][$bankcard->id] = [
                    'id' => $bankcard->id,
                    'name' => $bankcard->account_name,
                    'number' => $bankcard->account_hidden,
                    'isdefault' => false,
                ];
            }
        }
        $aAllBanks = []; // 页面JS数据接口
        foreach ($oAllBanks as $bank) {
            $bank->is_band_card = !$bCheckUserBankCard || !empty($aUserBankCards[$bank->id]); // 显示用户是否有绑卡，当不检查绑卡时默认值为true
            $aAllBanks[$bank->id] = [
                'id' => $bank->id,
                'name' => $bank->name,
                'min' => $bank->min_load,
                'max' => $bank->max_load,
                'text' => $bank->notice,
                'userAccountList' => !empty($aUserBankCards[$bank->id]) ? $aUserBankCards[$bank->id] : [],
            ];
        }
        $sAllBanksJs = json_encode($aAllBanks); // 页面JS数据接口
        /* 验证（以下验证不再需要 @20141104） */
        // 是否需要输入资金密码（用于资金密码框显示）
        // 是否至少绑定了一张银行卡
        // 系统是否有可用充值银行
        // 是否达到充值次数上限
        // return View::make($this->resourceView . '.netbank');
        $iStatus = Session::get('is_tester') ? PaymentPlatform::STATUS_AVAILABLE_FOR_TESTER : PaymentPlatform::STATUS_AVAILABLE;
        $oPlatforms = PaymentPlatform::getAvailabelPlatforms($iStatus, [], 'mobile');
//        $fMinLoad = number_format(SysConfig::readValue('deposit_3rdpart_min_amount '), 2);
//        $fMaxLoad = number_format(SysConfig::readValue('deposit_3rdpart_max_amount'), 2);
//        $this->setVars(compact('oAllBanks', 'bSetFundPassword', 'fMinLoad', 'fMaxLoad', 'oPlatforms', 'iPlatformId'));
        $iPlatformId = null;
        $this->setVars(compact('oAllBanks', 'sAllBanksJs', 'bCheckUserBankCard', 'bSetFundPassword', 'oPlatforms', 'iPlatformId'));
        return $this->render();
    }

    private function doDepositQuick($iPlatformId) {
        $oPayment = PaymentPlatform::find($iPlatformId);
        if (!is_object($oPayment)) {
            return $this->goBack('error', __('_basic.no-data', ['data' => '支付渠道']));
        }
        if (Request::method() == 'POST') {
//            pr($this->params);
            $fMinLoad = $oPayment->min_load;
            $fMaxLoad = $oPayment->max_load;
            $this->params['amount'] = number_format($this->params['amount'], 2, '.', '');
            if ($this->params['amount'] < $fMinLoad || $this->params['amount'] > $fMaxLoad) {
                $aReplace = [
                    'min' => number_format($fMinLoad, 2),
                    'max' => number_format($fMaxLoad, 2),
                ];
                return $this->goBack('error', __('_deposit.amount-error', $aReplace));
            }
//            $oPayment = PaymentPlatform::getObject('zhifu');
//            pr($iPlatformId);
//            exit;
            $oPayment = PaymentPlatform::getObject($oPayment->identifier);
            $oPaymentAccount = PaymentAccount::getAccountForDeposit($oPayment->id, false, true, $this->params['amount']);
            if (empty($oPaymentAccount)) {
                return $this->goBack('error', __('_deposit.no-payment-account'));
            }
//            pr($oPaymentAccount->toArray());
//            exit;
            $oUser = User::find(Session::get('user_id'));
            $oBank = $oPayment->need_bank ? Bank::find($this->params['bank']) : null;
            $oDeposit = UserDeposit::addDeposit(UserDeposit::DEPOSIT_MODE_THIRD_PART, $oUser, $oBank, $this->params['amount'], $oPayment, null, $oPaymentAccount);
            if (empty($oDeposit)) {
                return $this->goBack('error', __('_deposit.save-failed'));
            }
            !$oPayment->query_on_callback or empty($oPayment->query_url) or Deposit::addCheckTask($oDeposit->id, 60);
//            pr($oDeposit->getAttributes());
//            exit;
            // 更新sign
//            $oDeposit->sign        = $sSafeStr;
//            $oDeposit->platform_id = $oPayment->id;
//            $oDeposit->platform = $oPayment->name;
//            $oDeposit->platform_identifier = $oPayment->identifier;
//            $oDeposit->save();
            $aInputData = $oPayment->compileInputData($oPaymentAccount, $oDeposit, $oBank, $sSafeStr);
//            pr($aInputData);
//            exit;
            $sUrl = $oPayment->getLoadUrl($oPaymentAccount);
//            $sRealUrl = $oPayment->status == PaymentPlatform::STATUS_AVAILABLE_FOR_TESTER ? $oPayment->test_load_url : $oPayment->load_url;
//            pr($oPayment->toArray());
//            $sRealUrl = ($oPayment->status & PaymentPlatform::STATUS_AVAILABLE) != PaymentPlatform::STATUS_AVAILABLE ? $oPayment->test_load_url : $oPayment->load_url;
            $sRealUrl = $oPaymentAccount->is_test ? $oPayment->test_load_url : $oPayment->load_url;
//            die($sRealUrl);

            $this->setVars(compact('aInputData', 'sUrl'));
            $this->setVars('___DepositUrl', $sRealUrl);
            if ($oPayment->is_self == 1) {
                $this->setVars(compact('oDeposit', 'oPaymentAccount', 'oPayment'));
                $this->view = $this->resourceView . '.doDepositSelf';
            } else {
                if (in_array($oPayment->identifier, ['TONGHUIZFB', 'TONGHUIWXPC'])) {
                    $this->view = $this->resourceView . '.doDepositTHZFB';
                } else {
                    $this->view = $this->resourceView . '.doDeposit';
                }
            }
            return $this->render();
        }
        exit;
    }

    /**
     * 第三方充值
     * @return type
     */
    public function quick($id = null) {
        if (!$id) {
            $id = $this->params['platform'];
        }
        if (Request::method() == 'POST') {
            if (isset($this->params['dodespoit'])) {
                return $this->doDepositQuick($id);
                exit;
            } else {
                return $this->confirmQuick($id);
            }
        } else {
            return $this->depositForm($id);
        }
    }

    private function depositForm($iPlatformId) {
        $oPlatform = PaymentPlatform::find($iPlatformId);
        if (!is_object($oPlatform)) {
            return $this->goBack('error', '支付渠道不存在');
        }
        $iUserId = Session::get('user_id');
        $oUser = UserUser::find($iUserId);
        if ($oUser->fund_password == null) {
            $this->saveUrlToSession();
            return Redirect::route('mobile-users.safe-reset-fund-password');
        }
        $bSetFundPassword = !empty($oUser->fund_password); // 是否已设置资金密码
//        if ($oPlatform->need_bank){
        $oAllBanks = Bank::getSupportThirdPartBank();
        $aAllBanks = []; // 页面JS数据接口
        foreach ($oAllBanks as $bank) {
            $aAllBanks[$bank->id] = [
                'id' => $bank->id,
                'identifier' => $bank->identifier,
                'name' => $bank->name,
//                    'min'        => max($fMinLoad, $bank->min_load),
//                    'max'        => min($fMaxLoad, $bank->max_load),
            ];
        }
        $sAllBanksJs = json_encode($aAllBanks); // 页面JS数据接口
        $this->setVars(compact('aAllBanks', 'sAllBanksJs'));
//        }
//        pr($aAllBanks);
        $iStatus = Session::get('is_tester') ? PaymentPlatform::STATUS_AVAILABLE_FOR_TESTER : PaymentPlatform::STATUS_AVAILABLE;
        $oPlatforms = PaymentPlatform::getAvailabelPlatforms($iStatus, [], 'mobile');
        $fMinLoad = number_format($oPlatform->min_load, 2);
        $fMaxLoad = number_format($oPlatform->max_load, 2);
        $this->setVars(compact('oAllBanks', 'bSetFundPassword', 'fMinLoad', 'fMaxLoad', 'oPlatforms', 'iPlatformId', 'oPlatform'));
        return $this->render();
    }

    /**
     * 充值确认
     */
    private function confirmQuick($iPlatformId) {
        $oPlatform = PaymentPlatform::find($iPlatformId);
        if (!is_object($oPlatform)) {
            return $this->goBack('error', '支付渠道不存在');
        }
        $oUser = UserUser::find(Session::get('user_id'));
        /* Step 1: 验证 */
        $aFormRules = [
//            'bank' => 'required|numeric', 
            'amount' => 'required|regex:/^[0-9]+(.[0-9]{1,2})?$/',
            'fund_password' => ($this->bCheckFundPassword ? 'required|' : '') . 'between:0, 60',
            'deposit_mode' => 'required|in:' . UserDeposit::DEPOSIT_MODE_BANK_CARD . ',' . UserDeposit::DEPOSIT_MODE_THIRD_PART
        ];
        // 验证表单
        $validator = Validator::make($this->params, $aFormRules);
        if (!$validator->passes()) { // 表单未通过验证
            return $this->goBack('error', __('_deposit.deposit-error-00'));
        }
        // 1 资金密码
        if ($this->bCheckFundPassword && !$oUser->checkFundPassword($this->params['fund_password'])) {
            return $this->goBack('error', __('_deposit.wrong-fund-passwd'));
        }
        // 2 是否绑定银行卡
        // 3 当前银行是否可用
        $iDepositMode = $this->params['deposit_mode']; // 充值方式
        if ($oPlatform->need_bank) {
            $oBank = Bank::find($this->params['bank']);
            if (!$oBank || $oBank->status != Bank::BANK_STATUS_AVAILABLE) {
                return $this->goBack('error', __('_deposit.missing-bank'));
            }
        }
        if ($iDepositMode == UserDeposit::DEPOSIT_MODE_THIRD_PART) { // 用户选择第三方充值
            if ($oPlatform->need_bank) {
                if (!in_array($oBank->mode, [BANK::BANK_MODE_ALL, BANK::BANK_MODE_THIRD_PART])) { // 当前银行是否支持第三方充值
                    return $this->goBack('error', __('_deposit.missing-bank'));
                }
            }
            $fMinLoad = number_format($oPlatform->min_load, 2, '.', '');
            $fMaxLoad = number_format($oPlatform->max_load, 2, '.', '');
            if ($this->params['amount'] < $fMinLoad || $this->params['amount'] > $fMaxLoad) { // 金额超出范围
                return $this->goBack('error', __('_deposit.amount-out-range'));
            }
        }
        // 4 是否达到充值次数上限
//        $sRequestMethod = Request::method();
        $fAmount = $this->params['amount'];
        $sDisplayAmount = number_format($fAmount, 2, '.', ',');
        $this->setVars(compact('oBank', 'iDepositMode', 'fAmount', 'sDisplayAmount', 'iPlatformId', 'oPlatform'));
        $this->view = $this->resourceView . '.confirm';
        return $this->render();
    }

    /**
     * 写充值日志
     * @param string|array $msg
     */
    protected function writeLog($msg) {
        !is_array($msg) or $msg = var_export($msg, true);
        @file_put_contents('/tmp/deposit', $msg . "\n", FILE_APPEND);
    }

    protected function beforeRender() {
        parent::beforeRender();
        $this->setVars('bCheckFundPassword', $this->bCheckFundPassword);
        $this->setVars('isOpenBankDeposit', SysConfig::readValue('is_open_bank_deposit'));
        switch ($this->action) {
            case 'index':
                $this->setVars('reportName', 'depositApply');
                break;
        }
    }

}
