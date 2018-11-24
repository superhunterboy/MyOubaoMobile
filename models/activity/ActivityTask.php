<?php

/**
 * Class task - 活动任务表
 *
 * @author Johnny <Johnny@anvo.com>
 */
use \Illuminate\Support\MessageBag;

class ActivityTask extends BaseModel {

    /**
     * 开启CACHE机制
     *
     * CACHE_LEVEL_FIRST : memcached
     *
     * @var int
     */
    protected static $cacheLevel = self::CACHE_LEVEL_FIRST;

    //一次性任务
    const DISPOSABEL_TASK = 0;
    //每日任务
    const DAILY_TASK = 1;
    //多次任务
    const MULTIPLE_TASK = 2;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'activity_tasks';

    /**
     * 软删除
     * @var boolean
     */
    protected $softDelete = false;
    protected $fillable = [
        'activity_id',
        'activity_name',
        'name',
        'need_sign',
        'start_time',
        'end_time',
        'type',
    ];
    public static $resourceName = 'ActivityTask';
    public static $mainParamColumn = 'activity_id';
    public static $titleColumn = 'name';

    /**
     * the columns for list page
     * @var array
     */
    public static $columnForList = [
        'activity_name',
        'name',
        'need_sign',
        'start_time',
        'end_time',
        'type',
    ];
    public static $aTypes = [
        self::DISPOSABEL_TASK => 'one-time-task',
        self::DAILY_TASK => 'each-day-task',
        self::MULTIPLE_TASK => 'multiple-task',
    ];
    public static $htmlSelectColumns = [
        'activity_id' => 'aActivities',
        'type' => 'aTypes',
    ];
    public static $ignoreColumnsInEdit = ['activity_name'];
    public static $rules = [
        'name' => 'required|between:0,50',
        'need_sign' => 'in:0,1',
        'activity_id' => 'required|integer',
        'activity_name' => 'required|between:1,45',
        'start_time' => 'date',
        'end_time' => 'date',
        'type' => 'in:0,1,2',
    ];

    /**
     * 获取到任务相关所有的条件
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function conditions() {
        return $this->hasMany('ActivityCondition', 'task_id', 'id')->orderBy('sequence', 'asc');
    }

    /**
     * 活动
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function activity() {
        return $this->belongsTo('Activity', 'activity_id', 'id');
    }

    /**
     * 任务奖品信息
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function taskPrizes() {
        return $this->hasMany('ActivityTaskPrize', 'task_id', 'id');
    }

    public function act() {
        return Activity::find($this->activity_id);
    }

    /**
     * 验证活动是否在有效时间范围
     *
     * @return bool
     */
    public function isValidateTask($sTime = null) {
        $now = is_null($sTime) ? date('Y-m-d H:i:s') : $sTime;
        if ($this->start_time && $this->start_time > $now) {
            return false;
        }

        if ($this->end_time && $this->end_time < $now) {
            return false;
        }

        return $this->activity()->first()->isValidateActivity($now);
    }

    /**
     *
     * 扩展参数修饰器
     *
     * @param $value
     * @return array
     */
    public function getTaskStartTimeAttribute($value) {
        if (!$this->start_time) {
            $activity = $this->activity()->first();
            return $activity->start_time;
        }
        return $this->start_time;
    }

    /**
     *
     * 扩展参数修饰器
     *
     * @param $value
     * @return array
     */
    public function getTaskEndTimeAttribute($value) {
        if (!$this->end_time) {
            $activity = $this->activity()->first();
            return $activity->end_time;
        }
        return $this->end_time;
    }

