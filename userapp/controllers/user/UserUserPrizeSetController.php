<?php

class UserUserPrizeSetController extends UserBaseController {

    /**
     * 资源模型名称
     * @var string|Illuminate\Database\Eloquent\Model
     */
    protected $resourceView = 'centerUser.userPrizeSet';
    protected $modelName = 'UserPrizeSet';

    /**
     * 在渲染前执行，为视图准备变量
     */
    protected function beforeRender() {
        parent::beforeRender();
        // $oLottery     = new Lottery;
        // $aCondition   = null; // Session::get('is_tester') ? null : ['open' => ['=',1]];
        // $aLotteries   = $oLottery->getValueListArray(Lottery::$titleColumn, $aCondition, [Lottery::$titleColumn => 'asc'], true);
        $oPrizeGroup = new PrizeGroup;
        $aPrizeGroups = $oPrizeGroup->getValueListArray($oPrizeGroup->titleColumn, ['series_id' => ['=', 1]], [PrizeGroup::$titleColumn => 'asc'], true);
        // $iUserId      = Session::get('user_id');
        $this->setVars(compact('aPrizeGroups'));
        // pr($aLotteries);exit;
        switch ($this->action) {
            case 'gamePrizeSet':
            case 'prizeSetDetail':
                // $iUserId       = Session::get('user_id');
                // $aUserPrizeSet = $this->generateUserPrizeSet($iUserId);
                $aPrizeLevel = ['一等奖', '二等奖', '三等奖', '四等奖', '五等奖'];
                // pr($aLotteriesPrizeSets[0]->lottery_id);exit;
                $this->setVars(compact('aPrizeLevel'));
                break;
            case 'setPrizeSet':
                Session::put($this->redictKey, route('users.index'));
                break;
        }
    }

    /**
     * [generateUserPrizeSet 生成用户信息 ]
     * @param  [Int] $iUserId [用户ID]
     * @return [Array]          [用户信息]
     */
    private function generateUserPrizeSet($iUserId) {
        $oUserAccount = Account::getAccountInfoByUserId($iUserId);
        $iBetMaxPrize = User::getPrizeLimit($iUserId);
        $oUser = User::find($iUserId);
        $aUserPrizeSets = [
            'username' => $oUser->username, // Session::get('username'),
            'nickname' => $oUser->nickname, // Session::get('nickname'),
            'is_agent' => $oUser->is_agent,
            'is_agent_formatted' => $oUser->user_type_formatted, // Session::get('is_agent'),
            'available_formatted' => $oUserAccount->available_formatted,
            'bet_max_prize' => $iBetMaxPrize
        ];
        return $aUserPrizeSets;
    }

