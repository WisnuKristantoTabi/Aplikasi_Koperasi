@extends('template.member')

@section('title', 'Transaksi')

@section('content')




<div class="row">
    <div class="col-lg-6">
        <div class="card shadow mb-4">
               <!-- Card Header - Accordion -->
               <a href="#pokok" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample">
                 <h6 class="m-0 font-weight-bold text-primary">SHU Jasa</h6>
               </a>
               <!-- Card Content - Collapse -->
               <div class="collapse show" id="pokok">
                 <div class="card-body">
                     <h5 class="card-title">Jumlah SHU Jasa</h5>
                     <p class="card-text">@currency($jasa)</p>
                 </div>
               </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card shadow mb-4">
               <!-- Card Header - Accordion -->
               <a href="#wajib" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample">
                 <h6 class="m-0 font-weight-bold text-primary">SHU Modal</h6>
               </a>
               <!-- Card Content - Collapse -->
               <div class="collapse show" id="wajib">
                 <div class="card-body">
                     <h5 class="card-title">Jumlah SHU Modal</h5>
                     <p class="card-text">@currency($modal)</p>
                 </div>
               </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col">
        <div class="card shadow mb-4">
               <!-- Card Header - Accordion -->
               <a href="#sukarela" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample">
                 <h6 class="m-0 font-weight-bold text-primary">Jumlah SHU Yang Diterima</h6>
               </a>
               <!-- Card Content - Collapse -->
               <div class="collapse show" id="sukarela">
                 <div class="card-body">
                     <h5 class="card-title">Jumlah Total</h5>
                     <p class="card-text">@currency( ($jasa + $modal ))</p>
                 </div>
               </div>
        </div>
    </div>
</div>

    <div class="d-flex justify-content-end mb-3 "><a class="btn btn-info" href="/shu/cetak-shu"> Laporan SHU</a></div>
    <div class="d-flex justify-content-end  mb-3"><a class="btn btn-primary" href="/shu/cetak-pembagian">Pembagian SHU</a></div>





@endsection
