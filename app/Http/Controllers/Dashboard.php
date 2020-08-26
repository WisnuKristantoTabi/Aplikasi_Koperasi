<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class Dashboard extends Controller
{
    public function admin()
    {
        $kas = DB::table('ukur')
        ->orderBy('tanggal', 'desc')
        ->select("tanggal","kas as saldo")
        ->paginate(5);

        $aktiva = DB::table('detail_perkiraan_table')
        ->select('jumlah_perkiraan')
        ->where('id','=',1)
        ->orWhere('id','=',2)
        ->get();

        return view('/layout/dashboardadmin',['kas'=>$kas,'aktiva'=>$aktiva]);
    }

    public function member()
    {
        $data = DB::table('ukur')
        ->orderBy('tanggal', 'desc')
        ->paginate(5);

        $bunga = DB::table('variabel_table')
        ->select('persen')
        ->where('id','=','9')
        ->first();



        return view('/layout/dashboardmember',['data'=>$data, 'bunga'=>$bunga]);

    }
}
