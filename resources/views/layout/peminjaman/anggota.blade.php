@extends('template.admin')

@section('title', 'Transaksi Pinjaman Anggota')

@section('content')
<link href="{{ asset('css/autocomplate.css') }}" rel="stylesheet">
<link href="{{ asset('css/format-rupiah.css') }}" rel="stylesheet">

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
<link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />

<link href="{{ asset('css/box.css') }}" rel="stylesheet">


<div class="container">
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
    <div class="card o-hidden border-0 shadow-lg mb-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <div class="row">
                    <div class="col">
                        <div class="p-5">
                            <form action="/transaksi-tambahtransaksipinjaman" method="post">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="namasearch">Nama Pemohon Pinjam :</label>
                                    <p></p>
                                    <select class="custom-select custom-select-sm" id="namasearch" style="width:90%;" name="namasearch"></select>
                                </div>

                                <div class="form-group">
                                    <label for="tanggal">Tanggal Transaksi :</label>
                                    <input id="datepicker" width="90%" name="tanggal"/>
                                </div>

                                <div class="form-group">
                                    <label for="Transaksi_name">keterangan :</label>
                                    <input name="keterangan" type="text" id="keterangan_transaksi_pinjaman" class="form-control" autocomplete="off" placeholder="Masukkan keterangan Transaksi" />
                                    <input type="hidden"  id="name" name="nama" >
                                </div>
                                <div class="form-group">
                                    <label for="Transaksi_name">Jumlah Angsuran (Max:30 dan Min:1):</label>
                                    <input name="angsuran" type="text" class="form-control jumlah-angsuran" autocomplete="off" placeholder="Masukkan Jumlah Angsuran"/>
                                </div>
                                <div class="form-group">
                                    <label for="Transaksi_name">Jumlah Nominal :</label>
                                    <input class="form-control inputrupiah" type="text" name="inputpinjaman" autocomplete="off" placeholder="Masukkan Jumlah Nominal"/>
                                    <label for="Transaksi_name">Jumlah Bunga Dikenakan ( <i>{{$bunga[0] ->persen}} %</i> ) :</label>
                                    <input type="hidden" class="bunga" value="{{$bunga[0] ->persen}}" >
                                    <input class="form-control-plaintext hasilhitungbunga" type="text" name="hitungbunga" placeholder="Jumlah Termasuk Bunga" readonly="readonly"/>
                                    <label for="Transaksi_name">Jumlah Provisi Dikenakan ( <i>{{$provisi[0] ->persen}} %</i> ) :</label>
                                    <input type="hidden" class="provisi" value="{{$provisi[0] ->persen}}" >
                                    <input class="form-control-plaintext hasilhitungprovisi" type="text" name="hitungrpovisi" placeholder="Provisi" readonly="readonly"/>
                                    <label for="Transaksi_name">Jumlah Pembayaran</label>
                                    <input id="pokok" class="form-control-plaintext " type="text" name="pembayaran" placeholder="Pembayaran" readonly="readonly"/>
                                </div>
                                <input class="btn btn-facebook btn-user btn-block" id="tambahtransaksipinjaman" type="submit" value="Tambahkan Ke Transaksi">
                            </form>
                        </div>
                    </div>
                </div>    
            </div>
        </div>
    </div>
</div>

<script>
    $('#datepicker').datepicker({
        uiLibrary: 'bootstrap4',
        format: 'yyyy-mm-dd'
    });
</script>


<script type="text/javascript">
$(document).ready(function () {
$('#namasearch').select2({
    selectOnClose: false,
    placeholder: 'Cari Nama',
    ajax: {
      url: "{{url('/pinjaman/userauto/member')}}",
      dataType: 'json',
      delay: 250,
      processResults: function (data) {
        return {
          results:  $.map(data, function (item) {
            return {
              text: item.full_name,
              id: item.id
            }
          })
        };
      },
      cache: true
    }
  });
 });
</script>

<script src="{{ asset('js/format-rupiah.js') }}"></script>
<script src="{{ asset('js/pinjaman.js') }}"></script>

@endsection
