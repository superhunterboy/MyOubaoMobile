<?php

class UserTrendController extends UserBaseController {

    // protected $resourceView = 'centerTrend.ssc';
    protected $customViewPath = 'centerTrend';
    protected $modelName = 'UserTrend';
    // protected static $aSeriesViews = [
    //     '1' => 'ssc', '2' => '11-5', '3' => '3d'
    // ];
    protected static $aViewTypes = [
        '5' => 'wu-xing', // ['wu-xing', '五星'],
        '4' => 'si-xing', // ['si-xing', '四星'],
        '3' => 'san-xing', // ['san-xing', '三星'],
        '3f' => 'qian-san', // ['qian-san', '前三'],
        '3e' => 'hou-san', // ['hou-san', '后三'],
        '2f' => 'qian-er', // ['qian-er', '前二'],
        '2e' => 'hou-er', // ['hou-er', '后二'],
    ];

    protected function beforeRender() {
        parent::beforeRender();
        $iOpen = Session::get('is_tester') ? null : 1;
        // pr($bIsOpen);exit;
        $aLotteries = Lottery::getAllLotteries($iOpen);
        // $aLotteries = & Lottery::getTitleList();
        $this->setVars(compact('aLotteries'));
    }

    /**
     * [trendView 开奖走势]b
     * @param  [Integer] $iLotteryId [彩种id]
     * @param  [String] $sTrendType     [玩法类型, 五星, 四星, 前三, 后三, 前二, 后二]
     * @return [Response]            [description]
     */
    public function trendView($iLotteryId = null, $sTrendType = null) {
        // 没有彩种参数, 则取彩种表的第一个彩种
        if ($iLotteryId) {
            $oLottery = Lottery::find($iLotteryId);
        } else {
            $oLottery = Lottery::first();
            $iLotteryId = $oLottery->id;
        }
        if (empty($oLottery)) {
            $this->halt(false, 'lottery-missing', Lottery::ERRNO_LOTTERY_MISSING);
        }

        $oSeries = Series::find($oLottery->series_id);
        $sSeriesName = strtolower($oSeries->identifier);
        $sLotteryName = $oLottery->friendly_name;
        $aViewTypes = [];
        $sTrendTypeEnName = null;
        if ($aEnabledViewTypes = Config::get('trend.' . $oLottery->series_id)) {
            foreach ($aEnabledViewTypes as $sViewType) {
                $aViewTypes[$sViewType] = static::$aViewTypes[$sViewType];
            }
            // 没有走势图类型, 则取配置数组的第一个
            $sTrendType or $sTrendType = $aEnabledViewTypes[0];
            $sTrendTypeEnName = $aViewTypes[$sTrendType];
        }
        $this->view = $this->customViewPath . '.' . $sSeriesName;
        if ($sTrendTypeEnName) {
            $this->view .= '.' . $sTrendTypeEnName;
            $sTrendTypeName = __('_trend.' . ($sTrendTypeEnName));
        }
        $aConfigs = & $this->_getTrendConfig($iLotteryId, $sTrendType);
        $sConfigs = json_encode($aConfigs);
        // TODO 测试用url
        // $url = route('user-trends.trend-data')
        //      . '?lottery_id='
        //      . $iLotteryId
        //      . '&num_type=' . $sTrendType
        //      // . '&count=100';
        //      . '&begin_time=1410109500&end_time=1410112500';
        $this->setVars(compact('sConfigs', 'oSeries', 'iLotteryId', 'sTrendType', 'sLotteryName', 'aViewTypes', 'sTrendTypeName'));
        return $this->render();
    }

    /**
     * [_getTrendConfig 返回ajax请求需要用到的请求参数]
     * @param  [Integer] $iLotteryId [彩种id]
     * @param  [String] $sTrendType     [玩法类型, 五星, 四星, 前三, 后三, 前二, 后二]
     * @return [Array]               [请求参数]
     */
    private function & _getTrendConfig($iLotteryId, $sTrendType) {
        $sBaseUrl = route('user-trends.trend-data');
        $aConfigs = [
            'lotteryId' => $iLotteryId,
            'wayId' => $sTrendType,
            'nowTime' => Carbon::now()->toDateTimeString(),
            'queryBaseUrl' => $sBaseUrl
        ];
        return $aConfigs;
    }

