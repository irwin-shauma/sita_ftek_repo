<?php

namespace App\Http\Controllers;

use App\Http\Requests\BimbinganAwalRequest;
use App\Http\Requests\BimbinganLanjutRequest;
use App\Http\Requests\PenjadwalanAwalRequest;
use App\Http\Requests\ReviewAwalRequest;
use App\Http\Requests\VerifKolokiumAwalRequest;
use Illuminate\Http\Request;
use App\Models\Pembimbing;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\Kolokium_awal;
use App\Models\Kolokium_lanjut;
use App\Models\NomorSurat;
use App\Models\Proposal_awal;
use App\Models\Reviewer;
use App\Models\Proposal_lanjut;
use App\Models\Paper_review;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Madzipper;
use Carbon\Carbon;
use Illuminate\Auth\Events\Validated;
use Terbilang;

class DosenController extends Controller
{

    //----------------------------------------------------------------------
    // Fungsi untuk permission Dosen
    //----------------------------------------------------------------------
    public function daftar_bimbingan()
    {
        $nomor = Auth::user()->id; //Dapat id user dari dosen yang sedang login.
        //$dosen berisi id dosen yang sedang login.
        $dosen = Dosen::where('user_id', $nomor)->pluck('id');

        $pembimbing1 = Pembimbing::where('dosen1_id', $dosen)->get();
        foreach ($pembimbing1 as $data1) {
            $mhs1[] = Mahasiswa::where('id', $data1->mhs_id)->get();
        }
        $pembimbing2 = Pembimbing::where('dosen2_id', $dosen)->get();
        foreach ($pembimbing2 as $data2) {
            $mhs2[] = Mahasiswa::where('id', $data2->mhs_id)->get();
        }

        return view('dosen.daftar_bimbingan', compact('mhs1', 'mhs2'));
    }

    public function menu_bimbingan()
    {
        return view('dosen.menu_bimbingan');
    }

