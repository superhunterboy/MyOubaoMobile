<?php
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
/**
 * 各任务基类
 *
 * @author frank
 */
class BaseTask {

    protected $prefix = 'com';
    protected $logBase;
    protected $data;
    protected $log;
    protected $job;

    protected $pid;
    protected $previousProcess;
    protected $logger;
    protected $logPath;
    protected $logFile;
    protected $logFileParam = [];
    protected $lockPath;
    protected $lockFile;
    protected $otherTasks = [];
    protected $startTime;
    protected $finishTime;
    protected $costTime;
    protected $delayOnRelease = 0;

    /**
     * 执行成功，需要delete
     */
    const TASK_SUCCESS = 0;

    /**
     * 执行失败，需要release
     */
    const TASK_KEEP    = 1;

    /**
     * 执行失败，但需要delete后建立新的job
     */
    const TASK_RESTORE = 2;

    /**
     * 接收命令
     * @param Job $job
     * @param array $data
     */
    public function fire($job, $data) {
        $this->job     = $job;
        $this->logBase = $this->getBaseLog($data);
        $this->data    = $data;
//        pr(get_class($this));
//        pr($data);
        $this->init();
        $this->logger->addInfo($this->logBase . ' START');
        if (!$this->checkLock()) {
            $this->log = "STOP: Locked by Previous Process: $this->previousProcess";
            $this->setRelease();
            return 2;
        }
        if (!$this->createLockFile()) {
            $this->log = 'STOP: Can Not Create Lock File';
            $this->setRelease();
            return 2;
        }
        if (!$this->checkData()) {
            $this->log = 'STOP: invalid data';
            $this->setRelease();
            return 2;
        }

        // 执行doCommand,根据返回值来处理job
        $this->startTime = microtime(true);
        $bReturn = $this->doCommand();
        $this->finishTime = microtime(true);
        $this->costTime   = $this->finishTime - $this->startTime;
        $this->log .= ' Finished at ' . date('Y-m-d H:i:s', $this->finishTime) . ' Cost time: ' . number_format($this->costTime, 4) . ' Seconds';
//        pr($bReturn);
        switch ($bReturn){
            case self::TASK_SUCCESS:
                $this->setFinished();
                $iReturn = 0;
                break;
            case self::TASK_KEEP:
                $this->setRelease();
                $iReturn = 2;
                break;
            case self::TASK_RESTORE:
                $this->setRestore();
                $iReturn = 0;
        }
        return $iReturn;
    }

    private function init() {
        $this->logPath = Config::get('log.root') . DS . 'tasks' . DS . date('Ym') . DS . date('d');
        if (!file_exists($this->logPath)) {
            @mkdir($this->logPath, 0777, true);
            @chmod($this->logPath, 0777);
        }
        $this->lockPath = storage_path() . '/locks';
        if (!file_exists($this->lockPath)) {
            @mkdir($this->lockPath, 0777, true);
            @chmod($this->lockPath, 0777);
        }
        $this->lockFile = $this->compileLockFileName();
        $this->logFile  = $this->logPath . '/' . get_class($this);
        !$this->logFileParam or $this->logFile .= '-' . implode('-', $this->logFileParam);
        $this->logger   = new Logger(get_class($this));
        $this->logger->pushHandler(new StreamHandler($this->logFile, Logger::INFO));
        $this->logger->pushHandler(new StreamHandler($this->logFile, Logger::WARNING));
    }

    /**
     * check file lock
     * @return boolean  if true, continue run
     */
    private function checkLock() {
        if (file_exists($this->lockFile)) {
            $this->previousProcess = file_get_contents($this->lockFile);
            if (!ProcessManage::checkProcessExists($this->previousProcess)) {
                $bContinue = @unlink($this->lockFile);
            } else {
                $bContinue = false;
            }
        } else {
            $bContinue = true;
        }
        return $bContinue;
    }

    private function createLockFile() {
        $mReturn = file_put_contents($this->lockFile, $this->pid);
        return $mReturn !== false;
    }

    protected function compileLockFileName() {
        return $this->lockPath . DIRECTORY_SEPARATOR . get_class($this) . '-' . md5(var_export($this->data, true));
    }

    /**
     * 执行命令
     * @return int      self::TASK_SUCCESS or self::TASK_KEEP self::TASK_RESTORE
     */
    protected function doCommand(){
        return self::TASK_KEEP;
    }

    /**
     * 生成日志基础信息
     * @param type $data
     * @return type
     */
    protected function & getBaseLog($data){
        $this->pid = posix_getpid();
//        $date     = Carbon::now()->toDateTimeString();
        $sAction  = String::humenlize(get_class($this));
        $sLogInfo  = " PID: $this->pid $sAction: ";
        $aParams  = [];
        foreach ($data as $key => $value){
            $aParams[] = $key . ': ' . json_encode($value,true);
        }
        $sLogInfo .= implode(' ',$aParams);
        return $sLogInfo;
    }

    /**
     * 向消息队列增加任务
     * @param string $sCommand
     * @param array $data
     * @param string $connection queue
     * @return bool
     */
    protected function pushJob($sCommand,$data,$connection){
        for ($i = 0; $i < 10; $i++){
            if ($bSucc = Queue::push($sCommand,$data,$connection) > 0){
                break;
            }
        }
        return $bSucc;
    }

