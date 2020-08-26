<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion toggled" id="accordionSidebar">

  <!-- Sidebar - Brand -->
  <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
    <div class="sidebar-brand-icon">
        <div class="sidebar-brand-icon">
             <img style="width: 3rem;" src="{{ asset('img/koperasi-indonesia-logo.png') }}" alt="">
        </div>
     <div class="sidebar-brand-text">Aplikasi Akuntansi</div>
    </div>

  </a>

  <!-- Divider -->
  <hr class="sidebar-divider my-0">

  <!-- Nav Item - Dashboard -->
  <li class="nav-item {{ set_active(['dashboardmember','gantipassword']) }}">
    <a class="nav-link" href="/dashboardmember">
      <i class="fas fa-fw fa-tachometer-alt"></i>
      <span>Dashboard</span></a>
  </li>

  <!-- Divider -->

  <hr class="sidebar-divider">

  <!-- Heading -->
  <div class="sidebar-heading">
    Data Akun
  </div>

  <!-- Nav Item - Pages Collapse Menu -->
  <li class="nav-item {{ set_active(['pinjaman-index-member']) }}">
    <a class="nav-link collapsed" href="/pinjaman-index-member" >
      <i class="fas fa-fw fa-coins"></i>
      <span>Pinjaman</span>
    </a>
  </li>

  <!-- Nav Item - Utilities Collapse Menu -->
  <li class="nav-item  {{ set_active(['simpanan-index-member','simpanan-detail-member']) }}">
    <a class="nav-link collapsed" href="/simpanan-index-member">
      <i class="fas fa-fw fa-donate"></i>
      <span>Simpanan</span>
    </a>
  </li>

  <li class="nav-item {{ set_active(['shu-index-member']) }}">
    <a class="nav-link" href="shu-index-member">
      <i class="fas fa-fw fa-money-bill-wave"></i>
      <span>SHU</span></a>
  </li>

  <!-- Divider -->
  <hr class="sidebar-divider">

  <div class="sidebar-heading">
    Neraca
  </div>

  <li class="nav-item {{ set_active('neraca') }}">
    <a class="nav-link" href="/neraca-member">
      <i class="fas fa-fw fa-balance-scale"></i>
      <span>Neraca</span></a>
  </li>


  <!-- Divider -->
  <hr class="sidebar-divider d-none d-md-block">

  <!-- Sidebar Toggler (Sidebar) -->
  <div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
  </div>

</ul>
