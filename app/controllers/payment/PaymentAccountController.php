<?php

class PaymentAccountController extends AdminBaseController {

    protected $modelName = 'PaymentAccount';

    protected function beforeRender() {
        $this->setVars('aValidStatuses', PaymentAccount::$validStatuses);
        $this->setVars('aPlatforms', PaymentPlatform::getTitleList());
        $this->setVars('aPayTypes', PaymentAccount::$aPayTypes);
        parent::beforeRender();
    }

    public function setDefault($id) {
        $oAccount = PaymentAccount::find($id);
        if (!is_object($oAccount)) {
            return $this->goBack('error', __('_paymentaccount.missing-data'));
}
        $oAccount->is_default = 1;
        $bSucc = $oAccount->save();
        if ($bSucc) {
            return $this->goBackToIndex('success', __('_paymentaccount.default-success'));
        } else {
            return $this->goBack('error', __('_paymentaccount.default-failed'));
        }
    }

    public function close($id) {
        $oAccount = PaymentAccount::find($id);
        if (!is_object($oAccount)) {
            return $this->goBack('error', __('_paymentaccount.missing-data'));
        }
        $oAccount->status = Paymentaccount::STATUS_NOT_AVAILABLE;
        $bSucc = $oAccount->save();
        if ($bSucc) {
            return $this->goBackToIndex('success', __('_paymentaccount.close-success'));
        } else {
            return $this->goBack('error', __('_paymentaccount.close-failed'));
        }
    }
    
        public function open($id) {
        $oAccount = PaymentAccount::find($id);
        if (!is_object($oAccount)) {
            return $this->goBack('error', __('_paymentaccount.missing-data'));
        }
        $oAccount->status = Paymentaccount::STATUS_AVAILABLE;
        $bSucc = $oAccount->save();
        if ($bSucc) {
            return $this->goBackToIndex('success', __('_paymentaccount.open-success'));
        } else {
            return $this->goBack('error', __('_paymentaccount.open-failed'));
        }
    }

}
