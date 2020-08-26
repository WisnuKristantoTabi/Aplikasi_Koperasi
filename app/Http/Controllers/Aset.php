<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;

class Aset extends Controller
{
    public function index()
    {
        $data = DB::table('aset_table')->get();

        return view('layout/aset/index',['data'=>$data]);
    }

    public function add(Request $request)
    {

        $pny = ( ( $request->nilai - $request->residu ) / $request->umur )  ;

        DB::insert('insert into aset_table (harga,nilai_residu,umur_ekonomis,tanggal_pembelian,nama_aset, penyusutan) values (?, ?, ?, ?, ?, ?)',
        [$request->nilai,$request->residu,$request->umur,$request->tanggal, $request->nama, $pny]);


        DB::table('detail_perkiraan_table')->where('id', '=', 1)->decrement('jumlah_perkiraan', $request ->nilai);
        DB::table('detail_perkiraan_table')->where('id', '=', 11)->increment('jumlah_perkiraan', $request ->nilai);

        DB::insert('insert into jurnal_umum_table (keterangan,tanggal,periode_table_id) values (?, ?, ?)',
        ["Pembelian ". $request->nama, $request->tanggal,getIdLatest('periode_table')]);

        DB::insert('insert into detail_jurnal_umum (jurnal_umum_table_id, detail_perkiraan_id , debit, kredit, id_admin) values (?, ?, ? , ?, ?)',
        [getIdLatest('jurnal_umum_table') , getIdLatest('detail_perkiraan_table') , $request ->nilai,0, Session::get('id_admin')]);

        DB::insert('insert into detail_jurnal_umum (jurnal_umum_table_id,detail_perkiraan_id, debit, kredit, id_admin) values (?, ?, ? , ?, ?)',
        [getIdLatest('jurnal_umum_table') , 1 , 0, $request ->nilai, Session::get('id_admin')]);

        Session::flash('success', "Aset Berhasil ditambah");
        return redirect()->back();
    }

    public function detail(Request $request)
    {
        if ($request->atid) {
            $current = Carbon::now();
            $data = DB::table('aset_table')
            ->where('id',$request->atid)
            ->first();

            $year = Carbon::createFromFormat('Y-m-d', $data->tanggal_pembelian)->year;

            return view('layout/aset/detail',['data'=>$data,'time'=>$current, 'tahun'=>$year]);
        }else {
            abort(404);
        }

    }

    public function edit(Request $request)
    {
        if ($request->atid) {
            $data = DB::table('aset_table')
            ->where('id',$request->atid)
            ->select("umur_ekonomis","nama_aset")
            ->first();
            return view('layout/aset/ubah',['data'=>$data,'id'=>$request->atid]);
        }else {
            abort(404);
        }
    }

    public function editProses(Request $request)
    {
        $this->validate($request, [
            'nama'       => 'required',
            'tanggal'    => 'required',
            'umur'       => 'required|numeric',
        ]);

        if ($request->id) {
            DB::table('aset_table')
            ->where('id',$request->id)
            ->update(["nama_aset"=>$request->nama, "tanggal_pembelian"=>$request->tanggal, "umur_ekonomis"=>$request->umur]);
            return redirect("/aset")->with("success","Berhasil Di edit");
        }else {
            abort(404);
        }
    }

    public function hapus(Request $request)
    {
        if ($request->id) {
            $current = Carbon::now();
            DB::table('aset_table')
            ->where('id',$request->id)
            ->delete();

            Session::flash('success', "Aset Berhasil dihapus");
            return redirect()->back();
        }else {
            abort(404);
        }

    }
}
