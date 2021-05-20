<?php

namespace App\Http\Controllers;

use App\Http\Requests\PenjadwalanAwalRequest;
use App\Http\Requests\PenjadwalanLanjutRequest;
use App\Http\Requests\VerifKolokiumAwalRequest;
use App\Http\Requests\VerifKolokiumLanjutRequest;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\Kolokium_awal;
use App\Models\Kolokium_lanjut;
use App\Models\NomorSurat;
use App\Models\Pembimbing;
use App\Models\Proposal_awal;
use App\Models\Proposal_lanjut;
use App\Models\Reviewer;
use Illuminate\Support\Facades\Storage;
use Madzipper;
use Carbon\Carbon;
use Terbilang;
use Illuminate\Http\Request;

class KorkonTelkomController extends Controller
{
    //----------------------------------------------------------------------
    // Fungsi untuk permission Korkon Telkom
    //----------------------------------------------------------------------
    public function korkon_telkom_verif_kolokium_awal()
    {
        $lists_id = Kolokium_awal::whereColumn('check_korkon', '<', 'check_mhs_send')
            ->where('tipe_korkon', 'korkon_telkom')
            ->pluck('id');
        if ($lists_id->count() != 0) {
            $lists_array = $lists_id->toArray();
            $lists = Mahasiswa::whereIN('id', $lists_array)->get();
        } else {
            return view('dosen.korkon_telkom.verif_kolokium_awal', compact(
                'lists',
                'kolokium_awal_status',
                'check_korkon',
                'check_mhs_send',
                'nama_field',
                'nama_only',
            ));
        }

        if ($lists->count() != 0) {
            $list_mhs = Mahasiswa::where('progress', 1)->pluck('id')->toArray();
            $kolokium_awal_status = Kolokium_awal::whereIN('mhs_id', $list_mhs)->select(
                'check_kartu_studi_tetap',
                'check_transkrip_nilai',
                'check_form_pengajuan_ta',
                'check_tagihan_pembayaran',
                'check_proposal_awal',
                'check_lembar_reviewer',
                'check_korkon',
                'check_mhs_send',
            )->orderBy('mhs_id', 'ASC')
                ->where('tipe_korkon', 'korkon_telkom')
                ->whereColumn('check_korkon', '<', 'check_mhs_send')
                ->get();
            $check_korkon = Kolokium_awal::whereIN('mhs_id', $list_mhs)->pluck('check_korkon')->toArray();
            $check_mhs_send = Kolokium_awal::whereIN('mhs_id', $list_mhs)->pluck('check_mhs_send')->toArray();
        }
        $nama_field = [
            'kartu_studi_tetap' => "check_kartu_studi_tetap",
            'transkrip_nilai' => "check_transkrip_nilai",
            'form_pengajuan_ta' => "check_form_pengajuan_ta",
            'tagihan_pembayaran' => "check_tagihan_pembayaran",
            'proposal_awal' => "check_proposal_awal",
            'lembar_reviewer' => "check_lembar_reviewer",
        ];
        $nama_only = [
            "Kartu Studi Tetap",
            "Transkrip Nilai",
            "Form Pengajuan Tugas Akhir",
            "Tagihan Pembayaran",
            "Proposal Awal",
            "Lembar Reviewer",
        ];
        return view('dosen.korkon_telkom.verif_kolokium_awal', compact(
            'lists',
            'kolokium_awal_status',
            'check_korkon',
            'check_mhs_send',
            'nama_field',
            'nama_only',
        ));
    }

    public function korkon_telkom_verif_kolokium_awal_download($id)
    {
        if (Storage::disk('local')->exists("PenyimpananData/$id/Kolokium_Awal/berkas")) {
            $files = storage_path("app/PenyimpananData/$id/Kolokium_Awal/berkas");
            $zip = Madzipper::make("storage/Berkas_Kolokium_Awal_$id.zip")->add($files)->close();
            return Storage::download("public/Berkas_Kolokium_Awal_$id.zip", "Berkas_Kolokium_Awal_$id.zip");
        } else
            return redirect()->back()->with('warning', 'Mahasiswa belum mengupload!');
    }

