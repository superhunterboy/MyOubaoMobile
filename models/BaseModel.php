<?php

/**
 * 基础模型类
 */
use LaravelBook\Ardent\Ardent;

class BaseModel extends Ardent {

    /**
     * No Cache
     */
    const CACHE_LEVEL_NONE = 0;

    /**
     * Level 1 cache
     */
    const CACHE_LEVEL_FIRST = 1;

    /**
     * Level 2 cache
     */
    const CACHE_LEVEL_SECOND = 2;

    /**
     * Level 2 cache
     */
    const CACHE_LEVEL_THIRD = 3;

    protected static $cacheUseParentClass = false;

    /**
     * cache level
     * @var int
     */
    protected static $cacheLevel = self::CACHE_LEVEL_NONE;

    /**
     * 缓存的有效时间
     * @var int
     */
    protected static $cacheMinutes = 0;

    /**
     * 可用的缓存级别
     * @var array
     */
    protected $validCacheLevels = array
        (
        self::CACHE_LEVEL_NONE,
        self::CACHE_LEVEL_FIRST,
        self::CACHE_LEVEL_SECOND,
        self::CACHE_LEVEL_THIRD
    );

    /**
     * 缓存驱动
     * @var array
     */
    protected static $cacheDrivers = [
        self::CACHE_LEVEL_FIRST => 'memcached',
        self::CACHE_LEVEL_SECOND => 'redis',
        self::CACHE_LEVEL_THIRD => 'mongo'
    ];

    /**
     * 默认语言包
     * @var type
     */
    public static $defaultLangPack;

    /**
     * if custom sequencable
     * @var true
     */
    public static $sequencable = false;

    /**
     * sequence column
     * @var string
     */
    public static $sequenceColumn = 'sequence';

    /**
     * 是否出现全选checkbox，用户支持批量处理
     * @var type
     */
    public static $bCheckboxForBatch = false;

    /**
     * 自定义验证消息Att
     * @var array
     */
    protected $validatorMessages = [];

    /**
     * 区别前后台错误信息展示格式
     * @var boolean
     */
    protected $isAdmin = true;

    /**
     * valid cache levels
     * @var array
     */
    protected $iDefaultCacheLevel = 1;

    /**
     * 资源名称
     * @var string
     */
    public static $resourceName = '';

    /**
     * 软删除
     * @var boolean
     */
    protected $softDelete = false;

