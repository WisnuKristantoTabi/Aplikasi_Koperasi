<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class CetakLaporanNeraca extends Controller
{

    public function cetak()
    {
        $spreadsheet = new Spreadsheet();
        $cetakLaporan = new CetakLaporanNeraca();

        $cetakLaporan->neraca($spreadsheet);
        $spreadsheet->getActiveSheet();


        /*
        Kas
        Buku Besar
        Sisa Hasil Usaha
        Piutang
        Pendapatan
        Neraca
        Simpanan
        */

        $writer = new Xlsx($spreadsheet);

        header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="Neraca.xlsx"');
		header('Cache-Control: max-age=0');
        $writer->save('php://output//Neraca.xlsx');

        echo"<meta http-equiv='refresh' content='0;url=Neraca.xlsx'/>";
    }

    function neraca($spreadsheet)
    {
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

        $todayDate = Carbon::now();

        $neraca = new Worksheet($spreadsheet, 'Neraca');
        $neraca->getColumnDimension('A')->setAutoSize(true);
        $neraca->getColumnDimension('B')->setAutoSize(true);
        $neraca->getColumnDimension('C')->setAutoSize(true);
        $neraca->getColumnDimension('D')->setAutoSize(true);
        $neraca->getColumnDimension('E')->setAutoSize(true);
        $neraca->getColumnDimension('F')->setAutoSize(true);
        $neraca->mergeCells('A2:F2')->setCellValue('A2', 'KP-RI  SENTOSA  SMPN 2 MAROS');
        $neraca->mergeCells('A3:F3')->setCellValue('A3', 'Neraca');
        $neraca->mergeCells('A4:F4')->setCellValue('A4', $todayDate->format('F').", ".$todayDate->year);
        $neraca->setCellValue('A6', 'NO PKRN');
        $neraca->setCellValue('B6', 'Nama Perkiraan');
        $neraca->setCellValue('C6', 'SALDO');
        $no =7 ;

        $aktiva = DB::table('detail_perkiraan_table')
        ->where('perkiraan_table_id','<','4')
        ->get();

        foreach ($aktiva as $d ) {
            $neraca->setCellValue('A'.$no, $d->nomor_perkiraan);
            $neraca->setCellValue('B'.$no, $d->nama_perkiraan_detail);
            $neraca->setCellValue('C'.$no, $d->jumlah_perkiraan);
            $no++;
        }

        $neraca->setCellValue('D6', 'NO PKRN');
        $neraca->setCellValue('E6', 'Nama Perkiraan');
        $neraca->setCellValue('F6', 'SALDO');


        $passiva = DB::table('detail_perkiraan_table')
        ->where('perkiraan_table_id','=','4')
        ->orwhere('perkiraan_table_id','=','5')
        ->get();
        $i =7 ;

        foreach ($passiva as $p ) {
            $neraca->setCellValue('D'.$i, $p->nomor_perkiraan);
            $neraca->setCellValue('E'.$i, $p->nama_perkiraan_detail);
            $neraca->setCellValue('F'.$i, $p->jumlah_perkiraan);
            $i++;
        }

        $j=0;
        if($i>$no){
            $j=$i;
        }else {
            $j=$no;
        }
        $neraca->mergeCells('A'.($j+1).":B".($j+1))->setCellValue('A'.($j+1), "Jumlah Aktiva");
        $neraca->setCellValue('C'.($j+1), "=SUM(C6:C".$j.")");
        $neraca->mergeCells('D'.($j+1).":E".($j+1))->setCellValue('D'.($j+1), "Jumlah Pasiva");
        $neraca->setCellValue('F'.($j+1), "=SUM(F6:F".$j.")");

        $spreadsheet->addSheet($neraca, 0);
        $neraca->getStyle('A2:F4')->applyFromArray($header);
        $neraca->getStyle('A6:F'.($j+3))->applyFromArray($border);
        $neraca->getStyle('C'.($j+3).':F'.($j+3))->applyFromArray($header);
        $neraca->getStyle('C7'.':F'.($j+3))->getNumberFormat()->setFormatCode('"RP" ###,###,##0,00');
    }

}
