<?php

namespace App\Http\Controllers;

use App\users;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;


class Login extends Controller
{

    public function index()
    {

        if(Session::get('login')){
            return redirect('/');
        }
        return view('/login')->with('revalidateback','');
    }

    public function proses(Request $request)
    {
        if (Session::get('role')=='admin') {
            return redirect('/dashboardadmin')->with('success','Login Sebagai Admin');
        }elseif (Session::get('role')=='member') {
            return redirect('/dashboardmember')->with('success','Selamat Datang');
        }else {
            return redirect('/login');
        }
    }

   public function logoutproses()
   {

       Session::flush();
       return redirect("/login");
   }

}
