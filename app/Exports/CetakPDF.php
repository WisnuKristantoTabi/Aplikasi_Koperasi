<?php

namespace App\Exports;

use Codedge\Fpdf\Fpdf\Fpdf;

class CetakPDF extends FPDF
{

    function Header()
    {
        //$url = new UrlGenerator();
        //URL::asset('image/koperasi_logo.jpg')

        $this->Image('https://raw.githubusercontent.com/WisnuKristantoTabi/AplikasiAkuntansi.github.io/master/public/logo_koperasi.png',10,6,20,20,'PNG');
        // Arial bold 15

        $this->SetFont('Arial','B',24);
        // Move to the right
        $this->Cell(40);
        // Title
        $this->Cell(30,10,'KP-RI Sentosa',0,1,'C');
        // Line break
        $this->Ln(20);

    }


    function SetDash($black=false, $white=false)
    {
        if($black and $white)
            $s=sprintf('[%.3f %.3f] 0 d', $black*$this->k, $white*$this->k);
        else
            $s='[] 0 d';
        $this->_out($s);
    }

    // Page footer
    function Footer()
    {
        // Position at 1.5 cm from bottom
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial','I',8);
        // Page number
        $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
    }
}
