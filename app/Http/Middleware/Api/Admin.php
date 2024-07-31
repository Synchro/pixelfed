<?php

namespace App\Http\Middleware\Api;

use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;
use Auth;
use Closure;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() == false || Auth::user()->is_admin == false) {
            return abort(403, 'You must be an administrator to do that');
        }

        return $next($request);
    }
}
