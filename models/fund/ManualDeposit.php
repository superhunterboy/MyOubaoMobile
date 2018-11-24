<?php

class ManualDeposit extends BaseModel {

    const STATUS_NOT_VERIFIED = 0;
    const STATUS_VERIFIED = 1;
    const STATUS_REFUSED = 2;
    const STATUS_DEPOSIT_SUCCESS = 3;
    const STATUS_DEPOSIT_ERROR = 4;

    public static $amountAccuracy = 2;
    public static $bCheckboxForBatch = true;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'manual_deposits';
    protected $fillable = [
        'user_id',
        'username',
        'is_tester',
        'amount',
        'transaction_type_id',
        'note',
        'administrator',
        'admin_user_id',
    ];
    public static $resourceName = 'ManualDeposit';

    /**
     * the columns for list page
     * @var array
     */
    public static $columnForList = [
        'id',
        'username',
        'is_tester',
        'amount',
        'transaction_description',
        'administrator',
        'note',
        'status',
        'created_at',
    ];
    public static $aDepositStatus = [
        self::STATUS_NOT_VERIFIED => 'not-verified',
        self::STATUS_VERIFIED => 'verified',
        self::STATUS_REFUSED => 'refused',
        self::STATUS_DEPOSIT_SUCCESS => 'deposit-success',
        self::STATUS_DEPOSIT_ERROR => 'deposit-error',
    ];
    public static $rules = [
        'user_id' => 'integer',
        'is_tester' => 'in:0, 1',
        'amount' => 'numeric|min:0',
        'transaction_type_id' => 'integer',
        'transaction_description' => 'between:0,50',
        'note' => 'between:0,100',
        'admin_user_id' => 'integer',
        'status' => 'in:0,1,2',
    ];
    public static $htmlNumberColumns = [
    ];

    /**
     * 下拉列表框字段配置
     * @var array
     */
    public static $htmlSelectColumns = [
        'status' => 'depositStatus',
    ];
    public static $noOrderByColumns = [
    ];

    /**
     * order by config
     * @var array
     */
    public $orderColumns = [
        'id' => 'desc',
    ];
    public static $listColumnMaps = [
        'status' => 'friendly_status',
        'amount' => 'amount_formatted',
    ];
    public static $viewColumnMaps = [
        'status' => 'friendly_status',
        'amount' => 'amount_formatted',
    ];
    public static $ignoreColumnsInView = [
        'admin_user_id',
        'transaction_type_id'
    ];

    public function changeStatus($iFromStatus, $iToStatus) {
        $aExtraData['status'] = $iToStatus;
        $bSucc = self::where('id', '=', $this->id)->where('status', '=', $iFromStatus)->update($aExtraData);
        return $bSucc;
    }

    protected function getFriendlyStatusAttribute() {
        return __('_manualDeposit.' . self::$aDepositStatus[$this->status]);
    }

    protected function getAmountFormattedAttribute() {
        return $this->getFormattedNumberForHtml('amount');
    }

}
