<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use Ramsey\Uuid\Uuid;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Support\Facades\Hash;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Maatwebsite\Excel\Facades\Excel;

class Simpanan extends Controller
{
    public function index()
    {

        return view('layout/simpanan/index');
    }

    public function indexSimpanan()
    {
        $data= DB::table('simpanan_table')
            ->join("detail_simpanan_table","simpanan_table.id_simpanan","=","detail_simpanan_table.simpanan_table_id")
            ->where('member_table_id', '=', Session::get('id_member'))
            ->select("id_simpanan",DB::raw('SUM(CASE WHEN jenis_simpanan_table_id = 1 THEN saldo ELSE 0 END) as pokok'),DB::raw('SUM(CASE WHEN jenis_simpanan_table_id = 2 THEN saldo ELSE 0 END) as wajib'),DB::raw('SUM(CASE WHEN jenis_simpanan_table_id = 3 THEN saldo ELSE 0 END) as sukarela'))
            ->first();

        return view('layoutmember/simpanan/index',["data"=>$data]);
    }

    public function detailSimpananMember(Request $request)
    {
        if ($request->sti && $request->jsti) {
            $data= DB::table('simpanan_table')
                ->join("detail_simpanan_table","simpanan_table.id_simpanan","=","detail_simpanan_table.simpanan_table_id")
                ->select("no_bukti","tanggal","saldo")
                ->where('simpanan_table_id', '=', $request->sti)
                ->where('jenis_simpanan_table_id','=',$request->jsti)
                ->get();

            return view('layoutmember/simpanan/detail',["data"=>$data]);
        }else {
            abort(404);
        }

    }



    public function formPokok()
    {
        $jenis= DB::table('jenis_simpanan_table')
            ->select('id','nama')
            ->get();


        return view('layout/simpanan/temppokok',['jenis' => $jenis, 'jenis_id'=>1]);
    }


    public function formWajib()
    {
        $jenis= DB::table('jenis_simpanan_table')
            ->select('id','nama')
            ->get();

        return view('layout/simpanan/tempwajib',['jenis' => $jenis, 'jenis_id'=>2]);
    }

    public function list()
    {
        return view("/layout/simpanan/list");
    }

    public function formSukarela()
    {
        $jenis= DB::table('jenis_simpanan_table')
            ->select('id','nama')
            ->get();

        return view('layout/simpanan/tempsukarela',['jenis' => $jenis, 'jenis_id'=>3]);
    }


    public function searchPokok(Request $request)
    {

        if($request->ajax()){
            $output="";
            $data=DB::table('simpanan_table')
            ->where('member_table_id','LIKE','%'.$request->search."%")
            ->count();

            if($data >0){
                $output.='<div class=" bg-danger"><p class="text-center text-white font-italic">Data Telah Terisi</p></div>';
            }else {
                $output.='<div class="form-group"><label for="nominal" class="text-white"> Nominal Yang Dibayar </label>'.
                '<input class="form-control" type="text" name="nominal" value="Rp. 100.000" readonly></div>'.
               '<input class="btn btn-primary" id="tambahtransaksi" type="submit" value="Tambahkan Ke Transaksi">';
            }
            return Response($output);
        }
    }

    public function addPokok(Request $request)
    {
        return redirect()->back();
    }

