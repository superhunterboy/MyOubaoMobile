<?php

/**
 * 用户管理(代理用户才有)
 */
class MobileH5UserController extends UserUserController {

    protected $resourceView = 'user';

    /**
     * 获取用户可用余额信息
     */
    public function getUserAccountInfo() {
        $data = [];
        $iUserId = Session::get('user_id');
        $fAvailable = formatNumber(Account::getAvaliable($iUserId), 2);
        $data['available'] = $fAvailable;
        $this->halt(true, 'info', null, $a, $a, $data);
    }

    /**
     * 查询代理下级用户信息
     * @return type
     */
    public function subUsers($pid) {
        if (!isset($pid)) {
            $this->goBack('error', '_user.missing-parent_id');
        }
        $aUsers = UserUser::getAllUsersBelongsToAgent(Session::get('user_id'));
        if (in_array($pid, $aUsers)) {
            $this->params['parent_id'] = $pid;
            $this->action = 'index';
            return parent::index();
        } else {
            $this->goBack('error', '_user.search-forbidden');
        }
    }

    /**
     * [generateData 生成用户数据]
     * @return [type] [description]
     */
    public function generateData() {
//        $iAccountFrom = Input::get('account_from');
//        $iAccountTo = Input::get('account_to');
//        // TODO 有优化空间，目前是每次循环都查询团队余额，所属用户组，下级户数
//        foreach ($this->viewVars['datas'] as $key => $oUser) {
//            $iAccountSum = $oUser->getGroupAccountSum();
//            if ($iAccountFrom && $iAccountSum < $iAccountFrom) {
//                array_forget($this->viewVars['datas'], $key);
//                continue;
//            }
//            if ($iAccountTo && $iAccountSum > $iAccountTo) {
//                array_forget($this->viewVars['datas'], $key);
//                continue;
//            }
//            // $oUser->role_desc = $oUser->getUserRoleNames();
//            $oUser->children_num = $oUser->getAgentDirectChildrenNum();
//            $oUser->group_account_sum = number_format($iAccountSum, 4);
//            // pr($oUser->toArray());exit;
//        }
    }

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
    public function resetPersonalInfo() {
        $iUserId = Session::get('user_id');
        $oUser = UserUser::find($iUserId);
        $sNickname = trim(Input::get('nickname'));
        // $oUser->nickname = $sNickname;
        $bSucc = $oUser->update(['nickname' => $sNickname]); // User::$rules['nickname']
        $sErrorMsg = & $oUser->getValidationErrorString();
        $sDesc = $bSucc ? '用户昵称更新成功！' : $sErrorMsg;
        return $this->renderReturn($bSucc, $sDesc);
    }

    /**
     * [passwordManagement 密码管理，包括登录密码和资金密码的重置]
     * @param  [Int] $iType [0: 登录密码, 1: 资金密码]
     * @return [Response]        [description]
     */
    public function passwordManagement($iType = null) {
        $iId = Session::get('user_id');
        switch ($iType) {
            case 1:
                return $this->changeFundPassword();
                break;
            case 0:
            default:
                return $this->changePassword();
                break;
        }
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
                $this->view = $this->resourceView . '.safeChangeFundPassword';
            }

