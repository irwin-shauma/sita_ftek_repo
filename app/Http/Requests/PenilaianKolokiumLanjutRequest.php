<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PenilaianKolokiumLanjutRequest extends FormRequest
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
            'nim' => 'present',
            'name' => 'present',
            'reviewer_ke' => 'present',
            'id_dosen' => 'present',
            'pengali_baris1' => 'required',
            'pengali_baris2' => 'required',
            'pengali_baris3' => 'required',

            'input_baris1' => 'required',
            'input_baris2' => 'required',
            'input_baris3' => 'required',

            'hasil_baris1' => 'required',
            'hasil_baris2' => 'required',
            'hasil_baris3' => 'required',
            'total' => 'present',
            // 'aksara' => 'present',
        ];
    }
}
