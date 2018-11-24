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
            'topbar'                  => 'assets/images/global/top-bar.css',
            'game'                    => 'assets/images/game/game.css?0624',
            'ucenter'                 => 'assets/images/ucenter/ucenter.css',
            'login'                   => 'assets/images/login/login.css',
            'reg'                     => 'assets/images/reg/reg.css',
            'chart'                   => 'assets/images/chart/chart.css',

            'findpassword'            => 'assets/images/findpassword/findpassword.css',

            //首页
            'index'                   => 'assets/images/index/index.css',
            //预约成为总代
            'merchants'               => 'events/reserve_agent/images/merchants.css',

            // 骰宝版
            'jquery.jscrollpane'      => 'assets/images/gamedice/jquery.jscrollpane.css',
            'gamedice'                => 'assets/images/gamedice/game.css',
            'k3-dice'                 => 'assets/images/gamedice/k3/k3.css',
            'nssc-dice'               => 'assets/images/gamedice/nssc/nssc.css',
        ),

        // 'jsAliases'  => array(  //  脚本文件别名配置
        //     //工具
        //     'jquery-1.9.1'             => 'assets/js-min/jquery-1.9.1.min.js',
        //     'jquery.min.map'           => 'assets/js-min/jquery.min.map.js',
        //     'jquery.easing.1.3'        => 'assets/js-min/jquery.easing.1.3.js',
        //     'jquery.tmpl'              => 'assets/js-min/jquery.tmpl.min.js',
        //     'jquery.mousewheel'        => 'assets/js-min/jquery.mousewheel.min.js',
        //     'jquery.jscrollpane'       => 'assets/js-min/jquery.jscrollpane.js',
        //     'jquery.cookie'            => 'assets/js-min/jquery.cookie.js',
        //     'IE-excanvas'              => 'assets/js-min/excanvas.js',
        //     'jquery.animateNumber.min' => 'assets/js-min/jquery.animateNumber.min.js',
        //     'jquery.inview.min'        => 'assets/js-min/jquery.inview.min.js',
        //     'jquery.longclick'         => 'assets/js-min/jquery.longclick.min.js',
        //     'jquery-ui-custom'         => 'assets/js-min/jquery-ui-custom.min.js',
        //     //组件
        //     'dsgame.base'               => 'assets/js-min/dsgame.base.js',
        //     'dsgame.Tab'                => 'assets/js-min/dsgame.Tab.js',
        //     'dsgame.Slider'             => 'assets/js-min/dsgame.Slider.js',
        //     'dsgame.Hover'              => 'assets/js-min/dsgame.Hover.js',
        //     'dsgame.Select'             => 'assets/js-min/dsgame.Select.js',
        //     'dsgame.Timer'              => 'assets/js-min/dsgame.Timer.js',
        //     'dsgame.Mask'               => 'assets/js-min/dsgame.Mask.js',
        //     'dsgame.MiniWindow'         => 'assets/js-min/dsgame.MiniWindow.js',
        //     'dsgame.Tip'                => 'assets/js-min/dsgame.Tip.js',
        //     'dsgame.Message'            => 'assets/js-min/dsgame.Message.js',
        //     'dsgame.DatePicker'         => 'assets/js-min/dsgame.DatePicker.js',
        //     'dsgame.Ernie'              => 'assets/js-min/dsgame.Ernie.js',
        //     'dsgame.SliderBar'          => 'assets/js-min/dsgame.SliderBar.js',
        //     'dsgame.Alive'              => 'assets/js-min/dsgame.Alive.js',
        //     'dsgame.Countdown'          => 'assets/js-min/dsgame.Countdown.js',

        //     //游戏类
        //     'dsgame.Games'              => 'assets/js-min/dsgame.Games.js', //游戏命名空间
        //     'dsgame.Game'               => 'assets/js-min/dsgame.Game.js', //游戏基类
        //     'dsgame.GameMethod'         => 'assets/js-min/dsgame.GameMethod.js', //玩法基类
        //     'dsgame.GameMessage'        => 'assets/js-min/dsgame.GameMessage.js', //游戏消息基类
        //     'dsgame.GameTypes'          => 'assets/js-min/dsgame.GameTypes.js', //玩法分类(静态类)
        //     'dsgame.GameStatistics'     => 'assets/js-min/dsgame.GameStatistics.js', //选球统计(静态类)
        //     'dsgame.GameOrder'          => 'assets/js-min/dsgame.GameOrder.js', //号码栏订单(静态类)
        //     'dsgame.GameTrace'          => 'assets/js-min/dsgame.GameTrace.js', //追号(静态类)
        //     'dsgame.GameSubmit'         => 'assets/js-min/dsgame.GameSubmit.js', //提交(静态类)
        //     'dsgame.GameRecords'        => 'assets/js-min/dsgame.GameRecords.js', //Records(静态类)

        //     //彩种初始化
        //     'dsgame.Games.SSC.config'  => 'assets/js-min/dsgame.Games.SSC.config.js',
        //     'dsgame.Games.L115.config'  => 'assets/js-min/dsgame.Games.L115.config.js',
        //     'dsgame.Games.K3.config'    => 'assets/js-min/dsgame.Games.K3.config.js',

        //     //时时彩游戏
        //     'dsgame.Games.SSC'          => 'assets/js-min/dsgame.Games.SSC.js', //时时彩游戏类
        //     'dsgame.Games.SSC.Danshi'   => 'assets/js-min/dsgame.Games.SSC.Danshi.js', //时时彩单式类
        //     'dsgame.Games.SSC.Message'  => 'assets/js-min/dsgame.Games.SSC.Message.js', //时时彩游戏类

        //     //L115 Game
        //     'dsgame.Games.L115'         => 'assets/js-min/dsgame.Games.L115.js', //L115游戏类
        //     'dsgame.Games.L115.Danshi'  => 'assets/js-min/dsgame.Games.L115.Danshi.js', //L115单式类 danshi
        //     'dsgame.Games.L115.Message' => 'assets/js-min/dsgame.Games.L115.Message.js', //L115游戏类 message

        //     //K3 Game
        //     'dsgame.Games.K3'           => 'assets/js-min/dsgame.Games.K3.js', //k3游戏类
        //     'dsgame.Games.K3.Danshi'    => 'assets/js-min/dsgame.Games.K3.Danshi.js', //k3单式类 danshi
        //     'dsgame.Games.K3.Message'   => 'assets/js-min/dsgame.Games.K3.Message.js', //k3游戏类 message


        //     'dsgame.GameChart'          => 'assets/js-min/dsgame.GameChart.js', // 时时彩走势图
        //     'dsgame.GameChart.Case'     => 'assets/js-min/dsgame.GameChart.case.js', // 时时彩走势图

        //     'dsgame.Games.SSC.init'     => 'assets/js-min/dsgame.Games.SSC.init.js', //时时彩页面行为js
        //     'dsgame.Games.L115.init'    => 'assets/js-min/dsgame.Games.L115.init.js', //L115页面行为js
        //     'dsgame.Games.K3.init'      => 'assets/js-min/dsgame.Games.K3.init.js', //k3页面行为js
        //     'dsgame.Games.K3Dice.inti'  => 'assets/js-min/dsgame.Games.K3.init.js',//骰宝

        //     //其他辅助
        //     'dsgame.U-groupgame'        => 'assets/js-min/dsgame.ucenter.groupgame.js',
        //     // 'functions'             => 'assets/js/functions.js',
        //     'ZeroClipboard'            => 'assets/js-min/ZeroClipboard.js',
        //     'loginSlides'              => 'assets/images/login/slides.js', //login-slides.js
        //     'md5'                      => 'assets/js-min/md5.js',

        //     // 'video' => 'assets/images/video/vcastr2/swfobject.js',

        //     //js 配置文件路劲
        //     'raphael-min'              =>'assets/js-min/raphael-min.js',
        //     'marquee-min'              =>'assets/js-min/jquery.marquee.min.js',

        //     //博狼娱乐js 配置文件路劲
        //     //工具类
        //     // 'jquery-1.11'              =>'assets/wc-js/jquery-1.11.0.min.js',
        //     'jquery.cycle2'            =>'assets/js-min/jquery.cycle2.min.js',
        //     'cycle2.scrollVert'        =>'assets/js-min/jquery.cycle2.scrollVert.min.js',
        //     'cycle2.carousel'          =>'assets/js-min/jquery.cycle2.carousel.min.js',


        //     //辅助
        //     'global'                    =>'assets/js-min/global.js',


        //     //活动相关
        //     //辛运猫-Date:2014-11-18
        //     // 'jquery.kxbdMarquee'       => 'events/xinyunmao/images/jquery.kxbdMarquee.js',
        //     //预约成为总代
        //     'swfobject'                => 'events/reserve_agent/images/vcastr2/swfobject.js',

        // ),
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
            'jquery.animateNumber.min' => 'assets/js/jquery.animateNumber.min.js',
            'jquery.inview.min'        => 'assets/js/jquery.inview.min.js',
            'jquery.longclick'         => 'assets/js/jquery.longclick.min.js',
            'jquery-ui-custom'         => 'assets/js/jquery-ui-custom.min.js',
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
            'dsgame.Alive'              => 'assets/js/dsgame.Alive.js',
            'dsgame.Countdown'          => 'assets/js/dsgame.Countdown.js',

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

            // 游戏类压缩合并版，包括上面前九个
            'dsgame.Gamesall.min'       => 'assets/js-dist/game/dsgame.game.min.js',

            'dsgame.Games.ssc.min'      => 'assets/js-dist/game/dsgame.game-ssc.min.js',
            'dsgame.Games.l115.min'     => 'assets/js-dist/game/dsgame.game-l115.min.js',
            'dsgame.Games.k3.min'       => 'assets/js-dist/game/dsgame.game-k3.min.js',
            'dsgame.Games.pk10.min'       => 'assets/js-dist/game/dsgame.game-pk10.min.js',
            'dsgame.Games.nssc.min'     => 'assets/js-dist/game/dsgame.game-nssc.min.js',

            //彩种初始化
             'dsgame.Games.SSC.config'      => 'assets/js/game/ssc/dsgame.Games.SSC.config.js',
            // 'dsgame.Games.L115.config'     => 'assets/js/game/l115/dsgame.Games.L115.config.js',
            // 'dsgame.Games.K3.config'       => 'assets/js/game/k3/dsgame.Games.K3.config.js',
            // 'dsgame.Games.NSSC.config'     => 'assets/js/game/nssc/dsgame.Games.NSSC.config.js',

            //时时彩游戏
             'dsgame.Games.SSC'          => 'assets/js/game/ssc/dsgame.Games.SSC.js', //时时彩游戏类
             'dsgame.Games.SSC.Danshi'   => 'assets/js/game/ssc/dsgame.Games.SSC.Danshi.js', //时时彩单式类
             'dsgame.Games.SSC.Message'  => 'assets/js/game/ssc/dsgame.Games.SSC.Message.js', //时时彩游戏类

            //L115 Game
            // 'dsgame.Games.L115'         => 'assets/js/game/l115/dsgame.Games.L115.js', //L115游戏类
            // 'dsgame.Games.L115.Danshi'  => 'assets/js/game/l115/dsgame.Games.L115.Danshi.js', //L115单式类 danshi
            // 'dsgame.Games.L115.Message' => 'assets/js/game/l115/dsgame.Games.L115.Message.js', //L115游戏类 message

            //K3 Game
            // 'dsgame.Games.K3'           => 'assets/js/game/k3/dsgame.Games.K3.js', //k3游戏类
            // 'dsgame.Games.K3.Danshi'    => 'assets/js/game/k3/dsgame.Games.K3.Danshi.js', //k3单式类 danshi
            // 'dsgame.Games.K3.Message'   => 'assets/js/game/k3/dsgame.Games.K3.Message.js', //k3游戏类 message

            // NSSC
            // 'dsgame.Games.NSSC'           => 'assets/js/game/nssc/dsgame.Games.NSSC.js', //新时时彩游戏类
            // 'dsgame.Games.NSSC.Danshi'    => 'assets/js/game/nssc/dsgame.Games.NSSC.Danshi.js', //新时时彩单式类 danshi
            // 'dsgame.Games.NSSC.Message'   => 'assets/js/game/nssc/dsgame.Games.NSSC.Message.js', //新时时彩游戏类 message

             'dsgame.Games.SSC.init'     => 'assets/js/game/ssc/dsgame.Games.SSC.init.js', //时时彩页面行为js
            // 'dsgame.Games.L115.init'    => 'assets/js/game/l115/dsgame.Games.L115.init.js', //L115页面行为js
            // 'dsgame.Games.K3.init'      => 'assets/js/game/k3/dsgame.Games.K3.init.js',//K3
            // 'dsgame.Games.NSSC.init'    => 'assets/js/game/nssc/dsgame.Games.NSSC.init.js',//新时时彩


            // 'dsgame.Gamedices.Config'    => 'assets/js/gamedice/dsgame.Gamedices.config.js', //骰宝配置类
            // 'dsgame.Gamedices.Gamedice'  => 'assets/js/gamedice/dsgame.Gamedices.gamedice.js', //骰宝游戏类
            // 'dsgame.Gamedices.Utils'     => 'assets/js/gamedice/dsgame.Gamedices.utils.js', //骰宝插件类
            // 'dsgame.Gamedices.Bootstrap' => 'assets/js/gamedice/dsgame.Gamedices.bootstrap.js', //骰宝启动脚本


            'dsgame.GameChart'          => 'assets/js/game/dsgame.GameChart.js', // 时时彩走势图
            'dsgame.GameChart.Case'     => 'assets/js/game/dsgame.GameChart.case.js', // 时时彩走势图


            // GAME DICE
            'dsgame.Gamedices'             => 'assets/js-dist/gamedice/dsgame.gamedice.min.js',
            // k3-dice
            'dsgame.Gamedices.K3.Config'   => 'assets/js-dist/gamedice/k3/dsgame.Gamedices.k3.config.min.js',
            // nssc-dice
            'dsgame.Gamedices.NSSC.Config' => 'assets/js-dist/gamedice/nssc/dsgame.Gamedices.nssc.config.min.js',

            /*// GAME DICE
            'dsgame.Gamedices'             => 'assets/js/gamedice/dsgame.gamedice.src.js',
            // k3-dice
            'dsgame.Gamedices.K3.Config'   => 'assets/js/gamedice/k3/dsgame.Gamedices.k3.config.js',
            // nssc-dice
            'dsgame.Gamedices.NSSC.Config' => 'assets/js/gamedice/nssc/dsgame.Gamedices.nssc.config.js',*/


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

            //博狼娱乐js 配置文件路劲
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