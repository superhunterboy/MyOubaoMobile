<?php

class Expression extends BaseModel {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'expressions';
    protected $softDelete = false;
    public $timestamps = false; // 取消自动维护新增/编辑时间
    protected $fillable = [
        'description',
        'identifier',
//'content',
    ];
    public static $resourceName = 'Expression';

    /**
     * the columns for list page
     * @var array
     */
    public static $columnForList = [
        'identifier',
        'content',
        'description',
    ];

    /**
     * 下拉列表框字段配置
     * @var array
     */
    public static $htmlSelectColumns = [
        'mode' => 'aMode',
    ];

    /**
     * order by config
     * @var array
     */
    public $orderColumns = [
    ];
    public static $titleColumn = 'name';
    public static $aMode = [
        self::BANK_MODE_BANK_CARD => 'bank-card-mode',
        self::BANK_MODE_THIRD_PART => 'third-part',
        self::BANK_MODE_ALL => 'all-mode',
    ];

    /**
     * the main param for index page
     * @var string
     */
    public static $mainParamColumn = 'name';
    public static $rules = [
    ];

    /**
     * 状态：可用
     */
    const BANK_STATUS_AVAILABLE = 1;

    /**
     * 状态：不可用
     */
    const BANK_STATUS_NOT_AVAILABLE = 0;

    /**
     * 手续费开关：关闭
     */
    const BANK_FEE_SWITCH_OFF = 0;

    /**
     * 手续费开关：开启
     */
    const BANK_FEE_SWITCH_ON = 1;

    /**
     * 模式：银行卡转账
     */
    const BANK_MODE_BANK_CARD = 1;

    /**
     * 模式：第三方
     */
    const BANK_MODE_THIRD_PART = 2;

    /**
     * 模式：兼容所有
     */
    const BANK_MODE_ALL = 3;

    /**
     * 手续费返还百分比取值集合
     * @var array
     */
    public static $aBankFeeRateSet = [0.1, 0.15, 0.2, 0.25, 0.3, 0.35, 0.4, 0.45, 0.5];

    // public function user()
    // {
    //     return $this->BelongsTo('User', 'user_bank_cards', 'bank_id', 'user_id')->withTimestamps();
    // }
    // public static function getAllBankNameArray()
    // {
    //     $data = [];
    //     $aUsers = Bank::all(['id', 'name']);
    //     foreach ($aUsers as $key => $value) {
    //         $data[$value->id] = $value->name;
    //     }
    //     return $data;
    // }

    /**
     * To get all of bank's information
     * @param boolean $bAvailable TRUE: available only | FALSE: all (default: TRUE)
     * @return Bank[]
     */
    public static function getAllBankInfo($bAvailable = TRUE) {
        $aData = [];
        if ($bAvailable) {
            $aData = Bank::where('status', '=', BANK::BANK_STATUS_AVAILABLE)->get();
        } else {
            $aData = Bank::all();
        }
        return $aData;
    }

    public static function & getAllBankArray($bAvailable = TRUE) {
        $oBanks = self::getAllBankInfo($bAvailable);
        $aBanks = [];
        foreach ($oBanks as $oBank) {
            $aBanks[$oBank->id] = $oBank->name;
        }
        return $aBanks;
    }

    /**
     * 获取支持银行卡转账的银行
     * @return array
     */
    public static function getSupportCardBank() {
        $oQuery = Bank::whereIn('mode', [Bank::BANK_MODE_BANK_CARD, Bank::BANK_MODE_ALL]);
        $oQuery->where('status', '=', BANK::BANK_STATUS_AVAILABLE);
        return $oQuery->get();
    }

    /**
     * 获取银行信息，供绑卡使用
     * @return array
     */
    public static function getAllBank() {
        $oQuery = Bank::where('status', '=', BANK::BANK_STATUS_AVAILABLE);
        return $oQuery->get();
    }

    /**
     * 获取支持第三方充值的银行
     * @return array
     */
    public static function getSupportThirdPartBank() {
        $oQuery = Bank::whereIn('mode', [Bank::BANK_MODE_THIRD_PART, Bank::BANK_MODE_ALL]);
        $oQuery->where('status', '=', BANK::BANK_STATUS_AVAILABLE);
        $oQuery->orderBy('sequence', 'asc');
        return $oQuery->get();
    }

