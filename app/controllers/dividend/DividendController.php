<?php

class DividendController extends AdminBaseController {

    /**
     * 需要加载的错误码定义文件
     * @var array
     */
    protected $errorFiles = ['account', 'system'];
    protected $customViewPath = 'fund.dividend';
    protected $customViews = [
        'index'
    ];

    /**
     * 资源模型名称
     * @var string
     */
    protected $modelName = 'Dividend';

    /**
     * 在渲染前执行，为视图准备变量
     */
    protected function beforeRender() {
        parent::beforeRender();
        $this->setVars('aStatus', Dividend::$aStatus);
        switch ($this->action) {
            case 'index':
                $this->resourceView = 'fund.dividend';
                for ($i = 1, $aMonth = []; $i <= 12; $aMonth[$i] = $i, $i++)
                    ;
                $this->setVars(compact('aMonth'));
            case 'view':
            case 'edit':
            case 'create':
                break;
        }
    }

    /**
     * 分红审核
     * @param type $id      分红 id
     */
    public function audit($id) {
        $oDividend = Dividend::find($id);
        if ($oDividend->status != Dividend::STATUS_WAITING_AUDIT) {
            return $this->goBackToIndex('error', __('_dividend.status-error'));
        }
        if (!is_object($oDividend)) {
            return $this->goBack('error', __('_dividend.missing-dividend'));
        }
        $oDividend->status = Dividend::STATUS_AUDIT_FINISH;
        $oDividend->auditor_id = Session::get('admin_user_id');
        $oDividend->auditor = Session::get('admin_username');
        $oDividend->verified_at = date('Y-m-d H:i:s');
        $bSucc = $oDividend->save();
        if ($bSucc) {
            if (SysConfig::check('dividend_auto_send_after_audited', true)) {
                return $this->send($id);
            }
            return $this->goBackToIndex('success', __('_dividend.dividend-audited'));
        } else {
            return $this->goBack('error', __('_dividend.dividend-audited-fail'));
        }
    }

    /**
     * 派发分红
     * @param type $id      分红 id
     */
    public function send($id) {
        $oDividend = Dividend::find($id);
        if ($oDividend->status != Dividend::STATUS_AUDIT_FINISH) {
            return $this->goBackToIndex('error', __('_dividend.status-error'));
        }
        if (!is_object($oDividend)) {
            return $this->goBack('error', __('_dividend.missing-dividend'));
        }
        $oUser = User::find($oDividend->user_id);
        if (!is_object($oUser)) {
            return $this->goBack('error', __('_user.missing-user'));
        }
        $oAccount = Account::lock($oUser->account_id, $iLocker);
        if (empty($oAccount)) {
            $oMessage = new Message($this->errorFiles);
            return $this->goBack('error', $oMessage->getResponseMsg(Account::ERRNO_LOCK_FAILED));
        }
        DB::connection()->beginTransaction();
        $bSucc = Transaction::addTransaction($oUser, $oAccount, TransactionType::TYPE_SEND_DIVIDEND, $oDividend->amount) == Transaction::ERRNO_CREATE_SUCCESSFUL ? true : false;
        if ($bSucc) {
            $oDividend->status = Dividend::STATUS_BONUS_SENT;
            $oDividend->sent_at = date('Y-m-d H:i:s');
            $bSucc = $oDividend->save();
            $bSucc ? DB::connection()->commit() : DB::connection()->rollback();
        }
        Account::unLock($oUser->account_id, $iLocker, false);
        if ($bSucc) {
            return $this->goBackToIndex('success', __('_dividend.dividend-sent'));
        } else {
            return $this->goBack('error', __('_dividend.dividend-sent-fail'));
        }
    }

    /**
     * 拒绝审核
     * @param type $id      dividend id
     */
    public function reject($id) {
        $oDividend = Dividend::find($id);
        if ($oDividend->status != Dividend::STATUS_WAITING_AUDIT) {
            return $this->goBackToIndex('error', __('_dividend.status-error'));
        }
        $aValidateData = ['note' => array_get($this->params, 'note')];
        $aValidateRule = ['note' => Dividend::$rules['note']];
        $validator = Validator::make($aValidateData, $aValidateRule);
        if (!$validator->passes()) {
            return $this->goBack('error', __('_dividend.note-validate-error'));
        }
        if (is_object($oDividend)) {
            $oDividend->status = Dividend::STATUS_AUDIT_REJECT;
            $oDividend->note = $this->params['note'];
            $oDividend->auditor_id = Session::get('admin_user_id');
            $oDividend->auditor = Session::get('admin_username');
            $oDividend->verified_at = date('Y-m-d H:i:s');
            $bSucc = $oDividend->save();
            if ($bSucc) {
                return $this->goBackToIndex('success', __('_dividend.dividend-rejected'));
            } else {
                return $this->goBackToIndex('error', __('_dividend.dividend-rejected-fail'));
            }
        } else {
            return $this->goBackToIndex('error', __('_dividend.missing-dividend'));
        }
    }

}
