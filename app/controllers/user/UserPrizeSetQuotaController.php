<?php

class UserPrizeSetQuotaController extends AdminBaseController {

    /**
     * 资源模型名称
     * @var string
     */
    protected $modelName = 'UserPrizeSetQuota';
    protected $customViewPath = 'userPrizeSet.quota';
    protected $customViews = [
        'addQuota',
    ];

    /**
     * 增加用户配额
     * @param int $userId  用户id
     */
    public function addQuota($id) {
        if (Request::method() == 'POST') {
            $oQuota = UserPrizeSetQuota::find(array_get($this->params, 'id'));
            if (!is_object($oQuota)) {
                return $this->goBack('error', __('_userprizesetquota.missing-data'));
            }
            $oUser = User::find($oQuota->user_id);
            if (!is_object($oUser) || $oUser->parent != null) {
                return $this->goBack('error', __('_userprizesetquota.top-agent-allowed'));
            }
            if ($oQuota->username != array_get($this->params, 'username')) {
                return $this->goBack('error', __('_userprizesetquota.wrong-username'));
            }
            if (array_get($this->params, 'quota_add') < 0) {
                return $this->goBack('error', __('_userprizesetquota.quota-more-than-zero'));
            }
            $oQuota->left_quota += array_get($this->params, 'quota_add');
            $oQuota->total_quota += array_get($this->params, 'quota_add');
            $bSucc = $oQuota->save();
            if ($bSucc) {
                return $this->goBackToIndex('success', __('_userprizesetquota.quota-add-success'));
            } else {
                return $this->goBack('error', __('_userprizesetquota.quota-add-error'));
            }
        } else {
            $oQuota = UserPrizeSetQuota::find($id);
            $this->setVars(compact('oQuota'));
            return $this->render();
        }
    }

}
