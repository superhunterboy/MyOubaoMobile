<?php
class PrizeDetailController extends AdminBaseController
{
    protected $modelName = 'PrizeDetail';

    
    /**
     * 在渲染前执行，为视图准备变量
     */
    protected function beforeRender() {
        parent::beforeRender();
        $oBasicMethod = new BasicMethod;
        $this->setVars('aBasicMethods', BasicMethod::getTitleList());
        $this->setVars('aLotteryTypes', ManLottery::$validTypes);
    }

}