<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

  <!-- Sidebar Toggle (Topbar) -->
  <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
    <i class="fa fa-bars"></i>
  </button>

  <!-- Topbar Navbar -->
  <ul class="navbar-nav ml-auto">
    <a class="nav-item mt-4 " href="/notif-index?id={{Session::get('id_member')}}" role="button">
        <i class="fas fa-bell fa-fw" ></i>
        <span id="count"></span>

    </a>

    <div class="topbar-divider d-none d-sm-block"></div>

    <!-- Nav Item - User Information -->
    <li class="nav-item dropdown no-arrow">
      <a class="nav-link dropdown-toggle" href="#" id="userDropdownMember" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      <i class="fas fa-user-circle fa-sm fa-fw mr-3 text-gray-800"></i>
        <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{Session::get('username')}}</span>
      </a>
      <!-- Dropdown - User Information -->
      <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdownMember">
        <a class="dropdown-item" href="/gantipassword">
          <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
          Ganti Password
        </a>

        <div class="dropdown-divider"></div>
        <form id="logout-form" action="/logout" method="post">
            @csrf
            <a class="dropdown-item" href="/logout" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
            Logout
             </a>
        </form>
      </div>
    </li>
  </ul>
</nav>





<!--<nav class="navbar navbar-expand-lg " color-on-scroll="500">
    <div class="container-fluid">
        <a class="navbar-brand" href="/">@yield('title')</a>
        <button href="" class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-bar burger-lines"></span>
            <span class="navbar-toggler-bar burger-lines"></span>
            <span class="navbar-toggler-bar burger-lines"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navigation">
            <ul class="nav navbar-nav mr-auto">
                <li class="dropdown nav-item">
                    <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                        <i class="fas fa-wrench"></i>
                        <span class="d-lg-none">{{ __('Setting') }}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <a class="dropdown-item" href="/gantipassword">{{ __('Ubah Password') }}</a>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="/notif/index/?id={{Session::get('id_member')}}" class="nav-link">
                        <i class="fas fa-bell"></i>
                        <div id="count"></div>
                        <span class="d-lg-none">{{ __('Notif') }}</span>
                    </a>
                </li>
            </ul>
            <ul class="navbar-nav   d-flex align-items-center">
                <li class="nav-item">
                    <a class="nav-link" href="/">
                        <span class="no-icon">{{Session::get('username')}}</span>
                    </a>
                </li>
                <li class="nav-item">
                    <form id="logout-form" action="/logout" method="post">
                        @csrf
                        <a class="text-danger" href="/logout" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"> {{ __('Log out') }} </a>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>-->
