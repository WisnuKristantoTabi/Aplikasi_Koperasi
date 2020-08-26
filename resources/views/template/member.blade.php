
<!--
Author: W3layouts
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" name='viewport'>
  <meta name="description" content="aplikasi akuntansi">
  <meta name="author" content="wisnu">

  <title>@yield('title')</title>

  <!-- Custom fonts for this template-->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">
  <link href="{{ asset('css/style.css') }}" rel="stylesheet">

  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

</head>

<body id="page-top">

  <!-- Page Wrapper -->
  @if(Session::get('login')&& Session::get('role')=='member')
  <div id="wrapper">

    <!-- Sidebar -->
    @include('template.navbars.sidebarmember')
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        @include('template.navbars.navbarmember')
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
		<div class="container-fluid">
            @if(\Session::has('danger'))
                 <div class="alert alert-danger" id="alert-popup">
                     <button type="button" class="close" data-dismiss="alert">x</button>
                    <div> {{Session::get('danger')}} </div>
                </div>
           @endif

           @if(\Session::has('success'))
          <div class="alert alert-success" id="alert-popup">
               <button type="button" class="close" data-dismiss="alert">x</button>
                <div> {{Session::get('success')}} </div>
            </div>
          @endif

              @yield('content')

		</div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy; Skripsi - 2020</span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

  </div>
    @endif
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->

  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
		 <form action="/logout" method="post">
        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
		@csrf
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
		  <input class="btn btn-primary" type="submit" value="Logout">
        </div>
		</form>
      </div>
    </div>
  </div>

  <script type="text/javascript">


      $(document).ready(function () {


      $('#sidebarCollapse').on('click', function () {
              $('#sidebar').toggleClass('active');
          });


          $("#alert-popup").ready(function showAlert() {
          $("#alert-popup").fadeTo(2000, 500).slideUp(500, function() {
              $("#alert-popup").slideUp(500);
              });
          });
          $(".tidakditemukan").hide();
          $(".loadingsearch").hide();
      });
  </script>

  <script type="text/javascript">
  $(document).ready(function () {
      function load_unseen_notification(){
           $.ajax({
               url:"{{url('/notif')}}",
               method:"get",
               data:{id:"{{Session::get('id_member')}}"},
               dataType:"json",
               success:function(data){
                   if(data.count> 0){
                       $('#count').html(data.notif);
                   }
               }
           });
      }
      load_unseen_notification();
  });
  </script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>

</body>

</html>
