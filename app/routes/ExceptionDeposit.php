<?php

/**
 * Bank管理
 */
Route::group(['prefix' => 'exception-deposits'], function () {
    $resource = 'exception-deposits';
    $controller = 'ExceptionDepositController@';
    Route::get('/', array('as' => $resource . '.index', 'uses' => $controller . 'index'));
    Route::get('{id}/view', array('as' => $resource . '.view', 'uses' => $controller . 'view'));

    Route::put('{id}/add-coin', array('as' => $resource . '.add-coin', 'uses' => $controller . 'addCoin'));
    Route::get('/edit', array('as' => $resource . '.edit', 'uses' => $controller . 'edit'));
    Route::put('{id}/ignore', array('as' => $resource . '.ignore', 'uses' => $controller . 'ignore'));
    Route::get('{id}/accept', array('as' => $resource . '.accept', 'uses' => $controller . 'accept'));
    Route::any('{id}/submit-document', array('as' => $resource . '.submit-document', 'uses' => $controller . 'submitDocument'));
    Route::any('{id}/accept-verify', array('as' => $resource . '.accept-verify', 'uses' => $controller . 'acceptVerify'));
    Route::any('{id}/set-verified', array('as' => $resource . '.set-verified', 'uses' => $controller . 'setToVerified'));
    Route::any('{id}/refund/', array('as' => $resource . '.refund', 'uses' => $controller . 'refund'));
    Route::get('load-img/{id}/{imgName}', ['as' => $resource . '.load-img', 'uses' => $controller . 'loadImg']);
});
