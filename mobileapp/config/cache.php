<?php

$config           = [
    'driver' => 'memcached',
    'path' => storage_path().'/cache',
    'prefix' => 'dsgame-',
];
$config['memcached'][] = Config::get('setup.memcached');
$redis                 = Config::get('setup.redis');
!$redis or $config['redis'][]     = $redis;
return $config;
