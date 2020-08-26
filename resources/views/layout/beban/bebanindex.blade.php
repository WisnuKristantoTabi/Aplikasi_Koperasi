@extends('template.admin')

@section('title', 'Beban')

@section('content')

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
<link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />

<a href="#formulirBeban" data-toggle="modal" class="btn btn-info m-3">Tambah Data</a>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Tabel Beban Operasi</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
              <thead>
                <tr>
                    <th scope="col"><center>Tanggal </center></th>
                    <th scope="col"><center>Keterangan</center></th>
                    <th scope="col"><center>Nomor</center></th>
                    <th scope="col"><center>Saldo</center></th>
                    <th scope="col"><center>Aksi</center></th>
                </tr>
              </thead>
              <tbody>
                  @if(empty($data[0]))
                  <tr>
                      <td colspan="5"><center>Data Tidak Ditemukan</center></td>
                  </tr>
                  @else
                  @foreach($data as $d )

                  <tr>
                      <td>{{ $d->tanggal }}</td>
                      <td>{{ $d->keterangan }}</td>
                      <td>{{ $d->nomor_perkiraan }}</td>
                      <td>@currency($d->debit)</td>
                      <td>
                          <button type="button" id="ubahbtn" class="btn btn-warning" data-keteranganubah="{{ $d->keterangan }}"
                          data-tanggalubah="{{ $d->tanggal }}" data-jui="{{ $d->jui }}" data-dui="{{ $d->dui }}"
                          data-id="{{ $d->dpi }}" data-nomorubah="{{$d->nomor_perkiraan}}"
                           data-toggle="modal" data-target="#ubah">Edit</button>
                      </td>
                  </tr>

                  @endforeach
                  @endif

              </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="ubah" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="formulirTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="formulirTitle">Formulir Ubah Transaksi Beban</h5>
        <button type="button" class="tutupTransaksi close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="/beban/ubah-beban" method="post">
      <div class="modal-body">
          {{ csrf_field() }}
          <div class="form-group">
              <label for="Transaksi_name">Keterangan</label>
              <div class="d-flex align-items-center">
                   <input id="inputketerangan" class="form-control " type="text" autocomplete="off" name="keteranganubah" value="" placeholder="Masukkan Keterangan Transaksi Beban"/>
              </div>
          </div>

          <div class="form-group">
              <label for="tanggal">Tanggal Transaksi :</label>
              <input id="datepickerUbah" class=".datepicker" width="276" name="tanggalubah"/>
          </div>

          <div class="form-group">
              <label for="Transaksi_name">Nomor Perkiraan :</label>
              <input id="inputNomorUbah" class="form-control " type="text" name="nomorubah" autocomplete="off" value="" placeholder="Masukkan Nomor Perkiraan"/>
              <input id="id"  type="hidden" name="id" />
              <input id="jui" type="hidden" name="jui"/>
              <input id="dui" type="hidden" name="dui"/>
          </div>

      </div>
      <div class="modal-footer">
         <input class="btn btn-primary " id="ubahtransaksi" type="submit" value="Tambahkan Ke Transaksi">
         <button type="button" class="btn btn-secondary tutupTransaksi" data-dismiss="modal">Close</button>
      </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="formulirBeban" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="formulirTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="formulirTitle">Formulir Tambah Transaksi Beban</h5>
        <button type="button" class="tutupTransaksi close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="/beban/tambah-beban" method="post">
      <div class="modal-body">
          {{ csrf_field() }}
          <div class="form-group">
              <label for="Transaksi_name">Keterangan</label>
              <div class="d-flex align-items-center">
                   <input class="form-control " type="text" autocomplete="off" name="keterangan" placeholder="Masukkan Keterangan Transaksi Beban"/>
              </div>
          </div>

          <div class="form-group">
              <label for="tanggal">Tanggal Transaksi :</label>
              <input id="datepicker" width="276" name="tanggal"/>
          </div>

          <div class="form-group">
              <label for="Transaksi_name">Jumlah Nominal :</label>
              <input id="nominal" class="form-control " type="text" name="inputnominal" autocomplete="off" placeholder="Masukkan Jumlah Nominal"/>
          </div>

          <div class="form-group">
              <label for="Transaksi_name">Nomor Perkiraan :</label>
              <input class="form-control " type="text" name="nomor" autocomplete="off" placeholder="Masukkan Nomor Perkiraan"/>
          </div>

      </div>
      <div class="modal-footer">
         <input class="btn btn-primary" id="tambahtransaksi" type="submit" value="Tambahkan Ke Transaksi">
         <button type="button" class="btn btn-secondary tutupTransaksi" data-dismiss="modal">Close</button>
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

    $('#datepickerUbah').datepicker({
        uiLibrary: 'bootstrap4',
        format: 'yyyy-mm-dd'
    });


</script>

<script >
$(document).ready(function () {

    $("#nominal").keyup(function () {
        $(this).val(formatRupiah(($(this).val()),'Rp. '));
    });

     $("#inputNominalUbah").keyup(function () {
         $(this).val(formatRupiah(($(this).val()),'Rp. '));
     });

    $("#tambahtransaksi").click(function () {
        $("#nominal").val($("#nominal").val().replace(/[^,\d]/g, '').toString());
    });

    $("#ubahbtn").click(function () {
        var Id = $(this).data('id');
        var keteranganUbah = $(this).data('keteranganubah');
        var jui = $(this).data('jui');
        var dui = $(this).data('dui');
        var tanggalUbah = $(this).data('tanggalubah');
        var nomorUbah = $(this).data('nomorubah');

         $(".modal-body #id").val( Id );
         $(".modal-body #inputketerangan").val( keteranganUbah );
         $(".modal-body #jui").val( jui );
         $(".modal-body #dui").val( dui );
         $(".modal-body #datepickerUbah").val( tanggalUbah );
         $(".modal-body #inputNomorUbah").val( nomorUbah );
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
