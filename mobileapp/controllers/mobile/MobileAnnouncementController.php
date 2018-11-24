<?php

class MobileAnnouncementController extends AnnouncementController {

    protected $resourceView = 'announcement';

    //根据模板获取帮助中心类别列表
    public function aIds() {
        $aHelpTemlIds = CmsCategory::where('template', '=', 'help')->get(['id'])->toArray();
        foreach ($aHelpTemlIds as $aId) {
            $aIds[] = $aId['id'];
        }
        return $aIds;
    }

}
