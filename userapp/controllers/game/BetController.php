<?php

/**
 * 投注
 */
class BetController extends UserBaseController {

    protected $errorFiles = ['system', 'bet', 'fund', 'account', 'lottery', 'issue', 'seriesway'];
    protected $resourceView = 'centerUser.bet';
    protected $customViewPath = 'centerGame';
    protected $modelName = 'UserProject';
    protected $customViews = [
        'bet',
        'uploadBetNumber',
    ];
    protected $accountLocker = null;
    protected $dbThreadId = null;
    protected $betTime = null;
    protected $lotteryId;
    protected $issue;

    /**
     * 投注方法
     * @param int $iLotteryId
     * @return mixed
     */
    public function bet($iLotteryId) {
        //后台是否禁止投注
        $iUserId = Session::get('user_id');
        $oUser = UserUser::find($iUserId);
        if (!is_object($oUser)) {
            return $this->goBack('error', __('_user.missing-user'));
        }
        if ($oUser->blocked == UserUser::BLOCK_BUY || $oUser->blocked == UserUser::BLOCK_FUND_OPERATE) {
            return $this->goBack('error', __('_user.bet-now-allowed'));
        }

        // $last_query = end($queries);
        // pr($last_query);exit;
        $oLottery = Lottery::find($iLotteryId);
        if (empty($oLottery)) {
            $this->halt(false, 'lottery-missing', Lottery::ERRNO_LOTTERY_MISSING);
        }
        $bPost = Request::method() == 'POST';
//        $bPost = true;
        if ($oLottery->status == Lottery::STATUS_NOT_AVAILABLE) {
            return $this->goBack('error', __('_lottery.not-available', ['lottery' => $oLottery->friendly_name]));
        }
        $iNeedStatus = Session::get('is_tester') ? Lottery::STATUS_AVAILABLE_FOR_TESTER : Lottery::STATUS_AVAILABLE;
        if ($oLottery->status & $iNeedStatus != $iNeedStatus) {
            return $this->goBack('error', __('_lottery.not-available', ['lottery' => $oLottery->friendly_name]));
        }
//            $this->halt(false,'lottery-closed',Lottery::ERRNO_LOTTERY_CLOSED);
//        }

        if ($bPost) {
            $this->doBet($oLottery);
            exit;
        } else {
            return $this->betForm($oLottery);
        }
    }

    private function countBetNumber($iSeriesId, $oSeriesWay, & $aBetInfo) {
        $sFunction = $iSeriesId == 15 ? 'countK3' : 'count';
        if ($iSeriesId != 15) {
            $aBetInfo['bet_number'] = $this->compileBetNumber($iSeriesId, $oSeriesWay, $aBetInfo['bet_number']);
        }
        return $oSeriesWay->$sFunction($aBetInfo);
    }

    private function compileBetNumber($iSeriesId, $oSeriesWay, $sBetNumber) {
        $sFunction = $iSeriesId == 4 ? 'compileBetNumberK3' : 'compileBetNumber';
        return $oSeriesWay->$sFunction($sBetNumber);
    }

    /**
     * 格式化投注数据
     * @param Lottery $oLottery
     * @param array $aBetData
     * @param array $aBetNumbers &
     * @param array $aSeriesWays &
     */
    protected function compileBetData($oLottery, $aBetData, & $aBetNumbers, & $aSeriesWays, $sMinGroupName, $sMaxGroupName, $sWnNumber = null) {
        $aBetNumbers = $aBetIssues = [];
//        $sSplitChar = Config::get('bet.split_char') or $sSplitChar = '|';
//        $aBetData['balls'][0]['ball'] = '07';
        $aPrizeGroups = [];
        $oSeries = Series::find($oLottery->series_id);
        $iSeriesId = $oSeries->link_to or $iSeriesId = $oLottery->series_id;
        foreach ($aBetData['balls'] as $aBetNumber) {
            if (($sPrizeGroup = $aBetNumber['prizeGroup']) < $sMinGroupName || $sPrizeGroup > $sMaxGroupName) {
                return -1;
            }
            if (array_key_exists($sPrizeGroup, $aPrizeGroups)) {
                $oPrizeGroup = $aPrizeGroups[$sPrizeGroup];
            } else {
                $oPrizeGroup = PrizeGroup::getPrizeGroupByClassicPrize($sPrizeGroup, $iSeriesId);
                $aPrizeGroups[$oPrizeGroup->name] = $oPrizeGroup;
            }
            if (empty($oPrizeGroup)) {
                return -1;
//                $this->halt(false, 'no-right', UserPrizeSet::ERRNO_MISSING_PRIZE_SET);
            }
//            $sGroupName = $oPrizeGroup->name;
            $iGroupId = $oPrizeGroup->id;
            $oSeriesWay = isset($aSeriesWays[$aBetNumber['wayId']]) ? $aSeriesWays[$aBetNumber['wayId']] : ($aSeriesWays[$aBetNumber['wayId']] = SeriesWay::find($aBetNumber['wayId']));
//            $sBetNumber = $oSeriesWay->compileBetNumber($aBetNumber['ball']);
//            $sBetNumber = $this->compileBetNumber($oLottery->series_id, $oSeriesWay, $aBetNumber['ball']);
//            if ($sBetNumber == '') {
//                return -2;
//            }

            $data = [
                'way' => $aBetNumber['wayId'],
                'bet_number' => $sBetNumber = $aBetNumber['ball'],
                'coefficient' => formatNumber($aBetNumber['moneyunit'], 4),
                'multiple' => $aBetNumber['multiple'],
                'single_count' => $aBetNumber['num'],
                'amount' => $aBetNumber['num'] * $aBetNumber['multiple'] * 4,
//                'amount' => $aBetNumber['amount'],
//                'price' => $aBetNumber['price'],
                'price' => 2,
                'prize_group' => $sPrizeGroup,
                'prize_group_id' => $iGroupId,
            ];

            if (isset($aBetData['is_encoded'])) {
                $data['is_encoded'] = $aBetData['is_encoded'];
            }
            if (isset($aBetNumber['position']) && is_array($aBetNumber['position'])) {
                $aPosition = [];
                foreach ($aBetNumber['position'] as $key => $bol) {
                    if ($bol)
                        array_push($aPosition, $key);
                }
                $data['position'] = implode("", $aPosition); // 123 012
            } else
                $data['position'] = "";
            // 秒秒彩开奖号码设置
            !$sWnNumber or $data['winning_number'] = $sWnNumber;
//            $sBetNumber = $aBetNumber['ball'];
            $iSingleCount = $this->countBetNumber($oLottery->series_id, $oSeriesWay, $data);
            if ($iSingleCount != $data['single_count']) {
                $this->writeLog($oSeriesWay->toArray());
                Log::info($aBetNumber);
                Log::info($iSingleCount);
                return -3;
            }
            if ($data['bet_number'] == '') {
                return -2;
            }
//            pr($data);
//            pr($iSingleCount);
//            exit;
            $aBetNumbers[] = $data;
        };
        return true;
    }

