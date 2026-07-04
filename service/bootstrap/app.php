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

        $middleware->alias([
            'role.check' => \App\Http\Middleware\CheckRole::class,
        ]);

        $middleware->redirectUsersTo(function () {
            if (auth()->check()) {
                return match(auth()->user()->role) {
                    'admin'        => '/admin/dashboard',
                    'prestataire'  => '/prestataire/dashboard',
                    default        => '/client/dashboard',
                };
            }
            return '/login';
        });

    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();