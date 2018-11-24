<?php
/**
 * 后台管理系统基础控制器
 *
 * @author frank
 */
class BaseAdminController extends BaseController {

    /**
     * 检查是否登录
     * @return bool
     */
    protected function checkLogin() {
        return Session::get('admin_user_id');
//        || Session::get('user_id');
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

}
