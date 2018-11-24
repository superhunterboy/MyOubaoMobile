<?php
class UserTrendK3 extends BaseModel
{
    protected $table              = 'issues';
    protected $fillable           = [];
    protected static $iIssueLimit = 1000; // 最多取x条奖期数据供走势分析
    // 不同统计类型统计号码分布数据时, 在data数组中的起始下标
    protected static $aIndexs     = ['3' => 2];
    // 不同统计类型实际需要遍历的标准列数(球个数 + 分布 + [二星的跨度]) * 10 + [1 (二星的对子)]
    protected static $aCellNums   = ['3' => 34];
    // 不同统计类型号码截取的起始下标
    protected static $aPositions  = ['3' => 0];

    protected static $aClips = ['', ' '];


    protected $dataLen = 0;
    protected $index   = 0;
    protected $ballNum = 0;
    protected $colCount = 34; // 标准列数(球个数 + 分布 + [二星的跨度]) * 10 + [1 (二星的对子)]
    protected $seriesId    = 1; // 彩系, 1: SSC, 2: 11-5

    /**
     * [getIssuesByParams 根据查询参数获取奖期开奖号码]
     * @param  [integer] $iLotteryId [彩种id]
     * @param  [integer] $iNumType   [位数]
     * @param  [integer] $iBeginTime [起始时间秒数]
     * @param  [integer] $iEndTime   [结束时间秒数]
     * @param  [integer] $iCount     [记录条数]
     * @return [Array]               [返回分析数据]
     */
    public function getIssuesByParams($iLotteryId, $iNumType = 5, $iBeginTime = null, $iEndTime = null, $iCount = null)
    {
        if ( ! $iLotteryId || ! $iNumType || ( ! $iCount && ! $iBeginTime && ! $iEndTime ) ) return false;
        $aColumns = ['issue', 'wn_number'];
        $aCondtions = [
            'lottery_id' => ['=', $iLotteryId],
            'wn_number'  => ['<>', ''],
        ];
        $aParams = [$iLotteryId, ''];
        // TIP 如果起止时间和奖期数都有值，优先使用起止时间条件
        if ($iBeginTime || $iEndTime) {
            if ($iBeginTime && $iEndTime) {
                $aCondtions['end_time'] = ['between', [$iBeginTime, $iEndTime]];
                $aParams[] = $iBeginTime;
                $aParams[] = $iEndTime;
            } else {
                $sOperator = $iBeginTime ? '>=' : '<=';
                $iTime = $iBeginTime ? $iBeginTime : $iEndTime;
                $aCondtions['end_time'] = [ $sOperator, $iTime];
                $aParams[] = $iTime;
            }
//            $iCount = static::$iIssueLimit;
        }

        $oQuery = self::doWhere($aCondtions);

        $oQuery  = $oQuery->orderBy('issue', 'desc');
        $sSql = $oQuery->take($iCount)->toSql();
        $data = DB::select('select ' . implode(',', $aColumns) . ' from (' . $sSql . ') as b order by issue asc', $aParams);
        // $queries = DB::getQueryLog();
        // $last_query = end($queries);
        // pr($last_query);exit;
        $data = objectToArray($data);
        // $data = $oQuery->get($aColumns)->toArray();
        return $data;
    }

