<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IpAveSecure
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->getMethod() == 'GET') {
            return $next($request);
        }
        if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] == 'https://app.aveonline.co/') {
            return $next($request);
        }

        return response('Origin not allowed : '.$_SERVER['SERVER_ADDR'], 423);
    }
}
