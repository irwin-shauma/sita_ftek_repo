<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidasiRekapNilaiRequest extends FormRequest
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
            'name' => 'present',
            'nim' => 'present',
            'hasil_nilai_bimbingan' => 'present',
            'hasil_nilai_penguji_1' => 'present',
            'hasil_nilai_penguji_2' => 'present',
            'hasil_nilai_kolokium_lanjut' => 'present',
            'total_all' => 'present',
            'aksara' => 'present',
        ];
    }
}
