<?php

class ReserveAgent extends BaseModel {

    //表名
    protected $table = 'reserve_agents';
    //软删除
    protected $softDelete = false;
    public static $columnForList = [
        'id',
        'qq',
        'platform',
        'sale',
        'available_date',
        'created_at',
    ];
    
    protected $fillable = [
        'qq',
        'platform',
        'sale',
        'sale_screenshot_path',
        'available_date',
        'available_time',
    ];
    public $orderColumns = [
        'created_at' => 'desc'
    ];
    public static $htmlSelectColumns = [
        'sale' => 'aSale',
        'available_date' => 'aDate',
        'available_time' => 'aTime',
    ];

    //销售额10w
    const SALE_10 = '小于10万';
    const SALE_30 = '10~30万';
    const SALE_50 = '30~50万';
    const SALE_70 = '50~70万';
    const SALE_100 = '70~100万';
    const SALE_MORE_THAN_100 = '大于100万';
    const DATE_WORKDAY = 1;
    const DATE_WEEKEND = 2;
    const TIME_WORKTIME = 1;
    const TIME_WORKDAYOFF = 2;

    public static $aSale = [
        0 => self::SALE_10,
        1 => self::SALE_30,
        2 => self::SALE_50,
        3 => self::SALE_70,
        4 => self::SALE_100,
        5 => self::SALE_MORE_THAN_100,
    ];
    public static $aDate = [
        self::DATE_WORKDAY => 'workday',
        self::DATE_WEEKEND => 'weekend',
    ];
    public static $aTime = [
        self::TIME_WORKTIME => 'work-time',
        self::TIME_WORKDAYOFF => 'work-dayoff',
    ];
    public static $listColumnMaps = [
        // 'account_available' => 'account_available_formatted',
        'available_date' => 'available_date_formatted',
    ];

    /**
     * the main param for index page
     * @var string
     */
    public static $mainParamColumn = 'id';
    public static $rules = [
        'qq' => 'required|integer|unique:reserve_agents,qq',
        'sale' => 'in:0,1,2,3,4,5',
        'available_date' => 'in:1,2',
        'available_time' => 'in:1,2',
        'platform' => 'max:60',
    ];
    public static $customMessages = [
        'qq.unique' => 'qq必须唯一',
        'qq.required' => '缺少您的qq',
        'qq.integer' => '您的qq填写不正确，请重新填写！',
        'sale.in' => '您的日均销售额选择不正确',
        'available_date.in' => '联系时间选择不正确',
        'available_time.in' => '联系时间选择不正确',
        'platform.max' => '您所代理的平台长度有误，不能超过 :max 个字符',
    ];

    /**
     * 资源名称
     * @var string
     */
    public static $resourceName = 'ReserveAgent';

    /**
     * 取得校验错误信息并转换为字符串返回
     * @return string
     */
    public function & getValidationErrorString() {
        $aErrMsg = [];
        if ($this->isAdmin) {
            // $sLangKey = '_' . Str::slug(static::$resourceName, '_') . '.';
            // pr($sLangKey);exit;
            foreach ($this->validationErrors->toArray() as $sColumn => $sMsg) {
                $aErrMsg[] = implode(',', $sMsg);
            }
        } else {
            foreach ($this->validationErrors->toArray() as $sMsg) {
                $aErrMsg[] = implode(',', $sMsg);
            }
        }
        $sError = implode(' ', $aErrMsg);
        // pr($sError);exit;
        return $sError;
    }

    public function getAvailableDateFormattedAttribute() {
        return __('_reserveagent.' . self::$aDate[$this->available_date]) . '  ' . __('_reserveagent.' . self::$aDate[$this->available_time]);
    }

}
