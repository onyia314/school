<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Closure;

class CheckAdminOrMaster
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user(); //get the authenticated user instance

        if( ($user->role == 'admin') ||  ($user->role == 'master') ){
            return $next($request);
        }

        return redirect('home');
    }

}
