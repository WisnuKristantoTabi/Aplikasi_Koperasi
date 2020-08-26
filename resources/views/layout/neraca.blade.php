
@extends('template.admin')

@section('title', 'Neraca')

@section('content')


<strong class="text-center"><center>KOPERASI SENTOSA SMPN 2 MAROS</center></strong>
<strong class="text-center"><center>{{$date}}</center></strong>
<div class="d-flex flex-row-reverse bd-highlight">
    <div class="p-2 bd-highlight"><a href="/neraca/cetakneraca" class="btn btn-primary">Cetak</a></div>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Tabel Neraca</h6>
    </div>
    <div class="card-body">
    <div class="table-responsive">
            <table class="table table-bordered">
              <thead>
                <tr >
                    <th scope="col">Nomor Perkiraan</th>
                    <th scope="col">Nama Perkiraan</th>
                    <th scope="col">Saldo</th>
                    <th scope="col">Aksi</th>
                </tr>
              </thead>
              <tbody>

                  @php $jum=0 @endphp
                @foreach($aktiva as $a)
                    <tr>
                        <td >{{ $a->nomor_perkiraan }} </td>
                        <td>{{ $a->nama_perkiraan_detail}}</td>
                        <td>@currency($a->jumlah_perkiraan)</td>
                        <td>
                            <button type="button" class="btn btn-danger"
                            data-id="{{ $a->dpi }}"
                            data-title="{{ $a->nama_perkiraan_detail }}"
                            data-jumlah={{$a->jumlah_perkiraan}}
                            data-nomor="{{ $a->nomor_perkiraan }}"
                            data-toggle="modal" 
                            data-target="#ubahNeraca">Ubah</button>
                        </td>
                         @php $jum= $jum+$a->jumlah_perkiraan @endphp
                    </tr>

                @endforeach

                <tr >
                    <td colspan="2" class="bg-success"><p class="font-weight-bold text-white text-center">Jumlah<p></td>
                    <td colspan="2" class="bg-success"><p class="font-weight-bold text-white">@currency($jum)</p></td>
                     @php $jum=0 @endphp
                </tr>

                @foreach($passiva as $p)
                    <tr>
                        <td >{{ $p->nomor_perkiraan }} </td>
                        <td>{{ $p->nama_perkiraan_detail}}</td>
                        <td>@currency($p->jumlah_perkiraan)</td>
                        <td>
                            <button type="button" class="btn btn-danger"
                            data-id="{{ $p->dpi }}"
                            data-title="{{ $p->nama_perkiraan_detail }}"
                            data-jumlah={{$p->jumlah_perkiraan}}
                            data-nomor="{{ $p->nomor_perkiraan }}"
                            data-toggle="modal" 
                            data-target="#ubahNeraca">Ubah</button>
                        </td>
                         @php $jum= $jum+$p->jumlah_perkiraan @endphp
                    </tr>
                @endforeach

                <tr >
                    <td colspan="2" class="bg-success"><p class="font-weight-bold text-white text-center">Jumlah<p></td>
                    <td colspan="2" class="bg-success"><p class="font-weight-bold text-white">@currency($jum)</p></td>
                </tr>

              </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="ubahNeraca" tabindex="-1" role="dialog" aria-labelledby="ubahNeracaTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ubahNeracaTitle"></h5>
        <button type="button" class="tutupEdit close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="/neraca-ubah" method="post">
      <div class="modal-body">
          {{ csrf_field() }}
          <input type="hidden" id="id_modal" name="id" > <br/>
          <div class="form-group">
               <label for="Transaksi_name">Nama Perkiraan : </label>
              <input id="nama" class="form-control" name="nama" />
          </div>
          <div class="form-group">
               <label for="Transaksi_name">Nomor Perkiraan : </label>
              <input id="nomor" class="form-control " name="nomor" />
          </div>
          <div class="form-group">
               <label for="Transaksi_name">Jumlah Perkiraan : </label>
              <input id="jumlah" class="form-control" name="jumlah" />
          </div>
      </div>
      <div class="modal-footer">
         <input class="btn btn-primary" id="edit" type="submit" value="Oke ">
      </div>
      </form>
    </div>
  </div>
</div>

<script>
$('#ubahNeraca').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget)
    var id = button.data('id')
    var nomor = button.data('nomor')
    var title =  button.data('title')
    var jumlah =  button.data('jumlah')

     var modal = $(this)
     modal.find('.modal-title').text(title)
     modal.find('.modal-body #id_modal').val(id)
     modal.find('.modal-body #nomor').val(nomor)
     modal.find('.modal-body #nama').val(title)
     modal.find('.modal-body #jumlah').val(formatRupiah(jumlah.toString(),'Rp. '))
     
})



$(document).ready(function () {

    $("#jumlah").keyup(function () {
        $(this).val(formatRupiah(($(this).val()),'Rp. '));
    });
    
    $("#edit").click(function () {
        $(".modal-body #jumlah").val($(".modal-body #jumlah").val().replace(/[^,\d]/g, '').toString());
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
