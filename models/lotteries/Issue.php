<?php
use Illuminate\Support\Facades\Redis;

class Issue extends BaseModel {

    static $cacheLevel = self::CACHE_LEVEL_FIRST;
    public static $resourceName = 'Issue';
    protected $table = 'issues';
    protected $maxFutureListLength = 10;
    protected $maxFinishedListLength = 20;

    /**
     * the columns for list page
     * @var array
     */
    public static $columnForList = [];
    protected $fillable = [];

    /**
     * order by config
     * @var array
     */
    public $orderColumns = [
        'issue' => 'asc'
    ];

    /**
     * the main param for index page
     * @var string
     */
    public static $mainParamColumn = 'lottery_id';

    /**
     * 下拉列表框字段配置
     * @var array
     */
    public static $htmlSelectColumns = [];

    /**
     * The rules to be applied to the data.
     *
     * @var array
     */
    public static $rules = [
            // 'name'                => 'required|between:1,10',
            // 'type'                => 'required|numeric',
            // 'lotto_type'          => 'numeric',
            // 'high_frequency'      => 'in:0,1',
            // 'sort_winning_number' => 'in:0,1',
            // 'valid_nums'          => 'required',
            // 'buy_len'             => 'required',
            // 'code_len'            => 'required',
            // 'identifier'          => 'required|between:3,10',
            // 'days'                => 'numeric',
            // 'issue_over_midnight' => 'in:0,1',
            // 'issue_format'        => 'required',
            // 'begin_time'          => 'required',
            // 'end_time'            => 'required',
            // 'need_draw'           => 'in:0,1',
            // 'sequence'            => 'numeric',
    ];

    /**
     * The array of custom error messages.
     *
     * @var array
     */
    public static $customMessages = [];

    /**
     * title field
     * @var string
     */
    public static $titleColumn = 'name';

    /**
     * 中奖号码状态：等待开奖
     */
    const ISSUE_CODE_STATUS_WAIT_CODE = 1;

    /**
     * 中奖号码状态：已输入号码，等待审核
     */
    const ISSUE_CODE_STATUS_WAIT_VERIFY = 2;

    /**
     * 中奖号码状态：号码已审核
     */
    const ISSUE_CODE_STATUS_FINISHED = 4;

    /**
     * 中奖号码状态：号码已取消开奖
     */
    const ISSUE_CODE_STATUS_CANCELED = 8;

    /**
     * 中奖号码状态：提前开奖A，获取到开奖号码的时间早于官方理论开奖时间
     */
    const ISSUE_CODE_STATUS_ADVANCE_A = 32;

    /**
     * 中奖号码状态：提前开奖B，获取到开奖号码的时间早于销售截止时间
     */
    const ISSUE_CODE_STATUS_ADVANCE_B = 64;

    /**
     * 计奖状态
     */
    const CALCULATE_NONE = 0;
    const CALCULATE_PROCESSING = 1;
    const CALCULATE_PARTIAL = 2;
    const CALCULATE_FINISHED = 4;

    /**
     * 派奖状态
     */
    const PRIZE_NONE = 0;
    const PRIZE_PROCESSING = 1;
    const PRIZE_PARTIAL = 2;
    const PRIZE_FINISHED = 4;

    /**
     * 派佣金状态
     */
    const COMMISSION_NONE = 0;
    const COMMISSION_PROCESSING = 1;
    const COMMISSION_PARTIAL = 2;
    const COMMISSION_FINISHED = 4;

    /**
     * 追号单状态
     */
    const TRACE_PRJ_NONE = 0;
    const TRACE_PRJ_PROCESSING = 1;
    const TRACE_PRJ_PARTIAL = 2;
    const TRACE_PRJ_FINISHED = 4;

