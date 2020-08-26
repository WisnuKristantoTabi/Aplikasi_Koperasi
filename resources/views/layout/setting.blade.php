@extends('template.admin')

@section('title', 'Transaksi')

@section('content')

<div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Pengaturan Sistem </h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped">
                <tbody>
                @foreach($variabel as $v)
                    <tr>
                        <td>{{ $v->keterangan }}</td>
                        <td>{{ $v->persen }} %</td>
                        <td>
                            <button type="button" class="btn btn-info" data-id="{{ $v->id }}"
                            data-title="{{ $v->keterangan }}" data-persen={{ $v->persen }}
                             data-toggle="modal" data-target="#ubahSetting">Edit</button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <a class="btn btn-warning m-3" href="/perkiraan-list">Akun Perkiraan</a>
        </div>
    </div>
</div>


<div class="modal fade" id="ubahSetting" tabindex="-1" role="dialog" aria-labelledby="ubahSettingTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ubahSettingTitle"></h5>
        <button type="button" class="tutupEdit close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="/setting/update" method="post">
      <div class="modal-body">
          {{ csrf_field() }}
          <input type="hidden" id="id_modal" name="id" > <br/>
          <div class="form-group">
               <label for="Transaksi_name">Besar Persen Menjadi : </label>
              <input class="form-control borderinput besar-persen" type="number" step="0.1" min="0" max="100" name="persen" value={{$v->persen}} />
          </div>
      </div>
      <div class="modal-footer">
         <input class="btn btn-primary" type="submit" value="Oke ">
         <button type="button" class="btn btn-secondary tutupEdit" data-dismiss="modal">Batal</button>
      </div>
      </form>
    </div>
  </div>
</div>
<script src="{{ asset('js/setting.js') }}"></script>

@endsection
