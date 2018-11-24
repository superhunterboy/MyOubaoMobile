<?php

class ActivityPrizeController extends AdminBaseController {

    /**
     * 资源模型名称
     * @var string
     */
    protected $modelName = 'ActivityPrize';

    /**
     * 在渲染前执行，为视图准备变量
     */
    protected function beforeRender() {
        parent::beforeRender();
        $sModelName = $this->modelName;
        switch ($this->action) {
            case 'index':
            case 'view':
            case 'edit':
            case 'create':
                $this->setVars('aActivities', Activity::getTitleList());
                $this->setVars('aPrizeClasses', ActivityPrizeClass::getTitleList());
                $this->setVars('aTasks', ActivityTask::getTitleList());
                $this->setVars('aCategories', [1=>'新彩体验红包',2=>'活动红包']);
                break;
        }
    }

}
