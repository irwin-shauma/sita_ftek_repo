<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReviewPengajuanReviewRequest extends FormRequest
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
            'action' => 'present',
            'file_revisi' => 'requiredIf:action,"revisi"|mimes:doc,docx,pdf,zip,rar',
            'file_paper' => 'present',
            'id_mhs' => 'present',
            'nim' => 'present',
            'name' => 'present',
            'komentar_reviewer' => 'present',
            'reviewer_ke' => 'present',
            'id_dosen' => 'present',

            'pengali_baris1' => 'requiredIf:action,"revisi"',
            'pengali_baris2' => 'requiredIf:action,"revisi"',
            'pengali_baris3' => 'requiredIf:action,"revisi"',
            'pengali_baris4' => 'requiredIf:action,"revisi"',
            'pengali_baris5' => 'requiredIf:action,"revisi"',
            'pengali_baris6' => 'requiredIf:action,"revisi"',
            'pengali_baris7' => 'requiredIf:action,"revisi"',
            'pengali_baris8' => 'requiredIf:action,"revisi"',

            'input_baris1' => 'requiredIf:action,"revisi"',
            'input_baris2' => 'requiredIf:action,"revisi"',
            'input_baris3' => 'requiredIf:action,"revisi"',
            'input_baris4' => 'requiredIf:action,"revisi"',
            'input_baris5' => 'requiredIf:action,"revisi"',
            'input_baris6' => 'requiredIf:action,"revisi"',
            'input_baris7' => 'requiredIf:action,"revisi"',
            'input_baris8' => 'requiredIf:action,"revisi"',

            'hasil_baris1' => 'requiredIf:action,"revisi"',
            'hasil_baris2' => 'requiredIf:action,"revisi"',
            'hasil_baris3' => 'requiredIf:action,"revisi"',
            'hasil_baris4' => 'requiredIf:action,"revisi"',
            'hasil_baris5' => 'requiredIf:action,"revisi"',
            'hasil_baris6' => 'requiredIf:action,"revisi"',
            'hasil_baris7' => 'requiredIf:action,"revisi"',
            'hasil_baris8' => 'requiredIf:action,"revisi"',

            'pengali_baris12' => 'requiredIf:action,"setujui"',
            'pengali_baris22' => 'requiredIf:action,"setujui"',
            'pengali_baris32' => 'requiredIf:action,"setujui"',
            'pengali_baris42' => 'requiredIf:action,"setujui"',
            'pengali_baris52' => 'requiredIf:action,"setujui"',
            'pengali_baris62' => 'requiredIf:action,"setujui"',
            'pengali_baris72' => 'requiredIf:action,"setujui"',
            'pengali_baris82' => 'requiredIf:action,"setujui"',

            'input_baris12' => 'requiredIf:action,"setujui"',
            'input_baris22' => 'requiredIf:action,"setujui"',
            'input_baris32' => 'requiredIf:action,"setujui"',
            'input_baris42' => 'requiredIf:action,"setujui"',
            'input_baris52' => 'requiredIf:action,"setujui"',
            'input_baris62' => 'requiredIf:action,"setujui"',
            'input_baris72' => 'requiredIf:action,"setujui"',
            'input_baris82' => 'requiredIf:action,"setujui"',

            'hasil_baris12' => 'requiredIf:action,"setujui"',
            'hasil_baris22' => 'requiredIf:action,"setujui"',
            'hasil_baris32' => 'requiredIf:action,"setujui"',
            'hasil_baris42' => 'requiredIf:action,"setujui"',
            'hasil_baris52' => 'requiredIf:action,"setujui"',
            'hasil_baris62' => 'requiredIf:action,"setujui"',
            'hasil_baris72' => 'requiredIf:action,"setujui"',
            'hasil_baris82' => 'requiredIf:action,"setujui"',

            'total' => 'present',
            'total2' => 'present',
        ];
    }
}
