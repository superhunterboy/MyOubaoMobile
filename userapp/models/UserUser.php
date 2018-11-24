<?php
class UserUser extends User {

    protected static $cacheUseParentClass = true;
    protected $isAdmin = false;

    public static $customMessages = [
        'username.required'               => '请填写用户名',
        'username.alpha_num'              => '用户名只能由大小写字母和数字组成',
        'username.between'                => '用户名长度有误，请输入 :min - :max 位字符',
        'username.unique'                 => '用户名已被注册',
        'username.custom_first_character' => '首字符必须是英文字母',
        'nickname.required'               => '请填写昵称',
        'nickname.between'                => '用户昵称长度有误，请输入 :min - :max 位字符',
        'password.custom_password'        => '密码由字母和数字组成, 且需同时包含字母和数字, 不允许连续三位相同',
//        'password.confirmed'              => '密码两次输入不一致',
        'fund_password.custom_password'   => '资金密码由字母和数字组成, 且需同时包含字母和数字, 不允许连续三位相同',
        'fund_password.confirmed'         => '资金密码两次输入不一致',
        // 'email.required'                  => '请填写邮箱地址',
    ];

    /**
     * 生成用户唯一标识
     * @return string
     */
    protected function getUserFlagAttribute()
    {
        $iUserId = $this->id;
        // $sRange = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $sRange = 'GqNbzewIF6kfx5mYaAnBEUvMuJyH8o9D7XcWt0hiQKOgRLdlSPpsC2jZ143rTV'; // 使用乱序字串
        if($iUserId == 0)
        {
            return $sRange[0];
        }
        $iLength = strlen($sRange);
        $sStr = ''; // 最终生成的字串
        while ($iUserId > 0)
        {
            $sStr = $sRange[$iUserId % $iLength]. $sStr;
            $iUserId = floor($iUserId / $iLength);
        }
        return $sStr;
    }

    /**
     * [getRegistPrizeGroup 获取注册用户的奖金组信息]
     * @param  [String] $sPrizeGroup [链接开户特征码]
     * @param  &      $aPrizeGroup [奖金组数组的引用]
     * @param  &      $oPrizeGroup [奖金组对象的引用]
     * @return [type]              [description]
     */
    public static function getRegistPrizeGroup($sPrizeGroup = null, & $aPrizeGroup, & $oPrizeGroup, & $aPrizeSetQuota) {
        // pr($sPrizeGroup);exit;
        // 如果不是链接开户的注册，提供默认奖金组供注册用
        if (!$sPrizeGroup) {
            $aLotteries = & Lottery::getTitleList();
            $oExpirenceAgent = User::getExpirenceAgent();
            if (!$oExpirenceAgent) {
                return false;
            }
            $iPrizeGroup = $oExpirenceAgent->prize_group;
            // $aPrizeGroup = [];
            foreach ($aLotteries as $key => $value) {
                $aPrizeGroup[] = arrayToObject(['lottery_id' => $key, 'prize_group' => $iPrizeGroup]);
            }
            // 模拟oPrizeGroup对象
            $oPrizeGroup = $oExpirenceAgent;
            $oPrizeGroup->is_admin = 0;
            $oPrizeGroup->is_agent = 0;
            $oPrizeGroup->user_id = $oExpirenceAgent->id;
        } else {
            $oPrizeGroup = UserRegisterLink::getRegisterLinkByPrizeKeyword($sPrizeGroup);
            // TODO 此处注册失败的具体条件后续可以改进
            if (!$oPrizeGroup) {
                return false;
            }
            $aPrizeSetQuota = objectToArray( json_decode($oPrizeGroup->agent_prize_set_quota));
            // 总代开户链接只能使用一次
            if ($oPrizeGroup->is_admin && $oPrizeGroup->created_count) {
                return false;
                // return Redirect::back()->withInput()->with('error', '该链接已被使用。');
            }
            $aPrizeGroup = json_decode($oPrizeGroup->prize_group_sets);
            
        }
        return true;
    }
}