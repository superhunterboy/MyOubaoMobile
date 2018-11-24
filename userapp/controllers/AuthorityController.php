<?php


class AuthorityController extends Controller {

    /**
     * 页面：登录
     * @return Response
     */
    public function signin() {
        if (Request::method() == 'POST') {
            return $this->postSignin();
        } else {
            if (SysConfig::readValue('daily_maintence')) {
                return View::make('authority.maintence');
            } else {
                return View::make('authority.signin');
            }
        }
    }

    /**
     * 动作：登录  
     * @return Response
     */
    public function postSignin() {
        $iLoginTimes = (int) Session::get('LOGIN_TIMES');
        Session::put('LOGIN_TIMES', ++$iLoginTimes);

        $aRandom = explode('_', trim(Input::get('_random')));
        if (count($aRandom) != 2 || (count($aRandom) == 2 && ($aRandom[1] != Session::get($aRandom[0])))) {
            return Redirect::back()
                            ->withInput()
                            ->with('error', __('_basic.login-fail-wrong'));
        }

        // 默认前3次登录不用验证码, 3次登录失败后需要验证码, 登录成功则清空登录次数
        if (isset($iLoginTimes) && ($iLoginTimes > 3)) {
            // 验证码校验
            if ($this->validateCaptchaError($sErrorMsg)) {
                return Redirect::back()
                                ->withInput()
                                ->with('error', $sErrorMsg);
            }
        }

        $sUsername = Input::get('username');
        $sPassword = Input::get('password');
        // 凭证
        // $credentials = array('username' => $sUsername, 'password' => $sPassword);
        // 是否记住登录状态
        $remember = Input::get('remember-me', 0);
        $user = User::where('username', '=', $sUsername)->first();
        if (!is_object($user)) {
            return Redirect::back()
                            ->withInput()
                            ->with('error', "用户名不存在，请重新输入用户名");
        }
        if (empty($user) || !Hash::check($sPassword, $user->password)) {
            return Redirect::back()
                            ->withInput()
                            ->with('error', __('_basic.login-fail-wrong'));
        }
        if ($user->blocked == User::BLOCK_LOGIN) {
            return Redirect::back()
                            ->withInput()
                            ->with('error', __('_basic.login-fail-blocked'));
            // ->with('error', __('_basic.login-fail-blocked'));
        }
        if (!$user->is_from_link && !$user->signin_at) {
            Session::put('first_login', true);
        }
        $user->signin_at = Carbon::now()->toDateTimeString();
        $user->login_ip = get_client_ip();

        $bSucc = $user->save();
        // pr($bSucc);
        // pr($user->validationErrors);
        // exit;
        $roles = $this->_getUserRole($user);
        if (in_array(Role::DENY, $roles)) {
            return Redirect::back()
                            ->withInput()
                            ->with('error', __('_basic.login-fail-wrong'));
        }
        Session::put('user_id', $user->id);
        Session::put('username', $user->username);
        Session::put('nickname', $user->nickname);
        Session::put('language', $user->language);
        Session::put('account_id', $user->account_id);
        Session::put('forefather_ids', $user->forefather_ids);
        Session::put('is_agent', $user->is_agent);
        Session::put('prize_group', $user->prize_group);
        Session::put('is_tester', $user->is_tester);
        Session::put('is_top_agent', $user->is_agent && empty($user->parent_id));
        Session::put('is_player', !$user->is_agent);
        Session::put('CurUserRole', $roles);
        Session::put('portraitCode', $user->portrait_code);

        // 默认前3次登录不用验证码, 3次登录失败后需要验证码, 登录成功则清空登录次数
        Session::forget('LOGIN_TIMES');
        $oUserLogin = UserLogin::getLatestLoginRecord($user->username);
        if(is_object($oUserLogin)){
            UserLogin::sso($user->username, $oUserLogin->session_id, Session::getId());
        }
        // 保存登录历史
        UserLogin::createLoginRecord($user);
        UserLoginIP::createLoginIPRecord($user);
        $user->is_tester or BaseTask::addTask('StatUpdateLoginCountOfProfit', ['date' => $user->signin_at, 'user_id' => $user->id], 'stat');
        $sToUrl = Session::get('__returnUrl');
        if ($sToUrl == '' || $sToUrl == '/') {
            $sToUrl = route('home');
        }
        return Redirect::to($sToUrl);
    }