    /**
     * display bet form
     * @param Lottery $oLottery
     */
    private function betForm($oLottery) {
        if (!$aGameConfig = & $this->_getGameSettings($oLottery)) {
            $this->halt(false, 'prize-missing', UserPrizeSet::ERRNO_MISSING_PRIZE_SET);
        }
        $sLotteryConfig = json_encode($aGameConfig);
        $iLotteryId = $oLottery->id;
        $sLotteryCode = ($oLottery->identifier);
        $sLotteryName = ($oLottery->friendly_name);
        $this->setVars(compact('sLotteryConfig', 'iLotteryId', 'sLotteryName', 'sLotteryCode'));
        $oSeries = Series::find($oLottery->series_id);
        $this->setVars('availableCoefficients', Coefficient::$coefficients);
        $this->view = $this->customViewPath . '.' . strtolower($oSeries->identifier);
        if ($oLottery->id == 16) {
            $this->view = $this->customViewPath . '.k3Dice';
        }
//        die($this->view);
        return $this->render();
    }

    /**
     * 输出游戏设置
     * @param int $iLotteryId
     * @return string json
     */
    public function getGameSettingsForRefresh($iLotteryId) {
        $oLottery = Lottery::find($iLotteryId);
        if (empty($oLottery)) {
            echo '';
            return;
        }
        if (!$aGameConfig = & $this->_getGameSettings($oLottery)) {
            echo '';
        }
        $this->halt(true, 'info', null, $a, $a, $aGameConfig);
//        echo json_encode($aGameConfig);
        exit;
    }

    private function & _compilePrizeSettings(& $aWayGroups, & $aPrizeDetails, $fPrizeLimit) {
        $aPrizeSettings = [];
        foreach ($aWayGroups as $i => $aMainGroup) {
            foreach ($aMainGroup['children'] as $k => $aSubGroupInfo) {
                foreach ($aSubGroupInfo['children'] as $k => $aWayInfo) {
                    $aBasicMethodIds = explode(',', $aWayInfo['basic_methods']);
                    $aWayPrizes = [];
                    foreach ($aBasicMethodIds as $iBasicMethodId) {
                        $aWayPrizes[] = $aPrizeDetails[$iBasicMethodId]['prize'];
                    }
                    if ($fPrizeLimit) {
                        $sPrize = max($aWayPrizes);
                        $iMaxMultiple = intval($fPrizeLimit / max($aWayPrizes));
                    } else {
                        $sPrize = implode(',', $aWayPrizes);
                        $iMaxMultiple = 0;
                    }
//                    $bDisplayPrize = count($aBasicMethodIds) == 1 || min($aWayPrizes) == max($aWayPrizes);
                    $bDisplayPrize = count(array_count_values($aBasicMethodIds)) == 1;

                    $aPrizeSettings[$aWayInfo['series_way_id']]['name'] = $aWayInfo['name_cn'];
                    $aPrizeSettings[$aWayInfo['series_way_id']]['prize'] = $sPrize;
                    $aPrizeSettings[$aWayInfo['series_way_id']]['max_multiple'] = $iMaxMultiple;
                    $aPrizeSettings[$aWayInfo['series_way_id']]['display_prize'] = $bDisplayPrize;
                }
            }
        }
        ksort($aPrizeSettings);
        return $aPrizeSettings;
    }

    /**
     * 获得游戏设置
     * @param Lottery $oLottery
     * @return array
     */
    protected function & _getGameSettings($oLottery) {
        $iUserId = Session::get('user_id');
        $oUser = User::find($iUserId);
        if (!$aWayGroups = & WayGroup::getWayGroupSettings($oLottery->series_id)) {
            return $aWayGroups;
//            $this->halt(false,'no-right',UserPrizeSet::ERRNO_MISSING_PRIZE_SET);
        }
//        pr(strlen(var_export($aWayGroups, true)));
        $aPrizeDetails = User::getPrizeSettingsOfUser($iUserId, $oLottery->id, $sGroupName);
        $fPrizeLimit = user::getPrizeLimit($iUserId);
        $aPrizeSettings = & $this->_compilePrizeSettings($aWayGroups, $aPrizeDetails, $fPrizeLimit);
        $iMinPrizeGroup = $oUser->is_agent ? SysConfig::readValue('agent_min_grize_group') : SysConfig::readValue('player_min_grize_group');

        // todo: 此处实时查数据库，待优化
        $aOptionalPrizeSettings = PrizeGroup::getPrizeCommissions($oLottery->series_id, $sGroupName, $iMinPrizeGroup);
//        pr($aOptionalPrizeSettings);
//        exit;
        $aGameInfo = & $this->_compileGameSettings($oLottery, $oUser, $aPrizeSettings, $fPrizeLimit, $aOptionalPrizeSettings, $aWayGroups);
        return $aGameInfo;
    }

