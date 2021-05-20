<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KolokiumLanjutRequest extends FormRequest
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

            'check_proposal_lanjut' => 'nullable',
            'check_surat_tugas' => 'nullable',
            'check_korkon' => 'nullable',
            'id_mhs' => 'present',
            'nim_mhs' => 'present',
            'tipe_korkon' => 'present',
            // 'proposal_lanjut' => 'required|mimes:jpg,png,pdf|max:10240',
            // 'surat_tugas' => 'required|mimes:jpg,png,pdf|max:10240',
            'proposal_lanjut' => 'required_unless:check_proposal_lanjut,1 |mimes:docx|max:10240',
            'surat_tugas' => 'required_unless:check_surat_tugas,1 |mimes:jpg,png,pdf|max:10240',
        ];
    }

    public function messages()
    {
        return [
            // 'proposal_lanjut.required' => 'Silahkan diisi terlebih dahulu!',
            // 'surat_tugas.required' => 'Silahkan diisi terlebih dahulu!'
            'proposal_lanjut.required_unless' => "Silahkan diisi terlebih dahulu!",
            'surat_tugas.required_unless' => "Silahkan diisi terlebih dahulu!",
        ];
    }
}