    /**
     * [gamePrizeSet 查看彩票奖金组]
     * @param [Int] $iLotteryId [彩票ID]
     */
    public function gamePrizeSet($iLotteryId = null) {
        $iUserId = Session::get('user_id');
        $aUserPrizeSet = $this->generateUserPrizeSet($iUserId);
        // 获取该用户的所有的彩种的奖金组
        $oLotteriesPrizeSets = UserUserPrizeSet::getUserLotteriesPrizeSets($iUserId);
        // pr($oLotteriesPrizeSets->toArray());exit;
        if (!$iLotteryId) {
            $oLotteriesPrizeSets = UserUserPrizeSet::getUserLotteriesPrizeSets($iUserId);
            $this->setVars(compact('oLotteriesPrizeSets'));
        } else {
            $oUserPrizeSet = UserUserPrizeSet::getUserLotteriesPrizeSets($iUserId, $iLotteryId);
            $iCurrentLotteryId = $iLotteryId;
            $iCurrentPrizeGroup = $oUserPrizeSet->prize_group;
            $iCurrentPrizeGroupId = $oUserPrizeSet->group_id;
            $aLotteriesPrizeSetsTable = $this->getLotteriesPrizeSetsTable($iUserId, $iCurrentLotteryId);
            // pr($aLotteriesPrizeSetsTable);exit;
            $this->getLotteriesPrizeSetsTableCount($aLotteriesPrizeSetsTable);
            // TODO 返点率不是water字段，需要根据上下级奖金设置来计算，待定
            $iWater = PrizeGroup::find($iCurrentPrizeGroupId)->water_formatted;
            $oUser = User::find(Session::get('user_id'));
            $iTopAgentMaxPrizeGroup = SysConfig::readValue('top_agent_max_grize_group');
            $iTopAgentMinPrizeGroup = SysConfig::readValue('top_agent_min_grize_group');
            // 查看用户是否在升降点黑名单中
            $bisUpRole = RoleUser::checkUserRoleRelation(Role::DONT_UP_PRIZE, Session::get('user_id')) || $oUser->prize_group == $iTopAgentMaxPrizeGroup;
            $bisDownRole = RoleUser::checkUserRoleRelation(Role::DONT_DOWN_PRIZE, Session::get('user_id')) || $oUser->prize_group == $iTopAgentMinPrizeGroup;
            $this->setVars('isUpRole', $bisUpRole);
            $this->setVars('isDownRole', $bisDownRole);
            // 获取用户团队销售总额
            $fTotalTurnover = TeamProfit::getUserTotalTeamTurnover(null, null, Session::get('user_id'));

            // 获取用户需要展示的升降点信息
            $sLastCalculateFloatDate = UserPrizeSetFloat::getLastCalculateFloatDate(Session::get('user_id'));

            $iDayRange = daysbetweendates(date('Y-m-d H:i:s', time()), $sLastCalculateFloatDate);
            // 获取升降点条件中天数大于$iDayRange的最小的天数对应的记录
            $aRuleData = PrizeSetFloatRule::getRulesByDayRange($iDayRange);
            // 获取下次计算升降点的日期
            if (key_exists('up', $aRuleData)) {
                $iUpDay = $aRuleData['up']['days'] - $iDayRange;
                $sUpDate = date('m月d日', strtotime($sLastCalculateFloatDate . " + " . ($iUpDay + 1) . " days"));
            } else {
                $iUpDay = $sUpDate = '';
            }
            if (key_exists('down', $aRuleData)) {
                $iDownDay = $aRuleData['down']['days'] - $iDayRange;
                $sDownDate = date('m月d日', strtotime($sLastCalculateFloatDate . " + " . ($iDownDay + 1) . " days"));
            } else {
                $iDownDay = $sDownDate = '';
            }
            // 获取用户指定日期范围的销售总额
            $sCurrentDate = date('Y-m-d');
            $aTopAgentFloatInfo = $this->_getTopAgentFloatInfo($sLastCalculateFloatDate, $sCurrentDate, $bisUpRole, $bisDownRole);
            $this->setVars('aFloatRule', PrizeSetFloatRule::getRuleList());
            $this->setVars(compact('aUserPrizeSet', 'aLotteriesPrizeSetsTable', 'iCurrentLotteryId', 'iCurrentPrizeGroup', 'iWater', 'fTotalTurnover', 'iUpDay', 'sUpDate', 'iDownDay', 'sDownDate', 'aRuleData', 'sLastCalculateFloatDate', 'aTopAgentFloatInfo', 'sCurrentDate'));
            $this->setVars('prizeset', PrizeGroup::getTopAgentPrizeGroups());
            $this->setVars('topAgentMaxPrizeSet', SysConfig::readValue('top_agent_max_grize_group'));
            $this->view = $this->resourceView . '.lotteryPrizeSet';
        }
        // pr(($aCounts));exit;
        return $this->render();
    }

