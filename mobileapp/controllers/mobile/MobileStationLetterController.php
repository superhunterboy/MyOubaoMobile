<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

# 站内信

class MobileStationLetterController extends StationLetterController {

    protected $resourceView = 'stationLetter';

        /**
     * [viewMessage 查看站内信详情, 相当于自定义view, 用户阅读后标记已读/未读状态, 并根据是否保持属性判断该条信息是否阅后即焚]
     * @param  [Integer] $id [站内信记录id]
     * @return [Response]    [description]
     */
    public function viewMessage($id) {
        $this->model = $this->model->find($id);
        if (!is_object($this->model)) {
            return $this->goBackToIndex('error', __('_basic.missing', $this->langVars));
        }
        // pr($this->model->msg_id);
        // pr(MsgMessage::find($this->model->msg_id)->content);
        // exit;
        // 只记录用户第一次阅读的时间
        if (!$this->model->readed_at && !$this->model->deleted_at) {
            $this->model->readed_at = date('Y-m-d H:i:m');
            $this->model->is_readed = 1;
            if (!$this->model->is_keep) {
                $this->model->deleted_at = date('Y-m-d H:i:m');
                $this->model->is_deleted = 1;
            }
        }

        $this->model->save([
            'readed_at' => MsgUser::$rules['readed_at'],
            'is_readed' => MsgUser::$rules['is_readed']
        ]);

        $oMsgMessage = MsgMessage::find($this->model->msg_id);
        // pr($oMsgMessage->exists);exit;
        if (!$oMsgMessage->exists)
            return $this->goBackToIndex('error', __('_basic.missing', $this->langVars));
        $this->model->msg_content = $oMsgMessage->content;
        $data = $this->model;
        $this->setVars(compact('data'));
        $this->view = $this->resourceView.'.view';
        return $this->render();
    }
    
}