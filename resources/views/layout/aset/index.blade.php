@extends('template.admin')

@section('title', 'Aset')

@section('content')

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
<link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />

<a class="btn btn-info" href="#tambahData" data-toggle="modal">Tambah</a>

<div class="line"></div>
<div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Tabel List Aset</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
              <thead>
                <tr class="bg-primary">
                    <th scope="col"><center>No </center></th>
                    <th scope="col"><center>Nama</center></th>
                    <th scope="col"><center>Aksi</center></th>
                </tr>
              </thead>
              <tbody>
            @foreach($data as $no => $d)
                <tr>
                    <td>{{$no+1}}</td>
                    <td><a href="aset-detail?atid={{$d->id}}"><p class="text-info"><u>{{ $d->nama_aset}}</u></p></a></td>
                    <td>
                    <center>
                        <a class="btn btn-warning " href="/aset-edit?atid={{$d->id}}">Edit</a>
                        <a id="delete" class="btn btn-danger" href="/aset/delete/?id={{$d->id}}"> Hapus </a>
                    </center>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        </div>
    </div>
</div>


<div class="modal fade" id="tambahData" tabindex="-1" role="dialog" aria-labelledby="tambahDataTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="tambahDataTitle">Catat Aset Koperasi</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="/aset/add" method="post">
      <div class="modal-body">
          {{ csrf_field() }}
          <div class="form-group">
              <label for="Transaksi_name">Nama Aset :</label>
              <input name="nama" type="text" class="form-control " placeholder="Masukkan Nama Aset" />
          </div>
          <div class="form-group">
              <label for="tanggal">Tanggal Pembelian :</label>
              <input id="datepicker" width="276" name="tanggal"/>
          </div>

          <div class="form-group">
              <label for="Transaksi_name">Nilai Aset :</label>
              <input id="aset" name="nilai" type="text" class="form-control borderinput inputrupiah" autocomplete="off" placeholder="Masukkan Nilai Aset"/>
          </div>
          <div class="form-group">
              <label for="Transaksi_name">Nilai Residu :</label>
              <input id="residu" name="residu" type="text" class="form-control borderinput inputrupiah" autocomplete="off" placeholder="Masukkan Nilai Residu"/>
          </div>
          <div class="form-group">
              <label for="Transaksi_name">Perkiraan Umur Aset :</label>
              <input name="umur" type="number" min="0" class="form-control " placeholder="Masukkan Umur Aset" />
          </div>

      </div>
      <div class="modal-footer">
         <input class="btn btn-primary " id="tambahdata" type="submit" value="Tambahkan Ke Transaksi">
         <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
      </form>
    </div>
  </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.4.0/bootbox.min.js"></script>

<script>


    $(document).ready(function () {
        $("#aset").keyup(function () {
            $(this).val(formatRupiah(($(this).val()),'Rp. '));
        });

        $("#residu").keyup(function () {
            $(this).val(formatRupiah(($(this).val()),'Rp. '));
        });

        $("#tambahdata").click(function () {
            $("#aset").val($("#aset").val().replace(/[^,\d]/g, '').toString());
            $("#residu").val($("#residu").val().replace(/[^,\d]/g, '').toString());
        });


    });

    $(document).on("click", "#delete", function(e) {
        e.preventDefault();
        var link = $(this).attr("href");
        bootbox.confirm({
            title: "Tutup Akun ini?",
            message: "Apakah Kamu Ingin Menghapus Dari Daftar Akun?",
            buttons: {
                cancel: {
                    label: '<i class="fa fa-times"></i> Tidak'
                },
                confirm: {
                    label: '<i class="fa fa-check"></i> Iya'
                }
            },
            callback: function (result) {
                if(result){
                    window.location.href = link;
                }
            }
        });
    });


    $('#datepicker').datepicker({
        uiLibrary: 'bootstrap4',
        format: 'yyyy-mm-dd'
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


<script src="{{ asset('js/format-rupiah.js') }}"></script>

@endsection
