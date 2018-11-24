<?php

/**
 * Class EventTaskQueue - 任务事件处理队列
 *
 * @author Johnny <Johnny@anvo.com>
 */
class EventTaskQueue extends BaseTask
{
    /**
     * 处理任务
     *
     * @return int
     */
    public function doCommand(& $sMsg = null)
    {
        $data = $this->data;
        DB::connection()->beginTransaction();
        try
        {
            $tasks = ActivityTask::findAllByEvent($data['event']);
            $messages   = [];

            foreach ($tasks as $task)
            {
                if (!$task->complete($data['user_id'], $data['data']))
                {
                    $messages   = array_merge($messages, $task->errors()->getMessages());
                }
            }

            $this->log  .= json_encode($messages) . "\n -> [{$data['event']}] task finished";
            DB::connection()->commit();
            return self::TASK_SUCCESS;
        }
        catch(Exception $e)
        {
            DB::connection()->rollBack();
            $this->log  = "Exception abnormal: ".$e->getMessage();
            return self::TASK_RESTORE;
        }
    }

}