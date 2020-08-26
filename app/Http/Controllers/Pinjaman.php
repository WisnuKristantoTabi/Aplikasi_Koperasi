<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;


class Pinjaman extends Controller
{

    public function index()
    {
         return view('layout/peminjaman/index');
    }

    public function indexMember()
    {
        $data = DB::table('pinjaman_table')
           ->join("detail_pinjaman_table","detail_pinjaman_table.pinjaman_table_id","=","pinjaman_table.id")
           ->join("status_pinjaman","status_pinjaman.id","=","detail_pinjaman_table.status_pinjaman_id")
           ->join("jenis_pinjaman_table","jenis_pinjaman_table.id","=","detail_pinjaman_table.jenis_pinjaman_table_id")
           ->select("no_bukti","tanggal","jumlah_pinjaman","nama","jumlah_angsuran","sisa_angsuran","keterangan", "pinjaman_table.id as pid")
           ->where("member_table_id","=",Session::get('id_member'))
           ->get();

         return view('layoutmember/pinjaman/pinjaman',['data'=>$data]);
    }

    public function detailpinjmanamember(Request $request)
    {
        if ($request->pid) {
            $data = DB::table('pinjaman_table')
               ->join("detail_pinjaman_table","detail_pinjaman_table.pinjaman_table_id","=","pinjaman_table.id")
               ->join("status_pinjaman","status_pinjaman.id","=","detail_pinjaman_table.status_pinjaman_id")
               ->join("jenis_pinjaman_table","jenis_pinjaman_table.id","=","detail_pinjaman_table.jenis_pinjaman_table_id")
               ->select("no_bukti","tanggal","jumlah_pinjaman","nama","sisa_angsuran","pembayaran")
               ->where("pinjaman_table.id","=",$request->pid)
               ->first();

              $angs = DB::table('angsuran_table')
                 ->select("no_bukti","tanggal","jumlah_bayar","jumlah_angsuran")
                 ->where("id_pinjaman_table","=",$request->pid)
                 ->get();

             return view('layoutmember/pinjaman/detailpinjaman',['data'=>$data, 'angs'=>$angs]);
        }else {
            abort(404);
        }

    }

    public function autocompleteMember(Request $request)
    {

        if ($request->has('q')) {
             $cari = $request->q;
             $data = DB::table('member_table')
                ->select("full_name","id")
                ->where("full_name","LIKE","%$cari%")
                ->where("status_member_table","=","1")
                ->get();

            return response()->json($data);
        }
    }

    public function autocompleteNonMember(Request $request)
    {

        if ($request->has('q')) {
            $cari = $request->q;
            $data = DB::table('nonmember_table')
            ->select("full_name","id")
            ->where("full_name","LIKE","%$cari%")
            ->get();

            return response()->json($data);
        }
    }

    public function anggota()
    {
        $bunga = DB::table('variabel_table')
        ->where('id',1)
        ->select('persen', 'keterangan')
        ->get();

        $provisi = DB::table('variabel_table')
        ->where('id',8)
        ->select('persen', 'keterangan')
        ->get();


       return view('layout/peminjaman/anggota',['bunga' => $bunga , 'provisi' => $provisi]);
    }

    public function nonAnggota()
    {
        $bunga = DB::table('variabel_table')
        ->where('id',1)
        ->select('persen', 'keterangan')
        ->get();

        $provisi = DB::table('variabel_table')
        ->where('id',8)
        ->select('persen', 'keterangan')
        ->get();

         return view('layout/peminjaman/nonanggota',['bunga' => $bunga , 'provisi' => $provisi]);
    }

    public function sementara()
    {

        $bunga = DB::table('variabel_table')
        ->where('id',1)
        ->select('persen', 'keterangan')
        ->get();

        $provisi = DB::table('variabel_table')
        ->where('id',8)
        ->select('persen', 'keterangan')
        ->get();

       return view('layout/peminjaman/sementara',[ 'bunga' => $bunga, 'provisi' => $provisi ]);
    }


