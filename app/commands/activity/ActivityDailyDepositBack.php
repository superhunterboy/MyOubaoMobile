<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

/**
 * 每日充，每日返
 */
class ActivityDailyDepositBack extends BaseCommand {

    protected $sFileName = 'activitydailydepositback';

    /**
     * The activity cash back command name.
     *
     * @var string
     */
    protected $name = 'activity:everyday-getmoney';

    /**
     * The activity cash back description.
     *
     * @var string
     */
    protected $description = 'activity daily deposit daily back';

    public function doCommand(& $sMsg = null) {
        $sDate = date('Y-m-d', strtotime('-1 day'));
//        $sDate = date('Y-m-d');
        $this->writeLog('start command, calculate date is ' . $sDate);
        $aUserTasks = ActivityUserTask::getAllUserTasksByDate($sDate);
        $this->writeLog('calculate record count ' . count($aUserTasks));
        foreach ($aUserTasks as $aUserTask) {
            $aFirstDepoisit = json_decode($aUserTask['data'], true);
            $oTask = ActivityTask::find($aUserTask['task_id']);
            if (!is_object($oTask)) {
                $this->writeLog('task missing ' . var_export($aUserTask));
            }
            $aData = json_decode($aUserTask['data'], true);
            $fBonusPercent = $this->getBonusPercent($aFirstDepoisit['amount'], array_get($aData, 'turnover'));
            $this->writeLog('username= ' . $aUserTask['username'] . ', turnover=' . array_get($aData, 'turnover') . ', first_deposit=' . $aFirstDepoisit['amount'] . ', bonus=' . $fBonusPercent);
            if ($fBonusPercent == 0) {
                continue;
            }
            $fBonus = $aFirstDepoisit['amount'] * $fBonusPercent;
            $aExtraInfo = [
                'first_deposit_amount' => $aFirstDepoisit['amount'],
                'turnover_from_time' => $aFirstDepoisit['put_at'],
                'turnover_to_time' => $aUserTask['updated_at'] ? $aUserTask['updated_at']->toDateTimeString() : $sDate . ' 23:59:59',
                'times' => array_get($aData, 'turnover') / $aFirstDepoisit['amount'],
                'percent' => $aUserTask['percent'],
                'turnover' => array_get($aData, 'turnover'),
                'rebate_percent' => $fBonusPercent,
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
    private function getBonusPercent($fDepositAmount, $fTurnover) {
        $fPercent = $fTurnover / $fDepositAmount;
        $sfeeExpressions = SysConfig::readValue('everyday_getmoney_calculate_expression');
        $sFeeExpressions = str_replace('x', '$fPercent', $sfeeExpressions);
        $sFeeExpressions = str_replace('y', '$fBonus', $sFeeExpressions);
        eval($sFeeExpressions);
        return $fBonus;
    }

}
