<br>
<div class="line"></div>
<br>
<!--<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalScrollable">
  Tambahkan Data Transaksi
</button> -->

<!-- Modal
<div class="modal fade" id="exampleModalScrollable" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalScrollableTitle">Formulir Transaksi</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="/transaksi/tambahtransaksi" method="post">
      <div class="modal-body">
          {{ csrf_field() }}
          <div class="form-group">
              <label for="username">Masukkan Jenis Transaksi: </label>
              <p><input type='radio' name='jenis_transaksi' value='Penerimaan' /> Penerimaan (DEBET)</p>
              <p><input type='radio' name='jenis_transaksi' value='Pembayaran' /> Pembayaran (KREDIT)</p>
          </div>
          <div class="form-group">
              <label for="username">Masukkan Perkiraan: </label>
              <select name="perkiraan">
                  {{ $i = 1}}
                    @foreach($perkiraan as $prk)

                      <option value= {{$prk->id}} >( {{ $prk->nomor_perkiraan}} ). {{ $prk->nama_perkiraan_detail}} </option>
                      @if( $i < $prk->perkiraan_table_id )
                      <option disabled>_________</option>
                      {{ $i++}}
                      @endif
                     @endforeach
              </select>

          </div>
          <div class="form-group">
              <label for="Transaksi_name">Transaksi Dilakukan Oleh:</label>
              <p></p>
              <div class="d-flex align-items-center">
                  <input id="search" name="search" type="text" class="form-control" placeholder="Cari Nama" />
                  <div id="loadingsearch" class="spinner-border text-success ml-auto" role="status" aria-hidden="true"></div>
                  <label id="tidakditemukan">Data Tidak Ditemukan</label>
              </div>
          </div>
          <div class="form-group">
              <label for="Transaksi_name">keterangan :</label>
              <input name="keterangan" type="text" class="form-control" placeholder="Masukkan keterangan Transaksi" />
          </div>
          <div class="form-group">
              <label for="Transaksi_name">Jumlah Nominal :</label>
              <input name="nominal" type="text" class="form-control" placeholder="Masukkan Jumlah Nominal Transaksi" />
          </div>
      </div>
      <div class="modal-footer">
         <input class="btn btn-primary" type="submit" value="Login">
         <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
      </form>
    </div>
  </div>
</div>
 -->
