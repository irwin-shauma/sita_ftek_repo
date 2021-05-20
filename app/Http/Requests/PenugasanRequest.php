<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PenugasanRequest extends FormRequest
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
            'penugasan_date' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'penugasan_date.required' => "Silahkan diisi terlebih dahulu!",
        ];
    }
}
