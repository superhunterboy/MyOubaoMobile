<?php

class UserPrizeSetController extends AdminBaseController {

    /**
     * 资源模型名称
     * @var string|Illuminate\Database\Eloquent\Model
     */
    protected $modelName = 'UserPrizeSet';
    protected $resourceView = 'default';
    protected $customViewPath = 'userPrizeSet';
    protected $customViews = [
        'agentDistributionList',
//        'edit',
        'setPrizeGroupForAgent'
    ];

    /**
     * 在渲染前执行，为视图准备变量
     */
    protected function beforeRender() {
        parent::beforeRender();
        $aLotteries = & ManLottery::getTitleList();
//        pr($aLotteries);
//        exit;
        $oPrizeGroup = new PrizeGroup;
        $aPrizeGroups = $oPrizeGroup->getValueListArray(PrizeGroup::$titleColumn, ['series_id' => ['=', 1]], [PrizeGroup::$titleColumn => 'asc'], true);
        $this->setVars(compact('aLotteries'));

        switch ($this->action) {
            case 'agentPrizeGroupList':
                $aUserTypes = UserPrizeSet::$aUserTypes;
                $this->setVars(compact('aUserTypes'));
                break;
            case 'setPrizeGroupForAgent':
                break;
            case 'index':
                break;
            default:
                # code...
                break;
        }
    }

    /**
     * [setPrizeGroupForAgent 设置用户奖金组(永久/临时)]
     * @param  [Integer] $id [用户id]
     */
    public function setPrizeGroupForAgent($id) {
        // pr(Request::method());exit;
        if (Request::method() == 'POST') {
            if (!$this->params['prize_group']) {
                return false;
            }
            if (!$this->params['valid_days']) {
                $bSucc = $this->updateUserPrizeSet($id, $sErrorStr);
            } else {
                $bSucc = $this->updateTempUserPrizeSet($id, $sErrorStr);
            }
            // pr($bSucc);exit;
            if ($bSucc) {
                DB::connection()->commit();
                // TODO 代理奖金组列表是查询的用户表, 所以这里要强制跳转回用户列表
                $this->redictKey = 'curPage-User';
                return $this->goBackToIndex('success', __('_basic.created', $this->langVars));
            } else {
                DB::connection()->rollback();
                $this->langVars['reason'] = $sErrorStr;
                return $this->goBack('error', __('_basic.create-fail', $this->langVars));
            }
        } else {
            $oUser = User::find($id);
            // TopAgent 1955-1960, Agent 1950-1955
            if ($oUser->parent_id) {
                $aLimitPrizeGroups = range(SysConfig::readValue('agent_min_grize_group'), SysConfig::readValue('agent_max_grize_group')); // SysConfig::getSource(sysConfig::readDataSource('agent_default_prize_group'));
            } else {
                $aLimitPrizeGroups = range(SysConfig::readValue('top_agent_min_grize_group'), SysConfig::readValue('top_agent_max_grize_group')); // SysConfig::getSource(sysConfig::readDataSource('top_agent_default_prize_group'));
            }
            $aLimitDays = range(0, 30);
            $data = $oUser;
            // array_unshift($aLimitDays, '');
            // pr($oUser->toArray());
            // pr($aLimitPrizeGroups);
            // pr($aLimitDays);
            // exit;
            $this->setVars(compact('id', 'data', 'aLimitPrizeGroups', 'aLimitDays'));
            return $this->render();
        }
    }

