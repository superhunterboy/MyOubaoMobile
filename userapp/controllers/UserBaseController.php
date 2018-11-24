<?php

class UserBaseController extends BaseController {

    protected $messages;
    protected $errorFiles = ['system', 'bet', 'fund', 'account', 'lottery', 'issue', 'seriesway'];
    protected $resourceView = 'template.ucenter';

    /**
     * 资源模型名称
     * @var string
     */
    protected $modelName;

    /**
     * 模型实例
     * @var Illuminate\Database\Eloquent\Model
     */
    protected $model;

    /**
     * Resource , use for route
     */
    protected $resource;

    /**
     * 资源数据库表
     * @var string
     */
    protected $resourceTable = '';

    /**
     * 资源名称
     * @var string
     */
    protected $resourceName = '';

    /**
     * Controller
     */
    protected $controller;

    /**
     * Action
     */
    protected $action;

    /**
     * var for views
     */
    protected $viewVars = [];

    /**
     * pagesize
     * @var int
     */
    protected static $pagesize = 15;
    protected static $originalColumns = [];

    /**
     * 检查是否登录
     * @return bool
     */
    protected function checkLogin() {
        return boolval(Session::get('user_id'));
    }

    /**
     * 如果未登录时执行的动作
     * @return type
     */
    protected function doNotLogin() {
        if ($this->isAjax) {
            $this->halt(false, 'loginTimeout', Config::get('global_error.ERRNO_LOGIN_EXPIRED'));
        } else {
            return Redirect::route('signin');
        }
    }

    /**
     * 获取可访问的功能ID数组
     *
     * @return Array              根据$returnType得到的不同数组
     */
    protected function & getUserRights() {
        $roleIds = Session::get('CurUserRole');
        $aRights = & Role::getRightsOfRoles($roleIds);
        return $aRights;
    }

    protected function & getBlockedFuncs() {
        $roleIds = Session::get('CurUserRole');
//        exit;
        $aRights = & Role::getBlockedFuncsOfRoles($roleIds);
        return $aRights;
    }

    protected function beforeRender() {
        parent::beforeRender();
        $this->setVars('iDefaultPaymentPlatformId', PaymentPlatform::getDefaultPlatformId());
        $iUserId = Session::get('user_id');
        $oUser = User::find($iUserId);
        $fAvailable = formatNumber(Account::getAvaliable($iUserId), 1);
        $iStatus = Session::get('is_tester') ? Lottery::STATUS_AVAILABLE_FOR_TESTER : Lottery::STATUS_AVAILABLE;
        $aCategoryLotteries = Lottery::getAllLotteriesByCategories($iStatus, null);
        $aLotteries = & Lottery::getLotteryList();;
        $aLotteryData = Lottery::getAllLotteries(Lottery::STATUS_AVAILABLE);
        $unreadMessagesNum = UserMessage::getUserUnreadMessagesNum();
        $this->setVars(compact('unreadMessagesNum', 'fAvailable', 'aCategoryLotteries', 'aLotteries','aLotteryData'));
    }

    //    protected function render(){
    //        $this->beforeRender();
    //        // pr($this->viewVars);exit;
    //        return View::make($this->resourceView . '.' . $this->action)->with($this->viewVars);
    //    }
    // public function index()
    // {
    //     return $this->render();
    // }
    // public function create($id = null)
    // {
    //     return $this->render();
    // }
    public function destroy($id) {
        if (!$this->filterRights($id))
            App::abort(404);
        return parent::destroy($id);
    }

    public function edit($id) {
        if (!$this->filterRights($id))
            App::abort(404);
        return parent::edit($id);
    }

    public function view($id) {
        if (!$this->filterRights($id))
            App::abort(404);
        return parent::view($id);
        // return Redirect::to('home')->with('error', __('_basic.no-rights'));
    }

