<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class Transaksi extends Controller
{
    public function showTransaction()
    {
        /*$transaksi = DB::table('transaksi_table')
            ->join('detail_perkiraan_table', 'detail_perkiraan_table.id', '=', 'transaksi_table.detail_perkiraan_table_id')
            ->join('periode_table', 'transaksi_table.id_periode', '=', 'periode_table.id')
            ->join('member_table','member_table.id','=','transaksi_table.member_table_id')
            ->select('member_table.full_name', 'transaksi_table.jenis_transaksi', 'detail_perkiraan_table.nama_perkiraan', 'transaksi_table.keterangan', 'periode_table.nama_periode')
            ->get();*/
         $perkiraan = DB::table('detail_perkiraan_table')
         ->select('id','perkiraan_table_id','nama_perkiraan_detail', 'nomor_perkiraan')
         ->orderBy('perkiraan_table_id', 'asc')
         ->get();

         $member = DB::table('member_table')
         ->select('id','full_name')
         ->orderBy('full_name', 'asc')
         ->get();

         $member = DB::table('periode_table')
         ->select('id','nama_periode')
         ->orderBy('nama_periode', 'asc')
         ->get();

        //dM6hRrPr
        return view('layout/transaksi',['perkiraan' => $perkiraan , 'member' =>$member]);
    }



    public function autocomplete(Request $request)
    {

        if ($request->has('q')) {
             $cari = $request->q;
             $data = DB::table('member_table')
                ->select("full_name","id")
                ->where("full_name","LIKE","%$cari%")
                ->where("status_member_table","=","1")
                ->get();

                if(count($data) <= 0){
                    $data = DB::table('nonmember_table')
                       ->select("full_name","id")
                       ->where("full_name","LIKE","%$cari%")
                       ->get();
                }

            return response()->json($data);
        }
    }

    public function listAngsuranAnggota(Request $request)
    {
        if($request->m ){
            $data = DB::table('angsuran_table')
            ->where('id_pinjaman_table','=',$request->m)
            ->get();

            $pinjaman=DB::table('detail_pinjaman_table')
            ->join('jenis_pinjaman_table','jenis_pinjaman_table.id','=','detail_pinjaman_table.jenis_pinjaman_table_id')
            ->join('pinjaman_table','pinjaman_table.id','=','detail_pinjaman_table.pinjaman_table_id')
            ->join('member_table','member_table.id','=','pinjaman_table.member_table_id')
            ->where('pinjaman_table_id','LIKE','%'.$request->m."%")
            ->select('jumlah_pinjaman','jumlah_bunga','jumlah_angsuran','sisa_angsuran','nama','tanggal','full_name','member_table_id','pembayaran')
            ->first();

            return view("layout/peminjaman/angsurananggota",['data'=>$data, 'id'=>$request->m , 'pinjaman'=>$pinjaman]);
        }

        return abort(404);

    }


    public function listAngsuranSementara(Request $request)
    {
        if($request->m){
            $data = DB::table('angsuran_table')
            ->where('id_pinjaman_table','=',$request->m)
            ->get();

            $pinjaman=DB::table('detail_pinjaman_table')
            ->join('jenis_pinjaman_table','jenis_pinjaman_table.id','=','detail_pinjaman_table.jenis_pinjaman_table_id')
            ->join('pinjaman_table','pinjaman_table.id','=','detail_pinjaman_table.pinjaman_table_id')
            ->join('member_table','member_table.id','=','pinjaman_table.member_table_id')
            ->where('pinjaman_table_id','LIKE','%'.$request->m."%")
            ->select('jumlah_pinjaman','jumlah_bunga','jenis_pinjaman_table_id','tanggal','nama','full_name','member_table_id')
            ->first();

            $dt = Carbon::create($pinjaman->tanggal);
            $current = Carbon::now();

            return view("layout/peminjaman/angsuransementara",['data'=>$data, 'id'=>$request->m , 'pinjaman'=>$pinjaman, 'waktu'=>$dt->diffForHumans($current), 'diff'=>$current->diffInDays($current) ]);
        }

        return abort(404);
    }

    public function listAngsuranNonMember(Request $request)
    {
        if($request->m ){
            $data = DB::table('angsuran_table')
            ->where('id_pinjaman_table','=',$request->m)
            ->get();

            $pinjaman=DB::table('detail_pinjaman_table')
            ->join('jenis_pinjaman_table','jenis_pinjaman_table.id','=','detail_pinjaman_table.jenis_pinjaman_table_id')
            ->join('pinjaman_table','pinjaman_table.id','=','detail_pinjaman_table.pinjaman_table_id')
            ->join('nonmember_table','nonmember_table.id','=','pinjaman_table.nonmember_table_id')
            ->where('pinjaman_table_id','LIKE','%'.$request->m."%")
            ->select('jumlah_pinjaman','jumlah_bunga','jumlah_angsuran','sisa_angsuran','nama','tanggal','full_name','member_table_id')
            ->first();

            return view("layout/peminjaman/angsuran-nonmember",['data'=>$data, 'id'=>$request->m , 'pinjaman'=>$pinjaman]);
        }

        return abort(404);
    }

    public function addAngsuranAnggota(Request $request)
    {

        $this->validate($request, [
            'tanggal'       => 'required',
            'keterangan'    => 'required',
            'total'       => 'required|digits_between:0,10',
            'bunga'       => 'required|digits_between:0,10',
            'angsuran' => 'required',

        ]);

        $currentid = DB::table('INFORMATION_SCHEMA.tables')
        ->select('AUTO_INCREMENT')
        ->where('table_name','=','angsuran_table')
        ->get();

        $bukti = "KPRI".date("Ymd").$currentid[0]->AUTO_INCREMENT."ANG";

        DB::insert('insert into jurnal_umum_table (keterangan,tanggal,periode_table_id) values (?, ?, ?)',
        [$request->keterangan,$request->tanggal,getIdLatest('periode_table')]);
        //kas
        DB::insert('insert into detail_jurnal_umum (jurnal_umum_table_id, detail_perkiraan_id , debit, kredit, id_admin) values (?, ?, ? , ?, ?)',
        [getIdLatest('jurnal_umum_table') , 1 , $request->total,0 , Session::get('id_admin')]);
        //piutang
        DB::insert('insert into detail_jurnal_umum (jurnal_umum_table_id,detail_perkiraan_id, debit, kredit,id_admin) values (?, ?, ? , ?,?)',
        [getIdLatest('jurnal_umum_table') , 2 , 0, ($request->total - $request->bunga), Session::get('id_admin') ]);
        //Pendpatan SHU
        DB::insert('insert into detail_jurnal_umum (jurnal_umum_table_id,detail_perkiraan_id, debit, kredit,id_admin) values (?, ?, ? , ?, ?)',
        [getIdLatest('jurnal_umum_table') , 20 , 0, $request->bunga, Session::get('id_admin') ]);
        //angusran
        DB::insert('INSERT INTO angsuran_table (id_pinjaman_table,jumlah_angsuran,jumlah_bayar,tanggal,no_bukti) values (?, ?, ?, ?, ?)',
        [$request->pid,$request->angsuran, $request->total,$request->tanggal,$bukti]);

        DB::table('detail_perkiraan_table')->where('id', '=', 2)->decrement('jumlah_perkiraan', $request->total - $request->bunga);//piutang
        DB::table('detail_perkiraan_table')->where('id', '=', 1)->increment('jumlah_perkiraan', $request->total);//kas
        DB::table('detail_perkiraan_table')->where('id', '=', 18)->increment('jumlah_perkiraan', $request->bunga);//SHU USP
        DB::table('detail_perkiraan_table')->where('id', '=', 20)->increment('jumlah_perkiraan', $request->bunga);//Jasa USP
        DB::table('detail_pinjaman_table')->where('pinjaman_table_id', '=', $request->pid)->decrement('sisa_angsuran',$request->angsuran);

        DB::table('jasa_shu_table')->where('member_table_id', '=', $request->id)->increment('pinjaman', $request->bunga);

        DB::insert('insert into notifikasi (admin_table_id ,content , status, member_table_id, tanggal) values (?, ?, ? , ?, ?)',
        [Session::get('id_admin') , "Transaksi Angsuran Pinjaman Anggota Sebesar Rp.".$request->total." Berhasil Ditambahkan Dengan Bukti Pembayaran : ".$bukti , 1,  $request->id, date("Y-m-d")]);

        return view("/layout/bukti/angsuran",["nama"=>$request->name, "angsuran"=>$request->angsuran, "total"=>$request->total, "bukti"=>$bukti, "keterangan"=>"Pembayaran Angsuran Pinjaman Anggota"]);

    }


    public function addAngsuranSementara(Request $request)
    {
        $this->validate($request, [
            'tanggal'       => 'required',
            'keterangan'    => 'required',
            'total'       => 'required|digits_between:4,10',
            'bunga'       => 'required|digits_between:4,10',

        ]);


        $currentid = DB::table('INFORMATION_SCHEMA.tables')
        ->select('AUTO_INCREMENT')
        ->where('table_name','=','angsuran_table')
        ->get();

        $bukti = "KPRI".date("Ymd").$currentid[0]->AUTO_INCREMENT."ANG";

        DB::insert('insert into jurnal_umum_table (keterangan,tanggal,periode_table_id) values (?, ?, ?)',
        [$request->keterangan,$request->tanggal,getIdLatest('periode_table')]);
        //kas
        DB::insert('insert into detail_jurnal_umum (jurnal_umum_table_id, detail_perkiraan_id , debit, kredit, id_admin) values (?, ?, ? , ?, ?)',
        [getIdLatest('jurnal_umum_table') , 1 , $request->total + $request->bunga ,0 , Session::get('id_admin')]);
        //piutang
        DB::insert('insert into detail_jurnal_umum (jurnal_umum_table_id,detail_perkiraan_id, debit, kredit,id_admin) values (?, ?, ? , ?,?)',
        [getIdLatest('jurnal_umum_table') , 2 , 0, $request->total, Session::get('id_admin') ]);
        //Pendpatan SHU
        DB::insert('insert into detail_jurnal_umum (jurnal_umum_table_id,detail_perkiraan_id, debit, kredit,id_admin) values (?, ?, ? , ?, ?)',
        [getIdLatest('jurnal_umum_table') , 20 , 0, $request->bunga, Session::get('id_admin') ]);
        //angusran
        DB::insert('INSERT INTO angsuran_table (id_pinjaman_table,jumlah_bayar,tanggal,no_bukti) values (?, ?, ?, ?)',
        [$request->pid,$request->total,$request->tanggal,$bukti]);

        DB::table('detail_perkiraan_table')->where('id', '=', 2)->decrement('jumlah_perkiraan', $request->total - $request->bunga);//piutang
        DB::table('detail_perkiraan_table')->where('id', '=', 1)->increment('jumlah_perkiraan', $request->total );//kas
        DB::table('detail_perkiraan_table')->where('id', '=', 18)->increment('jumlah_perkiraan', $request->bunga);//SHU USP
        DB::table('detail_perkiraan_table')->where('id', '=', 20)->increment('jumlah_perkiraan', $request->bunga);//Jasa USP

        DB::table('jasa_shu_table')->where('member_table_id', '=', $request->id)->increment('pinjaman', $request->bunga);

        DB::insert('insert into notifikasi (admin_table_id ,content , status, member_table_id, tanggal) values (?, ?, ? , ?, ?)',
        [Session::get('id_admin') , "Transaksi Angsuran Pinjaman Sementara Sebesar Rp.".($request->total)." Berhasil Ditambahkan Dengan Bukti Pembayaran : ".$bukti , 1, $request->id, date("Y-m-d")]);

        return view("/layout/bukti/angsuran",["nama"=>$request->name, "angsuran"=>"-", "total"=>$request->total, "bukti"=>$bukti, "keterangan"=>"Pembayaran Angsuran Pinjaman Sementara"]);

    }

    public function addAngsuranNonAnggota(Request $request)
    {

        $currentid = DB::table('INFORMATION_SCHEMA.tables')
        ->select('AUTO_INCREMENT')
        ->where('table_name','=','angsuran_table')
        ->get();

        $bukti = "KPRI".date("Ymd").$currentid[0]->AUTO_INCREMENT."ANG";

        DB::insert('insert into jurnal_umum_table (keterangan,tanggal,periode_table_id) values (?, ?, ?)',
        [$request->keterangan,$request->tanggal,getIdLatest('periode_table')]);
        //kas
        DB::insert('insert into detail_jurnal_umum (jurnal_umum_table_id, detail_perkiraan_id , debit, kredit, id_admin) values (?, ?, ? , ?, ?)',
        [getIdLatest('jurnal_umum_table') , 1 , $request->total,0 , Session::get('id_admin')]);
        //piutang
        DB::insert('insert into detail_jurnal_umum (jurnal_umum_table_id,detail_perkiraan_id, debit, kredit,id_admin) values (?, ?, ? , ?,?)',
        [getIdLatest('jurnal_umum_table') , 2 , 0, ($request->total - $request->bunga), Session::get('id_admin') ]);
        //Pendpatan SHU
        DB::insert('insert into detail_jurnal_umum (jurnal_umum_table_id,detail_perkiraan_id, debit, kredit,id_admin) values (?, ?, ? , ?, ?)',
        [getIdLatest('jurnal_umum_table') , 20 , 0, $request->bunga, Session::get('id_admin') ]);
        //angusran
        DB::insert('INSERT INTO angsuran_table (id_pinjaman_table,jumlah_angsuran,jumlah_bayar,tanggal,no_bukti) values (?, ?, ?, ?, ?)',
        [$request->pid,$request->angsuran,$request->pokok,$request->tanggal,$bukti]);

        DB::table('detail_perkiraan_table')->where('id', '=', 2)->decrement('jumlah_perkiraan', $request->total - $request->bunga);//piutang
        DB::table('detail_perkiraan_table')->where('id', '=', 1)->increment('jumlah_perkiraan', $request->total);//kas
        DB::table('detail_perkiraan_table')->where('id', '=', 18)->increment('jumlah_perkiraan', $request->bunga);//SHU USP
        DB::table('detail_perkiraan_table')->where('id', '=', 20)->increment('jumlah_perkiraan', $request->bunga);//Jasa USP
        DB::table('detail_pinjaman_table')->where('pinjaman_table_id', '=', $request->pid)->decrement('sisa_angsuran',$request->angsuran);

        return view("/layout/bukti/angsuran",["nama"=>$request->name, "angsuran"=>$request->angsuran, "total"=>$request->total, "bukti"=>$bukti, "keterangan"=>"Pembayaran Angsuran Pinjaman Non Anggota"]);

    }

}
