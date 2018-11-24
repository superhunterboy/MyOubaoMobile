<?php

#系统设置管理
$sUrlDir = 'sys-configs';
Route::group(['prefix' => $sUrlDir], function () {
    $resource = 'sys-configs';
    $controller = 'SysConfigController@';
    Route::get('/', array('as' => $resource . '.index', 'uses' => $controller . 'index'));
    Route::get('settings', array('as' => $resource . '.settings', 'uses' => $controller . 'settings'));
    Route::any('create/{cur_id?}', array('as' => $resource . '.create', 'uses' => $controller . 'create'));
    Route::any('{id}/view', array('as' => $resource . '.view', 'uses' => $controller . 'view'));
    Route::any('{id}/edit', array('as' => $resource . '.edit', 'uses' => $controller . 'edit'));
    Route::delete('{id}', array('as' => $resource . '.destroy', 'uses' => $controller . 'destroy'));
    Route::post('set-order', array('as' => $resource . '.set-order', 'uses' => $controller . 'setOrder'));
    Route::any('set-value/{id?}', array('as' => $resource . '.set-value', 'uses' => $controller . 'setValue'));
        });
