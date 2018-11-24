<?php

class BaseController extends Controller {

    protected $Message;

    /**
     * 是否是ajax方式
     * @var bool
     */
    protected $isAjax = false;

    /**
     * 需要加载的错误码定义文件
     * @var array
     */
    protected $errorFiles = [];

    /**
     * 资源视图目录
     * @var string
     */
    protected $resourceView = 'default';

    /**
     * self view path
     * @var string
     */
    protected $customViewPath = '';

    /**
     * view path
     * @var string
     */
    protected $view = '';

    /**
     * views use custom view path
     * @var array
     */
    protected $customViews = [];

    /**
     * 资源模型名称
     * @var string
     */
    protected $modelName;

    /**
     * friendly model
     * @var string
     */
    protected $friendlyModelName;

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
     * pagesize
     * @var int
     */
    protected static $pagesize = 20;

    /**
     * 须自动准备数据的视图名称
     * @var array
     */
    protected $composerViews = array(
        'view',
        'index',
        'create',
        'edit',
    );

    /**
     * Functionality Model
     * @var Functionality
     */
    protected $functionality = null;

    /**
     * 视图使用的样式名
     * @var array
     */
    public $viewClasses = [
        'div' => 'form-group ',
        'label' => 'col-sm-3 control-label ',
        'input_div' => 'col-sm-5 ',
        'msg_div' => 'col-sm-4 ',
        'msg_label' => 'text-danger control-label ',
        'radio_div' => 'switch ',
        'select' => 'form-control ',
        'input' => 'form-control ',
        'radio' => 'boot-checkbox',
        'date' => 'input-group date form_date ',
    ];

    /**
     * 自定义验证消息
     * @var array
     */
    protected $validatorMessages = [];

    /**
     * 消息对象
     * @var Illuminate\Support\MessageBag
     */
    protected $messages = null;

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
     * sysConfig model
     * @var sysConfig
     */
    protected $sysConfig;

    /**
     * search config
     * @var array
     */
    protected $searchConfig;

    /**
     * search fields
     * @var array
     */
    protected $searchItems = [];

    /**
     * param settings
     * @var array
     */
    protected $paramSettings;

    /**
     * use for redirect
     * @var string
     */
    protected $redictKey;

    /**
     * save the all input data: get,post
     * @var array
     */
    protected $params = [];

    /**
     * Widgets
     * @var array
     */
    protected $widgets = [];

    /**
     * Breadcrumb
     * @var array
     */
    protected $breadcrumbs = [];

    /**
     * for lang transfer
     * @var array
     */
    protected $langVars = [];

    /**
     * for lang transfer, short title
     * @var array
     */
    protected $langShortVars = [];

    /**
     * default lang file
     */
    protected $defaultLangPack;

    /**
     * if is admininistrator
     */
    protected $admin;

    /**
     * Client IP
     * @var string
     */
    protected $clientIP;

    /**
     * Proxy IP
     * @var string
     */
    protected $proxyIP;

    /**
     * Need Right Check
     * @var bool
     */
    protected $needRightCheck = true;

    /**
     * 当前用户可访问的功能ID列表
     * @var array
     */
    protected $hasRights = null;

    /**
     * 不进行权限检查的控制器列表
     * @var array
     */
    protected $openControllers = ['AdminController', 'HomeController'];

    /**
     * 初始化
     * @return void
     */
    public function __construct() {
        // CSRF 保护
        $this->isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest';
        $this->checkLogin() or $this->doNotLogin();

        $this->admin = (bool) Session::get('admin_user_id');

        // init controller and action
        $this->initCA() or App::abort(404);

        // 设置功能配置信息
        $this->setFunctionality();
        // todo: new function
        if (!in_array($this->controller, $this->openControllers)) {
            $this->functionality or App::abort(404);
            $this->checkRight() or App::abort(403);
        }

        // 实例化 消息对象
        $this->messages = new Illuminate\Support\MessageBag;

        $this->setReirectKey();
        if (Request::method() == 'GET' && in_array($this->action, ['encode', 'index', 'settings', 'agentPrizeGroupList', 'agentDistributionList', 'listSearchConfig', 'unVefiriedRecords', 'verifiedRecords', 'remitRecords'])) {
            Session::put($this->redictKey, Request::fullUrl());
            // pr(Session::all());exit;
        }
        // 实例化资源模型
        $this->initModel();

        $this->resource = $this->getResourceName();

        // sysconfig
        $this->sysConfig = new SysConfig;

        // language
        $sLanguage = $this->admin ? Session::get('admin_language') : 'zh-CN';
        App::setLocale($sLanguage);

        $this->clientIP = get_client_ip();
        $this->proxyIP = get_proxy_ip();
//        Kint::dump(func_get_arg(0));
    }