    /**
     * [setPrizeSet 设置彩票奖金组]
     * @param [Int] $iUserId    [用户ID]
     * @param [Int] $iLotteryId [彩票ID]
     */
    public function setPrizeSet($iUserId, $iLotteryId = null) {
        // TODO 暂时禁用, 该功能有问题
        // App::abort(403);
        $oAgent = User::find(Session::get('user_id'));
//        $oUser = User::find($iUserId);
        if (!$oAgent) {
            // TIP 如果当前用户不存在，则直接退出登录
            return App::make('AuthorityController')->logout();
        }
        $bDirectChild = $oAgent->isChild($iUserId, true, $oUser);
        if (!$oUser) {
            return Redirect::route('users.index')->with('error', __('_user.user-not-exist'));
        }
        if (!$bDirectChild) {
            $sUsername = $oUser->username;
            $aReplace = ['username' => $sUsername];
            $sMessage = __('_basic.not-your-user', $aReplace);
            return Redirect::route('users.index')->with('error', $sMessage);
        }
        $iIsAgent = intval($oUser->is_agent);
        $aLotteriesPrizeSets = UserUserPrizeSet::generateLotteriesPrizeWithSeries($iUserId, $iMinPrizeGroup);
//             pr($aLotteriesPrizeSets);exit;
        // 获取玩家的奖金组范围
//            pr($oUser->toArray());
        if (!$oUser->is_agent) {
            $sCurrentUserPrizeGroup = '';
            $iMaxPrizeGroupOfSystem = Sysconfig::readValue('player_max_grize_group');
//                pr('system: ' . $iMaxPrizeGroupOfSystem);
            $iPlayerMinPrizeGroupRange = SysConfig::readValue('min_diff_between_player_agent');
//                pr($iPlayerMinPrizeGroupRange);
            $iUserMaxPrizeGroup = $oAgent->prize_group - $iPlayerMinPrizeGroupRange;
//                pr($iUserMaxPrizeGroup);
            $iMaxPrizeGroup = $iUserMaxPrizeGroup > $iMaxPrizeGroupOfSystem ? $iMaxPrizeGroupOfSystem : $iUserMaxPrizeGroup;
//                $iMinPrizeGroup = Sysconfig::readValue('player_min_grize_group');
        } else {
            // 如果是总代开户，获取代理的奖金组范围
            $sCurrentUserPrizeGroup = $oUser->prize_group;
            $iMaxPrizeGroup = $oAgent->prize_group;
            $iMinPrizeGroup = $oUser->prize_group;
        }
        $bSetable = $iMaxPrizeGroup > $iMinPrizeGroup;
        // $sLotteryPrizeJson = trim(Input::get('lottery_prize_group_json'));
        // $sSeriesPrizeJson = trim(Input::get('series_prize_group_json'));
        // pr($sLotteryPrizeJson);
        // pr($sSeriesPrizeJson);
        // exit;
        if (Request::method() == 'PUT') {
            $aUpdatePrizeSetQuota = $aPrizeSetQuota = json_decode(trim(Input::get('agent_prize_set_quota')), true);
            $aOldPrizeSetQuota = UserPrizeSetQuota::getUserAllPrizeSetQuota($iUserId);
            foreach ($aOldPrizeSetQuota as $sPrizeGroup => $iCount) {
                if (key_exists($sPrizeGroup, $aPrizeSetQuota)) {
                    $aUpdatePrizeSetQuota[$sPrizeGroup] -= $iCount;
                }
            }
//            if (!$bSetable) {
//                return $this->goBack('error', __('_userprizeset.cannot-adjust', $oUser->username));
//            }
            if ($oUser->is_agent) {
                $aSeriesSettings = json_decode($this->params['series_prize_group_json'], true);
//                pr($oAgent->prize_group);
                $iToPrizeGroup = $aSeriesSettings['1'];

                if ($iToPrizeGroup >= 1950) {
                    if ($iToPrizeGroup > $oUser->prize_group && !UserPrizeSetQuota::checkQuota([$iToPrizeGroup => 1], $oAgent->id)) {
                        return $this->goBack('error', __('_userprizeset.quota-not-enough'));
                    }
                    //检验当前开户者是否有开户配额
                    if (array_get($aUpdatePrizeSetQuota, $iToPrizeGroup) !== null) {
                        $aUpdatePrizeSetQuota[$iToPrizeGroup] ++;
                    }
                    //检验开户配额是否符合要求
                    $bSucc = UserPrizeSetQuota::checkQuota($aUpdatePrizeSetQuota, $oAgent->id);
                    if (!$bSucc) {
                        return $this->goBack('error', __('_userprizeset.quota-not-enough'));
                    }
                    if (array_get($aUpdatePrizeSetQuota, $iToPrizeGroup) !== null) {
                        $aUpdatePrizeSetQuota[$iToPrizeGroup] --;
                    }
                }

//                $iToPrizeGroup   = 1935;
                if ($iToPrizeGroup < $oUser->prize_group) {
                    return $this->goBack('error', __('_userprizeset.less-than-exist-prize-group'));
                }
                $oToPrizeGroups = PrizeGroup::getPrizeGroupByName($iToPrizeGroup);
                if ($oToPrizeGroups->count() == 0) {
                    return $this->goBack('error', __('_prizegroup.not-exists', ['group' => $iToPrizeGroup]));
                }
                unset($oToPrizeGroups);
            }
            return $this->setUserPrizeGroups($oUser, $aPrizeSetQuota, $aUpdatePrizeSetQuota);
        } else {
            $aUserAllPrizeSetQuota = UserPrizeSetQuota::getUserAllPrizeSetQuota($oAgent->id);
            $aSelfAllPrizeSetQuota = UserPrizeSetQuota::getUserAllPrizeSetQuota($iUserId);
//            pr($iMaxPrizeGroup);
//            pr($iMinPrizeGroup);
            if ($bSetable) {
                $oAllPossiblePrizeGroups = PrizeGroup::getPrizeGroupsBelowExistGroup($iMaxPrizeGroup, 1, null, $iMinPrizeGroup);
                $sAllPossiblePrizeGroups = json_encode($oAllPossiblePrizeGroups->toArray());
                unset($oAllPossiblePrizeGroups);
            } else {
                $sAllPossiblePrizeGroups = '';
            }
            $aUserPrizeSet = $this->generateUserPrizeSet($iUserId);
            $this->setVars(compact('iUserId', 'aUserPrizeSet', 'aLotteriesPrizeSets', 'iIsAgent', 'aDefaultMaxPrizeGroups', 'aDefaultPrizeGroups', 'iCurrentPrize', 'sCurrentUserPrizeGroup', 'iMinPrizeGroup', 'iMaxPrizeGroup', 'sAllPossiblePrizeGroups', 'bSetable', 'aUserAllPrizeSetQuota', 'aSelfAllPrizeSetQuota'));
            return $this->render();
        }
    }

