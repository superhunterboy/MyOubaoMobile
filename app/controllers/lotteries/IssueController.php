<?php

define('SECONDS_OF_DAY', 3600 * 24);

//ManIssue::generateIssues(6);
//exit;
class IssueController extends AdminBaseController {

    protected $customViewPath = 'lottery.issue';
    protected $customViews = [
//        'encode',
        'issueOperate',
        'generate',
        'batchDelete',
    ];

    /**
     * 资源模型名称
     * @var string|Illuminate\Database\Eloquent\Model
     */
    protected $modelName = 'ManIssue';

    /**
     * 在渲染前执行，为视图准备变量
     */
    protected function beforeRender() {
        $sModelName = $this->modelName;
        $aWnNumberStatus = $sModelName::$winningNumberStatus;
        $aLotteries = & ManLottery::getTitleList();
        $aSeriesLotteries = & Series::getLotteriesGroupBySeries();
        $this->setVars(compact('aLotteries', 'aWnNumberStatus', 'aSeriesLotteries'));
//        $this->setVars('aValidTypes', $sModelName::$validTypes);
//        $this->setVars('aValidLottoTypes', $sModelName::$validLottoTypes);
        switch ($this->action) {
            case 'view':
                $oIssueRule = new IssueRule;
                $aIssueRules = $oIssueRule->getIssueRules();
                $this->setVars(compact('aIssueRules'));
                $this->setVars('aViewColumnMaps', $sModelName::$viewColumnMaps);
                break;
            case 'encode':
                $this->addWidget('lottery.issue.encodeForm');
                $this->setVars('bSequencable', $sModelName::$sequencable);
                $this->setVars('bCheckboxForBatch', $sModelName::$bCheckboxForBatch);
                $this->setVars('aNoOrderByColumns', $sModelName::$noOrderByColumns);
                if ($sModelName::$totalColumns) {
                    $this->setVars('aTotalColumns', $sModelName::$totalColumns);
                }
                $this->view = 'default.index';
            case 'index':
                $this->setVars('aListColumnMaps', $sModelName::$listColumnMaps);
                break;
        }
        parent::beforeRender();
    }

    function download() {
        if (true) {
            set_time_limit(0);
//            pr($this->request->data);
            $aTitles = [
                'issue' => __('Draw #'),
                'begin_time' => __('Begin Time'),
                'end_time' => __('End Time'),
                'status' => __('Status'),
                'wn_number' => __('Winning #'),
                'encode_time' => __('Encode Time'),
            ];
            $aConvertFields = [
                'issue' => 'issue',
                'begin_time' => 'date',
                'end_time' => 'date',
                'encode_time' => 'date',
                'status' => 'status',
                'wn_number' => 'bonuscode',
            ];
            $iLotteryId = 1;
            $sBeginDate = '2014-07-05';
            $sEndDate = '2014-07-06';
            $oLottery = ManLottery::find($iLotteryId);
//            $aLotteryInfo = $oLottery->find($iLotteryId)->getAttributes();
//            pr($aLotteryInfo);
            $sType = $oLottery->validTypes[$oLottery->type];

            $aFields = array_keys($aTitles);
            $iBeginTime = strtotime($sBeginDate);
            $iEndTime = strtotime($sEndDate) + 3600 * 24 - 1;
//            $iBeginTime != $iEndTime or $iEndTime = $iBeginTime + 3600 * 24 - 1;
            $aIssues = $this->model->findAllIssuesByCond($iLotteryId, $iBeginTime, $iEndTime);
            if (empty($aIssues)) {
//                $this->Session->setFlash(__('No Issues'));
//                $this->_goBackUrl('index');
            }
            $aData = & $this->_makeData($aIssues, $aFields, $aConvertFields, $this->ManIssue->bonusCodeStatus, $oLottery->type, $oLottery->code_len);
//            pr($aData);exit;
//            pr(count($aData));
            $oDownExcel = new DownExcel;
            $oDownExcel->setTitle($aTitles);
//            pr('set data');
            $oDownExcel->setData($aData);

            $sSheetTitle = $sFileName = __($sType) . '型开奖_' . $oLottery->name . '_' . substr(str_replace('-', '', $sBeginDate), 2) . '_' . substr(str_replace('-', '', $sBeginDate), 2);
            $oDownExcel->setActiveSheetIndex(0);
            $oDownExcel->setSheetTitle($sSheetTitle);
            $oDownExcel->setEncoding('gb2312');

// Download xls文件
            $oDownExcel->Download($sFileName);
//            $this->_goBackUrl('index');
//            $this->_setActionResult(1, __('Download Success'), 'index', true);
        } else {
            $this->_downloadVar();
        }
    }

    private function _downloadVar() {
        $this->setVars('lotteries', ManLottery::getLotteryList());
        isset($this->params->params['named']['lottery_id']) or $this->params->params['named']['lottery_id'] = 1;
        $this->setVars('iCurrentLotteryId', $this->params->params['named']['lottery_id']);
        $this->setVars('bNeedCalendar', true);      // load calendar
//        $this->set('bNeedCalendar', true);      // load calendar
        $this->setVars('dBeginDate', date('Y-m-d'));
        $this->setVars('dEndDate', date('Y-m-d'));
    }

