<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class Member extends Controller
{
    public function index()
    {
        return view('/layout/member/member-index');
    }

    public function listMember()
    {
        $member = DB::table('member_table')
        ->join("users","users.id","=","member_table.users_id")
        ->select('full_name','status_member_table', 'member_table.id as mti' ,'users.id as uid')
        ->orderBy('full_name', 'asc')
        ->paginate(10);


        return view('/layout/member/member-list',['anggota' =>$member]);
    }

    public function searchMember(Request $request){
        $member = DB::table('member_table')
        ->join("users","users.id","=","member_table.users_id")
        ->select('full_name','status_member_table', 'member_table.id as mti' ,'users.id as uid')
        ->where('full_name','LIKE','%'.$request->searchname."%")
        ->orderBy('full_name', 'asc')
        ->paginate(10);

        return view('/layout/member/member-list',['anggota' =>$member]);
    }

    public function listNonMember()
    {
        $member = DB::table('nonmember_table')
        ->orderBy('full_name', 'asc')
        ->paginate(10);
        return view('/layout/member/nonmember-list',['list' =>$member]);
    }

    public function notActive($id)
    {
        $tanggal = Carbon::now();

        $accept =DB::table('detail_pinjaman_table')
        ->join('pinjaman_table', 'detail_pinjaman_table.pinjaman_table_id', '=', 'pinjaman_table.id')
        ->where('pinjaman_table.member_table_id',"=",$id)
        ->where('status_pinjaman_id',"=","2")
        ->count();

        if($accept > 0){
            Session::flash('danger', "Tidak Berhasil Di Non Aktikan! Semua Pinjaman Anggota Harus Berstatus Lunas");
            return redirect()->back();
        }else {


            $pokok= DB::table('simpanan_table')
                ->join("detail_simpanan_table","simpanan_table.id_simpanan","=","detail_simpanan_table.simpanan_table_id")
                ->where('member_table_id', '=', $id)
                ->select(DB::raw('SUM(CASE WHEN jenis_simpanan_table_id = 1 THEN saldo ELSE 0 END) as total'))
                ->first();

            if(!$pokok->total){
                $pokok->total=0;
            }    

            $wajib= DB::table('simpanan_table')
                ->join("detail_simpanan_table","simpanan_table.id_simpanan","=","detail_simpanan_table.simpanan_table_id")
                ->where('member_table_id', '=', $id)
                ->select(DB::raw('SUM(CASE WHEN jenis_simpanan_table_id = 2 THEN saldo ELSE 0 END) as total'))
                ->first();

            if(!$wajib->total){
                 $wajib->total=0;
            }      

            $sukarela= DB::table('simpanan_table')
            ->join("detail_simpanan_table","simpanan_table.id_simpanan","=","detail_simpanan_table.simpanan_table_id")
            ->where('member_table_id', '=', $id)
            ->select(DB::raw('SUM(CASE WHEN jenis_simpanan_table_id = 3 THEN saldo ELSE 0 END) as total'))
            ->first();

            if(!$sukarela->total){
                $sukarela->total=0;
            }  
            

            DB::table('member_table')
            ->where('id',$id)
            ->update(['status_member_table' => 2]);

            DB::insert('insert into jurnal_umum_table (keterangan,tanggal,periode_table_id) values (?, ?, ?)',
            ["Bayar pengembalian Simpanan Pada",$tanggal,getIdLatest('periode_table')]);

            //kas
            DB::insert('insert into detail_jurnal_umum (jurnal_umum_table_id, detail_perkiraan_id , debit, kredit, id_admin) values (?, ?, ? , ?, ?)',
            [getIdLatest('jurnal_umum_table') , 1 ,0 ,$pokok->total + $wajib->total + $sukarela->total, Session::get('id_admin')]);
            //pokok
            DB::insert('insert into detail_jurnal_umum (jurnal_umum_table_id,detail_perkiraan_id, debit, kredit,id_admin) values (?, ?, ? , ?,?)',
            [getIdLatest('jurnal_umum_table') , 16 ,$pokok->total, 0, Session::get('id_admin') ]);
            //wajib
            DB::insert('insert into detail_jurnal_umum (jurnal_umum_table_id,detail_perkiraan_id, debit, kredit,id_admin) values (?, ?, ? , ?,?)',
            [getIdLatest('jurnal_umum_table') , 15 ,$wajib->total, 0, Session::get('id_admin') ]);
            //sukarela
            DB::insert('insert into detail_jurnal_umum (jurnal_umum_table_id,detail_perkiraan_id, debit, kredit,id_admin) values (?, ?, ? , ?,?)',
            [getIdLatest('jurnal_umum_table') , 14 ,$sukarela->total, 0, Session::get('id_admin') ]);
            DB::table('detail_perkiraan_table')->where('id', '=', 1)->decrement('jumlah_perkiraan', $pokok->total + $wajib->total + $sukarela->total);
            DB::table('detail_perkiraan_table')->where('id', '=', 16)->decrement('jumlah_perkiraan', $pokok->total);
           
            DB::table('detail_perkiraan_table')->where('id', '=', 15)->decrement('jumlah_perkiraan', $wajib->total);
            DB::table('detail_perkiraan_table')->where('id', '=', 14)->decrement('jumlah_perkiraan', $sukarela->total);


            Session::flash('success', "Berhasil Di Non Aktikan !");
            return redirect()->back();
        }

    }

    public function hapusMember(Request $request)
    {
        if($request->id){
            DB::table('users')
        ->where('id', $request->id)
        ->delete();

            return redirect()->back()->with('success',"Berhasil Di Hapus Aktikan !");
        }else {
            abort(404);
        }
    }

    public function hapusNonMember(Request $request)
    {

        if($request->id){
            DB::table('nonmember_table')
            ->where('id', $request->id)
            ->delete();

            return redirect()->back()->with('success',"Berhasil Di Hapus Aktikan !");
        }else {
            abort(404);
        }

    }

    public function ubahProfil(Request $request)
    {
        if ($request->m) {
            $member = DB::table('member_table')
            ->select("id","full_name","jenis_kelamin_id","alamat","no_telpon","no_slip_gaji")
            ->orderBy('full_name', 'asc')
            ->where("id","=",$request->m)
            ->where("status_member_table","=","1")
            ->first();

            return view("layout/member/member-ubah",["member"=>$member]);
        }else {
            abort(404);
        }

    }

    public function ubah(Request $request)
    {

        $this->validate($request, [
            'namalengkap'   => 'required',
            'jeniskelamin'  => 'required',
            'alamat'        => 'required',
            'notelp'        => 'required|digits_between:4,10',
            'noslip'        => 'required|digits_between:4,10',
        ]);

        DB::table('member_table')
        ->where('id',"=",$request->id)
        ->update(['full_name' => $request->namalengkap, 'jenis_kelamin_id'=>$request->jeniskelamin, 'alamat'=>$request->alamat, 'no_telpon'=>$request->notelp, 'no_slip_gaji'=>$request->noslip]);

        return redirect("/member-view-profil-member?profil=".$request->id)->with('success', "Berhasil Di Ubah !");

    }




    public function profilMember(Request $request)
    {
        if ($request->profil) {
            $user = DB::table('member_table')
            ->leftJoin("jenis_kelamin","jenis_kelamin.id","member_table.jenis_kelamin_id")
            ->select("member_table.id as mti","full_name","jenis","alamat","no_telpon")
            ->where("member_table.id","=",$request->profil)
            ->first();

            $pinjaman = DB::table('pinjaman_table')
            ->join('detail_pinjaman_table', 'detail_pinjaman_table.pinjaman_table_id', '=', 'pinjaman_table.id')
            ->join('jenis_pinjaman_table', 'jenis_pinjaman_table.id', '=', 'detail_pinjaman_table.jenis_pinjaman_table_id')
            ->join('status_pinjaman', 'detail_pinjaman_table.status_pinjaman_id', '=', 'status_pinjaman.id')
            ->select('jumlah_pinjaman','sisa_angsuran','tanggal','nama', 'keterangan','pembayaran')
            ->where("member_table_id","like","%{$request->profil}")
            ->get();

            $simpanan = DB::table('simpanan_table')
            ->join('detail_simpanan_table', 'detail_simpanan_table.simpanan_table_id', '=', 'simpanan_table.id_simpanan')
            ->join('jenis_simpanan_table', 'detail_simpanan_table.jenis_simpanan_table_id', '=', 'jenis_simpanan_table.id')
            ->select('saldo','tanggal','nama','no_bukti')
            ->where("member_table_id","like","%{$request->profil}")
            ->get();

            return view('/layout/member/member-profil',['user' =>$user,'pinjaman' => $pinjaman, 'simpanan' =>$simpanan]);

        }else {
            abort(404);
        }



    }

    public function profilNonMember(Request $request)
    {
        if ($request->profil) {
            $user = DB::table('nonmember_table')
            ->leftJoin("jenis_kelamin","jenis_kelamin.id","nonmember_table.jenis_kelamin_id")
            ->select("nonmember_table.id as mti","full_name","jenis","alamat","no_telpon")
            ->where("nonmember_table.id","like","%{$request->profil}")
            ->first();

            $pinjaman = DB::table('pinjaman_table')
            ->join('detail_pinjaman_table', 'detail_pinjaman_table.pinjaman_table_id', '=', 'pinjaman_table.id')
            ->join('jenis_pinjaman_table', 'jenis_pinjaman_table.id', '=', 'detail_pinjaman_table.jenis_pinjaman_table_id')
            ->join('status_pinjaman', 'detail_pinjaman_table.status_pinjaman_id', '=', 'status_pinjaman.id')
            ->select('jumlah_pinjaman','sisa_angsuran','tanggal','nama', 'keterangan','pembayaran')
            ->where("nonmember_table_id","like","%{$request->profil}")
            ->get();



            return view('/layout/member/nonmember-profil',['user' =>$user,'pinjaman' => $pinjaman]);
        }else {
            abort(404);
        }

    }

}
