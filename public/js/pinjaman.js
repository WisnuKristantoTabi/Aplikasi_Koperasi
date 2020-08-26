$(document).ready(function () {
    $("#keterangan_transaksi_pinjaman").click(function () {
        var member = $( "#namasearch option:selected" ).text();
        $("#name").val(member);
        $(this).val("Bayar pinjaman pada " +member);
    });

    $("#keterangan_transaksi_pinjaman_sementara").click(function () {
        var member = $( "#namasearch option:selected" ).text();
        $("#name").val(member);
        $(this).val("Bayar pinjaman Sementara pada " +member);
    });

    $("#tambahtransaksipinjaman").click(function () {
        $(".hasilhitungbunga").val($(".hasilhitungbunga").val().replace(/[^,\d]/g, '').toString());
        $(".inputrupiah").val($(".inputrupiah").val().replace(/[^,\d]/g, '').toString());
        $(".hasilhitungprovisi").val($(".hasilhitungprovisi").val().replace(/[^,\d]/g, '').toString());
        $(".jumlah-angsuran").val($(".jumlah-angsuran").val().replace(/[^,\d]/g, '').toString());
        $("#pokok").val($("#pokok").val().replace(/[^,\d]/g, '').toString());
        this.disabled=true;
        this.value='Mengirim Data..';
    });



    $(".jumlah-angsuran").keyup(function () {
        var angsuran = $(this).val();
        $(this).val(formatAngsuran(angsuran, "X. "));
    });
});


function formatAngsuran(angka, prefix){
    var number_string = angka.replace(/[^,\d]/g, '').toString();
    var number_conv = Number(number_string);
    if(number_conv>30 || number_conv <1){
        return "" ;
    }
    return prefix == undefined ? number_string : (number_string ? 'X. ' + number_string : '');
	}
