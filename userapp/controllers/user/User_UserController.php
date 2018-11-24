<?php

# 用户管理(代理用户才有)

class User_UserController extends UserBaseController {

    protected $resourceView = 'centerUser.user';
    protected $modelName = 'UserUser';

    protected function beforeRender() {
        parent::beforeRender();
        $iUserId = Session::get('user_id');
        switch ($this->action) {
            case 'index':
                // TODO 如果是二代，则需要递归计算他下面的用户
                $this->generateData();
                break;
            case 'personal':
                $data = UserUser::find($iUserId);
                // pr($data->email);exit;
                $this->setVars(compact('data'));
                break;
            // case 'userList':
            //     $aUsers = $this->generateUsers();
            //     $this->setVars(compact('aUsers'));
            case 'passwordManagement':
                $sFundPassword = User::find($iUserId)->fund_password;
                $bFundPasswordSetted = (int) ($sFundPassword != null);
                // pr($sFundPassword);
                // pr($bFundPasswordSetted);exit;
                $this->setVars(compact('bFundPasswordSetted'));
            case 'accurateCreate':
                $iUserId = Session::get('user_id');
                $aLotteriesPrizeSets = UserPrizeSet::generateLotteriesPrizeWithSeries($iUserId);
                $aMaxPrizeSets = CreateUserLink::$aDefaultMaxPrizeGroups[1]; // TODO 玩家和一代的最大奖金组范围一致, 先用一代的值
                $aCurrentPrizeGroups = $aLotteriesPrizeSets[0]['children'][0]; // TODO 链接开户的奖金组选择，页面设计里没有体现时时彩和乐透彩的区别，先用时时彩
                if ($aMaxPrizeSets['classic_prize'] < $aCurrentPrizeGroups['classic_prize']) {
                    // $iCurrentPrizeGroupId = $aMaxPrizeSets['group_id'];
                    $iCurrentPrizeGroup = $aMaxPrizeSets['prize_group'];
                    $iCurrentPrize = $aMaxPrizeSets['classic_prize'];
                } else {
                    // $iCurrentPrizeGroupId = $aCurrentPrizeGroups['group_id'];
                    $iCurrentPrizeGroup = $aCurrentPrizeGroups['prize_group'];
                    $iCurrentPrize = $aCurrentPrizeGroups['classic_prize'];
                }

                $iSeriesId = $aCurrentPrizeGroups['series_id']; // TODO 链接开户的奖金组选择，页面设计里没有体现时时彩和乐透彩的区别，先用时时彩
                // pr($iCurrentPrizeGroup);exit;
                // 获取低于当前代理的奖金组的可能的6个奖金组
                $oPossiblePrizeGroups = PrizeGroup::getPrizeGroupsBelowExistGroup($iCurrentPrizeGroup, $iSeriesId);
                $aDefaultMaxPrizeGroups = CreateUserLink::$aDefaultMaxPrizeGroups;
                $aDefaultPrizeGroups = CreateUserLink::$aDefaultPrizeGroups;
                // pr($aDefaultPrizeGroups);exit;
                $this->setVars(compact('oPossiblePrizeGroups', 'aLotteriesPrizeSets', 'iCurrentPrize', 'aDefaultPrizeGroups', 'aDefaultMaxPrizeGroups'));
                break;
            default:
                # code...
                break;
        }
    }

    /**
     * [getLoginUserMonetaryInfo ajax方式请求用户/代理可用余额，代理昨日销售额]
     * @return [Json] [用户/代理可用余额，代理昨日销售额]
     */
    public function getLoginUserMonetaryInfo() {
        $data = [];
        // TIP 关于只有登录用户才有权限访问的限制，已经在过滤器中做了处理，这里不再判断
        // if (! $iUserId = Session::get('user_id') ) {
        //     // $aRtn = [
        //     //     'success' => false,
        //     //     'data'    => '未登录用户',
        //     // ];
        //     // echo json_encode($aRtn);
        //     // exit;
        //     $data['msg'] = '未登录用户';
        //     $this->halt(false, 'info', null, $a, $a, $data);
        // }
        $iUserId = Session::get('user_id');
        if (Session::get('is_agent')) {
            $sDate = Carbon::yesterday()->toDateString();
            $oUserProfit = UserProfit::getUserProfitObject($sDate, $iUserId);
            $fTeamTurnOver = formatNumber($oUserProfit->team_turnover + 0, 2);
            $data['team_turnover'] = $fTeamTurnOver;
        }
        $fAvailable = formatNumber(Account::getAvaliable($iUserId), 2);
        $data['available'] = $fAvailable;
        // $aRtn['data'] = $data;
        // echo json_encode($data);
        // exit;
        $this->halt(true, 'info', null, $a, $a, $data);
    }

