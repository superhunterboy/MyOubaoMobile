<?php

# 上下级转账
Route::group(['prefix' => 'transfer'],function (){
    $resource   = 'transfer';
    $controller = 'UserAccountController@';
    Route::any('transfer', ['as' => $resource . '.transfer', 'uses' => $controller . 'transfer']);

    //return View::make('centerUser.transfer.index');

});