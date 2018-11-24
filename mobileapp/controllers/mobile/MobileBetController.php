<?php

/**
 * 移动端投注
 */
class MobileBetController extends BetController {

    protected $sProjectIndexUrl = 'mobile-users.index';

    /**
     * display bet form
     * @param Lottery $oLottery
     */
    public function betForm($oLottery) {
        if (!$aGameConfig = & $this->_getGameSettings($oLottery)) {
            $this->halt(false, 'prize-missing', UserPrizeSet::ERRNO_MISSING_PRIZE_SET);
        }
        $sLotteryConfig = json_encode($aGameConfig);
        $iLotteryId = $oLottery->id;
        $sLotteryCode = ($oLottery->identifier);
        $sLotteryName = ($oLottery->friendly_name);
        $this->setVars(compact('sLotteryConfig', 'iLotteryId', 'sLotteryName', 'sLotteryCode'));
        $oSeries = Series::find($oLottery->series_id);
        $this->view = $this->customViewPath . '.' . strtolower($oSeries->identifier);
        return $this->render();
    }

    public function & _compilePrizeSettings(& $aWayGroups, & $aPrizeDetails, $fPrizeLimit) {
        $aPrizeSettings = [];
        foreach ($aWayGroups as $i => $aMainGroup) {
            if(in_array($aMainGroup['id'], [80, 93])){
                unset($aWayGroups[$i]);
                continue;
            }
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
                    $aPrizeSettings[$aWayInfo['series_way_id']]['display_prize'] = true;
                }
            }
        }
        ksort($aPrizeSettings);
        return $aPrizeSettings;
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

            $iUserId = Session::get('user_id');
            $iUserPrizeGroupId = UserUserPrizeSet::getGroupId($iUserId, $oLottery->id, $sUserPrizeGroupName);
            if (!$iUserPrizeGroupId) {
                $this->halt(false, 'group-error', UserPrizeSet::ERRNO_MISSING_PRIZE_SET);
            }
            $iMaxBetPrizeGroupOfSysSettings = SysConfig::readValue('bet_max_prize_group');
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
            
            Log::info('$iBetCount='.$iBetCount);
//            Log::info('count($aBetResults[1])='.count($aBetResults[1]));
            if (count($aBetResults[1]) == $iBetCount) {
                $iErrno = UserProject::ERRNO_BET_ALL_CREATED;
                $bSuccess = true;
                $sType = 'success';
                $sLinkUrl = URL::route('mobile-projects.index');
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
     * 获得游戏设置
     * @param Lottery $oLottery
     * @return array
     */
    public function & _getGameSettings($oLottery) {
        $iUserId = Session::get('user_id');
        $oUser = User::find($iUserId);
        if (!$aWayGroups = & WayGroup::getWayGroupSettings($oLottery->series_id, true)) {
            return $aWayGroups;
//            $this->halt(false,'no-right',UserPrizeSet::ERRNO_MISSING_PRIZE_SET);
        }
//        pr(strlen(var_export($aWayGroups, true)));
        $aPrizeDetails = User::getPrizeSettings($iUserId, $oLottery->id, $sGroupName);
        $fPrizeLimit = user::getPrizeLimit($iUserId);
        $aPrizeSettings = & $this->_compilePrizeSettings($aWayGroups, $aPrizeDetails, $fPrizeLimit);
        $iMinPrizeGroup = $oUser->is_agent ? SysConfig::readValue('agent_min_grize_group') : SysConfig::readValue('player_min_grize_group');

        // todo: 此处实时查数据库，待优化
        $aOptionalPrizeSettings = PrizeGroup::getPrizeCommissions($oLottery->series_id, $sGroupName, $iMinPrizeGroup);
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
            'jsPath' => '/assets/dist/js/game/' . strtolower(trim($oSeries->identifier)) . '/',
            //游戏注单提交地址
            'submitUrl' => URL::route('mobile-bets.bet', ['lottery_id' => $oLottery->id]),
            'loaddataUrl' => URL::route('mobile-bets.load-data', ['lottery_id' => $oLottery->id]),
            'loadIssueUrl' => URL::route('mobile-bets.load-numbers', ['lottery_id' => $oLottery->id]),
            //最大追号期数
            'traceMaxTimes' => count($aIssues),
            'optionalPrizes' => $aOptionalPrizeSettings,
            'gameNumbers' => $aIssues,
            'currentNumber' => $aIssues[0]['number'],
            'currentNumberTime' => strtotime($aIssues[0]['time']),
            'currentTime' => time(),
            'availableCoefficients' => Coefficient::$MobileCoefficients,
            // multiple
            'defaultMultiple' => $iDefaultMultiple,
            'defaultCoefficient' => $fDefaultCoeffcient,
            'prizeLimit' => $fPrizeLimit,
            '_token' => Session::get('_token')
        ];

        $aGameInfo['issueHistory'] = & $this->_getIssueListForRefresh($oLottery->id, 5);
        $oLottery->id != 18 or $aGameInfo['ballsHistory'] = $this->_getWnNumberListForRefresh($oLottery->id);
        return $aGameInfo;
    }

    public function getIssueListForRefresh($iLotteryId) {
        $data = & $this->_getIssueListForRefresh($iLotteryId, 5);
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

    public function gameHome() {
        $allLotteries = Lottery::getAllLotteries(true);
        $this->setVars(compact('allLotteries'));
        $this->view = 'game';
        return $this->render();
    }

}