    /**
     * 中奖号码状态数组
     * @var array
     */
    public static $winningNumberStatus = [
        self::ISSUE_CODE_STATUS_WAIT_CODE => 'Waiting For Number',
        self::ISSUE_CODE_STATUS_WAIT_VERIFY => 'Waiting For Verify',
        self::ISSUE_CODE_STATUS_FINISHED => 'Verified',
        self::ISSUE_CODE_STATUS_CANCELED => 'Canceled',
    ];
    public static $calculateStatus = [
        self::CALCULATE_NONE => 'waiting',
        self::CALCULATE_PROCESSING => 'running',
        self::CALCULATE_PARTIAL => 'partial',
        self::CALCULATE_FINISHED => 'done'
    ];
    public static $prizeStatus = [
        self::PRIZE_NONE => 'waiting',
        self::PRIZE_PROCESSING => 'running',
        self::PRIZE_PARTIAL => 'partial',
        self::PRIZE_FINISHED => 'done'
    ];
    public static $commissionStatus = [
        self::COMMISSION_NONE => 'waiting',
        self::COMMISSION_PROCESSING => 'running',
        self::COMMISSION_PARTIAL => 'partial',
        self::COMMISSION_FINISHED => 'done'
    ];
    public static $tracePrjStatus = [
        self::TRACE_PRJ_NONE => 'waiting',
        self::TRACE_PRJ_PROCESSING => 'running',
        self::TRACE_PRJ_PARTIAL => 'partial',
        self::TRACE_PRJ_FINISHED => 'done'
    ];

    const ERRNO_ISSUE_MISSING = -910;
    const ERRNO_ISSUE_EXPIRED = -911;

    /**
     * 官方未开奖时的中奖号码
     */
    const ISSUE_CODE_CANCELED = 'XXXXX';

    /**
     * 录错号标识
     */
    const ISSUE_CODE_FAIL = 'FFFFF';
    const ISSUE_CODE_CLEAR = 'CCCCC';

    public static $specialFlags = [
        self::ISSUE_CODE_CANCELED,
        self::ISSUE_CODE_FAIL
    ];

    /**
     * 获取指定游戏的奖期对象
     * @param int $iLotteryId
     * @param int $iCount
     * @param int $iBeginTime
     * @return Collection
     */
    function getIssueObjects($iLotteryId, $iCount = null, $iBeginTime = null, $iEndTime = null, $bOrderDesc = false) {
//        $iBeginTime or $iBeginTime = time();
        $iCount or $iCount = 120;
        $aCondtions = [
            'lottery_id' => ['=', $iLotteryId],
        ];
        if ($iBeginTime || $iEndTime) {
            if ($iBeginTime && $iEndTime) {
                $aCondtions['end_time'] = ['between', [$iBeginTime, $iEndTime]];
            } else {
                $sOperator = $iBeginTime ? '>=' : '<=';
                $iTime = $iBeginTime ? $iBeginTime : $iEndTime;
                $aCondtions['end_time'] = [ $sOperator, $iTime];
            }
        }
        $aOrderBy = ['issue' => $bOrderDesc ? 'desc' : 'asc'];
        $oQuery = $this->doWhere($aCondtions);
        $oQuery = $this->doOrderBy($oQuery, $aOrderBy);
        return $oQuery->paginate($iCount);
//        return $oQuery->take($iCount)->get();
    }

    private static function compileIssueListCacheKey($iLotteryId) {
        return self::getCachePrefix(true) . 'lists-lottery-' . $iLotteryId;
    }

    private static function compileOnSaleIssueCacheKey($iLotteryId){
        return self::getCachePrefix() . 'on-sale-issue-' . $iLotteryId;
    }

