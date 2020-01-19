<?php

namespace App\Http\Middleware;

use Closure;

class CheckAdminOrAccountant
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
        if( $request->user()->role == 'admin' || $request->user()->role == 'accountant'){
            return $next($request);
        }

        return redirect('home');
    }
}
