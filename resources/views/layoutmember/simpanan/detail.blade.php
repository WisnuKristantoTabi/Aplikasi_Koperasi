@extends('template.member')

@section('title', 'Detail Simpanan')

@section('content')


<div class="row">
    <div class="col">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Tabel Riwayat Data Simpanan</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                      <thead>
                        <tr >
                            <th scope="col"><center>No.Bukti</center></th>
                            <th scope="col"><center>Tanggal Penyetoran</center></th>
                            <th scope="col"><center>Sebesar</center></th>
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
                                  <td> @currency($d->saldo)</td>
                              </tr>
                              @endforeach
                          @endif
                    </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>





@endsection
