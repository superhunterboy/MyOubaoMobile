<?php

class LotteryController extends AdminBaseController {
    /**
     * 资源视图目录
     * @var string
     */
//    protected $resourceView = 'default';

    /**
     * 资源模型名称
     * @var string|Illuminate\Database\Eloquent\Model
     */
    protected $modelName = 'ManLottery';

    /**
     * 在渲染前执行，为视图准备变量
     */
    protected function beforeRender() {
        parent::beforeRender();
        $sModelName = $this->modelName;
        $this->setVars('aSeries', Series::getTitleList());
        $this->setVars('aValidTypes', $sModelName::$validTypes);
        $this->setVars('aValidLottoTypes', $sModelName::$validLottoTypes);
        $this->setVars('aValidStatus', $sModelName::$validStatus);
        $this->setVars('aLotteryCategories', $sModelName::$aLotteryCategories);
        $this->setVars('aLotteryFlags', $sModelName::$aLotteryFlags);
    }

    protected function generateWidget() {
        $aReturn = ManLottery::generateWidget();
        $sKey = $aReturn['code'] > 0 ? 'success' : 'error';
//        pr($aReturn['message']);
//        die($sKey);
        return $this->goBack($sKey, $aReturn['message']);
    }

}
