@extends('template.admin')

@section('title', 'Transaksi')

@section('content')
<script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
<link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />

<link href="{{ asset('css/box.css') }}" rel="stylesheet">


<div class="latar">
    <div class="kotak shadow-lg">
    <a href="/pinjaman-anggota" >
        <div class="icon">
            <i class="fa fa-plus-square"></i>
        </div>
        <div class="about-tombol"><h4>  Tambahkan Data Transaksi Pinjaman Anggota</h4></div>
    </a>
    </div>
    <div class="kotak shadow-lg ">
    <a href="/pinjaman-sementara">
        <div class="icon">
            <i class="fa fa-plus-square"></i>
        </div>
        <div class="about-tombol"><h4> Tambahkan Data Transaksi Pinjaman  Sementara</h4></div>
    </a>
    </div>
    <div class="kotak shadow-lg ">
    <a href="pinjaman-nonanggota" >
        <div class="icon">
            <i class="fas fa-plus-square"></i>
        </div>
        <div class="about-tombol"><h4> Tambahkan Data Transaksi Pinjaman non Anggota</h4></div>
    </a>
    </div>

    <div class="kotak shadow-lg ">
    <a href="/piutang">
        <div class="icon">
            <i class="fas fa-list-ol"></i>
        </div>
        <div class="about-tombol"><h4> Piutang USP/ Angsuran</h4></div>
    </a>
    </div>


</div>

@endsection
