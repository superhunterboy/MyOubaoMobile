<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

/**
 * 报表下载
 */
class ReportDownload extends BaseReportDownload {

    protected $sFileName = 'reportdownload';

    /**
     * The activity cash back command name.
     *
     * @var string
     */
    protected $name = 'report:download';

    /**
     * The activity cash back description.
     *
     * @var string
     */
    protected $description = 'report download';

    public function doCommand(& $sMsg = null) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');
        $this->writeLog('begin download');
        $aReportConfigs = ReportDownloadConfig::getEnableConfig();
        foreach ($aReportConfigs as $oReportConfig) {
            $sClassName = $oReportConfig->class_name;
            $oClass = new $sClassName;
            $aDownloadTime = $this->getDownloadTime($oReportConfig->freq_type);
//            $aDownloadTime = ['beginTime' => '2015-05-07 00:00:00', 'endTime' => '2015-05-08 00:00:00'];
            $reportType = array_get($sClassName::$aReportType, $oReportConfig->report_type);
            $this->writeLog("reportType=" . (is_array($reportType) ? implode(',', $reportType) : $reportType) . ", beginTime=" . $aDownloadTime['beginTime'] . ", endTime=" . $aDownloadTime['endTime']);
            if ($sClassName == 'Transaction') {
                $sFileName = $this->createFileName($sClassName, $oReportConfig->report_type, $aDownloadTime, '.csv');
            } else {
                $sFileName = $this->createFileName($sClassName, $oReportConfig->report_type, $aDownloadTime);
            }
            $oReportInfo = ReportDownloadInfo::getObjectByParams(['file_name' => $sFileName]);
            if (is_object($oReportInfo)) {
                continue;
            }
            $sDir = SysConfig::readValue('report_download_dir');
            $sDir .= $oReportConfig->report_type . '/';
            $bSucc = true;
            if (!file_exists($sDir)) {
                $bSucc = mkdir($sDir, 0777, true);
            }
            //检查是否存在指定报表类型的目录，如果不存在，创建该目录
            $this->writeLog("filepath=" . $sDir . $sFileName);
            !$bSucc or $bSucc = $oClass->download($reportType, $aDownloadTime, $sFileName, $sDir);
            !$bSucc or $bSucc = $this->createReportInfo($sFileName, $sDir, $oReportConfig->report_type, $aDownloadTime);
        }
    }

}
