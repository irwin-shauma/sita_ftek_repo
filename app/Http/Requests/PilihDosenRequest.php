<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PilihDosenRequest extends FormRequest
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
            "pilih_dosen1" => 'different:pilih_dosen2',
            "pilih_dosen2" => 'different:pilih_dosen1',
        ];
    }

    public function messages()
    {
        return [
            'pilih_dosen1.different' => 'dosen tidak boleh sama',
            'pilih_dosen2.different' => 'dosen tidak boleh sama'
        ];
    }
}
