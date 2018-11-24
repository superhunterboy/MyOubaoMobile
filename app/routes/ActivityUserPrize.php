<?php

/**
 * Way管理
 */
$sUrlDir = 'activity-user-prizes';
Route::group(['prefix' => $sUrlDir], function () {
    $resource = 'activity-user-prizes';
    $controller = 'ActivityUserPrizeController@';
    Route::get('/', array('as' => $resource . '.index', 'uses' => $controller . 'index'));
    Route::any('create', array('as' => $resource . '.create', 'uses' => $controller . 'create'));
    Route::get('{id}/view', array('as' => $resource . '.view', 'uses' => $controller . 'view'));
    Route::any('{id}/edit', array('as' => $resource . '.edit', 'uses' => $controller . 'edit')); // ->before('not.self');
    Route::delete('{id}', array('as' => $resource . '.destroy', 'uses' => $controller . 'destroy')); // ->before('not.self');
    Route::get('/download', ['as' => $resource . '.download', 'uses' => $controller . 'download']);
    Route::any('{id}/accept', array('as' => $resource . '.accept', 'uses' => $controller . 'accept'));
    Route::any('{id}/audit', array('as' => $resource . '.audit', 'uses' => $controller . 'audit'));
    Route::any('{id}/reject', array('as' => $resource . '.reject', 'uses' => $controller . 'reject'));
});
