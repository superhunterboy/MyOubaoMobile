<?php

# 链接开户管理

class UserRegisterLinkController extends UserBaseController {

    protected $resourceView = 'centerUser.link';
    protected $modelName = 'UserRegisterLink';
    public $resourceName = '';

    const QQ_NUM_MIN = 50000;
    const QQ_NUM_MAX = 99999999999;

    public function beforeRender() {
        parent::beforeRender();
        // $aChannels = UserRegisterLink::$aChannels;
        // $oLottery     = new Lottery;
        // $aCondition   = null; //Session::get('is_tester') ? null : ['open' => ['=', 1]];
        // $aLotteries   = $oLottery->getValueListArray(Lottery::$titleColumn, $aCondition, [Lottery::$titleColumn => 'asc'], true);
        // $this->setVars(compact('aLotteries'));
        switch ($this->action) {
            case 'view':
                $aSeriesLotteries = Series::getLotteriesGroupBySeries();
                $this->setVars('aListColumnMaps', UserRegisterLink::$listColumnMaps);
                // $aPrizeGroupWaters       = PrizeGroup::getPrizeGroupWaterMap();
                $this->setVars(compact('aSeriesLotteries'));
            // pr($this->viewVars['data']->toArray());
            // exit;
            case 'index':
                $aUserTypes = User::$aUserTypes;
                $this->setVars(compact('aUserTypes'));
                $iUserId = Session::get('user_id');
                $totalUserCount = RegisterLink::getTotalUserCountByUserId($iUserId);
                $this->setVars('totalUserCount', $totalUserCount);
                break;
            case 'create': // 新增时, 需要提供奖金组范围, 当前奖金组信息等数据
                $iUserId = Session::get('user_id');
                $aLotteriesPrizeSets = UserPrizeSet::generateLotteriesPrizeWithSeries($iUserId, $iMinPrizeGroup);
                $oUser = User::find($iUserId);
                $this->setVars('currentUserPrizeGroup', $oUser->prize_group);
                // 获取玩家的奖金组范围
                $iPlayerMaxPrizeGroup = Sysconfig::readValue('player_max_grize_group');
                $aCurrentPrizeGroups = $aLotteriesPrizeSets[0]['children'][0];              // TODO 链接开户的奖金组选择，页面设计里没有体现时时彩和乐透彩的区别，先用时时彩
                $iSeriesId = $aCurrentPrizeGroups['series_id']; // TODO 链接开户的奖金组选择，页面设计里没有体现时时彩和乐透彩的区别，先用时时彩
                $iPlayerMinPrizeGroupRange = SysConfig::readValue('min_diff_between_player_agent');
                if ($iPlayerMaxPrizeGroup < $aCurrentPrizeGroups['classic_prize']) {
                    $iCurrentPrize = $iPlayerMaxPrizeGroup;
                    $bInclude = true;
                } else {
                    $bInclude = false;
                    $iCurrentPrize = $aCurrentPrizeGroups['classic_prize'];
                }
                $iPlayerMinPrizeGroup = Sysconfig::readValue('player_min_grize_group');
                // 获取低于当前代理奖金组的玩家可能的6个奖金组
                $oPossiblePrizeGroups = PrizeGroup::getPrizeGroupsBelowExistGroup($iCurrentPrize, $iSeriesId, 8, $iPlayerMinPrizeGroup, 'desc', $bInclude);
                $oAllPossiblePrizeGroups = PrizeGroup::getPrizeGroupsBelowExistGroup($iCurrentPrize, $iSeriesId, null, $iPlayerMinPrizeGroup, 'asc', 0);

                // 如果是总代开户，获取代理的奖金组范围
                $oPossibleAgentPrizeGroups = [];
                if (Session::get('is_agent')) {
                    $iAgentMaxPrizeGroup = Sysconfig::readValue('agent_max_grize_group');
                    $aCurrentPrizeGroups = $aLotteriesPrizeSets[0]['children'][0];              // TODO 链接开户的奖金组选择，页面设计里没有体现时时彩和乐透彩的区别，先用时时彩
                    if ($iAgentMaxPrizeGroup < $aCurrentPrizeGroups['classic_prize']) {
                        $iAgentCurrentPrize = $iAgentMaxPrizeGroup;
                    } else {
                        $iAgentCurrentPrize = $aCurrentPrizeGroups['classic_prize'];
                    }
                    $iAgentMinPrizeGroup = Sysconfig::readValue('agent_min_grize_group');
                    $oPossibleAgentPrizeGroups = PrizeGroup::getPrizeGroupsBelowExistGroup($iAgentCurrentPrize, $iSeriesId, 8, $iAgentMinPrizeGroup, 'desc', Session::get('is_top_agent'));
                    $oAllPossibleAgentPrizeGroups = PrizeGroup::getPrizeGroupsBelowExistGroup($iAgentCurrentPrize, $iSeriesId, null, $iAgentMinPrizeGroup, 'asc', Session::get('is_top_agent'));
                    $aUserAllPrizeSetQuota = UserPrizeSetQuota::getUserAllPrizeSetQuota($iUserId);
                }
                $aDefaultMaxPrizeGroups = RegisterLink::$aDefaultMaxPrizeGroups;
                $aDefaultPrizeGroups = RegisterLink::$aDefaultPrizeGroups;
                // pr($aDefaultPrizeGroups);exit;
                $this->setVars(compact('oAllPossibleAgentPrizeGroups', 'oAllPossiblePrizeGroups', 'aUserAllPrizeSetQuota'));
                $this->setVars(compact('oPossiblePrizeGroups', 'oPossibleAgentPrizeGroups', 'aLotteriesPrizeSets', 'iAgentCurrentPrize', 'iCurrentPrize', 'aDefaultPrizeGroups', 'aDefaultMaxPrizeGroups', 'iAgentMinPrizeGroup', 'iPlayerMinPrizeGroup'));
                break;
        }
    }

