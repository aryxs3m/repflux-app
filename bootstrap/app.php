<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Validation\UnauthorizedException;
use Illuminate\Validation\ValidationException;
use Sentry\Laravel\Integration;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->trustProxies(at: '*');
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->reportable(fn (Throwable $throwable) => Integration::captureUnhandledException($throwable));

        if (request()->is('api/*')) {
            $exceptions->renderable(function (Throwable $throwable) {
                $code = 500;

                if ($throwable instanceof ValidationException) {
                    $code = 400;
                }

                if ($throwable instanceof UnauthorizedException) {
                    $code = 401;
                }

                return response()->json([
                    'error' => class_basename(get_class($throwable)),
                    'message' => $throwable->getMessage()
                ], $code);
            });
        }
    })->create();
