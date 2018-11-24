<?php

use Illuminate\Support\Facades\Redis;

class UserTransaction extends Transaction {

    protected static $cacheUseParentClass = true;
    protected $fillable = [];

    /**
     * the columns for list page
     * @var array
     */
    public static $columnForList = [
        'serial_number',
        'created_at',
        'username',
        'is_tester',
        'description',
        'lottery_id',
        'way_id',
        'coefficient',
        'amount',
        'available',
        'note',
        'ip',
        'administrator',
        'is_income',
        'tag',
    ];

    public static function createListCache($iUserId, $iPage = 1, $iPageSize = 20) {
        $redis = Redis::connection();
        $sKey = self::compileListCacheKey($iUserId, $iPage);
        $aColumns = static::$columnForList;
        $oQuery = self::where('user_id', '=', $iUserId);
        $iStart = ($iPage - 1) * $iPageSize;
        $oTransactions = $oQuery->orderBy('created_at', 'desc')->skip($iStart)->limit($iPageSize)->get($aColumns);
        $redis->multi();
        $redis->del($sKey);
        foreach ($oTransactions as $oTransaction) {
            $redis->rpush($sKey, json_encode($oTransaction->toArray()));
        }
        $redis->exec();
    }

    public static function & getListOfPage($iUserId, $iPage = 1, $iPageSize = 20) {
        $redis = Redis::connection();
        $sKey = self::compileListCacheKey($iUserId, $iPage);
        if (!$bHasInRedis = $redis->exists($sKey)) {
            self::createListCache($iUserId, $iPage);
        }
        $aTransactionsFromRedis = $redis->lrange($sKey, 0, $redis->llen($sKey) - 1);
        $aTransactions = [];
        foreach ($aTransactionsFromRedis as $sTransaction) {
            $obj = new static;
            $obj = $obj->newFromBuilder(json_decode($sTransaction, true));
            $aTransactions[] = $obj;
        }
        unset($aTransactionsFromRedis, $obj, $sKey, $redis);
//        pr($aTransactions);
//        exit;
        return $aTransactions;
    }

    public static function & getLatestRecords($iUserId = null, $iCount = 20) {
        $aTransactions = ($aFirstTransactions = & self::getListOfPage($iUserId, 1)) ? array_slice($aFirstTransactions, 0, $iCount) : [];
        return $aTransactions;
    }

    public static function _getLatestRecords($iUserId = null, $iCount = 4) {
        $redis = Illuminate\Support\Facades\Redis::connection();
        $sKey = self::compileListCacheKey($iUserId);
        if ($bHasInRedis = $redis->exists($sKey)) {
            $aTransactionsFromRedis = $redis->lrange($sKey, 0, $iCount - 1);
//            pr($aTransactionsFromRedis);
//            exit;
            $iNeedCount = $iCount - count($aTransactionsFromRedis);
            foreach ($aTransactionsFromRedis as $sInfo) {
                $obj = new static;
                $obj = $obj->newFromBuilder(json_decode($sInfo, true));
                $aTransactions[] = $obj;
            }
            unset($obj);
        } else {
            $iNeedCount = $iCount;
            $aTransactions = [];
        }
        if (!$bHasInRedis || $iNeedCount > 0){
            $aColumns = ['id', 'amount', 'type_id', 'description', 'updated_at', 'is_income', 'serial_number','is_income'];
            $oQuery = self::where('user_id', '=', $iUserId);
            $aMoreTransactions = isset($oQuery) ? $oQuery->orderBy('id', 'desc')->limit($iNeedCount)->get($aColumns) : [];
            foreach ($aMoreTransactions as $oMoreTransaction) {
                $aTransactions[] = $oMoreTransaction;
                $redis->rpush($sKey, json_encode($oMoreTransaction->toArray()));
            }
        }
//        pr($aTransactions);
//        exit;
        return $aTransactions;
    }

//    public static function getLatestRecords($iCount = 4) {
//        $aColumns = ['id', 'amount', 'type_id', 'description', 'updated_at', 'is_income'];
//        $iUserId = Session::get('user_id');
//        $oQuery = self::where('user_id', '=', $iUserId);
//        $aTransactions = isset($oQuery) ? $oQuery->orderBy('updated_at', 'desc')->limit($iCount)->get($aColumns) : [];
//        return $aTransactions;
//    }
}
