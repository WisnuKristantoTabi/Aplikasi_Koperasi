@extends('template.admin')

@section('title', 'Daftar Non-Member')

@section('content')




<div class="card o-hidden border-0 shadow-lg my-5">
    <div class="card-body p-0">
    <div class="table-responsive">
        <div class="row">
            <div class="col">
                <div class="p-5">
                    <p class="text-dark">Tambah Non Member</p>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                        <form action="/register-addnonuser" method="post">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="namasearch">Nama Lengkap Pemohon :</label>
                                <input class="form-control" type="text"  id="name" name="nama" placeholder="Masukkan Nama Lengkap" >
                            </div>

                            <div class="form-group">
                                <label for="jeniskelamin">Jenis Kelamin :</label>
                                <div class="form-check">
                                    <input type='radio' class="form-check-input" id="jeniskelamin" name='jeniskelamin' value='1' checked='checked' />
                                     <label class="form-check-label" for="jeniskelamin">
                                       Pria
                                     </label>
                                 </div>
                                 <div class="form-check">
                                     <input type='radio' class="form-check-input" id="jeniskelamin" name='jeniskelamin' value='2' />
                                      <label class="form-check-label" for="jeniskelamin">
                                        Wanita
                                      </label>
                                  </div>
                            </div>

                            <div class="form-group">
                                <label for="alamat">Alamat Pemohon :</label>
                                <input class="form-control" type="text"  id="alamat" name="alamat" placeholder="Masukkan Alamat" >
                            </div>

                            <div class="form-group">
                                <label for="telpon">No.HP :</label>
                                <input class="form-control" type="text"  id="telpon" name="telpon" placeholder="Masukkan Nomor Telpon" >
                            </div>


                            <div class="form-group">
                                <input class="btn btn-primary " id="tambah" type="submit" value="Tambahkan Ke Database">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            </div>
        </div>
</div>


<script type="text/javascript">
$(document).ready(function(){
    $("#tambah").click(function () {
        this.disabled=true;
        this.value='Mengirim Data...';
    })
});

</script>


@endsection
