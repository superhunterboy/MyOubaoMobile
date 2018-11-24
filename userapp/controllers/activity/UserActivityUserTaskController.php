<?php

class UserActivityUserTaskController extends UserBaseController {

    protected $modelName = 'ActivityUserTask';

    /**
     * 参加活动报名
     * @param int $iTaskId  活动任务id
     */
    public function signTask($iTaskId) {
        if ($iTaskId == 8) {
            $this->jsonEcho(['msgType' => 'error', 'msg' => __('_activitytask.wroing-task')]);
        }
        $date = date('Y-m-d');
        $iUserId = Session::get('user_id');

        $oActivityTask = ActivityTask::find($iTaskId);
        if (!is_object($oActivityTask)) {
            return $this->goBack('error', __('_activitytask.missing-data'));
        }
        if (!$oActivityTask->isValidateTask()) {
            $this->jsonEcho(['msgType' => 'error', 'msg' => __('_activitytask.task_expired')]);
        }
        $aParams = [
            'user_id' => $iUserId,
            'task_id' => $iTaskId,
            'sign_date' => $date,
        ];
        $oUserActivityTask = ActivityUserTask::getObjectByParams($aParams);
        if (is_object($oUserActivityTask) && $oUserActivityTask->is_signed) {
            $this->jsonEcho(['msgType' => 'error', 'msg' => __('_activityusertask.signed-already')]);
        }
        $oUserActivityTask = new ActivityUserTask;
        $aExtraInfo = [
            'activity_id' => $oActivityTask->activity_id,
            'is_signed' => 1,
            'signed_time' => date('Y-m-d H:i:s'),
        ];
        $oUserActivityTask->fill(array_merge($aParams, $aExtraInfo));
        $bSucc = $oUserActivityTask->save();
        if ($bSucc) {
            $this->jsonEcho(['msgType' => 'success', 'msg' => __('_activityusertask.sign-success')]);
        } else {
            $this->jsonEcho(['msgType' => 'error', 'msg' => __('_activityusertask.sign-failed')]);
        }
    }
    
    /**
     * 参加打量送真金活动
     * @param int $iTaskId  活动任务id
     */
    public function signTaskforDailyMoney($iTaskId) {
        if ($iTaskId != 9) {
            $this->jsonEcho(['msgType' => 'error', 'msg' => __('_activitytask.wroing-task')]);
        }
        $iUserId = Session::get('user_id');

        $oActivityTask = ActivityTask::find($iTaskId);
        if (!is_object($oActivityTask)) {
            $this->jsonEcho(['msgType' => 'error', 'msg' => __('_activitytask.missing-data')]);
        }
        if (!$oActivityTask->isValidateTask()) {
            $this->jsonEcho(['msgType' => 'error', 'msg' => __('_activitytask.task_expired')]);
        }
        $aParams = [
            'user_id' => $iUserId,
            'task_id' => $iTaskId,
            'sign_date' => date('Y-m-d'),
        ];
        $oUserActivityTask = ActivityUserTask::getObjectByParams($aParams);
        if (is_object($oUserActivityTask) && $oUserActivityTask->is_signed) {
            $this->jsonEcho(['msgType' => 'repeatjoin', 'msg' => __('您已经报名')]);
        }
        $oDeposit = UserDeposit::getCurrentDayDeposit($iUserId,1000);
        if(!is_object($oDeposit)){
            $this->jsonEcho(['msgType' => 'unrecharged', 'msg' => __('充值金额不满足条件，单笔>=1000')]);
        }
        $oUserActivityTask = new ActivityUserTask;
        $aExtraInfo = [
            'activity_id' => $oActivityTask->activity_id,
            'is_signed' => 1,
            'signed_time' => date('Y-m-d H:i:s'),
        ];
        $oUserActivityTask->fill(array_merge($aParams, $aExtraInfo));
        $bSucc = $oUserActivityTask->save();
        if ($bSucc) {
            $this->jsonEcho(['msgType' => 'success', 'msg' => __('_activityusertask.sign-success')]);
        } else {
            $this->jsonEcho(['msgType' => 'error', 'msg' => __('_activityusertask.sign-failed')]);
        }
    }
    

