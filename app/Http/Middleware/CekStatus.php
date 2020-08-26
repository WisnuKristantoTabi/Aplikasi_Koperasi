<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Session;
use Closure;


class CekStatus
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
        if (Session::get('role')!='admin') {
            return redirect(route('login'));
        }else{
            return $next($request);
        }
    }
}
