@extends('template.admin')

@section('title', 'Transaksi')

@section('content')

<script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
<link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />

@php $jum=0 @endphp
@php $angs= $pinjaman->sisa_angsuran @endphp

@if($angs > 0)
<a class="btn btn-info" href="#transaksiAnggota" data-toggle="modal"> Tambah Transaksi Angsuran</a>
@endif

<div class="line"></div>
<div class="d-flex flex-row-reverse">
    <div class="card text-white bg-secondary shadow-lg rounded mb-3 mr-3" style="max-width: 18rem;">
      <div class="card-header text-dark">Tanggal Pinjaman</div>
      <div class="card-body">
        <p class="card-text text-white"> {{$pinjaman->tanggal}}</p>
       </div>
      </div>

    <div class="card text-white bg-primary shadow-lg rounded mb-3 mr-3" style="max-width: 18rem;">
      <div class="card-header text-dark">Sisa Angsuran</div>
      <div class="card-body">
        <p class="card-text text-white">{{$angs}}</p>
       </div>
      </div>

    <div class="card text-white bg-info shadow-lg rounded mb-3 mr-3" style="max-width: 18rem;">
      <div class="card-header text-dark">Pinjaman</div>
      <div class="card-body">
        <p class="card-text text-white"> @currency($pinjaman->jumlah_pinjaman)</p>
       </div>
      </div>
      <div class="card text-white bg-success shadow-lg rounded mb-3 mr-3" style="max-width: 18rem;">
        <div class="card-header text-dark">Jenis Pinjaman</div>
        <div class="card-body">
          <p class="card-text text-white"> {{$pinjaman->nama}}</p>
         </div>
        </div>
</div>

<div class="line"></div>


<input type="hidden" name="" value="nanoabbg">

<table class="table table-bordered table-striped table-hover">
    <thead>
        <tr>
            <th>Tanggal</th>
            <th>Jumlah Angsuran</th>
            <th>Jumlah Bayar</th>
            <th>No.Bukti</th>
        </tr>

    </thead>
    <tbody>
        @foreach($data as $d)
        <tr>
            @if($d->tanggal)
            <td>{{$d->tanggal}}</td>
            <td>{{$d->jumlah_angsuran}}</td>
            <td>@currency($d->jumlah_bayar)</td>
            <td>{{$d->no_bukti}}</td>
            @php $jum = $jum+ $d->jumlah_bayar @endphp
            @else
            <td colspan="4">Data Tidak Ditemukan</td>
            @endif
        </tr>
        @endforeach
    </tbody>
</table>

<div class="card border-secondary mb-3" style="max-width: 18rem;">
    <div class="card-header">Jumlah Yang Telah Dibayar </div>
    <div class="card-body text-secondary">
        <h5 class="card-title">@currency($jum)</h5>
    </div>
</div>

<div class="modal fade" id="transaksiAnggota" tabindex="-1" role="dialog" aria-labelledby="tambahTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="tambahTitle">Formulir Transaksi Angsuran Anggota</h5>
        <button type="button" class="tutup close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="/transaksi-add-angsuran-non-member" method="post">
      <div class="modal-body">
          {{ csrf_field() }}
          <div class="form-group">
              <label for="tanggal">Tanggal Transaksi :</label>
              <input id="datepicker" width="276px" name="tanggal"/>
          </div>

          <div class="form-group">
              <label for="pokok">Pokok Angsuran (+bunga)</label>
              <input name="pokok" id="pokok" type="text" class="form-control" autocomplete="off" placeholder="Jumlah Pokok" value="@currency(($pinjaman->jumlah_pinjaman / $pinjaman->jumlah_angsuran ) + $pinjaman->jumlah_bunga)" readonly="readonly"/>
          </div>

          <div class="form-group">
              <label for="angsuran">Jumlah Angsuran Dibayar(Max:{{$angs}} dan Min:1):</label>
              <input name="angsuran" id="angsuran" type="number" min="1" max="{{$angs}}" class="form-control" autocomplete="off" placeholder="Masukkan Jumlah Angsuran"/>
          </div>

          <div class="form-group">
              <label for="total">Bunga Dikenakan</label>
              <input name="bunga" id="bunga" type="text" class="form-control " autocomplete="off" placeholder="Bunga" readonly="readonly" />
          </div>

          <div class="form-group">
              <label for="total">Jumlah Total Dibayarkan (+bunga)</label>
              <input name="total" id="total" type="text" class="form-control " autocomplete="off" placeholder="Jumlah Total" readonly="readonly"/>
          </div>

          <div class="form-group">
              <label for="keterangan">Keterangan Transaksi :</label>
              <input name="keterangan" type="text" class="form-control" autocomplete="off" placeholder="Masukkan keterangan Transaksi" value="Terima USP dan Bunga USP Dari {{$pinjaman->full_name}}" />
              <input name="id" type="hidden" value="{{$pinjaman->member_table_id}}" />
              <input name="pid" type="hidden" value="{{$id}}" />
          </div>
      </div>
      <div class="modal-footer">
         <input class="btn btn-primary" id="tambahtransaksi" type="submit" value="Tambahkan Ke Transaksi">
         <button type="button" class="btn btn-secondary tutup" data-dismiss="modal">Close</button>
      </div>
      </form>
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
    $("#angsuran").keyup(function () {
        var angsuran=$(this).val();
        if(Number(angsuran)<={{$angs}}){
            var pokok=$("#pokok").val();
            pokok = pokok.replace(/[^,\d]/g, '').toString();
            var hasil = ( Number(angsuran) * Number(pokok) );
            var bunga = ( Number(angsuran) * {{$pinjaman->jumlah_bunga}} );
            $("#total").val(formatRupiah(String(hasil.toFixed(0)),'Rp. '));
            $("#bunga").val(formatRupiah(String(bunga.toFixed(0)),'Rp. '));
        }else{
            $("#total").val("");
            $("#bunga").val("");
        }
    });

    $("#tambahtransaksi").click(function () {
        $("#total").val($("#total").val().replace(/[^,\d]/g, '').toString());
        $("#bunga").val($("#bunga").val().replace(/[^,\d]/g, '').toString());
        $("#pokok").val($("#pokok").val().replace(/[^,\d]/g, '').toString());
        this.disabled=true;
        this.value='Mengirim Data...';
    });


    $(".tutup").click(function () {
        $("#total").val("");
        $("#angsuran").val("");
        setTimeout("preback()",0);
        window.onunload=function(){null};
    });

});

function preback(){
    window.history.forward();
}


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