    private function & _makeData($aIssues, $aKeys, & $aConvertFields, & $aValidStatus, $iType, $iCodeLen) {
        $aData = array();
        foreach ($aIssues as $aInfo) {
            $a = [];
            foreach ($aKeys as $key) {
                if (empty($aInfo->$key)) {
                    $a[] = $aInfo->$key;
                    continue;
                }
                if (array_key_exists($key, $aConvertFields)) {
                    switch ($aConvertFields[$key]) {
                        case 'date':
                            $a[] = date('Y-m-d H:i:s', $aInfo->$key);
                            break;
                        case 'bonuscode':
                            if ($iType == ManLottery::LOTTERY_TYPE_NUM) {
                                $a[] = '=TEXT("' . $aInfo->$key . '","' . str_repeat('0', $iCodeLen) . '")';
                            } else {
                                $a[] = $aInfo->$key;
                            }
                            break;
//                        case 'user':
//                            if ($aInfo[$key] > SYSTEM_USER_BASE) {
//                                $a[] = $aDrawSources[$aInfo[$key] - SYSTEM_USER_BASE];
//                            } else {
//                                $a[] = $aUsers[$aInfo[$key]];
//                            }
//                            break;
                        case 'status':
                            $a[] = $aValidStatus[$aInfo->$key];
                            break;
                        case 'issue':
                            if (!is_numeric($aInfo->$key)) {
                                $a[] = $aInfo->$key;
                            } else {
                                $a[] = '=TEXT("' . $aInfo->$key . '","' . str_repeat('0', strlen($aInfo->$key)) . '")';
                            }
                            break;
                        default :
                            break;
                    }
                } else {
                    $a[] = $aInfo->$key;
                }
            }
            $aData[] = $a;
        }
        return $aData;
    }

    public function batchDelete($id = null) {
        if (Request::method() == 'POST' || Request::ajax()) {
            $data = Input::all();
//            $data = array();
//            $data['lottery_id'] = 1;
//            $data['begin_time'] = '2014-07-02';
//            $data['end_time'] = '2014-07-03';
//            $data['begin_issue'] = '';
//            $data['end_issue'] = '';
            if (empty($data['lottery_id'])) {
                return $this->goBack('error', __('_issue.missing-lottery'));
            }
            if (empty($data['begin_time']) && empty($data['begin_issue'])) {
                return $this->goBack('error', __('_issue.invalid-date'));
            }
            $aConditions = [];
            if ($data['begin_time']) {
                $iBeginTime = strtotime($data['begin_time']);
                empty($data['end_time']) or $iEndTime = strtotime($data['end_time']);
                if ($iBeginTime < time() + 3600) {
                    return $this->goBack('error', __('_issue.time-early'));
                }
                $aConditions['end_time'] = ['>=', $iBeginTime];
                !isset($iEndTime) or $aConditions['end_time'] = ['between', [$iBeginTime, $iEndTime]];
            }
            if ($data['begin_issue']) {
                if (!$iEndTimeOfBeginIssue = $this->model->field('end_time', ['lottery_id' => ['=', $data['lottery_id']], 'issue' => ['=', $data['begin_issue']]])) {
                    return $this->goback('error', __('_issue.missing-begin-issue'));
                }
                if ($iEndTimeOfBeginIssue < time() + 3600) {
                    return $this->goback('error', __('_issue.issue-early'));
                }
                $aConditions['issue'] = ['>=', $data['begin_issue']];
            }
            if ($data['end_issue']) {
                if (!$iEndTimeOfEndIssue = $this->model->field('end_time', ['lottery_id' => ['=', $data['lottery_id']], 'issue' => ['=', $data['end_issue']]])) {
                    return $this->goback('error', __('_issue.missing-end-issue'));
                }
                if ($iEndTimeOfEndIssue < $iEndTimeOfBeginIssue) {
                    return $this->goBack('error', __('_issue.invalid-issue'));
                }
                $aConditions['issue'] = ['between', [$data['begin_issue'], $data['end_issue']]];
            }
            $aConditions['lottery_id'] = ['=', $data['lottery_id']];
            $bSucc = $this->model->deleteAll($aConditions);
            if ($bSucc) {
                return $this->goBackToIndex('success', __('_issue.delete-success'));
            } else {
                return $this->goBack('error', __('_issue.delete-error'));
            }
        } else {
            $this->setVars('aLotteries', ManLottery::getTitleList());
            $this->setVars('lottery_id', $id);
            return $this->render();
        }
    }

