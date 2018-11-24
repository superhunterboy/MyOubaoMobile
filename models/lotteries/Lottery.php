<?php

/**
 * 彩票模型
 */
class Lottery extends BaseModel {

    static $cacheLevel = self::CACHE_LEVEL_FIRST;

    /**
     * 数字排列类型
     */
    const LOTTERY_TYPE_DIGITAL = 1;

    /**
     * 乐透类型
     */
    const LOTTERY_TYPE_LOTTO = 2;

    /**
     * 单区乐透类型
     */
    const LOTTERY_TYPE_LOTTO_SINGLE = 1;

    /**
     * 双区乐透类型
     */
    const LOTTERY_TYPE_LOTTO_DOUBLE = 2;

    /**
     * 
     */
    const WINNING_SPLIT_FOR_DOUBLE_LOTTO = '+';

    /**
     * 彩票状态：不可用
     */
    const STATUS_NOT_AVAILABLE = 0;

    /**
     * 彩票状态：测试用户可用
     */
    const STATUS_AVAILABLE_FOR_TESTER = 1;

    /**
     * 彩票状态：所有用户可用
     */
    const STATUS_AVAILABLE = 3;

    /**
     * 错误编码列表
     */
    const ERRNO_LOTTERY_MISSING = -900;
    const ERRNO_LOTTERY_CLOSED = -901;

    /**
     * 彩票展示分组类型
     */
    const LOTTERY_CATEGORY_SSC = 0;
    const LOTTERY_CATEGORY_11Y = 1;
    const LOTTERY_CATEGORY_OFFICIAL = 2;
    const LOTTERY_CATEGORY_K3 = 3;
    const LOTTERY_CATEGORY_OTHER = 4;
    const LOTTERY_CATEGORY_PK10 = 5;

    /**
     * 彩票游戏标记
     */
    const LOTTERY_FLAG_NONE = 0;
    const LOTTERY_FLAG_OFFICAL = 1;
    const LOTTERY_FLAG_HOT = 2;
    const LOTTERY_FLAG_NEW = 3;

    /**
     * all types
     * @var array
     */
    public static $validTypes = [
        self::LOTTERY_TYPE_DIGITAL => 'Digital',
        self::LOTTERY_TYPE_LOTTO => 'Lotto',
    ];

    /**
     * all lotto types
     * @var array
     */
    public static $validLottoTypes = [
        self::LOTTERY_TYPE_LOTTO_SINGLE => 'Single',
        self::LOTTERY_TYPE_LOTTO_DOUBLE => 'Double',
    ];
    public static $aLotteryCategories = [
        self::LOTTERY_CATEGORY_SSC => 'ssc',
        self::LOTTERY_CATEGORY_11Y => 'l115',
        self::LOTTERY_CATEGORY_OFFICIAL => 'own',
        self::LOTTERY_CATEGORY_OTHER => 'other',
        self::LOTTERY_CATEGORY_K3 => 'k3',
        self::LOTTERY_CATEGORY_PK10 => 'pk10',
    ];
    public static $aLotteryFlags = [
        self::LOTTERY_FLAG_NONE => 'none',
        self::LOTTERY_FLAG_OFFICAL => 'offical',
        self::LOTTERY_FLAG_HOT => 'hot',
        self::LOTTERY_FLAG_NEW => 'new',
    ];
    public static $validStatus = [
        self::STATUS_NOT_AVAILABLE => 'Closed',
        self::STATUS_AVAILABLE_FOR_TESTER => 'Testing',
        self::STATUS_AVAILABLE => 'Available'
    ];
    public static $resourceName = 'Lottery';
    protected $table = 'lotteries';

    /**
     * 下拉列表框字段配置
     * @var array
     */
    public static $htmlSelectColumns = [
        'series_id' => 'aSeries',
        'type' => 'aValidTypes',
        'lotto_type' => 'aValidLottoTypes',
        'status' => 'aValidStatus',
        'category' => 'aLotteryCategories',
        'flag' => 'aLotteryFlags',
    ];
    public static $sequencable = true;
    public static $listColumnMaps = [
        'name' => 'friendly_name'
    ];

