<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PenjadwalanAwalRequest extends FormRequest
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
            // 'dosen_pembimbing_1' => 'required',
            // 'dosen_pembimbing_2' => 'required',

            'penjadwalan' => 'required|date',
            'pilih_reviewer1' => 'required|different:pilih_reviewer2',
            'pilih_reviewer2' => 'required|different:pilih_reviewer1',
            // 'file_revisi' => 'requiredIf:action,"revisi"|mimes:doc,docx,pdf,zip,rar',
            'id_mhs' => 'present',
        ];
    }
    public function messages()
    {
        return [
            'penjadwalan.required' => 'Tanggal harus diisi!',
            'pilih_reviewer1.different' => "Pilihan reviewer tidak boleh sama!",
            'pilih_reviewer2.different' => "Pilihan reviewer tidak boleh sama!",
        ];
    }
}
