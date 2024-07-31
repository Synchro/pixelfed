<?php

use App\Providers\AppServiceProvider;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withProviders()
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        channels: __DIR__.'/../routes/channels.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->redirectGuestsTo(fn () => route('login'));
        $middleware->redirectUsersTo(AppServiceProvider::HOME);

        $middleware->validateCsrfTokens(except: [
            '/api/v1/*',
        ]);

        $middleware->append(\Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class);

        $middleware->web([
            \App\Http\Middleware\FrameGuard::class,
            \Illuminate\Session\Middleware\AuthenticateSession::class,
            \Laravel\Passport\Http\Middleware\CreateFreshApiToken::class,
        ]);

        $middleware->alias([
            'admin' => \App\Http\Middleware\Admin::class,
            'api.admin' => \App\Http\Middleware\Api\Admin::class,
            'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
            'dangerzone' => \App\Http\Middleware\DangerZone::class,
            'interstitial' => \App\Http\Middleware\AccountInterstitial::class,
            'localization' => \App\Http\Middleware\Localization::class,
            'scope' => \Laravel\Passport\Http\Middleware\CheckForAnyScope::class,
            'scopes' => \Laravel\Passport\Http\Middleware\CheckScopes::class,
            'twofactor' => \App\Http\Middleware\TwoFactorAuth::class,
            'validemail' => \App\Http\Middleware\EmailVerificationCheck::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