    /**
     * order by config
     * @var array
     */
    public $orderColumns = [
        'sequence' => 'asc'
    ];

    /**
     * the main param for index page
     * @var string
     */
    public static $mainParamColumn = 'type';

    /**
     * The rules to be applied to the data.
     *
     * @var array
     */
    public static $rules = [
        'series_id' => 'required|integer',
        'name' => 'required|between:2,10',
        'type' => 'required|numeric',
//        'lotto_type'     => 'numeric',
        'high_frequency' => 'in:0,1',
        'sort_winning_number' => 'in:0,1',
        'valid_nums' => 'required',
        'buy_length' => 'required',
        'wn_length' => 'required',
        'identifier' => 'required|between:3,10',
        'introduction' => 'between:0,50',
        'days' => 'numeric',
        'issue_over_midnight' => 'in:0,1',
        'issue_format' => 'required',
        'daily_issue_count' => 'integer',
        'trace_issue_count' => 'integer',
//        'begin_time' => 'required',
//        'end_time' => 'required',
        'category' => 'in:0,1,2,3,4,5',
        'flag' => 'in:0,1,2,3',
        'status' => 'in:0,1,3',
        'sequence' => 'integer',
    ];
    public static $customMessages = [];
    public static $titleColumn = 'name';

    public function series() {
        return $this->belongsTo('Series');
    }

    protected function beforeValidate() {
        $this->lotto_type or $this->lotto_type = null;
        return parent::beforeValidate();
    }

//    public static function getAllLotteryNameArray($aColumns = null)
//    {
//        $aColumns or $aColumns = ['id', 'name'];
//        $aLotteries = Lottery::all($aColumns);
//        $data = [];
//        foreach ($aLotteries as $key => $value) {
//            $data[$value->id] = $value->name;
//        }
//        return $data;
//    }
    protected static function compileLotteryListCacheKey($bOpen = null) {
        $sKey = self::getCachePrefix(true) . 'list';
        if (!is_null($bOpen)) {
            $sKey .= $bOpen ? '-open' : '-close';
        }
        return $sKey;
    }

    protected static function & getLotteryListByStatus($iStatus = null) {
        $bReadDb = true;
        $bPutCache = false;
        if (static::$cacheLevel != self::CACHE_LEVEL_NONE) {
            Cache::setDefaultDriver(static::$cacheDrivers[static::$cacheLevel]);
            $sCacheKey = self::compileLotteryListCacheKey($iStatus);
            if ($aLotteries = Cache::get($sCacheKey)) {
                $bReadDb = false;
            } else {
                $bPutCache = true;
            }
        }
//        $bReadDb = $bPutCache = true;
        if ($bReadDb) {
            if (!is_null($iStatus)) {
                $aStatus = self::_getStatusArray($iStatus);
//                file_put_contents('/tmp/kkkkkk', var_export($aStatus, true));
                $aLotteries = Lottery::whereIn('series_id', [1,2,3,13,15,19])->whereIn('status', $aStatus)->orderBy('series_id')->get();
            } else {
                $aLotteries = Lottery::whereIn('series_id', [1,2,3,13,15,19])->orderBy('series_id')->get();
            }
        }
        if ($bPutCache) {
            Cache::forever($sCacheKey, $aLotteries);
        }
        return $aLotteries;
    }

    protected static function _getStatusArray($iNeedStatus) {
        $aStatus = [];
        foreach (static::$validStatus as $iStatus => $sTmp) {
            if (($iStatus & $iNeedStatus) == $iNeedStatus) {
                $aStatus[] = $iStatus;
            }
        }
        return $aStatus;
    }

