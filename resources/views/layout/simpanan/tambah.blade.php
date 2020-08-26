@extends('template.admin')

@section('title', 'Tambah Simpanan')

@section('content')

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
<link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />

<p class="text-dark font-weight-bold">Formulir Penambah Transaksi Simpanan</p>


<div class="card o-hidden border-0 shadow-lg my-5">
    <div class="card-body p-0">

        <div class="row">
            <div class="col">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form class="m-3 form-inline">
                <div class="form-group mb-2">
                    <label class="text-center">Pilih Jenis Simpanan : </label>
                </div>
                <div class="form-group mx-sm-3 mb-2">
                    <select id="link" class="custom-select custom-select-sm mr-3" style="width:200px" name="perkiraan">
                        @php $i = 1  @endphp
                        @foreach($jenis as $j)

                        <option @if($jenis_id== $j->id ) selected @endif value= {{$j->id}} > {{ $j->nama }} </option>
                         @endforeach
                    </select>
                </div>
                <button type="button" id="cari" class="btn mb-2 btn-info"> Cari </button>
            </form>

            @yield('form')
            </div>



        </div>
    </div>
</div>



<script type="text/javascript">


$(document).ready(function () {


    $("#formatuang").keyup(function () {
        $(this).val(formatRupiah(($(this).val()),'Rp. '));
    });

    $('.namasearch').select2({
        selectOnClose: false,
        dropdownAutoWidth: true,
        placeholder: 'Cari Nama',
        ajax: {
          url: "{{url('/pinjaman/userauto/member')}}",
          dataType: 'json',
          delay: 250,
          processResults: function (data) {
            return {
              results:  $.map(data, function (item) {
                $("#name").val(item.full_name);
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

    $('#nama_pokok').on("click",function(){
         $value = $("#namasearch_pokok").val();
         $.ajax({
            url: "{{URL::to('/simpanan/search-pokok')}}",
            type: 'get',
            data:{'search':$value},
            success:function(data){
                $('#pokok_form').html(data);
            }
          });
    });

});


$(document).ready(function() {

   //this will be triggered when the first button was clicked
   $("#cari").click(function(){
      var akun = $("#link").find(":selected").val();

      console.log(akun);
         if (akun == 1) {
             document.location.href = 'simpanan-add-pokok';
         }else if (akun == 2) {
             document.location.href = 'simpanan-add-wajib';
         }else if (akun == 3) {
             document.location.href = 'simpanan-add-sukarela';
         }else {
             document.location.href = 'simpanan-add-wajib';
         }
   });
});




function formatRupiah(angka, prefix){
    var number_string = angka.replace(/[^,\d]/g, '').toString(),
		split   		= number_string.split(','),
		sisa     		= split[0].length % 3,
		rupiah     		= split[0].substr(0, sisa),
		ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);

    if(ribuan){
		separator = sisa ? '.' : '';
		rupiah += separator + ribuan.join('.');
	}

		rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
		return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
	}

</script>

@endsection
