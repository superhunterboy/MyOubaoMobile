<?php

class AlarmRecord extends BaseModel {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'alarm_records';

    /**
     * 资源名称
     * @var string
     */
    public static $resourceName = 'AlarmRecord';
    public static $treeable = false;
    public static $sequencable = false;

    /**
     * the columns for list page
     * @var array
     */
    public static $columnForList = [
//        'codecenter_id',
        'lottery_id',
        'issue',

//        'created_at',
//        'updated_at',
    ];

    /**
     * 下拉列表框字段配置
     * @var array
     */
    public static $htmlSelectColumns = [];

    /**
     * 软删除
     * @var boolean
     */
    protected $softDelete = false;
    protected $fillable = [
        'codecenter_id',
        'lottery_id',
        'issue',
        'number',
        'err_code',
        'err_msg',
        'earliest_draw_time',
        'record_id',
        'correct_time',
        'created_at',
        'updated_at',
    ];

    /**
     * The rules to be applied to the data.
     *
     * @var array
     */
    public static $rules = [
//        'customer_id' => 'required|max:20',
//        'domain' => 'required|max:50',
//        'version' => 'required|integer|min:1|max:2',
//        'ip' => 'required|max:100',
//        'set_url' => 'required|url|max:200',
//        'get_url' => 'url|max:200',
//        'set_verify_url' => 'required|url|max:200',
//        'customer_key' => 'required|size:32',
//        'default' => 'required|in:0,1',
    ];

    /**
     * order by config
     * @var array
     */
    public $orderColumns = [
        'id' => 'desc'
    ];

    /**
     * The array of custom error messages.
     *
     * @var array
     */
    public static $customMessages = [];

}