    /**
     * [getProbabilityOfOccurrenceByParams 根据查询参数获取奖期开奖号码, 并生成分析后的冷热数据]
     * @param  [integer] $iLotteryId [彩种id]
     * @param  [integer] $iNumType   [位数]
     * @param  [integer] $iBeginTime [起始时间秒数]
     * @param  [integer] $iEndTime   [结束时间秒数]
     * @param  [integer] $iCount     [记录条数]
     * @return [Array]               [返回分析数据]
     */
    public function getProbabilityOfOccurrenceByParams($iLotteryId, $iNumType = 5, $iBeginTime = null, $iEndTime = null, $iCount = null)
    {
        // pr(111);
        $data = $this->getIssuesByParams($iLotteryId, $iNumType, $iBeginTime, $iEndTime, $iCount);
        // pr($data);exit;
        if (! $data) {
            $result = [
                'isSuccess' => 0,
                'type'      => 'error',
                'msg'       => 'No Data',
                'errno'     => '',
            ];
            return $result;
        }
        $aLinkTo        = Series::getAllSeriesWithLinkTo();
        $iSeriesId      = Lottery::find($iLotteryId)->series_id;
        $this->seriesId    = $aLinkTo[$iSeriesId] ? $aLinkTo[$iSeriesId] : $iSeriesId;

        $aOccurrenceData = $this->generateOccurrenceData($data);
        $result = [
            'isSuccess' => 1,
            'data'      => $aOccurrenceData,
        ];
        return $result;
    }
    /**
     * [getTrendDataByParams 根据查询参数获取奖期开奖号码, 并生成分析后的走势数据]
     * @param  [integer] $iLotteryId [彩种id]
     * @param  [integer] $iNumType   [位数]
     * @param  [integer] $iBeginTime [起始时间秒数]
     * @param  [integer] $iEndTime   [结束时间秒数]
     * @param  [integer] $iCount     [记录条数]
     * @return [Array]               [返回分析数据]
     */
    public function & getTrendDataByParams($iLotteryId, $iNumType = 5, $iBeginTime = null, $iEndTime = null, $iCount = null)
    {
        $data = $this->getIssuesByParams($iLotteryId, $iNumType, $iBeginTime, $iEndTime, $iCount);
//        pr($data);
//        exit;
        if (! $data) {
            $result = [
                'isSuccess' => 0,
                'type'      => 'error',
                'msg'       => 'No Data',
                'errno'     => '',
            ];
            return $result;
        }
        // pr($data);exit;
        // $data       = [];
        $statistics = [];
        $hotAndCold = [];
        $aOmissionBarStatus = [];
        // foreach ($aIssues as $oIssue) {
        //     $data[] = array_values($oIssue->getAttributes());
        // }
        $this->dataLen = count($data);

        $aLinkTo        = Series::getAllSeriesWithLinkTo();
        $iSeriesId      = Lottery::find($iLotteryId)->series_id;
        $this->seriesId    = $aLinkTo[$iSeriesId] ? $aLinkTo[$iSeriesId] : $iSeriesId;
        $this->index   = static::$aIndexs[$iNumType];
//        $this->colCount = $this->seriesId == 1 ? static::$aCellNums[$iNumType] : 66;
        $this->ballNum = intval(substr($iNumType, 0, 1));
//         pr($this->seriesId);
//         pr($this->index);
//         pr($this->colCount);
//         pr($this->ballNum);
//         exit;

        $aData = $this->generateTrendData($data, $statistics, $hotAndCold, $aOmissionBarStatus, $iNumType);
        // TODO 目前的BaseController中的halt函数只能输出一个data属性，这里的statistics同级属性无法追加, 先不用halt来组织输出
        //统计数据
        $result = [
            'isSuccess'  => 1,
            'data'       => $aData,
//            'statistics' => $statistics,
//            // 'hotAndCold' => $hotAndCold,
//            'omissionBarStatus' => $aOmissionBarStatus,
        ];

        return $result;
//        $result = [
//            'isSuccess'  => 1,
//            'data'       => $aData,
////            'statistics' => $statistics,
//            // 'hotAndCold' => $hotAndCold,
////            'omissionBarStatus' => $aOmissionBarStatus,
//        ];
        // pr($data);exit;
//        pr($result);
//        return $result;
    }
    /**
     * [generateOccurrenceData 生成号码冷热统计的数据]
     * @param  &      $data [奖期数据的引用]
     * @return [type]       [description]
     */
    public function generateOccurrenceData( & $data)
    {
        $sClip = static::$aClips[$this->seriesId - 1];
        $iCount = $this->seriesId == 1 ? 10 : 11;
        $aOccurrenceData = [];
        foreach ($data as $key1 => $oIssue) {
            $sNumber = $oIssue['wn_number'];
            $aBalls = $sClip ? explode($sClip, $sNumber) : str_split($sNumber);
            $iBallsLen = count($aBalls);
            foreach ($aBalls as $key2 => $value) {
                for($i = 0; $i < $iCount; $i++){
                    $index = $key2 * 10 + $i;
                    $iNumber = $this->seriesId == 1 ? $i : $i + 1;
                    if (! isset($aOccurrenceData[$key2])) $aOccurrenceData[$key2] = [];
                    //当前号码为开奖号码数字
                    if($value == $iNumber){
                        isset($aOccurrenceData[$key2][$iNumber]) ? ++$aOccurrenceData[$key2][$iNumber] : $aOccurrenceData[$key2][$iNumber] = 0;
                    }
                }
            }
        }
        $result = [];
        // 降序排列
        foreach ($aOccurrenceData as $key => $value) {
            arsort($value);
            $iNumSum = array_sum($value);
            $value['sum'] = $iNumSum;
            $result[] = $value;
        }
        return $result;
    }

