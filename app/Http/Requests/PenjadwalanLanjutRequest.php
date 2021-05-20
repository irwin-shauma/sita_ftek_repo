<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PenjadwalanLanjutRequest extends FormRequest
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
            'penjadwalan' => 'required|date',
            'pilih_reviewer1' => 'present',
            'pilih_reviewer2' => 'present',
            'id_mhs' => 'present',
        ];
    }
    public function messages()
    {
        return [
            'penjadwalan.required' => 'Tanggal harus diisi!',
        ];
    }
}
