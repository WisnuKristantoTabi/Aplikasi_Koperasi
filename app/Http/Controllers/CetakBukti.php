<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Codedge\Fpdf\Fpdf\Fpdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\URL;
use Illuminate\Routing\UrlGenerator;
use App\Exports\CetakPDF;
use Illuminate\Support\Facades\DB;

class CetakBukti extends Controller
{

    public function index()
    {
        $perkiraan = DB::table('detail_perkiraan_table')
        ->select('id','perkiraan_table_id','nama_perkiraan_detail', 'nomor_perkiraan')
        ->orderBy('perkiraan_table_id', 'asc')
        ->get();
        $a = [0,1,13,14,15,17,19,20];

        foreach ($a as $key) {
            unset($perkiraan[$key]);
        }

        return view('layout/bukti/index', ['perkiraan'=>$perkiraan]);
    }



    public function simpanan(Request $request)
    {

        $todayDate = Carbon::now();

        $pdf = new CetakPDF();
        $pdf->AliasNbPages();
        $pdf->AddPage();
        $pdf->SetLineWidth(0.8);
        $pdf->SetDash(); //restore no dash
        $pdf->Line(10, 30, 200, 30);
        $pdf->SetFont('Times','B',18);
        $pdf->Cell(180,12,'Formulir Bukti Simpanan',0,1,'C');
        $pdf->Ln(10);
        $pdf->SetFont('Times','',14);
        $pdf->Cell(40,12,"Nama Pemohon",0,0);
        $pdf->Cell(40,12,": ".$request->nama,0,1);
        $pdf->Cell(40,12,"Jenis Simpanan",0,0);
        $pdf->Cell(40,12,": ".$request->jenis.",",0,1);
        $pdf->Cell(40,12,"Membayar Nominal",0,0);
        $pdf->Cell(40,12,": ".$request->nominal.",",0,1);
        $pdf->Cell(40,12,"dan Bukti Simpanan ",0,0);
        $pdf->Cell(40,12,": ".$request->bukti.",",0,1);
        $pdf->Ln(40);
        $pdf->Cell(180,12,"Maros, ".$todayDate->format('j F Y '),0,1,'R');
        $pdf->Ln(5);
        $pdf->Cell(180,12,"Mengetahui, ",0,1,'R');
        $pdf->Ln(5);
        $pdf->Cell(10,6,'',0,0);
        $pdf->Cell(65,6,'Pemohon',0,0,'C');
        $pdf->Cell(50,6,'',0,0);
        $pdf->Cell(50,6,'Bendahara',0,1,'C');
        $pdf->Ln(40);
        $pdf->Cell(10,6,'',0,0);
        $pdf->Cell(65,6,$request->nama,0,0,'C');
        $pdf->Cell(50,6,'',0,0);
        $pdf->Cell(50,6,'Yohanis Tabi S.Pd,. M.M',0,1,'C');
        $pdf->Output();

        exit;
    }


    public function income(Request $request)
    {
        $request->keteranganKasMasuk;
        $request->perkiraanKasMasuk;
        $request->nominalKasMasuk;
        $todayDate = Carbon::now();


        $pdf = new CetakPDF();
        $pdf->AliasNbPages();
        $pdf->AddPage();
        $pdf->SetLineWidth(0.8);
        $pdf->SetDash(); //restore no dash
        $pdf->Line(10, 30, 200, 30);
        $pdf->SetFont('Times','B',18);
        $pdf->Cell(180,12,'Formulir Bukti Peminjaman',0,1,'C');
        $pdf->Ln(10);
        $pdf->SetFont('Times','',14);
        $pdf->Cell(40,12,"Nama Pemohon",0,0);
        $pdf->Cell(40,12,": ".$nama,0,1);
        $pdf->Cell(40,12,"Jumlah Pinjaman",0,0);
        $pdf->Cell(40,12,": ".$nominal,0,1);
        $pdf->Cell(40,12,"Bunga dikenakan",0,0);
        $pdf->Cell(40,12,": ".$bunga,0,1);
        $pdf->Cell(40,12,"Jumlah Angsuran",0,0);
        $pdf->Cell(40,12,": ".$angsuran,0,1);
        $pdf->Cell(40,12,"Biaya Provisi",0,0);
        $pdf->Cell(40,12,": ".$provisi,0,1);
        $pdf->Ln(40);
        $pdf->Cell(180,12,"Maros, ".$todayDate->format('j F Y '),0,1,'R');
        $pdf->Ln(5);
        $pdf->Cell(180,12,"Mengetahui, ",0,1,'R');
        $pdf->Ln(5);
        $pdf->Cell(10,6,'',0,0);
        $pdf->Cell(65,6,'Pemohon',0,0,'C');
        $pdf->Cell(50,6,'',0,0);
        $pdf->Cell(50,6,'Bendahara',0,1,'C');
        $pdf->Ln(40);
        $pdf->Cell(10,6,'',0,0);
        $pdf->Cell(65,6,$nama,0,0,'C');
        $pdf->Cell(50,6,'',0,0);
        $pdf->Cell(50,6,'Yohanis Tabi S.Pd,. M.M',0,1,'C');
        $pdf->Output();

        exit;

    }


