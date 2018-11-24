<?php

class ActivityReportUserPrizeController extends AdminBaseController {

    protected $modelName = 'ActivityReportUserPrize';
    protected $customViewPath = 'activity.report';
    protected $customViews = [
        'index'
    ];

    public function index() {
        $aConditions = & $this->makeSearchConditions();
        $this->setVars('sumInfo', ActivityReportUserPrize::getUserPrizeSumInfo($aConditions));
        $this->setVars('aPrize', ActivityPrize::getTitleList());
        return parent::index();
    }

}
