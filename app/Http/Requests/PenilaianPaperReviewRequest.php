<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PenilaianPaperReviewRequest extends FormRequest
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
            'pengali_baris4' => 'required',
            'pengali_baris5' => 'required',
            'pengali_baris6' => 'required',
            'pengali_baris7' => 'required',
            'pengali_baris8' => 'required',

            'input_baris1' => 'required',
            'input_baris2' => 'required',
            'input_baris3' => 'required',
            'input_baris4' => 'required',
            'input_baris5' => 'required',
            'input_baris6' => 'required',
            'input_baris7' => 'required',
            'input_baris8' => 'required',

            'hasil_baris1' => 'required',
            'hasil_baris2' => 'required',
            'hasil_baris3' => 'required',
            'hasil_baris4' => 'required',
            'hasil_baris5' => 'required',
            'hasil_baris6' => 'required',
            'hasil_baris7' => 'required',
            'hasil_baris8' => 'required',

            'total' => 'present',
            // 'aksara' => 'present',
        ];
    }
}
