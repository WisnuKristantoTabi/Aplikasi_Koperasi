@extends('template.admin')

@section('title', 'Daftar Member')

@section('content')





<div class="card o-hidden border-0 shadow-lg my-5">
    <div class="card-body p-0">
    <div class="table-responsive">
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
                    <p class="text-dark">Tambah Akun Admin</p>
                    <form action="/register-addadmin" method="post">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="full_name">Nama Lengkap Admin :</label>
                            <input class="form-control" type="text"  id="full_name" name="full_name" autocomplete="off" placeholder="Masukkan Nama Pemohon" >
                        </div>

                        <div class="form-group">
                            <label for="response">Username Admin :</label>
                            <input class="form-control" type="text"  id="username" name="username" autocomplete="off" placeholder="Masukkan Username Pemohon" >
                            <div  id="response" class="m-3"><div id="loader" class="spinner-border text-primary" role="status"></div></div>
                        </div>
                        <input class="btn btn-facebook btn-user btn-block" id="tambah" type="submit" value="Tambahkan Ke Database">

                    </form>
                </div>
            </div>
        </div>
        </div>
    </div>
</div>

<script type="text/javascript">
$(document).ready(function(){
    $("#loader").hide();
    $("#username").keyup(function(){
        var username = $(this).val().trim();
        if (username != '') {
            $.ajax({
                url: '/register-cekusername',
                type: 'get',
                data:{username:username},
                beforeSend: function(){
                    $("#loader").show();
                },
                success : function(response){
                    $('#response').html(response);
                },
                complete:function(data){
                    $("#loader").hide();
                }
            });
        }else {
            $('#response').html('');
        }
    });
    $("#tambah").click(function () {
        this.disabled=true;
        this.value='Mengirim Data...';
    })
});
</script>

@endsection
