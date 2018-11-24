<?php

# 用户盈亏报表管理

class UserDividendController extends UserBaseController {

    protected $resourceView = 'centerUser.report.dividend';
    protected $modelName = 'Dividend';
    public $resourceName = '';

    public function beforeRender() {
        parent::beforeRender();
        switch ($this->action) {
            case 'index':
                $aUserTypes = User::$aUserTypes;
//                $this->setVars(compact('aUserTypes'));
                $this->setVars('reportName', 'dividend');
                break;
        }
    }

    public function index() {
        $this->params['user_id'] = Session::get('user_id');
        return parent::index();
    }

}
