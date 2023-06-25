<?php

namespace App\Http\Middleware;

use Closure;

class ApplicantMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = 'applicant')
    {
        if(!auth()->guard($guard)->check()) {
            return redirect('/customer/login');
        }
        

        return $next($request);
    }
}