    public function & _compileGameSettings($oLottery, $oUser, & $aPrizeSettings, $fPrizeLimit, & $aOptionalPrizeSettings, & $aWayGroups) {
        $aGameInfo = [];
        $aIssues = & $this->getIssuesForBet($oLottery);
        if (empty($aIssues)) {
            return $aGameInfo;
//            $this->halt(false,'issue-missing',Issue::ERRNO_ISSUE_MISSING);
        }
//        pr($aWayGroups);
        // todo
//        pr($gameNumbers);
        $iDefaultMultiple = $oUser->bet_multiple or $iDefaultMultiple = 1;
        $fDefaultCoeffcient = $oUser->bet_coefficient or $fDefaultCoeffcient = 1;
        $fDefaultCoeffcient = number_format($fDefaultCoeffcient, 3);
        $oSeries = Series::find($oLottery->series_id);
        $aGameInfo = [
            'gameId' => $oLottery->id,
            'gameSeriesId' => $oLottery->series_id,
            'gameNameEn' => $oLottery->identifier,
            'gameNameCn' => $oLottery->friendly_name,
            'wayGroups' => & $aWayGroups,
            'defaultMethodId' => $oSeries->default_way_id,
//            'gameMethods' => $aWayGroups,
            'prizeSettings' => $aPrizeSettings,
            'uploadPath' => URL::route('bets.upload-bet-number'),
            'jsPath' => '/assets/js/game/' . strtolower(trim($oSeries->identifier)) . '/',
            //游戏注单提交地址
            'submitUrl' => URL::route('bets.bet', ['lottery_id' => $oLottery->id]),
            'loaddataUrl' => URL::route('bets.load-data', ['lottery_id' => $oLottery->id]),
            'loadIssueUrl' => URL::route('bets.load-numbers', ['lottery_id' => $oLottery->id]),
            //最大追号期数
            'traceMaxTimes' => count($aIssues),
            'optionalPrizes' => $aOptionalPrizeSettings,
            'gameNumbers' => $aIssues,
            'currentNumber' => $aIssues[0]['number'],
            'currentNumberTime' => strtotime($aIssues[0]['time']),
            'currentTime' => time(),
            'availableCoefficients' => Coefficient::$coefficients,
            // multiple
            'defaultMultiple' => $iDefaultMultiple,
            'defaultCoefficient' => $fDefaultCoeffcient,
            'prizeLimit' => $fPrizeLimit,
            'maxPrizeGroup' => SysConfig::readValue('max_bet_prize_group'),
            '_token' => Session::get('_token')
        ];

        $aGameInfo['issueHistory'] = & $this->_getIssueListForRefresh($oLottery->id);
        return $aGameInfo;
    }

    // todo: 获取最新开奖号码
    public function getLastWnNumber($iLotteryId) {
        //delayTime:30
        //
        ////请求上期开奖球的url地址
        //lastGameBallsUrl:'/xxx/xxx'
        ////请求上次开奖球的ajax返回格式
        //{
        //'isSuccess':1,
        //'type':'xxxx',
        //'data':{'lastBalls':[1,2,3,4,5]}
        //}
        if ($aLatestWnNumber = Issue::getLatestWnNumber($iLotteryId)) {
            $aGameInfo['lastNumber'] = $aLatestWnNumber['issue'];
            $aGameInfo['lotteryBalls'] = $aLatestWnNumber['wn_number'];
        }
    }

    /**
     * 取得奖期列表，供渲染投注页面使用
     * @param Lottery $oLottery
     * @param int $iCount
     * @return array &
     */
    public function & getIssuesForBet($oLottery, $iCount = null) {
        $oIssue = new Issue;
        $gameNumbers = [];
        $iCount or $iCount = $oLottery->trace_issue_count;

        $aIssues = & $oIssue->getIssueArrayForBet($oLottery->id, $iCount, time());
        return $aIssues;
    }

    /**
     * 生成奖金设置数组，供投注功能使用
     *
     * @param int $iSeriesWayId
     * @param int $iPrizeGroupId
     * @param SeriesWay $oSeriesWay
     * @param array $aPrizeSettings &
     * @param array $aPrizeSettingOfWay &
     * @param array $aMaxPrize &
     */
    private function makePrizeSettingArray($iSeriesWayId, $iPrizeGroupId, $oSeriesWay, & $aPrizeSettings, & $aPrizeSettingOfWay, & $aMaxPrize) {
        if (isset($aPrizeSettings[$iSeriesWayId])) {
            $aPrizeSettingOfWay = $aPrizeSettings[$iSeriesWayId];
        } else {
//            pr($oSeriesWay->toArray());
            $sMethods = $oSeriesWay->basic_methods;
            $aMethodIds = explode(',', $oSeriesWay->basic_methods);
            $aPrizeSettingOfMethods = [];
            $fMaxPrize = 0;
            foreach ($aMethodIds as $iMethodId) {
                $aPrizeSettingOfMethods[$iMethodId] = PrizeDetail::getPrizeSetting($iPrizeGroupId, $iMethodId);
                $fMaxPrize >= $aPrizeSettingOfMethods[$iMethodId][1] or $fMaxPrize = $aPrizeSettingOfMethods[$iMethodId][1];
            }
            $aPrizeSettingOfWay = $aPrizeSettings[$iSeriesWayId] = $aPrizeSettingOfMethods;
            $aMaxPrize[$iSeriesWayId] = $fMaxPrize;
        }
    }

    protected function & getBetData() {
        $aBetData = [];
        if ($this->isAjax) {
            $aBetData = Input::all();
            if (!empty($aBetData['is_encoded'])) {
                $sDecodeContent = Encrypt::decode($aBetData['balls']);
                //print_r($sDecodeContent);exit;
                $aBetData['balls'] = json_decode($sDecodeContent, true);
            }
        } else {
            $sBetData = urldecode($_POST['betdata']);
            $aBetData = json_decode($sBetData, true);
//            !is_object($aBetData) or $aBetData = objectToArray($aBetData);
        }
        return $aBetData;
    }