    public function index() {
        // $aUserLinkGroups = UserRegisterLink::getUserLinksWithChannelGroup();
        $iUserId = Session::get('user_id');
        if (!$iUserId)
            return $this->goBack('error', __('_basic.no-rights'));
        $this->params['user_id'] = $iUserId;
        $this->params['is_admin'] = 0;
        // TODO 是否只显示未删除的链接
        // $this->params['status']   = 0;

        return parent::index();
    }

    public function create($id = null) {
        if (!$bIsAgent = Session::get('is_agent')) {
            return $this->goBack('error', __('_basic.no-rights'));
        }
        if (Request::method() == 'POST') {
            // 总代不能开玩家
            if (Session::get('is_top_agent') && array_get($this->params, 'is_agent') == 0) {
                return $this->goBack('error', __('_basic.no-rights'));
            }
            $iPrizeGroupType = trim(Input::get('prize_group_type'));
            $iPrizeGroupId = trim(Input::get('prize_group_id'));
            $sLotteryPrizeJson = trim(Input::get('lottery_prize_group_json'));
            $sSeriesPrizeJson = trim(Input::get('series_prize_group_json'));
            $iUserId = Session::get('user_id');
            // pr($iPrizeGroupType);
            // pr($iPrizeGroupId);
            // pr($sLotteryPrizeJson);
            // pr($sSeriesPrizeJson);
            // pr($this->params);
            // exit;
            $oUserRegisterLink = new UserRegisterLink;
            $sPrizeGroupSetsJson = $oUserRegisterLink->generateUserPrizeSetJson($this->params['is_agent'], $iPrizeGroupType, $iPrizeGroupId, $sLotteryPrizeJson, $sSeriesPrizeJson, $iUserId);
            if (!$sPrizeGroupSetsJson) {
                return $this->goBack('error', __('_userprizeset.no-available-prize-group'));
            }
            $iType = intval($this->params['is_agent']) ? Domain::TYPE_AGENT : Domain::TYPE_USER;
            $sAvailableDomain = Domain::getRandomDomainInPool($iType);
            // pr($sAvailableDomain);exit;
            $sAvailableDomain or $sAvailableDomain = $_SERVER['SERVER_NAME'];
            // pr($sAvailableDomain);exit;
            $this->params['user_id'] = $iUserId;
            $this->params['username'] = Session::get('username');
            $this->params['is_tester'] = Session::get('is_tester');
            $this->params['keyword'] = md5($this->params['username'] . time() . random_str(5));
            $this->params['url'] = $sAvailableDomain . Config::get('var.default_signup_dir_name') . '?prize=' . $this->params['keyword']; // $_SERVER['SERVER_NAME']
            $this->params['prize_group_sets'] = $sPrizeGroupSetsJson;
            if (strpos($this->params['url'], 'http') !== 0) {
                $this->params['url'] = ((isset($_SERVER["https"]) && $_SERVER["https"]) ? 'https://' : 'http://') . $this->params['url'];
            }
            $bSucc = true;
            $aAgentQQs = array_filter($this->params['agent_qqs']);
            foreach ($aAgentQQs as $key => $value) {
                if (!preg_match("/^\d*$/", $value) || $value < static::QQ_NUM_MIN) { // || $value > static::QQ_NUM_MAX
                    $bSucc = false;
                    break;
                }
            }
            if (!$bSucc) {
                return $this->goBack('error', __('_registerlink.qq-number-error', ['min' => static::QQ_NUM_MIN, 'max' => static::QQ_NUM_MAX]));
            }
            $this->params['agent_qqs'] = implode(',', $aAgentQQs);
            $this->params['is_admin'] = 0;
            if (intval($this->params['valid_days'])) {
                // TIP 添加链接从添加时间的后一天开始计算, 到过期时间的23：59：59 即过期日期的后一天的00:00:00
                // 编辑时, 从编辑当天向后续期
                $this->params['expired_at'] = Carbon::today()->addDays(intval($this->params['valid_days']) + 1)->toDateTimeString();
            }
        }
        if (!$this->isMobile) {
            Session::put($this->redictKey, route('user-links.index'));
        }
        return parent::create($id);
    }

    /**
     * [closeLink 删除代理创建的开户链接]
     * @param  [Integer] $id [链接id]
     */
    public function closeLink($id) {
        $oLink = UserRegisterLink::getActiveLink($id);
        // pr($oLink->toArray());exit;
        if (!$oLink) {
            return $this->goBack('error', __('_basic.no-rights'));
        }
        // 只能关闭自己的链接
        if ($oLink->user_id != Session::get('user_id')) {
            return $this->goBack('error', __('_basic.no-rights'));
        }
        // $oLink->status = 1;
        $bSucc = $oLink->update(['status' => 1]);
        if ($bSucc) {
            return $this->goBack('success', __('_basic.closed', $this->langVars));
        } else {
            return $this->goBack('error', __('_basic.close-fail', $this->langVars));
        }
    }

}