    public function addWajib(Request $request)
    {
        $this->validate($request, [
            'namasearch'      => 'required',
            'tanggal'      => 'required',
            'keterangan' => 'required',
            'nominal' => 'required',

        ]);

        $tanggal = Carbon::now();

        DB::table('jasa_shu_table')->where('member_table_id', '=', $request->namasearch)->increment('modal', $request->nominal);

        DB::insert('insert into jurnal_umum_table (keterangan,tanggal,periode_table_id) values (?, ?, ?)',
        [$request->keterangan,$request->tanggal,getIdLatest('periode_table')]);

        DB::insert('insert into detail_jurnal_umum (jurnal_umum_table_id,detail_perkiraan_id, debit, kredit, id_admin) values (?, ?, ? , ?, ?)',
        [getIdLatest('jurnal_umum_table') , 1 , $request->nominal, 0, Session::get('id_admin')]);

        DB::insert('insert into detail_jurnal_umum (jurnal_umum_table_id,detail_perkiraan_id, debit, kredit, id_admin) values (?, ?, ? , ?, ?)',
        [getIdLatest('jurnal_umum_table') , 16 , 0, $request->nominal , Session::get('id_admin')]);

        DB::table('detail_perkiraan_table')->where('id', '=', 1)->increment('jumlah_perkiraan', $request->nominal);
        DB::table('detail_perkiraan_table')->where('id', '=', 16)->increment('jumlah_perkiraan', $request->nominal);

        $currentid = DB::table('INFORMATION_SCHEMA.tables')
        ->select('AUTO_INCREMENT')
        ->where('table_name','=','detail_simpanan_table')
        ->get();

        $bukti= "KPRI".$tanggal->year.$tanggal->month.$tanggal->day.$currentid[0]->AUTO_INCREMENT."SIMP";

        $id_simpan = DB::table('simpanan_table')
        ->where('member_table_id',"=",$request->namasearch)
        ->select('id_simpanan')
        ->first();

         DB::insert('insert into detail_simpanan_table (jenis_simpanan_table_id, saldo, simpanan_table_id, jurnal_umum_table_id, no_bukti, tanggal) values (?, ?, ?, ?, ?, ?)',
         [2,$request->nominal,$id_simpan->id_simpanan,getIdLatest('jurnal_umum_table'),$bukti, $request->tanggal]);

         DB::insert('insert into notifikasi (admin_table_id ,content , status, member_table_id, tanggal) values (?, ?, ? , ?, ?)',
         [Session::get('id_admin') , "Transaksi Simpanan Wajib Anggota Sebesar ".$request->nominal." Berhasil Ditambahkan Dengan Bukti Pembayaran : ".$bukti , 1, $request->namasearch, date("Y-m-d")]);

        return view("layout/bukti/simpanan",["nama"=>$request->nama ,"bukti"=>$bukti,"nominal"=>$request->nominal,"jenis"=>"Wajib" ])->with("success","Berhasil ditambah ke Data");
    }



    public function addSukarela(Request $request)
    {
        $this->validate($request, [
            'namasearch'    => 'required',
            'tanggal'       => 'required',
            'keterangan'    => 'required',
            'nominal'       => 'required|digits_between:4,10',

        ]);

        $tanggal = Carbon::now();

        DB::table('jasa_shu_table')->where('member_table_id', '=', $request->namasearch)->increment('modal', $request->nominal);

        DB::insert('insert into jurnal_umum_table (keterangan,tanggal,periode_table_id) values (?, ?, ?)',
        [$request->keterangan,$request->tanggal,getIdLatest('periode_table')]);

        DB::insert('insert into detail_jurnal_umum (jurnal_umum_table_id,detail_perkiraan_id, debit, kredit, id_admin) values (?, ?, ? , ?, ?)',
        [getIdLatest('jurnal_umum_table') , 1 , $request->nominal, 0, Session::get('id_admin')]);

        DB::insert('insert into detail_jurnal_umum (jurnal_umum_table_id,detail_perkiraan_id, debit, kredit, id_admin) values (?, ?, ? , ?, ?)',
        [getIdLatest('jurnal_umum_table') , 16 , 0, $request->nominal , Session::get('id_admin')]);

        DB::table('detail_perkiraan_table')->where('id', '=', 1)->increment('jumlah_perkiraan', $request->nominal);
        DB::table('detail_perkiraan_table')->where('id', '=', 16)->increment('jumlah_perkiraan', $request->nominal);

        $currentid = DB::table('INFORMATION_SCHEMA.tables')
        ->select('AUTO_INCREMENT')
        ->where('table_name','=','detail_simpanan_table')
        ->get();

        $bukti= "KPRI".$tanggal->year.$tanggal->month.$tanggal->day.$currentid[0]->AUTO_INCREMENT."SIMP";

        $id_simpan = DB::table('simpanan_table')
        ->where('member_table_id',"=",$request->namasearch)
        ->select('id_simpanan')
        ->first();

         DB::insert('insert into detail_simpanan_table (jenis_simpanan_table_id, saldo, simpanan_table_id, jurnal_umum_table_id, no_bukti, tanggal) values (?, ?, ?, ?, ?, ?)',
         [3,$request->nominal,$id_simpan->id_simpanan,getIdLatest('jurnal_umum_table'),$bukti, $request->tanggal]);

         DB::insert('insert into notifikasi (admin_table_id ,content , status, member_table_id, tanggal) values (?, ?, ? , ?, ?)',
         [Session::get('id_admin') , "Transaksi Simpanan Sukarela Sebesar Rp.".$request->nominal." Berhasil Ditambahkan Dengan Bukti Pembayaran : ".$bukti , 1, $request->namasearch, date("Y-m-d")]);


        return view("layout/bukti/simpanan",["nama"=>$request->nama ,"bukti"=>$bukti,"nominal"=>$request->nominal,"jenis"=>"Sukarela" ])->with("success","Berhasil ditambah ke Data");

    }



