@extends('template.admin')

@section('title', 'Transaksi')

@section('content')



<div class="row">
       <div class="col-xl-3 col-md-6 mb-4">
         <div class="card border-left-success shadow h-100 py-2">
           <div class="card-body">
             <div class="row no-gutters align-items-center">
               <div class="col mr-2">
                 <div class="text-xs font-weight-bold text-success text-uppercase mb-1">SHU Modal Pada Koperasi Sebesar</div>
                 <div class="h5 mb-0 font-weight-bold text-gray-800">@currency($modal)</div>
                <div class="copyright my-auto">
                    @php $modal = $modal - ($modal * ($pajak/100) )  @endphp
                    Modal Setelah Pajak ({{$pajak}} %) :<br> <code>@currency($modal)</code>
                </div>
               </div>
               <div class="col-auto">
               </div>
             </div>
           </div>
         </div>
       </div>

       <div class="col-xl-3 col-md-6 mb-4">
          <div class="card border-left-secondary shadow h-100 py-2">
            <div class="card-body">
              <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                  <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">SHU Jasa Pada Koperasi Sebesar</div>
                  <div class="h5 mb-0 font-weight-bold text-gray-800">@currency($jasa)</div>
                  <div class="copyright my-auto">
                      @php $jasa = $jasa - ($jasa * ($pajak/100) ) @endphp
                      Jasa Setelah Pajak ({{$pajak}} %) :<br> <code>@currency($jasa)</code>
                  </div>
                </div>
                <div class="col-auto">
                </div>
              </div>
            </div>
          </div>
        </div>
</div>

    <div class="d-flex justify-content-end mb-3 "><a class="btn btn-info" href="/shu/cetak-shu"> Laporan SHU</a></div>
    <div class="d-flex justify-content-end  mb-3"><a class="btn btn-primary" href="/shu/cetak-jasa"> Laporan SHU Diterima</a></div>
    <div class="d-flex justify-content-end  mb-3"><a class="btn btn-danger" id="tutup" href="/shu/accept-all"> Tandai Semua Telah Terima </a></div>
    <div class="d-flex justify-content-end  mb-3"><a class="btn btn-warning text-dark" href="/shu/cetak-pembagian"> Laporan Pembagian </a></div>








<div class="line"></div>
<div class="d-flex justify-content-end mb-3">
    <form class="form-inline my-2 my-lg-0" method="get" action="/shu-search">
       <input class="form-control mr-sm-2" type="text" name="q" placeholder="Cari" aria-label="Search">
        <button class="btn btn-info my-2 my-sm-0" type="submit">Cari</button>
    </form>
</div>


<div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Tabel Jasa SHU Yang Diterima</h6>
    </div>
    <div class="card-body">
    <div class="table-responsive">

<table class="table table-bordered">
  <thead>
    <tr >
        <th scope="col"><center>No </center></th>
        <th scope="col"><center>Nama</center></th>
        <th scope="col"><center>Modal</center></th>
        <th scope="col"><center>Pinjaman</center></th>
        <th scope="col"><center>Jumlah</center></th>
        <th scope="col"><center>Keterangan</center></th>
        <th scope="col"><center>Aksi</center></th>
    </tr>
  </thead>
  <tbody>
@foreach($data as $no => $d)

    <tr>
        <td>{{ ++$no + ($data->currentPage()-1) * $data->perPage() }}</td>
        <td><a href="/member-view-profil-member?profil={{$d->idmember}}"><p class="text-info"><u>{{ $d->full_name}}</u></p></a></td>
            @php $m = ($d->modal/($summodal)) * $modal @endphp
            @php $j = ($d->pinjaman/($sumjasa)) * $jasa @endphp
        <td>@currency($m)</td>
        <td>@currency($j)</td>
        <td>@currency(($m + $j ))</td>
        <td><p class="font-italic text-dark">{{ $d->keterangan}}</p></td>
        <td>
            @if($d->status_shu_id==1)
            <a href="/shu/accept?jstid={{$d->jstid}}" class="btn btn-danger" id="terima" >SHU Diterima</a>
            @endif
        </td>
    </tr>

@endforeach
</tbody>
</table>

    </div>
</div>
</div>

  <div class="d-flex justify-content-center">{{ $data->links() }}</div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
 <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.4.0/bootbox.min.js"></script>


  <script>
     $(document).on("click", "#terima", function(e) {
         e.preventDefault();
         var link = $(this).attr("href");
         bootbox.confirm({
             title: "Catatan!!",
             message: "<p class='text-dark'>Anggota Yang Bersangkutan Telah Menerima SHU.<p class='text-dark'>Apakah Anda Yakin??</p>",
             buttons: {
                 cancel: {
                     label: '<i class="fa fa-times"></i> Tidak'
                 },
                 confirm: {
                     label: '<i class="fa fa-check"></i> Iya'
                 }
             },
             callback: function (result) {
                 if(result){
                     window.location.href = link;
                 }
             }
         });
     });

     $(document).on("click", "#tutup", function(e) {
         e.preventDefault();
         var link = $(this).attr("href");
         bootbox.confirm({
             title: "Catatan!!",
             message: "<p class='text-dark'>Seluruh Anggota Telah Menerima SHU.</p><p class='text-dark'>Membuat Saldo SHU Tercatat Akan di Nolkan.</p><p class='text-dark'>Mencatat Otomatis Ke Jurnal Umum.</p><p class='text-dark'>Apakah Anda Yakin??</p>",
             buttons: {
                 cancel: {
                     label: '<i class="fa fa-times"></i> Tidak'
                 },
                 confirm: {
                     label: '<i class="fa fa-check"></i> Iya'
                 }
             },
             callback: function (result) {
                 if(result){
                     window.location.href = link;
                 }
             }
         });
     });
 </script>
@endsection
