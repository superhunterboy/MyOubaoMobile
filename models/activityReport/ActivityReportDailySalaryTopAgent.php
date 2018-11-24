<?php

class ActivityReportDailySalaryTopAgent extends BaseModel {

    protected $table = 'activity_report_daily_salary_topagent';
    public static $resourceName = 'ActivityReportDailySalaryTopAgent';
    public static $columnForList = [
        'username',
        'rebate_amount',
        'rebate_date',
        'team_turnover',
        'team_profit',
    ];

}
