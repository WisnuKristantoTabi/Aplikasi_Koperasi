@extends('template.admin')

@section('title', 'Bukti')

@section('content')

<link href="{{ asset('css/box.css') }}" rel="stylesheet">

@if (count($errors) > 0)
<div class = "alert alert-danger">
    <ul>
@foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
@endforeach
    </ul>
</div>
@endif

<div class="latar">
    <div class="kotak">
    <a href="#formulirPemasukkan" data-toggle="modal">
        <div class="icon">
            <i class="fa fa-sign-in-alt"></i>
        </div>
        <div class="about-tombol"><h4> Cetak Bukti Pemasukkan Kas</h4></div>
    </a>
    </div>
    <div class="kotak">
    <a href="#formulirPengeluaran" data-toggle="modal">
        <div class="icon">
            <i class="fa fa-sign-out-alt"></i>
        </div>
        <div class="about-tombol"><h4>  Cetak Bukti Pengeluaran Kas</h4></div>
    </a>
    </div>
</div>


<div class="modal fade" id="formulirPemasukkan" tabindex="-1" role="dialog" aria-labelledby="formulirPemasukkanTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="formulirPemasukkanTitle">Cetak Formulir Pemasukkan</h5>
        <button type="button" class="tutupTransaksi close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="/transaksi/tambahtransaksipinjaman" method="post">
      <div class="modal-body">
          {{ csrf_field() }}
          <div class="form-group">
              <label for="Transaksi_name">Keterangan :</label>
              <input name="keteranganKasMasuk" type="text" class="form-control" autocomplete="off" placeholder="Masukkan keterangan Transaksi" />
          </div>

          <div class="form-group">
              <label for="Transaksi_name">Akun Saldo Debit :</label>
              <br>
               <select disabled>
                     <option ><p class="text-dark">(1.1.1). KAS</p></option>
                     <option ><p class="text-dark">#############################</p></option>
               </select>
          </div>

          <div class="form-group">
              <label for="Transaksi_name">Akun Saldo Kredit :</label>
              <select name="perkiraanKasMasuk" >
                  @foreach($perkiraan as $prk)
                  <option value= {{$prk->id}} ><p class="text-dark">( {{ $prk->nomor_perkiraan}} ). {{ $prk->nama_perkiraan_detail}}</p></option>
                   @endforeach
              </select>
          </div>

          <div class="form-group">
              <label for="Transaksi_name">Nilai Nominal :</label>
              <input name="nominalKasMasuk" type="text" class="form-control borderinput formatubahuang" autocomplete="off" placeholder="Masukkan Jumlah"/>
          </div>
      </div>
      <div class="modal-footer">
         <input class="btn btn-primary " type="submit" value="Tambahkan Ke Transaksi">
         <button type="button" class="btn btn-secondary tutupTransaksi" data-dismiss="modal">Close</button>
      </div>
      </form>
    </div>
  </div>
</div>

<!-- Formulir Pengeluaran-->

<div class="modal fade" id="formulirPengeluaran" tabindex="-1" role="dialog" aria-labelledby="formulirPengeluaranTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="formulirPengeluaranTitle">Cetak Formulir Pengeluaran</h5>
        <button type="button" class="tutupTransaksi close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="/bukti/kas-keluar" method="post">
      <div class="modal-body">
          {{ csrf_field() }}
          <div class="form-group">
              <label for="Transaksi_name">Keterangan :</label>
              <input name="keteranganKasKeluar" type="text" class="form-control" autocomplete="off" placeholder="Masukkan keterangan Transaksi" />
          </div>

          <div class="form-group">
              <label for="Transaksi_name">Akun Saldo Debit :</label>
              <select name="perkiraanKasKeluar" >
                  @foreach($perkiraan as $prk)
                  <option value= {{$prk->id}} ><p class="text-dark">( {{ $prk->nomor_perkiraan}} ). {{ $prk->nama_perkiraan_detail}}</p></option>
                   @endforeach
              </select>
          </div>

          <div class="form-group">
              <label for="Transaksi_name">Akun Saldo Kredit :</label>
              <br>
               <select disabled>
                     <option ><p class="text-dark">(1.1.1). KAS</p></option>
                     <option ><p class="text-dark">#############################</p></option>
               </select>
          </div>

          <div class="form-group">
              <label for="Transaksi_name">Nilai Nominal :</label>
              <input name="nominalKasKeluar" type="text" class="form-control borderinput formatubahuang" autocomplete="off" placeholder="Masukkan Jumlah"/>
          </div>
      </div>
      <div class="modal-footer">
         <input class="btn btn-primary " type="submit" value="Tambahkan Ke Transaksi">
         <button type="button" class="btn btn-secondary tutupTransaksi" data-dismiss="modal">Close</button>
      </div>
      </form>
    </div>
  </div>
</div

<script src="{{ asset('js/format-rupiah.js') }}"></script>

@endsection
