<?php

class DomainApiController extends Controller
{
    /**
     * 资源模型名称，初始化后转为模型实例
     * @var string|Illuminate\Database\Eloquent\Model
     */
    protected $modelName = 'Domain';
    //
    public function getDomains(){
        $this->model = App::make($this->modelName);
        $oQuery = $this->model->get(['domain'])->take(10)->toJson();
        echo $oQuery;
        exit;
    }


}
