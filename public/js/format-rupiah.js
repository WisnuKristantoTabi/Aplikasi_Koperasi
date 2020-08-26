$(document).ready(function () {
    $(".inputrupiah").keyup(function () {
        var rupiah = $(this).val();
        rupiah = rupiah.replace(/[^,\d]/g, '').toString();
        var angsuran = $(".jumlah-angsuran").val();
        angsuran = angsuran.replace(/[^,\d]/g, '').toString();

        rupiah = rupiah.replace(/[^,\d]/g, '').toString();
        var bunga = $(".bunga").val();
        var provisi = $(".provisi").val();
        var hasilbunga = Number(rupiah) * ( Number(bunga) /100);
        var hasilprovisi = Number(rupiah) * ( Number(provisi) /100);
        var pokok = ( Number(rupiah) / Number(angsuran) )+hasilbunga;
        $(".hasilhitungbunga").val(formatRupiah(String(hasilbunga.toFixed(0)),'Rp. '));
        $(".hasilhitungprovisi").val(formatRupiah(String(hasilprovisi.toFixed(0)),'Rp. '));
        $("#pokok").val(formatRupiah(String(pokok.toFixed(0)),'Rp. '));
        $(this).val(formatRupiah(rupiah,'Rp. '));
    });

    $(".formatubahuang").val( function () {
        return formatRupiah(($(this).val()),'Rp. ');
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
