@extends('template.admin')

@section('title', 'Jurnal Umum')

@section('content')


    <strong class="text-center"><center>Jurnal Umum</center></strong>
    <div class="line"></div>
    <div class="mb-3 d-flex flex-row-reverse bd-highlight">

        <button type="button" id="cari" class="btn btn-md btn-info"> Cari </button>
        <select class="custom-select custom-select-sm mr-3" style="width:200px" name="periode" id="link">
            @foreach ($periode as $p)
                <option @if($id_periode == $p->id) @php $np=$p->nama_periode @endphp selected @endif value="{{$p->id}}">{{$p->nama_periode}}</option>
            @endforeach
        </select>
        <p class="text-dark mr-3">Periode : </p>
    </div>
    <div class="d-flex flex-row-reverse bd-highlight">

        <div class="p-2 bd-highlight"><a href="/jurnal-umum/cetak/?pti={{$id_periode}}&&periode={{$np}}" class="btn btn-warning mb-3">Cetak</a></div>
        @if($id_periode == getIdLatest("periode_table"))
        <div class="p-2 bd-highlight"><a href="/jurnal-umum-tambah" class="btn btn-info mb-3">Tambah Transaksi</a></div>
        @endif

    </div>
<div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Tabel Jurnal Umum</h6>
    </div>
    <div class="card-body">
    <div class="table-responsive">
        <table class="table table-bordered cellspacing="0"">
            <thead>
                <tr>
                    <th scope="col" rowspan="2"><p class="text-center font-weight-bold text-body">Tanggal</p></th>
                    <th scope="col" rowspan="2"><p class="text-center font-weight-bold text-body">Keterangan</p></th>
                    <th scope="col" colspan="2"><p class="text-center font-weight-bold text-body">Saldo</p></th>
                    <th scope="col" rowspan="2"><p class="text-center font-weight-bold text-body">Diinput</p></th>
                </tr>
                <tr >
                    <th scope="col">Debet</th>
                    <th scope="col">Kredit</th>
                </tr>
            </thead>

            <tbody>
                @foreach($data as $d)
                <tr>
                    <td >{{$d->tanggal}}</td>
                    <td >{{ $d->nama_perkiraan_detail}}</td>
                    <td>@currency($d->debit)</td>
                    <td>@currency($d->kredit)</td>
                    <td>{{$d->full_name}}</td>

                </tr>
                @endforeach
            </tbody>

        </table>
    </div>
</div>
</div>

<script type='text/javascript'>
$(document).ready(function() {

   //this will be triggered when the first button was clicked
   $("#cari").click(function(){
      //this will find the selected website from the dropdown
      var go_to_url = $("#link").find(":selected").val();
      document.location.href = '/jurnal-umum?pti=' +go_to_url;
      //window.open('/buku-besar/' +go_to_url, '_blank');
   });
});
</script>

@endsection
