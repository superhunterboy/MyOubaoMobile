<?php

class ReportDownloadRecordController extends AdminBaseController {

    /**
     * 资源模型名称
     * @var string
     */
    protected $modelName = 'ReportDownloadRecord';

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
                break;
        }
    }

}
