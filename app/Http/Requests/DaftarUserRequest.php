<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DaftarUserRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'nim' => ['required', 'string', 'max:9', 'unique:mahasiswa'],
            'role' => ['required', 'string'],


        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Silahkan diisi!',
            'email.required' => 'Silahkan diisi!',
            'password.required' => 'Silahkan diisi!',
            'nim.required' => 'Silahkan diisi!',
            'nim.unique' => 'Nim sudah ada!',
        ];
    }
}