    /**
     * [getDataByParams 根据查询参数获取走势或冷热数据]
     * @param  [integer] $iType [类型]
     * @return [Response]       [JSON数据]
     */
    protected function getDataByParams($iType = 1) {
        $iLotteryId = trim(Input::get('lottery_id'));
        $iNumType = trim(Input::get('num_type'));
        $iCount = trim(Input::get('count'));
        $iBeginTime = trim(Input::get('begin_time'));
        $iEndTime = trim(Input::get('end_time'));
        // TODO 没有添加字典
        if (!$iLotteryId || !$iNumType || !(($iBeginTime && $iEndTime) || $iCount)) {
            $sErrorMsg = '缺少必要的查询参数';
            return Redirect::route('home')->with('error', $sErrorMsg);
        }


        if (in_array($iLotteryId, [15, 16, 19, 24, 25, 26])) {
            $oTrend = new UserTrendK3;
        } else if ($iLotteryId == 17) {
            $oTrend = new UserTrendXSSC;
        } else if ($iLotteryId == 22) {
            $oTrend = new UserTrendPK10;
        } else {
            $oTrend = new UserTrend;
        }
        switch ($iType) {
            case 2:
                $data = $oTrend->getProbabilityOfOccurrenceByParams($iLotteryId, $iNumType, $iBeginTime, $iEndTime, $iCount);
                break;
            case 1:
            default:
                $data = $oTrend->getTrendDataByParams($iLotteryId, $iNumType, $iBeginTime, $iEndTime, $iCount);
//                pr($data);
//                exit;
                break;
        }


        // pr(json_encode($data));exit;
        // -------------------------------------------test data----------------------------------
        // $data = [
        //     [
        //         "20130603-045",
        //         "12345",
        //         [[0, 1, 2, 3],[0, 1, 2, 3],[0, 1, 2, 3],[0, 1, 2, 3],[0, 1, 2, 3],[0, 1, 2, 3],[0, 1, 2, 3],[0, 1, 2, 3],[0, 1, 2, 3],[0, 1, 2, 3]],
        //         [[0, 1, 2, 3],[0, 1, 2, 3],[0, 1, 2, 3],[0, 1, 2, 3],[0, 1, 2, 3],[0, 1, 2, 3],[0, 1, 2, 3],[0, 1, 2, 3],[0, 1, 2, 3],[0, 1, 2, 3]],
        //         [[0, 1, 2, 3],[0, 1, 2, 3],[0, 1, 2, 3],[0, 1, 2, 3],[0, 1, 2, 3],[0, 1, 2, 3],[0, 1, 2, 3],[0, 1, 2, 3],[0, 1, 2, 3],[0, 1, 2, 3]],
        //         [[0, 1, 2, 3],[0, 1, 2, 3],[0, 1, 2, 3],[0, 1, 2, 3],[0, 1, 2, 3],[0, 1, 2, 3],[0, 1, 2, 3],[0, 1, 2, 3],[0, 1, 2, 3],[0, 1, 2, 3]],
        //         [[0, 1, 2, 3],[0, 1, 2, 3],[0, 1, 2, 3],[0, 1, 2, 3],[0, 1, 2, 3],[0, 1, 2, 3],[0, 1, 2, 3],[0, 1, 2, 3],[0, 1, 2, 3],[0, 1, 2, 3]],
        //         [[0, 2],[2, 2],[5, 1],[6, 2],[3, 1],[6, 2],[4, 2],[1, 1],[3, 1],[7, 1]]
        //     ],
        //     [
        //         "20130603-046",
        //         "12345",
        //         [[0, 1, 2, 3],[0, 1, 2, 3],[0, 1, 2, 3],[0, 1, 2, 3],[0, 1, 2, 3],[0, 1, 2, 3],[0, 1, 2, 3],[0, 1, 2, 3],[0, 1, 2, 3],[0, 1, 2, 3]],
        //         [[0, 1, 2, 3],[0, 1, 2, 3],[0, 1, 2, 3],[0, 1, 2, 3],[0, 1, 2, 3],[0, 1, 2, 3],[0, 1, 2, 3],[0, 1, 2, 3],[0, 1, 2, 3],[0, 1, 2, 3]],
        //         [[0, 1, 2, 3],[0, 1, 2, 3],[0, 1, 2, 3],[0, 1, 2, 3],[0, 1, 2, 3],[0, 1, 2, 3],[0, 1, 2, 3],[0, 1, 2, 3],[0, 1, 2, 3],[0, 1, 2, 3]],
        //         [[0, 1, 2, 3],[0, 1, 2, 3],[0, 1, 2, 3],[0, 1, 2, 3],[0, 1, 2, 3],[0, 1, 2, 3],[0, 1, 2, 3],[0, 1, 2, 3],[0, 1, 2, 3],[0, 1, 2, 3]],
        //         [[0, 1, 2, 3],[0, 1, 2, 3],[0, 1, 2, 3],[0, 1, 2, 3],[0, 1, 2, 3],[0, 1, 2, 3],[0, 1, 2, 3],[0, 1, 2, 3],[0, 1, 2, 3],[0, 1, 2, 3]],
        //         [[0, 2],[2, 2],[5, 1],[6, 2],[3, 1],[6, 2],[4, 2],[1, 1],[3, 1],[7, 1]]
        //     ]
        // ];
        // 号温
        // Array
        // (
        //     [0] => 1
        // )
        // Array
        // (
        //     [0] => 3
        //     [1] => 0
        //     [2] => 4
        //     [3] => 7
        // )
        // -------------------------------------------test data----------------------------------
        $this->halt(true, 'info', null, $a, $a, $data);
        exit;
        // if ($this->isAjax) {
        //     return Response::json($data);
        // }
    }

    /**
     * [getOccurrenceData 冷热数据]
     * @return [type] [description]
     */
    public function getOccurrenceData() {
        $this->getDataByParams(2);
    }

    /**
     * [getTrendData 走势数据]
     * @return [type] [description]
     */
    public function getTrendData() {
        $this->getDataByParams(1);
    }

}