    // Fungsi untuk bimbingan kolokium awal, download, dan action.
    //----------------------------------------------------------------------
    public function bimbingan_kolokium_awal()
    {
        $nomor = Auth::user()->id; //Dapat id user
        $dosen = Dosen::where('user_id', $nomor)->get();

        //Ambil id mhs dari yang memilih sebagai dosen 1 (raw data dari pembimbing)
        $mhs_dosen1_id = Pembimbing::where('dosen1_id', $dosen[0]->id)->pluck('mhs_id');

        if ($mhs_dosen1_id->count() !== 0) {
            //Ambil data mhs dari tabel mahasiswa
            $mhs_dosen1_id = $mhs_dosen1_id->toArray();
            $mhs_dosen1_name = Mahasiswa::whereIN('id', $mhs_dosen1_id)->pluck('name')->toArray();
            // dd($mhs_dosen1_name);
            //Foreach data mhs yang dari tabel, kemudian dimasukkan ke array, sehingga array hanya berisi nama2 mhs
            //sesuai dengan dosen1 yg mereka pilih
            // foreach ($mhs_dosen1_name as $key => $value) {
            //     $list_mhs_dosen1[] = $value['name'];
            // }

            // Data proposal sesuai dosen 1  beserta dengan urutan mahasiswanya, pengirim, dan check nya.
            $data_proposal_dosen1 = Proposal_awal::whereIN('mhs_id', $mhs_dosen1_id)
                ->where('check1', 0)
                ->whereIN('sender', $mhs_dosen1_name)
                // ->whereIN('sender', $list_mhs_dosen1)
                ->orderBy('updated_at', 'asc')
                ->get();
            if ($data_proposal_dosen1->count() === 0) {
                $mhs_dosen1 = 'empty';
                $data_proposal_dosen1 = 'empty';
            } else {
                $data_proposal_dosen1_urutan = $data_proposal_dosen1->pluck('mhs_id')->toArray();
                //Data mahasiswa sesuai dosen 1
                $mhs_dosen1 = Mahasiswa::whereIN('id', $data_proposal_dosen1_urutan)->orderByRaw('FIELD(id, ' . implode(',', $data_proposal_dosen1_urutan) . ')')->get();
            }
        } else {
            $mhs_dosen1_id = 'empty';
            $mhs_dosen1 = 'empty';
            $data_proposal_dosen1 = 'empty';
        }

        //Ambil id mhs dari yang memilih sebagai dosen 2
        $mhs_dosen2_id = Pembimbing::where('dosen2_id', $dosen[0]->id)->pluck('mhs_id');

        if ($mhs_dosen2_id->count() !== 0) {

            $mhs_dosen2_id = $mhs_dosen2_id->toArray();

            //Ambil data mhs dari tabel mahasiswa
            $mhs_dosen2_name = Mahasiswa::whereIN('id', $mhs_dosen2_id)->get('name')->toArray();
            //Foreach data mhs yang dari tabel, kemudian dimasukkan ke array, sehingga array hanya berisi nama2 mhs
            //sesuai dengan dosen 2 yg mereka pilih
            // foreach ($mhs_dosen2_name as $key => $value) {
            //     $list_mhs_dosen2[] = $value['name'];
            // }
            // dd($list_mhs_dosen2);
            // Data proposal sesuai dosen 2 beserta dengan urutan mahasiswanya, pengirim, dan check nya.
            $data_proposal_dosen2 = Proposal_awal::whereIN('mhs_id', $mhs_dosen2_id)
                ->where('check2', 0)
                // ->whereIN('sender', $list_mhs_dosen2)
                ->whereIN('sender', $mhs_dosen2_name)
                ->orderBy('updated_at', 'asc')
                ->get();

            // If ini berguna jika ada mahasiswa yang milih sbg dosen 2, tapi proposal/revisinya udah dicek
            // dosen 1 dan dosen 2. 
            if ($data_proposal_dosen2->count() === 0) {
                $mhs_dosen2 = 'empty';
                $data_proposal_dosen2 = 'empty';
            } else {
                $data_proposal_dosen2_urutan = $data_proposal_dosen2->pluck('mhs_id')->toArray();
                //Data mahasiswa sesuai dosen 2
                $mhs_dosen2 = Mahasiswa::whereIN('id', $data_proposal_dosen2_urutan)->orderByRaw('FIELD(id, ' . implode(',', $data_proposal_dosen2_urutan) . ')')->get();
            }
        } else {
            $mhs_dosen2_id = 'empty';
            $mhs_dosen2 = 'empty';
            $data_proposal_dosen2 = 'empty';
        }
        return view('dosen.bimbingan_kolokium_awal', compact('mhs_dosen1', 'data_proposal_dosen1', 'mhs_dosen2', 'data_proposal_dosen2'));
    }

    public function bimbingan_kolokium_awal_download(Request $request)
    {
        $file = $request->file_proposal;
        $id = $request->nim;
        if (Storage::disk('local')->exists("PenyimpananData/$id/Kolokium_Awal/Proposal/$file")) {
            return Storage::download("PenyimpananData/$id/Kolokium_Awal/Proposal/$file");
        }
    }