    public function angsuran(Request $request)
    {
        $todayDate = Carbon::now();

        $pdf = new CetakPDF();
        $pdf->AliasNbPages();
        $pdf->AddPage();
        $pdf->SetLineWidth(0.8);
        $pdf->SetDash(); //restore no dash
        $pdf->Line(10, 30, 200, 30);
        $pdf->SetFont('Times','B',18);
        $pdf->Cell(180,12,'Formulir Bukti Angsuran',0,1,'C');
        $pdf->Ln(10);
        $pdf->SetFont('Times','',14);
        $pdf->Cell(40,12,"Nama Pemohon",0,0);
        $pdf->Cell(40,12,": ".$request->nama,0,1);
        $pdf->Cell(40,12,"Keterangan",0,0);
        $pdf->Cell(40,12,": ".$request->keterangan,0,1);
        $pdf->Cell(40,12,"Jumlah Angusran",0,0);
        $pdf->Cell(40,12,": ".$request->angsuran,0,1);
        $pdf->Cell(40,12,"Total Pembayaran",0,0);
        $pdf->Cell(40,12,": ".$request->nominal,0,1);
        $pdf->Cell(40,12,"Nomor Bukti",0,0);
        $pdf->Cell(60,12,": ".$request->bukti,0,1);
        $pdf->Ln(40);
        $pdf->Cell(180,12,"Maros, ".$todayDate->format('j F Y '),0,1,'R');
        $pdf->Ln(5);
        $pdf->Cell(180,12,"Mengetahui, ",0,1,'R');
        $pdf->Ln(5);
        $pdf->Cell(10,6,'',0,0);
        $pdf->Cell(65,6,'Pemohon',0,0,'C');
        $pdf->Cell(50,6,'',0,0);
        $pdf->Cell(50,6,'Bendahara',0,1,'C');
        $pdf->Ln(40);
        $pdf->Cell(10,6,'',0,0);
        $pdf->Cell(65,6,$request->nama,0,0,'C');
        $pdf->Cell(50,6,'',0,0);
        $pdf->Cell(50,6,'Yohanis Tabi S.Pd,. M.M',0,1,'C');
        $pdf->Output();
        exit;
    }

