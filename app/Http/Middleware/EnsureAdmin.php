<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdmin
{
    // UI guard only; the API enforces the role on every admin endpoint.
    public function handle(Request $request, Closure $next): Response
    {
        abort_unless($request->session()->get('api_user.role') === 'admin', 403);

        return $next($request);
    }
}
