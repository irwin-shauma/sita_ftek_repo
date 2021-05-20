<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DsnUpdateRequest extends FormRequest
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
        $id = $this->request->get('dsn_id');
        return [
            'name' => ['required'],
            'nip' => ['required', "unique:dosen,nip,$id"],
            // Iki user id diganti id dosen  nanti
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Silahkan diisi!',
            'nip.required' => 'Silahkan diisi!',
            'nip.unique' => 'Nim sudah ada!',
        ];
    }
}