    /**
     * 奖期生成第一步，显示奖期生成界面，提供彩种信息
     */
    function generate($iLotteryId = null) {
        if ($iLotteryId == null) {
            return $this->goBackToIndex('error', __('invalid lottery !'));
        }
        $step = isset($this->params['step']) ? intval($this->params['step']) : 0;
        $step++;
//        pr($step);exit;
        switch ($step) {
            case 1:
                $oLottery = ManLottery::find($iLotteryId);
//                $aLotteryInfo = $oLottery->find($iLotteryId)->getAttributes();
//                pr($aLotteryInfo);
                if (empty($oLottery)) {
                    return $this->goBackToIndex('error', __('Invalid Lottery ID'));
                }
                $aIssueRules = IssueRule::getIssueRulesOfLottery($iLotteryId);
                $oIssue = new ManIssue;
                //获取最后一期已经存在的奖期
                if ($aLastIssue = $oIssue->getLastIssueInfo($iLotteryId)) {
                    $sLastIssue = $aLastIssue['issue'];
                    //获取生成奖期的开始时间
                    if (!empty($sBeginDate)) {
                        $dBeginDate = $sBeginDate;
                    } else {
                        $dBeginDate = $oLottery->getNextDay($aLastIssue['offical_time']);
                    }
                } else {
                    $sLastIssue = $dBeginDate = '';
                }
                $oDate = new Date;
                // 获取一周开奖时间，即周一到周日哪几天开奖
                $aWeek = & $oDate->checkWeekDays($oLottery->days);

                $sIssueFormat = $oLottery->issue_format;
//                pr($sIssueFormat);
                $bAccumulating = (strpos($sIssueFormat, 'T') !== false || strpos($sIssueFormat, 'C') !== false); //奖期是否需要全年累加
//                $bNeedBeginIssue = $bAccumulating && !$sLastIssue;
                $this->setVars('bNeedBeginIssue', $bAccumulating && !$sLastIssue);
                $this->setVars(compact('sIssueFormat'));
                $this->setVars('weeks', $oDate->weeks);
                $this->setVars('aBonusDays', $aWeek);
                $this->setVars(compact('sLastIssue', 'dBeginDate'));
                $this->setVars('sLotteryName', $oLottery->name);
                $this->setVars('bNeedCalendar', true);
                $this->setVars('aIssueRules', $aIssueRules);
                $this->setVars('lottery_id', $iLotteryId);
                $this->setVars('step', $step);
                return $this->render();
                break;
            case 2:
                return $this->generateStep2();
                break;
            case 3:
                return $this->generateStep3();
        }
    }

    /**
     * 奖期生成第二步，奖期生成确认界面
     */
    private function generateStep2() {
        $oDate = new Date;
        // 验证日期开始日期和结束日期是否符合要求
        if (!$oDate->isLegalDate($this->params['begin_date'])) {
            return $this->goBackToIndex('error', __('Error: The begin date is not valid!!!'));
        }
        if (!$oDate->isLegalDate($this->params['end_date'])) {
            return $this->goBackToIndex('error', __('Error: The end date is not valid!!!'));
        }
        if ($this->params['begin_date'] > $this->params['end_date']) {
            return $this->goBackToIndex('error', __('Error: The end date must be greater than begin date!!!'));
        }
        // 验证彩种信息是否符合要求
        if ($this->params['lottery_id'] == null) {
            return $this->goBackToIndex('error', __('invalid lottery !'));
        }
        $oLottery = ManLottery::find($this->params['lottery_id']);
        $aLotteries = & ManLottery::getTitleList();
//        $oLottery = new ManLottery;
//        $aLotteryInfo = $oLottery->find($this->params['lottery_id'])->getAttributes();
        if (empty($oLottery)) {
            return $this->goBackToIndex('error', __('Invalid Lottery ID'));
        }
        $aIssueRules = IssueRule::getIssueRulesOfLottery($this->params['lottery_id']);
        // 获取一周开奖时间，即周一到周日哪几天开奖
        $aWeek = & $oDate->checkWeekDays($oLottery->days);
        $sIssueFormat = $oLottery->issue_format;
        $oIssue = new ManIssue;
        $aLastIssue = $oIssue->getLastIssueInfo($oLottery->id);
        $sLastIssue = !empty($aLastIssue) ? $aLastIssue['issue'] : '';
        $bAccumulating = (strpos($sIssueFormat, 'T') !== false || strpos($sIssueFormat, 'C') !== false); //奖期是否需要全年累加
//        $bNeedBeginIssue = $bAccumulating && !$sLastIssue;
        $this->setVars('bNeedBeginIssue', $bAccumulating && !$sLastIssue);

        $this->setVars('weeks', $oDate->weeks);
        $this->setVars(compact('sIssueFormat'));
        $this->setVars('aBonusDays', $aWeek);
        $this->setVars('sLotteryName', $oLottery->name);
        $this->setVars('bNeedCalendar', true);
        $this->setVars('aIssueRules', $aIssueRules);
        $this->setVars(compact('aLotteries'));
        $this->setVars('data', Input::all());
//        pr($this->params);
//        exit;
        $this->view = $this->customViewPath . '.' . 'generateStep2';
        return $this->render();
    }

