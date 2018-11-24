<?php
$sPrefix = Config::get('queue.prefix');
//$sPrefix = '';
return [
    'calculate'  => $sPrefix . Config::get('queue.calculate_prefix') . '%lottery_id%',
    'send_money' => $sPrefix . 'send_money',
    'send_prize' => $sPrefix . 'prize',
    'send_commission' => $sPrefix . 'commission',
    'trace'      => $sPrefix . 'trace',
    'withdraw'   => $sPrefix . 'withdraw',
    'stat'       => $sPrefix . 'stat',
    'account'    => $sPrefix . 'account',
    'activity'    => $sPrefix . 'activity',
];
