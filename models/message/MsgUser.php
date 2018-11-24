<?php

use Illuminate\Support\Facades\Redis;

class MsgUser extends BaseModel {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'msg_users';
    protected $softDelete = true;
    public static $resourceName = 'MsgUser';
    public static $mainParamColumn = 'receiver_id';
    public static $rules = [
        'received_id' => 'integer',
        'receiver' => 'required|between:3,16',
        'sender_id' => 'integer',
        'sender' => 'required|between:3,16',
        'msg_id' => 'required|integer',
        'msg_title' => 'required|between:1,30',
        'is_keep' => 'in:0,1',
        'is_to_all' => 'in:0,1',
        'is_readed' => 'in:0,1',
        'is_deleted' => 'in:0,1',
        'readed_at' => 'date',
    ];
    protected $fillable = [
        'received_id',
        'receiver',
        'sender_id',
        'sender',
        'msg_id',
        'is_keep',
        'is_to_all',
        'is_readed',
        'is_deleted',
        'readed_at',
        'deleted_at',
    ];
    public static $columnForList = [
        'receiver',
        'sender',
        'msg_title',
        'is_keep',
        'deleted_at',
        'readed_at',
    ];

    /**
     * order by config
     * @var array
     */
    public $orderColumns = [
        'updated_at' => 'desc'
    ];
    public static $aDeletedStatus = ['未删', '已删'];
    public static $aReadedStatus = ['未读', '已读'];
    public static $ignoreColumnsInView = ['receiver_id', 'sender_id', 'msg_id', 'type_id', 'is_keep', 'is_to_all', 'is_readed', 'is_deleted', 'updated_at'];

    public static function & getListOfPage($iUserId, $iPage = 1, $iPageSize = 20) {
        $redis = Redis::connection();
        $sKey = self::compileListCacheKey($iUserId);
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

    /**
     * 获取指定用户的站内信
     * @param int $iUserId  用户id
     */
    public static function & getLatestRecords($iUserId = null, $iCount = 6) {
        $aUserMsgs = $aFirstUserMsgs = & self::getListOfPage($iUserId, 1) ? array_slice($aFirstUserMsgs, 0, $iCount) : [];
        return $aUserMsgs;
    }

    private static function compileListCacheKey($iUserId = null) {
        $sKey = self::getCachePrefix(TRUE);
        is_null($iUserId) or $sKey .= $iUserId;
        return $sKey;
    }

    public static function deleteListCache($iUserId) {
        $sKey = self::compileListCacheKey($iUserId);
        $redis = Redis::connection();
        $redis->del($sKey);
    }

    public static function createListCache($iUserId, $iPage = 1, $iPageSize = 20) {
        $redis = Redis::connection();
        $sKey = self::compileListCacheKey($iUserId);
        $aColumns = ['id', 'msg_title', 'is_readed', 'created_at'];
        $iStart = ($iPage - 1) * $iPageSize;
        $oUserMsgs = self::where('receiver_id', $iUserId)->where('is_deleted', 0)->orderBy('created_at', 'desc')->skip($iStart)->limit($iPageSize)->get($aColumns);
        $redis->multi();
        $redis->del($sKey);
        foreach ($oUserMsgs as $oUserMsg) {
            $redis->rpush($sKey, json_encode($oUserMsg->toArray()));
        }
        $redis->exec();
    }

    protected function afterSave($oSavedModel) {
        parent::afterSave($oSavedModel);
        $oSavedModel->deleteListCache($oSavedModel->receiver_id);
    }
}