    /**
     * 建立实例时获取的字段数组
     * @var array
     */
    protected $defaultColumns = [ '*'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * The attributes that should be visible in arrays.
     *
     * @var array
     */
    protected $visible = [];

    /**
     * If Tree Model
     * @var Bool
     */
    public static $treeable = false;

    /**
     * forefather id field
     * @var Bool
     */
    public static $foreFatherIDColumn = '';

    /**
     * forefather field
     * @var Bool
     */
    public static $foreFatherColumn = '';

    /**
     * the columns for list page
     * @var array
     */
    public static $columnForList = [];

    /**
     * 需要显示页面小计的字段数组
     * @var array
     */
    public static $totalColumns = [];

    /**
     * 加租显示的列
     * @var array
     */
    public static $weightFields = [];

    /**
     * 显示为不同颜色的列
     * @var array
     */
    public static $classGradeFields = [];
    public static $floatDisplayFields = [];

    /**
     * 不显示orderby按钮的列，供列表页使用
     * @var array
     */
    public static $noOrderByColumns = [];

    /**
     * ignore columns for view
     * @var array
     */
    public static $ignoreColumnsInView = [];

    /**
     * ignore columns for edit
     * @var array
     */
    public static $ignoreColumnsInEdit = [];

    /**
     * index视图显示时使用，用于某些列有特定格式，且定义了虚拟列的情况
     * @var array
     */
    public static $listColumnMaps = [];

    /**
     * view视图显示时使用，用于某些列有特定格式，且定义了虚拟列的情况
     * @var array
     */
    public static $viewColumnMaps = [];

    /**
     * 下拉列表框字段配置
     * @var array
     */
    public static $htmlSelectColumns = [];

    /**
     * 编辑框字段配置
     * @var array
     */
    public static $htmlTextAreaColumns = [];

    /**
     * number字段配置
     * @var array
     */
    public static $htmlNumberColumns = [];

    /**
     * 显示原始数字的列
     * @var array
     */
    public static $htmlOriginalNumberColumns = [];

    /**
     * 金额字段的存储精度
     * @var int
     */
    public static $amountAccuracy = null;

    /**
     * Columns
     * @var array
     */
    public static $originalColumns;

    /**
     * Column Settings
     * @var array
     */
    public $columnSettings = [];

    /**
     * order by config
     * @var array
     */
    public $orderColumns = [];

    /**
     * title field
     * @var string
     */
    public static $titleColumn = 'title';

    /**
     * the main param for index page
     * @var string
     */
    public static $mainParamColumn = 'parent_id';

    /**
     * save the column types
     * @var array
     */
    public $columnTypes = [];

    public function __construct(array $attributes = []) {

        parent::__construct($attributes);
        $this->comaileLangPack();
    }

    protected function getFriendlyCreatedAtAttribute() {
        return friendly_date($this->created_at);
    }

    /**
     * 访问器：友好的更新时间
     * @return string
     */
    protected function getFriendlyUpdatedAtAttribute() {
        return friendly_date($this->updated_at);
    }

    /**
     * 访问器：友好的删除时间
     * @return string
     */
    protected function getFriendlyDeletedAtAttribute() {
        return friendly_date($this->deleted_at);
    }

    public function parseKey($id) {
        return $this->getTable() . '_' . $id;
    }

    public static function find($id, $columns = []) {
        if (static::$cacheLevel == self::CACHE_LEVEL_NONE) {
            !empty($columns) or $columns = ['*'];
            return parent::find($id, $columns);
        }
        Cache::setDefaultDriver(static::$cacheDrivers[static::$cacheLevel]);
        $key = self::createCacheKey($id);
//        file_put_contents('/tmp/cachekey', 'find--' . $key . "\n", FILE_APPEND);
        if ($aAttributes = Cache::get($key)) {
            $obj = new static;
            $obj = $obj->newFromBuilder($aAttributes);
        } else {
            $obj = parent::find($id);
            if (!is_object($obj)) {
                return false;
            }
            $data = $obj->getAttributes();
            if (static::$cacheMinutes) {
                Cache::put($key, $data, static::$cacheMinutes);
            } else {
                Cache::forever($key, $data);
            }
        }
        // 移除不需要的属性
        if (is_array($columns) && !empty($columns) && !in_array('*', $columns)) {
            $aAllColumns = array_keys($obj->attributes);
            $aExpertColumns = array_diff($aAllColumns, $columns);
            foreach ($aExpertColumns as $sColumn) {
                unset($obj->attributes[$sColumn]);
            }
        }
        return $obj;
    }

    public static function deleteCache($sKeyData) {
        if (static::$cacheLevel == self::CACHE_LEVEL_NONE) {
            return true;
        }
//        pr($sKeyData);
//        !empty($sKeyData) or $sKeyData = $this->id;
        $key = self::createCacheKey($sKeyData);
//        pr($key);
//        exit;
//        file_put_contents('/tmp/cachekey', $key . "\n", FILE_APPEND);
//        pr(static::$cacheDrivers[static::$cacheLevel]);
//        exit;
        Cache::setDefaultDriver(static::$cacheDrivers[static::$cacheLevel]);
        !Cache::has($key) or Cache::forget($key);
    }

    /**
     * 根据指定的信息和排序查询，并将结果对象返回
     * @param array $aOptions
     * @param array $aOrderby
     * @return object
     */
    public function getDataByParams($aOptions, $aOrderby = [ 'id', 'asc']) {
        $query = $this->orderBy($aOrderby[0], $aOrderby[1]);
        // pr($aOptions[ 'conditions' ]);exit;
        foreach ($aOptions['conditions'] as $key => $value) {
            // pr($value);exit;
            $query = $query->where($value[0], $value[1], $value[2]);
        }
        $oData = $query->get($aOptions['columns']);
        return $oData;
    }

    /**
     * return object
     * @param int $id
     * @param int $iCacheLevel
     * @return model or false
     */
//    public static function getObject($id = null,$aConditions = [], $aColumns = [], $aCacheKeyField = ''){
//        if ($id){
//            return self::find($id,$aColumns);
//        }
//        $key    = $this->parseKey($aCacheKeyField);
//
//        doWhere($aConditions)->get()->first();
////        pr($aOptions);
//        $result = Cache::get($key);
//        if (!$result){
//            $result = $this->getDataByParams($aOptions);
//            if ($result)
//                $this->setObject($id,$iCacheLevel,$aOptions,43200,$result);
//        }
//
//        return $result;
//    }
//    public function setObject($id,$iCacheLevel = self::CACHE_LEVEL_FIRST,$aOptions = [],$iMinutes = 60,$oData = null){
//        if (!$id)
//            return false;
//        if (is_null($iCacheLevel))
//            $iCacheLevel = $this->iDefaultCacheLevel;
//        if ($iCacheLevel == 0)
//            return false;
//        switch ($iCacheLevel){
//            case self::CACHE_LEVEL_FIRST:
//// todo: read from level 1 cache
//                Cache::setDefaultDriver('memcached');
//                break;
//            case self::CACHE_LEVEL_SECOND:
//// todo:  read from level 2 cache
//                Cache::setDefaultDriver('mongo');
//                $iMinutes = 43200;
//                break;
//        }
//        $key = $this->parseKey($id);
//        if (!$oData){
//            $oData = $$this->getDataByParams($aOptions);
//        }
//        if ($oData){
//            Cache::put($key,$oData,$iMinutes);
//        }
//        else{
//            return false;
//        }
//    }

    /**
     * 根据表结构及各项属性设置生成数据表配置数组，为内部调用
     * todo: need action
     */
    public function makeColumnConfigures($bForEdit = true) {
        static::$originalColumns = Schema::getColumnListing($this->table);
        $this->columnTypes = $this->getColumnTypes();
//        pr($this->columnTypes);
//        exit;
        $rules = $this->explodeRules(static::$rules);
        $aColumnRules = [];

// 处理在编辑表单中忽略的字段信息
        if ($bForEdit) {
            $aIgnoreColumns = [
                $this->primaryKey,
                $this->getCreatedAtColumn(),
                $this->getUpdatedAtColumn(),
                $this->getDeletedAtColumn(),
            ];
            $aIgnoreColumns = array_merge(static::$ignoreColumnsInEdit, $aIgnoreColumns);
        } else {
            $aIgnoreColumns = static::$ignoreColumnsInView;
        }
//        $aIgnoreColumnsForView = $this->getIgnoreColumnsForView();
//        $aIgnoreForView        = is_array($aIgnoreColumnsForView) ? $aIgnoreColumnsForView : []; // is_array($this->getIgnoreColumnsForView()) ? $this->getIgnoreColumnsForView() : [];
        if (static::$treeable) {
            $bForEdit or $aIgnoreColumns[] = 'parent_id';
            if (static::$foreFatherIDColumn) {
                $aIgnoreColumns[] = static::$foreFatherIDColumn;
                $aIgnoreColumns[] = static::$foreFatherColumn;
            }
        }
        $aIgnoreColumns = array_unique($aIgnoreColumns);
//        pr($aIgnoreColumns);
        foreach (static::$originalColumns as $sColumn) {
            if (in_array($sColumn, $aIgnoreColumns)) {
//                pr($sColumn);
//                    $bDone                                   = true;
//                    $aColumnRules[ $sColumn ][ 'required' ]  = false;
//                    $aColumnRules[ $sColumn ][ 'type' ]      = 'ignore';
//                    $aColumnRules[ $sColumn ][ 'form_type' ] = 'ignore';
                continue;
            }
            if (isset(static::$htmlSelectColumns[$sColumn])) {
                $bDone = true;
                $aColumnRules[$sColumn]['type'] = 'select';
                $aColumnRules[$sColumn]['form_type'] = 'select';
                $aColumnRules[$sColumn]['options'] = static::$htmlSelectColumns[$sColumn];
                continue;
            }
            if (in_array($sColumn, static::$htmlTextAreaColumns)) {
                $bDone = true;
                $aColumnRules[$sColumn]['type'] = 'text';
                $aColumnRules[$sColumn]['form_type'] = 'textarea';
                continue;
            }
//            $aColumnRules[ $sColumn ] = [];
            $bDone = false;
            if (isset($rules[$sColumn])) {
//                $aRuleOfColumn = $rules[$sColumn];
                $bDone = true;
                $sFormType = 'text';
                $bRequired = false;
                foreach ($rules[$sColumn] as $sRule) {
                    $a = explode(':', $sRule);
                    switch ($a[0]) {
                        case 'required':
                            $bRequired = TRUE;
                            $sType = 'text';
                            break;
                        case 'in':
                            if (str_replace(' ', '', $a[1]) == '0,1') {
                                $sType = 'bool';
                                $sFormType = 'bool';
                            } else {
                                $sFormType = 'select';
                                $sType = 'select';
                            }
                            break;
                        case 'between':
                            $sFormType = 'text';
                            $sType = 'string';
                            break;
                        case 'numeric':
                        case 'integer':
                            $sFormType = 'text';
                            $sType = $a[0];
//                            pr($sType);
                            break;
                        case 'min';
                        case 'max':
                            if (!isset($aColumnRules[$sColumn]['type'])) {
                                $sFormType = 'text';
                                $sType = 'string';
                            }
                            break;
                        case 'date':
                            $sFormType = 'date';
                            $sType = 'text';
                            break;
                        default:
                            $sFormType = 'text';
                            $sType = 'string';
                    }
                    $aColumnRules[$sColumn]['required'] = $bRequired;
                    $aColumnRules[$sColumn]['type'] = $sType;
                    $aColumnRules[$sColumn]['form_type'] = $sFormType;
//                    pr($aColumnRules[ $sColumn ]);
//                $aColumnRules[$sColumn] = $aRule;
                }
            }
//         pr($aColumnRules);
//            if (in_array($sColumn,$aIgnoreForEdit)){
//                $bDone                                   = true;
//                $aColumnRules[ $sColumn ][ 'required' ]  = false;
//                $aColumnRules[ $sColumn ][ 'form_type' ] = 'ignore';
//            }
            if (!$bDone) {
                $aColumnRules[$sColumn]['form_type'] = 'ignore';
                $aColumnRules[$sColumn]['type'] = 'text';
            }
        }
//        pr($aColumnRules);
//        pr('-----------');
//        exit;
        $this->columnSettings = $aColumnRules;
    }

    /**
     * Explode the rules into an array of rules.
     *
     * @param  string|array  $rules
     * @return array
     */
    protected function explodeRules($rules) {
        foreach ($rules as $key => &$rule) {
            $rule = (is_string($rule)) ? explode('|', $rule) : $rule;
        }

        return $rules;
    }

    /**
     * get tree array
     * @staticvar int   $deep
     * @param array     $aTree           to save the array
     * @param int       $iParentId       parent_id
     * @param string    $sTitlePrev      the prefix for sub title
     * @return void
     */
    public function getTree(& $aTree, $iParentId = null, $aConditions = [], $aOrderBy = [], $sTitlePrev = '--') {
        if (!static::$treeable)
            return false;

        static $deep = 0;

        $aConditions['parent_id'] = ['=', $iParentId];

        $oQuery = $this->doWhere($aConditions);
        $oQuery = $this->doOrderBy($oQuery, $aOrderBy);

        $deep++;

        $aModels = $oQuery->get([ 'id', static::$titleColumn]);
        foreach ($aModels as $oModel) {
            $sTitle = empty($sTitlePrev) ? $oModel->{static::$titleColumn} : str_repeat($sTitlePrev, ($deep - 1)) . $oModel->{static::$titleColumn};
            $aTree[$oModel->id] = $sTitle;
            $this->getTree($aTree, $oModel->id, $aConditions, $aOrderBy, $sTitlePrev);
        }
        $deep--;
    }

    /**
     * make the order by
     * @param array $aOrderBy
     * @return Query|Model
     */
    public function doOrderBy($oQuery = null, $aOrderBy = null) {
        $aOrderBy or $aOrderBy = $this->orderColumns;
        $oQuery or $oQuery = $this;
        foreach ($aOrderBy as $sColumn => $sDirection) {
            $oQuery = $oQuery->orderBy($sColumn, $sDirection);
        }
        return isset($oQuery) ? $oQuery : $this;
    }

    public function doGroupBy($oQuery = null, $aGroupBy = null) {
        $aGroupBy or $aGroupBy = $this->groupByColumns;
        $oQuery or $oQuery = $this;
        foreach ($aGroupBy as $sColumn) {
            $oQuery = $oQuery->groupBy($sColumn);
        }
        return isset($oQuery) ? $oQuery : $this;
    }

    /**
     * 批量设置查询条件，返回Query实例
     *
     * @param array $aConditions
     * @return Query
     */
    public static function doWhere($aConditions = [], $oQuery = null) {
        is_array($aConditions) or $aConditions = [];
        foreach ($aConditions as $sColumn => $aCondition) {
            $sObject = isset($oQuery) ? '$oQuery->' : 'self::';
            $statement = '';
            switch ($aCondition[0]) {
                case '=':
                    if (is_null($aCondition[1])) {
                        $statement = '$oQuery = ' . $sObject . 'whereNull($sColumn);';
                    } else {
                        $statement = '$oQuery = ' . $sObject . 'where($sColumn , \'=\' , $aCondition[ 1 ]);';
                    }
                    break;
                case 'in':
                    $array = is_array($aCondition[1]) ? $aCondition[1] : explode(',', $aCondition[1]);
                    $statement = '$oQuery = ' . $sObject . 'whereIn($sColumn , $array);';
                    break;
                case '>=':
                case '<=':
                case '<':
                case '>':
                case 'like':
                    if (is_null($aCondition[1])) {
                        $statement = '$oQuery = ' . $sObject . 'whereNotNull($sColumn);';
                    } else {
                        $statement = '$oQuery = ' . $sObject . 'where($sColumn,$aCondition[ 0 ],$aCondition[ 1 ]);';
                    }
                    break;
                case '<>':
                case '!=':
                    if (is_null($aCondition[1])) {
                        $statement = '$oQuery = ' . $sObject . 'whereNotNull($sColumn);';
                    } else {
                        $statement = '$oQuery = ' . $sObject . 'where($sColumn,\'<>\',$aCondition[ 1 ]);';
                    }
//                    echo $statement,"\n";
                    break;
                case 'between':
                    $statement = '$oQuery = ' . $sObject . 'whereBetween($sColumn,$aCondition[ 1 ]);';
                    break;
            }
//            echo $statement,"\n";
            eval($statement);
        }
//        exit;
        if (!isset($oQuery)) {
            $oQuery = self::where('id', '>', '0');
        }
        return $oQuery;
    }

    // public static function doWhere($aConditions = [])
    // {
    //     // pr($aConditions);exit;
    //     is_array($aConditions) or $aConditions = [];
    //     $oQuery = self::where('id', '>', 0);
    //     foreach ($aConditions as $sColumn => $aCondition) {
    //         $sOperator = $aCondition[0];
    //         $mParams   = $aCondition[1];
    //         switch ($sOperator){
    //             case '=':
    //                 if (is_null($mParams)) {
    //                     $oQuery = $oQuery->whereNull($sColumn);
    //                 } else {
    //                     $oQuery->where($sColumn, $sOperator, $aCondition[1]);
    //                 }
    //                 break;
    //             case 'in':
    //                 $mParams = is_array($mParams) ? $mParams : explode(',',$mParams);
    //                 $oQuery  = $oQuery->whereIn($sColumn, $mParams);
    //                 break;
    //             case '>=':
    //             case '<=':
    //             case '<':
    //             case '>':
    //             case 'like':
    //             case '<>':
    //             case '!=':
    //                 if (is_null($mParams)) {
    //                     $oQuery = $oQuery->whereNotNull($sColumn);
    //                 } else {
    //                     $oQuery->where($sColumn, $sOperator, $mParams);
    //                 }
    //                 break;
    //             case 'between':
    //                 $oQuery = $oQuery->whereBetween($sColumn,$mParams);
    //                 break;
    //         }
    //     }
    //     return $oQuery ;
    // }
    /**
     * 根据给定的parent_id生成user_forefather_ids
     *
     * @param int $iParentId
     * @return string
     */
    public function setForeFather() {
//        die(static::$foreFatherIDColumn);
        if (!static::$treeable) {
            return false;
        }
//        if (empty($this->parent_id)) return '';
        $sColumn = static::$foreFatherIDColumn;
        $oParentModel = $this->find($this->parent_id);
//        pr($oParentModels->$sColumn);
//        exit;
        $this->$sColumn = empty($oParentModel->$sColumn) ? $this->parent_id : ($oParentModel->$sColumn . ',' . $this->parent_id);
        if ($this->$sColumn) {
            if ($this->parent_id) {
                $oParentModel = $this->find($this->parent_id);
                //            pr($oParentModel->attributes);
                //            exit;
                if ($sForeColumn = static::$foreFatherColumn) {
                    $this->$sForeColumn = empty($oParentModel->$sForeColumn) ? $oParentModel->{static::$titleColumn} : ($oParentModel->$sForeColumn . ',' . $oParentModel->{static::$titleColumn});
                    //                die($this->attributes[ $sForeColumn ]);
                }
            }
        } else {
            $this->attributes[static::$foreFatherIDColumn] = '';
            if ($sForeColumn = static::$foreFatherColumn) {
                $this->attributes[$sForeColumn] = '';
            }
        }
    }

    /**
     * run before save()
     */
    protected function beforeValidate() {
        if (static::$treeable) {
            $this->parent_id = $this->parent_id;
        }
        return true;
    }

    protected function afterUpdate() {
        $this->deleteCache($this->id);
    }

    /**
     * run after save
     * @param $bSucc
     * @param $bNew
     * @return boolean
     */
    protected function afterSave($oSavedModel) {
        $sModelName = get_class($oSavedModel);
        $this->deleteCache($this->id);
        $bSucc = true;
        if ($sModelName::$treeable) {
            $aSubs = & $oSavedModel->getSubObjectArray($this->id);
//        pr($a);
//        exit;
            if ($aSubs) {
                foreach ($aSubs as $oModel) {
//            pr("$oModel->id | $oModel->parent_id | $oModel->user_forefather_ids");
                    if ($oModel->parent_id == $this->id){
                        continue;
                    }
                    $oModel->parent_id = $this->id;
                    if (!$bSucc = $oModel->save()) {
                        break;
                    }
                }
            }
        }
        return $bSucc;
    }

    protected function afterDelete($oDeletedModel) {
        $this->deleteCache($oDeletedModel->id);
        return true;
    }

    /**
     * get Column type array
     * @return array
     */
    public function & getColumnTypes() {
        if (empty($this->columnTypes)) {
            $sDatabase = $this->getConnection()->getConfig('database');
            $sql = "select column_name, data_type from information_schema.columns where table_schema = '$sDatabase' and table_name = '{$this->table}' order by ordinal_position;";
            $aColumns = DB::select($sql);
            $data = [];
            foreach ($aColumns as $aConfig) {
                $data[$aConfig->column_name] = $aConfig->data_type;
            }
            $this->columnTypes = $data;
            return $data;
        } else {
            return $this->columnTypes;
        }
    }

    /**
     * get value array
     *
     * @param String $sColumn
     * @param array $aConditions
     * @param array $aOrderBy
     * @param bool $bUsePrimaryKey
     * @return array
     */
    function getValueListArray($sColumn = null, $aConditions = [], $aOrderBy = [], $bUsePrimaryKey = false) {
        $sColumn or $sColumn = static::$titleColumn;
        $aColumns = $bUsePrimaryKey ? [ 'id', $sColumn] : [ $sColumn];
        $aOrderBy or $aOrderBy = [ $sColumn => 'asc'];
        $oQuery = $this->doWhere($aConditions);
        $oQuery = $this->doOrderBy($oQuery, $aOrderBy);
        $oModels = $oQuery->get($aColumns);
        $data = [];
        foreach ($oModels as $oModel) {
            $sKeyField = $bUsePrimaryKey ? $oModel->id : $oModel->$sColumn;
            $data[$sKeyField] = $oModel->$sColumn;
        }
        return $data;
    }

    /**
     * 取得校验错误信息并转换为字符串返回
     * @return string
     */
    public function & getValidationErrorString() {
        $aErrMsg = [];
        if ($this->isAdmin) {
            $aErrMsg = $this->exists ? [ $this->id . ':'] : [ $this->{static::$titleColumn} . ':'];
            // $sLangKey = '_' . Str::slug(static::$resourceName, '_') . '.';
            // pr($sLangKey);exit;
            foreach ($this->validationErrors->toArray() as $sColumn => $sMsg) {
                $aErrMsg[] = $sColumn . ': ' . implode(',', $sMsg);
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

    /**
     * get tree array
     * @staticvar int   $deep
     * @param array     $aTree           to save the array
     * @param int       $iParentId       parent_id
     * @param string    $sTitlePrev      the prefix for sub title
     * @return void
     */
    public function & getSubObjectArray($iParentId = null, $aConditions = [], $aOrderBy = []) {
        if (!static::$treeable)
            return false;

//        static $deep = 0;
//        pr($iParentId);
        $data = [];
        !empty($aConditions) or $aConditions = [];
        $aConditions['parent_id'] = [ '=', $iParentId];
        $oQuery = $this->doWhere($aConditions);
        $oQuery = $this->doOrderBy($oQuery, $aOrderBy);
        $oModels = $oQuery->get();
//        pr($oModels->toArray());
//        exit;
//        $sObject = is_object($oQuery) ? $oQuery : $this;
//        $deep++;
//        $oModels = $sObject->where('parent_id', '=', $iParentId)->get();
        foreach ($oModels as $oModel) {
//            $sTitle = empty($sTitlePrev) ? $oModel->{static::$titleColumn} : str_repeat($sTitlePrev,($deep - 1)) . $oModel->{static::$titleColumn};
            $data[$oModel->id] = $oModel;
//            $this->getTreeObjectArray($aTree, $oModel->id, $aConditions, $aOrderBy);
        }
        return $data;
//        $deep--;
    }

    protected function setParentIdAttribute($iParentId) {
        $this->attributes['parent_id'] = $iParentId;
        // pr($this->attributes);exit;
        $sModelName = get_class($this);
        if ($iParentId) {
            // pr($sModelName . '---' . $this->parent_id);exit;
            $oParent = $sModelName::find($this->parent_id);
            // if (! $oParent) {
            //     pr($this->parent_id);exit;
            // }
            // pr($this->parent_id);
            // pr($oParent->{static::$titleColumn});
            // pr(static::$titleColumn);
            // exit;
//            $this->parent or
            $this->parent = $oParent->{static::$titleColumn};
            // pr($this->attributes);
            // exit;
//            $this->{static::$foreFatherIDColumn} = $this->setForeFather();
        } else {
            $this->parent = '';
        }
        if (static::$foreFatherIDColumn) {
//                $this->{static::$foreFatherIDColumn} = $this->setForeFather();
            $this->setForeFather();
        }
    }

    public static function getObjectByParams(array $aParams = ['*']) {
        //         $aParams or $aParams = ['*'];
        foreach ($aParams as $key => $value) {
            if (isset($oQuery) && is_object($oQuery)) {
                $oQuery = $oQuery->where($key, '=', $value);
            } else {
                $oQuery = self::where($key, '=', $value);
            }
        }
        return $oQuery->get()->first();
    }
    
        public static function getObjectCollectionByParams(array $aParams = ['*']) {
        //         $aParams or $aParams = ['*'];
        foreach ($aParams as $key => $value) {
            if (isset($oQuery) && is_object($oQuery)) {
                $oQuery = $oQuery->where($key, '=', $value);
            } else {
                $oQuery = self::where($key, '=', $value);
            }
        }
        return $oQuery->get();
    }

    /**
     * 返回经格式化后的数字，用于金额显示
     * @param string $sColumn
     * @return type
     */
    protected function getFormattedNumberForHtml($sColumn) {
        $iAccuracy = isset(static::$htmlNumberColumns[$sColumn]) ? static::$htmlNumberColumns[$sColumn] : static::$amountAccuracy;
        return number_format($this->{ $sColumn }, $iAccuracy);
    }

    protected static function createCacheKey($data) {
        return self::getCachePrefix() . $data;
    }

    /**
     * 返回数据列表
     * @param boolean $bOrderByTitle
     * @return array &  键为ID，值为$$titleColumn
     */
    public static function & getTitleList($bOrderByTitle = true) {
        $aColumns = [ 'id', static::$titleColumn];
        $sOrderColumn = $bOrderByTitle ? static::$titleColumn : 'id';
        $oModels = self::orderBy($sOrderColumn, 'asc')->get($aColumns);
        $data = [];
        foreach ($oModels as $oModel) {
            $data[$oModel->id] = $oModel->{static::$titleColumn};
        }
        return $data;
    }

    public static function comaileLangPack() {
        $sClass = self::getRealClassForCache();
        return static::$defaultLangPack = '_' . strtolower($sClass);
    }

    /**
     * get list array
     * @return & array  key is id, value is titleColumn
     */
//    public function & getAllListArray(){
//        $aArray  = [];
//        $aModels = $this->all([ 'id',static::$titleColumn]);
//        foreach ($aModels as $oModel){
//            $aArray[ $oModel->id ] = $oModel->{static::$titleColumn};
//        }
//        return $aArray;
//    }

    public static function translate($sText, $iUcType = 3, $aReplace = []) {
        return __(static::$defaultLangPack . '.' . strtolower($sText), $aReplace, $iUcType);
    }

    public static function translateArray(& $aTexts, $iUcType = 2, $aReplace = []) {
        self::comaileLangPack();
        foreach ($aTexts as $key => $sText) {
            $aTexts[$key] = __(static::$defaultLangPack . '.' . strtolower($sText), $aReplace, $iUcType);
        }
    }

    protected static function getRealClassForCache() {
        $sClass = get_called_class();
        !static::$cacheUseParentClass or $sClass = get_parent_class($sClass);
        return $sClass;
    }

    protected static function getCachePrefix($bPlural = false) {
        $sClass = self::getRealClassForCache();
        !$bPlural or $sClass = Str::plural($sClass);
        return Config::get('cache.prefix') . $sClass . '-';
    }

    protected function strictUpdate($aConditions, $data) {
        if ($bSucc = $this->doWhere($aConditions)->update($data) > 0) {
            $this->afterUpdate();
        }
        return $bSucc;
    }

    /**
     * 返回excel文件到浏览器端
     * @param array $aTitles        excel表头信息
     * @param array $aData           excel数据
     * @param string $sFileName  excel文件名称
     * @return excel内容或者跳转到index页面
     */
    public function downloadExcel($aTitles, $aData, $sFileName, $sDir='./') {
        if (count($aData) <= 0) {
            return false;
        }
        PHPExcel_Settings::setCacheStorageMethod(PHPExcel_CachedObjectStorageFactory::cache_in_memory_serialized);
        $oDownExcel = new DownExcel;
        $sModelName = get_class($this);
        $sModelName = starts_with($sModelName, 'Man') ? substr($sModelName, 3) : $sModelName;
        $oDownExcel->setTitle(strtolower($sModelName), $aTitles);
        $oDownExcel->setData($aData);
        $oDownExcel->setActiveSheetIndex(0);
        $oDownExcel->setSheetTitle($sFileName);
        $oDownExcel->setEncoding('gb2312');
        return $oDownExcel->Download($sDir . $sFileName, 'Excel2007', 'Command');
    }
    
        /**
     * 导出数据为CSV文件
     * @param array $aTitles        excel表头信息
     * @param array $aData           excel数据
     * @param string $sFileName  excel文件名称
     * @return excel内容或者跳转到index页面
     */
    public function downloadCSV($aTitles, $aData, $sFileName, $sDir='./') {
        if (count($aData) <= 0) {
            return false;
        }
        $oDownCSV = new DownCSV;
        $sModelName = get_class($this);
        $sModelName = starts_with($sModelName, 'Man') ? substr($sModelName, 3) : $sModelName;
        $oDownCSV->setTitle(strtolower($sModelName), $aTitles);
        return $oDownCSV->download($sDir . $sFileName, $aData);
    }
}