    /**
     * 奖期生成第三步，生成指定彩种的奖期数据
     */
    function generateStep3() {
//        pr($this->params);exit;
        $iLotteryId = $this->params['lottery_id'];
        $sBeginDate = $this->params['begin_date'];
        $sEndDate = $this->params['end_date'];
        $sLastIssue = $this->params['last_issue'];
        $oLottery = ManLottery::find($iLotteryId);
        $sIssueFormat = $oLottery->issue_format;
        if ($bAccumulating = $oLottery->isAccumulating()) { //奖期是否需要全年累加
            if (!$sLastIssue && empty($this->params['begin_issue'])) {
                $this->goBackToIndex('error', 'Missing Begin Issue');
            }
            $sBeginIssue = $sLastIssue ? '' : $this->params['begin_issue'];
        } else {
            $sBeginIssue = '';
        }

//        $aLotteryInfo = $oLottery->find($iLotteryId)->getAttributes();
        if (empty($oLottery)) {
            $this->goBackToIndex("error", __('Invalid Lottery ID'));
        }
        // 验证日期开始日期和结束日期是否符合要求
        $oDate = new Date;
        if (!$oDate->isLegalDate($this->params['begin_date'])) {
            
        }
        if (!$oDate->isLegalDate($this->params['end_date'])) {
            
        }
        if ($this->params['begin_date'] > $this->params['end_date']) {
            
        }
        if (!$oDate->isLegalDate($sBeginDate)) {
            return $this->goBackToIndex('error', __('Error: The begin date is not valid!!!'));
        }
        if (!$oDate->isLegalDate($sEndDate)) {
            return $this->goBackToIndex('error', __('Error: The end date is not valid!!!'));
        }
        if ($sBeginDate > $sEndDate) {
            return $this->goBackToIndex('error', __('Error: The end date must be greater than begin date!!!'));
        }
        $aIssueRules = IssueRule::getIssueRulesOfLottery($this->params['lottery_id']);
        set_time_limit(0);
        $fBeginTime = microtime(TRUE);
        $this->model->getConnection()->beginTransaction();
        $iCount = $bSucc = $this->_generate($oLottery, $aIssueRules, $sBeginDate, $sEndDate, $sLastIssue, $sBeginIssue);
//        pr($iCount);
//        exit;
        if ($bSucc) {
            $this->model->getConnection()->commit();
            $fEndTime = microtime(TRUE);
            $fCostTime = number_format($fEndTime - $fBeginTime, 3);
            $sMsg = sprintf(__('The issue were generated, spent %s seconds'), $fCostTime);
            return $this->goBackToIndex('success', $sMsg);
        } else {
            $this->model->getConnection()->rollBack();
            return $this->goBackToIndex('error', __('Generate failed!'));
        }
    }

