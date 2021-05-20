<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VerifKolokiumAwalRequest extends FormRequest
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
            'check_korkon' => 'present',
            'check_all' => 'nullable',
            'kartu_studi_tetap' => 'nullable',
            'transkrip_nilai' => 'nullable',
            'form_pengajuan_ta' => 'nullable',
            'tagihan_pembayaran' => 'nullable',
            'proposal_awal' => 'nullable',
            'lembar_reviewer' => 'nullable',
            // 'kartu_studi_tetap' => 'present',
            // 'transkrip_nilai' => 'present',
            // 'form_pengajuan_ta' => 'present',
            // 'tagihan_pembayaran' => 'present',
            // 'proposal_awal' => 'present',
            // 'lembar_reviewer' => 'present',

        ];
    }
}