    /**
     * [getAllLotteries 获取所有彩种信息]
     * @param  [Boolean] $bOpen  [open属性]
     * @param  [Array] $aColumns [要获取的数据列名]
     * @return [Array]           [结果数组]
     */
    public static function getAllLotteries($iStatus = null, $aColumns = null) {
        $aLotteries = self::getLotteryListByStatus($iStatus);
        $data = [];
        foreach ($aLotteries as $key => $oLottery) {
            if ($aColumns) {
                foreach ($aColumns as $sColumn) {
                    $aTmpData[$sColumn] = $oLottery->$sColumn;
                }
            } else {
                $aTmpData = $oLottery->getAttributes(); // ['id' => $value->id, 'series_id' => $value->series_id, 'name' => $value->name];
            }
            $aTmpData['name'] = $oLottery->friendly_name;
            $data[] = $aTmpData;
        }
        return $data;
    }

    /**
     * generate select widget
     * @return int or false   -1: path not writeable
     */
    public static function generateWidget() {
        $sCacheDataPath = Config::get('widget.data_path');
        if (!is_writeable($sCacheDataPath)) {
            return [
                'code' => -1,
                'message' => __('_basic.file-write-fail-path', ['path' => $sCacheDataPath]),
            ];
        }
        $sFile = $sCacheDataPath . '/' . 'lotteries.blade.php';
        if (file_exists($sFile) && !is_writeable($sFile)) {
            return [
                'code' => -1,
                'message' => __('_basic.file-write-fail-file', ['file' => $sFile]),
            ];
        }
        $aLotterys = self::getAllLotteryNameArray();
//        pr(json_encode($aLotterys));
        $iCode = @file_put_contents($sFile, 'var lotteries = ' . json_encode($aLotterys));
        $sLangKey = '_basic.' . ($iCode ? 'file-writed' : 'file-write-fail');
        return [
            'code' => $iCode,
            'message' => __($sLangKey, ['resource' => $sFile]),
        ];
    }

    /**
     * 返回可用的数字数组
     *
     * @param string $sString
     * @param int $iLotteryType
     * @param int $iLottoType
     * @return array
     */
    public function & getValidNums($sString, $iLotteryType = self::LOTTERY_TYPE_DIGITAL, $iLottoType = self::LOTTERY_TYPE_LOTTO_SINGLE) {
        $data = [];
        if ($iLotteryType == self::LOTTERY_TYPE_LOTTO && $iLottoType != self::LOTTERY_TYPE_LOTTO_SINGLE) {
//            echo "$iLotteryType   New...\n";
            $aStringOfAreas = explode('|', $sString);
            $data = [];
            foreach ($aStringOfAreas as $iArea => $sStr) {
                $data[$iArea] = & $this->getValidNums($sStr, self::LOTTERY_TYPE_LOTTO, self::LOTTERY_TYPE_LOTTO_SINGLE);
            }
//            return $data;
        } else {
            $a = explode(',', $sString);
            foreach ($a as $part) {
                $aPart = explode('-', $part);
                if (count($aPart) == 1) {
                    $data[] = $this->formatBall($aPart[0], $iLotteryType, $iLottoType);
                } else {
                    for ($i = $aPart[0]; $i <= $aPart[1]; $i++) {
                        $data[] = $this->formatBall($i, $iLotteryType, $iLottoType);
                    }
                }
            }
        }
        return $data;
    }

    /**
     * 格式化数字
     *
     * @param int $iNum
     * @param int $iLotteryType
     * @param int $iLottoType
     * @return string
     */
    public function formatBall($iNum, $iLotteryType = self::LOTTERY_TYPE_DIGITAL, $iLottoType = self::LOTTERY_TYPE_LOTTO_SINGLE) {
        switch ($iLotteryType) {
            case self::LOTTERY_TYPE_DIGITAL:
                return $iNum + 0;
                break;
            case self::LOTTERY_TYPE_LOTTO:
                switch ($iLottoType) {
                    case self::LOTTERY_TYPE_LOTTO_SINGLE:
                    case self::LOTTERY_TYPE_LOTTO_DOUBLE:
                    case self::LOTTERY_TYPE_LOTTO_MIXED:
                        return str_pad($iNum, 2, '0', STR_PAD_LEFT);
                        break;
                }
        }
    }

    protected function getFriendlyNameAttribute() {
        return __('_lotteries.' . strtolower($this->name), [], 1);
    }