    /**
     * 生成奖期并保存
     * @param array $aLotteryInfo	彩种配置数组
     * @param array $aRules             奖期规则数组
     * @param date $dBeginDate		开始日期
     * @param date $dEndDate		结束日期
     * @param string $sStartIssue	开始奖期号
     * @return bool                 是否成功
     */
    private function _generate($oLottery, $aRules, $dBeginDate, $dEndDate, $sLastIssue, $sStartIssue = '') {
        set_time_limit(0);
//        if($sStartIssue) $this->_checkIssue($sStartIssue,$sIssueRule) > 0 or goBack('奖期不符合规则');
        $sIssueFormat = $oLottery->issue_format;
        if ($bAccumulating = (strpos($sIssueFormat, 'T') !== false || strpos($sIssueFormat, 'C') !== false)) { //奖期是否需要全年累加
//            if (!$sStartIssue){
//                $this->setError(-); //只有这种情况，开始日期才是必须的,所在在此进行检测
//        pr($sStartIssue);
            if (!$sStartIssue) {
                $sLastIssue = $this->model->getLastIssue($oLottery->id);
                $sStartIssue = $this->model->getNextIssue($oLottery->issue_format, $sLastIssue, strtotime($dBeginDate), !$oLottery->high_frequency);
            }
            if ($this->model->getIssueDateMessage($sIssueFormat, $sStartIssue) != $this->model->getIssueDateMessage($sIssueFormat, '', $dBeginDate)) {
                return FALSE;
            }
        }
//        pr($sStartIssue);
//        exit;
//检查是否是休市日
//        LoadClass('Lt_Restday');
//        $oRestday = new Lt_Restday();
//        $aRestdayOptions['pageSize'] = -1;
//        $aRestdayOptions['where'][] = " cp_id = '$oLt->Id'";
//        $aRestdayOptions['orderby'] = " start_date desc ";
//        $aRestdayList = $oRestday->getTableRows($aRestdayOptions);e

        $iStartDay = strtotime($dBeginDate);
        $iEndDay = strtotime($dEndDate); //需要添加的奖期结束时间
//        pr($dBeginDate);
//        exit;
        if ($bAccumulating) {    //数据库中原来不存在奖期数据
//            $iStartDay = strtotime($dBeginDate) - 3600 * 24;
            $sNextIssue = $sStartIssue; //输入的开始奖期
        } else {
//            if ($oLottery->is_highfrequency) {
//                if ($oLottery->is_hf_issue_over_midnight) {//高频跨天,开始时间回退一天
////                    $iStartDay -= 3600 * 24;
//                    $iEndDay += 3600 * 24;
//                }
//            }
//            $sLastIssue = $this->ManIssue->getLastIssue($oLottery->id, $iStartDay);
//            pr($sLastIssue);
            $sNextIssue = $this->model->getNextIssue($sIssueFormat, null, $iStartDay); //获取下一期奖期
        }
// restdays
        $aRestdayList = array();    // temp, need modify
        $data = [];
        $oRestSetting = new RestSetting;
// 获取休市信息
        $aRestSetting = $oRestSetting->getClosedMarketInfoByLotteryId($oLottery->id);
        if (!empty($aRestSetting)) {
            $iExceptionType = $aRestSetting['close_type'];
            if ($iExceptionType == RestSetting::TYPE_DRAW_TIME) {
                $iExceptionBeginTime = strtotime($aRestSetting['start_date']);
                $iExceptionEndTime = strtotime($aRestSetting['end_date']);
            }
            $iExceptionSuccessive = $aRestSetting['issue_successive'];
            if ($iExceptionType == RestSetting::TYPE_REPEATE)
                $aExceptionDays = $aRestSetting['week'] != '' ? explode(",", $aRestSetting['week']) : array();
        }

        if (!$oLottery->high_frequency) {  // low
            $oExistLastIssue = ManIssue::getLastIssueObject($oLottery->id);
            if (is_object($oExistLastIssue)) {
                $iIssueBeginTime = $oExistLastIssue['end_time'];
            } else {
                $iIssueBeginTime = null;
            }
            $iBonusDay = $iStartDay;
            while ($iBonusDay <= $iEndDay) {
                $weekDay = date('w', $iBonusDay);
                if (isset($iExceptionType) && $iExceptionType == RestSetting::TYPE_DRAW_TIME) {
                    if ($iBonusDay >= $iExceptionBeginTime && $iBonusDay < $iExceptionEndTime) {
                        if ($iExceptionSuccessive == 0)
                            $sNextIssue = $this->model->getNextIssue($sIssueFormat, null, $iBonusDay);
                        $iBonusDay += 3600 * 24; //在最近一期的基础上增加一天
                        $iStartDay += 3600 * 24;
                        continue;
                    }
                }else if (isset($iExceptionType) && $iExceptionType == RestSetting::TYPE_REPEATE && in_array($weekDay, $aExceptionDays)) {
                    if ($iBonusDay >= $iExceptionBeginTime && $iBonusDay < $iExceptionEndTime) {
                        // 不是连续的奖期
                        if ($iExceptionSuccessive == 0)
                            $sNextIssue = $this->model->getNextIssue($sIssueFormat, null, $iBonusDay);
                        $iBonusDay += 3600 * 24; //在最近一期的基础上增加一天
                        $iStartDay += 3600 * 24;
                        continue;
                    }
                }
                if ((($oLottery->days) & pow(2, $weekDay)) == 0 || $this->checkRestday($aRestdayList, $iBonusDay)) {//休息日判断
                    $iBonusDay += 3600 * 24; //在最近一期的基础上增加一天
                    continue; //检测到对应天是休息日,不添加这一Day的奖期号，继续循环下一天
                }
                if (date('Y', $iBonusDay) > date('Y', $iBonusDay - SECONDS_OF_DAY) && !ereg('C', $sIssueFormat)) {     //跨年
                    $sNextIssue = $this->model->getNextIssue($sIssueFormat, null, $iBonusDay);
                }
                if (!$bAccumulating) {//不需要全年累加期数的情况
                    $sNextIssue = $this->model->getNextIssue($sIssueFormat, null, $iBonusDay);
                }
                foreach ($aRules as $aRuleData) {
                    $iBeginTimeOfRule = strtotime(date('Y-m-d', $iStartDay) . $aRuleData->begin_time); //第一期开始时间
                    $iIssueBeginTime or $iIssueBeginTime = strtotime(date('Y-m-d', $iStartDay) . $aRuleData->first_time) - $aRuleData->cycle;
                    $iEndTime = strtotime(date('Y-m-d', $iStartDay) . $aRuleData->end_time); //最后一期结束时间
                    $aRuleData->begin_time <= $aRuleData->end_time or $iEndTime += 3600 * 24; //最后一期结束时间，跨天增加一天
                    $bIsFirstIssue = true;      // first
                    while ($iIssueBeginTime <= $iEndTime - $aRuleData->cycle) {
                        $iIssueEndTime = $iIssueBeginTime + $aRuleData->cycle;
                        !$bIsFirstIssue or $iIssueEndTime = strtotime(date('Y-m-d', $iStartDay) . $aRuleData->first_time) - $aRuleData->stop_adjust_time;
                        $iOfficalTime = $iIssueEndTime + $aRuleData->stop_adjust_time;
                        $data[] = array(
                            'lottery_id' => $oLottery->id,
                            'issue' => $sNextIssue,
                            'begin_time' => $iIssueBeginTime,
                            'offical_time' => $iOfficalTime,
                            'end_time' => $iIssueEndTime,
                            'end_time2' => date('Y-m-d H:i:s', $iIssueEndTime),
                            'status' => Issue::ISSUE_CODE_STATUS_WAIT_CODE,
                            'allow_encode_time' => $iIssueEndTime + $aRuleData->encode_time,
                            'issue_rule_id' => $aRuleData->id,
                            'cycle' => $aRuleData->cycle
                        );
                        $bIsFirstIssue = false;
                        $sNextIssue = $this->model->getNextIssue($sIssueFormat, $sNextIssue, $iStartDay, TRUE);
                        $iIssueBeginTime = $iIssueEndTime;
                    }
                }
                $iBonusDay += 3600 * 24; //在最近一期的基础上增加一天
                $iStartDay += 3600 * 24;
            }
//            exit;
//                }
        } else {//高频
//            pr($iStartDay);
//            pr(date('Y-m-d H:i:s',$iStartDay));
//            pr($iEndDay);
//            pr(date('Y-m-d H:i:s',$iEndDay));
//            exit;
            $oExistLastIssue = ManIssue::getLastIssueObject($oLottery->id);
            if (is_object($oExistLastIssue)) {
                $iIssueBeginTime = $oExistLastIssue['end_time'];
            } else {
                $iIssueBeginTime = null;
            }
            while ($iStartDay <= $iEndDay) {
                $weekDay = date('w', $iStartDay);
                if ((($oLottery->days) & pow(2, $weekDay)) == 0) {//休息日判断
                    continue; //检测到对应天是休息日,不添加这一天的奖期号，继续循环下一天
                }
                if (date('Y', $iStartDay) > date('Y', $iStartDay - SECONDS_OF_DAY) && strpos($sIssueFormat, 'C') === false) {     //跨年
                    $sNextIssue = $this->model->getNextIssue($sIssueFormat, null, $iStartDay);
                }
                if (!$bAccumulating) {//不需要全年累加期数的情况
                    $sNextIssue = $this->model->getNextIssue($sIssueFormat, null, $iStartDay);
                }
                if (isset($iExceptionType) && $iExceptionType == 2 && in_array($weekDay, $aExceptionDays)) {
                    $iExceptionBeginTime = strtotime(date('Y-m-d', $iStartDay) . ' ' . $this->request->data['IssueBatch']['exceptionBeginTime']);
                    $iExceptionEndTime = strtotime(date('Y-m-d', $iStartDay) . ' ' . $this->request->data['IssueBatch']['exceptionEndTime']);
                }
                // 判断是否有例外，在例外指定的时间段内不产生奖期数据
//                if ($iException == 1) {
//                    if($iExceptionType == 1){
                //一段时间没有奖期数据
//                    }else if($iExceptionType == 2){
//                      //重复时间段内没有奖期数据
//                    }
//                    $iBonusDay += 3600 * 24; //在最近一期的基础上增加一天
//                    continue; //检测到对应天是休息日,不添加这一Day的奖期号，继续循环下一天
//                }
// 得到指定玩法的奖期规则
                foreach ($aRules as $aRuleData) {
                    $iBeginTimeOfRule = strtotime(date('Y-m-d', $iStartDay) . $aRuleData->begin_time); //第一期开始时间
                    $iIssueBeginTime or $iIssueBeginTime = strtotime(date('Y-m-d', $iStartDay) . $aRuleData->first_time) - $aRuleData->cycle;
                    $iEndTime = strtotime(date('Y-m-d', $iStartDay) . $aRuleData->end_time); //最后一期结束时间
                    $aRuleData->begin_time < $aRuleData->end_time or $iEndTime += 3600 * 24; //最后一期结束时间，跨天增加一天
//                    pr($iIssueBeginTime);
//                    pr(date('Y-m-d H:i:s',$iIssueBeginTime));
//                    pr(date('Y-m-d H:i:s',$iEndTime));
//                    pr(date('H:i:s',$iEndTime - $aRuleInfo['cycle']));
//                    exit;
                    $bIsFirstIssue = true;      // first
                    while ($iIssueBeginTime <= $iEndTime - $aRuleData->cycle) {
                        $iIssueEndTime = $iIssueBeginTime + $aRuleData->cycle;
                        !$bIsFirstIssue or $iIssueEndTime = strtotime(date('Y-m-d', $iStartDay) . $aRuleData->first_time) - $aRuleData->stop_adjust_time;
                        $iOfficalTime = $iIssueEndTime + $aRuleData->stop_adjust_time;
//                        pr($aRuleData->stop_adjust_time);
//                        pr(date('Y-m-d H:i:s', $iIssueBeginTime));
//                        pr(date('Y-m-d H:i:s', $iIssueEndTime));
//                        pr(date('Y-m-d H:i:s', $iOfficalTime));
//                        $iRealBeginTime = $bIsFirstIssue ? $iBeginTimeOfRule : $iIssueBeginTime - $aRuleData->stop_adjust_time;
//                            pr("enter");pr($this->request->data['IssueBatch']);exit;
                        if (isset($iExceptionType) && $iExceptionType == 1) {
                            if ($iIssueBeginTime >= $iExceptionBeginTime && $iIssueBeginTime < $iExceptionEndTime) {
                                if ($iExceptionSuccessive == 0)
                                    $sNextIssue = $this->model->getNextIssue($sIssueFormat, $sNextIssue, $iStartDay);
                                $iIssueBeginTime = $iIssueEndTime;
                                continue;
                            }
                        }else if (isset($iExceptionType) && $iExceptionType == RestSetting::TYPE_REPEATE && in_array($weekDay, $aExceptionDays)) {
                            if ($iIssueBeginTime >= $iExceptionBeginTime && $iIssueBeginTime < $iExceptionEndTime) {
                                // 不是连续的奖期
                                if ($iExceptionSuccessive == 0)
                                    $sNextIssue = $this->model->getNextIssue($sIssueFormat, $sNextIssue, $iStartDay);
                                $iIssueBeginTime = $iIssueEndTime;
                                continue;
                            }
                        }
                        $data[] = array(
                            'lottery_id' => $oLottery->id,
                            'issue' => $sNextIssue,
                            'begin_time' => $iIssueBeginTime,
//                            'sale_close_time' => $iIssueEndTime - $aRuleInfo['stop_adjust_time'],
                            'offical_time' => $iOfficalTime,
                            'end_time' => $iIssueEndTime,
                            'end_time2' => date('Y-m-d H:i:s', $iIssueEndTime),
                            'status' => Issue::ISSUE_CODE_STATUS_WAIT_CODE,
                            'allow_encode_time' => $iIssueEndTime + $aRuleData->encode_time,
                            'issue_rule_id' => $aRuleData->id,
                            'cycle' => $aRuleData->cycle
                        );
//                        pr('-----------------------------------------------');
////                        pr(date('Y-m-d H:i:s', $iIssueBeginTime));
//                        pr($data);
//                        pr('-----------------------------------------------');
//                        exit;
                        $bIsFirstIssue = false;
                        $sNextIssue = $this->model->getNextIssue($sIssueFormat, $sNextIssue, $iStartDay);
                        $iIssueBeginTime = $iIssueEndTime;
                    }
                }
                $iStartDay += 3600 * 24; //在最近一期的基础上增加一天
            }
        }
        return $this->model->saveAllIssues($data);
    }

