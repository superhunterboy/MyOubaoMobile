<?php

/*
 * 词汇模型类
 * 作用：生成语言包词汇以及导出语言包文件
 */

use Illuminate\Support\Facades\Redis;

class CmsArticle extends BaseModel {

    protected static $cacheLevel = self::CACHE_LEVEL_FIRST;
    protected static $cacheMinutes = 60;
    public static $resourceName = 'CmsArticle';
    protected static $maxCacheLength = 20;

    /**
     * title field
     * @var string
     */
    public static $titleColumn = 'title';
    public $orderColumns = [
        'is_top' => 'desc',
        'updated_at' => 'desc'
    ];
    public static $mobileColumns = [
        'id',
        'title',
        'created_at'
    ];

    /**
     * the columns for list page
     * @var array
     */
    public static $columnForList = [
        'category_id',
        'title',
        'summary',
        'search_text',
        'add_user_id',
        'is_top',
        'status',
        'update_user_id',
        'created_at'
    ];

    /**
     * The rules to be applied to the data.
     *
     * @var array
     */
    public static $rules = [
        'title' => 'required|max:50',
        'summary' => 'max:50',
        'content' => 'required',
        'search_text' => 'max:50000',
        'category_id' => 'required|integer',
        'is_top' => 'required|in:0,1',
        'status' => 'required|in:0,1,2,3',
    ];
    protected $table = 'cms_articles';
    public static $htmlSelectColumns = [
        'category_id' => 'aCategories',
        'add_user_id' => 'aAdmins',
        'update_user_id' => 'aAdmins',
        'status' => 'aStatus',
    ];
    protected $fillable = [
        'category_id',
        'title',
        'summary',
        'content',
        'search_text',
        'status',
    ];

    const TYPE_HELP = 1;
    const TYPE_ANNOUMCEMENT = 2;
    const STATUS_NEW = 0; // 待审核
    const STATUS_AUDITED = 1; // 审核通过
    const STATUS_REJECTED = 2; // 审核未通过
    const STATUS_RETRACT = 3; // 公告下架
    const STATUS_TOP_ON = 1;
    const STATUS_TOP_OFF = 0;

    public static $aStatusDesc = [
        self::STATUS_NEW => 'new',
        self::STATUS_AUDITED => 'audited',
        self::STATUS_REJECTED => 'rejected',
        self::STATUS_RETRACT => 'retract',
    ];

    /**
     * ignore columns for edit
     * @var array
     */
    public static $ignoreColumnsInEdit = ['status','is_top'];

    protected function afterSave($oSavedModel) {
        parent::afterSave($oSavedModel);
        $oSavedModel->deleteListCache();
    }

    protected function beforeValidate() {
        if (!Session::get('admin_user_id')) {
            return false;
        }
        $this->add_user_id = Session::get('admin_user_id');
        isset($this->is_top) or $this->is_top = 0;
        isset($this->status) or $this->status = self::STATUS_AUDITED;
        return parent::beforeValidate();
    }

    // protected function afterSave($bSucc) {
    //     // pr($this->aFiles);
    //     // exit;
    //     return parent::afterSave($bSucc);
    // }

    protected static function createAnnouncementCache() {
        $redis = Redis::connection();
        $sKey = self::compileListCacheKey(CmsArticle::TYPE_ANNOUMCEMENT);
        $aColumns = ['id', 'title', 'created_at'];
        $aMoreArticles = self::where('category_id', CmsArticle::TYPE_ANNOUMCEMENT)->where('status', self::STATUS_AUDITED)->orderBy('is_top', 'desc')->orderBy('created_at', 'desc')->skip($iExistsCount)->take($iCount)->get($aColumns);
        foreach ($aMoreArticles as $oMoreArticle) {
            $aArticles[] = $oMoreArticle;
            $redis->rpush($sKey, json_encode($oMoreArticle->toArray()));
        }
    }

    public static function createListCache($iUserId, $iPage = 1, $iPageSize = 20) {
        $redis = Redis::connection();
        $sKey = self::compileListCacheKey($iUserId, $iPage);
        $aColumns = ['id', 'title', 'created_at'];
        $iStart = ($iPage - 1) * $iPageSize;
        $oArticles = self::where('category_id', CmsArticle::TYPE_ANNOUMCEMENT)->where('status', self::STATUS_AUDITED)->orderBy('is_top', 'desc')->orderBy('created_at', 'desc')->skip($iStart)->limit($iPageSize)->get($aColumns);
        $redis->multi();
        $redis->del($sKey);
        foreach ($oArticles as $oArticle) {
            $redis->rpush($sKey, json_encode($oArticle->toArray()));
        }
        $redis->exec();
    }

