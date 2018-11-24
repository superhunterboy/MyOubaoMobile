<?php

class UserActivityUserPrizeController extends UserBaseController {

    protected $resourceView = 'centerUser.user';
    protected $modelName = 'ActivityUserPrize';


    protected function beforeRender() {
        parent::beforeRender();
        $iUserId = session::get('user_id');
        $iHongBaoAvailableCount = ActivityUserPrize::getAvailableHBCount($iUserId);
        $iHongBaoReceivedCount = ActivityUserPrize::getReceivedHBCount($iUserId);
        $iHongBaoExpiredCount = ActivityUserPrize::getExpiredHBCount($iUserId);
        $iHongBaoTotalCount = $iHongBaoAvailableCount + $iHongBaoReceivedCount + $iHongBaoExpiredCount;
        $this->setVars(compact('iHongBaoAvailableCount', 'iHongBaoReceivedCount', 'iHongBaoExpiredCount', 'iHongBaoTotalCount'));
    }

    public function index() {
        $this->view = $this->resourceView . '.hongbao';
        $this->params['user_id'] = Session::get('user_id');
        $this->params['status'] = [ActivityUserPrize::STATUS_SENT, ActivityUserPrize::STATUS_VERIRIED, ActivityUserPrize::STATUS_RECEVIED];
        $this->setVars('type', !key_exists('type', $this->params) ? 'pic' : array_get($this->params, 'type'));
        return parent::index();
    }

    /**
     * 暂不可领取的红包
     */
    public function unAvailableHB() {
        $this->params['user_id'] = Session::get('user_id');
        $this->params['status'] = [ActivityUserPrize::STATUS_NO_SEND, ActivityUserPrize::STATUS_ACCEPTED];
        $this->view = $this->resourceView . '.hongbao';
        $this->setVars('type', !key_exists('type', $this->params) ? 'pic' : array_get($this->params, 'type'));
        return parent::index();
    }

    /**
     * 可领取的红包
     */
    public function availableHB() {
        $this->params['user_id'] = Session::get('user_id');
        $this->params['status'] = ActivityUserPrize::STATUS_VERIRIED;
        $this->view = $this->resourceView . '.hongbao';
        $this->setVars('type', !key_exists('type', $this->params) ? 'pic' : array_get($this->params, 'type'));
        Session::put($this->redictKey, Request::fullUrl());
        return parent::index();
    }

    /**
     * 已经过期的红包
     */
    public function expiredHB() {
        $this->params['user_id'] = Session::get('user_id');
        $this->params['status'] = ActivityUserPrize::STATUS_VERIRIED;
        $this->params['expired_at'] = date('Y-m-d H:i:s');
        $this->view = $this->resourceView . '.hongbao';
        $this->setVars('type', !key_exists('type', $this->params) ? 'pic' : array_get($this->params, 'type'));
        return parent::index();
    }

    /**
     * 已领取的红包
     */
    public function receivedHB() {
        $this->params['user_id'] = Session::get('user_id');
        $this->params['status'] = ActivityUserPrize::STATUS_SENT;
        $this->view = $this->resourceView . '.hongbao';
        $this->setVars('type', !key_exists('type', $this->params) ? 'pic' : array_get($this->params, 'type'));
        return parent::index();
    }

