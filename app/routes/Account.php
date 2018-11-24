<?php

/**
 * Account管理
 */
$sUrlDir = 'accounts';
Route::group(['prefix' => $sUrlDir], function () {
    $resource = 'accounts';
    $controller = 'AccountController@';
    Route::get(      '/', ['as' => $resource . '.index',   'uses' => $controller . 'index']);
    Route::get(   '{id}/view', ['as' => $resource . '.view',    'uses' => $controller . 'view']);
    Route::get('/download', array('as' => $resource . '.download', 'uses' => $controller . 'download'));
});
