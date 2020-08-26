@if(Session::get('role')=='admin')
    @extends('template.admin')
@elseif(Session::get('role')=='member')
    @extends('template.member')
@endif

@section('title', 'Ubah Profil')

@section('content')


<div class="row">
    <div class="col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Basic Card Example</h6>
            </div>
            <div class="card-body">
              <hr>
            </div>
        </div>
    </div>
</div>

@endsection
