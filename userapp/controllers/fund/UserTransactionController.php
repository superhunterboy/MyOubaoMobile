<?php

class UserTransactionController extends UserBaseController {

    protected $resourceView = 'centerUser.transaction';
    protected $modelName = 'UserTransaction';
    private static $aTransactionTypeMyDeposit = [1, 18];
    private static $aTransactionTypeMyWithdraw = [2, 19];
    private static $aTransactionTypeMyTransfer = [3, 4];

    protected function beforeRender() {
        parent::beforeRender();

        $aCoefficients = Coefficient::$coefficients;
//        $aLotteries    = & Lottery::getTitleList();
        $aSeriesWays = & SeriesWay::getTitleList(); // TODO
        switch ($this->action) {
            case 'index':
                $this->setVars('reportName', 'transaction');
                break;
            case 'myDeposit':
                $this->action = 'index';
                $this->setVars('reportName', 'deposit');
                $this->setVars('transactionType', self::$aTransactionTypeMyDeposit);
                break;
            case 'myWithdraw':
                $this->action = 'index';
                $this->setVars('reportName', 'withdraw');
                $this->setVars('transactionType', self::$aTransactionTypeMyWithdraw);
                break;
            case 'myTransfer':
                $this->action = 'index';
                $this->setVars('reportName', 'transfer');
                $this->setVars('transactionType', self::$aTransactionTypeMyTransfer);
                break;
            case 'view':
                // $bHasSumRow = 1;
                // $aNeedSumColumns = ['amount', 'transaction_charge', 'transaction_amount'];
                // $aSum = $this->getColumnSum($aNeedSumColumns);
//                $aSum = $this->getSumData(['amount'], true);
                break;
        }
        $aTransactionTypes = TransactionType::getAllTransactionTypes();
        $aSelectorData = $this->generateSelectorData();
        // pr($aTransactionTypes);exit;
        $this->setVars(compact('aCoefficients', 'aSeriesWays', 'aTransactionTypes', 'aSelectorData'));
    }

    /**
     * [index 自定义资金列表查询, 代理用户需要可以查询其子用户的记录]
     * @return [Response] [description]
     */
    public function index($iUserId = null) {
        $this->params = trimArray(Input::except('page', 'sort_up', 'sort_down'));
        if ($iCount = count($this->params))
            $this->generateSearchParams($this->params);
        if (!key_exists('created_at_from', $this->params) && !key_exists('created_at_to', $this->params)) {
            $this->params['created_at_from'] = date('Y-m-d 00:00:00');
            $this->params['created_at_to'] = date('Y-m-d H:i:s');
        }
        if (!array_get($this->params, 'created_at_from') && !array_get($this->params, 'created_at_to')) {
            $this->params['created_at_from'] = date('Y-m-d 00:00:00');
            $this->params['created_at_to'] = date('Y-m-d H:i:s');
        }
        // 查询时间不能大于30天
        if (strtotime($this->params['created_at_to']) - strtotime($this->params['created_at_from']) > 2592000) {
            return $this->goBack('error', '查询时间范围不能超过30天');
        }
        if ($iUserId) {
            $this->params['user_id'] = $iUserId;
            $sJumpUsername = User::find($iUserId)->username;
            $this->setVars('sJumpUsername', $sJumpUsername);
        } else {
            if (Session::get('is_agent')) {
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
            }else{
                $this->params['user_id'] = Session::get('user_id');
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

    /**
     * [generateSearchParams 生成自定义查询参数]
     * @param  [Array]     & $aParams [查询参数数组的引用]
     */
    private function generateSearchParams(& $aParams) {
        if (isset($aParams['number_type']) && isset($aParams['number_value'])) {
            $aParams[$aParams['number_type']] = $aParams['number_value'];
        }
        unset($aParams['way_group_id'], $aParams['number_type'], $aParams['number_value']);
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

    public function myDeposit($iUserId = null) {

        if (!isset($this->params['type_id'])) {
            $this->params['type_id'] = implode(',', self::$aTransactionTypeMyDeposit);
        } else {
            in_array($this->params['type_id'], self::$aTransactionTypeMyDeposit) or $this->params['type_id'] = implode(',', self::$aTransactionTypeMyDeposit);
        }
        $this->params['user_id'] = Session::get('user_id');
        return parent::index();
    }

    public function myWithdraw($iUserId = null) {
        if (!isset($this->params['type_id'])) {
            $this->params['type_id'] = implode(',', self::$aTransactionTypeMyWithdraw);
        } else {
            in_array($this->params['type_id'], self::$aTransactionTypeMyWithdraw) or $this->params['type_id'] = implode(',', self::$aTransactionTypeMyWithdraw);
        }
        $this->params['user_id'] = Session::get('user_id');
        return parent::index();
    }

    public function myTransfer($iUserId = null) {
        $aTransactionTransfer = implode(',', self::$aTransactionTypeMyTransfer);
        if (!isset($this->params['type_id'])) {
            $this->params['type_id'] = $aTransactionTransfer;
        } else {
            in_array($this->params['type_id'], self::$aTransactionTypeMyTransfer) or $this->params['type_id'] = $aTransactionTransfer;
        }
        $this->params['user_id'] = Session::get('user_id');
        return parent::index();
    }

    public function miniWindow() {
//        Input::merge(['pagesize' => 5]);
        $this->setVars('datas', UserTransaction::getLatestRecords(Session::get('user_id')));
        return $this->render();
    }

}