    /**
     * [generateTrendData 生成走势数据]
     * @param  &      $data               [奖期数据的引用]
     * @param  &      $statistics         [统计数据的引用]
     * @param  &      $hotAndCold         [号温数据的引用]
     * @param  &      $aOmissionBarStatus [遗漏条数据的引用]
     * @param  [Integer] $iNumType        [号码类型]
     * @return [type]                     [description]
     */
    public function generateTrendData(& $aWnNumbers, & $statistics, & $hotAndCold, & $aOmissionBarStatus, $iNumType)
    {
        // $aClips = ['', ' '];
        $aLostTimes = [];
        $iCount = 6;
        // $aAllNumbers = [];
        // 根据中奖号码个数初始化待填充的数组
        $tempOmissionForNumberStyle = array_fill(0, $iCount, 0);
        $tempOmissionForDistribution = array_fill(0, $iCount, 0);
        // -------------------start 统计数据--------------------

        $iColumnNum      = $this->colCount;
//        pr($colCount);
        $iAdditional   = $this->ballNum == 3 ? 3 : 0; // 3星额外有豹子 组三 组六的统计列
//        $iColumnNum    = $colCount + $iAdditional;
//        pr($iColumnNum);
//        exit;
        $aTimes        = array_fill(0, $iColumnNum, 0);
        $aAvgOmission  = array_fill(0, $iColumnNum, 0);
        $aMaxOmission  = array_fill(0, $iColumnNum, 0);
        $aMaxContinous = $aMaxContinousCache = array_fill(0, $iColumnNum, 0);
        $aData = [];
        $aTotalYiLou = array_fill(0,34,0);
        $aTotalSumYiLou = array_fill(3,16,0);
        foreach ($aWnNumbers as $key1 => $aIssue) {
//            $aIssue['wn_number'] = K3Number::compileNumber();
            $data = array_fill(0,34,'');
            $aYiLou = array_fill(0,34,3);
            $aSumYiLou = array_fill(3,16,0);
            $data[0] = $sIssue = $aIssue['issue'];
            $data[1] = $sNumber = $aIssue['wn_number'];
            unset($data['issue']);
            unset($data['wn_number']);

            // 如果是时时彩, 则按号码位数分割, 11选5则按空格分割
            $oK3Number = new K3Number($sNumber);
            $aBalls = array_unique($oK3Number->getDigitals());
            $aAttributes = $oK3Number->getAttributes();
            $iBallsLen = count($aBalls);
//            pr($data);
            // pr($aBalls);exit;

            $aYiLou[0] = $sIssue = $aIssue['issue'];
            $aYiLou[1] = $sNumber = $aIssue['wn_number'];
            // 遍历每一位号码，生成每一位号码在0-9数字上的分布数据
//            pr($aYiLou);
//            exit;
            $aDiff = array_diff([1,2,3,4,5,6], $aBalls);
            
//            pr($aDiff);
//            pr($aBalls);
            foreach ($aBalls as $i => $iNumber) {
//                $value = intval($value);
                $iIndexOfYilou = $iNumber + 1;
                $data[$iIndexOfYilou] = $iNumber;
                $aYiLou[$iIndexOfYilou] = $aTotalYiLou[$iIndexOfYilou] = 0;
//                $arr = $this->makeRowData($key2, $key1, $value, $aOmissionBarStatus, $aLostTimes, $aTimes, $aAvgOmission, $aMaxOmission, $aMaxContinous, $aMaxContinousCache);
//                $data[$key1][$key2 + 2] = $arr;
                // $aAllNumbers[$key2 + 2] = $value;
            }
//            pr($aYiLou);
//            exit;
            foreach($aDiff as $iNumber){
                $iIndexOfYilou = $iNumber + 1;
//                pr($iIndexOfYilou);
                $aTotalYiLou[$iIndexOfYilou]++;
                $aYiLou[$iIndexOfYilou] = $aTotalYiLou[$iIndexOfYilou];
            }
//            pr($aYiLou);
//            exit;
//            pr($iIndexOfYilou);
            $iBaseIndexYilou = 8;
//            exit;
            $iSum = $aAttributes['sum'];
            $aTotalSumYiLou[$iSum] = 0;
            for($i = 3; $i <= 18;$i++){
                $iIndexOfYilou = $iBaseIndexYilou + $i - 3;
                $i == $iSum or $aTotalYiLou[$iIndexOfYilou]++;
//                $aTotalYiLou[$iIndexOfYilou] = $aTotalSumYiLou[$i];
                $aYiLou[$iIndexOfYilou] = $aTotalYiLou[$iIndexOfYilou];
//                $data[$iIndexOfYilou] = '';
            }
            $aTotalYiLou[$iBaseIndexYilou + $iSum - 3] = 0;
//            $data[$iBaseIndexYilou + $iSum - 3] = $iSum;
            $aYiLou[$iBaseIndexYilou + $iSum - 3] = 0;
            
            $iBaseIndexYilou = $iIndexOfYilou + 1;

            $aColumns = ['smallOdd', 'smallEven', 'BigOdd', 'BigEven','3same', '3diff', 'ordered', '2same', '2same', '2diff'];
            foreach($aColumns as $i => $sColumn){
                $iIndexOfYilou = $iBaseIndexYilou + $i;
                if ($aAttributes[$sColumn]){
//                    $data[$iIndexOfYilou] = 1;
                    $aYiLou[$iIndexOfYilou] = $aTotalYiLou[$iIndexOfYilou] = 0;
                }
                else{
                    $aTotalYiLou[$iIndexOfYilou]++;
                    $aYiLou[$iIndexOfYilou] = $aTotalYiLou[$iIndexOfYilou];
                }
            }
//            pr($aYiLou);
//            pr($data);
            $aData[] = $aYiLou;
        }
//        pr($aData);
//        exit;
        return $aData;
//        pr($aData);
//                // pr(json_encode($data));exit;
//
//        exit;
        // pr($aOmissionBarStatus);exit;
        // pr($aTimes);exit;
        // 平均遗漏值
        // $aNumberTemp = array_slice($aTimes, $this->ballNum * 10 + intval($this->ballNum == 2), 10);
        // $hotAndCold = $aNumberTemp; // $this->generateHotAndColdNumber($aNumberTemp);
        // pr($aNumberTemp);
        // pr(json_encode($data));exit;
    }

