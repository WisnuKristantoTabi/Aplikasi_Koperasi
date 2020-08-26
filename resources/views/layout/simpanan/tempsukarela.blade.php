@extends('layout.simpanan.tambah')

@section('form')

<div class="border shadow-lg p-5" style="background-color: #e3f2fd;">
    <form action="/simpanan-addsukarela" id="simpanan-sukarela-form" method="post">
        {{ csrf_field() }}
        <p class="text-dark font-weight-bold">Simpanan Sukarela</p>
        <div class="form-group">
            <label for="nama" class="text-dark">Masukkan Nama </label>
            <select id="namasearch" class="namasearch" style="width:90%;" name="namasearch"></select>
            <input type="hidden"  id="name" name="nama" >
        </div>
        <div class="form-group">
            <label for="tanggal">Tanggal Pembayaran :</label>
            <input id="datepicker" width="90%" name="tanggal"/>
        </div>
        <div class="form-group">
            <label for="nominal" class="text-dark">Masukkan Nominal </label>
            <input class="form-control" id="formatuang" type="text" name="nominal" placeholder="Masukkan Nominal">
        </div>

        <div class="form-group">
            <label for="nominal" class="text-dark">Keterangan :</label>
            <input id="keterangan" class="form-control" type="text" name="keterangan" >
        </div>
        <div class="my-2"></div>

        <input class="btn btn-primary" id="tambahtransaksi" type="submit" value="Tambahkan Ke Transaksi">
    </form>
</div>

<script>
    $('#datepicker').datepicker({
        uiLibrary: 'bootstrap4',
        format: 'yyyy-mm-dd'
    });

    $(document).ready(function () {

        $("#tambahtransaksi").click(function () {
            $("#formatuang").val($("#formatuang").val().replace(/[^,\d]/g, '').toString());
            this.disabled=true;
            this.value='Mengirim Data...';
        });

        $("#keterangan").click(function () {
            var member = $( "#namasearch option:selected" ).text();
            $("#name").val(member);
            $(this).val("Terima Simpanan Sukarela Dari " +member);
        });

        $("#formatuang").keyup(function () {
            var angsuran = $(this).val();
            $(this).val(formatRupiah(angsuran, "Rp. "));
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
