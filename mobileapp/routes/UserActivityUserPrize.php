<?php

Route::group(['prefix' => 'user-activity-user-prizes'], function () {
    $resource = 'user-activity-user-prizes';
    $controller = 'UserActivityUserPrizeController@';
    Route::get('/', ['as' => $resource . '.index', 'uses' => $controller . 'index']);
//    Route::get('/unavailable', ['as' => $resource . '.unavailable', 'uses' => $controller . 'unAvailableHB']);
    Route::get('/available', ['as' => $resource . '.available', 'uses' => $controller . 'availableHB']);
    Route::get('/received', ['as' => $resource . '.received', 'uses' => $controller . 'receivedHB']);
    Route::get('/expired', ['as' => $resource . '.expired', 'uses' => $controller . 'expiredHB']);
    Route::post('/get-prize', ['as' => $resource . '.get-prize', 'uses' => $controller . 'getPrize']);
    // Route::any(   'create', ['as' => $resource . '.create',  'uses' => $controller . 'create']);
    // Route::get('{id}/view', ['as' => $resource . '.view',    'uses' => $controller . 'view']);
    // Route::delete(  '{id}', ['as' => $resource . '.destroy', 'uses' => $controller . 'destroy']);
});
