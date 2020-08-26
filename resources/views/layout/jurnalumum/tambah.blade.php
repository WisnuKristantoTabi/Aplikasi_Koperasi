@extends('template.admin')

@section('title', 'Jurnal Umum -Tambah')

@section('content')

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
<link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />


<div class="card o-hidden border-0 shadow-lg my-5">
    <div class="card-body p-0">
        <div class="row">
            <div class="col">
                <div class="p-5">

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


<form  action="/transaksi/tambahdata"  method="post">
    {{ csrf_field() }}
    <div class="form-group">
        <label for="Transaksi_name">Keterangan :</label>
        <input name="keterangan" type="text" class="form-control" autocomplete="off" placeholder="Masukkan keterangan Transaksi" />
    </div>

    <div class="form-group">
        <label for="tanggal">Tanggal Transaksi :</label>
        <input id="datepicker" width="100%" name="tanggal"/>
    </div>

    <div class="form-group">
        <label for="Transaksi_name">Akun Saldo Debit :</label>
        <br>
         <select name="debit" class="custom-select mr-sm-2">
             @foreach($perkiraan as $prk)
             <option value= {{$prk->id}} ><p class="text-dark">( {{ $prk->nomor_perkiraan}} ). {{ $prk->nama_perkiraan_detail}}</p></option>
              @endforeach
         </select>
    </div>

    <div class="form-group">
        <label for="Transaksi_name">Akun Saldo Kredit :</label>
        <select name="kredit" class="custom-select mr-sm-2" name="perkiraanKasMasuk" >
            @foreach($perkiraan as $prk)
            <option value= {{$prk->id}} ><p class="text-dark">( {{ $prk->nomor_perkiraan}} ). {{ $prk->nama_perkiraan_detail}}</p></option>
             @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="Transaksi_name">Nilai Nominal :</label>
        <input id="nominal" name="nominal" type="text" class="form-control borderinput formatubahuang" autocomplete="off" placeholder="Masukkan Jumlah"/>
    </div>
        <input class="btn btn-facebook btn-user btn-block" id="tambah" type="submit" value="Tambahkan Transaksi Jurnal Umum">

    </form>
    </div>
    </div>
    </div>
    </div>
</div>

<script type="text/javascript">

$('#datepicker').datepicker({
    uiLibrary: 'bootstrap4',
    format: 'yyyy-mm-dd'
});


$(document).ready(function () {

    $("#nominal").keyup(function () {
        $(this).val(formatRupiah(($(this).val()),'Rp. '));
    });

    $("#tambah").click(function () {
        $("#nominal").val($("#nominal").val().replace(/[^,\d]/g, '').toString());
    });
});

function formatRupiah(angka, prefix){
    var number_string = angka.replace(/[^,\d]/g, '').toString(),
		split   		= number_string.split(','),
		sisa     		= split[0].length % 3,
		rupiah     		= split[0].substr(0, sisa),
		ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);

    if(ribuan){
		separator = sisa ? '.' : '';
		rupiah += separator + ribuan.join('.');
	}

		rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
		return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
	}

</script>


@endsection
