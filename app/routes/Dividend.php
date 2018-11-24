<?php

/**
 * 代理分红红利
 */
$sUrlDir = 'dividends';
Route::group(['prefix' => $sUrlDir], function () {
    $resource = 'dividends';
    $controller = 'DividendController@';
    Route::get( '/', array('as' => $resource . '.index', 'uses' => $controller . 'index'));
    // Route::any( 'create', array('as' => $resource . '.create', 'uses' => $controller . 'create'));
     Route::get('{id}/view', array('as' => $resource . '.view' , 'uses' => $controller . 'view'   ));
     Route::any('{id}/audit', array('as' => $resource . '.audit', 'uses' => $controller . 'audit')); // ->before('not.self');
     Route::any('{id}/reject', array('as' => $resource . '.reject', 'uses' => $controller . 'reject')); // ->before('not.self');
     Route::any('{id}/send', array('as' => $resource . '.send', 'uses' => $controller . 'send')); // ->before('not.self');
     Route::delete('{id}', array('as' => $resource . '.destroy', 'uses' => $controller . 'destroy')); // ->before('not.self');
});