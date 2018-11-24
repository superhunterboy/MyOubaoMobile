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

        'cssAliases' => array(  //  样式文件别名配置

            'global'                  => 'assets/images/global/global.css',
            'game'                    => 'assets/images/game/game.css',
            'ucenter'                 => 'assets/images/ucenter/ucenter.css',
            'login'                   => 'assets/images/login/login.css',
            'reg'                     => 'assets/images/reg/reg.css',
            'chart'                   => 'assets/images/chart/chart.css',

            'findpassword'            => 'assets/images/findpassword/findpassword.css',

            //首页
            'index'                   => 'assets/images/index/index.css',
            //预约成为总代
            'merchants'               => 'events/reserve_agent/images/merchants.css',

        ),

        'jsAliases'  => array(  //  脚本文件别名配置
            //工具
            'jquery-1.9.1'             => 'assets/js/jquery-1.9.1.min.js',
            'jquery.min.map'           => 'assets/js/jquery.min.map.js',
            'jquery.easing.1.3'        => 'assets/js/jquery.easing.1.3.js',
            'jquery.tmpl'              => 'assets/js/jquery.tmpl.min.js',
            'jquery.mousewheel'        => 'assets/js/jquery.mousewheel.min.js',
            'jquery.jscrollpane'       => 'assets/js/jquery.jscrollpane.js',
            'jquery.cookie'            => 'assets/js/jquery.cookie.js',
            'IE-excanvas'              => 'assets/js/excanvas.js',
            //组件
            'dsgame.base'               => 'assets/js/dsgame.base.js',
            'dsgame.Tab'                => 'assets/js/dsgame.Tab.js',
            'dsgame.Slider'             => 'assets/js/dsgame.Slider.js',
            'dsgame.Hover'              => 'assets/js/dsgame.Hover.js',
            'dsgame.Select'             => 'assets/js/dsgame.Select.js',
            'dsgame.Timer'              => 'assets/js/dsgame.Timer.js',
            'dsgame.Mask'               => 'assets/js/dsgame.Mask.js',
            'dsgame.MiniWindow'         => 'assets/js/dsgame.MiniWindow.js',
            'dsgame.Tip'                => 'assets/js/dsgame.Tip.js',
            'dsgame.Message'            => 'assets/js/dsgame.Message.js',
            'dsgame.DatePicker'         => 'assets/js/dsgame.DatePicker.js',
            'dsgame.Ernie'              => 'assets/js/dsgame.Ernie.js',
            'dsgame.SliderBar'          => 'assets/js/dsgame.SliderBar.js',

            //游戏类
            'dsgame.Games'              => 'assets/js/game/dsgame.Games.js', //游戏命名空间
            'dsgame.Game'               => 'assets/js/game/dsgame.Game.js', //游戏基类
            'dsgame.GameMethod'         => 'assets/js/game/dsgame.GameMethod.js', //玩法基类
            'dsgame.GameMessage'        => 'assets/js/game/dsgame.GameMessage.js', //游戏消息基类
            'dsgame.GameTypes'          => 'assets/js/game/dsgame.GameTypes.js', //玩法分类(静态类)
            'dsgame.GameStatistics'     => 'assets/js/game/dsgame.GameStatistics.js', //选球统计(静态类)
            'dsgame.GameOrder'          => 'assets/js/game/dsgame.GameOrder.js', //号码栏订单(静态类)
            'dsgame.GameTrace'          => 'assets/js/game/dsgame.GameTrace.js', //追号(静态类)
            'dsgame.GameSubmit'         => 'assets/js/game/dsgame.GameSubmit.js', //提交(静态类)
            'dsgame.GameRecords'        => 'assets/js/game/dsgame.GameRecords.js', //Records(静态类)

            //彩种初始化
            'dsgame.Games.SSC.config'  => 'assets/js/game/ssc/dsgame.Games.SSC.config.js',
            'dsgame.Games.L115.config'  => 'assets/js/game/l115/dsgame.Games.L115.config.js',

            //时时彩游戏
            'dsgame.Games.SSC'          => 'assets/js/game/ssc/dsgame.Games.SSC.js', //时时彩游戏类
            'dsgame.Games.SSC.Danshi'   => 'assets/js/game/ssc/dsgame.Games.SSC.Danshi.js', //时时彩单式类
            'dsgame.Games.SSC.Message'  => 'assets/js/game/ssc/dsgame.Games.SSC.Message.js', //时时彩游戏类

            //L115 Game
            'dsgame.Games.L115'         => 'assets/js/game/l115/dsgame.Games.L115.js', //L115游戏类
            'dsgame.Games.L115.Danshi'  => 'assets/js/game/l115/dsgame.Games.L115.Danshi.js', //L115单式类 danshi
            'dsgame.Games.L115.Message' => 'assets/js/game/l115/dsgame.Games.L115.Message.js', //L115游戏类 message


            'dsgame.GameChart'          => 'assets/js/game/dsgame.GameChart.js', // 时时彩走势图
            'dsgame.GameChart.Case'     => 'assets/js/game/dsgame.GameChart.case.js', // 时时彩走势图

            'dsgame.Games.SSC.init'     => 'assets/js/game/ssc/dsgame.Games.SSC.init.js', //时时彩页面行为js
            'dsgame.Games.L115.init'     => 'assets/js/game/l115/dsgame.Games.L115.init.js', //L115页面行为js



            //其他辅助
            'dsgame.U-groupgame'        => 'assets/js/dsgame.ucenter.groupgame.js',
            // 'functions'             => 'assets/js/functions.js',
            'ZeroClipboard'            => 'assets/js/ZeroClipboard.js',
            'loginSlides'              => 'assets/images/login/slides.js', //login-slides.js
            'md5'                      => 'assets/js/md5.js',

            // 'video' => 'assets/images/video/vcastr2/swfobject.js',

            //js 配置文件路劲
            'raphael-min'              =>'assets/js/raphael-min.js',
            'marquee-min'              =>'assets/js/jquery.marquee.min.js',

            //CC彩票js 配置文件路劲
            //工具类
            // 'jquery-1.11'              =>'assets/wc-js/jquery-1.11.0.min.js',
            'jquery.cycle2'            =>'assets/js/jquery.cycle2.min.js',
            'cycle2.scrollVert'        =>'assets/js/jquery.cycle2.scrollVert.min.js',
            'cycle2.carousel'          =>'assets/js/jquery.cycle2.carousel.min.js',


            //辅助
            'global'                    =>'assets/js/global.js',


            //活动相关
            //辛运猫-Date:2014-11-18
            // 'jquery.kxbdMarquee'       => 'events/xinyunmao/images/jquery.kxbdMarquee.js',
            //预约成为总代
            'swfobject'                => 'events/reserve_agent/images/vcastr2/swfobject.js',

        ),

    ),

);