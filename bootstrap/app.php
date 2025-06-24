<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Register middleware to the 'web' group (global web middleware)
        $middleware->web(append: [
            \App\Http\Middleware\SetLocale::class, // Your custom locale middleware
            // Add any other global web middleware here
        ]);

        // Register route middleware aliases
        $middleware->alias([
            'check.profile' => \App\Http\Middleware\CheckProfile::class, // Your custom profile check middleware
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class, // Spatie role middleware
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class, // Spatie permission middleware
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class, // Spatie role or permission middleware
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
