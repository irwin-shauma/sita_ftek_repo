<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\AdminTUController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\KorkonElektroController;
use App\Http\Controllers\KorkonTek_KomController;
use App\Http\Controllers\KorkonTelkomController;
use App\Http\Controllers\PanitiaUjianController;
use App\Http\Controllers\ReviewerController;

if (version_compare(PHP_VERSION, '7.2.0', '>=')) {
    // Ignores notices and reports all other kinds... and warnings
    error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
    // error_reporting(E_ALL ^ E_WARNING); // Maybe this is enough
}

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::group(['middleware' => ['permission:mahasiswa']], function () {
    Route::get('/test', [MahasiswaController::class, 'test'])->name('test');
    Route::match(['get', 'post'], '/surat_tugas', [MahasiswaController::class, 'surat_tugas'])->name('surat_tugas');
    Route::get('/cetak_surat_tugas', [MahasiswaController::class, 'cetak_surat_tugas'])->name('cetak_surat_tugas');
    Route::get('/cetak_surat_tugas/download/{user}', [MahasiswaController::class, 'download_surat_tugas'])->name('download_surat_tugas');

    Route::get('/pilih_pembimbing', [MahasiswaController::class, 'pilih_pembimbing'])->name('pilih_pembimbing');
    Route::post('/data_pembimbing', [MahasiswaController::class, 'data_pembimbing'])->name('data_pembimbing');

    Route::get('/kolokium_awal/proposal', [MahasiswaController::class, 'kolokium_awal_proposal'])->name('kolokium_awal_proposal');
    Route::post('/kolokium_awal/proposal/upload', [MahasiswaController::class, 'kolokium_awal_proposal_upload'])->name('kolokium_awal_proposal_upload');
    Route::post('/kolokium_awal/proposal/download', [MahasiswaController::class, 'kolokium_awal_proposal_download'])->name('kolokium_awal_proposal_download');
    Route::get('/kolokium_awal/berkas', [MahasiswaController::class, 'kolokium_awal_berkas'])->name('kolokium_awal_berkas');
    Route::post('/kolokium_awal/berkas/upload', [MahasiswaController::class, 'kolokium_awal_berkas_upload'])->name('kolokium_awal_berkas_upload');

    Route::get('/kolokium_lanjut/proposal', [MahasiswaController::class, 'kolokium_lanjut_proposal'])->name('kolokium_lanjut_proposal');
    Route::post('/kolokium_lanjut/proposal/upload', [MahasiswaController::class, 'kolokium_lanjut_proposal_upload'])->name('kolokium_lanjut_proposal_upload');
    Route::post('/kolokium_lanjut/proposal/download', [MahasiswaController::class, 'kolokium_lanjut_proposal_download'])->name('kolokium_lanjut_proposal_download');
    Route::get('/kolokium_lanjut/berkas', [MahasiswaController::class, 'kolokium_lanjut_berkas'])->name('kolokium_lanjut_berkas');
    Route::post('/kolokium_lanjut/berkas/upload', [MahasiswaController::class, 'kolokium_lanjut_berkas_upload'])->name('kolokium_lanjut_berkas_upload');

    Route::get('/pengajuan_review/paper', [MahasiswaController::class, 'pengajuan_review_paper'])->name('pengajuan_review_paper');
    Route::post('/pengajuan_review/paper/upload', [MahasiswaController::class, 'pengajuan_review_paper_upload'])->name('pengajuan_review_paper_upload');
    Route::post('/pengajuan_review/paper/download', [MahasiswaController::class, 'pengajuan_review_paper_download'])->name('pengajuan_review_paper_download');
    Route::get('/pengajuan_review/berkas', [MahasiswaController::class, 'pengajuan_review_berkas'])->name('pengajuan_review_berkas');
    Route::post('/pengajuan_review/berkas/upload', [MahasiswaController::class, 'pengajuan_review_berkas_upload'])->name('pengajuan_review_berkas_upload');

    Route::get('/pengajuan_publikasi/berkas', [MahasiswaController::class, 'pengajuan_publikasi_berkas'])->name('pengajuan_publikasi_berkas');
    Route::post('/pengajuan_publikasi/berkas/upload', [MahasiswaController::class, 'pengajuan_publikasi_berkas_upload'])->name('pengajuan_publikasi_berkas_upload');
});

