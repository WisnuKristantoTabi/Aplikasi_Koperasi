@extends('template/header')
@section('header')
@section('title','Aplikasi Akuntansi ')

<style media="screen">
 .balon-right {
    position: relative;
    border-radius: 10px;
    padding: 10px;
    background:#5cb85c;
    margin-bottom: 20px;
}

.balon-left {
   position: relative;
   border-radius: 10px;
   padding: 10px;
   margin-bottom: 20px;
}
.balon-right:after {
    position: absolute;
    content: '';
    display: block;
    position: absolute;
    bottom: -20px;
    right: 30px;
    border-top: solid 20px #5cb85c;
    border-left: solid 10px transparent;
    border-right: solid 10px transparent;
}

.balon-left:after {
    position: absolute;
    content: '';
    display: block;
    position: absolute;
    bottom: -20px;
    left: 30px;
    border-top: solid 20px #ffffff;
    border-left: solid 10px transparent;
    border-right: solid 10px transparent;
}

.kanan{
 right: 23px;
}


</style>

<div class="container-fluid" >
<nav class="navbar navbar-expand-lg shadow-lg p-3 mb-5 rounded navbar-light bg-success">

      <a class="navbar-brand text-white" href="@if(Session::get('login')&& Session::get('role')=='admin') /dashboardadmin @elseif(Session::get('login')&& Session::get('role')=='member') /dashboardmember @else / @endif">Aplikasi Akuntansi</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
		</ul>
        <span class="navbar-text">
            @if(Session::get('login')&& Session::get('role')=='admin')
            <div class="btn-group ">
                    <button type="button" href="/dashboardadmin" class="btn">
                        <a class="text-white px-md-2 font-weight-bold" href="/dashboardadmin">{{Session::get('username')}}</a>
                    </button>
              </div>
            @elseif(Session::get('login')&& Session::get('role')=='member')
            <a class="nav-link text-white kanan" href="/dashboardmember">{{Session::get('username')}}</a>
            @else
            <a class="nav-link text-white kanan" href="/login">Login</a>
            @endif
        </span>

      </div>

</nav>

<div class="container" >

<div class="card card-image" style="background-image: url({{ asset('image/background.jpg') }})">
      <div class="text-white text-left rgba-stylish-strong " style="margin-left: 12px">
        <div class="py-5">

          <h2 class="card-title h2 my-4 py-2 ">Aplikasi Akuntansi</h2>
          <p class="mb-4 pb-2 px-md-5 mx-md-5 ">KP-RI SENTOSA SMPN Unggulan 2 Maros</p>

        </div>
      </div>
</div>
<div class="line"></div>
<br>

<div class="bg-light text-wrap shadow-lg p-3 mb-5 balon-left " style="width: 77%; padding:12px;">
    <p class="mb-4 pb-2 text-dark px-md-5 mx-md-5 ">
        Koperasi Merupakan suatu badan usaha yang dimiliki dan dioperasikan oleh para anggotanya untuk memenuhi
         kepentingan bersama. Koperasi adalah satu-satunya bentuk perusahaan yang paling
         sesuai dengan demokrasi ekonomi indonesia . Pada pasal 33 ayat 1 Undang-Undang
         Dasar 1945 yang menyebutkan bahwa perekonomian disusun sebagai usaha bersama
         berdasarkan asas kekeluargaan, sehingga Koperasi diharapkan sebagai salah satu pelaku ekonomi,
         dapat mampu menjadi soko guru bagi perekonomian Indonesia.
    </p>
</div>

<div class="line"></div>

<div class=" text-wrap shadow-lg p-3 mb-5 balon-right" style="padding:12px; margin-left:30%;">

    <p class="mb-4 pb-2  text-white px-md-5 mx-md-5 text-right">

        Dewasa ini penggunaan Teknologi khususnya dalam bidang informasi semakin meningkat.
        Teknologi infomasi dapat digunakan untuk menyampaikan informasi secara cepat dan akurat.
        Informasi yang disampaikan biasa menggunakan media internet yang dimana penggunanya dapat
         mengaksesnya melalui Website . Dengan perkembangan zaman dan diikuti dengan perkembangan
          teknologi informasi , pelaporan keuangan dapat dilakukan dengan mudah. Arus infomasi
          yang banyak memungkinkan sebuah aplikasi yang digunakan memiliki sistem dan database yang baik.
    </p>

</div>


<div class="line"></div>



<div class="bg-info text-wrap shadow-lg p-3 mb-5 oval " style="width: 77%; padding:12px; right: 0; ">
    <p class="mb-4 pb-2 text-white px-md-5 mx-md-5 text-center">

        Aplikasi ini bertujuan agar pemanfaatan teknologi informasi menggunakan website
        lebih optimal. Selain itu, Aplikasi ini diharapkan dapat membantu pengurus
        koperasi KPRI SENTOSA SMPN 2 Maros dalam menyusun dan melaporkan keuangan.

    </p>
</div>
</div>

<div class="line"></div>


<div id="carouselExampleFade" class="carousel slide carousel-fade" data-ride="carousel">
  <div class="carousel-inner">
    <div class="carousel-item active">
        <img src="{{ asset('image/Iklan1.png') }}" class="d-block w-100" alt="...">
    </div>
    <div class="carousel-item">
        <img src="{{ asset('image/Iklan2.png') }}" class="d-block w-100" alt="...">
        <div class="carousel-caption d-none bg-light d-md-block">
            <p class="display-5 text-body">Kunjungi Website Untuk Menggunakan Aplikasi</p>
            <a class="text-info" href="/"><i>"Aplikasi Akuntansi"</i></a>
        </div>
    </div>
    <div class="carousel-item">
        <img src="{{ asset('image/Iklan3.png') }}" class="d-block w-100" alt="...">
    </div>
  </div>
  <a class="carousel-control-prev" href="#carouselExampleFade" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#carouselExampleFade" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>

<div class="line"></div>

<div class="bg-secondary">
    <p class="text-white text-center">

        @Tugas Akhir Skripsi

    </p>
</div>


</div>




<!--<div class="jumbotron jumbotron-fluid">
    <div class="container">
        <h1 class="display-4">KPRI SENTOSA SMPN UNGGULAN 2 MAROS</h1>
        <p class="lead">This is a modified jumbotron that occupies the entire horizontal space of its parent.</p>
    </div>
</div>-->
@extends('template/footer')
@section('footer')
