<?php

# 首页

class MobileHomeH5Controller extends UserBaseController {

    protected $modelName = 'UserMessage';

    public function beforeRender() {
        parent::beforeRender();
    }

    /**
     * [getIndex 首页，输出首页需要渲染的参数]
     * @return [type] [description]
     */
    public function getIndex() {
//        if (SysConfig::readValue('daily_maintence')) {
//            return View::make('authority.maintence');
//        }
        $this->beforeRender();
        $iUserId = Session::get('user_id');
        $aPrizePrj = PrjPrizeSet::getPrizeDetails(25);
        $aLotteries = Lottery::getLotteryList();
        $oUser = User::find(Session::get('user_id'));
        if (!is_object($oUser)) {
            $this->goBack('error', '_user.missing-user');
        }

        $aLastIssue = Issue::getLastWnNumber(1);
        $aHotLottery = [
            '1' => 'CQSSC',
            '12' => 'PLW',
            '13' => 'CCFFC',
            '14' => 'CC115',
            '15' => 'JSK3',
            '6' => 'XJSSC',
        ];
        return View::make('home')->with($this->viewVars + compact('bFirstLogin', 'aPrizePrj', 'aLotteries', 'oUser', 'aLastIssue', 'aHotLottery'));
    }

}
