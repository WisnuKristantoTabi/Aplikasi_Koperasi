@extends('template.admin')

@section('title', 'Tutup- Jasa SHU')

@section('content')

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
<link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />

<div class="bg-secondary shadow-lg pl-5 pt-3 pb-5 pr-5 rounded">
    <p class="text-white">Jasa SHU Akan Di Nolkan("Jasa Pinjaman"),</p>
    @if($status>0)
    <div class="bg-danger mt-3 mr-5 ml-5 pl-5">
        <p class="text-white font-italic font-weight-bold">SHU Belum Berikan Secara Merata!! </p>
        <p class="text-white font-italic font-weight-bold">SHU Harus Dibagikan Secara Merata </p>
    </div>
    @endif
</div>
<div class="p-5 d-flex flex-row-reverse bd-highlight">

    @if($status>0)
        <a class="btn btn-danger" href="/shu/accept-all">Tandai SHU Telah Dibagikan </a>
    @else
    <form action="/akun-tutup-periode" method="post">
            {{ csrf_field() }}
        <input type="hidden" name="password" value="{{$pass}}">
        <input class="btn btn-danger ml-3" type="submit" value="Oke, Lanjutkan">
    </form>
    @endif
        <a class="btn btn-warning mr-3" href="/shu/cetak-jasa">Cetak Laporan Jasa SHU</a>

</div>


@endsection