    public static function & getListOfPage($iUserId, $iPage = 1, $iPageSize = 20) {
        $redis = Redis::connection();
        $sKey = self::compileListCacheKey($iUserId, $iPage);
        if (!$bHasInRedis = $redis->exists($sKey)) {
            self::createListCache($iUserId, $iPage);
        }
        $aArticlesFromRedis = $redis->lrange($sKey, 0, $redis->llen($sKey) - 1);
        $aArticles = [];
        foreach ($aArticlesFromRedis as $sArticle) {
            $obj = new static;
            $obj = $obj->newFromBuilder(json_decode($sArticle, true));
            $aArticles[] = $obj;
        }
        unset($aArticlesFromRedis, $obj, $sKey, $redis);
        return $aArticles;
    }

    public static function & getLatestRecords($iUserId = null, $iCount = 4) {
        $aArticles = $aFirstArticles = & self::getListOfPage($iUserId, 1) ? array_slice($aFirstArticles, 0, $iCount) : [];
        return $aArticles;
    }

//    public static function getLatestRecords($iCount = 4) {
//        $redis = Redis::connection();
//        $sKey = self::compileListCacheKey();
//        if ($bHasInRedis = $redis->exists($sKey)){
//            $aArticlesFromRedis = $redis->lrange($sKey,0,$iCount - 1);
////            pr($aArticlesFromRedis);
//            $iExistsCount = count($aArticlesFromRedis);
//            $iNeedCount = $iCount - $iExistsCount;
//            foreach($aArticlesFromRedis as $sInfo){
//                $obj = new static;
//                $obj = $obj->newFromBuilder(json_decode($sInfo, true));
//                $aArticles[] = $obj;
//            }
//            unset($obj);
//        }
//        else{
//            $iNeedCount = $iCount;
//            $aArticles = [];
//            $iExistsCount = 0;
//        }
//        if (!$bHasInRedis || $iNeedCount > 0){
//            $aColumns = ['id', 'title', 'created_at'];
//            $aMoreArticles = self::where('category_id', CmsArticle::TYPE_ANNOUMCEMENT)->where('status', self::STATUS_AUDITED)->orderBy('is_top', 'desc')->orderBy('created_at', 'desc')->skip($iExistsCount)->take($iCount)->get($aColumns);
//            foreach($aMoreArticles as $oMoreArticle){
//                $aArticles[] = $oMoreArticle;
//                $redis->rpush($sKey, json_encode($oMoreArticle->toArray()));
//            }
//        }
////        pr($aArticles);
////        exit;
//        return $aArticles;
//    }

    private static function compileListCacheKey($iType = null) {
        $sKey = self::getCachePrefix(TRUE);
        is_null($iType) or $sKey .= $iType;
        return $sKey;
    }

    public static function deleteListCache() {
        $sKey = self::compileListCacheKey();
        $redis = Redis::connection();
        $redis->del($sKey);
    }

//    public static function getLatestRecords($iCount = 5) {
//        $aColumns = ['id', 'title', 'updated_at'];
//        $aArticles = self::where('category_id', CmsArticle::TYPE_ANNOUMCEMENT)->where('status', 1)->orderBy('is_top', 'desc')->orderBy('updated_at', 'desc')->limit($iCount)->get($aColumns);
////        pr($aArticles->toArray());
////        exit;
//        return $aArticles;
//    }

    public static function getHelpCenterArticles() {
        $aCategories = CmsCategory::getHelpCenterCategories();
        $aCategoryIds = [];
        foreach ($aCategories as $key => $value) {
            $aCategoryIds[] = $value->id;
        }

        return CmsArticle::whereIn('category_id', $aCategoryIds)->get();
    }

    public static function getArticlesByCaregoryId($iCategoryId) {
        return CmsArticle::where('category_id', '=', $iCategoryId)->get();
    }

    public function getUpdatedAtDayAttribute() {
        return date('m/d', strtotime($this->updated_at));
    }

    public function getCreatedAtDayAttribute() {
        return date('m/d', strtotime($this->created_at));
    }

}
