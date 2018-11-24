<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

/**
 * 报表下载
 */
class AccountReportDownload extends BaseReportDownload {

    protected $sFileName = 'reportaccountdownload';

    /**
     * The activity cash back command name.
     *
     * @var string
     */
    protected $name = 'report:account-download';

    /**
     * The activity cash back description.
     *
     * @var string
     */
    protected $description = 'report account download';

    public function doCommand(& $sMsg = null) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');
        $this->writeLog('begin download');
        $oReportConfig = ReportDownloadConfig::getObjectByParams(['report_type' => ReportDownloadConfig::TYPE_ACCOUNT, 'is_enabled'=>1]);
        if(!is_object($oReportConfig)){
            return false;
        }
        $sClassName = $oReportConfig->class_name;
        $oClass = new $sClassName;
        $aDownloadTime = $this->getDownloadTime($oReportConfig->freq_type);
//            $aDownloadTime = ['beginTime' => '2015-05-12 00:00:00', 'endTime' => '2015-06-13 00:00:00'];
        $iReportType = array_get($sClassName::$aReportType, $oReportConfig->report_type);
        $this->writeLog("reportType=" . $iReportType . ", beginTime=" . $aDownloadTime['beginTime'] . ", endTime=" . $aDownloadTime['endTime']);
        $sFileName = $this->createFileName($sClassName, $oReportConfig->report_type, $aDownloadTime);
        $oReportInfo = ReportDownloadInfo::getObjectByParams(['file_name' => $sFileName]);
        if (is_object($oReportInfo)) {
            return false;
        }
        $sDir = SysConfig::readValue('report_download_dir');
        $sDir .= $oReportConfig->report_type . '/';
        $bSucc = true;
        if (!file_exists($sDir)) {
            $bSucc = mkdir($sDir, 0777, true);
        }
        //检查是否存在指定报表类型的目录，如果不存在，创建该目录
        $this->writeLog("filepath=" . $sDir . $sFileName);
        !$bSucc or $bSucc = $oClass->download($iReportType, $aDownloadTime, $sFileName, $sDir);
        !$bSucc or $bSucc = $this->createReportInfo($sFileName, $sDir, $oReportConfig->report_type, $aDownloadTime);
    }

}
