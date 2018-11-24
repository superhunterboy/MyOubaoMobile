<?php

# 充值管理
Route::group(['prefix' => 'mobile-deposits'], function () {
    $resource = 'mobile-deposits';
    $controller = 'MobileDepositController@';
    Route::any('/', ['as' => $resource . '.index', 'uses' => $controller . 'index']);
    Route::any('create', ['as' => $resource . '.create', 'uses' => $controller . 'create']);
    Route::any('{id}/view', ['as' => $resource . '.view', 'uses' => $controller . 'view']);
    Route::any('{id}/edit', ['as' => $resource . '.edit', 'uses' => $controller . 'edit']);
    Route::any('netbank', ['as' => $resource . '.netbank', 'uses' => $controller . 'netbank']);
    Route::any('quick/{id?}', ['as' => $resource . '.quick', 'uses' => $controller . 'quick']);
    Route::any('confirm', ['as' => $resource . '.confirm', 'uses' => $controller . 'confirm']);
});
