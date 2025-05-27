<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Aqui você registra seus middlewares globais

        // Adicione este código para registrar seus middlewares de rota
        $middleware->alias([
            'permission' => \App\Http\Middleware\CheckPermission::class,
            // outros aliases...
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
