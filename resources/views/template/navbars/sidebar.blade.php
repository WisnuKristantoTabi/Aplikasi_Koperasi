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
  <li class="nav-item {{ set_active(['dashboardadmin','gantipassword','setting','akun-tutup','gantipassword']) }}">
    <a class="nav-link" href="/dashboardadmin">
      <i class="fas fa-fw fa-tachometer-alt"></i>
      <span>Dashboard</span></a>
  </li>

  <!-- Divider -->
  <hr class="sidebar-divider">

  <div class="sidebar-heading">
    Daftar
  </div>

  <li class="nav-item {{ set_active(['register-member','register-admin','register-nonmember']) }}">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
      <i class="fas fa-fw fa-coins"></i>
      <span>Daftar</span>
    </a>
    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <h6 class="collapse-header">Daftar:</h6>
        <a class="collapse-item" href="/register-member">Anggota</a>
        <a class="collapse-item" href="/register-admin">Admin</a>
        <a class="collapse-item" href="/register-nonmember">Non-Anggota</a>
      </div>
    </div>
  </li>

  <hr class="sidebar-divider">

  <!-- Heading -->
  <div class="sidebar-heading">
    Transaksi
  </div>

  <!-- Nav Item - Pages Collapse Menu -->
  <li class="nav-item {{ set_active(['pinjaman','pinjaman-anggota','pinjaman-sementara','pinjaman-nonanggota','piutang']) }}">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#pinjaman" aria-expanded="true" aria-controls="collapseTwo">
      <i class="fas fa-fw fa-coins"></i>
      <span>Pinjaman</span>
    </a>
    <div id="pinjaman" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <h6 class="collapse-header">Pinjaman:</h6>
        <a class="collapse-item" href="/pinjaman">Pinjam</a>
        <a class="collapse-item" href="/pinjaman-anggota">Anggota</a>
        <a class="collapse-item" href="/pinjaman-sementara">Sementara</a>
        <a class="collapse-item" href="/pinjaman-nonanggota">Non Anggota</a>
        <a class="collapse-item" href="/piutang">Piutang</a>
      </div>
    </div>
  </li>

  <!-- Nav Item - Utilities Collapse Menu -->
  <li class="nav-item  {{ set_active(['simpanan-add-wajib','simpanan-add-sukarela','simpanan-add-pokok']) }}">
    <a class="nav-link collapsed" href="/simpanan-add-wajib">
      <i class="fas fa-fw fa-donate"></i>
      <span>Simpanan</span>
    </a>
  </li>

  <hr class="sidebar-divider">

  <div class="sidebar-heading">
    Jurnal Umum
  </div>

  <li class="nav-item {{set_active('jurnal-umum')}}">
    <a class="nav-link" href="/jurnal-umum?pti={{getIdLatest('periode_table')}}">
      <i class="fas fa-fw fa-money-check-alt"></i>
      <span>Jurnal Umum</span></a>
  </li>

  <!-- Divider -->
  <hr class="sidebar-divider">

  <div class="sidebar-heading">
    Neraca
  </div>

  <li class="nav-item {{ set_active('neraca') }}">
    <a class="nav-link" href="/neraca">
      <i class="fas fa-fw fa-balance-scale"></i>
      <span>Neraca</span></a>
  </li>

  <hr class="sidebar-divider">


  <!-- Heading -->
  <div class="sidebar-heading">
    SHU
  </div>

  <li class="nav-item {{ set_active(['shu-search','shu']) }}">
    <a class="nav-link" href="shu?page=1">
      <i class="fas fa-fw fa-money-bill-wave"></i>
      <span>SHU</span></a>
  </li>

  <hr class="sidebar-divider">

  <div class="sidebar-heading">
    Buku Besar
  </div>

  <li class="nav-item {{set_active('buku-besar')}}">
    <a class="nav-link" href="/buku-besar?i=1&&pti={{getIdLatest('periode_table')}}">
      <i class="fas fa-fw fa-book-open"></i>
      <span>Buku Besar</span></a>
  </li>

  <hr class="sidebar-divider">

  <div class="sidebar-heading">
    Anggota
  </div>

  <li class="nav-item {{ set_active(['pinjaman','pinjaman-anggota','pinjaman-sementara','pinjaman-nonanggota','piutang']) }}">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#anggota" aria-expanded="true" aria-controls="collapseTwo">
      <i class="fas fa-fw fa-users"></i>
      <span>Anggota</span>
    </a>
    <div id="anggota" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <h6 class="collapse-header">Anggota:</h6>
        <a class="collapse-item" href="/member-list-member">Anggota Tetap</a>
        <a class="collapse-item" href="/member-view-list-non-member">Bukan Anggota</a>
      </div>
    </div>
  </li>

  <hr class="sidebar-divider">

  <div class="sidebar-heading">
    Lain-Lain
  </div>

  <li class="nav-item {{set_active('aset')}}" >
    <a class="nav-link" href="/aset">
      <i class="fas fa-fw fa-home"></i>
      <span>Aset</span></a>
  </li>

  <li class="nav-item {{set_active('beban')}}">
    <a class="nav-link" href="/beban?prd={{getIdLatest('periode_table')}}">
      <i class="fas fa-fw fa-dollar-sign"></i>
      <span>Biaya</span></a>
  </li>

  <!-- Divider -->
  <hr class="sidebar-divider d-none d-md-block">

  <!-- Sidebar Toggler (Sidebar) -->
  <div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
  </div>

</ul>