    /**
     * 录号
     * @param int $iLotteryId
     * @return Redirect
     */
    public function encode($iLotteryId = null) {
        // pr(Request::method());exit;
        if (Request::method() == 'POST') {
            $sWnNumber = trim(Input::get('wn_number'));
            $iLotteryId = trim(Input::get('lottery_id'));
            $sIssue = trim(input::get('issue'));

            $oIssue = ManIssue::getIssue($iLotteryId, $sIssue);
            if (!$oIssue) {
                return $this->goBack('error', __('_basic.no-data', $this->langVars));
            }
            $oLottery = ManLottery::find($iLotteryId);
            if ($oIssue->status < ManIssue::ISSUE_CODE_STATUS_FINISHED) {
                $sCode = $oLottery->formatWinningNumber($sWnNumber);
                if ($oLottery->checkWinningNumber($sCode)) {
                    $bSucc = $oIssue->setWinningNumber($sCode);
                    if ($bSucc === true) {
                        $aJobData = [
                            'lottery_id' => $oIssue->lottery_id,
                            'issue' => $oIssue->issue,
                        ];
                        $bSucc = BaseTask::addTask('CalculatePrize', $aJobData, 'calculate');
//                        Queue::push('CalculatePrize',$aJobData,Config::get('schedule.calculate'));
                        // todo: add count prize task to queue
                        return $this->goBack('success', __('_issue.encoded', $this->langVars));
                    } else {
                        $key = $bSucc == -1 ? '_issue.encode-fail-time' : '_issue.encode-fail';
                    }
                } else {
                    $key = '_issue.encode-fail-wrong-number';
                }
            } else {
                $key = '_issue.encode-fail-encoded';
            }
            $this->langVars['lottery'] = $oLottery->name;
            $this->langVars['issue'] = $sIssue;
            $this->langVars['wn_number'] = $sWnNumber;
            return $this->goBack('error', __($key, $this->langVars));
        } else {
            isset($iLotteryId) or $iLotteryId = 1; // TODO 暂时设置默认彩票id为1
            $oIssue = new ManIssue;
            $sModelName = & $this->modelName;
            $oLatestIssue = $oIssue->getFirstNonNumberIssue($iLotteryId);
            $aColumnForList = $sModelName::$columnForList;
//            $datas          = $oQuery->paginate(static::$pagesize);
            $datas = $oIssue->getIssueObjects($iLotteryId, 100, null, time(), true);
            $this->setVars(compact('oLatestIssue', 'aColumnForList', 'datas'));
            return $this->render();
        }
    }

