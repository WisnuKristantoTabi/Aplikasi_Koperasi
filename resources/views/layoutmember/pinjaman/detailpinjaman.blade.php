@extends('template.member')

@section('title', 'Detail ')

@section('content')


<div class="m-3 d-flex justify-content-between">
    <p class="text-dark">{{$data->no_bukti}}</p>
</div>

<br>
<div class="d-flex flex-row-reverse mb-5">
    <div class="card text-white bg-secondary shadow-lg rounded mb-3 mr-3" style="max-width: 18rem;">
      <div class="card-header text-dark">Tanggal Pinjaman</div>
      <div class="card-body">
        <p class="card-text text-white"> {{$data->tanggal}}</p>
       </div>
      </div>

    <div class="card text-white bg-primary shadow-lg rounded mb-3 mr-3" style="max-width: 18rem;">
      <div class="card-header text-dark">Sisa Angsuran</div>
      <div class="card-body">
        <p class="card-text text-white">{{$data->sisa_angsuran}}</p>
       </div>
      </div>

    <div class="card text-white bg-info shadow-lg rounded mb-3 mr-3" style="max-width: 18rem;">
      <div class="card-header text-dark">Pinjaman</div>
      <div class="card-body">
        <p class="card-text text-white"> @currency($data->jumlah_pinjaman)</p>
       </div>
      </div>
      <div class="card text-white bg-success shadow-lg rounded mb-3 mr-3" style="max-width: 18rem;">
        <div class="card-header text-dark">Jenis Pinjaman</div>
        <div class="card-body">
          <p class="card-text text-white"> {{$data->nama}}</p>
         </div>
        </div>
</div>
@php $jum = 0 @endphp

<table class="table table-bordered table-striped table-hover">
    <thead>
        <tr>
            <th>Tanggal</th>
            <th>Jumlah Angsuran</th>
            <th>Jumlah Bayar</th>
            <th>No.Bukti</th>
            <th>Total</th>
        </tr>

    </thead>
    <tbody>

        @if(empty($angs[0]))
        <td colspan="4">Data Tidak Ditemukan</td>
        @else
        @foreach($angs as $a)
        <tr>
            <td>{{$a->tanggal}}</td>
            <td>{{$a->jumlah_angsuran}}</td>
            <td>@currency($a->jumlah_bayar)</td>
            <td>{{$a->no_bukti}}</td>
            @php $jum = $jum+ $a->jumlah_bayar @endphp
            <td>@currency($jum)</td>
        </tr>
        @endforeach
        @endif
    </tbody>
</table>

<div class="card border-secondary mb-3" style="max-width: 18rem;">
    <div class="card-header">Jumlah Yang Telah Dibayar </div>
    <div class="card-body text-secondary">
        <h5 class="card-title">@currency($jum)</h5>
    </div>
</div>


@endsection
