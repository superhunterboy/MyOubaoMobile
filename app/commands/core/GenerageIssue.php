<?php

/**
 * 生成奖期
 *
 * @author white
 */
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class GenerageIssue extends BaseCommand {
    protected $sFileName = 'GenerateIssue';
    protected $name = 'issue:generate';
    protected $description = 'generate issues';
    public $writeTxtLog    = true;
    private $checkDays = [ 50, 5 ];
    
    public function doCommand(& $sMsg = null){
        $iLotteryId = $this->argument('lottery_id');
        $oLottery = ManLottery::find($iLotteryId);
        $this->writeLog("Generate Issue For Lottery: $iLotteryId");
        if (empty($oLottery)) {
            $sMsg = "Lottery $iLotteryId not Exists!";
            return;
        }
        $this->writeLog("Lottery: $oLottery->name");
        $bAccumulating = $oLottery->isAccumulating();
//        $oLastIssue = self::getla
//        pr($oLottery->toArray());
        $oExistLastIssue = ManIssue::getLastIssueObject($iLotteryId);
//        pr($oExistLastIssue->toArray());
        $iNeedDays = $this->checkDays[$oLottery->high_frequency];
        if (!empty($oExistLastIssue)){
            $sBeginDate = $oLottery->getNextDay($oExistLastIssue->end_time);
            !$bAccumulating or $sBeginIssue = $oExistLastIssue->issue + 1;
            $iLastEndTime = $oExistLastIssue['end_time'];
            if ($iLastEndTime - time() > $iNeedDays * 3600 * 24){
                $sMsg = "The Issues of $oLottery->name are enough, exiting";
                return;
            }
            $sLastIssue = $oExistLastIssue->issue;
        }
        else{
            if ($bAccumulating && empty($sBeginIssue)){
                $sMsg = "The Issue of $oLottery->name is Accumulating, need Begin Issue exiting";
                return;
            }
            if (empty($sBeginDate)){
                $sBeginDate = Carbon::now()->toDateString();
            }
            $iLastEndTime = null;
            $sLastIssue = null;
        }
        $oBeginDate = new Carbon($sBeginDate);
        $oEndDate = $oLottery->high_frequency ? $oBeginDate->endOfMonth() : $oBeginDate->endOfYear();
//        $oEndDate = $oBeginDate->addDays(1);
//        pr($oEndDate);
//        exit;
        $sEndDate = $oEndDate->toDateString();
//        $iBeginDate = strtotime($sBeginDate);
//        $iEndDate = strtotime($sEndDate);
//        pr($sBeginDate);
//        pr($sEndDate);
        $DB          = DB::connection();
        $DB->beginTransaction();
        $this->writeLog("Start Generate, From $sBeginDate to $sEndDate, Generating...");
        if (!$bsucc = ManIssue::generateIssues($oLottery, $sBeginDate, $sEndDate, $iLastEndTime, $sLastIssue, null, $iCount)){
            $DB->rollback();
            $sMsg = "Generate Failed";
        }
        else{
            $DB->commit();
            $sMsg = "Generated, Total $iCount Issues";
        }
        return;
//        $sMsg = $sMsg;
        
//        $oIssueRules = IssueRule::getIssueRulesOfLottery($oLottery->id);
//        pr($oIssueRules->toArray());
//        for($i = 0, $iDate = $iBeginDate; $iDate <= $iEndDate; $i++, $iDate += 3600 * 24){
//            $aIssues = [];
//            foreach($oIssueRules as $oIssueRule){
//                $sDate = date('Y-m-d', $iDate);
//                $iLastEndTime or $iLastEndTime = strtotime($sDate . ' ' . $oIssueRule->begin_time);
//                $sFirstIssueEndTime = $sDate . $oIssueRule->first_time;
//                $iFirstIssueEndTime = strtotime($sFirstIssueEndTime);
//                $iStopTime = strtotime($sDate . ' ' . $oIssueRule->end_time);
//                $iStopTime > $iFirstIssueEndTime or $iStopTime += 3600 * 24;
////                pr($iFirstIssueEndTime);
////                pr($iStopTime);
////                exit;
//                for($iTime = $iFirstIssueEndTime; $iTime <= $iStopTime; $iTime += $oIssueRule->cycle){
//                    $iEndTime = $iTime - $oIssueRule->stop_adjust_time;
////                    $sIssue = $sLastIssue = self::getNextIssue($oLottery->issue_format, $sLastIssue, $iDate, false);
//
//                    $iYear = date('Y', $iDate);
//                    $sIssue = str_replace('(M)', date('m', $iDate), $oLottery->issue_format);
//                    $sIssue = str_replace('(D)', date('d', $iDate), $sIssue);
//                    $sIssue = str_replace('(Y)', $iYear, $sIssue);
//                    $sIssue = str_replace('(y)', substr($iYear, 2), $sIssue);
//                    preg_match_all("/\([N,T,C](.*)\)/", $sIssue, $aIssueOrder);
//                    $iIssueOrderLength = $aIssueOrder[1][0];
////                    pr($iIssueOrderLength);
////                    exit;
////                    pr($iTime);
////                    pr($iFirstIssueEndTime);
////                    pr($iTime == $iFirstIssueEndTime);
//                    if (!$bAccumulating && $iTime == $iFirstIssueEndTime){
//                        $sLastIssueOrder = 0;
//                    }
//                    else {
//                        $sLastIssueOrder = substr($sLastIssue, strlen($sLastIssue) - $iIssueOrderLength, $iIssueOrderLength);
//                    }
//                    $sNextIssueOrder = $sLastIssueOrder + 1;
//            //        $sNextIssueOrder = (string) $sNextIssueOrder;
//
//                    $sNextIssueOrder = str_pad($sNextIssueOrder, $iIssueOrderLength, 0, STR_PAD_LEFT);
//            //        pr($sNextIssueOrder);
//                    $sIssue = $sLastIssue = preg_replace("/\([N,T,C](.*)\)/", $sNextIssueOrder, $sIssue);
//                    
//                    $aIssues[] = [
//                        'lottery_id' => $oLottery->id,
//                        'issue' => $sIssue,
//                        'issue_rule_id' => $oIssueRule->id,
//                        'begin_time' => $iLastEndTime,
//                        'end_time' => $iEndTime,
//                        'end_time2' => date('Y-m-d H:i:s',$iEndTime),
//                        'offical_time' => $iTime,
//                        'cycle' => $oIssueRule->cycle,
//                        'allow_encode_time' => $iTime + $oIssueRule->encode_time,
//                        'status' => self::ISSUE_CODE_STATUS_WAIT_CODE,
//                        'created_at' => $sCreatedTime = date('Y-m-d H:i:s'),
//                        'updated_at' => $sCreatedTime,
//                    ];
//                    $iLastEndTime = $iEndTime;
//                }
//            }
//            self::saveAllIssues($aIssues);
////            break;
//        }
//        pr($aIssues);
    }

    protected function getArguments() {
        return array(
//            array('lottery_id', InputArgument::REQUIRED, null),
            array('lottery_id', InputArgument::OPTIONAL, null, 1),
        );
    }

}
