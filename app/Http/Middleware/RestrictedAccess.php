<?php

namespace App\Http\Middleware;

use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;
use Closure;
use Illuminate\Support\Facades\Auth;

class RestrictedAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
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
