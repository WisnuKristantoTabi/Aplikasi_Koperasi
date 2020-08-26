@extends('template.admin')

@section('title', 'Aset')

@section('content')

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
<link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />

<div class="card o-hidden border-0 shadow-lg my-5">
    <div class="card-body p-0">
        <div class="row">
            <div class="col">
                <div class="p-5">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                    <form action="/aset/edit/proses/?id={{$id}}" method="post">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="Transaksi_name">Nama Aset :</label>
                        <input name="nama" type="text" class="form-control " placeholder="Masukkan Nama Aset" value="{{$data->nama_aset}}" />
                    </div>
                    <div class="form-group">
                        <label for="tanggal">Tanggal Pembelian :</label>
                        <input id="datepicker" width="90%" name="tanggal"/>
                    </div>

                    <div class="form-group">
                        <label for="Transaksi_name">Perkiraan Umur Aset :</label>
                        <input name="umur" type="number" min="0" class="form-control " placeholder="Masukkan Umur Aset" value="{{$data->umur_ekonomis}}"/>
                    </div>
                    <input class="btn btn-facebook btn-user btn-block" id="tambahdata" type="submit" value="Ubah">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
$('#datepicker').datepicker({
    uiLibrary: 'bootstrap4',
    format: 'yyyy-mm-dd'
});
</script>

@endsection
