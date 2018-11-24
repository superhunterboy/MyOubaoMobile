<?php

class AccountController extends AdminBaseController {

    protected $modelName = 'ManAccount';
    protected $customViewPath = 'fund.account';
    protected $customViews = [
        'index'
    ];

    function _setSearchInfo() {
        $bNeedCalendar = SearchConfig::makeSearhFormInfo($this->searchItems, $this->params, $aSearchFields);
        $this->setVars(compact('aSearchFields', 'bNeedCalendar'));
        $this->setVars('aSearchConfig', $this->searchConfig);
        $this->addWidget('w.search_download');
    }

    public function index() {
        $aConditions = & $this->makeSearchConditions();
        $this->setVars('sumInfo', Account::getAccountSumInfo($aConditions));
        return parent::index();
    }

    public function download() {
        $oQuery = $this->indexQuery();

        set_time_limit(0);
        $sModelName = $this->modelName;
        $aData = $oQuery->get($sModelName::$columnForList);
        $aConvertFields = [
            'is_tester' => 'boolean',
        ];
        $aData = $this->model->makeData($aData, $sModelName::$columnForList, $aConvertFields);
        return $this->downloadExcel($sModelName::$columnForList, $aData, 'Account Report');
    }

}
