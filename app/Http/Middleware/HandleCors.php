<?php

namespace App\Http\Middleware;

use Closure;

class HandleCors
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
        // --- omitted
    
        // Handle the request
        $response = $next($request); // <--- if you die here
    
        if ($request->getMethod() === 'OPTIONS') {
            $this->cors->varyHeader($response, 'Access-Control-Request-Method');
        }
        
        // you will never reach here
        return $this->addHeaders($request, $response);
    }
}
