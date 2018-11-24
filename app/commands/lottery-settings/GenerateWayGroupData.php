<?php

/**
 * generate way groups settings
 *
 * @author white
 */
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class GenerateWayGroupData extends BaseCommand {
    protected $sFileName = 'GenerateWayGroupData';
    protected $name = 'bet:generate-way-group-data';
    protected $description = 'generate way groups settings';
    public $writeTxtLog    = true;

    public function doCommand(& $sMsg = null) {
        $oAllSeries = Series::all();
        $sPath = Config::get('widget.js_data_path');
        if (!is_writable($sPath)){
            $sMsg = "The path $sPath is not writable";
            return;
        }

        foreach($oAllSeries as $oSeries){
            if (!$aWayGroups = & WayGroup::getWayGroupSettings($oSeries->id)) {
                continue;
            }
            $sWayGroups = json_encode($aWayGroups);
            $sFileName =  $sPath . $oSeries->id . '.json';
            if (file_exists($sFileName) && !is_writable($sFileName)){
                $sMsg .= "The file $sFileName is not writable";
                continue;
            }
            file_put_contents($sFileName, $sWayGroups);
            $sMsg .= "$sFileName Generated,";
        }
    }

//    protected function getArguments() {
//        return [];
//        return array(
//            array('lottery_id', InputArgument::REQUIRED, null),
//            array('count', InputArgument::OPTIONAL, null, 100),
//        );
//    }

}
