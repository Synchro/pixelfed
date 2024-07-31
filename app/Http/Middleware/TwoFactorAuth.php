<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TwoFactorAuth
{
    /**
     * Handle an incoming request.
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user()) {
            $user = $request->user();
            $enabled = (bool) $user->{'2fa_enabled'};
            if ($enabled != false) {
                $checkpoint = 'i/auth/checkpoint';
                if ($request->session()->has('2fa.session.active') !== true && ! $request->is($checkpoint) && ! $request->is('logout')) {
                    return redirect('/i/auth/checkpoint');
                } elseif ($request->session()->has('2fa.attempts') && (int) $request->session()->get('2fa.attempts') > 3) {
                    $request->session()->pull('2fa.attempts');
                    Auth::logout();
                }
            }
        }

        return $next($request);
    }
}
