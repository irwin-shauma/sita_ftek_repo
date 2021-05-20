<?php

namespace App\Http\Controllers;

use App\Http\Requests\KolokiumAwalRequest;
use App\Http\Requests\KolokiumLanjutRequest;
use App\Http\Requests\PengajuanReviewRequest;
use App\Http\Requests\PengajuanPublikasiRequest;
use App\Http\Requests\PilihDosenRequest;
use App\Http\Requests\ProposalAwalRequest;
use App\Http\Requests\ProposalLanjutRequest;
use App\Models\User;
use App\Models\Kolokium_awal;
use App\Models\Kolokium_lanjut;
use App\Models\Pengajuan_review;
use App\Models\Pengajuan_publikasi;
use App\Models\Mahasiswa;
use App\Models\Dosen;
use App\Models\Pembimbing;
use App\Models\NomorSurat;
use App\Models\Proposal_awal;
use App\Models\Proposal_lanjut;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use PDF;
use Carbon\Carbon;
use Terbilang;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    // -----------------------------------------------------------------------------------------------
    // Bagian Pilih Pembimbing
    // -----------------------------------------------------------------------------------------------
    public function pilih_pembimbing()
    {
        $id = Auth::user()->id;
        $mhs = Mahasiswa::where('user_id', $id)->get();
        $progress = $mhs[0]->progress;

        $dosen = Dosen::all();
        if ($progress !== null) {
            $fetch_mhs = Mahasiswa::find($mhs[0]->id)->dosens()->get();
            // dd($fetch_mhs[0]->pivot->dosen1_id);

            $pembimbing[] = Dosen::where('id', $fetch_mhs[0]->pivot->dosen1_id)->value('name');
            $pembimbing[] = Dosen::where('id', $fetch_mhs[0]->pivot->dosen2_id)->value('name');
            // dd($pembimbing);
        }
        return view('mahasiswa.pilih_pembimbing', compact('dosen', 'progress', 'pembimbing'));
    }

    public function data_pembimbing(PilihDosenRequest $request)
    {
        $data = $request->validated();
        $id = Auth::user()->id;
        $mhs = Mahasiswa::where('user_id', $id)->get();
        $mhs = $mhs[0];

        $progress = Mahasiswa::where('id', $mhs->id)
            ->update(['progress' => 0]);

        $dsn = Dosen::where('id', $data['pilih_dosen1'])->get();
        // dd($dsn);
        $mhs->dosens()->attach($dsn, ['dosen2_id' => $data['pilih_dosen2']]);
        return redirect()->back()->with('success', 'Anda berhasil memilih pembimbing!');
    }

    // -----------------------------------------------------------------------------------------------



    // -----------------------------------------------------------------------------------------------
    // Bagian Kolokium Awal Proposal & Berkas
    // -----------------------------------------------------------------------------------------------

    // $cond jika 1, berarti mahasiswa belum upload proposal sama sekali
    // $cond jika 2, berarti mahasiswa sudah upload proposal, namun belum diverifikasi dosen 1 dan 2
    // $cond jika 3, berarti mahasiswa sudah upload revisi, amun belum diverifikasi dosen 1 dan 2
    // $cond jika 4, berarti mahasiswa udah upload revisi, sudah diverifikasi oleh dosen 1 dan 2. Tinggal kirim revisi lagi
    // $cond jika 5, berati proposal mahasiswa sudah di acc oleh dosen 1 dan dosen 2

    // $cond jika 6, berarti proposal mahasiswa sudah dicek oleh reviewer, dan bisa di upload revisinya
    // $cond jika 7, berarti mahasiswa sudah upload revisi hasil review, namun belum belum diverifikasi.
    // $cond jika 8, berarti mahasiswa udah upload revisi review, sudah diverifikasi oleh dosen 1 dan 2, tapi belum acc.
    // $cond jika 9, berarti revisi review proposal mahasiswa sudah diacc oleh dosen, dan bisa di upload.
    // $cond jika 10, berarti propsoal mahasiswa sudah diacc oleh reviewer dan bisa lanjut upload
    public function kolokium_awal_proposal()
    {
        $id = Auth::user()->id;
        $mhs = Mahasiswa::where('user_id', $id)->get();
        $data_proposal = Proposal_awal::where('mhs_id', $mhs[0]->id)->get();
        if ($data_proposal->count() === 0) {
            $cond = 1;
        } elseif ($data_proposal->count() === 1) {
            $cond = 2;
            $data_proposal_seen = Proposal_awal::where('mhs_id', $mhs[0]->id)
                ->whereIN('check1', [0, 1])
                ->whereIN('check2', [0, 1])
                ->where('sender', $mhs[0]->name)
                ->get();
            $data_proposal_seen_last = $data_proposal_seen->last();
            if ($data_proposal_seen_last->acc1 == 1 && $data_proposal_seen_last->acc2 == 1) {
                $cond = 5;
            }
        } elseif ($data_proposal->count() > 1) {
            $data_proposal_seen = Proposal_awal::where('mhs_id', $mhs[0]->id)
                ->whereIN('check1', [0, 1])
                ->whereIN('check2', [0, 1])
                ->where('sender', $mhs[0]->name)
                ->get();
            $data_proposal_seen_last = $data_proposal_seen->last();
            $review_check_count = Proposal_awal::where('mhs_id', $mhs[0]->id)
                ->where('review_check1', 1)
                ->orWhere('review_check2', 1)
                ->where('sender', $mhs[0]->name)
                ->get()->count();

            if ($review_check_count == 0) {
                if ($data_proposal_seen_last->check1 != 1 || $data_proposal_seen_last->check2 != 1)
                    $cond = 3;
                else {
                    $cond = 4;
                    if ($data_proposal_seen_last->acc1 == 1 && $data_proposal_seen_last->acc2 == 1) {
                        $cond = 5;
                    }
                }
            } else {
                if ($data_proposal_seen_last->review_acc1 == 1 && $data_proposal_seen_last->review_acc2 == 1) {
                    $cond = 10;
                    $data_proposal_seen_last->update(['check_mhs_send' => 1]);
                }
                if ($data_proposal_seen_last->review_check1 == 1 && $data_proposal_seen_last->review_check2 == 1) {
                    $cond = 6;
                } else if ($data_proposal_seen_last->check1 != 1 || $data_proposal_seen_last->check2 != 1)
                    $cond = 7;
                else {
                    $cond = 8;
                    if ($data_proposal_seen_last->acc1 == 1 && $data_proposal_seen_last->acc2 == 1) {
                        $cond = 9;
                        $data_proposal_seen_last->update(['check_mhs_send' => 1]);
                    }
                }
            }
        }
        return view('mahasiswa.kolokium_awal.proposal', compact('cond', 'data_proposal', 'data_proposal_seen_last'));
    }
    public function kolokium_awal_proposal_upload(ProposalAwalRequest $request)
    {
        $validated = $request->validated();
        // dd($validated);
        $id = Auth::user()->id;
        $mhs = Mahasiswa::where('user_id', $id)->get();
        $nomor_revisi = Proposal_awal::where('mhs_id', $mhs[0]->id)
            ->where('sender', $mhs[0]->name)
            ->count();
        $file = $validated['file_proposal'];
        if ($nomor_revisi === 0) {
            $filename = "Proposal_Awal_" . $mhs[0]->nim . "." . $file->extension();
        } else {
            $filename = "Proposal_Awal_" . $mhs[0]->nim . "_Revisi_" . $nomor_revisi . "." . $file->extension();
        }

        Proposal_awal::create([
            'mhs_id' => $mhs[0]->id,
            'nomor_revisi' => $nomor_revisi,
            'file_proposal' => $filename,
            'komentar' => $validated['komentar'],
            'sender' => $mhs[0]->name,
            'check1' => 0,
            'check2' => 0,
            'acc1' => 0,
            'acc2' => 0,
            'review_check1' => 0,
            'review_check2' => 0,
            'review_acc1' => 0,
            'review_acc2' => 0,
            'check_validasi_korkon' => 0,
            'check_mhs_send' => 0,
        ]);

        $path = Storage::putFileAs("PenyimpananData/" . $mhs[0]->nim . "/Kolokium_Awal/Proposal", $file, $filename);

        return redirect()->back()->with('success', 'Anda berhasil mengupload proposal kolokium awal!');
    }

    public function kolokium_awal_proposal_download(Request $request)
    {

        $id = Auth::user()->id;
        $mhs = Mahasiswa::where('user_id', $id)->get();
        $file = $request->file_proposal;
        $dosen_pembimbing = $request->sender;

        $nim = $mhs[0]->nim;
        if (Storage::disk('local')->exists("PenyimpananData/$nim/Kolokium_Awal/Proposal/$file")) {
            return Storage::download("PenyimpananData/$nim/Kolokium_Awal/Proposal/$file");
        } elseif ($dosen_pembimbing == 1) {
            return Storage::download("PenyimpananData/$nim/Kolokium_Awal/Proposal/Dosen1/$file");
        } elseif ($dosen_pembimbing == 2) {
            # code...
            return Storage::download("PenyimpananData/$nim/Kolokium_Awal/Proposal/Dosen2/$file");
        }
    }

    public function kolokium_awal_berkas()
    {
        $id = Auth::user()->id;
        $mhs = Mahasiswa::where('user_id', $id)->get();
        $progress = $mhs[0]->progress;

        $kolokium_awal_status = Kolokium_awal::where('mhs_id', $mhs[0]->id)->select(
            'check_kartu_studi_tetap',
            'check_transkrip_nilai',
            'check_form_pengajuan_ta',
            'check_tagihan_pembayaran',
            'check_proposal_awal',
            'check_lembar_reviewer',
            'check_korkon',
            'check_mhs_send',
        )->orderByDesc('mhs_id')->get();
        // dd($kolokium_awal_status[0]->check_mhs_send);

        $check_korkon = Kolokium_awal::where('mhs_id', $mhs[0]->id)->value('check_korkon');
        $check_nama = [
            'check_kartu_studi_tetap' => "Kartu Studi Tetap",
            'check_transkrip_nilai' => "Transkrip Nilai",
            'check_form_pengajuan_ta' => "Form Pengajuan Tugas Akhir",
            'check_tagihan_pembayaran' => "Tagihan Pembayaran",
            'check_proposal_awal' => "Proposal Awal",
            'check_lembar_reviewer' => "Lembar Reviewer",
        ];
        $nama_field = [
            'kartu_studi_tetap' => "check_kartu_studi_tetap",
            'transkrip_nilai' => "check_transkrip_nilai",
            'form_pengajuan_ta' => "check_form_pengajuan_ta",
            'tagihan_pembayaran' => "check_tagihan_pembayaran",
            'proposal_awal' => "check_proposal_awal",
            'lembar_reviewer' => "check_lembar_reviewer",
        ];
        // foreach ($nama_field as $key => $value) {
        //     // dd($value);
        //     // dd($kolokium_awal_status[0]->$value);
        //     // dd($check_nama[$value]);
        // }
        $nama_only = [
            "Kartu Studi Tetap",
            "Transkrip Nilai",
            "Form Pengajuan Tugas Akhir",
            "Tagihan Pembayaran",
            "Proposal Awal",
            "Lembar Reviewer",
        ];

        // dd($kolokim_awal_status);
        return view('mahasiswa.kolokium_awal.berkas', compact(
            'mhs',
            'progress',
            'kolokium_awal_status',
            'check_nama',
            'check_korkon',
            'nama_field',
            'nama_only'
        ));
    }

    public function kolokium_awal_berkas_upload(KolokiumAwalRequest $request)
    // public function kolokium_awal_berkas_upload(Request $request)
    {
        $validated = $request->validated();
        // dd($validated);
        // $id = Auth::user()->id;
        $mhs = Mahasiswa::where('user_id', $validated['id_mhs'])->get();
        // $nim_mhs = $mhs[0]->nim;
        $nim_mhs = $validated['nim_mhs'];


        if ($validated['check_korkon'] < 1 || $validated['check_korkon'] == null) {
            // Mengubah nama file dan simpan file.

            $file = $validated['kartu_studi_tetap'];
            $filename = "1. KST_" . $nim_mhs . "." . $file->extension();
            $path = Storage::putFileAs("PenyimpananData/$nim_mhs/Kolokium_Awal/berkas", $file, $filename);

            $file2 = $validated['transkrip_nilai'];
            $filename2 = "2. Transkrip_" . $nim_mhs . "." . $file2->extension();
            $path2 = Storage::putFileAs("PenyimpananData/$nim_mhs/Kolokium_Awal/berkas", $file2, $filename2);

            $file3 = $validated['form_pengajuan_ta'];
            $filename3 = "3. Form_Pengajuan_TA_" . $nim_mhs . "." . $file3->extension();
            $path3 = Storage::putFileAs("PenyimpananData/$nim_mhs/Kolokium_Awal/berkas", $file3, $filename3);

            $file4 = $validated['tagihan_pembayaran'];
            $filename4 = "4. Tagihan_Pembayaran_" . $nim_mhs . "." . $file4->extension();
            $path4 = Storage::putFileAs("PenyimpananData/$nim_mhs/Kolokium_Awal/berkas", $file4, $filename4);

            $file5 = $validated['proposal_awal'];
            $filename5 = "5. Proposal_Awal_" . $nim_mhs . "." . $file5->extension();
            $path5 = Storage::putFileAs("PenyimpananData/$nim_mhs/Kolokium_Awal/berkas", $file5, $filename5);

            $file6 = $validated['lembar_reviewer'];
            $filename6 = "6. Lembar_Reviewer_" . $nim_mhs . "." . $file6->extension();
            $path6 = Storage::putFileAs("PenyimpananData/$nim_mhs/Kolokium_Awal/berkas", $file6, $filename6);

            // // Yang ini disesuaiin sama yang ada di dtbase
            $data = [
                'kartu_studi_tetap' => $filename,
                'transkrip_nilai' => $filename2,
                'form_pengajuan_ta' => $filename3,
                'tagihan_pembayaran' => $filename4,
                'proposal_awal' => $filename5,
                'lembar_reviewer' => $filename6,
                'check_korkon' => 0,
                // 'progress' => 1,
            ];
            $id_kolokium_awal = Kolokium_awal::where('mhs_id', $validated['id_mhs'])->value('id');
            $data_kolokium = Kolokium_awal::where('id', $id_kolokium_awal)
                ->update($data);
            $progress = Mahasiswa::where('id', $validated['id_mhs'])
                ->update(['progress' => 1]);
        } else {
            # code...

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
            $nama_only = [
                "KST",
                "Transkrip",
                "Form_Pengajuan_TA",
                "Tagihan_Pembayaran",
                "Proposal_Awal",
                "Lembar_Reviewer",
            ];
            $counter = 1;
            foreach ($nama_field as $key => $value) {
                // dd($nama_only[$counter - 1]);
                if ($kolokium_awal_status[0]->$value != 1) {
                    $file = $validated[$key];
                    // $filename = "1. KST_" . $nim_mhs . "." . $file->extension();
                    $filename = $counter . ". " . $nama_only[$counter - 1] . "_" . $nim_mhs . "." . $file->extension();
                    // dd($filename);
                    $path = Storage::putFileAs("PenyimpananData/$nim_mhs/Kolokium_Awal/berkas", $file, $filename);
                    $data_kolokium = Kolokium_awal::where('mhs_id', $validated['id_mhs'])
                        ->update([$key => $filename]);
                }
                $counter++;
            }

            // // Antara taruh disini atau taruh didalam fornya. Ketoke luwih cocok didalam fornya deh.
            // $progress = Mahasiswa::where('id', $validated['id_mhs'])
            //     ->update(['progress' => 1]);
        }
        $data_kolokium = Kolokium_awal::where('mhs_id', $validated['id_mhs'])
            ->increment('check_mhs_send');

        return redirect()->route('home')->with('success', 'Anda berhasil mengupload berkas kolokium awal!');
    }
    // -----------------------------------------------------------------------------------------------------------


    // -----------------------------------------------------------------------------------------------
    // Bagian Kolokium Lanjut Proposal & Berkas
    // -----------------------------------------------------------------------------------------------

    // $cond == 1, artinya mahasiswa belum sama sekali upload proposal lanjut.
    // $cond == 2, artinya mahasiswa sudah mengupload proposal, namun belum diverifikasi oelh dosen 1 dan dosen 2

    public function kolokium_lanjut_proposal()
    {
        $id = Auth::user()->id;
        $mhs = Mahasiswa::where('user_id', $id)->get();
        $data_proposal = Proposal_lanjut::where('mhs_id', $mhs[0]->id)->get();
        // dd($data_proposal);
        if ($data_proposal->count() === 0) {
            $cond = 1;
        } elseif ($data_proposal->count() === 1) {
            $cond = 2;
            $data_proposal_seen = Proposal_lanjut::where('mhs_id', $mhs[0]->id)
                ->whereIN('check1', [0, 1])
                ->whereIN('check2', [0, 1])
                ->where('sender', $mhs[0]->name)
                ->get();
            $data_proposal_seen_last = $data_proposal_seen->last();
            // If dibawah ini untuk antisipasi jika ada mahasiswa yang sekali kirim prposal, langsung di acc dosen.
            if ($data_proposal_seen_last->acc1 == 1 && $data_proposal_seen_last->acc2 == 1) {
                $cond = 5;
            }
        } elseif ($data_proposal->count() > 1) {
            $data_proposal_seen = Proposal_lanjut::where('mhs_id', $mhs[0]->id)
                ->whereIN('check1', [0, 1])
                ->whereIN('check2', [0, 1])
                ->where('sender', $mhs[0]->name)
                ->get();
            $data_proposal_seen_last = $data_proposal_seen->last();
            $review_check_count = Proposal_lanjut::where('mhs_id', $mhs[0]->id)
                ->where('review_check1', 1)
                ->orWhere('review_check2', 1)
                ->where('sender', $mhs[0]->name)
                ->get()->count();

            if ($review_check_count == 0) {
                if ($data_proposal_seen_last->check1 != 1 || $data_proposal_seen_last->check2 != 1)
                    $cond = 3;
                else {
                    $cond = 4;
                    if ($data_proposal_seen_last->acc1 == 1 && $data_proposal_seen_last->acc2 == 1) {
                        $cond = 5;
                    }
                }
            } else {
                if ($data_proposal_seen_last->review_acc1 == 1 && $data_proposal_seen_last->review_acc2 == 1) {
                    $cond = 10;
                    $data_proposal_seen_last->update(['check_mhs_send' => 1]);
                }
                if ($data_proposal_seen_last->review_check1 == 1 && $data_proposal_seen_last->review_check2 == 1) {
                    $cond = 6;
                } else if ($data_proposal_seen_last->check1 != 1 || $data_proposal_seen_last->check2 != 1)
                    $cond = 7;
                else {
                    $cond = 8;
                    if ($data_proposal_seen_last->acc1 == 1 && $data_proposal_seen_last->acc2 == 1) {
                        $cond = 9;
                        $data_proposal_seen_last->update(['check_mhs_send' => 1]);
                    }
                }
            }
        }

        return view('mahasiswa.kolokium_lanjut.proposal', compact('cond', 'data_proposal', 'data_proposal_seen_last'));
    }
    public function kolokium_lanjut_proposal_upload(ProposalLanjutRequest $request)
    {
        $validated = $request->validated();
        // dd($validated);
        $id = Auth::user()->id;
        $mhs = Mahasiswa::where('user_id', $id)->get();
        $nomor_revisi = Proposal_lanjut::where('mhs_id', $mhs[0]->id)
            ->where('sender', $mhs[0]->name)
            ->count();
        $file = $validated['file_proposal'];
        if ($nomor_revisi === 0) {
            $filename = "Proposal_Lanjut_" . $mhs[0]->nim . "." . $file->extension();
        } else {
            $filename = "Proposal_Lanjut_" . $mhs[0]->nim . "_Revisi_" . $nomor_revisi . "." . $file->extension();
        }

        Proposal_lanjut::create([
            'mhs_id' => $mhs[0]->id,
            'nomor_revisi' => $nomor_revisi,
            'file_proposal' => $filename,
            'komentar' => $validated['komentar'],
            'sender' => $mhs[0]->name,
            'check1' => 0,
            'check2' => 0,
            'acc1' => 0,
            'acc2' => 0,
            'review_check1' => 0,
            'review_check2' => 0,
            'review_acc1' => 0,
            'review_acc2' => 0,
            'check_validasi_korkon' => 0,
            'check_mhs_send' => 0,
        ]);

        $path = Storage::putFileAs("PenyimpananData/" . $mhs[0]->nim . "/Kolokium_Lanjut/Proposal", $file, $filename);

        return redirect()->back()->with('success', 'Anda berhasil mengupload proposal kolokium lanjut!');
    }

    public function kolokium_lanjut_proposal_download(Request $request)
    {
        $id = Auth::user()->id;
        $mhs = Mahasiswa::where('user_id', $id)->get();
        $file = $request->file_proposal;
        $dosen_pembimbing = $request->sender;

        $nim = $mhs[0]->nim;
        if (Storage::disk('local')->exists("PenyimpananData/$nim/Kolokium_Lanjut/Proposal/$file")) {
            return Storage::download("PenyimpananData/$nim/Kolokium_Lanjut/Proposal/$file");
        } elseif ($dosen_pembimbing == 1) {
            return Storage::download("PenyimpananData/$nim/Kolokium_Lanjut/Proposal/Dosen1/$file");
        } elseif ($dosen_pembimbing == 2) {
            return Storage::download("PenyimpananData/$nim/Kolokium_Lanjut/Proposal/Dosen2/$file");
        }
    }

    public function kolokium_lanjut_berkas()
    {
        $id = Auth::user()->id;
        $mhs = Mahasiswa::where('user_id', $id)->get();
        $progress = $mhs[0]->progress;

        $kolokium_lanjut_status = Kolokium_lanjut::where('mhs_id', $mhs[0]->id)->select(
            'check_proposal_lanjut',
            'check_surat_tugas',
        )->orderByDesc('mhs_id')->get();

        $check_korkon = Kolokium_awal::where('mhs_id', $mhs[0]->id)->value('check_korkon');
        $kolokium_lanjut_status = Kolokium_lanjut::where('mhs_id', $mhs[0]->id)->select(
            'check_proposal_lanjut',
            'check_',

        )->orderByDesc('mhs_id')->get();
        // dd($kolokium_awal_status[0]->check_mhs_send);


        $check_nama = [
            'check_kartu_studi_tetap' => "Kartu Studi Tetap",
            'check_transkrip_nilai' => "Transkrip Nilai",
            'check_form_pengajuan_ta' => "Form Pengajuan Tugas Akhir",
            'check_tagihan_pembayaran' => "Tagihan Pembayaran",
            'check_proposal_awal' => "Proposal Awal",
            'check_lembar_reviewer' => "Lembar Reviewer",
        ];
        $nama_field = [
            'kartu_studi_tetap' => "check_kartu_studi_tetap",
            'transkrip_nilai' => "check_transkrip_nilai",
            'form_pengajuan_ta' => "check_form_pengajuan_ta",
            'tagihan_pembayaran' => "check_tagihan_pembayaran",
            'proposal_awal' => "check_proposal_awal",
            'lembar_reviewer' => "check_lembar_reviewer",
        ];
        // foreach ($nama_field as $key => $value) {
        //     // dd($value);
        //     // dd($kolokium_awal_status[0]->$value);
        //     // dd($check_nama[$value]);
        // }
        $nama_only = [
            "Kartu Studi Tetap",
            "Transkrip Nilai",
            "Form Pengajuan Tugas Akhir",
            "Tagihan Pembayaran",
            "Proposal Awal",
            "Lembar Reviewer",
        ];



        $nama = [
            'check_proposal_lanjut' => "Proposal Lanjut",
            'check_surat_tugas' => "Surat Tugas",
        ];

        return view('mahasiswa.kolokium_lanjut.berkas', compact('progress', 'kolokium_lanjut_status', 'nama'));
    }

    public function kolokium_lanjut_berkas_upload(KolokiumLanjutRequest $request)
    {
        $validated = $request->validated();
        $id = Auth::user()->id;
        $mhs = Mahasiswa::where('user_id', $id)->get();
        $nim_mhs = $mhs[0]->nim;

        // Mengubah nama file dan simpan file.

        $file = $validated['proposal_lanjut'];
        $filename = "1. Proposal_lanjut_" . $nim_mhs . "." . $file->extension();
        $path = Storage::putFileAs("PenyimpananData/$nim_mhs/Kolokium_Lanjut", $file, $filename);

        $file2 = $validated['surat_tugas'];
        $filename2 = "2. Surat_Tugas_" . $nim_mhs . "." . $file2->extension();
        $path2 = Storage::putFileAs("PenyimpananData/$nim_mhs/Kolokium_Lanjut", $file2, $filename2);


        // // Yang ini disesuaiin sama yang ada di dtbase
        $data = [
            'proposal_lanjut' => $filename,
            'surat_tugas' => $filename2,
        ];

        $id_kolokium_lanjut = Kolokium_lanjut::where('mhs_id', $mhs[0]->id)->value('id');
        $data_kolokium = Kolokium_lanjut::where('id', $id_kolokium_lanjut)
            ->update($data);
        $progress = Mahasiswa::where('id', $mhs[0]->id)
            ->update(['progress' => 3]);

        return redirect()->route('home')->with('success', 'Anda berhasil mengupload berkas kolokium lanjut!');;
    }

    // -----------------------------------------------------------------------------------------


    // -----------------------------------------------------------------------------------------------
    // Bagian Pengajuan Review & Berkas
    // -----------------------------------------------------------------------------------------------

    public function pengajuan_review_paper()
    {
        return view('mahasiswa.pengajuan_review.paper');
    }
    public function pengajuan_review_paper_upload()
    {
        return redirect()->route('home')->with('success', 'Anda berhasil mengupload proposal kolokium awal!');
    }

    public function pengajuan_review_berkas()
    {
        $id = Auth::user()->id;
        $mhs = Mahasiswa::where('user_id', $id)->get();
        $progress = $mhs[0]->progress;

        $pengajuan_review_status = Pengajuan_review::where('mhs_id', $mhs[0]->id)->select(
            'check_makalah',
            'check_surat_tugas',
            'check_scan_ijazah',
            'check_transkrip_nilai',
            'check_tagihan_pembayaran',
            'check_transkrip_poin',
            'check_kartu_studi',
            'check_cek_plagiasi',
        )->orderByDesc('mhs_id')->get();

        $nama = [
            'check_makalah' => "Proposal Lanjut",
            'check_surat_tugas' => "Surat Tugas",
            'check_scan_ijazah' => "Scan Ijazah",
            'check_transkrip_nilai' => "Transkrip Nilai",
            'check_tagihan_pembayaran' => "Tagihan Pembayaran",
            'check_transkrip_poin' => "Transkrip Poin",
            'check_kartu_studi' => "Kartu Studi",
            'check_cek_plagiasi' => "Cek Plagiasi",

        ];

        return view('mahasiswa.pengajuan_review.berkas', compact('progress', 'pengajuan_review_status', 'nama'));
    }

    public function pengajuan_review_berkas_upload(PengajuanReviewRequest $request)
    {
        $validated = $request->validated();
        $id = Auth::user()->id;
        $mhs = Mahasiswa::where('user_id', $id)->get();
        $nim_mhs = $mhs[0]->nim;

        // Mengubah nama file dan simpan file.

        $file = $validated['makalah'];
        $filename = "1. Makalah_" . $nim_mhs . "." . $file->extension();
        $path1 = Storage::putFileAs("PenyimpananData/$nim_mhs/Pengajuan_Review", $file, $filename);

        $file2 = $validated['surat_tugas'];
        $filename2 = "2. Surat_Tugas_" . $nim_mhs . "." . $file2->extension();
        $path2 = Storage::putFileAs("PenyimpananData/$nim_mhs/Pengajuan_Review", $file2, $filename2);

        $file3 = $validated['scan_ijazah'];
        $filename3 = "3. Scan_Ijazah_" . $nim_mhs . "." . $file3->extension();
        $path3 = Storage::putFileAs("PenyimpananData/$nim_mhs/Pengajuan_Review", $file3, $filename3);

        $file4 = $validated['transkrip_nilai'];
        $filename4 = "4. Transkrip_Nilai_" . $nim_mhs . "." . $file4->extension();
        $path4 = Storage::putFileAs("PenyimpananData/$nim_mhs/Pengajuan_Review", $file4, $filename4);

        $file5 = $validated['tagihan_pembayaran'];
        $filename5 = "5. Tagihan_Pembayaran_" . $nim_mhs . "." . $file5->extension();
        $path5 = Storage::putFileAs("PenyimpananData/$nim_mhs/Pengajuan_Review", $file5, $filename5);

        $file6 = $validated['transkrip_poin'];
        $filename6 = "6. Transkrip_Poin_" . $nim_mhs . "." . $file6->extension();
        $path6 = Storage::putFileAs("PenyimpananData/$nim_mhs/Pengajuan_Review", $file6, $filename6);

        $file7 = $validated['kartu_studi'];
        $filename7 = "7. Kartu_Studi_" . $nim_mhs . "." . $file7->extension();
        $path7 = Storage::putFileAs("PenyimpananData/$nim_mhs/Pengajuan_Review", $file7, $filename7);

        $file8 = $validated['cek_plagiasi'];
        $filename8 = "8. Cek_Plagiasi_" . $nim_mhs . "." . $file8->extension();
        $path8 = Storage::putFileAs("PenyimpananData/$nim_mhs/Pengajuan_Review", $file8, $filename8);

        // // Yang ini disesuaiin sama yang ada di dtbase
        $data = [
            'makalah' => $filename,
            'surat_tugas' => $filename2,
            'scan_ijazah' => $filename3,
            'transkrip_nilai' => $filename4,
            'tagihan_pembayaran' => $filename5,
            'transkrip_poin' => $filename6,
            'kartu_studi' => $filename7,
            'cek_plagiasi' => $filename8,
        ];

        $id_pengajuan_review = Pengajuan_review::where('mhs_id', $mhs[0]->id)->value('id');
        $data_kolokium = Pengajuan_review::where('id', $id_pengajuan_review)
            ->update($data);
        $progress = Mahasiswa::where('id', $mhs[0]->id)
            ->update(['progress' => 5]);

        return redirect()->route('home')->with('success', 'Anda berhasil mengupload berkas pengajuan review!');;
    }

    // -----------------------------------------------------------------------------------------------


    // -----------------------------------------------------------------------------------------------
    // Bagian Pengajuan publikasi
    // -----------------------------------------------------------------------------------------------
    public function pengajuan_publikasi()
    {
        $id = Auth::user()->id;
        $mhs = Mahasiswa::where('user_id', $id)->get();
        $progress = $mhs[0]->progress;


        $pengajuan_publikasi_status = Pengajuan_publikasi::where('mhs_id', $mhs[0]->id)->select(
            'check_makalah',
            'check_letter_of_acceptance',
            'check_scan_ijazah',
            'check_transkrip_nilai',
            'check_tagihan_pembayaran',
            'check_transkrip_poin',
            'check_kartu_studi',
            'check_cek_plagiasi',
        )->orderByDesc('mhs_id')->get();

        $nama = [
            'check_makalah' => "Proposal Lanjut",
            'check_letter_of_acceptance' => "Letter of Acceptance",
            'check_scan_ijazah' => "Scan Ijazah",
            'check_transkrip_nilai' => "Transkrip Nilai",
            'check_tagihan_pembayaran' => "Tagihan Pembayaran",
            'check_transkrip_poin' => "Transkrip Poin",
            'check_kartu_studi' => "Kartu Studi",
            'check_cek_plagiasi' => "Cek Plagiasi",

        ];

        return view('mahasiswa.pengajuan_publikasi', compact('progress', 'pengajuan_publikasi_status', 'nama'));
    }

    public function pengajuan_publikasi_upload(PengajuanPublikasiRequest $request)
    {
        $validated = $request->validated();
        $id = Auth::user()->id;
        $mhs = Mahasiswa::where('user_id', $id)->get();
        $nim_mhs = $mhs[0]->nim;

        // Mengubah nama file dan simpan file.

        $file = $validated['makalah'];
        $filename = "1. Makalah_" . $nim_mhs . "." . $file->extension();
        $path1 = Storage::putFileAs("PenyimpananData/$nim_mhs/Pengajuan_Nilai_Publikasi", $file, $filename);

        $file2 = $validated['letter_of_acceptance'];
        $filename2 = "2. Letter_Of_Acceptance_" . $nim_mhs . "." . $file2->extension();
        $path2 = Storage::putFileAs("PenyimpananData/$nim_mhs/Pengajuan_Nilai_Publikasi", $file2, $filename2);

        $file3 = $validated['scan_ijazah'];
        $filename3 = "3. Scan_Ijazah_" . $nim_mhs . "." . $file3->extension();
        $path3 = Storage::putFileAs("PenyimpananData/$nim_mhs/Pengajuan_Nilai_Publikasi", $file3, $filename3);

        $file4 = $validated['transkrip_nilai'];
        $filename4 = "4. Transkrip_Nilai_" . $nim_mhs . "." . $file4->extension();
        $path4 = Storage::putFileAs("PenyimpananData/$nim_mhs/Pengajuan_Nilai_Publikasi", $file4, $filename4);

        $file5 = $validated['tagihan_pembayaran'];
        $filename5 = "5. Tagihan_Pembayaran_" . $nim_mhs . "." . $file5->extension();
        $path5 = Storage::putFileAs("PenyimpananData/$nim_mhs/Pengajuan_Nilai_Publikasi", $file5, $filename5);

        $file6 = $validated['transkrip_poin'];
        $filename6 = "6. Transkrip_Poin_" . $nim_mhs . "." . $file6->extension();
        $path6 = Storage::putFileAs("PenyimpananData/$nim_mhs/Pengajuan_Nilai_Publikasi", $file6, $filename6);

        $file7 = $validated['kartu_studi'];
        $filename7 = "7. Kartu_Studi_" . $nim_mhs . "." . $file7->extension();
        $path7 = Storage::putFileAs("PenyimpananData/$nim_mhs/Pengajuan_Nilai_Publikasi", $file7, $filename7);

        $file8 = $validated['cek_plagiasi'];
        $filename8 = "8. Cek_Plagiasi_" . $nim_mhs . "." . $file8->extension();
        $path8 = Storage::putFileAs("PenyimpananData/$nim_mhs/Pengajuan_Nilai_Publikasi", $file8, $filename8);

        // // Yang ini disesuaiin sama yang ada di dtbase
        $data = [
            'makalah' => $filename,
            'letter_of_acceptance' => $filename2,
            'scan_ijazah' => $filename3,
            'transkrip_nilai' => $filename4,
            'tagihan_pembayaran' => $filename5,
            'transkrip_poin' => $filename6,
            'kartu_studi' => $filename7,
            'cek_plagiasi' => $filename8,
            'check_mhs_send' => 1,
        ];

        $id_pengajuan_publikasi = Pengajuan_publikasi::where('mhs_id', $mhs[0]->id)->value('id');
        $data_kolokium = Pengajuan_publikasi::where('id', $id_pengajuan_publikasi)
            ->update($data);
        $progress = Mahasiswa::where('id', $mhs[0]->id)
            ->update(['progress' => 5]);
        return redirect()->route('home')->with('success', 'Anda berhasil mengupload berkas pengajuan niiali publikasi!');;
    }


    // ------------------------------------------------

    public function cetak_surat_tugas()
    {
        $permission_name = Permission::whereIn('name', ['kaprogdi_elektro', 'kaprogdi_tekkom'])->get();
        $permission_kaprogdi = DB::table('model_has_permissions')->whereIn('permission_id', [$permission_name[0]->id, $permission_name[1]->id])->get();

        $kaprogdi_elektro = User::where('id', $permission_kaprogdi[0]->model_id)->value('name'); // Langsung dapetin namenya
        $kaprogdi_tekkom = User::where('id', $permission_kaprogdi[1]->model_id)->value('name'); // Langsung dapetin namenya
        // dd($kaprogdi_elektro, $kaprogdi_tekkom);
        // Ambil 
        $id = Auth::user()->id;
        $mhs = Mahasiswa::where('user_id', $id)->get();
        $data_mhs = $mhs[0];

        $jenis_nim = Str::substr($data_mhs->nim, 0, 2);

        $pembimbing = Pembimbing::where('mhs_id', $data)->get();
        $dosen_get = Dosen::whereIn('id', [$pembimbing[0]->dosen1_id, $pembimbing[0]->dosen2_id])->get();
        $data_dosen = [];
        foreach ($dosen_get as $dosen) {
            $data_dosen[] = $dosen->name;
        }

        $nomor_surat = NomorSurat::where('name', $mhs[0]->name)->get();
        $data_nomor_surat = $nomor_surat[0];
        // $nomor_surat = $nomor_surat[0]->nomor;
        // $order = NomorSurat::create([
        //     'name' => 'Irwin',
        // ]);

        // dd($order);
        // dd($data_dosen);
        // return view('mahasiswa.cetak_surat_tugas', compact('data', 'data_dosen'));
        return view('mahasiswa.surat_tugas.cetak_surat', compact('data_mhs', 'data_dosen', 'data_nomor_surat', 'kaprogdi_elektro', 'kaprogdi_tekkom', 'jenis_nim'));
    }

    public function surat_tugas(Request $request)
    {
        $id = Auth::user()->id;
        $mhs = Mahasiswa::where('user_id', $id)->get();
        $data = $mhs[0];

        $jenis_nim = Str::substr($data->nim, 0, 2);
        $current = Carbon::now(); // Ini buat inisialisasi waktu
        $hasil =
            [
                'judul_skripsi' => $request->judul_skripsi,
                'spesifikasi_skripsi' => $request->spesifikasi_skripsi,
                'uraian_tugas_skripsi' => $request->uraian_tugas_skripsi,
                'jenis_skripsi' => $request->jenis_skripsi,
                'dosen_1' => $request->dosen_1,
                'dosen_2' => $request->dosen_2,
                'nomor_surat' => $request->nomor_surat,
                'kaprogdi' => $request->kaprogdi,

            ];

        // Ini untuk memisahkan tombol preview dan simpan.
        switch ($request->action) {
            case 'preview':
                $pdf = PDF::loadView('mahasiswa.surat_tugas.main', $hasil, compact('current', 'data', 'jenis_nim'))
                    ->setOption('enable-javascript', true)
                    ->setOption('margin-top', 45)
                    ->setOption('margin-left', 10)
                    ->setOption('header-html', view('mahasiswa.surat_tugas.header'))
                    ->setPaper('a4');
                return $pdf->inline('Surat_Tugas_' . $data->nim . '.pdf');
                break;

            case 'simpan':
                $update_judul = NomorSurat::where('nim', $data->nim)
                    ->update(['judul' => $request->judul_skripsi]);

                $pdf = PDF::loadView('mahasiswa.surat_tugas.main', $hasil, compact('current', 'data'))
                    ->setOption('enable-javascript', true)
                    ->setOption('margin-top', 45)
                    ->setOption('margin-left', 10)
                    ->setOption('header-html', view('mahasiswa.surat_tugas.header'))
                    ->setPaper('a4')
                    ->save(storage_path('app/PenyimpananData/SuratTugas/' . $data->nim . '.pdf'));


                return redirect()->route('home')->with('success', 'File surat tugas berhasil disimpan!');
                break;
        }
    }

    public function download_surat_tugas($id)
    {
        if (Storage::disk('local')->exists("PenyimpananData/SuratTugas/$id.pdf")) {
            return Storage::download("PenyimpananData/SuratTugas/$id.pdf");
        }
    }
}