    public function index() {
        if (!Session::get('is_agent')) {
            return $this->goBack('error', __('_basic.agent-only', $this->langVars));
        }
        $this->params['parent_id'] = Session::get('user_id');
        return parent::index();
    }

    /**
     * 查询代理下级用户信息
     * @return type
     */
    public function subUsers($pid) {
        if (!isset($pid)) {
            $this->goBack('error', '_user.missing-parent_id');
        }
        $aUsers = User::getAllUsersBelongsToAgent(Session::get('user_id'));
        if (in_array($pid, $aUsers)) {
            $this->params['parent_id'] = $pid;
            $this->action='index';
            return parent::index();
        }else{
            $this->goBack('error', '_user.search-forbidden');
        }
    }

    /**
     * [generateData 生成用户数据]
     * @return [type] [description]
     */
    private function generateData() {
        $iAccountFrom = Input::get('account_from');
        $iAccountTo = Input::get('account_to');
        // TODO 有优化空间，目前是每次循环都查询团队余额，所属用户组，下级户数
        foreach ($this->viewVars['datas'] as $key => $oUser) {
            $iAccountSum = $oUser->getGroupAccountSum();
            if ($iAccountFrom && $iAccountSum < $iAccountFrom) {
                array_forget($this->viewVars['datas'], $key);
                continue;
            }
            if ($iAccountTo && $iAccountSum > $iAccountTo) {
                array_forget($this->viewVars['datas'], $key);
                continue;
            }
            $oUser->role_desc = $oUser->getUserRoleNames();
            $oUser->children_num = $oUser->getAgentDirectChildrenNum();
            $oUser->group_account_sum = number_format($iAccountSum, 4);
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

    /**
     * [resetPersonalInfo 重置用户个人信息]
     * @return [Response] [description]
     */
    private function resetPersonalInfo() {
        $iUserId = Session::get('user_id');
        $oUser = User::find($iUserId);
        $sNickname = trim(Input::get('nickname'));
        $oUser->nickname = $sNickname;
        $bSucc = $oUser->save(['nickname' => User::$rules['nickname']]);
        $sDesc = $bSucc ? __('_basic.updated', $this->langVars) : __('_basic.update-fail', $this->langVars);
        return $this->renderReturn($bSucc, $sDesc);
    }

    /**
     * [passwordManagement 密码管理，包括登录密码和资金密码的重置]
     * @param  [Int] $iType [0: 登录密码, 1: 资金密码]
     * @return [Response]        [description]
     */
    public function passwordManagement($iType = null) {
        // pr(Request::method());exit;
        if (Request::method() == 'PUT') {
            $iId = Session::get('user_id');
            switch ($iType) {
                case 1:
                    return $this->changeFundPassword($iId);
                    break;
                case 0:
                default:
                    return $this->changePassword($iId);
                    break;
            }
        } else {
            return $this->render();
        }
    }

    /**
     * [safeChangeFundPassword 第一次设置资金密码]
     * @return [Response] [description]
     */
    public function safeChangeFundPassword() {
        if (Request::method() == 'PUT') {
            $iId = Session::get('user_id');
            return $this->changeFundPassword($iId, true);
        } else {
            return $this->render();
        }
    }

    /**
     * [changePassword 改变用户密码]
     * @param  [Integer] $iId [用户id]
     * @return [Response]      [description]
     */
    private function changePassword($iId) {
        $sOldPassword = trim(Input::get('old_password'));
        $sNewPassword = trim(Input::get('password'));
        $sNewPasswordConfirmation = trim(Input::get('password_confirmation'));
        $this->model = $this->model->find($iId);
        $sOldPwd = md5(md5(md5($this->model->username . $sOldPassword)));
        if (!$this->model->checkPassword($sOldPassword)) {
            return $this->goBack('error', __('_user.validate-password-fail', $this->langVars));
        }
        if ($this->model->checkFundPassword($sNewPassword)) {
            return $this->goBack('error', __('_user.same-with-password'));
        }
        $aFormData = [
            'password' => $sNewPassword,
            'password_confirmation' => $sNewPasswordConfirmation,
        ];
        $aReturnMsg = $this->model->resetPassword($aFormData);
        $bSucc = $aReturnMsg['success'];
        if (!$bSucc)
            $this->langVars['reason'] = $aReturnMsg['msg'];
        // pr($aReturnMsg);exit;
        $sDesc = $bSucc ? __('_user.password-updated') : __('_user.update-password-fail', $this->langVars);
        return $this->renderReturn($bSucc, $sDesc);
    }

    /**
     * [changeFundPassword 改变用户资金密码]
     * @param  [Integer] $iId      [用户id]
     * @param  [boolean] $bIsFirst [是否初次设置]
     * @return [Response]            [description]
     */
    private function changeFundPassword($iId, $bIsFirst = false) {
        $sOldFundPassword = trim(Input::get('old_fund_password'));
        $sNewFundPassword = trim(Input::get('fund_password'));
        $sNewFundPasswordConfirmation = trim(Input::get('fund_password_confirmation'));
        $this->model = $this->model->find($iId);
        if (!$bIsFirst && $sOldFundPassword) {
            if (!$this->model->checkFundPassword($sOldFundPassword)) {
                return $this->goBack('error', __('_user.fund-password-check-fail', $this->langVars));
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
        $bSucc = $aReturnMsg['success'];
        if (!$bSucc)
            $this->langVars['reason'] = $aReturnMsg['msg'];
        // pr($bSucc);
        // pr($this->model->getValidationErrorString());exit;
        // pr($this->langVars);exit;
        $sDesc = $bSucc ? __('_user.fund-password-updated') : __('_user.update-fund-password-fail', $this->langVars);
        return $this->renderReturn($bSucc, $sDesc);
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
            return $this->goBack('error', $sDesc, true);
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
                $sDesc = __('_basic.created', $this->langVars);
                return $this->renderReturn('success', $sDesc);
            }
            // 如果不是总代，强制只能开玩家
            //Session::get('is_top_agent') or $this->params['is_agent'] = 0;
            // 验证用户名是否存在
            $this->validateUsernameExist();

            $data = trimArray(Input::except(['_token', '_random']));

            $iPrizeGroupType = trim(Input::get('prize_group_type'));
            $iPrizeGroupId = trim(Input::get('prize_group_id'));
            $sLotteryPrizeJson = trim(Input::get('lottery_prize_group_json'));
            $sSeriesPrizeJson = trim(Input::get('series_prize_group_json'));
            // pr($iPrizeGroupType);
            // pr($iPrizeGroupId);
            // pr($sLotteryPrizeJson);
            // pr($sSeriesPrizeJson);
            // pr($this->params['is_agent']);
            // exit;
            $iAgentId = Session::get('user_id');
            $oUserCreateUserLink = new UserCreateUserLink;
            $aPrizeGroup = json_decode($oUserCreateUserLink->generateUserPrizeSetJson($this->params['is_agent'], $iPrizeGroupType, $iPrizeGroupId, $sLotteryPrizeJson, $sSeriesPrizeJson, $iAgentId));
            if (!$aPrizeGroup) {
                return $this->goBack('error', __('_basic.no-available-prize-group', $this->langVars));
            }
            $sPrizeGroup = $this->params['is_agent'] ? $aPrizeGroup[0]->prize_group : '';
            // pr($data);exit;

            $oAgent = User::find($iAgentId);
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
            DB::connection()->beginTransaction();
            $bSucc = $this->createProcess($oUser, $aPrizeGroup);
            // pr($bSucc);exit;
            if ($bSucc) {
                DB::connection()->commit();
                $sDesc = __('_basic.created', $this->langVars);
                return $this->renderReturn('success', $sDesc);
            } else {
                DB::connection()->rollback();
                $this->langVars['reason'] = & $this->model->getValidationErrorString();
                $sDesc = __('_basic.create-fail', $this->langVars);
                return $this->renderReturn('error', $sDesc);
            }
        } else {
            return $this->render();
        }
    }

    /**
     * [validateUsernameExist 验证用户名是否存在]
     * @return [Response/Boolean] [视图响应/true: 不存在]
     */
    private function validateUsernameExist() {
        $sUsername = trim(Input::get('username'));
        // $sPassword = trim(Input::get('password'));
        if (User::checkUsernameExist($sUsername)) {
            return Redirect::back()
                            ->withInput()
                            ->withErrors(['attempt' => __('_basic.username-exist')]);
            // ->with('error', __('_basic.signup-username-exist'));
        }
        return true;
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
}
