<?php

/**
 * 管理员角色关系模型
 *
 * @author frank
 */
class PaymentPlatformBank extends BaseModel {

    protected $table = 'payment_platform_banks';
    public static $resourceName = 'PaymentPlatformBank';
    protected $fillable = [
        'id',
        'platform_name',
        'platform_id',
        'platform_identifier',
        'bank_id',
        'bank_name',
        'bank_identifier',
    ];
    public static $columnForList = [
        'platform_name',
        'platform_identifier',
        'bank_name',
        'bank_identifier',
        'created_at',
        'updated_at',
    ];
    public static $htmlSelectColumns = [
    ];
    public $orderColumns = [
        'updated_at' => 'asc'
    ];
    public static $rules = [
        'bank_id' => 'required|integer',
        'platform_id' => 'required|integer',
    ];
    public static $mainParamColumn = 'platform_id';

    protected function beforeValidate() {
        $oPaymentPlatform = PaymentPlatform::find($this->platform_id);
        if (is_object($oPaymentPlatform)) {
            $this->platform_name = $oPaymentPlatform->name;
            $this->platform_identifier = $oPaymentPlatform->identifier;
        } else {
            return false;
        }
        $oBank = Bank::find($this->bank_id);
        if (is_object($oPaymentPlatform)) {
            $this->bank_name = $oPaymentPlatform->name;
            $this->bank_identifier = $oPaymentPlatform->identifier;
        } else {
            return false;
        }
        return parent::beforeValidate();
    }

}
