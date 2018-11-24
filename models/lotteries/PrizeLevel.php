<?php

class PrizeLevel extends BaseModel {
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'prize_levels';
    /**
     * 软删除
     * @var boolean
     */
    protected $softDelete = false;
    protected $fillable = [
        'lottery_type_id',
        'basic_method_id',
        'level',
        'probability',
        'max_prize',
        'full_prize',
        'max_group',
        'min_water',
        'rule',
    ];

    public static $resourceName = 'Prize Level';
    /**
     * number字段配置
     * @var array
     */
    public static $htmlNumberColumns = [
        'max_prize' => 2
    ];

    /**
     * the columns for list page
     * @var array
     */
    public static $columnForList = [
        'lottery_type_id',
        'basic_method_id',
        'level',
        'probability',
        'max_group',
        'full_prize',
        'max_prize',
        'min_water',
        'rule',
    ];

    /**
     * 下拉列表框字段配置
     * @var array
     */
    public static $htmlSelectColumns = [
//        'type' => 'aLotteryTypes',
        'basic_method_id' => 'aBasicMethods',
    ];

    public static $listColumnMaps = [
        'probability' => 'probability_formatted',
        'min_water' => 'min_water_formatted',
        'full_prize' => 'full_prize_formatted'
    ];

    public static $viewColumnMaps = [
        'probability' => 'probability_formatted',
        'min_water' => 'min_water_formatted',
        'full_prize' => 'full_prize_formatted'
    ];
    /**
     * order by config
     * @var array
     */
    public $orderColumns = [
        'lottery_type_id' => 'asc',
        'basic_method_id' => 'asc',
    ];

    /**
     * the main param for index page
     * @var string
     */
    public static $mainParamColumn = 'basic_method_id';

    public $digitalCounts = [];
    public static $rules = [
        'basic_method_id' => 'required|integer',
        'level'           => 'required|numeric',
        'probability'     => 'required|numeric|max:0.9',
        'max_group'       => 'required|numeric',
        'full_prize'      => 'numeric',
        'max_prize'       => 'numeric',
        'min_water'       => 'numeric|min:0',
        'rule'            => 'max:50'
    ];

    protected function beforeValidate(){
        if (empty($this->basic_method_id)){
            return false;
        }
        $oBasicMethod          = BasicMethod::find($this->basic_method_id);
        $this->lottery_type_id = $oBasicMethod->lottery_type;
        if ($this->probability){
            $this->full_prize = formatNumber(2 / $this->probability,4);
        }
//        pr(!$this->max_prize);
//        exit;
//        if (empty($this->max_prize)){
//            exit;
        $oSeries         = Series::find($oBasicMethod->series_id);
//        pr($oSeries->toArray());
//        exit;
        if ($oSeries->id > 3){
            $this->max_prize = $this->full_prize * ($this->max_group / 2000);
        }
        else{
            $this->max_prize = $this->full_prize * ($this->max_group / $oSeries->classic_amount);
        }
        $this->min_water = 1 - $this->max_prize / $this->full_prize;
//        pr($this->toArray());
//        exit;
        //        }
        return parent::beforeValidate();
    }

    private static function compileAllPrizeLevelCacheKey($iTypeId){
        return self::getCachePrefix(true) . $iTypeId;
    }

    public static function getTheoreticPrizeSets($iTypeId){
        if (!$iTypeId){
            return false;
        }
        $bReadDb = true;
        $bPutCache = false;
        if (static::$cacheLevel != self::CACHE_LEVEL_NONE){
            Cache::setDefaultDriver(static::$cacheDrivers[static::$cacheLevel]);
            $sCacheKey = self::compileAllPrizeLevelCacheKey($iTypeId);
            if ($aData = Cache::get($sCacheKey)) {
                $bReadDb = false;
            }
            else{
                $bPutCache = true;
            }
        }
        if ($bReadDb){
            $oPrizeLevels = self::where('lottery_type_id' , '=', $iTypeId)->get(['basic_method_id','level','full_prize']);
            if (!is_object($oPrizeLevels)) {
                return false;
            }
            $aData = [];
            foreach($oPrizeLevels as $oPrizeLevel){
                $aData[$oPrizeLevel->basic_method_id][$oPrizeLevel->level] = $oPrizeLevel->full_prize;
            }
        }

        if ($bPutCache){
            Cache::forever($sCacheKey, $aData);
        }
        return $aData;
//        $array = [];
//        $aData = self::where('lottery_type_id' , '=', $iTypeId)->get(['basic_method_id','level','full_prize']);
//        foreach($aData as $model){
//            $array[$model->basic_method_id][$model->level] = $model->full_prize;
//        }
//        return $array;
    }
    
    protected function getProbabilityFormattedAttribute(){
        return formatNumber($this->attributes['probability'] * 100,4) . '%';
    }

    protected function getMinWaterFormattedAttribute(){
        return formatNumber($this->attributes['min_water'] * 100,2) . '%';
    }

    protected function getFullPrizeFormattedAttribute(){
        return number_format($this->attributes['full_prize'],4);
    }
}