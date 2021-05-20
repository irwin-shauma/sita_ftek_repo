<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('home') }}" class="brand-link">
        <img src="{{ asset('template/dist/img/LOGO_FTEK.png') }}" alt="SITA-FTEK" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">SITA-FTEK</span>
    </a>

    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
            with font-awesome or any other icon font library -->
                @can('mahasiswa')
                    <li class="nav-item">
                    <a href="{{ route('pilih_pembimbing') }}" class="nav-link">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                        Pilih Dosen Pembimbing
                        </p>
                    </a>
                    </li>

                    <li class="nav-item has-treeview ml-n2">
                        <a href="#" class="nav-link ">
                        <i class="nav-icon fa fa-bars"></i>
                        <p>
                            Kolokium Awal
                            <i class="right fa fa-angle-left"></i>
                        </p>
                        </a>
                        <ul class="nav nav-treeview ml-2">
                            <li class="nav-item">
                            <a href="{{ route('kolokium_awal_proposal') }}" class="nav-link">
                                <i class="fas fa-clipboard-list nav-icon"></i>
                                <p>Proposal Awal</p>
                            </a>
                            </li>

                            <li class="nav-item">
                            <a href="{{ route('kolokium_awal_berkas') }}" class="nav-link">
                                <i class="nav-icon fas fa-file-archive"></i>
                                <p>Berkas Kolokium Awal</p>
                            </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item ml-n2">
                    <a href="{{ route('cetak_surat_tugas') }}" class="nav-link">
                        <i class="nav-icon fas fa-print"></i>
                        <p>
                        Cetak Surat Tugas
                        </p>
                    </a>
                    </li>

                    <li class="nav-item has-treeview ml-n2">
                        <a href="#" class="nav-link ">
                        <i class="nav-icon fa fa-bars"></i>
                        <p>
                            Kolokium Lanjut
                            <i class="right fa fa-angle-left"></i>
                        </p>
                        </a>
                        <ul class="nav nav-treeview ml-2">
                            <li class="nav-item">
                            <a href="{{ route('kolokium_lanjut_proposal') }}" class="nav-link">
                                <i class="fas fa-clipboard-list nav-icon"></i>
                                <p>Proposal Lanjut</p>
                            </a>
                            </li>

                            <li class="nav-item">
                            <a href="{{ route('kolokium_lanjut_berkas') }}" class="nav-link">
                                <i class="nav-icon fas fa-file-archive"></i>
                                <p>Berkas Kolokium Lanjut</p>
                            </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item has-treeview ml-n2">
                        <a href="#" class="nav-link ">
                        <i class="nav-icon fa fa-bars"></i>
                        <p>
                            Pengajuan Review
                            <i class="right fa fa-angle-left"></i>
                        </p>
                        </a>
                        <ul class="nav nav-treeview ml-2">
                            <li class="nav-item">
                            <a href="{{ route('pengajuan_review_paper') }}" class="nav-link">
                                <i class="fas fa-clipboard-list nav-icon"></i>
                                <p>Paper</p>
                            </a>
                            </li>

                            <li class="nav-item">
                            <a href="{{ route('pengajuan_review_berkas') }}" class="nav-link">
                                <i class="nav-icon fas fa-file-archive"></i>
                                <p>Berkas Pengajuan Review</p>
                            </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item ml-n2">
                    <a href="{{ route('pengajuan_publikasi_berkas') }}" class="nav-link">
                        <i class="nav-icon fas fa-file-archive"></i>
                        <p>
                        Pengajuan Nilai Publikasi
                        </p>
                    </a>
                    </li>
                @endcan

                @can('dosen')
                    <li class="nav-item has-treeview ml-n2">
                        <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-home"></i>
                        <p>
                            Dosen
                            <i class="right fas fa-angle-left"></i>
                        </p>
                        </a>
                        <ul class="nav nav-treeview ml-2">
                            <li class="nav-item">
                            <a href="{{ route('daftar_bimbingan') }}" class="nav-link">
                                <i class="fas fa-clipboard-list nav-icon"></i>
                                <p>Daftar Bimbingan</p>
                            </a>
                            </li>

                            <li class="nav-item">
                            <a href="{{ route('daftar_revisi_makalah') }}" class="nav-link">
                                <i class="fas fa-bars nav-icon"></i>
                                <p>Daftar Revisi Makalah</p>
                            </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item has-treeview ml-n2">
                        <a href="#" class="nav-link ">
                        <i class="nav-icon fas fa-bars"></i>
                        <p>
                            Menu Bimbingan
                            <i class="right fas fa-angle-left"></i>
                        </p>
                        </a>
                        <ul class="nav nav-treeview ml-2">
                            <li class="nav-item">
                                <a href="{{ route('bimbingan_kolokium_awal') }}" class="nav-link">
                                    <i class="fas fa-bars nav-icon"></i>
                                    <p>Kolokium Awal</p>
                                </a>
                                </li>
                                <li class="nav-item">
                                <a href="{{ route('bimbingan_kolokium_lanjut') }}" class="nav-link">
                                    <i class="fas fa-bars nav-icon"></i>
                                    <p>Kolokium Lanjut</p>
                                </a>
                                </li>
                                <li class="nav-item">
                                <a href="{{ route('bimbingan_pengajuan_review') }}" class="nav-link">
                                    <i class="fas fa-bars nav-icon"></i>
                                    <p>Pengajuan Review</p>
                                </a>
                                </li>
                                <li class="nav-item">
                                <a href="{{ route('bimbingan_penilaian_tugas_akhir') }}" class="nav-link">
                                    <i class="fas fa-bars nav-icon"></i>
                                    <p>Penilaian Tugas Akhir</p>
                                </a>
                                </li>
                        </ul>
                    </li>

                    {{-- @can('korkon') --}}
                    @canany('korkon_elektro')
                    {{-- @canany(['korkon_elektro', 'korkon_telkom', 'korkon_tek_kom'] ) --}}
                        <li class="nav-item has-treeview ml-n2">
                            <a href="#" class="nav-link ">
                            <i class="nav-icon fas fa-home"></i>
                            <p>
                                Korkon Elektro
                                <i class="right fas fa-angle-left"></i>
                            </p>
                            </a>
                            <ul class="nav nav-treeview ml-2">
                                <li class="nav-item">
                                <a href="{{ route('korkon_elektro_verif_kolokium_awal') }}" class="nav-link">
                                    <i class="fas fa-file-archive nav-icon"></i>
                                    <p>Berkas Kolokium Awal</p>
                                </a>
                                </li>
                                <li class="nav-item">
                                <a href="{{ route('korkon_elektro_verif_kolokium_lanjut') }}" class="nav-link">
                                    <i class="fas fa-file-archive nav-icon"></i>
                                    <p>Berkas Kolokium Lanjut</p>
                                </a>
                                </li>
                                <li class="nav-item">
                                <a href="{{ route('korkon_elektro_penjadwalan_awal') }}" class="nav-link">
                                    <i class="fas fa-file-archive nav-icon"></i>
                                    <p>Penjadwalan Kolokium Awal</p>
                                </a>
                                <a href="{{ route('korkon_elektro_penjadwalan_lanjut') }}" class="nav-link">
                                    <i class="fas fa-file-archive nav-icon"></i>
                                    <p>Penjadwalan Kolokium Lanjut</p>
                                </a>
                                <a href="{{ route('korkon_elektro_validasi_revisi_awal') }}" class="nav-link">
                                    <i class="fas fa-file-archive nav-icon"></i>
                                    <p>Validasi Revisi Awal</p>
                                </a>
                                <a href="{{ route('korkon_elektro_validasi_revisi_lanjut') }}" class="nav-link">
                                    <i class="fas fa-file-archive nav-icon"></i>
                                    <p>Validasi Revisi Lanjut</p>
                                </a>
                            </ul>
                        </li>
                    @endcan
                    @can('korkon_telkom' )
                        <li class="nav-item has-treeview ml-n2">
                            <a href="#" class="nav-link ">
                            <i class="nav-icon fas fa-home"></i>
                            <p>
                                Korkon Telkom
                                <i class="right fas fa-angle-left"></i>
                            </p>
                            </a>
                            <ul class="nav nav-treeview ml-2">
                                <li class="nav-item">
                                <a href="{{ route('korkon_telkom_verif_kolokium_awal') }}" class="nav-link">
                                    <i class="fas fa-file-archive nav-icon"></i>
                                    <p>Berkas Kolokium Awal</p>
                                </a>
                                </li>
                                <li class="nav-item">
                                <a href="{{ route('korkon_telkom_verif_kolokium_lanjut') }}" class="nav-link">
                                    <i class="fas fa-file-archive nav-icon"></i>
                                    <p>Berkas Kolokium Lanjut</p>
                                </a>
                                </li>
                                <li class="nav-item">
                                <a href="{{ route('korkon_telkom_penjadwalan_awal') }}" class="nav-link">
                                    <i class="fas fa-file-archive nav-icon"></i>
                                    <p>Penjadwalan Kolokium Awal</p>
                                </a>
                                <a href="{{ route('korkon_telkom_penjadwalan_lanjut') }}" class="nav-link">
                                    <i class="fas fa-file-archive nav-icon"></i>
                                    <p>Penjadwalan Kolokium Lanjut</p>
                                </a>
                                <a href="{{ route('korkon_telkom_validasi_revisi_awal') }}" class="nav-link">
                                    <i class="fas fa-file-archive nav-icon"></i>
                                    <p>Validasi Revisi Awal</p>
                                </a>
                                <a href="{{ route('korkon_telkom_validasi_revisi_lanjut') }}" class="nav-link">
                                    <i class="fas fa-file-archive nav-icon"></i>
                                    <p>Validasi Revisi Lanjut</p>
                                </a>
                            </ul>
                        </li>
                    @endcan
                    @canany('korkon_tek_kom')
                    {{-- @canany(['korkon_elektro', 'korkon_telkom', 'korkon_tek_kom'] ) --}}
                        <li class="nav-item has-treeview ml-n2">
                            <a href="#" class="nav-link ">
                            <i class="nav-icon fas fa-home"></i>
                            <p>
                                Korkon Tekkom
                                <i class="right fas fa-angle-left"></i>
                            </p>
                            </a>
                            <ul class="nav nav-treeview ml-2">
                                <li class="nav-item">
                                <a href="{{ route('korkon_tek_kom_verif_kolokium_awal') }}" class="nav-link">
                                    <i class="fas fa-file-archive nav-icon"></i>
                                    <p>Berkas Kolokium Awal</p>
                                </a>
                                </li>
                                <li class="nav-item">
                                <a href="{{ route('korkon_tek_kom_verif_kolokium_lanjut') }}" class="nav-link">
                                    <i class="fas fa-file-archive nav-icon"></i>
                                    <p>Berkas Kolokium Lanjut</p>
                                </a>
                                </li>
                                <li class="nav-item">
                                <a href="{{ route('korkon_tek_kom_penjadwalan_awal') }}" class="nav-link">
                                    <i class="fas fa-file-archive nav-icon"></i>
                                    <p>Penjadwalan Kolokium Awal</p>
                                </a>
                                <a href="{{ route('korkon_tek_kom_penjadwalan_lanjut') }}" class="nav-link">
                                    <i class="fas fa-file-archive nav-icon"></i>
                                    <p>Penjadwalan Kolokium Lanjut</p>
                                </a>
                                <a href="{{ route('korkon_tek_kom_validasi_revisi_awal') }}" class="nav-link">
                                    <i class="fas fa-file-archive nav-icon"></i>
                                    <p>Validasi Revisi Awal</p>
                                </a>
                                <a href="{{ route('korkon_tek_kom_validasi_revisi_lanjut') }}" class="nav-link">
                                    <i class="fas fa-file-archive nav-icon"></i>
                                    <p>Validasi Revisi Lanjut</p>
                                </a>
                            </ul>
                        </li>
                    @endcan

                    @can('panitia_ujian')
                        <li class="nav-item has-treeview ml-n2">
                            <a href="#" class="nav-link ">
                                <i class="nav-icon fas fa-home"></i>
                                <p>
                                    Panitia Ujian
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview ml-2">
                                <li class="nav-item">
                                    <a href="{{ route('penugasan_review') }}" class="nav-link">
                                        <i class="fas fa-clipboard-list nav-icon"></i>
                                        <p>Penugasan</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('verifikasi_rekap') }}" class="nav-link">
                                        <i class="far fa-check-circle nav-icon"></i>
                                        <p>Verifikasi Rekap Nilai</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('verifikasi_rekap_publikasi') }}" class="nav-link">
                                        <i class="far fa-check-circle nav-icon"></i>
                                        <p>Verifikasi Rekap Nilai Publikasi</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endcan
                    
                    @can('reviewer')
                        <li class="nav-item has-treeview ml-n2">
                            <a href="#" class="nav-link ">
                                <i class="nav-icon fas fa-home"></i>
                                <p>
                                    Reviewer
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview ml-2">
                                <li class="nav-item">
                                    <a href="{{ route('review_kolokium_awal') }}" class="nav-link">
                                        <i class="fas fa-clipboard-list nav-icon"></i>
                                        <p>Kolokium Awal</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('review_kolokium_lanjut') }}" class="nav-link">
                                        <i class="fas fa-clipboard-list nav-icon"></i>
                                        <p>Kolokium Lanjut</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('penilaian_kolokium_lanjut') }}" class="nav-link">
                                        <i class="fas fa-clipboard-list nav-icon"></i>
                                        <p>Penilaian Kolokium Lanjut</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('review_pengajuan_review') }}" class="nav-link">
                                        <i class="fas fa-clipboard-list nav-icon"></i>
                                        <p>Revisi Pengajuan Review</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('penilaian_paper') }}" class="nav-link">
                                        <i class="fas fa-clipboard-list nav-icon"></i>
                                        <p>Penilaian Paper</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endcan

                @endcan

                @can('adminTU')
            
                <li class="nav-item has-treeview ml-n2">
                    <a href="#" class="nav-link ">
                    <i class="nav-icon fas fa-book"></i>
                    <p>
                        Daftar User
                        <i class="right fas fa-angle-left"></i>
                    </p>
                    </a>
                    <ul class="nav nav-treeview ml-2">
                    
                        <li class="nav-item">
                        <a href="{{ route('tambah_user') }}" class="nav-link">
                            <i class="fas fa-user-plus nav-icon"></i>
                            <p>Tambah User</p>
                        </a>
                        </li>

                        <li class="nav-item">
                        <a href="{{ route('daftar_mahasiswa') }}" class="nav-link">
                            <i class="fa fa-users nav-icon"></i>
                            <p>Daftar Mahasiswa</p>
                        </a>
                        </li>

                        <li class="nav-item">
                        <a href="{{ route('daftar_dosen') }}" class="nav-link">
                            <i class="fas fa-users nav-icon"></i>
                            <p>Daftar Dosen</p>
                        </a>
                        </li>

                        <li class="nav-item">
                        <a href="{{ route('tambah_permissions') }}" class="nav-link">
                            <i class="fas fa-user-plus nav-icon"></i>
                            <p>Tambah Permissions</p>
                        </a>
                        </li>
                    </ul>
                </li>
            
                <li class="nav-item has-treeview ml-n2">
                    <a href="#" class="nav-link ">
                    <i class="nav-icon far fa-check-circle"></i>
                    <p>
                        Verifikasi Berkas
                        <i class="right fas fa-angle-left"></i>
                    </p>
                    </a>
                    <ul class="nav nav-treeview ml-2">
                    
                        {{-- <li class="nav-item">
                        <a href="{{ route('korkon_elektro_verif_kolokium_awal') }}" class="nav-link">
                            <i class="fas fa-vote-yea nav-icon"></i>
                            <p>Kolokium Awal</p>
                        </a>
                        </li>

                        <li class="nav-item">
                        <a href="{{ route('korkon_elektro_verif_kolokium_lanjut') }}" class="nav-link">
                            <i class="fas fa-vote-yea nav-icon"></i>
                            <p>Kolokium Lanjut</p>
                        </a>
                        </li> --}}

                        <li class="nav-item">
                        <a href="{{ route('verif_pengajuan_review') }}" class="nav-link">
                            <i class="fas fa-vote-yea nav-icon"></i>
                            <p>Pengajuan Review</p>
                        </a>
                        </li>

                        <li class="nav-item">
                        <a href="{{ route('verif_pengajuan_nilai_publikasi') }}" class="nav-link">
                            <i class="fas fa-vote-yea nav-icon"></i>
                            <p>Pengajuan Nilai Publikasi</p>
                        </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="{{ route('daftar_mahasiswa_cetak') }}" class="nav-link">
                    <i class="nav-icon fas fa-print ml-n2"></i>
                    <p>
                        Cetak Daftar MHS
                    </p>
                    </a>
                </li>
                @endcan
            </ul>
        </nav>
    <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>