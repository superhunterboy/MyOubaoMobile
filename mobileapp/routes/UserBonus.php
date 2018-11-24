<?php

# 盈亏报表
Route::group(['prefix' => 'dividends'], function () {
    $resource = 'user-dividends';
    $controller = 'UserDividendController@';
    Route::get(         '/', ['as' => $resource . '.index',      'uses' => $controller . 'index']);
});