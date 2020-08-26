@extends('template.member')

@section('title', 'Pinjaman')

@section('content')

<div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Tabel Neraca</h6>
    </div>
        <div class="card-body">
            <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr >
                                <th scope="col"><center>No.Bukti</center></th>
                                <th scope="col"><center>Tanggal Peminjaman</center></th>
                                <th scope="col"><center>Jumlah Pinjaman</center></th>
                                <th scope="col"><center>Jenis Pinjaman</center></th>
                                <th scope="col"><center>Angsuran Yang Diambil</center></th>
                                <th scope="col"><center>Sisa Angusuran</center></th>
                                <th scope="col"><center>Aksi</center></th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(empty($data[0]))
                            <tr > <th class="text-center font-weight-bold text-body" colspan="7"> Data Tidak Ditemukan </th></tr>
                            @else
                                @foreach($data as $d)
                                <tr>
                                    <td> {{$d->no_bukti}}</td>
                                    <td> {{$d->tanggal}}</td>
                                    <td> @currency($d->jumlah_pinjaman)</td>
                                    <td> {{$d->nama}}</td>
                                    <td> {{$d->jumlah_angsuran}}</td>
                                    <td> {{$d->sisa_angsuran}}</td>
                                    <td> <a class="btn btn-warning" href="/pinjaman-detail-member?pid={{$d->pid}}">Detail</a> </td>
                                </tr>

                                @endforeach
                            @endif
                        </tbody>
                    </table>
            </div>
        </div>
</div>


@endsection
