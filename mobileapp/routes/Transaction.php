<?php

# 账变管理
Route::group(['prefix' => 'transactions'], function () {
    $resource = 'user-transactions';
    $controller = 'UserTransactionController@';
    Route::get('/index/{id?}', ['as' => $resource . '.index', 'uses' => $controller . 'index']);
    Route::any('create', ['as' => $resource . '.create', 'uses' => $controller . 'create']);
    Route::get('{id}/view', ['as' => $resource . '.view', 'uses' => $controller . 'view']);
    Route::any('{id}/edit', ['as' => $resource . '.edit', 'uses' => $controller . 'edit']);
    Route::delete('{id}', ['as' => $resource . '.destroy', 'uses' => $controller . 'destroy']);
    Route::get('/mini-window', ['as' => $resource . '.mini-window', 'uses' => $controller . 'miniWindow']);
});