Route::group(['middleware' => ['permission:dosen']], function () {
    Route::get('/daftar_bimbingan', [DosenController::class, 'daftar_bimbingan'])->name('daftar_bimbingan');
    Route::get('/daftar_revisi_makalah', [DosenController::class, 'daftar_revisi_makalah'])->name('daftar_revisi_makalah');
    Route::post('/daftar_revisi_makalah/download', [DosenController::class, 'daftar_revisi_makalah_download'])->name('daftar_revisi_makalah_download');

    Route::get('/bimbingan/kolokium_awal', [DosenController::class, 'bimbingan_kolokium_awal'])->name('bimbingan_kolokium_awal');
    Route::post('/bimbingan/kolokium_awal/download', [DosenController::class, 'bimbingan_kolokium_awal_download'])->name('bimbingan_kolokium_awal_download');
    Route::post('/bimbingan/kolokium_awal/action', [DosenController::class, 'bimbingan_kolokium_awal_action'])->name('bimbingan_kolokium_awal_action');

    Route::get('/bimbingan/kolokium_lanjut', [DosenController::class, 'bimbingan_kolokium_lanjut'])->name('bimbingan_kolokium_lanjut');
    Route::post('/bimbingan/kolokium_lanjut/download', [DosenController::class, 'bimbingan_kolokium_lanjut_download'])->name('bimbingan_kolokium_lanjut_download');
    Route::post('/bimbingan/kolokium_lanjut/action', [DosenController::class, 'bimbingan_kolokium_lanjut_action'])->name('bimbingan_kolokium_lanjut_action');

    Route::get('/bimbingan/pengajuan_review', [DosenController::class, 'bimbingan_pengajuan_review'])->name('bimbingan_pengajuan_review');
    Route::post('/bimbingan/pengajuan_review/download', [DosenController::class, 'bimbingan_pengajuan_review_download'])->name('bimbingan_pengajuan_review_download');
    Route::post('/bimbingan/pengajuan_review/action', [DosenController::class, 'bimbingan_pengajuan_review_action'])->name('bimbingan_pengajuan_review_action');

    Route::get('/bimbingan/penilaian_tugas_akhir', [DosenController::class, 'bimbingan_penilaian_tugas_akhir'])->name('bimbingan_penilaian_tugas_akhir');
    Route::post('/bimbingan/penilaian_tugas_akhir/action', [DosenController::class, 'bimbingan_penilaian_tugas_akhir_action'])->name('bimbingan_penilaian_tugas_akhir_action');
});

Route::group(['middleware' => ['permission:reviewer']], function () {
    Route::get('/review/kolokium_awal', [ReviewerController::class, 'review_kolokium_awal'])->name('review_kolokium_awal');
    Route::post('/review/kolokium_awal/download', [ReviewerController::class, 'review_kolokium_awal_download'])->name('review_kolokium_awal_download');
    Route::post('/review/kolokium_awal/action', [ReviewerController::class, 'review_kolokium_awal_action'])->name('review_kolokium_awal_action');

    Route::get('/review/kolokium_lanjut', [ReviewerController::class, 'review_kolokium_lanjut'])->name('review_kolokium_lanjut');
    Route::post('/review/kolokium_lanjut/download', [ReviewerController::class, 'review_kolokium_lanjut_download'])->name('review_kolokium_lanjut_download');
    Route::post('/review/kolokium_lanjut/action', [ReviewerController::class, 'review_kolokium_lanjut_action'])->name('review_kolokium_lanjut_action');

    Route::get('/review/pengajuan_review', [ReviewerController::class, 'review_pengajuan_review'])->name('review_pengajuan_review');
    Route::post('/review/pengajuan_review/download', [ReviewerController::class, 'review_pengajuan_review_download'])->name('review_pengajuan_review_download');
    Route::post('/review/pengajuan_review/action', [ReviewerController::class, 'review_pengajuan_review_action'])->name('review_pengajuan_review_action');

    Route::get('/review/penilaian/kolokium_lanjut', [ReviewerController::class, 'penilaian_kolokium_lanjut'])->name('penilaian_kolokium_lanjut');
    Route::post('/review/penilaian/kolokium_lanjut/action', [ReviewerController::class, 'penilaian_kolokium_lanjut_action'])->name('penilaian_kolokium_lanjut_action');

    Route::get('/review/penilaian/paper', [ReviewerController::class, 'penilaian_paper'])->name('penilaian_paper');
    Route::post('/review/penilaian/paper/action', [ReviewerController::class, 'penilaian_paper_action'])->name('penilaian_paper_action');
});