    public function & getIssueArrayForBet($iLotteryId, $iCount = null, $iBeginTime = null, $iEndTime = null, $bOrderDesc = false, $bStop = false) {
        $aIssues = $this->_getIssueArrayForBet($iLotteryId, $iCount, $iBeginTime, $iEndTime, $bOrderDesc);
        $iCurrentTime = time();
        foreach ($aIssues as $i => $aIssue) {
            if ($iCurrentTime < $aIssue['end_time']) {
                break;
            }
            if ($iCurrentTime > $aIssue['end_time']) {
                unset($aIssues[$i]);
            }
        }
        sort($aIssues);
        if (count($aIssues) < $iCount && !$bStop) {
            Cache::setDefaultDriver(static::$cacheDrivers[static::$cacheLevel]);
            $sCacheKey = self::compileIssueListCacheKey($iLotteryId);
            Cache::forget($sCacheKey);
            $aIssuesForBet = $this->getIssueArrayForBet($iLotteryId, $iCount, $iBeginTime, $iEndTime, $bOrderDesc, true);
        } else {
            $aIssuesForBet = [];
            $iTrueCount = min($iCount, count($aIssues));
            for ($i = 0; $i < $iTrueCount; $i++) {
                $aIssuesForBet[] = [
                    'number' => $aIssues[$i]['issue'],
                    'time' => date('Y-m-d H:i:s', $aIssues[$i]['end_time'])
                ];
            }
        }
        return $aIssuesForBet;
//        pr($aIssuesForBet);
//        exit;
//        for($i++,$j = 0;$j < $iCount;$i++,$j++){
//            $gameNumbers[] = [
//                'number' => $aIssues[$i]['issue'] ,
//                'time'   => date('Y-m-d H:i:s' , $aIssues[$i]['end_time'])
//            ];
//        }
    }

    /**
     * 获取指定游戏的奖期数组
     * @param int $iLotteryId
     * @param int $iCount
     * @param int $iBeginTime
     * @return Collection
     */
    private function & _getIssueArrayForBet($iLotteryId, $iCount = null, $iBeginTime = null, $iEndTime = null, $bOrderDesc = false) {
//        $iBeginTime or $iBeginTime = time();
        $iCount or $iCount = 120;
        $bReadDb = true;
        $bPutCache = false;
        if (static::$cacheLevel != self::CACHE_LEVEL_NONE) {
            Cache::setDefaultDriver(static::$cacheDrivers[static::$cacheLevel]);
            $sCacheKey = self::compileIssueListCacheKey($iLotteryId);
            if ($aIssues = Cache::get($sCacheKey)) {
                $bReadDb = false;
            } else {
                $bPutCache = true;
            }
        }
        if ($bReadDb) {
            $aCondtions = [
                'lottery_id' => ['=', $iLotteryId],
            ];
            if ($iBeginTime || $iEndTime) {
                if ($iBeginTime && $iEndTime) {
                    $aCondtions['end_time'] = ['between', [$iBeginTime, $iEndTime]];
                } else {
                    $sOperator = $iBeginTime ? '>=' : '<=';
                    $iTime = $iBeginTime ? $iBeginTime : $iEndTime;
                    $aCondtions['end_time'] = [ $sOperator, $iTime];
                }
            }
            $aOrderBy = ['issue' => $bOrderDesc ? 'desc' : 'asc'];
            $oQuery = $this->doWhere($aCondtions);
            $oQuery = $this->doOrderBy($oQuery, $aOrderBy);
            $oIssues = $oQuery->take($iCount * 2)->get();
            $aIssues = [];
            foreach ($oIssues as $oIssue) {
                $aIssues[] = $oIssue->getAttributes();
            }
        }
        if ($bPutCache) {
            Cache::forever($sCacheKey, $aIssues);
        }
//        pr($aIssues);
//        exit;
        return $aIssues;
    }

    private static function compileIssueCacheKey($iLotteryId, $sIssue){
        return self::getCachePrefix() . $iLotteryId . '-' . $sIssue;
    }

