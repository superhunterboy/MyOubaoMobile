<?php

# 盈亏报表
Route::group(['prefix' => 'prize-lift'], function () {
    $resource = 'user-prizeset-float-reports';
    $controller = 'UserPrizeSetFloatReportController@';
    Route::get(         '/', ['as' => $resource . '.index',      'uses' => $controller . 'index']);
});