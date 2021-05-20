<?php

namespace App\Http\Controllers;

use App\Models;

use App\Http\Requests\DaftarUserRequest;
use App\Http\Requests\EditRequest;
use App\Http\Requests\MhsUpdateRequest;
use App\Http\Requests\DsnUpdateRequest;
use App\Http\Requests\VerifPengajuanReviewRequest;
use App\Models\User;
use App\Models\Mahasiswa;
use App\Models\Dosen;
use App\Models\Kolokium_awal;
use App\Models\Kolokium_lanjut;
use App\Models\Pembimbing;
use App\Models\Pengajuan_review;
use App\Models\Pengajuan_publikasi;
use App\Models\Permission_counter;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Database\Eloquent\Model;
use PDF;
use Illuminate\Support\Facades\Storage;
use Madzipper;


class AdminTUController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     * @param app\Http\Requests\DaftarUserRequest $request
     * @return \Illuminate\Http\Response
     */
    public function create(DaftarUserRequest $request)
    {
        $validated = $request->validated();

        // dd($validated);
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        $user->assignRole($validated['role']);

        if ($validated['role'] == "mahasiswa") {
            $data =
                [
                    'name' => $user->name,
                    'nim' => $validated['nim'],
                    'progress' => null,
                ];

            $mahasiswa = new Mahasiswa($data);
            $mahasiswa->user()->associate($user);
            $mahasiswa->save();

            $kolokium_awal = new Kolokium_awal();
            $kolokium_awal->mahasiswa()->associate($mahasiswa);
            $kolokium_awal->save();

            $kolokium_lanjut = new Kolokium_lanjut();
            $kolokium_lanjut->mahasiswa()->associate($mahasiswa);
            $kolokium_lanjut->save();

            $pengajuan_review = new Pengajuan_review();
            $pengajuan_review->mahasiswa()->associate($mahasiswa);
            $pengajuan_review->save();

            $pengajuan_publikasi = new Pengajuan_publikasi();
            $pengajuan_publikasi->mahasiswa()->associate($mahasiswa);
            $pengajuan_publikasi->save();
        } else {
            $data =
                [
                    'name' => $user->name,
                    'nip' => $validated['nim']
                ];

            $dosen = new Dosen($data);
            $dosen->user()->associate($user);
            $dosen->save();
        }
        // dd($user['id']);
        // $nomor = User::find($user['id']);
        // $mahasiswa = Mahasiswa::create([
        //     'name' => $user->name,
        //     'nim' => $validated['nim'],
        //     'progress' => 0,
        // ]);

        // $mahasiswa->user()->associate($nomor);
        // $mahasiswa->save();

        return redirect()->route('tambah_user')->with('success', 'Data berhasil ditambahkan!');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Retrieve the validated input data
        $validated = $request->validated();
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
    // public function update(EditRequest $request, $id)
    // {
    //     dd($id);
    //     $data = $request->validated();
    //     // $data = $request->all();

    //     dd($data);
    //     if (Mahasiswa::where('nim', $id)->exists()) {
    //         Mahasiswa::where('nim', $id)
    //             ->update([
    //                 'nim' => $data['nim'],
    //                 'name' => $data['name'],
    //             ]);
    //     } elseif (Dosen::where('nip', $id)->exists()) {
    //         Dosen::where('nip', $id)
    //             ->update([
    //                 'nip' => $data['nip'],
    //                 'name' => $data['name'],
    //             ]);
    //     }
    //     return redirect()->back()->with('notice', 'Data berhasil diupdate!');
    // }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function destroy($id)
    // {
    //     if (Mahasiswa::where('nim', $id)->exists()) {
    //         $id_user_mahasiswa = Mahasiswa::where('nim', $id)->value('user_id');
    //         User::destroy($id_user_mahasiswa);
    //     } elseif (Dosen::where('nip', $id)->exists()) {
    //         $id_user_dosen = Dosen::where('nip', $id)->value('user_id');
    //         User::destroy($id_user_dosen);
    //     }

    //     return redirect()->back()->with('notice', 'Data berhasil dihapus!');
    // }


    public function update_mhs(MhsUpdateRequest $request, $id)
    {
        //$id disini memakai nim yang lawas.
        $data = $request->validated();

        if ($data['nim'] !== $id && Storage::disk('local')->exists("PenyimpananData/$id")) {
            Storage::move("PenyimpananData/$id", "PenyimpananData/" . $data['nim']);
            // Ini aku sementara ganti nama foldere doang
        }

        // $data = $request->validated();
        // dd($data['nim']);
        Mahasiswa::where('nim', $id)
            ->update([
                'nim' => $data['nim'],
                'name' => $data['name'],
            ]);
        return redirect()->back()->with('success', 'Data berhasil diupdate!');
    }

    public function update_dsn(DsnUpdateRequest $request, $id)
    {
        $data = $request->validated();
        Dosen::where('nip', $id)
            ->update([
                'nip' => $data['nip'],
                'name' => $data['name'],
            ]);

        return redirect()->back()->with('success', 'Data berhasil diupdate!');
    }

    public function destroy_mhs($id)
    {

        $path = storage_path("app/public/$id");


        if (Storage::disk('local')->exists("PenyimpananData/$id")) {
            Storage::deleteDirectory("PenyimpananData/$id");
        }

        $id_user_mahasiswa = Mahasiswa::where('nim', $id)->value('user_id');
        User::destroy($id_user_mahasiswa);


        return redirect()->back()->with('success', 'Data berhasil dihapus!');
    }

    public function destroy_dsn($id)
    {
        $id_user_dosen = Dosen::where('nip', $id)->value('user_id');
        User::destroy($id_user_dosen);

        return redirect()->back()->with('success', 'Data berhasil dihapus!');
    }


    public function tambah_user(Request $request)
    {
        $nama_role = [
            "mahasiswa",
            "dosen",
            // "reviewer",
        ];

        $roles = Role::whereIn('name', $nama_role)->get();

        return view('AdminTU.daftar_user.tambah_user', compact('roles'));
    }
    public function daftar_mahasiswa()
    {

        $lists = Mahasiswa::all();

        return view('AdminTU.daftar_user.daftar_mahasiswa', compact('lists'));
    }
    public function daftar_dosen()
    {
        $lists = Dosen::all();
        return view('AdminTU.daftar_user.daftar_dosen', compact('lists'));
    }


    public function verif_kolokium_awal()
    {
        // return Storage::download('example.txt');
        // return Storage::disk('local')->put('example.txt', 'Contents');


        $lists = Mahasiswa::where('progress', 1)->get();
        $data_kolokium = Kolokium_awal::select('kartu_studi_tetap', 'transkrip_nilai', 'mhs_id')
            ->orderByDesc('mhs_id')
            ->get();

        $nama = [
            'kartu_studi_tetap' => "Kartu Studi Tetap",
            'transkrip_nilai' => "Transkrip Nilai",
            'form_pengajuan_ta' => "Form Pengajuan Tugas Akhir",
            'tagihan_pembayaran' => "Tagihan Pembayaran",
            'proposal_awal' => "Proposal Awal",
            'lembar_reviewer' => "Lembar Reviewer",
        ];
        // dd($data_kolokium);


        // return view('AdminTU.verif_berkas.verif_kolokium_awal', compact('lists', 'data_kolokium', 'nama'));
        return view('AdminTU.verif_berkas.verif_2', compact('lists', 'data_kolokium', 'nama'));
    }

    public function verif_kolokium_awal_download($id)
    {

        $path = storage_path("app/public/$id");
        // dd($path);
        if (Storage::disk('local')->exists("PenyimpananData/$id/Kolokium_Awal")) {
            $files = storage_path("app/PenyimpananData/$id/Kolokium_Awal");
            // $files = "C:/xampp/htdocs/sita_ftek/storage/app/PenyimpananData/1001/";
            // dd($files);
            $zip = Madzipper::make("storage/Berkas_kolokium_Awal_$id.zip")->add($files)->close();

            return Storage::download("public/Berkas_kolokium_Awal_$id.zip", "Berkas_kolokium_Awal_$id.zip");

            // return redirect()->back()->with('notice', 'Data mahasiswa telah diunduh!');
        } else
            return redirect()->back()->with('warning', 'Mahasiswa belum mengupload!');
        // return Storage::download('Spare/contoh.txt');
        // $files = Storage::path('example.txt');
        // return Storage::download("PenyimpananData/$id/example.txt");
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

    // -----------------------------------------------------------------
    public function verif_pengajuan_review()
    {
        $lists_id = Pengajuan_review::whereColumn('check_admin', '<', 'check_mhs_send')->pluck('id');
        if ($lists_id->count() != 0) {
            $lists_array = $lists_id->toArray();
            $lists = Mahasiswa::whereIN('id', $lists_array)->get();
        } else {
            return view('AdminTU.verif_berkas.verif_pengajuan_review', compact(
                'lists',
                'pengajuan_review_status',
                'check_admin',
                'check_mhs_send',
                'nama_field',
                'nama_only',
            ));
        }

        if ($lists->count() != 0) {
            $list_mhs = Mahasiswa::where('progress', 5)->pluck('id')->toArray();
            $pengajuan_review_status = Pengajuan_review::whereIN('mhs_id', $list_mhs)->select(
                'check_makalah',
                'check_surat_tugas',
                'check_scan_ijazah',
                'check_transkrip_nilai',
                'check_tagihan_pembayaran',
                'check_transkrip_poin',
                'check_kartu_studi',
                'check_cek_plagiasi',
            )->orderBy('mhs_id', 'ASC')
                ->whereColumn('check_admin', '<', 'check_mhs_send')
                ->get();
            $check_admin = Pengajuan_review::whereIN('mhs_id', $list_mhs)->pluck('check_admin')->toArray();
            $check_mhs_send = Pengajuan_review::whereIN('mhs_id', $list_mhs)->pluck('check_mhs_send')->toArray();
        }
        $nama_field = [
            'makalah' => 'check_makalah',
            'surat_tugas' => 'check_surat_tugas',
            'scan_ijazah' => 'check_scan_ijazah',
            'transkrip_nilai' => 'check_transkrip_nilai',
            'tagihan_pembayaran' => 'check_tagihan_pembayaran',
            'transkrip_poin' => 'check_transkrip_poin',
            'kartu_studi' => 'check_kartu_studi',
            'cek_plagiasi' => 'check_cek_plagiasi',
        ];

        $nama_only = [
            "Proposal Lanjut",
            "Surat Tugas",
            "Scan Ijazah",
            "Transkrip Nilai",
            "Tagihan Pembayaran",
            "Transkrip Poin",
            "Kartu Studi",
            "Cek Plagiasi",
        ];


        return view('AdminTU.verif_berkas.verif_pengajuan_review', compact(
            'lists',
            'pengajuan_review_status',
            'check_admin',
            'check_mhs_send',
            'nama_field',
            'nama_only',
        ));
    }

    public function verif_pengajuan_review_download($id)
    {
        if (Storage::disk('local')->exists("PenyimpananData/$id/Pengajuan_Review/berkas")) {
            $files = storage_path("app/PenyimpananData/$id/Pengajuan_Review/berkas");
            $zip = Madzipper::make("storage/Berkas_Pengajuan_Review_$id.zip")->add($files)->close();
            return Storage::download("public/Berkas_Pengajuan_Review_$id.zip", "Berkas_Pengajuan_Review_$id.zip");
        } else
            return redirect()->back()->with('warning', 'Mahasiswa belum mengupload!');
    }

    public function verif_pengajuan_review_verified(VerifPengajuanReviewRequest $request, $id)
    {
        $validated = $request->validated();
        // dd($validated);
        if ($validated['check_admin'] < 1 || $validated['check_admin'] == null) {
            $data = [
                'check_makalah' => $validated['makalah'],
                'check_surat_tugas' => $validated['surat_tugas'],
                'check_scan_ijazah' => $validated['scan_ijazah'],
                'check_transkrip_nilai' => $validated['transkrip_nilai'],
                'check_tagihan_pembayaran' => $validated['tagihan_pembayaran'],
                'check_transkrip_poin' => $validated['transkrip_poin'],
                'check_kartu_studi' => $validated['kartu_studi'],
                'check_cek_plagiasi' => $validated['cek_plagiasi'],
            ];
            $nama = Mahasiswa::where('nim', $id)->get();
            $data_review = Pengajuan_review::where('mhs_id', $nama[0]->id)
                ->update($data);
        } else {
            $pengajuan_review_status = Pengajuan_review::where('mhs_id', $validated['id_mhs'])
                ->select(
                    'check_makalah',
                    'check_surat_tugas',
                    'check_scan_ijazah',
                    'check_transkrip_nilai',
                    'check_tagihan_pembayaran',
                    'check_transkrip_poin',
                    'check_kartu_studi',
                    'check_cek_plagiasi',
                )->orderByDesc('mhs_id')->get();
            $nama_field = [
                'makalah' => 'check_makalah',
                'surat_tugas' => 'check_surat_tugas',
                'scan_ijazah' => 'check_scan_ijazah',
                'transkrip_nilai' => 'check_transkrip_nilai',
                'tagihan_pembayaran' => 'check_tagihan_pembayaran',
                'transkrip_poin' => 'check_transkrip_poin',
                'kartu_studi' => 'check_kartu_studi',
                'cek_plagiasi' => 'check_cek_plagiasi',
            ];

            foreach ($nama_field as $key => $value) {
                # code...
                if ($pengajuan_review_status[0]->$value != 1) {
                    # code...
                    $data_review = Pengajuan_review::where('mhs_id', $validated['id_mhs'])
                        ->update([$value => $validated[$key]]);
                }
            }
        }

        $data_review = Pengajuan_review::where('mhs_id', $validated['id_mhs'])
            ->increment('check_admin');

        // $progress = Mahasiswa::where('nim', $id)
        //     ->update(['progress' => 6]);

        return redirect()->back()->with('success', 'Mahasiwa berhasil diverifikasi');
    }

    // -----------------------------------------------------------------


    public function verif_pengajuan_nilai_publikasi()
    {
        $lists = Mahasiswa::where('progress', 5)->get();
        $nama = [
            'makalah' => "Makalah",
            'letter_of_acceptance' => "Letter Of Acceptance",
            'scan_ijazah' => "Scan Ijazah",
            'transkrip_nilai' => "Transkrip Nilai",
            'tagihan_pembayaran' => "Tagihan Pembayaran",
            'transkrip_poin' => "Transkrip Poin",
            'kartu_studi' => "Kartu Studi",
            'cek_plagiasi' => "Cek Plagiasi",
        ];
        return view('AdminTU.verif_berkas.verif_pengajuan_nilai_publikasi', compact('lists', 'nama'));
    }

    public function verif_pengajuan_nilai_publikasi_download($id)
    {
        if (Storage::disk('local')->exists("PenyimpananData/$id/Pengajuan_Nilai_Publikasi")) {
            $files = storage_path("app/PenyimpananData/$id/Pengajuan_Nilai_Publikasi");
            $zip = Madzipper::make("storage/Berkas_Pengajuan_Nilai_Publikasi_$id.zip")->add($files)->close();
            return Storage::download("public/Berkas_Pengajuan_Nilai_Publikasi_$id.zip", "Berkas_Pengajuan_Nilai_Publikasi_$id.zip");
        } else
            return redirect()->back()->with('warning', 'Mahasiswa belum mengupload!');
    }

    public function verif_pengajuan_nilai_publikasi_verified(Request $request, $id)
    {
        $validated = $request->all();
        $data = [
            'check_makalah' => $request->makalah,
            'check_letter_of_acceptance' => $request->letter_of_acceptance,
            'check_scan_ijazah' => $request->scan_ijazah,
            'check_transkrip_nilai' => $request->transkrip_nilai,
            'check_tagihan_pembayaran' => $request->tagihan_pembayaran,
            'check_transkrip_poin' => $request->transkrip_poin,
            'check_kartu_studi' => $request->kartu_studi,
            'check_cek_plagiasi' => $request->cek_plagiasi,
            'check_admin' => 1,
        ];

        $nama = Mahasiswa::where('nim', $id)->get();
        $data_publikasi = Pengajuan_publikasi::where('mhs_id', $nama[0]->id)
            ->update($data);

        $progress = Mahasiswa::where('nim', $id)
            ->update(['progress' => 6]);

        return redirect()->back()->with('success', 'Mahasiswa berhasil diverifikasi!');
    }

    // -----------------------------------------------------------------

    public function daftar_mahasiswa_cetak()
    {

        $lists = Mahasiswa::all();
        $pembimbing = Pembimbing::all();
        // $pembimbing = Dosen::first()->mahasiswas()->get();

        // $dosen_pembimbing = Dosen::whereIn('dosen', ['$pembimbing[']);
        $dosen_pembimbing_1 = [];
        $dosen_pembimbing_2 = [];
        foreach ($pembimbing as $key) {
            $dosen_pembimbing_1[] = Dosen::where('id', $key->dosen1_id)->get('name');
            // $dosen_pembimbing = Dosen::whereIn('id', [$key->dosen2_id, $key->dosen2_id])->get('name');
            $dosen_pembimbing_2[] = Dosen::where('id', $key->dosen2_id)->get('name');
        }
        // dd($dosen_pembimbing_1);
        $pdf = PDF::loadView('adminTU.cetak_mhs', compact('lists', 'dosen_pembimbing_1', 'dosen_pembimbing_2'));
        return $pdf->inline('test.pdf');
    }

    public function tambah_permissions()
    {

        $nama_permission = [
            "korkon_elektro",
            "korkon_telkom",
            "korkon_tek_kom",
            "panitia_ujian",
            "kaprogdi_elektro",
            "kaprogdi_tekkom",
        ];

        $permissions = Permission::whereIn('name', $nama_permission)->get();
        $dosen_all = Dosen::all();
        $lists = Dosen::pluck('user_id');

        if ($lists->count() != 0) {

            $lists_array = $lists->toArray();
        } else {
            $lists_array = [];
        }

        $users = User::whereIn('id', $lists_array)->get();
        // dd($users[0]->hasPermissionTo('korkon'));
        $user_with_permission = [];
        foreach ($users as $key) {
            $key_permission = $key->getPermissionNames();
            // dd($key_permission);
            if ($key_permission->count() != 0) {
                // dd('satu');
                $user_with_permission[] = $key->id;
            }
        }

        if ($user_with_permission === null) {
            $user_with_permission = [];
        }

        $users = User::whereIn('id', $user_with_permission)->get();
        $dosen = Dosen::whereIN('user_id', $user_with_permission)->get();
        // dd($users);
        return view('adminTU.daftar_user.tambah_permissions', compact('cond', 'permissions', 'users', 'dosen', 'dosen_all', 'nama_permission'));
    }

    public function apply_permission(Request $request)
    {
        $data = $request->all();
        // dd($data);
        $nama_permission = [
            "korkon_elektro" => 1,
            "korkon_telkom" => 1,
            "korkon_tek_kom" => 1,
            "panitia_ujian" => 1,
            "kaprogdi_elektro" => 1,
            "kaprogdi_tekkom" => 1,
        ];
        $counter = Permission_counter::where('permission_name', $data['permission'])->get();
        if ($counter->count() == 0) {
            $buat_baru = Permission_counter::create([
                'permission_name' => $data['permission'],
                'counter' => 1
            ]);
            $tambah = User::where('id', $data['user_id'])->get();
            $tambah[0]->givePermissionTo($request['permission']);
            return redirect()->back()->with('success', 'Permission Berhasi Ditambahkan!');
        } else {
            foreach ($nama_permission as $key => $value) {
                if ($key === $data['permission']) {
                    $update_counter = Permission_counter::where('permission_name', $key)->get();
                    if ($update_counter[0]->counter < $value) {
                        $tambah = User::where('id', $data['user_id'])->get();
                        if ($tambah[0]->hasPermissionTo($data['permission'])) {
                            return redirect()->back()->with('warning', "Dosen sudah punya permission!");
                        } else {
                            $update_counter = Permission_counter::where('permission_name', $key)->increment('counter');
                            $tambah[0]->givePermissionTo($request['permission']);
                            return redirect()->back()->with('success', 'Permission Berhasi Ditambahkan!');
                        }
                    } else {
                        return redirect()->back()->with('warning', 'Permission sudah penuh!');
                    }
                }
            }
        }
    }

    public function delete_permission(Request $request)
    {
        $data = $request->all();
        // dd($data);
        $dosen_id = $data['id_dosen'];

        $nama_permission = [
            "korkon_elektro",
            "korkon_telkom",
            "korkon_tek_kom",
            "panitia_ujian",
            "kaprogdi_elektro",
            "kaprogdi_tekkom",
        ];

        foreach ($nama_permission as $key) {
            if ($data[$key] == 1) {

                $kurang = User::where('id', $data['id_user_dosen'])->get();
                $kurang[0]->revokePermissionTo($key);
                $update_counter = Permission_counter::where('permission_name', $key)->decrement('counter');
            }
        }
        return redirect()->back()->with('warning', 'Permission sudah dihapus!');
    }
}
