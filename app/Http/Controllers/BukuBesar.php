<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class BukuBesar extends Controller
{
    public function index(Request $request)
    {
        if (($request->i) &&($request->pti)) {
        $data = DB::table('jurnal_umum_table')
        ->join('detail_jurnal_umum', 'jurnal_umum_table.id', '=', 'detail_jurnal_umum.jurnal_umum_table_id')
        ->select('tanggal','keterangan','debit','kredit')
        ->where("detail_perkiraan_id","=",$request->i)
        ->where("periode_table_id","=",$request->pti)
        ->get();

        $perkiraan = DB::table('detail_perkiraan_table')
        ->select('id','perkiraan_table_id','nama_perkiraan_detail', 'nomor_perkiraan')
        ->orderBy('perkiraan_table_id', 'asc')
        ->get();

        $periode = DB::table('periode_table')
        ->select('id','nama_periode')
        ->orderBy('id', 'desc')
        ->get();

        $detail = DB::table('detail_perkiraan_table')
        ->select('nama_perkiraan_detail','nomor_perkiraan')
        ->where("id","=",$request->i)
        ->first();

        return view('/layout/bukubesar',['data' => $data,'id_akun'=>$request->i, 'detail' => $detail, 'perkiraan' => $perkiraan, 'periode'=>$periode, 'id_periode'=>$request->pti] );

        }else {
            abort(404);
        }
    }

    public function cetakLaporan(Request $request){


        if (($request->i) &&($request->pti)) {

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

        $jurnal = new Worksheet($spreadsheet, 'Buku Besar');
        $jurnal->getColumnDimension('A')->setAutoSize(true);
        $jurnal->getColumnDimension('B')->setAutoSize(true);
        $jurnal->getColumnDimension('C')->setAutoSize(true);
        $jurnal->getColumnDimension('D')->setAutoSize(true);
        $jurnal->getColumnDimension('E')->setAutoSize(true);
        $jurnal->getColumnDimension('F')->setAutoSize(true);
        $jurnal->mergeCells('A2:F2')->setCellValue('A2', 'KP-RI  SENTOSA  SMPN 2 MAROS');
        $jurnal->mergeCells('A3:F3')->setCellValue('A3', 'Buku Besar '.$request->akun);
        $jurnal->mergeCells('A4:F4')->setCellValue('A4',  $request->periode);
        $jurnal->mergeCells('A6:A7')->setCellValue('A6','Tanggal');
        $jurnal->mergeCells('B6:B7')->setCellValue('B6','Keterangan');
        $jurnal->mergeCells('C6:C7')->setCellValue('C6','Debit');
        $jurnal->mergeCells('D6:D7')->setCellValue('D6','Kredit');
        $jurnal->mergeCells('E6:F6')->setCellValue('E6','Saldo');
        $jurnal->setCellValue('E7', 'Debit');
        $jurnal->setCellValue('F7', 'Kredit');


        $data = DB::table('jurnal_umum_table')
        ->join('detail_jurnal_umum', 'jurnal_umum_table.id', '=', 'detail_jurnal_umum.jurnal_umum_table_id')
        ->select('tanggal','keterangan','debit','kredit')
        ->where("detail_perkiraan_id","=",$request->i)
        ->where("periode_table_id","=",$request->pti)
        ->get();

        $i=8;
        $jid=1;
        $total = 0 ;

        foreach ($data as $d ) {
            $total = $total + $d->debit;
            $jurnal->setCellValue('A'.$i, $d->tanggal);
            $jurnal->setCellValue('B'.$i, $d->keterangan);
            $jurnal->setCellValue('C'.$i, $d->debit);
            $jurnal->setCellValue('D'.$i, $d->kredit);

            $jurnal->setCellValue('F'.$i, $d->kredit);
            if ($d->debit != 0) {
                if($total < 0){
                    $jurnal->setCellValue('E'.$i, $total * (-1));
                }else{
                    $jurnal->setCellValue('E'.$i, $total);
                }
            }else {
                $jurnal->setCellValue('E'.$i, 0);
            }


            $total = $total - $d->kredit;
            if ($d->kredit != 0) {
                if($total < 0){
                    $jurnal->setCellValue('F'.$i, $total * (-1));
                }else{
                    $jurnal->setCellValue('F'.$i, $total);
                }
            }else {
                $jurnal->setCellValue('F'.$i, 0);
            }
            $i++;
        }

        $jurnal->mergeCells('A'.($i+2).':D'.($i+2))->setCellValue('A'.($i+2),'Jumlah');
        $jurnal->mergeCells('E'.($i+2).':F'.($i+2))->setCellValue('E'.($i+2),$total);


        $spreadsheet->addSheet($jurnal, 1);
        $jurnal->getStyle('A2:F4')->applyFromArray($header);
        $jurnal->getStyle('A6:F'.($i+3))->applyFromArray($border);
        $jurnal->getStyle('E'.($i+3).':F'.($i+3))->applyFromArray($header);
        $jurnal->getStyle('C8'.':F'.($i+3))->getNumberFormat()->setFormatCode('"RP" ###,###,##0,00');

        $writer = new Xlsx($spreadsheet);

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Laporan_BukuBesar.xlsx"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
    }else{
        abort(404);
    }

    }
}
