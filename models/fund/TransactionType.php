<?php
/**
 * 账变类型
 */
class TransactionType extends BaseModel {
    const TYPE_DEPOSIT                                          = 1;
    const TYPE_WITHDRAW                                     = 2;
    const TYPE_TRANSFER_IN                                  = 3;
    const TYPE_TRANSFER_OUT                              = 4;
    const TYPE_FREEZE_FOR_TRACE                       = 5;
    const TYPE_UNFREEZE_FOR_BET                      = 6;
    const TYPE_BET                                                   = 7;
    const TYPE_DROP                                               = 8;
    const TYPE_FREEZE_FOR_WITHDRAWAL        = 9;
    const TYPE_UNFREEZE_FOR_WITHDRAWAL  = 10;
    const TYPE_SEND_PRIZE                                   = 11;
    const TYPE_CANCEL_PRIZE                               = 12;
    const TYPE_SEND_COMMISSION                     = 13;
    const TYPE_CANCEL_COMMISSION                = 14;
    const TYPE_UNFREEZE_FOR_TRACE                = 15;
    const TYPE_DEPOSIT_FEE_BACK                      = 16;
    const TYPE_WITHDRAW_FEE                            = 17;
    const TYPE_DEPOSIT_BY_ADMIN                    = 18;
    const TYPE_WITHDRAW_BY_ADMIN               = 19;
    const TYPE_SEND_DIVIDEND                           = 20;
    const TYPE_CANCEL_DIVIDEND                      = 21;
    const TYPE_SETTLING_CLAIMS                       = 22;
    const TYPE_PROMOTIANAL_BONUS             = 23;
    const TYPE_DEPOSIT_COMMISSION             = 24;
    const TYPE_DEDUCTION                                 = 25;
    const TYPE_NEW_GAME_LUCKY_MONEY      = 26;
    const TYPE_SEND_SALARY                            = 27;
    const TYPE_DEDUCT_ACTIVITY                     = 28;

    protected static $cacheLevel = self::CACHE_LEVEL_FIRST;
    protected $table = 'transaction_types';
    protected $softDelete = false;
    protected $fillable = [
        'id',
        'parent_id',
        'fund_flow_id',
        'description',
        'cn_title',
        'balance',
        'available',
        'frozen',
        'withdrawable',
        'prohibit_amount',
        'credit',
        'debit',
        'project_linked',
        'trace_linked',
        'reverse_type'
    ];

    public static $resourceName = 'TransactionType';
    public static $titleColumn = 'description';

    public static $ignoreColumnsInEdit = [
        'balance',
        'available',
        'frozen',
    ];
    /**
     * the columns for list page
     * @var array
     */
    public static $columnForList = [
        'id',
        'description',
        'cn_title',
        'fund_flow_id',
        'balance',
        'available',
        'frozen',
        'withdrawable',
        'prohibit_amount',
        'credit',
        'debit',
        'project_linked',
        'trace_linked',
        'reverse_type'
    ];

    /**
     * 下拉列表框字段配置
     * @var array
     */
    public static $htmlSelectColumns = [
        'fund_flow_id' => 'aFundFlows',
        'balance' => 'aFundActions',
        'available' => 'aFundActions',
        'frozen' => 'aFundActions',
        'reverse_type' => 'aTransactionTypes'
    ];

    /**
     * order by config
     * @var array
     */
    public $orderColumns = [
        'credit' => 'desc'
    ];

    /**
     * If Tree Model
     * @var Bool
     */
    public static $treeable = true;

    /**
     * the main param for index page
     * @var string
     */
    public static $mainParamColumn = 'parent_id';

    public static $rules = [
        'description'    => 'required|max:30',
        'cn_title'      => 'required|max:30',
        'fund_flow_id'   => 'required|integer',
        'reverse_type'  => 'integer',
//        'balance'        => 'required|in:1,0,-1',
//        'available'      => 'required|in:1,0,-1',
//        'frozen'         => 'required|in:1,0,-1',
        'withdrawable'   => 'required|integer',
        'prohibit_amount'   => 'required|integer',
        'credit'         => 'in:0,1',
        'debit'          => 'in:0,1',
        'project_linked' => 'in:0,1',
        'trace_linked'    => 'in:0,1',
    ];

    protected function beforeValidate(){
        if (!$this->fund_flow_id){
            return false;
        }
        if (!$oFundFlow = FundFlow::find($this->fund_flow_id)){
            return false;
        }
        $this->balance = $oFundFlow->balance;
        $this->available = $oFundFlow->available;
        $this->frozen = $oFundFlow->frozen;
//        $this->withdrawable = $oFundFlow->withdrawable;
        $this->credit or $this->credit = 0;
        $this->debit or $this->debit = 0;
        $this->reverse_type or $this->reverse_type = null;
        return parent::beforeValidate();
    }

    public static function getAllTransactionTypes()
    {
        $aColumns = ['id', 'description','cn_title'];
        $aTransactionTypes = self::all($aColumns);
        return $aTransactionTypes;
    }
    
    private static function makeCacheKeyOfAll(){
        return 'basic-transaction-types';
    }

    public static function getAllTransactionTypesArray()
    {
        $bReadDb = true;
        $bPutCache = false;
        if (static::$cacheLevel != self::CACHE_LEVEL_NONE){
            Cache::setDefaultDriver(static::$cacheDrivers[static::$cacheLevel]);
            $sCacheKey = self::makeCacheKeyOfAll();
            if ($aAllTypes = Cache::get($sCacheKey)) {
                $bReadDb = false;
            }
            else{
                $bPutCache = true;
            }
        }
        if ($bReadDb){
            $aAllTypes = [];
            $aTransactionTypes = self::getAllTransactionTypes();
            foreach ($aTransactionTypes as $oTransactionType) {
                $aAllTypes[$oTransactionType->id] = $oTransactionType->cn_title;
            }
        }

        if ($bPutCache){
            Cache::forever($sCacheKey, $aAllTypes);
        }
//        pr($aAllTypes);
//        exit;
        return $aAllTypes;
    }

    public static function getFieldsOfAllTransactionTypesArray()
    {
        $data = [];
        $aTransactionTypes = self::getAllTransactionTypes();
        foreach ($aTransactionTypes as $oTransactionType) {
            $data[$oTransactionType->id] = $oTransactionType->cn_title;
        }
        return $data;
    }

    protected function getFriendlyDescriptionAttribute(){
        return __('_transactiontype.' . strtolower(Str::slug($this->attributes[ 'description' ])));
    }
}