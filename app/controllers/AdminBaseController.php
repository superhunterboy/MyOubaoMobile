<?php

/**
 * 后台管理系统基础控制器
 *
 * @author frank
 */
class AdminBaseController extends BaseController {

    protected function beforeRender() {
        parent::beforeRender();
        $sModelName = $this->modelName;
        $this->setVars('aWeightFields', $sModelName::$weightFields);
        $this->setVars('aClassGradeFields', $sModelName::$classGradeFields);
        $this->setVars('aFloatDisplayFields', $sModelName::$floatDisplayFields);
    }

    /**
     * 检查是否登录
     * @return bool
     */
    protected function checkLogin() {
        return boolval(Session::get('admin_user_id'));
    }

    /**
     * 如果未登录时执行的动作
     * @return type
     */
    protected function doNotLogin() {
        if ($this->isAjax) {
            $this->halt(false, 'loginTimeout', Config::get('global_error.ERRNO_LOGIN_EXPIRED'));
        } else {
            return Redirect::route('admin-signin');
        }
    }

    /**
     * 获取可访问的功能ID数组
     *
     * @return Array              根据$returnType得到的不同数组
     */
    protected function & getUserRights() {
        $roleIds = Session::get('CurUserRole');
        $aRights = & AdminRole::getRightsOfRoles($roleIds);
        return $aRights;
    }

    /**
     * 生成面包屑导航
     * @return array
     */
    protected function _getBreadcrumb() {
        return [];
    }

    /**
     * 获取指定角色ID范围所拥有的权限集合
     * @param array $aRoleIds
     * @return array
     */
    public function & getRights($aRoleIds = array()) {
        $aRoles = AdminRole::whereIn('id', $aRoleIds)->get(array('id', 'rights'));
        $aRights = [];
        foreach ($aRoles as $oRole) {
            $aRights = array_merge($aRights, explode(',', $oRole->rights));
        }
        $aRights = array_unique($aRights);
        return $aRights;
    }

    public function __destruct() {
        parent::__destruct();
        if (is_object($this->functionality)) {
            $oAdminLog = new AdminLog;
            $oAdminLog->functionality_id = $this->functionality->id;
            $oAdminLog->functionality_title = $this->functionality->title;
            $oAdminLog->controller = $this->functionality->controller;
            $oAdminLog->action = $this->functionality->action;
            $oAdminLog->admin_id = Session::get('admin_user_id');
            $oAdminLog->admin_name = Session::get('admin_username');
            $oAdminLog->request_uri = $_SERVER['REQUEST_URI'];

            empty($this->params) or $oAdminLog->request_data = json_encode($this->params);
            $oAdminLog->save();
        }
    }

    /**
     * go back
     * @param string $sMsgType      in list: success, error, warning, info
     * @param string $sMessage
     * @return RedirectResponse
     */
    protected function goBack($sMsgType, $sMessage, $bWithModelErrors = false) {
//        pr($this->redictKey);
//        pr(Session::get($this->redictKey));
//        exit;
        $oRedirectResponse = Session::get($this->redictKey) ? Redirect::back() : Redirect::route('admin.home');
        $oRedirectResponse->withInput()->with($sMsgType, $sMessage);
        !$bWithModelErrors or $oRedirectResponse = $oRedirectResponse->withErrors($this->model->validationErrors);
        return $oRedirectResponse;
    }

}
