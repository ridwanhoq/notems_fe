<?php

use App\Exceptions\ApiException;
use App\Http\Middleware\EnsureAdmin;
use App\Http\Middleware\EnsureApiAuthenticated;
use App\Http\Middleware\RedirectIfApiAuthenticated;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'api.auth' => EnsureApiAuthenticated::class,
            'api.guest' => RedirectIfApiAuthenticated::class,
            'api.admin' => EnsureAdmin::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*') || $request->expectsJson(),
        );

        $exceptions->render(function (ApiException $e, Request $request) {
            if ($e->status === 401 && $request->session()->has('api_token')) {
                $request->session()->forget(['api_token', 'api_user']);

                return redirect()->route('login')->withErrors(['email' => 'Your session has expired. Please log in again.']);
            }

            if ($request->isMethod('GET')) {
                return response()->view('error', ['status' => $e->status, 'message' => $e->getMessage()], $e->status);
            }

            $errors = $e->errors ?: ['api' => $e->getMessage()];

            return back()->withInput($request->except('password'))->withErrors($errors);
        });
    })->create();