    /**
     * [getLotteriesPrizeSetsTable 获取彩票奖金组详细信息 ]
     * @param [Int] $iUserId    [用户ID]
     * @param [Int] $iLotteryId [彩票ID]
     * @return [Array]             [彩票奖金组详细列表数组]
     */
    private function getLotteriesPrizeSetsTable($iUserId, $iLotteryId) {
        $oLottery = Lottery::find($iLotteryId);
        $aLotteriesPrizeSetsTable = User::getWaySettings($iUserId, $oLottery);
        return $aLotteriesPrizeSetsTable;
    }

    /**
     * [getLotteriesPrizeSetsTableCount 获取彩票奖金组详细列表的各级子节点数量，供渲染table时使用]
     * @param  [Array] $aLotteriesPrizeSetsTable [彩票奖金组详细列表]
     * @return [Array]                           [包含各级子节点数量数组的彩票奖金组详细列表]
     */
    private function getLotteriesPrizeSetsTableCount(& $aLotteriesPrizeSetsTable) {
        $aLotteriesPrizeSetsTable = arrayToObject($aLotteriesPrizeSetsTable);
        foreach ($aLotteriesPrizeSetsTable as $aWayGroup) {
            $iCount = 0;
            foreach ($aWayGroup->children as $aWay) {
                $iICount = 0;
                foreach ($aWay->children as $aMethod) {
                    $iMethodId = $aMethod->id;
                    $item = explode(',', $aMethod->prize);
                    $item = array_unique($item);
                    $iPrizeCount = count($item);
                    // TIP 特殊处理, 定位但有5个奖级但是都是一样的值
                    if ($iPrizeCount == 1) {
                        $aMethod->prize = $item[0];
                    }
                    // $iPrizeCount = count(explode(',', $item));
                    $aMethod->count = $iPrizeCount;
                    $iCount += $iPrizeCount;
                    $iICount += $iPrizeCount;
                }
                // $aCounts['way_' . $aWay['id']] = $iICount;
                $aWay->count = $iICount;
            }
            // $aCounts['waygroup_' . $aWayGroup['id']] = $iCount;
            $aWayGroup->count = $iCount;
        }
        return $aLotteriesPrizeSetsTable;
    }