    /**
     * [updateUserPrizeSet 更新永久用户奖金组]
     * @param  [Integer] $iUserId [用户id]
     * @return [String]      [错误信息]
     */
    private function updateUserPrizeSet($iUserId, & $sErrorStr) {
        // $oExistUserPrizeSet = UserPrizeSet::find($id);
        // $iUserId            = $oExistUserPrizeSet->user_id;
        $sPrizeGroup = $this->params['prize_group'];
        $oPrizeGroups = PrizeGroup::getPrizeGroupByName($sPrizeGroup);
        $aLotteriesSeries = ManLottery::getAllLotteryIdsGroupBySeries();
        $aPrizeGroups = [];
        foreach ($oPrizeGroups as $key => $oPrizeGroup) {
            $aPrizeGroups[$oPrizeGroup->series_id] = $oPrizeGroup;
        }
        // $iClassicPrize      = $oPrizeGroup->classic_prize;
        // $iPrizeGroupId      = $oPrizeGroup->id;
        $aUserPrizeSets = UserPrizeSet::getUserLotteriesPrizeSets($iUserId, null, ['*']);
        $oUser = User::find($iUserId);
        // pr($oPrizeGroups->toArray());exit;
        $sErrorStr = '';
        DB::connection()->beginTransaction();
        foreach ($aUserPrizeSets as $oUserPrizeSet) {
            $oPrizeGroup = $aPrizeGroups[$aLotteriesSeries[$oUserPrizeSet->lottery_id]];
            $iClassicPrize = $oPrizeGroup->classic_prize;
            $iPrizeGroupId = $oPrizeGroup->id;
            $aParam = ['group_id' => $iPrizeGroupId, 'prize_group' => $sPrizeGroup, 'classic_prize' => $iClassicPrize];
            // pr($aParam);
            if (!$bSucc = $oUserPrizeSet->update($aParam)) {
                $sErrorStr = $oUserPrizeSet->getValidationErrorString();
                break;
            }
        }
        $bSucc = $oUser->update(['prize_group' => $sPrizeGroup]);
        // exit;
        return $bSucc;
    }

    /**
     * [updateTempUserPrizeSet 更新临时用户奖金组]
     * @param  [Integer] $iUserId [用户id]
     * @return [String]      [错误信息]
     */
    private function updateTempUserPrizeSet($iUserId, & $sErrorStr) {
        $sPrizeGroup = $this->params['prize_group'];
        $oPrizeGroups = PrizeGroup::getPrizeGroupByName($sPrizeGroup);
        $aLotteriesSeries = ManLottery::getAllLotteryIdsGroupBySeries();
        $aPrizeGroups = [];
        foreach ($oPrizeGroups as $key => $oPrizeGroup) {
            $aPrizeGroups[$oPrizeGroup->series_id] = $oPrizeGroup;
        }
        $aUserPrizeSets = UserPrizeSet::getUserLotteriesPrizeSets($iUserId, null, ['*']);
        $aUserPrizeSetTemps = UserPrizeSetTemp::getUserLotteriesPrizeSets($iUserId, null, ['*']);
        $data = [];
        foreach ($aUserPrizeSetTemps as $oUserPrizeSetTemp) {
            $key = $oUserPrizeSetTemp->user_id . '_' . $oUserPrizeSetTemp->lottery_id;
            $data[$key] = $oUserPrizeSetTemp;
        }
        // pr($aUserPrizeSetTemps->toArray());exit;
        $sErrorStr = '';
        DB::connection()->beginTransaction();
        foreach ($aUserPrizeSets as $oUserPrizeSet) {
            $oPrizeGroup = $aPrizeGroups[$aLotteriesSeries[$oUserPrizeSet->lottery_id]];
            $iClassicPrize = $oPrizeGroup->classic_prize;
            $iPrizeGroupId = $oPrizeGroup->id;
            $aParams = $oUserPrizeSet->getAttributes();
            $aParams['group_id'] = $iPrizeGroupId;
            $aParams['prize_group'] = $sPrizeGroup;
            $aParams['classic_prize'] = $iClassicPrize;
            $aParams['valid_days'] = $this->params['valid_days'];
            $aParams['expired_at'] = Carbon::today()->addDays($this->params['valid_days'])->toDateTimeString();
            // $aParams['user_parent_id'] or $aParams['user_parent_id'] = '';
            // $aParams['user_parent'] or $aParams['user_parent'] = '';
            $key = $oUserPrizeSet->user_id . '_' . $oUserPrizeSet->lottery_id;
            if ($data && array_key_exists($key, $data)) {
                $oUserPrizeSetTemp = $data[$key];
            } else {
                $oUserPrizeSetTemp = new UserPrizeSetTemp;
            }
            // pr($aParams);
            // pr($oUserPrizeSet->toArray());
            // exit;
            $oUserPrizeSetTemp->fill($aParams);
            // pr($oUserPrizeSetTemp->toArray());exit;
            if (!$bSucc = $oUserPrizeSetTemp->save()) {
                $sErrorStr = $oUserPrizeSetTemp->getValidationErrorString();
                break;
            }
        }
        return $bSucc;
    }

