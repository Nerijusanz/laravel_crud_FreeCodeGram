<?php

namespace App\Http\Middleware;

use Closure;

class TestMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        /*
        // turn on/off middleware on Kernel.php
        //add into $midleware list:
        //\App\Http\Middleware\TestMiddleware::class //test middleware
        if( now()->format('s') % 2){
            return $next($request);
        }

        return response("TestMiddleware Not allowed");
        */

        return $next($request);
    }
}