    public function bimbingan_kolokium_awal_action(BimbinganAwalRequest $request)
    {
        $validated = $request->validated();
        $id = Auth::user()->id;
        $dsn = Dosen::where('user_id', $id)->get();
        $nomor_revisi = Proposal_awal::where('mhs_id', $validated['id_mhs'])
            ->where('sender', $validated['pembimbing_ke'])
            ->count();

        $nomor_revisi += 1;

        if ($validated['pembimbing_ke'] == 1) {

            $check1 = 1;
            $check2 = 0;
        } else {

            $check1 = 0;
            $check2 = 1;
        }

        if ($validated['action'] === 'revisi') {
            if ($validated['pembimbing_ke'] == 1) {
                $filename = "Proposal_Awal_" . $validated['nim'] . "_Revisi_" . $nomor_revisi . "_Pembimbing_1." . $validated['file_revisi']->extension();
            } else {
                $filename = "Proposal_Awal_" . $validated['nim'] . "_Revisi_" . $nomor_revisi . "_Pembimbing_2." . $validated['file_revisi']->extension();
            }
            $path = Storage::putFileAs("PenyimpananData/" . $validated['nim'] . "/Kolokium_Awal/Proposal/Dosen" . $validated['pembimbing_ke'], $validated['file_revisi'], $filename);
            Proposal_awal::create([
                'mhs_id' => $validated['id_mhs'],
                'nomor_revisi' => $nomor_revisi,
                'file_proposal' => $filename,
                'komentar' => $validated['komentar_pembimbing'],
                'sender' => $validated['pembimbing_ke'],
                'check1' => $check1,
                'check2' => $check2,
            ]);
            if ($validated['pembimbing_ke'] == 1) {
                $progress = Proposal_awal::where('file_proposal', $validated['file_proposal'])
                    ->increment('check1');
            } else {
                $progress = Proposal_awal::where('file_proposal', $validated['file_proposal'])
                    ->increment('check2');
            }

            return redirect()->back()->with('success', 'Proposal Awal Mahasiswa berhasil direvisi!');
        } elseif ($validated['action'] === 'setujui') {

            if ($validated['pembimbing_ke'] == 1) {
                $progress = Proposal_awal::where('file_proposal', $validated['file_proposal'])
                    ->where('sender', $validated['name_mhs'])
                    ->increment('check1', 1, ['acc1' => 1]);
            } else {
                $progress = Proposal_awal::where('file_proposal', $validated['file_proposal'])
                    ->where('sender', $validated['name_mhs'])
                    ->increment('check2', 1, ['acc2' => 1]);
            }

            return redirect()->back()->with('success', 'Proposal Awal mahasiswa berhasil disetujui!');
        }
    }


    // Fungsi untuk bimbingan kolokium lanjut, download, dan action.
    //----------------------------------------------------------------------
    public function bimbingan_kolokium_lanjut()
    {
        $nomor = Auth::user()->id;
        $dosen = Dosen::where('user_id', $nomor)->get();

        // Ambil id mhs dari yang memilih sebagai dosen 1 (raw data dari pembimbing)
        $mhs_dosen1_id = Pembimbing::where('dosen1_id', $dosen[0]->id)->pluck('mhs_id');
        if ($mhs_dosen1_id->count() !== 0) {
            $mhs_dosen1_id_array = $mhs_dosen1_id->toArray();
            $mhs_dosen1_name = Mahasiswa::whereIN('id', $mhs_dosen1_id)->pluck('name')->toArray();
            $data_proposal_dosen1 = Proposal_lanjut::whereIN('mhs_id', $mhs_dosen1_id_array)
                ->where('check1', 0)
                ->whereIN('sender', $mhs_dosen1_name)
                ->orderBy('updated_at', 'asc')
                ->get();
            if ($data_proposal_dosen1->count() !== 0) {
                $data_proposal_dosen1_array = $data_proposal_dosen1->pluck('mhs_id')->toArray();
                $mhs_dosen1 = Mahasiswa::whereIn('id', $data_proposal_dosen1_array)->orderByRaw('FIELD(id, ' . implode(',', $data_proposal_dosen1_array) . ')')->get();
            } else {
                $mhs_dosen1 = 'empty';
                $data_proposal_dosen1 = 'empty';
            }
        } else {
            $mhs_dosen1_id = 'empty';
            $mhs_dosen1 = 'empty';
            $data_proposal_dosen1 = 'empty';
        }

        $mhs_dosen2_id = Pembimbing::where('dosen2_id', $dosen[0]->id)->pluck('mhs_id');
        if ($mhs_dosen2_id->count() !== 0) {
            $mhs_dosen2_id_array = $mhs_dosen2_id->toArray();
            $mhs_dosen2_name = Mahasiswa::whereIN('id', $mhs_dosen2_id)->pluck('name')->toArray();
            $data_proposal_dosen2 = Proposal_lanjut::whereIN('mhs_id', $mhs_dosen2_id_array)
                ->where('check2', 0)
                ->whereIN('sender', $mhs_dosen2_name)
                ->orderBy('updated_at', 'asc')
                ->get();
            if ($data_proposal_dosen2->count() !== 0) {
                $data_proposal_dosen2_array = $data_proposal_dosen2->pluck('mhs_id')->toArray();
                $mhs_dosen2 = Mahasiswa::whereIn('id', $data_proposal_dosen2_array)->orderByRaw('FIELD(id, ' . implode(',', $data_proposal_dosen2_array) . ')')->get();
            } else {
                $mhs_dosen2 = 'empty';
                $data_proposal_dosen2 = 'empty';
            }
        } else {
            $mhs_dosen2_id = 'empty';
            $mhs_dosen2 = 'empty';
            $data_proposal_dosen2 = 'empty';
        }
        return view('dosen.bimbingan_kolokium_lanjut', compact('mhs_dosen1', 'data_proposal_dosen1', 'mhs_dosen2', 'data_proposal_dosen2'));
    }