    public function korkon_telkom_verif_kolokium_awal_verified(VerifKolokiumAwalRequest $request)
    {
        // Fungsi dimana kol awal sudah diverifikasi
        $validated = $request->validated();
        // dd($validated);
        if ($validated['check_korkon'] < 1 || $validated['check_korkon'] == null) {
            $data = [
                'check_kartu_studi_tetap' => $validated['kartu_studi_tetap'],
                'check_transkrip_nilai' => $validated['transkrip_nilai'],
                'check_form_pengajuan_ta' => $validated['form_pengajuan_ta'],
                'check_tagihan_pembayaran' => $validated['tagihan_pembayaran'],
                'check_proposal_awal' => $validated['proposal_awal'],
                'check_lembar_reviewer' => $validated['lembar_reviewer'],
                // 'check_korkon' => 1,
            ];
            $data_kolokium = Kolokium_awal::where('mhs_id', $validated['id_mhs'])
                ->update($data);
        } else {
            $kolokium_awal_status = Kolokium_awal::where('mhs_id', $validated['id_mhs'])->select(
                'check_kartu_studi_tetap',
                'check_transkrip_nilai',
                'check_form_pengajuan_ta',
                'check_tagihan_pembayaran',
                'check_proposal_awal',
                'check_lembar_reviewer',
            )->orderByDesc('mhs_id')->get();
            $nama_field = [
                'kartu_studi_tetap' => "check_kartu_studi_tetap",
                'transkrip_nilai' => "check_transkrip_nilai",
                'form_pengajuan_ta' => "check_form_pengajuan_ta",
                'tagihan_pembayaran' => "check_tagihan_pembayaran",
                'proposal_awal' => "check_proposal_awal",
                'lembar_reviewer' => "check_lembar_reviewer",
            ];

            foreach ($nama_field as $key => $value) {
                if ($kolokium_awal_status[0]->$value != 1) {
                    $data_kolokium = Kolokium_awal::where('mhs_id', $validated['id_mhs'])
                        ->update([$value => $validated[$key]]);
                }
            }
        }
        $data_kolokium = Kolokium_awal::where('mhs_id', $validated['id_mhs'])
            ->increment('check_korkon');

        // $progress = Mahasiswa::where('nim', $id)
        //     ->update(['progress' => 2]);

        return redirect()->back()->with('success', 'Mahasiswa berhasil diverifikasi!');
    }


    public function korkon_telkom_validasi_revisi_awal()
    {
        //Untuk mengecek apakah ada proposal yang sudah direview reviewer.
        // Ini nanti tulis di notepad ya caranya!

        $mahasiswa_sesuai_korkon = Kolokium_awal::where('tipe_korkon', 'korkon_telkom')
            ->where('check_korkon', 2)
            ->pluck('mhs_id');
        if ($mahasiswa_sesuai_korkon->count() != 0) {
            $mahasiswa_sesuai_korkon_array = $mahasiswa_sesuai_korkon->toArray();
        } else {
            $mahasiswa_sesuai_korkon_array = [];
        }

        $list_mhs = Proposal_awal::whereIN('mhs_id', $mahasiswa_sesuai_korkon_array)
            ->where('check_mhs_send', 2)
            ->where('check_validasi_korkon', 0)
            ->where('review_check1', 1)
            ->where('review_check2', 1)
            ->get();
        $data_proposal_seen = Proposal_awal::whereIN('mhs_id', $mahasiswa_sesuai_korkon_array)
            ->where('check_mhs_send', 2)
            ->where('check_validasi_korkon', 0)
            ->where('review_check1', 1)
            ->where('review_check2', 1)
            ->get();

        if ($list_mhs->pluck('mhs_id')->count() != 0) {
            $list_mhs_id_array = $list_mhs->pluck('mhs_id')->unique()->toArray();
            $data_mhs = Mahasiswa::whereIN('id', $list_mhs_id_array)->get();
            $data_mhs_name = $data_mhs->pluck('name')->toArray();

            $data_review1 = Proposal_awal::whereIN('mhs_id', $list_mhs_id_array)
                ->where('sender', "Reviewer 1")
                ->get();
            if ($data_review1->count() == 0) {
                $data_review1 = 'kosong';
            }
            $data_review2 = Proposal_awal::whereIN('mhs_id', $list_mhs_id_array)
                ->where('sender', "Reviewer 2")
                ->get();
            if ($data_review2->count() == 0) {
                $data_review2 = 'kosong';
            }
        }
        return view('dosen.korkon_telkom.validasi_revisi_awal', compact('data_mhs', 'data_proposal_seen', 'data_review1', 'data_review2'));
    }

