@extends('template.admin')

@section('title', 'Detail Aset')

@section('content')




<p class="text-dark text-center">{{$data->nama_aset}}</p>
<br>
<p class="text-dark text-center">Tahun Pembelian : {{$tahun}}</p>
<br>
<p class="text-dark text-center">Tahun Pemakaian : {{($time->year+1) - $tahun}} Tahun</p>

<div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Tabel Akumulasi Aset</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <p class="font-italic">Peritungan menggunakan straight line method</p>
            <table class="table table-bordered">
              <thead>
                <tr class="bg-primary">
                    <th scope="col"><center>Tahun Ke-</center></th>
                    <th scope="col"><center>Harga Perolehan</center></th>
                    <th scope="col"><center>Nilai Residu</center></th>
                    <th scope="col"><center>Umur Ekonomis</center></th>
                    <th scope="col"><center>Penyusutan</center></th>
                    <th scope="col"><center>Akumulasi Penyusutan</center></th>
                    <th scope="col"><center>Harga Buku</center></th>

                </tr>
              </thead>
              <tbody>
            @php
                $pny = ( ( $data->harga - $data->nilai_residu ) / $data->umur_ekonomis )  ;
            @endphp

            @for ($i = 1; $i <= (($time->year+1) - $tahun); $i++)

                <tr>
                    <td><p class="text-info">{{$i}}</p></td>
                    <td><p class="text-info">@currency($data->harga)</p></td>
                    <td><p class="text-info">@currency($data->nilai_residu)</p></td>
                    <td><p class="text-info">{{$data->umur_ekonomis}}</p></td>
                    <td><p class="text-info">@currency($data->penyusutan)</p></td>
                    <td><p class="text-info">@currency(($data->penyusutan)*$i)</p></td>
                    <td><p class="text-info">@currency(($data->harga)-(($data->penyusutan)*$i))</p></td>
                </tr>

            @endfor
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
