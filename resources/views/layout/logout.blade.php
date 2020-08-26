<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>

        <title>Logout</title>
        <script  type="text/javascript">

        function logout() {
            function preback(){
            	window.history.forward();

            }setTimeout("preback()",0);
            window.onunload=function(){null};
        }


        </script>
    </head>
    <body>

        <div class="flex-center position-ref full-height">

            <div class="content">
                <div class="title m-b-md">
                    Berhasil Keluar
                    <h1>{{Session::get('username')}}</h1>
                </div>
                <div onclick="logout()">
                    <a href="/login">Klik Untuk Kleuar</a>
                </div>
                <div class="">
                    <a href="/login">Test</a>
                </div>
            </div>
        </div>
    </body>
</html>