    public function korkon_telkom_validasi_revisi_awal_download(Request $request)
    {
        $data_all = $request->all();
        // dd($data_all, 'download');
        $id = $data_all['nim'];
        if ($data_all['action'] == 'mahasiswa') {
            $file = $data_all['file_proposal_mahasiswa'];
            if (Storage::disk('local')->exists("PenyimpananData/$id/Kolokium_Awal/Proposal/$file")) {
                return Storage::download("PenyimpananData/$id/Kolokium_Awal/Proposal/$file");
            }
        } elseif (($data_all['action'] == 'reviewer_1')) {
            $file = $data_all['file_proposal_reviewer1'];
            if (Storage::disk('local')->exists("PenyimpananData/$id/Kolokium_Awal/Proposal/Reviewer/$file")) {
                return Storage::download("PenyimpananData/$id/Kolokium_Awal/Proposal/Reviewer/$file");
            }
        } elseif (($data_all['action'] == 'reviewer_2')) {
            $file = $data_all['file_proposal_reviewer2'];
            if (Storage::disk('local')->exists("PenyimpananData/$id/Kolokium_Awal/Proposal/Reviewer/$file")) {
                return Storage::download("PenyimpananData/$id/Kolokium_Awal/Proposal/Reviewer/$file");
            }
        }
    }

    public function korkon_telkom_validasi_revisi_awal_validated(Request $request)
    {
        $data_all = $request->all();
        $data_proposal_seen = Proposal_awal::where('mhs_id', $data_all['id_mhs']) // Data ini yang nantinya akan dikirim ke validasi.
            ->where('acc1', 1)
            ->where('acc2', 1)
            ->where('check_mhs_send', 1)
            ->update(['check_validasi_korkon' => 1]);

        //Bikin nomor surat || Kalau nanti ada yang error, coba lihat backupan e 
        $nomor = NomorSurat::whereMonth("created_at", Carbon::now()->month) // Mengecek bulan
            ->whereYear("created_at", Carbon::now()->year) // Mengecek tahun
            ->count(); // Terus hitung sudah berapa nomor

        $nama = Mahasiswa::where('id', $data_all['id_mhs'])->get();
        $current_time = Carbon::now();
        $bulan_romawi = Terbilang::roman($current_time->month);
        // dd($nama);
        $buatnomor = NomorSurat::create([
            'name' => $nama[0]->name,
            'nim' => $nama[0]->nim,
            'nomor' => ($nomor + 1) . "/I.3/FTEK/" . $bulan_romawi . '/' . $current_time->year,
            'tanggal_awal' => $current_time->isoFormat('LL'),
            'tanggal_akhir' => $current_time->addMonths(9)->isoFormat('LL'),
        ]);
        $progress = Mahasiswa::where('id', $data_all['id_mhs'])
            ->update(['progress' => 2]);
        return redirect()->back()->with('success', 'Mahasiswa berhasil divalidasi!');
    }

    //------------------------------------------------------------------------------------------
    // Fungsi untuk kolokium lanjut (verif, penjadwalan dan validasi)
    //------------------------------------------------------------------------------------------
    public function korkon_telkom_verif_kolokium_lanjut()
    {
        $lists_id = Kolokium_lanjut::whereColumn('check_korkon', '<', 'check_mhs_send')
            ->where('tipe_korkon', 'korkon_telkom')
            ->pluck('id');
        if ($lists_id->count() != 0) {
            $lists_array = $lists_id->toArray();
            $lists = Mahasiswa::whereIN('id', $lists_array)->get();
        } else {
            return view('dosen.korkon_telkom.verif_kolokium_lanjut', compact(
                'lists',
                'kolokium_lanjut_status',
                'check_korkon',
                'check_mhs_send',
                'nama_field',
                'nama_only',
            ));
        }

        if ($lists->count() != 0) {
            $list_mhs = Mahasiswa::where('progress', 3)->pluck('id')->toArray();
            $kolokium_lanjut_status = Kolokium_lanjut::whereIN('mhs_id', $list_mhs)->select(
                'check_proposal_lanjut',
                'check_surat_tugas',
            )->orderBy('mhs_id', 'ASC')
                ->where('tipe_korkon', 'korkon_telkom')
                ->whereColumn('check_korkon', '<', 'check_mhs_send')
                ->get();
            $check_korkon = Kolokium_lanjut::whereIN('mhs_id', $list_mhs)->pluck('check_korkon')->toArray();
            $check_mhs_send = Kolokium_lanjut::whereIN('mhs_id', $list_mhs)->pluck('check_mhs_send')->toArray();
        }
        $nama_field = [
            'proposal_lanjut' => "check_proposal_lanjut",
            'surat_tugas' => "check_surat_tugas",
        ];
        $nama_only = [
            "Proposal Lanjut",
            "Surat Tugas",
        ];
        return view('dosen.korkon_telkom.verif_kolokium_lanjut', compact(
            'lists',
            'kolokium_lanjut_status',
            'check_korkon',
            'check_mhs_send',
            'nama_field',
            'nama_only',
        ));
    }

