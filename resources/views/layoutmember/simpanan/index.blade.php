@extends('template.member')

@section('title', 'Simpanan')

@section('content')



<div class="row">
    <div class="col-lg-6">
        <div class="card shadow mb-4">
               <!-- Card Header - Accordion -->
               <a href="#pokok" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample">
                 <h6 class="m-0 font-weight-bold text-primary">Simpanan Pokok</h6>
               </a>
               <!-- Card Content - Collapse -->
               <div class="collapse show" id="pokok">
                 <div class="card-body">
                     <h5 class="card-title">Jumlah Simpanan Pokok</h5>
                     <p class="card-text">@currency($data->pokok)</p>
                    <a href="/simpanan-detail-member?sti={{$data->id_simpanan}}&&jsti=1" class="btn btn-primary">Detail</a>
                 </div>
               </div>
        </div>

        <div class="card shadow mb-4">
               <!-- Card Header - Accordion -->
               <a href="#wajib" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample">
                 <h6 class="m-0 font-weight-bold text-primary">Simpanan Wajib</h6>
               </a>
               <!-- Card Content - Collapse -->
               <div class="collapse show" id="wajib">
                 <div class="card-body">
                     <h5 class="card-title">Jumlah Simpanan Wajib</h5>
                     <p class="card-text">@currency($data->wajib)</p>
                     <a href="/simpanan-detail-member?sti={{$data->id_simpanan}}&&jsti=2" class="btn btn-secondary">Detail</a>
                 </div>
               </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card shadow mb-4">
               <!-- Card Header - Accordion -->
               <a href="#sukarela" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample">
                 <h6 class="m-0 font-weight-bold text-primary">Simpanan Sukarela</h6>
               </a>
               <!-- Card Content - Collapse -->
               <div class="collapse show" id="sukarela">
                 <div class="card-body">
                     <h5 class="card-title">Jumlah Simpanan Sukarela</h5>
                     <p class="card-text">@currency($data->sukarela)</p>
                     <a href="/simpanan-detail-member?sti={{$data->id_simpanan}}&&jsti=3" class="btn btn-success">Detail</a>
                 </div>
               </div>
        </div>
    </div>
</div>


@endsection
