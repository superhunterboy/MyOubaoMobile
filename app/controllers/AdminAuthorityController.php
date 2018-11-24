<?php

class AdminAuthorityController extends Controller
{


    /**
     * 登录
     * @return Response
     */
    public function signin()
    {
//        exit;
//        $sc = new SysConfig;
        $bSecureCard = SysConfig::check('enable_secure_card_check', true);
        $bCaptcha = SysConfig::check('enable_identifying_code_check', true);

        // $bSecureCard = 1;
        // $bCaptcha = 0;
        if (Request::method() == 'POST') {
            if ($bCaptcha) {
                $captcha = ['captcha' => Input::get('captcha')];
                $rules = ['captcha'   => 'required|captcha'];
                $validator = Validator::make($captcha, $rules);
                if (!$validator->passes()) {
                    return $this->goBack('error', __('_basic.login-fail-captcha'));
                }
            }

            $sUsername = Input::get('username');
            $sPassword = Input::get('password');
//            pr($this->params);
            // 凭证
            $credentials = ['username' => $sUsername, 'password' => $sPassword];
            // 是否记住登录状态
            $remember    = Input::get('remember-me', 0);
            $user = AdminUser::where('username', '=', $sUsername)->first();

            if (empty($user) || !Hash::check($sPassword, $user->password)) {
                return $this->goBack('error', __('_basic.login-fail-wrong'));
            }
            if ($bSecureCard) {
                $secure_passwrod = Input::get('secure_password');
                $sSecureCardNumber = $user->secure_card_number;

                $oSecureCard = SecureCard::where('number', '=', $sSecureCardNumber)->first();

                $sSafeString = $oSecureCard->safe_string;

                useclass("seamoonapi");
                $seamoon = new seamoonapi();
                error_reporting(0);
                $result = $seamoon->checkpassword($sSafeString, $secure_passwrod);
                if (strlen($result) <= 3) {
                    return $this->goBack('error', __('_basic.login-fail-secure'));
//                    return Redirect::back()
//                        ->withInput()
//                        ->withErrors(['attempt' => 'Invalid secure password, please retry.']);
                }

                $check_result = $seamoon->passwordsyn($sSafeString, $secure_passwrod);
                if (strlen($check_result) <= 3) {
                    return $this->goBack('error', __('_basic.login-fail-secure'));
                }
                $oSecureCard->safe_string = $check_result;
                $oSecureCard->number = $sSecureCardNumber;
                // $oSecureCard->updated_at = Carbon::now()->toDateTimeString();
                $oSecureCard->save();
                // SecureCard::update(['safe_string' => "'" . $check_result . "'", 'modified' => "'" . Carbon::now()->toDateTimeString() . "'"], ['number' => $sSecureCardNumber]);
            }
            // check role , save session
            Session::put('admin_user_id',$user->id);
            Session::put('admin_username',$user->username);
            Session::put('admin_language',$user->language);
            $user->signin_at = Carbon::now()->toDateTimeString();
//            pr($user->signin_at);
//            exit;
            // $rules = AdminUser::$rules;
            // unset($rules['password']);
            // unset($rules['password_confirmation']);
            // $rules['username'] .= $user->id;
            $user->save();
           // pr($user->validationErrors);
           // exit;
            $roles = $this->_getUserRole();
            if (in_array(Role::DENY, $roles)){
                // var_dump('expression');
                return $this->goBack('error', __('_basic.login-fail-wrong'));
            }
            $bFlagForFinance = !empty(array_intersect($roles, AdminRole::$aRoleFinance));
            $bFlagForCustomer =!empty(array_intersect($roles, AdminRole::$aRoleCustomer));
            Session::put('CurUserRole', $roles);
            Session::put('IsAdmin', in_array(Role::ADMIN, $roles));
            // 提现申请提示音
            Session::put('bFlagForFinance', $bFlagForFinance);
            Session::put('bFlagForCustomer', $bFlagForCustomer);

            
//            $url = URL::route('admin.frameset');
//            die($url);

            return Redirect::route('admin.home');
//return Redirect::to('/admin');
//            } else {
//                // 登录失败，跳回
//                return Redirect::back()
//                    ->withInput()
//                    ->withErrors(['attempt' => __('Username or password was error, please retry.')]);
//            }
        } else {
//            $oSysConfig = new SysConfig;
            // $sLanguage  = SysConfig::readValue('user_default_language');
            App::setlocale('en');
            $sAppTitle  = SysConfig::readValue('app_title');
            $sAppName   = SysConfig::readValue('app_name');
            return View::make('adminAuthority.signin')->with(compact('bSecureCard', 'bCaptcha', 'sAppTitle', 'sAppName'));
        }
    }
    /**
     * 动作：退出
     * @return Response
     */
    public function logout()
    {
//        $baseUrl = '/admin';
        if (Session::get('admin_user_id') > 0) {
            Session::flush();
        }
        return Redirect::route('admin.home');
    }

