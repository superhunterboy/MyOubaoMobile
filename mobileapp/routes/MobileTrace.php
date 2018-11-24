<?php

# 追号管理
Route::group(['prefix' => 'mobile-traces'], function () {
    $resource = 'mobile-traces';
    $controller = 'MobileTraceController@';
    Route::any('/', ['as' => $resource . '.index', 'uses' => $controller . 'index']);
    Route::any('cancel-index', ['as' => $resource . '.cancel-index', 'uses' => $controller . 'cancelIndex']);
    Route::any('process-index', ['as' => $resource . '.process-index', 'uses' => $controller . 'processIndex']);
    Route::any('end-index', ['as' => $resource . '.end-index', 'uses' => $controller . 'endIndex']);
    Route::any('{id?}/view', ['as' => $resource . '.view', 'uses' => $controller . 'view']);
    Route::any('{id}/stop', ['as' => $resource . '.stop', 'uses' => $controller . 'stop']);
    Route::get('{id}/cancel/{detail_id}', ['as' => $resource . '.cancel', 'uses' => $controller . 'cancel']);
});
