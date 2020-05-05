<?php

namespace App\Http\Middleware;

use Closure;
use Sentinel;

class AdminCMS
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
        $getUser = Sentinel::getUser();
        if (!$getUser) {
            toastr()->error('AUTHENTICATION REQUIRED!');
            return redirect("auth/login");
        }
        return $next($request);
    }
}