    /**
     * 发起计奖任务
     * @param int $id
     * @return Redirect
     */
    public function setCalculateTask($id) {
        $oIssue = ManIssue::find($id);
        if (empty($oIssue)) {
            return $this->goBack('error', __('_basic.no-data'));
        }
        if ($oIssue->status != ManIssue::ISSUE_CODE_STATUS_FINISHED) {
            return $this->goBack('error', __('_issue.has-no-winning-number'));
        }
        if ($bSucc = $oIssue->setCalculateTask()) {
            $sLangKey = '_issue.calculate-task-seted';
            $sMsgType = 'success';
        } else {
            $sLangKey = '_issue.calculate-task-set-failed';
            $sMsgType = 'error';
        }
        return Redirect::route('issues.encode', ['lottery_id' => $oIssue->lottery_id])->with($sMsgType, __($sLangKey));
    }

    /**
     * 发起批量计奖任务
     * @return Redirect
     */
    public function setCalculateTaskBatch($iLotteryId = null) {
        set_time_limit(0);
        $oIssues = ManIssue::getNeedCalculateIssues($iLotteryId);
        if ($oIssues->count() == 0) {
            return Redirect::route('issues.encode')->with('success', __('_issue.calculate-task-no-issue'));
        }
        $iSuccCount = $iFailCount = 0;
        $aFails = [];
        $i = 0;
        foreach ($oIssues as $oIssue) {
//            pr($oIssue->getAttributes());
//            continue;
            if ($i++ > 200) {
                break;
            }
            if ($bSucc = $oIssue->setCalculateTask()) {
                $iSuccCount++;
            } else {
                $iFailCount++;
                $aFails[] = $oIssue->getAttributes();
            }
        }
        $sMsgType = 'success';
        $sLangKey = $iFailCount ? '_issue.calculate-task-batch-partial' : '_issue.calculate-task-batch-seted';
        $aInfo = $iFailCount ? ['failed' => var_export($aFails, true)] : [];
        return Redirect::route('issues.encode')->with($sMsgType, __($sLangKey, $aInfo));
    }