    /**
     * 返回指定游戏和奖期号的奖期对象
     * @param int $iLotteryId
     * @param string $sIssue
     * @return Issue
     */
    public static function getIssue($iLotteryId, $sIssue) {
        if (!$iLotteryId || !$sIssue){
            return false;
        }
        $bReadDb = true;
        $bPutCache = false;
        if (static::$cacheLevel != self::CACHE_LEVEL_NONE){
            Cache::setDefaultDriver(static::$cacheDrivers[static::$cacheLevel]);
            $sCacheKey = self::compileIssueCacheKey($iLotteryId, $sIssue);
            if ($aIssueInfo = Cache::get($sCacheKey)) {
                $oIssue = new static;
                $oIssue = $oIssue->newFromBuilder($aIssueInfo);
                $bReadDb = false;
            }
            else{
                $bPutCache = true;
            }
        }
        if ($bReadDb){
            $oIssue = self::where('lottery_id', '=', $iLotteryId)->where('issue', '=', $sIssue)->get()->first();
            if (!is_object($oIssue)) {
                return false;
            }
        }

        if ($bPutCache){
            Cache::put($sCacheKey, $oIssue->toArray(), intval($oIssue->cycle / 60));
        }
        return $oIssue;
//        return self::where('lottery_id', '=', $iLotteryId)->where('issue', '=', $sIssue)->get()->first();
    }

     public static function clearCacheByIssue($iLotteryId, $sIssue) {
        $sCacheKey = self::compileIssueCacheKey($iLotteryId, $sIssue);
        if (static::$cacheLevel != self::CACHE_LEVEL_NONE) {
            Cache::setDefaultDriver(static::$cacheDrivers[static::$cacheLevel]);
            !Cache::has($sCacheKey) or Cache::forget($sCacheKey);
        }
    }
    
    public static function & getRecentIssues($iLotteryId,$iCount = 20){
        $bReadDb = false;
        $bPutCache = false;
        if (static::$cacheLevel == self::CACHE_LEVEL_NONE){
            $bReadDb = true;
            $bPutCache = false;
        }
        else{
            Cache::setDefaultDriver(static::$cacheDrivers[static::$cacheLevel]);
            $key = self::compileRecentIssuesCacheKey($iLotteryId, $iCount);
            if (!$aIssues = Cache::get($key)){
                $bReadDb = true;
                $bPutCache = true;
            }
        }
        if ($bReadDb){
            $oMoreIssues = self::getRecentIssuesFromDb($iLotteryId, $iCount, 0, null);
            $aIssues = [];
            foreach($oMoreIssues as $oIssue){
                $aIssues[] = $oIssue->toArray();
            }
        }
        $iOnSaleEndTime = self::getOnSaleIssueEndTime($iLotteryId);
        !$bPutCache or Cache::put($key, $aIssues, ($iOnSaleEndTime - time()) / 60);
//        pr(Cache::has($key));
//        pr($aIssues);
//        exit;
        return $aIssues;
    }

    public static function & getRecentIssuesRedis($iLotteryId,$iCount = 20){
        $redis = Redis::connection();
        $sCacheKey = self::compileRecentIssuesCacheKey($iLotteryId, $iCount);
        $aIssues = [];
        if ($bHasInRedis = $redis->exists($sCacheKey)){
            $aIssues = self::getDataFromRedis($redis, $sCacheKey, $iCount, $iNeedCount);
        }
        else{
            $iNeedCount = $iCount;
        }
//        pr($iNeedCount);
        if (!$bHasInRedis || $iNeedCount > 0){
            $oMoreIssues = self::getRecentIssuesFromDb($iLotteryId, $iNeedCount, $iCount - $iNeedCount, null);
            $aMoreIssues = & self::pushToList($redis, $sCacheKey, $oMoreIssues, false);
            $iOnSaleEndTime = self::getOnSaleIssueEndTime($iLotteryId);
            $redis->expire($sCacheKey, $iOnSaleEndTime - time());
            $aIssues = array_merge($aIssues, $aMoreIssues);
        }
//        pr($aIssues);
//        exit;
        return $aIssues;
    }

