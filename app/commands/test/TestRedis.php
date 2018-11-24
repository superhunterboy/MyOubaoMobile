<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Illuminate\Support\Facades\Redis;
/**
 * 测试Redis
 */
class TestRedis extends BaseCommand {
    protected $sFileName = 'TestRedis';
    protected $name = 'test:redis';
    protected $description = 'test the redis function';

    public function doCommand(& $sMsg = null){
        pr(UserWithdrawal::getIsLargeStandard(50));
        exit;
        Cache::setDefaultDriver('memcached');
        $key = 'testttttttt';
        Cache::has($key) or Cache::forever($key,0);
        Cache::increment('testttttttt');
        Cache::increment('testttttttt');
        Cache::increment('testttttttt');
        Cache::increment('testttttttt');
        pr(Cache::get('testttttttt'));
        exit;

        $oTrace = Trace::find(427);
        pr(get_class($oTrace));
        $oTrace2 = $oTrace->where('id','=',427)->get()->first();
        pr(get_class($oTrace2));
        exit;
        ManProject::deleteAllUserBetListCache();
        exit;
        ManIssue::deleteOnSaleIssueCache(1);
        $sIssue = ManIssue::getOnSaleIssue(1);
        die($sIssue . "\n");
        $redis = Redis::connection();
        $redis->sadd('bet',12345);
        $redis->sadd('bet',12345);
        $redis->sadd('bet',45862);
        $redis->sadd('bet',3939);
//        $redis->sadd('beta',3939);
        $a = $redis->smembers('bet');
        var_dump($a);
        $redis->srem('bet',[45862,3939]);
//        $redis->srem('beta',[45862,3939]);
        $redis->del('beta');
        
//        $redis->srem('bet',03939);
        $a = $redis->smembers('bet');
        $b = $redis->smembers('beta');
        var_dump($a);
        var_dump($b);
        
        var_dump($redis->smembers('bet-thread--13--1505130805'));
        var_dump($redis->smembers('bet-thread--1--150513087'));
        var_dump(BetThread::isEmpty(1, '150513087'));
        pr($redis->smembers('bet-thread--1--150513087'));

        var_dump($redis->smembers('bet-thread--1--150513089'));
    }
}
