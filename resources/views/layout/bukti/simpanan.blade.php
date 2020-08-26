@extends('template.admin')

@section('title', 'Cetak Bukti Simpanan')

@section('content')

<div class="border shadow-lg p-5" style="background-color: #e3f2fd;">
    <form action="/simpanan/cetak" method="post">
    {{ csrf_field() }}
        <div class="form-group">
            <label class="font-weight-bolder"> No.Bukti :</label>
            <input class="form-control-plaintext" name="bukti" type="text" readonly="readonly" value="{{$bukti}}"/>
        </div>

        <div class="form-group">
            <label class="font-weight-bolder">Jenis Simpanan :</label>
            <input class="form-control-plaintext" name="jenis" type="text" readonly="readonly" value="{{$jenis}}"/>
        </div>

        <div class="form-group">
            <label class="font-weight-bolder">Nama Pemohon :</label>
            <input class="form-control-plaintext" name="nama" type="text" readonly="readonly" value="{{$nama}}"/>
        </div>

        <div class="form-group">
            <label class="font-weight-bolder">Sebesar :</label>
            <input class="form-control-plaintext" name="nominal" type="text" readonly="readonly" value="@currency($nominal)"/>
        </div>


        <div class="form-group">
            <button class="btn btn-warning float-right" type="submit" ><i class="fas fa-print"></i> Cetak</button>
        </div>
    </form>
</div>

@endsection
