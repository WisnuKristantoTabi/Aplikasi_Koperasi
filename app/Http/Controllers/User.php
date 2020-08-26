<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Validator;
use Ramsey\Uuid\Uuid;
use Carbon\Carbon;


class User extends Controller
{
    public function addUser(Request $request)
    {

        $this->validate($request, [
            'username'  => 'required|min:2',
            'full_name' => 'required',
            'role'      => 'required',

        ]);
        //Hash::make("Nano");
        $tanggal = Carbon::now();
        $passwordasli = str_random(8);
        $password    =   Hash::make($passwordasli);
        $username    =   $request->username;
        $full_name   =   $request->full_name;
        $id_user = Uuid::uuid4() ;
        $id = Uuid::uuid4();


        if ($request->role == 'admin'){

            DB::insert('insert into users (id,username,password,role,created_at,updated_at) values (?, ?, ?, ?, ?, ?)',
            [$id_user,$username,$password,'admin',$tanggal,$tanggal]);


            DB::insert('insert into admin_table (id,full_name,users_id) values (?, ?, ?)',
            [$id,$full_name,$id_user]);

            return view("layout/cetakBiodata", ["username"=>$username,"password"=>$passwordasli,"role"=>"Admin", "full_name"=>$full_name ]);
        }

        if ($request->role == 'member') {
            DB::insert('insert into users (id,username,password,role,created_at,updated_at) values (?, ?, ?, ?, ?, ?)',
            [$id_user,$username,$password,'member',$tanggal,$tanggal]);

            DB::insert('insert into member_table (id,users_id,full_name, status_member_table) values (?, ?, ?, ?)',
            [$id,$id_user,$full_name,1]);

            DB::insert('insert into jasa_shu_table (id,member_table_id,modal,pinjaman,status_shu_id) values (?, ?, ?, ?, ?)',
            [Uuid::uuid4(),$id,0,0,1]);

            return view("layout/cetakBiodata", ["username"=>$username,"password"=>$passwordasli,"role"=>"member", "full_name"=>$full_name]);
        }
    }

    public function searchUsername(Request $request)
    {
        //
        if ($request->ajax()) {

            $data = DB::table('users')
            ->where("username","=",$request->username)
            ->count();
            $response = "<span style='color: green'>Username Tersedia </span>";

            if ($data>0) {
                $response = "<span style='color: red'>Username Tidak Tersedia </span>";
            }
            echo $response;
        }
    }

    public function createAdmin()
    {
        return view("layout/register/registeradmin");
    }

    public function createMember()
    {
        return view("layout/register/registermember");
    }

    public function createNonUser()
    {
        return view("layout/register/registernonmember");
    }

    public function addAdmin(Request $request)
    {
        $this->validate($request, [
            'username' => 'required|min:3|max:77',
            'full_name' => 'required|min:3|max:77',
        ]);

        $count = DB::table('users')
        ->where("username","=",$request->username)
        ->count();

        if($count > 0)
        {
            return back()->withErrors('Username telah Terpakai');
        }else {
            $tanggal = Carbon::now();
            $passwordasli = str_random(8);
            $password    =   Hash::make($passwordasli);
            $username    =   strtolower($request->username);
            $full_name   =   $request->full_name;
            $id_user = Uuid::uuid4() ;
            $id = Uuid::uuid4();

            DB::insert('insert into users (id,username,password,role,created_at,updated_at) values (?, ?, ?, ?, ?, ?)',
            [$id_user,$username,$password,'admin',$tanggal,$tanggal]);

            DB::insert('insert into admin_table (id,full_name,users_id) values (?, ?, ?)',
            [$id,$full_name,$id_user]);

            return view("layout/cetakBiodata", ["username"=>$username,"password"=>$passwordasli,"role"=>"Admin", "full_name"=>$full_name , "bukti"=>"-"]);
        }

    }



    public function addNonUser(Request $request)
    {
        $tanggal = Carbon::now();
        $this->validate($request, [
            'nama'  => 'required|min:2',
            'jeniskelamin' => 'required|numeric',
            'alamat'      => 'required|max:100',
            'telpon'      => 'required|numeric|digits_between:1,15',

        ]);

        $id = "Non-". Uuid::uuid4() ;
        DB::insert('insert into nonmember_table (id,full_name,jenis_kelamin_id,alamat,no_telpon,tanggal_dibuat) values (?, ?, ?, ?, ?, ?)',
        [$id,$request->nama ,$request->jeniskelamin, $request->alamat, $request->telpon, $tanggal ]);

        return redirect("member-view-list-non-member")->with("success","Data Non Member Berhasil Ditambah");
    }

