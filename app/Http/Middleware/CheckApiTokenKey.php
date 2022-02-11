<?php

namespace App\Http\Middleware;

use Closure;

class CheckApiTokenKey
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
        if($request->api_token!='MAGA_PAYMENT_TOKEN_0001'){
            return abort(403, 'Unauthorized action.');
        }
        return $next($request);
    }
}