    public function addPinjamanSementara(Request $request)
    {

        $this->validate($request, [
            'keterangan'  => 'required|min:2',
            'inputpinjaman' => 'required|max:9',
            'tanggal'      => 'required',
            'namasearch'      => 'required',
        ]);

        $currentid = DB::table('INFORMATION_SCHEMA.tables')
        ->select('AUTO_INCREMENT')
        ->where('table_name','=','pinjaman_table')
        ->get();

        $tanggal = Carbon::now();

        $bukti= "KPRI".$tanggal->year.$tanggal->month.$tanggal->day.$currentid[0]->AUTO_INCREMENT."PINJ";

        $data = array(
            'keterangan'        =>$request ->keterangan,
            'tanggal'           =>$request->tanggal,
            'carinama'          => $request ->nama,
	        'hitungbunga'       => $request ->hitungbunga,
	        'inputpinjaman'     => $request ->inputpinjaman,
            'angsuran'          => 0,
            'provisi'           => $request->hitungrpovisi,
            'pembayaran'        => 0,
            'bukti'             => $bukti,
        );

        DB::insert('insert into jurnal_umum_table (keterangan,tanggal,periode_table_id) values (?, ?, ?)',
        [$data['keterangan'],$data['tanggal'],getIdLatest('periode_table')]);

        DB::insert('insert into detail_jurnal_umum (jurnal_umum_table_id, detail_perkiraan_id , debit, kredit, id_admin) values (?, ?, ? , ?, ?)',
        [getIdLatest('jurnal_umum_table') , 2 , $data['inputpinjaman'],0 , Session::get('id_admin')]);

        DB::insert('insert into detail_jurnal_umum (jurnal_umum_table_id,detail_perkiraan_id, debit, kredit,id_admin) values (?, ?, ? , ?,?)',
        [getIdLatest('jurnal_umum_table') , 1 , 0, $data['inputpinjaman'], Session::get('id_admin') ]);


        DB::insert('insert into pinjaman_table (member_table_id, tanggal , jurnal_umum_table_id, no_bukti  ) values (?, ?, ?, ?)',
        [$request->namasearch, $data['tanggal'] , getIdLatest('jurnal_umum_table'), $bukti ]);

        DB::insert('insert into detail_pinjaman_table (pinjaman_table_id, jumlah_pinjaman , jumlah_bunga , jenis_pinjaman_table_id, status_pinjaman_id) values (?, ?, ?, ?, ?)',
        [getIdLatest('pinjaman_table'), $data['inputpinjaman'],$data['hitungbunga'] , 2, 2]);

        DB::table('detail_perkiraan_table')->where('id', '=', 1)->decrement('jumlah_perkiraan', $data['inputpinjaman']);
        DB::table('detail_perkiraan_table')->where('id', '=', 2)->increment('jumlah_perkiraan', $data['inputpinjaman']);
        //provisi
        DB::table('detail_perkiraan_table')->where('id', '=', 1)->increment('jumlah_perkiraan', $data['provisi']);
        DB::table('detail_perkiraan_table')->where('id', '=', 21)->increment('jumlah_perkiraan', $data['provisi']);
        DB::table('detail_perkiraan_table')->where('id', '=', 18)->increment('jumlah_perkiraan', $data['provisi']);

        DB::table('jasa_shu_table')->where('member_table_id', '=', $request->namasearch)->increment('pinjaman', $request->hitungrpovisi);


        return view('layout/cetakbuktipeminjaman',['data'=>$data] );

    }

    public function hapus(Request $request)
    {
        if ($request->pti) {
            DB::table('pinjaman_table')
            ->where('id', '=', $request->pti)
            ->delete();

            Session::flash('success', "Berhasil Dihapus");
            return redirect()->back();
        }else {
            abort(404);
        }

    }