    /**
     * [filterRights 过滤访问权限，只有属于该用户或总代的记录可以被访问]
     * @param  [Integer] $id [数据记录的id]
     * @return [Integer]     [是否有权限, 0:否, 1:是]
     */
    private function filterRights($id) {
        $bSucc = true;
        // 只需过滤view, edit, destroy三种视图
        if (in_array($this->action, ['view', 'edit', 'destroy'])) {
            $sModelName = $this->modelName;
            $sTable = $this->model->getTable();
            $originalColumns = Schema::getColumnListing($sTable);
            if (in_array('user_id', $originalColumns)) {
                $iUserId = Session::get('user_id');
                $rUserId = $sModelName::find($id)->user_id;
                $sForefatherIds = User::find($rUserId)->forefather_ids;
                $aForefatherIds = explode(',', $sForefatherIds);
                $bIsAgent = Session::get('is_agent');
                $bIsTopAgent = Session::get('is_top_agent');
                // pr($sModelName);
                // pr($bIsTopAgent);
                // pr($bIsAgent);
                // pr($aForefatherIds);
                // pr($rUserId);
                // pr($iUserId);
                // exit;
                // 只有view视图需要判断是否是代理的子用户的数据
                // $bSucc = ($bIsAgent && !$bIsTopAgent && $this->action == 'view') ? in_array($iUserId, $aForefatherIds) : ($iUserId == $rUserId);
                $bSucc = ($iUserId == $rUserId or in_array($iUserId, $aForefatherIds));
            }
        }
        // pr((int)$bSucc);exit;
        return $bSucc;
    }

    /**
     * [getSumData 获取统计值]
     * @param  [Array]  $aSumColumns [待统计的列]
     * @param  [boolean] $bPerPage   [是否按页统计，该功能采用视图中操作每页数据的方式实现，以前的逻辑暂时注释掉]
     * @return [Array]               [统计数据]
     */
    public function getSumData($aSumColumns, $bPerPage = false) {
        // TODO 和BaseController中的查询有所重复，后续改进
        $aConditions = & $this->makeSearchConditions();
        $oQuery = $this->model->doWhere($aConditions);
        // $iPage              = Input::get('page', 1);
        // pr($aConditions);
        // pr($iPage . ',' . static::$pagesize);
        // pr($this->params);exit;
        $aRawColumns = [];
        // $aParams     = array_values($this->params);
        foreach ($aSumColumns as $key => $value) {
            $aRawColumns[] = DB::raw('SUM(' . $value . ') as ' . $value . '_sum');
        }
        $aSum = [];
        // if ($bPerPage) {
        //     $oQuery = $oQuery->forPage($iPage, static::$pagesize);
        //     $oQuerySql = $oQuery->toSql();
        //     pr($oQuerySql);
        //     $sSql = $this->model->select($aRawColumns)->toSql();
        //     // pr($aParams);exit;
        //     $aSumObjects = DB::select('select ' . implode(',', $aRawColumns) . ' from (' . $oQuerySql . ') as temp', $aParams);
        //     foreach ($aSumObjects[0] as $key => $value) {
        //         $aSum[$key] = $value;
        //     }
        // } else {
        //     pr($oQuery->toSql());exit;
        $aSum = $oQuery->get($aRawColumns)->toArray();
        if (count($aSum))
            $aSum = $aSum[0];
        // }
        // $queries = DB::getQueryLog();
        // $last_query = end($queries);
        // pr($last_query);
        // pr($aSum);exit;
        return $aSum;
    }

    /**
     * 将需要缓存的url信息保存到session中
     */
    protected function saveUrlToSession() {
        Session::forget('request_full_url');
        Session::push('request_full_url', Request::url());
    }

    /**
     * 返回先前请求的url信息
     * @param string $sRoute    路由信息
     * @return string
     */
    protected function getUrlFromSession($sDefaultUrl = '/') {
        if (Session::has('request_full_url')) {
            $sUrl = Session::get('request_full_url')[0];
        } else {
            $sUrl = Route($sDefaultUrl);
        }
        return $sUrl;
    }

    public function index() {
        $oQuery = $this->indexQuery();
        $sModelName = $this->modelName;
        $iPageSize = isset($this->params['pagesize']) && is_numeric($this->params['pagesize']) ? $this->params['pagesize'] : static::$pagesize;
        $datas = $oQuery->paginate($iPageSize);
//         $queries = DB::getQueryLog();
//         $last_query = end($queries);
//         pr($last_query);exit;
//         pr(($datas->toArray()));exit;
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

    protected function goBackToIndex($sMsgType, $sMessage) {
        $sToUrl = Session::get($this->redictKey) or $sToUrl = route('home');
        return Redirect::to($sToUrl)->with($sMsgType, $sMessage);
    }

}
