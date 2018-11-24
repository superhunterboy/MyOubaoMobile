<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

/**
 * 计算总代升降点
 */
class CreateActivityReportUserPrize extends BaseCommand {

    protected $sFileName = 'createactivityreportuserprize';

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'activity:report-user-prize';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'create activity report user prize';

    public function doCommand(& $sMsg = null) {
        $this->writeLog('start command');
        $oReport = ActivityReportUserPrize::orderBy('id', 'desc')->get()->first();
        if (is_object($oReport)) {
            $statDate = date('Y-m-d', strtotime($oReport->stat_at . " +1 day"));
            $sBeginTime = $statDate . ' 00:00:00';
            $sEndTime = $statDate . ' 23:59:59';
        } else {
            $statDate = date('Y-m-d', strtotime(" -1 day"));
            $sBeginTime = '2015-05-18 00:00:00';
            $sEndTime = $statDate . ' 23:59:59';
        }
        $this->writeLog('calculate begin time is ' . $sBeginTime);
        $this->writeLog('calculate end time is ' . $sEndTime);
        $aUserPrizes = ActivityUserPrize::getUserPrizeByDate($sBeginTime, $sEndTime);
        $this->writeLog('calculate record count is ' . count($aUserPrizes));
        DB::connection()->beginTransaction();
        $bSucc = false;
        foreach ($aUserPrizes as $oUserPrize) {
            $oNewReport = new ActivityReportUserPrize;
            $oNewReport->prize_id = $oUserPrize->prize_id;
            $oNewReport->prize_name = $oUserPrize->prize_name;
            $oNewReport->user_id = $oUserPrize->user_id;
            $oNewReport->username = $oUserPrize->username;
            $oNewReport->is_tester = $oUserPrize->is_tester;
            $oNewReport->count = $oUserPrize->count;
            $oNewReport->stat_at = date('Y-m-d', strtotime($oUserPrize->created_at));
            $oNewReport->ip = $oUserPrize->remote_ip;
            $oNewReport->user_prize_id = $oUserPrize->id;
            $oNewReport->created_at = $oUserPrize->created_at;
            $bSucc = $oNewReport->save();
            if (!$bSucc) {
                $this->writeLog('save error: ' . var_export($this->getAttributes(), true));
                break;
            }
        }
        if ($bSucc) {
            DB::connection()->commit();
        } else {
            DB::connection()->rollback();
        }
    }

}
