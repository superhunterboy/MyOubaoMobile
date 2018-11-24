<?php

/*
|--------------------------------------------------------------------------
| 拓展配置文件
|--------------------------------------------------------------------------
|
*/

return array(

  /**
   * 网站静态资源文件别名配置
   */
  'webAssets' => array(

    'cssAliases' => array(
      'third'   => 'assets/third/bootstrap/css/third.min.css',
      'game'    => 'assets/dist/css/game.min.css',
      'account' => 'assets/dist/css/account.min.css',
      'home'    => 'assets/dist/css/home.min.css',
      'login'   => 'assets/dist/css/login.min.css',
      'trend'   => 'assets/dist/css/trend.min.css',
      'ucenter' => 'assets/dist/css/ucenter.min.css',
      'download' => 'assets/dist/css/download.min.css',
    ),
    'jsAliases'  => array(
      'third'                   => 'assets/dist/js/third.min.js',
      'global'                  => 'assets/dist/js/global.min.js',
      'districts'               => 'assets/dist/js/districts.min.js', // 省市数据
      'md5'                     => 'assets/dist/js/md5.min.js',
      'betgame.Games.all'       => 'assets/dist/js/betgame.Games.all.min.js',
      'betgame.Games.bootstrap' => 'assets/dist/js/betgame.Games.bootstrap.min.js',

      'betgame.Games.SSC'       => 'assets/dist/js/betgame.Games.SSC.min.js',
      'betgame.Games.L115'      => 'assets/dist/js/betgame.Games.L115.min.js',
      'betgame.Games.K3'        => 'assets/dist/js/betgame.Games.K3.min.js',
      'betgame.Games.PK10'        => 'assets/dist/js/betgame.Games.PK10.min.js',
    ),

  ),

);
