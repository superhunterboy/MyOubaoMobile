<?php

# 上下级转账
Route::group(['prefix' => 'mobile-transfer'],function (){
    $resource   = 'mobile-transfer';
    $controller = 'MobileAccountController@';
    Route::any('transfer', ['as' => $resource . '.transfer', 'uses' => $controller . 'transfer']);

    //return View::make('centerUser.transfer.index');

});