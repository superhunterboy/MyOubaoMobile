<?php

class UserProjectController extends UserBaseController {

    protected $errorFiles = ['system', 'bet', 'fund', 'account', 'lottery', 'issue', 'seriesway'];
    protected $resourceView = 'centerUser.bet';
    protected $customViewPath = 'centerGame';
    protected $modelName = 'UserProject';

    protected function beforeRender() {
        parent::beforeRender();
        switch ($this->action) {
            case 'index':
            case 'miniWindow':
                $bHasSumRow = 1;
                $aSelectorData = $this->generateSelectorData();
                $this->setVars(compact('bHasSumRow', 'aSum', 'aSelectorData'));
                break;
            case 'view':
                $aLotteryIdentifierList = Lottery::getIdentifierList();
                $this->setVars(compact('aLotteryIdentifierList'));
                break;
        }

        $aCoefficients = Coefficient::$coefficients;
        $this->setVars(compact('aCoefficients'));
        $this->setVars('aValidStatus', UserProject::$validStatuses);
    }

    /**
     * [generateSelectorData 页面公用下拉框的生成参数]
     * @return [Array] [参数数组]
     */
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
     * [index 投注列表]
     * @return [Response] [description]
     */
    public function index() {
        $this->params = trimArray(Input::except('page', 'sort_up', 'sort_down'));
        $sUsername = Session::get('username');
        $this->params['username'] = key_exists('username', $this->params) && !empty($this->params['username']) ? $this->params['username'] : $sUsername;
        $oUser = UserUser::getObjectByParams(['username' => $this->params['username']]);
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
        if (is_object($oUser) && $oUser->id != Session::get('user_id')) {
            if (!$oUser->forefather_ids) {
                return $this->goBack('error', __('_project.search-not-allowed'));
            }
            $aParent = explode(',', $oUser->forefather_ids);
            if (!in_array(Session::get('user_id'), $aParent)) {
                return $this->goBack('error', __('_project.search-not-allowed'));
            }
        }
        if ($iCount = count($this->params)) {
            $this->generateSearchParams($this->params);
        }
        $aConditions = & $this->makeSearchConditions();
        $aPlusConditions = $this->makePlusSearchConditions();
        $aConditions = array_merge($aConditions, $aPlusConditions);
        $oQuery = $this->model->doWhere($aConditions);
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


        $sModelName = $this->modelName;
        $iPageSize = isset($this->params['pagesize']) && is_numeric($this->params['pagesize']) ? $this->params['pagesize'] : static::$pagesize;
        $datas = $oQuery->paginate($iPageSize);
        $this->setVars(compact('datas'));
        if ($sMainParamName = $sModelName::$mainParamColumn) {
            if (isset($aConditions[$sMainParamName])) {
                $$sMainParamName = is_array($aConditions[$sMainParamName][1]) ? $aConditions[$sMainParamName][1][0] : $aConditions[$sMainParamName][1];
            } else {
                $$sMainParamName = null;
            }
            $this->setVars(compact($sMainParamName));
        }
        return $this->render();
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

    /**
     * [miniWindow 投注列表mini窗口，用于彩票投注页面]
     * @return [Response] [description]
     */
    public function miniWindow($iLotteryId = '') {
        $this->setVars('datas', UserProject::getLatestRecords(Session::get('user_id'), 10, $iLotteryId));
        $this->setVars('lotteryId', $iLotteryId);
//        Input::merge(['pagesize' => 5]);
        return $this->render();
    }

    /**
     * [generateSearchParams 生成自定义查询参数]
     * @param  [Array]     & $aParams [查询参数数组的引用]
     */
    private function generateSearchParams(& $aParams) {
        if (isset($aParams['number_value']) && $aParams['number_value']) {
            $aParams[$aParams['number_type']] = $aParams['number_value'];
        }
        unset($aParams['way_group_id'], $aParams['number_type'], $aParams['number_value']);
    }

    /**
     * 撤单
     * @param int $id
     * @return Redirect
     */
    function drop($id) {
        $oProject = UserProject::find($id);
        $Redirect = Redirect::route('projects.view', ['id' => $oProject->id]);
        $oMessage = new Message($this->errorFiles);
        if (empty($oProject)) {
            return $Redirect->with('error', $oMessage->getResponseMsg(Project::ERRNO_PROJECT_MISSING));
        }
        if (Session::get('user_id') != $oProject->user_id) {
            return $Redirect->with('error', $oMessage->getResponseMsg(Project::ERRNO_DROP_ERROR_NOT_YOURS));
        }
        $oAccount = Account::lock($oProject->account_id, $iLocker);
        if (empty($oAccount)) {
            return $Redirect->with('error', $oMessage->getResponseMsg(Account::ERRNO_LOCK_FAILED));
        }
        DB::connection()->beginTransaction();
        $this->writeLog('begin DB Transaction');
        if (($iReturn = $oProject->drop()) != Project::ERRNO_DROP_SUCCESS) {
            $this->writeLog($iReturn);
            DB::connection()->rollback();
            $this->writeLog('Rollback');
            Account::unLock($oAccount->id, $iLocker, false);
            return $Redirect->with('error', $oMessage->getResponseMsg($iReturn));
            exit;
        }
        DB::connection()->commit();
        $this->writeLog('Commit');
        $oProject->addTurnoverStatTask(false);    // 建立销售量更新任务
        Account::unLock($oAccount->id, $iLocker, false);
        return Redirect::route('projects.view', ['id' => $oProject->id])->with('success', __('_project.droped'));
    }

}