    /**
     * 动作：退出
     * @return Response
     */
    public function logout() {
        UserLogin::ssoLogout(Session::get('username'), Session::getId());
        Session::flush();
        if (!$bIsAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
            return Redirect::route('home');
        }
    }

    /**
     * 页面：注册
     * @return Response
     */
    public function signup($sKeyword = null) {
        if (Request::method() == 'POST') {
            return $this->postSignup();
        }
        $sKeyword = trim(Input::get('prize'));
        $oRegisterLink = null;
        if (!$sKeyword) {
            $sViewFileName = 'authority.signup';
        } else {
            if (!$oRegisterLink = UserRegisterLink::getRegisterLinkByPrizeKeyword($sKeyword)) {
                return View::make('authority.signup')->with(compact('sKeyword', 'oRegisterLink'));
            }
                $sViewFileName = 'authority.signup';
                }
        // pr($oRegisterLink->toArray());exit;
        // $sKeyword or $sKeyword = 'experience';
        return View::make($sViewFileName)->with(compact('sKeyword', 'oRegisterLink'));
    }

    /**
     * [validateCaptchaError 验证验证码]
     * @return [Boolean/Response] [验证成功/失败]
     */
    private function validateCaptchaError(& $sErrorMsg) {
        $aDatas = ['captcha' => trim(Input::get('captcha'))];
        $aRules = ['captcha' => 'required|captcha'];
        $oValidator = Validator::make($aDatas, $aRules);
        if (!$oValidator->passes()) {
            $sErrorMsg = __('_basic.captcha-error');
            return true;
        }
        return false;
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
        } else if (User::checkUsernameExist($sUsername)) {
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
        } else if (User::checkEmailExist($sEmail)) {
            $sErrorMsg = '该邮箱已被注册，请重新输入！';
            return true;
        }
        return false;
    }

    /**
     * [postSignup 实际处理注册流程
     *         注册流程:
     *            1. 判断随机码是否正确
     *            2. 判断验证码是否正确
     *            3. 判断用户名是否已经存在
     *            4. 获取开户奖金组信息, 如果有链接开户的特征码, 则获取对应的奖金组信息, 否则, 获取体验账户的奖金组
     *            5. 生成用户信息
     *            6. 新建用户
     *            7. 新建用户的账户
     *            8. 更新用户的account_id字段
     *            9. 创建用户奖金组
     *            10.(链接开户) 更新链接开户数
     *            11.(链接开户) 更新链接所开用户的关联表(register_links表的created_count字段)
     * ]
     * @return [Response] [description]
     */
    public function postSignup() {
        $aRandom = explode('_', trim(Input::get('_random')));
        if (!isset($aRandom[1]) || $aRandom[1] != Session::get($aRandom[0])) {
            return Redirect::back()
                            ->withInput()
                            ->with('error', '注册失败！');
        }

        if ($this->validateCaptchaError($sErrorMsg)) {
            return Redirect::back()
                            ->withInput()
                            ->with('error', $sErrorMsg);
        }
        if ($this->validateUsernameExist($sErrorMsg)) {
            return Redirect::back()
                            ->withInput()
                            ->with('error', $sErrorMsg);
        }
//        if ($this->validateEmailExist($sErrorMsg)) {
//            return Redirect::back()
//                            ->withInput()
//                            ->with('error', $sErrorMsg);
//        }
        $iPortraitCode = Input::get('avatarid');
        if (!$iPortraitCode && $iPortraitCode > 6 && $iPortraitCode < 1) {
            return Redirect::back()
                            ->withInput()
                            ->with('error', '头像选择有误');
        }

        $sPrizeGroupCode = trim(Input::get('prize'));
        $aPrizeGroup = [];
        $oPrizeGroup = null;
        $bSucc = UserUser::getRegistPrizeGroup($sPrizeGroupCode, $aPrizeGroup, $oPrizeGroup, $aPrizeSetQuota);
        if (!$bSucc) {
            $sReason = '该链接已失效！';
            return Redirect::back()
                            ->withInput()
                            ->with('error', '注册失败！' . $sReason);
        }
        $data = trimArray(Input::except(['captcha', 'prize', '_token', '_random']));
        $sPrizeGroup = $aPrizeGroup[0]->prize_group;
        $sLinkPrizeGroup = json_decode($oPrizeGroup->prize_group_sets)[0]->prize_group;
        if (false && $oPrizeGroup->is_agent && !$oPrizeGroup->is_admin && $sLinkPrizeGroup >= 1950) {
            $bSucc2 = UserPrizeSetQuota::checkQuota([$sPrizeGroup => 1], $oPrizeGroup->user_id);
            if (array_get($aPrizeSetQuota, $sPrizeGroup)) {
                $aPrizeSetQuota[$sPrizeGroup] ++;
            }
            !$bSucc2 or $bSucc2 = UserPrizeSetQuota::checkQuota($aPrizeSetQuota, $oPrizeGroup->user_id);
            if (!$bSucc2) {
                $sReason = '配额不足！';
                return Redirect::back()
                                ->withInput()
                                ->with('error', '注册失败！' . $sReason);
            }
            if (array_get($aPrizeSetQuota, $sPrizeGroup)) {
                $aPrizeSetQuota[$sPrizeGroup] --;
            }
        }

        $aExtraData = [
            'is_agent' => intval($oPrizeGroup->is_agent),
            'parent_id' => ($oPrizeGroup->is_admin ? null : $oPrizeGroup->user_id),
            'parent' => ($oPrizeGroup->is_admin ? '' : $oPrizeGroup->username),
            'is_tester' => $oPrizeGroup->is_tester,
            'register_at' => Carbon::now()->toDateTimeString(),
            'portrait_code' => $iPortraitCode,
        ];
        $data = array_merge($data, $aExtraData);
        $oUser = new User;
        $aReturnMsg = $oUser->generateUserInfo($sPrizeGroup, $data);
        if (!$aReturnMsg['success']) {
            return Redirect::back()
                            ->withInput()
                            ->with('error', $aReturnMsg['msg']);
        }
        $oUser->is_from_link = 1;

        DB::connection()->beginTransaction();

        $bSucc = $this->createProcess($oUser, $aPrizeGroup, $oPrizeGroup, $sPrizeGroupCode);
        if (!$oPrizeGroup->is_admin) {
            !$bSucc or $bSucc = UserPrizeSetQuota::updateUserPrizeSetQuota($aExtraData['parent_id'], $aPrizeSetQuota);
            !$bSucc or $bSucc = UserPrizeSetQuota::updateUserPrizeSetQuota($aExtraData['parent_id'], [$oUser->prize_group => 1]);
            !$bSucc or $bSucc = UserPrizeSetQuota::insertUserPrizeSetQuota($oUser, $aPrizeSetQuota);
        } else {
            !$bSucc or $bSucc = UserPrizeSetQuota::insertUserPrizeSetQuota($oUser, $aPrizeSetQuota);
        }
        if ($bSucc) {
            $sRegisterMail = $oUser->email;
            DB::connection()->commit();
            $oUser->is_tester or BaseTask::addTask('StatUpdateRegisterCountOfProfit', ['date' => $oUser->register_at, 'user_id' => $oUser->id], 'stat');

            //给用户发送一封激活邮件
            // $oUser->sendActivateMail();
//            BaseTask::addTask('EventTaskQueue', ['event' => 'ds.auth.regist', 'user_id' => $oUser->id, 'data' => []], 'activity');
            return Redirect::to(route('signin'))->withInput()->with('success', '注册成功，请登录');;
        } else {
            DB::connection()->rollback();
            return Redirect::back()
                            ->withInput()
                            ->with('error', '注册失败。');
        }
    }

    /**
     * [createProcess 开户流程]
     * @param  [Object] $oUser       [用户对象]
     * @param  [Array]  $aPrizeGroup [奖金组数据]
     * @param  [Object] $oPrizeGroup [开户链接对象]
     * @param  [String] $sPrizeGroupCode [链接开户特征码]
     * @return [Boolean]             [开户成功/失败]
     */
    private function createProcess($oUser, $aPrizeGroup, $oPrizeGroup, $sPrizeGroupCode) {
        $bSucc = false;
        // $aRules = User::$rules;
        // $aRules['username'] = str_replace('{:id}', '', $aRules['username']);
        if ($bSucc = $oUser->save()) {
            $oAccount = $oUser->generateAccountInfo();
            if ($bSucc = $oAccount->save()) {
                // $aRules = User::$rules;
                // $aRules['username'] = str_replace('{:id}', $oUser->id, $aRules['username'] );
                $oUser->account_id = $oAccount->id;
                // $bSucc = $oUser->save($aRules);
                if ($bSucc = $oUser->save()) {
                    $aReturnMsg = UserPrizeSet::createUserPrizeGroup($oUser, $aPrizeGroup); // $this->createUserPrizeGroup($aPrizeGroup, $oUser);
                    $bSucc = $aReturnMsg['success'];
                }
                // 只有链接开户时需要增加链接的开户数以及关联开户用户
                if ($sPrizeGroupCode && $bSucc) {
                    $oPrizeGroup->increment('created_count');
                    if ($oPrizeGroup->is_admin && $oPrizeGroup->created_count == 0) {
                        $oPrizeGroup->increment('status');
                    }
                    $oPrizeGroup->users()->attach($oUser->id, ['url' => $oPrizeGroup->url, 'username' => $oUser->username]);
                }
            }
        }
        return $bSucc;
    }

    /**
     * [createUserPrizeGroup 创建用户彩票奖金组]
     * @param  [Array] $aPrizeGroup [链接开户的奖金组配置]
     * @param  [Object] $oUser      [用户对象]
     * @return [Boolean]            [是否成功]
     */
    // private function createUserPrizeGroup($aPrizeGroup, $oUser)
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
     * 页面：注册成功，提示激活
     * @param  string $email 用户注册的邮箱
     * @return Response
     */
    public function getSignupSuccess($email) {
        // 确认是否存在此未激活邮箱
        $activation = Activation::whereRaw("email = '{$email}'")->first();
        // 数据库中无邮箱，抛出404
        is_null($activation) AND App::abort(404);
        // 提示激活
        return View::make('authority.signupSuccess')->with('email', $email);
    }

    /**
     * 动作：激活账号
     * @param  string $activationCode 激活令牌
     * @return Response
     */
    public function getActivate($activationCode) {
        // 数据库验证令牌
        $activation = Activation::where('token', $activationCode)->first();
        // 数据库中无令牌，抛出404
        is_null($activation) AND App::abort(404);
        // 数据库中有令牌
        // 激活对应用户
        $user = User::where('email', $activation->email)->first();
        $user->activated_at = new Carbon;
        $user->save();
        // 删除令牌
        $activation->delete();
        // 激活成功提示
        return View::make('authority.activationSuccess');
    }

    /**
     * 页面：忘记密码，发送密码重置邮件
     * @return Response
     */
    public function getForgotPassword() {
        return View::make('authority.password.remind');
    }

    /**
     * 动作：忘记密码，发送密码重置邮件
     * @return Response
     */
    public function postForgotPassword() {
        // 调用系统提供的类
        $response = Password::remind(Input::only('email'), function ($m, $user, $token) {
                    $m->subject('密码重置邮件'); // 标题
                });
        // 检测邮箱并发送密码重置邮件
        switch ($response) {
            case Password::INVALID_USER:
                return Redirect::back()->with('error', Lang::get($response));
            case Password::REMINDER_SENT:
                return Redirect::back()->with('status', Lang::get($response));
        }
    }

    /**
     * 页面：进行密码重置
     * @return Response
     */
    public function getReset($token) {
        // 数据库中无令牌，抛出404
        is_null(PassowrdReminder::where('token', $token)->first()) AND App::abort(404);
        return View::make('authority.password.reset')->with('token', $token);
    }

    /**
     * 动作：进行密码重置
     * @return Response
     */
    public function postReset() {
        // 调用系统自带密码重置流程
        $credentials = Input::only(
                        'email', 'password', 'password_confirmation', 'token'
        );

        $response = Password::reset($credentials, function ($user, $password) {
                    // 保存新密码
                    $user->password = $password;
                    $user->save();
                    // 登录用户
                    Auth::login($user);
                });

        switch ($response) {
            case Password::INVALID_PASSWORD:
            // no break
            case Password::INVALID_TOKEN:
            // no break
            case Password::INVALID_USER:
                return Redirect::back()->with('error', Lang::get($response));
            case Password::PASSWORD_RESET:
                return Redirect::to('/');
        }
    }

    protected function _getUserRole($oUser) {
        $roles = $oUser->getRoleIds();

        $aDefaultRoles[] = Role::EVERY_USER;

        if ($oUser->is_agent) {
            $aDefaultRoles[] = Role::AGENT;
            if (empty($oUser->parent_id)) {
                $aDefaultRoles[] = Role::TOP_AGENT;
            }
        } else {
            $aDefaultRoles[] = Role::PLAYER;
        }
        $roles = array_merge($roles, $aDefaultRoles);
        $roles = array_unique($roles);
        $roles = array_map(function($value) {
            return (int) $value;
        }, $roles);

        return $roles;
    }

    /**
     * 忘记密码，找回密码
     */
    public function findPassword() {
        if (Request::method() == 'PUT') {
            if ($this->validateCaptchaError($sErrorMsg)) {
                return Redirect::back()->withInput()->with('error', $sErrorMsg);
            }
            $sUsername = trim(Input::get('username'));
            $sFundPasswd = trim(Input::get('fund_password'));
            $sNewPasswd = trim(Input::get('new_password'));
            $sNewPasswdConfirmation = trim(Input::get('new_password_confirmation'));

            $oUser = UserUser::findUser($sUsername);
            if (!is_object($oUser)) {
                return Redirect::back()->withInput()->with('error', __('_user.missing-data'));
            }

            if (!$oUser->checkFundPassword($sFundPasswd)) {
                return Redirect::back()->withInput()->with('error', __('_user.wrong-fund-password'));
            }

            if ($oUser->checkFundPassword($sNewPasswd)) {
                return Redirect::back()->withInput()->with('error', __('_user.same-with-password'));
            }

            $aFormData = [
                'password' => $sNewPasswd,
                'password_confirmation' => $sNewPasswdConfirmation,
            ];
            $aReturnMsg = $oUser->resetPassword($aFormData);
            if (!$bSucc = $aReturnMsg['success']) {
                $this->langVars['reason'] = $aReturnMsg['msg'];
            }
            if ($bSucc) {
                return Redirect::route('signin')->with('success', __('_user.password-updated'));
            } else {
                return Redirect::back()->with('error', __('_user.update-password-fail', $this->langVars));
            }
        } else {
            return View::make('authority.findPassword');
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

}
