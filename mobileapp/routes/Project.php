<?php

# 注单管理
Route::group(['prefix' => 'boughts'], function () {
    $resource = 'projects';
    $controller = 'UserProjectController@';
    Route::get(            '/', ['as' => $resource . '.index',       'uses' => $controller . 'index']);
    Route::get( '/mini-window/{iLotteryId?}', ['as' => $resource . '.mini-window', 'uses' => $controller . 'miniWindow']);

    // Route::any( 'create', ['as' => $resource . '.create', 'uses' => $controller . 'create']);
    Route::get(    '{id}/view', ['as' => $resource . '.view', 'uses' => $controller . 'view']);
    // Route::any('{id}/edit', ['as' => $resource . '.edit', 'uses' => $controller . 'edit']);
    Route::get(    '{id}/drop', ['as' => $resource . '.drop', 'uses' => $controller . 'drop']);
});