            $this->setVars('isWin', $isWin);
            return $this->render();
        }
    }

    /**
     * [changePassword 改变用户密码]
     * @param  [Integer] $iId [用户id]
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
     * @param  [Integer] $iId      [用户id]
     * @param  [boolean] $bIsFirst [是否初次设置]
     * @return [Response]            [description]
     */
    public function changeFundPassword($bIsFirst = false) {
        if (Request::method() == 'PUT') {
            $sOldFundPassword = trim(Input::get('old_fund_password'));
            $sNewFundPassword = trim(Input::get('fund_password'));
            $sNewFundPasswordConfirmation = trim(Input::get('fund_password_confirmation'));
            $this->model = $this->model->find(Session::get('user_id'));
            if (!$bIsFirst) {
                if (!$this->model->checkFundPassword($sOldFundPassword)) {
                    return $this->goBack('error', __('_user.validate-fund-password-fail'));
                }
            }
            if (empty($sNewFundPassword) || empty($sNewFundPasswordConfirmation)) {
            	return $this->goBack('error', '请正确输入资金密码');
	        }
	        if ($sNewFundPassword != $sNewFundPasswordConfirmation) {
	            return $this->goBack('error', '两次输入的资金密码不一致');
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
            if (!$this->model->find(Session::get('user_id'))->fund_password) {
	            $this->view = $this->resourceView . '.safeChangeFundPassword';
	        }
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
            // 如果不是总代，强制只能开玩家
            Session::get('is_top_agent') or $this->params['is_agent'] = 0;
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
                'is_tester' => $oAgent->is_tester,
                'register_at' => Carbon::now()->toDateTimeString(),
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
            $oUser->is_from_link = 0;
            DB::connection()->beginTransaction();
            $bSucc = $this->createProcess($oUser, $aPrizeGroup);
            // pr($bSucc);exit;
            if ($bSucc) {
                DB::connection()->commit();
//                Queue::push('EventTaskQueue', ['event'=>'bomao.auth.register', 'user_id'=>$oUser->id, 'data' => []], 'activity');
                file_put_contents('/tmp/event.log', 'accurate create');
                $sDesc = __('_basic.created', $this->langVars);
                return $this->renderReturn(true, $sDesc);
            } else {
                DB::connection()->rollback();
                $sErrorMsg = & $this->model->getValidationErrorString();
                // $this->langVars['reason'] = $sErrorMsg;
                return $this->renderReturn(false, $sErrorMsg);
            }
        } else {
            return $this->render();
        }
    }

    /**
     * [validateUsernameExist 验证用户名是否存在]
     * @return [Boolean] [true: 存在, false: 不存在]
     */
    public function validateUsernameExist(& $sErrorMsg) {
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
    public function validateEmailExist(& $sErrorMsg) {
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
    // public function createUserPrizeGroup($oUser, $aPrizeGroup)
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
    public function bindEmailSave() {
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
//            $user->sendActivateMail();
//            Queue::push('EventTaskQueue', ['event'=>'bomao.info.lockEmail', 'user_id'=>$user_id, 'data' => []], 'activity');
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

        //登录的用户需要一直才行
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

    public function index() {
    
        $this->view = 'user';
        $fAmount = number_format(Account::getAvaliable(Session::get('user_id')), 2);
        $oProfit = UserProfit::getUserProfitObject(date('Y-m-d'), Session::get('user_id'));
        if (is_object($oProfit)) {
            $fProfit = $oProfit->profit == null ? 0 : $oProfit->profit;
        } else {
            $fProfit = 0.00;
        }
        $oUser = UserUser::find(Session::get('user_id'));
        $fProfit = number_format($fProfit, 2);
        $iMsgCount = UserMessage::getUserUnreadMessagesNum();
        $this->setVars(compact('fProfit', 'fAmount', 'oUser', 'iMsgCount'));
        return $this->render();
    }

    /**
     * [getLoginUserMonetaryInfo ajax方式请求用户/代理可用余额，代理昨日销售额]
     * @return [Json] [用户/代理可用余额，代理昨日销售额]
     */
    public function getLoginUserMonetaryInfo() {
        $data = [];
        $iUserId = Session::get('user_id');
        $fAvailable = formatNumber(Account::getAvaliable($iUserId), 2);
        $oProfit = UserProfit::getUserProfitObject(date('Y-m-d'), $iUserId);
        if (is_object($oProfit)) {
            $fProfit = $oProfit->profit == null ? 0 : $oProfit->profit;
        } else {
            $fProfit = 0.00;
        }
        $data['available'] = number_format($fAvailable, 2);;
        $data['profit'] = number_format($fProfit, 2);
        $this->halt(true, 'info', null, $a, $a, $data);
    }
    
    public function teamHome() 
    {
        $iUserId = Session::get('user_id');
        $sBeginDate = date('Y-m-d');
        $sStartTime = date('Y-m-d 00:00:00');
        $sEndTime = date('Y-m-d 23:59:59');
        $aUserIds = User::getAllUsersBelongsToAgent($iUserId);	//获取所有下级的id
        $iSubUserCount = count($aUserIds);
        array_unshift($aUserIds, $iUserId);
        $iRegistUserCount = User::getRegisterNums($iUserId, $sStartTime);
        $iTeamOnlineCount = UserOnline::getTeamOnlineUsers($aUserIds);
        //$aTeamBets = UserProject::getTeamBetsByDate($iUserId,$sStartTime,$sEndTime);
        //$aTeamDeposit = Deposit::getTeamDepositsByDate($aUserIds, $sStartTime, $sEndTime) ;
        $iTeamTodayBetUsers = UserProject::getTeamBetUsers($aUserIds,$sStartTime,$sEndTime);
        $iTeamHistoryBetUsers = UserProject::getTeamBetUsers($aUserIds);
        $aTeamProfit = TeamProfit::getTodayTeamProfit($iUserId, $sBeginDate);
        $fTeamAvailableBalance = Account::getTeamAvailableBalance($aUserIds);
        $iTeamTodayBets = UserProject::getTeamTodayBets($aUserIds, $sStartTime, $sEndTime);
        $iTeamTodayCasinoBets = UserProject::getTeamTodayCasinoBets($aUserIds, $sStartTime, $sEndTime);
        $iTeamDepositUsers = Deposit::getTeamDepositsByDate($aUserIds, $sStartTime);
        
		$this->setVars(compact('iSubUserCount', 'iTeamOnlineCount', 'iRegistUserCount', 
								'iTeamHistoryBetUsers', 'iTeamTodayBetUsers', 
								'aTeamProfit', 'fTeamAvailableBalance','iTeamTodayBets', 'iTeamTodayCasinoBets', 'iTeamDepositUsers'
						));        
       return $this->render();
    }
    
    
}
