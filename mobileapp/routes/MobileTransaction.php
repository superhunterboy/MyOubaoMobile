<?php

# 账变管理
Route::group(['prefix' => 'mobile-transactions'], function () {
    $resource = 'mobile-transactions';
    $controller = 'MobileTransactionController@';
    Route::any('/index', ['as' => $resource . '.index', 'uses' => $controller . 'index']);
    Route::get('/{id?}/mydeposit', ['as' => $resource . '.mydeposit', 'uses' => $controller . 'myDeposit']);
    Route::get('/{id?}/mywithdraw', ['as' => $resource . '.mywithdraw', 'uses' => $controller . 'myWithdraw']);
    Route::get('/mytransfer', ['as' => $resource . '.mytransfer', 'uses' => $controller . 'myTransfer']);
    Route::any('create', ['as' => $resource . '.create', 'uses' => $controller . 'create']);
    Route::any('{id}/view', ['as' => $resource . '.view', 'uses' => $controller . 'view']);
    Route::any('{id}/edit', ['as' => $resource . '.edit', 'uses' => $controller . 'edit']);
    Route::delete('{id}', ['as' => $resource . '.destroy', 'uses' => $controller . 'destroy']);
});
