<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;
use Illuminate\Support\Facades\Redis;

class User extends BaseModel implements UserInterface, RemindableInterface {

    protected static $cacheLevel = self::CACHE_LEVEL_FIRST;
    protected $table = 'users';
    protected $softDelete = true;
    protected $fillable = [
        'account_id',
        'username',
        'portrait_code',
        'nickname',
        'email',
        'parent_id',
        'parent',
        'forefather_ids',
        'forefathers',
        'prize_group',
        'blocked',
        'activated_at',
        'signin_at',
        'register_at',
        'is_agent',
        'is_tester',
        'fund_password',
        'fund_password_confirmation',
        'password',
        'password_confirmation',
        'register_ip',
        'login_ip',
        'bet_coefficient',
        'bet_multiple',
    ];
    // protected $hidden = ['password', 'fund_password'];
    /**
     * 资源名称
     * @var string
     */
    public static $resourceName = 'User';

    /**
     * If Tree Model
     * @var Bool
     */
    public static $treeable = true;
    public static $foreFatherIDColumn = 'forefather_ids';

    /**
     * forefather field
     * @var Bool
     */
    public static $foreFatherColumn = 'forefathers';

    /**
     * the columns for list page
     * @var array
     */
    public static $columnForList = [
        'parent',
        'username',
        'nickname',
        // 'user_type_formatted',
        'account_available',
        // 'group_account_sum',
//        'email',
        'prize_group',
        'blocked',
        'activated_at',
        'signin_at',
        'created_at',
        'is_agent',
        'is_tester'
    ];
    public static $noOrderByColumns = [
        'account_available'
    ];
    public static $listColumnMaps = [
        // 'account_available' => 'account_available_formatted',
        'is_agent' => 'user_type_formatted',
        'signin_at' => 'friendly_signin_at',
        // 'created_at'   => 'friendly_created_at',
        'activated_at' => 'friendly_activated_at',
        'blocked' => 'friendly_block_type',
        'is_tester' => 'friendly_is_tester',
    ];
    public static $ignoreColumnsInView = ['id', 'role_ids', 'password', 'fund_password', 'remember_token'];
    public static $ignoreColumnsInEdit = ['password', 'fund_password', 'blocked'];

    /**
     * the main param for index page
     * @var string
     */
    public static $mainParamColumn = 'parent_id';
    public static $titleColumn = 'username';

    /**
     * 下拉列表框字段配置
     * @var array
     */
    public static $htmlSelectColumns = [
//        'parent_id' => 'aParentIds',
        'blocked' => 'aBlockedTypes',
        'bet_coefficient' => 'aCoefficient'
    ];
    public static $aUserTypes = [
        self::TYPE_USER => 'User',
        self::TYPE_AGENT => 'Agent',
        self::TYPE_TOP_AGENT => 'top-agent',
    ];
    public $autoPurgeRedundantAttributes = true;
    public $autoHashPasswordAttributes = true;
    public static $passwordAttributes = ['password', 'fund_password'];
    public static $rules = [
        'username' => 'required|alpha_num|custom_first_character|between:6,16|unique:users,username,',
        'nickname' => 'required|between:2,16',
        'email' => 'email|between:0, 50', // |unique:users,email,
        // 'password'                   => 'required|regex:/^(?![^a-zA-Z]+$)(?!\D+$).{6,16}$/|confirmed|different_before_hash:fund_password',
        // 'password_confirmation'      => 'required|regex:/^(?![^a-zA-Z]+$)(?!\D+$).{6,16}$/',
        // 'fund_password'              => 'required|regex:/^(?![^a-zA-Z]+$)(?!\D+$).{6,16}$/|confirmed|different_before_hash:password', // 资金账户密码
        // 'fund_password_confirmation' => 'required|regex:/^(?![^a-zA-Z]+$)(?!\D+$).{6,16}$/',
        'parent_id' => 'integer',
        // 'parent'                     => 'required',
        // 'parent_str'                 => 'required',
        'account_id' => 'integer',
        'blocked' => 'in:0,1,2,3',
        'forefathers' => 'between:0,1024',
        'forefather_ids' => 'between:0,100',
        'is_agent' => 'in:0, 1',
        'is_tester' => 'in:0, 1',
        'activated_at' => 'date',
        'signin_at' => 'date',
        'register_at' => 'date',
        'register_ip' => 'between:0,15',
        'login_ip' => 'between:0,15',
        'bet_coefficient' => 'in:1,0.1,0.01,0.5,0.05,0.001',
        'bet_multiple' => 'integer',
    ];
    // 单独提取出密码的验证规则, 以便在hash之前完成验证并将password字段替换为username . password三次md5后的字符串
    // 正则表达式: 大小写字母+数字, 长度6-16, 不能连续3位字符相同, 不能和资金密码字段相同
    public static $passwordRules = [
        'password' => 'required|custom_password|different:username',
//        'password_confirmation' => 'required',
    ];
    // 单独提取出资金密码的验证规则, 以便在hash之前完成验证并将fund_password字段替换为username . fund_password三次md5后的字符串
    // 正则表达式: 大小写字母+数字, 长度6-16, 不能连续3位字符相同, 不能和密码字段相同
    public static $fundPasswordRules = [
        'fund_password' => 'required|custom_password|confirmed|different:username',
        'fund_password_confirmation' => 'required',
    ];
    // 按钮指向的链接，查询列名和实际参数来源的列名的映射
    // public static $aButtonParamMap = ['prize_group' => 'prize_group'];


