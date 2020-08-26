@extends('template.admin')

@section('title', 'Aplikasi Akuntansi')


@section('content')


<form  action="/createuser/cetakformulir"  method="post">
    {{ csrf_field() }}
    <div class="form-group">
        <label class="font-weight-bolder">User Name :</label>
        <input class="form-control-plaintext " type="text" name="username" readonly="readonly" value="{{$username}}"/>
    </div>

    <div class="form-group">
        <label class="font-weight-bolder">Nama Lengkap :</label>
        <input class="form-control-plaintext " type="text" name="full_name" readonly="readonly" value="{{$full_name}}"/>
    </div>

    <div class="form-group">
        <label class="font-weight-bolder">Password :</label>
        <input class="form-control-plaintext " type="text" name="password" readonly="readonly" value="{{$password}}"/>
    </div>

    <div class="form-group">
        <label class="font-weight-bolder">Sebagai :</label>
        <input class="form-control-plaintext " type="text" name="role" readonly="readonly" value="{{$role}}"/>
    </div>

    <div class="form-group">
        <label class="font-weight-bolder">Bukti Pembayaran Simpanan Pokok :</label>
        <input class="form-control-plaintext " type="text" name="bukti" readonly="readonly" value="{{$bukti}}"/>
    </div>

    <div class="form-group">
        <input class="btn btn-primary float-right " id="tambahtransaksipinjaman" type="submit" value="Cetak Formulir">
    </div>

</form>







@endsection
