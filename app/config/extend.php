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
            'ui'                 => 'assets/cssnew/ui.css',
        ),

        'jsAliases'  => array(  //  脚本文件别名配置
            //框架
            'jquery'                => 'assets/js/jquery.1.11.2.js',
            'bootstrap'             => 'assets/js/bootstrap.min.js',
            'jquery-ui'             => 'assets/js/jquery-ui-1.10.3.custom.min.js',

            //工具
            'create-user-link'      => 'assets/js/create-user-link.js',
            'md5'                   => 'assets/js/md5.js',
            'ZeroClipboard'         => 'assets/js/ZeroClipboard.js',
                //文本编辑器
                'ueditor.config'        => 'assets/ueditor/ueditor.config.js',
                'ueditor.min'           => 'assets/ueditor/ueditor.all.min.js',
                'zh-cn'                 => 'assets/ueditor/lang/zh-cn/zh-cn.js',

            'numtochinese'          => 'assets/js/numtochinese.js',
            'datepicker'            => 'assets/js/datepicker.min.js',
            'switch'                => 'assets/js/switch.js',

            'dome'                  => 'assets/js/dome.js',


        ),

    ),

);