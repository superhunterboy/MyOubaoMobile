<?php

/*
  |--------------------------------------------------------------------------
  | 前台路由
  |--------------------------------------------------------------------------
 */

//未登录访问index
Route::any('index', ['as' => 'index', function() {
        if (isMobile()) {
            $domain = $_SERVER['SERVER_NAME'];
            $domain = 'http://' . str_replace('www', 'm', $domain);
            return Redirect::to($domain);
        }
        return Redirect::route('signin');
    }]);
#博狼娱乐宣传
//Route::any('about', ['as' => 'index', function() {
//        return View::make('brand.about');
//    }]);
//Route::any('ability', ['as' => 'index', function() {
//        return View::make('brand.ability');
//    }]);
//404 报错
Route::get('404', ['as' => '404', function () {
        return View::make('system.404');
    }]);
Route::get('403', ['as' => '403', function () {
        return View::make('system.403');
    }]);



# 帮助中心
Route::group(['prefix' => 'help'], function () {
    $resource = 'help';
    $controller = 'HelpController@';
    Route::get('/{category_id?}', ['as' => $resource . '.index', 'uses' => $controller . 'helpIndex']);
});



Route::group(['prefix' => 'auth'], function () {
    $Authority = 'AuthorityController@';
    # 退出
    Route::get('logout', ['as' => 'logout', 'uses' => $Authority . 'logout']);
    Route::group(['before' => 'guest'], function () use ($Authority) {
        # 登录
        Route::any('signin', ['as' => 'signin', 'uses' => $Authority . 'signin']);
        Route::any('signup', ['as' => 'signup', 'uses' => $Authority . 'signup']);
    });
    # 忘记密码
    Route::any('find-password', array('as' => 'find-password', 'uses' => $Authority . 'findPassword'));
    // # 密码重置
    // Route::get(  'forgot-password/{token}', array('as' => 'reset'         , 'uses' => $Authority.'getReset'));
    // Route::post( 'forgot-password/{token}', $Authority.'postReset');
});

Route::group(['before' => 'user-auth|csrf'], function () {
    $controller = 'HomeController@';
    # 博客首页
    Route::get('/home', ['as' => 'home', 'uses' => $controller . 'getIndex']);
    # include start #
    $sRouteDir = Config::get('route.root');
    $aRouteFiles = glob($sRouteDir . '*.php');
    foreach ($aRouteFiles as $sRouteFile) {
        include($sRouteFile);
    }
    unset($aRouteFiles);
});


// 投注
Route::group(['prefix' => 'bets'], function () {
    $resource = 'bets';
    Route::post('bet/{lottery_id?}', [ 'as' => $resource . '.bet', 'uses' => 'BetController@bet']);
    Route::get('/upload-bet-number', ['as' => $resource . '.upload-bet-number', function () {
            return View::make('centerGame.uploadBetNumber');
        }]);
    Route::post('/upload-bet-number', ['as' => $resource . '.upload-bet-number', 'uses' => function () {
            // pr(Input::all());exit;
//        if (Request::getMethod() !== 'GET' && Session::token() != Input::get('_token')){
//            die('请先登录');
//        }
            $aLimits = [
                'extension' => [ 'txt'],
                'mime_type' => [ 'text/plain'],
                'max_size' => 200 * 1024
            ];
            $aInputData = Input::all();
            $oFileInfo = $aInputData['betNumber'];
            in_array($oFileInfo->getClientOriginalExtension(), $aLimits['extension']) or die();
            in_array($oFileInfo->getClientMimeType(), $aLimits['mime_type']) or die();
            $oFileInfo->getClientSize() <= $aLimits['max_size'] or die();
            $rs = file_get_contents($oFileInfo->getPathName());
            echo '<script>(function(){var Games = window.parent.dsgame.Games,current = Games.getCurrentGame().getCurrentGameMethod(),data=' . json_encode($rs) . ';current.getFile(data)})()</script>';
            // pr($aInputData);exit;
            exit;
        }]);
        });

// 充值回调
        Route::group(['prefix' => 'depositapi'], function () {
            $resource = 'depositapi';
//            $controller = 'DepositNotifyController';
            Route::any('zf', ['as' => $resource . '.zf', 'uses' => "ZHIFUDepositNotifyController@doCallback"]);
            Route::any('ips', ['as' => $resource . '.ips', 'uses' => "IPSDepositNotifyController@doCallback"]);
            Route::any('xs', ['as' => $resource . '.xs', 'uses' => "XINSHENGDepositNotifyController@doCallback"]);
            Route::any('gfb', ['as' => $resource . '.gfb', 'uses' => "GUOFUBAODepositNotifyController@doCallback"]);
            Route::any('rf', ['as' => $resource . '.rf', 'uses' => "RFPAYDepositNotifyController@doCallback"]);
        });
        Route::group(['prefix' => 'dnotify'], function () {
            $resource = 'dnotify';
//            $controller = 'DepositNotifyController';
            Route::any('zf', ['as' => $resource . '.zf', 'uses' => "ZHIFUDepositNotifyController@doCallback"]);
            Route::any('ips', ['as' => $resource . '.ips', 'uses' => "IPSDepositNotifyController@doCallback"]);
            Route::any('xs', ['as' => $resource . '.xs', 'uses' => "XINSHENGDepositNotifyController@doCallback"]);
            Route::any('gfb', ['as' => $resource . '.gfb', 'uses' => "GUOFUBAODepositNotifyController@doCallback"]);
            Route::any('rf', ['as' => $resource . '.rf', 'uses' => "RFPAYDepositNotifyController@doCallback"]);
        });

//域名管理 登陆地址配置接口
        Route::group([], function () {
            $controller = 'DomainApiController@';
            Route::any('/domain-api/get-domains', ['as' => 'domain-api.get-domains', 'uses' => $controller . 'getDomains']);
            Route::any('/domain-api/get-software-info', ['as' => 'domain-api.get-software-info', 'uses' => $controller . 'getSoftwareInfo']);
        });

        Route::group([], function () {
            $sController = 'UserReserveAgentController@';
            Route::any('/reserve-agent/reserve', ['as' => 'reserve-agent.reserve', 'uses' => $sController . 'reserve']);
        });


        Route::group([], function () {
            $sController = 'UserReserveAgentController@';
            Route::any('/reserve-agent/reserve', ['as' => 'reserve-agent.reserve', 'uses' => $sController . 'reserve']);
        });
        