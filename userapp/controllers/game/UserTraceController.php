<?php

# 追号

class UserTraceController extends UserBaseController {

    protected $resourceView = 'centerUser.trace';
    protected $modelName = 'UserTrace';

    protected function beforeRender() {
        parent::beforeRender();
        $aValidStatus = Project::$validStatuses;
        $aBoolDesc = Config::get('var.boolean');
        $this->setVars(compact('aValidStatus', 'aBoolDesc'));
        switch ($this->action) {
            case 'index':
            case 'miniWindow':
                $bHasSumRow = 1;
                $aSelectorData = $this->generateSelectorData();
                $this->setVars(compact('bHasSumRow', 'aSelectorData'));
                break;
            case 'view':
                $aLotteryIdentifierList = Lottery::getIdentifierList();
                $this->setVars(compact('aLotteryIdentifierList'));
                break;
        }

        $aCoefficients = Coefficient::$coefficients;
//        $aLotteries = & Lottery::getTitleList();
        $this->setVars(compact('aCoefficients'));
    }

    /**
     * [index 自定义追号记录列表查询, 代理用户需要可以查询其子用户的记录]
     * @return [Response] [description]
     */
    public function index() {
        $this->params = trimArray(Input::except('page', 'sort_up', 'sort_down'));
        if ($iCount = count($this->params)) {
            $this->generateSearchParams($this->params);
        }
        if (!key_exists('bought_at_from', $this->params) && !key_exists('bought_at_to', $this->params)) {
            $this->params['bought_at_to'] = date('Y-m-d 00:00:00');
            $this->params['bought_at_from'] = date('Y-m-d H:i:s');
        }
        if (!array_get($this->params, 'bought_at_from') && !array_get($this->params, 'bought_at_to')) {
            $this->params['bought_at_to'] = date('Y-m-d 00:00:00');
            $this->params['bought_at_from'] = date('Y-m-d H:i:s');
        }
        // 查询时间不能大于30天
        if (strtotime($this->params['bought_at_to']) - strtotime($this->params['bought_at_from']) > 2592000) {
            return $this->goBack('error', '查询时间范围不能超过30天');
        }
        $sUsername = Session::get('username');
        $this->params['username'] = key_exists('username', $this->params) && !empty($this->params['username']) ? $this->params['username'] : $sUsername;
        $oUser = UserUser::getObjectByParams(['username' => $this->params['username']]);
        if (is_object($oUser) && $oUser->id != Session::get('user_id')) {
            if (!$oUser->forefather_ids) {
                return $this->goBack('error', __('_project.search-not-allowed'));
            }
            $aParent = explode(',', $oUser->forefather_ids);
            if (!in_array(Session::get('user_id'), $aParent)) {
                return $this->goBack('error', __('_project.search-not-allowed'));
            }
        }
        return parent::index();
    }

    public function indexQuery() {
        $aConditions = & $this->makeSearchConditions();
        $aPlusConditions = $this->makePlusSearchConditions();
        $aConditions = array_merge($aConditions, $aPlusConditions);
        $oQuery = $aConditions ? $this->model->doWhere($aConditions) : $this->model;
        // TODO 查询软删除的记录, 以后需要调整到Model层
        $bWithTrashed = trim(Input::get('_withTrashed', 0));
        // pr($bWithTrashed);exit;
        if ($bWithTrashed)
            $oQuery = $oQuery->withTrashed();
        if ($sGroupByColumn = Input::get('group_by')) {
            $oQuery = $this->model->doGroupBy($oQuery, [$sGroupByColumn]);
        }
        // 获取排序条件
        $aOrderSet = [];
        if ($sOorderColumn = Input::get('sort_up', Input::get('sort_down'))) {
            $sDirection = Input::get('sort_up') ? 'asc' : 'desc';
            $aOrderSet[$sOorderColumn] = $sDirection;
        }
        $oQuery = $this->model->doOrderBy($oQuery, $aOrderSet);
        return $oQuery;
    }

    /**
     * 账变搜索中附件的搜索条件
     */
    public function makePlusSearchConditions() {
        $aPlusConditions = [];
        // 包含下级
        if (isset($this->params['un_include_children']) && $this->params['un_include_children'] && !empty($this->params['username'])) {
            $aUserIds = User::getAllUsersBelongsToAgentByUsername($this->params['username'], isset($this->params['un_include_children']));
            if (count($aUserIds) > 0) {
                $aPlusConditions['user_id'] = ['in', $aUserIds];
            } else {
                $aPlusConditions['username'] = ['=', $this->params['username']];
            }
        } else if (!empty($this->params['username'])) {
            // 不包含下级
            $aPlusConditions['username'] = ['=', $this->params['username']];
        }
        return $aPlusConditions;
    }

//    public function miniWindow() {
//        Input::merge(['pagesize' => 5]);
//        return $this->index();
//    }