    /**
     * 初始化模型实例及语言包等
     */
    protected function initModel() {
        if ($this->modelName) {
            $sModelName = $this->modelName;
            $this->resourceName = __('_model.' . $sModelName::$resourceName);
//            pr($this->resourceName);
            $this->model = App::make($this->modelName);
            // pr($this->modelName);exit;
            $this->resourceTable = $this->model->getTable();
            $this->friendlyModelName = Str::slug($this->modelName);
            $this->langVars = ['resource' => __('_model.' . Str::slug($sModelName::$resourceName))];
            $this->langShortVars = ['resource' => null];
            $this->defaultLangPack = $sModelName::comaileLangPack();
//            pr($this->langVars);
        }
    }

    /**
     * 检查当前用户是否有权限访问当前功能
     * @return boolean
     */
    protected function checkRight() {
        if ($this->functionality) {
            $this->paramSettings = FunctionalityParam::getParams($this->functionality->id);
            // pr($this->functionality->id);
            // $queries = DB::getQueryLog();
            // $last_query = end($queries);
            // pr($last_query);exit;
            // pr($this->paramSettings);
            // exit;
            $this->params = trimArray(Input::except('_token'));
            if ($this->functionality->need_search) {
                $this->getSearchConfig();
                $this->_setSearchInfo();
            }
            $roleIds = Session::get('CurUserRole');
//                if ($this->admin){
//                    $adminRoleId = Role::ADMIN;
//                    $enabled = in_array($adminRoleId, $roleIds);
//                }
            if (!isset($enabled)) {
//                    pr($this->hasRights);
                $this->blockedFuncs = & $this->getBlockedFuncs();
//                pr($this->blockedFuncs);
//                pr($this->functionality->id);
//                pr(in_array($this->functionality->id, $this->blockedFuncs));
//                exit;
                if ($enabled = !in_array($this->functionality->id, $this->blockedFuncs)) {
                    $this->hasRights = & $this->getUserRights();
//                        pr($this->hasRights);
//                        exit;
                    // pr($this->functionality->id);
                    // exit;
                    $enabled = in_array($this->functionality->id, $this->hasRights);
                }
            }
        } else {
            $enabled = false;
        }
        return $enabled;
    }

    protected function & getBlockedFuncs() {
        $a = [];
        return $a;
    }

    /**
     * 检查是否登录，需要在子类中覆盖
     * @return bool
     */
    protected function checkLogin() {
        return false;
    }

    /**
     * 如果未登录时执行的动作,需要在子类中覆盖
     * @return Redirect
     */
    protected function doNotLogin() {
        
    }

    /**
     * 初始化controller　action属性
     * @return boolean
     */
    protected function initCA() {
        if (!$ca = Route::currentRouteAction()) {
            return false;
        }
        list($this->controller, $this->action) = explode('@', $ca);
        return true;
    }

    /**
     * set the redirect key, use for redirect after edit,create,delete action and so on.
     */
    protected function setReirectKey() {
        $this->redictKey = 'curPage-' . $this->modelName;
    }

    /**
     * 当负责响应的方法没有返回值，或返回值为 null 时，
     * 系统将判断 layout 属性是否为空，
     * 若不为空，则根据 layout 属性，返回一个视图响应。
     * @return void
     */
    protected function setupLayout() {
        if (!is_null($this->layout)) {
            $this->layout = View::make($this->layout);
        }
    }

    /**
     * [_generateTreeList 递归生成树形数据]
     * @param  [Array] $table     [待递归的数据]
     * @param  [String] $parent_id [父id]
     * @return [Array]            [格式为{..., children: [{..., leaf: true}]}]
     */
    protected function _generateTreeList($table, $parent_id) {
        $tree = array();
        foreach ($table as $row) {
            if ($row['parent_id'] == $parent_id) {
                $tmp = $this->_generateTreeList($table, $row['id']);
                if ($tmp) {
                    $row['children'] = $tmp;
                } else {
                    $row['leaf'] = true;
                }
                $tree[] = $row;
            }
        }
        return $tree;
    }

