@extends('template.admin')

@section('title', 'Piutang')

@section('content')
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<style>
.select2-default {
color: #999 !important;
width: auto !important;
}

.my-custom-scrollbar {
position: relative;
height: 450px;
overflow: auto;
}
.table-wrapper-scroll-y {
display: block;
}
</style>

<h1>Piutang User</h1>

    {{ csrf_field() }}

    <div class="form-group">
        <label for="Transaksi_name">Nama :</label>
        <div class="col-md-12 col-sm-12">
                <select class="form-control namasearch" style=" width:50%;" name="search"> ></select>
                <button type="button" class="btn btn-info " id="cari" name="button">Cari</button>
        </div>
    </div>

    <div class="line"></div>
<div class="table-wrapper-scroll-y my-custom-scrollbar">
    <table class="table table-bordered table-striped table-hover">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Jumlah Pinjaman</th>
                <th>No.Bukti</th>
                <th>Pembayaran Per angsuran</th>
                <th>Keterangan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <tr><td colspan="5"><p class="text-center text-dark">Cari Nama</p></td></tr>
        </tbody>
    </table>
</div>

<div class="line"></div>

<script type="text/javascript">
$(document).ready(function () {
$('.namasearch').select2({
    selectOnClose: false,
    placeholder: 'Cari Nama.....',
    ajax: {
      url: "{{url('/userauto')}}",
      dataType: 'json',
      delay: 250,
      processResults: function (data) {
        return {
          results:  $.map(data, function (item) {
            return {
              text: item.full_name,
              id: item.id
            }
          })
        };
      },
      cache: true
    }
  });

  $('#cari').on("click",function(){
       $value = $(".namasearch").val();
       $.ajax({
          url: "{{URL::to('/piutang/search')}}",
          type: 'get',
          data:{'search':$value},
          success:function(data){
              $('tbody').html(data);
          }
        });
  });

 });
</script>

<script src="{{ asset('js/format-rupiah.js') }}"></script>

@endsection
