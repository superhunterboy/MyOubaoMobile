<?php

/**
 * Description of Bonus
 *
 * @author abel
 */
class Dividend extends BaseModel {

    const STATUS_WAITING_AUDIT = 0;
    const STATUS_AUDIT_FINISH = 1;
    const STATUS_AUDIT_REJECT = 2;
    const STATUS_BONUS_SENT = 3;
    const TOP_AGENT = 0;
    const NORMAL_AGENT = 1;

    protected $table = 'dividends';
    public static $resourceName = 'Dividend';
    public static $treeable = false;
    public static $sequencable = false;
    protected $softDelete = false;
    public static $aStatus = [
        self::STATUS_WAITING_AUDIT => 'waiting audit',
        self::STATUS_AUDIT_FINISH => 'audited',
        self::STATUS_AUDIT_REJECT => 'rejected',
        self::STATUS_BONUS_SENT => 'bonus sent',
    ];
    public static $aAgentLevel = [
        self::TOP_AGENT => 'top agent',
        self::NORMAL_AGENT => 'agent',
    ];
    public static $columnForList = [
        'year',
        'month',
        'begin_date',
        'end_date',
        'username',
        'is_tester',
        'turnover',
        'prize',
        'bonus',
        'commission',
        'profit',
        'rate',
        'amount',
        'status',
        'auditor',
        'note',
        'verified_at',
        'sent_at',
    ];
    public static $listColumnMaps = [
        'is_tester' => 'is_tester_formatted',
        'rate' => 'rate_formatted',
        'turnover' => 'turnover_formatted',
        'prize' => 'prize_formatted',
        'bonus' => 'bonus_formatted',
        'commission' => 'commission_formatted',
        'profit' => 'profit_formatted',
        'amount' => 'amount_formatted',
        'status' => 'friendly_status',
    ];
    public static $rules = [
        'note' => 'between:0,100',
    ];

    /**
     * 下拉列表框字段配置
     * @var array
     */
    public static $htmlSelectColumns = [
        'status' => 'aStatus',
    ];

    /**
     * order by config
     * @var array
     */
    public $orderColumns = [
        'end_date' => 'desc',
    ];

    protected function getRateFormattedAttribute() {
        return $this->attributes['rate'] * 100 . '%';
    }

    protected function getTurnoverFormattedAttribute() {
        return number_format($this->attributes['turnover'], 2);
    }

    protected function getPrizeFormattedAttribute() {
        return number_format($this->attributes['prize'], 2);
    }

    protected function getBonusFormattedAttribute() {
        return number_format($this->attributes['bonus'], 2);
    }

    protected function getCommissionFormattedAttribute() {
        return number_format($this->attributes['commission'], 2);
    }

    protected function getProfitFormattedAttribute() {
        return number_format($this->attributes['profit'], 2);
    }

    protected function getAmountFormattedAttribute() {
        return number_format($this->attributes['amount'], 2);
    }

    protected function getFriendlyStatusAttribute() {
        return __('_bonus.' . self::$aStatus[$this->status]);
    }

    public static function getDividendByMonthUser($iUserId, $sBeginDate = null, $sEndDate = null) {
        $aConditions = [
            'user_id' => ['=', $iUserId],
        ];
        !$sBeginDate or $aConditions['begin_date'] = ['=', $sBeginDate];
        !$sEndDate or $aConditions['end_date'] = ['=', $sEndDate];
        $oDividend = self::doWhere($aConditions)->orderBy('end_date', 'desc')->get()->first();
        return $oDividend;
    }

    protected function getIsTesterFormattedAttribute() {
        return __('_basic.' . strtolower(Config::get('var.boolean')[$this->attributes['is_tester']]));
    }

}
