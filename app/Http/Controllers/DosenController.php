<?php

namespace App\Http\Controllers;

use App\Http\Requests\BimbinganAwalRequest;
use App\Http\Requests\BimbinganLanjutRequest;
use App\Http\Requests\BimbinganReviewRequest;
use App\Http\Requests\PenilaianBimbinganTARequest;

use Illuminate\Http\Request;
use App\Models\Pembimbing;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\Nilai_bimbingan_ta;
use App\Models\NomorSurat;
use App\Models\Proposal_awal;
use App\Models\Proposal_lanjut;
use App\Models\Paper_review;
use App\Models\Pengajuan_review;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

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

    public function daftar_revisi_makalah()
    {
        $nomor = Auth::user()->id; //Dapat id user dari dosen yang sedang login.
        //$dosen berisi id dosen yang sedang login.
        $dosen = Dosen::where('user_id', $nomor)->pluck('id');

        $data_review = Paper_review::pluck('mhs_id');
        if ($data_review->count() != 0) {
            $data_review_array = $data_review->unique()->toArray();
        } else {
            $data_review_array = 0;
        }
        $pembimbing1 = Pembimbing::where('dosen1_id', $dosen)->pluck('mhs_id');
        if ($pembimbing1->count() != 0) {
            $pembimbing1_array = $pembimbing1->toArray();
        } else {
            $pembimbing1_array = [];
        }
        $mhs1 = Mahasiswa::whereIN('id', $pembimbing1_array)
            ->whereIN('id', $data_review_array)
            ->get();

        $pembimbing2 = Pembimbing::where('dosen2_id', $dosen)->pluck('mhs_id');
        if ($pembimbing2->count() != 0) {
            $pembimbing2_array = $pembimbing2->toArray();
        } else {
            $pembimbing2_array = [];
        }
        // dd($pembimbing2_array);
        $mhs2 = Mahasiswa::whereIN('id', $pembimbing2_array)
            ->whereIN('id', $data_review_array)
            ->get();
        $data_review1_filtered = Paper_review::whereIn('mhs_id', $pembimbing1_array)->get();
        $data_review2_filtered = Paper_review::whereIn('mhs_id', $pembimbing2_array)->get();
        return view('dosen.daftar_revisi_makalah', compact('mhs1', 'mhs2', 'data_review1_filtered', 'data_review2_filtered'));
    }

    public function daftar_revisi_makalah_download(Request $request)
    {
        // dd($request->all());
        // $id = Auth::user()->id;
        // $mhs = Mahasiswa::where('user_id', $id)->get();
        $file = $request->file_paper;
        $dosen_pembimbing = $request->sender;

        // $nim = $mhs[0]->nim;
        $nim = $request->nim;
        if (Storage::disk('local')->exists("PenyimpananData/$nim/Pengajuan_Review/Paper/$file")) {
            return Storage::download("PenyimpananData/$nim/Pengajuan_Review/Paper/$file");
        } elseif ($dosen_pembimbing == 1) {
            return Storage::download("PenyimpananData/$nim/Pengajuan_Review/Paper/Dosen1/$file");
        } elseif ($dosen_pembimbing == 2) {
            return Storage::download("PenyimpananData/$nim/Pengajuan_Review/Paper/Dosen2/$file");
        } elseif ($dosen_pembimbing == "Reviewer 1" || $dosen_pembimbing = "Reviewer 2") {
            return Storage::download("PenyimpananData/$nim/Pengajuan_Review/Paper/Reviewer/$file");
        }
        // return redirect()->route('home')->with('success', 'Anda berhasil mengupload paper pengajuan review!');

        // return view('dosen.menu_bimbingan');
    }

    // Fungsi untuk bimbingan kolokium awal, download, dan action.
    //----------------------------------------------------------------------
    public function bimbingan_kolokium_awal()
    {
        $nomor = Auth::user()->id; //Dapat id user
        $dosen = Dosen::where('user_id', $nomor)->get();
        //-----------------------------------------------------------------------------------------------------------------------------------------------------------------------
        //Ambil id mhs dari yang memilih sebagai dosen 1 (raw data dari pembimbing)
        // $mhs_dosen1_id = Pembimbing::where('dosen1_id', $dosen[0]->id)->pluck('mhs_id');
        // if ($mhs_dosen1_id->count() !== 0) {
        //     $mhs_dosen1_id = $mhs_dosen1_id->toArray();

        //     $mhs_dosen1_name = Mahasiswa::whereIN('id', $mhs_dosen1_id)->pluck('name')->toArray(); // Membuat array name dari DB Mahasiswa
        //     $check_mhs_send = Proposal_awal::whereIN('mhs_id', $mhs_dosen1_id)->whereIn('sender', $mhs_dosen1_name)->get()->groupBy('sender')->map->count('check_mhs_send');
        //     if ($check_mhs_send != 0) {
        //         $check_mhs_send_array = $check_mhs_send->toArray();
        //     } else {
        //         $check_mhs_send_array = [];
        //     }
        //     $check_acc_dosen = Proposal_awal::whereIN('mhs_id', $mhs_dosen1_id)->where('acc1', 1)->whereIn('sender', $mhs_dosen1_name)->get()->groupBy('sender')->map->count('sender');
        //     if ($check_acc_dosen != 0) {
        //         $check_acc_dosen_array = $check_acc_dosen->toArray();
        //     } else {
        //         $check_acc_dosen_array = [];
        //     }

        //     $data_proposal_dosen1 = Proposal_awal::whereIN('mhs_id', $mhs_dosen1_id)
        //         ->whereNotIn('sender', array_keys($check_acc_dosen_array))
        //         ->where('check1', 0)
        //         ->whereIN('sender', $mhs_dosen1_name)
        //         ->orderBy('updated_at', 'asc')
        //         ->get();
        //     if ($data_proposal_dosen1->count() === 0) {
        //         $mhs_dosen1 = 'empty';
        //         $data_proposal_dosen1 = 'empty';
        //     } else {
        //         $data_proposal_dosen1_urutan = $data_proposal_dosen1->pluck('mhs_id')->toArray();
        //         $mhs_dosen1 = Mahasiswa::whereIN('id', $data_proposal_dosen1_urutan)->orderByRaw('FIELD(id, ' . implode(',', $data_proposal_dosen1_urutan) . ')')->get();
        //     }
        // } else {
        //     $mhs_dosen1_id = 'empty';
        //     $mhs_dosen1 = 'empty';
        //     $data_proposal_dosen1 = 'empty';
        // }

        //-----------------------------------------------------------------------------------------------------------------------------------------------------------------------

        // //-----------------------------------------------------------------------------------------------------------------------------------------------------------------------
        // //Ambil id mhs dari yang memilih sebagai dosen 1 (raw data dari pembimbing)
        $mhs_dosen1_id = Pembimbing::where('dosen1_id', $dosen[0]->id)->pluck('mhs_id');
        if ($mhs_dosen1_id->count() !== 0) {
            //Ambil data mhs dari tabel mahasiswa
            $mhs_dosen1_id = $mhs_dosen1_id->toArray();
            $mhs_dosen1_name = Mahasiswa::whereIN('id', $mhs_dosen1_id)->pluck('name')->toArray();
            // Data proposal sesuai dosen 1  beserta dengan urutan mahasiswanya, pengirim, dan check nya.
            $data_proposal_dosen1 = Proposal_awal::whereIN('mhs_id', $mhs_dosen1_id)
                ->where('check1', 0)
                ->whereIN('sender', $mhs_dosen1_name)
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

        // //-----------------------------------------------------------------------------------------------------------------------------------------------------------------------


        //Ambil id mhs dari yang memilih sebagai dosen 2
        $mhs_dosen2_id = Pembimbing::where('dosen2_id', $dosen[0]->id)->pluck('mhs_id');
        if ($mhs_dosen2_id->count() !== 0) {
            $mhs_dosen2_id = $mhs_dosen2_id->toArray();
            //Ambil data mhs dari tabel mahasiswa
            $mhs_dosen2_name = Mahasiswa::whereIN('id', $mhs_dosen2_id)->get('name')->toArray();
            //Foreach data mhs yang dari tabel, kemudian dimasukkan ke array, sehingga array hanya berisi nama2 mhs
            //sesuai dengan dosen 2 yg mereka pilih
            // Data proposal sesuai dosen 2 beserta dengan urutan mahasiswanya, pengirim, dan check nya.
            $data_proposal_dosen2 = Proposal_awal::whereIN('mhs_id', $mhs_dosen2_id)
                ->where('check2', 0)
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
                $send_mhs_check = Proposal_awal::where('file_proposal', $validated['file_proposal'])
                    ->where('sender', $validated['name_mhs'])->get();
                if ($send_mhs_check[0]->check2 == 1 && $send_mhs_check[0]->acc2 == 1) {
                    $send_mhs_check[0]->update(['check_mhs_send' => 1]);
                }
            } else {
                $progress = Proposal_awal::where('file_proposal', $validated['file_proposal'])
                    ->where('sender', $validated['name_mhs'])
                    ->increment('check2', 1, ['acc2' => 1]);
                $send_mhs_check = Proposal_awal::where('file_proposal', $validated['file_proposal'])
                    ->where('sender', $validated['name_mhs'])->get();
                if ($send_mhs_check[0]->check1 == 1 && $send_mhs_check[0]->acc1 == 1) {
                    $send_mhs_check[0]->update(['check_mhs_send' => 1]);
                }
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
                // dd($progress);
                $send_mhs_check = Proposal_lanjut::where('file_proposal', $validated['file_proposal'])
                    ->where('sender', $validated['name_mhs'])->get();
                if ($send_mhs_check[0]->check2 == 1 && $send_mhs_check[0]->acc2 == 1) {
                    $send_mhs_check[0]->update(['check_mhs_send' => 1]);
                }
            } else {
                $progress = Proposal_lanjut::where('file_proposal', $validated['file_proposal'])
                    ->where('sender', $validated['name_mhs'])
                    ->increment('check2', 1, ['acc2' => 1]);

                $send_mhs_check = Proposal_lanjut::where('file_proposal', $validated['file_proposal'])
                    ->where('sender', $validated['name_mhs'])->get();
                if ($send_mhs_check[0]->check1 == 1 && $send_mhs_check[0]->acc1 == 1) {
                    $send_mhs_check[0]->update(['check_mhs_send' => 1]);
                }
            }
            return redirect()->back()->with('success', 'Proposal Awal mahasiswa berhasil disetujui!');
        }
    }

    // Fungsi untuk bimbingan pengajuan review, download, dan action.
    //----------------------------------------------------------------------
    public function bimbingan_pengajuan_review()
    {
        $nomor = Auth::user()->id;
        $dosen = Dosen::where('user_id', $nomor)->get();

        // Ambil id mhs dari yang memilih sebagai dosen 1 (raw data dari pembimbing)
        $mhs_dosen1_id = Pembimbing::where('dosen1_id', $dosen[0]->id)->pluck('mhs_id');
        if ($mhs_dosen1_id->count() !== 0) {
            $mhs_dosen1_id_array = $mhs_dosen1_id->toArray();
            $mhs_dosen1_name = Mahasiswa::whereIN('id', $mhs_dosen1_id)->pluck('name')->toArray();
            $data_paper_dosen1 = Paper_review::whereIN('mhs_id', $mhs_dosen1_id_array)
                ->where('check1', 0)
                ->whereIN('sender', $mhs_dosen1_name)
                ->orderBy('updated_at', 'asc')
                ->get();
            if ($data_paper_dosen1->count() !== 0) {
                $data_paper_dosen1_array = $data_paper_dosen1->pluck('mhs_id')->toArray();
                $mhs_dosen1 = Mahasiswa::whereIn('id', $data_paper_dosen1_array)->orderByRaw('FIELD(id, ' . implode(',', $data_paper_dosen1_array) . ')')->get();
            } else {
                $mhs_dosen1 = 'empty';
                $data_paper_dosen1 = 'empty';
            }
        } else {
            $mhs_dosen1_id = 'empty';
            $mhs_dosen1 = 'empty';
            $data_paper_dosen1 = 'empty';
        }
        $mhs_dosen2_id = Pembimbing::where('dosen2_id', $dosen[0]->id)->pluck('mhs_id');
        if ($mhs_dosen2_id->count() !== 0) {
            $mhs_dosen2_id_array = $mhs_dosen2_id->toArray();
            $mhs_dosen2_name = Mahasiswa::whereIN('id', $mhs_dosen2_id)->pluck('name')->toArray();
            $data_paper_dosen2 = Paper_review::whereIN('mhs_id', $mhs_dosen2_id_array)
                ->where('check2', 0)
                ->whereIN('sender', $mhs_dosen2_name)
                ->orderBy('updated_at', 'asc')
                ->get();
            if ($data_paper_dosen2->count() !== 0) {
                $data_paper_dosen2_array = $data_paper_dosen2->pluck('mhs_id')->toArray();
                $mhs_dosen2 = Mahasiswa::whereIn('id', $data_paper_dosen2_array)->orderByRaw('FIELD(id, ' . implode(',', $data_paper_dosen2_array) . ')')->get();
            } else {
                $mhs_dosen2 = 'empty';
                $data_paper_dosen2 = 'empty';
            }
        } else {
            $mhs_dosen2_id = 'empty';
            $mhs_dosen2 = 'empty';
            $data_paper_dosen2 = 'empty';
        }
        return view('dosen.bimbingan_pengajuan_review', compact('mhs_dosen1', 'data_paper_dosen1', 'mhs_dosen2', 'data_paper_dosen2'));
    }

    public function bimbingan_pengajuan_review_download(Request $request)
    {
        $data_all = $request->all();
        $file = $data_all['file_paper'];
        $id = $data_all['nim'];

        if (Storage::disk('local')->exists("PenyimpananData/$id/Pengajuan_Review/Paper/$file")) {
            return Storage::download("PenyimpananData/$id/Pengajuan_Review/Paper/$file");
        }
    }

    public function bimbingan_pengajuan_review_action(BimbinganReviewRequest $request)
    {
        $validated = $request->validated();
        $id = Auth::user()->id;
        $dsn = Dosen::where('user_id', $id)->get();
        $nomor_revisi = Paper_review::where('mhs_id', $validated['id_mhs'])
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
                $filename = "Paper_Pengajuan_Review_" . $validated['nim'] . "_Revisi_" . $nomor_revisi . "_Pembimbing_1." . $validated['file_revisi']->extension();
            } else {
                $filename = "Paper_Pengajuan_Review_" . $validated['nim'] . "_Revisi_" . $nomor_revisi . "_Pembimbing_2." . $validated['file_revisi']->extension();
            }
            $path = Storage::putFileAs("PenyimpananData/" . $validated['nim'] . "/Pengajuan_Review/Paper/Dosen" . $validated['pembimbing_ke'], $validated['file_revisi'], $filename);
            Paper_review::create([
                'mhs_id' => $validated['id_mhs'],
                'nomor_revisi' => $nomor_revisi,
                'file_paper' => $filename,
                'komentar' => $validated['komentar_pembimbing'],
                'sender' => $validated['pembimbing_ke'],
                'check1' => $check1,
                'check2' => $check2,
            ]);
            if ($validated['pembimbing_ke'] == 1) {
                $progress = Paper_review::where('file_paper', $validated['file_paper'])
                    ->increment('check1');
            } else {
                $progress = Paper_review::where('file_paper', $validated['file_paper'])
                    ->increment('check2');
            }

            return redirect()->back()->with('success', 'Paper Pengajuan Review Mahasiswa berhasil direvisi!');
        } elseif ($validated['action'] === 'setujui') {

            if ($validated['pembimbing_ke'] == 1) {
                $progress = Paper_review::where('file_paper', $validated['file_paper'])
                    ->where('sender', $validated['name_mhs'])
                    ->increment('check1', 1, ['acc1' => 1]);
                // dd($progress);
                $send_mhs_check = Paper_review::where('file_paper', $validated['file_paper'])
                    ->where('sender', $validated['name_mhs'])->get();
                if ($send_mhs_check[0]->check2 == 1 && $send_mhs_check[0]->acc2 == 1) {
                    $send_mhs_check[0]->update(['check_mhs_send' => 1]);
                }
            } else {
                $progress = Paper_review::where('file_paper', $validated['file_paper'])
                    ->where('sender', $validated['name_mhs'])
                    ->increment('check2', 1, ['acc2' => 1]);

                $send_mhs_check = Paper_review::where('file_paper', $validated['file_paper'])
                    ->where('sender', $validated['name_mhs'])->get();
                if ($send_mhs_check[0]->check1 == 1 && $send_mhs_check[0]->acc1 == 1) {
                    $send_mhs_check[0]->update(['check_mhs_send' => 1]);
                }
            }
            return redirect()->back()->with('success', 'Paper Pengajuan Review mahasiswa berhasil disetujui!');
        }
    }
    //----------------------------------------------------------------------

    public function bimbingan_penilaian_tugas_akhir()
    {
        $nomor = Auth::user()->id; //Dapat id user dari dosen yang sedang login.
        //$dosen berisi id dosen yang sedang login.
        $dosen = Dosen::where('user_id', $nomor)->pluck('id');
        $id_dosen = Dosen::where('user_id', $nomor)->value('id');

        $pembimbing1 = Pembimbing::where('dosen1_id', $dosen)->pluck('mhs_id');
        if ($pembimbing1->count() != 0) {
            $cond1 = 1;
            $pembimbing1_array = $pembimbing1->toArray();
        } else {
            $cond2 = 2;
            $pembimbing1_array = [];
        }
        $mhs1_done = Nilai_bimbingan_ta::whereIN('mhs_id', $pembimbing1_array)->pluck('mhs_id');
        if ($mhs1_done->count() != 0) {
            $mhs1_done_array = $mhs1_done->toArray();
        } else {
            $mhs1_done_array = [];
        }
        $daftar_mhs1_review = Pengajuan_review::whereIN('mhs_id', $pembimbing1_array)
            ->where('check_admin', 1)
            ->where('check_panitia_ujian', 1)
            ->whereNotIn('mhs_id', $mhs1_done_array)
            ->pluck('mhs_id');

        if ($daftar_mhs1_review->count() != 0) {
            $daftar_mhs1_review_array = $daftar_mhs1_review->toArray();
        } else {
            $daftar_mhs1_review_array = [];
        }
        $mhs1 = Mahasiswa::whereIN('id', $daftar_mhs1_review_array)->get();
        $judul1 = NomorSurat::whereIN('id', $daftar_mhs1_review_array)->get();


        $pembimbing2 = Pembimbing::where('dosen2_id', $dosen)->pluck('mhs_id');
        if ($pembimbing2->count() != 0) {
            $cond2 = 1;
            $pembimbing2_array = $pembimbing2->toArray();
        } else {
            $cond2 = 2;
            $pembimbing2_array = [];
        }
        $mhs2_done = Nilai_bimbingan_ta::whereIN('mhs_id', $pembimbing2_array)->pluck('mhs_id');
        if ($mhs2_done->count() != 0) {
            $mhs2_done_array = $mhs2_done->toArray();
        } else {
            $mhs2_done_array = [];
        }
        $daftar_mhs2_review = Pengajuan_review::whereIN('mhs_id', $pembimbing2_array)
            ->where('check_admin', 1)
            ->where('check_panitia_ujian', 1)
            ->whereNotIn('mhs_id', $mhs2_done_array)
            ->pluck('mhs_id');

        if ($daftar_mhs2_review->count() != 0) {
            $daftar_mhs2_review_array = $daftar_mhs2_review->toArray();
        } else {
            $daftar_mhs2_review_array = [];
        }
        $mhs2 = Mahasiswa::whereIN('id', $daftar_mhs2_review_array)->get();
        $judul2 = NomorSurat::whereIN('id', $daftar_mhs2_review_array)->get();

        return view('dosen.bimbingan.penilaian_tugas_akhir', compact('cond1', 'cond2', 'mhs1', 'mhs2', 'judul1', 'judul2', 'id_dosen'));
    }

    public function bimbingan_penilaian_tugas_akhir_action(PenilaianBimbinganTARequest $request)
    {
        $current = Carbon::now();
        $validated = $request->validated();
        $data = [
            'mhs_id' => $validated['id_mhs'],
            'pembimbing_id' => $validated['id_dosen'],
            'name' => $validated['name'],
            'nim' => $validated['nim'],
            'judul' => $validated['judul'],
            'nilai' => $validated['nilai'],
            'komentar' => $validated['komentar'],
            'total_all' => $validated['total'],
            'tanggal_penilaian' => $current->format('Y-m-d'),
        ];

        $input_data = Nilai_bimbingan_ta::create($data);
        return redirect()->back()->with('success', 'Berhasil menilai tugas akhir mahasiswa!');
        return view('dosen.bimbingan.penilaian_tugas_akhir');
    }
}
