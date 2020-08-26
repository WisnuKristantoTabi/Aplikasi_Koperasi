<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Exports\LaporanExport;
use Illuminate\Validation\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Session;

class Neraca extends Controller
{
    public function getDataNeraca()
    {
        $aktiva = DB::table('detail_perkiraan_table')
        ->join('perkiraan_table', 'perkiraan_table.id', '=', 'detail_perkiraan_table.perkiraan_table_id')
        ->where('perkiraan_table_id','<','4')
        ->select('detail_perkiraan_table.id as dpi','nama_perkiraan_detail', 'jumlah_perkiraan', 'perkiraan_table_id','nomor_perkiraan','nama_perkiraan')
        ->get();

        $passiva = DB::table('detail_perkiraan_table')
        ->join('perkiraan_table', 'perkiraan_table.id', '=', 'detail_perkiraan_table.perkiraan_table_id')
        ->where('perkiraan_table_id','<','6')
        ->where('perkiraan_table_id','>','3')
        ->select('detail_perkiraan_table.id as dpi','nama_perkiraan_detail', 'jumlah_perkiraan', 'perkiraan_table_id','nomor_perkiraan','nama_perkiraan')
        ->get();
        $todayDate = Carbon::now();
        $date = $todayDate->format('F').", ".$todayDate->year;
    	return view('/layout/neraca', ['aktiva' => $aktiva ,'passiva'=>$passiva, 'date' =>$date ]);
    }


    public function getDataNeracaMember()
    {
        $aktiva = DB::table('detail_perkiraan_table')
        ->join('perkiraan_table', 'perkiraan_table.id', '=', 'detail_perkiraan_table.perkiraan_table_id')
        ->where('perkiraan_table_id','<','4')
        ->select('nama_perkiraan_detail', 'jumlah_perkiraan', 'perkiraan_table_id','nomor_perkiraan','nama_perkiraan')
        ->get();

        $passiva = DB::table('detail_perkiraan_table')
        ->join('perkiraan_table', 'perkiraan_table.id', '=', 'detail_perkiraan_table.perkiraan_table_id')
        ->where('perkiraan_table_id','<','6')
        ->where('perkiraan_table_id','>','3')
        ->select('nama_perkiraan_detail', 'jumlah_perkiraan', 'perkiraan_table_id','nomor_perkiraan','nama_perkiraan')
        ->get();
        $todayDate = Carbon::now();
        $date = $todayDate->format('F').", ".$todayDate->year;
    	return view('/layoutmember/neraca', ['aktiva' => $aktiva ,'passiva'=>$passiva, 'date' =>$date ]);
    }

    public function ubah(Request $request){
        $this->validate($request, [
            'id'    => 'required',
            'nomor' => 'required',
            'jumlah'=> 'required',
        ]);

        DB::table('detail_perkiraan_table')
        ->where("id","=",$request->id)
        ->update(['nama_perkiraan_detail'=>$request->nama,
        'nomor_perkiraan'=>$request->nomor,
        'jumlah_perkiraan'=>$request->jumlah]);
        Session::flash('success', "Berhasil Di Ubah !");
        return redirect()->back();
    }



    function cetakLaporan()
    {
        //
        return Excel::download(new LaporanExport, 'LaporanNeraca.xlsx');
    }

    function tampil(){
        $tampil = DB::table('users')
        ->get();

        print_r($tampil);
    }
}