    /**
     * 发起未开奖撤单任务
     * @param int $id
     * @return Redirect
     */
    public function setCancelTask($id) {
        $oIssue = ManIssue::find($id);
        if (empty($oIssue)) {
            return Redirect::route('issues.encode', ['lottery_id' => $oIssue->lottery_id])->with('error', __('_basic.no-data'));
        }
        if (!in_array($oIssue->status, [ManIssue::ISSUE_CODE_STATUS_WAIT_CODE, ManIssue::ISSUE_CODE_STATUS_CANCELED])) {
            return Redirect::route('issues.encode', ['lottery_id' => $oIssue->lottery_id])->with('error', __('_issue.wrong-status'));
        }
        if ($bSucc = $oIssue->setCancelTask()) {
            $sLangKey = '_issue.cancel-task-seted';
            $sMsgType = 'success';
        } else {
            $sLangKey = '_issue.cancel-task-set-failed';
            $sMsgType = 'error';
        }
        return Redirect::route('issues.encode', ['lottery_id' => $oIssue->lottery_id])->with($sMsgType, __($sLangKey));
    }

    /**
     * 奖期操作，取消开奖，修改开奖号码，提前开奖
     * @param int $lottery_id  彩种id
     * @param string $issue     奖期数据
     * @return type
     */
    public function issueOperate($lottery_id = null, $issue = null) {
        if (Request::method() == 'POST') {
            $iType = $this->params['operate_type'];
            if (!in_array($iType, [ManIssue::ISSUE_OPERATE_TYPE_REVISE, ManIssue::ISSUE_OPERATE_TYPE_CANCEL, ManIssue::ISSUE_OPERATE_TYPE_ADVANCED])) {
                return $this->goBack('error', __('_issue.wrong-operate-type'));
            }
            $lottery_id = $this->params['lottery_id'];
            $issue = $this->params['issue'];
            switch ($iType) {
                case ManIssue::ISSUE_OPERATE_TYPE_REVISE:
                    $result = $this->reviseCode($lottery_id, $issue);
                    break;
                case ManIssue::ISSUE_OPERATE_TYPE_CANCEL:
                    $result = $this->cancelCode($lottery_id, $issue);
                    break;
                case ManIssue::ISSUE_OPERATE_TYPE_ADVANCED:
                    $result = $this->advanceCode($lottery_id, $issue);
                    break;
            }
            return $result;
        } else {
            $aLotteries = ManLottery::getAllLotteries(ManLottery::STATUS_AVAILABLE);
            $aOperateType = ManIssue::getIssueOperateTypes();
            $this->setVars(compact('aLotteries', 'aOperateType'));
            return $this->render();
        }
    }

    /**
     * 修改开奖号码后,触发取消派奖,重新计奖的流程
     */
    public function reviseCode($lottery_id, $issue) {
        $oIssue = ManIssue::getIssue($lottery_id, $issue);
        if (!is_object($oIssue)) {
            return $this->goBack('error', __('_issue.missing-data'));
        }
        $oLottery = ManLottery::find($lottery_id);
        if (!is_object($oLottery)) {
            return $this->goBack('error', __('_lottery.missing-data'));
        }
        if ($oLottery->is_self) {
            return $this->goBack('error', __('_lottery.self-not-allowed'));
        }
        $sNewCode = $this->params['new_code'];
        $sCode = $oLottery->formatWinningNumber($sNewCode);
        if (!$oLottery->checkWinningNumber($sCode)) {
            return $this->goBack('error', __('_issue.wrong-code'));
        }
        $bSucc = $oIssue->setCancelPriceTask(null, $sCode);

        if ($bSucc) {
            return $this->goBackToIndex('success', __('_issue.revise-success'));
        } else {
            return $this->goBackToIndex('error', __('_issue.revise-fail'));
        }
    }

    /**
     * 官方未开奖的处理流程
     */
    public function cancelCode($lottery_id, $issue) {
        $oIssue = ManIssue::getIssue($lottery_id, $issue);
        if (!is_object($oIssue)) {
            return $this->goBack('error', __('_issue.missing-data'));
        }
        if (!in_array($oIssue->status, [ManIssue::ISSUE_CODE_STATUS_WAIT_CODE, ManIssue::ISSUE_CODE_STATUS_CANCELED])) {
            return $this->goBack('error', __('_issue.wrong-status'));
        }
        if ($bSucc = $oIssue->setCancelTask()) {
            $sLangKey = '_issue.cancel-task-seted';
            $sMsgType = 'success';
        } else {
            $sLangKey = '_issue.cancel-task-set-failed';
            $sMsgType = 'error';
        }
        return $this->goBack($sMsgType, __($sLangKey));
    }

    /**
     * 提前开奖的处理流程
     */
    public function advanceCode($lottery_id, $issue) {
        $oIssue = ManIssue::getIssue($lottery_id, $issue);
        if (!is_object($oIssue)) {
            return $this->goBack('error', __('_issue.missing-data'));
        }
        $sEarliestDrawTime = $this->params['earliest_draw_time'];
        if (strtotime($sEarliestDrawTime) > $oIssue->offical_time || $sEarliestDrawTime < $oIssue->begin_time) {
            return $this->goBack('error', __('_issue.wrong-time'));
        }
        $bSucc = $oIssue->setCancelTask($sEarliestDrawTime);
        if ($bSucc) {
            return $this->goBackToIndex('success', '_issue.advance-success');
        } else {
            return $this->goBackToIndex('error', '_issue.advance-fail');
        }
    }

    /**
     * temp
     * @return boolean always false
     */
    function checkRestday() {
        return false;
    }

}
