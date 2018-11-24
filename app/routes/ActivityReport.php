<?php

/**
 *  活动报表
 */
Route::group(['prefix' => 'activity-report-user-prizes'], function () {
    $resource = 'activity-report-user-prizes';
    $controller = 'ActivityReportUserPrizeController@';
    Route::get('/', array('as' => $resource . '.index', 'uses' => $controller . 'index'));
    Route::get('/download', array('as' => $resource . '.download', 'uses' => $controller . 'download'));
});