    /**
     * Bet
     * @param Lottery $oLottery
     */
    protected function doBet($oLottery) {
        if ($oLottery->id == ManLottery::LOTTERY_MMC) {
            $this->_betMMC($oLottery);
        } else {
            $sOnSaleIssue = Issue::getOnSaleIssue($oLottery->id);
            if (empty($sOnSaleIssue)) {
                $this->halt(false, 'issue-missing', Issue::ERRNO_ISSUE_MISSING);
            }
//        $this->dbThreadId = DbTool::getDbThreadId();
            $this->lotteryId = $oLottery->id;
            $this->issue = $sOnSaleIssue;
            BetThread::addThread($oLottery->id, $sOnSaleIssue, $this->dbThreadId);

            $aBetData = & $this->getBetData();
            if (empty($aBetData)) {
                $this->halt(false, 'no-right', UserProject::ERRNO_BET_DATA_ERROR);
            }

            $iLotteryId = $aBetData['gameId'];
            if ($iLotteryId != $oLottery->id) {
                $this->halt(false, 'no-right', UserProject::ERRNO_BET_DATA_ERROR);
            }
            if (Config::get('lotteries.display_bet_data') && in_array($oLottery->id, Config::get('lotteries.debug'))) {
                pr($aBetData);
//            exit;
            }
//        exit;
            $aBetIssues = $aBetData['orders'];
            ksort($aBetIssues, SORT_REGULAR);
            list($sIssue, $iTmp) = each($aBetIssues);

            if ($sOnSaleIssue > $sIssue) {
                $this->halt(false, 'issue-error', Issue::ERRNO_ISSUE_MISSING);
            }

            if (!Session::get('is_player')) {
//            $bAllowAgentBet = SysConfig::readValue('allow_agent_bet');
                if (!SysConfig::check('allow_agent_bet', true)) {
                    $this->halt(false, 'no-right', UserProject::ERRNO_BET_NO_RIGHT);
                }
            }
            $iUserId = Session::get('user_id');
            $iUserPrizeGroupId = UserUserPrizeSet::getGroupId($iUserId, $oLottery->id, $sUserPrizeGroupName);
            if (!$iUserPrizeGroupId) {
                $this->halt(false, 'group-error', UserPrizeSet::ERRNO_MISSING_PRIZE_SET);
            }
            $iMaxBetPrizeGroupOfSysSettings = SysConfig::readValue('max_bet_prize_group');
            $sMaxGroupName = $sUserPrizeGroupName <= $iMaxBetPrizeGroupOfSysSettings ? $sUserPrizeGroupName : $iMaxBetPrizeGroupOfSysSettings;

            $this->writeLog('start do bet');
//        $this->writeLog(var_export($_SERVER,TRUE));
//        $this->writeLog(var_export($_POST,TRUE));
//         pr($this->params);
            // pr($_POST);
            // 整理投注数据
            $this->writeLog(var_export($aBetData, TRUE));
            $sMinGroupName = SysConfig::readValue('player_min_grize_group');
            $oLottery = Lottery::find($iLotteryId);
            if (empty($oLottery)) {
                $this->halt(false, 'lottery-missing', Lottery::ERRNO_LOTTERY_MISSING);
            }

            $this->betTime = Carbon::now();
            if (!$this->checkBetIssue($oLottery, $aBetIssues)) {
                $this->halt(false, 'issue-error', Issue::ERRNO_ISSUE_MISSING);
            }

            $aSeriesWays = [];

            $bCompileResult = $this->compileBetData($oLottery, $aBetData, $aBetNumbers, $aSeriesWays, $sMinGroupName, $sMaxGroupName);
            if ($bCompileResult !== true) {
                switch ($bCompileResult) {
                    case -1:
                        $this->halt(false, 'group-error', UserPrizeSet::ERRNO_PRIZE_GROUP_ERROR);
                        break;
                    case -2:
                        $this->halt(false, 'issue-error', SeriesWay::ERRNO_SERIES_BET_NUMBER_WRONG);
                        break;
                    case -3:
                        $this->halt(false, 'errorTip', UserProject::ERRNO_COUNT_ERROR);
                }
            }
//        pr($aBetNumbers);
//        exit;

            $fTotalAmount = formatNumber($aBetData['amount'], 4);
            // 形成投注用数组
            $this->writeLog('compile-bet-data');
            $aProjects = $aTraces = $aMaxPrize = [];
            $aPrizeSettings = [];
            $iPrizeLimit = User::getPrizeLimit($iUserId);
            $oUser = User::find($iUserId);
            $oAccount = Account::lock($oUser->account_id, $this->accountLocker);
            if (empty($oAccount)) {
                $this->writeLog('lock-fail');
                $this->halt(false, 'netAbnormal', Account::ERRNO_LOCK_FAILED);
            }
            $this->compileTaskAndProjects($aTraces, $aProjects, $aBetData, $aBetNumbers, $aBetIssues, $oAccount, $iPrizeLimit, $aMaxPrize, $aSeriesWays, $oLottery);
//        pr($aProjects);
            // 投注
            $this->writeLog('crate-project');
            if ($bTrace = $aBetData['isTrace']) {
                $aBetResults = $this->createTraces($aTraces, $aSeriesWays, $oLottery, $oAccount, $oUser, $aBetData['traceWinStop']);
                $iBetCount = count($aTraces);
            } else {
                $aBetResults = $this->createProjects($aProjects, $aSeriesWays, $oLottery, $oAccount, $oUser);
                $iBetCount = count($aProjects);
            }
            $this->writeLog('result:');
            $this->writeLog(var_export($aBetResults, 1));

            if (count($aBetResults[1]) == $iBetCount) {
                $iErrno = UserProject::ERRNO_BET_ALL_CREATED;
                $bSuccess = true;
                $sType = 'success';
                $sLinkUrl = URL::route('projects.index');
                $oUser->setBetParams($aBetNumbers[0]['multiple'], $aBetNumbers[0]['coefficient']);
            } else {
                if (count($aBetResults[0]) != $iBetCount) {
                    $iErrno = UserProject::ERRNO_BET_PARTLY_CREATED;
                    $bSuccess = true;
                    $sType = 'bet_part';
                } else {
                    $iErrno = UserProject::ERRNO_BET_FAILED;
                    $bSuccess = false;
                    $sType = 'bet_failed';
                }
                $sLinkUrl = '';
            }
            $this->writeLog('response:');
            $aData = [];
            $this->halt($bSuccess, $sType, $iErrno, $aBetResults[1], $aBetResults[0], $aData, $sLinkUrl);
//        pr($oSeriesWay->toArray());
//        Account::unLock($oUser->account_id);
            exit;
        }
    }

