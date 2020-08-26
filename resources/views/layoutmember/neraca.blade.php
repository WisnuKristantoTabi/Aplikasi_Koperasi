@extends('template.member')

@section('title', 'Neraca')

@section('content')


<strong class="text-center"><center>KOPERASI SENTOSA SMPN 2 MAROS</center></strong>
<strong class="text-center"><center>{{$date}}</center></strong>
<div class="d-flex flex-row-reverse bd-highlight">
    <div class="p-2 bd-highlight"><a href="/neraca/cetakneraca" class="btn btn-warning ">Cetak</a></div>
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
                </tr>
              </thead>
              <tbody>

                  @php $jum=0 @endphp
                @foreach($aktiva as $a)
                    <tr>
                        <td >{{ $a->nomor_perkiraan }} </td>
                        <td>{{ $a->nama_perkiraan_detail}}</td>
                        <td>@currency($a->jumlah_perkiraan)</td>
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

@endsection
