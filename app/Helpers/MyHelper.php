<?php
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Crypt;

function set_active($uri){
    if( is_array($uri) ) {
        foreach ($uri as $u) {
            if (Request()->path() == $u) {
                return 'active';
            }
        }
    }else {
        if (Request()->path() == $uri){
            return 'active';
        }
    }
}

function enkripsi($pass){
    return Crypt::encryptString($pass);
}


function show($uri){
    if( is_array($uri) ) {
        foreach ($uri as $u) {
            if (Request()->path() == $u) {
                return 'show';
            }
        }
    }else {
        if (Request()->path() == $uri){
            return 'show';
        }
    }
}

function getIdLatest($table)
{
    $data = DB::table($table)
    ->select('id')
    ->latest('id')
    ->first();
    return $data->id;
}

function getStringBulan($bulan)
{


    $kumpulanBulan="Januari Februari Maret April Mei Juni Juli Augustus September Oktober November Desember";

    $arrayBulan=explode(" ", $kumpulanBulan);

    return $arrayBulan[$bulan-1];
}
