<?php

/**
 * 操作日志管理
 */
$sUrlDir = 'functionality-logs';
Route::group(['prefix' => $sUrlDir], function () {
    $resource = 'functionality-logs';
    $controller = 'FunctionalityLogController@';
    Route::get('/', array('as' => $resource . '.index', 'uses' => $controller . 'index'));
    Route::any('create/{id?}', array('as' => $resource . '.create', 'uses' => $controller . 'create'));
    Route::any('{id}/view', array('as' => $resource . '.view', 'uses' => $controller . 'view'));
    Route::any('{id}/edit', array('as' => $resource . '.edit', 'uses' => $controller . 'edit'));
    Route::delete('{id}', array('as' => $resource . '.destroy', 'uses' => $controller . 'destroy'));
});
