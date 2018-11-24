<?php

/**
 * generate winning-number for self lotteries
 *
 * @author white
 */
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class GenerateNumber extends BaseCommand {
    protected $sFileName = 'GenerateNumber';
    protected $name = 'number:generate';
    protected $description = 'generate winning-number for self lotteries';
    public $writeTxtLog    = true;
    protected $tryTimes = 15;
    protected $betweenSeconds = 0.5;
    
    protected function fire(){
        $this->logFileParam[] = $this->params['lottery_id'] = $this->argument('lottery_id');
        $this->params['count']     = $this->argument('count');
        parent::fire();
    }

    public function doCommand(& $sMsg = null) {
        $iLotteryId = $this->params['lottery_id'];
        $iCount = $this->params['count'];
//        pr($iLotteryId);
//        pr($iCount);
        $oLottery   = ManLottery::find($iLotteryId);
        if (!$oLottery->is_self) {
            $this->writeLog($oLottery->name . ' Is Not Self ');
            exit;
        }
//        pr($oLottery->toArray());
//        $oToolIssue = new ManIssue;
//        sleep(1);
        $this->writeLog('Generate Winning Number for ' . $oLottery->name);
        $i = 0;
        do {
            !$i or usleep($this->betweenSeconds * 1000000);
            $oIssues    = ManIssue::getNonNumberIssues($iLotteryId, $iCount);
//            pr($oIssues->count());
        } while (!$oIssues->count() && (++$i < $this->tryTimes));
        if (!$oIssues->count()){
            $this->writeLog('No Issue, Exiting');
            exit;
        }
        foreach ($oIssues as $oIssue) {
            $this->writeLog('Issue: ' . $oIssue->issue);
            $this->writeLog('End Time: ' . $oIssue->end_time2);
            if ($oIssue->status != ManIssue::ISSUE_CODE_STATUS_WAIT_CODE) {
                $this->writeLog('Status Error, Exiting');
                continue;
            }
            $sCode = $oLottery->compileWinningNumber();
            $this->writeLog('Number: ' . $sCode);
            if (!$oLottery->checkWinningNumber($sCode)) {
                $this->writeLog('InValud Number, Exiting');
                continue;
            }
            do {
                $bSucc = $oIssue->setWinningNumber($sCode) === true;
                $this->writeLog('Set Wn Number: ' . $bSucc);
                if ($bSucc === true) {
                    $oIssue->addCalculateTask();
                }
            } while (!$bSucc);
        }
    }

    protected function getArguments() {
        return array(
            array('lottery_id', InputArgument::REQUIRED, null),
            array('count', InputArgument::OPTIONAL, null, 100),
        );
    }

}
