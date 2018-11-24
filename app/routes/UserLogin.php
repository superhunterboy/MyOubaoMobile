<?php

/**
 * UserLogin用户登录历史
 */
$sUrlDir = 'user-logins';
Route::group(['prefix' => $sUrlDir], function () {
    $resource = 'user-logins';
    $controller = 'UserLoginController@';
    Route::get(           '/', ['as' => $resource . '.index',   'uses' => $controller . 'index']);
    Route::get(   '{id}/view', ['as' => $resource . '.view',    'uses' => $controller . 'view']);
});