    public function addTransactionPinjaman(Request $request)
    {
        $this->validate($request, [
            'keterangan'  => 'required|min:2',
            'inputpinjaman' => 'required|max:9',
            'tanggal'      => 'required',
            'hitungrpovisi'      => 'required',
            'angsuran'      => 'required',
            'namasearch'      => 'required',
        ]);

        DB::insert('insert into jurnal_umum_table (keterangan,tanggal,periode_table_id) values (?, ?, ?)',
        [$request ->keterangan,$request->tanggal,getIdLatest('periode_table')]);

        DB::insert('insert into detail_jurnal_umum (jurnal_umum_table_id, detail_perkiraan_id , debit, kredit, id_admin) values (?, ?, ? , ?, ?)',
        [getIdLatest('jurnal_umum_table') , 2 , $request->inputpinjaman,0 , Session::get('id_admin')]);

        DB::insert('insert into detail_jurnal_umum (jurnal_umum_table_id,detail_perkiraan_id, debit, kredit, id_admin) values (?, ?, ? , ?, ?)',
        [getIdLatest('jurnal_umum_table') , 1 , 0, $request->inputpinjaman , Session::get('id_admin')]);

        DB::insert('insert into jurnal_umum_table (keterangan,tanggal,periode_table_id) values (?, ?, ?)',
        ["Terima provisi dari ".$request->nama,$request->tanggal,getIdLatest('periode_table')]);

        DB::insert('insert into detail_jurnal_umum (jurnal_umum_table_id,detail_perkiraan_id, debit, kredit, id_admin) values (?, ?, ? , ?, ?)',
        [getIdLatest('jurnal_umum_table') , 1 , $request->hitungrpovisi, 0, Session::get('id_admin')]);

        DB::insert('insert into detail_jurnal_umum (jurnal_umum_table_id,detail_perkiraan_id, debit, kredit, id_admin) values (?, ?, ? , ?, ?)',
        [getIdLatest('jurnal_umum_table') , 21 , 0, $request->hitungrpovisi , Session::get('id_admin')]);

        $tanggal = Carbon::now();

        $currentid = DB::table('INFORMATION_SCHEMA.tables')
        ->select('AUTO_INCREMENT')
        ->where('table_name','=','pinjaman_table')
        ->get();

        $bukti= "KPRI".$tanggal->year.$tanggal->month.$tanggal->day.$currentid[0]->AUTO_INCREMENT."PINJ";

        DB::insert('insert into pinjaman_table (member_table_id, tanggal , jurnal_umum_table_id, no_bukti ) values (?, ?, ?, ?)',
        [$request->namasearch, $request->tanggal , getIdLatest('jurnal_umum_table'),$bukti]);

        DB::insert('insert into detail_pinjaman_table (pinjaman_table_id, jumlah_pinjaman , jumlah_bunga , jumlah_angsuran, jenis_pinjaman_table_id, sisa_angsuran, status_pinjaman_id, pembayaran ) values (?, ?, ?, ?, ?, ?, ?, ?)',
        [getIdLatest('pinjaman_table'), $request->inputpinjaman,$request ->hitungbunga, $request->angsuran , 1, $request->angsuran, 2, $request->pembayaran]);

        DB::table('detail_perkiraan_table')->where('id', '=', 1)->decrement('jumlah_perkiraan', $request->inputpinjaman);
        DB::table('detail_perkiraan_table')->where('id', '=', 2)->increment('jumlah_perkiraan', $request->inputpinjaman);
        //provisi
        DB::table('detail_perkiraan_table')->where('id', '=', 1)->increment('jumlah_perkiraan', $request->hitungrpovisi);
        DB::table('detail_perkiraan_table')->where('id', '=', 21)->increment('jumlah_perkiraan', $request->hitungrpovisi);
        DB::table('detail_perkiraan_table')->where('id', '=', 18)->increment('jumlah_perkiraan', $request->hitungrpovisi);

        DB::table('jasa_shu_table')->where('member_table_id', '=', $request->namasearch)->increment('pinjaman', $request->hitungrpovisi);

        $data = array(
            'carinama'          => $request ->nama,
	        'hitungbunga'       => $request ->hitungbunga,
	        'inputpinjaman'     => $request ->inputpinjaman,
            'angsuran'          => $request->angsuran,
            'provisi'           => $request->hitungrpovisi,
            'pembayaran'        => $request->pembayaran,
            'bukti'             => $bukti,
        );

        return view('layout/cetakbuktipeminjaman',['data'=>$data] );
    }