    /**
     * [generateHotAndColdNumber 生成号温的判断规则, 热号, 冷号号码数组, 因为有可能几个号码值的出现次数是一样的, 如都是一次，那么就都是冷号]
     * @param  [Array] $aNumberTemp [所有开奖号码数组]
     * @return [Array]              [热号, 冷号]
     */
    private function generateHotAndColdNumber(& $aNumberTemp)
    {
        // $aNumberTemp = array_count_values($aAllNumbers);
        arsort($aNumberTemp);
        $aKeys = array_keys($aNumberTemp);
        $aValues = array_values($aNumberTemp);
        $iTop         = ($aValues[0]);
        $iBottom      = ($aValues[count($aValues) - 1]);
        $aHottestNums = [];
        $aColdestNums = [];
        $aWarmNums    = [];
        foreach ($aNumberTemp as $key => $value) {
            if ($value == $iTop) $aHottestNums[] = $key;
            else if ($value == $iBottom) $aColdestNums[] = $key;
            else $aWarmNums[] = $key;
        }
        return ['hot' => $aHottestNums, 'cold' => $aColdestNums];
    }

    /**
     * [makeRowData 生成一组号码以及号码属性, 通过遍历0-9数字的方式]
     * @param  [Int] $iNum          [万千百十个位]
     * @param  [String] $sBall      [某位上的开奖号码值]
     * @param  [Array] $aLostTimes  [号码遗漏次数缓存]
     * @return [Array]              [一条奖期的开奖号码分析属性数组，格式是：]
     *       [
     *         遗漏次数,
     *         当前开奖号数字 (当前位的号码数字),
     *         号温 (1:冷号, 2:温号, 3:热号),
     *         遗漏条 (开奖号码数字是否是最后一次出现该号码数字,是为1,否为0)
     *       ]
     */
    private function makeRowData($iNum, $key1, $sBall, & $aOmissionBarStatus, & $aLostTimes, & $aTimes, & $aAvgOmission, & $aMaxOmission, & $aMaxContinous, & $aMaxContinousCache){
        
        $result = [];
        $iCount = 6;
        // 11选5的遗漏次数数组排序是万千百十个位[0-10][11-21][22-32][33-43][44-54]
        $iAdditional = $iNum;
        for($i = 0; $i < $iCount; $i++){
            $iNumber = $i + 1;
            $index = $iNum + $iAdditional + $i;
            //当前号码为开奖号码数字
            if($sBall == $iNumber){
                $aLostTimes[$index] = 0;
                $iOmission = 0;
                ++$aTimes[$index];
                ++$aMaxContinousCache[$index];
                $aOmissionBarStatus[$index] = $key1;
            }else{
                isset($aLostTimes[$index]) ? ++$aLostTimes[$index] : $aLostTimes[$index] = 1;
                $iOmission = 1;
                $aMaxOmission[$index]       = max($aLostTimes[$index], $aMaxOmission[$index]);
                $aMaxContinousCache[$index] = 0;

                // $aOmissionBarStatus[$index] = -1;
            }
            // $aAvgOmission[$index]  += $aLostTimes[$index];
            if ($aLostTimes[$index] == 0) $aAvgOmission[$index]++;
            $aMaxContinous[$index] = max($aMaxContinousCache[$index], $aMaxContinous[$index]);

            $result[] = [$aLostTimes[$index], $sBall, 1, $iOmission];
        }
        return $result;
    }

