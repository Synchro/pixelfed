<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RestrictedAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $guard = null): Response
    {
        if (config('instance.restricted.enabled')) {
            if (! Auth::guard($guard)->check()) {
                $p = ['login', 'password*', 'loginAs*'];
                if (! $request->is($p)) {
                    return redirect('/login');
                }
            }
        }

        return $next($request);
    }
}
