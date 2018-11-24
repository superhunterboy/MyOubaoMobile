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
    'account'   => $sPrefix . 'account',
    'stat'       => $sPrefix . 'stat',
    'statWithdrawal'       => $sPrefix . 'statWithdrawal',
    'statDeposit'       => $sPrefix . 'statDeposit',
    'statTurnover'       => $sPrefix . 'statTurnover',
    'statBonus'       => $sPrefix . 'statBonus',
    'statPrize'       => $sPrefix . 'statPrize',
    'statCommission'       => $sPrefix . 'statCommission',
    'account'    => $sPrefix . 'account',
    'activity'    => $sPrefix . 'activity',
];