    /**
     * 返回最近n期的开奖号码
     * @param int $iLotteryId
     * @return array | false            issue wn_number
     */
    public static function & getLatestWnNumbers($iLotteryId, $iCount = 1) {
        $redis = Redis::connection();
        $sCacheKey = self::compileRecentWnNumbersCacheKey($iLotteryId);
        $aIssues = [];
        if ($bHasInRedis = $redis->exists($sCacheKey)){
            $aIssues = self::getDataFromRedis($redis, $sCacheKey, $iCount, $iNeedCount);
        }
        else{
            $iNeedCount = $iCount;
        }
        if (!$bHasInRedis || $iNeedCount > 0){
            $oMoreIssues = self::getRecentIssuesFromDb($iLotteryId, $iNeedCount,count($aIssues), true);
            $aMoreIssues = & self::pushToList($redis, $sCacheKey, $oMoreIssues, false);
            $iOnSaleEndTime = self::getOnSaleIssueEndTime($iLotteryId);
            $redis->expire($sCacheKey, $iOnSaleEndTime - time());
            $aIssues = array_merge($aIssues, $aMoreIssues);
        }
//        pr($aIssues);
//        exit;
        return $aIssues;
    }

    protected static function compileFutureIssuesCacheKey($iLotteryId){
        return self::getCachePrefix(true) . 'future-issues-' . $iLotteryId;
    }

    /**
     * 返回当前期后最近n期的未开奖奖期
     * @param int $iLotteryId
     * @return array | false            issue wn_number
     */
    public static function & getFutureIssues($iLotteryId, $sIssue, $iCount = 6) {
        $redis = Redis::connection();
        $sCacheKey = self::compileFutureIssuesCacheKey($iLotteryId);
        $aIssues = [];
        if ($bHasInRedis = $redis->exists($sCacheKey)){
            $aIssues = self::getDataFromRedis($redis, $sCacheKey, $iCount, $iNeedCount);
//            pr($aIssues);
//            exit;
        }
        else{
            $iNeedCount = $iCount;
        }
        if (!$bHasInRedis || $iNeedCount > 0){
            $sStartIssue = !empty($aIssues) ? $aIssues[count($aIssues) - 1]['issue'] : $sIssue;
            $oMoreIssues = self::getFutureIssuesFromDb($iLotteryId, $sStartIssue, $iNeedCount);     // todo: 此处的奖期号存在问题
            $aMoreIssues = & self::pushToList($redis, $sCacheKey, $oMoreIssues, false);
            $iOnSaleEndTime = self::getOnSaleIssueEndTime($iLotteryId);
            $redis->expire($sCacheKey, $iOnSaleEndTime - time());
            $aIssues = array_merge($aIssues, $aMoreIssues);
        }
//        pr($aIssues);
//        exit;
        return $aIssues;
    }

    protected static function getRecentIssuesFromDb($iLotteryId, $iCount = 6, $iSkipCount = null, $iHasWnNumber = null){

        $aColumns = ['issue', 'wn_number', 'offical_time'];
        $aCondtions = [
            'lottery_id' => [ '=', $iLotteryId],
            'end_time' => [ '<', time()],
        ];
        if (!is_null($iHasWnNumber)){
            $iStatus = $iHasWnNumber ? self::ISSUE_CODE_STATUS_FINISHED : self::ISSUE_CODE_STATUS_WAIT_CODE;
            $aCondtions['status'] = ['=', $iStatus];
        }
        return self::doWhere($aCondtions)->orderBy('issue', 'desc')->skip($iSkipCount)->limit($iCount)->get($aColumns);

    }

    protected static function getFutureIssuesFromDb($iLotteryId, $sIssue, $iCount = 6){
        $aColumns = ['issue', 'wn_number', 'offical_time'];
        return self::where('lottery_id', '=', $iLotteryId)->where('issue', '>=', $sIssue)->orderBy('issue', 'asc')->limit($iCount)->get($aColumns);
    }

