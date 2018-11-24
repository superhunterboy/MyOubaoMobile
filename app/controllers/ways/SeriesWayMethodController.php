<?php

class SeriesWayMethodController extends AdminBaseController {
    /**
     * 资源视图目录
     * @var string
     */
    protected $resourceView = 'default';
    /**
     * self view path
     * @var string
     */
    protected $customViewPath = 'ways.series-way-method';
    /**
     * views use custom view path
     * @var array
     */
    protected $customViews = [
        'index',
        'create',
        'edit',
        'view'
    ];

    /**
     * 资源模型名称
     * @var string|Illuminate\Database\Eloquent\Model
     */
    protected $modelName = 'SeriesWayMethod';

//    /**
//     * 资源创建页面
//     * @return Response
//     */
//    public function create($id = null) {
//        if (Request::method() == 'POST') {
//            DB::connection()->beginTransaction();
//            if ($bSucc = $this->saveData($id)) {
//                DB::connection()->commit();
//                return $this->goBackToIndex('success', __('_basic.created', $this->langVars));
//            } else {
//                // pr($this->model->toArray());
//                // pr('---------');
////                 pr($this->model->validationErrors);exit;
//                DB::connection()->rollback();
//                $this->langVars['reason'] = & $this->model->getValidationErrorString();
////                pr($this->langVars);
////                exit;
//                return $this->goBack('error', __('_basic.create-fail', $this->langVars));
//            }
//        } else {
//            $data = $this->model;
//            $isEdit = false;
//            $this->setVars(compact('data', 'isEdit'));
//            $sModelName = $this->modelName;
//            if ($sModelName::$treeable) {
//                $sFirstParamName = 'parent_id';
//            } else {
//                foreach ($this->paramSettings as $sFirstParamName => $tmp) {
//                    break;
//                }
//            }
//            $aInitAttributes = isset($sFirstParamName) ? [$sFirstParamName => $id] : [];
//            $this->setVars(compact('aInitAttributes'));
//            $this->resourceView = 'lottery.way';
//            return $this->render();
//        }
//    }

    /**
     * 在渲染前执行，为视图准备变量
     */
    protected function beforeRender() {
        parent::beforeRender();
        $oSeriesMethod = new SeriesMethod;
        $oBasicWay = new BasicWay;
        $aConditions    = !empty($this->viewVars[ 'series_id' ]) ? [ 'series_id' => [ '=',$this->viewVars[ 'series_id' ]]] : [];
        $aSeriesMethods = $oSeriesMethod->getValueListArray('name',$aConditions,null,true);
//        $oSeries = new Series;
        $oSeries        = !empty($this->viewVars[ 'series_id' ]) ? Series::find($this->viewVars[ 'series_id' ]) : new Series;
        $aConditions    = $oSeries->id ? [ 'lottery_type' => [ '=',$oSeries->type]] : [];
        $aBasicWays     = $oBasicWay->getValueListArray('name',$aConditions,null,true);
        $this->setVars('aSeries',Series::getTitleList());
        $this->setVars(compact('aSeriesMethods','aBasicWays'));
    }

}