Route::group(['middleware' => ['permission:panitia_ujian']], function () {
    Route::get('/penugasan/review', [PanitiaUjianController::class, 'penugasan_review'])->name('penugasan_review');
    Route::post('/penugasan/review/action', [PanitiaUjianController::class, 'penugasan_review_action'])->name('penugasan_review_action');
    Route::get('/penugasan/revisi', [PanitiaUjianController::class, 'penugasan_revisi'])->name('penugasan_revisi');
    Route::get('/verifikasi/rekap', [PanitiaUjianController::class, 'verifikasi_rekap'])->name('verifikasi_rekap');
    Route::post('/verifikasi/rekap/action', [PanitiaUjianController::class, 'verifikasi_rekap_action'])->name('verifikasi_rekap_action');
    Route::get('/verifikasi/rekap/publikasi', [PanitiaUjianController::class, 'verifikasi_rekap_publikasi'])->name('verifikasi_rekap_publikasi');
    Route::post('/verifikasi/rekap/publikasi/action', [PanitiaUjianController::class, 'verifikasi_rekap_publikasi_action'])->name('verifikasi_rekap_publikasi_action');
});

Route::group(['middleware' => ['permission:korkon_elektro']], function () {
    // Route::group(['middleware' => ['permission:korkon_telkom|korkon_elektro|korkon_tek_kom']], function () {
    Route::get('/korkon_elektro/verifikasi/kolokium_awal', [KorkonElektroController::class, 'korkon_elektro_verif_kolokium_awal'])->name('korkon_elektro_verif_kolokium_awal');
    Route::get('/korkon_elektro/verifikasi/kolokium_awal_download/{user}', [KorkonElektroController::class, 'korkon_elektro_verif_kolokium_awal_download'])->name('korkon_elektro_verif_kolokium_awal_download');
    Route::post('/korkon_elektro/verifikasi/kolokium_awal/verified', [KorkonElektroController::class, 'korkon_elektro_verif_kolokium_awal_verified'])->name('korkon_elektro_verif_kolokium_awal_verified');
    Route::get('/korkon_elektro/validasi/revisi_proposal_awal', [KorkonElektroController::class, 'korkon_elektro_validasi_revisi_awal'])->name('korkon_elektro_validasi_revisi_awal');
    Route::post('/korkon_elektro/validasi/revisi_proposal_awal/download', [KorkonElektroController::class, 'korkon_elektro_validasi_revisi_awal_download'])->name('korkon_elektro_validasi_revisi_awal_download');
    Route::post('/korkon_elektro/validasi/revisi_proposal_awal/validated', [KorkonElektroController::class, 'korkon_elektro_validasi_revisi_awal_validated'])->name('korkon_elektro_validasi_revisi_awal_validated');

    Route::get('/korkon_elektro/verifikasi/kolokium_lanjut', [KorkonElektroController::class, 'korkon_elektro_verif_kolokium_lanjut'])->name('korkon_elektro_verif_kolokium_lanjut');
    Route::get('/korkon_elektro/verifikasi/kolokium_lanjut_download/{user}', [KorkonElektroController::class, 'korkon_elektro_verif_kolokium_lanjut_download'])->name('korkon_elektro_verif_kolokium_lanjut_download');
    Route::post('/korkon_elektro/verifikasi/kolokium_lanjut/verified', [KorkonElektroController::class, 'korkon_elektro_verif_kolokium_lanjut_verified'])->name('korkon_elektro_verif_kolokium_lanjut_verified');
    Route::get('/korkon_elektro/validasi/revisi_proposal_lanjut', [KorkonElektroController::class, 'korkon_elektro_validasi_revisi_lanjut'])->name('korkon_elektro_validasi_revisi_lanjut');
    Route::post('/korkon_elektro/validasi/revisi_proposal_lanjut/download', [KorkonElektroController::class, 'korkon_elektro_validasi_revisi_lanjut_download'])->name('korkon_elektro_validasi_revisi_lanjut_download');
    Route::post('/korkon_elektro/validasi/revisi_proposal_lanjut/validated', [KorkonElektroController::class, 'korkon_elektro_validasi_revisi_lanjut_validated'])->name('korkon_elektro_validasi_revisi_lanjut_validated');

    Route::get('/korkon_elektro/verifikasi/penjadwalan_awal', [KorkonElektroController::class, 'korkon_elektro_penjadwalan_awal'])->name('korkon_elektro_penjadwalan_awal');
    Route::post('/korkon_elektro/verifikasi/penjadwalan_awal/data', [KorkonElektroController::class, 'korkon_elektro_penjadwalan_awal_data'])->name('korkon_elektro_penjadwalan_awal_data');

    Route::get('/korkon_elektro/verifikasi/penjadwalan_lanjut', [KorkonElektroController::class, 'korkon_elektro_penjadwalan_lanjut'])->name('korkon_elektro_penjadwalan_lanjut');
    Route::post('/korkon_elektro/verifikasi/penjadwalan_lanjut/data', [KorkonElektroController::class, 'korkon_elektro_penjadwalan_lanjut_data'])->name('korkon_elektro_penjadwalan_lanjut_data');
});
Route::group(['middleware' => ['permission:korkon_telkom']], function () {
    Route::get('/korkon_telkom/verifikasi/kolokium_awal', [KorkonTelkomController::class, 'korkon_telkom_verif_kolokium_awal'])->name('korkon_telkom_verif_kolokium_awal');
    Route::get('/korkon_telkom/verifikasi/kolokium_awal_download/{user}', [KorkonTelkomController::class, 'korkon_telkom_verif_kolokium_awal_download'])->name('korkon_telkom_verif_kolokium_awal_download');
    Route::post('/korkon_telkom/verifikasi/kolokium_awal/verified', [KorkonTelkomController::class, 'korkon_telkom_verif_kolokium_awal_verified'])->name('korkon_telkom_verif_kolokium_awal_verified');
    Route::get('/korkon_telkom/validasi/revisi_proposal_awal', [KorkonTelkomController::class, 'korkon_telkom_validasi_revisi_awal'])->name('korkon_telkom_validasi_revisi_awal');
    Route::post('/korkon_telkom/validasi/revisi_proposal_awal/download', [KorkonTelkomController::class, 'korkon_telkom_validasi_revisi_awal_download'])->name('korkon_telkom_validasi_revisi_awal_download');
    Route::post('/korkon_telkom/validasi/revisi_proposal_awal/validated', [KorkonTelkomController::class, 'korkon_telkom_validasi_revisi_awal_validated'])->name('korkon_telkom_validasi_revisi_awal_validated');

    Route::get('/korkon_telkom/verifikasi/kolokium_lanjut', [KorkonTelkomController::class, 'korkon_telkom_verif_kolokium_lanjut'])->name('korkon_telkom_verif_kolokium_lanjut');
    Route::get('/korkon_telkom/verifikasi/kolokium_lanjut_download/{user}', [KorkonTelkomController::class, 'korkon_telkom_verif_kolokium_lanjut_download'])->name('korkon_telkom_verif_kolokium_lanjut_download');
    Route::post('/korkon_telkom/verifikasi/kolokium_lanjut/verified', [KorkonTelkomController::class, 'korkon_telkom_verif_kolokium_lanjut_verified'])->name('korkon_telkom_verif_kolokium_lanjut_verified');
    Route::get('/korkon_telkom/validasi/revisi_proposal_lanjut', [KorkonTelkomController::class, 'korkon_telkom_validasi_revisi_lanjut'])->name('korkon_telkom_validasi_revisi_lanjut');
    Route::post('/korkon_telkom/validasi/revisi_proposal_lanjut/download', [KorkonTelkomController::class, 'korkon_telkom_validasi_revisi_lanjut_download'])->name('korkon_telkom_validasi_revisi_lanjut_download');
    Route::post('/korkon_telkom/validasi/revisi_proposal_lanjut/validated', [KorkonTelkomController::class, 'korkon_telkom_validasi_revisi_lanjut_validated'])->name('korkon_telkom_validasi_revisi_lanjut_validated');

    Route::get('/korkon_telkom/verifikasi/penjadwalan_awal', [KorkonTelkomController::class, 'korkon_telkom_penjadwalan_awal'])->name('korkon_telkom_penjadwalan_awal');
    Route::post('/korkon_telkom/verifikasi/penjadwalan_awal/data', [KorkonTelkomController::class, 'korkon_telkom_penjadwalan_awal_data'])->name('korkon_telkom_penjadwalan_awal_data');

    Route::get('/korkon_telkom/verifikasi/penjadwalan_lanjut', [KorkonTelkomController::class, 'korkon_telkom_penjadwalan_lanjut'])->name('korkon_telkom_penjadwalan_lanjut');
    Route::post('/korkon_telkom/verifikasi/penjadwalan_lanjut/data', [KorkonTelkomController::class, 'korkon_telkom_penjadwalan_lanjut_data'])->name('korkon_telkom_penjadwalan_lanjut_data');
});
Route::group(['middleware' => ['permission:korkon_tek_kom']], function () {
    Route::get('/korkon_tek_kom/verifikasi/kolokium_awal', [KorkonTek_KomController::class, 'korkon_tek_kom_verif_kolokium_awal'])->name('korkon_tek_kom_verif_kolokium_awal');
    Route::get('/korkon_tek_kom/verifikasi/kolokium_awal_download/{user}', [KorkonTek_KomController::class, 'korkon_tek_kom_verif_kolokium_awal_download'])->name('korkon_tek_kom_verif_kolokium_awal_download');
    Route::post('/korkon_tek_kom/verifikasi/kolokium_awal/verified', [KorkonTek_KomController::class, 'korkon_tek_kom_verif_kolokium_awal_verified'])->name('korkon_tek_kom_verif_kolokium_awal_verified');
    Route::get('/korkon_tek_kom/validasi/revisi_proposal_awal', [KorkonTek_KomController::class, 'korkon_tek_kom_validasi_revisi_awal'])->name('korkon_tek_kom_validasi_revisi_awal');
    Route::post('/korkon_tek_kom/validasi/revisi_proposal_awal/download', [KorkonTek_KomController::class, 'korkon_tek_kom_validasi_revisi_awal_download'])->name('korkon_tek_kom_validasi_revisi_awal_download');
    Route::post('/korkon_tek_kom/validasi/revisi_proposal_awal/validated', [KorkonTek_KomController::class, 'korkon_tek_kom_validasi_revisi_awal_validated'])->name('korkon_tek_kom_validasi_revisi_awal_validated');

    Route::get('/korkon_tek_kom/verifikasi/kolokium_lanjut', [KorkonTek_KomController::class, 'korkon_tek_kom_verif_kolokium_lanjut'])->name('korkon_tek_kom_verif_kolokium_lanjut');
    Route::get('/korkon_tek_kom/verifikasi/kolokium_lanjut_download/{user}', [KorkonTek_KomController::class, 'korkon_tek_kom_verif_kolokium_lanjut_download'])->name('korkon_tek_kom_verif_kolokium_lanjut_download');
    Route::post('/korkon_tek_kom/verifikasi/kolokium_lanjut/verified', [KorkonTek_KomController::class, 'korkon_tek_kom_verif_kolokium_lanjut_verified'])->name('korkon_tek_kom_verif_kolokium_lanjut_verified');
    Route::get('/korkon_tek_kom/validasi/revisi_proposal_lanjut', [KorkonTek_KomController::class, 'korkon_tek_kom_validasi_revisi_lanjut'])->name('korkon_tek_kom_validasi_revisi_lanjut');
    Route::post('/korkon_tek_kom/validasi/revisi_proposal_lanjut/download', [KorkonTek_KomController::class, 'korkon_tek_kom_validasi_revisi_lanjut_download'])->name('korkon_tek_kom_validasi_revisi_lanjut_download');
    Route::post('/korkon_tek_kom/validasi/revisi_proposal_lanjut/validated', [KorkonTek_KomController::class, 'korkon_tek_kom_validasi_revisi_lanjut_validated'])->name('korkon_tek_kom_validasi_revisi_lanjut_validated');

    Route::get('/korkon_tek_kom/verifikasi/penjadwalan_awal', [KorkonTek_KomController::class, 'korkon_tek_kom_penjadwalan_awal'])->name('korkon_tek_kom_penjadwalan_awal');
    Route::post('/korkon_tek_kom/verifikasi/penjadwalan_awal/data', [KorkonTek_KomController::class, 'korkon_tek_kom_penjadwalan_awal_data'])->name('korkon_tek_kom_penjadwalan_awal_data');

    Route::get('/korkon_tek_kom/verifikasi/penjadwalan_lanjut', [KorkonTek_KomController::class, 'korkon_tek_kom_penjadwalan_lanjut'])->name('korkon_tek_kom_penjadwalan_lanjut');
    Route::post('/korkon_tek_kom/verifikasi/penjadwalan_lanjut/data', [KorkonTek_KomController::class, 'korkon_tek_kom_penjadwalan_lanjut_data'])->name('korkon_tek_kom_penjadwalan_lanjut_data');
});