    public function bimbingan_kolokium_lanjut_download(Request $request)
    {
        $data_all = $request->all();
        $file = $data_all['file_proposal'];
        $id = $data_all['nim'];

        if (Storage::disk('local')->exists("PenyimpananData/$id/Kolokium_Lanjut/Proposal/$file")) {
            return Storage::download("PenyimpananData/$id/Kolokium_Lanjut/Proposal/$file");
        }
    }
    public function bimbingan_kolokium_lanjut_action(BimbinganLanjutRequest $request)
    {
        $validated = $request->validated();
        $id = Auth::user()->id;
        $dsn = Dosen::where('user_id', $id)->get();
        $nomor_revisi = Proposal_lanjut::where('mhs_id', $validated['id_mhs'])
            ->where('sender', $validated['pembimbing_ke'])
            ->count();

        $nomor_revisi += 1;

        if ($validated['pembimbing_ke'] == 1) {

            $check1 = 1;
            $check2 = 0;
        } else {

            $check1 = 0;
            $check2 = 1;
        }

        if ($validated['action'] === 'revisi') {
            if ($validated['pembimbing_ke'] == 1) {
                $filename = "Proposal_Lanjut_" . $validated['nim'] . "_Revisi_" . $nomor_revisi . "_Pembimbing_1." . $validated['file_revisi']->extension();
            } else {
                $filename = "Proposal_Lanjut_" . $validated['nim'] . "_Revisi_" . $nomor_revisi . "_Pembimbing_2." . $validated['file_revisi']->extension();
            }
            $path = Storage::putFileAs("PenyimpananData/" . $validated['nim'] . "/Kolokium_Lanjut/Proposal/Dosen" . $validated['pembimbing_ke'], $validated['file_revisi'], $filename);
            Proposal_lanjut::create([
                'mhs_id' => $validated['id_mhs'],
                'nomor_revisi' => $nomor_revisi,
                'file_proposal' => $filename,
                'komentar' => $validated['komentar_pembimbing'],
                'sender' => $validated['pembimbing_ke'],
                'check1' => $check1,
                'check2' => $check2,
            ]);
            if ($validated['pembimbing_ke'] == 1) {
                $progress = Proposal_lanjut::where('file_proposal', $validated['file_proposal'])
                    ->increment('check1');
            } else {
                $progress = Proposal_lanjut::where('file_proposal', $validated['file_proposal'])
                    ->increment('check2');
            }

            return redirect()->back()->with('success', 'Proposal Lanjut Mahasiswa berhasil direvisi!');
        } elseif ($validated['action'] === 'setujui') {

            if ($validated['pembimbing_ke'] == 1) {
                $progress = Proposal_lanjut::where('file_proposal', $validated['file_proposal'])
                    ->where('sender', $validated['name_mhs'])
                    ->increment('check1', 1, ['acc1' => 1]);
            } else {
                $progress = Proposal_lanjut::where('file_proposal', $validated['file_proposal'])
                    ->where('sender', $validated['name_mhs'])
                    ->increment('check2', 1, ['acc2' => 1]);
            }
            return redirect()->back()->with('success', 'Proposal Awal mahasiswa berhasil disetujui!');
        }
        // return view('dosen.bimbingan_kolokium_lanjut');
    }


