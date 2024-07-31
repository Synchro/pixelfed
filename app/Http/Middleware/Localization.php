<?php

namespace App\Http\Middleware;

use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;
use Closure;
use Session;

class Localization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Session::has('locale')) {
            app()->setLocale(Session::get('locale'));
        }

        return $next($request);
    }
}
