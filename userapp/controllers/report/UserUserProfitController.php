<?php

# 用户盈亏报表管理

class UserUserProfitController extends UserBaseController {

    protected $resourceView = 'centerUser.user_profit';
    protected $modelName = 'UserProfit';
    public $resourceName = '';

    public function beforeRender() {
        parent::beforeRender();
        switch ($this->action) {
            case 'index':
                $aUserTypes = User::$aUserTypes;
                $this->setVars(compact('aUserTypes'));
                $this->setVars('reportName', 'profit');
                break;
            case 'commission':
                $this->setVars('reportName', 'commission');
                break;
            case 'myself':
                $this->setVars('reportName', 'myself');
                break;
        }
    }

    /**
     * [index 查询用户的盈亏报表]
     * @return [Response]          [description]
     */
    public function index() {
        $sUsername = Session::get('username');
        if (Session::get('is_agent')) {
            if (!key_exists('date_from', $this->params) && !key_exists('date_to', $this->params)) {
                $this->params['date_from'] = date('Y-m-d', strtotime('-6 days'));
                $this->params['date_to'] = date('Y-m-d');
            }
            if (!array_get($this->params, 'date_from') && !array_get($this->params, 'date_to')) {
                $this->params['date_from'] = date('Y-m-d', strtotime('-6 days'));
                $this->params['date_to'] = date('Y-m-d');
            }
            if (array_get($this->params, 'date_from') && array_get($this->params, 'date_to') && array_get($this->params, 'date_from') > array_get($this->params, 'date_to')) {
                return $this->goBack('error', '开始日期不能大于结束日期');
            }
            $this->params['parent_user'] = key_exists('username', $this->params) && !empty($this->params['username']) ? $this->params['username'] : $sUsername;
            $this->params['username'] = key_exists('username', $this->params) && !empty($this->params['username']) ? $this->params['username'] : $sUsername;
            $this->setVars('search_params', $this->params);
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
        } else {
            $this->params['user_id'] = $iUserId;
        }
        return parent::index();
    }

    public function myself() {
        $sUsername = Session::get('username');
        if (!$sUsername)
            return $this->goBack('error', __('_basic.no-rights'));
        $this->params['username'] = $sUsername;
        return parent::index();
    }

    public function indexQuery() {
        $aConditions = & $this->makeSearchConditions();
        $oQuery = $aConditions ? $this->model->doWhere($aConditions) : $this->model;
        if (array_get($this->params, 'username') && array_get($this->params, 'parent_user')) {
            $oQuery = $oQuery->where(function($query) {
                $query->where('username', '=', $this->params['username'])->orWhere('parent_user', '=', $this->params['parent_user']);
            });
        }

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

    public function commission() {
        return $this->index();
    }

    // public function create($id = null)
    // {
    //     if ( ! $bIsAgent = Session::get('is_agent')) {
    //         return $this->goBack('error', __('_basic.no-rights', $this->langVars));
    //     }
    //     return parent::create($id);
    // }
}
