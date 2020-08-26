<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/







Route::get('/', function ()
{
    return view('home');
});

Route::get('/login', 'Login@index')->name('login');

Route::match(['get', 'post'],'/proseslogin', 'Login@proses')->middleware('cekrole','csrftoken');

Route::post('/logout', 'Login@logoutproses');

Route::get('/datamember', 'Simpanan@datamember');






Route::middleware(['revalidate'])->group(function () {

    Route::get('/dashboardmember', 'Dashboard@member');

    Route::get('/dashboardadmin', 'Dashboard@admin');

    Route::get('/register-nonmember', 'User@createNonUser');

    Route::get('/register-admin', 'User@createAdmin');

    Route::get('/register-member', 'User@createMember');

    Route::get('/register-cekusername', 'User@searchUsername');

    Route::get('/create-nonuser', 'User@addNonUser');

    Route::get('/jurnal-umum', 'JurnalUmum@index');

    Route::get('/jurnal-umum-tambah', 'JurnalUmum@tambah');

    Route::get('/jurnal-umum-cetak', 'JurnalUmum@cetakLaporan');

    Route::get('/akun-tutup', 'Tutup@main');

    Route::get('/perkiraan-tambah', 'Perkiraan@tambah');

    Route::get('/perkiraan-list', 'Perkiraan@list');

    Route::get('/gantipassword', function (){
        return view('/layout/changepasswordadmin');
    });

    Route::get('/userauto', 'Transaksi@autocomplete');

    Route::get('/transaksi-list-angsuran-anggota', 'Transaksi@listAngsuranAnggota');

    Route::get('/transaksi-list-angsuran-sementara', 'Transaksi@listAngsuranSementara');

    Route::get('/transaksi-list-angsuran-non-anggota', 'Transaksi@listAngsuranNonMember');

    Route::get('/pinjaman', 'Pinjaman@index');

    Route::get('/pinjaman-anggota', 'Pinjaman@anggota');

    Route::get('/pinjaman-nonanggota', 'Pinjaman@nonAnggota');

    Route::get('/pinjaman-sementara', 'Pinjaman@sementara');

    Route::get('/pinjaman/userauto/member', 'Pinjaman@autocompleteMember');

    Route::get('/pinjaman/userauto/non-member', 'Pinjaman@autocompleteNonMember');

    Route::get('/neraca','Neraca@getDataNeraca');

    Route::get('/neraca-member','Neraca@getDataNeracaMember');

    Route::get('/neraca/cetakneraca','CetakLaporanNeraca@cetak');

    Route::get('/member-view','Member@index');

    Route::get('/member-list-member-cari','Member@searchMember');

    Route::get('/member-list-member','Member@listMember');

    Route::get('/member-view/list-member/no-active/{id}','Member@notActive');

    Route::get('/member-view/list-member/hapus','Member@hapusMember');

    Route::get('/member-view/list-non-member/hapus','Member@hapusNonMember');

    Route::get('/member-view-list-non-member','Member@listNonMember');

    Route::get('/member-view-profil-member','Member@profilMember');

    Route::get('/member-view-profil-nonmember','Member@profilNonMember');

    Route::get('/member-view-ubah','Member@ubahProfil');


    Route::get('/simpanan','Simpanan@index');

    Route::get('/simpanan-add-pokok','Simpanan@formPokok');

    Route::get('/simpanan-add-sukarela','Simpanan@formSukarela');

    Route::get('/simpanan-add-wajib','Simpanan@formWajib');

    Route::get('/simpanan/search-pokok','Simpanan@searchPokok');

    Route::get('/setting', 'Setting@showVariabel');

    Route::get('/simpanan/list','Simpanan@list');

    Route::get('/lag','Simpanan@test');;

    Route::get('/buku-besar','BukuBesar@index');

    Route::get('/buku-besar/cetak','BukuBesar@cetakLaporan');

    Route::get('/beban','Beban@index');

    Route::get('/aset-detail','Aset@detail');

    Route::get('/aset-edit','Aset@edit');

    Route::get('/shu','Pendapatan@index');

    Route::get('/shu/cetak-shu','Pendapatan@cetakSHU');

    Route::get('/shu/cetak-jasa','Pendapatan@cetakSHUDiterima');

    Route::get('/shu/cetak-pembagian','Pendapatan@cetakPembagianSHU');

    Route::get('/tampil-coba','Neraca@tampil');
    
    Route::get('/shu-close','Pendapatan@tutupSaldo');

    Route::get('/piutang','Pendapatan@pembayaran');

    Route::get('/piutang/search/','Pendapatan@searchDetail');

    Route::get('/shu-search','Pendapatan@search');

    Route::match(['get', 'post'],'/shu/accept-all','Pendapatan@acceptAll');

    Route::match(['get', 'post'],'/shu/accept','Pendapatan@accept');

    Route::get('/bukti','CetakBukti@index');

    Route::get('/aset','Aset@index');

    Route::get('/notif','Notif@countUnseen');

    Route::get('/notif-index','Notif@index');

    Route::get('/notif-show','Notif@show');

    Route::post('/notif/hapus','Notif@delete');

    //Route::get('/perkiraan/hapus','Perkiraan@hapus');

    Route::get('/pinjaman-index-member','Pinjaman@indexMember');

    Route::get('/pinjaman-detail-member','Pinjaman@detailpinjmanamember');

    Route::get('/simpanan-index-member','Simpanan@indexSimpanan');

    Route::get('/simpanan-detail-member','Simpanan@detailSimpananMember');

    Route::get('/shu-index-member','Pendapatan@indexMember');



});









