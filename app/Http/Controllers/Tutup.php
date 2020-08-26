<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;


class Tutup extends Controller
{
    public function main()
    {
        return view("layout/tutup/main");
    }

    public function jurnalPenutup(Request $request)
    {
        if(env('PASSWORD_APP')==$request->password){
            $pass = Hash::make($request->password);
            return view("layout/tutup/jurnalpenutup",["pass"=>$pass]);
        }else {
            return redirect()->back();
        }
    }

    public function pendapatanSHU(Request $request)
    {

            $data = DB::table('detail_perkiraan_table')
            ->get();

            foreach ($data as $d ) {
                DB::insert('insert into detail_perkiraan_table_backup (perkiraan_table_id,nama_perkiraan_detail,jumlah_perkiraan,nomor_perkiraan,periode_table_id) values (?, ?, ?, ? ,?)',
                [$d->perkiraan_table_id,$d->nama_perkiraan_detail,$d->jumlah_perkiraan,$d->nomor_perkiraan,getIdLatest('periode_table')]);
            }

            DB::table('detail_perkiraan_table')
            ->where("perkiraan_table_id","=","6")
            ->orwhere("id","=","18")
            ->update(['jumlah_perkiraan' => 0]);

            DB::table('detail_perkiraan_table')
            ->where('perkiraan_table_id', '=', "7")
            ->where("id","!=","22")
            ->delete();

            DB::table('detail_perkiraan_table')
            ->where("id","=","22")
            ->update(['jumlah_perkiraan' => 0]);

            $status=DB::table('jasa_shu_table')
            ->where("status_shu_id","=","1")
            ->count();

            return view("layout/tutup/shu",["pass"=>$request->password,"status"=>$status]);
    }

    public function setPeriode(Request $request)
    {
            DB::table('jasa_shu_table')
            ->update(['pinjaman' => 0, 'status_shu_id' => 1]);

            return view("layout/tutup/setperiode",["pass"=>$request->password]);
    }

    public function complete(Request $request)
    {
            DB::table('periode_table')
            ->where("id","=",getIdLatest('periode_table'))
            ->update(['akhir' => Carbon::now()]);

            DB::insert('insert into periode_table (nama_periode , mulai, id_admin) values (?, ?, ? )',
            [$request->keterangan,$request->tanggal,Session::get('id_admin')]);
            return view("layout/tutup/complete");

    }
}