    /**
     * 追号任务入库
     *
     * @param array     $aTraces
     * @param array     $aSeriesWays &
     * @param Lottery   $oLottery
     * @param Account   $oAccount
     * @param User      $oUser
     * @param bool      $bStopOnPrized
     * @return array
     */
    protected function createTraces($aTraces, & $aSeriesWays, $oLottery, $oAccount, $oUser, $bStopOnPrized) {
        $aBetResults = [[], []];
        if (!$aTraces) {
            return $aTraceCount;
        }
//        pr($aSeriesWays);
        $aExtraData = [
            'clientIP' => $this->clientIP,
            'proxyIP' => $this->proxyIP
        ];
        foreach ($aTraces as $aTrace) {
            DB::connection()->beginTransaction();
            $mReturn = UserTrace::createTrace($oUser, $oAccount, $aTrace, $aSeriesWays[$aTrace['bet']['way']], $oLottery, $bStopOnPrized, $aExtraData, $this->betTime, $oFirstProject);
            if (!is_object($mReturn)) {
                DB::connection()->rollback();
                $aBetResults[0][] = [
                    'way' => $aTrace['bet']['way'],
                    'ball' => $aTrace['bet']['bet_number'],
                    'position' => $aTrace['bet']['position'],
                    'reason' => $mReturn
                ];
                break;
            } else {
                DB::connection()->commit();
                $oTrace = $mReturn;
                $oFirstProject->setCommited();
//                $oFirstProject->addTurnoverStatTask(true);     // 建立销售量更新任务
//                pr($aTrace);
                $aBetResults[1][] = [
                    'way' => $aTrace['bet']['way'],
                    'ball' => $aTrace['bet']['bet_number'],
                    'position' => $aTrace['bet']['position'],
                ];
            }
        }
        return $aBetResults;
    }

    /**
     * 注单入库
     *
     * @param array`    $aProjects
     * @param array     $aSeriesWays &
     * @param Lottery   $oLottery
     * @param Account   $oAccount
     * @param User      $oUser
     * @return array
     */
    protected function createProjects($aProjects, & $aSeriesWays, $oLottery, $oAccount, $oUser) {
        $aBetResults = [[], []];
//        $aSuccProjects = [];
        if (!$aProjects) {
            return $aPrjCount;
        }
//        $oTransaction = new Transaction;
        $aExtraData = [
            'client_ip' => $this->clientIP,
            'proxy_ip' => $this->proxyIP,
            'is_tester' => $oUser->is_tester
        ];
        foreach ($aProjects as $aPrj) {
            $aProjectDetails = & UserProject::compileProjectData($aPrj, $aSeriesWays[$aPrj['way']], $oLottery, $aExtraData, $this->betTime);
//            pr($aProjectDetails);
//            exit;

            $oProject = new UserProject($aProjectDetails);
            $oProject->setAccount($oAccount);
            $oProject->setUser($oUser);
            $oProject->setLottery($oLottery);
            DB::connection()->beginTransaction();

//            pr($iReturn);
//            exit;
            if (!$oProject->addProject(true, $iErrno)) {
                DB::connection()->rollback();
                $this->writeLog($iErrno);
                $this->writeLog($oProject->toArray());
                $this->writeLog($oProject->validationErrors->toArray());
                $aBetResults[0][] = [
                    'way' => $aPrj['way'],
                    'ball' => $aPrj['bet_number'],
                    'position' => $aPrj['position'],
                    'reason' => $iErrno
                ];
                break;
            } else {
                DB::connection()->commit();
                $oProject->setCommited();
//                $oProject->updateBuyCommitTime();
//                $oProject->addTurnoverStatTask(true);    // 建立销售量更新任务
//                $aPrjCount[1]++;
                $aBetResults[1][] = [
                    'id' => $oProject->id,
                    'way' => $aPrj['way'],
                    'ball' => $aPrj['bet_number'],
                    'position' => $aPrj['position'],
                ];
            }
        }
        return $aBetResults;
    }

    /**
     * 向追号任务数组中增加一个任务
     *
     * @param array     $aTraces &
     * @param array     $aBetNumber
     * @param array     $aBetIssues
     * @param SeriesWay $oSeriesWay
     * @param int       $iSingleCount
     */
    private function addTraceTaskQueue(& $aTraces, $aBetNumber, $aBetIssues, $oSeriesWay, $aPrizeSettingOfWay, $oLottery, & $aIssueEndTimes) {
//        $sIssue = $aIssue[0];
        $aEndTimes = [];
//        foreach($aBetIssues as $sIssue => $iMultiple){
//        }
        $iSingleCount = $aBetNumber['single_count'];
        $aTraceIssues = [];
        $iOriginalMultiple = $aBetNumber['multiple'];
        $fSingleAmount = formatNumber($iSingleCount * $oSeriesWay->price * $aBetNumber['coefficient'], 4);    // get single amount
        $iTotalCount = $iSingleCount * $iOriginalMultiple;                 // get total amount
        $fValidBaseAmount = formatNumber($fSingleAmount * $iOriginalMultiple, 4);
        foreach ($aBetIssues as $sIssue => $iOrderMultiple) {
            $iMultiple = $iOrderMultiple * $iOriginalMultiple;
            $fValidAmount = formatNumber($fSingleAmount * $iMultiple, 4);   // get valid amount
            $aTraceIssues[$sIssue] = $iMultiple;
            if (!isset($aIssueEndTimes[$sIssue])) {
                $oIssue = Issue::getIssue($oLottery->id, $sIssue);
                $aIssueEndTimes[$sIssue] = $oIssue->end_time;
            }
            $aEndTimes[$sIssue] = $aIssueEndTimes[$sIssue];
        }
        $fTraceMultiple = array_sum($aBetIssues);
        $fTraceAmount = $fTraceMultiple * $fValidBaseAmount;
//        $aBetNumber['prize_group'] = $sGroupName;
        $aBetNumber['prize_set'] = json_encode($aPrizeSettingOfWay);
        $aTraces[] = [
            'bet' => $aBetNumber,
            'issues' => $aTraceIssues,
            'end_times' => $aEndTimes,
        ];
    }

