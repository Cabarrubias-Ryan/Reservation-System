<?php

use App\Http\Middleware\ValidateUser;
use Illuminate\Foundation\Application;
use App\Http\Middleware\RoleMiddleware;
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
        'user-access' => ValidateUser::class,
        'role' => RoleMiddleware::class,
    ]);
  })
  ->withProviders([
      App\Providers\MenuServiceProvider::class, // <-- Add this line
  ])
  ->withExceptions(function (Exceptions $exceptions) {
    //
  })->create();