    /**
     * 页面：注册
     * @return Response
     */
    public function signup()
    {
        if (Request::method() == 'PUT') {
            // 获取所有表单数据.
            $data = Input::all();
            // 创建验证规则
            $rules = [
                'username' => 'required|between:4,16|unique:users',
                // 'email'    => 'required|email|unique:users',
                'password' => 'required|alpha_dash|between:6,16|confirmed',
            ];
            // 自定义验证消息
            $messages = [
                'username.required'   => '请输入用户名。',
                'username.between'    => '用户名长度请保持在:min到:max位之间。',
                // 'email.required'      => '请输入邮箱地址。',
                // 'email.email'         => '请输入正确的邮箱地址。',
                // 'email.unique'        => '此邮箱已被使用。',
                'password.required'   => '请输入密码。',
                'password.alpha_dash' => '密码格式不正确。',
                'password.between'    => '密码长度请保持在:min到:max位之间。',
                'password.confirmed'  => '两次输入的密码不一致。',
            ];
            // 开始验证
            $validator = Validator::make($data, $rules, $messages);
            if ($validator->passes()) {
                // 验证成功，添加用户
                $user = new User;
                $user->email    = Input::get('email');
                $user->password = Input::get('password');
                if ($user->save()) {
                    // 添加成功
                    // 生成激活码
                    $activation = new Activation;
                    $activation->email = $user->email;
                    $activation->token = str_random(40);
                    $activation->save();
                    // 发送激活邮件
                    $with = ['activationCode' => $activation->token];
                    Mail::send('adminAuthority.email.activation', $with, function ($message) use ($user) {
                        $message
                            ->to($user->email)
                            ->subject('账号激活邮件'); // 标题
                    });
                    // 跳转到注册成功页面，提示用户激活
                    return Redirect::route('signupSuccess', $user->email);
                } else {
                    // 添加失败
                    return Redirect::back()
                        ->withInput()
                        ->withErrors(['add' => '注册失败。']);
                }
            } else {
                // 验证失败，跳回
                return Redirect::back()
                    ->withInput()
                    ->withErrors($validator);
            }
        }
        return View::make('adminAuthority.signup');
    }


    /**
     * 页面：注册成功，提示激活
     * @param  string $email 用户注册的邮箱
     * @return Response
     */
    public function getSignupSuccess($email)
    {
        // 确认是否存在此未激活邮箱
        $activation = Activation::whereRaw("email = '{$email}'")->first();
        // 数据库中无邮箱，抛出404
        is_null($activation) AND App::abort(404);
        // 提示激活
        return View::make('adminAuthority.signupSuccess')->with('email', $email);
    }

    /**
     * 动作：激活账号
     * @param  string $activationCode 激活令牌
     * @return Response
     */
    public function getActivate($activationCode)
    {
        // 数据库验证令牌
        $activation = Activation::where('token', $activationCode)->first();
        // 数据库中无令牌，抛出404
        is_null($activation) AND App::abort(404);
        // 数据库中有令牌
        // 激活对应用户
        $user = User::where('email', $activation->email)->first();
        $user->activated_at = Carbon::now()->toDateTimeString();
        $user->save();
        // 删除令牌
        $activation->delete();
        // 激活成功提示
        return View::make('adminAuthority.activationSuccess');
    }

    /**
     * 页面：忘记密码，发送密码重置邮件
     * @return Response
     */
    public function getForgotPassword()
    {
        return View::make('adminAuthority.password.remind');
    }

    /**
     * 动作：忘记密码，发送密码重置邮件
     * @return Response
     */
    public function postForgotPassword()
    {
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
    public function getReset($token)
    {
        // 数据库中无令牌，抛出404
        is_null(PassowrdReminder::where('token', $token)->first()) AND App::abort(404);
        return View::make('adminAuthority.password.reset')->with('token', $token);
    }

    /**
     * 动作：进行密码重置
     * @return Response
     */
    public function postReset()
    {
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
                return Redirect::to('/admin');
        }
    }

    /**
     * [_getUserRole 获取用户角色数据]
     * @return [type] [存入Session, key为CurUserRole]
     */
    protected function _getUserRole() {
        $iUserId = Session::get('admin_user_id');
        $roles = AdminUser::find($iUserId)->getRoleIds();
//        print_r($roles);
//        exit;
//        $roleIds = [];
        $adminRoleId = Role::ADMIN;
        $everyOneId = Role::EVERYONE;

//        foreach ($roles as $role) {
//            array_push($roleIds, $role->id);
//        }
        // 如果用户有Administrators角色，使用系统管理员权限；否则，默认添加everyone角色
        array_push($roles, $everyOneId);
        array_map(function($value){
            return (int)$value;
        }, $roles);
        array_unique($roles);
        return $roles;
    }

    /**
     * go back
     * @param string $sMsgType      in list: success, error, warning, info
     * @param string $sMessage
     * @return RedirectResponse
     */
    protected function goBack($sMsgType , $sMessage , $bWithModelErrors = false){
        // pr(func_get_args());
        // exit;
        $oRedirectResponse = Redirect::back()
            ->withInput()
            ->with($sMsgType , $sMessage);
//        $sMsgType != 'error' or $oRedirectResponse->withErrors($sMessage);
        !$bWithModelErrors or $oRedirectResponse = $oRedirectResponse->withErrors($this->model->validationErrors);
        return $oRedirectResponse;
    }

}
