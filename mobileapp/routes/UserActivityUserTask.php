<?php

Route::group(['prefix' => 'events'], function () {
    $resource = 'user-activity-user-tasks';
    $controller = 'UserActivityUserTaskController@';
    Route::get('sign/{taskId}', ['as' => $resource . '.sign-task', 'uses' => $controller . 'signTaskforDailyMoney']);
    Route::get('signregist/{taskId}', ['as' => $resource . '.sign-regist', 'uses' => $controller . 'signTaskforRegist']);
    Route::get('signmooncake/{taskId}', ['as' => $resource . '.sign-mooncake', 'uses' => $controller . 'signTaskforMooncake']);
    Route::get('/', ['as' => $resource . '.index', 'uses' => $controller . 'index']);
    Route::get('/everydaygetmoney', ['as' => $resource . '.user-task', 'uses' => $controller . 'getUserTask']);
    Route::get('/registgetmoney', ['as' => $resource . '.regist-task', 'uses' => $controller . 'registTask']);
    Route::get('/mooncakes', ['as' => $resource . '.mooncake-task', 'uses' => $controller . 'mooncakeTask']);
    // Route::any(   'create', ['as' => $resource . '.create',  'uses' => $controller . 'create']);
    // Route::get('{id}/view', ['as' => $resource . '.view',    'uses' => $controller . 'view']);
    // Route::delete(  '{id}', ['as' => $resource . '.destroy', 'uses' => $controller . 'destroy']);
});