    /**
     * [countNumberDistribution 号码分布 格式: [遗漏次数, 当前数字, 重复次数]]
     * @param  [Array] $aBalls          [开奖号码]
     * @param  [Int]   $iBallsLen       [开奖号码位数]
     * @return [Array]                  [号码分布统计数据数组]
     */
    private function countNumberDistribution($aBalls, $iBallsLen)
    {
        $times = [];
        $iCount = $this->seriesId == 1 ? 10 : 12;
        $iStart = $this->seriesId == 1 ? 0 : 1;
        for($iStart = 0; $iStart < $iCount; $iStart++){
            $num = 0;
            for($j = 0; $j < $iBallsLen; $j++){
                if($aBalls[$j] == $iStart){
                    ++$num;
                }
            }
            $times[] = [in_array($iStart, $aBalls) ? 0 : 1, $iStart, $num];
        }
        return $times;
    }
    /**
     * [countNumberSizePattern 大小形态 [1,0,1]; 1代表大 0代表小]
     * @param  [Array] $aBalls [开奖号码分解数组]
     * @return [Array]         [大小形态数组]
     */
    private function countNumberSizePattern($aBalls)
    {
        return  array_map(function ($item) {
                    return (int)($item > 4);
                }, $aBalls);
    }
    /**
     * [countNumberOddEvenPattern 单双形态 [1,0,1]; 1单 0双]
     * @param  [Array] $aBalls [开奖号码分解数组]
     * @return [Array]         [单双形态数组]
     */
    private function countNumberOddEvenPattern($aBalls)
    {
        return  array_map(function ($item) {
                    return (int)($item % 2 != 0);
                }, $aBalls);
    }