    /**
     * [_getButtons 获取当前访问页面的按钮]
     * @return [Array] [pageButtons: 页级按钮, itemButtons: 行级按钮]
     */
    protected function & _getButtons() {
        $pageButtons = [];
        $itemButtons = [];
        $pageBatchButtons = [];
        $data = ['pageButtons' => [], 'itemButtons' => [], 'pageBatchButtons' => []];
        if (!$this->admin || !$this->functionality) {
            return $data;
        }
        $aHadRights = $this->hasRights;
//        pr($aHadRights);
//        exit;
        $buttons = $this->functionality->getRelationFunctionalities($aHadRights, $aRelationIds);
//        pr($buttons->toArray());
//        pr($aHadRights);
//        exit;
//        $aRelatedFunctionalities = [];
//        foreach ($buttons as $oRelatedFunctionality) {
//            array_push($aRelatedFunctionalities, $oRelatedFunctionality->r_functionality_id);
//        }
//        $functionalities = $this->getUserRights(4,false,$aRelatedFunctionalities);
        $functionalities = & Functionality::getActionArray($aRelationIds);
        // print_r($functionalities);
        // exit;

        foreach ($buttons as $key => $value) {
//            pr($value);
            if (!isset($functionalities[$value->r_functionality_id]))
                continue;
            $route_action = $functionalities[$value->r_functionality_id][1] . '@' . $functionalities[$value->r_functionality_id][2];
            // print_r($route_action);exit;
            switch ($functionalities[$value->r_functionality_id][2]) { // TODO 目前需要弹窗的按钮没有很好的配置方式，待改进
                case 'destroy':
                    $value->btn_type = 1;
                    $value->btn_action = 'modal';
                    break;
                case 'refuse':
                    $value->btn_type = 1;
                    $value->btn_action = 'refuseWithdrawal';
                    break;
                case 'waitingForConfirmation':
                    $value->btn_type = 1;
                    $value->btn_action = 'waitingForConfirmation';
                    break;
                case 'reject':
                    $value->btn_type = 1;
                    $value->btn_action = 'rejectBonus';
                    break;
                case 'unblockUser':
                    $value->btn_type = 1;
                    $value->btn_action = 'setUnblockedStatus';
                    break;
                case 'blockUser':
                    $value->btn_type = 1;
                    $value->btn_action = 'setBlockedStatus';
                    break;
                case 'ignore':
                    $value->btn_type = 1;
                    $value->btn_action = 'ignore';
                    break;
                case 'addCoin':
                    $value->btn_type = 1;
                    $value->btn_action = 'addCoin';
                    break;
                case 'reviseCode':
                    $value->btn_type = 1;
                    $value->btn_action = 'reviseCode';
                    break;
                case 'advanceCode':
                    $value->btn_type = 1;
                    $value->btn_action = 'advanceCode';
                    break;
                case 'cancelCode':
                    $value->btn_type = 1;
                    $value->btn_action = 'cancelCode';
                    break;
                case 'setToBlackList':
                    $value->btn_type = 1;
                    $value->btn_action = 'setToBlackList';
                    break;
                case 'setToInUseStatus':
                    $value->btn_type = 1;
                    $value->btn_action = 'setToInUseStatus';
                    break;
                case 'putBadRecord':
                    $value->btn_type = 1;
                    $value->btn_action = 'putBadRecord';
                    break;
                case 'edit':
                case 'show':
                    $value->btn_type = 2;
                    break;
                default:
                    $value->btn_type = 3;
                    break;
            }
            $route_name = $this->_getRouterName($route_action);
            $value->route_name = $route_name;

            // label
            $bShort = false;
            $aShortActions = ['view', 'edit', 'delete', 'create'];
            if ($value->for_item) {
                $aWords = explode(' ', $value->label);
                $sFirst = $aWords[0];
                $bShort = in_array(strtolower($sFirst), $aShortActions);
            } else {
                $bShort = in_array(strtolower($value->label), $aShortActions);
                $sFirst = $value->label;
            }
            if ($bShort) {
                $sDictionary = '_basic';
                $sKeyword = strtolower($sFirst);
                $sReplaceVarName = 'langShortVars';
            } else {
                $sDictionary = '_function';
                $sKeyword = strtolower($value->label);
                $sReplaceVarName = 'langVars';
            }
            $value->label = __($sDictionary . '.' . $sKeyword, $this->$sReplaceVarName, 2);

            // file_put_contents('/tmp/route', $route_action . "\n", FILE_APPEND);
//            if ($value->r_functionality_id == )
//            if ($functionalities)
//            pr($value->getAttributes());
            $iParamFunctionalityId = $value->for_page ? $value->functionality_id : $value->r_functionality_id;
            if ($value->params) {
                $value->para_name = $value->params;
            } else {
                if ($aParamConfig = FunctionalityParam::getParams($iParamFunctionalityId)) {
                    //                exit;
                    foreach ($aParamConfig as $sParamName => $aRaramSetting) {
                        break;
                    }
                    $value->para_name = $sParamName;
                    //                pr($sParamName);
                    //                continue;
                    //                exit;
                } else {
                    $sModelName = & $this->modelName;
                    switch ($functionalities[$value->r_functionality_id][2]) {        // action
                        case 'index':
                        case 'list':
                        case 'create':
                            $value->para_name = $sModelName::$treeable ? 'parent_id' : null;
                            break;
                        case 'updateModels':
                        case 'generateAll':
                            $value->para_name = null;
                            break;
                        default:
                            $value->para_name = 'id';
                    }
                }
            }
            if ($value->use_redirector) {
                $value->url = Session::get($this->redictKey);
            }
            if ($value->for_page) {
                array_push($pageButtons, $value);
            } else if ($value->for_item) {
                array_push($itemButtons, $value);
            } else if ($value->for_page_batch) {
                array_push($pageBatchButtons, $value);
            }
        }
        $data = ['pageButtons' => $pageButtons, 'itemButtons' => $itemButtons, 'pageBatchButtons' => $pageBatchButtons];
        // pr($data['pageButtons']);exit;
//        foreach($data['pageButtons'] as $oButton){
//            pr($oButton->getAttributes());
//        }
        return $data;
    }