    /**
     * 返回数据列表
     * @param boolean $bOrderByTitle
     * @return array &  键为ID，值为$$titleColumn
     */
    public static function & getTitleList($bOrderByTitle = false) {
        $aColumns = [ 'id', 'name'];
        $sOrderColumn = $bOrderByTitle ? 'name' : 'sequence';
        $oModels = self::orderBy($sOrderColumn, 'asc')->get($aColumns);
        $data = [];
        foreach ($oModels as $oModel) {
            $data[$oModel->id] = $oModel->friendly_name;
        }
        return $data;
    }

    /**
     * 返回人性化的游戏列表，游戏名称为已翻译的
     * @param boolean $bOrderByTitle
     * @return array &  键为ID，值为$$titleColumn
     */
    public static function & getLotteryList() {
        $bReadDb = false;
        $sLocale = App::getLocale();
        if (static::$cacheLevel != self::CACHE_LEVEL_NONE) {
            Cache::setDefaultDriver(static::$cacheDrivers[static::$cacheLevel]);
            $key = self::compileListCaheKey($sLocale);
            if (!$aLotteries = Cache::get($key)) {
                $bReadDb = true;
            }
        }
        if ($bReadDb) {
            $aLotteries = self::getTitleList();
            !$key or Cache::forever($key, $aLotteries);
        }

        return $aLotteries;
    }

    /**
     * 从数据库提取游戏列表
     * @param bool $bOrderByTitle   是否按名字排序
     * @return array
     */
    protected static function & _getLotteryList($bOrderByTitle = true) {
        $aColumns = [ 'id', 'name'];
        $sOrderColumn = $bOrderByTitle ? 'name' : 'sequence';
        $oModels = self::orderBy($sOrderColumn, 'asc')->get($aColumns);
        $data = [];
        foreach ($oModels as $oModel) {
            $data[$oModel->id] = $oModel->name;
        }
        return $data;
    }

    public static function & getIdentifierList($bOrderByTitle = false) {
        $aColumns = [ 'id', 'identifier'];
        $sOrderColumn = $bOrderByTitle ? 'name' : 'sequence';
        $oModels = self::orderBy($sOrderColumn, 'asc')->get($aColumns);
        $data = [];
        foreach ($oModels as $oModel) {
            $data[$oModel->id] = $oModel->identifier;
        }
        return $data;
    }

    /**
     * 更新游戏列表配置
     * @return int  1: 成功 0:失败 -1: 文件不可写
     */
    public static function updateLotteryConfigs() {
        $aLotteries = & self::getIdentifierList();
//        pr($aLotteries);
        $sString = "<?php\nreturn " . var_export($aLotteries, true) . ";\n";
        $sPath = app_path('config');
        $sFile = $sPath . DIRECTORY_SEPARATOR . 'lotteries.php';
        if (!is_writeable($sFile)) {
            return -1;
        }
        return file_put_contents($sFile, $sString) ? 1 : 0;
    }

    public static function updateLotteryListCache() {
        if (static::$cacheLevel == self::CACHE_LEVEL_NONE)
            return true;
        Cache::setDefaultDriver(static::$cacheDrivers[static::$cacheLevel]);
        $sLanguageSource = SysConfig::readDataSource('sys_support_languages');
        // pr($sLanguageSource);
        $aLanguages = SysConfig::getSource($sLanguageSource);
        $aLotteries = & self::_getLotteryList();
        foreach ($aLanguages as $sLocale => $sLanguage) {
            $aLotteriesOfLocale = array_map(function($value) use ($sLocale) {
                return __('_lotteries.' . strtolower($value), [], 1, $sLocale);
            }, $aLotteries);
            $key = self::compileListCaheKey($sLocale);
            Cache::forever($key, $aLotteriesOfLocale);
        }
        return true;
    }

    protected static function compileListCaheKey($sLocate) {
        return 'lottery-list-' . $sLocate;
    }

