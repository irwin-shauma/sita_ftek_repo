<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PengajuanPublikasiRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //

            'check_makalah' => 'nullable',
            'check_letter_of_acceptance' => 'nullable',
            'check_scan_ijazah' => 'nullable',
            'check_transkrip_nilai' => 'nullable',
            'check_tagihan_pembayaran' => 'nullable',
            'check_transkrip_poin' => 'nullable',
            'check_kartu_studi' => 'nullable',
            'check_cek_plagiasi' => 'nullable',
            'check_admin' => 'nullable',
            'id_mhs' => 'present',
            'nim_mhs' => 'present',


            'makalah' => 'required_unless:check_makalah, 1|mimes:docx|max:10240',
            'letter_of_acceptance' => 'required_unless:check_surat_tugas, 1|mimes:jpg,png,pdf|max:10240',
            'scan_ijazah' => 'required_unless:check_scan_ijazah, 1|mimes:jpg,png,pdf|max:10240',
            'transkrip_nilai' => 'required_unless:check_transkrip_nilai, 1|mimes:jpg,png,pdf|max:10240',
            'tagihan_pembayaran' => 'required_unless:check_tagihan_pembayaran, 1|mimes:jpg,png,pdf|max:10240',
            'transkrip_poin' => 'required_unless:check_transkrip_poin, 1|mimes:jpg,png,pdf|max:10240',
            'kartu_studi' => 'required_unless:check_kartu_studi, 1|mimes:jpg,png,pdf|max:10240',
            'cek_plagiasi' => 'required_unless:check_cek_plagiasi, 1|mimes:jpg,png,pdf|max:10240',
        ];
    }

    public function messages()
    {
        return [
            'makalah.required_unless' => "Silahkan diisi terlebih dahulu!",
            'letter_of_acceptance.required_unless' => "Silahkan diisi terlebih dahulu!",
            'scan_ijazah.required_unless' => "Silahkan diisi terlebih dahulu!",
            'transkrip_nilai.required_unless' => "Silahkan diisi terlebih dahulu!",
            'tagihan_pembayaran.required_unless' => "Silahkan diisi terlebih dahulu!",
            'transkrip_poin.required_unless' => "Silahkan diisi terlebih dahulu!",
            'kartu_studi.required_unless' => "Silahkan diisi terlebih dahulu!",
            'cek_plagiasi.required_unless' => "Silahkan diisi terlebih dahulu!",
        ];
    }
}
