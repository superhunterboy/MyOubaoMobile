<?php

/**
 * 用户银行卡
 *
 * @author dev
 */
class BankCardController extends AdminBaseController {

    protected $modelName = 'BankCard';
    protected $customViewPath = 'bank.bankcard';
    protected $customViews = [
        'index',
    ];

    protected function beforeRender() {
        parent::beforeRender();
        $aBanks = & Bank::getAllBankArray();
        $this->setVars(compact('aBanks'));
        $this->setVars('aStatus', Bankcard::$validStatuses);
    }

    /**
     * 将银行卡拉黑
     * @param type $id
     */
    public function setToBlackList($id) {
        $oBankCard = BankCard::find($id);
        if (Request::method() == 'POST') {
            $sNote = $this->params['note'];
            if (empty($sNote)) {
                return $this->goBack('error', __('_bankcard.note-required'));
            }
            $oBankCard->note .= "<p>$sNote</p>";
            $oBankCard->status = BankCard::STATUS_BLACK;
            $bSucc = $oBankCard->save();
            if ($bSucc) {
                return $this->goBackToIndex('success', __('_bankcard.black-success'));
            } else {
                return $this->goBackToIndex('error', __('_bankcard.black-fail'));
            }
        } else {
            $this->setVars(compact('oBankCard'));
            return $this->render();
        }
    }

    /**
     * 取消拉黑
     * @param type $id
     */
    public function setToInUseStatus($id) {
        $oBankCard = BankCard::find($id);
        if (Request::method() == 'POST') {
            $sNote = $this->params['note'];
            if (empty($sNote)) {
                return $this->goBack('error', __('_bankcard.note-required'));
            }
            $oBankCard->note .= "<p>$sNote</p>";
            $oBankCard->status = BankCard::STATUS_IN_USE;
            $bSucc = $oBankCard->save();
            if ($bSucc) {
                return $this->goBackToIndex('success', __('_bankcard.inuse-success'));
            } else {
                return $this->goBackToIndex('error', __('_bankcard.inuse-fail'));
            }
        } else {
            $this->setVars(compact('oBankCard'));
            return $this->render();
        }
    }

}
