<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function () {
            Route::prefix('api/auth')->name('api.auth')->group(function () {
                require base_path('app/Domains/Api/Auth/Routes/auth.php');
            });

            /* Route::middleware(['auth:api'])
            ->prefix('api')
            ->name('api')
            ->group(function () {
                
            }); */
        },
    )
    ->withMiddleware(function (Middleware $middleware) {

        $middleware->group('web', [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            \App\Http\Middleware\AuthGates::class,
            \App\Http\Middleware\RedirectIfInactive::class,
        ]);

        $middleware->group('api', [
            \Illuminate\Routing\Middleware\ThrottleRequests::class.':api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            \App\Http\Middleware\AuthGates::class,
            \App\Http\Middleware\CheckUserStatus::class,
        ]);

        $middleware->alias([
            'PreventBackHistory' =>\App\Http\Middleware\PreventBackHistory::class,
            'AuthGates' =>\App\Http\Middleware\AuthGates::class,
            // 'checkUserStatus' => \App\Http\Middleware\CheckUserStatus::class,
            // 'userinactive' => \App\Http\Middleware\RedirectIfInactive::class,
            // 'check.device' => \App\Http\Middleware\LogoutUserFromOtherDevice::class,
            // 'role' => \App\Http\Middleware\CheckRole::class,
            'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
