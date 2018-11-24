<?php

/**
 * 删除指定条件的注单缓存
 *
 * @author white
 */
class ClearProjectCache extends BaseTask {
    function doCommand() {
        extract($this->data, EXTR_PREFIX_ALL, 'prj');
//        $data = [
//            'lottery_id' => ['=', $iLotteryId],
//            'issue' => ['=', $sIssue],
//            'way_id' => ['=', $iWayId],
//        ];
        $oProjects = ManProject::getValidProjects($prj_lottery_id, $prj_issue, $prj_way_id);
        foreach($oProjects as $oProject){
            ManProject::deleteCache($oProject->id);
            ManProject::deleteUserDataListCache($oProject->user_id);
        }
        $this->log = " Total " . $oProjects->count() . " Cache Deleted" ;
        return self::TASK_SUCCESS;
    }

}
