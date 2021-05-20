<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title')</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('template/plugins/fontawesome-free/css/all.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('template/dist/css/adminlte.min.css') }}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{ asset('template/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
 
  <script src="{{ asset('template/plugins/jquery/jquery.min.js') }}"></script>
  <!-- Bootstrap 4 -->
  <script src="{{ asset('template/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <!-- AdminLTE App -->
  {{-- <script src="../../dist/js/adminlte.min.js"></script> --}}
  <script src="{{ asset('template/dist/js/adminlte.min.js') }}"></script>
  <!-- overlayScrollbars -->
  <script src="{{ asset('template/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
  <!-- AdminLTE App -->
  <script src="{{ asset('template/dist/js/adminlte.min.js') }}"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="{{ asset('template/dist/js/demo.js') }}"></script>
  {{-- from app.blade --}}
  <script src="{{ asset('js/app.js') }}" defer></script>

  <link rel="stylesheet" href="{{ asset('template/plugins/summernote/summernote-bs4.min.css') }}">
  <script src="{{ asset('template/plugins/summernote/summernote-bs4.min.js') }}"></script>

  <script src="{{ asset('template/plugins/summernote/summernote-bs4.min.js') }}"></script>
  <script src="{{ asset('ckeditor5-custom/build/ckeditor.js') }}"></script>

  <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('img/apple-touch-icon.png') }}">
  <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('img/favicon-32x32.png') }}">
  <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('img/favicon-16x16.png') }}">


</head>
<body class="hold-transition sidebar-mini layout-fixed">
<!-- Site wrapper -->
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="/" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Role : {{ Auth::user()->getRoleNames()[0] }}</a>
      </li>
      {{-- <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">ID : {{ Auth::user()->id }}</a>
      </li> --}}
    </ul>
    <!-- Right navbar links -->
    
    <ul class="navbar-nav ml-auto">
      @can('adminTU')
        <li class="nav-item">
          <a href="{{ route('setting') }}" class="nav-link">Setting</a>
        </li>  
      @endcan
      <li class="nav-item">
        <a href="#" class="nav-link">Name: {{ Auth::user()->name }}</a>
      </li>
        <li class="nav-item">
            <a href="{{ route('logout') }}" class="nav-link" 
                onclick="event.preventDefault(); 
                  document.getElementById('logout-form').submit();" >
              Logout
            </a>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
              @csrf
          </form>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-widget="fullscreen" href="#" role="button">
            <i class="fas fa-expand-arrows-alt"></i>
          </a>
        </li>
      </ul>
    </nav>
  
  
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
      <img src="{{ asset('template/dist/img/LOGO_FTEK.jpeg') }}" alt="SITA-FTEK" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">SITA-FTEK</span>
    </a>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
        @can('mahasiswa')
            <li class="nav-item">
              <a href="{{ route('pilih_pembimbing') }}" class="nav-link">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                  Pilih Dosen Pembimbing
                </p>
              </a>
            </li>

            <li class="nav-item">
              <a href="{{ route('kolokium_awal') }}" class="nav-link">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                  Kolokium Awal
                </p>
              </a>
            </li>

            <li class="nav-item">
              <a href="{{ route('kolokium_lanjut') }}" class="nav-link">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                  Kolokium Lanjut
                </p>
              </a>
            </li>

            <li class="nav-item">
              <a href="{{ route('cetak_surat_tugas') }}" class="nav-link">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                  Cetak Surat Tugas
                </p>
              </a>
            </li>

            <li class="nav-item">
              <a href="{{ route('pengajuan_review') }}" class="nav-link">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                  Pengajuan Review
                </p>
              </a>
            </li>

            <li class="nav-item">
              <a href="{{ route('pengajuan_publikasi') }}" class="nav-link">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                  Pengajuan Nilai Publikasi
                </p>
              </a>
            </li>
        @endcan

        @can('dosen')
            <li class="nav-item has-treeview">
                <a href="#" class="nav-link ">
                  <i class="nav-icon fas fa-circle"></i>
                  <p>
                    Dosen
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href="{{ route('daftar_bimbingan') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Daftar Bimbingan</p>
                      </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item has-treeview">
                <a href="#" class="nav-link ">
                  <i class="nav-icon fas fa-circle"></i>
                  <p>
                    Korkon
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href="{{ route('daftar_mahasiswa') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Kolokium Awal</p>
                      </a>
                    </li>
                </ul>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href="{{ route('daftar_mahasiswa') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Kolokium Lanjut</p>
                      </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item has-treeview">
                <a href="#" class="nav-link ">
                  <i class="nav-icon fas fa-circle"></i>
                  <p>
                    Panitia Ujian
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href="{{ route('daftar_mahasiswa') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Penugasan</p>
                      </a>
                    </li>
                </ul>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href="{{ route('daftar_mahasiswa') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Validasi</p>
                      </a>
                    </li>
                </ul>

            </li>
            <li class="nav-item has-treeview">
                <a href="#" class="nav-link ">
                  <i class="nav-icon fas fa-circle"></i>
                  <p>
                    Reviewer
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href="{{ route('daftar_mahasiswa') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Daftar Bimbingan</p>
                      </a>
                    </li>
                </ul>
            </li>

        @endcan

        @can('adminTU')
       
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link ">
              <i class="nav-icon fas fa-circle"></i>
              <p>
                Daftar User
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
             
                <li class="nav-item">
                  <a href="{{ route('tambah_user') }}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Tambah User</p>
                  </a>
                </li>

                <li class="nav-item">
                  <a href="{{ route('daftar_mahasiswa') }}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Daftar Mahasiswa</p>
                  </a>
                </li>

                <li class="nav-item">
                  <a href="{{ route('daftar_dosen') }}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Daftar Dosen</p>
                  </a>
                </li>
            </ul>
          </li>
    
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link ">
              <i class="nav-icon fas fa-circle"></i>
              <p>
                Verifikasi Berkas
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
             
                <li class="nav-item">
                  <a href="{{ route('verif_kolokium_awal') }}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Kolokium Awal</p>
                  </a>
                </li>

                <li class="nav-item">
                  <a href="{{ route('verif_kolokium_lanjut') }}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Kolokium Lanjut</p>
                  </a>
                </li>

                <li class="nav-item">
                  <a href="{{ route('verif_pengajuan_review') }}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Pengajuan Review</p>
                  </a>
                </li>

                <li class="nav-item">
                  <a href="{{ route('verif_pengajuan_nilai_publikasi') }}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Pengajuan Nilai Publikasi</p>
                  </a>
                </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="{{ route('test_pdf') }}" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Cetak Daftar MHS
              </p>
            </a>
          </li>
        @endcan
         
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>@yield('title')</h1>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>
    
    <section class="content">
        <div class="container-fluid">
            <div class="row">
              <div class="col-12">
                @yield('content')
              </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>

<!-- jQuery -->
{{-- <script src="../../plugins/jquery/jquery.min.js"></script> --}}
<script src="{{ asset('template/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('template/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE App -->
{{-- <script src="../../dist/js/adminlte.min.js"></script> --}}
<script src="{{ asset('template/dist/js/adminlte.min.js') }}"></script>
<!-- overlayScrollbars -->
<script src="{{ asset('template/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('template/dist/js/adminlte.min.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('template/dist/js/demo.js') }}"></script>
{{-- from app.blade --}}
<script src="{{ asset('js/app.js') }}" defer></script>
{{-- <script src="{{ asset('summernote/summernote-bs4.min.js') }}"></script> --}}

</body>
</html>