    public function addTransactionPinjamanNonMember(Request $request)
    {
        $this->validate($request, [
            'keterangan'  => 'required|min:2',
            'inputpinjaman' => 'required|max:9',
            'tanggal'      => 'required',
            'hitungrpovisi'      => 'required',
            'angsuran'      => 'required',
            'namasearch'      => 'required',
        ]);

        DB::insert('insert into jurnal_umum_table (keterangan,tanggal,periode_table_id) values (?, ?, ?)',
        [$request ->keterangan,$request->tanggal,getIdLatest('periode_table')]);

        DB::insert('insert into detail_jurnal_umum (jurnal_umum_table_id, detail_perkiraan_id , debit, kredit, id_admin) values (?, ?, ? , ?, ?)',
        [getIdLatest('jurnal_umum_table') , 2 , $request->inputpinjaman,0 , Session::get('id_admin')]);

        DB::insert('insert into detail_jurnal_umum (jurnal_umum_table_id,detail_perkiraan_id, debit, kredit, id_admin) values (?, ?, ? , ?, ?)',
        [getIdLatest('jurnal_umum_table') , 1 , 0, $request->inputpinjaman , Session::get('id_admin')]);

        DB::insert('insert into jurnal_umum_table (keterangan,tanggal,periode_table_id) values (?, ?, ?)',
        ["Terima provisi dari ".$request->nama,$request->tanggal,getIdLatest('periode_table')]);

        DB::insert('insert into detail_jurnal_umum (jurnal_umum_table_id,detail_perkiraan_id, debit, kredit, id_admin) values (?, ?, ? , ?, ?)',
        [getIdLatest('jurnal_umum_table') , 1 , $request->hitungrpovisi, 0, Session::get('id_admin')]);

        DB::insert('insert into detail_jurnal_umum (jurnal_umum_table_id,detail_perkiraan_id, debit, kredit, id_admin) values (?, ?, ? , ?, ?)',
        [getIdLatest('jurnal_umum_table') , 21 , 0, $request->hitungrpovisi , Session::get('id_admin')]);

        $tanggal = Carbon::now();

        $currentid = DB::table('INFORMATION_SCHEMA.tables')
        ->select('AUTO_INCREMENT')
        ->where('table_name','=','pinjaman_table')
        ->get();

        $bukti= "KPRI".$tanggal->year.$tanggal->month.$tanggal->day.$currentid[0]->AUTO_INCREMENT."PINJ";

        DB::insert('insert into pinjaman_table (nonmember_table_id, tanggal , jurnal_umum_table_id, no_bukti ) values (?, ?, ?, ?)',
        [$request->namasearch, $request->tanggal , getIdLatest('jurnal_umum_table'), $bukti]);

        DB::insert('insert into detail_pinjaman_table (pinjaman_table_id, jumlah_pinjaman , jumlah_bunga , jumlah_angsuran, jenis_pinjaman_table_id, sisa_angsuran, status_pinjaman_id, pembayaran ) values (?, ?, ?, ?, ?, ?, ?, ?)',
        [getIdLatest('pinjaman_table'), $request->inputpinjaman,$request ->hitungbunga, $request->angsuran , 3, $request->angsuran, 2, $request->pembayaran]);

        DB::table('detail_perkiraan_table')->where('id', '=', 1)->decrement('jumlah_perkiraan', $request->hitungrpovisi);
        DB::table('detail_perkiraan_table')->where('id', '=', 2)->increment('jumlah_perkiraan', $request->hitungrpovisi);

        DB::table('detail_perkiraan_table')->where('id', '=', 1)->increment('jumlah_perkiraan', $request->hitungrpovisi);
        DB::table('detail_perkiraan_table')->where('id', '=', 21)->increment('jumlah_perkiraan', $request->hitungrpovisi);
        DB::table('detail_perkiraan_table')->where('id', '=', 18)->increment('jumlah_perkiraan', $request->hitungrpovisi);

        $data = array(
            'carinama'          => $request ->nama,
	        'hitungbunga'       => $request ->hitungbunga,
	        'inputpinjaman'     => $request ->inputpinjaman,
            'angsuran'          => $request->angsuran,
            'provisi'           => $request->hitungrpovisi,
            'pembayaran'        => $request->pembayaran,
            'bukti'             =>$bukti,
        );

        return view('layout/cetakbuktipeminjaman',['data'=>$data] );
    }


}
