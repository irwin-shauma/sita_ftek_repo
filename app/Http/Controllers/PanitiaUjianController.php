<?php

namespace App\Http\Controllers;

use App\Http\Requests\PenugasanRequest;
use App\Http\Requests\ValidasiRekapNilaiRequest;

use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\Reviewer;
use App\Models\Pengajuan_review;
use App\Models\Nilai_bimbingan_ta;
use App\Models\Nilai_kolokium_lanjut;
use App\Models\Nilai_review_paper;
use App\Models\Rekap_nilai_ta;

use App\Models\Pengajuan_publikasi;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PanitiaUjianController extends Controller
{
    //----------------------------------------------------------------------
    // Fungsi untuk permission Panitia Ujian
    //----------------------------------------------------------------------
    public function penugasan_review()
    {
        $current = Carbon::now();
        $dosen = Dosen::all();
        $daftar_mhs_review = Pengajuan_review::where('check_admin', 1)
            ->where('check_panitia_ujian', 0)
            ->pluck('mhs_id');
        if ($daftar_mhs_review->count() != 0) {
            $daftar_mhs_review_array = $daftar_mhs_review->toArray();
        } else {
            $daftar_mhs_review_array = [];
        }
        $mhs = Mahasiswa::whereIN('id', $daftar_mhs_review_array)->get();
        return view('dosen.panitia_ujian.penugasan', compact('mhs', 'current'));
    }
    public function penugasan_review_action(PenugasanRequest $request)
    {
        $data = $request->validated();
        $update_mhs_review = Pengajuan_review::where('mhs_id', $data['id_mhs'])
            ->where('check_admin', 1)
            ->update(['check_panitia_ujian' => 1, 'date_panitia_ujian' => $data['penugasan_date']]);
        $mhs_dosen = Reviewer::where('mhs_id', $data['id_mhs'])
            ->where('jenis_review', 'kolokium_awal')
            ->get();
        $reviewer1_id = $mhs_dosen[0]->reviewer1_id;
        $reviewer2_id = $mhs_dosen[0]->reviewer2_id;
        $create_jenis_review = Reviewer::create([
            'mhs_id' => $data['id_mhs'],
            'reviewer1_id' => $reviewer1_id,
            'reviewer2_id' => $reviewer2_id,
            'jadwal' => $data['penugasan_date'],
            'jenis_review' => 'pengajuan_review',
        ]);
        return redirect()->back()->with('success', 'Berhasil menugaskan!');
    }

    public function verifikasi_rekap()
    {
        $current = Carbon::now();
        $get_mhs_id = Pengajuan_review::where('check_panitia_ujian', 1)->pluck('mhs_id');
        if ($get_mhs_id->count() != 0) {
            $get_mhs_id_array = $get_mhs_id->toArray();
        } else {
            $get_mhs_id_array = [];
        }
        $cek_mhs = Rekap_nilai_ta::whereIN('mhs_id', $get_mhs_id_array)->pluck('mhs_id');
        if ($cek_mhs->count() != 0) {
            $cek_mhs_array = $cek_mhs->toArray();
        } else {
            $cek_mhs_array = [];
        }

        $get_nilai_bimbingan = Nilai_bimbingan_ta::whereIN('mhs_id', $get_mhs_id_array)
            ->pluck('total_all');
        if ($get_nilai_bimbingan->count() != 0) {
            $get_nilai_bimbingan_array = $get_nilai_bimbingan->toArray();
        } else {
            $get_nilai_bimbingan_array = [];
        }

        $get_nilai_paper_reviewer1 = Nilai_review_paper::whereIN('mhs_id', $get_mhs_id_array)
            ->where('reviewer_ke', 1)
            ->pluck('total_all');
        if ($get_nilai_paper_reviewer1->count() != 0) {
            $get_nilai_paper_reviewer1_array = $get_nilai_paper_reviewer1->toArray();
        } else {
            $get_nilai_paper_reviewer1_array = [];
        }

        $get_nilai_paper_reviewer2 = Nilai_review_paper::whereIN('mhs_id', $get_mhs_id_array)
            ->where('reviewer_ke', 2)
            ->pluck('total_all');
        if ($get_nilai_paper_reviewer2->count() != 0) {
            $get_nilai_paper_reviewer2_array = $get_nilai_paper_reviewer2->toArray();
        } else {
            $get_nilai_paper_reviewer2_array = [];
        }

        $get_nilai_kolokium_lanjut_reviewer1 = Nilai_kolokium_lanjut::whereIN('mhs_id', $get_mhs_id_array)
            ->where('reviewer_ke', 1)
            ->pluck('total_all');
        if ($get_nilai_kolokium_lanjut_reviewer1->count() != 0) {
            $get_nilai_kolokium_lanjut_reviewer1_array = $get_nilai_kolokium_lanjut_reviewer1->toArray();
        } else {
            $get_nilai_kolokium_lanjut_reviewer1_array = [];
        }
        $get_nilai_kolokium_lanjut_reviewer2 = Nilai_kolokium_lanjut::whereIN('mhs_id', $get_mhs_id_array)
            ->where('reviewer_ke', 2)
            ->pluck('total_all');
        if ($get_nilai_kolokium_lanjut_reviewer2->count() != 0) {
            $get_nilai_kolokium_lanjut_reviewer2_array = $get_nilai_kolokium_lanjut_reviewer2->toArray();
        } else {
            $get_nilai_kolokium_lanjut_reviewer2_array = [];
        }
        foreach ($get_nilai_kolokium_lanjut_reviewer1_array as $key => $value) {
            $total_nilai_kolokium_lanjut[] = (($value + $get_nilai_kolokium_lanjut_reviewer2_array[$key]) / 2);
        }

        $get_mhs_data = Mahasiswa::whereIN('id', $get_mhs_id_array)
            ->whereNotIn('id', $cek_mhs_array)
            ->get();

        $pengali_nilai_bimbingan = 0.35;
        $pengali_nilai_penguji = 0.2;
        $pengali_nilai_kolokium_lanjut = 0.25;
        $counter = 0;

        foreach ($get_mhs_data as $key) {
            $hasil_nilai_bimbingan[] = $get_nilai_bimbingan_array[$counter] * $pengali_nilai_bimbingan;
            $hasil_nilai_penguji_1[] = $get_nilai_paper_reviewer1_array[$counter] * $pengali_nilai_penguji;
            $hasil_nilai_penguji_2[] = $get_nilai_paper_reviewer2_array[$counter] * $pengali_nilai_penguji;
            $hasil_nilai_kolokium_lanjut[] = $total_nilai_kolokium_lanjut[$counter] * $pengali_nilai_kolokium_lanjut;
            $total_all[] = ($hasil_nilai_bimbingan[$counter] + $hasil_nilai_penguji_1[$counter] + $hasil_nilai_penguji_2[$counter] + $hasil_nilai_kolokium_lanjut[$counter]);
            if ($total_all[$counter] >= 8.5) {
                $aksara[] = 'A';
            } else if (($total_all[$counter] < 8.5) && ($total_all[$counter] >= 8)) {
                $aksara[] = 'AB';
            } else if (($total_all[$counter] < 8) && ($total_all[$counter] >= 7.5)) {
                $aksara[] = 'B';
            } else if (($total_all[$counter] < 7.5) && ($total_all[$counter] >= 7)) {
                $aksara[] = 'BC';
            } else if (($total_all[$counter] < 7) && ($total_all[$counter] >= 6.5)) {
                $aksara[] = 'C';
            } else if (($total_all[$counter] < 6.5)) {
                $aksara[] = 'E';
            }
            $counter++;
        }

        return view('dosen.panitia_ujian.verifikasi_rekap', compact(
            'get_mhs_data',
            'current',
            'get_nilai_bimbingan_array',
            'get_nilai_paper_reviewer1_array',
            'get_nilai_paper_reviewer2_array',
            'total_nilai_kolokium_lanjut',
            'pengali_nilai_bimbingan',
            'pengali_nilai_penguji',
            'pengali_nilai_kolokium_lanjut',
            'hasil_nilai_bimbingan',
            'hasil_nilai_penguji_1',
            'hasil_nilai_penguji_2',
            'hasil_nilai_kolokium_lanjut',
            'total_all',
            'aksara',
        ));
    }

    public function verifikasi_rekap_action(ValidasiRekapNilaiRequest $request)
    {
        $current = Carbon::now();
        $validated = $request->validated();

        $data = [
            'mhs_id' => $validated['id_mhs'],
            'name' => $validated['name'],
            'nim' => $validated['nim'],
            'nilai_pembimbing' => $validated['hasil_nilai_bimbingan'],
            'nilai_reviewer1_paper' => $validated['hasil_nilai_penguji_1'],
            'nilai_reviewer2_paper' => $validated['hasil_nilai_penguji_2'],
            'nilai_kolokium_lanjut' => $validated['hasil_nilai_kolokium_lanjut'],
            'total_nilai_akhir' => $validated['total_all'],
            'total_aksara' => $validated['aksara'],
            'tanggal_penilaian' => $current->format('Y-m-d'),
        ];
        $input_data = Rekap_nilai_ta::create($data);
        $progress = Mahasiswa::where('id', $validated['id_mhs'])
            ->update(['progress' => 6]);
        return redirect()->back()->with('success', 'Berhasil memvalidasi/memverifikasi rekap nilai mahasiswa!');
    }

    public function verifikasi_rekap_publikasi()
    {
        $current = Carbon::now();
        $get_mhs_id = Pengajuan_publikasi::where('check_admin', 1)->pluck('mhs_id');
        if ($get_mhs_id->count() != 0) {
            $get_mhs_id_array = $get_mhs_id->toArray();
        } else {
            $get_mhs_id_array = [];
        }
        $cek_mhs = Rekap_nilai_ta::whereIN('mhs_id', $get_mhs_id_array)->pluck('mhs_id');
        if ($cek_mhs->count() != 0) {
            $cek_mhs_array = $cek_mhs->toArray();
        } else {
            $cek_mhs_array = [];
        }
        $get_mhs_data = Mahasiswa::whereIN('id', $get_mhs_id_array)
            ->whereNotIn('id', $cek_mhs_array)
            ->get();

        $total_all = 8.5;
        $aksara = 'A';
        return view('dosen.panitia_ujian.verifikasi_rekap_publikasi', compact(
            'get_mhs_data',
            'current',
            'total_all',
            'aksara',
        ));
    }

    public function verifikasi_rekap_publikasi_action(Request $request)
    {
        $current = Carbon::now();
        $validated = $request->all();
        $data = [
            'mhs_id' => $validated['id_mhs'],
            'name' => $validated['name'],
            'nim' => $validated['nim'],
            'nilai_pembimbing' => 0,
            'nilai_reviewer1_paper' => 0,
            'nilai_reviewer2_paper' => 0,
            'nilai_kolokium_lanjut' => 0,
            'total_nilai_akhir' => $validated['total_all'],
            'total_aksara' => $validated['aksara'],
            'tanggal_penilaian' => $current->format('Y-m-d'),
        ];
        $input_data = Rekap_nilai_ta::create($data);
        $progress = Mahasiswa::where('id', $validated['id_mhs'])
            ->update(['progress' => 6]);
        return redirect()->back()->with('success', 'Berhasil memvalidasi/memverifikasi rekap nilai mahasiswa!');
    }
}
