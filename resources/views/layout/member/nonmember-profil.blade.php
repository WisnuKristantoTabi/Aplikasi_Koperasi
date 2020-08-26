@extends('template.admin')

@section('title', 'Member Profil')

@section('content')

<style >
.my-custom-scrollbar {
position: relative;
height: 200px;
overflow: auto;
}
.table-wrapper-scroll-y {
display: block;
}
</style>


<h1>{{$user->full_name}}</h1>


<table class="m-4 mt-5">
       <tr>
           <td><p class="text-dark">Jenis Kelamin</p></td>
           <td><p class="text-dark">: {{$user->jenis}}</p></td>
       </tr>
       <tr>
           <td><p class="text-dark">Alamat</p></td>
           <td><p class="text-dark">: {{$user->alamat}}</p></td>
       </tr>
       <tr>
           <td><p class="text-dark">Nomor Telpon</p></td>
           <td><p class="text-dark">: {{$user->no_telpon}}</p></td>
       </tr>
</table>

<br>

<div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Tabel Riwayat Pinjaman</h6>
    </div>
    <div class="card-body">
    <div class="table-responsive">

        <div class="container table-wrapper-scroll-y my-custom-scrollbar">
             <table class="table table-bordered table-striped mb-0">
                <thead>
                    <tr>

                        <th scope="col" class="text-center font-weight-bold text-body"> Tanggal </th>
                        <th scope="col" class="text-center font-weight-bold text-body">Jenis Pinjaman</th>
                        <th scope="col" class="text-center font-weight-bold text-body">Pinjaman Yang Diambil </th>
                        <th scope="col" class="text-center font-weight-bold text-body">Pembayaran Perangsuran</th>
                        <th scope="col" class="text-center font-weight-bold text-body">Sisa Angsuran</th>
                        <th scope="col" class="text-center font-weight-bold text-body">Status</th>
                    </tr>
                </thead>
                <tbody>
                @if(empty($pinjaman[0]))
                <tr > <th class="text-center font-weight-bold text-body" colspan="6"> Data Tidak Ditemukan </th></tr>
                @else
                @foreach($pinjaman as $p)
                    <tr>
                        <td>{{$p->tanggal}}</td>
                        <td>{{$p->nama}}</td>
                        <td>@currency($p->jumlah_pinjaman)</td>
                        <td>{{$p->pembayaran}}</td>
                        <td>{{$p->sisa_angsuran}}</td>
                        <td>{{$p->keterangan}}</td>
                    </tr>
                    @endforeach
                @endif
                </tbody>
            </table>
        </div>
    </div>
    </div>
</div>

@endsection