    protected static function compileRecentWnNumbersCacheKey($iLotteryId) {
        return self::getCachePrefix(true) . 'Recent-wnnumbers-' . $iLotteryId;
    }

    protected static function compileRecentIssuesCacheKey($iLotteryId, $iCount) {
        return self::getCachePrefix(true) . 'Recent-issues-' . $iLotteryId . '-'. $iCount;
    }

    protected static function compileLastWnNumberCacheKey($iLotteryId, $iCount=3) {
        return Config::get('cache.prefix') . 'Last-wnnumber-' . $iLotteryId . '-' . $iCount;
    }

    public static function getLastWnNumber($iLotteryId, $iCount = 1){
        Cache::setDefaultDriver(static::$cacheDrivers[static::$cacheLevel]);
        $key = self::compileLastWnNumberCacheKey($iLotteryId, $iCount);
        if (!$aInfo = Cache::get($key)){
//            $aIssues = self::getLatestWnNumbers($iLotteryId,1);
            $aIssues = self::getRecentIssuesFromDb($iLotteryId, 1,0, true)->toArray();
            if ($aIssues){
                $aInfo = [
                    'issue' => $aIssues[0]['issue'],
                    'wn_number' => $aIssues[0]['wn_number'],
                    'offical_time' => $aIssues[0]['offical_time'],
                ];
                Cache::put($key, $aInfo, 1);
            };
        }
        return $aInfo;
    }

    /**
     * 返回最近没有开奖号码的奖期
     * @param int $iLotteryId
     * @return array
     */
    public static function getLatestIssueOfNoWnNumber($iLotteryId) {
        $aCondtions = [
            'lottery_id' => [ '=', $iLotteryId],
            'end_time' => [ '<', time()],
            'status' => ['in', [self::ISSUE_CODE_STATUS_WAIT_CODE, self::ISSUE_CODE_STATUS_WAIT_VERIFY]],
        ];
        $aOrderBy = ['end_time' => 'desc'];
        $oIssue = self::doWhere($aCondtions)->orderBy('end_time', 'asc')->limit(1)->get(['*'])->first();
        return $oIssue;
    }

    public static function deleteOnSaleIssueCache($iLotteryId){
        $redis = Redis::connection();
        $sCacheKey = self::compileOnSaleIssueCacheKey($iLotteryId);
        $redis->del($sCacheKey);
    }

    public static function getOnSaleIssue($iLotteryId) {
        $sIssueInfo = self::getOnSaleIssueInfo($iLotteryId);
        list($sIssue, $iEndTime) = explode(',', $sIssueInfo);
        return $sIssue;
    }

    public static function getOnSaleIssueEndTime($iLotteryId) {
        $sIssueInfo = self::getOnSaleIssueInfo($iLotteryId);
        list($sIssue, $iEndTime) = explode(',', $sIssueInfo);
        return $iEndTime;
    }

    public static function getOnSaleIssueInfo($iLotteryId) {
        $redis = Redis::connection();
        $sCacheKey = self::compileOnSaleIssueCacheKey($iLotteryId);
        if (!$sIssueInfo = $redis->get($sCacheKey)) {
            $oIssue = self::where('lottery_id', '=', $iLotteryId)->where('end_time', '>', time())->orderBy('issue', 'asc')->limit(1)->get(['issue','end_time','end_time2'])->first();
            $sIssueInfo = $oIssue->issue . ',' . $oIssue->end_time;
            $redis->set($sCacheKey, $sIssueInfo, 'EX', $oIssue->end_time - time());
        }
//        list($sIssue, $iEndTime) = explode(',', $sIssueInfo);
        return $sIssueInfo;
    }