    public $orderColumns = [
        'username' => 'asc'
    ];

    const TYPE_TOP_AGENT = 2;
    const TYPE_AGENT = 1;
    const TYPE_USER = 0;
    const UNBLOCK = 0;
    const BLOCK_LOGIN = 1;
    const BLOCK_BUY = 2;
    const BLOCK_FUND_OPERATE = 3;

    public static $blockedTypes = [
        self::UNBLOCK => 'unblock',
        self::BLOCK_LOGIN => 'block-login',
        self::BLOCK_BUY => 'block-bet',
        self::BLOCK_FUND_OPERATE => 'block-fund',
    ];

    public function roles() {
        return $this->belongsToMany('Role', 'role_users', 'user_id', 'role_id')->withTimestamps();
    }

    public function parents() {
        return $this->belongsTo('User', 'parent_id');
    }

    public function children() {
        return $this->hasMany('User', 'parent_id');
    }

    public function msg_messages() {
        return $this->belongsToMany('MsgMessage', 'msg_user', 'receiver_id', 'msg_id')->withTimestamps();
    }

    /**
     * 账户信息关系
     *
     * @return mixed
     */
    public function account() {
        return $this->hasOne('Account', 'user_id', 'id');
    }

    // public function user_bank_cards()
    // {
    //     return $this->hasMany('UserBankCard', '');
    // }

    public function create_user_links() {
        return $this->belongsToMany('RegisterLink', 'register_link_users', 'user_id', 'register_link_id')->withTimestamps();
    }

    public function __construct(array $attributes = []) {
        parent::__construct($attributes);
    }

    /**
     * Get the unique identifier for the user.
     *
     * @return mixed
     */
    public function getAuthIdentifier() {
        return $this->getKey();
    }

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword() {
        return $this->password;
    }

    /**
     * Get the token value for the "remember me" session.
     *
     * @return string
     */
    public function getRememberToken() {
        return $this->remember_token;
    }

    /**
     * Set the token value for the "remember me" session.
     *
     * @param  string  $value
     * @return void
     */
    public function setRememberToken($value) {
        $this->remember_token = $value;
    }

    /**
     * Get the column name for the "remember me" token.
     *
     * @return string
     */
    public function getRememberTokenName() {
        return 'remember_token';
    }

    /**
     * Get the e-mail address where password reminders are sent.
     *
     * @return string
     */
    public function getReminderEmail() {
        return $this->email;
    }

    /**
     * 判断该账户是否激活
     *
     * @return bool 是否激活
     */
    public function isActivated() {
        return $this->email && $this->activated_at;
    }

    /**
     * 发送激活邮件
     *
     * @return mixed
     */
    public function sendActivateMail() {
        //给用户发送一封激活邮件
        $code = mt_rand(1000000, 9999999);

        Cache::section('bindEmail')->put($this->id, $code, 1440);

        $user = $this;

        return Mail::send('emails.auth.activation', [
                    'code' => $code,
                    'user' => $this,
                        ], function($message) use ($user) {
                    $message->to($user->email, $user->username)->subject('绑定邮箱确认');
                });
    }

    /**
     * 访问器：友好的最后登录时间
     * @return string
     */
    protected function getFriendlySigninAtAttribute() {
        if (is_null($this->signin_at))
            return __('_user.not-before'); // '新账号尚未登录'
        else
            return friendly_date($this->signin_at);
    }

    protected function getFriendlyCreatedAtAttribute() {
        // return friendly_date($this->created_at);
        return $this->created_at->toDateTimeString();
    }

    protected function getFriendlyBlockTypeAttribute() {
        return __('_user.' . self::$blockedTypes[$this->blocked]);
    }

    protected function getFriendlyIsTesterAttribute() {
        return yes_no(intval($this->is_tester));
    }

    protected function getUserTypeFormattedAttribute() {
        if ($this->parent_id)
            $sUserType = static::$aUserTypes[$this->is_agent];
        else
            $sUserType = static::$aUserTypes[self::TYPE_TOP_AGENT];
        return __('_user.' . $sUserType);
    }

