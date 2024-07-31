<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EmailVerificationCheck
{
    /**
     * Handle an incoming request.
     *
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
