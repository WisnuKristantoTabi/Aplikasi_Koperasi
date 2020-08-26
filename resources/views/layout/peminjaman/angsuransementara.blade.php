@extends('template.admin')

@section('title', 'Transaksi')

@section('content')


@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
<link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />

@php $jum=0 @endphp



<a class="btn btn-info m-3" href="#transaksiAnggota" data-toggle="modal"> Tambah Transaksi Angsuran</a>


<div class="row">
       <div class="col-xl-3 col-md-6 mb-4">
         <div class="card border-left-success shadow h-100 py-2">
           <div class="card-body">
             <div class="row no-gutters align-items-center">
               <div class="col mr-2">
                 <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Jenis Pinjaman</div>
                 <div class="h5 mb-0 font-weight-bold text-gray-800">{{$pinjaman->nama}}</div>
               </div>
               <div class="col-auto">
               </div>
             </div>
           </div>
         </div>
       </div>

       <div class="col-xl-3 col-md-6 mb-4">
          <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
              <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                  <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Pinjaman</div>
                  <div class="h5 mb-0 font-weight-bold text-gray-800">@currency($pinjaman->jumlah_pinjaman)</div>
                </div>
                <div class="col-auto">
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
           <div class="card border-left-primary shadow h-100 py-2">
             <div class="card-body">
               <div class="row no-gutters align-items-center">
                 <div class="col mr-2">
                   <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Bunga Dikenakan</div>
                   <div class="h5 mb-0 font-weight-bold text-gray-800"> @currency($pinjaman->jumlah_bunga)</div>
                 </div>
                 <div class="col-auto">
                 </div>
               </div>
             </div>
           </div>
         </div>

         <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-secondary shadow h-100 py-2">
              <div class="card-body">
                <div class="row no-gutters align-items-center">
                  <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">Waktu Peminjaman Pinjaman</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{$waktu}}</div>
                  </div>
                  <div class="col-auto">
                  </div>
                </div>
              </div>
            </div>
          </div>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Tabel Angsuran</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <input type="hidden" name="" value="nanoabbg">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Jumlah Bayar</th>
                            <th>No.Bukti</th>
                        </tr>

                    </thead>
                    <tbody>
                        @foreach($data as $d)
                        <tr>
                            @if($d->tanggal)
                            <td>{{$d->tanggal}}</td>
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
            </div>
        </div>
</div>

<div class="col-xl-3 col-md-6 mb-4">
   <div class="card border-left-secondary shadow h-100 py-2">
     <div class="card-body">
       <div class="row no-gutters align-items-center">
         <div class="col mr-2">
           <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">Jumlah Yang Telah Dibayar </div>
           <div class="h5 mb-0 font-weight-bold text-gray-800">@currency($jum)</div>
         </div>
         <div class="col-auto">
         </div>
       </div>
     </div>
   </div>
 </div>

<div class="modal fade" id="transaksiAnggota" tabindex="-1" role="dialog" aria-labelledby="tambahTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="tambahTitle">Formulir Transaksi Angsuran Sementara</h5>
        <button type="button" class="tutup close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="/transaksi-add-angsuran-sementara" method="post">
      <div class="modal-body">
          {{ csrf_field() }}
           <input type="hidden" name="name" value="{{$pinjaman->full_name}}">
          <div class="form-group">
              <label for="tanggal">Tanggal Transaksi :</label>
              <input id="datepicker" width="276px" name="tanggal"/>
          </div>

          <div class="form-group">
              <label for="total">Jumlah Total Dibayarkan </label>
              <input name="total" id="total" type="text" class="form-control " autocomplete="off" placeholder="Jumlah Total" />
          </div>

          <div class="form-group">
              <label for="total">Bunga</label>
              <input name="bunga" id="bunga" type="text" class="form-control " autocomplete="off" placeholder="Jumlah Total"/>
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

    $("#tambahtransaksi").click(function () {
        $("#total").val($("#total").val().replace(/[^,\d]/g, '').toString());
        $("#bunga").val($("#bunga").val().replace(/[^,\d]/g, '').toString());
        this.disabled=true;
        this.value='Mengirim Data...';
    });

        $("#total").keyup(function () {
            $(this).val(formatRupiah(($(this).val()),'Rp. '));
        });

        $("#bunga").keyup(function () {
            $(this).val(formatRupiah(($(this).val()),'Rp. '));
        });


    $(".tutup").click(function () {
        $("#total").val("");
        $("#bunga").val("");
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