    protected static function deleteOtherCache() {
        if (static::$cacheLevel == self::CACHE_LEVEL_NONE)
            return true;
        Cache::setDefaultDriver(static::$cacheDrivers[static::$cacheLevel]);
        $sKey = self::compileLotteryListCacheKey();
        !Cache::has($sKey) or Cache::forget($sKey);
        $sKey = self::compileLotteryListCacheKey(1);
        !Cache::has($sKey) or Cache::forget($sKey);
        $sKey = self::compileLotteryListCacheKey(0);
        !Cache::has($sKey) or Cache::forget($sKey);
    }

    protected function afterSave($oSavedModel) {
        parent::afterSave($oSavedModel);
        $this->updateLotteryListCache();
        $this->deleteOtherCache();
        return true;
    }

    protected function afterDelete($oDeletedModel) {
        parent::afterDelete($oDeletedModel);
        $this->updateLotteryListCache();
        $this->deleteOtherCache();
        return true;
    }

    /**
     * 根据代码返回游戏对象
     * @param string $sIdentifier
     * @return Lottery | false
     */
    public static function getByIdentifier($sIdentifier) {
        $bReadDb = false;
        if (static::$cacheLevel != self::CACHE_LEVEL_NONE) {
            Cache::setDefaultDriver(static::$cacheDrivers[static::$cacheLevel]);
            $key = self::compileCacheKeyByIdentifier($sIdentifier);
            if ($aAttributes = Cache::get($key)) {
                $obj = new static;
                $obj = $obj->newFromBuilder($aAttributes);
            } else {
                $bReadDb = true;
            }
        }
        if ($bReadDb) {
            $obj = self::where('identifier', '=', $sIdentifier)->get()->first();
            if (!is_object($obj)) {
                return false;
            }
            !$key or Cache::forever($key, $obj->getAttributes());
        }

        return $obj;
    }

    protected static function compileCacheKeyByIdentifier($sIdentifier) {
        return 'lottery-identifier-' . $sIdentifier;
    }

    /**
     * [getAllLotteriesGroupBySeries 根据彩系组织彩种]
     * @param  [Integer] $iOpen     [open属性]
     * @param  [boolean] $bNeedLink [是否需要判断彩系的link_to属性]
     * @return [Array]           [彩种数据]
     */
    public static function getAllLotteriesGroupBySeries($iStatus = null, $bNeedLink = true, $aLotteryColumns = null) {
        $aLotteries = self::getAllLotteries($iStatus, $aLotteryColumns);
        $aLinkTo = Series::getAllSeriesWithLinkTo();
        $aLotteriesArray = [];
        foreach ($aLotteries as $key => $aLottery) {
            if ($bNeedLink && $aLinkTo[$aLottery['series_id']]) {
                $aLottery['series_id'] = $aLinkTo[$aLottery['series_id']];
            }
            if (!isset($aLotteriesArray[$aLottery['series_id']])) {
                $aLotteriesArray[$aLottery['series_id']] = [];
            }
            $aLotteriesArray[$aLottery['series_id']][] = $aLottery;
        }
        return $aLotteriesArray;
    }

    /**
     * [getAllLotteryIdsGroupBySeries 生成彩种--彩系的映射数组, 彩系以linkTo属性为准]
     * @return [Array] [彩种--彩系的映射数组]
     */
    public static function getAllLotteryIdsGroupBySeries() {
        $aLotteries = self::getAllLotteries();
        $aLinkTo = Series::getAllSeriesWithLinkTo();
        $aLotteriesArray = [];
        foreach ($aLotteries as $key => $aLottery) {
            if ($aLinkTo[$aLottery['series_id']]) {
                $aLottery['series_id'] = $aLinkTo[$aLottery['series_id']];
            }
            $aLotteriesArray[$aLottery['id']] = $aLottery['series_id'];
        }
        return $aLotteriesArray;
    }

    /**
     * 获取彩种的分类显示信息
     */
    public static function getAllLotteriesByCategories($iStatus, $aLotteryColumns = null) {
        $aLotteries = self::getAllLotteries($iStatus, $aLotteryColumns);
        $aLotteriesArray = [];
        foreach ($aLotteries as $key => $aLottery) {
            $aLotteriesArray[$aLottery['category']][] = $aLottery;
        }
        return $aLotteriesArray;
    }

}
