<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaperReviewRequest extends FormRequest
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
            //max satuannya kB
            'name_mhs' => 'present',
            'file_paper' => 'required|mimes:docx|max:10240',
            'komentar' => 'present',
        ];
    }
    public function messages()
    {
        return [
            'file_paper.required' => "Silahkan diisi terlebih dahulu!",
        ];
    }
}
