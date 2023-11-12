<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Classes\Config\AppConfig;

class Cors
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
        if ($request->getMethod() == 'OPTIONS') {
            return response('', 204);
        }

        $response = $next($request);
        $response->header('Access-Control-Allow-Methods', 'HEAD, GET, POST, PUT, PATCH, DELETE, OPTIONS');

        if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] == 'https://cifrado.com.co/') {
            $response->header('Access-Control-Allow-Origin', 'https://cifrado.com.co/');

            return $response;
        }

        $allowed = AppConfig::REFERRERS;
        $domains = implode(', ', $allowed);
        $response->header('Access-Control-Allow-Origin', $domains);
        if (isset($_SERVER['HTTP_REFERER'])) {
            if (! in_array($_SERVER['HTTP_REFERER'], $allowed)) {
                return response('Origin not allowed : '.$_SERVER['HTTP_REFERER'], 423);
            }
        } else {
            if (! in_array($_SERVER['SERVER_ADDR'], $allowed)) {
                return response('Origin not allowed : '.$_SERVER['SERVER_ADDR'], 423);
            }
        }

        return $response;
    }
}
