<?php

namespace App\Http\Middleware;

use App\users;
use Illuminate\Support\Facades\Session;
use Closure;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class CekRole
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
         $username = strtolower($request->username) ;
         $user =  DB::table("users")->where('username',"=",$username)->first();
         $password = $request->password;

         if($user){
            if(Hash::check($password,$user->password)){
                if ($user->role == 'admin') {
                    $id =DB::table('admin_table')
                    ->where('users_id','LIKE','%'.$user->id.'%')
                    ->first();

                    Session::put('username',$username);
                    Session::put('id_user',$user->id);
                    Session::put('id_admin',$id->id);
                    Session::put('role',$user->role);
                    Session::put('login',TRUE);

                    return $next($request);
                    

                } elseif ($user->role == 'member') {
                    $idm =DB::table('member_table')
                    ->where('users_id','LIKE','%'.$user->id.'%')
                    ->first();

                    Session::put('id_user',$user->id);
                    Session::put('username',$username);
                    Session::put('id_member',$idm->id);
                    Session::put('role',$user->role);
                    Session::put('login',TRUE);

                    return $next($request);

                }else{
                    return redirect('/login')->with('alert','Data Tidak Ditemukan');
                }

           }else{
               return redirect('/login')->with('alert','Password atau Username Salah!');
           }
       }else {
           return redirect('/login')->with('alert','Data Tidak Ditemukan');
       }

         return $next($request);
     }
}