    /**
     * 条件满足则更新数据库
     *
     * 遇到第一个不满足的条件就停止
     *
     */
    public function complete($user_id) {
        $this->validationErrors = new MessageBag();
        //过滤掉无效活动
        if (!$this->isValidateTask()) {
            $this->validationErrors->add('start_time', "Task [{$this->id}] has been expired");
            return false;
        }
        $aCondition = [
            'user_id' => $user_id,
            'task_id' => $this->id,
            'activity_id' => $this->activity_id,
        ];
        // 每日任务增加报名日期
        $this->type != self::DAILY_TASK or $aCondition['sign_date'] = date('Y-m-d');
        //如果活动需要报名而未报名则返回失败
        $userTask = ActivityUserTask::firstOrNew($aCondition);
        //过滤掉需要报名,而没有报名的情况
        if ($this->need_sign && !$userTask->is_signed) {
            $this->validationErrors->add('is_signed', " Registrations is required for task [{$this->id}]");
            return false;
        }
        //过滤掉已完成的任务
        if ($this->isFinsh($userTask)) {
            return true;
        }
        //循环判断任务内的条件情况
        foreach ($this->conditions()->get() as $condition) {
            $aCondition = [
                'user_id' => $user_id,
                'condition_id' => $condition->id,
                'task_id' => $condition->task_id,
                'activity_id' => $condition->activity_id
            ];
            // 每日任务增加报名日期
            $this->type != self::DAILY_TASK or $aCondition['condition_date'] = date('Y-m-d');
            $userCondition = ActivityUserCondition::firstOrCreate($aCondition);
            if (!$this->isFinsh($userCondition)) {
                if (!FactoryClass::Factory($condition)->load($userCondition)->process()) {
                    $this->validationErrors->add('task_id', "Either one of the task : [ {$condition->task_id} ] - condition : {$condition->id} - User: [{$userCondition->user_id}] not satisfied!");
                    return false;
                }
            }
        }

        //用户任务完成
        if (!$userTask->completed()) {
            //数据异常需要回滚
            throw new Exception("User [{$userTask->user_id}] task [{$userTask->id}] status failed");
        }

//        完成则发放礼物
        if (!$this->send($user_id)) {
            //数据异常需要回滚
            throw new Exception("User [{$userTask->user_id} - {$userTask->id}]  prize status send failed");
        }
        return true;
    }

    /**
     * 发放奖品
     *
     * @param $user_id
     * @return bool
     */
    public function send($user_id, $aExtraData = null, $sSource = ActivityUserPrize::SOURCE_TASK_SYSTEM) {
        foreach ($this->taskPrizes()->get() as $taskPrize) {
            //是否自动生成奖品
            if ($sSource == ActivityUserPrize::SOURCE_TASK_SYSTEM && $taskPrize->is_auto_send == 0) {
                continue;
            }
            if (!$taskPrize->send($user_id, $aExtraData, $sSource)) {
                return false;
            }
        }
        return true;
    }

    /**
     * 判断任务或者是条件是否已完成
     *
     */
    public function isFinsh(ActivityTaskTypeInterface $userObject) {
        /**
         * 0为未完成状态, 1为已完成(循环任务需要进一步判断)
         */
        $status = $userObject->getStatus();
        $finish_time = $userObject->getFinshTime();

        if ($status != 1) {
            return false;
        }

        /**
         * 区分不同类型的任务(目前主要分0:一次性任务, 1:每日任务)
         *
         * 这一块有必要的话,后期做扩展,支持更多类型的任务
         *
         */
        switch ($this->type) {
            case ActivityTask::DISPOSABEL_TASK :
                return true;
                break;
            case ActivityTask::DAILY_TASK :
                if (date("Y-m-d") == date("Y-m-d", strtotime($finish_time))) {
                    return true;
                }
                break;
            case ActivityTask::MULTIPLE_TASK :
                return false;
                break;
        }
        return false;
    }

    /**
     * 根据事件获取相关的任务
     *
     * @param $event
     * @return array
     */
    static public function findAllByEvent($event) {
        $data = ActivityConditionClass::findAllByEvent($event);

        $tasks = [];
        foreach ($data as $value) {
            foreach ($value->conditions()->get() as $condition) {
                if (!isset($tasks[$condition['task_id']])) {
                    $tasks[$condition['task_id']] = $condition->task()->first();
                }
            }
        }

        return $tasks;
    }

    /**
     * 特殊处理,为空的时候,默认为NULL
     *
     */
    protected function beforeSave() {

        if (!$this->start_time) {
            $this->start_time = NULL;
        }

        if (!$this->end_time) {
            $this->end_time = NULL;
        }
    }

    /**
     * 验证前操作
     *
     * @return bool
     */
    protected function beforeValidate() {
        $oActivity = Activity::find($this->activity_id);
        if (is_object($oActivity)) {
            $this->activity_name = $oActivity->name;
        } else {
            return false;
        }
        return parent::beforeValidate();
    }

}

/**
 * 活动类型判断接口
 *
 * Interface ActivityTaskTypeInterface
 */
interface ActivityTaskTypeInterface {

    /**
     * 获得状态
     * @return mixed
     */
    public function getStatus();

    /**
     * 获得完成时间
     * @return mixed
     */
    public function getFinshTime();
}
