<?php

/**
 * 分红规则类
 *
 * @author white
 */
class DividendRule extends BaseModel {

    protected $table = 'dividend_rules';
    public static $resourceName = 'DividendRule';
    public static $treeable = false;
    public static $sequencable = false;
    protected $softDelete = false;
    protected $fillable = [
        'rate',
        'turnover',
    ];
    public static $columnForList = [
        'rate',
        'turnover'
    ];
    public static $listColumnMaps = [
        'rate' => 'rate_formatted',
        'turnover' => 'turnover_formatted',
    ];

    /**
     * The rules to be applied to the data.
     *
     * @var array
     */
    public static $rules = [
        'rate' => 'required|numeric|min:0.01|max:0.40',
        'turnover' => 'required|integer|min:0',
    ];

    /**
     * order by config
     * @var array
     */
    public $orderColumns = [
        'rate' => 'asc',
    ];

    protected function beforeValidate() {
        $this->rate < 1 or $this->rate /= 100;
        $this->turnover >= 100000 or $this->turnover *= 10000;
        return parent::beforeValidate();
    }

    public static function getRuleObject($fRate) {
        $oRule = self::where('rate', '=', $fRate)->get()->first();
        is_object($oRule) or $oRule = new BonusRule(['rate' => $fRate]);
        return $oRule;
    }

    public static function getRuleObjectByProfit($fProfit) {
        $oBonusRule = self::where('turnover', '<=', $fProfit)->orderBy('turnover', 'desc')->first();
        is_object($oBonusRule) or $oBonusRule = null;
        return $oBonusRule;
    }

    public static function updateRule($fRate, $iTurnOver) {
        $oRule = self::getRuleObject($fRate);
        $oRule->turnover = $iTurnOver;
        return $oRule->save();
    }

    protected function getRateFormattedAttribute() {
        return $this->attributes['rate'] * 100 . '%';
    }

    protected function getTurnoverFormattedAttribute() {
        return $this->attributes['turnover'] / 10000 . ' 万';
    }

}