    public static function getIssuesByLotteryId($iLotteryId) {
        $i = 0;
        $aData = [];
        $sStartTime = date('Y-m-d', (time() - 3600 * 24));
        $aColumns = ['id', 'issue'];
        $aLotteryWays = $oQuery = self::where('lottery_id', '=', $iLotteryId)->where('end_time', '<', time())->where('end_time2', '>', $sStartTime)->orderBy('issue', 'desc')->get($aColumns);
        foreach ($aLotteryWays as $id => $value) {
            $aData[$i]['id'] = $value->id;
            $aData[$i]['name'] = $value->issue;
            $i++;
        }
        return $aData;
    }

    /**
     * 根据彩种id和时间获取奖期信息
     * @param int $iLotteryId          彩种id
     * @param int $sLotteryName          彩种名称
     * @param int $iStartTime        开始时间
     * @param int $iEndTime         结束时间
     * @return array
     */
    public static function getIssuesByLotteryIdAndTime($iLotteryId, $iStartTime, $iEndTime, $sLotteryName) {
        $i = 0;
        $aData = [];
        $aColumns = ['issue', 'end_time', 'offical_time'];
        $aIssues = $oQuery = self::where('lottery_id', '=', $iLotteryId)->where('end_time', '<=', $iEndTime)->where('end_time', '>=', $iStartTime)->get($aColumns);
        foreach ($aIssues as $id => $value) {
            $aData[$i]['lottery'] = $sLotteryName;
            $aData[$i]['issue'] = $value->issue;
            $aData[$i]['drawTime'] = date('YmdHis', $value->offical_time);
            $aData[$i]['saleCloseTime'] = date('YmdHis', $value->end_time);
            $i++;
        }
        return $aData;
    }

    protected static function & getDataFromRedis($redis, $sCacheKey, $iCount, & $iNeedCount){
        $aFutureIssues = $redis->lrange($sCacheKey,0,$redis->llen($sCacheKey) - 1);
//            pr($aProjectsFromRedis);
        $iNeedCount = $iCount - count($aFutureIssues);
        $iNeedCount >= 0 or $iNeedCount = 0;
        $i = 0;
        foreach($aFutureIssues as $sIssueInfo){
//                $obj = new static;
//                $obj = $obj->newFromBuilder(json_decode($sIssueInfo, true));
            $aIssues[] = json_decode($sIssueInfo, true);
            if ($i++ == $iCount - 1){
                break;
            }
        }
        return $aIssues;
    }

    protected static function & pushToList($redis, $sCacheKey, $mMoreIssues, $bReverse = false){
        $sFunction = $bReverse ? 'lpush' : 'rpush';
        $data = is_object($mMoreIssues) ? $mMoreIssues->toArray() : $mMoreIssues;
//        if ($bReverse){
//            $aMoreIssues = array_reverse($aMoreIssues);
//        }
        $redis->multi();
        foreach($data as $aMoreIssue){
            $aIssues[] = $aMoreIssue;
            $redis->$sFunction($sCacheKey, json_encode($aMoreIssue));
        }
        $redis->exec();
        return $data;
    }
    
        /**
     * 获取指定彩种已经开奖的奖期数据
     * @param int $iLotteryId      彩种id
     * @param int $iCount           记录数量
     * @param type $bOrderDesc
     * @return array
     */
    public function & getIssueArrayForWinNum($iLotteryId, $iCount = 3) {
        Cache::setDefaultDriver(static::$cacheDrivers[static::$cacheLevel]);
        $key = self::compileLastWnNumberCacheKey($iLotteryId, $iCount);
        if (!$aInfo = Cache::get($key)) {
//            $aIssues = self::getLatestWnNumbers($iLotteryId,1);
            $aIssues = self::getRecentIssuesFromDb($iLotteryId, $iCount, 0, true)->toArray();
            foreach ($aIssues as $aIssue) {
                $aInfo[] = [
                    'number' => $aIssue['issue'],
                    'code' => $aIssue['wn_number'],
                ];
                Cache::put($key, $aInfo, 1);
            };
        }
        return $aInfo;
    }
}
