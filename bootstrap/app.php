<?php

use App\Helpers\AuditLogger;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\ApplySystemModes;
use App\Http\Middleware\EnsureSessionActivity;
use App\Http\Middleware\LogFailedHttpResponses;
use App\Http\Middleware\ValidateFormInput;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Session\Middleware\StartSession;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        channels: __DIR__.'/../routes/channels.php',
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'role' => \App\Http\Middleware\RoleMiddleware::class,
            'permission' => \App\Http\Middleware\PermissionMiddleware::class,
        ]);
    })
    ->withMiddleware(function ($middleware) {
        $middleware->append([
            EncryptCookies::class,
            AddQueuedCookiesToResponse::class,
            StartSession::class,
        ]);

        $middleware->web(append: [
            ValidateFormInput::class,
            ApplySystemModes::class,
            EnsureSessionActivity::class,
            LogFailedHttpResponses::class,
        ], remove: [
            EncryptCookies::class,
            AddQueuedCookiesToResponse::class,
            StartSession::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->respond(function ($response, \Throwable $exception, $request) {
            AuditLogger::logException($exception, 'system', $response->getStatusCode());

            return $response;
        });
    })
    ->create();
