<?php

//未登录访问index
Route::any(' download', ['as' => 'download', function() {
        return View::make('download');
    }]);

//未登录访问index
Route::any('index', ['as' => 'index', function() {
        if (Session::get('username')) {
            return Redirect::to(route('home'));
        } else {
            return View::make('authority.signin');
        }
    }]);


Route::group(['before' => 'mobile-auth|csrf'], function () {
    $controller = 'MobileHomeH5Controller@';
    # 首页
    Route::get('/home', ['as' => 'home', 'uses' => $controller . 'getIndex']);
    # include start #
    $sRouteDir = Config::get('route.root');
    $aRouteFiles = glob($sRouteDir . '*.php');
    foreach ($aRouteFiles as $sRouteFile) {
        include($sRouteFile);
    }
    unset($aRouteFiles);
});

Route::group(['prefix' => 'mobile-auth'], function () {
    $Authority = 'MobileAuthorityH5Controller@';
    # 退出
    Route::get('logout', ['as' => 'mobile-auth.logout', 'uses' => $Authority . 'logout']);
    # 登录
    Route::any('login', ['as' => 'mobile-auth.login', 'uses' => $Authority . 'signin']);
    Route::any('register', ['as' => 'mobile-auth.register', 'uses' => $Authority . 'register']);
    
    # 忘记密码
    Route::any('find-password', array('as' => 'find-password', 'uses' => $Authority . 'findPassword'));
});

        Route::group(['prefix' => 'depositapi'], function () {
            $resource = 'depositapi';
//            $controller = 'DepositNotifyController';
            Route::any('zf', ['as' => $resource . '.zf', 'uses' => "ZHIFUDepositNotifyController@doCallback"]);
            Route::any('ips', ['as' => $resource . '.ips', 'uses' => "IPSDepositNotifyController@doCallback"]);
            Route::any('xs', ['as' => $resource . '.xs', 'uses' => "XINSHENGDepositNotifyController@doCallback"]);
            Route::any('gfb', ['as' => $resource . '.gfb', 'uses' => "GUOFUBAODepositNotifyController@doCallback"]);
            Route::any('gfbwap', ['as' => $resource . '.gfbwap', 'uses' => "GUOFUBAOWAPDepositNotifyController@doCallback"]);
            Route::any('rf', ['as' => $resource . '.rf', 'uses' => "RFPAYDepositNotifyController@doCallback"]);
            Route::any('th', ['as' => $resource . '.th', 'uses' => "TONGHUIDepositNotifyController@doCallback"]);
            Route::any('thwy', ['as' => $resource . '.thwy', 'uses' => "TONGHUIWYDepositNotifyController@doCallback"]);
            Route::any('thzfb', ['as' => $resource . '.thzfb', 'uses' => "TONGHUIZFBDepositNotifyController@doCallback"]);
            Route::any('thwxpc', ['as' => $resource . '.thwxpc', 'uses' => "TONGHUIWXPCDepositNotifyController@doCallback"]);
        });
        Route::group(['prefix' => 'dnotify'], function () {
            $resource = 'dnotify';
//            $controller = 'DepositNotifyController';
            Route::any('zf', ['as' => $resource . '.zf', 'uses' => "ZHIFUDepositNotifyController@doCallback"]);
            Route::any('ips', ['as' => $resource . '.ips', 'uses' => "IPSDepositNotifyController@doCallback"]);
            Route::any('xs', ['as' => $resource . '.xs', 'uses' => "XINSHENGDepositNotifyController@doCallback"]);
            Route::any('gfbwap', ['as' => $resource . '.gfbwap', 'uses' => "GUOFUBAOWAPDepositNotifyController@doCallback"]);
            Route::any('gfb', ['as' => $resource . '.gfb', 'uses' => "GUOFUBAODepositNotifyController@doCallback"]);
            Route::any('rf', ['as' => $resource . '.rf', 'uses' => "RFPAYDepositNotifyController@doCallback"]);
            Route::any('th', ['as' => $resource . '.th', 'uses' => "TONGHUIDepositNotifyController@doCallback"]);
            Route::any('thwy', ['as' => $resource . '.thwy', 'uses' => "TONGHUIWYDepositNotifyController@doCallback"]);
            Route::any('thzfb', ['as' => $resource . '.thzfb', 'uses' => "TONGHUIZFBDepositNotifyController@doCallback"]);
            Route::any('thwxpc', ['as' => $resource . '.thwxpc', 'uses' => "TONGHUIWXPCDepositNotifyController@doCallback"]);
        });

// 投注
Route::group(['prefix' => 'bets'], function () {
    $resource = 'mobile-bets';
    Route::post('bet/{lottery_id?}', [ 'as' => $resource . '.bet', 'uses' => 'MobileBetController@bet']);
});
