<?php
return [
    'memcached' => [
        'host'   => '127.0.0.1',
        'port'   => 11211,
        'weight' => 100
    ],
    'beanstalkd' => '127.0.0.1',
    'redis' => [
        'cluster' => false,
        'default' => [
            'host'     => '127.0.0.1',
            'port'     => 6379,
            'database' => 0,
        ]
    ],
];