    /**
     * 向注单数组中增加一个注单
     *
     * @param array     $aProjects &
     * @param array     $aBetNumber
     * @param array     $aBetIssues
     * @param float       $fSingleAmount
     */
    private function addSingleProject(& $aProjects, $aBetNumber, $aBetIssues, $fSingleAmount, $aPrizeSettingOfWay, $oLottery, & $aIssueEndTimes) {
        $aIssue = each($aBetIssues);
        $sIssue = $aIssue[0];
        if (!isset($aIssueEndTimes[$sIssue])) {
            $oIssue = Issue::getIssue($oLottery->id, $sIssue);
            $aIssueEndTimes[$sIssue] = $oIssue->end_time;
        }
        $aOrderInfo = [
            'issue' => $sIssue,
            'end_time' => $aIssueEndTimes[$sIssue],
            'single_count' => $aBetNumber['single_count'],
            'multiple' => array_sum($aBetIssues) * $aBetNumber['multiple'],
            'single_amount' => $fSingleAmount,
            'prize_set' => json_encode($aPrizeSettingOfWay),
            'prize_group' => $aBetNumber['prize_group'],
        ];
        $aProjects[] = array_merge($aBetNumber, $aOrderInfo);
    }

    /**
     * 生成追号任务数组及注单数组
     *
     * @param array     $aTraces        &
     * @param array     $aProjects      &
     * @param array     $aBetData       &
     * @param array     $aBetNumbers    &
     * @param array     $aBetIssues        &
     * @param Account   $oAccount
     * @param int       $iGroupId
     * @param int      $iPrizeLimit
     * @param array     $aMaxPrize      &
     * @param array     $aSeriesWays    &
     */
    function compileTaskAndProjects(& $aTraces, & $aProjects, & $aBetData, & $aBetNumbers, & $aBetIssues, $oAccount, $iPrizeLimit, & $aMaxPrize, & $aSeriesWays, $oLottery) {
        $bTrace = $aBetData['isTrace'];
        $fTotalValidAmount = 0;
        $aIssues = [];
        foreach ($aBetNumbers as $k => $aBetNumber) {
//            pr($aBetNumber);
//            exit;
//            !$bTrace or $aTraces[$k] = $aBetNumber;
//                $aBetNumber['amount'] = formatNumber($aBetNumber['amount'], 4);
//            pr($aBetNumber);
//            exit;
            // get way config
            $fTaskValidAmount = 0;
            $iSeriesWayId = $aBetNumber['way'];
            $oSeriesWay = isset($aSeriesWays[$aBetNumber['way']]) ? $aSeriesWays[$aBetNumber['way']] : ($aSeriesWays[$aBetNumber['way']] = SeriesWay::find($aBetNumber['way']));
            // get prize config
            $this->makePrizeSettingArray($iSeriesWayId, $aBetNumber['prize_group_id'], $oSeriesWay, $aPrizeSettings, $aPrizeSettingOfWay, $aMaxPrize);
            $fMaxPrize = $aMaxPrize[$iSeriesWayId];
            // get max multiple
            $iMaxMultiple = intval($iPrizeLimit / $fMaxPrize);
            // check price
            if ($oSeriesWay->price != $aBetNumber['price']) {
                $this->halt('Price Error');
            }

            $this->writeLog('bet-number; ' . var_export($aBetNumber, 1));
//            // todo: 此处会优化到投注码检查处
//            // check count
//            $iSingleCount = $oSeriesWay->count($aBetNumber);        // get single count
//            if ($iSingleCount != $aBetNumber['single_count']) {
//                $this->writeLog($oSeriesWay->toArray());
//                $this->writeLog($aBetNumber);
//                $this->writeLog($iSingleCount);
//                $this->halt(false, 'errorTip', UserProject::ERRNO_COUNT_ERROR);
//            }
            // check mulitple
            if ($iMaxMultiple > 0 && max($aBetIssues) > $iMaxMultiple) {
                $this->halt(false, 'errorTip', UserProject::ERRNO_PRIZE_OVERFLOW);
            }
//            pr($aBetNumber);
//            exit;
            // get amount
            $iOriginalMultiple = $aBetNumber['multiple'];
            $iSingleCount = $aBetNumber['single_count'];
            $fSingleAmount = formatNumber($iSingleCount * $oSeriesWay->price * $aBetNumber['coefficient'], 4);    // get single amount
            $iTotalCount = $iSingleCount * $iOriginalMultiple;                 // get total amount
            $fValidBaseAmount = formatNumber($fSingleAmount * $iOriginalMultiple, 4);
            if ($fValidBaseAmount < 0.02) {
                $this->halt(false, 'low-balance', UserProject::ERRNO_BET_LOW_AMOUNT);
            }
            if ($fValidBaseAmount > $oAccount->available) {
                $this->halt(false, 'low-balance', UserProject::ERRNO_BET_ERROR_LOW_BALANCE);
            }
            if ($bTrace) {
                $this->addTraceTaskQueue($aTraces, $aBetNumber, $aBetIssues, $oSeriesWay, $aPrizeSettingOfWay, $oLottery, $aIssues);
            } else {
                $this->addSingleProject($aProjects, $aBetNumber, $aBetIssues, $fSingleAmount, $aPrizeSettingOfWay, $oLottery, $aIssues);
            }
            $iTotalOrderMultiple = array_sum($aBetIssues);
            $fTotalValidAmount += $fTaskValidAmount = $fValidBaseAmount * $iTotalOrderMultiple;
//            exit;
        }
    }

    /**
     * 析构
     * 1 自动解锁
     * 2 自动删除交易线程
     */
    function __destruct() {
        empty($this->accountLocker) or Account::unLock(Session::get('account_id'), $this->accountLocker, false);
        empty($this->dbThreadId) or BetThread::deleteThread($this->lotteryId, $this->issue, $this->dbThreadId);
        parent::__destruct();
    }

    public function uploadBetNumber() {
        return $this->render();
    }

    protected function checkBetIssue($oLottery, & $aBetIssues) {
        $aTraceIssues = $this->getIssuesForBet($oLottery);
        $aAvailableIssues = array_column($aTraceIssues, 'number');
        $aAvailableEndTimes = array_column($aTraceIssues, 'time');
//        exit;
        $aBetIssueNumbers = array_keys($aBetIssues);
        if ($aDiffIssues = array_diff($aBetIssueNumbers, $aAvailableIssues)) {
            return false;
        }
//        pr($aAvailableEndTimes);
//        pr(min($aAvailableEndTimes));
        unset($aDiffIssues, $aAvailableIssues);
        if ($this->betTime->timestamp > strtotime(min($aAvailableEndTimes))) {
            return false;
        }
        return true;
//        array_multisort($volume, SORT_DESC, $edition, SORT_ASC, $data);
    }