    public function test(Request $request)
    {
        /*$shu = DB::select("(SELECT ((sum(CASE WHEN perkiraan_table_id = ? THEN jumlah_perkiraan ELSE 0 END))".
        " - (sum(CASE WHEN perkiraan_table_id = ? THEN jumlah_perkiraan ELSE 0 END))) AS s FROM detail_perkiraan_table)",[6,7]);
        $aktiva = DB::select("SELECT sum(CASE WHEN perkiraan_table_id = ? THEN jumlah_perkiraan ELSE 0 END)  AS s FROM detail_perkiraan_table",[1]);


        $hutang = DB::select("SELECT sum(CASE WHEN perkiraan_table_id = ? THEN jumlah_perkiraan ELSE 0 END) AS s FROM detail_perkiraan_table",[4]);
        $pendapatan = DB::select("SELECT sum(CASE WHEN perkiraan_table_id = ? THEN jumlah_perkiraan ELSE 0 END) AS s FROM detail_perkiraan_table",[5]);
        $modal = DB::select("SELECT sum(CASE WHEN id > ? && id < ? THEN jumlah_perkiraan ELSE 0 END) AS s FROM detail_perkiraan_table",[14,18]);
        // 15,16,17
        echo "Rasio Modal<br>";
        print_r( (($shu[0]->s / $modal[0]->s )*100 ));
        echo "<br>Likuiditas<br>";
        print_r((($aktiva[0]->s / $hutang[0]->s )*100 ));
        echo "<br>Provibilitas<br>";
        print_r((($shu[0]->s / $pendapatan[0]->s )*100 ));
        echo "<br>------<br>";

        echo "SHU<br>";
        print_r($shu[0]->s);
        echo "<br>Aktiva<br>";
        print_r($aktiva[0]->s);
        echo "<br>Hutang<br>";
        print_r($hutang[0]->s);
        echo "<br>Pendapatan<br>";
        print_r($pendapatan[0]->s);
        echo "<br>Modal<br>";
        print_r($modal[0]->s);
        echo "<br>------";*/



        /*$data = DB::table('jasa_shu_table')
        ->join('member_table', 'member_table.id', '=', 'jasa_shu_table.member_table_id')
        ->join('status_shu', 'status_shu.id', '=', 'jasa_shu_table.status_shu_id')
        ->select('member_table.id as idmember','full_name','modal','pinjaman','keterangan')
        ->where('member_table.status_member_table','=',1)
        ->orderBy('full_name', 'asc')
        ->get();*/

        /*$data = DB::table('pinjaman_table')
        ->where("member_table_id","LIKE","%76a66e9e-40e5-4386-b70d-4f9ec47c35e5%")
        ->count();*/
//Salma.S.Sos


    /*$request->input('full_name') = "jaka";
    $request->input('username') = "jaka";
    $request->input('jeniskelamin') = 1;
    $request->input('alamat') = "jaka";
    $request->input('telpon') = 08123456;
    $request->input('gaji') = "gaji##";

    echo $request->full_name;*/
    $currentid = DB::table('INFORMATION_SCHEMA.tables')
        ->select('AUTO_INCREMENT')
        ->where('table_name','=','detail_simpanan_table')
        ->get();

        echo $currentid[0]->AUTO_INCREMENT;
    }

    public function datamember()
    {

        $spreadsheet = new Spreadsheet();
        $header = array(
            'font' => [
                'bold' => true,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ]
        );


        $border = array(
			'borders' => [
				'allBorders' => [
					'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
				],
			],
		);

        $dt = Carbon::now();
        $jurnal = new Worksheet($spreadsheet, 'Id');
        $jurnal->getColumnDimension('A')->setAutoSize(true);
        $jurnal->getColumnDimension('B')->setAutoSize(true);

        $data = DB::table('member_table')
        ->select('full_name','id')
        ->get();

        $i=1;


        foreach ($data as $d ) {

                $jurnal->setCellValue('A'.$i, $d->full_name);
                $jurnal->setCellValue('B'.$i, $d->id);
                $i++;
            }

        $spreadsheet->addSheet($jurnal, 1);


        $writer = new Xlsx($spreadsheet);

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Data_Id.xlsx"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
    }
}