    /**
     * [countNumberOddEvenPattern 质合形态 [1,0,1]; 1质数 0 合数]
     * @param  [Array] $aBalls [开奖号码分解数组]
     * @return [Array]         [质合形态数组]
     */
    private function countNumberPrimeCompositePattern($aBalls)
    {
        $pArray = [1, 2, 3, 5, 7];
        $result = [];
        foreach ($aBalls as $key => $value) {
            $result[] = (int)(in_array($value, $pArray));
        }
        return $result;
    }
    /**
     * [countNumber012Pattern 012形态 [1,0,1]; 模3余数]
     * @param  [Array] $aBalls [开奖号码分解数组]
     * @return [Array]         [质合形态数组]
     */
    private function countNumber012Pattern($aBalls)
    {
        return  array_map(function ($item) {
                    return (int)($item % 3);
                }, $aBalls);
    }
    /**
     * [countNumberSamePattern 判断号码是否豹子, 组三, 组六]
     * @param  [Array] $aBalls [开奖号码分解数组]
     * @return [Array]         [遗漏值]
     */
    private function countNumberSamePattern($aBalls)
    {
        switch (count(array_count_values($aBalls))) {
            case 1: // 是否豹子
                $aNumberStyle = [[0], [1], [1]];
                break;
            case 2: // 是否组三
                $aNumberStyle = [[1], [0], [1]];
                break;
            case 3: // 是否组六
            default:
                $aNumberStyle = [[1], [1], [0]];
                break;
        }
        return $aNumberStyle;
    }
    /**
     * [countNumberRangePattern 跨度]
     * @param  [Array] $aBalls [开奖号码分解数组]
     * @return [Array]         [遗漏值]
     */
    private function countNumberRangePattern($aBalls, $iBallsLen)
    {
        return  max($aBalls) - min($aBalls);
    }

    /**
     * [countNumberSumPattern 和值]
     * @param  [Array] $aBalls [开奖号码分解数组]
     * @return [Array]         [遗漏值]
     */
    private function countNumberSumPattern($aBalls)
    {
        return  array_sum($aBalls);
    }
    /**
     * [countNumberSumMantissaPattern 和值尾数]
     * @param  [Int] $iSum [开奖号码和值]
     * @return [Array]         [遗漏值]
     */
    private function countNumberSumMantissaPattern($iSum)
    {
        return  substr(strval($iSum), -1);
    }

    /**
     * [countPairPattern 对子]
     * @param  [Array] $aBalls [开奖号码分解数组]
     * @return [Array]         [遗漏值]
     */
    private function countPairPattern($aBalls)
    {
        return intval($aBalls[0] != $aBalls[1]);
    }
    /**
     * [countNumberRangeTrendPattern 跨度走势]
     * @param  [Array] $aBalls [开奖号码分解数组]
     * @return [Array]         [遗漏值, 当前球内容, 重复次数]
     */
    private function countNumberRangeTrendPattern($aBalls)
    {
        $times = [];
        $kd = abs($aBalls[1] - $aBalls[0]);
        for($i = 0; $i < 10; $i++){
            $times[] = [($i == $kd) ? 0 : 1, $i];
        }
        return $times;
    }