Route::group(['middleware' => ['permission:adminTU']], function () {
    Route::get('/setting', [HomeController::class, 'setting'])->name('setting');
    Route::match(['get', 'post'], '/edit/{user}', [HomeController::class, 'edit'])->name('edit');
    Route::match(['get', 'post'], '/tambah_user', [AdminTUController::class, 'tambah_user'])->name('tambah_user');
    Route::post('/create', [AdminTUController::class, 'create'])->name('create');
    Route::get('/daftar_mahasiswa', [AdminTUController::class, 'daftar_mahasiswa'])->name('daftar_mahasiswa');
    Route::get('/daftar_dosen', [AdminTUController::class, 'daftar_dosen'])->name('daftar_dosen');

    Route::get('/tambah_permissions', [AdminTUController::class, 'tambah_permissions'])->name('tambah_permissions');
    Route::post('/tambah_permission/apply', [AdminTUController::class, 'apply_permission'])->name('apply_permission');
    Route::post('/tambah_permission/delete', [AdminTUController::class, 'delete_permission'])->name('delete_permission');

    Route::match(['get', 'post'], '/daftar/delete_mhs/{user}', [AdminTUController::class, 'destroy_mhs'])->name('daftar_destroy_mhs');
    Route::match(['get', 'post'], '/daftar/delete_dsn/{user}', [AdminTUController::class, 'destroy_dsn'])->name('daftar_destroy_dsn');
    Route::match(['get', 'post'], '/daftar/update_mhs/{user}', [AdminTUController::class, 'update_mhs'])->name('daftar_update_mhs');
    Route::match(['get', 'post'], '/daftar/update_dsn/{user}', [AdminTUController::class, 'update_dsn'])->name('daftar_update_dsn');

    Route::get('/verifikasi/pengajuan_review', [AdminTUController::class, 'verif_pengajuan_review'])->name('verif_pengajuan_review');
    Route::get('/verifikasi/pengajuan_review_download/{user}', [AdminTUController::class, 'verif_pengajuan_review_download'])->name('download_berkas_review');
    Route::match(['get', 'post'], '/verifikasi/pengajuan_review/verified/{user}', [AdminTUController::class, 'verif_pengajuan_review_verified'])->name('verif_pengajuan_review_verified');

    Route::get('/verifikasi/pengajuan_nilai_publikasi', [AdminTUController::class, 'verif_pengajuan_nilai_publikasi'])->name('verif_pengajuan_nilai_publikasi');
    Route::get('/verifikasi/pengajuan_nilai_publikasi_download/{user}', [AdminTUController::class, 'verif_pengajuan_nilai_publikasi_download'])->name('download_berkas_nilai_publikasi');
    Route::match(['get', 'post'], '/verifikasi/pengajuan_nilai_publikasi/verified/{user}', [AdminTUController::class, 'verif_pengajuan_nilai_publikasi_verified'])->name('verif_pengajuan_nilai_publikasi_verified');
    Route::get('/daftar_mahasiswa/cetak', [AdminTUController::class, 'daftar_mahasiswa_cetak'])->name('daftar_mahasiswa_cetak');
});
