<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

/**
 * 报表下载
 */
class BaseReportDownload extends BaseCommand {

    /**
     * 根据频率类型获取下载的开始和结束时间
     * @param int $iFreqType  频率类型
     */
    public function getDownloadTime($iFreqType) {
        $sBeginTime = $sEndTime = '';
        switch ($iFreqType) {
            case ReportDownloadConfig::FREQ_TYPE_EVERYDAY:
                $iLastDay = strtotime('-1 day');
                $sBeginTime = date('Y-m-d 00:00:00', $iLastDay);
                $sEndTime = date('Y-m-d 23:59:59', $iLastDay);
                //获取上一天的开始和结束日期
                break;
            case ReportDownloadConfig::FREQ_TYPE_EVERYWEEK:
                $iLastMonday = strtotime('-1 week last monday');
                $iLastSunday = strtotime(' last sunday');
                $sBeginTime = date('Y-m-d 00:00:00', $iLastMonday);
                $sEndTime = date('Y-m-d 23:59:59', $iLastSunday);
                //获取上一个星期的开始和结束日期
                break;
            case ReportDownloadConfig::FREQ_TYPE_EVERYMONTH:
                //获取上一个的开始和结束日期
                break;
            case ReportDownloadConfig::FREQ_TYPE_EVERYYEAR:
                //获取上一年的开始和结束日期
                break;
        }
        return ['beginTime' => $sBeginTime, 'endTime' => $sEndTime];
    }

    public function createFileName($sClassName, $iReportType, $aDownloadTime, $sSuffix = '.xls') {
        $sFileName = $sClassName . "_" . $iReportType . "_";
        $sFileName.=date('md', strtotime($aDownloadTime['beginTime'])) . '_';
        $sFileName.=date('md', strtotime($aDownloadTime['endTime']));
        $sFileName.=$sSuffix;
        return $sFileName;
    }

    public function createReportInfo($sFileName, $sDir, $iReportType, $aDownloadTime) {
        $oReportInfo = new ReportDownloadInfo;
        $oReportInfo->file_name = $sFileName;
        $oReportInfo->file_path = $sDir;
        $oReportInfo->file_type = $iReportType;
        $oReportInfo->begin_time = $aDownloadTime['beginTime'];
        $oReportInfo->end_time = $aDownloadTime['endTime'];
        return $oReportInfo->save();
    }

}
