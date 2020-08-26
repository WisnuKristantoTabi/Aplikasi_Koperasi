@extends('template.admin')

@section('title', 'Transaksi')

@section('content')



<p class="text-center font-weight-bold text-body p-2"> {{$detail->nama_perkiraan_detail}} </p>
<p class="text-center font-weight-bold text-body "> Nomor Perkiraan : {{$detail->nomor_perkiraan}} </p>


<div class="mt-4 mb-3 d-flex justify-content-around">

<div>
    <label class="text-dark mr-3">Periode : </label>
    <select id="periode" class="custom-select custom-select-sm mr-3" style="width:200px" name="periode">
        @foreach ($periode as $p)
            <option @if($id_periode == $p->id) selected @php $np=$p->nama_periode  @endphp @endif value="{{$p->id}}">{{$p->nama_periode}}</option>
        @endforeach
    </select>
</div>

<div>
    <label class="text-center">Pilih Perkiraan : </label>
    <select id="link" class="custom-select custom-select-sm mr-3" style="width:200px" name="perkiraan">
        @php $i = 1  @endphp
        @foreach($perkiraan as $prk)
            @if( $i < $prk->perkiraan_table_id )
            @php $i++  @endphp
        <option disabled>_________</option>
            @endif
        <option @if($detail->nomor_perkiraan == $prk->nomor_perkiraan ) selected @endif value= {{$prk->id}} >( {{ $prk->nomor_perkiraan}} ). {{ $prk->nama_perkiraan_detail}} </option>
         @endforeach
    </select>
    <button type="button" id="cari" class="btn btn-md btn-info"> Cari </button>
</div>
</div>


<div class="float-right">

</div>


<div class="line"></div>

@php $total = 0  @endphp

<div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Tabel Buku Besar</h6>
    </div>
    <div class="card-body">
    <div class="table-responsive">

    <table class="table table-bordered">
        <thead>
            <tr >

                <th scope="col" rowspan="2" class="text-center font-weight-bold text-body"> Tanggal </th>
                <th scope="col" rowspan="2">Keterangan </th>
                <th scope="col" rowspan="2">Debet</th>
                <th scope="col" rowspan="2">Kredit</th>
                <th scope="col" colspan="2">Saldo</th>
            </tr>
            <tr>
                <th scope="col">Debet</th>
                <th scope="col">Kredit</th>
            </tr>
        </thead>
        <tbody>
        @if(empty($data[0]))
        <tr > <th class="text-center font-weight-bold text-body" colspan="6"> Data Tidak Ditemukan </th></tr>
        @else
            @foreach($data as $no => $d)
            <tr>
                @php $total = $total + $d->debit @endphp
                <td>{{$d->tanggal}}</td>
                <td>{{$d->keterangan}}</td>
                <td>@currency($d->debit)</td>
                <td>@currency($d->kredit)</td>
                @if($d->debit != 0)
                    @if($total < 0)
                    <td>@currency($total * (-1))</td>
                    @else
                    <td>@currency($total)</td>
                    @endif
                @else
                <td> - </td>
                @endif

                @php $total = $total - $d->kredit  @endphp

                @if($d->kredit != 0)
                    @if($total < 0)
                    <td>@currency($total * (-1))</td>
                    @else
                    <td>@currency($total)</td>
                    @endif
                @else
                <td> - </td>
                @endif
            </tr>
            @endforeach
            <tr >
                <th colspan="4"> Jumlah</th>
                @if($total < 0)
                <th colspan="2">@currency($total * (-1)) (Saldo Kredit)</th>
                @else
                <th colspan="2">@currency($total) (Saldo Debit)</th>
                @endif
            </tr>

        @endif
        </tbody>
    </table>
</div>
</div>
</div>

<a href="/buku-besar/cetak/?i={{$id_akun}}&&pti={{$id_periode}}&&akun={{$detail->nama_perkiraan_detail}}&&periode={{$np}}" class="btn btn-warning">Cetak</a>

<script type='text/javascript'>
$(document).ready(function() {

   //this will be triggered when the first button was clicked
   $("#cari").click(function(){
      var akun = $("#link").find(":selected").val();
      var periode = $("#periode").find(":selected").val();
      document.location.href = '/buku-besar?i='+akun+'&&pti='+periode;
   });
});
</script>



@endsection
