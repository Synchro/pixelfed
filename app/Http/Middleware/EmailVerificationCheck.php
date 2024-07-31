<?php

namespace App\Http\Middleware;

use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;
use Closure;

class EmailVerificationCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user() &&
            config('pixelfed.enforce_email_verification') &&
            is_null($request->user()->email_verified_at) &&
            ! $request->is(
                'i/auth/*',
                'i/verify-email*',
                'log*',
                'site*',
                'i/confirm-email/*',
                'settings/home',
                'settings/email'
            )
        ) {
            return redirect('/i/verify-email');
        }

        return $next($request);
    }
}
