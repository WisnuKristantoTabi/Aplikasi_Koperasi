@extends('template.admin')

@section('title', 'List Non-Member')

@section('content')

<table class="table table-bordered">
  <thead>
    <tr class="bg-primary">
        <th scope="col"><center>No </center></th>
        <th scope="col"><center>Nama</center></th>
        <th scope="col"><center>Aksi</center></th>
    </tr>
  </thead>
  <tbody>
      @foreach($list as $li)
      <tr>
          <th scope="row">2</th>
          <td>{{ $li->full_name }}</td>
          <td>
              <a class="btn btn-info" href="/member-view-profil-nonmember?profil={{$li->id}}">Lihat Pinjaman </a>
              <a class="btn btn-danger" id="delete" href="/member-view/list-non-member/hapus?id={{$li->id}}">Hapus</a>
          </td>
      </tr>
      @endforeach

  </tbody>
</table>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.4.0/bootbox.min.js"></script>


<script type="text/javascript">
$(document).on("click", "#delete", function(e) {
    e.preventDefault();
    var link = $(this).attr("href");
    bootbox.confirm({
        title: "Tutup Akun ini?",
        message: "Apakah Kamu Ingin Menghapus Dari Database?",
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
