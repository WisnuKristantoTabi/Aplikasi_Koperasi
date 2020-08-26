@extends('template.admin')

@section('title', 'Bukti Angsuran')


@section('content')

<form action="/transaksi/cetak/angsuran" method="post">
{{ csrf_field() }}
<label >Keterangan :</label>
<input class="form-control-plaintext borderinput" name="keterangan" type="text" readonly="readonly" value="{{$keterangan}}"/>
<label >Nama Pemohon :</label>
<input class="form-control-plaintext borderinput" name="nama" type="text" readonly="readonly" value="{{$nama}}"/>
<label >Bukti Pembyaran:</label>
<input class="form-control-plaintext borderinput" name="bukti" type="text" readonly="readonly" value="{{$bukti}}"/>
<label >Jumlah Angsuran :</label>
<input class="form-control-plaintext borderinput" type="text" name="angsuran" readonly="readonly" value="
@if($angsuran == 0)
    -
@else
    {{$angsuran}} . X
@endif"/>
<label >Total Pembayaran:</label>
<input class="form-control-plaintext borderinput" name="nominal" type="text" readonly="readonly" value="@currency($total)"/>
<button class="btn btn-warning float-right" type="submit" ><i class="fas fa-print"></i> Cetak</button>
</form>

@endsection