    public function korkon_telkom_verif_kolokium_lanjut_download($id)
    {
        if (Storage::disk('local')->exists("PenyimpananData/$id/Kolokium_Lanjut/berkas")) {
            $files = storage_path("app/PenyimpananData/$id/Kolokium_Lanjut/berkas");
            $zip = Madzipper::make("storage/Berkas_Kolokium_Lanjut_$id.zip")->add($files)->close();
            return Storage::download("public/Berkas_Kolokium_Lanjut_$id.zip", "Berkas_Kolokium_Lanjut_$id.zip");
        } else
            return redirect()->back()->with('warning', 'Mahasiswa belum mengupload!');
    }

    public function korkon_telkom_verif_kolokium_lanjut_verified(VerifKolokiumLanjutRequest $request)
    {
        //$id berisi nim mhs.
        $validated = $request->validated();
        if ($validated['check_korkon'] < 1 || $validated['check_korkon'] == null) {
            $data = [
                'check_proposal_lanjut' => $validated['proposal_lanjut'],
                'check_surat_tugas' => $validated['surat_tugas'],
            ];
            $data_kolokium = Kolokium_lanjut::where('mhs_id', $validated['id_mhs'])
                ->update($data);
        } else {
            $kolokium_lanjut_status = Kolokium_lanjut::where('mhs_id', $validated['id_mhs'])
                ->select(
                    'check_proposal_lanjut',
                    'check_surat_tugas',
                )->orderByDesc('mhs_id')->get();
            $nama_field = [
                'proposal_lanjut' => "check_proposal_lanjut",
                'surat_tugas' => "check_surat_tugas",
            ];

            foreach ($nama_field as $key => $value) {
                if ($kolokium_lanjut_status[0]->$value != 1) {
                    $data_kolokium = Kolokium_lanjut::where('mhs_id', $validated['id_mhs'])
                        ->update([$value => $validated[$key]]);
                }
            }
        }
        $data_kolokium = Kolokium_lanjut::where('mhs_id', $validated['id_mhs'])
            ->increment('check_korkon');
        // $progress = Mahasiswa::where('nim', $id)
        //     ->update(['progress' => 4]);

        return redirect()->back()->with('success', 'Mahasiwa berhasil diverifikasi');
    }