    /**
     * [view 查看追号记录的详情]
     * @param  [Integer] $id [追号记录id]
     * @return [Response]     [description]
     */
    public function view($id) {
        $aTraceDetailList = TraceDetail::getListByTraceId($id, 10);
        $this->setVars(compact('aTraceDetailList'));
        return parent::view($id);
    }

    /**
     * 终止追号任务
     * @param int $iTraceId
     * @return Redirect
     */
    public function stop($iTraceId) {
        $oTrace = Trace::find($iTraceId);
        if (empty($oTrace)) {
            $this->goBack('error', __('_basic.no-data'));
        }
        if ($oTrace->user_id != Session::get('user_id')) {
            return Redirect::route('traces.view', $iTraceId)->with('error', __('_trace.stop-failed'));
        }
        if ($oTrace->status != Trace::STATUS_RUNNING) {
            return Redirect::route('traces.view', $iTraceId)->with('error', __('_trace.stop-failed-status'));
        }
        $oAccount = Account::lock($oTrace->account_id, $iLocker);
        if (empty($oAccount)) {
            return Redirect::route('traces.view', $iTraceId)->with('error', __('_trace.stop-failed'));
        }
        $oUser = User::find($oTrace->user_id);
        $oTrace->setAccount($oAccount);
        $oTrace->setUser($oUser);
        $DB = DB::connection();
        $DB->beginTransaction();
        if (($iReturn = $oTrace->terminate()) === true) {
            $DB->commit();
            $sLangKey = '_trace.stoped';
            $sMsgType = 'success';
        } else {
            $DB->rollback();
            $sLangKey = '_trace.stop-failed';
            $sMsgType = 'error';
        }
        Account::unLock($oTrace->account_id, $iLocker, false);
        return Redirect::route('traces.view', $iTraceId)->with($sMsgType, __($sLangKey));
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
            return Redirect::route('traces.view', $iTraceId)->with('error', __('_trace.detail-not-canceled'));
        }
        $oAccount = Account::lock($oTrace->account_id, $iLocker);
        if (empty($oAccount)) {
            return Redirect::route('traces.view', $iTraceId)->with('error', __('_trace.detail-not-canceled'));
        }
        $oUser = User::find($oTrace->user_id);
        $oTrace->setAccount($oAccount);
        $oTrace->setUser($oUser);
        $DB = DB::connection();
        $DB->beginTransaction();
        if (($iReturn = $oTrace->cancelDetail($aDetailId)) == Trace::ERRNO_DETAIL_CANCELED) {
            $DB->commit();
            $sLangKey = '_trace.detail-canceled';
            $sMsgType = 'success';
        } else {
            $DB->rollback();
            $sLangKey = '_trace.detail-not-canceled';
            $sMsgType = 'error';
        }
        Account::unLock($oTrace->account_id, $iLocker, false);
        return Redirect::route('traces.view', $iTraceId)->with($sMsgType, __($sLangKey));
//        return $this->goBack($sMsgType,__($sLangKey));
    }

    private function generateSearchParams(& $aParams) {
        if (isset($aParams['number_type']) && isset($aParams['number_value'])) {
            $aParams[$aParams['number_type']] = $aParams['number_value'];
        }
        unset($aParams['way_group_id'], $aParams['number_type'], $aParams['number_value']);
    }

    private function generateSelectorData() {
        $aSelectColumn = [
            ['name' => 'lottery_id', 'emptyDesc' => '所有游戏', 'desc' => '游戏名称：'],
            ['name' => 'way_group_id', 'emptyDesc' => '所有玩法群', 'desc' => '玩法群：'],
            ['name' => 'way_id', 'emptyDesc' => '所有玩法', 'desc' => '玩法：'],
        ];

        $aSelectorData = [
            'aSelectColumn' => $aSelectColumn,
            'sFirstNameKey' => 'name',
            'sSecondNameKey' => 'title',
            'sThirdNameKey' => 'title',
            'sDataFile' => 'series-way-groups-way-group-ways',
            'sExtraDataFile' => 'lottery-series',
            'sSelectedFirst' => trim(Input::get('lottery_id')),
            'sSelectedSecond' => trim(Input::get('way_group_id')),
            'sSelectedThird' => trim(Input::get('way_id')),
        ];
        return $aSelectorData;
    }

    /**
     * [miniWindow 投注列表mini窗口，用于彩票投注页面]
     * @return [Response] [description]
     */
    public function miniWindow() {
        $this->setVars('datas', UserTrace::getLatestRecords(Session::get('user_id')));
//        Input::merge(['pagesize' => 5]);
        return $this->render();
    }

}
