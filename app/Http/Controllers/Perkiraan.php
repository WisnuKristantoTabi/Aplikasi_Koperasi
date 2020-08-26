<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class Perkiraan extends Controller
{

        public function addPerkiraan(Request $request)
        {
            $this->validate($request, [
                'golongan_perkiraan' => 'required|numeric',
                'nama_perkiraan'  => 'required',
                'nomor_perkiraan' => 'required',
            ]);

            DB::insert('insert into detail_perkiraan_table (nama_perkiraan_detail,jumlah_perkiraan,perkiraan_table_id,nomor_perkiraan,keterangan_id) values (?, ?, ?, ?, ?)',
            [$request->nama_perkiraan,0,$request->golongan_perkiraan,$request->nomor_perkiraan,1]);

            return redirect("/perkiraan-list")->with("success","Berhasil Ditambah");

        }

        public function tambah()
        {
            $perkiraan = DB::table('perkiraan_table')
            ->select('nama_perkiraan','id')
            ->where('id','<',7)
            ->get();

            return view('/layout/perkiraan/perkiraan', ["perkiraan"=>$perkiraan]);
        }

        public function list()
        {
            $data = DB::table('detail_perkiraan_table')
            ->join('perkiraan_table', 'perkiraan_table.id', '=', 'detail_perkiraan_table.perkiraan_table_id')
            ->select('nama_perkiraan','nama_perkiraan_detail','nomor_perkiraan', 'keterangan_id', 'perkiraan_table_id', 'detail_perkiraan_table.id as dpi')
            ->where('perkiraan_table_id','<',7)
            ->orderBy("nomor_perkiraan","asc")
            ->get();

            $perkiraan = DB::table('perkiraan_table')
            ->select('nama_perkiraan','id')
            ->where('id','<',"7")
            ->get();

            return view("layout/perkiraan/listperkiraan", ["data"=>$data ,"perkiraan"=>$perkiraan]);
        }

        public function hapus(Request $request)
        {
            if ($request->id) {
                DB::table('detail_perkiraan_table')
                ->where('id','=',$request->id)
                ->delete();

                Session::flash('success', "Berhasil Dihapus");
                return redirect()->back();
            }else {
                abort(404);
            }

        }


        public function edit(Request $request)
        {
            $this->validate($request, [
                'nama'                  => 'required|min:3',
                'nomor_perkiraan'       => 'required',
                'golongan_perkiraan'    => 'required',
            ]);


            DB::table('detail_perkiraan_table')
            ->where("id","=",$request->id)
            ->update(["nama_perkiraan_detail"=>$request->nama, "nomor_perkiraan"=>$request->nomor_perkiraan, "perkiraan_table_id"=>$request->golongan_perkiraan]);
            Session::flash('success', "Berhasil Dihapus");
            return redirect()->back();
        }

}