    public function korkon_telkom_validasi_revisi_lanjut()
    {
        $mahasiswa_sesuai_korkon = Kolokium_lanjut::where('tipe_korkon', 'korkon_telkom')
            ->where('check_korkon', 2)
            ->pluck('mhs_id');
        if ($mahasiswa_sesuai_korkon->count() != 0) {
            $mahasiswa_sesuai_korkon_array = $mahasiswa_sesuai_korkon->toArray();
        } else {
            $mahasiswa_sesuai_korkon_array = [];
        }
        $list_mhs = Proposal_lanjut::whereIN('mhs_id', $mahasiswa_sesuai_korkon_array)
            ->where('check_mhs_send', 1)
            ->where('check_validasi_korkon', 0)
            ->where('review_check1', 1)
            ->where('review_check2', 1)
            ->get();

        $data_proposal_seen = Proposal_lanjut::whereIN('mhs_id', $mahasiswa_sesuai_korkon_array)
            ->where('check_mhs_send', 1)
            ->where('check_validasi_korkon', 0)
            ->where('review_check1', 1)
            ->where('review_check2', 1)
            ->get();

        if ($list_mhs->pluck('mhs_id')->count() != 0) {
            $list_mhs_id_array = $list_mhs->pluck('mhs_id')->unique()->toArray();
            // dd($list_mhs_id_array);
            $data_mhs = Mahasiswa::whereIN('id', $list_mhs_id_array)->get();
            $data_mhs_name = $data_mhs->pluck('name')->toArray();

            // if ($list_mhs_check->count() != 0) {
            //     $data_proposal_seen = Proposal_lanjut::where('check_mhs_send', 1)
            //         ->where('check_validasi_korkon', 0)
            //         ->where('review_check1', 0)
            //         ->orWhere('review_acc1', 1)
            //         ->where('review_check2', 0)
            //         ->orWhere('review_acc2', 1)
            //         ->get();
            // }
            $data_review1 = Proposal_lanjut::whereIN('mhs_id', $list_mhs_id_array)
                ->where('sender', "Reviewer 1")
                ->get();
            if ($data_review1->count() == 0) {
                $data_review1 = 'kosong';
            }
            $data_review2 = Proposal_lanjut::whereIN('mhs_id', $list_mhs_id_array)
                ->where('sender', "Reviewer 2")
                ->get();
            if ($data_review2->count() == 0) {
                $data_review2 = 'kosong';
            }
        }
        return view('dosen.korkon_telkom.validasi_revisi_lanjut', compact('data_mhs', 'data_proposal_seen', 'data_review1', 'data_review2'));
    }

    public function korkon_telkom_validasi_revisi_lanjut_download(Request $request)
    {
        $data_all = $request->all();
        $id = $data_all['nim'];
        if ($data_all['action'] == 'mahasiswa') {
            $file = $data_all['file_proposal_mahasiswa'];
            if (Storage::disk('local')->exists("PenyimpananData/$id/Kolokium_Lanjut/Proposal/$file")) {
                return Storage::download("PenyimpananData/$id/Kolokium_Lanjut/Proposal/$file");
            }
        } elseif (($data_all['action'] == 'reviewer_1')) {
            $file = $data_all['file_proposal_reviewer1'];
            if (Storage::disk('local')->exists("PenyimpananData/$id/Kolokium_Lanjut/Proposal/Reviewer/$file")) {
                return Storage::download("PenyimpananData/$id/Kolokium_Lanjut/Proposal/Reviewer/$file");
            }
        } elseif (($data_all['action'] == 'reviewer_2')) {
            $file = $data_all['file_proposal_reviewer2'];
            if (Storage::disk('local')->exists("PenyimpananData/$id/Kolokium_Lanjut/Proposal/Reviewer/$file")) {
                return Storage::download("PenyimpananData/$id/Kolokium_Lanjut/Proposal/Reviewer/$file");
            }
        }
    }

    public function korkon_telkom_validasi_revisi_lanjut_validated(Request $request)
    {
        $data_all = $request->all();
        $data_proposal_seen = Proposal_lanjut::where('mhs_id', $data_all['id_mhs']) // Data ini yang nantinya akan dikirim ke validasi.
            ->where('acc1', 1)
            ->where('acc2', 1)
            ->where('check_mhs_send', 1)
            ->update(['check_validasi_korkon' => 1]);

        return redirect()->back()->with('success', 'Mahasiswa berhasil divalidasi!');
    }

    //-------------------------------------------------------------------------------------------------------------
    //Pendajwalan Maju Awal
    //-------------------------------------------------------------------------------------------------------------
    public function korkon_telkom_penjadwalan_awal()
    {
        $current = Carbon::now();
        $dosen = Dosen::all();
        // $id_reviewed = Reviewer::all()->pluck('mhs_id')->toArray();
        // $lists = Kolokium_awal::whereNotIn('mhs_id', $id_reviewed)
        $lists = Kolokium_awal::where('check_korkon', 1)
            ->where('tipe_korkon', 'korkon_telkom')
            ->where('check_kartu_studi_tetap', 1)
            ->where('check_transkrip_nilai', 1)
            ->where('check_form_pengajuan_ta', 1)
            ->where('check_tagihan_pembayaran', 1)
            ->where('check_proposal_awal', 1)
            ->where('check_lembar_reviewer', 1)
            ->pluck('mhs_id');
        if ($lists->count() != 0) {
            $list_mhs = $lists->toArray();
            $mhs = Mahasiswa::whereIN('id', $list_mhs)->get();
            $lists_dosen = Pembimbing::whereIn('mhs_id', $list_mhs)->get();
        }
        $nama = [
            'kartu_studi_tetap' => "Kartu Studi Tetap",
            'transkrip_nilai' => "Transkrip Nilai",
            'form_pengajuan_ta' => "Form Pengajuan Tugas Akhir",
            'tagihan_pembayaran' => "Tagihan Pembayaran",
            'proposal_awal' => "Proposal Awal",
            'lembar_reviewer' => "Lembar Reviewer",
        ];
        return view('dosen.korkon_telkom.penjadwalan_awal', compact('lists', 'nama', 'mhs', 'dosen', 'current', 'lists_dosen'));
    }

