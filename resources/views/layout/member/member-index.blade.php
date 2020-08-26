@extends('template.admin')

@section('title', 'Member - Home')

@section('content')

<link href="{{ asset('css/box.css') }}" rel="stylesheet">

<div class="latar">

    <a href="/member-list-member" >
    <div class="kotak">
        <div class="icon">
            <i class="fa fa-user"></i>
        </div>
        <div class="about-tombol"><h4>  Anggota Terdaftar</h4></div>
    </div>
    </a>

    <div class="kotak">
    <a href="/member-view-list-non-member">
        <div class="icon">
            <i class="fa fa-user-times"></i>
        </div>
        <div class="about-tombol"><h4>Non anggota</h4></div>
    </a>
    </div>
</div>



@endsection
