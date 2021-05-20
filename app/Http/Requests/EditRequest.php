<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditRequest extends FormRequest
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
            'name' => ['required'],
            // 'nim' => ['exclude_unless:nip,null', 'unique:mahasiswa'],
            // 'nip' => ['exclude_unless:nim,null', 'unique:dosen'],
            'nim_nip' => ['required', 'unique:mahasiswa,nim', 'unique:dosen,nip'],
        ];
    }
}
