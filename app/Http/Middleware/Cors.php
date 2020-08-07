<?php

namespace App\Http\Middleware;

use Closure;

class Cors
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        dd($request->header("Authorization"));
        $response = $next($request);

        $response->headers->set('Authorization', 'Bearer '.$request->bearerToken());
        
        return $response;
    }
}
