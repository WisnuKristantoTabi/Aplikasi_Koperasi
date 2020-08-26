@extends('template.member')

@section('title', 'Pesan')

@section('content')

<table class="table table-bordered">
    <tr>
        <td colspan="2"><p class="text-center font-weight-bolder">Pesan</p></td>
    </tr>
    <tr>
        <td><p class="text-center font-weight-bolder">Tanggal</p></td>
        <td><p class="text-center">{{$data->tanggal}}</p></td>
    </tr>
    <tr>
        <td colspan="2"><p class="text-center font-weight-bolder">Isi Pesan</p></td>
    </tr>
    <tr class="bg-secondary">
        <td colspan="2"><p class=" text-white">{{$data->content}}</p></td>
    </tr>

</table>

<p class="dark"></p>

@endsection
