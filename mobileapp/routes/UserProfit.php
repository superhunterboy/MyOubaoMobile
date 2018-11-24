<?php

# 盈亏报表
Route::group(['prefix' => 'user-profits'], function () {
    $resource = 'user-profits';
    $controller = 'UserUserProfitController@';
    Route::get(         '/', ['as' => $resource . '.index',      'uses' => $controller . 'index']);
    Route::get(         '/myself', ['as' => $resource . '.myself',      'uses' => $controller . 'myself']);
    Route::get('commission', ['as' => $resource . '.commission', 'uses' => $controller . 'commission']);
});