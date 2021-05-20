<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VerifPengajuanReviewRequest extends FormRequest
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
            'id_mhs' => 'present',
            'check_admin' => 'present',
            'check_all' => 'nullable',
            'makalah' => 'nullable',
            'surat_tugas' => 'nullable',
            'scan_ijazah' => 'nullable',
            'transkrip_nilai' => 'nullable',
            'tagihan_pembayaran' => 'nullable',
            'transkrip_poin' => 'nullable',
            'kartu_studi' => 'nullable',
            'cek_plagiasi' => 'nullable',
        ];
    }
}