    /**
     * 领取奖品
     * @param int $iTaskId  活动任务id
     */
    public function getPrize() {
        $oUserPrize = ActivityUserPrize::find(array_get($this->params, 'id'));
        $iUserId = Session::get('user_id');
        if (!is_object($oUserPrize)) {
            return $this->goBack('error', __('_activityuserprize.missing-data'));
        }
        if ($oUserPrize->user_id != $iUserId) {
            return $this->goBack('error', __('_activityuserprize.wrong-person'));
        }
        if ($oUserPrize->status != ActivityUserPrize::STATUS_VERIRIED) {
            return $this->goBack('error', __('_activityuserprize.wrong-status'));
        }
//        if ($oUserPrize->status == ActivityUserPrize::STATUS_SENT) {
//            return $this->goBack('error', __('_activityuserprize.sent-already'));
//        }
        if (time() > strtotime($oUserPrize->expired_at)) {
            return $this->goBack('error', __('_activityuserprize.prize-expired'));
        }
        $aExtraInfo = [
            'status' => ActivityUserPrize::STATUS_RECEVIED,
            'received_at' => date('Y-m-d H:i:s'),
        ];
        $oUserTask = ActivityUserTask::getObjectByParams(['user_id' => $iUserId, 'sign_date' => date('Y-m-d', strtotime($oUserPrize->updated_at . ' -1 days'))]);
        DB::connection()->beginTransaction();
        $bSucc = $oUserPrize->setToSent($aExtraInfo);
        $aData = json_decode($oUserPrize->data, true);
        !$bSucc or $bSucc = $oUserPrize->addPrizeTask();
        if (is_object($oUserTask)) {
            $oUserTask->prize_status = 1;
            !$bSucc or $bSucc = $oUserTask->save();
        }
        if ($bSucc) {
            DB::connection()->commit();
            $oUserPrize->flushAllCount();
            $aReturn = ['msgType' => 'success', 'money' => $aData['rebate_amount']];
        } else {
            DB::connection()->rollback();
            $aReturn = ['msgType' => 'error'];
        }
        echo json_encode($aReturn);
        exit;
    }

    /**
     * get search conditions array
     *
     * @return array
     */
    protected function & makeSearchConditions() {
        $aConditions = [];
        // pr($this->functionality->id);
        // pr($this->searchConfig);
        // pr($this->paramSettings);
//         pr($this->searchItems);
        // pr($this->params);
        // exit;

        $iCount = count($this->params);
        foreach ($this->paramSettings as $sColumn => $aParam) {
            if (!isset($this->params[$sColumn])) {
                if ($aParam['limit_when_null'] && $iCount <= 1) {
                    $aFieldInfo[1] = null;
                } else {
                    continue;
                }
            }

            $mValue = isset($this->params[$sColumn]) ? $this->params[$sColumn] : null;
            if (!is_array($mValue) && !mb_strlen($mValue) && !$aParam['limit_when_null'])
                continue;
            if (is_array($mValue) && empty($mValue[0]) && empty($mValue[1])) {
                continue;
            }
            $aPattSearch = array('!\$model!', '!\$\$field!', '!\$field!');
            $aItemConfig = & $this->searchItems[$sColumn];
            $mValue = is_array($mValue) ? implode(',', $mValue) : $mValue;
            $aPattReplace = array($aItemConfig['model'], $mValue, $aItemConfig['field']);
            $sMatchRule = preg_replace($aPattSearch, $aPattReplace, $aItemConfig['match_rule']);
            $aMatchRule = explode("\n", $sMatchRule);
            if (count($aMatchRule) > 1) {        // OR
                // todo : or
            } else {
                $aFieldInfo = array_map('trim', explode(' = ', $aMatchRule[0]));
                $aTmp = explode(' ', $aFieldInfo[0]);
                $iOperator = (count($aTmp) > 1) ? $aTmp[1] : '=';
                if (!mb_strlen($mValue) && $aParam['limit_when_null']) {
                    $aFieldInfo[1] = null;
                }
                list($tmp, $sField) = explode('.', $aTmp[0]);
                $sField{0} == '$' or $sColumn = $sField;
                if (isset($aConditions[$sColumn])) {
                    // TODO 原来的方式from/to的值和search_items表中的记录的顺序强关联, 考虑修改为自动从小到大排序的[from, to]数组
                    $arr = [$aConditions[$sColumn][1], $aFieldInfo[1]];
                    sort($arr);
                    $aConditions[$sColumn] = [ 'between', $arr];
                } else {
                    if ($aFieldInfo[1] == "NULL") {
                        $aConditions[$sColumn] = [ $iOperator, null];
                    } else {
                        $aConditions[$sColumn] = [ $iOperator, $aFieldInfo[1]];
                    }
                }
            }
        }
        return $aConditions;
    }

}