    /**
     * 参加注册送38元活动报名，一次性活动
     * @param int $iTaskId  活动任务id
     */
    public function signTaskforRegist($iTaskId) {
        if ($iTaskId != 8) {
            $this->jsonEcho(['msgType' => 'error', 'msg' => __('_activitytask.wroing-task')]);
        }
        $iUserId = Session::get('user_id');

        $oActivityTask = ActivityTask::find($iTaskId);
        if (!is_object($oActivityTask)) {
            return $this->goBack('error', __('_activitytask.missing-data'));
        }
        if (!$oActivityTask->isValidateTask()) {
            $this->jsonEcho(['msgType' => 'error', 'msg' => __('_activitytask.task_expired')]);
        }
        $aUserBankCard = UserBankCard::where('user_id', '=', $iUserId)->get();
        $oUser = User::find($iUserId);
        if (!$oActivityTask->isValidateTask($oUser->register_at)) {
            $this->jsonEcho(['msgType' => 'olduser', 'msg' => __('_activitytask.user_expired')]);
        }
        if (!UserUserBankCard::getUserBankCardsCount($iUserId)) {
            $this->jsonEcho(['msgType' => 'nobankcard', 'msg' => __('_activitytask.no_bank_card')]);
        }

        $bSucc = true;
        foreach ($aUserBankCard as $oUserBankCard) {
            if (is_object($oUserBankCard)) {
                $oUserCondition = ActivityUserCondition::getObjectByParams(['data' => $oUserBankCard->account]);
                if (is_object($oUserCondition)) {
                    $bSucc = false;
                    break;
                }
            }
        }
        if (!$bSucc) {
            $this->jsonEcho(['msgType' => 'wrongbankcard', 'msg' => __('_activitytask.wrong-bank-card')]);
        }

        $aParams = [
            'user_id' => $iUserId,
            'task_id' => $iTaskId,
        ];
        $oUserActivityTask = ActivityUserTask::getObjectByParams($aParams);
        if (is_object($oUserActivityTask) && $oUserActivityTask->is_signed) {
            $this->jsonEcho(['msgType' => 'repeatjoin', 'msg' => __('_activityusertask.signed-already')]);
        }
        $oUserActivityTask = new ActivityUserTask;
        $aExtraInfo = [
            'activity_id' => $oActivityTask->activity_id,
            'is_signed' => 1,
            'signed_time' => date('Y-m-d H:i:s'),
            'sign_date' => date('Y-m-d'),
        ];
        $oUserActivityTask->fill(array_merge($aParams, $aExtraInfo));
        $bSucc = $oUserActivityTask->save();
        if ($bSucc) {
            $this->jsonEcho(['msgType' => 'success', 'msg' => __('_activityusertask.sign-success')]);
        } else {
            $this->jsonEcho(['msgType' => 'error', 'msg' => __('_activityusertask.sign-failed')]);
        }
    }

    /**
     * 进入用户活动首页
     */
    public function getUserTask() {
        Session::put($this->redictKey, Request::fullUrl());
        $iUserId = Session::get('user_id');
        $oUserTask = ActivityUserTask::getObjectByParams(['user_id' => $iUserId, 'sign_date' => date('Y-m-d'), 'task_id' => 6]);
        if (is_object($oUserTask) && $oUserTask->is_signed) {
            $bTaskIsOpen = true;
            $oData = json_decode($oUserTask->data);
            $fDepoistAmount = !is_object($oData) ? 0 : $oData->amount;
            $fTurnover = !is_object($oData) ? 0 : $oData->turnover;
        } else {
            $bTaskIsOpen = false;
            $fDepoistAmount = 0;
            $fTurnover = 0;
        }
//        pr(var_dump($bTaskIsOpen));
//        pr(var_dump($fDepoistAmount));
//        pr(var_dump($fPercent));
        $iDefaultPaymentPlatformId = PaymentPlatform::getDefaultPlatformId();
        $sJsonActivityRecords = $this->createActivityRecords($iUserId);
        $sCurTime = date('D M d Y H:i:s');
        return View::make('events.dashengqujing.index')->with(compact('bTaskIsOpen', 'fDepoistAmount', 'fTurnover', 'iDefaultPaymentPlatformId', 'sJsonActivityRecords', 'sCurTime'));
    }
    /**
     * 进入中秋活动首页
     */
    public function mooncakeTask() {
        Session::put($this->redictKey, Request::fullUrl());
        $iUserId = Session::get('user_id');
        $oUserTask = ActivityUserTask::getObjectByParams(['user_id' => $iUserId, 'sign_date' => date('Y-m-d'), 'task_id' => 6]);
        if (is_object($oUserTask) && $oUserTask->is_signed) {
            $bTaskIsOpen = true;
            $oData = json_decode($oUserTask->data);
            $fDepoistAmount = !is_object($oData) ? 0 : $oData->amount;
            $fTurnover = !is_object($oData) ? 0 : $oData->turnover;
        } else {
            $bTaskIsOpen = false;
            $fDepoistAmount = 0;
            $fTurnover = 0;
        }
//        pr(var_dump($bTaskIsOpen));
//        pr(var_dump($fDepoistAmount));
//        pr(var_dump($fPercent));
        $iDefaultPaymentPlatformId = PaymentPlatform::getDefaultPlatformId();
        $sJsonActivityRecords = $this->createActivityRecords($iUserId);
        $sCurTime = date('D M d Y H:i:s');
        return View::make('events.mooncake.index')->with(compact('bTaskIsOpen', 'fDepoistAmount', 'fTurnover', 'iDefaultPaymentPlatformId', 'sJsonActivityRecords', 'sCurTime'));;
    }