    /**
     * [countPairAndRangeOmission 对子, 跨度走势遗漏]
     * @param  [Array]   $data       [待分析的数据]
     * @param  [Integer] $i          [数据数组索引值]
     * @param  [Array]   $tempOmissionForPair  [对子走势遗漏值]
     * @param  [Array]   $tempOmissionForRange [跨度走势遗漏值]
     * @return [Array]               [分析后的数据]
     */
    private function countPairAndRangeOmission(& $data, $i, & $tempOmissionForPair, & $tempOmissionForRange, & $aTimes, & $aAvgOmission, & $aMaxOmission, & $aMaxContinous, & $aMaxContinousCache )
    {
        $iPairColumnIndex = 20;
        $iRangeColumnIndex = 31;
        // 对子走势遗漏
        $data[$i][4] ? ++$tempOmissionForPair : $tempOmissionForPair = 0;
        $data[$i][4] = $tempOmissionForPair;
        // ---------对子的4项统计
        if (! $data[$i][4]) {
            ++$aTimes[$iPairColumnIndex];
            ++$aMaxContinousCache[$iPairColumnIndex];
            $aMaxContinous[$iPairColumnIndex] = max($aMaxContinous[$iPairColumnIndex], $aMaxContinousCache[$iPairColumnIndex]);
        } else {
            $aMaxContinousCache[$iPairColumnIndex] = 0;
        }
        // $aAvgOmission[$iPairColumnIndex] += $tempOmissionForPair;
        if ($tempOmissionForPair == 0) $aAvgOmission[$iPairColumnIndex]++;
        $aMaxOmission[$iPairColumnIndex] = max($aMaxOmission[$iPairColumnIndex], $tempOmissionForPair);
        // 跨度走势遗漏
        for($n = 0; $n < 10; $n++) {
            $m = $iRangeColumnIndex + $n;
            $data[$i][6][$n][0] ? ++$tempOmissionForRange[$n] : $tempOmissionForRange[$n] = 0;
            $data[$i][6][$n][0] = $tempOmissionForRange[$n];
            // 跨度的4项统计
            if (! $data[$i][6][$n][0]) {
                ++$aTimes[$m];
                ++$aMaxContinousCache[$m];
                $aMaxContinous[$m] = max($aMaxContinous[$m], $aMaxContinousCache[$m]);
            } else {
                $aMaxContinousCache[$m] = 0;
            }
            // $aAvgOmission[$m] += $tempOmissionForRange[$n];
            if ($tempOmissionForRange[$n] == 0) $aAvgOmission[$m]++;
            $aMaxOmission[$m] = max($aMaxOmission[$m], $tempOmissionForRange[$n]);
        }
    }
    /**
     * [countNumberStyleOmission 计算 豹子 组三 组六 的遗漏值]
     * @param  [Array]   $data     [统计数据]
     * @param  [Integer] $i        [数据记录的循环索引]
     * @param  [Int]     $tempOmissionForNumberStyle     [豹子 组三 组六的遗漏次数统计缓存]
     * @return [Array]   $data     [分析后的统计数据]
     */
    private function countNumberStyleOmission(& $data, $i, & $tempOmissionForNumberStyle, & $aTimes, & $aAvgOmission, & $aMaxOmission, & $aMaxContinous, & $aMaxContinousCache)
    {
        $colCount = $this->colCount;
        for($j = 10; $j < 13; $j++){
            $n = $j - 10;
            $data[$i][$j][0] ? ++$tempOmissionForNumberStyle[$n] : $tempOmissionForNumberStyle[$n] = 0;
            $data[$i][$j][0] = $tempOmissionForNumberStyle[$n];

            // 豹子 组三 组六的4项统计
            $m = $colCount + $n;
            if (! $data[$i][$j][0]) {
                ++$aTimes[$m];
                ++$aMaxContinousCache[$m];
                $aMaxContinous[$m] = max($aMaxContinous[$m], $aMaxContinousCache[$m]);
            } else {
                $aMaxContinousCache[$m] = 0;
            }
            // $aAvgOmission[$m] += $tempOmissionForNumberStyle[$n];
            if($tempOmissionForNumberStyle[$n] == 0) $aAvgOmission[$m]++;
            $aMaxOmission[$m] = max($aMaxOmission[$m], $tempOmissionForNumberStyle[$n]);
        }
    }

    /**
     * [countDistributionOmission 号码分布的遗漏次数]
     * @param  [Array]   $data     [统计数据]
     * @param  [Integer] $i        [数据记录的循环索引]
     * @param  [Int]     $tempOmissionForDistribution     [号码分布的遗漏次数统计缓存]
     * @return [Array]   $data     [分析后的统计数据]
     */
    private function countDistributionOmission( & $data, $i, & $tempOmissionForDistribution, & $aTimes, & $aAvgOmission, & $aMaxOmission, & $aMaxContinous, & $aMaxContinousCache )
    {
        $index = $this->index;
        $iCount = $this->seriesId == 1 ? 10 : 11;
        $iDistributionStart = $this->ballNum * 10 + intval($this->ballNum == 2);
        for($n = 0; $n < $iCount; $n++){
            !$data[$i][$index][$n][2] ? ++$tempOmissionForDistribution[$n] : $tempOmissionForDistribution[$n] = 0;
            $data[$i][$index][$n][0] = $tempOmissionForDistribution[$n];

            // 号码分布的4项统计
            $m = $iDistributionStart + $n;
            if (! $data[$i][$index][$n][0]) {
                $aTimes[$m] += $data[$i][$index][$n][2];
                ++$aMaxContinousCache[$m];
                $aMaxContinous[$m] = max($aMaxContinous[$m], $aMaxContinousCache[$m]);
            } else {
                $aMaxContinousCache[$m] = 0;
            }
            // $aAvgOmission[$m] += $tempOmissionForDistribution[$n];
            if ($tempOmissionForDistribution[$n] == 0) $aAvgOmission[$m]++;
            $aMaxOmission[$m] = max($aMaxOmission[$m], $tempOmissionForDistribution[$n]);
        }
    }

}