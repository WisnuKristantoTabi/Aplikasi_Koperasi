<?php

namespace App\Http\Controllers;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;

class JurnalUmum extends Controller
{
    public function index(Request $request)
    {
        if ($request->pti) {
            $data = DB::table('jurnal_umum_table')
            ->join('detail_jurnal_umum', 'jurnal_umum_table.id', '=', 'detail_jurnal_umum.jurnal_umum_table_id')
            ->join('detail_perkiraan_table', 'detail_perkiraan_table.id', '=', 'detail_jurnal_umum.detail_perkiraan_id')
            ->join('admin_table','admin_table.id','=','detail_jurnal_umum.id_admin')
            ->select('nama_perkiraan_detail','tanggal','debit','kredit','full_name')
            ->where('periode_table_id','=',$request->pti)
            ->get();

            $periode = DB::table('periode_table')
            ->select('id','nama_periode')
            ->orderBy('id', 'desc')
            ->get();

            return view('layout/transaksi',['data' =>$data,'periode'=>$periode, 'id_periode'=>$request->pti]);
        }else {
            abort(404);
        }

    }

    public function tambah()
    {
        $perkiraan = DB::table('detail_perkiraan_table')
        ->select('id','perkiraan_table_id','nama_perkiraan_detail', 'nomor_perkiraan')
        ->orderBy('perkiraan_table_id', 'asc')
        ->get();

        $a = [1,10,11,13,14,15,16,17,18,19,20,21];

        foreach ($a as $key) {
            unset($perkiraan[$key]);
        }

        return view("layout/jurnalumum/tambah",["perkiraan"=>$perkiraan]);
    }

    public function tambahProses(Request $request)
    {
        $this->validate($request, [
            'keterangan'  => 'required|min:2',
            'debit' => 'required',
            'tanggal' => 'required',
            'kredit'      => 'required',
            'nominal'      => 'required|max:9',
        ]);

        DB::insert('insert into jurnal_umum_table (keterangan,tanggal,periode_table_id) values (?, ?, ?)',
        [$request ->keterangan,$request->tanggal,getIdLatest('periode_table')]);

        DB::insert('insert into detail_jurnal_umum (jurnal_umum_table_id, detail_perkiraan_id , debit, kredit, id_admin) values (?, ?, ? , ?, ?)',
        [getIdLatest('jurnal_umum_table') , $request->debit , $request->nominal,0 , Session::get('id_admin')]);

        DB::insert('insert into detail_jurnal_umum (jurnal_umum_table_id,detail_perkiraan_id, debit, kredit, id_admin) values (?, ?, ? , ?, ?)',
        [getIdLatest('jurnal_umum_table') , $request->kredit , 0, $request->nominal , Session::get('id_admin')]);


        $akundebit = DB::table('detail_perkiraan_table')
        ->select('perkiraan_table_id')
        ->where('id','=',$request->debit)
        ->first();

        $akunkredit = DB::table('detail_perkiraan_table')
        ->select('perkiraan_table_id')
        ->where('id','=',$request->kredit)
        ->first();

        echo $akundebit->perkiraan_table_id."<br>";
        echo $akunkredit->perkiraan_table_id."<br>";


        if( ($akundebit->perkiraan_table_id <4 ) || ($akundebit->perkiraan_table_id == 6 )){
            DB::table('detail_perkiraan_table')->where('id', '=', $akundebit->perkiraan_table_id)->increment('jumlah_perkiraan', $request->nominal);
        }
        else {
            DB::table('detail_perkiraan_table')->where('id', '=', $akundebit->perkiraan_table_id)->decrement('jumlah_perkiraan', $request->nominal);
        }

        if( ($akunkredit->perkiraan_table_id == 4) || ($akunkredit->perkiraan_table_id == 5) || ($akunkredit->perkiraan_table_id == 7)){
            DB::table('detail_perkiraan_table')->where('id', '=', $akunkredit->perkiraan_table_id)->increment('jumlah_perkiraan', $request->nominal);
        }
        else {
            DB::table('detail_perkiraan_table')->where('id', '=', $akunkredit->perkiraan_table_id)->decrement('jumlah_perkiraan', $request->nominal);
        }

        return redirect("jurnal-umum/?pti=".getIdLatest("periode_table"))->with("success","Data Berhasil Ditambahkan");

    }


