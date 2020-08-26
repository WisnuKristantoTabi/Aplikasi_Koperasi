@extends('template.admin')

@section('title', 'Aplikasi Akuntansi')


@section('content')

<form action="/transaksi/tambahtransaksipinjaman/bukti" method="post">
{{ csrf_field() }}
<label >Nama Pemohon :</label>
<input class="form-control-plaintext borderinput" name="nama" type="text" readonly="readonly" value="{{$data['carinama']}}"/>
<label >Sebesar :</label>
<input class="form-control-plaintext borderinput" name="nominal" type="text" readonly="readonly" value="@currency($data['inputpinjaman'])"/>
<label >Bukti Pembayaran :</label>
<input class="form-control-plaintext borderinput" name="bukti" type="text" readonly="readonly" value="{{$data['bukti']}}"/>
<label >Dengan Angsuran :</label>
<input class="form-control-plaintext borderinput" type="text" name="angsuran" readonly="readonly" value="
@if($data['angsuran'] == 0)
    -
@else
    {{$data['angsuran']}} . X
@endif"/>
<label class="font-weight-bolder">Bunga Dikenakan :</label>
<input class="form-control-plaintext borderinput" type="text"  name="bunga" readonly="readonly" value="@currency($data['hitungbunga'])">
<label class="font-weight-bolder">Biaya Provisi Sebesar :</label>
<input class="form-control-plaintext borderinput" type="text" name="provisi" readonly="readonly" value="
@if($data['provisi'] == 0)
    -
@else
    @currency($data['provisi'])
@endif"/>
<label class="font-weight-bolder">Pembayaran :</label>
<input class="form-control-plaintext borderinput" type="text" name="pokok" readonly="readonly" value="
@if($data['pembayaran'] == 0)
    -
@else
    @currency($data['pembayaran'])
@endif"/>
<p></p>
<button class="btn btn-warning float-right" type="submit" target="_blank" ><i class="fas fa-print"></i> Cetak</button>
</form>

@endsection
