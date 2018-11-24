<?php

# 站内信
Route::group(['prefix' => 'letters'], function () {
    $resource = 'station-letters';
    $controller = 'StationLetterController@';
    Route::get( '/', ['as' => $resource . '.index', 'uses' => $controller . 'index']);
    Route::get('{id}/view', ['as' => $resource . '.view', 'uses' => $controller . 'viewMessage']);
//    Route::get('get-user-unread-num', ['as' => $resource . '.get-user-unread-num', 'uses' => $controller . 'getUserUnreadNum']);
    Route::get('get-user-messages', ['as' => $resource . '.get-user-messages', 'uses' => $controller . 'getUserMessages']);
    Route::get('/delete/{id}', ['as' => $resource . '.delete-message', 'uses' => $controller . 'deleteMessage']);
});
