@extends('template.admin')

@section('title', 'List Member')

@section('content')

<div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Tabel Anggota</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
        <div class="d-flex flex-row-reverse bd-highlight">
            <form class="m-3 form-inline" action="/member-list-member-cari" method="get">
                <div class="form-group mx-sm-3 mb-2">
                    <input name="searchname" type="text" class="form-control" autocomplete="off" placeholder="Cari Nama"/>
                </div>
                <input class="btn btn-primary" type="submit" value="Cari">
            </form>
        </div>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col"><center>No </center></th>
                        <th scope="col"><center>Nama</center></th>
                        <th scope="col"><center>Aksi</center></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($anggota as $no => $m)
                    <tr>
                        <th scope="row">{{ ++$no + ($anggota->currentPage()-1) * $anggota->perPage() }}</th>
                        @if($m->status_member_table == 2)
                        <td><strike>{{ $m->full_name }}</strike></td>
                        @else
                            <td>{{ $m->full_name }}</td>
                        @endif


                        <td>
                            <center>
                            @if($m->status_member_table == 1)
                            <a class="btn btn-info" href="/member-view-profil-member?profil={{$m->mti}}">Lihat Profil </a>
                            <a class="btn btn-danger" id="hapus" href="/member-view/list-member/no-active/{{$m->mti}}">Tutup Akun </a>

                            <a class="btn btn-warning" href="/member-view-ubah?m={{$m->mti}}">Ubah </a>
                            @else
                            <a class="btn btn-danger" id="delete" href="/member-view/list-member/hapus/?id={{$m->uid}}">Hapus</a>
                            @endif
                            </center>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="d-flex justify-content-center">{{ $anggota->links() }}</div>
        </div>
    </div>
</div>

 <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.4.0/bootbox.min.js"></script>


 <script>
    $(document).on("click", "#hapus", function(e) {
        e.preventDefault();
        var link = $(this).attr("href");
        bootbox.confirm({
            title: "Tutup Akun ini?",
            message: "Apakah Kamu Ingin Menutup Akun ini?",
            buttons: {
                cancel: {
                    label: '<i class="fa fa-times"></i> Tidak'
                },
                confirm: {
                    label: '<i class="fa fa-check"></i> Iya'
                }
            },
            callback: function (result) {
                if(result){
                    window.location.href = link;
                }
            }
        });
    });

    $(document).on("click", "#delete", function(e) {
        e.preventDefault();
        var link = $(this).attr("href");
        bootbox.confirm({
            title: "Tutup Akun ini?",
            message: "Apakah Kamu Ingin Menghapus Dari Daftar Akun?",
            buttons: {
                cancel: {
                    label: '<i class="fa fa-times"></i> Tidak'
                },
                confirm: {
                    label: '<i class="fa fa-check"></i> Iya'
                }
            },
            callback: function (result) {
                if(result){
                    window.location.href = link;
                }
            }
        });
    });
</script>

@endsection