    /**
     * 生成手续费表达式「公式」（需要以下格式数组作为条件）：
     * <pre>array(
     *  ['x'=>['>='=>100, '<'=>'200'], 'y'=>['='=>5]],
     *  ['x'=>['>='=>200, '<'=>'500'], 'y'=>['%'=>5]],
     * )</pre>
     * @param array $aConditions 条件数据
     * @return string 公式（示例：x>=100&&x<200&&y=5;x>=200&&y=x*5/100）
     */
    public function setExpressions($aConditions = []) {
        $aResult = [];
        if (empty($aConditions)) {
            $this->content = '';
        }
        if (!is_array($aConditions)) {
            return false;
        }
        foreach ($aConditions as $ct) {
            if (!empty($ct['x']) && !empty($ct['y'])) {
                $aTemp = [];
                foreach ($ct['x'] as $k => $v) {
                    $v = floatval($v);
                    switch ($k) {
                        case '>':
                            $aTemp[] = 'x>' . $v;
                            break;
                        case '>=':
                            $aTemp[] = 'x>=' . $v;
                            break;
                        case '<':
                            $aTemp[] = 'x<' . $v;
                            break;
                        case '<=':
                            $aTemp[] = 'x<=' . $v;
                            break;
                        default :
                            break;
                    }
                }
                foreach ($ct['y'] as $k => $v) {
                    switch ($k) {
                        case '=':
                            $aTemp[] = 'y=' . floatval($v);
                            break;
                        case '%':
                            $aTemp[] = 'y=x*' . floatval($v) . '/100';
                            break;
                        default :
                            break;
                    }
                }
                $aResult[] = implode('&&', $aTemp);
            }
        }
        $this->content = implode(';', $aResult);
    }

    /**
     * 解析手续费表达式为数组形式，返回数据格式如下：
     * <pre>array(
     *  ['x'=>['>='=>100, '<'=>'200'], 'y'=>['='=>5]],
     *  ['x'=>['>='=>200, '<'=>'500'], 'y'=>['%'=>5]],
     * )</pre>
     * @return array
     */
    public function getExpressionsArray() {
        $aResult = [];
        if (empty($this->content)) {
            return $aResult;
        }
        // x>=100&&x<200&&y=5;x>=200&&y=x*5/100
        $aConditions = explode(';', $this->content);
        foreach ($aConditions as $ct) {
            $aTemp = [];
            preg_match_all('/x([><]=?)(\d+(?:\.\d+)?)/', $ct, $matches);
            foreach ($matches[1] as $k => $v) {
                $aTemp['x'][$v] = $matches[2][$k];
            }
            preg_match_all('/y=(x\*)?(\d+(?:\.\d+)?)(\/100)?/', $ct, $matches);
            if (!empty($matches[1][0]) && !empty($matches[3][0])) {
                $aTemp['y']['%'] = $matches[2][0];
            } else {
                $aTemp['y']['='] = $matches[2][0];
            }
            $aResult[] = $aTemp;
        }
        return $aResult;
    }

    protected function beforeValidate() {
        return parent::beforeValidate();
    }

    /**
     * 根据公式计算手续费
     * @param float $fAmount 充值金额
     * @return float
     */
    public function calculateBankFee($fAmount) {
        $fAmount = floatval($fAmount);
        $fBankFee = 0;
        if (empty($this->fee_expressions)) {
            return $fBankFee;
        }
        // x>=100&&x<200&&y=5;x>=200&&y=x*5/100
        $sFeeExpressions = str_replace('x', '$fAmount', $this->fee_expressions);
        $sFeeExpressions = str_replace('y', '$fBankFee', $sFeeExpressions);
        eval($sFeeExpressions . ';');
        return number_format($fBankFee, 2, '.', ''); // 保留两位小数，四舍五入
    }

    public static function getExpressionByIdentifier($sIdentifier) {
        return self::where('identifier', '=', $sIdentifier)->get()->first();
    }

}
