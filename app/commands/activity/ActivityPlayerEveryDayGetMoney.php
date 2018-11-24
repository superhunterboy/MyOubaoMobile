<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

/**
 * 玩家流水送真金
 */
class ActivityPlayerEveryDayGetMoney extends BaseCommand {

    protected $sFileName = 'activityplayereverydaygetmoney';

    /**
     * The activity cash back command name.
     *
     * @var string
     */
    protected $name = 'activity:player-everyday-getmoney';

    /**
     * The activity cash back description.
     *
     * @var string
     */
    protected $description = 'activity player every day get money';

    public function doCommand(& $sMsg = null) {
        $sDate = date('Y-m-d', strtotime('-1 day'));
        $this->writeLog('date='.$sDate);
        $aUserTask = ActivityUserTask::getAllUserTasksByDate($sDate);
        $this->writeLog('user task count='.count($aUserTask));
        foreach ($aUserTask as $oUserTask) {
            $oTask = ActivityTask::find($oUserTask->task_id);
            if (!is_object($oTask)) {
                $this->writeLog('task missing ' . var_export($oUserTask->getAttributes(), true));
            }
            $fTurnover = ManProject::getCurrentDayTurnover($oUserTask->user_id, $oUserTask->signed_time,$sDate.' 23:59:59');
            $fBonus = $this->getBonusByTurnover($fTurnover);
            //奖金不满足条件，退出
            if ($fBonus == 0) {
                continue;
            }
            $this->writeLog(" date=$sDate, username=$oUserTask->username, turnover=$fTurnover , bonus=$fBonus");
            $oUserTask->calculate_status = 1;
            $aExtraData = [
                'rebate_amount' => $fBonus,
                'turnover_username' => $oUserTask->username,
                'turnover' => $fTurnover,
            ];
            $bSucc = $oTask->send($oUserTask->user_id, $aExtraData, ActivityUserPrize::SOURCE_COMMAND);
            !$bSucc or $bSucc = $oUserTask->save();
            if ($bSucc) {
                DB::connection()->commit();
            } else {
                DB::connection()->rollback();
            }
        }
    }

    private function getBonusByTurnover($fAmount) {
        $fBonus = 0;
        $sFeeExpressions = 'x<1888&&y=0;x>=1888&&x<4588&&y=8;x>=4588&&x<6988&&y=18;x>=6988&&x<9888&&y=28;x>=9888&&x<16888&&y=38;x>=16888&&x<38888&&y=68;x>=38888&&x<88888&&y=158;x>=88888&&y=358;';
        $sFeeExpressions = str_replace('x', '$fAmount', $sFeeExpressions);
        $sFeeExpressions = str_replace('y', '$fBonus', $sFeeExpressions);
        eval($sFeeExpressions);
        return $fBonus;
    }

}
