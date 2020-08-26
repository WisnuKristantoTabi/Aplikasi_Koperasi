<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;

class Beban extends Controller
{
    public function index(Request $request)
    {
        $data = DB::table('jurnal_umum_table')
        ->join('detail_jurnal_umum', 'jurnal_umum_table.id', '=', 'detail_jurnal_umum.jurnal_umum_table_id')
        ->join('detail_perkiraan_table', 'detail_perkiraan_table.id', '=', 'detail_jurnal_umum.detail_perkiraan_id')
        ->select('keterangan','tanggal','debit','kredit', 'detail_perkiraan_table.id as dpi', 'nomor_perkiraan', 'jurnal_umum_table.id as jui', 'detail_jurnal_umum.id as dui')
        ->where('debit','>',0)
        ->where('detail_perkiraan_table.perkiraan_table_id',7)
        ->where('periode_table_id',$request->prd)
        ->get();

        return view('layout/beban/bebanindex',['data' => $data]);
    }

    public function addBeban(Request $request)
    {

        $this->validate($request, [
            'tanggal'       => 'required',
            'keterangan'    => 'required',
            'inputnominal'  => 'required',
            'nomor'         => 'required',

        ]);

        $tanggal = Carbon::now();


        /*$nominal = str_replace('Rp. ', '', $request->inputnominal);
        $nominal = intval($nominal);*/

        DB::insert('insert into jurnal_umum_table (keterangan,tanggal,periode_table_id) values (?, ?, ?)',
        [$request->keterangan, $request->tanggal,getIdLatest('periode_table')]);

        DB::insert('insert into detail_perkiraan_table (perkiraan_table_id, nama_perkiraan_detail, jumlah_perkiraan, nomor_perkiraan, keterangan_id) values (?, ?, ?, ?, ?)',
        [7 , $request->keterangan, $request->inputnominal, $request->nomor, 1]);

        DB::insert('insert into detail_jurnal_umum (jurnal_umum_table_id, detail_perkiraan_id , debit, kredit, id_admin) values (?, ?, ? , ?, ?)',
        [getIdLatest('jurnal_umum_table') , getIdLatest('detail_perkiraan_table') , $request->inputnominal,0, Session::get('id_admin')]);

        DB::insert('insert into detail_jurnal_umum (jurnal_umum_table_id,detail_perkiraan_id, debit, kredit, id_admin) values (?, ?, ? , ?, ?)',
        [getIdLatest('jurnal_umum_table') , 1 , 0, $request->inputnominal, Session::get('id_admin')]);

        DB::table('detail_perkiraan_table')->where('id', '=', 1)->decrement('jumlah_perkiraan', $request->inputnominal);
        DB::table('detail_perkiraan_table')->where('id', '=', 18)->decrement('jumlah_perkiraan', $request->inputnominal);

        Session::flash('success', "Berhasil Ditambahkan");
        return redirect()->back();
    }

    public function changeBeban(Request $request){
        DB::table('detail_perkiraan_table')
        ->where('id',"=",$request->id)
        ->update(['nama_perkiraan_detail' => $request->keteranganubah, 'nomor_perkiraan'=>$request->nomorubah]);

        DB::table('jurnal_umum_table')
        ->where('id',"=",$request->jui)
        ->update(['tanggal' => $request->tanggalubah, 'keterangan'=>$request->keteranganubah]);

        DB::table('detail_jurnal_umum')
        ->where('id',"=",$request->dui)
        ->update(['id_admin' => Session::get('id_admin')]);


        Session::flash('success', "Berhasil Diubah");
        return redirect()->back();
    }

    public function delete(Request $request){
        Session::flash('success', "Berhasil Dihapus");
        return redirect()->back();
    }

}