    /**
     * [generatePasswordStr 生成3次md5后的密码字符串]
     * @param  [Integer] $iPwdType [密码字段类型]
     * @return [Array]    ['success' => true/false:验证成功/失败, 'msg' => 返回消息, 成功: 加密后的密码字符串, 失败: 错误信息]
     */
    public function generatePasswordStr($iPwdType = 1) {
        if ($iPwdType == 2) {
            $aPwdRules = static::$fundPasswordRules;
            $sPwdName = 'fund_password';
        } else {
            $aPwdRules = static::$passwordRules;
            $sPwdName = 'password';
        }
        // pr($this->toArray());
        // pr($aPwdRules);
        // exit;
        $customAttributes = [
            "password" => __('_user.login-password'),
            "password_confirmation" => __('_user.password_confirmation'),
            "fund_password" => __('_user.fund_password'),
            "fund_password_confirmation" => __('_user.fund_password_confirmation'),
            "username" => __('_user.login-username'),
        ];
        $oValidator = Validator::make($this->toArray(), $aPwdRules);
        $oValidator->setAttributeNames($customAttributes);

        if (!$oValidator->passes()) {
            // pr($oValidator->errors()->toArray());exit;
            // $aErrMsg = [];
            foreach ($oValidator->errors()->toArray() as $sColumn => $sMsg) {
                // $aErrMsg[] = implode(',', $sMsg);
                // TIP 只取第一个验证错误信息
                $sError = $sMsg[0];
                break;
            }
            // pr($aErrMsg);exit;
            // $sError = implode(' ', $aErrMsg);
            // pr($sError);exit;
            return ['success' => false, 'msg' => $sError];
        }
        // pr($oValidator->errors());exit;
        $sPwd = strtolower($this->username) . $this->{$sPwdName};
        $sPwd = md5(md5(md5($sPwd)));
        // pr($sPwd);exit;
        return ['success' => true, 'msg' => $sPwd];
    }

    /**
     * [resetPassword 重置密码]
     * @param  [Array] $aFormData [数据数组]
     * @return [Array]    [['success' => true/false:验证成功/失败, 'msg' => 返回消息, 成功: 加密后的密码字符串, 失败: 错误信息]]
     */
    public function resetPassword($aFormData) {
        $this->password = $aFormData['password'];
        $this->password_confirmation = $aFormData['password_confirmation'];

        $aReturnMsg = $this->generatePasswordStr(1);
        if ($aReturnMsg['success']) {
            $this->password = $aReturnMsg['msg'];
            if ($bSucc = $this->save()) {
                $aReturnMsg['msg'] = __('_user.password-updated');
            }
        }
        return $aReturnMsg;
    }

    /**
     * [resetFundPassword 重置资金密码]
     * @param  [Array] $aFormData [数据数组]
     * @return [type]           [description]
     */
    public function resetFundPassword($aFormData) {
        $this->fund_password = $aFormData['fund_password'];
        $this->fund_password_confirmation = $aFormData['fund_password_confirmation'];

        $aReturnMsg = $this->generatePasswordStr(2);
        if ($aReturnMsg['success']) {
            $this->fund_password = $aReturnMsg['msg'];
            if ($bSucc = $this->save()) {
                $aReturnMsg['msg'] = __('_user.fund-password-updated');
            }
        }
        return $aReturnMsg;
    }

    /**
     * [checkPassword 检查密码]
     * @param  [String] $sPassword [密码字符串]
     * @return [Boolean]           [验证成功/失败]
     */
	public function checkPassword($sPassword) {
        $sPwd = strtolower($this->username) . $sPassword;
        $sUserPassword = md5(md5(md5($sPwd)));
        // pr($sUserPassword);exit;
        $oUser = self::where('username', '=', Session::get('username'))->first(['password']);
        return Hash::check($sUserPassword, $oUser->password);
    }

    /**
     * [checkFundPassword 检查资金密码]
     * @param  [String] $sFundPassword [资金密码字符串]
     * @return [Boolean]               [验证成功/失败]
     */
    public function checkFundPassword($sFundPassword) {
        $sPwd = strtolower($this->username) . $sFundPassword;
        $sUserFundPassword = md5(md5(md5($sPwd)));
        $oUser = self::where('username', '=', Session::get('username'))->first(['fund_password']);
        return Hash::check($sUserFundPassword, $oUser->fund_password);
    }

    /**
     * [checkUsernameExist 判断用户名是否存在]
     * @param  [String] $sUsername [用户名]
     * @return [Boolean]           [true:存在, false:不存在]
     */
    public static function checkUsernameExist($sUsername) {
        return User::where('username', '=', $sUsername)->exists();
    }

    /**
     * [checkEmailExist 判断邮箱是否已经被绑定]
     * @param  [String] $sEmail [邮箱名]
     * @return [Boolean]           [true:存在, false:不存在]
     */
    public static function checkEmailExist($sEmail) {
        return User::where('email', '=', $sEmail)->whereNotNull('activated_at')->exists();
    }

    public static function getAllUserNameArrayByUserType($iUserType = self::TYPE_USER, $iAgentLevel = null) {
        $data = [];
        $aColumns = ['id', 'username'];
        if ($iUserType == 'all') {
            $aUsers = User::all($aColumns);
        } else {
            $oQuery = User::where('is_agent', '=', $iUserType);

            switch ($iAgentLevel) {
                case 1:
                    $oQuery = $oQuery->whereNull('parent_id');
                    break;
                case 2:
                    $oQuery = $oQuery->whereNotNull('parent_id');
                    break;
            }
            $aUsers = $oQuery->get($aColumns);
        }

        foreach ($aUsers as $key => $value) {
            $data[$value->id] = $value->username;
        }
        return $data;
    }