    // Fungsi untuk bimbingan pengajuan review, download, dan action.
    //----------------------------------------------------------------------
    public function bimbingan_pengajuan_review()
    {
        return view('dosen.bimbingan_pengajuan_review');
    }

    //----------------------------------------------------------------------
    // Fungsi untuk permission Korkon
    //----------------------------------------------------------------------
    public function verif_kolokium_awal()
    {
        $lists_id = Kolokium_awal::whereColumn('check_korkon', '<', 'check_mhs_send')->pluck('id');
        if ($lists_id->count() != 0) {
            $lists_array = $lists_id->toArray();
            $lists = Mahasiswa::whereIN('id', $lists_array)->get();
        }
        // $lists = Mahasiswa::where('progress', 1)->get();

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
                ->whereColumn('check_korkon', '<', 'check_mhs_send')
                ->get();
            $check_korkon = Kolokium_awal::whereIN('mhs_id', $list_mhs)->pluck('check_korkon')->toArray();
            $check_mhs_send = Kolokium_awal::whereIN('mhs_id', $list_mhs)->pluck('check_mhs_send')->toArray();
        }
        // Aku bisa pake ini buat verif yang udah sma yang belum
        // $nama = [
        //     'kartu_studi_tetap' => "Kartu Studi Tetap",
        //     'transkrip_nilai' => "Transkrip Nilai",
        //     'form_pengajuan_ta' => "Form Pengajuan Tugas Akhir",
        //     'tagihan_pembayaran' => "Tagihan Pembayaran",
        //     'proposal_awal' => "Proposal Awal",
        //     'lembar_reviewer' => "Lembar Reviewer",
        // ];
        // $check_nama = [
        //     'check_kartu_studi_tetap' => "Kartu Studi Tetap",
        //     'check_transkrip_nilai' => "Transkrip Nilai",
        //     'check_form_pengajuan_ta' => "Form Pengajuan Tugas Akhir",
        //     'check_tagihan_pembayaran' => "Tagihan Pembayaran",
        //     'check_proposal_awal' => "Proposal Awal",
        //     'check_lembar_reviewer' => "Lembar Reviewer",
        // ];
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
        return view('dosen.verif_kolokium_awal', compact(
            'lists',
            'kolokium_awal_status',
            'check_korkon',
            'check_mhs_send',
            'nama_field',
            'nama_only',
        ));
    }

    public function verif_kolokium_awal_verified(VerifKolokiumAwalRequest $request, $id)
    {
        // Fungsi dimana kol awal sudah diverifikasi
        $validated = $request->validated();
        if ($validated['check_korkon'] < 1 || $validated['check_korkon'] == null) {
            # code...
            dd("Masuk 1");
            $data = [
                'check_kartu_studi_tetap' => $request->kartu_studi_tetap,
                'check_transkrip_nilai' => $request->transkrip_nilai,
                'check_form_pengajuan_ta' => $request->form_pengajuan_ta,
                'check_tagihan_pembayaran' => $request->tagihan_pembayaran,
                'check_proposal_awal' => $request->proposal_awal,
                'check_lembar_reviewer' => $request->lembar_reviewer,
                'check_korkon' => 1,
            ];
            $nama = Mahasiswa::where('nim', $id)->get();
            //ambil id_kolokium awal, update data kolokium.
            $data_kolokium = Kolokium_awal::where('mhs_id', $nama[0]->id)
                ->update($data);

            // Dipindah ke fungsi validasi_revisi_awal_validated
            // $nomor = NomorSurat::whereMonth("created_at", Carbon::now()->month) // Mengecek bulan
            //     ->whereYear("created_at", Carbon::now()->year) // Mengecek tahun
            //     ->count(); // Terus hitung sudah berapa nomor

            // $current_time = Carbon::now();
            // $bulan_romawi = Terbilang::roman($current_time->month);

            // $buatnomor = NomorSurat::create([
            //     'name' => $nama[0]->name,
            //     'nim' => $nama[0]->nim,
            //     'nomor' => ($nomor + 1) . "/I.3/FTEK/" . $bulan_romawi . '/' . $current_time->year,
            // ]);

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
                # code...
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

    public function verif_kolokium_awal_download($id)
    {
        if (Storage::disk('local')->exists("PenyimpananData/$id/Kolokium_Awal/berkas")) {
            $files = storage_path("app/PenyimpananData/$id/Kolokium_Awal/berkas");
            $zip = Madzipper::make("storage/Berkas_kolokium_Awal_$id.zip")->add($files)->close();
            return Storage::download("public/Berkas_kolokium_Awal_$id.zip", "Berkas_kolokium_Awal_$id.zip");
        } else
            return redirect()->back()->with('warning', 'Mahasiswa belum mengupload!');
    }

    public function validasi_revisi_awal()
    {
        $list_mhs_id = Proposal_awal::where('check_mhs_send', 1)
            ->where('check_validasi_korkon', null)
            ->orWhere('check_validasi_korkon', 0)
            ->pluck('mhs_id');
        // dd($list_mhs_id);
        if ($list_mhs_id->count() != 0) {
            $list_mhs_id_array = $list_mhs_id->toArray();
            $data_mhs = Mahasiswa::whereIN('id', $list_mhs_id_array)->get();
            $data_mhs_name = $data_mhs->pluck('name')->toArray();

            $data_proposal_seen = Proposal_awal::whereIN('mhs_id', $list_mhs_id_array) // Data ini yang nantinya akan dikirim ke validasi.
                ->where('acc1', 1)
                ->where('acc2', 1)
                ->whereIN('sender', $data_mhs_name)
                ->where('check_mhs_send', 1)
                ->get();

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

        // $data_proposal = Proposal_awal::where('')
        return view('dosen.korkon.validasi_revisi_awal', compact('data_mhs', 'data_proposal_seen', 'data_review1', 'data_review2'));
    }

    public function validasi_revisi_awal_download(Request $request)
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

        // return view('dosen.korkon.validasi_revisi_awal');
    }

    public function validasi_revisi_awal_validated(Request $request)
    {
        $data_all = $request->all();
        $data_proposal_seen = Proposal_awal::where('mhs_id', $data_all['id_mhs']) // Data ini yang nantinya akan dikirim ke validasi.
            ->where('acc1', 1)
            ->where('acc2', 1)
            ->where('check_mhs_send', 1)
            // ->increment('check_validasi_korkon');
            ->update(['check_validasi_korkon' => 1]);

        //Bikin nomor surat || Kalau nanti ada yang error, coba lihat backupan e 
        $nomor = NomorSurat::whereMonth("created_at", Carbon::now()->month) // Mengecek bulan
            ->whereYear("created_at", Carbon::now()->year) // Mengecek tahun
            ->count(); // Terus hitung sudah berapa nomor

        $nama = Mahasiswa::where('nim', $data_all['id_mhs'])->get();
        $current_time = Carbon::now();
        $bulan_romawi = Terbilang::roman($current_time->month);

        $buatnomor = NomorSurat::create([
            'name' => $nama[0]->name,
            'nim' => $nama[0]->nim,
            'nomor' => ($nomor + 1) . "/I.3/FTEK/" . $bulan_romawi . '/' . $current_time->year,
        ]);
        // dd($data_proposal_seen);
        // $data_proposal_seen->update(['check_korkon', 1]);
        // dd($data_all, 'validasi');
        return redirect()->back()->with('success', 'Mahasiswa berhasil divalidasi!');
    }



    //------------------------------------------------------------------------------------------
    // Fungsi untuk kolokium lanjut (verif, penjadwalan dan validasi)
    //------------------------------------------------------------------------------------------
    public function verif_kolokium_lanjut()
    {
        $lists_id = Kolokium_lanjut::whereColumn('check_korkon', '<', 'check_mhs_send')->pluck('id');
        if ($lists_id->count() != 0) {
            $lists_array = $lists_id->toArray();
            $lists = Mahasiswa::whereIN('id', $lists_array)->get();
        }

        if ($lists->count() != 0) {
            $list_mhs = Mahasiswa::where('progress', 3)->pluck('id')->toArray();
            $kolokium_lanjut_status = Kolokium_lanjut::whereIN('mhs_id', $list_mhs)->select(
                'check_proposal_lanjut',
                'check_surat_tugas',
            )->orderBy('mhs_id', 'ASC')
                ->whereColumn('check_korkon', '<', 'check_mhs_send')
                ->get();
            $check_korkon = Kolokium_lanjut::whereIN('mhs_id', $list_mhs)->pluck('check_korkon')->toArray();
            $check_mhs_send = Kolokium_lanjut::whereIN('mhs_id', $list_mhs)->pluck('check_mhs_send')->toArray();

            // $lists = Mahasiswa::where('progress', 3)->get();
            // $nama = [
            //     'proposal_lanjut' => "Proposal Lanjut",
            //     'surat_tugas' => 'Surat Tugas'
            // ];
            // $check_nama = [
            //     'check_proposal_lanjut' => "Proposal Lanjut",
            //     'check_surat_tugas' => "Surat Tugas",
            // ];
            $nama_field = [
                'proposal_lanjut' => "check_proposal_lanjut",
                'surat_tugas' => "check_surat_tugas",
            ];
            $nama_only = [
                "Proposal Lanjut",
                "Surat Tugas",
            ];
            return view('dosen.verif_kolokium_lanjut', compact(
                'lists',
                'kolokium_lanjut_status',
                'check_korkon',
                'check_mhs_send',
                'nama_field',
                'nama_only',
            ));
        }
    }

    public function verif_kolokium_lanjut_verified(Request $request, $id)
    {
        // Fungsi dimana kol awal sudah diverifikasi
        $validated = $request->all();
        $data = [
            'check_proposal_lanjut' => $request->proposal_lanjut,
            'check_surat_tugas' => $request->surat_tugas,
        ];

        $nama = Mahasiswa::where('nim', $id)->get();

        //ambil id_kolokium awal, update data kolokium.
        $data_kolokium = Kolokium_lanjut::where('mhs_id', $nama[0]->id)
            ->update($data);
        $progress = Mahasiswa::where('nim', $id)
            ->update(['progress' => 4]);
        return redirect()->back()->with('success', 'Mahasiswa berhasil diverifikasi!');
    }

    public function verif_kolokium_lanjut_download($id)
    {

        if (Storage::disk('local')->exists("PenyimpananData/$id/Kolokium_Lanjut")) {
            $files = storage_path("app/PenyimpananData/$id/Kolokium_Lanjut");
            $zip = Madzipper::make("storage/Berkas_kolokium_Lanjut_$id.zip")->add($files)->close();
            return Storage::download("public/Berkas_kolokium_Lanjut_$id.zip", "Berkas_kolokium_Lanjut_$id.zip");
        } else
            return redirect()->back()->with('warning', 'Mahasiswa belum mengupload!');
    }

    public function penjadwalan_awal()
    {
        $current = Carbon::now();
        $dosen = Dosen::all();
        // $lists = Mahasiswa::where('progress', 1)
        $id_reviewed = Reviewer::all()->pluck('mhs_id')->toArray();
        $lists = Kolokium_awal::whereNotIn('mhs_id', $id_reviewed)
            ->where('check_kartu_studi_tetap', 1)
            ->where('check_transkrip_nilai', 1)
            ->where('check_form_pengajuan_ta', 1)
            ->where('check_tagihan_pembayaran', 1)
            ->where('check_proposal_awal', 1)
            ->where('check_lembar_reviewer', 1)
            ->get('mhs_id');
        if (!empty($lists)) {
            $list_mhs = $lists->pluck('mhs_id')->toArray();

            $mhs = Mahasiswa::whereIN('id', $list_mhs)->get();
        }
        $nama = [
            'kartu_studi_tetap' => "Kartu Studi Tetap",
            'transkrip_nilai' => "Transkrip Nilai",
            'form_pengajuan_ta' => "Form Pengajuan Tugas Akhir",
            'tagihan_pembayaran' => "Tagihan Pembayaran",
            'proposal_awal' => "Proposal Awal",
            'lembar_reviewer' => "Lembar Reviewer",
        ];
        return view('dosen.korkon.penjadwalan_awal', compact('lists', 'nama', 'mhs', 'dosen', 'current'));
    }
    public function penjadwalan_awal_data(PenjadwalanAwalRequest $request)
    {
        $current = Carbon::now();
        // dd($current->format('Y-m-d'));
        $validated = $request->validated();
        $mhs = Mahasiswa::where('id', $validated['id_mhs'])->get();
        $reviewer1 = Dosen::where('id', $validated['pilih_reviewer1'])->get();
        $reviewer2 = Dosen::where('id', $validated['pilih_reviewer2'])->get();
        $mhs[0]->dosen_review()->attach($reviewer1, ['jadwal' => $validated['penjadwalan'], 'reviewer2_id' => $reviewer2[0]->id]);
        return redirect()->back()->with('success', 'Mahasiswa berhasil dijadwalkan');
    }

    //----------------------------------------------------------------------
    // Fungsi untuk permission Reviewer
    //----------------------------------------------------------------------
    public function review_kolokium_awal()
    {
        $nomor = Auth::user()->id; //Dapat id user
        $dosen = Dosen::where('user_id', $nomor)->get();

        $daftar_mhs1 = Reviewer::where('reviewer1_id', $dosen[0]->id)->pluck('mhs_id');
        $daftar_mhs2 = Reviewer::where('reviewer2_id', $dosen[0]->id)->pluck('mhs_id');

        if ($daftar_mhs1->count() != 0 || $daftar_mhs2->count() != 0) {
            if ($daftar_mhs1->count() != 0) {
                $cond1 = 1;
                $daftar_mhs1 = $daftar_mhs1->toArray();
                $data_proposal1 = Proposal_awal::whereIN('mhs_id', $daftar_mhs1)
                    ->where('acc1', 1)
                    ->where('acc2', 1)
                    ->where('review_check1', 0)
                    ->get();
                if ($data_proposal1->count() != 0) {
                    $data_mhs1 = Mahasiswa::whereIN('id', $daftar_mhs1)->get();
                }
            }
            if ($daftar_mhs2->count() != 0) {
                $cond2 = 1;
                $daftar_mhs2 = $daftar_mhs2->toArray();
                $data_proposal2 = Proposal_awal::whereIN('mhs_id', $daftar_mhs2)
                    ->where('acc1', 1)
                    ->where('acc2', 1)
                    ->where('review_check2', 0)
                    ->get();
                if ($data_proposal2->count() != 0) {
                    $data_mhs2 = Mahasiswa::whereIN('id', $daftar_mhs2)->get();
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

    //----------------------------------------------------------------------
    // Fungsi untuk permission Panitia Ujian
    //----------------------------------------------------------------------

}
