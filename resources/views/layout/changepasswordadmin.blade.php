
@if(Session::get('role')=='admin')
    @extends('template.admin')
@elseif(Session::get('role')=='member')
    @extends('template.member')
@endif

@section('title', 'Tutup Akun')


@section('content')

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
                    <form action="/gantipassword/proses" method="post">
                    {{ csrf_field() }}


                    <div class="form-group">
                        <label for="passwordlama">Masukkan Password Lama</label>
                        <input class="form-control form-password" type="password" placeholder="Masukkan Lama" autocomplete="off" name="passwordlama" >
                    </div>

                    <div class="form-group">
                        <label class="card-text">Masukkan Password Baru</label>
                        <input class="form-control form-password" type="password" placeholder= "Masukkan Password Baru" autocomplete="off" name="passwordbaru" >
                    </div>

                    <div class="form-group">
                        <label for="" >Ulangi Masukkan Password Baru</label>
                        <input class="form-control form-password" type="password" placeholder= "Ulangi Masukkan Password Baru" autocomplete="off" name="repasswordbaru" >
                    </div>

                    <div class="form-group form-check">
                    	<input type="checkbox" class="form-check-input form-checkbox">
                    	<label class="form-check-label" for="repasswordbaru">Show password</label>
                  	</div>

                    <input class="btn btn-primary" type="submit" value="Ganti Password">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
	$(document).ready(function(){
		$('.form-checkbox').click(function(){
			if($(this).is(':checked')){
				$('.form-password').attr('type','text');
			}else{
				$('.form-password').attr('type','password');
			}
		});
	});
</script>

@endsection
