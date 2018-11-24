<?php
# 用户角色关联关系管理
class UserRoleController extends AdminBaseController
{
    /**
     * 资源视图目录
     * @var string
     */
    protected $privateResourceView = 'admin.userRoleRelation';

    /**
     * 资源模型名称
     * @var string
     */
    protected $modelName = 'UserRole';
    protected $iRoleType = 1;


    /**
     * 自定义验证消息
     * @var array
     */
    protected $validatorMessages = [];

    // public function create()
    // {
    //     $
    // }

    public function destroy($id) {
        $model = $this->model->find($id);
        $role_id = $model->role_id;
        $user_id = $model->user_id;
        $sModelName = $this->modelName;
        $count = Role::find($role_id)->users()->detach($user_id);
        $sMessage = $count > 0 ? $this->resourceName . ' was deleted.' : $this->resourceName . 'cannot be deleted.';
        return $this->goBackToIndex('success', $sMessage);
    }

    /**
     * 在渲染前执行，为视图准备变量
     */
    protected function beforeRender() {
        parent::beforeRender();
        $sModelName = $this->modelName;
        switch($this->action){
            case 'index':
            case 'view':
            case 'create':
                $aUserRoles = Role::getAllRoleNameArray(1);
                $this->setVars(compact('aUserRoles'));
                break;
        }
    }
}