    /**
     * 资源编辑页面
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
        $this->model = $this->model->find($id);
        if (!is_object($this->model)) {
            return $this->goBackToIndex('error', __('_basic.missing', $this->langVars));
        }
        $oUser = User::find($this->model->user_id);
        if (!is_object($oUser)) {
            return $this->goBackToIndex('error', __('_user.missing-data'));
        }
        if ($oUser->is_agent == 0) {
            return $this->goBackToIndex('error', __('_basic.not-allowed'));
        }
        $oLottery = Lottery::find($this->model->lottery_id);
        if (!is_object($oLottery)) {
            return $this->goBackToIndex('error', __('_lottery.missing-data'));
        }
        if (is_null($oUser->parent_id)) {
            $iMaxPrizeGroup = SysConfig::readValue('top_agent_max_grize_group');
            $iMinPrizeGroup = SysConfig::readValue('top_agent_min_grize_group');
        } else {
            $iMinPrizeGroup = SysConfig::readValue('agent_min_grize_group');
            $oParentUser = User::find($oUser->parent_id);
            $iMaxPrizeGroup = $oParentUser->prize_group;
        }
        $iMaxSubAgentPrizeGroup = User::getMaxPrizeGroupByParentId($oUser->id);
        $iMinPrizeGroup = $iMinPrizeGroup > $iMaxSubAgentPrizeGroup ? $iMinPrizeGroup : $iMaxSubAgentPrizeGroup;
        $aConditions = [
            'series_id' => ['=', $oLottery->series_id],
            'classic_prize' => ['between', [$iMinPrizeGroup, $iMaxPrizeGroup]],
        ];
        $oPrizeGroup = new PrizeGroup;
        $aPrizeGroups = $oPrizeGroup->getValueListArray(PrizeGroup::$titleColumn, $aConditions, [PrizeGroup::$titleColumn => 'asc'], true);
        $aPrizeGroup = range($iMinPrizeGroup, $iMaxPrizeGroup);
        if (Request::method() == 'PUT') {
            $iPrizeGroupId = $this->params['group_id'];
            $oPrizeGroup = PrizeGroup::find($iPrizeGroupId);
            if (!is_object($oPrizeGroup)) {
                return $this->goBack('error', __('_prizegroup.missing-data'));
            }
            if ($oPrizeGroup->classic_prize > $iMaxPrizeGroup || $oPrizeGroup->classic_prize < $iMinPrizeGroup) {
                return $this->goBack('error', __('_basic.not-allowed'));
            }
            DB::connection()->beginTransaction();
            $oUser->prize_group = $oPrizeGroup->classic_prize;
            $bSucc = $oUser->save();
            !$bSucc or $bSucc = UserPrizeSet::updateAgentPrizeGroup($oUser->id, $oPrizeGroup);
            if ($bSucc) {
                DB::connection()->commit();
                return $this->goBackToIndex('success', __('_basic.updated', $this->langVars));
            } else {
                DB::connection()->rollback();
                $this->langVars['reason'] = & $this->model->getValidationErrorString();
                return $this->goBack('error', __('_basic.update-fail', $this->langVars));
            }
        } else {
            // $table = Functionality::all();
            $parent_id = $this->model->parent_id;
            $data = $this->model;
            $isEdit = true;
            $this->setVars(compact('data', 'parent_id', 'isEdit', 'id', 'aPrizeGroups'));
            return $this->render();
        }
    }

}