    /**
     * [getRoleIds 获取用户的角色id]
     * @return [Array] [用户的角色id数组]
     */
    public function getRoleIds() {
        if (!$aRoles = RoleUser::where('user_id', '=', $this->id)->get())
            return false;
        $aRoleId = [];
        foreach ($aRoles as $oRole) {
            $aRoleId[] = $oRole->role_id;
        }
        // $aRoleId = explode(',', $this->role_ids);
        return $aRoleId;
    }

    /**
     * [getUserRoleNames 获取用户组 ]
     * @return [String]          [用户组]
     */
    public function getUserRoleNames() {
        // $aRoles = User::find($iUserId)->roles()->get();
        $aRoles = $this->roles()->get();
        $aRoleNames = [];
        foreach ($aRoles as $oRole) {
            if (in_array($oRole->role_type, [Role::ADMIN_ROLE, Role::USER_ROLE])) {
                $aRoleNames[] = $oRole->name;
            }
        }
        return implode(',', $aRoleNames);
    }

    /**
     * [getAgentDirectChildrenNum 获取代理的直属用户数量]
     * @return [Int]          [直属用户数量]
     */
    public function getAgentDirectChildrenNum() {
        // $oUser = User::find($iUserId);
        if (!$this->is_agent)
            return 0;
        $iNum = $this->children()->count();
        return $iNum;
    }

    /**
     * [getGroupAccountSum 获取代理的团队余额]
     * @param  [Boolean] [返回值类型, true: 团队余额, flase: 包含团队余额的代理用户信息]
     * @return [Float/Object]          [true: 玩家或代理团队账户余额, flase: 包含团队余额的玩家或代理信息]
     */
    public function getGroupAccountSum($bOnlySum = true) {
        // TODO 当代理下的用户数较多时，计算比较费时，需要优化
        $oAccount = Account::getAccountInfoByUserId($this->id);
        $iGroupAccountSum = $oAccount->available;
        $this->group_account_sum = $iGroupAccountSum;
        if (!$this->is_agent)
            return $bOnlySum ? $iGroupAccountSum : $this;
        // $aUsers = $this->children()->get();
        $aUserIds = self::getAllUsersBelongsToAgent($this->id);
        // pr($this->toArray());exit;
        $oAccounts = Account::getAccountInfoByUserId($aUserIds);
        if ($oAccounts && count($oAccounts)) {
            foreach ($oAccounts as $oAccount) {
                $iGroupAccountSum += $oAccount->available;
            }
        }
        $this->group_account_sum = $iGroupAccountSum;
        return $bOnlySum ? $iGroupAccountSum : $this;
    }

    public function getUserAccount(){
        return Account::getAvaliable($this->id);
    }
    
    /**
     * [getAllUsersBelongsToAgent 查询属于某代理的所有下级的id ]
     * @param  [Integer] $iAgentId [代理id]
     * @return [Array]           [id数组]
     */
    public static function getAllUsersBelongsToAgent($iAgentId) {
        $aColumns = ['id', 'username', 'is_agent'];
        $aUsers = User::whereRaw(' find_in_set(?, forefather_ids)', [$iAgentId])->get($aColumns);
        // $queries = DB::getQueryLog();
        // $last_query = end($queries);
        // pr($last_query);exit;
        $aUserIds = [];
        foreach ($aUsers as $oUser) {
            $aUserIds[] = $oUser->id;
        }
        return $aUserIds;
    }

    /**
     * [getAllUsersBelongsToAgentByUsername 按用户名称查询属于某代理的所有下级的id ]
     * @param  [Integer] $iAgentId [代理id]
     * @return [Array]           [id数组]
     */
    public static function getAllUsersBelongsToAgentByUsername($sAgentName, $bIncludeSelf = TRUE) {
        $aColumns = ['id', 'username', 'is_agent'];
        $oQuery = User::whereRaw(' find_in_set(?, forefathers)', [$sAgentName]);
        if ($bIncludeSelf) {
            $aUsers = $oQuery->orwhereRaw('username=?', [$sAgentName])->get($aColumns);
        } else {
            $aUsers = $oQuery->get($aColumns);
        }
        // $queries = DB::getQueryLog();
        // $last_query = end($queries);
        // pr($last_query);exit;
        $aUserIds = [];
        foreach ($aUsers as $oUser) {
            $aUserIds[] = $oUser->id;
        }
        return $aUserIds;
    }

    /**
     * [getUsersByIds 根据用户id数组获取用户信息]
     * @param  [Array] $aUserIds [用户id数组]
     * @param  [Array] $aColumns [要返回的列]
     * @return [Array]           [用户信息数组]
     */
    public static function getUsersByIds($aUserIds, $aColumns = null) {
        if (!$aUserIds) {
            return [];
        }
        is_array($aUserIds) or $aUserIds = explode(',', $aUserIds);
        $aColumns or $aColumns = ['id', 'username'];
        $aUsers = self::whereIn('id', $aUserIds)->get($aColumns);
        return $aUsers;
    }

