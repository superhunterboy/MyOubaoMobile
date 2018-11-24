<?php

class SeriesWayMethod extends BaseModel {

//    protected static $cacheLevel = self::CACHE_LEVEL_FIRST;
    protected $table = 'series_way_methods';

    /**
     * 软删除
     * @var boolean
     */
    protected $softDelete = false;
    protected $fillable = [
        'series_id',
        'name',
        'single',
        'basic_way_id',
        'series_methods',
    ];
    public static $resourceName = 'Way Method Realation';

    /**
     * the columns for list page
     * @var array
     */
    public static $columnForList = [
        'name',
        'single',
        'basic_way_id',
        'series_methods',
    ];

    /**
     * 下拉列表框字段配置
     * @var array
     */
    public static $htmlSelectColumns = [
        'series_id' => 'aSeries',
        'series_methods' => 'aSeriesMethods',
        'basic_way_id' => 'aBasicWays',
    ];

    public static $titleColumn = 'name';
    /**
     * order by config
     * @var array
     */
    public $orderColumns = [
    ];

    /**
     * the main param for index page
     * @var string
     */
    public static $mainParamColumn = 'series_id';
    public static $rules = [
        'name' => 'required|max:30',
        'series_id' => 'required|integer',
        'basic_way_id' => 'required|integer',
        'series_methods' => 'required|max:1024',
        'single' => 'required|in:0,1',
//        'name' => 'required|max:30',
//        'function' => 'required|max:32',
//        'price' => 'required|numeric',
//        'shape' => 'required|numeric',
//        'buy_len' => 'required|numeric',
//        'wn_length' => 'required|numeric',
//        'wn_count' => 'required|numeric',
//        'valid_nums' => 'required|max:50',
    ];

    function beforeValidate() {
        if (!isset($this->id)) {
            if (!$this->basic_way_id){
                return false;
            }
            if (!$this->series_methods){
                return false;
            }
            if (!$this->name){
                $oBasicWay = BasicWay::find($this->basic_way_id);
                if (empty($oBasicWay)) {
                    return false;
                }
                $this->name = $oBasicWay->name;
            }
        }

        return true;
    }

}