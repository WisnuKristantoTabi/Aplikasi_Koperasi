@extends('template.admin')
@section('title', 'Perkiraan ')
@section('content')


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

<div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Tabel List Perkiraan</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
        <a class="m-3 btn btn-info" href="/perkiraan-tambah">Tambah</a>
        <table class="table table-bordered">
            <thead>
                <tr >
                    <th scope="col" class="text-center font-weight-bold text-body" >Nomor</th>
                    <th scope="col" class="text-center font-weight-bold text-body"> Akun </th>
                    <th scope="col" class="text-center font-weight-bold text-body">Nama</th>
                    <th scope="col" class="text-center font-weight-bold text-body" >Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $d)
                <tr>
                    <td>{{$d->nomor_perkiraan}}</td>
                    <td>{{$d->nama_perkiraan}}</td>
                    <td>{{$d->nama_perkiraan_detail}}</td>
                    <td>
                        @if($d->keterangan_id ==1)
                        <button class="btn btn-warning m-1" type="button"
                        data-toggle="modal" data-id="{{ $d->dpi }}" data-nomorperkiraan="{{ $d->nomor_perkiraan }}"
                        data-pti="{{ $d->perkiraan_table_id }}" data-npd="{{$d->nama_perkiraan_detail}}"
                        data-title ="{{$d->nama_perkiraan_detail}}"
                        data-target="#edit"><i class="fas fa-fw fa-edit"></i> Edit</button>

                        <form id=hapus-data action="/perkiraan/hapusperkiraan/?id={{ $d->dpi }}" method="post">
                            @csrf
                            <a class="btn btn-danger m-1" href="/perkiraan/hapusperkiraan/?id={{ $d->dpi }}" onclick="event.preventDefault(); document.getElementById('hapus-data').submit();"><i class="fas fa-fw fa-trash-alt"></i> Hapus</a>
                        </form>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        </div>
    </div>
</div>


<div class="modal fade" id="edit" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="tambahTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="tambahTitle">Ubah Data</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="/perkiraan/editperkiraan" method="post">
      <div class="modal-body">
          {{ csrf_field() }}
            <div class="form-group">
              <label >Jenis Perkiraan</Label>

              <select class="custom-select custom-select-sm mr-3" name="golongan_perkiraan">
                  @foreach($perkiraan as $p)
                    <option value= {{$p->id}} > {{$p->nama_perkiraan}}</option>
                  @endforeach
              </select>
            </div>
            <div class="form-group">
                  <label >Nomor Perkiraan</label>
                  <input class="form-control" id="nomorperkiraan" type="text" placeholder= "Masukkan Nomor Perkiraan" name="nomor_perkiraan" value="{{ $d->nomor_perkiraan }}">
            </div>
            <div class="form-group">
                  <label >Nama Perkiraan</label>
                  <input name="nama" id="nama" type="text" class="form-control" autocomplete="off" placeholder="Nama Perkiraan" value="{{$d->nama_perkiraan_detail}}"/>
                  <input name="id" id="id" type="hidden" value="{{ $d->dpi }}" />
            </div>

      </div>
      <div class="modal-footer">
         <input class="btn btn-primary" type="submit" value="Tambahkan Ke Transaksi">
         <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
      </form>
    </div>
  </div>
</div>
</div>
<script src="{{ asset('js/perkiraan.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.4.0/bootbox.min.js"></script>


<script >

$(document).on("click", "#hapus-data", function(e) {
    e.preventDefault();
    var link = $(this).attr("href");
    bootbox.confirm({
        title: "Tutup Akun ini?",
        message: "Apakah Anda Yakin Ingin Menghapus Dari Daftar Akun?",
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



/*
    $("#ubahbtn").click(function () {
        var Id = $(this).data('id');
        var nomorperkiraan = $(this).data('nomorperkiraan');
        var pti = $(this).data('pti');
        var npd = $(this).data('npd');

         $(".modal-body #id").val( Id );
         $(".modal-body #nomorperkiraan").val( nomorperkiraan );
         $(".modal-body #nama").val( npd );
         $(".modal-body #pti").val( pti );

    });
*/

</script>

@endsection
