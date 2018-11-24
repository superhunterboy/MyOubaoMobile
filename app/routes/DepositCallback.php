<?php
/**
 * 第三方充值回调日志管理
 */
$sUrlDir = 'deposit-callbacks';
Route::group(['prefix' => $sUrlDir], function () {
    $resource = 'deposit-callbacks';
    $controller = 'DepositCallbackController';
    $prev = $controller . '@';
    Route::get(        '/', ['as' => $resource . '.index',       'uses' => $prev . 'index']);
    Route::any(        '{id}/view', ['as' => $resource . '.view',        'uses' => $prev . 'view']);
});