    /**
     * [setUserPrizeGroups 更新用户各彩种的奖金组]
     * @param [Integer] $iUserId    [用户id]
     * @param [Integer] $iLotteryId [description]
     */
    private function setUserPrizeGroups($oUser, $aPrizeSetQuota, $aUpdatePrizeSetQuota) {

        $oExistUserPrizeGroups = UserUserPrizeSet::getUserLotteriesPrizeSets($oUser->id);
        $aExistUserPrizeGroups = [];
        foreach ($oExistUserPrizeGroups as $oUserPrizeSet) {
            $aExistUserPrizeGroups[$oUserPrizeSet->lottery_id] = $oUserPrizeSet;
        }
        $sLotteryPrizeJson = trim(Input::get('lottery_prize_group_json'));
        $sSeriesPrizeJson = trim(Input::get('series_prize_group_json'));
        $iAgentId = Session::get('user_id');
        $bIsAgent = $oUser->is_agent;
        $oUserCreateUserLink = new UserRegisterLink;
        $aPostedPrizeGroup = $bIsAgent ? json_decode($sSeriesPrizeJson, true) : json_decode($sLotteryPrizeJson, true);
        if (!$aPostedPrizeGroup) {
            return $this->goBack('error', __('_userprizeset.no-available-prize-group'));
        }
        $aSeries = [];
        if ($bIsAgent) {
            $iToGroup = $aPostedPrizeGroup[1];
//            $iToGroup--;
            if ($iToGroup < $oUser->prize_group) {
                return $this->goBack('error', __('_userprizeset.prize-group-too-low', ['lottery' => __('_lottery.all'), 'group' => $oUser->prize_group]));
            }
//            if ($iToGroup == $oUser->prize_group) {
//                return $this->goBackToIndex('success', __('_userprizeset.seted', ['user' => $oUser->username]));
//            }
            $aPostedSeriesPrizeGroup = $aPostedPrizeGroup;
            $aPostedPrizeGroup = [];
            $aAllLotteries = Lottery::getAllLotteries(null, ['id', 'name', 'series_id']);
            foreach ($aAllLotteries as $aLotteryInfo) {
                $aPostedPrizeGroup[$aLotteryInfo['id']] = $iToGroup;
            }
        }
//        if (!$bIsAgent){
        DB::connection()->beginTransaction();
        $bSucc = false;
        foreach ($aPostedPrizeGroup as $iLotteryId => $sGroup) {
            $oLottery = Lottery::find($iLotteryId);
//            pr($oLottery->toArray());
            if (empty($oLottery)) {
                return $this->goBack('error', __('_basic.data-not-exists', ['data' => __('_basic.lottery') . $iLotteryId]));
            }
            if ($sGroup < $aExistUserPrizeGroups[$iLotteryId]->prize_group) {
                return $this->goBack('error', __('_userprizeset.prize-group-too-low', ['lottery' => $oLottery->friendly_name, 'group' => $aExistUserPrizeGroups[$iLotteryId]->prize_group]));
                ;
            }
            if ($sGroup == $aExistUserPrizeGroups[$iLotteryId]->prize_group) {
                $bSucc = true;
                continue;
            }

            $oSeries = isset($aSeries[$oLottery->series_id]) ? $aSeries[$oLottery->series_id] : $aSeries[$oLottery->series_id] = Series::find($oLottery->series_id);
            !$oSeries->link_to or $oSeries = isset($aSeries[$oSeries->link_to]) ? $aSeries[$oSeries->link_to] : $aSeries[$oSeries->link_to] = Series::find($oSeries->link_to);
            $oPrizeGroup = PrizeGroup::getPrizeGroupsBySeriesName($oSeries->id, $sGroup);
            if (empty($oPrizeGroup)) {
                return $this->goBack('error', __('_prizegroup.not-exists', ['series' => $iSeriesId, 'group' => $sGroup]));
                ;
            }
            if (isset($aExistUserPrizeGroups[$iLotteryId])) {
                $oUserPrizeSet = $aExistUserPrizeGroups[$iLotteryId];
            } else {
                $oUserPrizeSet = new UserPrizeSet([
                    'user_id' => $oUser->id,
                    'lottery_id' => $iLotteryId,
                ]);
            }
            $oUserPrizeSet->group_id = $oPrizeGroup->id;
            $oUserPrizeSet->prize_group = $oPrizeGroup->name;
            $oUserPrizeSet->classic_prize = $oPrizeGroup->classic_prize;
//            pr($oUserPrizeSet);
//            exit;
            if (!$bSucc = empty($oUserPrizeSet->getDirty()) ? true : $oUserPrizeSet->save()) {
                break;
            }
            continue;
        }
        if ($bIsAgent) {
            if ($iToGroup >= 1950) {
                $bSucc = true;
                if ($iToGroup != $oUser->prize_group) {
                    $bSucc = UserPrizeSetQuota::updateUserPrizeSetQuota($oUser->parent_id, [$iToGroup => 1], 'minus');
                    !$bSucc or $bSucc = UserPrizeSetQuota::updateUserPrizeSetQuota($oUser->parent_id, [$oUser->prize_group => 1], 'plus');
                }
                !$bSucc or $bSucc = UserPrizeSetQuota::updateUserPrizeSetQuota($oUser->parent_id, $aUpdatePrizeSetQuota);
                !$bSucc or $bSucc = UserPrizeSetQuota::insertUserPrizeSetQuota($oUser, $aUpdatePrizeSetQuota);
            }
            $oUser->prize_group = $iToGroup;
            $bSucc = $oUser->save();
        }
        $bSucc ? DB::connection()->commit() : DB::connection()->rollback();
//        }
        if ($bSucc) {
//            Session::put($this->redictKey, route('users.index'));
            return $this->goBackToIndex('success', __('_userprizeset.seted', ['user' => $oUser->username]));
        } else {
//            $this->langVars['reason'] = $aReturnMsg['msg'];
            return $this->goBack('error', __('_basic.update-fail', $this->langVars));
        }
    }

