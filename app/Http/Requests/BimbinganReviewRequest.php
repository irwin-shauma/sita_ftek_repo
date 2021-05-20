<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BimbinganReviewRequest extends FormRequest
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
            'action' => 'present',
            'file_revisi' => 'requiredIf:action,"revisi"|mimes:doc,docx,pdf,zip,rar',
            'file_paper' => 'present',
            'id_mhs' => 'present',
            'nim' => 'present',
            'komentar_pembimbing' => 'present',
            'pembimbing_ke' => 'present',
            'name_mhs' => 'present',
        ];
    }
}
