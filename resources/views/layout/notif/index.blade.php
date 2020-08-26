@extends('template.member')

@section('title', 'Transaksi')

@section('content')

<div class="container">
    <table class="table table-bordered">
      <thead>
        <tr>
            <th scope="col"><center>No </center></th>
            <th scope="col"><center>Pesan</center></th>
            <th scope="col"><center>Aksi</center></th>
        </tr>
      </thead>
      <tbody>
          @foreach($data as $no => $d)
          <tr>
             <td>{{$no+1}}</td>
             <td>
                 <p class="@if($d->status == 1) font-weight-bolder text-primary @else font-weight-normal text-dark @endif">
                  {{substr($d->content,0,20)." ... "}}

                 </p>
             </td>
             <td>
                 <a class="btn btn-info m-2" href="/notif-show?id={{$d->id}}"><i class="fas fa-fw fa-eye"></i> Lihat</a>
                 <form id="hapus-notif" action="/notif/hapus/?id={{$d->id}}" method="post">
                     @csrf
                     <a class="btn btn-danger m-2" href="/notif/hapus/?id={{$d->id}}" onclick="event.preventDefault(); document.getElementById('hapus-notif').submit();"><i class="fas fa-fw fa-trash-alt"></i> Hapus</a>
                 </form>

             </td>
          </tr>
          @endforeach
      </tbody>
    </table>

     <div class="d-flex justify-content-center">{{ $data->links() }}</div>
</div>
@endsection