    /**
     * [setUserPrizeGroup 设置用户奖金组]
     * @param [Int] $iUserId    [用户ID]
     * @param [Int] $iLotteryId [彩票ID]
     */
    // private function setUserPrizeGroup($iUserId, $iLotteryId)
    // {
    //     $iPrize                       = trim(Input::get('user_Lottery_prize'));
    //     if (! $oLottery = Lottery::find($iLotteryId)) {
    //         return $this->goBack('error', __('_basic.no-available-lottery', $this->langVars));
    //     }
    //     $iLotteryType = $oLottery->type;
    //     if (!$oPrizeGroup = PrizeGroup::getPrizeGroupByClassicPrize($iPrize, $iLotteryType)) {
    //         return $this->goBack('error', __('_basic.no-available-prize-group', $this->langVars));
    //     }
    //     $oUserPrizeSet                = UserUserPrizeSet::getUserLotteriesPrizeSets($iUserId, $iLotteryId);
    //     $oUserPrizeSet->group_id      = $oPrizeGroup->id;
    //     $oUserPrizeSet->prize_group   = $oPrizeGroup->name;
    //     $oUserPrizeSet->classic_prize = $oPrizeGroup->classic_prize;
    //     // pr($oUserPrizeSet->toArray());exit;
    //     $bSucc = $oUserPrizeSet->save();
    //     if ($bSucc) {
    //         return $this->goBack('success', __('_basic.update-success', $this->langVars));
    //     } else {
    //         return $this->goBack('error', __('_basic.update-fail', $this->langVars));
    //     }
    // }

