<?php

# 开奖走势管理
Route::group(['prefix' => 'trends'], function () {
    $resource = 'mobile-trends';
    $controller = 'MobileTrendController@';
    Route::get('index', ['as' => $resource . '.index', 'uses' => $controller . 'index']);
    Route::get('trend-view/{lottery_id?}/{num_type?}', ['as' => $resource . '.trend-view', 'uses' => $controller . 'trendView']);
    Route::match(['GET', 'POST'], 'trend-data', ['as' => $resource . '.trend-data', 'uses' => $controller . 'getTrendData'])->before('ajax');
//    Route::get('trend-data', ['as' => $resource . '.trend-data',  'uses' => $controller . 'getTrendData']);
});
