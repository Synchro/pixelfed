<?php

use Illuminate\Support\Facades\Facade;
use Illuminate\Support\ServiceProvider;

return [

    'short_description' => 'Pixelfed is an image sharing platform, an ethical alternative to centralized platforms.',

    'description' => 'Pixelfed is an image sharing platform, an ethical alternative to centralized platforms.',

    'rules' => null,

    'logo' => '/img/pixelfed-icon-color.svg',

    'banner_image' => '/storage/headers/default.jpg',

    'providers' => ServiceProvider::defaultProviders()->merge([
        /*
         * Laravel Framework Service Providers...
         */

        /*
         * Package Service Providers...
         */

        /*
         * Application Service Providers...
         */
        App\Providers\AppServiceProvider::class,
        App\Providers\AuthServiceProvider::class,
        App\Providers\BroadcastServiceProvider::class,
        App\Providers\HorizonServiceProvider::class,
        App\Providers\EventServiceProvider::class,
        App\Providers\RouteServiceProvider::class,
        // App\Providers\TelescopeServiceProvider::class,
        App\Providers\PassportServiceProvider::class,
    ])->toArray(),

    'aliases' => Facade::defaultAliases()->merge([
        'Captcha' => Buzz\LaravelHCaptcha\CaptchaFacade::class,
        'FFMpeg' => Pbmedia\LaravelFFMpeg\FFMpegFacade::class,
        'PrettyNumber' => App\Util\Lexer\PrettyNumber::class,
        'Purify' => Stevebauman\Purify\Facades\Purify::class,
        'Redis' => Illuminate\Support\Facades\Redis::class,
    ])->toArray(),

];
