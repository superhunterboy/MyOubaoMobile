<?php

# User管理
Route::group(['prefix' => 'users'], function () {
    $resource   = 'users';
    $controller = 'UserUserController@';
    Route::get(                          '/', ['as' => $resource . '.index',                    'uses' => $controller . 'index'])->before('agent');
    Route::get(            '{pid}/sub-users', ['as' => $resource . '.sub-users',                'uses' => $controller . 'subUsers'])->before('agent');
    Route::any('change-password', ['as' => $resource . '.change-password',      'uses' => $controller . 'changePassword']);
    Route::any('change-fund-password', ['as' => $resource . '.change-fund-password',      'uses' => $controller . 'changeFundPassword']);
    Route::any(   'safe-reset-fund-password/{isWin?}', ['as' => $resource . '.safe-reset-fund-password', 'uses' => $controller . 'safeChangeFundPassword']);
    Route::any(            'accurate-create', ['as' => $resource . '.accurate-create',          'uses' => $controller . 'accurateCreate'])->before('agent');
    Route::any(                       'user', ['as' => $resource . '.user',                     'uses' => $controller . 'user']);
    Route::any(                   'personal', ['as' => $resource . '.personal',                 'uses' => $controller . 'personal']);
    Route::any(                   'portrait', ['as' => $resource . '.portrait',                 'uses' => $controller . 'portrait']);
    Route::any(                   'bind-email', ['as' => $resource . '.bind-email',             'uses' => $controller . 'bindEmail']);
    Route::any(                   'activate-email', ['as' => $resource . '.activate-email',     'uses' => $controller . 'activateEmail', 'before'=>'maxAccess:1,10']);
    Route::get(         'user-monetary-info', ['as' => $resource . '.user-monetary-info',       'uses' => $controller . 'getLoginUserMonetaryInfo'])->before('ajax');
});