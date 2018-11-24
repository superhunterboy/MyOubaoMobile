<?php

/**
 * 第三方充值回调记录
 *
 * @author white
 */
class DepositCallbackController extends AdminBaseController {

    protected $modelName = 'DepositCallback';

    protected function beforeRender() {
        parent::beforeRender();
        $this->setVars('aValidStatus', DepositCallback::$validStatus);
    }

    
}