    public function addUserMember(Request $request)
    {
        $tanggal = Carbon::now();
        $this->validate($request, [
            'jeniskelamin' => 'required|numeric',
            'alamat'      => 'required|max:100',
            'telpon'      => 'required|numeric|digits_between:1,15',
            'username' => 'required|min:3|max:77',
            'full_name' => 'required|min:3|max:77',
        ]);

        $count = DB::table('users')
        ->where("username","=",$request->username)
        ->count();

        if($count > 0)
        {
            return back()->withErrors('Username telah Terpakai');
        }else {


            $tanggal = Carbon::now();
            $passwordasli = str_random(8);
            $password    =   Hash::make($passwordasli);
            $username    =   strtolower($request->username);
            $full_name   =   $request->full_name;
            $id_user = Uuid::uuid4() ;
            $id = Uuid::uuid4();

            DB::insert('insert into users (id,username,password,role,created_at,updated_at) values (?, ?, ?, ?, ?, ?)',
            [$id_user,$username,$password,'member',$tanggal,$tanggal]);

            DB::insert('insert into member_table (id,users_id,full_name, status_member_table,jenis_kelamin_id, alamat, no_telpon, no_slip_gaji) values (?, ?, ?, ?, ?, ?, ?, ?)',
            [$id,$id_user,$full_name,1,$request->jeniskelamin,$request->alamat,$request->telpon,$request->gaji]);

            DB::insert('insert into jasa_shu_table (id,member_table_id,modal,pinjaman,status_shu_id) values (?, ?, ?, ?, ?)',
            [Uuid::uuid4(),$id,100000,0,1]);

            DB::insert('insert into jurnal_umum_table (keterangan,tanggal,periode_table_id) values (?, ?, ?)',
            ["Terima Simpnana_pokok dari ".$full_name,$tanggal,getIdLatest('periode_table')]);

            DB::insert('insert into detail_jurnal_umum (jurnal_umum_table_id,detail_perkiraan_id, debit, kredit, id_admin) values (?, ?, ? , ?, ?)',
            [getIdLatest('jurnal_umum_table') , 1 , 100000, 0, Session::get('id_admin')]);

            DB::insert('insert into detail_jurnal_umum (jurnal_umum_table_id,detail_perkiraan_id, debit, kredit, id_admin) values (?, ?, ? , ?, ?)',
            [getIdLatest('jurnal_umum_table') , 16 , 0, 100000 , Session::get('id_admin')]);

            DB::table('detail_perkiraan_table')->where('id', '=', 1)->increment('jumlah_perkiraan', 100000);
            DB::table('detail_perkiraan_table')->where('id', '=', 16)->increment('jumlah_perkiraan', 100000);

            $id_simpan = Uuid::uuid4();
            $currentid = DB::table('INFORMATION_SCHEMA.tables')
            ->select('AUTO_INCREMENT')
            ->where('table_name','=','detail_simpanan_table')
            ->get();

            $bukti= "KPRI".$tanggal->year.$tanggal->month.$tanggal->day.$currentid[0]->AUTO_INCREMENT."SIMP";

             DB::insert('insert into simpanan_table (id_simpanan,member_table_id,tanggal_buat,keterangan) values (?, ?, ?, ?)',
             [$id_simpan,$id,$tanggal,"-"]);

             DB::insert('insert into detail_simpanan_table (jenis_simpanan_table_id, saldo, simpanan_table_id, jurnal_umum_table_id, no_bukti, tanggal) values (?, ?, ?, ?, ?, ?)',
             [1,100000,$id_simpan,getIdLatest('jurnal_umum_table'),$bukti,$tanggal]);

             DB::insert('insert into notifikasi (admin_table_id ,content , status, member_table_id, tanggal) values (?, ?, ? , ?, ?)',
             [Session::get('id_admin') , "Selamat Datang Di Aplikasi ... \n Simpanan Pokok Telah Ditambahkan Sebesar Rp.100000 Berhasil Dengan Bukti Pembayaran : ".$bukti , 1, $id, date("Y-m-d")]);

            return view("layout/cetakBiodata", ["username"=>$username,"password"=>$passwordasli,"role"=>"member", "full_name"=>$full_name, "bukti"=>$bukti]);
        }

    }


    function changePassword(Request $request){

        $this->validate($request, [
            'passwordlama' => 'required',
            'repasswordbaru'      => 'required|min:8|',
            'passwordbaru'      => 'required|min:8',
        ]);

        $passwordlama = $request->passwordlama;
        $data = DB::table('users')->select('id','password')
        ->where('id', Session::get('id_user'))
        ->first();

        if(Hash::check($passwordlama,$data->password)){
            if($request->passwordbaru == $request->repasswordbaru){
                $passwordbaru = Hash::make($request->passwordbaru);
                DB::table('users')
                    ->where('id', $data->id)
                    ->update(['password' => $passwordbaru]);
                    if (Session::get('role')=='admin') {
                        return redirect('/dashboardadmin')->with('success','Password Admin berhasil diganti');
                    }if (Session::get('role')=='member') {
                        return redirect('/dashboardmember')->with('success','Password Member berhasil diganti');
                    }

            }else {
                return redirect('/gantipassword')->with('danger','Ulangi Masukkan Password Baru');
            }
        }else {
            return redirect('/gantipassword')->with('danger','Password Lama Salah');
        }
    }

    public function updateProfil()
    {
        // code...
    }

}
