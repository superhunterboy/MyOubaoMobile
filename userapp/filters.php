<?php

/*
  |--------------------------------------------------------------------------
  | 注册应用程序事件，执行顺序如下：
  |--------------------------------------------------------------------------
  |
  | 1.执行 应用程序事件   App::before   参数 $request
  | 2.执行 前置过滤器   Route::filter   参数 $route, $request
  |
  | 3.执行（之前注册进路由的）匿名回调函数或相应的控制器方法，并取得响应实例 $response
  |
  | 4.执行 后置过滤器   Route::filter   参数 $route, $request, $response
  | 5.执行 应用程序事件   App::after    参数 $request, $response
  |
  | 6.向客户端返回响应实例 $response
  |
  | 7.执行 应用程序事件   App::finish   参数 $request, $response
  | 8.执行 应用程序事件   App::shutdown 参数 $application
  |
 */

# App::before(function ($request) {});
# App::after(function ($request, $response) {});
# App::finish(function ($request, $response) {});
# App::shutdown(function($application) {});


/*
  |--------------------------------------------------------------------------
  | [前置] 过滤器
  |--------------------------------------------------------------------------
  # Route::filter('beforeFilter', function ($route, $request) {});
  |
 */
Route::filter('beforeFilter', function ($route, $request) {
//     if (Request::method() == 'GET' && str_contains(Route::currentRouteAction(), 'index') ) {
//         Session::put('curPage', Request::url());
//         Cookie::make('curPage', Request::url());
//     }
});

# CSRF保护过滤器，防止跨站点请求伪造攻击
Route::filter('csrf', function() {
    if (Request::getMethod() !== 'GET' && Session::token() != Input::get('_token'))
        throw new Illuminate\Session\TokenMismatchException;
});

# 必须是登录用户
Route::filter('user-auth', function () {
    if (isMobile()) {
        $domain = $_SERVER['SERVER_NAME'];
        $domain = 'http://' . str_replace('www', 'm', $domain);
        return Redirect::to($domain);
    }
    // 拦截未登录用户并记录当前 URL，跳转到登录页面
//    die(Session::get('user_id'));
    if (!Session::get('user_id')) {
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
            $iErrno = Config::get('global_error.ERRNO_LOGIN_EXPIRED');
            $oMessage = new Message(['system']);
            $oMessage->output(0, 'loginTimeout', $iErrno, $data);
//            $sMsg           = __(Config::get("errorcode/error-system.$iErrno"));
//            $aResponse            = [
//                'isSuccess' => 0,
//                'type'      => 'loginTimeout',
//                'msg'       => $sMsg,
//                'errno'     => abs($iErrno),
//                'data'      => [
//                    'tplData' => [
//                        'msg' => $sMsg,
//                    ]
//                ]
//            ];
//            echo json_encode($aResponse);
            exit;
        } else {
            Session::put('__returnUrl', Request::getRequestUri());
            return Redirect::route('signin');
        }
    }
});
# 只允许玩家访问
Route::filter('player', function () {
    if (!Session::get('is_player')) {
        return Redirect::to('/');
    }
});
# 只允许代理访问
Route::filter('agent', function () {
    if (!Session::get('is_agent')) {
        return Redirect::to('/');
    }
});

// # HTTP 基础身份验证过滤器 - 单次弹窗登录验证
// Route::filter('auth.basic', function () {
//     return Auth::basic();
// });
// # 必须是游客（较少应用）
Route::filter('guest', function () {
    // 拦截已登录用户
    if (Auth::admin()->check())
        return Redirect::to('/admin');
    else if (Auth::user()->check())
        return Redirect::to('/');
});

// # 禁止对自己的账号进行危险操作
Route::filter('not.admin.self', function ($route) {
    // 拦截自身用户 ID
    if (Auth::admin()->get()->id == $route->parameter('id'))
        return Redirect::back();
});
// # 禁止对自己的账号进行危险操作
Route::filter('not.user.self', function ($route) {
    // 拦截自身用户 ID
    if (Auth::user()->get()->id == $route->parameter('id'))
        return Redirect::back();
});

Route::filter('enabled-actions', function($route) {
    $ca = Route::currentRouteAction();
    $roleIds = Session::get('CurUserRole');
    if (!$roleIds || $roleIds == '') {
        App::make('AdminAuthorityController')->logout();
        // return Redirect::back()->with('error', '<strong>无法获取用户权限，请重新登录。</strong>');
    }
//    $roleIds = explode(',', $curUserRoles);
    $adminRoleId = Role::ADMIN;
    $data = App::make('BaseController')->getUserRights(2, true);
    $enabled = false;

    if (in_array($adminRoleId, $roleIds) || in_array($ca, $data))
        $enabled = true;
    if (!$enabled) {
        return Redirect::back()->with('error', '<strong>您没有没有权限执行或访问该页面。</strong>');
    }
});
Route::filter('ajax', function ($route) {
    if (!Request::ajax()) {
        App::abort(403);
    }
});
/*
  |--------------------------------------------------------------------------
  | [后置] 过滤器
  |--------------------------------------------------------------------------
  # Route::filter('afterFilter', function ($route, $request, $response) {});
  |
 */



/*
  |--------------------------------------------------------------------------
  | 事件监控
  |--------------------------------------------------------------------------
  |
 */
# 用户登录事件
Event::listen('auth.login', function () {
    // 记录最后登录时间
    if (Auth::admin()->check()) {
        $user = Auth::admin()->get();
    } else if (Auth::user()->check()) {
        $user = Auth::user()->get();
    }
    $user->signin_at = Carbon::now()->toDateTimeString();
    $user->save();
    // 后期可附加权限相关操作
    // ...
});
Event::listen('illuminate.query', function($query, $params, $time, $conn) {
    // dd(array($query, $params, $time, $conn));
    // \Log::sql($query."\n");
    // \Log::sql(json_encode($params)."\n");
});
# 用户退出事件
// Event::listen('auth.logout', function ($user) {
//     //
// });
//注册访问量过滤器
Route::filter('maxAccess', 'MaxAccessFilter');