    /**
     * [getUsersByUsernames 根据用户名数组获取用户信息]
     * @param  [array]   $aUsernames [用户名数组]
     * @param  [boolean] $bNeedCount [是否返回数据总数]
     * @param  [Array]  $aColumns   [要返回的列]
     * @return [type]              [用户信息数组]
     */
    public static function getUsersByUsernames(array $aUsernames, $bNeedCount = false, $aColumns = null) {
        $aColumns or $aColumns = ['id', 'username', 'is_agent', 'forefather_ids'];
        // pr($aColumns);exit;
        $oQuery = self::whereIn('username', $aUsernames);
        if ($bNeedCount)
            $result = $oQuery->count('id');
        else
            $result = $oQuery->get($aColumns);
        // if (!$bNeedCount) {
        //     $result = [];
        //     foreach ($aUsers as $oUser) {
        //         $result[$oUser->id] = $oUser->username;
        //     }
        // }

        return $result;
    }

    /**
     * [getUsersBelongsToAgent 获取代理的所有直接下级用户]
     * @return [Object]           [代理的所有直接下级用户]
     */
    public function getUsersBelongsToAgent() {
        $aColumns = ['id', 'username', 'is_agent'];
        // pr($iAgentId);
        $aUsers = $this->children()->get($aColumns);
        // pr($aUsers->toArray());exit;
        return $aUsers;
    }

    protected function beforeValidate() {
        // TIP 如果有父用户，则子用户的is_tester属性应该和父用户保持一致
        if ($this->parent_id) {
            $oParent = self::find($this->parent_id);
            $this->is_tester = $oParent->is_tester;
        }
        isset($this->is_tester) or $this->is_tester = 0;
        $this->parent_str = $this->forefather_ids;
        $this->signin_at or $this->signin_at = null;
        // $this->password              = md5(md5(md5($this->username . $this->password)));
        // $this->password_confirmation = md5(md5(md5($this->username . $this->password_confirmation)));
        // $this->account_id != 0 or $this->account_id = null;
        // TODO 激活时间, 应该是邮件激活的时间
        // $this->activated_at or $this->activated_at = Carbon::now()->toDateTimeString();
        // $this->login_ip = get_client_ip();
        // pr($this->toArray());exit;
        if ($this->id) {
            // self::$rules['username'] .= $this->id; // str_replace('{:id}', $this->id, self::$rules['username'] );
            self::$rules['username'] = 'required|alpha_num|between:6,16|unique:users,username,' . $this->id;
            // self::$rules['email']    = 'email|between:0, 50|unique:users,email,' . $this->id;
        }
        // pr($this->toArray());
        // pr(User::$rules);
        // exit;
        return parent::beforeValidate();
    }

    /**
     * 取得玩法设置数组，供渲染投注页面或奖金页面使用
     * @param int $iUserId
     * @param Lottery $oLottery
     * @param bool $bForBet
     * @return array &
     */
    public static function & getWaySettings($iUserId, $oLottery, $bForBet = false, & $sGroupName = null) {
        $iGroupId = UserPrizeSet::getGroupId($iUserId, $oLottery->id, $sGroupName);
        if (empty($iGroupId)) {
            $a = [];
            return $a;
        }
        // pr($iGroupId);exit;
        // $iGroupId = 512;
        $aPrizes = & PrizeGroup::getPrizeDetails($iGroupId);
//        pr($aPrizes);

        $fMaxPrize = $bForBet ? self::getPrizeLimit($iUserId) : null;
        return WayGroup::getWayInfos($oLottery->series_id, $aPrizes, $fMaxPrize);
    }

    public static function & getPrizeSettingsOfUser($iUserId, $iLotteryId, & $sGroupName) {
        $iGroupId = UserPrizeSet::getGroupId($iUserId, $iLotteryId, $sGroupName);
        if (empty($iGroupId)) {
            $aPrizes = [];
        } else {
            $aPrizes = & PrizeGroup::getPrizeDetails($iGroupId);
        }
        return $aPrizes;
    }

    //手机端用
    public static function & getPrizeSettings($iUserId, $iLotteryId, & $sGroupName) {
        $oLottery = Lottery::find($iLotteryId);
        $iGroupId = UserPrizeSet::getGroupId($iUserId, $iLotteryId, $sGroupName);
        $sGroupName < SysConfig::readValue('bet_max_prize_group') or $sGroupName = SysConfig::readValue('bet_max_prize_group');
        $oGroup = PrizeGroup::getObjectByParams(['series_id' => $oLottery->series_id, 'classic_prize' => $sGroupName]);
        $iGroupId = $oGroup->id;
        if (empty($iGroupId)) {
            $aPrizes = [];
        } else {
            $aPrizes = & PrizeGroup::getPrizeDetails($iGroupId);
        }
        return $aPrizes;
    }

    /**
     * 取得奖金限额
     *
     * @param int $iUserId
     * @return int
     */
    public static function getPrizeLimit($iUserId) {
        return SysConfig::readValue('bet_max_prize');
    }

