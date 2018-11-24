<?php

/**
 * Description of checkAndMakePartition
 *
 * @author white
 */
class checkAndMakePartition extends BaseCommand {

    protected $sFileName = 'checkAndMakePartition';

    protected $name = 'db:check-partition';

    protected $description = 'check and make partition';
    
    protected $newPartitions = 7;
    
    protected $maxDate = null;

    public function doCommand(& $sMsg = null) {
        $this->maxDate = Carbon::now()->addDays($this->newPartitions)->toDateString();
        $sDbName = Config::get('database.connections.mysql.database');
        $aTables = $this->getPartitionedTables();
        foreach($aTables as $sTable => $aConfig){
            if ($aConfig['by'] != 'date'){
                continue;
            }
//            pr($sTable);
            $sLastPartition = $this->getLastPartition($sDbName, $sTable);
            $sLastDate = substr($sLastPartition,1);
            $oDate = Carbon::createFromFormat($aConfig['format'],$sLastDate);
//            pr($oDate->toDateString());
            for($i = 0;$i < $this->newPartitions;$i++){
                if ($oDate->toDateString() > $this->maxDate) break;
                $oDate->addDay();
                $sPartitionName = 'p' . date($aConfig['format'],$oDate->timestamp);
                $sDate = $oDate->toDateString();
                $sSql = "alter table $sTable add partition ( partition $sPartitionName values in (to_days('$sDate')))";
                if (!$bSucc = DB::statement($sSql)){
                   continue 2;
               }
            }
        }
    }

    private function getPartitionedTables(){
        return Config::get('partition');
//        $sSql = "select distinct table_name from INFORMATION_SCHEMA.PARTITIONS where table_schema = '$sDbName' and partition_name is not null";
//        $aResults = DB::select($sSql);
//            $sSql = "select max(partition_name) from INFORMATION_SCHEMA.PARTITIONS where table_schema = '$sDbName' and table_name = '$sTable' order by partition_name";
    }
    
    private function getLastPartition($sDb, $sTable){
        $sSql = "select max(partition_name) partition_name from INFORMATION_SCHEMA.PARTITIONS where table_schema = '$sDb' and table_name = '$sTable'";
        if ($aResults = DB::select($sSql)){
            return $aResults[0]->partition_name;
        }
        return false;
    }
}
