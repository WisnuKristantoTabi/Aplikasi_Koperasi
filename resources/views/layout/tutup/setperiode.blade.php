@extends('template.admin')

@section('title', 'Tutup- Periode Baru')

@section('content')


<script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
<link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="bg-white shadow-lg pl-5 pt-3 pb-5 pr-5 rounded">
    <p class="text-dark font-weight-bold">Pekiraan Akun Beban dan Perkiraan Akun Pendapatan (SHU) Menjadi Nol,</p>
    <p class="text-dark font-weight-bold mb-3">Data Akun Perkiraan Periode Sebelumnya Akan Dibackup pada Database.</p>
    <form action="/akun-tutup-finish" method="post">
            {{ csrf_field() }}
        <input type="hidden" name="password" value="{{$pass}}">

        <div class="form-group">
            <label for="tanggal">Tanggal Mulai :</label>
            <input id="datepicker" width="276" name="tanggal"/>
        </div>
        <div class="form-group">
            <label for="tanggal">Keterangan :</label>
            <input id="keterangan" class="form-control" type="text" name="keterangan" autocomplete="off" placeholder="Masukkan Keterangan" />
        </div>
</div>
<div class="p-5 d-flex flex-row-reverse bd-highlight">

    <input class="btn btn-danger ml-3" type="submit" value="Oke, Lanjutkan">
    <!--<a id="next" class=" btn btn-danger" href="/akun/tutup/password">Oke, Lanjutkan</a>-->
    </form>
</div>

<script>
    $('#datepicker').datepicker({
        uiLibrary: 'bootstrap4',
        format: 'yyyy-mm-dd',

    });

    var d = $('#datepicker').datepicker('getDate');
    console.log(d);

</script>




@endsection
