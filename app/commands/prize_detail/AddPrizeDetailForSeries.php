<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

/**
 * 当添加新的彩种时，更新所有的玩家开户链接的彩种奖金组字段
 */
class AddPrizeDetailForSeries extends BaseCommand {

    protected $sFileName = 'addprizedetail';

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'prize_detail:add';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'add prize detail for new series.';

    protected function getArguments() {
        return array(
            array('series_id', InputArgument::REQUIRED, null),
        );
    }

    public function doCommand(& $sMsg = null) {
        $iSeriesId = $this->argument('series_id');
        $oSeries = Series::find($iSeriesId);
        if (!is_object($oSeries)) {
            $this->exitPro("missing series, series_id=" . $iSeriesId, false);
        }
        $aPrizeGroup = PrizeGroup::getAllPrizeGroups($iSeriesId);
        pr($aPrizeGroup);exit;
        $aPrizeLevel = PrizeLevel::getObjectCollectionByParams(['series_id' => $iSeriesId]);
        if ($iSeriesId == 2) {
            $iMaxPrizeGroup = 1980;
        } else {
            $iMaxPrizeGroup = 2000;
        }
        foreach ($aPrizeGroup as $oPrizeGroup) {
            foreach ($aPrizeLevel as $oPrizeLevel) {
                $oPrizeDetail = PrizeDetail::getObjectByParams(['group_id' => $oPrizeGroup['id'], 'method_id' => $oPrizeLevel->basic_method_id, 'level'=>$oPrizeLevel->level]);
                if(is_object($oPrizeDetail)){
                    continue;
                }
                $oNewPrizeDetail = new PrizeDetail;
                $oNewPrizeDetail->series_id = $iSeriesId;
                $oNewPrizeDetail->group_id = $oPrizeGroup['id'];
                $oNewPrizeDetail->group_name = $oPrizeGroup['name'];
                $oNewPrizeDetail->classic_prize = $oPrizeGroup['classic_prize'];
                $oNewPrizeDetail->method_id = $oPrizeLevel->basic_method_id;
                $oNewPrizeDetail->level = $oPrizeLevel->level;
                $oNewPrizeDetail->probability = $oPrizeLevel->probability;
                $oNewPrizeDetail->full_prize = $oPrizeLevel->full_prize;
                $oNewPrizeDetail->prize = $oPrizeGroup['classic_prize'] * $oPrizeLevel->max_group * $oPrizeLevel->full_prize / $iMaxPrizeGroup / 1960;
                $oNewPrizeDetail->save();
            }
        }
    }

}
