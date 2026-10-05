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
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->renderable(function (\Spatie\Permission\Exceptions\UnauthorizedException $e, $request) {
            if (auth()->check()) {
                \App\Models\AccessViolationLog::create([
                    'user_id' => auth()->id(),
                    'user_email' => auth()->user()->email,
                    'attempted_url' => $request->fullUrl(),
                    'route_name' => $request->route() ? $request->route()->getName() : null,
                    'required_permission' => implode(', ', $e->getRequiredPermissions()),
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->header('User-Agent'),
                    'status' => 'flagged',
                ]);
            }
        });
    })->create();