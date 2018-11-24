<?php

# 投注
Route::group(['prefix' => 'buy'], function () {
    $resource = 'bets';
    $controller = 'BetController@';
    Route::get('/bet/{lottery_id?}',['as' => $resource . '.betform','uses' => $controller . 'bet']);
    Route::get('/load-data/{lottery_id?}',['as' => $resource . '.load-data','uses' => $controller . 'getGameSettingsForRefresh']);
    Route::get('/load-numbers/{lottery_id?}',['as' => $resource . '.load-numbers','uses' => $controller . 'getIssueListForRefresh']);

    // Route::post('/upload-bet-number',['as'   => $resource . '.upload-bet-number','uses' => function (){
    //     if (Request::getMethod() !== 'GET' && Session::token() != Input::get('_token')){
    //         die('请先登录');
    //     }
    //     $aLimits    = [
    //         'extension' => [ 'txt'],
    //         'mime_type' => [ 'text/plain'],
    //         'max_size'  => 200 * 1024
    //     ];
    //     $aInputData = Input::all();
    //     $oFileInfo  = $aInputData[ 'betNumber' ];
    //     in_array($oFileInfo->getClientOriginalExtension(),$aLimits[ 'extension' ]) or die();
    //     in_array($oFileInfo->getClientMimeType(),$aLimits[ 'mime_type' ]) or die();
    //     $oFileInfo->getClientSize() <= $aLimits[ 'max_size' ] or die();
    //     echo file_get_contents($oFileInfo->getPathName());
    //     exit;
    // }]);
});
