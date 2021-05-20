<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KolokiumAwalRequest extends FormRequest
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

            'check_kartu_studi_tetap' => 'nullable',
            'check_transkrip_nilai' => 'nullable',
            'check_form_pengajuan_ta' => 'nullable',
            'check_tagihan_pembayaran' => 'nullable',
            'check_proposal_awal' => 'nullable',
            'check_lembar_reviewer' => 'nullable',
            'check_korkon' => 'nullable',
            'id_mhs' => 'present',
            'nim_mhs' => 'present',

            'tipe_korkon' => 'required',
            'kartu_studi_tetap' => 'required_unless:check_kartu_studi_tetap,1 |mimes:jpg,png,pdf|max:10240',
            'transkrip_nilai' => 'required_unless:check_transkrip_nilai,1 |mimes:jpg,png,pdf|max:10240',
            'form_pengajuan_ta' => 'required_unless:check_form_pengajuan_ta,1 |mimes:jpg,png,pdf|max:10240',
            'tagihan_pembayaran' => 'required_unless:check_tagihan_pembayaran,1 |mimes:jpg,png,pdf|max:10240',
            'proposal_awal' => 'required_unless:check_proposal_awal,1 |mimes:docx|max:10240',
            'lembar_reviewer' => 'required_unless:check_lembar_reviewer,1 |mimes:jpg,png,pdf|max:10240',
        ];
    }

    public function messages()
    {
        return [
            'kartu_studi_tetap.required_unless' => "Silahkan diisi terlebih dahulu!",
            'transkrip_nilai.required_unless' => "Silahkan diisi terlebih dahulu!",
            'form_pengajuan_ta.required_unless' => "Silahkan diisi terlebih dahulu!",
            'tagihan_pembayaran.required_unless' => "Silahkan diisi terlebih dahulu!",
            'proposal_awal.required_unless' => "Silahkan diisi terlebih dahulu!",
            'lembar_reviewer.required_unless' => "Silahkan diisi terlebih dahulu!",
        ];
    }
}
