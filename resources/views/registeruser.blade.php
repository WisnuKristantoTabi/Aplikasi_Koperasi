@extends('template.admin')
@section('title', 'Perkiraan')
@section('content')

<div class="container">
        <h1>DAFTAR ANGGOTA/ADMIN</h1>
        <hr>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
            <form action="{{ url('/createuser') }}" method="post">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="twxt" class="form-control" id="username" name="username">
                </div>
                <div class="form-group">
                    <label for="full_name">Full Name:</label>
                    <input type="text"  class="form-control" id="full_name" name="full_name">
                </div>
                <div class="form-group">
                    <label for="role">Role:</label>
                    <p><input type='radio' class="form-control" id="role" name='role' value='admin' checked='checked' /> Admin </p>
                    <p><input type='radio' class="form-control" id="role" name='role' value='member' /> Anggota </p>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-md btn-primary">Submit</button>
                    <button type="reset" class="btn btn-md btn-danger">Cancel</button>
                </div>
            </form>
        <!-- /.content -->
    </div>
@endsection
