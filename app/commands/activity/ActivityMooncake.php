<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

/**
 * 每日充，每日返
 */
class ActivityMooncake extends BaseCommand {

    protected $sFileName = 'activity-mooncake-getmoney';

    /**
     * The activity cash back command name.
     *
     * @var string
     */
    protected $name = 'activity:mooncake-getmoney';

    /**
     * The activity cash back description.
     *
     * @var string
     */
    protected $description = 'activity mooncake get money';

    public function doCommand(& $sMsg = null) {
        $sDate = date('Y-m-d', strtotime('-1 day'));
//        $sDate = date('Y-m-d');
        $this->writeLog('start command, calculate date is ' . $sDate);
        $aUserTasks = ActivityUserTask::getAllUserTasksByDate($sDate);
        $this->writeLog('calculate record count ' . count($aUserTasks));
        foreach ($aUserTasks as $aUserTask) {
            $sSignTime = $aUserTask['signed_time'];
            $fTurnover = Project::getCurrentDayTurnover($aUserTask['user_id'], $sSignTime, $sDate . ' 23:59:59');
            if($fTurnover<1888){
                coutinue;
            }
            $fMaxDepositAmount = Deposit::getMaxAmountByDate($sDate.' 00:00:00', $sDate.' 23:59:59', $aUserTask['user_id']);
            $fBonus = $this->getBonus($fMaxDepositAmount, $fTurnover);
            $this->writeLog('username= ' . $aUserTask['username'] . ', turnover=' . array_get($aData, 'turnover') . ', max_deposit=' . $fMaxDepositAmount . ', bonus=' . $fBonus);
            if ($fBonus == 0) {
                continue;
            }
            $aExtraInfo = [
                'max_deposit' => $fMaxDepositAmount,
                'turnover' => array_get($aData, 'turnover'),
                'rebate_amount' => $fBonus,
            ];
            $aUserTaskData = json_decode($aUserTask->data, true);
            $aUserTaskData['bonus'] = $fBonus;
            $aUserTask->data = json_encode($aUserTaskData);
            $aUserTask->calculate_status = 1;
            DB::connection()->beginTransaction();
            $bSucc = $oTask->send($aUserTask['user_id'], $aExtraInfo, ActivityUserPrize::SOURCE_COMMAND);
            !$bSucc or $bSucc = $aUserTask->save();
            if ($bSucc) {
                DB::connection()->commit();
            } else {
                DB::connection()->rollback();
            }
        }
    }

    /**
     * 格式化返还比例字段
     * @param float $fPercent 返还比例
     */
    private function getBonus($fDepositAmount, $fTurnover) {
        if($fTurnover>=188888){
            if($fDepositAmount>=18888){
                return 1888;
            }else if($fDepositAmount>=8888){
                return 888;
            }else if($fDepositAmount>=5888){
                return 688;
            }else if($fDepositAmount>=1888){
                return 188;
            }else if($fDepositAmount>=888){
                return 88;
            }else if($fDepositAmount>=188){
                return 28;
            }
        }else if($fTurnover>=88888){
            if($fDepositAmount>=8888){
                return 888;
            }else if($fDepositAmount>=5888){
                return 688;
            }else if($fDepositAmount>=1888){
                return 188;
            }else if($fDepositAmount>=888){
                return 88;
            }else if($fDepositAmount>=188){
                return 28;
            }
        }else if($fTurnover>=58888){
            if($fDepositAmount>=5888){
                return 688;
            }else if($fDepositAmount>=1888){
                return 188;
            }else if($fDepositAmount>=888){
                return 88;
            }else if($fDepositAmount>=188){
                return 28;
            }
        }else if($fTurnover>=18888){
            if($fDepositAmount>=1888){
                return 188;
            }else if($fDepositAmount>=888){
                return 88;
            }else if($fDepositAmount>=188){
                return 28;
            }
        }else if($fTurnover>=8888){
           if($fDepositAmount>=888){
                return 88;
            }else if($fDepositAmount>=188){
                return 28;
            }
        }else if($fTurnover>=1888){
            if($fDepositAmount>=188){
                return 28;
            }
        }
        return 0;
    }

}
