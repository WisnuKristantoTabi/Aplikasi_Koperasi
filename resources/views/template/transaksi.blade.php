<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title></title>
    </head>
    <body>
        <form action="/proseslogin" method="post">
            {{ csrf_field() }}
            <h6 class="card-text">Traksaksi</h6>
            <input class="form-control" type="text" placeholder= "Masukkan UserName" name="username" value="{{ old('username') }}">
            <h6 class="card-text">Password</h6>
            <input class="form-control" type="text" placeholder= "Masukkan Password" name="password" value="{{ old('password') }}">
            <br>
            <input class="btn btn-primary" type="submit" value="Login">
        </form>
    </body>
</html>
