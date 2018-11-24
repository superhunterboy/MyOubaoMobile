<?php
class MsgUserController extends AdminBaseController
{
    /**
     * 资源视图目录
     * @var string
     */
    // protected $resourceView = 'message';
    protected $customViewPath = 'message';
    protected $customViews = [
        'index', 'viewMessage',
    ];

    /**
     * 资源模型名称，初始化后转为模型实例
     * @var string|Illuminate\Database\Eloquent\Model
     */
    protected $modelName = 'MsgUser';

    protected function beforeRender()
    {
        parent::beforeRender();
        $aDeletedStatus = MsgUser::$aDeletedStatus;
        $aReadedStatus  = MsgUser::$aReadedStatus;
        $this->setVars(compact('aDeletedStatus', 'aReadedStatus'));
        switch ($this->action) {
            case 'index':
                $aMsgTypes = MsgType::getMsgTypesByGroup();
                $bWithTrashed = true;
                $bNeedCalendar = true;
                // pr($aDeletedStatus);exit;
                $this->setVars(compact('aMsgTypes', 'bWithTrashed', 'bNeedCalendar'));
                break;
            // case 'createMessage':
            //     $aMsgTypes = MsgType::getMsgTypesByGroup(0);
            //     $this->setVars(compact('aMsgTypes'));
            //     break;
            case 'viewMessage':
                $aMsgTypes = MsgType::getMsgTypesByGroup(0);
                $this->viewVars['aColumnSettings']['msg_content'] = [
                    'required' => 1,
                    'type'     => 'string',
                    'form_type'=> 'text'
                ];
                $this->setVars(compact('aMsgTypes'));
                break;
            default:
                # code...
                break;
        }

    }
    public function index()
    {
        $this->params = trimArray(Input::except('_withTrashed'));
        return parent::index();
    }
    /**
     * [viewMessage 自定义查看详情]
     * @param  [integer] $id [消息记录id]
     */
    public function viewMessage($id)
    {
        $this->model = $this->model->find($id);
        if (!is_object($this->model)) {
            return $this->goBackToIndex('error', __('_basic.missing', $this->langVars));
        }
        $this->model->msg_content = MsgMessage::find($this->model->msg_id)->content;
        $data = $this->model;
        $this->setVars(compact('data'));
        return $this->render();
    }

}