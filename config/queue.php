<?php
//$sPrefix = str_replace('-','_',Config::get('cache.prefix'));
$sPrefix = Config::get('cache.prefix');
//$sPrefix = '';
$driver = 'beanstalkd';
$host   = Config::get('setup.beanstalkd');
$ttr         = 60;
$lotteries   = Config::get('lotteries.lotteries');
$connections = [
    'main',
    'send_money',
    'prize',
    'commission',
    'trace',
    'withdraw',
    'account',
    'stat',
    'statWithdrawal',
    'statDeposit',
    'statTurnover',
    'statBonus',
    'statPrize',
    'statCommission',
    'activity',
    'deposit',
];
$prev        = 'calculate-';
foreach ($lotteries as $iLotteryId) {
    $connections[] = $prev . $iLotteryId;
}
$config      = [
    'default'     => $sPrefix . 'main',
    'connections' => [
        'sync' => [
            'driver' => 'sync',
        ],
    ],
    'failed'      => [
        'database' => 'mysql', 'table'    => 'failed_jobs',
    ],
    'prefix' => $sPrefix,
    'calculate_prefix' => $prev,
];
//$sPrefix = Config::get('cache.prefix');
foreach ($connections as $sName) {
    $config['connections'][$sPrefix . $sName] = [
        'driver' => $driver,
        'host'   => $host,
        'queue'  => $sPrefix . $sName,
        'ttr'    => $ttr,
    ];
}
return $config;