    /**
     * [checkUserBelongsToAgent 检查用户是否属于当前登录的代理]
     * @param  [Integer] $iUserId [用户ID]
     * @return [Boolean]          [true/false: 属于/不属于]
     */
    public function checkUserBelongsToAgent($iUserId, $bDirect = false) {
        // $iUserId or $iUserId = Session::get('user_id');
        if ($this->is_agent) {
            // $oUser = User::find($iUserId);
            $oToCheckUser = self::find($iUserId);
            if ($bDirect) {
                return $oToCheckUser->parent_id == $this->id;
            }
            if (!$oToCheckUser->forefather_ids) {
                return false;
            }
            $aForeIds = explode(',', $oToCheckUser->forefather_ids);
            return in_array($this->id, $aForeIds);
//            $aUsers   = $this->getUsersBelongsToAgent();
//            $aUserIds = [];
//            foreach ($aUsers as $oUser) {
//                $aUserIds[] = $oUser->id;
//            }
//            return in_array($iUserId, $aUserIds);
        }
        return false;
    }

    /**
     * [getTopAgentPrizeGroupDistribution 按奖金组分组查询总代用户]
     * @return [Collection] [用户集合]
     */
    public static function getAgentPrizeGroupDistribution($iParentId) {
        $aColumns = ['prize_group', 'num'];
        $oQuery = self::selectRaw(' *, count(distinct id) as num ');
        $iParentId == self::TYPE_AGENT or $oQuery = $oQuery->whereNull('parent_id');
        $oQuery = $oQuery->where('is_tester', '=', '0')->groupBy('prize_group')->orderBy('prize_group', 'desc');
        return $oQuery->get($aColumns);
    }

    /**
     * [getUserLevelAttribute 获取用户级别]
     * @return [Integer] [用户级别]
     */
    protected function getUserLevelAttribute() {
        if (is_null($this->parent_id)) {
            return 0;
        }
        return count(explode(',', $this->forefather_ids));
    }

    /**
     * [getExpirenceAgent 获取体验账户的虚拟总代]
     * @return [Object] [虚拟总代对象]
     */
    public static function getExpirenceAgent() {
        $aColumns = ['id', 'username', 'is_agent', 'is_tester', 'prize_group'];
        return self::find(Config::get('vagent.user_id'), $aColumns);
    }

    /**
     * [getUserByParams 根据参数查询用户对象]
     * @param  [Array] $aParams [参数数组]
     * @param  [Array] $aInSetKeys [需要使用find_in_set函数的查询条件的key值数组]
     * @return [Object]          [用户对象]
     */
    public static function getUserByParams(array $aParams = ['*'], $aInSetKeys) {
        $oQuery = self::where('id', '>', 0);
        foreach ($aParams as $key => $value) {
            if (in_array($key, $aInSetKeys)) {
                $oQuery = $oQuery->whereRaw(' find_in_set(?, ' . $key . ')', [$value]);
            } else {
                $oQuery = $oQuery->where($key, '=', $value);
            }
        }
        return $oQuery->get()->first();
    }

    /**
     * [generateAccountInfo 根据用户对象创建账户对象]
     * @return [Object]        [账户对象]
     */
    public function generateAccountInfo() {
        $oAccount = new Account;
        $oAccount->user_id = $this->id;
        $oAccount->username = $this->username;
        $oAccount->is_tester = $this->is_tester;
        $oAccount->withdrawable = 0;
        $oAccount->status = 1;
        return $oAccount;
    }

    /**
     * [generateUserInfo 生成新建用户的信息]
     * @param [String] $sPrizeGroup [如果是代理, 则prize_group为其奖金组, 玩家有多种奖金组, 所以置空值]
     * @param [Array] $data         [表单参数]
     * @return [Array]              [生成成功/失败提示信息]
     */
    public function generateUserInfo($sPrizeGroup, $data) {
        // $data              = trimArray(Input::except(['captcha', 'prize', '_token', '_random']));
        $data['username'] = strtolower($data['username']);
        (isset($data['nickname']) && $data['nickname']) or $data['nickname'] = $data['username']; // TODO 页面没有填写nickname字段，先用username替代nickname
        (isset($data['fund_password']) && $data['fund_password']) or $data['fund_password'] = '';
        // TIP 此处的prize_group实际是prize_groups表的classic_prize字段
        !$sPrizeGroup or $data['prize_group'] = $sPrizeGroup;
        $data['register_ip'] = get_client_ip();
        $data['register_at'] = date('Y-m-d H:i:s');
        // pr($data);
        // 验证成功，添加用户
        $this->fill($data);
        // pr($this->toArray());exit;
        // TODO 这两个字段不能为空, parent_str可能已经被弃用, 后续可以考虑写到User模型的beforeValidate里
        $this->parent_str = $this->forefather_ids;
        $aReturnMsg = ['success' => true, 'msg' => __('_user.user-info-generated')];
        if ($this->password) {
            $aReturnMsg = $this->generatePasswordStr(1);
            if ($aReturnMsg['success']) {
                $this->password = $aReturnMsg['msg'];
                $aReturnMsg['msg'] = __('_user.password-generated');
            }
            unset($this->password_confirmation);
        } else {
            return ['success' => false, 'msg' => __('_user.no-password')];
        }
        // if ($this->fund_password) {
        //     $aReturnMsg = $this->generatePasswordStr(2);
        //     if ( $aReturnMsg['success'] ) {
        //         $this->fund_password = $aReturnMsg['msg'];
        //         $aReturnMsg['msg'] = __('_user.fund-password-generated');
        //     }
        //     unset($this->fund_password_confirmation);
        // }
        // pr($this->toArray());exit;

        return $aReturnMsg;
    }