    /**
     * 生成面包屑导航
     * @return array
     */
    protected function _getBreadcrumb() {
        return [];
    }

    /**
     * getUserRights 获取可访问的功能ID数组，必须在子类中覆盖
     *
     * @param  boolean $onlyMenu   是否只获取设置为菜单的功能权限
     * @return Array              根据$returnType得到的不同数组
     */
    protected function & getUserRights() {
        $a = [];
        return $a;
    }

    /**
     * 获取指定角色ID范围所拥有的权限集合
     * @param array $aRoleIds
     * @return array
     */
    public function & getRights($aRoleIds = array()) {
        $aRoles = Role::whereIn('id', $aRoleIds)->get(array('id', 'rights'));
        $aRights = [];
        foreach ($aRoles as $oRole) {
            $aRights = array_merge($aRights, explode(',', $oRole->rights));
        }
        $aRights = array_unique($aRights);
        return $aRights;
    }

    /**
     * get router name
     * @param string $route_action
     * @return string
     */
    protected function _getRouterName($route_action) {
        $router = Route::getRoutes()->getByAction($route_action);
        return $router ? $router->getName() : '';
    }

    /**
     * render view
     * @return Response
     */
    protected function render() {
        $this->beforeRender();
        if (!$this->view) {
            if (in_array($this->action, $this->customViews) && $this->customViewPath) {
                $this->resourceView = $this->customViewPath;
            }
            $this->view = $this->resourceView . '.' . $this->action;
        }
        $this->layout = View::make($this->view)->with($this->viewVars);
    }

    /**
     * 在渲染前执行，为视图准备变量
     */
    protected function beforeRender() {
//        pr($this->params);exit;
        $this->setVars($this->params);
        $resource = $this->resource;
        $resourceName = $this->resourceName;
        // $resourceName = __('_model.' . $this->resourceName);
        $sModelName = & $this->modelName;
        // pr($this->modelName);exit;
        $buttons = & $this->_getButtons();
//        pr($buttons);
//        exit;
        $breadcrumb = $this->_getBreadcrumb();
//        View::composer([$this->resourceView . '.' . $this->action], function ($view) use ($resource, $resourceName, $buttons, $breadcrumb) {
//            $view->with(compact('resource', 'resourceName', 'buttons', 'breadcrumb'));
//        });
        $bTreeable = $sModelName::$treeable;
        $this->setVars(compact('resource', 'resourceName', 'buttons', 'breadcrumb', 'bTreeable'));

        $oFormHelper = new FormHelper;
        $bEdit = in_array($this->action, ['edit', 'create']);
        if ($this->model) {
            !empty($this->model->columnSettings) or $this->model->makeColumnConfigures($bEdit);
            $oFormHelper->setModel($this->model);
        }
        // pr($this->viewVars['data']->toArray());
        // exit;
        // pr($this->model->columnSettings);exit;
        $this->setVars('aColumnSettings', $this->model->columnSettings);

        $sLangKey = '_basic.';
        switch ($this->action) {
            case 'index':
                $sLangKey .= 'management';
//                $sColumnConfigVar = $this->admin ? 'columnForList' : 'columnForListForUser';
//                $this->setVars('aColumnForList', $sModelName::$$sColumnConfigVar);
                $this->setVars('aColumnForList', $sModelName::$columnForList);
                $this->setVars('sModelSingle', __('_model.' . $this->friendlyModelName));
                $this->setVars('bSequencable', $sModelName::$sequencable);
                $this->setVars('bCheckboxForBatch', $sModelName::$bCheckboxForBatch);
                if ($sModelName::$sequencable) {
                    $sSetOrderRoute = $this->resource . '.set-order';
                    $this->setvars(compact('sSetOrderRoute'));
                }
                $this->setVars('aListColumnMaps', $sModelName::$listColumnMaps);
                $this->setVars('aNoOrderByColumns', $sModelName::$noOrderByColumns);
                if ($sModelName::$totalColumns) {
                    $this->setVars('aTotalColumns', $sModelName::$totalColumns);
                }
//                exit;
                break;
            case 'create':
                $sLangKey .= 'create';
//                $sAction = Lang::get('_basic.create', $this->langVars);
                $this->setVars('aOriginalColumns', $sModelName::$originalColumns);
                $this->setVars(compact('oFormHelper'));
                break;
            case 'view':
                $this->setVars('aViewColumnMaps', $sModelName::$viewColumnMaps);
            default:
//                pr($this->defaultLangPack);
//            case 'edit':
//                $sLangKey = $this->defaultLangPack . '.' . $this->action;
                $sLangKey = '_function.' . strtolower($this->functionality->title);
                break;
//            case 'view':
//                $sLangKey .= 'view';
//                break;
        }
        $sAction = Lang::get($sLangKey, $this->langVars);
        $oFormHelper->setClass($this->viewClasses);
        $oFormHelper->setLangPrev($this->defaultLangPack . '.');
        // set the form helper
        $this->setVars(compact('oFormHelper'));
        // addWidget
        $this->setVars('aWidgets', $this->widgets);
        $this->setVars('sLangKey', $sLangKey);
        isset($this->viewVars['bNeedCalendar']) or $this->viewVars['bNeedCalendar'] = false;

        // title
        $sPageTitle = __('_basic.management', $this->langVars);
        if ($sAction != $sPageTitle) {
            $sPageTitle .= ' - ' . $sAction;
        }
        $this->setVars(compact('sPageTitle', 'sModelName'));
        $this->setvars('sLangPrev', $this->defaultLangPack . '.');
        $this->setvars('aLangVars', $this->langVars);
        $this->setVars('aNumberColumns', $sModelName::$htmlNumberColumns);
        $this->setVars('aOriginalNumberColumns', $sModelName::$htmlOriginalNumberColumns);
        $this->setVars('iDefaultAccuracy', $sModelName::$amountAccuracy);
        if ($this->functionality->refresh_cycle && $this->functionality->refresh_cycle > 0) {
            $this->setVars('iRefreshTime', $this->functionality->refresh_cycle);
            // print($this->functionality->refresh_cycle);exit;
        }
    }

