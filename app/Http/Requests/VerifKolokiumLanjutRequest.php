<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VerifKolokiumLanjutRequest extends FormRequest
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
            'proposal_lanjut' => 'nullable',
            'surat_tugas' => 'nullable',
        ];
    }
}
