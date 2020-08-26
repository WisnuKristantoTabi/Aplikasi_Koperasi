@extends('template.admin')

@section('title', 'Ubah')

@section('content')


<p class="text-dark">Profil</p>

<div class="line"></div>
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="/ubah-profil" method="post">
@csrf
    <div class="form-group">
        <label for="Transaksi_name">Nama Lengkap :</label>
        <input name="namalengkap" type="text" value="{{$member->full_name}}" class="form-control" autocomplete="off" placeholder="Masukkan Nama Lengkap"/>
        <input name="id" type="hidden" value="{{$member->id}}">
    </div>

    <div class="form-group">
        <label for="jeniskelamin">Jenis Kelamin :</label>
        <div class="form-group">
            <label for="jeniskelamin">Jenis Kelamin :</label>
            <div class="form-check">
                <input type='radio' class="form-check-input" id="jeniskelamin" name='jeniskelamin' @if($member->jenis_kelamin_id == 1) checked='checked' @endif />
                 <label class="form-check-label" for="jeniskelamin">
                   Pria
                 </label>
             </div>
             <div class="form-check">
                 <input type='radio' class="form-check-input" id="jeniskelamin" name='jeniskelamin' @if($member->jenis_kelamin_id == 2) checked='checked' @endif />
                  <label class="form-check-label" for="jeniskelamin">
                    Wanita
                  </label>
              </div>
        </div>
    </div>

    <div class="form-group">
        <label for="Transaksi_name">Alamat :</label>
        <input name="alamat" type="text" value="{{$member->alamat}}" class="form-control" autocomplete="off" placeholder="Masukkan Alamat"/>

    </div>

    <div class="form-group">
        <label for="notelp">Nomor Telpon :</label>
        <input name="notelp" type="text" value="{{$member->no_telpon}}" class="form-control" autocomplete="off" />
    </div>

    <div class="form-group">
        <label for="noslip">Nomor Slip Gaji :</label>
        <input name="noslip" type="text" value="{{$member->no_slip_gaji}}" class="form-control" autocomplete="off" />
    </div>

    <div class="form-group">
        <input class="btn btn-warning" type="submit" value="Ubah">
    </div>

</form>

@endsection