    public function korkon_telkom_penjadwalan_awal_data(PenjadwalanAwalRequest $request)
    {
        $current = Carbon::now();
        $validated = $request->validated();
        $mhs = Mahasiswa::where('id', $validated['id_mhs'])->get();
        $reviewer1 = Dosen::where('id', $validated['pilih_reviewer1'])->get();
        $reviewer2 = Dosen::where('id', $validated['pilih_reviewer2'])->get();
        $tambah = Kolokium_awal::where('mhs_id', $validated['id_mhs'])->update(['check_korkon' => 2]);
        $mhs[0]->dosen_review()->attach($reviewer1, ['jadwal' => $validated['penjadwalan'], 'reviewer2_id' => $reviewer2[0]->id, 'jenis_review' => 'kolokium_awal']);
        return redirect()->back()->with('success', 'Mahasiswa berhasil dijadwalkan');
    }

    //-------------------------------------------------------------------------------------------------------------
    //Pendajwalan Maju Lanjut
    //-------------------------------------------------------------------------------------------------------------
    public function korkon_telkom_penjadwalan_lanjut()
    {
        //Pertama, ambil id yang sudah penjadwalan kol_lanjut, kemudian selain id tsb, ambil datanya.
        // Bila udah, cek id tadi di kol_awal, apakah sudah upload berkas dan diverifikasi.
        $current = Carbon::now();
        $dosen = Dosen::all();
        $lists = Kolokium_lanjut::where('check_korkon', 1)
            ->where('tipe_korkon', 'korkon_telkom')
            ->where('check_proposal_lanjut', 1)
            ->where('check_surat_tugas', 1)
            ->pluck('mhs_id');
        if ($lists->count() != 0) {
            $list_mhs = $lists->toArray();
            $mhs = Mahasiswa::whereIN('id', $list_mhs)->get();
            $reviewer_data = Reviewer::where('jenis_review', 'kolokium_awal')
                ->whereIN('mhs_id', $list_mhs)
                ->select('mhs_id', 'reviewer1_id', 'reviewer2_id')
                ->get();
            foreach ($reviewer_data as $key) {
                $reviewer1[] = Dosen::where('id', $key->reviewer1_id)->value('name');
                $reviewer2[] = Dosen::where('id', $key->reviewer2_id)->value('name');
            }
        }
        $nama = [
            'proposal_lanjut' => "Proposal Lanjut",
            'surat_tugas' => "Surat Tugas",
        ];
        return view('dosen.korkon_telkom.penjadwalan_lanjut', compact('lists', 'nama', 'mhs', 'dosen', 'current', 'reviewer1', 'reviewer2'));
    }

    public function korkon_telkom_penjadwalan_lanjut_data(PenjadwalanLanjutRequest $request)
    {
        $current = Carbon::now();
        $validated = $request->validated();
        $mhs = Mahasiswa::where('id', $validated['id_mhs'])->get();
        $reviewer1 = Dosen::where('name', $validated['pilih_reviewer1'])->get();
        $reviewer2 = Dosen::where('name', $validated['pilih_reviewer2'])->get();
        $tambah = Kolokium_lanjut::where('mhs_id', $validated['id_mhs'])->update(['check_korkon' => 2]);

        $mhs[0]->dosen_review()->attach($reviewer1, ['jadwal' => $validated['penjadwalan'], 'reviewer2_id' => $reviewer2[0]->id, 'jenis_review' => 'kolokium_lanjut']);
        return redirect()->back()->with('success', 'Mahasiswa berhasil dijadwalkan');
    }
}
