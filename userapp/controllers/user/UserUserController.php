<?php

/**
 * 用户管理(代理用户才有)
 */
class UserUserController extends UserBaseController {

    protected $resourceView = 'centerUser.user';
    protected $modelName = 'UserUser';

    protected function beforeRender() {
        parent::beforeRender();
        $iUserId = Session::get('user_id');
        switch ($this->action) {
            case 'index':
                $this->generateData();
                break;
            case 'personal':
                $oUser = UserUser::find($iUserId);
                $this->setVars(compact('oUser'));
                break;
            case 'user':
                $oUser = UserUser::find($iUserId);
                $aQuota = UserPrizeSetQuota::getUserAllPrizeSetQuota($iUserId);
                $aUserPrizeSet = UserPrizeSet::getUserLotteriesPrizeSets($iUserId);
                $iUserBankCardCount = UserUserBankCard::getUserBankCardsCount($iUserId);
                $iAvailableHBCount = ActivityUserPrize::getAvailableHBCount($iUserId);
                $iReceivedHBCount = ActivityUserPrize::getReceivedHBCount($iUserId);
                $oAccount = Account::find($oUser->account_id);
                $fWithdrawable = $oAccount->getWithdrawableAmount();
                $oLotteriesPrizeSets = UserUserPrizeSet::getUserLotteriesPrizeSets($iUserId);
                $fAvailableHBTotalAmount = ActivityUserPrize::getAvailableHBTotalAmount($iUserId);
                $this->setVars(compact('oUser', 'oAccount', 'fWithdrawable', 'aQuota', 'iUserBankCardCount', 'iReceivedHBCount', 'iAvailableHBCount', 'oLotteriesPrizeSets', 'fAvailableHBTotalAmount'));
                break;
            case 'bindEmail':
                $data = UserUser::find($iUserId);
                // pr($data->email);exit;
                $this->setVars(compact('data'));
                break;
            // case 'userList':
            //     $aUsers = $this->generateUsers();
            //     $this->setVars(compact('aUsers'));
            case 'changePassword':
            case 'changeFundPassword':
            case 'safeChangeFundPassword':
                $oUser = UserUser::find($iUserId);
                $sFundPassword = UserUser::find($iUserId)->fund_password;
                $bFundPasswordSetted = (int) ($sFundPassword != null);
                $this->setVars(compact('bFundPasswordSetted', 'oUser'));
                break;
            case 'accurateCreate':
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
                    $iCurrentPrize = $aCurrentPrizeGroups['classic_prize'];
                    $bInclude = false;
                }
                $iPlayerMinPrizeGroup = Sysconfig::readValue('player_min_grize_group');
                // 获取低于当前代理奖金组的玩家可能的6个奖金组
                $oPossiblePrizeGroups = PrizeGroup::getPrizeGroupsBelowExistGroup($iCurrentPrize, $iSeriesId, 8, $iPlayerMinPrizeGroup, 'desc', $bInclude);
                $oAllPossiblePrizeGroups = PrizeGroup::getPrizeGroupsBelowExistGroup($iCurrentPrize, $iSeriesId, null, $iPlayerMinPrizeGroup, 'asc', 0);
                // 如果是总代开户，获取代理的奖金组范围
                $oPossibleAgentPrizeGroups = [];
                $iAgentMinPrizeGroup = Sysconfig::readValue('agent_min_grize_group');
                //if (Session::get('is_top_agent')) {
                if (Session::get('is_agent')) {
                    $iAgentMaxPrizeGroup = Sysconfig::readValue('agent_max_grize_group');
                    $aCurrentPrizeGroups = $aLotteriesPrizeSets[0]['children'][0];              // TODO 链接开户的奖金组选择，页面设计里没有体现时时彩和乐透彩的区别，先用时时彩
                    if ($iAgentMaxPrizeGroup < $aCurrentPrizeGroups['classic_prize']) {
                        $iAgentCurrentPrize = $iAgentMaxPrizeGroup;
                    } else {
                        $iAgentCurrentPrize = $aCurrentPrizeGroups['classic_prize'];
                    }
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

    /**
     * [getLoginUserMonetaryInfo ajax方式请求用户/代理可用余额，代理昨日销售额]
     * @return [Json] [用户/代理可用余额，代理昨日销售额]
     */
    public function getLoginUserMonetaryInfo() {
        $data = [];
        $iUserId = Session::get('user_id');
//        if (Session::get('is_agent')) {
//            $sDate = Carbon::yesterday()->toDateString();
//            $oUserProfit = UserProfit::getUserProfitObject($sDate, $iUserId);
//            $fTeamTurnOver = formatNumber($oUserProfit->team_turnover + 0, 2);
//            $data['team_turnover'] = $fTeamTurnOver;
//        }
        $fAvailable = formatNumber(Account::getAvaliable($iUserId), 2);
        $data['available'] = $fAvailable;
        $this->halt(true, 'info', null, $a, $a, $data);
    }

    public function index() {
        // TIP 已经在路由中过滤只有代理能访问
        // if (!Session::get('is_agent')) {
        //     return $this->goBack('error', __('_basic.agent-only', $this->langVars));
        // }
        $this->params['parent_id'] = Session::get('user_id');
        return parent::index();
    }

    /**
     * 查询代理下级用户信息
     * @return type
     */
    public function subUsers($pid) {
        if (!isset($pid)) {
            return $this->goBack('error', '_user.missing-parent_id');
        }
        $iUserId = Session::get('user_id');
        $oUser = User::find($pid);
        $this->setVars(compact('oUser'));
        $aUsers = UserUser::getAllUsersBelongsToAgent($iUserId);
        if (in_array($pid, $aUsers) || $pid == $iUserId) {
            $this->params['parent_id'] = $pid;
            $this->action = 'index';
            return parent::index();
        } else {
            return $this->goBack('error', '_user.search-forbidden');
        }
    }

    /**
     * [generateData 生成用户数据]
     * @return [type] [description]
     */
    public function generateData() {
        $iGroupAccountFrom = Input::get('group_account_from');
        $iGroupAccountTo = Input::get('group_account_to');
        $iAccountFrom = Input::get('account_from');
        $iAccountTo = Input::get('account_to');
        // TODO 有优化空间，目前是每次循环都查询团队余额，所属用户组，下级户数
        foreach ($this->viewVars['datas'] as $key => $oUser) {
            $fGroupAccountSum = $oUser->getGroupAccountSum();
            $fAccount = $oUser->getUserAccount();
            if ($iGroupAccountFrom && $fGroupAccountSum < $iGroupAccountFrom) {
                array_forget($this->viewVars['datas'], $key);
                continue;
            }
            if ($iGroupAccountTo && $fGroupAccountSum > $iGroupAccountTo) {
                array_forget($this->viewVars['datas'], $key);
                continue;
            }
            if ($iAccountFrom && $fAccount < $iAccountFrom) {
                array_forget($this->viewVars['datas'], $key);
                continue;
            }
            if ($iAccountTo && $fAccount > $iAccountTo) {
                array_forget($this->viewVars['datas'], $key);
                continue;
            }
            // $oUser->role_desc = $oUser->getUserRoleNames();
            $oUser->children_num = $oUser->getAgentDirectChildrenNum();
            $oUser->user_account = number_format($fAccount, 2);
            $oUser->group_account_sum = number_format($fGroupAccountSum, 2);
            // pr($oUser->toArray());exit;
        }
    }

    // public function userList()
    // {
    //     if (!Session::get('is_agent')) {
    //         return $this->goBack('error', __('_basic.agent-only', $this->langVars));
    //     }
    //     return $this->render();
    // }
    // private function generateUsers()
    // {
    //     $iAgentId = Session::get('user_id');
    //     $aUsers   = User::getUsersBelongsToAgent($iAgentId);
    //     foreach ($aUsers as $oUser) {
    //         $oUser->role_desc         = $oUser->getUserRoleNames();
    //         $oUser->children_num      = $oUser->getAgentDirectChildrenNum();
    //         $oUser->group_account_sum = $oUser->getGroupAccountSum();
    //     }
    //     // pr($aUsers->toArray());
    //     // exit;
    //     return $aUsers;
    // }


    public function personal() {
        if (Request::method() == 'PUT') {
            return $this->resetPersonalInfo();
        } else {
            return $this->render();
        }
    }

    public function portrait() {
        if (Request::method() == 'POST') {
            $iPortrait = array_get($this->params, 'portrait');
            if (!$iPortrait || !in_array($iPortrait, [1, 2, 3, 4, 5, 6])) {
                return json_encode(['msgType' => 'error']);
            }
            $oUser = UserUser::find(Session::get('user_id'));
            $bSucc = $oUser->update(['portrait_code' => $iPortrait]);
            if ($bSucc) {
                Session::set('portraitCode', $oUser->portrait_code);
                return json_encode(['msgType' => 'success']);
            } else {
                return json_encode(['msgType' => 'error']);
            }
        } else {
            return $this->render();
        }
    }

    public function user() {
        if (Request::method() == 'PUT') {
            return $this->resetPersonalInfo();
        } else {
            Session::put($this->redictKey, Request::fullUrl());
            return $this->render();
        }
    }

    /**
     * [resetPersonalInfo 重置用户个人信息]
     * @return [Response] [description]
     */
    private function resetPersonalInfo() {
        $iUserId = Session::get('user_id');
        $oUser = UserUser::find($iUserId);
        $sNickname = trim(Input::get('nickname'));
        // $oUser->nickname = $sNickname;
        $bSucc = $oUser->update(['nickname' => $sNickname]); // User::$rules['nickname']
        $sErrorMsg = & $oUser->getValidationErrorString();
        $sDesc = $bSucc ? '用户昵称更新成功！' : $sErrorMsg;
        if ($bSucc) {
            $oUser->nickname = $sNickname;
            Session::set('nickname', $oUser->nickname);
        }
        return $this->renderReturn($bSucc, $sDesc);
    }

    /**
     * [safeChangeFundPassword 第一次设置资金密码]
     * @return [Response] [description]
     */
    public function safeChangeFundPassword($isWin = false) {
        if (Request::method() == 'PUT') {
            $iId = Session::get('user_id');
            return $this->changeFundPassword($iId, true);
        } else {
            if ($isWin) {
                $this->view = $this->resourceView . '.safeChangeWinPassword';
            }

            $this->setVars('isWin', $isWin);
            return $this->render();
        }
    }

    /**
     * [changePassword 改变用户密码]
     * @return [Response]      [description]
     */
    public function changePassword() {
        if (Request::method() == 'PUT') {
            $sOldPassword = trim(Input::get('old_password'));
            $sNewPassword = trim(Input::get('password'));
            $sNewPasswordConfirmation = trim(Input::get('password_confirmation'));
            $this->model = $this->model->find(Session::get('user_id'));
            $sOldPwd = md5(md5(md5($this->model->username . $sOldPassword)));
            if (!$this->model->checkPassword($sOldPassword)) {
                return $this->goBack('error', __('_user.validate-password-fail'));
            }
            if ($this->model->checkFundPassword($sNewPassword)) {
                return $this->goBack('error', __('_user.same-with-fund-password'));
            }
            $aFormData = [
                'password' => $sNewPassword,
                'password_confirmation' => $sNewPasswordConfirmation,
            ];
            $aReturnMsg = $this->model->resetPassword($aFormData);
            if (!$bSucc = $aReturnMsg['success']) {
                $this->langVars['reason'] = $aReturnMsg['msg'];
            }
            // pr($aReturnMsg);exit;
            $sDesc = $bSucc ? __('_user.password-updated') : __('_user.update-password-fail', $this->langVars);
            return $this->renderReturn($bSucc, $sDesc);
        } else {
            $this->saveUrlToSession();
            return $this->render();
        }
    }

    /**
     * [changeFundPassword 改变用户资金密码]
     * @param  [boolean] $bIsFirst [是否初次设置]
     * @return [Response]            [description]
     */
    public function changeFundPassword($bIsFirst = false) {
        if (Request::method() == 'PUT') {
            $sOldFundPassword = trim(Input::get('old_fund_password'));
            $sNewFundPassword = trim(Input::get('fund_password'));
            $sNewFundPasswordConfirmation = trim(Input::get('fund_password_confirmation'));
            $this->model = $this->model->find(Session::get('user_id'));
            if (!$bIsFirst && $sOldFundPassword) {
                if (!$this->model->checkFundPassword($sOldFundPassword)) {
                    return $this->goBack('error', __('_user.validate-fund-password-fail'));
                }
            }
            if ($this->model->checkPassword($sNewFundPassword)) {
                return $this->goBack('error', __('_user.same-with-password'));
            }
            $aFormData = [
                'fund_password' => $sNewFundPassword,
                'fund_password_confirmation' => $sNewFundPasswordConfirmation,
            ];
            $aReturnMsg = $this->model->resetFundPassword($aFormData);
            if (!$bSucc = $aReturnMsg['success']) {
                $this->langVars['reason'] = $aReturnMsg['msg'];
            }
            // pr($bSucc);
            // pr($this->model->getValidationErrorString());exit;
            // pr($this->langVars);exit;
            if ($bSucc) {
                $sUrl = $this->getUrlFromSession();
                return Redirect::to($sUrl)->with('success', __('_user.fund-password-updated'));
            } else {
                return $this->goBack('error', __('_user.update-fund-password-fail', $this->langVars));
            }
        } else {
            $this->saveUrlToSession();
            return $this->render();
        }
    }

    /**
     * [renderReturn 响应函数]
     * @param  [Boolean] $bSucc [是否成功]
     * @param  [String] $sDesc [响应描述]
     * @return [Response]        [响应]
     */
    public function renderReturn($bSucc, $sDesc) {
        // pr($this->model->validationErrors);exit;
        if ($bSucc) {
            return $this->goBack('success', $sDesc);
        } else {
            return $this->goBack('error', $sDesc);
        }
    }

    /**
     * [accurateCreate 精准开户
     *         注册流程:
     *            1. 判断随机码是否正确
     *            2. 判断是否代理用户(一代只能开玩家用户)
     *            3. 判断用户名是否已经存在
     *            4. 获取开户奖金组信息
     *            5. 生成用户信息
     *            6. 新建用户
     *            7. 新建用户的账户
     *            8. 更新用户的account_id字段
     *            9. 创建用户奖金组
     * ]
     * @return [Response] [description]
     */
    public function accurateCreate() {
        if (Request::method() == 'POST') {
            // 先验证随机码
            $aRandom = explode('_', trim(Input::get('_random')));
            if ($aRandom[1] != Session::get($aRandom[0])) {
                return Redirect::back()
                                ->withInput()
                                // ->withErrors(['attempt' => __('_basic.signup-fail')]);
                                ->with('error', '注册失败！');
            }
            // 只有代理才能开户
            if (!Session::get('is_agent')) {
                $sDesc = __('_basic.no-rights', $this->langVars);
                return $this->renderReturn(false, $sDesc);
            }
            if (Session::get('is_top_agent') && array_get($this->params, 'is_agent') == 0) {
                $sDesc = __('_basic.no-rights', $this->langVars);
                return $this->renderReturn(false, $sDesc);
            }
            // 如果不是总代，强制只能开玩家
            //Session::get('is_top_agent') or $this->params['is_agent'] = 0;
            // 验证用户名是否存在
            if ($this->validateUsernameExist($sErrorMsg)) {
                return $this->renderReturn(false, $sErrorMsg);
            }
            // if ($this->validateEmailExist($sErrorMsg)) {
            //     return $this->renderReturn(false, $sErrorMsg);
            // }

            $data = trimArray(Input::except(['_token', '_random']));

            $iPrizeGroupType = trim(Input::get('prize_group_type'));
            $iPrizeGroupId = trim(Input::get('prize_group_id'));
            $sLotteryPrizeJson = trim(Input::get('lottery_prize_group_json'));
            $sSeriesPrizeJson = trim(Input::get('series_prize_group_json'));
            $aPrizeSetQuota = objectToArray(json_decode(trim(Input::get('agent_prize_set_quota'))));
            // pr($iPrizeGroupType);
            // pr($iPrizeGroupId);
            // pr($sLotteryPrizeJson);
            // pr($sSeriesPrizeJson);
            // pr($this->params['is_agent']);
            // exit;
            $iAgentId = Session::get('user_id');
            $oUserRegisterLink = new UserRegisterLink;
            $aPrizeGroup = json_decode($oUserRegisterLink->generateUserPrizeSetJson($this->params['is_agent'], $iPrizeGroupType, $iPrizeGroupId, $sLotteryPrizeJson, $sSeriesPrizeJson, $iAgentId));
            if (!$aPrizeGroup) {
                return $this->goBack('error', __('_userprizeset.no-available-prize-group'));
            }
            $sPrizeGroup = $this->params['is_agent'] ? $aPrizeGroup[0]->prize_group : '';
            // pr($data);exit;

            $oAgent = UserUser::find($iAgentId);
            $aExtraData = [
                'parent_id' => $iAgentId,
                'parent' => Session::get('username'),
                'is_tester' => $oAgent->is_tester
            ];
            $data = array_merge($data, $aExtraData);
            $oUser = $this->model;
            $aReturnMsg = $oUser->generateUserInfo($sPrizeGroup, $data);
            // pr($oUser->toArray());
            // pr($bSucc);exit;
            if (!$aReturnMsg['success']) {
                return Redirect::back()
                                ->withInput()
                                // ->withErrors(['attempt' => __('_basic.signup-fail')]);
                                ->with('error', $aReturnMsg['msg']);
            }
            if (false && $this->params['is_agent'] && $oUser->prize_group >= 1950) {
                //检验当前开户者是否有开户配额
                $bSucc2 = UserPrizeSetQuota::checkQuota([$oUser->prize_group => 1], $iAgentId);
                if (array_get($aPrizeSetQuota, $oUser->prize_group) !== null) {
                    $aPrizeSetQuota[$oUser->prize_group] ++;
                }
                //检验开户配额是否符合要求
                !$bSucc2 or $bSucc2 = UserPrizeSetQuota::checkQuota($aPrizeSetQuota, $iAgentId);
                // pr($bSucc);
                if (!$bSucc2) {
                    $sReason = '配额不足！';
                    return Redirect::back()
                                    ->withInput()
                                    // ->withErrors(['attempt' => __('_basic.signup-fail')]);
                                    ->with('error', '注册失败！' . $sReason);
                }
                if (array_get($aPrizeSetQuota, $oUser->prize_group) !== null) {
                    $aPrizeSetQuota[$oUser->prize_group] --;
                }
            }
            $oUser->is_from_link = 0;
            DB::connection()->beginTransaction();
            $bSucc = $this->createProcess($oUser, $aPrizeGroup);
            if ($this->params['is_agent'] && $oUser->prize_group >= 1950) {
                !$bSucc or $bSucc = UserPrizeSetQuota::updateUserPrizeSetQuota($aExtraData['parent_id'], $aPrizeSetQuota);
                !$bSucc or $bSucc = UserPrizeSetQuota::updateUserPrizeSetQuota($aExtraData['parent_id'], [$oUser->prize_group => 1]);
                !$bSucc or $bSucc = UserPrizeSetQuota::insertUserPrizeSetQuota($oUser, $aPrizeSetQuota);
            }
            // pr($bSucc);exit;
            if ($bSucc) {
                DB::connection()->commit();
                $sDesc = __('_basic.created', $this->langVars);
//                BaseTask::addTask('EventTaskQueue', ['event' => 'ds.auth.regist', 'user_id' => $oUser->id, 'data' => []], 'activity');
                return $this->renderReturn(true, $sDesc);
            } else {
                DB::connection()->rollback();
                $sErrorMsg = & $this->model->getValidationErrorString();
                // $this->langVars['reason'] = $sErrorMsg;
                return $this->renderReturn(false, $sErrorMsg);
            }
        } else {
            $this->render();
        }
    }

    /**
     * [validateUsernameExist 验证用户名是否存在]
     * @return [Boolean] [true: 存在, false: 不存在]
     */
    private function validateUsernameExist(& $sErrorMsg) {
        $sUsername = trim(Input::get('username'));
        if (!$sUsername) {
            $sErrorMsg = '请填写用户名！';
            return true;
        } else if (UserUser::checkUsernameExist($sUsername)) {
            $sErrorMsg = '该用户名已被注册，请重新输入！';
            return true;
        }
        return false;
    }

    /**
     * [validateEmailExist 验证邮箱是否存在]
     * @return [Boolean] [true: 存在, false: 不存在]
     */
    private function validateEmailExist(& $sErrorMsg) {
        $sEmail = trim(Input::get('email'));
        // $sPassword = trim(Input::get('password'));
        if (!$sEmail) {
            $sErrorMsg = '请填写邮箱！';
            return true;
        } else if (UserUser::checkEmailExist($sEmail)) {
            $sErrorMsg = '该邮箱已被注册，请重新输入！';
            return true;
        }
        return false;
    }

    /**
     * [createProcess 精准开户流程]
     * @return [Boolean] [开户是否成功]
     */

    /**
     * [createProcess 精准开户流程]
     * @param  [Object] $oUser       [用户对象]
     * @param  [Array] $aPrizeGroup  [奖金组数据]
     * @return [Boolean]             [开户成功/失败]
     */
    protected function createProcess($oUser, $aPrizeGroup) {
        // $bSucc = false;
        // $aRules = User::$rules;
        // $aRules['username'] = str_replace('{:id}', '', $aRules['username']);
        if ($bSucc = $oUser->save()) {
            $oAccount = $oUser->generateAccountInfo();
            if ($bSucc = $oAccount->save()) {
                // pr($bSucc);exit;
                // $aRules = User::$rules;
                // $aRules['username'] = str_replace('{:id}', $oUser->id, $aRules['username'] );
                $oUser->account_id = $oAccount->id;
                // $bSucc = $oUser->save($aRules);
                if ($bSucc = $oUser->save()) {
                    // pr($bSucc);exit;
                    $aReturnMsg = UserPrizeSet::createUserPrizeGroup($oUser, $aPrizeGroup);
                    $bSucc = $aReturnMsg['success'];
                }
            }
        }
        // pr($oUser->validationErrors->toArray());exit;
        return $bSucc;
    }

    /**
     * [createUserPrizeGroup 创建用户奖金组]
     * @param  [Object] $oUser      [新建的用户对象]
     * @param  [Array] $aPrizeGroup [奖金组数组]
     * @return [Boolean]            [是否成功]
     */
    // private function createUserPrizeGroup($oUser, $aPrizeGroup)
    // {
    //     $aLotteryPrizeGroups = $oUser->generateLotteryPrizeGroup($aPrizeGroup);
    //     $aUserPrizeGroups    = $oUser->generateUserPrizeGroups($aLotteryPrizeGroups);
    //     foreach($aUserPrizeGroups as $value) {
    //         $oUserPrizeSet = new UserPrizeSet;
    //         $oUserPrizeSet->fill($value);
    //         $bSucc = $oUserPrizeSet->save();
    //         if (! $bSucc) break;
    //     }
    //     return $bSucc;
    // }

    /**
     * 绑定用户邮箱
     *
     * @return RedirectResponse|Response
     */
    public function bindEmail() {
        if (Request::method() == 'PUT') {
            return $this->bindEmailSave();
        }
        //申请绑定邮箱
        else {
            return $this->render();
        }
    }

    /**
     * 保存邮箱信息并给用户发送确认邮件
     *
     * @return RedirectResponse
     */
    private function bindEmailSave() {
        $user_id = Session::get('user_id');
        $email = trim(Input::get('email'));

        $user = UserUser::find($user_id);

        if (!$user->isActivated()) {
            //邮箱已被绑定
            if (User::checkEmailExist($email)) {
                return $this->goBack('error', '您的邮箱已被绑定，请重新输入邮箱！');
            }

            $user->email = $email;
            $user->save();

            //给用户发送一封激活邮件
            $user->sendActivateMail();

            return $this->goBack('success', '链接已发送，24小时之内有效，请从邮箱激活！');
        }

        return $this->goBack('success', '您已绑定邮箱，无需重复绑定！');
    }

    /**
     * 激活邮箱
     *
     * @return RedirectResponse
     */
    public function activateEmail() {
        $user_id = trim(Input::get('u'));
        $code = trim(Input::get('c'));
        $suser_id = Session::get('user_id');

        //如果用户返回的信息有效，则成功
        $this->viewVars['msg'] = [
            0 => ['class' => 'alert-error', 'backUrl' => route('users.personal'), 'backMsg' => '重新绑定', 'msg' => '验证失败，邮件激活链接无效或已过期。'],
            1 => ['class' => 'alert-success', 'backUrl' => route('home'), 'backMsg' => '返回首页', 'msg' => '恭喜您，邮箱验证成功。'],
        ];

        $this->viewVars['state'] = 0;

        //登陆的用户需要一直才行
        if ($suser_id == $user_id && Cache::section('bindEmail')->get($user_id) == $code) {
            $this->viewVars['state'] = 1;
            //更新用户绑定时间，清空cache
            $user = UserUser::find($user_id);
            $user->activated_at = Carbon::now()->toDateTimeString();
            $user->save();

            Cache::section('bindEmail')->forget($user_id);
        }

        return $this->render();
    }

}
