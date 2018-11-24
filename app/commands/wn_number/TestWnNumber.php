<?php

/**
 * generate winning-number for self lotteries
 *
 * @author white
 */
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class TestWnNumber extends BaseCommand {
    protected $sFileName = 'GenerateNumber';
    protected $name = 'number:test';
    protected $description = 'generate winning-number for self lotteries';
    public $writeTxtLog    = true;

    public function doCommand(& $sMsg = null) {
        $iLotteryId = $this->argument('lottery_id');
        $iCount     = $this->argument('count');
//        pr($iLotteryId);
//        pr($iCount);
        $oLottery   = ManLottery::find($iLotteryId);
        if (!$oLottery->is_self) {
            exit;
        }
        for ($i = 0;$i < 100000;$i++) {
            $sCode = $oLottery->compileWinningNumber();
//            echo "$sCode\n";
            if ($oLottery->checkWinningNumber($sCode)) {
                echo "$sCode\n";
                continue;
            }
        }
    }

    protected function getArguments() {
        return array(
            array('lottery_id', InputArgument::REQUIRED, null),
            array('count', InputArgument::OPTIONAL, null, 100),
        );
    }

}