Route::middleware(['status'])->group(function () {

    Route::post('/register-addnonuser', 'User@addNonUser');

    Route::post('/register-addmemberuser', 'User@addUserMember');

    Route::post('/register-addadmin', 'User@addAdmin');

    Route::post('/createuser', 'User@addUser');

    Route::post('/createuser/cetakformulir', 'CetakBiodata@cetakPDF');

    Route::post('/neraca-ubah','Neraca@ubah');

    Route::post('/akun-tutup-jurnal-penutup', 'Tutup@jurnalPenutup');

    Route::match(['get', 'post'],'/akun-tutup-shu', 'Tutup@pendapatanSHU');

    Route::post('/akun-tutup-periode', 'Tutup@setPeriode');

    Route::post('/akun-tutup-finish', 'Tutup@complete');

    Route::post('/perkiraan/tambahperkiraan', 'Perkiraan@addPerkiraan');

    Route::match(['get', 'post'],'/perkiraan/hapusperkiraan', 'Perkiraan@hapus');

    Route::post('/perkiraan/editperkiraan', 'Perkiraan@edit');

    Route::post('/ubah-profil','Member@ubah');

    Route::post('/transaksi-tambahtransaksipinjaman', 'Pinjaman@addTransactionPinjaman');

    Route::post('/transaksi-tambahtransaksipinjaman-nonmember', 'Pinjaman@addTransactionPinjamanNonMember');

    Route::post('/transaksi-tambahpinjamansementara', 'Pinjaman@addPinjamanSementara');

    Route::get('/transaksi-hapuspinjaman', 'Pinjaman@hapus');

    Route::post('/transaksi-add-angsuran-anggota', 'Transaksi@addAngsuranAnggota');

    Route::post('/transaksi-add-angsuran-sementara', 'Transaksi@addAngsuranSementara');

    Route::post('/transaksi-add-angsuran-non-member', 'Transaksi@addAngsuranNonAnggota');

    Route::post('/transaksi/tambahtransaksipinjaman/bukti', 'CetakBukti@buktiTransaksi');

    Route::post('/transaksi/tambahdata', 'JurnalUmum@tambahProses');

    Route::post('/transaksi/cetak/angsuran', 'CetakBukti@angsuran');

    
    Route::post('/setting/update', 'Setting@editVariabel');

    Route::post('/simpanan-addpokok','Simpanan@addPokok');

    Route::post('/simpanan-addwajib','Simpanan@addWajib');

    Route::post('/simpanan-addsukarela','Simpanan@addSukarela');

    Route::post('/simpanan-bukti','Simpanan@bukti');

    Route::post('/simpanan/cetak','CetakBukti@simpanan');

    Route::post('/beban/tambah-beban','Beban@addBeban');

    Route::post('/beban/ubah-beban','Beban@changeBeban');

    Route::post('/aset/add','Aset@add');

    Route::get('/aset/delete','Aset@hapus');

    Route::post('/aset/edit/proses','Aset@editProses');

    Route::post('/bukti/kas-keluar','CetakBukti@outcome');

});


Route::post('/gantipassword/proses', 'User@changePassword');