    /**
     * [prizeSetDetail 根据奖金值查询彩票奖金组信息]
     * @param [Integer] $iPrize [奖金组]
     * @param [Integer] $iLotteryId [彩种id]
     */
    public function prizeSetDetail($iPrize, $iLotteryId = null) {
        // $aLotteries   = Lottery::all();
        if (!$iLotteryId) {
            $oLottery = Lottery::first();
        } else {
            $oLottery = Lottery::find($iLotteryId);
        }
        if (!is_object($oLottery)) {
            $replace['resource'] = __('_model.Lottery');
            return $this->goBack('error', __('_basic.missing', $replace));
        }
        $iLotteryType = $oLottery->type;
        $iCurrentLotteryId = $oLottery->id;
        $iCurrentPrizeGroup = $iPrize;
        $iGroupId = PrizeGroup::getPrizeGroupByClassicPrize($iPrize, $iLotteryType)->id;
        // pr($iGroupId);exit;
        // $aLotteriesPrizeSetsTable = WayGroup::getWaySettings($oLottery, $iGroupId);
        $aPrizes = & PrizeGroup::getPrizeDetails($iGroupId);
        // pr($iGroupId);
        // pr($aPrizes);exit;
        $aLotteriesPrizeSetsTable = WayGroup::getWayInfos($oLottery->series_id, $aPrizes, null);
        // pr($aLotteriesPrizeSetsTable);exit;
        $this->getLotteriesPrizeSetsTableCount($aLotteriesPrizeSetsTable);

        $this->setVars(compact('aLotteriesPrizeSetsTable', 'iCurrentPrizeGroup', 'iCurrentLotteryId'));
        return $this->render();
    }

    /**
     * 获取总代我的奖金组页面升降点统计信息
     * @param type $sLastCalculateFloatDate     上次升降点统计信息
     * @param string $sCurrentDate                  当前日期
     * @param boolean $bisUpRole                是否允许升点
     * @param boolean $bisDownRole          是否允许降点
     * @return array
     */
    private function _getTopAgentFloatInfo($sLastCalculateFloatDate, $sCurrentDate, $bisUpRole, $bisDownRole) {
        $aFloatRule = PrizeSetFloatRule::getRuleList();
        $aResult = [];
        if (!is_null($sLastCalculateFloatDate)) {
            foreach ($aFloatRule as $isUp => $val) {
                foreach ($val as $iDay => $aTurnover) {
                    if ($isUp == PrizeSetFloatRule::FLOAT_TYPE_UP && $bisUpRole || $isUp == PrizeSetFloatRule::FLOAT_TYPE_STAY && $bisDownRole) {
                        $aResult[$isUp][$iDay]['beginDate'] = '----';
                        $aResult[$isUp][$iDay]['endDate'] = '----';
                        $aResult[$isUp][$iDay]['isUp'] = $isUp;
                        $aResult[$isUp][$iDay]['turnover'] = null;
                    } else {
                        $sBeginDate = date('Y-m-d', strtotime($sCurrentDate . " - " . ($iDay - 1) . " days"));
                        $sBeginDate = $sBeginDate > $sLastCalculateFloatDate ? $sBeginDate : $sLastCalculateFloatDate;
                        $aResult[$isUp][$iDay]['beginDate'] = $sBeginDate;
                        $aResult[$isUp][$iDay]['endDate'] = date('Y-m-d', strtotime($sBeginDate . ' + ' . ($iDay - 1) . ' days'));
                        $aResult[$isUp][$iDay]['isUp'] = $isUp;
                        $aResult[$isUp][$iDay]['turnover'] = TeamProfit::getUserTotalTeamTurnover($sBeginDate, $sCurrentDate, Session::get('user_id'));
                    }
                }
            }
        } else {
            foreach ($aFloatRule as $isUp => $val) {
                foreach ($val as $iDay => $aTurnover) {
                    if ($isUp == PrizeSetFloatRule::FLOAT_TYPE_UP && $bisUpRole || $isUp == PrizeSetFloatRule::FLOAT_TYPE_STAY && $bisDownRole) {
                        $aResult[$isUp][$iDay]['beginDate'] = '----';
                        $aResult[$isUp][$iDay]['endDate'] = '----';
                        $aResult[$isUp][$iDay]['isUp'] = $isUp;
                        $aResult[$isUp][$iDay]['turnover'] = null;
                    } else {
                        $sEndDate = date('Y-m-d', strtotime($sCurrentDate . " + " . ($iDay - 1) . " days"));
                        $aResult[$isUp][$iDay]['beginDate'] = $sCurrentDate;
                        $aResult[$isUp][$iDay]['isUp'] = $isUp;
                        $aResult[$isUp][$iDay]['endDate'] = $sEndDate;
                        $aResult[$isUp][$iDay]['turnover'] = TeamProfit::getUserTotalTeamTurnover($sCurrentDate, $sEndDate, Session::get('user_id'));
                    }
                }
            }
        }
        return $aResult;
    }

}
