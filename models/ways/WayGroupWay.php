<?php

class WayGroupWay extends BaseModel {

    protected static $cacheLevel = self::CACHE_LEVEL_FIRST;
    protected $table = 'way_group_ways';

    /**
     * 软删除
     * @var boolean
     */
    protected $softDelete = false;
    protected $fillable = [
        'series_id',
        'group_id',
        'series_way_id',
        'title',
        'en_title',
        'sequence',
    ];
    public static $resourceName = 'Way Group Way';
    public static $sequencable  = true;

    /**
     * the columns for list page
     * @var array
     */
    public static $columnForList = [
        'series_id',
        'group_id',
        'title',
        'en_title',
        'series_way_id',
        'sequence',
    ];

    /**
     * 下拉列表框字段配置
     * @var array
     */
    public static $htmlSelectColumns = [
        'series_id' => 'aSeries',
        'group_id'=> 'aWayGroups',
        'series_way_id'=> 'aSeriesWays',
    ];

    /**
     * order by config
     * @var array
     */
    public $orderColumns = [
        'sequence' => 'asc',
        'id' => 'asc'
    ];

    /**
     * the main param for index page
     * @var string
     */
    public static $mainParamColumn = 'group_id';
    public static $rules = [
        'group_id' => 'required|integer',
        'sequence' => 'integer',
        'title'     => 'max:20',
        'en_title'     => 'max:30',
        'series_way_id' => 'required|integer',
    ];

    public static $treeable = false;

    protected function beforeValidate() {
        if ($this->group_id){
            $oGroup = WayGroup::find($this->group_id);
            $this->series_id = $oGroup->series_id;
        }
        if (!$this->title && $this->series_way_id){
            $oSeriesWay = SeriesWay::find($this->series_way_id);
            $this->title = $oSeriesWay->short_name;
        }
        parent::beforeValidate();
    }

}