    /**
     * [generateLotteryPrizeGroup 创建所有彩种奖金组]
     * @param  [Array] $aPrizeGroup [链接开户的奖金组配置]
     * @return [Array]              [彩种奖金组]
     */
    public function generateLotteryPrizeGroup($aPrizeGroup) {
        $data = [];
        $oSeries = new Series;
        $aSeriesLinkTo = $oSeries->getValueListArray('link_to', [], [], true);
        if (isset($aPrizeGroup[0]->lottery_id)) {
            // 玩家开户
            $aLotteryPrizeGroups = [];
            $aLotteriesGroupBySeries = Lottery::getAllLotteries();
            // pr($aLotteriesGroupBySeries);exit;
            foreach ($aLotteriesGroupBySeries as $key => $value) {
                // 考虑彩系link_to属性
                if ($aSeriesLinkTo[$value['series_id']]) {
                    $value['series_id'] = $aSeriesLinkTo[$value['series_id']];
                }
                $data[$value['id']] = $value;
            }
            // pr($data);exit;
            foreach ($aPrizeGroup as $key => $value) {
                if (array_key_exists($value->lottery_id, $data)) {
                    $aLotteryPrizeGroups[] = [
                        'series_id' => $data[$value->lottery_id]['series_id'],
                        'lottery_id' => $value->lottery_id,
                        'classic_prize' => $value->prize_group
                    ];
                }
            }
            // $aLotteryPrizeGroups = $aPrizeGroup;
        } else {
            // 代理开户
            $aSeriesLotteries = Series::getLotteriesGroupBySeries();
            $aLotteryPrizeGroups = [];
            // pr($aSeriesLotteries);exit;
            foreach ($aSeriesLotteries as $key => $value) {
                $data[$value['id']] = $value['children'];
            }
            // pr($data);exit;
            foreach ($aPrizeGroup as $key => $value) {
                if (isset($data[$value->series_id])) {
                    foreach ($data[$value->series_id] as $key2 => $aLottery) {
                        // pr($key2);
                        // pr($aLottery);
                        // exit;
                        $aLotteryPrizeGroups[] = [
                            'series_id' => $value->series_id,
                            'lottery_id' => $aLottery['id'],
                            'classic_prize' => $value->prize_group
                        ];
                    }
                }
            }
        }
        return $aLotteryPrizeGroups;
    }

    /**
     * [generateUserPrizeGroups 生成用户的所有彩种的奖金组数据]
     * @param  [Array] $aLotteryPrizeGroups [所有彩种的奖金组数据]
     * @return [Array]                      [用户的奖金组数据]
     */
    public function generateUserPrizeGroups($aLotteryPrizeGroups) {
        $aUserPrizeGroups = [];
        $aParams = array_column($aLotteryPrizeGroups, 'classic_prize');
        $aGroups = PrizeGroup::getPrizeGroupsWithOnlyKey($aParams);
        foreach ($aLotteryPrizeGroups as $value) {
            $oUserPrizeSet = new UserPrizeSet;
            $key = $value['series_id'] . '_' . $value['classic_prize'];
            $data = [
                'user_id' => $this->id,
                'user_parent_id' => $this->parent_id,
                'user_parent' => $this->parent,
                'username' => $this->username,
                'is_agent' => $this->is_agent,
                'lottery_id' => $value['lottery_id'],
                'prize_group' => $aGroups[$key]['name'],
                'group_id' => $aGroups[$key]['id'],
                'classic_prize' => $value['classic_prize'],
            ];
            $aUserPrizeGroups[] = $data;
        }
        return $aUserPrizeGroups;
    }

    public static function getAllUserArrayByUserType($iUserType = self::TYPE_USER, $aExtraColumn = []) {
        $aColumns = ['id', 'username', 'blocked', 'parent_id', 'parent', 'account_id', 'prize_group'];
        $aColumns = array_merge($aColumns, $aExtraColumn);
        if ($iUserType == 'all') {
            $aUsers = User::all($aColumns);
        } else {
            if ($iUserType == self::TYPE_TOP_AGENT) {
                $oQuery = User::where('is_agent', '=', self::TYPE_AGENT)->whereNull('parent_id');
            } else {
                $oQuery = User::where('is_agent', '=', $iUserType);
            }
            $aUsers = $oQuery->get($aColumns);
        }
        return $aUsers;
    }