    /**
     * get search conditions array
     *
     * @return array
     */
    protected function & makeSearchConditions() {
        $aConditions = [];
        // pr($this->functionality->id);
        // pr((SearchConfig::getForm($this->functionality->id, $this->admin)->toArray());
        // pr($this->searchConfig);
        // pr($this->paramSettings);
        // pr($this->searchItems);
        // pr($this->params);
        // pr(isset($this->searchItems['parent_id']));
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
//            die(is_null($mValue));
            if (!mb_strlen($mValue) && !$aParam['limit_when_null'])
                continue;
            if (!isset($this->searchItems[$sColumn])) {
                $aConditions[$sColumn] = [ '=', $mValue];
                continue;
            }
            // pr($aConditions);exit;
            // compile match
//            $sMatchRule = $this->searchItems[$sColumn]['match_rule'];
//            die($sMatchRule);
            $aPattSearch = array('!\$model!', '!\$\$field!', '!\$field!');
//            pr($this->searchItems);
//            pr($sColumn);
            $aItemConfig = & $this->searchItems[$sColumn];
//            pr($aItemConfig);
            $aPattReplace = array($aItemConfig['model'], $mValue, $aItemConfig['field']);
            $sMatchRule = preg_replace($aPattSearch, $aPattReplace, $aItemConfig['match_rule']);
//            pr($sMatchRule);
            $aMatchRule = explode("\n", $sMatchRule);
            // pr($aMatchRule);
            // exit;
            if (count($aMatchRule) > 1) {        // OR
                // todo : or
            } else {
//                pr($aMatchRule);
                $aFieldInfo = array_map('trim', explode(' = ', $aMatchRule[0]));
//                    pr($aFieldInfo);
//                    pr($mValue);
                $aTmp = explode(' ', $aFieldInfo[0]);
//                pr($aTmp);
//                pr(count($aTmp));
//                exit;
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
                    // $sFrom = $aConditions[$sColumn][1];
                    // $sTo = $aFieldInfo[1];
                    $aConditions[$sColumn] = [ 'between', $arr];
                } else {
                    $aConditions[$sColumn] = [ $iOperator, $aFieldInfo[1]];
                }
            }
//            if ($sColumn == 'parent_id'){
//                die('test');
//            }
        }
//        pr($this->params);
        // pr($aConditions);exit;
