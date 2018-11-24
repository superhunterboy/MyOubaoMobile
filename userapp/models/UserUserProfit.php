<?php

/**
 * 用户盈亏表
 *
 * @author snowan
 */
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class UserUserProfit extends UserProfit {
    public static function getUserTotalTeamTurnover($iUserId, $iDays = 7){
        $oCarbon = Carbon::now();
        $sEndDate = $oCarbon->toDateString();
//        $iDays--;
        $oCarbon->addDays(- --$iDays);
        $sBeginDate = $oCarbon->toDateString();
        $sSql = "select sum(turnover) turnover from user_profits where user_id = $iUserId and date between '$sBeginDate' and '$sEndDate'";
        $aResults = DB::select($sSql);
        return $aResults[0]->turnover ? $aResults[0]->turnover : 0;
    }
}