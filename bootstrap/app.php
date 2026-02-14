<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\RoleMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )

    // ✅ ENREGISTREMENT DES MIDDLEWARES
    ->withMiddleware(function (Middleware $middleware): void {

        // Alias de middleware (équivalent de $routeMiddleware)
        $middleware->alias([
            'role' => RoleMiddleware::class,
        ]);

    })

    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })

    ->create();
