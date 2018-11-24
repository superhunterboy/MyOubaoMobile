<?php

/**
 * UserLogin用户登录历史
 */
$sUrlDir = 'user-login-ips';
Route::group(['prefix' => $sUrlDir], function () {
    $resource = 'user-login-ips';
    $controller = 'UserLoginIPController@';
    Route::get(           '/', ['as' => $resource . '.index',   'uses' => $controller . 'index']);
    Route::get(   '{id}/view', ['as' => $resource . '.view',    'uses' => $controller . 'view']);
});
