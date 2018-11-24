<?php

return array(

    'debug' => true,

    'url' => 'http://localhost',

    'timezone' => 'Asia/Shanghai',

    //    'locale' => 'en',
    'locale' => 'zh-CN',

    'fallback_locale' => 'en',

    'key' => 'Tezkdj3gPqXKyX9TWsJ0FGXaAGUhvuK5',

    'providers' => array(

        'Illuminate\Foundation\Providers\ArtisanServiceProvider',
        // 'Illuminate\Auth\AuthServiceProvider', // to use 'Ollieread\Multiauth\MultiauthServiceProvider'
        // 'Illuminate\Cache\CacheServiceProvider', // to use 'MongoCache\CacheServiceProvider'
        'Illuminate\Session\CommandsServiceProvider',
        'Illuminate\Foundation\Providers\ConsoleSupportServiceProvider',
        'Illuminate\Routing\ControllerServiceProvider',
        'Illuminate\Cookie\CookieServiceProvider',
        'Illuminate\Database\DatabaseServiceProvider',
        'Illuminate\Encryption\EncryptionServiceProvider',
        'Illuminate\Filesystem\FilesystemServiceProvider',
        'Illuminate\Hashing\HashServiceProvider',
        'Illuminate\Html\HtmlServiceProvider',
        'Illuminate\Log\LogServiceProvider',
        'Illuminate\Mail\MailServiceProvider',
        'Illuminate\Database\MigrationServiceProvider',
        'Illuminate\Pagination\PaginationServiceProvider',
        'Illuminate\Queue\QueueServiceProvider',
        'Illuminate\Redis\RedisServiceProvider',
        'Illuminate\Remote\RemoteServiceProvider',
        // 'Illuminate\Auth\Reminders\ReminderServiceProvider', // to use 'Ollieread\Multiauth\Reminders\ReminderServiceProvider'
        'Illuminate\Database\SeedServiceProvider',
        'Illuminate\Session\SessionServiceProvider',
        'Illuminate\Translation\TranslationServiceProvider',
        'Illuminate\Validation\ValidationServiceProvider',
        'Illuminate\View\ViewServiceProvider',
        'Illuminate\Workbench\WorkbenchServiceProvider',

        'Ollieread\Multiauth\MultiauthServiceProvider',
        'Ollieread\Multiauth\Reminders\ReminderServiceProvider',

        // 'Barryvdh\Debugbar\ServiceProvider',
        'Intervention\Image\ImageServiceProvider',
        'Johntaa\Captcha\CaptchaServiceProvider',
        // 'Baum\BaumServiceProvider',

        'Digithis\Activehelper\ActivehelperServiceProvider',
        'LMongo\LMongoServiceProvider',
        'MongoCache\CacheServiceProvider',
        // 'Jenssegers\Mongodb\MongodbServiceProvider',
        // 'Barryvdh\Debugbar\ServiceProvider', // laravel调试工具栏
        'App\Extension\Validation\ValidationServiceProvider', // 自定义验证规则

    ),

    /*
    |--------------------------------------------------------------------------
    | Service Provider Manifest
    |--------------------------------------------------------------------------
    |
    | The service provider manifest is used by Laravel to lazy load service
    | providers which are not needed for each request, as well to keep a
    | list of all of the services. Here, you may set its storage spot.
    |
    */

    'manifest' => storage_path().'/meta',

    /*
    |--------------------------------------------------------------------------
    | Class Aliases
    |--------------------------------------------------------------------------
    |
    | This array of class aliases will be registered when this application
    | is started. However, feel free to register as many as you wish as
    | the aliases are "lazy" loaded so they don't hinder performance.
    |
    */

    'aliases' => array(

        'App'             => 'Illuminate\Support\Facades\App',
        'Artisan'         => 'Illuminate\Support\Facades\Artisan',
        'Auth'            => 'Illuminate\Support\Facades\Auth',
        'Blade'           => 'Illuminate\Support\Facades\Blade',
        'Cache'           => 'Illuminate\Support\Facades\Cache',
        'ClassLoader'     => 'Illuminate\Support\ClassLoader',
        'Config'          => 'Illuminate\Support\Facades\Config',
        'Controller'      => 'Illuminate\Routing\Controller',
        'Cookie'          => 'Illuminate\Support\Facades\Cookie',
        'Crypt'           => 'Illuminate\Support\Facades\Crypt',
        'DB'              => 'Illuminate\Support\Facades\DB',
        'Eloquent'        => 'Illuminate\Database\Eloquent\Model',
        'Event'           => 'Illuminate\Support\Facades\Event',
        'File'            => 'Illuminate\Support\Facades\File',
        'Form'            => 'Illuminate\Support\Facades\Form',
        'Hash'            => 'Illuminate\Support\Facades\Hash',
        'HTML'            => 'Illuminate\Support\Facades\HTML',
        'Input'           => 'Illuminate\Support\Facades\Input',
        'Lang'            => 'Illuminate\Support\Facades\Lang',
        'Log'             => 'Illuminate\Support\Facades\Log',
        'Mail'            => 'Illuminate\Support\Facades\Mail',
        'Paginator'       => 'Illuminate\Support\Facades\Paginator',
        'Password'        => 'Illuminate\Support\Facades\Password',
        'Queue'           => 'Illuminate\Support\Facades\Queue',
        'Redirect'        => 'Illuminate\Support\Facades\Redirect',
        'Redis'           => 'Illuminate\Support\Facades\Redis',
        'Request'         => 'Illuminate\Support\Facades\Request',
        'Response'        => 'Illuminate\Support\Facades\Response',
        'Route'           => 'Illuminate\Support\Facades\Route',
        'Schema'          => 'Illuminate\Support\Facades\Schema',
        'Seeder'          => 'Illuminate\Database\Seeder',
        'Session'         => 'Illuminate\Support\Facades\Session',
        'SSH'             => 'Illuminate\Support\Facades\SSH',
        'Str'             => 'Illuminate\Support\Str',
        'URL'             => 'Illuminate\Support\Facades\URL',
        'Validator'       => 'Illuminate\Support\Facades\Validator',
        'View'            => 'Illuminate\Support\Facades\View',

        'Carbon'          => 'Carbon\Carbon',
        'Image'           => 'Intervention\Image\Facades\Image',
        'Identicon'       => 'Identicon\Identicon',
        'Captcha'         => 'Johntaa\Captcha\Facades\Captcha',
        'Active'          => 'Digithis\Activehelper\ActiveFacade',
        'LMongo'          => 'LMongo\Facades\LMongo',
        'EloquentMongo'   => 'LMongo\Eloquent\Model',

    ),

);
