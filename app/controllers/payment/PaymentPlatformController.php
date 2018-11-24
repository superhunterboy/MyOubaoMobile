<?php

class PaymentPlatformController extends AdminBaseController {
    protected $modelName = 'PaymentPlatform';

    protected function beforeRender() {
        $this->setVars('aValidStatus', PaymentPlatform::$validStatus);
        parent::beforeRender();
    }
}
