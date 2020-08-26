@extends('template.admin')

@section('title', 'Transaksi')

@section('content')
<link href="{{ asset('css/autocomplate.css') }}" rel="stylesheet">
<link href="{{ asset('css/format-rupiah.css') }}" rel="stylesheet">

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
<link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />

<link href="{{ asset('css/box.css') }}" rel="stylesheet">

<div class="card o-hidden border-0 shadow-lg my-5">
    <div class="card-body p-0">
    <div class="table-responsive">
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
                    <form action="/transaksi-tambahpinjamansementara" method="post">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="namasearch">Nama Pemohon Pinjam :</label>
                            <p></p>
                            <select class="form-control" id="namasearch" style="width:90%;" name="namasearch"></select>
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
                            <label >Jumlah Angsuran (Max:30 dan Min:1):</label>
                            <div class="p-3 mb-2 bg-primary "><p class="font-italic font-weight-bold text-white">Angsuran Akan Dikenakan Setiap Bulan<p></div>
                            <p class="text-info">  </p>
                        </div>
                        <div class="form-group">
                            <label for="Transaksi_name">Jumlah Nominal :</label>
                            <input id="formatubahuang" class="form-control" type="text" name="inputpinjaman" autocomplete="off" placeholder="Masukkan Jumlah Nominal"/>
                            <label for="Transaksi_name">Jumlah Bunga Dikenakan ( <i>{{$bunga[0] ->persen}} %</i> ) :</label>
                            <input type="hidden" id="bunga" value="{{$bunga[0] ->persen}}" >
                            <input id="hasilhitungbunga" class="form-control-plaintext" type="text" name="hitungbunga" placeholder="Jumlah Termasuk Bunga" autocomplete="off" readonly="readonly"/>
                        </div>
                        <div class="form-group">
                            <label for="Transaksi_name">Jumlah Provisi Dikenakan ( <i>{{$provisi[0] ->persen}} %</i> ) :</label>
                            <input id="provisi" type="hidden" class="provisi" value="{{$provisi[0] ->persen}}" >
                            <input id="hasilhitungprovisi" class="form-control-plaintext" type="text" name="hitungrpovisi" placeholder="Provisi" readonly="readonly"/>
                        </div>
                        <input class="btn btn-facebook btn-user btn-block" id="tambahtransaksipinjaman" type="submit" value="Tambahkan Ke Transaksi">
                    </form>
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

  $("#formatubahuang").keyup(function () {
      var rupiah = $(this).val();
      rupiah = rupiah.replace(/[^,\d]/g, '').toString();
      var bunga = $("#bunga").val();
      var provisi = $("#provisi").val();
      var hasilbunga = Number(rupiah) * ( Number(bunga) /100);
      var hasilprovisi = Number(rupiah) * ( Number(provisi) /100);
      $("#hasilhitungprovisi").val(formatRupiah(String(hasilprovisi.toFixed(0)),'Rp. '));
      $("#hasilhitungbunga").val(formatRupiah(String(hasilbunga.toFixed(0)),'Rp. '));
      $(this).val(formatRupiah(rupiah,'Rp. '));

  });

  $("#keterangan_transaksi_pinjaman").click(function () {
      var member = $( "#namasearch option:selected" ).text();
      $("#name").val(member);
      $(this).val("Bayar pinjaman pada " +member);
  });

  $("#tambahtransaksipinjaman").click(function () {
      $("#formatubahuang").val($("#formatubahuang").val().replace(/[^,\d]/g, '').toString());
      $("#hasilhitungbunga").val($("#hasilhitungbunga").val().replace(/[^,\d]/g, '').toString());
      $("#hasilhitungprovisi").val($("#hasilhitungprovisi").val().replace(/[^,\d]/g, '').toString());
    this.disabled=true;
        this.value='Mengirim Data...';
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