    /**
     * 从消息队列删除任务,并建立其他的任务
     * @param string $sLogMsg
     */
    protected function setFinished(){
        $this->job->delete();
        $this->logger->addInfo($this->logBase . ' ' . $this->log . ' Job Delete');
        $this->compileOtherTasks();
        $this->addOtherTask();
    }

    /**
     * 恢复任务
     * @param string $sLogMsg
     */
    protected function setRelease(){
        $this->job->release($this->delayOnRelease);
        $this->logger->addInfo($this->logBase . ' ' . $this->log . ' Job Release' . ($this->delayOnRelease ? ' After ' . $this->delayOnRelease . ' Seconds' : ''));
    }

    /**
     * 删除任务，在队列尾新建同样的任务
     */
    protected function setRestore(){
        $sConnection = $this->job->getQueue();
        $this->job->delete();
//        $bSucc = BaseTask::addTask(get_class($this),$this->data,'calculate');
        for ($i = 0,$bSucc = false; $i < 100; $i++){
            if ($bSucc = Queue::push(get_class($this),$this->data,$sConnection) > 0){
                break;
            }
        }
        $this->logger->addInfo($this->logBase . ' ' . $this->log . ' Job Restore');
    }

    protected function checkData(){
        return true;
    }

    /**
     * 新建终止追号和生成追号单任务
     * @param array $aNeedStopTraces
     * @param array $aNeedGenerateTrace
     */
    protected function setTraceTask($aNeedStopTraces,$aNeedGenerateTrace){
        $connection = Config::get('schedule.trace');
        empty($aNeedStopTraces) or $this->pushJob('StopTrace',['traces' => $aNeedStopTraces],$connection);
//        pr($aNeedGenerateTrace);
        if ($aNeedGenerateTrace) {
            foreach ($aNeedGenerateTrace as $iTraceId) {
                $this->pushJob('CreateProject', ['trace_id' => $iTraceId], $connection);
            }
        }
    }

    public static function addTask($sCommand, $data, $sQueue, $iDelaySeconds = 0) {
        $sRealQueue = Config::get('schedule.' . $sQueue);
        if (isset($data['lottery_id'])){
            $sRealQueue = str_replace('%lottery_id%', $data['lottery_id'], $sRealQueue);
        }
//        die($sRealQueue);
        if ($iDelaySeconds > 0) {
            $date = Carbon::now()->addSeconds($iDelaySeconds);
            $bSucc = Queue::later($date, $sCommand, $data, $sRealQueue) > 0;
        } else {
            $bSucc = Queue::push($sCommand, $data, $sRealQueue) > 0;
        }
//        for ($i = 0,$bSucc = false; $i < 100; $i++){
//            if ($bSucc = Queue::push($sCommand, $data, $sRealQueue) > 0) {
//                break;
//            }
//        }
        if (!$bSucc) {
            MissedTask::addMissedTask($sCommand, $data, $sQueue);
        }
//        file_put_contents('/tmp/addtask',var_export(func_get_args(),true) . "\n", FILE_APPEND);
        return $bSucc;
    }

    protected function addOtherTask() {
        foreach ($this->otherTasks as $aTaskInfo) {
            self::addTask($aTaskInfo['command'], $aTaskInfo['data'], $aTaskInfo['queue']);
        }
    }

    protected function compileOtherTasks() {

    }

    public function __destruct() {
        if (file_exists($this->lockFile)) {
            @unlink($this->lockFile);
        }
        if (SysConfig::check('sys_use_sql_log', true)) {
            $sLogPath = Config::get('log.root') . DIRECTORY_SEPARATOR . 'sql' . DIRECTORY_SEPARATOR . date('Ymd');
//            pr($sLogPath);
            if (!file_exists($sLogPath)) {
                @mkdir($sLogPath, 0777, true);
                @chmod($sLogPath, 0777);
            }
            $sLogFile = $sLogPath . DIRECTORY_SEPARATOR . date('H') . '.sql';
            if (!$queries = DB::getQueryLog()){
                return;
            }
//            $me       = DB::connection();
//            pr($queries);
            foreach ($queries as $aQueryInfo) {
//                $sql       = $aQueryInfo['query'];
                $sql = '';
                $aSqlParts = explode('?', $aQueryInfo['query']);
                foreach ($aSqlParts as $i => $sPart) {
                    $sql .= $aSqlParts[$i];
                    if (isset($aQueryInfo['bindings'][$i])) {
                        $bindings = $aQueryInfo['bindings'][$i];
                        !(is_string($bindings) && strlen($bindings) > 0 && $bindings{0} != "'") or $bindings = "'" . $bindings . "'";
                        $sql .= $bindings;
                    }
                }
                $aLogs[] = $sql;
                $aLogs[] = number_format($aQueryInfo['time'], 3) . 'ms';
//                pr($sql);
            }

            @file_put_contents($sLogFile, date('Y-m-d H:i:s') . "\n", FILE_APPEND);
            @file_put_contents($sLogFile, 'Class: ' . get_class($this) . "\n", FILE_APPEND);
//            @file_put_contents($sLogFile, var_export($queries, true) . "\n\n", FILE_APPEND);
            @file_put_contents($sLogFile, implode("\n", $aLogs) . "\n\n", FILE_APPEND);
        }

    }

}
