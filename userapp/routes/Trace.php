<?php

# 追号管理
Route::group(['prefix' => 'tasks'],function (){
    $resource   = 'traces';
    $controller = 'UserTraceController@';
    Route::get(                 '/', ['as' => $resource . '.index',  'uses' => $controller . 'index']);
    Route::get(        '{id?}/view', ['as' => $resource . '.view',   'uses' => $controller . 'view']);
    Route::get(         'stop/{id}', ['as' => $resource . '.stop',   'uses' => $controller . 'stop']);
    Route::get('{id}/cancel/{detail_id}',['as' => $resource . '.cancel','uses' => $controller . 'cancel']);
    Route::get( '/mini-window', ['as' => $resource . '.mini-window', 'uses' => $controller . 'miniWindow']);
});
