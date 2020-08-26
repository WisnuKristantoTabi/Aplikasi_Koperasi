@extends('template.admin')

@section('title', 'Tutup Periode')

@section('content')


<div class="bg-secondary shadow-lg pl-5 pt-3 pb-5 pr-5 rounded">
    <p class="text-white">Menghapus Periode Akan Menyebabkan Akun SHU Member Menjadi 0. Perkiraan Akun Pendapatan Menjadi Nol.</p>
    <p class="text-white">Pekiraan Akun Beban Menjadi Nol. Namun Sebelumnya,</p>
    <p class="text-white font-italic font-weight-bold">Masukkan Password Aplikasi Untuk Melanjutkan </p>
    <form action="/akun-tutup-jurnal-penutup" method="post">
            {{ csrf_field() }}
        <input class="form-control" id="password" type="text" placeholder= "Masukkan Password Aplikasi" name="password" autocomplete="off">

</div>
<div class="p-5 d-flex flex-row-reverse bd-highlight">
    <input class="btn btn-danger" id="tambahtransaksipinjaman" type="submit" value="Oke, Lanjutkan">
    <!--<a id="next" class=" btn btn-danger" href="/akun/tutup/password">Oke, Lanjutkan</a>-->
    </form>
</div>



@endsection
