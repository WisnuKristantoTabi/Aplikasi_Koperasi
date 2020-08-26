$(document).ready(function () {
    $(".keterangan_transaksi_simpanan_wajib").click(function () {
        var member = $(".namasearch").val();
        $(this).val("Terima Simpanan Wajib dari " +member);
    });

    $(".tutupTransaksi").click(function () {
        $(".inputrupiah").val('');
        $(".keterangan_transaksi_simpanan_wajib").val('');
        $(".namasearch").val('');
    });

});
