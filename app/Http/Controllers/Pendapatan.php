<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class Pendapatan extends Controller
{
    public function index()
    {
        $data = DB::table('jasa_shu_table')
        ->join('member_table', 'member_table.id', '=', 'jasa_shu_table.member_table_id')
        ->join('status_shu', 'status_shu.id', '=', 'jasa_shu_table.status_shu_id')
        ->select('member_table.id as idmember','jasa_shu_table.id as jstid','status_shu_id','full_name','modal','pinjaman','keterangan')
        ->where('member_table.status_member_table','=',1)
        ->orderBy('full_name', 'asc')
        ->paginate(10);

        $total = DB::table('detail_perkiraan_table')->select('jumlah_perkiraan')->where('id','=',18)->first();
        $total = $total->jumlah_perkiraan;
        $jasa = DB::select("SELECT ((SELECT persen FROM variabel_table WHERE id =?)/100)* $total as anggota", [2]);
        $modal = DB::select("SELECT ((SELECT persen FROM variabel_table WHERE id =?)/100)* $total as modal", [3]);
        $sumjasa = DB::select("SELECT sum(pinjaman) as jml from jasa_shu_table");
        $summodal = DB::select("SELECT sum(modal) as jml from jasa_shu_table");

        $summodal = $summodal[0]->jml >0 ? $summodal[0]->jml:1 ;
        $sumjasa = $sumjasa[0]->jml >0 ? $sumjasa[0]->jml :1 ;

        return view('layout/shu/index',['data'=>$data, 'jasa'=>$jasa[0]->anggota, 'modal'=>$modal[0]->modal, 'pajak'=> 10 ,'summodal'=>$summodal ,'sumjasa'=>$sumjasa ]);


        //SELECT ((SELECT persen FROM variabel_table WHERE id =2)/100)* (SELECT ((sum(CASE WHEN perkiraan_table_id = 6 THEN jumlah_perkiraan ELSE 0 END)) - (sum(CASE WHEN perkiraan_table_id = 7
        //THEN jumlah_perkiraan ELSE 0 END))) AS nama FROM detail_perkiraan_table) as total
    }

    public function indexMember()
    {
        $data = DB::table('jasa_shu_table')
        ->select('modal','pinjaman')
        ->where('member_table_id','=',Session::get('id_member'))
        ->first();

        $total = DB::table('detail_perkiraan_table')->select('jumlah_perkiraan')->where('id','=',18)->first();
        $total = $total->jumlah_perkiraan;

        $sumjasa = DB::select("SELECT sum(pinjaman) as jml from jasa_shu_table");
        $summodal = DB::select("SELECT sum(modal) as jml from jasa_shu_table");


        $jasa = DB::select("SELECT ((SELECT persen FROM variabel_table WHERE id =?)/100)* $total as anggota", [2]);
        $modal = DB::select("SELECT ((SELECT persen FROM variabel_table WHERE id =?)/100)* $total as modal", [3]);

        $jasabersih = $jasa[0]->anggota - ($jasa[0]->anggota * (10/100) ) ;
        $modalbersih = $modal[0]->modal - ($modal[0]->modal * (10/100) );

         $m =( ( $summodal[0]->jml >0 ? $data->modal/($summodal[0]->jml) :0 ) *$modalbersih);
         $j =( ( $sumjasa[0]->jml >0 ? $data->pinjaman/($sumjasa[0]->jml) :0) *$jasabersih);

         //echo $m;
        return view("/layoutmember/shu/shu-member",['jasa'=>floor($j) , 'modal'=>floor($m)]);
    }


    public function cetakSHUDiterima()
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

        $shu = new Worksheet($spreadsheet, 'SHU');
        $shu->getColumnDimension('A')->setAutoSize(true);
        $shu->getColumnDimension('B')->setAutoSize(true);
        $shu->getColumnDimension('C')->setAutoSize(true);
        $shu->getColumnDimension('D')->setAutoSize(true);
        $shu->getColumnDimension('E')->setAutoSize(true);
        $shu->getColumnDimension('F')->setAutoSize(true);
        $shu->mergeCells('A2:F2')->setCellValue('A2', 'KP-RI  SENTOSA  SMPN 2 MAROS');
        $shu->mergeCells('A3:F3')->setCellValue('A3', 'DAFTAR JUMLAH SHU YANG DITRIMA PADA UNIT SIMPAN PINJAM');
        $shu->mergeCells('A4:F4')->setCellValue('A4', 'Tanggal');
        $shu->setCellValue('A6', 'NO');
        $shu->setCellValue('B6', 'Nama');
        $shu->setCellValue('C6', 'Jasa Modal');
        $shu->setCellValue('D6', 'Jasa Pinjaman');
        $shu->setCellValue('E6', 'SHU Diterima');
        $shu->setCellValue('F6', 'Keterangan');

        $data = DB::table('jasa_shu_table')
        ->join('member_table', 'member_table.id', '=', 'jasa_shu_table.member_table_id')
        ->join('status_shu', 'status_shu.id', '=', 'jasa_shu_table.status_shu_id')
        ->select('full_name','modal','pinjaman','keterangan')
        ->where('member_table.status_member_table','=',1)
        ->orderBy('full_name', 'asc')
        ->get();

        $total = DB::table('detail_perkiraan_table')->select('jumlah_perkiraan')->where('id','=',18)->first();
        $total = $total->jumlah_perkiraan;
        $jasa = DB::select("SELECT ((SELECT persen FROM variabel_table WHERE id =?)/100)* $total as anggota", [2]);
        $modal = DB::select("SELECT ((SELECT persen FROM variabel_table WHERE id =?)/100)* $total as modal", [3]);
        $sumjasa = DB::select("SELECT sum(pinjaman) as jml from jasa_shu_table");
        $summodal = DB::select("SELECT sum(modal) as jml from jasa_shu_table");

        $jasa = $jasa[0]->anggota - ( $jasa[0]->anggota * (10/100) );
        $modal= $modal[0]->modal - ( $modal[0]->modal * (10/100) ) ;

        $summodal = $summodal[0]->jml >0 ? $summodal[0]->jml:1 ;
        $sumjasa = $sumjasa[0]->jml >0 ? $sumjasa[0]->jml :1 ;

        $i=7;

        foreach ($data as $no=>$d ) {
            $j = ($d->pinjaman/$sumjasa) ;
            $shu->setCellValue('A'.$i, ($no+1));
            $shu->setCellValue('B'.$i, $d->full_name);
            $shu->setCellValue('C'.$i, ($d->modal/ $summodal )*($modal));
            $shu->setCellValue('D'.$i, ($d->pinjaman/($sumjasa))*($jasa));
            $shu->setCellValue('E'.$i, '=C'.$i.'+D'.$i);
            $shu->setCellValue('F'.$i, $d->keterangan);
            $i++;
        }
        $shu->setCellValue('A'.($i+2),'');
        $shu->setCellValue('B'.($i+2),'Jumlah');
        $shu->setCellValue('C'.($i+2),'=SUM(C7:C'.($i+2).')');
        $shu->setCellValue('D'.($i+2),'=SUM(D7:D'.($i+2).')');
        $shu->setCellValue('E'.($i+2),'=SUM(E7:E'.($i+2).')');
        $shu->setCellValue('F'.($i+2),'');


        $spreadsheet->addSheet($shu, 1);
        $shu->getStyle('A2:F4')->applyFromArray($header);
        $shu->getStyle('A6:F'.($i+3))->applyFromArray($border);
        $shu->getStyle('C'.($i+3).':E'.($i+3))->applyFromArray($header);
        $shu->getStyle('C6'.':E'.($i+3))->getNumberFormat()->setFormatCode('"RP" ###,###,##0,00');

        $writer = new Xlsx($spreadsheet);

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Laporan_SHU_Yang_Diterima.xlsx"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');

    }

    public function cetakPembagianSHU()
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

        $shu = new Worksheet($spreadsheet, 'SHU');
        $shu->getColumnDimension('A')->setAutoSize(true);
        $shu->getColumnDimension('B')->setAutoSize(true);
        $shu->getColumnDimension('C')->setAutoSize(true);
        $shu->getColumnDimension('D')->setAutoSize(true);
        $shu->getColumnDimension('E')->setAutoSize(true);
        $shu->mergeCells('A2:E2')->setCellValue('A2', 'KP-RI  SENTOSA  SMPN 2 MAROS');
        $shu->mergeCells('A3:E3')->setCellValue('A3', 'DAFTAR PEMBAGIAN SHU');
        $shu->mergeCells('A4:E4')->setCellValue('A4', "---");

        $data = DB::table('variabel_table')
        ->where('id','>',1)
        ->where('id','<',8)
        ->get();


        $total = DB::table('detail_perkiraan_table')->select('jumlah_perkiraan')->where('id','=',18)->first();
        $total = $total->jumlah_perkiraan;
        $i=6;
        $jumlah = 0;

        foreach ($data as $no=>$d ) {

            $shu->setCellValue('A'.$i, ($no+1));
            $shu->setCellValue('B'.$i, $d->keterangan);
            $shu->setCellValue('C'.$i, $total);
            $shu->setCellValue('D'.$i, $d->persen." %");
            $shu->setCellValue('E'.$i, ($total * ($d->persen /100)) );
            if ($d->kena_pajak == 1) {
                $jumlah = $jumlah + ($total * ($d->persen /100)) ;
            }
            $i++;
        }

        $shu->mergeCells('A'.($i+1).':D'.($i+1))->setCellValue('A'.($i+1),'Jumlah = ');
        $shu->setCellValue('E'.($i+1),'=SUM(E6:E'.$i.')');


        $shu->setCellValue('A'.($i+2), '');
        $shu->setCellValue('B'.($i+2), "PPh DARI SHU YANG DIBAGI");
        $shu->setCellValue('C'.($i+2), $jumlah);
        $shu->setCellValue('D'.($i+2), "10 %");
        $shu->setCellValue('E'.($i+2), ($jumlah * (10 /100)) ) ;


        $spreadsheet->addSheet($shu, 1);
        $shu->getStyle('A2:E4')->applyFromArray($header);
        $shu->getStyle('A6:E'.($i+3))->applyFromArray($border);
        $shu->getStyle('C'.($i+3).':E'.($i+3))->applyFromArray($header);
        $shu->getStyle('C6'.':C'.($i+3))->getNumberFormat()->setFormatCode('"RP" ###,###,##0,00');
        $shu->getStyle('E6'.':E'.($i+3))->getNumberFormat()->setFormatCode('"RP" ###,###,##0,00');

        $writer = new Xlsx($spreadsheet);

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Laporan_Pembagian_SHU.xlsx"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');

    }

    public function cetakSHU()
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

        $shu = new Worksheet($spreadsheet, 'SHU');
        $shu->getColumnDimension('A')->setAutoSize(true);
        $shu->getColumnDimension('B')->setAutoSize(true);
        $shu->getColumnDimension('C')->setAutoSize(true);
        $shu->getColumnDimension('D')->setAutoSize(true);
        $shu->getColumnDimension('E')->setAutoSize(true);
        $shu->mergeCells('A2:E2')->setCellValue('A2', 'KP-RI  SENTOSA  SMPN 2 MAROS');
        $shu->mergeCells('A3:E3')->setCellValue('A3', 'SISA HASIL USAHA USP');
        $shu->mergeCells('A4:E4')->setCellValue('A4', 'Tanggal');
        $shu->setCellValue('A6', 'NO PKRN');
        $shu->setCellValue('B6', 'Perkiraan');
        $shu->setCellValue('C6', 'Beban');
        $shu->setCellValue('D6', '      ');
        $shu->setCellValue('E6', 'Pendapatan');
        $data = DB::table('detail_perkiraan_table')
        ->where('perkiraan_table_id', 6)
        ->get();

        $i = 7 ;
        foreach ($data as $d ) {
            $shu->setCellValue('A'.$i, $d->nomor_perkiraan);
            $shu->setCellValue('B'.$i, $d->nama_perkiraan_detail);
            $shu->setCellValue('C'.$i, "   ");
            $shu->setCellValue('D'.$i, "   ");
            $shu->setCellValue('E'.$i, $d->jumlah_perkiraan);
            $i++;
        }
        $jumlah = DB::table('detail_perkiraan_table')
        ->select('perkiraan_table_id',DB::raw('SUM(jumlah_perkiraan) as jp'))
        ->groupBy('perkiraan_table_id')
        ->havingRaw('perkiraan_table_id > ?', [5])
        ->orderBy('perkiraan_table_id', 'asc')
        ->get();

        $shu->setCellValue('B'.$i, "JUMLAH");
        $shu->setCellValue('D'.$i, "Jumlah:");
        $shu->setCellValue('E'.$i, $jumlah[0]->jp );

        $i++;

        $data = DB::table('detail_perkiraan_table')->where('perkiraan_table_id', 7)->get();

        foreach ($data as $d ) {
            $shu->setCellValue('A'.$i, $d->nomor_perkiraan);
            $shu->setCellValue('B'.$i, $d->nama_perkiraan_detail);
            $shu->setCellValue('C'.$i, $d->jumlah_perkiraan);
            $shu->setCellValue('D'.$i, "   ");
            $shu->setCellValue('E'.$i, "   ");
            $i++;
        }

        $shu->setCellValue('B'.($i+2), "JUMLAH");
        $shu->setCellValue('C'.($i+2), $jumlah[1]->jp);
        $shu->setCellValue('C'.($i+3), "SHU ");
        $shu->mergeCells('D'.($i+3).':E'.($i+3))->setCellValue('D'.($i+3),(($jumlah[0]->jp)-($jumlah[1]->jp)));
        $spreadsheet->addSheet($shu, 2);
        $shu->getStyle('A2:E4')->applyFromArray($header);
        $shu->getStyle('A6:E'.($i+3))->applyFromArray($border);
        $shu->getStyle('C'.($i+3).':E'.($i+3))->applyFromArray($header);
        $shu->getStyle('C6'.':E'.($i+3))->getNumberFormat()->setFormatCode('"RP" ###,###,##0,00');

        $writer = new Xlsx($spreadsheet);

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="LaporanSHU.xlsx"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
    }



    public function search(Request $request){
        $data = DB::table('jasa_shu_table')
        ->join('member_table', 'member_table.id', '=', 'jasa_shu_table.member_table_id')
        ->join('status_shu', 'status_shu.id', '=', 'jasa_shu_table.status_shu_id')
        ->select('member_table.id as idmember','jasa_shu_table.id as jstid','status_shu_id','full_name','modal','pinjaman','keterangan')
        ->when($request->q, function ($query) use ($request) {
                $query->where('full_name', 'LIKE', "%{$request->q}%");
                })->paginate(10);


         $data->appends($request->only('q'));

         $total = DB::select("(SELECT ((sum(CASE WHEN perkiraan_table_id = ? THEN jumlah_perkiraan ELSE 0 END)) - (sum(CASE WHEN perkiraan_table_id = ? THEN jumlah_perkiraan ELSE 0 END))) AS total FROM detail_perkiraan_table)",[6,7]);
         $total = $total[0]->total;
         $jasa = DB::select("SELECT ((SELECT persen FROM variabel_table WHERE id =?)/100)* $total as anggota", [2]);
         $modal = DB::select("SELECT ((SELECT persen FROM variabel_table WHERE id =?)/100)* $total as modal", [3]);
         $sumjasa = DB::select("SELECT sum(pinjaman) as jml from jasa_shu_table");
         $summodal = DB::select("SELECT sum(modal) as jml from jasa_shu_table");

         $summodal = $summodal[0]->jml >0 ? $summodal[0]->jml:1 ;
         $sumjasa = $sumjasa[0]->jml >0 ? $sumjasa[0]->jml :1 ;

        if(!$data->isEmpty()) {
            return view('layout/shu/index',['data'=>$data, 'jasa'=>$jasa[0]->anggota, 'modal'=>$modal[0]->modal, 'pajak'=> 10, 'sumjasa'=>$sumjasa , 'summodal'=>$summodal ]);
            //return view('search', ['search' => $search, 'q' => $request->q]);
        }else{
            return redirect()
            ->back();
        }
    }

    public function pembayaran(){
        return view ("/layout/bayar/index");
    }

    function rupiah($angka){

	$hasil_rupiah = "Rp " . number_format($angka,0,',','.');
	return $hasil_rupiah;

    }
    public function delete(){

    }


    public function searchDetail(Request $request){
        if($request->ajax()){
            $output="";
            $cari =DB::table('pinjaman_table')
            ->where('member_table_id','LIKE','%'.$request->search."%")
            ->count();

            if ($cari >0) {
                $data=DB::table('pinjaman_table')
                ->join('detail_pinjaman_table','detail_pinjaman_table.pinjaman_table_id','=','pinjaman_table.id')
                ->join('jenis_pinjaman_table','jenis_pinjaman_table.id','=','detail_pinjaman_table.jenis_pinjaman_table_id')
                ->join('member_table','member_table.id','=','pinjaman_table.member_table_id')
                ->where('member_table_id','LIKE','%'.$request->search."%")
                ->select('tanggal','jumlah_pinjaman','jumlah_bunga','no_bukti','full_name','pinjaman_table.id as pid','jumlah_angsuran','nama','jenis_pinjaman_table_id')
                ->get();
            }else {
                $data=DB::table('pinjaman_table')
                ->join('detail_pinjaman_table','detail_pinjaman_table.pinjaman_table_id','=','pinjaman_table.id')
                ->join('jenis_pinjaman_table','jenis_pinjaman_table.id','=','detail_pinjaman_table.jenis_pinjaman_table_id')
                ->join('nonmember_table','nonmember_table.id','=','pinjaman_table.nonmember_table_id')
                ->where('nonmember_table_id','LIKE','%'.$request->search."%")
                ->select('tanggal','jumlah_pinjaman','jumlah_bunga','no_bukti','full_name','pinjaman_table.id as pid','jumlah_angsuran','nama','jenis_pinjaman_table_id')
                ->get();
            }

            if(!$data->isEmpty()){
                foreach ($data as $key =>$d) {
                    $output.='<tr>'.
                    '<td><a href="#formulirPinjaman" data-toggle="modal">'.$d->tanggal.'</a></td>'.
                    '<td>'.Pendapatan::rupiah($d->jumlah_pinjaman).'</td><td>'.$d->no_bukti.'</td><td>';

                    if ($d->jumlah_angsuran == null) {
                        $output.= " - " ;
                    }else {
                        $output.= Pendapatan::rupiah((($d->jumlah_pinjaman/$d->jumlah_angsuran) +$d->jumlah_bunga)) ;
                    }

                    $output.='</td><td>'.$d->nama.' / <br>'.$d->full_name.'</td>'.
                    '<td>'.
                    '<div class="mb-3 mr-3">';
                    if($d->jenis_pinjaman_table_id == 1){
                        $output.='<a href="/transaksi-list-angsuran-anggota?m='.$d->pid;
                    }elseif($d->jenis_pinjaman_table_id == 2) {
                        $output.='<a href="/transaksi-list-angsuran-sementara?m='.$d->pid;
                    }elseif($d->jenis_pinjaman_table_id == 3){
                        $output.='<a href="/transaksi-list-angsuran-non-anggota?m='.$d->pid;
                    }

                     $output.='"class="btn btn-info"><i class="fas fa-eye"></i>Detail</a></div>'.
                    '<div class="mb-3 mr-3"><a href="/transaksi-hapuspinjaman?pti='.$d->pid.'" class="btn btn-danger" ><i class="fas fa-trash-alt"></i>.
                    Hapus</a></div>'.
                    '</td>'.
                    '</tr>';


                }
            }else {
                $output.='<tr><td colspan="5"><p class="text-center text-dark font-italic">Data Tidak Ditemukan</p></td></tr>';
            }
            return Response($output);
        }
    }

    public function acceptAll()
    {
        DB::table('jasa_shu_table')
        ->update(['status_shu_id' => 2]);

        return redirect()->back();
    }

    public function accept(Request $request)
    {
        DB::table('jasa_shu_table')
        ->where('id','=',$request->jstid)
        ->update(['status_shu_id' => 2]);

        return redirect()->back();
    }

    public function tutupSaldo()
    {
        $tanggal = Carbon::now();

        DB::insert('insert into jurnal_umum_table (keterangan,tanggal,periode_table_id) values (?, ?, ?)',
        ["Bayar SHU ".$tanggal->year ,$tanggal->toDateString(),getIdLatest('periode_table')]);

        DB::insert('insert into detail_jurnal_umum (jurnal_umum_table_id, detail_perkiraan_id , debit, kredit) values (?, ?, ? , ?)',
        [getIdLatest('jurnal_umum_table') , 2 , $request->inputpinjaman,0 ]);

        DB::insert('insert into detail_jurnal_umum (jurnal_umum_table_id,detail_perkiraan_id, debit, kredit) values (?, ?, ? , ?)',
        [getIdLatest('jurnal_umum_table') , 1 , 0, $request->inputpinjaman ]);

        //return redirect()->back();
    }
}
