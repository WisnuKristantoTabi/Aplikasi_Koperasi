<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Codedge\Fpdf\Fpdf\Fpdf;
use Carbon\Carbon;
use App\Exports\CetakPDF;

class CetakBiodata extends Controller
{
    public function cetakPDF(Request $request)
    {

        $todayDate = Carbon::now();

        $pdf = new CetakPDF();
        $pdf->AliasNbPages();
        $pdf->AddPage();
        $pdf->SetLineWidth(0.8);
        $pdf->SetDash(); //restore no dash
        $pdf->Line(10, 30, 200, 30);
        $pdf->SetFont('Times','B',18);
        $pdf->Cell(180,12,'Formulir Bukti Pendaftaran Member',0,1,'C');
        $pdf->Ln(10);
        $pdf->SetFont('Times','',14);
        $pdf->Cell(40,12,"Nama Pemohon",0,0);
        $pdf->Cell(40,12,": ".$request->full_name,0,1);
        $pdf->Cell(40,12,"Username",0,0);
        $pdf->Cell(40,12,": ".$request->username,0,1);
        $pdf->Cell(40,12,"Password",0,0);
        $pdf->Cell(40,12,": ".$request->password,0,1);
        $pdf->Cell(40,12,"Login Sebagai",0,0);
        $pdf->Cell(40,12,": ".$request->role,0,1);
        $pdf->Cell(100,12,"Telah Membayar Simpanan Pokok Sebesar Rp. 100.000, ",0,1);
        $pdf->Cell(40,12,"Dengan Bukti Pembayaran : ".$request->bukti,0,1);
        $pdf->Ln(30);
        $pdf->Cell(180,12,"Maros, ".$todayDate->format('j F Y '),0,1,'R');
        $pdf->Ln(5);
        $pdf->Cell(180,12,"Mengetahui, ",0,1,'R');
        $pdf->Ln(5);
        $pdf->Cell(10,6,'',0,0);
        $pdf->Cell(65,6,'Ketua Koperasi',0,0,'C');
        $pdf->Cell(50,6,'',0,0);
        $pdf->Cell(50,6,'Pemohon',0,1,'C');
        $pdf->Ln(40);
        $pdf->Cell(10,6,'',0,0);
        $pdf->Cell(65,6,'Abdul Haris, S.Pd',0,0,'C');
        $pdf->Cell(50,6,'',0,0);
        $pdf->Cell(50,6,$request->full_name,0,1,'C');
        $pdf->Output();

        exit;
    }
}