//        if (count($this->params) > 1 && isset($aConditions['parent_id'])){
//            unset($aConditions['parent_id']);
//        }
        return $aConditions;
    }

    /**
     * 资源列表页面
     * GET
     * @return Response
     */
    public function index() {
//        $oQuery     = $this->model;
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

    public function indexQuery() {
        $aConditions = & $this->makeSearchConditions();
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
     * set view vars
     * @param string|array $sKey
     * @param mixed $mValue
     */
    function setVars($sKey, $mValue = null) {
        if (is_array($sKey)) {
            foreach ($sKey as $key => $value) {
                $this->setVars($key, $value);
            }
        } else {
            $this->viewVars[$sKey] = $mValue;
        }
    }

    /**
     * 资源创建页面
     * @return Response
     */
    public function create($id = null) {
        if (Request::method() == 'POST') {
            DB::connection()->beginTransaction();
            if ($bSucc = $this->saveData($id)) {
                DB::connection()->commit();
                return $this->goBackToIndex('success', __('_basic.created', $this->langVars));
            } else {
                // pr($this->model->toArray());
                // pr('---------');
                // pr($this->model->validationErrors);exit;
                DB::connection()->rollback();
                $this->langVars['reason'] = & $this->model->getValidationErrorString();
//                pr($this->langVars);
//                exit;
                return $this->goBack('error', __('_basic.create-fail', $this->langVars));
            }
        } else {
            $data = $this->model;
            $isEdit = false;
            $this->setVars(compact('data', 'isEdit'));
            $sModelName = $this->modelName;
            //            if ($sModelName::$treeable){
//                $sFirstParamName = 'parent_id';
//            }
//            else{
//foreach($this->paramSettings as $sFirstParamName => $tmp){
//                    break;
//                }
            list($sFirstParamName, $tmp) = each($this->paramSettings);
            //            }
            // pr($sModelName);
            // exit;
            !isset($sFirstParamName) or $this->setVars($sFirstParamName, $id);
            $aInitAttributes = isset($sFirstParamName) ? [$sFirstParamName => $id] : [];
            $this->setVars(compact('aInitAttributes'));

            return $this->render();
        }
    }

    /**
     * 资源编辑页面
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
        $this->model = $this->model->find($id);
        if (!is_object($this->model)) {
            return $this->goBackToIndex('error', __('_basic.missing', $this->langVars));
        }
        if (Request::method() == 'PUT') {
            DB::connection()->beginTransaction();
            if ($bSucc = $this->saveData($id)) {
                DB::connection()->commit();
                return $this->goBackToIndex('success', __('_basic.updated', $this->langVars));
            } else {
                DB::connection()->rollback();
                $this->langVars['reason'] = & $this->model->getValidationErrorString();
                return $this->goBack('error', __('_basic.update-fail', $this->langVars));
            }
        } else {
            // $table = Functionality::all();
            $parent_id = $this->model->parent_id;
            $data = $this->model;
            $isEdit = true;
            $this->setVars(compact('data', 'parent_id', 'isEdit', 'id'));
            return $this->render();
        }
    }

    /**
     * view model
     * @param int $id
     * @return bool
     */
    public function view($id) {
//         pr($this->model);exit;
        $this->model = $this->model->find($id);
        if (!is_object($this->model)) {
            return $this->goBackToIndex('error', __('_basic.missing', $this->langVars));
        }
        $data = $this->model;
        $sModelName = $this->modelName;
        if ($sModelName::$treeable) {
            if ($this->model->parent_id) {
                if (!array_key_exists('parent', $this->model->getAttributes())) {
                    $sParentTitle = $sModelName::find($this->model->parent_id)->{$sModelName::$titleColumn};
                } else {
                    $sParentTitle = $this->model->parent;
                }
            } else {
                $sParentTitle = '(' . __('_basic.top_level', [], 3) . ')';
            }
        }
        $this->setVars(compact('data', 'sParentTitle'));
        return $this->render();
    }

    /**
     * delete model from database
     * @param type $id
     * @return type
     */
    public function destroy($id) {
        $this->model = $this->model->find($id);
        $sModelName = $this->modelName;
        if ($sModelName::$treeable) {
            if ($iSubCount = $this->model->where('parent_id', '=', $this->model->id)->count()) {
                $this->langVars['reason'] = __('_basic.not-leaf', $this->langVars);
                return Redirect::back()->with('error', __('_basic.delete-fail', $this->langVars));
            }
        }
        DB::connection()->beginTransaction();
        if ($bSucc = $this->model->delete()) {
            $bSucc = $this->afterDestroy();
        }

        $bSucc ? DB::connection()->commit() : DB::connection()->rollback();

        $sLangKey = '_basic.' . ($bSucc ? 'deleted' : 'delete-fail.');
        return $this->goBackToIndex('success', __($sLangKey, $this->langVars));
    }

    protected function afterDestroy() {
        return true;
    }

    /**
     * save data to database
     * auto redirect
     * @return bool
     */
    protected function saveData() {
        // 用表单数据填充模型实例
        $this->_fillModelDataFromInput();
        // 创建验证规则
        $aRules = & $this->_makeVadilateRules($this->model);
        // pr($aRules);
        // pr('------------');
        // pr($this->model->toArray());exit;
        // save
        return $this->model->save($aRules);
    }

    /**
     * 用表单数据填充模型实例
     */
    protected function _fillModelDataFromInput() {
//        $this->model = $id ? $this->model->find($id) : $this->model;
        $data = $this->params;
        $sModelName = $this->modelName;
        !empty($this->model->columnSettings) or $this->model->makeColumnConfigures();
        foreach ($this->model->columnSettings as $sColumn => $aSettings) {
            if ($sColumn == 'id')
                continue;
            if (!isset($aSettings['type']))
                continue;
            switch ($aSettings['type']) {
                case 'bool':
                case 'numeric':
                case 'integer':
                    !empty($data[$sColumn]) or $data[$sColumn] = 0;
                    break;
                case 'select':
                    if (isset($data[$sColumn]) && is_array($data[$sColumn])) {
                        sort($data[$sColumn]);
                        $data[$sColumn] = implode(',', $data[$sColumn]);
                    }
            }
        }
        // pr($data);
        //        exit;
        // pr(get_class($this->model));
        // pr('---------');

        $this->model = $this->model->fill($data);
        // pr('---------');
        // pr($this->model->toArray());exit;
        if ($sModelName::$treeable) {
            $this->model->parent_id or $this->model->parent_id = null;
            if ($sModelName::$foreFatherColumn) {
                $this->model->{$sModelName::$foreFatherColumn} = $this->model->setForeFather();
            }
        }
    }

    /**
     * 根据实际情况修改验证规则
     * @param model $oModel
     * @return array
     */
    protected function & _makeVadilateRules($oModel) {
        $sClassName = get_class($oModel);
        return $sClassName::$rules;
    }

    /**
     * 构造 unique 验证规则
     * @param  string $column 字段名称
     * @param  int    $id     排除指定 ID
     * @return string
     */
    protected function unique($column = null, $id = null, $extraParam = null) {
        $rule = 'unique:' . $this->resourceTable;
        if (!is_null($column))
            $rule .= ',' . $column;
        if (!is_null($id))
            $rule .= ',' . $id . ',id';
        else
            $rule .= ',NULL,id';
        if (!is_null($extraParam) && is_array($extraParam)) {
            foreach ($extraParam as $key => $value) {
                $rule .= ',' . $key . ',' . $value;
            }
        }
        return $rule;
    }

    protected function getResourceName() {
        $sControllerName = str_replace('Controller', '', $this->controller);
        $aParts = explode('_', $sControllerName);
        $sName = $aParts[count($aParts) - 1];
        $sName = String::snake($sName);
        return String::plural(String::slug($sName, '-'));
    }

    /**
     * 根据搜索配置生成搜索表单数据
     */
    function _setSearchInfo() {
        $bNeedCalendar = SearchConfig::makeSearhFormInfo($this->searchItems, $this->params, $aSearchFields);
        // pr($this->searchItems);
        // pr('---------');
        // pr($aSearchFields);
        // exit;
        $this->setVars(compact('aSearchFields', 'bNeedCalendar'));
//        !$bNeedCalendar or $this->setvars('aDateObjects',[]);
        $this->setVars('aSearchConfig', $this->searchConfig);
        $this->addWidget('w.search');
    }

    /**
     * get search config
     */
    protected function getSearchConfig() {
        $iFunctionalityId = $this->functionality->id;
        if ($this->searchConfig = SearchConfig::getForm($iFunctionalityId, $this->admin)) {
            $this->searchItems = & $this->searchConfig->getItems();
        }
    }

    /**
     * add widget name
     * @param string $sWidget
     */
    protected function addWidget($sWidget) {
        $this->widgets[] = $sWidget;
    }

    /**
     * redict to index page
     * @param string $sMsgType      in list: success, error, warning, info
     * @param string $sMessage
     * @return RedirectResponse
     */
    protected function goBackToIndex($sMsgType, $sMessage) {
//         pr($this->redictKey);
//         pr(Session::get($this->redictKey));
//         exit;
        $sToUrl = Session::get($this->redictKey) or $sToUrl = route('admin.dashboard');
        return Redirect::to($sToUrl)->with($sMsgType, $sMessage);
    }

    /**
     * go back
     * @param string $sMsgType      in list: success, error, warning, info
     * @param string $sMessage
     * @return RedirectResponse
     */
    protected function goBack($sMsgType, $sMessage, $bWithModelErrors = false) {
        $oRedirectResponse = Session::get($this->redictKey) ? Redirect::back() : Redirect::route('home');
        $oRedirectResponse->withInput()->with($sMsgType, $sMessage);
        !$bWithModelErrors or $oRedirectResponse = $oRedirectResponse->withErrors($this->model->validationErrors);
        return $oRedirectResponse;
    }

    protected function setFunctionality() {
        $this->functionality = Functionality::getByCA($this->controller, $this->action, $this->admin);
    }

    public function setOrder() {
//        pr($this->params);
//        exit;
        if (Request::method() != 'POST') {
            return $this->goBack('error', __('_basic.method-error'));
        }
        if (!isset($this->params['sequence']) || !is_array($this->params['sequence'])) {
            return $this->goBack('error', __('_basic.data-error'));
        }
        $sModelName = $this->modelName;
        DB::connection()->beginTransaction();
        $bSucc = true;
        foreach ($this->params['sequence'] as $id => $sequence) {
            $oModel = $sModelName::find($id);
            if ($oModel->sequence == $sequence) {
                continue;
            }
            $oModel->sequence = $sequence;
            if (!$bSucc = $oModel->save(['sequence' => 'numeric'])) {
                break;
            }
        }
        if ($bSucc) {
            DB::connection()->commit();

            $sInfoType = 'success';
            $sLangKey = '_basic.ordered';
        } else {
            DB::connection()->rollback();
            $sInfoType = 'error';
            $sLangKey = '_basic.order-fail';
        }
        return $this->goBack($sInfoType, __($sLangKey));
    }

    /**
     * 输出信息并终止运行
     * @param string $msg
     */
    protected function halt($bSuccess, $sType, $iErrno, & $aSuccessedBets = null, & $aFailedBets = null, & $aData = null, $sLinkUrl = null) {
        is_object($this->Message) or $this->Message = new Message($this->errorFiles);
        $this->Message->output($bSuccess, $sType, $iErrno, $aData, $aSuccessedBets, $aFailedBets, $sLinkUrl);
        exit;
    }

    /**
     * 输出Json数据
     * @param array $msg
     */
    protected function jsonEcho($msg) {
        header('Content-Type: application/json');
        echo json_encode($msg);
        exit();
    }

    protected function writeLog($msg) {
//        !is_array($msg) or $msg = var_export($msg, true);
//        file_put_contents('/tmp/bet', $msg . "\n", FILE_APPEND);
    }

    /**
     * [createUserManageLog 生成管理员对用户进行操作的日志]
     * @param  [Integer] $iUserId [用户id]
     * @return [Boolean]          [成功/失败状态]
     */
    protected function createUserManageLog($iUserId, $sComment = null) {
        $iFunctionalityId = $this->functionality->id;
        $sFunctionality = $this->functionality->title;
        return UserManageLog::createLog($iUserId, $iFunctionalityId, $sFunctionality, $sComment);
    }

    /**
     * 返回excel文件到浏览器端
     * @param array $aTitles        excel表头信息
     * @param array $aData           excel数据
     * @param string $sFileName  excel文件名称
     * @return excel内容或者跳转到index页面
     */
    public function downloadExcel($aTitles, $aData, $sFileName) {
        if (count($aData) > 0) {

            PHPExcel_Settings::setCacheStorageMethod(PHPExcel_CachedObjectStorageFactory::cache_in_memory_serialized);
            $oDownExcel = new DownExcel;
            $sModelName = starts_with($this->modelName, 'Man') ? substr($this->modelName, 3) : $this->modelName;
            $oDownExcel->setTitle(strtolower($sModelName), $aTitles);
            $oDownExcel->setData($aData);
            $oDownExcel->setActiveSheetIndex(0);
            $oDownExcel->setSheetTitle($sFileName);
            $oDownExcel->setEncoding('gb2312');
            $oDownExcel->Download($sFileName);
            exit;
        }
        return Redirect::route(str_replace('.download', '.index', Route::currentRouteName()));
    }

    public function __destruct() {
    	return true;
//        pr(SysConfig::readValue('sys_use_sql_log'));
//        pr(SysConfig::check('sys_use_sql_log',true));
        if (SysConfig::check('sys_use_sql_log', true)) {
            $sLogPath = Config::get('log.root') . DIRECTORY_SEPARATOR . 'sql' . DIRECTORY_SEPARATOR . date('Ymd');
//            pr($sLogPath);
            if (!file_exists($sLogPath)) {
                @mkdir($sLogPath, 0777, true);
                @chmod($sLogPath, 0777);
            }
            $sLogFile = $sLogPath . DIRECTORY_SEPARATOR . date('H') . '.sql';
            if (!$queries = DB::getQueryLog()) {
                return;
            }
//            $me       = DB::connection();
//            pr($queries);
            foreach ($queries as $aQueryInfo) {
//                $sql       = $aQueryInfo['query'];
                $sql = '';
                $aSqlParts = explode('?', $aQueryInfo['query']);
                foreach ($aSqlParts as $i => $sPart) {
                    $sql .= $aSqlParts[$i];
                    if (isset($aQueryInfo['bindings'][$i])) {
                        $bindings = $aQueryInfo['bindings'][$i];
                        !(is_string($bindings) && strlen($bindings) > 0 && $bindings{0} != "'") or $bindings = "'" . $bindings . "'";
                        $sql .= $bindings;
                    }
                }
                $aLogs[] = $sql;
                $aLogs[] = number_format($aQueryInfo['time'], 3) . 'ms';
//                pr($sql);
            }

            @file_put_contents($sLogFile, date('Y-m-d H:i:s') . "\n", FILE_APPEND);
            @file_put_contents($sLogFile, 'controller: ' . $this->controller . ' action: ' . $this->action . "\n", FILE_APPEND);
//            @file_put_contents($sLogFile, var_export($queries, true) . "\n\n", FILE_APPEND);
            @file_put_contents($sLogFile, implode("\n", $aLogs) . "\n\n", FILE_APPEND);
        }
    }

}
