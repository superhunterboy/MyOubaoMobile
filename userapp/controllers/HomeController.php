<?php

# 首页

class HomeController extends UserBaseController {

    protected $modelName = 'UserMessage';

    public function beforeRender() {
        parent::beforeRender();
    }

    /**
     * [getIndex 首页，输出首页需要渲染的参数]
     * @return [type] [description]
     */
    public function getIndex() {
        if (SysConfig::readValue('daily_maintence')) {
            return View::make('authority.maintence');
        }
        $this->beforeRender();
        $iUserId = Session::get('user_id');
//        $aLatestProjects = UserProject::getLatestRecords($iUserId, 8);
//        $aLatestTraces = UserTrace::getLatestRecords($iUserId, 8);
//        $aTransactionTypes = TransactionType::getAllTransactionTypesArray();
//        $aLatestTransactions = UserTransaction::getLatestRecords($iUserId, 8);
        $aLatestAnnouncements = CmsArticle::getLatestRecords(null, 10);
        $aPrizePrj = PrjPrizeSet::getPrizeDetails(25);
        $aLotteries = Lottery::getLotteryList();

//        $aADInfo = AdInfo::getLatestRecords();
        //获取用户销售总额
//        $fTotalTurnover = number_format(UserUserProfit::getUserTotalTeamTurnover(Session::get('user_id')), 2);

        $oUser = User::find(Session::get('user_id'));
//        $sCurrentDate = date('Y-m-d');
//        $oUser = User::find(Session::get('user_id'));
        if (!is_object($oUser)) {
            $this->goBack('error', '_user.missing-user');
        }
        //统一设置安全等级
        $iUserBankCardCount = UserUserBankCard::getUserBankCardsCount($iUserId);
        $iSafeRate = 2;
        $iUserBankCardCount <= 0 or $iSafeRate++;
        !$oUser->fund_password or $iSafeRate++;

        //获取可领红包个数
        $iHongBaoCount = ActivityUserPrize::getAvailableHBCount($iUserId);

        $this->setVars('currentPrizeSet', $oUser->prize_group);
        $bFirstLogin = Session::get('first_login');
        Session::forget('first_login');
        $sViewFileName = 'index';
//        $fAvailable = formatNumber(Account::getAvaliable(Session::get('user_id')), 2);
        return View::make($sViewFileName)->with($this->viewVars + compact('bFirstLogin', 'aLatestAnnouncements', 'aADInfo', 'aPrizePrj', 'aLotteries', 'fAvailable', 'iSafeRate', 'iHongBaoCount', 'iUserBankCardCount', 'oUser'));
    }

}
