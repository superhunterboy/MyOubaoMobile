<?php

/**
 * 更新用户月盈亏表
 *
 * @author white
 */
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class UpdateUserMonthProfitCommand extends BaseCommand {
    /**
     * command name.
     *
     * @var string
     */
    protected $name = 'stat:update-user-month-profit';

    /**
     * The activity cash back description.
     *
     * @var string
     */
    protected $description = 'Update the user month profit data';
    
    public function doCommand(& $sMsg = null) {
        $iYear = $this->argument('year');
        $iMonth = $this->argument('month');
        $sMonth = $iYear . '-' . str_pad($iMonth, 2, '0', STR_PAD_LEFT);
//        $iBeginTime or die("Invalid Begin Date\n");
//        $iEndTime or die("Invalid End Date\n");
//        $iEndTime >= $iBeginTime or die("End Date Less Than Begin Date!\n");
        
//        for($iTime = $iBeginTime; $iTime <= $iEndTime;$iTime += 3600 * 24){
//            $sDate = date('Y-m-d', $iTime);
////            continue;
////            pr($sDate);
//            pr($oProfit->toArray());
            $aData = & $this->getMonthSumData($sMonth);
//            $aData = & $this->countData($aUserProfits);
//            pr($aData);
//            exit;
            foreach($aData as $obj){
                $oMonthProfit = UserMonthProfit::getUserMonthProfitObject($iYear, $iMonth, $obj->user_id);
                $oMonthProfit->fill(objectToArray($obj));
                $oMonthProfit->save();
//                pr($oMonthProfit->toArray());
//                pr($oMonthProfit->validationErrors->toArray());
            }
            exit;
            if ($aData){
                $oMonthProfit = UserMonthProfit::getUserMonthProfitObject($iYear, $iMonth, $iUserId);
                $oMonthProfit->fill($aData);
                $oMonthProfit->calculateProfit();
                $oMonthProfit->save();
            }
//            $oProfit->update($aData);
//        }
    }

    protected function & getMonthSumData($sMonth){
        $sSql = "select user_id,sum(deposit) deposit, sum(withdrawal) withdrawal, sum(turnover) turnover, sum(prize) prize, sum(bonus) bonus, sum(commission) commission, sum(profit) profit "
                . " from user_profits where date like '$sMonth%' group by user_id";
        $aResults = DB::select($sSql);
        pr($aResults);
        return $aResults;
    }
    
    protected function & countData($aUserProfits){
        $aData = [];
        foreach($aUserProfits as $oUserProfit){
            if (isset($aData[$oUserProfit->user_id])){
                $aData[$oUserProfit->user_id]['deposit'] += $oUserProfit->deposit;
                $aData[$oUserProfit->user_id]['withdrawal'] += $oUserProfit->withdrawal;
                $aData[$oUserProfit->user_id]['turnover'] += $oUserProfit->turnover;
                $aData[$oUserProfit->user_id]['deposit'] += $oUserProfit->deposit;
                $aData[$oUserProfit->user_id]['prize'] += $oUserProfit->prize;
                $aData[$oUserProfit->user_id]['bonus'] += $oUserProfit->bonus;
                $aData[$oUserProfit->user_id]['commission'] += $oUserProfit->commission;
                $aData[$oUserProfit->user_id]['profit'] += $oUserProfit->profit;
            }
            else{
                $data = objectToArray($aUserProfits);
                unset($data['user_id']);
                $aData[$oUserProfit->user_id] = $data;
            }
        }
        return $data;
    }
    protected function queryTotalAmount($sDate, $aTransactionTypes, $bOnlyTester = false){
        $sTransactionTypes = implode(',',$aTransactionTypes);
        $sSql = "select sum(amount) total_amount from transactions where type_id in ($sTransactionTypes) and created_at between '$sDate' and '$sDate 23:59:59'";
        !$bOnlyTester or $sSql .= ' and is_tester = 1';
        $aResults = DB::select($sSql);
        return $aResults[0]->total_amount ? $aResults[0]->total_amount : 0;
    }

    protected function queryPrjCount($sDate, $bOnlyTester = false){
        $sSql = "select count(*) prj_count from projects where status <> " . Project::STATUS_DROPED . " and bought_at between '$sDate' and '$sDate 23:59:59'";
        !$bOnlyTester or $sSql .= ' and is_tester = 1';
        $aResults = DB::select($sSql);
        return $aResults[0]->prj_count ? $aResults[0]->prj_count : 0;
    }
    
    protected function getArguments() {
        return array(
//            array('lottery_id', InputArgument::REQUIRED, null),
            array('year', InputArgument::OPTIONAL, null, date('Y')),
            array('month', InputArgument::OPTIONAL, null, date('n', time() - 3600 * 24)),
        );
    }

}
