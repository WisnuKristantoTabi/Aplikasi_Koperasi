@extends('layout.simpanan.tambah')

@section('form')

<div class="border shadow-lg p-5" style="background-color: #e3f2fd;">
    <form  action="/simpanan/addpokok" method="post">
        {{ csrf_field() }}
        <p class="text-dark font-weight-bold">Simpanan Pokok</p>
        <div class="form-group">
            <label for="nama" class="text-dark">Masukkan Nama </label>
            <select class="namasearch" id="namasearch_pokok" style="width:90%;" name="namasearch"></select>
            <button type="button" id="nama_pokok" class="btn btn-info" name="button">Cari</button>
        </div>
        <div id="pokok_form">

        </div>
    </form>
</div>

@endsection
