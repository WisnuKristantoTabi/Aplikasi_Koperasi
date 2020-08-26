@extends('template.admin')
@section('title', 'Perkiraan')
@section('content')


@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card o-hidden border-0 shadow-lg my-5">
    <div class="card-body p-0">
        <div class="row">
            <div class="col">
                <div class="p-5">
            <form action="/perkiraan/tambahperkiraan" method="post">
            {{ csrf_field() }}
            <div class="form-group">
                <h6 class="card-text">Jenis Perkiraan</h6>
                <select class="custom-select custom-select-sm mr-3" name="golongan_perkiraan">
                    @foreach($perkiraan as $p)
                    <option value= {{$p->id}} > {{$p->nama_perkiraan}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <h6 class="card-text">Nama Perkiraan</h6>
                <input class="form-control" type="text" placeholder= "Masukkan Nama Perkiraan" name="nama_perkiraan">
            </div>
            <div class="form-group">
                <h6 class="card-text">Nomor Perkiraan</h6>
                <input class="form-control" type="text" placeholder= "Masukkan Nomor Perkiraan" name="nomor_perkiraan">
            </div>
            <div class="form-group">
                <input class="btn btn-primary" type="submit" value="Tambah Data">
            </div>
            </form>
        </div>
    </div>
</div>
</div>
</div>
@endsection
