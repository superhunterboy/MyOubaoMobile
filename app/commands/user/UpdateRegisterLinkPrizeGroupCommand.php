<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

/**
 * 更新旧的开户链接奖金组数据
 */
class UpdateRegisterLinkPrizeGroupCommand extends BaseCommand {

    protected $sFileName = 'updatereigsterlinks';

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'register_link:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'update register link for new lottery.';

    protected function getArguments() {
        return array(
            array('lottery_id', InputArgument::REQUIRED, null),
            array('prize_group', InputArgument::OPTIONAL, null),
        );
    }

    public function doCommand(& $sMsg = null) {
        $iLotteryId = $this->argument('lottery_id');
        $iPrizeGroup = $this->argument('prize_group');
        $oLottery = ManLottery::find($iLotteryId);
        if (!$oLottery) {
            $this->exitPro("missing lottery, lottery_id=" . $iLotteryId, false);
        }

        $aAllInuseLinks = RegisterLink::where('status', '=', 0)->where('is_admin', '=', 0)
                        ->whereRaw(' (expired_at > ? or expired_at is null)', [Carbon::now()->toDateTimeString()])->get();
        DB::connection()->beginTransaction();
        $bSucc = true;
        foreach ($aAllInuseLinks as $oRegisterLink) {
            $aOldPrizeGroupSet = json_decode($oRegisterLink->prize_group_sets, true);
            if ($oRegisterLink->is_agent) {
                $bMatch = false;
                foreach ($aOldPrizeGroupSet as $aPrizeGroup) {
                    if ($aPrizeGroup['series_id'] == $oLottery->series_id) {
                        $bMatch = true;
                    }
                }
                if ($bMatch) {
                    continue;
                }
                $newPrizeGroup['series_id'] = $oLottery->series_id;
                $newPrizeGroup['prize_group'] = $aOldPrizeGroupSet[0]['prize_group'];
                $aOldPrizeGroupSet[] = $newPrizeGroup;
                pr($oRegisterLink->prize_group_sets);
                $oRegisterLink->prize_group_sets = json_encode($aOldPrizeGroupSet);
                pr($oRegisterLink->prize_group_sets);
                $bSucc = $oRegisterLink->save();
            } else {
                $bMatch = false;
                foreach ($aOldPrizeGroupSet as $aPrizeGroup) {
                    if ($aPrizeGroup['lottery_id'] == $oLottery->id) {
                        $bMatch = true;
                    }
                }
                if ($bMatch) {
                    continue;
                }
                $newPrizeGroup['lottery_id'] = $oLottery->id;
                $newPrizeGroup['prize_group'] = $aOldPrizeGroupSet[0]['prize_group'];
                $aOldPrizeGroupSet[] = $newPrizeGroup;
                pr($oRegisterLink->prize_group_sets);
                $oRegisterLink->prize_group_sets = json_encode($aOldPrizeGroupSet);
                pr($oRegisterLink->prize_group_sets);
                $bSucc = $oRegisterLink->save();
            }
            if (!$bSucc) {
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
