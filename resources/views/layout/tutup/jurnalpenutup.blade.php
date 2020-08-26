@extends('template.admin')

@section('title', 'Tutup-Jurnal Penutup')

@section('content')


<div class="bg-secondary shadow-lg pl-5 pt-3 pb-5 pr-5 rounded">
    <p class="text-white">Pekiraan Akun Beban dan Perkiraan Akun Pendapatan (SHU) Menjadi Nol,</p>
    <p class="text-white">Data Akun Perkiraan Periode Sebelumnya Akan Dibackup pada Database.</p>
    <form action="/akun-tutup-shu" method="post">
            {{ csrf_field() }}
        <input type="hidden" name="password" value="{{$pass}}">
</div>
<div class="p-5 d-flex flex-row-reverse bd-highlight">

    <input class="btn btn-danger ml-3" type="submit" value="Oke, Lanjutkan">
    <a href="/shu/cetak-jasa">Cetak Laporan SHU</a>
    <!--<a id="next" class=" btn btn-danger" href="/akun/tutup/password">Oke, Lanjutkan</a>-->
    </form>
</div>



@endsection
