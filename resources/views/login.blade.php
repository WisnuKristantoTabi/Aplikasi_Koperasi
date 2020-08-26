@extends('template/header')
@section('header')
@section('title','Aplikasi Akuntansi')

<script src="https://code.jquery.com/jquery-1.12.4.js"></script>

<script  type="text/javascript">
function preback(){
	window.history.forward();
}
	setTimeout("preback()",0);
	window.onunload=function(){null};
</script>


	<center>
  <div class="card-body">
      <div class="card shadow-lg p-3 mb-5 rounded" style="width: 18rem;  padding:12px;">
          <img src="{{ asset('image/logo_koperasi.png') }}" class="card-img-top" alt="...">
        <center><h4 class="card-title">Login</h4></center>
      @if(\Session::has('alert'))
      <div class="alert alert-danger">
            <div>{{Session::get('alert')}}</div>
      </div>
     @endif

    <form action="/proseslogin" method="post">
    {{ csrf_field() }}

	<div class="form-group">
		<label>UserName</label>
    	<input class="form-control" type="text" placeholder= "Masukkan UserName" name="username" value="{{ old('username') }}">
	</div>
	<div class="form-group">
		<label for="password" >Password</label>
	    <input class="form-control form-password" type="password" placeholder= "Masukkan Password" name="password" value="{{ old('password') }}">

	</div>
	<div class="form-group form-check">
    	<input type="checkbox" class="form-check-input form-checkbox">
    	<label class="form-check-label" for="exampleCheck1">Show password</label>
  	</div>
    <input class="btn btn-primary" type="submit" value="Login">
    </form>
    </div>
    </div>
</center>



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




@extends('template/footer')
@section('footer')