    public function outcome(Request $request)
    {

        $keterangan =$request->keteranganKasKeluar;
        $nominal =$request->nominalKasKeluar;
        $todayDate = Carbon::now();

        $pdf = new CetakPDF();
        $pdf->AliasNbPages();
        $pdf->AddPage();
        $pdf->SetLineWidth(0.8);
        $pdf->SetDash(); //restore no dash
        $pdf->Line(10, 30, 200, 30);
        $pdf->SetFont('Times','B',18);
        $pdf->Cell(180,12,'Bukti Pengeluaran Kas',0,1,'C');
        $pdf->Ln(10);
        $pdf->SetFont('Times','',14);
        $pdf->Cell(40,12,"Diterima dari",0,0);
        $pdf->Cell(40,12,": Bendahara",0,1);
        $pdf->Cell(40,12,"Tunai ",0,0);
        $pdf->Cell(40,12,": ".$nominal,0,1);
        $pdf->Cell(40,12,"Untuk Pembayaran ",0,0);
        $pdf->Cell(40,12,": ".$keterangan,0,1);
        $pdf->Ln(65);
        $pdf->Cell(180,12,"Maros, ".$todayDate->format('j F Y '),0,1,'R');
        $pdf->Ln(5);
        $pdf->Cell(180,12,"Mengetahui, ",0,1,'R');
        $pdf->Ln(5);
        $pdf->Cell(10,6,'',0,0);
        $pdf->Cell(65,6,'Ketua',0,0,'C');
        $pdf->Cell(50,6,'',0,0);
        $pdf->Cell(50,6,'Bendahara',0,1,'C');
        $pdf->Ln(40);
        $pdf->Cell(10,6,'',0,0);
        $pdf->Cell(65,6,'Abdul Haris',0,0,'C');
        $pdf->Cell(50,6,'',0,0);
        $pdf->Cell(50,6,'Yohanis Tabi S.Pd,. M.M',0,1,'C');
        $pdf->Output();

        exit;

        $this->validate($request,[
        'keteranganKasKeluar'=>'required',
        'nominalKasKeluar'=>'required'
        ]);

    }



    public function buktiTransaksi(Request $request)
    {
        $nama  = $request->nama;
        $nominal = $request->nominal;
        $bunga = $request->bunga;
        $angsuran = $request->angsuran;
        $provisi = $request->provisi;
        $pokok = $request->pokok;
        $todayDate = Carbon::now();


        $pdf = new CetakPDF();
        $pdf->AliasNbPages();
        $pdf->AddPage();
        $pdf->SetLineWidth(0.8);
        $pdf->SetDash(); //restore no dash
        $pdf->Line(10, 30, 200, 30);
        $pdf->SetFont('Times','B',18);
        $pdf->Cell(180,12,'Bukti Pengeluaran Kas',0,1,'C');
        $pdf->Ln(10);
        $pdf->SetFont('Times','',14);
        $pdf->Cell(40,12,"Diterima dari",0,0);
        $pdf->Cell(40,12,": Bendahara",0,1);
        $pdf->Cell(40,12,"Tunai ",0,0);
        $pdf->Cell(40,12,": ".$nominal,0,1);
        $pdf->Cell(40,12,"Untuk Pembayaran ",0,0);
        $pdf->Cell(40,12,": Peminjaman USP",0,1);
        $pdf->Cell(40,12,"Nama Pemohon",0,0);
        $pdf->Cell(40,12,": ".$nama,0,1);
        $pdf->Cell(40,12,"NomorBukti",0,0);
        $pdf->Cell(40,12,": ".$request->bukti,0,1);
        $pdf->Cell(40,12,"Pembayaran",0,0);
        $pdf->Cell(40,12,": ".$pokok,0,1);
        $pdf->Cell(40,12,"Bunga dikenakan",0,0);
        $pdf->Cell(40,12,": ".$bunga,0,1);
        $pdf->Cell(40,12,"Jumlah Angsuran",0,0);
        $pdf->Cell(40,12,": ".$angsuran,0,1);
        $pdf->Cell(40,12,"Biaya Provisi",0,0);
        $pdf->Cell(40,12,": ".$provisi,0,1);
        $pdf->Ln(20);
        $pdf->Cell(180,12,"Maros, ".$todayDate->format('j F Y '),0,1,'R');
        $pdf->Ln(5);
        $pdf->Cell(180,12,"Mengetahui, ",0,1,'R');
        $pdf->Ln(5);
        $pdf->Cell(10,6,'',0,0);
        $pdf->Cell(65,6,'Pemohon',0,0,'C');
        $pdf->Cell(50,6,'',0,0);
        $pdf->Cell(50,6,'Bendahara',0,1,'C');
        $pdf->Ln(40);
        $pdf->Cell(10,6,'',0,0);
        $pdf->Cell(65,6,$nama,0,0,'C');
        $pdf->Cell(50,6,'',0,0);
        $pdf->Cell(50,6,'Yohanis Tabi S.Pd,. M.M',0,1,'C');
        $pdf->Output();

        exit;

    }
}