    /**
     * 根据用户名查找
     *
     * @param $username
     * @return \LaravelBook\Ardent\Ardent|\LaravelBook\Ardent\Collection|static
     */
    public static function findUser($username) {
        if (static::$cacheLevel == self::CACHE_LEVEL_NONE) {
            return parent::where('username', '=', $username)->first();
        }
        Cache::setDefaultDriver(static::$cacheDrivers[static::$cacheLevel]);

        $key = self::createCacheKey($username);
        if ($aAttributes = Cache::get($key)) {
            $obj = new static;
            $obj = $obj->newFromBuilder($aAttributes);
        } else {
            $obj = parent::where('username', '=', $username)->first();
            if (!is_object($obj)) {
                return false;
            }
            Cache::forever($key, $obj->getAttributes());
        }

        return $obj;
    }

    /**
     * 保存之后出发的事件
     *
     * @param $oSavedModel
     * @return bool
     */
    protected function afterSave($oSavedModel) {
        $this->deleteCache($this->username);
        return parent::afterSave($oSavedModel);
    }

    public function setBetParams($iMultiple, $fCoefficient) {
        if ($this->bet_multiple == $iMultiple && $this->bet_coefficient == $fCoefficient) {
            return true;
        }
        $data = [
            'bet_multiple' => $iMultiple,
            'bet_coefficient' => $fCoefficient,
        ];
        if ($bSucc = $this->where('id', '=', $this->id)->update($data)) {
            $this->bet_multiple = $iMultiple;
            $this->bet_coefficient = $fCoefficient;
        }
        return $bSucc;
    }

    public function & getDirectChildrenArray() {
        $oChildrens = self::where('parent_id', '=', $this->id)->orderBy('username', 'asc')->get(['id', 'username']);
        $aChildren = [];
        foreach ($oChildrens as $oChildren) {
            $aChildren[$oChildren->id] = $oChildren->username;
        }
        return $aChildren;
    }

    public function isChild($iUserId, $bDirect = true, & $oChildren = null) {
        $oUser = $oChildren = User::find($iUserId);
        if (empty($oUser)) {
            return false;
        }
        if (!$oUser->parent_id) {
            return false;
        }
        if ($bDirect) {
            return $oUser->parent_id == $this->id;
        } else {
            if ($oUser->forefather_ids) {
                $aForeId = explode(',', $oUser->forefather_ids);
                return in_array($this->id, $aForeId);
            }
        }
    }

    public function getTopAgentId() {
        if (!$this->parent_id) {
            return $this->id;
        } else {
            $aFores = explode(',', $this->forefather_ids);
            return $aFores[0];
        }
    }

    public function getTopAgentUserName() {
        if (!$this->parent_id) {
            return $this->username;
        } else {
            $aFores = explode(',', $this->forefathers);
            return $aFores[0];
        }
    }

    public static function getRegisterCount($sDate, $bOnlyTop = false) {
        $sSql = "select count(distinct id) count from users where register_at between '$sDate' and '$sDate 23:59:59' and is_tester = 0";
        !$bOnlyTop or $sSql .= " and parent_id is null";
        $aResults = DB::select($sSql);
        return $aResults[0]->count ? $aResults[0]->count : 0;
    }

    /**
     * 团队：代理的注册人数
     * @param $fatherId
     * @return int
     */
    public static function getRegisterNums($parentId, $sBeginDate) {
        return self::whereRaw(' find_in_set(?, forefather_ids)', [$parentId])->where('register_at', '>=', $sBeginDate)->count();
    }
    
    public static function getMaxPrizeGroupByParentId($iParentId) {
        $iResult = self::where('is_agent', '=', '1')->where('parent_id', '=', $iParentId)->max('prize_group');
//             $queries = DB::getQueryLog();
//             $last_query = end($queries);
//             pr($last_query);exit;
        return $iResult;
    }

    public static function compileUserSessionKey($username) {
        return self::getCachePrefix(true) . 'serssion-' . $username;
}

    public static function userLogout($username) {
        $userSessionKey = self::compileUserSessionKey($username);
        $redis = Redis::connection();
        if ($redis->exists($userSessionKey)) {
            $userSession = $redis->get($userSessionKey);
            if ($redis->exists($userSession)) {
                $redis->del($userSession);
            }
        }
    }

    public function createDailySalaryProtocal() {
        $oDSP = new DailySalaryProtocal();
        $oDSP->user_id = $this->id;
        $oDSP->username = $this->username;
        $oDSP->is_tester = $this->is_tester;
        $oDSP->status = DailySalaryProtocal::STATUS_NEW_CREATE;
        $oDSP->parent_id = $this->parent_id;
        $oDSP->parent_name = $this->parent;
        $oDSP->user_forefather_ids = $this->forefather_ids;
        $oDSP->max_salary = 0;
        $oDSP->turnover_limit = 0;
        return $oDSP->save();
    }

    /**
     * 获取代理团队的用户ID
     * @param $fatherId
     * @return array|null
     */
    public static function getTeamAgentUserIds($fatherId) {
        $aColumns = ['id', 'username', 'is_agent'];
        $aUsers = User::whereRaw(' find_in_set(?, forefather_ids)', [$fatherId])->where('is_agent', '=', self::TYPE_AGENT)->get($aColumns)->toArray();

        return $aUsers ? array_column($aUsers, 'id') : null;
    }
    
}
