@extends('template.admin')

@section('title', 'Simpanan')

@section('content')

<script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
<link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />

<link href="{{ asset('css/box.css') }}" rel="stylesheet">


<div class="latar">
    <div class="kotak shadow-lg">
    <a href="/simpanan-add-wajib" >
        <div class="icon">
            <i class="fa fa-money-check-alt"></i>
        </div>
        <div class="about-tombol"><h4>  Tambahkan Data Transaksi Simpanan</h4></div>
    </a>
    </div>
    <div class="kotak shadow-lg ">
    <a href="#" >
        <div class="icon">
            <i class="fas fa-money-bill-alt"></i>
        </div>
        <div class="about-tombol"><h4> Daftar Simpanan</h4></div>
    </a>
    </div>
</div>

@endsection
