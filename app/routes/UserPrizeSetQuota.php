<?php

/**
 * UserPrizeSet管理
 */
$sUrlDir = 'user-prize-set-quotas';
Route::group(['prefix' => $sUrlDir], function () {
    $resource = 'user-prize-set-quotas';
    $controller = 'UserPrizeSetQuotaController@';
    Route::get(    '/index', ['as' => $resource . '.index',         'uses' => $controller . 'index']);
//    Route::any(           'create', ['as' => $resource . '.create',     'uses' => $controller . 'create']);
    Route::get(        '{id}/view', ['as' => $resource . '.view' ,      'uses' => $controller . 'view'   ]);
    Route::any(         '{id}/edit', ['as' => $resource . '.edit',          'uses' => $controller . 'edit']);
    Route::any(         '{id}/quota', ['as' => $resource . '.add-quota',          'uses' => $controller . 'addQuota']);
//    Route::delete(          '{id}', ['as' => $resource . '.destroy',    'uses' => $controller . 'destroy']);
});