    /**
     * 进入用户活动首页
     */
    public function registTask() {
        Session::put($this->redictKey, Request::fullUrl());
        $iUserId = Session::get('user_id');
        $oUserTask = ActivityUserTask::getObjectByParams(['user_id' => $iUserId, 'task_id' => 8]);
        if (is_object($oUserTask) && $oUserTask->is_signed) {
            $bTaskIsOpen = true;
            $oData = json_decode($oUserTask->data);
            $fDepoistAmount = !is_object($oData) ? 0 : $oData->amount;
            $fTurnover = !is_object($oData) ? 0 : $oData->turnover;
        } else {
            $bTaskIsOpen = false;
            $fDepoistAmount = 0;
            $fTurnover = 0;
        }
//        pr(var_dump($bTaskIsOpen));
//        pr(var_dump($fDepoistAmount));
//        pr(var_dump($fPercent));
        $iDefaultPaymentPlatformId = PaymentPlatform::getDefaultPlatformId();
        $sJsonActivityRecords = $this->createActivityRecords($iUserId);
        $sCurTime = date('D M d Y H:i:s');
        return View::make('events.newuser_gift.index')->with(compact('bTaskIsOpen', 'fDepoistAmount', 'fTurnover', 'iDefaultPaymentPlatformId', 'sJsonActivityRecords', 'sCurTime'));
    }

    /**
     * 获取指定用户的任务完成情况
     */
    public function getAllUserTasks() {
        $iUserId = Session::get('user_id');
        $aUserTasks = ActivityUserTask::getAllUserTasksByUser($iUserId);
        $this->setVars(compact('aUserTasks'));
        return $this->render();
    }

    /**
     * 创建活动记录
     */
    public function createActivityRecords($iUserId) {
        $aUserTask = ActivityUserTask::getAllUserTasksByUser($iUserId);
        $aUserTasks = [];
        foreach ($aUserTask as $oUserTask) {
            $aUserTask = [];
            $aUserTask['date'] = $oUserTask->sign_date;
            $aUserTask['tasktime'] = date('H:i:s', strtotime($oUserTask->signed_time));
            $aData = json_decode($oUserTask->data, true);
            $aUserTask['recharge'] = array_get($aData, 'amount');
            $aUserTask['bet'] = array_get($aData, 'turnover');
            $aUserTask['hongbao'] = array_get($aData, 'bonus') ? array_get($aData, 'bonus') : 0;
            $aUserTask['status'] = $oUserTask->prize_status ? 1 : 0;
            $aUserTasks[] = $aUserTask;
        }
        return json_encode($aUserTasks);
    }
    
      /**
     * 参加注册送38元活动报名，一次性活动
     * @param int $iTaskId  活动任务id
     */
    public function signTaskforMooncake($iTaskId) {
        if ($iTaskId != 10) {
            $this->jsonEcho(['msgType' => 'error', 'msg' => __('_activitytask.wroing-task')]);
        }
        $iUserId = Session::get('user_id');

        $oActivityTask = ActivityTask::find($iTaskId);
        if (!is_object($oActivityTask)) {
            return $this->goBack('error', __('_activitytask.missing-data'));
        }
        if (!$oActivityTask->isValidateTask()) {
            $this->jsonEcho(['msgType' => 'error', 'msg' => __('_activitytask.task_expired')]);
        }
        $oUser = User::find($iUserId);
        if (!$oActivityTask->isValidateTask($oUser->register_at)) {
            $this->jsonEcho(['msgType' => 'olduser', 'msg' => __('_activitytask.user_expired')]);
        }
        if (!UserUserBankCard::getUserBankCardsCount($iUserId)) {
            $this->jsonEcho(['msgType' => 'nobankcard', 'msg' => __('_activitytask.no_bank_card')]);
        }

        $aParams = [
            'user_id' => $iUserId,
            'task_id' => $iTaskId,
        ];
        $oUserActivityTask = ActivityUserTask::getObjectByParams($aParams);
        if (is_object($oUserActivityTask) && $oUserActivityTask->is_signed) {
            $this->jsonEcho(['msgType' => 'repeatjoin', 'msg' => __('_activityusertask.signed-already')]);
        }
        $oUserActivityTask = new ActivityUserTask;
        $aExtraInfo = [
            'activity_id' => $oActivityTask->activity_id,
            'is_signed' => 1,
            'signed_time' => date('Y-m-d H:i:s'),
            'sign_date' => date('Y-m-d'),
        ];
        $oUserActivityTask->fill(array_merge($aParams, $aExtraInfo));
        $bSucc = $oUserActivityTask->save();
        if ($bSucc) {
            $this->jsonEcho(['msgType' => 'success', 'msg' => __('_activityusertask.sign-success')]);
        } else {
            $this->jsonEcho(['msgType' => 'error', 'msg' => __('_activityusertask.sign-failed')]);
        }
    }

}
