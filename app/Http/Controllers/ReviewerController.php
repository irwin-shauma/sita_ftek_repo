<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReviewAwalRequest;
use App\Http\Requests\ReviewLanjutRequest;
use App\Http\Requests\ReviewPengajuanReviewRequest;
use App\Http\Requests\PenilaianKolokiumLanjutRequest;
use App\Http\Requests\PenilaianPaperReviewRequest;

use App\Models\Reviewer;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\Proposal_awal;
use App\Models\Proposal_lanjut;
use App\Models\Pengajuan_review;

use App\Models\Paper_review;
use App\Models\Nilai_kolokium_lanjut;
use App\Models\Nilai_review_paper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReviewerController extends Controller
{
    //----------------------------------------------------------------------
    // Fungsi untuk permission Reviewer
    //----------------------------------------------------------------------
    public function review_kolokium_awal()
    {
        $nomor = Auth::user()->id; //Dapat id user
        $dosen = Dosen::where('user_id', $nomor)->get();

        $daftar_mhs1 = Reviewer::where('reviewer1_id', $dosen[0]->id)->where('jenis_review', 'kolokium_awal')->pluck('mhs_id');
        $daftar_mhs2 = Reviewer::where('reviewer2_id', $dosen[0]->id)->where('jenis_review', 'kolokium_awal')->pluck('mhs_id');
        if ($daftar_mhs1->count() != 0 || $daftar_mhs2->count() != 0) {
            if ($daftar_mhs1->count() != 0) {
                $cond1 = 1;
                $daftar_mhs1 = $daftar_mhs1->toArray();
                $data_proposal1 = Proposal_awal::whereIN('mhs_id', $daftar_mhs1)
                    ->where('acc1', 1)
                    ->where('acc2', 1)
                    ->where('review_check1', 0)
                    ->where('check_mhs_send', 1)
                    ->where('check_validasi_korkon', 0)
                    ->get();
                // dd($data_proposal1);
                if ($data_proposal1->count() != 0) {
                    $data_proposal1_array = $data_proposal1->pluck('mhs_id')->toArray();
                    // dd($data_proposal1_array);
                    $data_mhs1 = Mahasiswa::whereIN('id', $data_proposal1_array)->get();
                    // dd($data_mhs1);
                }
            }
            if ($daftar_mhs2->count() != 0) {
                $cond2 = 1;
                $daftar_mhs2 = $daftar_mhs2->toArray();
                $data_proposal2 = Proposal_awal::whereIN('mhs_id', $daftar_mhs2)
                    ->where('acc1', 1)
                    ->where('acc2', 1)
                    ->where('review_check2', 0)
                    ->where('check_mhs_send', 1)
                    ->where('check_validasi_korkon', 0)
                    ->get();
                if ($data_proposal2->count() != 0) {
                    $data_proposal2_array = $data_proposal2->pluck('mhs_id')->toArray();
                    $data_mhs2 = Mahasiswa::whereIN('id', $data_proposal2_array)->get();
                }
            }
        } else {
            $cond1 = 2;
            $cond2 = 2;
        }
        return view('dosen.reviewer.review_kolokium_awal', compact('cond1', 'cond2', 'data_mhs1', 'data_mhs2', 'data_proposal1', 'data_proposal2'));
    }

    public function review_kolokium_awal_download(Request $request)
    {
        // dd($request->file_proposal);
        $file = $request->file_proposal;
        $id = $request->nim;
        if (Storage::disk('local')->exists("PenyimpananData/$id/Kolokium_Awal/Proposal/$file")) {
            return Storage::download("PenyimpananData/$id/Kolokium_Awal/Proposal/$file");
        }
    }

    public function review_kolokium_awal_action(ReviewAwalRequest $request)
    {
        $validated = $request->validated();
        $id = Auth::user()->id;
        $dsn = Dosen::where('user_id', $id)->get();
        $nomor_revisi = Proposal_awal::all()->pluck('nomor_revisi')->last();
        if ($validated['action'] === 'revisi') {

            if ($validated['reviewer_ke'] == 1) {
                $filename = "Proposal_Awal_" . $validated['nim'] . "_Revisi_" . $nomor_revisi . "_Reviewer_1." . $validated['file_revisi']->extension();
                $path = Storage::putFileAs("PenyimpananData/" . $validated['nim'] . "/Kolokium_Awal/Proposal/Reviewer", $validated['file_revisi'], $filename);
                $sender = "Reviewer 1";
                $review_check1 = 1;
                $review_check2 = 0;
            } else {
                $filename = "Proposal_Awal_" . $validated['nim'] . "_Revisi_" . $nomor_revisi . "_Reviewer_2." . $validated['file_revisi']->extension();
                $path = Storage::putFileAs("PenyimpananData/" . $validated['nim'] . "/Kolokium_Awal/Proposal/Reviewer", $validated['file_revisi'], $filename);
                $sender = "Reviewer 2";
                $review_check1 = 0;
                $review_check2 = 1;
            }
            $buat_data = Proposal_awal::create([
                'mhs_id' => $validated['id_mhs'],
                'nomor_revisi' => $nomor_revisi,
                'file_proposal' => $filename,
                'komentar' => $validated['komentar_reviewer'],
                'sender' => $sender,
                'review_check1' => $review_check1,
                'review_check2' => $review_check2,
            ]);
            if ($validated['reviewer_ke'] == 1) {
                $progress = Proposal_awal::where('file_proposal', $validated['file_proposal'])
                    ->increment('review_check1');
            } else {
                $progress = Proposal_awal::where('file_proposal', $validated['file_proposal'])
                    ->increment('review_check2');
            }
            return redirect()->back()->with('success', 'Proposal Awal Mahasiswa berhasil direvisi!');
        } elseif ($validated['action'] === 'setujui') {
            if ($validated['reviewer_ke'] == 1) {
                $progress = Proposal_awal::where('file_proposal', $validated['file_proposal'])
                    ->where('sender', $validated['name'])
                    ->increment('review_check1', 1, ['review_acc1' => 1]);
            } else {
                $progress = Proposal_awal::where('file_proposal', $validated['file_proposal'])
                    ->where('sender', $validated['name'])
                    ->increment('review_check2', 1, ['review_acc2' => 1]);
            }

            return redirect()->back()->with('success', 'Proposal Awal mahasiswa berhasil disetujui!');
        }
    }

    public function review_kolokium_lanjut()
    {
        $nomor = Auth::user()->id; //Dapat id user
        $dosen = Dosen::where('user_id', $nomor)->get();
        $daftar_mhs1 = Reviewer::where('reviewer1_id', $dosen[0]->id)->where('jenis_review', 'kolokium_lanjut')->pluck('mhs_id');
        $daftar_mhs2 = Reviewer::where('reviewer2_id', $dosen[0]->id)->where('jenis_review', 'kolokium_lanjut')->pluck('mhs_id');
        // dd('here');
        if ($daftar_mhs1->count() != 0 || $daftar_mhs2->count() != 0) {
            if ($daftar_mhs1->count() != 0) {
                $cond1 = 1;
                $daftar_mhs1 = $daftar_mhs1->toArray();
                $data_proposal1 = Proposal_lanjut::whereIN('mhs_id', $daftar_mhs1)
                    ->where('acc1', 1)
                    ->where('acc2', 1)
                    ->where('review_check1', 0)
                    ->where('check_mhs_send', 1)
                    ->where('check_validasi_korkon', 0)
                    ->get();
                if ($data_proposal1->count() != 0) {
                    $data_proposal1_array = $data_proposal1->pluck('mhs_id')->toArray();
                    $data_mhs1 = Mahasiswa::whereIN('id', $data_proposal1_array)->get();
                }
            }
            if ($daftar_mhs2->count() != 0) {
                $cond2 = 1;
                $daftar_mhs2 = $daftar_mhs2->toArray();
                $data_proposal2 = Proposal_lanjut::whereIN('mhs_id', $daftar_mhs2)
                    ->where('acc1', 1)
                    ->where('acc2', 1)
                    ->where('review_check2', 0)
                    ->where('check_mhs_send', 1)
                    ->where('check_validasi_korkon', 0)
                    ->get();
                if ($data_proposal2->count() != 0) {
                    $data_proposal2_array = $data_proposal2->pluck('mhs_id')->toArray();
                    // $data_mhs2 = Mahasiswa::whereIN('id', $daftar_mhs2)->get();
                    $data_mhs2 = Mahasiswa::whereIN('id', $data_proposal2_array)->get();
                }
            }
        } else {
            $cond1 = 2;
            $cond2 = 2;
        }
        return view('dosen.reviewer.review_kolokium_lanjut', compact('cond1', 'cond2', 'data_mhs1', 'data_mhs2', 'data_proposal1', 'data_proposal2'));
    }

    public function review_kolokium_lanjut_download(Request $request)
    {
        $file = $request->file_proposal;
        $id = $request->nim;
        if (Storage::disk('local')->exists("PenyimpananData/$id/Kolokium_Lanjut/Proposal/$file")) {
            return Storage::download("PenyimpananData/$id/Kolokium_Lanjut/Proposal/$file");
        }
    }

    public function review_kolokium_lanjut_action(ReviewLanjutRequest $request)
    {
        $validated = $request->validated();
        $id = Auth::user()->id;
        $dsn = Dosen::where('user_id', $id)->get();
        $nomor_revisi = Proposal_lanjut::all()->pluck('nomor_revisi')->last();
        if ($validated['action'] === 'revisi') {

            if ($validated['reviewer_ke'] == 1) {
                $filename = "Proposal_Lanjut_" . $validated['nim'] . "_Revisi_" . $nomor_revisi . "_Reviewer_1." . $validated['file_revisi']->extension();
                $path = Storage::putFileAs("PenyimpananData/" . $validated['nim'] . "/Kolokium_Lanjut/Proposal/Reviewer", $validated['file_revisi'], $filename);
                $sender = "Reviewer 1";
                $review_check1 = 1;
                $review_check2 = 0;
            } else {
                $filename = "Proposal_Lanjut_" . $validated['nim'] . "_Revisi_" . $nomor_revisi . "_Reviewer_2." . $validated['file_revisi']->extension();
                $path = Storage::putFileAs("PenyimpananData/" . $validated['nim'] . "/Kolokium_Lanjut/Proposal/Reviewer", $validated['file_revisi'], $filename);
                $sender = "Reviewer 2";
                $review_check1 = 0;
                $review_check2 = 1;
            }

            $buat_data = Proposal_lanjut::create([
                'mhs_id' => $validated['id_mhs'],
                'nomor_revisi' => $nomor_revisi,
                'file_proposal' => $filename,
                'komentar' => $validated['komentar_reviewer'],
                'sender' => $sender,
                'review_check1' => $review_check1,
                'review_check2' => $review_check2,
            ]);

            if ($validated['reviewer_ke'] == 1) {
                $progress = Proposal_lanjut::where('file_proposal', $validated['file_proposal'])
                    ->increment('review_check1');
            } else {
                $progress = Proposal_lanjut::where('file_proposal', $validated['file_proposal'])
                    ->increment('review_check2');
            }

            return redirect()->back()->with('success', 'Proposal Lanjut Mahasiswa berhasil direvisi!');
        } elseif ($validated['action'] === 'setujui') {
            if ($validated['reviewer_ke'] == 1) {
                $progress = Proposal_lanjut::where('file_proposal', $validated['file_proposal'])
                    ->where('sender', $validated['name'])
                    ->increment('review_check1', 1, ['review_acc1' => 1]);
            } else {
                $progress = Proposal_lanjut::where('file_proposal', $validated['file_proposal'])
                    ->where('sender', $validated['name'])
                    ->increment('review_check2', 1, ['review_acc2' => 1]);
            }

            return redirect()->back()->with('success', 'Proposal Lanjut mahasiswa berhasil disetujui!');
        }
    }

    public function review_pengajuan_review()
    {
        $nomor = Auth::user()->id;
        $dosen = Dosen::where('user_id', $nomor)->get();
        $daftar_mhs1 = Reviewer::where('reviewer1_id', $dosen[0]->id)->where('jenis_review', 'pengajuan_review')->pluck('mhs_id');
        $daftar_mhs2 = Reviewer::where('reviewer2_id', $dosen[0]->id)->where('jenis_review', 'pengajuan_review')->pluck('mhs_id');
        if ($daftar_mhs1->count() != 0 || $daftar_mhs2->count() != 0) {
            if ($daftar_mhs1->count() != 0) {
                $cond1 = 1;
                $daftar_mhs1 = $daftar_mhs1->toArray();
                $counter1 = Paper_review::where('check_mhs_send', 1)->get();
                $counter1_send = $counter1->count();
                if ($counter1_send == 1) {

                    $data_paper1 = Paper_review::whereIN('mhs_id', $daftar_mhs1)
                        ->where('acc1', 1)
                        ->where('acc2', 1)
                        ->where('review_check1', 0)
                        ->where('check_validasi_panitia_ujian', 0)
                        ->get();
                    if ($data_paper1->count() != 0) {
                        $data_mhs1 = Mahasiswa::whereIN('id', $daftar_mhs1)->get();
                    }
                }
            }
            if ($daftar_mhs2->count() != 0) {
                $cond2 = 1;
                $daftar_mhs2 = $daftar_mhs2->toArray();
                $counter2 = Paper_review::where('check_mhs_send', 1)->get();
                $counter2_send = $counter2->count();
                if ($counter2_send == 1) {
                    $data_paper2 = Paper_review::whereIN('mhs_id', $daftar_mhs2)
                        ->where('acc1', 1)
                        ->where('acc2', 1)
                        ->where('review_check2', 0)
                        ->where('check_validasi_panitia_ujian', 0)
                        ->get();
                    if ($data_paper2->count() != 0) {
                        $data_mhs2 = Mahasiswa::whereIN('id', $daftar_mhs2)->get();
                    }
                }
            }
        } else {
            $cond1 = 2;
            $cond2 = 2;
        }
        return view('dosen.reviewer.review_pengajuan_review', compact('cond1', 'cond2', 'data_mhs1', 'data_mhs2', 'data_paper1', 'data_paper2', 'dosen'));
    }

    public function review_pengajuan_review_download(Request $request)
    {
        $file = $request->file_paper;
        $id = $request->nim;
        if (Storage::disk('local')->exists("PenyimpananData/$id/Pengajuan_Review/Paper/$file")) {
            return Storage::download("PenyimpananData/$id/Pengajuan_Review/Paper/$file");
        }
    }

    public function review_pengajuan_review_action(ReviewPengajuanReviewRequest $request)
    {
        $current = Carbon::now();
        $validated = $request->validated();
        // dd($validated);
        $id = Auth::user()->id;
        $dsn = Dosen::where('user_id', $id)->get();
        $nomor_revisi = Paper_review::all()->pluck('nomor_revisi')->last();
        if ($validated['action'] === 'revisi') {
            // dd('revisi');
            if ($validated['reviewer_ke'] == 1) {
                $filename = "Pengajuan_Review_" . $validated['nim'] . "_Revisi_" . $nomor_revisi . "_Reviewer_1." . $validated['file_revisi']->extension();
                $path = Storage::putFileAs("PenyimpananData/" . $validated['nim'] . "/Pengajuan_Review/Paper/Reviewer", $validated['file_revisi'], $filename);
                $sender = "Reviewer 1";
                $review_check1 = 1;
                $review_check2 = 0;

                //Bagian Penilaian
                $cek_mhs = Nilai_review_paper::where('mhs_id', $validated['id_mhs'])->where('reviewer_ke', 1)->get();
            } else {
                $filename = "Pengajuan_Review_" . $validated['nim'] . "_Revisi_" . $nomor_revisi . "_Reviewer_2." . $validated['file_revisi']->extension();
                $path = Storage::putFileAs("PenyimpananData/" . $validated['nim'] . "/Pengajuan_Review/Paper/Reviewer", $validated['file_revisi'], $filename);
                $sender = "Reviewer 2";
                $review_check1 = 0;
                $review_check2 = 1;

                //Bagian Penilaian
                $cek_mhs = Nilai_review_paper::where('mhs_id', $validated['id_mhs'])->where('reviewer_ke', 2)->get();
            }

            $buat_data = Paper_review::create([
                'mhs_id' => $validated['id_mhs'],
                'nomor_revisi' => $nomor_revisi,
                'file_paper' => $filename,
                'komentar' => $validated['komentar_reviewer'],
                'sender' => $sender,
                'review_check1' => $review_check1,
                'review_check2' => $review_check2,
            ]);

            if ($cek_mhs->count() == 0) {
                Nilai_review_paper::create([
                    'mhs_id' => $validated['id_mhs'],
                    'name' => $validated['name'],
                    'nim' => $validated['nim'],
                    'reviewer_ke' => $validated['reviewer_ke'],
                    'reviewer_id' => $validated['id_dosen'],

                    'nilai_bobot_ta' => $validated['input_baris1'],
                    'nilai_novelty' => $validated['input_baris2'],
                    'nilai_metodologi' => $validated['input_baris3'],
                    'nilai_kelengkapan_analisis' => $validated['input_baris4'],
                    'nilai_daftar_pustaka' => $validated['input_baris5'],
                    'nilai_kaidah_penulisan' => $validated['input_baris6'],
                    'nilai_kesinambungan' => $validated['input_baris7'],
                    'nilai_template_ta' => $validated['input_baris8'],

                    'total_nilai_bobot_ta' => $validated['hasil_baris1'],
                    'total_nilai_novelty' => $validated['hasil_baris2'],
                    'total_nilai_metodologi' => $validated['hasil_baris3'],
                    'total_nilai_kelengkapan_analisis' => $validated['hasil_baris4'],
                    'total_nilai_daftar_pustaka' => $validated['hasil_baris5'],
                    'total_nilai_kaidah_penulisan' => $validated['hasil_baris6'],
                    'total_nilai_kesinambungan' => $validated['hasil_baris7'],
                    'total_nilai_template_ta' => $validated['hasil_baris8'],

                    'total_all' => $validated['total'],
                    'tanggal_penilaian' => $current->format('Y-m-d'),
                ]);
            }

            if ($validated['reviewer_ke'] == 1) {
                $progress = Paper_review::where('file_paper', $validated['file_paper'])
                    ->increment('review_check1');

                $cek_nilai_reviewer2 = Nilai_review_paper::where('mhs_id', $validated['id_mhs'])
                    ->where('reviewer_ke', 2)
                    ->get();
                if ($cek_nilai_reviewer2->count() != 0) {
                    $progress = Mahasiswa::where('id', $validated['id_mhs'])
                        ->update(['progress' => 5]);
                }
            } elseif ($validated['reviewer_ke'] == 2) {
                $progress = Paper_review::where('file_paper', $validated['file_paper'])
                    ->increment('review_check2');

                $cek_mhs = Nilai_review_paper::where('mhs_id', $validated['id_mhs'])
                    ->where('reviewer_ke', 1)
                    ->get();
                if ($cek_mhs->count() != 0) {
                    $progress = Mahasiswa::where('id', $validated['id_mhs'])
                        ->update(['progress' => 5]);
                }
            }

            return redirect()->back()->with('success', 'Paper Pengajuan Review mahasiswa berhasil direvisi dan dinilai!');
        } elseif ($validated['action'] === 'setujui') {
            // dd('setujui');
            if ($validated['reviewer_ke'] == 1) {
                $progress = Paper_review::where('file_paper', $validated['file_paper'])
                    ->where('sender', $validated['name'])
                    ->increment('review_check1', 1, ['review_acc1' => 1]);
                //Bagian Penilaian
                $cek_mhs = Nilai_review_paper::where('mhs_id', $validated['id_mhs'])->where('reviewer_ke', 1)->get();
            } else {
                $progress = Paper_review::where('file_paper', $validated['file_paper'])
                    ->where('sender', $validated['name'])
                    ->increment('review_check2', 1, ['review_acc2' => 1]);
                $cek_mhs = Nilai_review_paper::where('mhs_id', $validated['id_mhs'])->where('reviewer_ke', 2)->get();
            }

            if ($cek_mhs->count() == 0) {
                Nilai_review_paper::create([
                    'mhs_id' => $validated['id_mhs'],
                    'name' => $validated['name'],
                    'nim' => $validated['nim'],
                    'reviewer_ke' => $validated['reviewer_ke'],
                    'reviewer_id' => $validated['id_dosen'],

                    'nilai_bobot_ta' => $validated['input_baris12'],
                    'nilai_novelty' => $validated['input_baris22'],
                    'nilai_metodologi' => $validated['input_baris32'],
                    'nilai_kelengkapan_analisis' => $validated['input_baris42'],
                    'nilai_daftar_pustaka' => $validated['input_baris52'],
                    'nilai_kaidah_penulisan' => $validated['input_baris62'],
                    'nilai_kesinambungan' => $validated['input_baris72'],
                    'nilai_template_ta' => $validated['input_baris82'],

                    'total_nilai_bobot_ta' => $validated['hasil_baris12'],
                    'total_nilai_novelty' => $validated['hasil_baris22'],
                    'total_nilai_metodologi' => $validated['hasil_baris32'],
                    'total_nilai_kelengkapan_analisis' => $validated['hasil_baris42'],
                    'total_nilai_daftar_pustaka' => $validated['hasil_baris52'],
                    'total_nilai_kaidah_penulisan' => $validated['hasil_baris62'],
                    'total_nilai_kesinambungan' => $validated['hasil_baris72'],
                    'total_nilai_template_ta' => $validated['hasil_baris82'],

                    'total_all' => $validated['total2'],
                    'tanggal_penilaian' => $current->format('Y-m-d'),
                ]);
            }

            if ($validated['reviewer_ke'] == 1) {

                $cek_nilai_reviewer2 = Nilai_review_paper::where('mhs_id', $validated['id_mhs'])
                    ->where('reviewer_ke', 2)
                    ->get();
                if ($cek_nilai_reviewer2->count() != 0) {
                    $progress = Mahasiswa::where('id', $validated['id_mhs'])
                        ->update(['progress' => 5]);
                }
            } elseif ($validated['reviewer_ke'] == 2) {

                $cek_mhs = Nilai_review_paper::where('mhs_id', $validated['id_mhs'])
                    ->where('reviewer_ke', 1)
                    ->get();
                if ($cek_mhs->count() != 0) {
                    $progress = Mahasiswa::where('id', $validated['id_mhs'])
                        ->update(['progress' => 5]);
                }
            }

            return redirect()->back()->with('success', 'Paper Pengajuan Review mahasiswa berhasil disetujui dan dinilai!');
        }
    }

    public function penilaian_kolokium_lanjut()
    {
        $current = Carbon::now();
        $nomor = Auth::user()->id; //Dapat id user
        $dosen = Dosen::where('user_id', $nomor)->get();
        $id_dosen = Dosen::where('user_id', $nomor)->value('id');
        $data_id_all = Proposal_lanjut::where('check_validasi_korkon', 1)->pluck('mhs_id');
        if ($data_id_all->count() !== 0) {
            $data_id_all_array = $data_id_all->toArray();
        } else {
            $data_id_all_array = [];
        }

        $cek_mhs1 = Nilai_kolokium_lanjut::where('reviewer_ke', 1)->pluck('mhs_id');
        $cek_mhs2 = Nilai_kolokium_lanjut::where('reviewer_ke', 2)->pluck('mhs_id');
        if ($cek_mhs1 != 0 || $cek_mhs2 != 0) {
            $cek_mhs1_array = $cek_mhs1->toArray();
            $cek_mhs2_array = $cek_mhs2->toArray();
        } else {
            $cek_mhs1_array = [];
            $cek_mhs2_array = [];
        }
        $daftar_mhs1 = Reviewer::where('reviewer1_id', $dosen[0]->id)
            ->where('jenis_review', 'kolokium_lanjut')
            ->whereIN('mhs_id', $data_id_all_array)
            ->whereNotIn('mhs_id', $cek_mhs1_array)
            ->pluck('mhs_id');
        $daftar_mhs2 = Reviewer::where('reviewer2_id', $dosen[0]->id)
            ->where('jenis_review', 'kolokium_lanjut')
            ->whereIN('mhs_id', $data_id_all_array)
            ->whereNotIn('mhs_id', $cek_mhs2_array)
            ->pluck('mhs_id');

        if ($daftar_mhs1->count() != 0 || $daftar_mhs2->count() != 0) {

            if ($daftar_mhs1->count() != 0) {
                $cond1 = 1;
                $daftar_mhs1_array = $daftar_mhs1->toArray();
                $data_mhs1 = Mahasiswa::whereIN('id', $daftar_mhs1_array)->get();
            }
            if ($daftar_mhs2->count() != 0) {
                $cond2 = 1;
                $daftar_mhs2_array = $daftar_mhs2->toArray();
                $data_mhs2 = Mahasiswa::whereIN('id', $daftar_mhs2_array)->get();
            }
        } else {
            $cond1 = 2;
            $cond2 = 2;
        }

        return view('dosen.reviewer.penilaian_kolokium_lanjut', compact('cond1', 'cond2', 'data_mhs1', 'data_mhs2', 'id_dosen'));
    }

    public function penilaian_kolokium_lanjut_action(PenilaianKolokiumLanjutRequest $request)
    {
        $current = Carbon::now();
        $validated = $request->validated();
        if ($validated['reviewer_ke'] == 1) {
            $cek_mhs = Nilai_kolokium_lanjut::where('mhs_id', $validated['id_mhs'])->where('reviewer_ke', 1)->get();
        } elseif ($validated['reviewer_ke'] == 2) {
            $cek_mhs = Nilai_kolokium_lanjut::where('mhs_id', $validated['id_mhs'])->where('reviewer_ke', 2)->get();
        }


        if ($cek_mhs->count() == 0) {
            Nilai_kolokium_lanjut::create([
                'mhs_id' => $validated['id_mhs'],
                'reviewer_id' => $validated['id_dosen'],
                'reviewer_ke' => $validated['reviewer_ke'],
                'name' => $validated['name'],
                'nim' => $validated['nim'],

                'nilai_isi_materi' => $validated['input_baris1'],
                'nilai_presentasi' => $validated['input_baris2'],
                'nilai_penguasaan_materi' => $validated['input_baris3'],

                'total_isi_materi' => $validated['hasil_baris1'],
                'total_presentasi' => $validated['hasil_baris2'],
                'total_penguasaan_materi' => $validated['hasil_baris3'],
                'total_all' => $validated['total'],
                'tanggal_penilaian' => $current->format('Y-m-d'),
            ]);

            if ($validated['reviewer_ke'] == 2) {
                $cek_mhs = Nilai_kolokium_lanjut::where('mhs_id', $validated['id_mhs'])
                    ->where('reviewer_ke', 1)
                    ->get();
                if ($cek_mhs->count() != 0) {
                    $progress = Mahasiswa::where('id', $validated['id_mhs'])
                        ->update(['progress' => 4]);
                }
            } elseif ($validated['reviewer_ke'] == 1) {
                $cek_mhs = Nilai_kolokium_lanjut::where('mhs_id', $validated['id_mhs'])->where('reviewer_ke', 2)->get();
                if ($cek_mhs->count() != 0) {
                    $progress = Mahasiswa::where('id', $validated['id_mhs'])
                        ->update(['progress' => 4]);
                }
            }
            return redirect()->back()->with('success', 'Berhasil menilai kolokium lanjut mahasiswa!');
        } else {
            return redirect()->back()->with('warning', 'Penilaian Gagal!');
        }
    }

    public function penilaian_paper()
    {
        $nomor = Auth::user()->id;
        $dosen = Dosen::where('user_id', $nomor)->get();
        $id_dosen = Dosen::where('user_id', $nomor)->value('id');

        $data_id_all = Pengajuan_review::where('check_panitia_ujian', 1)->pluck('mhs_id');
        if ($data_id_all->count() !== 0) {
            $data_id_all_array = $data_id_all->toArray();
        } else {
            $data_id_all_array = [];
        }
        $cek_mhs1 =  Nilai_review_paper::where('reviewer_ke', 1)->pluck('mhs_id');
        $cek_mhs2 =  Nilai_review_paper::where('reviewer_ke', 2)->pluck('mhs_id');
        if ($cek_mhs1 != 0 || $cek_mhs2 != 0) {
            $cek_mhs1_array = $cek_mhs1->toArray();
            $cek_mhs2_array = $cek_mhs2->toArray();
        } else {
            $cek_mhs1_array = [];
            $cek_mhs2_array = [];
        }

        $daftar_mhs1 = Reviewer::where('reviewer1_id', $dosen[0]->id)
            ->where('jenis_review', 'pengajuan_review')
            ->whereIN('mhs_id', $data_id_all_array)
            ->whereNotIn('mhs_id', $cek_mhs1_array)
            ->pluck('mhs_id');
        $daftar_mhs2 = Reviewer::where('reviewer2_id', $dosen[0]->id)
            ->where('jenis_review', 'pengajuan_review')
            ->whereIN('mhs_id', $data_id_all_array)
            ->whereNotIn('mhs_id', $cek_mhs2_array)
            ->pluck('mhs_id');

        if ($daftar_mhs1->count() != 0 || $daftar_mhs2->count() != 0) {
            if ($daftar_mhs1->count() != 0) {
                $cond1 = 1;
                $daftar_mhs1_array = $daftar_mhs1->toArray();
                $data_mhs1 = Mahasiswa::whereIN('id', $daftar_mhs1_array)->get();
            }
            if ($daftar_mhs2->count() != 0) {
                $cond2 = 1;
                $daftar_mhs2_array = $daftar_mhs2->toArray();
                $data_mhs2 = Mahasiswa::whereIN('id', $daftar_mhs2_array)->get();
            }
        } else {
            $cond1 = 2;
            $cond2 = 2;
        }
        return view('dosen.reviewer.penilaian_paper', compact('cond1', 'cond2', 'data_mhs1', 'data_mhs2', 'id_dosen'));
    }

    public function penilaian_paper_action(PenilaianPaperReviewRequest $request)
    {
        $current = Carbon::now();
        $validated = $request->validated();
        if ($validated['reviewer_ke'] == 1) {
            $cek_mhs = Nilai_review_paper::where('mhs_id', $validated['id_mhs'])->where('reviewer_ke', 1)->get();
        } elseif ($validated['reviewer_ke'] == 2) {
            $cek_mhs = Nilai_review_paper::where('mhs_id', $validated['id_mhs'])->where('reviewer_ke', 2)->get();
        }

        if ($cek_mhs->count() == 0) {
            Nilai_review_paper::create([
                'mhs_id' => $validated['id_mhs'],
                'name' => $validated['name'],
                'nim' => $validated['nim'],
                'reviewer_ke' => $validated['reviewer_ke'],
                'reviewer_id' => $validated['id_dosen'],

                'nilai_bobot_ta' => $validated['input_baris1'],
                'nilai_novelty' => $validated['input_baris2'],
                'nilai_metodologi' => $validated['input_baris3'],
                'nilai_kelengkapan_analisis' => $validated['input_baris4'],
                'nilai_daftar_pustaka' => $validated['input_baris5'],
                'nilai_kaidah_penulisan' => $validated['input_baris6'],
                'nilai_kesinambungan' => $validated['input_baris7'],
                'nilai_template_ta' => $validated['input_baris8'],

                'total_nilai_bobot_ta' => $validated['hasil_baris1'],
                'total_nilai_novelty' => $validated['hasil_baris2'],
                'total_nilai_metodologi' => $validated['hasil_baris3'],
                'total_nilai_kelengkapan_analisis' => $validated['hasil_baris4'],
                'total_nilai_daftar_pustaka' => $validated['hasil_baris5'],
                'total_nilai_kaidah_penulisan' => $validated['hasil_baris6'],
                'total_nilai_kesinambungan' => $validated['hasil_baris7'],
                'total_nilai_template_ta' => $validated['hasil_baris8'],

                'total_all' => $validated['total'],
                'tanggal_penilaian' => $current->format('Y-m-d'),
            ]);

            if ($validated['reviewer_ke'] == 2) {
                $cek_mhs = Nilai_review_paper::where('mhs_id', $validated['id_mhs'])
                    ->where('reviewer_ke', 1)
                    ->get();
                if ($cek_mhs->count() != 0) {
                    $progress = Mahasiswa::where('id', $validated['id_mhs'])
                        ->update(['progress' => 5]);
                }
            } elseif ($validated['reviewer_ke'] == 1) {
                $cek_mhs = Nilai_review_paper::where('mhs_id', $validated['id_mhs'])
                    ->where('reviewer_ke', 2)
                    ->get();
                if ($cek_mhs->count() != 0) {
                    $progress = Mahasiswa::where('id', $validated['id_mhs'])
                        ->update(['progress' => 5]);
                }
            }
            return redirect()->back()->with('success', 'Berhasil menilai paper mahasiswa!');
        } else {
            return redirect()->back()->with('warning', 'Penilaian Gagal!');
        }
    }
}
