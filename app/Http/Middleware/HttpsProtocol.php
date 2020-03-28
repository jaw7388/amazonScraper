<?php

namespace App\Http\Middleware;
use Closure;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\App;

class HttpsProtocol
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
            if (!$request->secure() && App::environment() === 'production') {
                URL::forceScheme('https');
            }

            return $next($request); 
    }
}
