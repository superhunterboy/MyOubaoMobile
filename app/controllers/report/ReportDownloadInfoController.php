<?php

class ReportDownloadInfoController extends AdminBaseController {

    /**
     * 资源模型名称
     * @var string
     */
    protected $modelName = 'ReportDownloadInfo';

    /**
     * 在渲染前执行，为视图准备变量
     */
    protected function beforeRender() {
        parent::beforeRender();
        $sModelName = $this->modelName;
        switch ($this->action) {
            case 'index':
                $this->setVars('aFileType', ReportDownloadConfig::$aReportType);
            case 'view':
            case 'edit':
            case 'create':
                break;
        }
    }

    public function index() {
        $aReportType = ReportDownloadRole::getReportTypeIdByUserId(Session::get('admin_user_id'));
        if (key_exists('file_type', $this->params) && $this->params['file_type']) {
            $this->params['file_type'] = array_intersect($aReportType, [$this->params['file_type']]);
        } else {
            $this->params['file_type'] = $aReportType;
        }
        return parent::index();
    }

    public function download($id = null) {
        if (is_null($id)) {
            return $this->goBack('error', 'no-data');
        }
        $oDownloadInfo = ReportDownloadInfo::find($id);
        if (!is_object($oDownloadInfo)) {
            return $this->goBack('error', 'missing-data');
        }
        if (!ReportDownloadRole::checkRoleExist($oDownloadInfo->file_type, Session::get('admin_user_id'))) {
            return $this->goBack('error', 'download-not-allowed');
        }
        $sFullFileName = $oDownloadInfo->file_path . $oDownloadInfo->file_name;
        if (!file_exists($sFullFileName)) {
            return $this->goBack('error', 'file-not-exists');
        }
        $bSucc = ReportDownloadRecord::saveDownloadRecord($id, Session::get('admin_user_id'));
        if (!$bSucc) {
            return $this->goBack('error', 'cannot make a record');
        }
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header("Content-Disposition: attachment; filename=" . $oDownloadInfo->file_name);
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($sFullFileName));
        ob_clean();
        flush();
        readfile($sFullFileName);
        exit;


//        return $this->goBackToIndex('success', 'download-success');
    }

    public function indexQuery() {
        $aConditions = & $this->makeSearchConditions();
        $aPlusConditions = $this->makePlusSearchConditions();
        $aConditions = array_merge($aConditions, $aPlusConditions);
        $oQuery = $this->model->doWhere($aConditions);
// TODO 查询软删除的记录, 以后需要调整到Model层
        $bWithTrashed = trim(Input::get('_withTrashed', 0));
        if ($bWithTrashed)
            $oQuery = $oQuery->withTrashed();
        if ($sGroupByColumn = Input::get('group_by')) {
            $oQuery = $this->model->doGroupBy($oQuery, [$sGroupByColumn]);
        }
// 获取排序条件
        $aOrderSet = [];
        if ($sOorderColumn = Input::get('sort_up', Input::get('sort_down'))) {
            $sDirection = Input::get('sort_up') ? 'asc' : 'desc';
            $aOrderSet[$sOorderColumn] = $sDirection;
        }
        $oQuery = $this->model->doOrderBy($oQuery, $aOrderSet);
        return $oQuery;
    }

    /**
     * 提现搜索中附加的搜索条件
     */
    public function makePlusSearchConditions() {
        $aPlusConditions = [];
        $aFileType = $this->params['file_type'];
        if (isset($aFileType) && count($aFileType) > 0) {
            $aPlusConditions['file_type'] = ['in', $aFileType];
        } else {
            $aPlusConditions['file_type'] = ['=', null];
        }
        return $aPlusConditions;
    }

}
