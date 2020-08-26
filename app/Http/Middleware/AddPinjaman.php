<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;

use Closure;

class AddPinjaman
{

    public function handle($request, Closure $next)
    {
        if (Session::get('role')!='admin') {
            abort(404);
        }else{
            return $next($request);
        }
    }


}