    public function & _getIssueListForRefresh($iLotteryId, $iCount = 20) {
//        $aHistoryWnNumbers = & Issue::getLatestWnNumbers($iLotteryId, 20);
        $sOnSaleIssue = Issue::getOnSaleIssue($iLotteryId);
//        $aFutureIssues = & Issue::getFutureIssues($iLotteryId, $sOnSaleIssue, 6);
        //pr($aFutureIssues);
        $aLastNumber = Issue::getLastWnNumber($iLotteryId);
        $aHistoryWnNumbers = & Issue::getRecentIssues($iLotteryId, $iCount);
        $data = [
//            'issues' => array_merge(array_reverse($aHistoryWnNumbers), $aFutureIssues),
            'issues' => $aHistoryWnNumbers,
            'last_number' => $aLastNumber,
            'current_issue' => $sOnSaleIssue,
        ];
        return $data;
    }

    public function getIssueListForRefresh($iLotteryId) {
        $data = & $this->_getIssueListForRefresh($iLotteryId);
        $ip = get_client_ip();
        if ($data['issues'][0]['issue'] == $data['last_number']['issue'] && empty($data['issues'][0]['wn_number'])) {
            file_put_contents('/tmp/issuelist', date('H:i:s') . ' ' . $ip . "\n", FILE_APPEND);
            file_put_contents('/tmp/issuelist', var_export($data, true) . "\n\n", FILE_APPEND);
        }

        if ($this->isAjax) {
            echo json_encode($data);
        } else {
            pr($data);
        }
        exit;
    }

    /**
     * 秒秒彩投注
     * @param type $oLottery
     */
    private function _betMMC($oLottery) {
        $this->lotteryId = $oLottery->id;

        $aBetData = & $this->getBetData();
        if (empty($aBetData)) {
            $this->halt(false, 'no-right', UserProject::ERRNO_BET_DATA_ERROR);
        }

        $iLotteryId = $aBetData['gameId'];
        if ($iLotteryId != $oLottery->id) {
            $this->halt(false, 'no-right', UserProject::ERRNO_BET_DATA_ERROR);
        }
        if (Config::get('lotteries.display_bet_data') && in_array($oLottery->id, Config::get('lotteries.debug'))) {
            pr($aBetData);
//            exit;
        }
        $aBetIssues = $aBetData['orders'];
        ksort($aBetIssues, SORT_REGULAR);
        list($sIssue, $iTmp) = each($aBetIssues);

        $sCode = $oLottery->compileWinningNumber();
        if (!$oLottery->checkWinningNumber($sCode)) {
            $this->halt(false, 'server-error', UserProject::ERRNO_BET_SERVER_ERROR);
        }

        if (!Session::get('is_player')) {
//            $bAllowAgentBet = SysConfig::readValue('allow_agent_bet');
            if (!SysConfig::check('allow_agent_bet', true)) {
                $this->halt(false, 'no-right', UserProject::ERRNO_BET_NO_RIGHT);
            }
        }
        $iUserId = Session::get('user_id');
        $iUserPrizeGroupId = UserUserPrizeSet::getGroupId($iUserId, $oLottery->id, $sUserPrizeGroupName);
        if (!$iUserPrizeGroupId) {
            $this->halt(false, 'group-error', UserPrizeSet::ERRNO_MISSING_PRIZE_SET);
        }
        $iMaxBetPrizeGroupOfSysSettings = SysConfig::readValue('max_bet_prize_group');
        $sMaxGroupName = $sUserPrizeGroupName <= $iMaxBetPrizeGroupOfSysSettings ? $sUserPrizeGroupName : $iMaxBetPrizeGroupOfSysSettings;

        $this->writeLog('start do bet');
//        $this->writeLog(var_export($_SERVER,TRUE));
//        $this->writeLog(var_export($_POST,TRUE));
//         pr($this->params);
        // pr($_POST);
        // 整理投注数据
        $this->writeLog(var_export($aBetData, TRUE));
        $sMinGroupName = SysConfig::readValue('player_min_grize_group');
        $oLottery = Lottery::find($iLotteryId);
        if (empty($oLottery)) {
            $this->halt(false, 'lottery-missing', Lottery::ERRNO_LOTTERY_MISSING);
        }

        $this->betTime = Carbon::now();

        $aSeriesWays = [];

        $bCompileResult = $this->compileBetData($oLottery, $aBetData, $aBetNumbers, $aSeriesWays, $sMinGroupName, $sMaxGroupName, $sCode);
        if ($bCompileResult !== true) {
            switch ($bCompileResult) {
                case -1:
                    $this->halt(false, 'group-error', UserPrizeSet::ERRNO_PRIZE_GROUP_ERROR);
                    break;
                case -2:
                    $this->halt(false, 'issue-error', SeriesWay::ERRNO_SERIES_BET_NUMBER_WRONG);
                    break;
                case -3:
                    $this->halt(false, 'errorTip', UserProject::ERRNO_COUNT_ERROR);
            }
        }
//        pr($aBetNumbers);
//        exit;

        $fTotalAmount = formatNumber($aBetData['amount'], 4);
        // 形成投注用数组
        $this->writeLog('compile-bet-data');
        $aProjects = $aTraces = $aMaxPrize = [];
        $aPrizeSettings = [];
        $iPrizeLimit = User::getPrizeLimit($iUserId);
        $oUser = User::find($iUserId);
        $oAccount = Account::lock($oUser->account_id, $this->accountLocker);
        if (empty($oAccount)) {
            $this->writeLog('lock-fail');
            $this->halt(false, 'netAbnormal', Account::ERRNO_LOCK_FAILED);
        }
        //秒秒彩没有追号
        $aBetData['isTrace'] = false;
        $this->compileTaskAndProjects($aTraces, $aProjects, $aBetData, $aBetNumbers, $aBetIssues, $oAccount, $iPrizeLimit, $aMaxPrize, $aSeriesWays, $oLottery);
//        pr($aProjects);
        // 投注
        $this->writeLog('crate-project');
        $aBetResults = $this->createProjects($aProjects, $aSeriesWays, $oLottery, $oAccount, $oUser);
        $iBetCount = count($aProjects);
        $this->writeLog('result:');
        $this->writeLog(var_export($aBetResults, 1));
        if (count($aBetResults[1]) == $iBetCount) {
            $iErrno = UserProject::ERRNO_BET_ALL_CREATED;
            $bSuccess = true;
            $sType = 'success';
            $sLinkUrl = URL::route('projects.index');
            $oUser->setBetParams($aBetNumbers[0]['multiple'], $aBetNumbers[0]['coefficient']);
        } else {
            if (count($aBetResults[0]) != $iBetCount) {
                $iErrno = UserProject::ERRNO_BET_PARTLY_CREATED;
                $bSuccess = true;
                $sType = 'bet_part';
            } else {
                $iErrno = UserProject::ERRNO_BET_FAILED;
                $bSuccess = false;
                $sType = 'bet_failed';
            }
            $sLinkUrl = '';
        }
        $this->writeLog('response:');
        $aWnNumberOfMethods = $this->_getWnNumberOfSeriesMethods($oLottery, $sCode);
        $aSeriesWays = [];
        $DB = DB::connection();
        $fPrize = 0;
        foreach ($aBetResults[1] as $val) {
            $oProject = Project::find($val['id']);
            if (in_array($oProject->way_id, $aSeriesWays)) {
                $oSeriesWay = $aSeriesWays[$oProject->way_id];
            } else {
                $oSeriesWay = SeriesWay::find($oProject->way_id);
                foreach ($oSeriesWay->series_method_ids as $iSeriesMethodId) {
                    $oSeriesMethod = SeriesMethod::find($iSeriesMethodId);
                    $aWinningNumbers = & $oSeriesWay->getWinningNumber($aWnNumberOfMethods);
                }
                $aSeriesWays[$oSeriesWay->id] = $oSeriesWay;
            }
            $this->calculateProject($DB, $oSeriesWay, $sCode, $oProject, $aPrizedOfBetNumbers, $aWonProjects, $aLostProjects);
            if ($oProject->status == Project::STATUS_WON) {
                $fPrize += $oProject->prize;
            }
        }
        if ($aLostProjects) {
            $bSucc = ManProject::setLostOfIds($oIssue->wn_number, $aLostProjects);
        }
        $this->setTask($aWonProjects, $aLostProjects);
        $aData['totalPrize'] = $fPrize;
        $this->halt($bSuccess, $sType, $iErrno, $aBetResults[1], $aBetResults[0], $aData, $sLinkUrl);
        exit;
    }

