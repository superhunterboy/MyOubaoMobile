<?php

/**
 * 自动更新奖金组设置
 *
 * @author white
 */
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class UpdateUserPrizeGroupCommand extends BaseCommand {
    /**
     * command name.
     *
     * @var string
     */
    protected $name = 'core:update-prize-group';

    /**
     * The activity cash back description.
     *
     * @var string
     */
    protected $description = 'Update the prize group settings';
    
    public function doCommand(& $sMsg = null) {
        $iSeriesId = $this->argument('series_id');
        if (!$iSeriesId){
            $sMsg = "Invalid Series ID!";
            exit;
        }
        $oGroups = PrizeGroup::where('series_id','=',$iSeriesId)->get();
        if (!$oGroups->count()){
            $sMsg = "No Prize Groups!";
            exit;
        }
        foreach($oGroups as $oGroup){
            $oGroup->save();
        }
    }

    protected function getArguments() {
        return array(
            array('series_id', InputArgument::REQUIRED, null),
        );
    }

}