    public function cetakLaporan(Request $request)
    {
        if (!$request->pti) {
            abort(404);
        }

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
        $jurnal = new Worksheet($spreadsheet, 'SHU');
        $jurnal->getColumnDimension('A')->setAutoSize(true);
        $jurnal->getColumnDimension('B')->setAutoSize(true);
        $jurnal->getColumnDimension('C')->setAutoSize(true);
        $jurnal->getColumnDimension('D')->setAutoSize(true);
        $jurnal->mergeCells('A2:D2')->setCellValue('A2', 'KP-RI  SENTOSA  SMPN 2 MAROS');
        $jurnal->mergeCells('A3:D3')->setCellValue('A3', 'Jurnal Umum');
        $jurnal->mergeCells('A4:D4')->setCellValue('A4',  $request->periode);

        $jurnal->setCellValue('A6', 'Tanggal');
        $jurnal->setCellValue('A7', $dt->year);
        $jurnal->mergeCells('B6:B7')->setCellValue('B6','Keterangan');
        $jurnal->mergeCells('C6:D6')->setCellValue('C6','Saldo');
        $jurnal->setCellValue('C7', 'Debit');
        $jurnal->setCellValue('D7', 'Kredit');

        $data = DB::table('jurnal_umum_table')
        ->join('detail_jurnal_umum', 'jurnal_umum_table.id', '=', 'detail_jurnal_umum.jurnal_umum_table_id')
        ->join('detail_perkiraan_table', 'detail_perkiraan_table.id', '=', 'detail_jurnal_umum.detail_perkiraan_id')
        ->select('tanggal','jurnal_umum_table_id','nama_perkiraan_detail','debit','kredit')
        ->where('periode_table_id','=',$request->pti)
        ->orderBy('jurnal_umum_table.id', 'asc')
        ->get();

        $i=8;
        $jid=1;

        foreach ($data as $d ) {
            if($jid == $d->jurnal_umum_table_id){
                $jurnal->setCellValue('A'.$i, $d->tanggal);
                $jurnal->setCellValue('B'.$i, $d->nama_perkiraan_detail);
                $jurnal->setCellValue('C'.$i, $d->debit);
                $jurnal->setCellValue('D'.$i, $d->kredit);
                $jid=$d->jurnal_umum_table_id;
                $i++;
            }else{
                $jurnal->setCellValue('A'.$i,' ');
                $jurnal->setCellValue('B'.$i,' ');
                $jurnal->setCellValue('C'.$i,' ');
                $jurnal->setCellValue('D'.$i,' ');
                $i++;

                $jurnal->setCellValue('A'.$i, $d->tanggal);
                $jurnal->setCellValue('B'.$i, $d->nama_perkiraan_detail);
                $jurnal->setCellValue('C'.$i, $d->debit);
                $jurnal->setCellValue('D'.$i, $d->kredit);
                $jid=$d->jurnal_umum_table_id;
                $i++;
            }
        }
        $jurnal->mergeCells('A'.($i+2).':B'.($i+2))->setCellValue('A'.($i+2),'Jumlah');
        $jurnal->setCellValue('C'.($i+2),'=SUM(C8:C'.$i.')');
        $jurnal->setCellValue('D'.($i+2),'=SUM(D8:D'.$i.')');


        $spreadsheet->addSheet($jurnal, 1);
        $jurnal->getStyle('A2:D4')->applyFromArray($header);
        $jurnal->getStyle('A6:D'.($i+3))->applyFromArray($border);
        $jurnal->getStyle('C'.($i+3).':D'.($i+3))->applyFromArray($header);
        $jurnal->getStyle('C8'.':D'.($i+3))->getNumberFormat()->setFormatCode('"RP" ###,###,##0,00');

        $writer = new Xlsx($spreadsheet);

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Laporan.xlsx"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
    }
}
