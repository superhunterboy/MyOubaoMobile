<?php
/**
 * 用户，银行卡关联关系管理
 */
$sUrlDir = 'bank-cards';
Route::group(['prefix' => $sUrlDir], function () {
    $resource = 'bank-cards';
    $controller = 'BankCardController@';
    Route::get( 		'/', ['as' => $resource . '.index',  'uses' => $controller . 'index']);
    Route::any('create/{id?}', ['as' => $resource . '.create', 'uses' => $controller . 'create']);
    Route::any( '{id}/view', ['as' => $resource . '.view',   'uses' => $controller . 'view']);
    Route::any( '{id}/edit', ['as' => $resource . '.edit',   'uses' => $controller . 'edit']);
    Route::any( '{id}/black', ['as' => $resource . '.black',   'uses' => $controller . 'setToBlackList']);
    Route::any( '{id}/inuse', ['as' => $resource . '.inuse',   'uses' => $controller . 'setToInUseStatus']);
    Route::delete(   '{id}', ['as' => $resource . '.destroy', 'uses' => $controller . 'destroy']);
});