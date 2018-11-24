<?php

# User管理
Route::group(['prefix' => 'mobile-users'], function () {
    $resource = 'mobile-users';
    $controller = 'MobileH5UserController@';
    Route::any('/user-account-info', ['as' => $resource . '.user-account-info', 'uses' => $controller . 'getUserAccountInfo']);
    Route::any('/index', ['as' => $resource . '.index', 'uses' => $controller . 'index']);
    Route::any('safe-reset-fund-password', ['as' => $resource . '.safe-reset-fund-password', 'uses' => $controller . 'safeChangeFundPassword']);
    Route::any('change-password', ['as' => $resource . '.change-password', 'uses' => $controller . 'changePassword']);
    Route::any('change-fund-password', ['as' => $resource . '.change-fund-password', 'uses' => $controller . 'changeFundPassword']);
    Route::get('user-monetary-info', ['as' => $resource . '.user-monetary-info', 'uses' => $controller . 'getLoginUserMonetaryInfo'])->before('ajax');
    Route::any('accurate-create', ['as' => $resource . '.accurate-create', 'uses' => $controller . 'accurateCreate'])->before('agent');
    Route::any('user', ['as' => $resource . '.user', 'uses' => $controller . 'user']);
    Route::get('team-home', ['as' => $resource . '.team-home', 'uses' => $controller . 'teamHome']);
});