    /**
     * 由中奖号码分析得出各投注方式的中奖号码数组
     * @param Lottery $oLottery
     * @param string $sFullWnNumber
     * @param bool $bNameKey
     * @return array &
     */
    private function & _getWnNumberOfSeriesMethods($oLottery, $sFullWnNumber, $bNameKey = false) {
        $oSeriesMethods = SeriesMethod::where('series_id', '=', $oLottery->series_id)->get();
        $aWnNumbers = [];
        foreach ($oSeriesMethods as $oSeriesMethod) {
            $aWnNumbers[$oSeriesMethod->id] = $oSeriesMethod->getWinningNumber($sFullWnNumber);
        }
        return $aWnNumbers;
    }

    /**
     * 对注单计奖
     * @param DB $DB
     * @param SeriesWay $oSeriesWay
     * @param Issue $oIssue
     * @param Project $oProject
     * @param array & $aPrizedOfBetNumbers
     * @param array & $aWonProjects
     * @param array & $aLostProjects
     * @return array &
     */
    private function & calculateProject($DB, $oSeriesWay, $sCode, $oProject, & $aPrizedOfBetNumbers, & $aWonProjects, & $aLostProjects) {
        $sBetNumber = $oProject->bet_number;
        $sKey = md5($sBetNumber);
        if (array_key_exists($sKey, $aPrizedOfBetNumbers)) {
            $aPrized = $aPrizedOfBetNumbers[$sKey];
        } else {
            $aPrized = $oSeriesWay->checkPrize($sBetNumber);
            !$aPrized or $aPrizedOfBetNumbers[md5($sBetNumber)] = $aPrized;
        }
//            pr($aPrized);
//            exit;
//            pr($oProject->toArray());
        if ($aPrized) {
            $oProject = ManProject::find($oProject->id);
            $DB->beginTransaction();
//            $aPrizeDetailOfPrj = [];
            if ($bSucc = $oProject->setWon($sCode, $aPrized, $aPrizeDetailOfPrj, $oTrace)) {
                $DB->commit();
//                $aPrizeDetails  = array_merge($aPrizeDetails,$aPrizeDetailOfPrj);
                $aWonProjects[] = $oProject->id;
            } else {
                $DB->rollback();
            }
        } else {
            $aLostProjects [] = $oProject->id;
        }
    }

    /**
     * 向队列中增加派奖、派佣金、终止追号、生成追号单等任务
     * @param array $aWonProjects
     * @param array $aLostProjects
     * @param array $aNeedStopTraces
     * @param array $aNeedGenerateTrace
     * @return void
     */
    function setTask($aWonProjects, $aLostProjects) {
        $this->setSendPrizeTask($aWonProjects);
        $this->setSendCommissionTaskOfProjectIds(array_merge($aWonProjects, $aLostProjects));
    }

    /**
     * 新增派奖任务
     * @param bool $aWonProjects 中奖的注单ID
     */
    function setSendPrizeTask($aWonProjects) {
        if (empty($aWonProjects)) {
            return true;
        }
        return $this->pushJob('SendPrize', ['projects' => $aWonProjects], Config::get('schedule.send_prize'));
    }

    /**
     * 新增派佣金任务:将给定ID的所有注单均加入任务
     * @param array $aProjectIds
     * @return bool
     */
    function setSendCommissionTaskOfProjectIds($aProjectIds) {
//        pr('add commission task: ' . var_export($aProjectIds,true));
        return $this->pushJob('SendCommission', ['projects' => $aProjectIds], Config::get('schedule.send_commission'));
    }

    /**
     * 向消息队列增加任务
     * @param string $sCommand
     * @param array $data
     * @param string $connection queue
     * @return bool
     */
    protected function pushJob($sCommand, $data, $connection) {
        for ($i = 0; $i < 10; $i++) {
            if ($bSucc = Queue::push($sCommand, $data, $connection) > 0) {
                break;
            }
        }
        return $bSucc;
    }

}
